<?php

function jzzf_get_graph($elements) {
    $data = array();
    $types = array();
    $dependencies = array();
    $formulas = array();
    foreach($elements as $elem) {
        $id = $elem->id;
        $type = $elem->type;
        $types[$id] = $type;
        if($type == "f") {
            $formula = jzzf_parse($elem->formula);
            $formulas[$id] = $formula;
            $deps = jzzf_get_dependencies($formula);
            foreach($deps as $dep) {
                $dependencies[$dep][] = $id;
            }
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
