<?php echo head(
	array(
		'title'=>'Browse Collections',
			'bodyid'=>'collections',
			'bodyclass' => 'browse'
	)); ?>
<div id="primary">
	<h1>Collections</h1>
	<div class="pagination">
		<?php echo pagination_links(); ?>
	</div>
	<?php foreach (loop('collections') as $collection): ?>
		<div class="collection">
            		<h2><?php echo link_to_collection(); ?></h2>
            		<div class="element">
				<h3>Description</h3>
				<div class="element-text"><?php echo text_to_paragraphs(metadata($collection,array('Dublin Core','Description'), array('snippet'=>150))); ?></div>
			</div>

			<?php if ($collection->hasContributor()): ?>			
            			<div class="element">
					<h3>Collector(s)</h3>
            				<div class="element-text">
						<p><?php echo metadata($collection,metadata("Dublin Core",'Contributor'), array('delimiter'=>', ')); ?></p>
            				</div>
            			</div>
            		<?php endif; ?>			
            		<p class="view-items-link"><?php echo link_to_items_browse('View the items in ' . metadata($collection,array('Dublin Core','Title')), array('collection' => $collection->id)); ?></p>
            		<?php echo fire_plugin_hook('collections_browse_each'); ?>
		</div><!-- end class="collection" -->
	<?php endforeach; ?>
	<?php echo fire_plugin_hook('collections_browse'); ?>
</div><!-- end primary -->

<?php echo foot(); ?>