<?php 
echo head(array(
	'title' => html_escape($exhibit->title . ' : '. $exhibit_page->title),
		'bodyid'=>'exhibit','bodyclass'=>'show'
));
?>
<div id="primary">
	<h1><?php echo link_to_exhibit(); ?></h1>

	<?php $childPages =  $exhibit_page->getChildPages();?>
	<?php $exhibit_page =  ($exhibit_page->parent_id) || !isset($childPages[0]) ? $exhibit_page : $childPages[0];?>

	<div id="nav-container">
    	  <?php echo exhibit_builder_page_nav($exhibit_page);?>
	</div>

	<h2><?php echo $exhibit_page->title; ?></h2>
	
	<div class="text-full exhibit-content">
		<?php exhibit_builder_render_exhibit_page($exhibit_page); ?>
	</div>

	<div id="exhibit-page-navigation">
		<?php if( count($childPages)>0 && $exhibit_page->id != $childPages[0]->id) 
			echo exhibit_builder_link_to_previous_page(null,array(),$exhibit_page); ?>
		<?php echo exhibit_builder_link_to_next_page(null,array(),$exhibit_page); ?>
	</div>
</div>	
<?php echo foot(); ?>
