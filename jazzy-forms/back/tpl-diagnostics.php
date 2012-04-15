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

<form method="post" action="#">
        Panic!
        <input type="submit" name="panic" value="DON'T PRESS THIS!" class="button-primary">
        This completely deletes any Jazzy Forms configuration and deactives the plugin, without any confirmation.
</form>
                    
<form method="post">
Tweaks:
<input type="checkbox" name="tweak_suppress_email"<?php if($tweak_suppress_email): ?> checked="checked" <?php endif ?> value="1"> Suppress email
Log file    <input type="text" name="log_file" value="<?php esc_attr_e($log_file) ?>">
Log level   <input type="text" name="log_level" value="<?php esc_attr_e($log_level) ?>"> (0: off, 10-50: debug-critical)
<input type="submit" name="tweaks" value="Save tweaks" class="button-secondary">
</form>
</pre>
