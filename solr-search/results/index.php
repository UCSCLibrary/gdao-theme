<?php

$pageTitle = __('Search Results');
echo head(array('title' => $pageTitle, 'id' => 'items', 'bodyclass' => 'search-results'));
?>

<div id="primary">
	<h1><?php echo $pageTitle; ?></h1>
	<div id="gdao_search_results_container">
	<?php if ($results->response->numFound == 0): ?>
		<div id="gdao_solr_results" style="padding: 10px; width: 97%">
			<p>We couldn't find anything that matched this search.</p>
			<p>If you have something, please <a href="/contribution">contribute it
			to the Archive.</a></p>
		</div>
	<?php else: ?>

      <div id="gdao_search_results_count">
        <strong><?php echo __('%s', $results->response->numFound); ?></strong> results
      </div>

    <div id="gdao_solr_results">
	<?php $number = 0; ?>
    	<?php foreach($results->response->docs as $doc): ?>
		<?php $curated = $doc->__get('420_s'); ?>
		<div class="gdao_solr_result <?php echo ($number++ % 2) ? 'even' : 'odd';  ?> 
<?php echo( (strcmp($curated, 'no') == 0) ? 'new-item' : ''); ?>">
		<?php $logo = $doc->__get('48_s'); ?>
		<?php $ark = $doc->__get('140_s'); ?>
		<?php $title = $doc->__get('title'); ?>
		<?php $itemtype = $doc->__get('itemtype'); ?>
		<?php $id = $doc->__get('modelid'); ?>
		<?php $model = $doc->__get('model'); ?>
		<?php $record = get_record_by_id($model,$id); ?>
		<?php $restricted = is_a($record,'Item') ? metadata($record,array('Item Type Metadata','AccessRestricted')) : false; ?>


		<?php set_current_record($model,$record); ?>

	    <?php if ($logo == 'Internet Archive'): ?>
		<div class="thumbnail_image">
			<?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
			<a href="<?php echo $uri . $id; ?>" alt="Item record">
			<img src="/themes/gdao-theme/images/ia-logo-sm.png"
				alt="<?php echo !empty($title) ? $title : ''; ?>"/>
			</a>
		</div>
	    <?php elseif ($itemtype == 'Sound'): ?>
		<div class="thumbnail_image">
			<?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
			<a href="<?php echo $uri . $id; ?>" alt="Item record">
                          <?php if ($restricted == 'true' && !gdao_is_authorized()): ?>
                            <img src="/themes/gdao-theme/images/content-not-available.png"
                            alt="Access limited to campus for copyright reasons"/>
                          <?php else: ?>
			    <img src="/themes/gdao-theme/images/itemtype-sound.png"
			    alt="<?php echo !empty($title) ? $title : ''; ?>"/>
			  <?php endif; ?>
                        </a>
		</div>
		<?php elseif ($itemtype == 'Video'): ?>
		<div class="thumbnail_image">
			<?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
			<a href="<?php echo $uri . $id; ?>" alt="Item record">
			<?php if ($restricted == 'true' && !gdao_is_authorized()): ?>
                           <img src="/themes/gdao-theme/images/content-not-available.png"
                           alt="Access limited to campus for copyright reasons"/>
                        <?php else: ?>
			   <img src="/themes/gdao-theme/images/itemtype-video.png"
			   alt="<?php echo !empty($title) ? $title : ''; ?>"/>
			<?php endif; ?>
                        </a>
		</div>
		<?php elseif ($itemtype == 'Story'): ?>
		<div class="thumbnail_image">
			<?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
			<a href="<?php echo $uri . $id; ?>" alt="Item record">
			<img src="/themes/gdao-theme/images/itemtype-oralhistory.png"
			  alt="<?php echo !empty($title) ? $title : ''; ?>"/>
                        </a>
		</div>
                <?php elseif ($itemtype == 'Article'): ?>
		<div class="thumbnail_image">
                        <?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
                        <a href="<?php echo $uri . $id; ?>" alt="Item record">
			<?php if ($restricted == 'true' && !gdao_is_authorized()): ?>
                           <img src="/themes/gdao-theme/images/content-not-available.png"
                           alt="Access limited to campus for copyright reasons"/>
                        <?php else: ?>
                           <img src="/themes/gdao-theme/images/itemtype-article.png"
                           alt="<?php echo !empty($title) ? $title : ''; ?>"/>
                        <?php endif; ?>
                        </a>
                </div>
		<?php elseif ($itemtype == 'Website'): ?>
		<div class="thumbnail_image">
			<?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
			<a href="<?php echo $uri . $id; ?>" alt="Item record">
			<img src="/themes/gdao-theme/images/itemtype-website.png"
			  alt="<?php echo !empty($title) ? $title : ''; ?>"/>
                        </a>
		</div>
		<?php elseif (!empty($ark)): ?>
		<div class="thumbnail_image">
			<?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
                        <a href="<?php echo $uri . $id; ?>" alt="Item record">
			<?php if ($restricted == 'true' && !gdao_is_authorized()): ?>
				<img src="/themes/gdao-theme/images/content-not-available.png"
				alt="Access limited to campus for copyright reasons"/>
			<?php else: /* ?>
                        	<img src="<?php echo JP2_IMAGE_SERVER; ?>/view/thumbnail/<?php echo
				urlencode($ark . '/is/1'); ?>" alt="<?php echo
				(!empty($title)) ? $title : ''; ?>"/>
			<?php */
                            if(is_a($record,'Item') && $record->hasThumbnail())
                	        echo item_image('thumbnail',array('alt'=>$title),0,$record);
                            else
                                echo '<img src="http://library.ucsc.edu/sites/default/files/imagecache/1-original-size/images/GDAO_round_lightbg.jpg" alt="'.$title.'" />';
                        endif; ?>
                        </a>
		</div>
		<?php elseif (is_a($record,'Item') && metadata($record,'has_files')): ?>
                <?php /* foreach(loop($files) as $file):*/ ?>
	                	<div class="thumbnail_image">
<?php echo link_to_item(item_image('square_thumbnail')); ?>
                    		<?php $uri = html_escape(WEB_ROOT) . '/items/show/'; ?>
                    		<a href="<?php echo $uri . $id; ?>" alt="Item record">
                      			<img src="<?php echo $thumb_path; ?>" alt="<?php echo $title; ?>"/>
                    		</a>
        		</div>
		<?php /* endforeach;*/ ?>

		<?php endif; ?>

    		<div class="gdao_search_item" id="solr_<?php echo $id; ?>">
          		<h3 class="gdao_search_item_label">
          		<?php
			$uri = html_escape(WEB_ROOT) . '/items/show/';
			echo '<a href="' . $uri . $id .'">' . gdao_shorten_text($title) . '</a>';?>
			<?php if ($itemtype != 'Backstage Pass' && $itemtype != 'Album Cover' && $itemtype != 'Laminate'): ?>
				<span class="item_type">
					<?php echo '(' . $itemtype . ')'; ?>
				</span>
			<?php endif; ?>
          		</h3>

			<?php $creators = $doc->__get('39_s'); ?>
			<?php $uri = html_escape(WEB_ROOT) . '/solr-search/results/index?solrq=39_s:'; ?>
			<?php if (!empty($creators) && is_array($creators)): ?>
			<h4>Creators:</h4>
         		<ul class="gdao_search_item_creators">
         		<?php foreach ($creators as $creator): ?>
				<li class="gdao_search_item_creator">
				<a href="<?php echo $uri . gdao_solr_escape($creator); ?>"><?php echo $creator; ?></a>
				</li>
				<?php endforeach; ?>
	        	</ul>
			<?php elseif (!empty($creators)): ?>
			<h4>Creator:</h4>
			<ul class="gdao_search_item_creators">
				<li class="gdao_search_item_creator">
				<a href="<?php echo $uri . gdao_solr_escape($creators); ?>">
				<?php echo $creators; ?>
				</a>
				</li>
			</ul>
			<?php endif; ?>

			<?php $shows = $doc->__get('38_s'); ?>
			<?php $uri = html_escape(WEB_ROOT) . '/solr-search/results/index?solrq=38_s:'; ?>

			<?php if (!empty($shows) && is_array($shows)): ?>
			<h4>Related shows:</h4>
			<ul class="gdao_search_item_shows">
				<?php foreach ($shows as $show): ?>
				<li class="gdao_search_item_show">
				<a href="<?php echo $uri . gdao_solr_escape($show); ?>">
				<?php echo $show; ?>
				</a>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php elseif (!empty($shows)): ?>
			<h4>Related show:</h4>
			<ul class="gdao_search_item_shows">
				<li class="gdao_search_item_show">
				<a href="<?php echo $uri . gdao_solr_escape($shows); ?>">
				<?php echo $shows; ?>
				</a>
				</li>
			</ul>
			<?php endif; ?>
		</div>
		</div>
    	<?php endforeach; ?>
    	<?php echo pagination_links(); ?>
        <?php endif; ?>
    </div>

    <?php if(!empty($facets) && $results->response->numFound > 0): ?>
      <?php //$query = SolrSearch_QueryHelpers::getParams(); 
	  $query = gdao_solr_get_params();
?>
      <div id="gdao_solr_facets">
        <?php echo gdao_create_sort_form(); ?>

        <h2 id="gdao_facets_label">Narrow your search</h2>
        <div>
        <?php foreach($results->facet_counts->facet_fields as $facet => $values): ?>
          <h3 class="gdao_facet_label">
        	<?php echo gdao_solr_search_element_lookup($facet); ?>
          </h3>
          <ul class="gdao_facet_values">
		<?php foreach($values as $label => $count): ?>
			<li><?php echo gdao_createFacetHtml($query, $facet, $label, $count); ?></li>
		<?php endforeach; ?>
          </ul>
        <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

  </div>
</div>


<?php echo foot(); ?>
