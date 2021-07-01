<?php
/*
 *	Plugin Name: Responsive Viewport Units v2
 *	Description: Displays window.innerHeight and window.innerWidth viewport properties in px, rem, vw and vh units each time the browser is resized. Real-time feedback for layout and media query breakpoints.
 *	Version: 2.0
 *	Author: Clinton Gallagher
 *	Author URI: http://clintongallagher.com/
 *	Plugin URI: http://clintongallagher.com/
 *	License: GPLv2 or later
 *	License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *	Text Domain: viewport-units
 */

// Disallow requesting this file by name
if(!defined('ABSPATH')){
	exit;
}

/**
 * INTENT:     The ovu prefix is an acronym of onBrowser Resize Viewport Units.
 *             This plugin provides immediate visual review and confirmation of elements positioned
 *             within the page and their relationship to the viewport allowing real time confirmation
 *             of responsive design objectives. This plugin uses window.innerWidth and window.innerHeight
 *             to display viewport unit properties in both pixel and rem unit values when the page is loaded.
 *             Viewport units dynamically update each time the browser is resized. An example of the
 *             output is displayed in the admin settings page.
 *
 * CREATED v1: December 17, 2017
 * UPDATED v2: June 21, 2021 added support for CSS vh and vw units
 * AUTHOR:     Clinton Gallagher. All Rights Reserved
 * DEPENDENCY: A required dependency is described in the includes/viewport-units-script-block.php file
 **/

// GLOBAL FORM SETTINGS OPTIONS VARIABLE
$ovu_options = get_option('ovu_settings');

// REQUIRE VIEWPORT-UNITS-SCRIPT-BLOCK.PHP
// The viewport units displayed in the page when the plugin is activated.
require_once( plugin_dir_path(__FILE__) . 'includes/viewport-units-script-block.php');

// LOAD OVU-APP.JS
function load_ovu_app_js() {
	wp_register_script( 'ovu-app-js', plugin_dir_url(__FILE__) . 'js/ovu-app.js', null, 1.0, true );
	wp_enqueue_script('ovu-app-js' );
}
add_action( 'admin_enqueue_scripts', 'load_ovu_app_js' );

// LOAD ADMIN ASSETS AND RESOURCES
// Does not determine if current user is an administrator
// but if the admin page is loaded
if ( is_admin() ) {

	// REQUIRE OVU-SETTINGS.PHP
	require_once( plugin_dir_path(__FILE__ )) . 'includes/ovu-settings.php';

	// LOAD OVU-SETTINGS.CSS
	function load_ovu_settings_css(){
		wp_register_style( 'ovu-settings-css', plugin_dir_url(  __FILE__ ) . 'css/ovu-settings.css', null, 1.0, false);
		wp_enqueue_style('ovu-settings-css');
	}
	add_action('admin_enqueue_scripts','load_ovu_settings_css');

	// LOAD TINYCOLORPICKER.JS
	function load_tinycolorpicker_js() {
		wp_register_script( 'ovu-tinycolorpicker-js', plugin_dir_url( __FILE__ ) . 'js/jquery.tinycolorpicker.js', array( 'jquery' ), 1.0, true );
		wp_enqueue_script( 'ovu-tinycolorpicker-js' );
	}
	add_action( 'admin_enqueue_scripts', 'load_tinycolorpicker_js' );

	// LOAD TINYCOLORPICKER.CSS
	function load_tinycolorpicker_css(){
		wp_register_style('tinycolorpicker-css', plugins_url('/css/tinycolorpicker.css', __FILE__), array(), '20171215', 'all' );
		wp_enqueue_style('tinycolorpicker-css');
	}
	add_action('admin_enqueue_scripts','load_tinycolorpicker_css');

} // is_admin()

// MISCELLANEOUS FUNCTIONS
function modify_admin_footer_text () {
	echo 'Fueled By <a href="http://www.wordpress.org" target="_blank">WordPress</a> | Made A Teeny Bit Better By  <a href="http://clintongallagher.com" target="_blank">Clinton Gallagher</a>.';
}
add_filter('admin_footer_text', 'modify_admin_footer_text');

// Load content
//require_once('plugin_dir_path(__FILE__)' . '/includes/viewport-units-content.php');