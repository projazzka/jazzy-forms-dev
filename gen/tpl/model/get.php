<?
    $data = json_decode($args);
    $column = $data->column;
    $placeholder = get_placeholder($data->type);
?>
function jzzf_<?=$method?>($id) {
    global $wpdb;
    $query = "SELECT * FROM {$wpdb->prefix}jzzf_<?=$table?> WHERE `<?=$column?>`=<?=$placeholder?>";
    $sql = $wpdb->prepare($query, $id);
    $obj = $wpdb->get_row($sql);
    if($obj) {
<? foreach($recursion as $id => $child) : ?>
        $obj-><?=$id?> = jzzf_list_<?=$child?>($id);
<? endforeach ?>
    }
    return $obj;
}
