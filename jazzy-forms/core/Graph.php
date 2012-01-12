<?php

function jzzf_get_graph($elements) {
    $data = array();
    $types = array();
    $dependencies = array();
    $formulas = array();
    foreach($elements as $elem) {
        $id = $elem->name;
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
        } elseif($values = jzzf_get_values($elem)) {
            $data[$id] = $values;
        }
    }
    return compact('data', 'types', 'dependencies', 'formulas');
}

function jzzf_get_dependencies($formula) {
    $deps = array();
    foreach($formula as $token) {
        if($token[0] == 'v') {
            $deps[] = $token[1];
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