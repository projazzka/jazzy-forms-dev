<?

define('SCHEMA_FILE', 'src/schema.json');
define('INDENT', 4);

$type_map = array(
    'str' => 'varchar(1024)',
    'bool' => 'int(1)',
    'json' => 'varchar(2048)',
    'id' => 'bigint(20)',
    'int' => 'int(12)'
);

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

function column_definition($column, $definition) {
    global $type_map;
    echo "`$column` " . $type_map[$definition['type']] . " NOT NULL";
    if(array_key_exists('default', $definition) && $definition['default'] !== null) {
        echo " DEFAULT " . $definition['default'];
    }
}
