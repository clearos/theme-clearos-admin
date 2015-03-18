(function($) {

	"use strict";
	
    $(document).ready(function() {

		/*
			Magic Line Start
		*/
		var $el,$current_index, leftPos, newWidth;

		/* Add Magic arrow markup via JavaScript, because it ain't gonna work without */
        /* But don't do this on wizard mode */
        if (jQuery(".theme-wizard-active").length == 0 && jQuery(".main-wrapper header > ul > li.placeholder").length == 0)
            jQuery("header").append("<span id='magic-arrow'>Arrow</span>");

		/* Cache it */
		var $magicLine = jQuery("#magic-arrow");
		
	 	jQuery("header").find("ul li").hover(function() {
			$el = jQuery(this);
			$current_index = $el.index();
			leftPos = $el.position().left;
			newWidth = $el.width();
			$magicLine.removeClass('magic_arrow_0 magic_arrow_1 magic_arrow_2 magic_arrow_3 magic_arrow_4').addClass("magic_arrow_"+$current_index);
			$magicLine.stop().animate({
				left: leftPos,
				width: newWidth
			});
		}, function() {
			$magicLine.stop().animate({
				left: $magicLine.data("origLeft"),
				width: $magicLine.data("origWidth")
			});    
		});


		/*
			Magic Line End
		*/


		/*
			Header Start
		*/

		var headerheight = jQuery(".main-wrapper header").height();
		var headerwidth = jQuery(".main-wrapper").width();
		jQuery(".main-wrapper header").css('width', headerwidth);
		jQuery(".main-wrapper header").sticky({topSpacing:0});


		/*
			Header End
		*/


	});	
})(jQuery);	
