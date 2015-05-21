/**
 * Menu type 2 javascript helper.
 *
 * @category  Theme
 * @package   ClearOS
 * @author    ClearFoundation <developer@clearfoundation.com>
 * @copyright 2014 ClearFoundation
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link      http://www.clearfoundation.com/docs/developer/theming/
 */

$(document).ready(function() {

    //jQuery(".navbar-toggle").hide();
    if (jQuery(window).width() < 801) {
        jQuery(".theme-menu-2 > div.sidebar form.sidebar-form").remove();
        var category = {
            'cloud': '',
            'network': '',
            'gateway': '',
            'server': '',
            'system': '',
            'report': '' 
        };
        jQuery.each($(".sidebar-menu-2 > li.category-cloud"), function(index, obj) {
            category.cloud += jQuery(obj).html();
        });
        jQuery.each($(".sidebar-menu-2 > li.category-network"), function(index, obj) {
            category.network += jQuery(obj).html();
        });
        jQuery.each($(".sidebar-menu-2 > li.category-gateway"), function(index, obj) {
            category.gateway += jQuery(obj).html();
        });
        jQuery.each($(".sidebar-menu-2 > li.category-server"), function(index, obj) {
            category.server += jQuery(obj).html();
        });
        jQuery.each($(".sidebar-menu-2 > li.category-system"), function(index, obj) {
            category.system += jQuery(obj).html();
        });
        jQuery.each($(".sidebar-menu-2 > li.category-report"), function(index, obj) {
            category.report += jQuery(obj).html();
        });
        jQuery(".sidebar-menu-2").remove();
        jQuery(".theme-menu-2").addClass('theme-menu-2-mobile');
        jQuery(".small_menu").addClass('sidebar-menu-2');
        var menu = "<ul class='left_nav'>";
        jQuery.each(category, function(index, item) {
            menu += "<li class='menu-2-category'><a href='#'>" + jQuery('.theme-menu-2-category.category-' + index).attr('title') + "</a><ul class='menu-2-sub-category'>"+item+"</ul></li>";
        });
        menu += "</ul>";
        jQuery('.small_menu').append(menu);
        //jQuery(".small_menu").append("<ul class='left_nav'>"+left_nav+"</ul>");
        jQuery('li.menu-2-category > a').on('click', function (e) {
            e.preventDefault();
            //jQuery(this).next().toggleClass('active');
            jQuery(this).next().slideToggle();
        });
        jQuery('ul.menu-2-sub-category > a').on('click', function (e) {
            e.preventDefault();
            //jQuery(this).next().toggleClass('active');
            jQuery(this).next().slideToggle();
        });
        //jQuery('.menu-2-sub-category > a > i').remove();
        jQuery(".theme-menu-2-list").remove();
    }
    if (jQuery(".theme-wizard-active").length == 0) {
        var menu_category = $('input[name=options]:checked', '#category-select').attr('id');
        // Hacks below keep style the same even though we're hiding li elements
        $('li.' + menu_category).filter(':first').css('border-top', '1px solid #dbdbdb');
        $('.' + menu_category + ' a').filter(':first').css('border-top', '1px solid #fff');
        $('.category').hide();
        $('.' + menu_category).show();
        $('#' + menu_category).parent().addClass('active');

        $('#category-select label.btn').on('click', function (e) {
            menu_category = $(this).find('input[name=options]:first').attr('id');
            // Hacks below keep style the same even though we're hiding li elements
            $('li.' + menu_category).filter(':first').css('border-top', '1px solid #dbdbdb');
            $('.' + menu_category + ' a').filter(':first').css('border-top', '1px solid #fff');
            $('.category').hide();
            $('.' + menu_category).show();
            if ($(this).find('input[name=options]:first').attr('checked')) {
                if ($('.sidebar-menu-2').find('li.category.' + menu_category + '.active').length > 0)
                    $('.' + menu_category).removeClass('active');
                else
                    $('.' + menu_category).addClass('active');
            }
            $('#category-select').find('input[name=options]').attr('checked', false);
            $(this).find('input[name=options]:first').attr('checked', true);
            $('.left-side').find('div#menu-no-access').remove();
            if ($('.' + menu_category).length == 0) {
                var options = {
                    id: 'menu-no-access'
                };
                $('.sidebar').after(theme_infobox('info', lang_menu_no_access, '', options));
            }
        });

        $('li.category > a').on('click', function (e) {
            e.preventDefault();
            $(this).parent().toggleClass('active');
        });

        /*
            Left sidebar End
        */
        jQuery(".navbar-toggle").click(function(){
            jQuery(".small_menu").slideToggle();
        });
    }
});
