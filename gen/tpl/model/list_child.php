<? extract(json_decode($args, true)) ?>
function jzzf_<?=$method?>($parent) {
    global $wpdb;
    $query = "SELECT * FROM {$wpdb->prefix}jzzf_<?=$table?> WHERE <?=$parent?>='%d' ORDER BY `<?=$order?>`";
    $sql = $wpdb->prepare($query, $parent);
    $results = $wpdb->get_results($sql);
    if($results) {
        foreach($results as $obj) {
<? include('sanitize.php') ?>
<? foreach($one_to_many as $id => $child) : ?>
            $obj-><?=$id?> = jzzf_list_<?=$child?>($obj->id);
<? endforeach ?>
        }
    }
    return $results;
}
