function jzzf_<?=$method?>($id) {
    global $wpdb;
    $query = "DELETE FROM {$wpdb->prefix}jzzf_<?=$table?> WHERE id = %d";
    $sql = $wpdb->prepare($query, $id);
    jzzf_debug("SQL (<?=$method?>): " . $sql);
    if(false === $wpdb->query($sql)) {
        return false;
    }
<? $children = $one_to_many + $one_to_one; ?>
<? foreach($children as $id => $child): ?>
    $query = "SELECT id FROM {$wpdb->prefix}jzzf_<?=$child?> WHERE <?=$table?> = %d";
    $sql = $wpdb->prepare($query, $id);
    jzzf_debug("SQL2 (<?=$method?>): " . $sql);
    $children = $wpdb->get_col($sql);
    if(jzzf_log_enabled()) {
        jzzf_debug("Children (<?=$method?>): " . json_encode($children));
    }
    if(is_array($children)) {
        foreach($children as $child) {
            jzzf_delete_<?=$child?>($child);
        }
    }
<? endforeach ?>
    return true;
}


