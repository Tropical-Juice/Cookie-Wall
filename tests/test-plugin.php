<?php
class PluginTest extends WP_UnitTestCase {
  // Check that that activation doesn't break
  function test_plugin_activated() {
	global $_SERVER;
	global $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_2) AppleWebKit/602.3.3 (KHTML, like Gecko) Version/10.0.2 Safari/602.3.3';
    $this->assertTrue( is_plugin_active( PLUGIN_PATH ) );
  }
}
