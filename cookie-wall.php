<?php
/*
	Plugin Name: Cookie Wall
	Plugin URI: https://tropicaljuice.nl/
	Description: This plugin add's a simple cookie wall to comply with Dutch Cookie-laws. This plugin can be used when there is not 'light' version availble of the website withouth cookies and 3rd-party embeds. 
	Version: 1.0
	Author: Tropical Juice
	Author URI: https://tropicaljuice.nl/
	Text Domain: tropical-juice
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hello There!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'COOKIE__WALL_VERSION', '1.0' );
define( 'COOKIE__WALL_MIN_WP_VERSION', '3.7' );
define( 'COOKIE__WALL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'COOKIE__WALL_PLUGIN_URI', plugin_dir_url( __FILE__ ) );

require_once( COOKIE__WALL_PLUGIN_DIR . 'class.cookie-wall.php' );

add_action( 'wp_loaded', array( 'CookieWall', 'init' ) );