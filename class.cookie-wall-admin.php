<?php
class CookieWallAdmin {
	private static $initiated = false;

	public static function init() {
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
	}

	public static function init_hooks() {
		add_action( 'admin_menu', array('CookieWallAdmin', 'addAdminMenu') );
		add_filter( 'plugin_action_links_' . COOKIE_WALL_PLUGIN_FILE_NAME, array('CookieWallAdmin', 'pluginLinks') );
	}
	
	public static function addAdminMenu(){
		add_options_page( __('Cookie Wall Options',COOKIE_WALL_TEXT_DOMAIN), __('Cookie Wall',COOKIE_WALL_TEXT_DOMAIN), 'manage_options', 'tropical-cookie-wall', array('CookieWallAdmin','options') );
	}
	
	public static function options() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' COOKIE_WALL_TEXT_DOMAIN) );
		}
		include('templates/admin-options.php');
	}

	public function pluginLinks( $links ) {
	   $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=tropical-cookie-wall') ) .'">'.__('Settings',COOKIE_WALL_TEXT_DOMAIN).'</a>';
	   $links[] = '<a href="https://tropicaljuice.nl" target="_blank">'.__('Need professional help?',COOKIE_WALL_TEXT_DOMAIN).'</a>';
	   return $links;
	}
}