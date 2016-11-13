<!DOCTYPE html>
<html>
<head>
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta charset="utf-8">
	<meta content="ie=edge" http-equiv="x-ua-compatible">
	<title><?php echo apply_filters('the_title', $post->post_title); ?></title>
	<link href="<?php echo COOKIE_WALL_PLUGIN_URI ?>assets/css/style.css" media="all" rel="stylesheet">
	<style>
	    .background {
	        background: url('<?php echo self::getPageBG() ?>') no-repeat top center;
	        -webkit-filter: blur(5px);
	        -moz-filter: blur(5px);
	        -o-filter: blur(5px);
	        -ms-filter: blur(5px);
	        filter: blur(5px);
	    }
	</style>
</head>
<body class="cookie_wall">
	<section class="background"></section>
	<section class="overlay"></section>
	<main>
		<section>
			<img alt="logo" id="logo" src="<?php echo self::getPageLogo(); ?>">
			<h1><?php echo apply_filters('the_title', $post->post_title); ?></h1>
			<p></p>
			<?php echo apply_filters('the_content', $post->post_content); ?>
		</section>
	</main>
		<script src="<?php echo get_site_url()?>/wp-includes/js/jquery/jquery.js" type='text/javascript'>
		</script> 
		<script src="<?php echo COOKIE_WALL_PLUGIN_URI ?>assets/js/scripts.js" type='text/javascript'>
		</script> 
		<script>
		    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		    	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		    ga('create', 'UA-345702-4', 'auto');
		    ga('set', 'anonymizeIp', true);
		    ga('set', 'displayFeaturesTask', null);
		    ga('send', 'pageview');
		</script>
</body>
</html>