<?php

function jzzf_get_graph($form) {    
    $generator = new Jzzf_Graph_Generator();
    return $generator->generate($form);
}

class Jzzf_Graph {
    public $data;
    public $types;
    public $dependencies;
    public $formulas;
    public $templates;
    public $params;
    public $email;
    public $required;
    
    public function __construct() {
        $this->data = array();
        $this->types = array();
        $this->dependencies = array();
        $this->formulas = array();
        $this->templates = array();
        $this->params = array();
        $this->email = array();
        $this->required = array();
    }
    
    public function to_array() {
        return array(
            "data" => $this->data,
            "types" => $this->types,
            "dependencies" => $this->dependencies,
            "formulas" => $this->formulas,
            "params" => $this->params,
            "email" => $this->email,
            "required" => $this->required
        );
    }
}

class Jzzf_Graph_Generator {
    private $form;
    private $graph;
    private $direct_dependencies = array();

    public function __construct() {
        $this->graph = new Jzzf_Graph();
    }
    
    public function generate($form) {
        $this->form = $form;

        $this->elements();
        $this->dependencies();
        $this->graph->email = $this->get_email_formulas();
        return $this->graph;
    }
    
    function elements() {
        foreach($this->form->elements as $elem) {
            $this->process_element($elem);
        }        
    }
    
    function dependencies() {
        foreach($this->direct_dependencies as $id => $directs) {
            $this->get_recursive_dependencies($id);
        }
        $this->clean_dependencies();
    }

    // remove empty dependencies and dependencies for output fields
    function clean_dependencies() {
        foreach($this->graph->dependencies as $id => $dependent) {
            if(!array_key_exists($id, $this->graph->types) || $this->is_output($this->graph->types[$id]) || !$dependent) {
                unset($this->graph->dependencies[$id]);
            }
        }        
    }
    
    function get_recursive_dependencies($id) {
        if(array_key_exists($id, $this->graph->dependencies)) {
            return $this->graph->dependencies[$id];
        }
        $this->graph->dependencies[$id] = array(); // this avoids endless recursion
        $dependencies = array();
        if(array_key_exists($id, $this->direct_dependencies)) {
            $directs = $this->direct_dependencies[$id];
            foreach($directs as $direct) {
                $recursive = $this->get_recursive_dependencies($direct);
                $dependencies[] = $direct;
                foreach($recursive as $r) {
                    if(!in_array($r, $dependencies)) {
                        $dependencies[] = $r;
                    }
                }
            }
        }
        $this->graph->dependencies[$id] = $dependencies;
        return $dependencies;
    }
    
    function process_element($elem) {
        $id = strtolower($elem->name);
        $type = $elem->type;
        $this->graph->types[$id] = $type;
        if(property_exists($elem, 'required') && $elem->required) {
            $this->graph->required[$id] = $elem->missing;
        }
        if($type == "f") {
            $this->process_output_element($id, $elem);
        } elseif($this->is_template($type)) {
            $this->process_template_element($id, $elem);
        } elseif($values = $this->get_values($elem)) {
            $this->graph->data[$id] = $values;
        }
    }
    
    function process_output_element($id, $elem) {
        $param_keys = array_flip(array('prefix', 'postfix', 'fixed', 'decimals', "zeros", "thousands", "point"));
        
        try {
            $formula = jzzf_parse($elem->formula);
        } catch(Exception $e) {
            return;
        }
        $this->graph->formulas[$id] = $formula;
        $deps = $this->get_dependencies($formula);
        $this->add_dependencies($deps, $id);
        $this->graph->params[$id] = array_intersect_key((array) $elem, $param_keys);        
    }

    function process_template_element($id, $elem) {
        $parsed = jzzf_parse_template($elem->title);
        if(!$parsed || (count($parsed)==1 && !is_array($parsed[0]))) {
            return;
        }
        $this->graph->templates[$id] = $parsed;
        $deps = $this->get_template_dependencies($parsed);
        $this->add_dependencies($deps, $id);        
    }
    
    function is_template($type) {
        return in_array($type, array('m', 't', 'h'));
    }
    
    function is_output($type) {
        return in_array($type, array('f', 'm', 't', 'h'));
    }
    
    function get_email_formulas() {
        $formulas = null;
        if(property_exists($this->form, 'email') && is_object($this->form->email)) {
            $email = $this->form->email;
            $formulas = jzzf_formulas_from_template($email->to, 'to') +
                jzzf_formulas_from_template($email->from, 'form') +
                jzzf_formulas_from_template($email->cc, 'cc') +
                jzzf_formulas_from_template($email->bcc, 'bcc') +
                jzzf_formulas_from_template($email->subject, 'subject') +
                jzzf_formulas_from_template($email->message, 'message');
        }
        return $formulas;
    }
    
    function get_dependencies($formula) {
        $deps = array();
        $nodes = array($formula);
        while(count($nodes)) {
            $node = array_pop($nodes);
            if(is_array($node)) {
                if($node[0] == 'v') {
                    if(!in_array($node[1], $deps)) {
                        $deps[] = $node[1];
                    }
                } elseif($node[0] == 'f' || $node[0] == 'o') {
                    for($i=2; $i<count($node); $i++) {
                        $nodes[] = $node[$i];
                    }
                }
            }
        }
        return $deps;
    }

    function get_template_dependencies($template) {
        $dependencies = array();
        
        foreach($template as $chunk) {
            if(jzzf_chunk_is_formula($chunk)) {
                $deps = $this->get_dependencies($chunk);
                foreach($deps as $dep) {
                    if(!in_array($dep, $dependencies)) {
                        $dependencies[] = $dep;
                    }
                }
            }
        }
        
        return $dependencies;
    }
    
    function add_dependencies($dependencies, $id) {
        foreach($dependencies as $dep) {
            $this->direct_dependencies[$dep][] = $id;
        }
    }
    
    function get_values($element) {
        $values = null;
        switch($element->type) {
            case 'n':
                if($val = $element->value) {
                    $values = $val;
                }
                break;
            case 'c':
                $val = $element->value ? $element->value : 1;
                $val2 = $element->value2 ? $element->value2 : 0;
                $values = array($val2, $val);
                break;
            case 'r':
            case 'd':
                $values = array();
                foreach($element->options as $opt) {
                    if($opt->value) {
                        $values[] = $opt->value;
                    } else {
                        $values[] = 0;
                    }
                }
                break;
        }
        return $values;
    }
}
    

