<div id="fantapes_browse" class="three-1">
	<h2>Selected Internet Archive Fan Recordingz</h2>

	<h3><a href="/items/show/201441">Grateful Dead Live at Barton Hall, Cornell University on 1977-05-08</a></h3>
	<iframe src="https://archive.org/embed/gd77-05-08.maizner.hicks.5002.sbeok.shnf" width="250" height="30" frameborder="0"></iframe>

	<h3><a href="/items/show/197793">Grateful Dead Live at Hollywood Palladium on 1971-08-06</a></h3>
	<iframe src="https://archive.org/embed/gd71-08-06.aud.bertrando.yerys.129.sbeok.shnf" width="250" height="30" frameborder="0"></iframe>

	<h3><a href="/items/show/373601">Grateful Dead Live at Olympic Arena on 1983-10-17</a></h3>
	<iframe src="https://archive.org/embed/gd1983-10-17.mtx.seamons.fix2.92424.sbeok.flac16" width="250" height="30" frameborder="0"></iframe>

	<h3><a href="/items/show/371073">Grateful Dead Live at Madison Square Garden on 1979-09-04</a></h3>
	<iframe src="https://archive.org/embed/gd79-09-04.sbd.clugston.9452.sbeok.shnf" width="250" height="30"  frameborder="0"></iframe>

	<h3><a href="/items/show/222785">Live at Rich Stadium on 1989-07-04</a></h3>
	<iframe src="https://archive.org/embed/gd89-07-04.aud.wiley.9045.sbeok.shnf" width="250" height="30" frameborder="0"></iframe>
	<p><a href="solr-search/results/index?q=%28*%29&facet=itemtype:%22Fan%20Tape%22" class="more">View More Fan Tapes</a></p>
	
</div>
<?php
   if(plugin_is_active('avalonvideo')){  ?>
     <div id="audiorecs_browse" class="three-2">
	<h2>Selected Audio Recordings</h2>
	   <?php 
		$audio_width = '275';
		$audio_height = '30';
		$video_width = '275';
		$video_height = '260';
?>
	<h3><a href="/items/show/375875">Concert Line Recording: August 28, 1986 (Phil Lesh and Eileen Law)</a></h3>
<?php fire_plugin_hook('hydra_hls_embed',array('hydra_id'=>'q524jn76v','width'=>$audio_width,'height'=>$audio_height)); ?>
	<h3><a href="/items/show/375907">Concert Line Recording: October 10, 1986 (Jerry Garcia and Eileen Law)</a></h3>
<?php fire_plugin_hook('hydra_hls_embed',array('hydra_id'=>'wd375w296','width'=>$audio_width,'height'=>$audio_height)); ?>
<h3><a href="/items/show/375971">Concert Line Recording: August 22, 1986 (Eileen Law)</a></h3>		
<?php fire_plugin_hook('hydra_hls_embed',array('hydra_id'=>'t148fh143','width'=>$audio_width,'height'=>$audio_height)); ?>
<h3><a href="/items/show/378627">Jerry Garcia interview. Interview broadcast on WHMR, November 27, 1978 [radio broadcast]</a></h3> 
<?php fire_plugin_hook('hydra_hls_embed',array('hydra_id'=>'c247ds10z','width'=>$audio_width,'height'=>$audio_height)); ?>
<h3><a href="/items/show/378051">Phil Lesh interview. Broadcast on WQED in Pittsburgh in 1990 [radio broadcast]</a></h3>
<?php fire_plugin_hook('hydra_hls_embed',array('hydra_id'=>'r494vk18s','width'=>$audio_width,'height'=>$audio_height)); ?>
   <p><a href='/solr-search/results/index?q=(*)&facet=itemtype:"Sound"' class="more">View More Audio Recordings</a></p>

</div>

<div id="videorecs_browse" class="three-3">
	<h2>Selected Video Recordings</h2>
	<h3><a href="/items/show/225506">Not Too Old for Rock and Roll: a segment of the television program, 20/20, originally broadcast in 1980 [excerpt]</a></h3>
<?php fire_plugin_hook('hydra_hls_embed',array('hydra_id'=>'ht24wj427','width'=>$video_width,'height'=>$video_height)); ?>

	<h3><a href="/items/show/225570">Touch of Grey: music video produced in 1987 [excerpt]</a></h3>
<?php fire_plugin_hook('hydra_hls_embed',array('hydra_id'=>'6969z080f','width'=>$video_width,'height'=>$video_height)); ?>
	<p><a href='/solr-search/results/index?q=(*)&facet=itemtype:"Video"' class="more">View More Videos</a></p>
	
</div>


<?php
   }
?>
 
