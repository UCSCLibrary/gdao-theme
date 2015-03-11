<?php if(!plugin_is_active('NeatlineTime')) : ?>
	<h2>Error: Neatline Time plugin not enabled.</h2>
<?php else: ?>
	<?php 
	$timelines = get_db()->getTable('NeatlineTimeTimeline')->findBy(array('title'=>'milestones'));
	$timeline = $timelines[0];
	?>
	<div id="<?php echo $timeline->id; ?>" class="neatlinetime-timeline">
	</div>
	<script>
	jQuery(document).ready(function($) {
		NeatlineTime.loadTimeline(
			"<?php echo $timeline->id;?>",
			"<?php echo neatlinetime_json_uri_for_timeline($timeline);?>"
		);
	});
	</script>
	<?php echo metadata($timeline, 'description'); ?>
<?php endif;?>                                                                     

