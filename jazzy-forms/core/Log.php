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

function jzzf_dump_log() {
    print @file_get_contents(jzzf_log_file());
}

function jzzf_log_clear() {
    file_put_contents(jzzf_log_file(), "");    
}

function jzzf_log_level_string($level) {
    switch($level) {
        case 10:
            return 'DEBUG';
        case 20:
            return 'INFO';
        case 30:
            return 'WARNING';
        case 40:
            return 'ERROR';
        case 50:
            return 'CRITICAL';
    }
    return '';
}

function jzzf_format_output($level, $msg) {
    $lines = explode("\n", $msg);
    $output = '';
    $first = true;
    foreach($lines as $line) {
        if($first) {
            $first = false;
        } else {
            $line = '->' . $line;
        }
        $output .= '[' . $level . '|' . date(DATE_ISO8601) . '|' . $_SERVER['REMOTE_ADDR'] . ']' . "$line\n";
    }
    return $output;
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
        $importance = jzzf_log_level_string($level);
        $output = jzzf_format_output($importance, $msg);
        file_put_contents($file, $output, FILE_APPEND);
    }
}
