<?php

function jzzf_get_graph($form) {    
    $generator = new Jzzf_Graph_Generator();
    // TODO: remove temporary to_array() method
    return $generator->generate($form)->to_array();
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
    
    // TODO: remove temporary to_array() method
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
    public function __construct() {
        $this->graph = new Jzzf_Graph();
    }
    
    public function generate($form) {
        $elements = $form->elements;
        $graph = $this->graph;

        $param_keys = array_flip(array('prefix', 'postfix', 'fixed', 'decimals', "zeros", "thousands", "point"));
        
        foreach($elements as $elem) {
            $id = strtolower($elem->name);
            $type = $elem->type;
            $graph->types[$id] = $type;
            if($type == "f") {
                $formula = null;
                try {
                    $formula = jzzf_parse($elem->formula);
                } catch(Exception $e) {
                    
                }
                if($formula) {
                    $graph->formulas[$id] = $formula;
                    $deps = jzzf_get_dependencies($formula);
                    foreach($deps as $dep) {
                        $graph->dependencies[$dep][] = $id;
                    }
                }
                $graph->params[$id] = array_intersect_key((array) $elem, $param_keys);
            } elseif($values = jzzf_get_values($elem)) {
                $graph->data[$id] = $values;
            }
        }
        $graph->email = jzzf_get_email_formulas($form);
        return $graph;
    }
}
    

function jzzf_get_email_formulas($form) {
    $formulas = null;
    if(property_exists($form, 'email') && is_object($form->email)) {
        $email = $form->email;
        $formulas = jzzf_formulas_from_template($email->to, 'to') +
            jzzf_formulas_from_template($email->from, 'form') +
            jzzf_formulas_from_template($email->cc, 'cc') +
            jzzf_formulas_from_template($email->bcc, 'bcc') +
            jzzf_formulas_from_template($email->subject, 'subject') +
            jzzf_formulas_from_template($email->message, 'message');
    }
    return $formulas;
}

function jzzf_get_dependencies($formula) {
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

function jzzf_get_values($element) {
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