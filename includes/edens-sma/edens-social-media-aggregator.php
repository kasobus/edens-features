<?php
/*
 * Plugin Name: EDENS Social Media Aggregator
 * Version: 1.2.2
 * Plugin URI: https://bitbucket.org/ksobus/edens-sma
 * Description: This plugin generates a social media feed based on EDENSSMA.wpengine.com data.
 * Author: Kyle Sobus
 * Author URI: http://kylesobus.com
 *
 * @package WordPress
 * @author Kyle Sobus
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-edens-social-media-aggregator.php' );
require_once( 'includes/class-edens-social-media-aggregator-settings.php' );

// Load plugin libraries
require_once( 'includes/lib/class-edens-social-media-aggregator-admin-api.php' );
require_once( 'includes/lib/class-edens-social-media-aggregator-sma.php' );
require_once( 'includes/lib/class-edens-social-media-aggregator-gallery.php' );


/**
 * Returns the main instance of EDENS_Social_Media_Aggregator to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object EDENS_Social_Media_Aggregator
 */
function EDENS_Social_Media_Aggregator () {
	$instance = EDENS_Social_Media_Aggregator::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = EDENS_Social_Media_Aggregator_Settings::instance( $instance );
	}

	return $instance;
}

EDENS_Social_Media_Aggregator();
