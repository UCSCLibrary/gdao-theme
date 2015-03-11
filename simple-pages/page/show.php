<?php
  if(metadata('simple_pages_page', 'slug') == "milestones")
    queue_timeline_assets();
  if(metadata('simple_pages_page', 'slug') == "ajax")
    gdao_handle_ajax();
?>
<?php echo head(array(
    'title' => metadata('simple_pages_page', 'title'),
    'bodyclass' => 'page simple-page',
    'bodyid' => metadata('simple_pages_page', 'slug')
)); ?>

<div id="primary">

<p id="simple-pages-breadcrumbs" class="navigation secondary-nav"><?php echo simple_pages_display_breadcrumbs(); ?></p>

<h1><?php echo metadata('simple_pages_page', 'title'); ?></h1>

    <?php
    $text = metadata('simple_pages_page', 'text', array('no_escape' => true));
    echo $this->shortcodes($text);
    ?>
</div>

<?php echo foot(); ?>
