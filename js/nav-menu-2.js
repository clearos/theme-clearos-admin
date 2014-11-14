/*!
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 * This file should be included in all pages
 * !**/

/**
 * Marketplace javascript helper.
 *
 * @category  Theme
 * @package   ClearOS
 * @author    ClearFoundation <developer@clearfoundation.com>
 * @copyright 2014 ClearFoundation
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link      http://www.clearfoundation.com/docs/developer/theming/
 */

$(function() {
    'use strict';

    $.fn.navmenu = function() {

        return this.each(function() {
            var btn = $(this).children("a").first();
            var menu = $(this).children(".treeview-menu").first();
            var isActive = $(this).hasClass('active');

            //initialize already active menus
            if (isActive) {
                menu.show();
            }
            //Slide open or close the menu on link click
            btn.click(function(e) {
                e.preventDefault();
                if (isActive) {
                    //Slide up to close menu
                    menu.slideUp();
                    isActive = false;
                    btn.parent("li").removeClass("active");
                } else {
                    //Slide down to open menu
                    menu.slideDown();
                    isActive = true;
                    btn.parent("li").addClass("active");
                }
            });

        });

    };

}(jQuery));

$(document).ready(function() {

    var menu_category = $('input[name=options]:checked', '#category-select').attr('id');
    // Hacks below keep style the same even though we're hiding li elements
    $('.' + menu_category).filter(':first').css('border-top', '1px solid #dbdbdb');
    $('.' + menu_category + ' a').filter(':first').css('border-top', '1px solid #fff');
    $('.' + menu_category).show();
    $('#' + menu_category).parent().addClass('active');
    $(".sidebar .treeview").navmenu();
    $('#category-select input:radio').change(function (e) {
        menu_category = $('input[name=options]:checked', '#category-select').attr('id');
        $('.treeview').hide();
        $('.' + menu_category).removeClass('active');
        $('.' + menu_category).show();
        $(".sidebar .treeview").navmenu();
    });

    $('#category-select label.btn').on('click', function (e) {
        menu_category = $('input[name=options]:checked', '#category-select').attr('id');
        // Hacks below keep style the same even though we're hiding li elements
        $('.' + menu_category).filter(':first').css('border-top', '1px solid #dbdbdb');
        $('.' + menu_category + ' a').filter(':first').css('border-top', '1px solid #fff');
        // If user clicked on button that was already selected, toggle the sliders
        if (menu_category == $(this).children('input[type=\'radio\']:first').attr('id')) {
            if ($('.sidebar-menu-2').hasClass('all-active')) {
                var menu = $('.treeview-menu');
                menu.slideUp();
                $('.sidebar-menu-2').removeClass('all-active');
                $('.' + menu_category).removeClass('active');
            } else {
                var menu = $('.treeview-menu');
                menu.slideDown();
                $('.sidebar-menu-2').addClass('all-active');
            }
        }
    });
});
