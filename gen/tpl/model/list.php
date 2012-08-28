function jzzf_<?=$method?>() {
    global $wpdb;
    $sql = "SELECT * FROM {$wpdb->prefix}jzzf_<?=$table?> ORDER BY `<?=$args?>`";
    jzzf_debug("SQL (<?=$method?>): " . $sql);
    $results = $wpdb->get_results($sql);
<? if($one_to_many) : ?>
    if($results) {
        foreach($results as $obj) {
<? include('sanitize.php') ?>
<? foreach($one_to_many as $id => $child) : ?>
            $obj-><?=$id?> = jzzf_list_<?=$child?>($obj->id);
<? endforeach ?>
<? foreach($one_to_one as $id => $child) : ?>
            $obj-><?=$id?> = jzzf_get_<?=$child?>($obj->id);
<? endforeach ?>
        }
    }
<? endif ?>
    return $results;
}
