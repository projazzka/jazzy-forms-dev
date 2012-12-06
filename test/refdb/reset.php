<?php require_once('config.php'); ?>
<html>
<body>
<h1>DB reset script</h1>
<form method="post" action="#">
    <ul>
        <li><input type="radio" name="type" value="blank" checked="checked">Blank WP installation</input></li>
        <li><input type="radio" name="type" value="installed">WP, Jazzy Forms installed</input></li>
    </ul>
    <input type="submit" name="load" value="Reset DB">
</form>
<pre>
<?php if($_POST) : ?>
<?php

    $db = new mysqli(DB_HOST, DB_USER, DB_PASSWD, DB_TABLE);
    $file = DUMP_FILE_DIR . '/dump-' . $_POST['type'] . '.sql';
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