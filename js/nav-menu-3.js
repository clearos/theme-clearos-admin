/**
 * Menu type 3 javascript helper.
 *
 * @category  Theme
 * @package   ClearOS
 * @author    ClearFoundation <developer@clearfoundation.com>
 * @copyright 2014 ClearFoundation
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link      http://www.clearfoundation.com/docs/developer/theming/
 */

$(document).ready(function() {

    $(".theme-menu-3.navbar").on("height", "calc(" + $("body").css("height") + ")"),
    $(".theme-nav-3 .dropdown>a").on("click", function(a) {
        a.stopPropagation(),
        $(this).find('i').toggleClass("down"); 
        $(this).parent("li.dropdown.open").length > 0 
        ? $(this).parent("li.dropdown").removeClass("open")
        : $(this).parents("li.dropdown").addClass("open"),
        $(this).parent("li.dropdown").find("li.dropdown").removeClass("open")
        a.preventDefault();
    });
    $("a.theme-menu-3-link").on("click", function(a) {
        a.stopPropagation();
    });
    if (jQuery(".theme-wizard-active").length == 0) {
        if (jQuery(window).width() < 801) {
            var left_nav = jQuery(".theme-nav-3").parent().html();
            jQuery(".theme-menu-3").remove();
            jQuery(".small_menu").append(left_nav);
            jQuery(".menu-description > i").removeClass('down');

            // Yuck...dom change loses this event
            $(".theme-nav-3 .dropdown>a").on("click", function(a) {
                $(this).find('i').toggleClass("down"); 
                a.stopPropagation(),
                $(this).parent("li.dropdown.open").length > 0 
                ? $(this).parent("li.dropdown").removeClass("open")
                : $(this).parents("li.dropdown").addClass("open"),
                $(this).parent("li.dropdown").find("li.dropdown").removeClass("open")
                a.preventDefault();
            });
            $("a.theme-menu-3-link").on("click", function(a) {
                a.stopPropagation();
            });

        }
    }
    jQuery(".navbar-toggle").click(function(){
        jQuery(".small_menu").slideToggle();
    });

});
    
