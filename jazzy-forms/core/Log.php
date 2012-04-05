<?php

/* improvised logging system */

function jzzf_log_enabled() { return jzzf_log_level(); }

function jzzf_log_level() {
    if(function_exists('get_option')) {
        return get_option('jzzf_log_level', 0);
    }
    return 10;
}

function jzzf_log_file() {
    if(function_exists('get_option')) {
        return get_option('jzzf_log_file', sys_get_temp_dir() . '/jazzy-forms.log');
    }
    return sys_get_temp_dir() . '/jazzy-forms.log';
}

function jzzf_debug($msg) { jzzf_log(10, $msg); }
function jzzf_info($msg) { jzzf_log(20, $msg); }
function jzzf_warning($msg) { jzzf_log(30, $msg); }
function jzzf_error($msg) { jzzf_log(40, $msg); }
function jzzf_critical($msg) { jzzf_log(50, $msg); }

function jzzf_log($level, $msg) {
    if(jzzf_log_enabled() && $level >= jzzf_log_level() ) {
        $file = jzzf_log_file();
        if(!$file) {
            return;
        }
        switch($level) {
            case 10: $importance = 'DEBUG'; break;
            case 20: $importance = 'INFO'; break;
            case 30: $importance = 'WARNING'; break;
            case 40: $importance = 'ERROR'; break;
            case 50: $importance = 'CRITICAL'; break;
        }
        $output = '[' . $importance . '|' . date(DATE_ISO8601) . '|' . $_SERVER['REMOTE_ADDR'] . ']' . "$msg\n";
        file_put_contents($file, $output, FILE_APPEND);
    }
}
