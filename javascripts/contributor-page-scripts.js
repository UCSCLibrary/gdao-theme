
/* Change 'terms and conditions' text, and contrib name text. */
jQuery('fieldset#contribution-confirm-submit p').html('In order to contribute, you must read and agree to the <a target="_blank" href="/policies">GDAO Policies.</a>');
jQuery('body.contribution label[for="terms-agree"]').text('I agree to the GDAO Policies.');
jQuery('body.contribution label[for="contributor-name"]').text('Name (optional)');


/* Show copyright and license radio buttons on contribution page. Also add instruction to Your Story form. */

jQuery('select#contribution-type').change(function() {
	if (jQuery('div#required-fields').length == 0) {
	    jQuery('#required-fields').show().insertBefore('div#contribution-type-form');
	}
	if (jQuery('div#contrib-copyright').length == 0) {
	    jQuery('#copyright-markup').show().insertAfter('fieldset#contribution-contributor-metadata div.field:eq(1)');
	}
	if (jQuery(this).val() == '6') {
	    jQuery('#filetypes').remove();
	    jQuery('#audio-file-types').show().insertBefore('div#contribution-type-form');
	}
	if (jQuery(this).val() == '2') {
	    jQuery('#filetypes').remove();
	    jQuery('#image-file-types').show().insertBefore('div#contribution-type-form');
	}
	if (jQuery(this).val() == '129') {
	    jQuery('#filetypes').remove();
	    jQuery('#video-file-types').show().insertBefore('div#contribution-type-form');
	}
	if (jQuery(this).val() == '34') {
	    jQuery('#filetypes').remove();
	    jQuery('#image-file-types').show().insertBefore('div#contribution-type-form');
	}
	if (jQuery(this).val() == '35') {
	    jQuery('#filetypes').remove();
	}
	if (jQuery(this).val() == '36') {
	    jQuery('#filetypes').remove();
	    jQuery('#image-file-types').show().insertBefore('div#contribution-type-form');
	}
	if (jQuery(this).val() == '65') {
	    jQuery('#filetypes').remove();
	    jQuery('#image-file-types').show().insertBefore('div#contribution-type-form');
	}
	if (jQuery(this).val() == '68') {
	    jQuery('#filetypes').remove();
	    jQuery('#article-file-types').show().insertBefore('div#contribution-type-form');
	}
	if (jQuery(this).val() !== '5') {
	    jQuery('ul#oh-instructions').remove();
	}
	if(!jQuery('label[for="contributor-name"]').hasClass('optional')) {
	    jQuery('label[for="contributor-name"]').addClass('optional');
	}
    });

if (jQuery('div#required-fields').length == 0 && jQuery('body.contribution div#primary div.error').length > 0) {
    jQuery('#required-fields').show().insertBefore('div#contribution-type-form');
}

if (jQuery('div#contrib-copyright').length == 0 && jQuery('body.contribution div#primary div.error').length > 0) {
    jQuery('copyright-markup').show().insertAfter('fieldset#contribution-contributor-metadata div.field:eq(1)');
}

/* Add value 'anonymous' to name field for oral history contribution form. Add copyright and licence values to rights holder and rights fields. Add value 'no' to curated field (#Elements-420-0-text). Validate title field. Note: the copyright script below was updated 11/2013 as part of the GDAO Stabilization Project. See ITR ticket INC0069422 for details.*/

  
jQuery('body.contribution #primary form #form-submit').click(function(e) {

        var contribName = jQuery('input#contributor-name').val();

	var fairUse = '';

	var submitterRegents = '';

	var submittercc = '';

	var licenseccby = '';

	var licenseccbyna = '';

	var dateTime = jQuery('meta[name=date]').attr("content");
	var licenseType = jQuery('input[name=license]:checked', 'body.contribution #primary form').val();
	var copyrightType = jQuery('input[name=copyright]:checked', 'body.contribution #primary form').val();
	jQuery('#Elements-420-0-text').val('no'); 
	jQuery('#element-100 textarea').val(dateTime);
	if(!jQuery('input#contributor-name').val()) {
	    jQuery('input#contributor-name').val('anonymous');
	}
	if(!jQuery('input#contributor-name').val()) {
	    jQuery('#Elements-420-0-text').val('no'); 
	}
	
	if(licenseType == 'regents'){
	    jQuery('textarea#Elements-47-0-text').val(jQuery('#submitter-regents').html());
	}

	if(licenseType == 'Creative Commons Attribution'){
	    jQuery('textarea#Elements-47-0-text').val(jQuery('#submitter-cc').html());
	    jQuery('textarea#Elements-135-0-text').val(jQuery('#license-cc-by').html());
	}

	if(licenseType == 'Creative Commons Attribution Non-Commercial'){
	    jQuery('textarea#Elements-47-0-text').val(jQuery('#submitter-cc').html());
	    jQuery('textarea#Elements-135-0-text').val(jQuery('#license-cc-by-na').html());
	}
	
	if(copyrightType == 'fair-use'){
	    jQuery('textarea#Elements-47-0-text').val(jQuery('#fair-use').html());
	}

	if (jQuery('#element-50 textarea').val().length == 0) {
	    jQuery('#title-error').show().insertBefore('#primary h1');
	    window.scrollTo(0,0);
	    e.preventDefault();
	}
    });

/* Change 'terms and conditions' text, and contrib name text. */

jQuery('fieldset#contribution-confirm-submit p').html('In order to contribute, you must read and agree to the <a target="_blank" href="/policies">GDAO Policies.</a>');
jQuery('body.contribution label[for="terms-agree"]').text('I agree to the GDAO Policies.');
jQuery('body.contribution label[for="contributor-name"]').text('Name (optional)');
