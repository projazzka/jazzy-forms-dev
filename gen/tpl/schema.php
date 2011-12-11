CREATE TABLE IF NOT EXISTS {prefix}jzzf_<?=$table?> ( id bigint(20) AUTO_INCREMENT, <? foreach($schema as $column => $type) { echo "`$column` $type NOT NULL,"; } ?> PRIMARY KEY (id) );
