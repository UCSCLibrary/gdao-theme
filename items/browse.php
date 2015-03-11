<?php echo head(array('title'=>'Browse Items','bodyid'=>'items','bodyclass' => 'browse')); ?>

  <div id="primary">

  <h1>Browse Items (<?php echo total_records('Item'); ?> total)</h1>

  <ul class="items-nav navigation" id="secondary-nav">
    <!--  -->
    <?php
//echo nav(array('Browse All' => url('items'), 'Browse by Tag' => url('items/tags'))); 
        echo nav(
            array(
                array('label'=>'Browse by Tag','uri' => url('items/tags'))
            )
        ); 
?>
  </ul>

  <div id="pagination-top" class="pagination"><?php echo pagination_links(); ?></div>
  <?php foreach (loop('items') as $item): ?>
    <div class="item hentry">
      <div class="item-meta">
    <?php if (metadata($item,'has_thumbnail')): ?>
          <div class="item-img">
	     <?php echo link_to_item(item_image('square_thumbnail')); ?>
          </div>
        <?php endif; ?>

    <h2><?php echo link_to_item(metadata($item,array('Dublin Core', 'Title'), array('class'=>'permalink'))); ?></h2>

        <?php if ($text = metadata($item, array('Item Type Metadata', 'Text'), array('snippet'=>250))): ?>
          <div class="item-description">
            <p><?php echo $text; ?></p>
          </div>
        <?php elseif ($description = metadata($item, array('Dublin Core', 'Description'), array('snippet'=>250))): ?>
          <div class="item-description">
            <?php echo $description; ?>
          </div>
        <?php endif; ?>

	  <?php if (metadata($item, 'has tags')): ?>
          <div class="tags"><p><strong>Tags:</strong>
            <?php echo tag_string($item); ?></p>
          </div>
        <?php endif; ?>

	    <?php echo fire_plugin_hook('items_browse_each'); ?>

      </div><!-- end class="item-meta" -->
    </div><!-- end class="item hentry" -->
  <?php endforeach; ?>

  <div id="pagination-bottom" class="pagination"><?php echo pagination_links(); ?></div>
    <?php 
//echo plugin_append_to_items_browse(); 
?>
  </div><!-- end primary -->

<?php echo foot(); ?>
