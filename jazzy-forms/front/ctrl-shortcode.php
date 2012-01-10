<?php

require_once(JZZF_CORE . 'Model.php');
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

function jzzf_view_front($form) {
    ob_start();
    $tpl = new Jzzf_List_Template($form);
    if($form->theme) {
        $tpl->theme($form->theme);
    }
    if(trim($form->css)) {
        $tpl->css($form->css);
    }
    $tpl->script($form);
    $tpl->head($form);
    foreach($form->elements as $element) {
        $tpl->before($element);
        switch($element->type) {
            case 'n':
                $tpl->number($element);
                break;
            case 'f':
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
        }
        $tpl->after($element);
    }
    $tpl->foot($form);
    $output = ob_get_clean();
    ob_end_clean();
    return $output;
}