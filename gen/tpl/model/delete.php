function jzzf_<?=$method?>($id) {
    global $wpdb;
    $query = "DELETE FROM ${wpdb->prefix}<?=$table?> WHERE id = %d";
    $sql = $wpdb->prepare($query, $id);
    return $wpdb->query($sql);
}


