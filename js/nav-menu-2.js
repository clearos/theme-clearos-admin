/**
 * Menu javascript helper.
 *
 * @category  Theme
 * @package   ClearOS
 * @author    ClearFoundation <developer@clearfoundation.com>
 * @copyright 2014 ClearFoundation
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link      http://www.clearfoundation.com/docs/developer/theming/
 */

$(document).ready(function() {

    var menu_category = $('input[name=options]:checked', '#category-select').attr('id');
    // Hacks below keep style the same even though we're hiding li elements
    $('.' + menu_category).filter(':first').css('border-top', '1px solid #dbdbdb');
    $('.' + menu_category + ' a').filter(':first').css('border-top', '1px solid #fff');
    $('.category').hide();
    $('.' + menu_category).show();
    $('#' + menu_category).parent().addClass('active');

    $('#category-select label.btn').on('click', function (e) {
        menu_category = $(this).find('input[name=options]:first').attr('id');
        // Hacks below keep style the same even though we're hiding li elements
        $('.' + menu_category).filter(':first').css('border-top', '1px solid #dbdbdb');
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
    });

    $('li.category > a').on('click', function (e) {
        e.preventDefault();
        $(this).parent().toggleClass('active');
    });
});
