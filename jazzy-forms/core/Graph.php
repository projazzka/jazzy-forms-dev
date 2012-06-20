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
    public $params;
    public $email;
    
    public function __construct() {
        $this->data = array();
        $this->types = array();
        $this->dependencies = array();
        $this->formulas = array();
        $this->params = array();
        $this->email = array();
    }
    
    public function to_array() {
        return array(
            "data" => $this->data,
            "types" => $this->types,
            "dependencies" => $this->dependencies,
            "formulas" => $this->formulas,
            "params" => $this->params,
            "email" => $this->email
        );
    }
}

class Jzzf_Graph_Generator {
    private $form;
    private $graph;

    public function __construct() {
        $this->graph = new Jzzf_Graph();
    }
    
    public function generate($form) {
        $this->form = $form;

        foreach($form->elements as $elem) {
            $this->process_element($elem);
        }
        $this->graph->email = $this->get_email_formulas();
        return $this->graph;
    }
    
    function process_element($elem) {
        $id = strtolower($elem->name);
        $type = $elem->type;
        $this->graph->types[$id] = $type;
        if($type == "f") {
            $this->process_output_element($id, $elem);
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
        foreach($deps as $dep) {
            $this->graph->dependencies[$dep][] = $id;
        }
        $this->graph->params[$id] = array_intersect_key((array) $elem, $param_keys);        
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
        foreach($formula as $token) {
            if($token[0] == 'v') {
                $id = $token[1];
                if(!in_array($id, $deps)) {
                    $deps[] = $id;
                }
            }
        }
        return $deps;
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
    

