function jzzf_<?=$method?>($<?=$arg?>) {
    global $wpdb;
    $query = "SELECT * FROM ${wpdb->prefix}<?=$table?> WHERE `<?=$arg?>` = %d";
    $sql = $wpdb->prepare($query, $<?=$parent?>);
    return $wpdb->get_results($sql);
}


