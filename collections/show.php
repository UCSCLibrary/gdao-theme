<?php echo head(
	array(
		'title' => html_escape($collection->name),
			'bodyid'=>'collections',
			'bodyclass' => 'show'
	)); ?>
<div id="primary" class="show">
	<h2>
		<?php echo html_escape($collection->name); ?>
	</h2>
	<h1>
		<?php echo metadata($collection,array('Dublin Core','Title')); ?>
	</h1>
	<div id="collection-description" class="element">
		<h2>Description</h2>
		<div class="element-text"><?php echo metadata($collection,array('Dublin Core','Description')); ?></div>
	</div><!-- end collection-description -->

	<?php if ($collection->hasContributor()): ?>	
		<div id="collectors" class="element">
			<h2>Collector(s)</h2> 
			<div class="element-text">
				<ul>
					<li>
						<?php echo metadata($collection,array('Dublin Core','Contributors'), array('delimiter'=>'</li><li>')); ?>
					</li>
				</ul>
			</div>
		</div><!-- end collectors -->
	<?php endif; ?>

	<p class="view-items-link">
		<?php echo link_to_items_browse('View the items in ' . metadata($collection,array('Dublin Core','Title')), array('collection' => $collection->id)); ?>
	</p>
	<?php echo fire_plugin_hook('collections_show'); ?>
</div><!-- end primary -->
<?php echo foot(); ?>