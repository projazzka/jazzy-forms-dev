<?php

require_once( JZZF_CORE . '/model.php');

function jzzf_ctrl_forms() {
    if($_POST['form']) {
        $json = stripcslashes($_POST['form']);
        $form = json_decode($json);
        if(jzzf_set_form($form)) {
            $msg = "Form Saved.";
        } else {
            $msg = "An error ocurred while saving your form!";
        }
    }
    $forms = jzzf_list_form();
    include('tpl-forms.php');
}