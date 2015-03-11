  /* new contributions script */

  jQuery('#gdao_solr_results .new-item h3 a').each(function() {
    var itemUrl = jQuery(this).attr('href');
	var reviewUrl =jQuery('<p class="new-button"><a href="' + itemUrl + '">Newly Contributed. Please review.</a>');
	reviewUrl.insertAfter(this.parentNode);
  });

  if(jQuery('div#primary').hasClass('new-item')) {
  var reviewLink = jQuery('<p class="new-button"><a href="#flagthis">Newly Contributed. Please review.</a>');
  reviewLink.insertBefore('div#fields-primary');
  }

  /* end new contributions script */
