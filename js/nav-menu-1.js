/**
 * Menu type 1 helper.
 *
 * @category  Theme
 * @package   ClearOS
 * @author    ClearFoundation <developer@clearfoundation.com>
 * @copyright 2014 ClearFoundation
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link      http://www.clearfoundation.com/docs/developer/theming/
 */

$(document).ready(function() {
    if (jQuery(".theme-wizard-active").length == 0) {
        if (jQuery(window).width() < 801) {
            var left_nav = jQuery(".left_nav").html();
            jQuery(".left_nav").remove();
            jQuery(".small_menu").append("<ul class='left_nav'>"+left_nav+"</ul>");
        } else {
            var left_nav = jQuery(".left_nav").html();
            jQuery(".left_nav").remove();
            jQuery(".sidebar-form").after("<ul class='left_nav'>"+left_nav+"</ul>");
        }
    }
        function left_menu_js(){
            if (jQuery(window).width() < 801) {
                var left_nav = jQuery(".left_nav").html();
                jQuery(".left_nav").remove();
                jQuery(".small_menu").append("<ul class='left_nav'>"+left_nav+"</ul>");
                jQuery('.left_nav li a').click(function() {
                    if(!jQuery(this).parent().hasClass("active")) {
                        jQuery(this).parent().siblings('li').removeClass('active').find('>ul').slideUp('slow').find('li').removeClass('active');
                        jQuery(this).parent().addClass('active').find('>ul').slideDown('slow');
                    } else {
                        jQuery(this).parent().removeClass('active').find('>ul').slideUp('slow').find('li').removeClass('active');
                    }
                });
            } else {
                var left_nav = jQuery(".left_nav").html();
                jQuery(".left_nav").remove();
                jQuery(".sidebar-form").after("<ul class='left_nav'>"+left_nav+"</ul>");
                jQuery('.left_nav li a').click(function(){
                    if(!jQuery(this).parent().hasClass("active")) {
                        jQuery(this).parent().siblings('li').removeClass('active').find('>ul').slideUp('slow').find('li').removeClass('active');
                        jQuery(this).parent().addClass('active').find('>ul').slideDown('slow');
                    } else {
                        jQuery(this).parent().removeClass('active').find('>ul').slideUp('slow').find('li').removeClass('active');
                    }
                });
            }

    }
    
    jQuery(window).resize(function(){
        //left_menu_js();
    });
    //left_menu_js();

    /*
        Left sidebar Start
    */

    // open first menu by-default 
    // if(!jQuery('.left_nav li').hasClass("active")){
    //     jQuery('.left_nav li:first a:first').trigger('click');
    // } else {
    //     jQuery('.left_nav li.active').find('>ul.sub_menu').slideDown('slow');
    // }
	//jQuery(".sub_menu li.active > ul").slideDown('slow');
    var asidewidth = jQuery(".marketPlaceSection aside").width();
    jQuery(".left_nav").css('width', asidewidth);
    
    /*
        Left sidebar End
    */
    jQuery(".navbar-toggle").click(function(){
        jQuery(".small_menu").slideToggle();
    });
});	

