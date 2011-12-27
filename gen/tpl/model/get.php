function jzzf_<?=$method?>($id) {
    global $wpdb;
    $query = "SELECT * FROM {$wpdb->prefix}jzzf_<?=$table?> WHERE id=%d";
    $sql = $wpdb->prepare($query, $id);
    $obj = $wpdb->get_row($sql);
    if($obj) {
<? foreach($recursion as $id => $child) : ?>
        $obj-><?=$id?> = jzzf_list_<?=$child?>($id);
<? endforeach ?>
    }
    return $obj;
}
