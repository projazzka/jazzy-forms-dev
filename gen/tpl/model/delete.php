function jzzf_<?=$method?>($id) {
    global $wpdb;
    $query = "DELETE FROM {$wpdb->prefix}jzzf_<?=$table?> WHERE id = %d";
    $sql = $wpdb->prepare($query, $id);
    if(false === $wpdb->query($sql)) {
        return false;
    }
<? foreach($one_to_many as $id => $child): ?>
    $query = "SELECT id FROM {$wpdb->prefix}jzzf_<?=$child?> WHERE <?=$table?> = %d";
    $sql = $wpdb->prepare($query, $id);
    $children = $wpdb->get_col($sql);
    if(is_array($children)) {
        foreach($children as $child) {
            jzzf_delete_<?=$child?>($child);
        }
    }
<? endforeach ?>
    return true;
}


