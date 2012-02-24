<h2>Jazzy Forms diagnostics</h2>
<pre>DB version: <?php echo $db_version ?>

Code version: <?php echo $version ?>

WP version: <?php bloginfo('version') ?>

PHP version: <?php print phpversion() ?>

Browser: <script type="text/javascript">
document.writeln(navigator.appCodeName + "|" +
    navigator.appName + "|" +
    navigator.appVersion + "|" +
    navigator.cookieEnabled + "|" +
    navigator.platform + "|" +
    navigator.userAgent);</script>
Forms:
<?php echo htmlentities(json_encode($forms)); ?>

Plugins: <?php echo htmlentities(json_encode(get_plugins())); ?>
</pre>