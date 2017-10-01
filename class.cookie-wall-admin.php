<?php
if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
class CookieWallAdmin
{
    private static $initiated = false;

    public static function init()
    {
        if (! self::$initiated) {
            self::init_hooks();
        }
    }

    public static function init_hooks()
    {
        add_filter('plugin_action_links_' . COOKIE_WALL_PLUGIN_FILE_NAME, array('CookieWallAdmin', 'pluginLinks'));
        $admin_settings = new CookieWallAdminSettingsPage();
    }
    
    public function pluginLinks($links)
    {
        $links[] = '<a href="'. esc_url(get_admin_url(null, 'options-general.php?page=tropical-cookie-wall')) .'">'.__('Settings', COOKIE_WALL_TEXT_DOMAIN).'</a>';
        $links[] = '<a href="https://tropicaljuice.nl" target="_blank">'.__('Need professional help?', COOKIE_WALL_TEXT_DOMAIN).'</a>';
        return $links;
    }
}
