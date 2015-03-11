<?php echo head(array('title'=>'Browse Items','bodyid'=>'items','bodyclass'=>'tags')); ?>

<div id="primary">
	<h1>Browse Items by Tag</h1>
	<?php echo tag_cloud($tags, url('items/browse')); ?>
</div>

<?php echo foot(); ?>
