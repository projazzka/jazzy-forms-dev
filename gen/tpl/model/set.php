<?
    $format = get_placeholder_format($table);
?>

public static function <?=$method?>($obj) {
    global $wpdb;
    $format = <? indented_export($format) ?>;
    if($obj->id) {
        $wpdb->update(
            '<?=$table?>',
            $obj,
            array('id'=>$obj->id),
            $format,
            '%d'
        ); 
    } else {
        $wpdb->insert(
            '<?=$table?>',
            $obj,
            $format
        ); 
    }
}
