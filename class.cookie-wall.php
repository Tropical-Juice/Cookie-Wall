<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
class CookieWall {
	private static $cookieName = "wp-tropical-cookie-wall";
	private static $initiated = false;
	private static $useragent = '';
	private static $requestscheme = '';
	private static $httphost = '';
	private static $redirecturl = '';
	private static $scripts = array();
	private static $styles = array();
	
	
	public static function init() {
		if ( ! self::$initiated ) {
			self::$initiated = true;
			self::init_hooks();
			self::createVars();
			self::createCookieWall();
		}
	}

	/**
	 * Initializes Plugin
	 */
	private static function init_hooks() {
		add_shortcode( 'accept_button', array('CookieWall', 'shrt_cookieAccept') );
		add_shortcode( 'readmore', array('CookieWall', 'shrt_readmore') );
		add_shortcode( 'page_edit_date', array('CookieWall', 'shrt_pageEdit') );
		load_plugin_textdomain(COOKIE_WALL_TEXT_DOMAIN, false, COOKIE_WALL_PLUGIN_DIR.'/translations/');	
	}
	
	public static function createCookieWall(){
		if(self::checkCookieWall()){
			$post = get_post(self::getCookiePageID());
			self::enqueueScripts();
			include('templates/cookiewall.php');
			exit;
		}
	}
	private static function checkCookieWall(){
		if(self::get_blocked_agents()){
			if(!self::checkCookie() && !self::isCookiePage() && !is_admin()){
				wp_redirect( self::getCookiePageUri()."?u=".base64_encode(self::$requestscheme."://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]) );
				exit;
			}elseif(isset($_GET['a'])){
				if($_GET['a'] == 'y'){
					setcookie(self::$cookieName,1,time()+31556926 ,'/');
					wp_redirect(base64_decode($_GET['u']));
					exit;
				}
			}elseif(self::isCookiePage()){
				return true;
			}
			return false;
		}
		return  false;
	}
	
	public static function enqueueScripts(){
		array_push(self::$styles, array("Cookie-wall-style", COOKIE_WALL_PLUGIN_URI .'assets/css/style.css', array(), 1));
		array_push(self::$scripts, array("jquery", get_site_url().'/wp-includes/js/jquery/jquery.js', array(), 1));
		array_push(self::$scripts, array("cookie-wall-scripts", COOKIE_WALL_PLUGIN_URI.'assets/js/scripts.js', array(), 1));
	}

	private static function checkCookie() {
		if (!isset($_COOKIE[SELF::$cookieName])) {
			return false;
		}
		return true;
	}
	
	private static function getCookiePageUri(){
		return get_site_url()."/".get_page_uri(self::getCookiePageID())."/";
	}
	
	private static function getCurrentUri(){
		return self::$requestscheme."://".self::$httphost.self::$redirecturl;
	}
	
	private static function isCookiePage(){
		if(self::getCookiePageUri() === self::getCurrentUri()){
			return true;
		}
		return false;
	}
	
	private static function getCookiePageID(){
		$options = get_option('tropical_cookie_wall_options');
		return $options['content_page'];
	}
	
	private static function getStyles(){
		foreach(self::$styles as $style){
			$html .= "<link id=\"{$style[0]}\" href=\"{$style[1]}\" media=\"all\" rel=\"stylesheet\">".PHP_EOL;
		}
		return $html;
	}
	
	private static function getScripts(){
		foreach(self::$scripts as $script){
			$html .= "<script id=\"{$script[0]}\" src=\"{$script[1]}\" type='text/javascript'></script> ".PHP_EOL;
		}
		return $html;
	}
	
	private static function getPageBgImage(){
		$options = get_option('tropical_cookie_wall_options');
		return wp_get_attachment_url($options['background_url']);
	}
	
	private static function getPageBgColor(){
		$options = get_option('tropical_cookie_wall_options');
		return $options['background_color'];
	}
	
	private static function getBGBlur(){
		$options = get_option('tropical_cookie_wall_options');
		return $options['background_blur'];
	}
	
	private static function getLogoUrl(){
		$options = get_option('tropical_cookie_wall_options');
		return wp_get_attachment_url($options['content_logo']);
	}
	
	private static function getTrackingCode(){
		$options = get_option('tropical_cookie_wall_options');
		return "<script>
		    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		    	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		    ga('create', '{$options['trackingID']}', 'auto');
		    ga('set', 'anonymizeIp', true);
		    ga('set', 'displayFeaturesTask', null);
		    ga('send', 'pageview');
		</script>;";
	}
	
	private static function get_blocked_agents(){
		$blocked_agents = array ('Internet\ Explorer', 'MSIE', 'Chrome', 'Safari', 'Firefox', 'Windows', 'Opera', 'iphone', 'ipad', 'android', 'blackberry');
		foreach($blocked_agents as $agent){
			if(stristr(self::$useragent, $agent) !== FALSE) {
				return true;
			}
		}
		return false;
	}
	
	public static function createVars(){
		self::$useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : getenv('HTTP_USER_AGENT');
		self::$requestscheme = isset($_SERVER["REQUEST_SCHEME"]) ? $_SERVER['REQUEST_SCHEME'] : getenv('REQUEST_SCHEME');
		self::$httphost = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
		self::$redirecturl = isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : getenv('REDIRECT_URL');
	}
	
	public function shrt_cookieAccept($atts){
		$url = self::$requestscheme."://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]."&a=y";
		return "<a class=\"btn btn__accept\" href=\"{$url}\" id=\"accept_koe\">".__('Accept',COOKIE_WALL_TEXT_DOMAIN)."</a>";
	}
	
	public function shrt_pageEdit($atts){
		$post = get_post(self::getCookiePageID());
		return date_i18n( get_option( 'date_format' ), strtotime( $post->post_modified ) );
	}
	
	public function shrt_readmore($atts, $content = ""){
		$content = do_shortcode($content);
		return "<a href=\"#\" id=\"readmore\">".__('Read more',COOKIE_WALL_TEXT_DOMAIN)."</a>
			<div id=\"readmore_content\">$content</div>
		";
	}
}