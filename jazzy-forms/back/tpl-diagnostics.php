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

<form method="post">
Tweaks:
<input type="checkbox" name="tweak_fake_email"<?php if($tweak_fake_email): ?> checked="checked" <?php endif ?> value="1"> Fake Email (writes to /tmp/jzzf_email.txt)

<input type="submit" name="tweaks" value="Save" class="button-secondary">
</form>
</pre>
<h2>Panic</h2>
<form method="post" action="#">
    <input type="submit" name="panic" value="DON'T PRESS THIS!" class="button-primary">
        <p>This completely deletes any Jazzy Forms configuration and deactives the plugin.</p>
