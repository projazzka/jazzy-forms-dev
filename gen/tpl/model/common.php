<?

function get_columns($table) {
    $schema = get_schema($table);
    return $schema['columns'];
}

function get_placeholder($type) {
    if(in_array($type, array('id', 'int', 'bool'))) {
        return '%d';
    } else {
        return '%s';
    }
}

