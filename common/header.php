<?php $hvals = gdao_run_header_functions() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" prefix="og: http://ogp.me/ns#">
	<head>
		<title>
			<?php echo $hvals['title']; ?>
		</title>

		<!-- Meta -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="<?php echo option('description'); ?>" />
		<meta name="viewport" content="initial-scale=1.0, width=device-width" />
		<meta name="date" content="<?php echo date('Y-m-d\TG:i:s\Z'); ?>"/>
		<meta property="og:title" content="<?php echo $hvals['item_title']; ?>" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="<?php echo $hvals['item_url'] ?>" />
		<meta property="og:image" content="<?php echo $hvals['item_image'];?>" />
		<meta property="og:description" content="<?php echo $hvals['item_description'];?>" />
		<meta name="google-site-verification" content="xe9V2u3rPSMSV6Hbd3qQ0DS26D01-8YDS2n_4yTX430" />
		<meta name="robots" content="index,follow" />

		<!-- new items / harvestable feed -->
		<link rel="alternate" type="application/atom+xml" title="GDAO New Items Feed" href="<?php echo absolute_url('/items/browse?output=atom')?>;" />

		<!-- favicon -->
		<link rel="icon" type="image/gif" href="/themes/gdao-theme/images/favicon.gif" />

		<?php queue_css_file('screen','screen'); ?>
		<?php queue_css_file('print','print'); ?>
		<?php queue_css_url('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" type="text/css'); ?>

		<?php echo fire_plugin_hook('public_head'); ?>

		<?php queue_js_url('https://www.google.com/jsapi'); ?>
		<?php/* queue_js_file('form-images');*/?>
		<?php queue_js_file('theme-scripts');?>

		<?php //page conditional scripts
		if(strpos($_SERVER['REQUEST_URI'],'fan-art')) {
			queue_css_file('carousel');
			queue_js_file('gdao-carousel');
			
		}else if(strpos($_SERVER['REQUEST_URI'],'milestones')) {
			queue_js_file('neatline-customizations'); 
			queue_css_file('timeline');
		}else if(strpos($_SERVER['REQUEST_URI'],'advanced-search')) {
			queue_js_file('gdao-adv-search');
		}else if(strpos($_SERVER['REQUEST_URI'],'contribution')) {
			queue_js_file('gdao-contribution');
		}
		?>

		<?php echo head_js(); ?>
		<?php echo head_css(); ?>

		<!--Google Analytics -->
		<script type="text/javascript">		
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-32396465-1']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();

		</script>
		<!-- End Google Analytics -->
		
	</head>
	<body
		<?php
		echo isset($bodyid) ? ' id="'.$bodyid.'"' : ''; 
		echo isset($bodyclass) ? ' class="'.$bodyclass.'"' : ''; 
		?>
		>
		<div id="banner"><!--begin #banner -->
			<div class="content"><!--begin #banner .content -->
				<h1><?php echo link_to_home_page(); ?></h1>
				<div id="banner-top"><!--begin #banner-top -->
					<ul id="nav-site">
						<?php echo nav(
							array(
								array('label'=>'home','uri' => url('/')),
								array('label'=>'about','uri' => url('about')),
								array('label'=> 'dead news','uri' => 'https://www.facebook.com/pages/Grateful-Dead-Archive/97374802938'),
								array('label'=> 'online exhibits','uri' => url('exhibits')),
								array('label'=> 'help','uri' => url('help'))
							)
						);
						?>
					</ul>
					<ul id="nav-contribute">
						<?php echo nav(
							array(
								array('label'=>'Add Content','uri' => url('contribution'))
							)
						);
						?>
					</ul>
				</div><!--end #banner-top -->
				<div id="banner-bottom"><!--begin #banner-bottom -->
					<ul id="nav-collection">
						<?php echo nav(
							array(
								array('label'=>'Shows','uri' => url('shows')),
								array('label'=>'Milestones','uri' => url('milestones')),
								array('label'=>'Artists','uri' => url('artists')),
								array('label'=>'Media','uri' => url('media')),
								array('label'=>'Fan Art','uri' => url('fan-art'))
							)
						);
						?>
					</ul>

					<div id="search-collection"><!--begin #search-collection -->
						<div id="searchwrapper"><!--begin #searchwrapper -->
							<form id="simple-search" action="/solr-search/results/index?" method="get">
								<fieldset>
									<?php $solrq = (isset($_REQUEST['solrq'])?$_REQUEST['solrq']:null); ?>
									<input type="text" name="q" id="solrq" value='<?php
														      echo empty($solrq) ? 'Search the Collection...' : $solrq;
														      ?>' class="searchbox default-value"/>
									<input type="image" name="submit_search" id="submit_search"
										src="/themes/gdao-theme/images/search-collection-transparent.png"
										class="searchbox_submit" value=""/>
								</fieldset>
							</form>
						</div><!-- end #searchwrapper -->
						<p><a href="/advanced-search">Advanced Search</a></p>
					</div><!--end #search-collection -->
				</div><!--end #banner-bottom -->
			</div><!-- end #banner .content -->
		</div><!--end #banner -->
		<div id="main">
