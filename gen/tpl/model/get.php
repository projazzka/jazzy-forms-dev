<?
    $data = json_decode($args);
    $column = $data->column;
    $placeholder = get_placeholder($data->type);
?>
function jzzf_<?=$method?>($key) {
    global $wpdb;
    $query = "SELECT * FROM {$wpdb->prefix}jzzf_<?=$table?> WHERE `<?=$column?>`=<?=$placeholder?>";
    $sql = $wpdb->prepare($query, $key);
    $obj = $wpdb->get_row($sql);
    if($obj) {
<? foreach($recursion as $id => $child) : ?>
        $obj-><?=$id?> = jzzf_list_<?=$child?>($obj->id);
<? endforeach ?>
    }
    return $obj;
}
