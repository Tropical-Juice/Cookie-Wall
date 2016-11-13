<div class="wrap">
	<h1><?php echo __("Cookie Wall Options", COOKIE_WALL_TEXT_DOMAIN) ?></h1>
	<form method="post" action="options.php"> 
		<p> Background Blur</p>
		<?php 
			settings_fields( 'tropical-cookiewall_blur-amount' );
			do_settings_sections( 'tropical-cookiewall_blur-amount' );
		?>
		<hr>
		<?php submit_button(); ?>
	</form>
</div>