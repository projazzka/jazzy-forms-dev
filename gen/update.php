<?

require_once('common.php');
define('TEMPLATE_DIR', 'tpl/');

$db = get_db();
foreach($db as $table => $def) {
    $schema = array();
    $colschema = $def['columns'];
    if(array_key_exists('update', $def)) {
        $updates = $def['update'];
    } else {
        $updates = null;
    }
    foreach($colschema as $column => $type) {
        $schema[$column] = $type_map[$type];
    }
    if($updates) {
        foreach($updates as $version => $columns) {
            foreach($columns as $column) {
                $type = $schema[$column];
                include(TEMPLATE_DIR . 'update.php');
            }
        }
    }
}



