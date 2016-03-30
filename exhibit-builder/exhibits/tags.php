<?php
$title = __('Browse Exhibits by Tag');
echo head(array('title' => $title, 'bodyid' => 'exhibit', 'bodyclass' => 'tags'));
?>
<div id="primary">
<h1><?php echo $title; ?></h1>
<?php 
    $secNav =  nav(array(
        array('label'=>__('Browse All'), 'uri' => url('exhibits/browse')),
        array('label'=>__('Browse by Tag'),'uri' => url('exhibits/tags'))
    ));
    $secNav->setUlId('secondary-nav');
    $secNav-setUlClass('navigation exhibit-tags');
    echo $secNav;
 ?>

<?php echo tag_cloud($tags,url('exhibits/browse')); ?>
</div>
<?php echo foot(); ?>
