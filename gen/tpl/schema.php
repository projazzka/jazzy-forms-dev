<? $definitions = array();
    foreach($schema as $column => $type) {
        $definitions[] = "$column $type";
    } ?>
CREATE TABLE IF NOT EXISTS {prefix}jzzf_<?=$table?> ( <?=implode(',', $definitions) ?> );
