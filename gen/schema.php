<?

require_once('common.php');
define('TEMPLATE_DIR', 'tpl/');

$type_map = array(
    'str' => 'varchar(1024)',
    'bool' => 'int(1)',
    'json' => 'varchar(2048)',
    'id' => 'bigint(20)',
    'int' => 'int(12)'
);

$db = get_db();
foreach($db as $table => $def) {
    $colschema = $def['columns'];
    foreach($colschema as $column => $type) {
        $schema[$column] = $type_map[$type];
    }
    include(TEMPLATE_DIR . 'schema.php');
}



