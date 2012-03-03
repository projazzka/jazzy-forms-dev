<?

define('SCHEMA_FILE', 'src/schema.json');
define('INDENT', 4);

$type_map = array(
    'str' => 'varchar',
    'bool' => 'int',
    'json' => 'varchar',
    'id' => 'bigint',
    'int' => 'int'
);

$length_map = array(
    'str' => 1024,
    'bool' => 1,
    'json' => 2048,
    'id' => 20,
    'int' => 12
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

function type($definition) {
    global $length_map, $type_map;
    
    if(array_key_exists('longtext', $definition)) {
        return 'LONGTEXT';
    }
    if(array_key_exists('len', $definition)) {
        $length = $definition['len'];
    } else {
        $length = $length_map[$definition['type']];
    }
    return $type_map[$definition['type']] . '(' . $length . ')';
}

function is_numeric_column($type) {
    return in_array($type, array('id', 'int', 'bool'));
}

function column_definition($column, $definition) {
    global $type_map;
    echo "`$column` " . type($definition) . " NOT NULL";
    if(array_key_exists('default', $definition) && $definition['default'] !== null) {
        if(is_numeric_column($definition['type'])) {
            echo " DEFAULT " . $definition['default'];
        } else {
            echo " DEFAULT '" . $definition['default'] . "'";
        }
    }
}
