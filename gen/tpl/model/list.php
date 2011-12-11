function jzzf_<?=$method?>() {
    global $wpdb;
    $sql = "SELECT * FROM {$wpdb->prefix}jzzf_<?=$table?>";
    return $wpdb->get_results($sql);
}
