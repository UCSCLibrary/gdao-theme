<?php echo head(array('title' => html_escape('Summary of ' . $exhibit->title),'bodyid'=>'exhibit','bodyclass'=>'summary')); ?>
<div id="primary">
	<h1><?php echo html_escape($exhibit->title); ?></h1>
	<?php //die(exhibit_builder_page_nav()); 
	?>

	<ul class="exhibit-section-nav">
		<?php set_exhibit_pages_for_loop_by_exhibit($exhibit); ?>
		<?php foreach (loop('exhibit_page') as $exhibitPage): ?>
			<li>
				<a class="exhibit-section-title" href="<?php echo $exhibitPage->getRecordUrl();?>">
					<?php echo $exhibitPage->title;?>
				</a>
			</li>
		<?php endforeach; ?>	
	</ul>

	<?php $desks = explode("!itemid!",$exhibit->description)?>
	<?php $description = $desks[0];?>
	<?php $item = get_record_by_id('Item',$desks[1]);?>

	<div class="exhibit-image">
		<?php echo link_to_item(item_image('fullsize',array(),0,$item),array(),'show',$item);?>
	</div>

	<p class="exhibit-content" id="exhibit-description">
		<?php echo $description; ?>		
	</p>
	<p class="exhibit-content">
		<?php echo $exhibit->credits; ?>		
	</p>


</div>
<?php echo foot(); ?>
