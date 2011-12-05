public static function <?=$method?>($id) {
    global $wpdb;
    $query = "SELECT * FROM {$wpdb->prefix}jzzf_<?=$table?> WHERE id=%d";
    $sql = $wpdb->prepare($query, $id);
    return $wpdb->get_row($sql);
}
