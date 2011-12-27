<?

define('TEMPLATE_DIR', 'tpl/model');
define('MODEL_FILE', 'src/model.csv');

require_once('common.php');
require_once(TEMPLATE_DIR . '/common.php');

function generate($method, $template, $table, $args, $recursion) {
    ob_start();
    include(TEMPLATE_DIR . "/${template}.php");
    return ob_get_clean();
}

function get_methods() {
    $out = array();
    $f = fopen(MODEL_FILE, 'r');
    while(($line = fgets($f)) !== false) {
        if($line[0] != '#') {
            $arr = explode('|', $line);
            if($arr && count($arr)>1) {
                $method = trim($arr[0]);
                $template = trim($arr[1]);
                $table = trim($arr[2]);
                $args = trim($arr[3]);
                $schema = get_schema($table);
                $recursion = array_key_exists('recursion', $schema) ? $schema['recursion'] : array();
                $out[] = array('method'=>$method, 'template'=>$template, 'table'=>$table, 'args'=> $args, 'recursion'=>$recursion);
            }
        }
    }
    return $out;
}
            
$methods = get_methods();
$code = '';
foreach($methods as $method) {
    $code .= generate($method['method'], $method['template'], $method['table'], $method['args'], $method['recursion']);
}
include(TEMPLATE_DIR . '/main.php');


