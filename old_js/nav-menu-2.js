
var left_side_width = 250; //Sidebar width in pixels

$(function() {
    'use strict';

    //Enable sidebar toggle
    $("[data-toggle='offcanvas']").click(function(e) {
        e.preventDefault();

        //If window is small enough, enable sidebar push menu
        if ($(window).width() <= 992) {
            $('.row-offcanvas').toggleClass('active');
            $('.left-side').removeClass("collapse-left");
            $(".right-side").removeClass("strech");
            $('.row-offcanvas').toggleClass("relative");
        } else {
            //Else, enable content streching
            if ($('.left-side').hasClass('collapse-left')) {
                $('.left-side').toggleClass("collapse-left");
                $(".right-side").toggleClass("strech").animate({'margin-left':'250px'});
            } else {
                $('.left-side').toggleClass("collapse-left");
                $(".right-side").toggleClass("strech").animate({'margin-left':'0px'});
            }
        }
    });

    /* 
     * Make sure that the sidebar is streched full height
     * ---------------------------------------------
     * We are gonna assign a min-height value every time the
     * wrapper gets resized and upon page load. We will use
     * Ben Alman's method for detecting the resize event.
     * 
     **/
    function _fix() {
        //Get window height and the wrapper height
        var height = $(window).height() - $("body > .header").height();
        $(".wrapper").css("min-height", height + "px");
        var content = $(".wrapper").height();
        //If the wrapper height is greater than the window
        if (content > height)
            //then set sidebar height to the wrapper
            $(".left-side, html, body").css("min-height", content + "px");
        else {
            //Otherwise, set the sidebar to the height of the window
            $(".left-side, html, body").css("min-height", height + "px");
        }
    }
    //Fire upon load
    _fix();
    //Fire when wrapper is resized
    $(".wrapper").resize(function() {
        _fix();
        fix_sidebar();
    });

    //Fix the fixed layout sidebar scroll bug
    fix_sidebar();

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

function fix_sidebar() {
    //Make sure the body tag has the .fixed class
    if (!$("body").hasClass("fixed")) {
        return;
    }

    //Add slimscroll
    $(".sidebar").slimscroll({
        height: ($(window).height() - $(".header").height()) + "px",
        color: "rgba(0,0,0,0.2)"
    });
}
function change_layout() {
    $("body").toggleClass("fixed");
    fix_sidebar();
}

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
        // Hacks below keep style the same even though we're hiding li elements
        $('.' + menu_category).filter(':first').css('border-top', '1px solid #dbdbdb');
        $('.' + menu_category + ' a').filter(':first').css('border-top', '1px solid #fff');
    });
    $('#category-select label.btn').click(function (e) {
        menu_category = $('input[name=options]:checked', '#category-select').attr('id');
        // If user clicked on button that was already selected, toggle the sliders
        if (menu_category == $(this).children('input[type=\'radio\']:first').attr('id')) {
            if ($('.sidebar-menu').hasClass('all-active')) {
                var menu = $('.treeview-menu');
                menu.slideUp();
                $('.sidebar-menu').removeClass('all-active');
                $('.' + menu_category).removeClass('active');
            } else {
                var menu = $('.treeview-menu');
                menu.slideDown();
                $('.sidebar-menu').addClass('all-active');
            }
        }
    });
});
