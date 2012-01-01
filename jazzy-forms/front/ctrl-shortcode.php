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
    $tpl->head($form);
    foreach($form->elements as $element) {
        $tpl->before($element);
        switch($element->type) {
            case 'number':
                $tpl->number($element);
                break;
            case 'hidden':
                $tpl->hidden($element);
                break;
            case 'output':
                $tpl->output($element);
                break;
            case 'radio':
                $tpl->radio($element);
                break;
            case 'dropdown':
                $tpl->dropdown($element);
                break;
        }
    }
    $output = ob_get_clean();
    ob_end_clean();
    return $output;
}