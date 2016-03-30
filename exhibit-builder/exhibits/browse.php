<?php
$title = __('Browse Exhibits');
echo head(
    array(
	'title'=>$title, 
	'bodyid' => 'exhibit', 
	'bodyclass'=>'browse'
    ));

$db =get_db();
$total_records = $db->fetchOne( 'SELECT COUNT(*) AS count FROM '.$db->Exhibit );
?>
<div id="primary">
  <h1><?php echo $title; ?> <?php echo __('(%s total)', $total_records); ?></h1>
  <?php if (count($exhibits) > 0): ?>
    <?php 
    $secNav =  nav(array(
	array('label'=>__('Browse All'), 'uri'=> url('exhibits')),
	array('label'=>__('Browse by Tag'), 'uri' => url('exhibits/tags'))
    ));
    $secNav->setUlId('secondary-nav');
    echo $secNav;
    ?>
    
    <div class="pagination"><?php echo pagination_links(); ?></div>
    
    <div id="exhibits">	
      <?php $exhibitCount = 0; ?>
      <?php foreach(loop('exhibits') as $exhibit): ?>

	<?php $desks = explode("!itemid!",$exhibit->description)?>
	<?php $description = $desks[0];?>
	<?php $item = get_record_by_id('Item',$desks[1]);?>

    	<?php $exhibitCount++; ?>
    	<div class="exhibit <?php if ($exhibitCount%2==1) echo ' even'; else echo ' odd'; ?>">
	  <div class="exhibit-image">
	    <?php echo link_to_item(item_image('fullsize',array(),0,$item),array(),'show',$item);?>
	  </div>

	  <h2><?php echo link_to($exhibit,null,$exhibit->title); ?></h2>

    	  <div class="description"><?php echo $description; ?></div>
    	  <p class="tags"><?php echo tag_string($exhibit, url('exhibits/browse/tag/')); ?></p>
    	</div>
      <?php endforeach; ?>
    </div>
    
    <div class="pagination"><?php echo pagination_links(); ?></div>

  <?php else: ?>
    <p><?php echo __('There are no exhibits available yet.'); ?></p>
  <?php endif; ?>
</div>
<?php echo foot(); ?>
