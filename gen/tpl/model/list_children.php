function jzzf_<?=$method?>($parent) {
    global $wpdb;
    $query = "SELECT * FROM {$wpdb->prefix}jzzf_<?=$table?> WHERE <?=$args?>='%d'";
    $sql = $wpdb->prepare($query, $parent);
    return $wpdb->get_results($sql);
}
