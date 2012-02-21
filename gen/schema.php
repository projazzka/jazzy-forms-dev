<?

require_once('common.php');
define('TEMPLATE_DIR', 'tpl/');

$db = get_db();
foreach($db as $table => $def) {
    $schema = array();
    $colschema = $def['columns'];
    foreach($colschema as $column => $definition) {
        $schema[$column] = $definition;
    }
    include(TEMPLATE_DIR . 'schema.php');
}



