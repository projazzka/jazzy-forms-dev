<?php

require_once( JZZF_CORE . '/model.php');

function jzzf_ctrl_forms() {
    if($_POST['form']) {
        $form = stripcslashes($_POST['form']);
        $msg = "Form Saved ($form)";
    }
    $forms = jzzf_list_form();
    include('tpl-forms.php');
}