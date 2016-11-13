<?php

class CookieWall {
	private static $cookieName = "wp-cookie-wall";
	private static $initiated = false;
	
	
	public static function init() {
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
	}

	/**
	 * Initializes Plugin
	 */
	private static function init_hooks() {
		add_shortcode( 'accept_button', array('CookieWall', 'shrt_cookieAccept') );
		add_shortcode( 'readmore', array('CookieWall', 'shrt_readmore') );
		add_shortcode( 'page_edit_date', array('CookieWall', 'shrt_pageEdit') );
		self::$initiated = true;
		self::createCookieWall();		
	}
	
	public static function createCookieWall(){
		if(self::checkCookieWall()){
			$post = get_post(self::getCookiePageID());
			include('templates/cookiewall.php');
			exit;
		}
	}
	private static function checkCookieWall(){
		if(self::get_blocked_agents()){
			if(!self::checkCookie() && !self::isCookiePage() && !is_admin()){
				wp_redirect( self::getCookiePageUri()."?u=".base64_encode($_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]) );
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
		return $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"].$_SERVER["REDIRECT_URL"];
	}
	
	private static function isCookiePage(){
		if(self::getCookiePageUri() === self::getCurrentUri()){
			return true;
		}
		return false;
	}
	
	private static function getCookiePageID(){
		return 4;
	}
	
	private static function getPageBG(){
		return COOKIE_WALL_PLUGIN_URI.'assets/images/bg.png';
	}
	
	private static function getPageLogo(){
		return 'http://www.dev.tropicaljuice.nl/cookie-wall/wp-content/uploads/2016/11/Screen-Shot-2016-11-12-at-15.24.38.png';
	}
	
	private static function get_blocked_agents(){
		$blocked_agents = array ('Internet\ Explorer', 'MSIE', 'Chrome', 'Safari', 'Firefox', 'Windows', 'Opera', 'iphone', 'ipad', 'android', 'blackberry');
		foreach($blocked_agents as $agent){
			if(stristr($_SERVER['HTTP_USER_AGENT'], 'Safari') === FALSE) {
				
			}else{
				return true;
			}
		}
		return false;
	}
	public function shrt_cookieAccept($atts){
		$url = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]."&a=y";
		return "<a class=\"btn btn__accept\" href=\"{$url}\" id=\"accept_cookies\">".__('Accept',COOKIE_WALL_TEXT_DOMAIN)."</a>";
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