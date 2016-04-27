jQuery(document).ready(function($){

	$('.novafw-likes').live('click',
	    function() {
    		var link = $(this);
    		if(link.hasClass('active')) return false;
		
    		var id = $(this).attr('id'),
    			postfix = link.find('.novafw-likes-postfix').text();
			
    		$.post(novafw_likes.ajaxurl, { action:'novafw-likes', likes_id:id, postfix:postfix }, function(data){
    			link.html(data).addClass('active').attr('title','You already like this');
    		});
		
    		return false;
	});
	
	if( $('body.ajax-novafw-likes').length ) {
        $('.novafw-likes').each(function(){
    		var id = $(this).attr('id');
    		$(this).load(novafw.ajaxurl, { action:'novafw-likes', post_id:id });
    	});
	}

});