function jzzf_<?=$method?>($parent) {
    global $wpdb;
    $query = "SELECT * FROM {$wpdb->prefix}jzzf_<?=$table?> WHERE <?=$args?>='%d'";
    $sql = $wpdb->prepare($query, $parent);
    $results = $wpdb->get_results($sql);
<? if($recursion) : ?>
    if($results) {
        foreach($results as $obj) {
<? foreach($recursion as $id => $child) : ?>
            $obj-><?=$id?> = jzzf_list_<?=$child?>($obj->id);
<? endforeach ?>
        }
    }
<? endif ?>
    return $results;
}
