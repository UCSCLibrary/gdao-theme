<?php
$id = htmlspecialchars($_REQUEST["id"]);
$tag = htmlspecialchars($_REQUEST["tag"]);
//check csrf
if(version_compare(OMEKA_VERSION,'2.2.1') >= 0) {
  $csrf = new Omeka_Form_SessionCsrf;
  if(!$csrf->isValid($_POST)) {
    ?>
	<div>
		<span style="font-weight: bold;">Error (Invalid Csrf Nonce) </span><br/><br/>
		<a href="mailto:gdao-technical@ucsc.edu" title="Invalid CSRF Nonce"
			>Please let us know you encountered this error</a>
	</div>
    <?php
      }
}
if (empty($id)): ?>
	<div>
		<span style="font-weight: bold;">Error (failed to find record ID) </span><br/><br/>
		<a href="mailto:gdao-technical@ucsc.edu" title="Record for add-tag lacked ID"
			>Please let us know you encountered this error</a>
	</div>
<?php elseif (empty($tag)) : ?>
		<div>
			<span style="font-weight: bold;">Error (failed to find tag) </span><br/><br/>
			<a href="mailto:gdao-technical@ucsc.edu" title="Failed to tag submit on
									<?php echo $id; ?>">Please let us know you encountered this error</a>
		</div>
<?php else : 
	gdao_add_tag($id,$tag);
?>
	    <script language="JavaScript">
           self.location="<?php echo '/items/show/' . $id; ?>";
          </script>
	   <div>It seems your browser did not redirect back to the item page like it should have.</div>
	    <div><a href="/items/show/<?php echo $id; ?>">Return to the item record</a> to see your tags.</div>
  <?php
   endif; ?>
