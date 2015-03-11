// JavaScript Document

jQuery(document).ready(function() {

	/* item page scripts */

	// Show/hide for item page fields
	jQuery('p.more').toggle(
				function() {
				    jQuery('#fields-secondary').slideDown();
				    jQuery(this).html('Hide Details');
				},
				function() {
				    jQuery('#fields-secondary').slideUp();
				    jQuery(this).html('Show Details');
				}
				);

	// item page styles
	jQuery('#fields-primary div.description h3').addClass('hidden');
	jQuery('body#items div#primary object').wrap('<div class="object" />');
	jQuery('body#items div#primary iframe').wrap('<div class="iframe" />');
	jQuery('body#items div.description').appendTo('body#items div.url');

	if (jQuery('div#fields-secondary div.format a:contains("Video recording")').length > 0) 
	    jQuery("div#fields-primary div.object").addClass('video');

	//comment styles
	jQuery('body#items p.comment-reply').addClass('more');
	jQuery('form#comment-form label[for="author_url"]').addClass('hidden');
	jQuery('form#comment-form label[for="author_url"] + div').addClass('hidden');

	// Comment form dialog 
	if (jQuery('div#comments-flash div.success').length > 0) {
	    jQuery('div#comments-flash').addClass('hidden');
	    alert ('Thanks. Your comments will be vetted and posted soon');
	}

	/* Adding 'flag this' link and 'newly contributed, please review. */
	var pageUrl = jQuery(location).attr('href');
	var urlIndex = pageUrl.lastIndexOf('/');
	var itemNumber = pageUrl.substring(urlIndex + 1, pageUrl.length);

	/* end of item page scripts */


	/* exhibit scripts */
	
	item_id = jQuery('body#exhibit > #exhibit-thumb-item').text();
	jQuery('body#exhibit > #exhibit-image a').prop('href',"");

	/*
	jQuery('body#exhibit ul.exhibit-page-nav')
	    .insertAfter('body#exhibit div#primary div#nav-container');

	jQuery('body#exhibit #primary > h2')
	    .next().addClass('exhibit-content');

	jQuery('body#exhibit div#primary > h2')
	    .prependTo('body#exhibit div#primary div.exhibit-content');

	jQuery('body#exhibit div#primary div#exhibit-page-navigation')
	    .insertAfter('body#exhibit div#primary div.exhibit-content');

	jQuery('body#exhibit ul.exhibit-page-nav li:first-child')
	    .addClass('first');

	jQuery('body#exhibit #primary p:empty')
	    .addClass('hidden');

	jQuery('body#exhibit div#exhibit-sections')
	    .addClass('hidden');


	/* Modify img src on exhibit pages to point to desired image in record. */
	/*	jQuery('body#exhibit div.exhibit-item').each(function(){
		if (jQuery(this).find('address').length > 0) {
		    var imgNumber = jQuery(this).find('address').text();
		    var imgNumber = imgNumber.trim();
		    var imgSrc = jQuery(this).find('img').attr('src');
		    var imgSrc = imgSrc.slice(0,-1);
		    jQuery(this).find('img').attr("src", imgSrc + imgNumber);
		    jQuery(this).find('address').addClass('hidden');
		};
	    });
*/
	/* add image to /exhibits and main exhibit pages */
	/*
	if(jQuery('body.summary address').length > 0){
	    jQuery('div#primary h2.hidden').remove();
	    jQuery('div#primary h2').addClass('hidden');
	    imgArk = jQuery('body.summary div#primary address').text();
	    arkArray = imgArk.split('/');
	    imgArk = arkArray[0];
	    imgNumber = arkArray[1];
	    itemNumber = arkArray[2];
	    imgSrc = 'http://images.gdao.org/view/image/ark%3A%2F38305%2F' + imgArk + '%2Fis%2F' + imgNumber;
	    imgLink = '<div class="exhibit-image"><a href="http://www.gdao.org/items/show/' + itemNumber + '"><img src="' + imgSrc + '"></a></div>';
	    jQuery(imgLink).insertAfter('div#primary h2');
	    jQuery('body.summary #primary address').addClass('hidden');
	}
	*//*
	jQuery('body.browse div#exhibits div.exhibit').each(function(){
		if (jQuery(this).find('address').length > 0) {
		    imgArk = jQuery(this).find('address').text();
		    arkArray = imgArk.split('/');
		    imgArk = arkArray[0];
		    imgNumber = arkArray[1];
		    exhibitLink = jQuery(this).find('h2 a').attr('href');
		    imgSrc = 'http://images.gdao.org/view/thumbnail/ark%3A%2F38305%2F' + imgArk + '%2Fis%2F' + imgNumber;
		    imgLink = '<div class="exhibit-image"><a href="' + exhibitLink + '"><img src="' + imgSrc + '"></a></div>';
		    jQuery(imgLink).prependTo(jQuery(this));
		    jQuery('body.browse div#exhibits address').addClass('hidden');
		};
	    });
*/

	/* end of exhibit scripts */

	/* Erase the sample text in the search box when a user clicks there 
	 * this is from: http://stackoverflow.com/questions/2544441/clearing-a-default-value-in-a-search-box-with-jquery 
	 */
	jQuery('').click(function(){
		if(jQuery('#solrq').val() == 'Search the Collection...')
		    jQuery('#solrq').val('');
	    });
	jQuery('#submit_search').click(function() {
		if(jQuery('#solrq').val() == 'Search the Collection...') {
		    jQuery('#solrq').val('');
		}
		else {
		    jQuery('#solrq').val(jQuery('#solrq').val().replace(': ', ' '));
		}
	    });


	/* change text of pagination buttons */
	jQuery('li.pagination_first a').text('<<');
	jQuery('li.pagination_previous a').text('<');
	jQuery('li.pagination_next a').text('>');
	jQuery('li.pagination_last a').text('>>');

	/* toggle facet links. this is from http://jsbin.com/odire */
	jQuery('ul.gdao_facet_values').each(function(){
		var $this = jQuery(this), lis = $this.find('li:gt(9)').hide();
		if(lis.length>0){
		    $this.append(jQuery('<li class="more">').text('More').click(function(){
				lis.toggle();
				jQuery(this).text(jQuery(this).text() === 'More' ? 'Less' : 'More');
			    }));
		}
	    });

	/* Preload theme images */
	/* This is from: http://chipsandtv.com/articles/jquery-image-preload */
	var images = [
		      '/themes/gdao-theme/images/bg-banner-320.png',
		      '/themes/gdao-theme/images/bg-banner-home.jpg',
		      '/themes/gdao-theme/images/bg-banner.png',
		      '/themes/gdao-theme/images/bg-button-gray.png',
		      '/themes/gdao-theme/images/bg-footer.png',
		      '/themes/gdao-theme/images/bg-main.png',
		      '/themes/gdao-theme/images/icon-artists-over.jpg',
		      '/themes/gdao-theme/images/icon-artists.jpg',
		      '/themes/gdao-theme/images/icon-fanart-over.jpg',
		      '/themes/gdao-theme/images/icon-fanart.jpg',
		      '/themes/gdao-theme/images/icon-media-over.jpg',
		      '/themes/gdao-theme/images/icon-media.jpg',
		      '/themes/gdao-theme/images/icon-milestones-over.jpg',
		      '/themes/gdao-theme/images/icon-milestones.jpg',
		      '/themes/gdao-theme/images/icon-shows-over.jpg',
		      '/themes/gdao-theme/images/icon-shows.jpg',
		      '/themes/gdao-theme/images/line-footer.png',
		      '/themes/gdao-theme/images/logo-gdao-gray.png',
		      '/themes/gdao-theme/images/logo-gdao-over.png',
		      '/themes/gdao-theme/images/logo-gdao.png',
		      '/themes/gdao-theme/images/ribbon.jpg',
		      '/themes/gdao-theme/images/search-collection.png',
		      '/themes/gdao-theme/images/site-nav-arrow.png'
		      ];

	jQuery(images).each(function() {
		var image = jQuery('<img />').attr('src', this);
	    });

    });
