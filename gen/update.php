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
    foreach($colschema as $column => $definition) {
        $schema[$column] = $definition;
    }
    if($updates) {
        foreach($updates as $version => $columns) {
            foreach($columns as $column) {
                $definition = $schema[$column];
                include(TEMPLATE_DIR . 'update.php');
            }
        }
    }
}



