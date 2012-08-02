<?php

require_once(JZZF_FRONT . 'tmpl-list.php');

function jzzf_ctrl_shortcode($attr) {
    if(!$attr['form']) {
        $output = 'Jazzy Forms: form ID missing.';
    } else {
        $form = jzzf_get_form_by_name($attr['form']);
        if($form) {
            $output = jzzf_view_front($form);
        } else {
            $output = 'Jazzy Forms: unknown form ID "' . htmlspecialchars($attr['form']) . '"';
        }
    }
    return $output;
}

function jzzf_get_classes($element, $ahead) {
    $classes = 'jzzf_element jzzf_element_' . $element->type . ' jzzf_ahead_' . $ahead->type;
    if($element->break) {
        $classes .= ' jzzf_break';
    } else {
        $classes .= ' jzzf_no_break';
    }
    switch($element->divisions) {
        case 1:
            $classes .= ' jzzf_full';
            break;
        case 2:
            $classes .= ' jzzf_half';
            break;
        case 3:
            $classes .= ' jzzf_third';
            break;
        case 4:
            $classes .= ' jzzf_quarter';
            break;
    }
    if($element->classes) {
        $classes .= ' ' . trim($element->classes);
    }
    return $classes;
}

function jzzf_view_front($form) {
    ob_start();
    $tpl = new Jzzf_List_Template($form);
    if($form->theme) {
        $tpl->theme($form->theme);
    }
    if(trim($form->css)) {
        $tpl->css($form->css);
    }
    $graph = jzzf_get_graph($form);
    $tpl->graph(jzzf_form_params($form), $graph);
    $tpl->script($form);
    $tpl->head($form);
    for($idx=0; $idx<count($form->elements); $idx++) {
        $element = $form->elements[$idx];
        if($idx < count($form->elements)-1) {
            $ahead = $form->elements[$idx+1];
        } else {
            $ahead = null;
        }
        
        $element->classes = jzzf_get_classes($element, $ahead);
        $is_template = in_array($element->type, array("m", "t", "h"));
        $tpl->before($element, $ahead, ($element->break || $idx==0), $is_template);
        
        switch($element->type) {
            case 'n':
                $tpl->number($element);
                break;
            case 'a':
                $tpl->textarea($element);
                break;
            case 'f':
                if(!in_array($element->name, $graph->formulas)) {
                    $element->invalid = true;
                }
                $tpl->output($element);
                break;
            case 'r':
                $tpl->radio($element);
                break;
            case 'd':
                $tpl->dropdown($element);
                break;
            case 'c':
                $tpl->checkbox($element);
                break;
            case 'u':
                $tpl->update($element);
                break;
            case 'h':
                $tpl->heading($element);
                break;
            case 't':
                $tpl->text($element);
                break;
            case 'm':
                $tpl->html($element);
                break;
            case 'x':
                $tpl->reset($element);
                break;
            case 'e':
                $tpl->email($element);
                break;
        }
        $tpl->after($element, ($ahead && $ahead->break) || ($idx==count($form->elements)-1));
    }
    $tpl->foot($form);
    $output = ob_get_clean();
    return $output;
}

function jzzf_form_params($form) {
    $params = clone $form;
    unset($params->elements);
    unset($params->css);
    if(property_exists($params, 'email') && $params->email) {
        $params->email = (object) array(
            "sending" => $form->email->sending,
            "ok" => $form->email->ok,
            "fail" => $form->email->fail
        );
    }
    return $params;

}