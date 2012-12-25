<?php $config = parse_ini_file('../config.ini', true); ?>
<html>
<body>
<h1>DB reset script</h1>
<form method="post" action="#">
    <ul>
        <li><input id="blank" type="radio" name="type" value="blank" checked="checked">Blank WP installation</input></li>
        <li><input id="installed" type="radio" name="type" value="installed">WP, Jazzy Forms installed</input></li>
    </ul>
    <input id="submit" type="submit" name="load" value="Reset DB">
</form>
<pre>
<?php if($_POST) : ?>
<?php

    $db = new mysqli($config['REF_DB']['HOST'], $config['REF_DB']['USER'], $config['REF_DB']['PASSWD'], $config['REF_DB']['TABLE']);
    $file = $config['REF_DB']['DUMP_FILE_DIR'] . '/dump-' . $_POST['type'] . '.sql';
    echo "Applying file $file\n";
    
    $sql = file_get_contents($file);
    
    if ($db->multi_query($sql)) {
        echo "DB reset\n";
    } else {
        echo "DB reset failed. Error:" . htmlspecialchars($db->error) . "\n";
    }
    
    $db->close();

?>
<?php endif ?>
</pre>