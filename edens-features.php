<?php
/*
 * Plugin Name: EDENS Features
 * Plugin URI: http://www.EDENS.com/
 * Version: 1.3.4
 * Description: This plugin is a feature set for the EDENS Center Theme.
 * Author: Kyle Sobus
 * Author URI: http://www.kylesobus.com
 * Requires at least: 4.0
 * Tested up to: 6.0
 *
 * Text Domain: edens-features
 * Domain Path: /lang/
 *
	* Bitbucket Plugin URI: https://bitbucket.org/ksobus/edens-features
	* Bitbucket Branch:    master
 * @package WordPress
 * @author Kyle Sobus
 * @since 1.0.0
	*/
if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-edens-features.php' );
require_once( 'includes/class-edens-features-settings.php' );
//require_once( 'includes/acf-field-date-time-picker/acf-date_time_picker.php' );

// Load ACF Plugin
	add_filter('acf/settings/path', 'my_acf_settings_path'); // 1. Customize ACF path
	function my_acf_settings_path( $path ) {
					$path = plugin_dir_path( __FILE__ ).'includes/acf/';  // update path
					return $path; // return
	}
	add_filter('acf/settings/dir', 'my_acf_settings_dir'); // 2. Customize ACF dir
	function my_acf_settings_dir( $dir ) {
					$dir = plugin_dir_url( __FILE__ ).'includes/acf/';// update path
					return $dir; // return
	}
	//add_filter('acf/settings/show_admin', '__return_false'); // 3. Hide ACF field group menu item
	//include_once( plugin_dir_path( __FILE__ ).'includes/acf/acf.php' ); // 4. Include ACF

// Load plugin libraries
require_once( 'includes/lib/class-edens-features-admin-api.php' );
require_once( 'includes/lib/class-edens-features-post-type.php' );
require_once( 'includes/lib/class-edens-features-taxonomy.php' );
require_once( 'includes/lib/class-edens-features-ACF.php' );
require_once( 'includes/lib/class-edens-features-extra-options.php' );
require_once( 'includes/lib/class-edens-features-custom-post-types.php' );
require_once( 'includes/lib/class-edens-features-social-media-aggregator-sma.php' );
/**
 * Returns the main instance of EDENS_Features to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object EDENS_Features
 */
function EDENS_Features () {
	$instance = EDENS_Features::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = EDENS_Features_Settings::instance( $instance );
	}
	return $instance;
}
EDENS_Features();