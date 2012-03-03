<?

require_once('common.php');
define('TEMPLATE_DIR', 'tpl/');

$db = get_db();
foreach($db as $table => $def) {
    $schema = array();
    $colschema = $def['columns'];
    if(array_key_exists('add', $def)) {
        $add = $def['add'];
    } else {
        $add = null;
    }
    if(array_key_exists('change', $def)) {
        $change = $def['change'];
    } else {
        $change = null;
    }
    foreach($colschema as $column => $definition) {
        $schema[$column] = $definition;
    }
    if($add) {
        foreach($add as $version => $columns) {
            foreach($columns as $column) {
                $definition = $schema[$column];
                include(TEMPLATE_DIR . 'add.php');
            }
        }
    }
    if($change) {
        foreach($change as $version => $columns) {
            foreach($columns as $column) {
                $definition = $schema[$column];
                include(TEMPLATE_DIR . 'change.php');
            }
        }
    }
}



