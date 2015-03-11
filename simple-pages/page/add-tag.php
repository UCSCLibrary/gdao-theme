<?php
$id = htmlspecialchars($_GET["id"]);
$tag = htmlspecialchars($_GET["tag"]);
if (empty($id)): ?>
	<div>
		<span style="font-weight: bold;">Error (failed to find record ID) </span><br/><br/>
		<a href="mailto:gdao-technical@ucsc.edu" title="Record for add-tag lacked ID"
			>Please let us know you encountered this error</a>
	</div>
	<?php else if (empty($tag)) : ?>
		<div>
			<span style="font-weight: bold;">Error (failed to find tag) </span><br/><br/>
			<a href="mailto:gdao-technical@ucsc.edu" title="Failed to tag submit on
									<?php echo $id; ?>">Please let us know you encountered this error</a>
		</div>
	<?php else : 
	$response = gdao_get_tag($id,$tag);
	if ($response->isSuccessful()) {?>
			<script language="JavaScript">
			self.location="<?php echo '/items/show/' . $id; ?>";
			</script>
			<div>It seems your browser did not redirect back to the item page like it should have.</div>
			<div><a href="/items/show/<?php echo $id; ?>">Return to the item record</a> to see your tags.</div><?php
    }
    else { ?>
      <div>
        <span style="font-weight: bold;">Error (HTTP response): </span>
        <a href="mailto:gdao-technical@ucsc.edu" title="<?php echo
        $response->getMessage(); ?>">Please let us know you encountered this error</a>
      </div><?php
    }
  }
  else { ?>
      <div>
        <span style="font-weight: bold;">Error (HTTP response): </span>
        <a href="mailto:gdao-technical@ucsc.edu" title="<?php echo
        $response->getMessage(); ?>">Please let us know you encountered this error</a>
      </div><?php
  }?>
<?php endif; ?>
