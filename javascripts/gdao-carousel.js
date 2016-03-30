function getUrlParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
	{
	    var sParameterName = sURLVariables[i].split('=');
	    if (sParameterName[0] == sParam) 
		{
		    return sParameterName[1];
		} else {
		return false;
	    }

	}
} 	


jQuery(document).ready(function() {
	var letter = getUrlParameter('letter');
	if(letter)
	    letter = "&letter="+letter;
	else
	    letter = "";
	var url='/gdao-helper/Envelope/get?offset=';

	var offset= carousel_offset ? carousel_offset : 0;

	jQuery('#fancarousel > a.next').click(function(){
		jQuery(this).css('cursor','wait');
		offset += 6;
		jQuery.get(url+offset+letter,function(data){
						jQuery('#fancarousel ul').hide("slide", { direction: "left" }, 600,function(){
				jQuery(this).remove();
				jQuery('#fancarousel').append('<ul style="display:none">'+data+'</ul>');
								jQuery('#fancarousel ul').show("slide", { direction: "right" }, 600);
				jQuery('#fancarousel > a.next').css('cursor','pointer');
			    });
		    });

	    });

	jQuery('#fancarousel > a.prev').click(function(){
		jQuery(this).css('cursor','wait');
		offset -= 6;
		offset = offset > 0 ? offset : 0;
		jQuery.get(url+offset+letter,function(data){
			jQuery('#fancarousel ul').hide("slide", { direction: "right" }, 600,function(){
				jQuery(this).remove();
				jQuery('#fancarousel').append('<ul style="display:none">'+data+'</ul>');
				jQuery('#fancarousel ul').show("slide", { direction: "left" }, 600);
				jQuery('#fancarousel > a.next').css('cursor','pointer');
			    });
		    });

	    });

});

