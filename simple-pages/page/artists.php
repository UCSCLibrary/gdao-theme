<?php $solr = new Apache_Solr_Service(get_option('solr_search_host'),get_option('solr_search_port'),get_option('solr_search_core')); ?>
<?php $xml = simplexml_load_string(file_get_contents(dirname(dirname(dirname(__FILE__))).'/meta/artists.xml'));?>
<?php $result = gdao_get_photographers($solr);?>
<div id="photographers" class="two-1">
	<h2>Photographers</h2>

	<?php foreach ($result['facet_counts']['facet_fields']['39_s'] as $name => $count) : ?>

		<?php $restricted = $xml->xpath('/artists/artist[name="' . str_replace('"', '', $name) . '"]/restricted-access'); ?>
		<?php $filename = $xml->xpath('/artists/artist[name="' . str_replace('"', '', $name) . '"]/thumb');?>

		<div class="artists-browse">
			<div>
				<h3>
						<a href="/solr-search/results/index?q=39_s:<?php echo gdao_solr_escape($name);?>">
							<?php echo htmlspecialchars($name);?>
						</a> 

						<span class="count">
							(<?php echo $count;?>)
						</span>
				</h3>
			</div>
			<div>
				<a href="/solr-search/results/index?q=39_s:<?php echo gdao_solr_escape($name);?>">
					<?php if (count($restricted) > 0 && !gdao_is_authorized()) : ?>
						<img src="/themes/gdao-theme/images/content-not-available.png"/>
					<?php else: ?>
						<img src="<?php echo public_url('files/square_thumbnails/').$filename[0];?>.jpg"/>
					<?php endif; ?>
				</a>
			</div>
		</div>
	<?php endforeach; ?>
	
	<p class="browse-more">
		<a href="/solr-search/results/index?q=<?php echo urlencode(gdao_get_photographer_search());?>" class="more">
			View More Photographers
		</a>
	</p>
</div>

<?php $result = gdao_get_poster_artists($solr); ?>

<div id="poster-artists" class="two-2">
	<h2>Poster Artists</h2>

	<?php foreach ($result['facet_counts']['facet_fields']['39_s'] as $name => $count) : ?>
		<?php if (!startsWith($name, 'Greene, Herb, 1942-')) : ?>
			<?php $restricted = $xml->xpath('/artists/artist[name="' . str_replace('"', '', $name) . '"]/restricted-access');?>
			<?php $filename = $xml->xpath('/artists/artist[name="' . str_replace('"', '', $name) . '"]/thumb');?>

			<div class="artists-browse">
				<div>
					<h3>
						<a href="/solr-search/results/index?q=39_s:<?php echo gdao_solr_escape($name);?>">
							<?php echo htmlspecialchars($name);?>
						</a> 
						<span class="count">
							(<?php echo $count;?>)
						</span>
					</h3>
				</div>
				<div>
					<a href="/solr-search/results/index?q=39_s:<?php echo gdao_solr_escape($name)?>;">
						<?php if (count($restricted) > 0 && !gdao_is_authorized()) : ?>
							<img src="/themes/gdao-theme/images/content-not-available.png"/>
						<?php else : ?>
							<img src="<?php echo public_url('files/square_thumbnails/').$filename[0];?>.jpg"/>
						<?php endif;?>
					</a>
				</div>
			</div>
		<?php endif;?>
	<?php endforeach;?>

	<p class="browse-more">
		<a href="/solr-search/results/index?q=<?php echo urlencode(gdao_get_poster_artist_search());?>" class="more">View More Poster Artists</a>
	</p>
</div>
