function jzzf_<?=$method?>() {
    global $wpdb;
    $sql = "SELECT * FROM {$wpdb->prefix}jzzf_<?=$table?> ORDER BY `<?=$args?>`";
    $results = $wpdb->get_results($sql);
<? if($recursion) : ?>
    if($results) {
        foreach($results as $obj) {
<? include('sanitize.php') ?>
<? foreach($recursion as $id => $child) : ?>
            $obj-><?=$id?> = jzzf_list_<?=$child?>($obj->id);
<? endforeach ?>
        }
    }
<? endif ?>
    return $results;
}
