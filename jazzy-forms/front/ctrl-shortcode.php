<?php

require_once(JZZF_CORE . 'Model.php');

function jzzf_ctrl_shortcode($attr) {
    $form = jzzf_get_form_by_name($attr['form']);
    if($form) {
        $output = json_encode($form);
    } else {
        $output = 'Unknown form';
    }
    return $output;
}