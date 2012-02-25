<?

require_once('common.php');
define('TEMPLATE_DIR', 'tpl/');

$db = get_db();
foreach($db as $table => $def) {
    include(TEMPLATE_DIR . 'drop.php');
}



