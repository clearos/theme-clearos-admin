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
        if (jQuery(window).width() < 801) {
            var left_nav = jQuery(".left_nav").html();
            jQuery(".left_nav").remove();
            jQuery(".small_menu").append("<ul class='left_nav'>"+left_nav+"</ul>");
        } else {
            var left_nav = jQuery(".left_nav").html();
            jQuery(".left_nav").remove();
            jQuery(".sidebar-form").after("<ul class='left_nav'>"+left_nav+"</ul>");
        }
        function left_menu_js(){
            if (jQuery(window).width() < 801) {
                var left_nav = jQuery(".left_nav").html();
                jQuery(".left_nav").remove();
                jQuery(".small_menu").append("<ul class='left_nav'>"+left_nav+"</ul>");
                    jQuery('.left_nav li a').click(function(){

                    if(!jQuery(this).parent().hasClass("active")){
                        jQuery(this).parent().siblings('li').removeClass('active').find('>ul').slideUp('slow').find('li').removeClass('active');
                        jQuery(this).parent().addClass('active').find('>ul').slideDown('slow');
                    }else{

                        jQuery(this).parent().removeClass('active').find('>ul').slideUp('slow').find('li').removeClass('active');
                    }
                });
            } else {
                var left_nav = jQuery(".left_nav").html();
                jQuery(".left_nav").remove();
                jQuery(".sidebar-form").after("<ul class='left_nav'>"+left_nav+"</ul>");
                jQuery('.left_nav li a').click(function(){
                    if(!jQuery(this).parent().hasClass("active")){
                        
                        jQuery(this).parent().siblings('li').removeClass('active').find('>ul').slideUp('slow').find('li').removeClass('active');
                        jQuery(this).parent().addClass('active').find('>ul').slideDown('slow');
                    }else{
                           
                        jQuery(this).parent().removeClass('active').find('>ul').slideUp('slow').find('li').removeClass('active');
                    }
                });
            }

        }
        
        jQuery(window).resize(function(){
            left_menu_js();
        });
        left_menu_js();

