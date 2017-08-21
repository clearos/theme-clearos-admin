/**
 * Marketplace javascript helper.
 *
 * @category  Theme
 * @package   ClearOS
 * @author    ClearFoundation <developer@clearfoundation.com>
 * @copyright 2014-2015 ClearFoundation
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link      http://www.clearfoundation.com/docs/developer/theming/
 */

// TODO: document
$.ajaxSetup({ cache: false });

// Globals
var auth_options = new Object();
var sdn_org = '';
var internet_connection = false;
var lang = new Object();
var my_location = _get_location_info();

// Document ready handler
$(document).ready(function() {
    $(".my-colorpicker").colorpicker();
    $('body').tooltip({
      html: true,
      selector: '[data-toggle=tooltip]'
    });
    handle_marketplace_on_page_ready();
    if (typeof(Storage) !== 'undefined') {
        if (localStorage.getItem("rhs-" + my_location.basename) != undefined && localStorage.getItem("rhs-" + my_location.basename) == 'off')
            theme_hide_rhs(true);
    }
    // Do not show toggle if dashboard type page.
    if ($('#theme-layout-content').length == 0)
        $('#rhs-widget-toggle').hide();
});

// Listens RHS toggle
$(document).on('click', '#rhs-widget-toggle', function(e) {
    e.preventDefault();
    theme_hide_rhs($('#theme-layout-content').hasClass('col-md-8'));
});
// Listens for app rating click
$(document).on('click', '.sidebar-review-app', function(e) {
    e.preventDefault();
    add_review();
});
// Listens for app status refresh
$(document).on('click', '.app_refresh_status', function(e) {
    e.preventDefault();
    // Remove any row entries that were added dynamically
    $(".theme-rhs-dynamic").remove();
    var options = {id: 'clearos-rhs-update', center: true, classes: 'theme-biggest-text'};
    // Add spinner feedback
    $('#sidebar_additional_info_row').after(clearos_loading(options));
    // Force update
    get_marketplace_data(my_location.basename, 1);
});

function theme_hide_rhs(hidden) {
    if (hidden) {
        $('#theme-layout-rhs').hide('slide', {direction: 'right'}, 500, function() {
            $('#theme-layout-content').removeClass('col-md-8');
            $('#theme-layout-content').addClass('col-md-12');
            $('#rhs-widget-toggle > i').removeClass('fa-toggle-on');
            $('#rhs-widget-toggle > i').addClass('fa-toggle-off');
            if (typeof(Storage) !== 'undefined')
                localStorage.setItem('rhs-' + my_location.basename, 'off');
        });
    } else {
        $('#theme-layout-content').removeClass('col-md-12');
        $('#theme-layout-content').addClass('col-md-8');
        $('#rhs-widget-toggle > i').removeClass('fa-toggle-off');
        $('#rhs-widget-toggle > i').addClass('fa-toggle-on');
        $('#theme-layout-rhs').show('slide', {direction: 'right'}, 500);
        if (typeof(Storage) !== 'undefined')
            localStorage.setItem('rhs-' + my_location.basename, 'on');
    }
}

function theme_sdn_account_setup(landing_url, username, device_id) {

    return '\
        <div id="sdn-account-setup-dialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"> \
          <div class="modal-dialog"> \
            <div class="modal-content"> \
              <div class="modal-header"> \
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> \
                <h4>' + lang_marketplace_sdn_account_setup + '</h4> \
              </div> \
              <div class="modal-body"> \
                <div id="sdn_marketplace_setup_dialog" title="lang_marketplace_sdn_account_setup">\
                   <p>\
                   ' + lang_marketplace_sdn_account_setup_help_1 + '\
                   </p>\
                   <p>\
                   ' + lang_marketplace_sdn_account_setup_help_2 + '\
                   </p>\
                </div>\
              </div>\
              <div class="modal-footer">\
                <div class="btn-group">\
                  <a href="' + landing_url + '?username=' + username + '&device_id=' + device_id + '" target="_blank" class="btn btn-primary theme-anchor-edit">' + lang_marketplace_setup_payment_on_clear + '<i class="fa fa-external-link theme-text-icon-spacing"></i></a>\
                  <a href="#" id="account-setup-cancel" class="btn btn-link theme-anchor-cancel">' + lang_cancel + '</a>\
                </div>\
              </div>\
            </div>\
          </div>\
        </div>\
        <script type="text/javascript">\
            $("#account-setup-cancel").click(function (e) {\
                e.preventDefault();\
                $("#sdn-account-setup-dialog").modal("hide");\
            });\
            $("#sdn-account-setup-dialog").on("hidden.bs.modal", function () {\
                window.location = "/app/marketplace";\
            });\
        </script>\
    ';
}

function theme_app(type, list, options)
{
    if (list.length == 0) {
        none_found = clearos_infobox_info(lang_marketplace_search_marketplace, lang_marketplace_search_no_results);
        if (options.container)
            $('#' + options.container).append(none_found);
        else
            $('#marketplace-app-container').append(none_found);
        return;
    }
    for (index = 0 ; index < list.length; index++) {
        app = list[index];

        if (type == 'tile')
            html = _get_app_tile(app, options);
        else
            html = _get_app_full(app, options);

        if (options.optional_apps)
            $('#optional-apps').append(html);
        else if (options.container)
            $('#' + options.container).append(html);
        else
            $('#marketplace-app-container').append(html);
    }

    $('#marketplace-app-container').append('\
        <div class="clearfix"></div>\
        <script type="text/javascript">\
            $(".app-description").dotdotdot({\
                ellipsis: "..."\
            });\
        </script>\
    ');
}



function handle_marketplace_on_page_ready()
{
    var my_location = _get_location_info();

    get_marketplace_data(my_location.basename, 0);

    // Insert login dialog
    // TODO find a proper dom to hitch this to
    $('#clearos-body-container').append(' \
        <div id="sdn-login-dialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"> \
          <div class="modal-dialog"> \
            <div class="modal-content"> \
              <div class="modal-header"> \
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> \
                <h4>' + sdn_org + ' ' + lang_sdn_authentication_required + '</h4> \
              </div> \
              <div class="modal-body"> \
                <p>' + lang_sdn_authentication_required_help + '</p> \
                <form class="form-horizontal theme-form" role="form"> \
                  <div class="form-group"><label class="col-md-4 control-label" for="sdn_usernme">' + lang_username + '</label> \
                    <div class="col-md-8"><select id="sdn_username" class="form-control"></select></div> \
                  </div> \
                  <div id="sdn_password_group" class="form-group"> \
                    <label class="col-md-4 control-label" for="sdn_password">' + lang_password + '</label> \
                    <div class="col-md-8"> \
                      <input id="sdn_password" type="password" name="password" value="" class="form-control" /> \
                      <a href="#" id="sdn_forgot_password" class="btn btn-link">' + lang_forgot_password + '</a> \
                    </div> \
                  </div> \
                  <div id="sdn_lost_password_group" class="form-group theme-hidden"> \
                    <label class="col-md-4 control-label" for="sdn_password">' + lang_sdn_email + '</label> \
                    <div class="col-md-8"> \
                      <input id="sdn_email" type="text" name="sdn_email" value="" class="form-control autofocus" /> \
                    </div> \
                  </div> \
                  <div id="sdn-login-dialog-message-bar"></div> \
                </form> \
              </div> \
              <div class="modal-footer"> \
                <div class="btn-group"> \
                  <a href="#" id="sdn_login_action" class="btn btn-primary theme-anchor-edit">' + lang_login + '</a> \
                  <a id="sdn_login_cancel" href="#" class="btn btn-link theme-anchor-cancel">' + lang_cancel + '</a> \
                </div> \
              </div> \
            </div> \
          </div> \
        </div> \
    ');

    $('#sdn_login_action').on('click', function () {
        auth_options.action_type = 'login';

        if ($('#sdn_lost_password_group').is(':visible'))
            auth_options.action_type = 'lost_password';
        clearos_is_authenticated();
    });

    $('#sdn_login_cancel').on('click', function (e) {
        auth_options.use_full_path_on_redirect = null;
        $('#sdn-login-dialog').modal('hide');
    });

    $('#sdn_forgot_password').click(function (e) {
        e.preventDefault();
        $('#sdn-login-dialog-message-bar').html('');
        $('#sdn_password_group').hide();
        $('#sdn_lost_password_group').show();
        $('.autofocus').focus();
        $('#sdn_login_action').text($('#sdn_login_action').text() == lang_login ? lang_reset_password_and_send : lang_login);
    });

    $('input#sdn_password').keyup(function(event) {
        if (event.keyCode == 13) {
            auth_options.action_type = 'login';
            clearos_is_authenticated();
        }
    });

    $('input#sdn_email').keyup(function(event) {
        if (event.keyCode == 13) {
            auth_options.action_type = 'lost_password';
            clearos_is_authenticated();
        }
    });
}

function theme_rating_review(basename, id, title, comment, rating, pseudonym, timestamp, agree, disagree) {
    return '\
        <div class="theme-review">\
          <div>\
            <div class="theme-review-reviewer">' + pseudonym + '</div>\
            <div class="theme-review-rating">' + theme_star_rating(rating) + '</div>\
          </div>\
          <div class="clearfix"></div>\
          <div>\
            <div class="theme-review-title">\
                <div class="theme-review-title-highlight">' + title + '</div>' + (comment != null ? comment.substr(title.length) : '') + '\
            </div>\
            <div class="theme-review-mod agree">\
                <a href="#" id="' + basename + '-' + id + '-up" class="btn btn-xs btn-primary review-action">\
                    <span id="agree_' + id + '">' + agree + '</span> <i class="fa fa-thumbs-up"></i>\
                </a>\
            </div>\
            <div class="theme-review-mod disagree">\
                <a href="#" id="' + basename + '-' + id + '-dn" class="btn btn-xs btn-primary review-action">\
                    <span id="disagree_' + id + '">' + disagree + '</span> <i class="fa fa-thumbs-down"></i>\
                </a>\
            </div>\
          </div>\
          <div class="clearfix"></div>\
        </div>\
    ';
}


function theme_star_rating(stars) {
    var html = '';
    for (var index = 1; index <= 5; index++)
        html += '<i class=\'app-rating-action theme-star fa fa-star' + (stars >= index ? ' on' : '') + '\'></i>';

    return html;
}

function theme_price(UNIT, price) {
    var html = lang_marketplace_free;
    var add_class = '';
    if (price.unit_price > 0) {
        if (price.exempt)
            add_class = 'marketplace-app-no-pay-required';
        html = '<span class="' + add_class + '">' + price.currency + price.unit_price + ' ' + UNIT[price.unit] + '</span>';
    }

    return html;
}

function get_marketplace_data(basename, realtime) {

    // We append this object in case we need to redraw RHS widget and remove these elements
    var options = {row_class: 'theme-rhs-dynamic'};
    $.ajax({
        url: '/app/marketplace/ajax/get_app_details/' + basename + '/' + realtime,
        method: 'GET',
        dataType: 'json',
        success : function(json) {
            if (json.code != undefined && json.code != 0) {
                $('#sidebar_additional_info_row').show(200);
                if (json.code < 0) {
                    // Could put real message for codes < 0, but it gets a bit technical
                    $('#sidebar_additional_info').html('<span class=\"theme-text-bad-status\">' + lang_marketplace_connection_failure + '</span>');
                } else {
                    if (json.code == 3)
                        $('#sidebar_additional_info').html('<a href=\'/app/registration/register\' class=\'theme-text-bad-status\'>' + json.errmsg + '</a>');
                    else
                        $('#sidebar_additional_info').html('<span class=\"theme-text-bad-status\">' + json.errmsg + '</span>');
                }
                return;
            } else {
                // Add title to review form
                $('#review-app-name').html(json.name);
                // We add rows in the reverse order to keep this section under the Version/Vendor

                // Evaluation
                if (json.license_info != undefined && json.license_info.expired == true) {
                    $('#sidebar_additional_info_row').after(
                        _sidebar_pair(
                            lang_status +
                            '<a href=\'#\' class=\'app_refresh_status\'><i class=\'fa fa-refresh theme-text-icon-spacing\'></i></a>',
                            '<span class=\'theme-text-alert\' id=\'app_refresh_status_value\'>' +
                            (json.license_info.evaluation ? lang_marketplace_trial_ended : lang_marketplace_subscription_expired) +
                            '</span>',
                            options
                        )
                        +
                        _sidebar_pair(
                            lang_marketplace_activate,
                            '<a id=\'eval-limit-anchor\' href=\'' + json.license_info.sdn_url_buy + '\' target=\'_blank\'>' +
                            lang_marketplace_purchase + '<i class=\'fa fa-external-link theme-text-icon-spacing\'></i></a>',
                            options
                        )
                    );
                } else if (json.license_info != undefined && json.license_info.evaluation != undefined && json.license_info.evaluation == true) {
                    if (json.license_info.eval_limitations != undefined) {
                        $('#sidebar_additional_info_row').after(
                            _sidebar_pair(
                                lang_marketplace_eval_limitations,
                                '<a id=\'eval-limit-anchor\' data-toggle=\'tooltip\' data-container=\'body\' href=\'javascript: void(0)\' title=\'' + json.license_info.eval_limitations + '\'>' + lang_yes + '</a>',
                                options
                            )
                        );
                    }
                    $('#sidebar_additional_info_row').after(
                        _sidebar_pair(
                            lang_marketplace_trial_ends,
                            $.datepicker.formatDate('M d, yy', new Date(json.license_info.expire)),
                            options
                        )
                    );
                    $('#sidebar_additional_info_row').after(
                        _sidebar_pair(
                            lang_status,
                            '<span class=\'theme-text-alert\'>' + lang_marketplace_evaluation + '</span>',
                            options
                        )
                    );
                } else {
                    // Redemption period
                    if (json.license_info != undefined && json.license_info.redemption != undefined && json.license_info.redemption == true) {
                        $('#sidebar_additional_info_row').after(
                            _sidebar_pair(
                                lang_status,
                                '<span class=\'theme-text-alert\'>' + lang_marketplace_redemption + '</span>',
                                options
                            )
                        );
                    }

                    // No Subscription
                    if (json.license_info != undefined && json.license_info.no_subscription != undefined && json.license_info.no_subscription == true) {
                        $('#sidebar_additional_info_row').after(
                            _sidebar_pair(
                                lang_status,
                                '<span class=\'theme-text-alert\'>' + lang_marketplace_expired_no_subscription + '</span>',
                                options
                            )
                        );
                    }

                    // Subscription?  A unit of 100 or greater represents a recurring subscription
                    if (json.license_info != undefined && json.license_info.unit >= 100) {
                        var bill_cycle = lang_marketplace_billing_cycle_monthly;
                        if (json.license_info.unit == 1000)
                            bill_cycle = lang_marketplace_billing_cycle_yearly;
                        else if (json.license_info.unit == 2000)
                            bill_cycle = lang_marketplace_billing_cycle_2_years;
                        else if (json.license_info.unit == 3000)
                            bill_cycle = lang_marketplace_billing_cycle_3_years;
                        else if (json.license_info.unit == 4000)
                            bill_cycle = lang_marketplace_billing_cycle_4_years;
                        else if (json.license_info.unit == 5000)
                            bill_cycle = lang_marketplace_billing_cycle_5_years;

                        $('#sidebar_additional_info_row').after(
                            _sidebar_pair(
                                lang_marketplace_billing_cycle,
                                bill_cycle,
                                options
                            )
                        );
                        if (json.license_info.expire != undefined) {
                            $('#sidebar_additional_info_row').after(
                                _sidebar_pair(
                                    lang_marketplace_renewal_date,
                                    $.datepicker.formatDate('M d, yy', new Date(json.license_info.expire)),
                                    options
                                )
                            );
                        }
                    }
                }

                // Support Policy
                if (json.supported != undefined && !json.hide_support_policy) {
                    // TODO - there are some clearcenter references here
                    $('#sidebar_additional_info_row').after(
                        _sidebar_pair(
                            lang_marketplace_support_policy,
                            get_support_policy(json),
                            options
                        )
                    );
                }

                // Version updates
                if (!json.up2date) {
                    $('#sidebar_additional_info_row').after(
                        _sidebar_pair(
                            lang_marketplace_upgrade,
                            json.latest_version,
                            options
                        )
                    );
                }
            }
            if (json.complementary_apps != undefined && json.complementary_apps.length > 0 && !json.hide_recommended_apps) {
                comp_apps = '<h3 class=\'box-title\'>' + lang_marketplace_recommended_apps + '</h3>' +
                    '<div>' + lang_marketplace_sidebar_recommended_apps.replace('APP_NAME', '<b>' + json.name + '</b>') + ':</div>';
                for (index = 0 ; index < json.complementary_apps.length; index++) {
                    comp_apps += '<div class=\'row\'>';
                    comp_apps += '  <div class=\'col-lg-8\'>';
                    comp_apps += '    <a href=\'/app/marketplace/view/' + json.complementary_apps[index].basename + '\'>';
                    comp_apps += json.complementary_apps[index].name;
                    comp_apps += '    </a>';
                    comp_apps += '  </div>\n';
                    comp_apps += '  <div class=\'col-lg-4\'>';
                    comp_apps += theme_star_rating(Math.round(json.complementary_apps[index].rating));
                    comp_apps += '  </div>';
                    comp_apps += '</div>';
                }
                $('#sidebar-recommended-apps').html(comp_apps);
            }
            // Remove any whirly that may have been added to indicate dynamic status update
            $("#clearos-rhs-update").remove();
        },
        error: function (xhr, text_status, error_thrown) {
            // No connection to Internet...let's bail
            $('#sidebar_additional_info').html('<a href=\'/app/network\' class=\'highlight-link\'>' + lang_internet_down + '</a>');
            $('#sidebar_additional_info_row').show(200);
        }
    });
}

/**
 * Returns app logos via ajax.
 *
 */

function get_app_logos(basenames) {
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: '/app/marketplace/ajax/get_app_logos',
        success: function(data) {
            // Success..pass data to theme to update HTML.
            if (data.code == 0) {
                $.each(basenames, function(index, basename) {
                    if (data.list[basename] != undefined) {
                        $('#app-logo-' + basename).html($.base64.decode(data.list[basename].base64));
                    } else {
                        get_app_logo(basename, 'app-logo-' + basename);
                    }
                });
                return;
            }
        },
        error: function(xhr, text, err) {
            get_app_logo(basename, 'app-logo-' + basename);
            return;
        }
    });
}

// FIXME: create generic theme widget

function get_support_policy(json) {
    return '<a href=\'#\' data-toggle=\'modal\' data-target=\'#support-legend\'>' +
        '<i class=\'fa fa-circle theme-support theme-support-' + (json.supported & 1) + '\'></i>' +
        '<i class=\'fa fa-circle theme-support theme-support-' + (json.supported & 2) + '\'></i>' +
        '<i class=\'fa fa-circle theme-support theme-support-' + (json.supported & 4) + '\'></i>' +
        '<i class=\'fa fa-circle theme-support theme-support-' + (json.supported & 8) + '\'></i>' +
        '<i class=\'fa fa-circle theme-support theme-support-' + (json.supported & 16) + '\'></i>' +
        '</a>' +
        '<div id=\'support-legend\' class=\'modal fade\' tabindex=\'-1\' role=\'dialog\' aria-labelledby=\'basicModal\' aria-hidden=\'true\'>' +
        '<div class=\'modal-dialog\'>' +
        '<div class=\'modal-content\'>' +
        '<div class=\'modal-header\'>' +
        '<button type=\'button\' class=\'close\' data-dismiss=\'modal\' aria-hidden=\'true\'>&times;</button>' +
        '<h2>' + lang_marketplace_support_legend + '</h2>' +
        '</div>' +
        '<div class=\'modal-body\'>' +
        '<div class=\'theme-support-type\'><h4><i class=\'fa fa-circle theme-support theme-support-1\' style=\'margin-right: 5px;\'></i>' +
        lang_marketplace_support_1_title + '</h4></div>' +
        '<p>' +
        lang_marketplace_support_1_description +
        '</p>' +
        '<div class=\'theme-support-type\'><h4><i class=\'fa fa-circle theme-support theme-support-2\' style=\'margin-right: 5px;\'></i>' +
        lang_marketplace_support_2_title + '</h4></div>' +
        '<p>' +
        lang_marketplace_support_2_description +
        '</p>' +
        '<div class=\'theme-support-type\'><h4><i class=\'fa fa-circle theme-support theme-support-4\' style=\'margin-right: 5px;\'></i>' +
        lang_marketplace_support_4_title + '</h4></div>' +
        '<p>' +
        lang_marketplace_support_4_description +
        '</p>' +
        '<div class=\'theme-support-type\'><h4><i class=\'fa fa-circle theme-support theme-support-8\' style=\'margin-right: 5px;\'></i>' +
        lang_marketplace_support_8_title + '</h4></div>' +
        '<p>' +
        lang_marketplace_support_8_description +
        '</p>' +
        '<div class=\'theme-support-type\'><h4><i class=\'fa fa-circle theme-support theme-support-16\' style=\'margin-right: 5px;\'></i>' +
        lang_marketplace_support_16_title + '</h4></div>' +
        '<p>' +
        lang_marketplace_support_16_description +
        '</p>' +
        '<div class=\'modal-footer\'>' +
        '<a href=\'http://www.clearcenter.com/clearcare/landing\' target=\'_blank\'>' + lang_marketplace_learn_more + '...</a>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';
}

function get_placeholder(type) {
    if (type == 'svg')
        return '\
        <svg version="1.1" class="clearos-svg clearfoundation placeholder" viewBox="0 0 400 400" preserveAspectRatio="xMinYMin" xmlns="http://www.w3.org/2000/svg" xmlns:xlink= "http://www.w3.org/1999/xlink">\
        <path id="path28" fill="#AA0707" d="M91.666,184.647"/>\
        <path id="path30" fill="#AA0707" d="M123.245,247.805"/>\
        <path id="path32" fill="#AA0707" d="M91.666,184.647"/>\
        <path id="path34" fill="#AA0707" d="M123.245,247.805"/>\
        <path fill="#686868" d="M384.452,221.512l-90.501-43.57l0.161-129.3l-0.9,0.426l0.933-0.463L202.21,4.345l-93.05,45.377l0.09,0.045\
            v127.799l-0.651-0.314l-93.051,45.377l0.09,0.045v128.777l91.02,44.054v0.15l92.905-44.202l91.016,44.052v0.15l93.681-44.572\
            l0.162-129.534l-0.9,0.426L384.452,221.512z M283.771,168.875l-73.001,35.203V102.652l73.001-35.207V168.875z M201.813,15.077\
            l69.611,33.261l-70.74,33.601l-67.692-32.782L201.813,15.077z M39.38,222.065l68.82-34.081l69.613,33.262l-70.741,33.601\
            L39.38,222.065z M190.158,341.782l-73,35.203V275.56l73-35.206V341.782z M223.301,222.065l68.821-34.081l69.612,33.262\
            l-70.741,33.601L223.301,222.065z M374.078,341.782l-73,35.203V275.56l73-35.206V341.782z"/>\
        </svg>\
    ';
}



function clearos_is_authenticated() {
    var my_location = _get_location_info();

    data_payload = 'ci_csrf_token=' + $.cookie('ci_csrf_token');
    if ($('#sdn_username').val() != undefined)
        data_payload += '&username=' + $('#sdn_username').val();
    $('#sdn-login-dialog-message-bar').html('');
    if (auth_options.action_type == 'login') {
        if ($('#sdn_password').val() == '') {
            $('#sdn-login-dialog-message-bar').html(theme_infobox('warning', lang_warning, lang_sdn_password_invalid));
            $('#sdn-login-dialog-message-bar').show(200);
            $('.autofocus').focus();
            return;
        } else {
            data_payload += '&password=' + $('#sdn_password').val();
        }
    } else if (auth_options.action_type == 'lost_password') {
        if ($('#sdn_email').val() == '') {
            $('#sdn-login-dialog-message-bar').html(theme_infobox('warning', lang_warning, lang_sdn_email_invalid));
            $('#sdn-login-dialog-message-bar').show(200);
            $('.autofocus').focus();
            return;
        } else {
            data_payload += '&email=' + $('#sdn_email').val();
        }
    }

    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: data_payload,
        url: '/app/marketplace/ajax/is_authenticated',
        success: function(data) {
            if (data.code == 0 && data.authorized) {
                // Might have pages where account is displayed (eg. Marketplace)
                $('#display_sdn_username').html(data.sdn_username);
                // Only case where authorized is true.
                clearos_modal_infobox_close('sdn-login-dialog');
                // If we're logged in and there is a 'check_sdn_edit' function defined on page, check to see if we need to get settings
                if (auth_options.callback)
                    window[auth_options.callback](auth_options.callback_args);
                if (window.check_sdn_edit)
                    check_sdn_edit();
                if (auth_options.action_type == 'login' && auth_options.reload_after_auth)
                    window.location.reload();
                return;
            } else if (data.code == 0 && !data.authorized) {

                // Open dialog
                clearos_modal_infobox_open('sdn-login-dialog');
                // If user closes modal box, redirect to non-edit mode
                $('#sdn-login-dialog').on('hidden.bs.modal', function() {
                    if (auth_options.no_redirect_on_cancel) {
                        return;
                    } else if (auth_options.use_full_path_on_redirect) {
                        window.location = my_location.fullpath;
                        return;
                    } else if (!my_location.default_controller && auth_options.use_full_path_on_redirect) {
                        return;
                    }
                    if (auth_options.action_type == 'login' && !auth_options.reload_after_auth)
                        return;
                    window.location = '/app/' + my_location.basename;
                });

                // If email was submitted...reset was a success...
                if (data.email != undefined) {
                    $('#sdn-login-dialog-message-bar').html(
                        theme_infobox('info', lang_success + '!', lang_sdn_password_reset + ': <span style=\'font-weight: bold\'>' + data.email + '</span>')
                    );
                    $('#sdn-login-dialog-message-bar').show(200);
                    $('#sdn_password_group').show();
                    $('#sdn_lost_password_group').hide();
                    $('.autofocus').focus();
                    $('#sdn_login_action').text(lang_login);
                    return;
                }
                
                // Marketplace 1.1 sends back array of admins
                $.each(data.sdn_admins, function(key, value) {   
                    $('#sdn_username')
                    .append($('<option>', { value : value })
                    .text(value)); 
                });

            } else if (data.code == 10) {
                // Code 10 is an invalid email
                $('#sdn-login-dialog-message-bar').html(theme_infobox('warning', lang_warning, lang_sdn_email_invalid));
                $('#sdn-login-dialog-message-bar').show(200);
            } else if (data.code == 11) {
                // Code 11 is an email mismatch for lost password
                $('#sdn-login-dialog-message-bar').html(theme_infobox('warning', lang_warning, lang_sdn_email_mismatch));
                $('#sdn-login-dialog-message-bar').show(200);
            } else if (data.code == 3 && auth_options.callback == 'display_review_form') {
                // Open dialog
                $('#sidebar_additional_info').fadeOut(300).fadeIn(300);
            } else if (data.code > 0) {
                $('#sdn-login-dialog-message-bar').html(theme_infobox('warning', lang_warning, lang_sdn_password_invalid));
                $('#sdn-login-dialog-message-bar').show(200);
            } else if (data.code < 0) {
                $('#sdn-login-dialog-message-bar').html(theme_infobox('warning', lang_warning, data.errmsg));
                $('#sdn-login-dialog-message-bar').show(200);
                return;
            }
            $('.autofocus').focus();
        },
        error: function(xhr, text, err) {
            // Don't display any errors if ajax request was aborted due to page redirect/reload
            if (xhr['abort'] == undefined)
                theme_clearos_dialog_box('some-error', lang_warning, xhr.responseText.toString());
            $('#sidebar_setting_status').html('---');
        }
    });
}

/**
 * Prevent review.
 */

function prevent_review() {
    clearos_dialog_box('review_error', lang_warning, lang_marketplace_no_install_no_review);
}

/**
 * Add review.
 */

function add_review() {
    auth_options.no_redirect_on_cancel = true;
    auth_options.callback = 'display_review_form';
    clearos_is_authenticated();
}

/**
 * Display review form.
 */

function display_review_form() {
    clearos_modal_infobox_open('review-form');
    // Sometimes browser autocompletes this field
    $('#review-comment').val('');
    $.ajax({
        url: '/app/marketplace/ajax/get_pseudonym',
        method: 'GET',
        dataType: 'json',
        success : function(name) {
            $('#review-pseudonym').val(name);
        }
    });
}

/**
 * Submit review.
 */

function submit_review(update) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/app/marketplace/ajax/add_review',
        data: 'ci_csrf_token=' + $.cookie('ci_csrf_token') + '&basename=' + $('#review-basename').val() + '&comment=' + $('#review-comment').val()
            + '&rating=' + $('#review-rating').val() + '&pseudonym=' + $('#review-pseudonym').val() + (update ? '&update=1' : ''),
        success: function(data) {
            if (data.code != 0) {
                // Check to see if there's already a review
                if (data.code == 8) {
                    $('#review-form').modal('hide');
                    $('#confirm-review-replace').modal('show');
                    return;
                }
                $('#review-message-bar').html(theme_infobox('warning', lang_warning, data.errmsg));
                $('#review-message-bar').show(200);
            } else {
                $('#review-form').modal('hide');
                var options = new Object();
                options.reload_on_close = true;
                clearos_dialog_box('submit_info', lang_information, data.status, options);
            }
        },
        error: function(xhr, text, err) {
            clearos_dialog_box('error', lang_warning, xhr.responseText.toString());
        }
    });
}

function clearos_marketplace_app_list(type, list, limit, total, options) {
    // theme_app function passes all information to theme to create HTML and place inside div
    theme_app(type, list, options);
    if (list.length < total) {
        // We need to populate the paginate widget
        
        var href = $(location).attr('href');
        var index = parseInt(href.substr(href.lastIndexOf('/') + 1));
        if (isNaN(index))
            index = 0;

        upper = ((parseInt(index) * limit) + parseInt(limit));
        if (upper > total)
            upper = total;
        $('#paginate_next').before('<a href="/app/marketplace/search/index/' + index + '" class="btn btn-secondary">' + lang_marketplace_displaying + ' ' +
            (1 + (parseInt(index) * limit)) + ' - ' + upper + ' ' + lang_of + ' ' + total + '</a>');

        if ((Math.ceil(total / limit)) > 1) {
            var prev = Math.max((index - 1), 0); 
            var next = Math.min((index + 1), (Math.ceil(total / limit) - 1)); 
            $('#paginate_prev').attr('href', '/app/marketplace/search/index/' + prev);
            $('#paginate_next').attr('href', '/app/marketplace/search/index/' + next);
            $('#paginate_last').attr('href', '/app/marketplace/search/index/' + (Math.ceil(total / limit) - 1));
            $('#paginate').buttonset();
            $('#marketplace_paginate_container').show();
        }
    }
}

//-------------------------------------------------------
// P R I V A T E
//-------------------------------------------------------

/**
 * Returns HTML for adding key/value pairs to the sidebar widget.
 */

function _sidebar_pair(field, value, options) {
    row_class = '';
    field_class = '';
    value_class = '';
    if (options != undefined) {
        if (options.row_class != undefined)
            row_class = ' ' + options.row_class;
        if (options.field_class != undefined)
            field_class = ' ' + options.field_class;
        if (options.value_class != undefined)
            value_class = ' ' + options.value_class;
    }
    return '<div class=\'row' + row_class + '\'>' +
                '<div class=\'col-xs-6 theme-field' + field_class + '\'>' + field + '</div>' +
                '<div class=\'col-xs-6' + value_class + '\'>' + value + '</div>' +
           '</div>'
    ;
}

/**
 * Returns app in full mode.
 */

function _get_app_full(app, options)
{
    disable_buttons = '';
    learn_more_target = '';
    if (options.wizard) {
        disable_buttons = ' disabled';
        learn_more_target = ' target="_blank"';
    }

    buttons = '<a href="/app/' + app.basename + '" class="btn btn-primary ' + disable_buttons + '">' + lang_configure + '</a>';
    if (app.can_uninstall)
        buttons += '<a href="/app/marketplace/uninstall/' + app.basename + '" class="btn btn-secondary ' + disable_buttons + '">' + lang_uninstall + '</a>';
    if (!app.installed) {
        if ((app.display_mask & 1) == 1)
            buttons = '';
        else if (options.search_only)
            buttons = '<a href="/app/marketplace/view/' + app.basename + '" class="btn btn-primary btn-xs">' + lang_install + '</a>';
        else
            buttons = '<input type="submit" name="install" value="' +
                (app.incart ? lang_marketplace_remove : lang_marketplace_select_for_install) +
                '" id="' + app.basename + '" class="btn btn-primary marketplace-app-event" data-appname="' +
                app.name + '"/>' +
                '<input type="checkbox" name="cart" id="select-' + app.basename + '" class="theme-hidden"' + (app.incart ? ' CHECKED' : '') + '/>'
            ;
    } else if (options.wizard) {
        buttons = '<a href="#" class="btn btn-warning disabled">' + lang_installed + '</a>';
    }

    return '\
        <div class="col-md-6 marketplace-list-layout">\
            <div class="app_box" id="box-' + app.basename + '">\
                <div id="active-select-' + app.basename + '" class="' + (app.incart ? '' : 'theme-hidden ') + 'marketplace-selected"><i class="ff-check-square-o"></i></div>\
            ' + (app.installed ? '<span class="installed_ribbon">' + lang_installed.toUpperCase() + '</span>' : '') + '\
            <h4 class="block-title marketplace-full-title">' + app.pricing.description + '<div class="app_vendor">' + app.vendor + '</div><span class="app_title_fade"></span></h4>\
            <div class="listsvg_cont">\
                <figure id="app-logo-' + app.basename + '" data-basename="' + app.basename + '" class="theme-app-logo theme-placeholder' + (app.incart ? ' theme-app-selected' : '') + '">\
                    ' + get_placeholder("svg") + '\
                </figure>\
                <div class="app_title"><div class="app_rating">' + theme_star_rating(app.rating) + '</div>' + theme_price(UNIT, app.pricing) + '</div>\
            </div>\
            <div class="app-description">\
                <p>' + app.description.replace(/(\r\n|\n|\r)/g, '</p><p>') + '</p>\
            </div>\
            <div class="app_footer">' +
                ((app.display_mask & 1) == 1 ? '<div class="pull-left marketplace-app-not-available">Requires Business Edition</div>' : '') + 
                
                '<div class="btn-group">' + buttons +
                '<a href="/app/marketplace/view/' + app.basename + '"' + learn_more_target + ' class="btn btn-secondary ">' + lang_marketplace_learn_more + '</a>\
                </div>\
            </div>\
        </div>\
        ' + (index % 2 ? '<div style="clear: both;"></div>' : '') + '\
    ';
}

/**
 * Returns app in tile mode.
 */

function _get_app_tile(app, options)
{
    disable_buttons = '';
    learn_more_target = '';

    if (options.wizard) {
        disable_buttons = ' disabled';
        learn_more_target = ' target="_blank"';
        learn_more_url = app.url_redirect + '/marketplace/apps/' + app.category.toLowerCase() + '/' + app.basename;
    } else {
        learn_more_url = '/app/marketplace/view/' + app.basename;
    }
    col = 3;
    if (options.columns)
        col = 12 / options.columns;

    var buttons = '<div class="btn-group">' +
        '<a href="/app/' + app.basename + '" data-toggle="tooltip" data-container="body" class="btn btn-success btn-xs ' + disable_buttons + '" title="' + lang_configure + '"><i class="fa fa-gears"></i></a>';
    if (app.can_uninstall)
        buttons += '<a href="/app/marketplace/uninstall/' + app.basename + '" class="btn btn-secondary btn-xs ' + disable_buttons + '">' + lang_uninstall + '</a>';
    buttons += '</div>';

    if (!app.installed) {
        if ((app.display_mask & 1) == 1)
            buttons = '<div class="theme-text-alert" style="font-size:.9em; display: inline;">Requires Business Edition</div>';
        else if (options.search_only)
            buttons = '<a href="/app/marketplace/view/' + app.basename + '" class="btn btn-primary btn-xs">' + lang_install + '</a>';
        else
            buttons = '<input type="checkbox" name="cart" id="select-' + app.basename + '" class="theme-hidden"' + (app.incart ? ' CHECKED' : '') + '/>' +
                '<input type="submit" name="install" value="' +
                (app.incart ? lang_marketplace_remove : lang_marketplace_select_for_install) +
                '" id="' + app.basename + '" class="btn btn-primary btn-xs marketplace-app-event" data-appname="' +
                app.name + '"/>'
            ;
    } else if (options.wizard) {
        buttons = '<a href="#" class="btn btn-warning btn-xs disabled">' + lang_installed + '</a>';
    }

    return '\
       <div class="col-md-' + col + ' marketplace-tile-layout">\
          <div class="app_box" id="box-' + app.basename + '">\
            <h4 class="block-title marketplace-tile-title" data-toggle="tooltip" data-container="body" title="' + app.pricing.description + '">' + app.pricing.description + '<div class="app_vendor">' + app.vendor + '</div><span class="app_title_fade"></span></h4>\
            <figure id="app-logo-' + app.basename + '" data-basename="' + app.basename + '" class="theme-app-logo theme-placeholder' + (app.incart ? ' theme-app-selected' : '') + '">\
                ' + get_placeholder("svg") + '\
            </figure>\
            <div class="app_tile_info">\
              <div class="app_price">' + theme_price(UNIT, app.pricing) + '</div>\
              <div class="app_rating">' + theme_star_rating(app.rating) + '</div>\
            </div>\
            <div class="app_footer">' + buttons +
              '<a href="' + learn_more_url + '" data-toggle="tooltip" data-container="body" class="btn btn-secondary btn-xs pull-left" ' + learn_more_target + ' title="' + lang_marketplace_learn_more + '"><i class="fa fa-question"></i></a>\
            </div>\
            </div>\
          </div>\
        </div>\
    ';
}

/**
 * Returns page location used in client side script.
 */

function _get_location_info()
{
    my_obj = new Object();
    my_obj.default_controller = true;
    my_obj.fullpath = document.location.pathname;

    regex = /\/app\/(\w+)\/.*/;
    path = document.location.pathname.match(regex);

    if (path == null) {
        my_obj.default_controller = false;
        regex = /\/app\/(\w+)$/;
        path = document.location.pathname.match(regex);

        if (path == null)
            console.log('Oh oh...could not determine app basename.');
        else
            my_obj.basename = path[1];
    } else {
        my_obj.basename = path[1];

        // Marketplace page where we can extract app name?
        regex = /\/app\/marketplace\/view\/(\w+)$/;
        app = document.location.pathname.match(regex);

        if (app != null)
            my_obj.app_name = app[1];
    }

    return my_obj;
}

// vim: syntax=javascript ts=4
