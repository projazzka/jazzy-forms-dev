<?php
/*
Plugin Name: Jazzy Forms
Plugin URI: http://www.jazzyforms.com/
Description: Online form builder with an emphasis on calculation
Version: 0.9.5
Author: Igor Prochazka
Author URI: http://www.l90r.com/

---------------------------------------------------------------------
    This file is part of the WordPress plugin "Jazzy Forms"
    Copyright (C) 2012 by Igor Prochazka

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

define(JZZF_VERSION, 0.0905);
define(JZZF_OPTION_VERSION, 'jzzf_version');

define(JZZF_ROOT, WP_PLUGIN_DIR . '/jazzy-forms/');
define(JZZF_GENERATED, JZZF_ROOT . 'generated/');
define(JZZF_CORE, JZZF_ROOT . 'core/');
define(JZZF_BACK, JZZF_ROOT . 'back/');
define(JZZF_FRONT, JZZF_ROOT . 'front/');

function jzzf_get_version() {
    return get_option(JZZF_OPTION_VERSION, 0.0);
}

function jzzf_set_version($float) {
    update_option(JZZF_OPTION_VERSION, JZZF_VERSION);
}

function jzzf_delete_version() {
	delete_option(JZZF_OPTION_VERSION);
}

function jzzf_head() {
	wp_register_script( 'mustache', plugins_url('jazzy-forms/3rdparty/mustache.js', null, '0.3.0'));
	wp_register_script( 'jzzf-tabs', plugins_url('jazzy-forms/back/tabs.js', null, '1.0'));
	wp_register_script( 'jzzf-elements', plugins_url('jazzy-forms/back/elements.js', null, '1.0'));
	wp_register_script( 'jzzf-id', plugins_url('jazzy-forms/back/id.js', null, '1.0'));
	wp_register_script( 'jzzf-admin-js', plugins_url('jazzy-forms/back/gui.js'), array('mustache', 'jzzf-id', 'jzzf-elements', 'jzzf-tabs', 'jquery-ui-draggable'), '1.0' );
	wp_register_style( 'jzzf-admin-css', plugins_url('jazzy-forms/back/gui.css'));
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jzzf-admin-js');
	wp_enqueue_style('jzzf-admin-css');
}

function jzzf_admin() {
	$page = add_menu_page( 'Forms', 'Forms', 8, 'jzzf_forms_top', 'jzzf_forms', null, 30);
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
	jzzf_execute_sql('schema.sql');
}

function jzzf_execute_sql($filename) {
	global $wpdb;
	
	$charset_collate = jzzf_charset_collate();

	$file = file( dirname(__FILE__) . '/generated/' . $filename );
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
	jzzf_execute_sql('drop.sql');
	jzzf_delete_version();
	deactivate_plugins(JZZF_ROOT . 'jazzy-forms.php');
}

function jzzf_sanitize_db() {
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
	jzzf_execute_sql('update.sql');
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
	wp_register_script('jazzy-forms', plugins_url('jazzy-forms/front/jazzy-forms.js'), array('jquery'), '1.0');
	wp_enqueue_script('jquery');
	wp_enqueue_script('jazzy-forms');
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
	require_once(JZZF_CORE . 'Graph.php');
	require_once(JZZF_CORE . 'Parser.php');
	require_once(JZZF_CORE . 'Tokenizer.php');
	require_once(JZZF_CORE . 'Template_Parser.php');
	jzzf_ctrl_email();
	exit;
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
 
?>
