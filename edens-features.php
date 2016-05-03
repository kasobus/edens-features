<?php
/*
 * Plugin Name: EDENS Features
 * Version: 1.0
 * Plugin URI: http://www.hughlashbrooke.com/
 * Description: This plugin is a feature set for the EDENS Center Theme.
 * Author: Hugh Lashbrooke
 * Author URI: http://www.hughlashbrooke.com/
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: edens-features
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author Hugh Lashbrooke
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-edens-features.php' );
require_once( 'includes/class-edens-features-settings.php' );

// Load plugin libraries
require_once( 'includes/lib/class-edens-features-admin-api.php' );
require_once( 'includes/lib/class-edens-features-post-type.php' );
require_once( 'includes/lib/class-edens-features-taxonomy.php' );
require_once( 'includes/lib/class-edens-features-ACF.php' );
require_once( 'includes/lib/class-edens-features-extra-options.php' );
require_once( 'includes/lib/class-edens-features-custom-post-types.php' );
//include_once( dirname( __FILE__ ) . '/includes/kirki/kirki.php' );


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
