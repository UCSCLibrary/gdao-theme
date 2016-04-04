</div><!-- end #main> -->
<div id="footer"><!-- begin #footer -->
	<div class="content"><!-- begin #footer .content -->
		<div class="four-1">
			<h3>GDAO</h3>
			<a href="/"><img src="<?php echo absolute_url('/themes/gdao-theme/images/logo-gdao-gray.png')?>" /></a>
                        <ul>
			  <li><a href="<?php echo url('/policies'); ?>">Policies</a></li>
			  <li><a href="<?php echo url('/credits'); ?>">Credits</a></li>
			</ul>
		</div>
		<div class="four-2">
			<h3>UCSC</h3>
			<a href="http://www.ucsc.edu/"><img src="<?php echo absolute_url('/themes/gdao-theme/images/logo-ucsc-gray.png')?>" /></a>
			<ul>
				<li><a href="http://library.ucsc.edu">UCSC Library</a></li>
				<li><a href="http://library.ucsc.edu/grateful-dead-archive">Visit the Archive in the Library</a></li>
				<li><a href="http://library.ucsc.edu/grateful-dead-archive/donate">Support the Grateful Dead Archive</a></li>
			</ul>
		</div>
		<div class="four-3">
			<h3>Partners</h3>
			<a href="http://www.cdlib.org/"><img src="<?php echo absolute_url('/themes/gdao-theme/images/logo-cdl-gray.png')?>" /></a>
			<a href="http://designbycosmic.com/"><img src="<?php echo absolute_url('/themes/gdao-theme/images/logo-cosmic-gray.png')?>" /></a>
			<a href="http://www.imls.gov/"><img src="<?php echo absolute_url('/themes/gdao-theme/images/logo-imls-gray.png')?>" /></a>
			<a href="http://archive.org/index.php" class="logo"><img src="<?php echo absolute_url('/themes/gdao-theme/images/logo-ia-gray.png')?>" /></a>
			<a href="http://omeka.org/" class="logo"><img src="<?php echo absolute_url('/themes/gdao-theme/images/logo-omeka-gray.png')?>" /></a>
		</div>
		<div class="four-4">
			<h3>Connect</h3>
			<ul>
				<li><a href="mailto:grateful@ucsc.edu">grateful@ucsc.edu</a></li>
				<li><a href="http://www.facebook.com/pages/Grateful-Dead-Archive/97374802938">Facebook</a></li>
			</ul>
		</div>
	</div><!-- end #footer .content -->
</div><!-- end #footer -->


<?php 
echo fire_plugin_hook('public_footer'); 
if(strpos($_SERVER['REQUEST_URI'],'contribution'))
  include(dirname(dirname(__FILE__)).'/contribution/contribution_additions.php');
?>

</body>
</html>
