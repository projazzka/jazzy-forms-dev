<?php

function jzzf_ctrl_log($public) {
    jzzf_info("Log API. public=" . ($public ? 1:0));
    if($public && !get_option('jzzf_tweak_log_public')) {
        jzzf_error('Unauthorized intent to access the log publicly!');
        jzzf_http_error('403', 'Unauthorized log access');
        
    }
    if($_REQUEST['clear']) {
        jzzf_log_clear();
        jzzf_info('Clearing log.');
    }
    header('Content-type: text/plain');
    jzzf_dump_log();
}

function jzzf_http_error($code, $msg) {
    $response = "HTTP/1.0 $code $msg";
    jzzf_error("Http error: $response");
    header($response);
    exit;
}
