<?

function get_columns($table) {
    $schema = get_schema($table);
    return $schema['columns'];
}

function get_placeholder_format($table) {
    $schema = get_columns($table);
    $format = array();
    foreach($schema as $column => $type) {
        if(in_array($type, array('id', 'int'))) {
            $placeholder = '%d';
        } else {
            $placeholder = '%s';
        }
        $format[$column] = $placeholder;
    }
    return $format;
}

