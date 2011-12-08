<?php
/*
Plugin Name: Jazzy Forms
Plugin URI: http://www.jazzyforms.com/
Description: Interactive forms for business: quote generators, price calculators, quizzes
Version: 1.0
Author: Igor Prochazka
Author URI: http://www.l90r.com/

---------------------------------------------------------------------
	This file is part of the wordpress plugin "Jazzy Forms"
    Copyright (C) 2009 by Igor Prochazka

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

function jzzf_head() {
	wp_register_script( 'jzzf-admin-js', plugins_url('jazzy-forms/back/gui.js'));
	wp_register_style( 'jzzf-admin-css', plugins_url('jazzy-forms/back/gui.css'));
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jzzf-admin-js');
	wp_enqueue_style('jzzf-admin-css');
}

function jzzf_admin() {
	$page = add_menu_page( 'Forms', 'Forms', 8, 'jzzf_forms_top', 'jzzf_forms', null, 30);
	add_submenu_page('jzzf_forms_top', "Data", "Data", 8, 'jzzf_data', 'jzzf_data');
	add_action('admin_print_styles-' . $page, 'jzzf_head');
}

function jzzf_forms() {
	echo "Forms screen";
}

function jzzf_data() {
	echo "Data screen";
}

function jzzf_init() {
}

function jzzf_activate() {
}

/* register filter hook */

register_activation_hook( WP_PLUGIN_DIR . '/jazzy-forms/jazz-forms.php', 'jzzf_activate' );
add_action('admin_menu', 'jzzf_admin' );
add_action('init', 'jzzf_init' );

?>