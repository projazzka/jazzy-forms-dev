ALTER TABLE {{prefix}}jzzf_<?=$table?> CHANGE COLUMN <? echo $column ?> <? column_definition($column, $definition)?>;
