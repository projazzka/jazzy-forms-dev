<?
    $format = get_placeholder_format($table);
?>

function jzzf_<?=$method?>($obj) {
    global $wpdb;
    $format = <? indented_export($format) ?>;
    if($obj->id) {
        $result = $wpdb->update(
            'jzzf_<?=$table?>',
            $obj,
            array('id'=>$obj->id),
            $format,
            '%d'
        );
        $id = $obj->id;
    } else {
        $result = $wpdb->insert(
            'jzzf_<?=$table?>',
            $obj,
            $format
        );
        $id = $wpdb->insert_id;
    }
<? if($recursion): ?>
    if($result !== false) {
<? foreach($recursion as $id => $child ) : ?>
        if(is_array($obj-><?=$id?>)) {
            foreach($obj-><?=$id?> as $child) {
                $child-><?=$table?> = $id;
                jzzf_set_<?=$child?>($child);
            }
        }
<? endforeach ?>
    }
<? endif ?>
    return $result;
}
