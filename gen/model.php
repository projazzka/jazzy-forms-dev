<?

define('TEMPLATE_DIR', 'tpl/model');
define('MODEL_FILE', 'src/model.csv');

require_once('common.php');
require_once(TEMPLATE_DIR . '/common.php');

function generate($method, $template, $table, $args, $one_to_many, $one_to_one) {
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
                $one_to_many = array_key_exists('one_to_many', $schema) ? $schema['one_to_many'] : array();
                $one_to_one = array_key_exists('one_to_one', $schema) ? $schema['one_to_one'] : array();
                $out[] = array(
                    'method'=>$method,
                    'template'=>$template,
                    'table'=>$table,
                    'args'=> $args,
                    'one_to_many'=>$one_to_many,
                    'one_to_one'=>$one_to_one
                );
            }
        }
    }
    return $out;
}
            
$methods = get_methods();
$code = '';
foreach($methods as $method) {
    $code .= generate(
        $method['method'],
        $method['template'],
        $method['table'],
        $method['args'],
        $method['one_to_many'],
        $method['one_to_one']
    );
}
include(TEMPLATE_DIR . '/main.php');


