<?php
/*
	Plugin Name: Cookie Wall
	Plugin URI: https://tropicaljuice.nl/
	Description: This plugin add's a simple cookie wall to comply with Dutch Cookie-laws. This plugin can be used when there is not 'light' version availble of the website withouth cookies and 3rd-party embeds. 
	Version: 1.0
	Author: Tropical Juice
	Author URI: https://tropicaljuice.nl/
	Text Domain: tropical_cookiewall
*/

if ( ! defined( 'ABSPATH' ) ) exit; 

define( 'COOKIE_WALL_VERSION', '1.0' );
define( 'COOKIE_WALL_MIN_WP_VERSION', '3.7' );
define( 'COOKIE_WALL_TEXT_DOMAIN', 'tropical_cookiewall' );
define( 'COOKIE_WALL_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'COOKIE_WALL_PLUGIN_DIR', basename(dirname(__FILE__)) );
define( 'COOKIE_WALL_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
define( 'COOKIE_WALL_PLUGIN_FILE_NAME', plugin_basename(__FILE__) );

require_once( COOKIE_WALL_PLUGIN_DIR_PATH . 'class.cookie-wall.php' );

add_action( 'wp_loaded', array( 'CookieWall', 'init' ) );

if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
	require_once( COOKIE_WALL_PLUGIN_DIR_PATH . 'class.cookie-wall-admin-settings.php' );
	require_once( COOKIE_WALL_PLUGIN_DIR_PATH . 'class.cookie-wall-admin.php' );
	add_action( 'init', array( 'CookieWallAdmin', 'init' ) );
}