<?
    $schema = get_columns($table);
?>
    $obj->id = intval($obj->id);
<? foreach($schema as $column => $definition) : $type = $definition['type']; ?>
<?   if($type == 'id' || $type == 'int') : ?>
    $obj-><?=$column ?> = intval($obj-><?=$column ?>);
<?   elseif($type == 'bool'): ?>
    $obj-><?=$column ?> = (bool) ($obj-><?=$column ?>);
<?   elseif($type == 'float'): ?>
    $obj-><?=$column ?> = floatval($obj-><?=$column ?>);
<? endif ?>
<? endforeach ?>
