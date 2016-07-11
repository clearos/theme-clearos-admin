/**
 * Menu type 1 helper.
 *
 * @category  Theme
 * @package   ClearOS
 * @author    ClearFoundation <developer@clearfoundation.com>
 * @copyright 2014-2016 ClearFoundation
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
            jQuery(".theme-menu-1").html("<ul class='left_nav'>"+left_nav+"</ul>");
        }
    }
    function left_menu_js(){
        if (jQuery(window).width() < 801) {
            var left_nav = jQuery(".left_nav").html();
            if (jQuery(".small_menu").length > 0){
                jQuery(".left_nav").remove();
                jQuery(".small_menu").append("<ul class='left_nav'>"+left_nav+"</ul>");
            }
            jQuery('.left_nav li.active').find('>ul').slideDown('fast').addClass('active');
            if (jQuery(".theme-wizard-active").length != 0)
                return;
            jQuery('.left_nav li a.nav-toggle').click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                if(!jQuery(this).parent().hasClass("active")) {
                    $this = jQuery(this);
                    $this.parent().find('li').removeClass('active');
                    $this.parent().find('>ul').slideDown('fast').addClass('active');
                    $this.parent().addClass('active');
                } else {
                    $this = jQuery(this);
                    $this.parent().find('>ul').slideUp('fast').find('li').removeClass('active');
                    $this.parent().removeClass('active');
                }
            });
        } else {
            var left_nav = jQuery(".left_nav").html();
            jQuery(".left_nav").remove();
            if (jQuery(".sidebar-form").length >0){
                jQuery(".theme-menu-1").html("<ul class='left_nav'>"+left_nav+"</ul>");
            } else {
                jQuery('.main-content > aside').append("<ul class='left_nav'>"+left_nav+"</ul>");
            }
            jQuery('.left_nav li.active').find('>ul').slideDown('fast').addClass('active');
            if (jQuery(".theme-wizard-active").length != 0)
                return;
            jQuery('.left_nav li a.nav-toggle').click(function(e){
                e.preventDefault();
                e.stopPropagation();
                if (!jQuery(this).parent().hasClass("active")) {
                    $this = jQuery(this);
                    $this.parent().find('li').removeClass('active');
                    $this.parent().find('>ul').slideDown('fast').addClass('active');
                    $this.parent().addClass('active');
                } else {
                    $this = jQuery(this);
                    $this.parent().find('>ul').slideUp('fast').find('li').removeClass('active');
                    $this.parent().removeClass('active');
                }
            });
        }

    }
    
    left_menu_js();

    var asidewidth = jQuery(".marketPlaceSection aside").width();
    jQuery(".left_nav").css('width', asidewidth);
    
    jQuery(".navbar-toggle").click(function(){
        jQuery(".small_menu").slideToggle();
    });
});

