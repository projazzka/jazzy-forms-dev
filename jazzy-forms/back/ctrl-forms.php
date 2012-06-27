<?php

function jzzf_ctrl_forms() {
    if($_GET['diagnostics']) {
        jzzf_ctrl_diagnostics();
        return;
    } elseif($_POST['delete']) {
        jzzf_info("Deleting form {$_POST['delete']}");
        if(jzzf_delete_form($_POST['delete'])) {
            jzzf_info("Success.");
            $msg = "Form Deleted.";
        } else {
            jzzf_error("Error deleting form.");
            $msg = "An error ocurred while deleting your form!";
        }
    } elseif($_POST['form']) {
        $json = stripcslashes($_POST['form']);
        jzzf_info("Setting form");
        jzzf_debug($json);
        $form = json_decode($json);
        if($current = jzzf_set_form($form)) {
            jzzf_info("Ok.");
            $msg = "Form Saved.";
        } else {
            jzzf_error("Error setting form.");
            $msg = "An error ocurred while saving your form!";
        }
    }
    $forms = jzzf_list_form();
    include('tpl-forms.php');
}

function jzzf_ctrl_diagnostics() {
    jzzf_info("Diagnostics controller");
    if($_POST['panic']) {
        jzzf_critical("PANIC!");
        jzzf_panic();
        return;
    } elseif($_POST['tweaks']) {
        jzzf_info("Updating tweaks.");
        update_option('jzzf_tweak_suppress_email', $_POST['tweak_suppress_email']);
        update_option('jzzf_log_level', $_POST['log_level']);
        update_option('jzzf_log_file', $_POST['log_file']);
        update_option('jzzf_tweak_log_public', $_POST['tweak_log_public']);
    }
    $db_version = jzzf_get_version();
    $version = JZZF_VERSION;
    $forms = jzzf_list_form();
    $tweak_suppress_email = get_option('jzzf_tweak_suppress_email', false);
    $log_level = jzzf_log_level();
    $log_file = jzzf_log_file();
    $tweak_log_public = get_option('jzzf_tweak_log_public', false);
    include('tpl-diagnostics.php');
    return;
}