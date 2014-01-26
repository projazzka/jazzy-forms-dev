<?php
/*
Plugin Name: Jazzy Forms
Plugin URI: http://www.jazzyforms.com/
Description: Online form builder with an emphasis on calculation
Version: 1.1.1
Author: Igor Prochazka
Author URI: http://www.jazzyforms.com/

---------------------------------------------------------------------
    This file is part of the WordPress plugin "Jazzy Forms"
    Copyright (C) 2012-2014 by Igor Prochazka

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

---------------------------------------------------------------------
*/

define(JZZF_VERSION, 1.0101);
define(JZZF_VERSION_STRING, "1.0101");
define(JZZF_OPTION_VERSION, 'jzzf_version');

define(JZZF_ROOT, WP_PLUGIN_DIR . '/jazzy-forms/');
define(JZZF_GENERATED, JZZF_ROOT . 'generated/');
define(JZZF_CORE, JZZF_ROOT . 'core/');
define(JZZF_BACK, JZZF_ROOT . 'back/');
define(JZZF_FRONT, JZZF_ROOT . 'front/');

require_once(JZZF_CORE . 'Log.php');

function jzzf_get_version() {
    return get_option(JZZF_OPTION_VERSION, 0.0);
}

function jzzf_set_version($float) {
    update_option(JZZF_OPTION_VERSION, JZZF_VERSION);
}

function jzzf_head() {
	wp_register_script( 'mustache', plugins_url('jazzy-forms/3rdparty/mustache.js'), null, '0.3.0');
	wp_register_script( 'jzzf-tabs', plugins_url('jazzy-forms/back/tabs.js'), null, JZZF_VERSION_STRING);
	wp_register_script( 'jzzf-elements', plugins_url('jazzy-forms/back/elements.js'), null, JZZF_VERSION_STRING);
	wp_register_script( 'jzzf-id', plugins_url('jazzy-forms/back/id.js'), null, JZZF_VERSION_STRING);
	wp_register_script( 'jzzf-smartid', plugins_url('jazzy-forms/back/smartid.js'), null, JZZF_VERSION_STRING);
	wp_register_script( 'jzzf-admin-js', plugins_url('jazzy-forms/back/gui.js'), array('jquery-ui-draggable', 'jquery-ui-sortable'), JZZF_VERSION_STRING );
	wp_register_style( 'jzzf-admin-css', plugins_url('jazzy-forms/back/gui.css'), null, JZZF_VERSION_STRING);
	wp_enqueue_script('mustache', '0.3.0');
	wp_enqueue_script('jzzf-id', null, null, JZZF_VERSION_STRING);
	wp_enqueue_script('jzzf-smartid', null, null, JZZF_VERSION_STRING);
	wp_enqueue_script('jzzf-elements', null, null, JZZF_VERSION_STRING);
	wp_enqueue_script('jzzf-tabs', null, null, JZZF_VERSION_STRING);
	wp_enqueue_script('jzzf-admin-js', null, null, JZZF_VERSION_STRING);
	wp_enqueue_style('jzzf-admin-css', null, null, JZZF_VERSION_STRING);
}

function jzzf_admin() {
	$page = add_menu_page( 'Forms', 'Forms', 8, 'jzzf_forms_top', 'jzzf_forms', null, '30.08161929');
	/* add_submenu_page('jzzf_forms_top', "Data", "Data", 8, 'jzzf_data', 'jzzf_data'); */
	add_action('admin_print_styles-' . $page, 'jzzf_head');
}

function jzzf_forms() {
	require_once(JZZF_BACK . 'ctrl-forms.php');
	require_once(JZZF_GENERATED . 'Basic_Model.php');
	jzzf_ctrl_forms();
}

function jzzf_data() {
	echo "Data screen";
}

function jzzf_init() {
	jzzf_sanitize_db();
}

function jzzf_activate() {
	global $wpdb;

	jzzf_create_tables();
	jzzf_update();
}

function jzzf_create_tables() {
	jzzf_execute_sql(JZZF_GENERATED . 'schema.sql');
}

function jzzf_execute_sql($filename) {
	global $wpdb;
	
	$charset_collate = jzzf_charset_collate();

	$file = file( $filename );
	foreach($file as $line) {
		$sql = trim($line);
		if($sql && $sql[0] != '#') {
			$sql = str_replace('{{prefix}}', $wpdb->prefix, $sql);
			$sql = str_replace('{{charset_collate}}', $charset_collate, $sql);
			$wpdb->query($sql);
		}
	}
}

function jzzf_panic() {
	jzzf_execute_sql(JZZF_GENERATED . 'drop.sql');
	jzzf_execute_sql(JZZF_ROOT . 'panic.sql');
	deactivate_plugins(JZZF_ROOT . 'jazzy-forms.php');
}

function jzzf_sanitize_db() {
	if(function_exists('is_multisite') && is_multisite()) {
		jzzf_create_tables();
	}
	$current = jzzf_get_version();
	if($current < JZZF_VERSION) {
		jzzf_update();
	}
}

function jzzf_charset_collate() {
	global $wpdb;
	
	$charset_collate = '';
	
	if(!empty($wpdb->charset)) {
		$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
	}
	
	if(!empty($wpdb->collate)) {
		$charset_collate .= " COLLATE $wpdb->collate";
	}	
	return $charset_collate;
}


function jzzf_update() {	
	jzzf_execute_sql(JZZF_GENERATED . 'update.sql');
	jzzf_set_version(JZZF_VERSION);
}

function jzzf_shortcode( $attr ) {
	require_once(JZZF_FRONT . 'ctrl-shortcode.php');
	require_once(JZZF_GENERATED . 'Basic_Model.php');
	require_once(JZZF_CORE . 'Graph.php');
	require_once(JZZF_CORE . 'Parser.php');
	require_once(JZZF_CORE . 'Tokenizer.php');
	require_once(JZZF_CORE . 'Template_Parser.php');
	return jzzf_ctrl_shortcode($attr);
}

function jzzf_enqueue() {
	wp_register_script('jazzy-forms', plugins_url('jazzy-forms/front/jazzy-forms.js'), array('jquery'), JZZF_VERSION_STRING);
	wp_enqueue_script('jquery');
	wp_enqueue_script('jazzy-forms', null, null, JZZF_VERSION_STRING);
}

function jzzf_form($id, $attr=null, $return=false) {
	if($attr === null) {
		$attr = array();
	}
	$attr['form'] = $id;
	$out = jzzf_shortcode($attr);
	if($return) {
		return $out;
	} else {
		echo $out;
	}
}

// Trick from http://goo.gl/5JnKZ
function jzzf_conditional_queuing($posts) {
	if (empty($posts)) {
		return $posts;
	}

	$shortcode_found = false;
	foreach($posts as $post) {
		if(stripos($post->post_content, '[jazzy') !== false) {
			$shortcode_found = true;
			break;
		}
	}

	if($shortcode_found) {
		jzzf_enqueue();
	}

	return $posts;
}

function jzzf_email() {
	require_once(JZZF_FRONT . 'ctrl-email.php');
	require_once(JZZF_GENERATED . 'Basic_Model.php');
	require_once(JZZF_CORE . 'Parser.php');
	require_once(JZZF_CORE . 'Tokenizer.php');
	require_once(JZZF_CORE . 'Template_Parser.php');
	require_once(JZZF_CORE . 'Mail.php');
	jzzf_ctrl_email();
	exit;
}

function jzzf_log_exposure($public=false) {
	require_once(JZZF_FRONT . 'ctrl-log.php');
	jzzf_ctrl_log($public);
	exit;
}

function jzzf_log_public_exposure() {
	jzzf_log_exposure(true);
}

/* register filter hook */

register_activation_hook( JZZF_ROOT . 'jazzy-forms.php', 'jzzf_activate' );
add_action('admin_menu', 'jzzf_admin' );
add_action('init', 'jzzf_init' );
add_shortcode( 'jazzy', 'jzzf_shortcode' );
add_filter('the_posts', 'jzzf_conditional_queuing');
add_action('jzzf_enqueue', 'jzzf_enqueue');
add_action('jzzf_form', 'jzzf_form', 2);
add_action('wp_ajax_jzzf_email', 'jzzf_email');
add_action('wp_ajax_nopriv_jzzf_email', 'jzzf_email');
add_action('wp_ajax_jzzf_log', 'jzzf_log_exposure');
add_action('wp_ajax_nopriv_jzzf_log', 'jzzf_log_public_exposure');

?>
