<?php

function jzzf_ctrl_forms() {
    if($_GET['diagnostics']) {
        $db_version = jzzf_get_version();
        $version = JZZF_VERSION;
        $forms = jzzf_list_form();
        include('tpl-diagnostics.php');
        return;
    } elseif($_POST['delete']) {
        if(jzzf_delete_form($_POST['delete'])) {
            $msg = "Form Deleted.";
        } else {
            $msg = "An error ocurred while deleting your form!";
        }
    } elseif($_POST['form']) {
        $json = stripcslashes($_POST['form']);
        $form = json_decode($json);
        if($current = jzzf_set_form($form)) {
            $msg = "Form Saved.";
        } else {
            $msg = "An error ocurred while saving your form!";
        }
    }
    $forms = jzzf_list_form();
    include('tpl-forms.php');
}