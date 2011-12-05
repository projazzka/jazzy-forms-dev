CREATE TABLE {prefix}jzzf_<?=$table?> IF NOT EXISTS ( <? foreach($schema as $column => $type): ?> <?=$column?> <?=$type?>, <? endforeach ?>);
