<?php

function jzzf_get_graph($form) {
    $elements = $form->elements;
    
    $data = array();
    $types = array();
    $dependencies = array();
    $formulas = array();
    $params = array();
    
    $param_keys = array_flip(array('prefix', 'postfix', 'fixed', 'decimals', "zeros", "thousands", "point"));
    
    foreach($elements as $elem) {
        $id = strtolower($elem->name);
        $type = $elem->type;
        $types[$id] = $type;
        if($type == "f") {
            $formula = null;
            try {
                $formula = jzzf_parse($elem->formula);
            } catch(Exception $e) {
                
            }
            if($formula) {
                $formulas[$id] = $formula;
                $deps = jzzf_get_dependencies($formula);
                foreach($deps as $dep) {
                    $dependencies[$dep][] = $id;
                }
            }
            $params[$id] = array_intersect_key((array) $elem, $param_keys);
        } elseif($values = jzzf_get_values($elem)) {
            $data[$id] = $values;
        }
    }
    $email = jzzf_get_email_formulas($form);
    return compact('data', 'types', 'dependencies', 'formulas', 'params', 'email');
}

function jzzf_get_email_formulas($form) {
    $formulas = null;
    if(property_exists($form, 'email') && is_array($form->email)) {
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
            } else {
                $values = 1;
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