<?
    $data = json_decode($args);
    $column = $data->column;
    $placeholder = get_placeholder($data->type);
?>
function jzzf_<?=$method?>($key) {
    global $wpdb;
    $query = "SELECT * FROM {$wpdb->prefix}jzzf_<?=$table?> WHERE `<?=$column?>`=<?=$placeholder?>";
    $sql = $wpdb->prepare($query, $key);
    jzzf_debug("SQL (<?=$method?>): " . $sql);
    $obj = $wpdb->get_row($sql);
    if($obj) {
<?php include('sanitize.php') ?>
<? foreach($one_to_many as $id => $child) : ?>
        $obj-><?=$id?> = jzzf_list_<?=$child?>($obj->id);
<? endforeach ?>
<? foreach($one_to_one as $id => $child) : ?>
        $obj-><?=$id?> = jzzf_get_<?=$child?>($obj->id);
<? endforeach ?>
    }
    return $obj;
}
