<?php echo head(array('bodyid'=>'home')); ?>

<div id="banner-home"><!--begin #banner-home -->
	<div class="content"><!--begin #banner-home .content -->
		<div class="six-1"></div>
		<div class="six-2"><a href="/milestones"><span>Milestones</span></a></div>
		<div class="six-3"><a href="/shows"><span>Shows</span></a></div>
		<div class="six-4"><a href="/artists"><span>Artists</span></a></div>
		<div class="six-5"><a href="/media"><span>Media</span></a></div>
		<div class="six-6"><a href="/fan-art"><span>Fan Art</span></a></div>
	</div><!-- end #banner .content -->
</div><!-- end #banner-home -->

<div id="primary"><!-- begin #primary -->
	<div class="content"><!-- begin #primary .content -->

		<div class="three-1">
			<h2>What\'s New</h2>
			<?php 
			//$recentItems = get_db()->getTable('Item')->findBy(array('recent'=>true,'collection'=>'Grateful Dead Archive'), 3); 
			$recentItems = get_recent_items(3);
			set_loop_records('items',$recentItems);
			if (has_loop_records('items')): ?>
			
				<div class="items-list">
					<?php foreach (loop('items') as $item): 

					$title = gdao_shorten_text(metadata($item,array('Dublin Core', 'Title')));
//					$itemtype = metadata($item,'item type name'); 
					$itemtype = $item->getItemType()->name;
					$ark = metadata($item, array('Item Type Metadata', 'ARK')); ?>
						
						<div class="item">

							<?php if (metadata($item, 'has thumbnail')): ?>
								<div class="image-item item-wrap">
									<?php echo link_to_item(item_image('square_thumbnail') ); ?>
								</div>
							<?php elseif ($itemtype == 'Fan Tape'): ?>
								<div class="fantape-item item-wrap">
									<?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
									<a href="<?php echo $uri . metadata($item,'ID'); ?>" alt="">
										<img src="<?php absolute_url('/themes/gdao-theme/images/ia-logo-sm.png')?>"
											alt="<?php echo !empty($title) ? $title : ''; ?>"/>
									</a>
								</div>
							<?php/* elseif ($itemtype == 'Sound'): ?>

								<div class="sound-item item-wrap">
									<?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
									<a href="<?php echo $uri . metadata($item,'ID'); ?>" alt="">
										<img src="/themes/gdao-theme/images/itemtype-sound.png"
											alt="<?php echo !empty($title) ? $title : ''; ?>"/>
									</a>
								</div>
							<?php*/ elseif ($itemtype == 'Video'): ?>
								<div class="video-item item-wrap">
									<?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
									<a href="<?php echo $uri . metadata($item,'ID'); ?>" alt="">
										<img src="/themes/gdao-theme/images/itemtype-video.png"
											alt="<?php echo !empty($title) ? $title : ''; ?>"/>
									</a>
								</div>
							<?php elseif ($itemtype == 'Story'): ?>
								<div class="oralhistory-item item-wrap">
									<?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
									<a href="<?php echo $uri . metadata($item,'ID'); ?>" alt="">
										<img src="/themes/gdao-theme/images/itemtype-oralhistory.png"
											alt="<?php echo !empty($title) ? $title : ''; ?>"/>
									</a>
								</div>
							<?php elseif ($itemtype == 'Website'): ?>
								<div class="website-item item-wrap">
									<?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
									<a href="<?php echo $uri . metadata($item,'ID'); ?>" alt="">
										<img src="/themes/gdao-theme/images/itemtype-website.png"
											alt="<?php echo !empty($title) ? $title : ''; ?>"/>
									</a>
								</div>
							<?php elseif ($itemtype == 'Article' && empty($ark)): ?>
								<div class="article-item item-wrap">
									<?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
									<a href="<?php echo $uri . metadata($item,'ID'); ?>" alt="">
										<img src="/themes/gdao-theme/images/itemtype-article.png"
											alt="<?php echo !empty($title) ? $title : ''; ?>"/>
									</a>
								</div>
								
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>

			<?php else: ?>
				<p>No recent items available.</p>
			<?php endif; ?>
			<p class="view-items-link"><span id="whatsnew-title"><?php echo link_to_item($title); ?></span><span>
				|<a href="/solr-search/results/index?sort=sortedCreateDate+desc" class="read-more" id="more-new">more recent items</a></span></p>
		</div>
		<div class="three-2">
			<h2>Upload Media</h2>
			<p id="contrib-text">Help build GDAO: a socially-constructed archive. Please share your photos and recordings to make this archive as deep an expression of dead culture as possible.</p>
			<p class="contribute"><a href="/contribution">Contribute</a>
		</div>
		<div class="three-3">
			<h2>Gdao on Facebook</h2>
			<div id="deadnews">
				<a href="https://www.facebook.com/pages/Grateful-Dead-Archive/97374802938">   
					<img src="/themes/gdao-theme/images/gdao-fb.png" />
				</a>
			</div>
		</div>
	</div><!-- end #primary .content -->
</div><!-- end #primary -->

<?php echo foot(); ?>
