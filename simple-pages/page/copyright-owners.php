<?php
$collection = get_db()->getTable('Collection')->find(3); // 'Copyright Clearance' collection
$limit = $collection->totalItems;
$items = get_records('Item',array('collection'=>$collId, 'sort_field'=>'Dublin Core,Title'), $limit);
$number = 0;
?>
<?php foreach($items as $item) : ?>
	<?php 
	$sortTitle = metadata($item, array('Dublin Core', 'Title'));
	$email = metadata($item, array('Item Type Metadata', 'Email'));
	$website = metadata($item, array('Item Type Metadata', 'Website'));
	$address = metadata($item, array('Item Type Metadata', 'StreetAddress'));
	$city = metadata($item, array('Item Type Metadata', 'City'));
	$state = metadata($item, array('Item Type Metadata', 'State'));
	$zip = metadata($item, array('Item Type Metadata', 'Zip'));
	$country = metadata($item, array('Item Type Metadata', 'Country'));
	$phone = metadata($item, array('Item Type Metadata', 'Phone'));
	?>

	<div class="copyright-owner <?php echo ($number++ % 2) ? 'even' : 'odd';  ?>" id="<?php echo $email; ?>">
		<div>
			<?php echo $sortTitle?> (<a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>)
		</div>
		<?php if ($address != '' || $phone != '' || $website != '') : ?>
			<div class="copyright-owner-contact-info">
				<?php if ($address != ''): ?>
					<div><?php echo $address ?></div>
					<div><?php echo $city . ', ' . $state . ' ' . $zip; ?></div>
					<div><?php echo $country; ?></div>
				<?php endif; ?>
				<?php if ($phone != ''): ?>
					<div><?php echo $phone; ?></div>
				<?php endif; ?>
				<?php if ($website != ''): ?>
					<div><a href="http://<?php echo $website; ?>" alt="website"><?php echo $website; ?></a></div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
	
<?php endforeach; ?>
