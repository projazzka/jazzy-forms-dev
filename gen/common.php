<?

define('SCHEMA_FILE', 'src/schema.json');
define('INDENT', 4);

function indent($str, $indent=1) {
    return preg_replace('/\n/', "\n" . str_repeat(" ", $indent*INDENT), $str);
}

function indented_export($data, $indent=1) {
    echo indent(var_export($data, true), $indent);
}

function get_db() {
    $json = file_get_contents(SCHEMA_FILE);
    return json_decode($json, true);
}

function get_schema($table) {
    $db = get_db();
    return $db[$table];
}

