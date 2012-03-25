<?php

function jzzf_ctrl_email() {
    if(!($form = $_REQUEST['_form'])) {
        jzzf_error(403, "Invalid form");
    }
    if(!($email = jzzf_get_email_by_form($form))) {
        jzzf_error(404, "Form Not Found");
    }
    $replaced = jzzf_apply_email_templates($email);
    jzzf_send_email($replaced);
}

function jzzf_apply_email_templates($email) {
    $names = array('to', 'from', 'cc', 'bcc', 'subject', 'message');
    $replaced = array();
    foreach($names as $name) {
        $chunks = jzzf_parse_template($email->$name);
        $replaced[$name] = jzzf_apply_template($chunks, $_REQUEST, $name);
    }
    return $replaced;
}

function jzzf_error($code, $msg) {
    header("HTTP/1.0 $code $msg");
    exit;
}
