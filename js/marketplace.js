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

// TODO: document
$.ajaxSetup({ cache: false });

// Globals
var auth_options = new Object();
var sdn_org = '';
var internet_connection = false;
var lang = new Object();

// Document ready handler
$(document).ready(function() {
    $(".my-colorpicker").colorpicker();
    $('body').tooltip({
      html: true,
      selector: '[data-toggle=tooltip]'
    });
    handle_marketplace_on_page_ready();
});

// Listens for app rating click
$(document).on('click', '.sidebar-review-app', function(e) {
    e.preventDefault();
    add_review();
});

function theme_paginate(url, total, active)
{
    var html = '';
    var offset = 0;
    var max = 5;
    if (active > (max / 2))
        offset = Math.floor(active - Math.floor(total / (max / 2)));
    if (active > offset + max)
        offset = total - max + 1;
    else if (total <= active + max / 2)
        offset = total - max + 1;

    if (offset < 0)
        offset = 0;

    if (total < max)
        max = total;

    for (i = offset; i < max + offset; i++) {
        html += '<a href="' + url + '/' + i + '" class="btn ' + (i == active ? 'btn-primary' : 'btn-secondary') + ' ">' + i + '</a>';
    }
    return html;
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

    get_marketplace_data(my_location.basename);

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
    var html = price.unit_price > 0 ? price.currency + price.unit_price + ' ' + UNIT[price.unit] : lang_marketplace_free;

    return html;
}

function get_marketplace_data(basename) {

    // Let's see if we have a connection to the Internet
    // Block on this call (async set to false)
    $.ajax({
        url: '/app/network/get_internet_connection_status',
        method: 'GET',
        dataType: 'json',
        async: false,
        success : function(status) {
            if (status != 'offline')
                internet_connection = true;
        },
        error: function (xhr, text_status, error_thrown) {
        }
    });

    // Avoid furter calls if target fields do not exist
    if ($('#sidebar_additional_info').length == 0)
        return;

    // No connection to Internet...let's bail
    if (!internet_connection) {
        $('#sidebar_additional_info').html('<a href=\'/app/network\' class=\'highlight-link\'>' + lang_internet_down + '</a>');
        $('#sidebar_additional_info_row').show(200);
        return;
    }

    $.ajax({
        url: '/app/marketplace/ajax/get_app_details/' + basename,
        method: 'GET',
        dataType: 'json',
        success : function(json) {
            if (json.code != undefined && json.code != 0) {
                $('#sidebar_additional_info').css('color', 'red');
                $('#sidebar_additional_info_row').show(200);
                if (json.code < 0) {
                    // Could put real message for codes < 0, but it gets a bit technical
                    $('#sidebar_additional_info').html(lang_marketplace_connection_failure);
                } else {
                    if (json.code == 3)
                        $('#sidebar_additional_info').html('<a href=\'/app/registration/register\'>' + json.errmsg + '</a>');
                    else
                        $('#sidebar_additional_info').html(json.errmsg);
                }
                return;
            } else {
                // Add title to review form
                $('#review-app-name').html(json.name);
                // We add rows in the reverse order to keep this section under the Version/Vendor

                // Evaluation
                if (json.license_info != undefined && json.license_info.evaluation != undefined && json.license_info.evaluation == true) {
                    if (json.license_info.eval_limitations != undefined) {
                        $('#sidebar_additional_info_row').after(
                            _c_row(
                                lang_marketplace_eval_limitations,
                                '<a id=\'eval-limit-anchor\' href=\'javascript: void(0)\'>' + lang_yes + '</a>' +
                                '<div class=\'theme-rhs-tooltip\'>' + json.license_info.eval_limitations + '</div>'
                            )
                        );
                        $('#eval-limit-anchor').tooltip({
                            offset: [-140, -315],
                            position: 'center left',
                            effect: 'slide',
                            direction: 'left',
                            slideOffset: 110,
                            opacity: 0.95
                        });
                    }
                    $('#sidebar_additional_info_row').after(
                        _c_row(
                            lang_marketplace_trial_ends,
                            $.datepicker.formatDate('M d, yy', new Date(json.license_info.expire))
                        )
                    );
                    $('#sidebar_additional_info_row').after(
                        _c_row(
                            lang_status,
                            '<span style=\'color: red\'>' + lang_marketplace_evaluation + '</span>'
                        )
                    );
                } else {
                    // Redemption period
                    if (json.license_info != undefined && json.license_info.redemption != undefined && json.license_info.redemption == true) {
                        $('#sidebar_additional_info_row').after(
                            _c_row(
                                lang_status,
                                '<span style=\'color: red\'>' + lang_marketplace_redemption + '</span>'
                            )
                        );
                    }

                    // No Subscription
                    if (json.license_info != undefined && json.license_info.no_subscription != undefined && json.license_info.no_subscription == true) {
                        $('#sidebar_additional_info_row').after(
                            _c_row(
                                lang_status,
                                '<span style=\'color: red\'>' + lang_marketplace_expired_no_subscription + '</span>'
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

                        $('#sidebar_additional_info_row').after(
                            _c_row(
                                lang_marketplace_billing_cycle,
                                bill_cycle
                            )
                        );
                        if (json.license_info.expire != undefined) {
                            $('#sidebar_additional_info_row').after(
                                _c_row(
                                    lang_marketplace_renewal_date,
                                    $.datepicker.formatDate('M d, yy', new Date(json.license_info.expire))
                                )
                            );
                        }
                    }
                }

                // Support Policy
                if (json.supported != undefined && !json.hide_support_policy) {
                    // TODO - there are some clearcenter references here
                    $('#sidebar_additional_info_row').after(
                        _c_row(
                            lang_marketplace_support_policy,
                            get_support_policy(json)
                        )
                    );
                }

                // Version updates
                if (!json.up2date) {
                    $('#sidebar_additional_info_row').after(
                        _c_row(
                            lang_marketplace_upgrade,
                            json.latest_version
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
        },
        error: function (xhr, text_status, error_thrown) {
            console.log(xhr.responseText.toString());
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
        '<h4>' + lang_marketplace_support_legend + '</h4>' +
        '</div>' +
        '<div class=\'modal-body\'>' +
        '<i class=\'fa fa-circle theme-support theme-support-1\' style=\'margin-right: 5px;\'></i>' +
        '<h4 class=\'theme-support-type\'>' + lang_marketplace_support_1_title + '</h4>' +
        '<p>' +
        lang_marketplace_support_1_description +
        '</p>' +
        '<i class=\'fa fa-circle theme-support theme-support-2\' style=\'margin-right: 5px;\'></i>' +
        '<h4 class=\'theme-support-type\'>' + lang_marketplace_support_2_title + '</h4>' +
        '<p>' +
        lang_marketplace_support_2_description +
        '</p>' +
        '<i class=\'fa fa-circle theme-support theme-support-4\' style=\'margin-right: 5px;\'></i>' +
        '<h4 class=\'theme-support-type\'>' + lang_marketplace_support_4_title + '</h4>' +
        '<p>' +
        lang_marketplace_support_4_description +
        '</p>' +
        '<i class=\'fa fa-circle theme-support theme-support-8\' style=\'margin-right: 5px;\'></i>' +
        '<h4 class=\'theme-support-type\'>' + lang_marketplace_support_8_title + '</h4>' +
        '<p>' +
        lang_marketplace_support_8_description +
        '</p>' +
        '<i class=\'fa fa-circle theme-support theme-support-16\' style=\'margin-right: 5px;\'></i>' +
        '<h4 class=\'theme-support-type\'>' + lang_marketplace_support_16_title + '</h4>' +
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
        <?xml version="1.0" encoding="utf-8"?>\
        <!-- Generator: Adobe Illustrator 15.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->\
        <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">\
        <svg version="1.1"\
             id="Layer_1" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:svg="http://www.w3.org/2000/svg"\
             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="100%" height="100%" preserveAspectRatio="xMinYMin" \
             viewBox="0 0 400 400" enable-background="new 0 0 400 400" xml:space="preserve">\
        <g id="Layer_7" transform="translate(0,1.3329999)" display="none">\
            <g id="g4" display="inline">\
                <path id="path6" d="M81.984,71.004h33.076l42.445,165.935c5.829,23.278,10.082,44.354,12.758,63.213\
                    c3.279-22.418,8.137-44.35,14.579-65.781l47.737-163.36h32.802l50.611,165.093c5.947,18.916,10.974,40.271,15.063,64.063\
                    c2.355-17.393,6.816-38.59,13.393-63.578L387.213,71.01h33.076l-71.85,268.657h-30.874l-53.407-180.144\
                    c-2.361-7.982-5.326-17.987-8.897-30.021c-3.565-12.034-5.424-19.282-5.536-21.74c-2.69,16.171-6.975,33.876-12.852,53.108\
                    l-52.494,178.801h-30.834L81.984,71.004z"/>\
            </g>\
        </g>\
        <g id="Layer_3" transform="translate(0,1.3329999)" display="none">\
            <g id="g9" display="inline">\
                <path id="path11" d="M150.803,339.665V71.004h35.279l146.442,224.558h1.449c-0.241-3.429-0.792-14.086-1.634-31.971\
                    c-0.603-13.966-0.91-24.811-0.91-32.519c0-2.205,0-4.163,0-5.868V71.02h28.854v268.657H325L178.18,114.186h-1.471\
                    c1.958,26.463,2.939,50.718,2.939,72.771v152.708H150.803L150.803,339.665z"/>\
            </g>\
        </g>\
        <g id="Layer_4" transform="translate(0,1.3329999)" display="none">\
            <g id="g14" display="inline">\
                <path id="path16" d="M170.766,333.886v-29.961c11.024,4.66,23.029,8.348,36.019,11.037c12.984,2.693,25.847,4.05,38.593,4.05\
                    c20.862,0,36.57-3.952,47.123-11.874c10.56-7.918,15.837-18.916,15.837-33.047c0-9.324-1.871-16.953-5.613-22.913\
                    c-3.746-5.952-10.008-11.448-18.781-16.474c-8.773-5.026-22.115-10.742-40.039-17.121c-25.032-8.958-42.854-19.574-53.447-31.845\
                    c-10.598-12.266-15.897-28.276-15.897-48.037c0-20.724,7.752-37.221,23.263-49.481c15.51-12.261,36.021-18.392,61.547-18.392\
                    c26.635,0,51.132,4.9,73.483,14.7l-9.626,27.221c-22.146-9.329-43.68-13.989-64.598-13.989c-16.569,0-29.522,3.563-38.848,10.676\
                    c-9.323,7.118-13.986,16.995-13.986,29.637c0,9.324,1.716,16.963,5.152,22.918c3.434,5.953,9.233,11.411,17.397,16.381\
                    c8.155,4.971,20.646,10.46,37.452,16.474c28.229,10.065,47.579,20.863,58.061,32.397c10.475,11.539,15.714,26.511,15.714,44.91\
                    c0,23.556-8.559,41.927-25.658,55.101c-17.104,13.173-40.321,19.772-69.645,19.772\
                    C212.413,346.036,187.916,341.985,170.766,333.886L170.766,333.886z"/>\
            </g>\
        </g>\
        <g id="Layer_5" transform="translate(0,1.3329999)" display="none">\
            <g id="g19" display="inline">\
                <path id="path21" d="M142.218,71.009h33.077l61.742,173.833c7.105,19.97,12.738,39.392,16.908,58.259\
                    c4.41-19.851,10.156-39.632,17.271-59.354l61.374-172.74h33.623l-96.844,268.659h-30.861L142.218,71.009z"/>\
            </g>\
        </g>\
        <g id="Layer_6" transform="translate(0,1.3329999)" display="none">\
            <g id="g24" display="inline">\
                <path id="path26" d="M154.708,208.841c0-27.668,5.116-51.908,15.355-72.721c10.24-20.811,25.124-36.85,44.653-48.113\
                    c19.528-11.26,42.532-16.895,68.989-16.895c28.177,0,52.8,5.145,73.868,15.437l-13.229,26.816\
                    c-20.339-9.547-40.676-14.321-61.016-14.321c-29.531,0-52.84,9.826-69.918,29.471c-17.09,19.645-25.634,46.542-25.634,80.698\
                    c0,35.144,8.237,62.272,24.716,81.429c16.479,19.155,39.968,28.731,70.479,28.731c18.739,0,40.115-3.365,64.123-10.095v27.479\
                    c-18.621,7.031-41.592,10.546-68.904,10.546c-39.582,0-70.045-12.015-91.421-36.036\
                    C165.395,287.237,154.708,253.093,154.708,208.841z"/>\
            </g>\
        </g>\
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
                $('#sdn-login-dialog').modal('hide');
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
                    if (auth_options.no_redirect_on_cancel)
                        return;
                    else if (auth_options.use_full_path_on_redirect)
                        window.location = my_location.fullpath;
                    else if (!my_location.default_controller && auth_options.use_full_path_on_redirect)
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

        $('#paginate_next').before(theme_paginate('/app/marketplace/search/index', Math.ceil(total / limit) - 1, index));

        if ((Math.ceil(total / limit) - 1) > 1) {
            var prev = Math.max((index - 1), 0); 
            var next = Math.min((index + 1), (Math.ceil(total / limit) - 1)); 
            $('#paginate_prev').attr('href', '/app/marketplace/search/index/' + prev);
            $('#paginate_next').attr('href', '/app/marketplace/search/index/' + next);
            $('#paginate').buttonset();
            $('#marketplace_paginate_container').show();
        }
    }
}

//-------------------------------------------------------
// P R I V A T E
//-------------------------------------------------------

/**
 * FIXME
 */

function _c_row(field, value) {
    return '<div class=\'row\'>' +
                '<div class=\'col-lg-6 theme-field\'>' + field + '</div>' +
                '<div class=\'col-lg-6\'>' + value + '</div>' +
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

    return '\
        <div class="col-md-6">\
            <div class="app_box" id="box-' + app.basename + '">\
                <div id="active-select-' + app.basename + '" class="' + (app.incart ? '' : 'theme-hidden ') + 'marketplace-selected"><i class="ff-check-square-o"></i></div>\
            ' + (app.installed ? '<span class="installed_ribbon">' + lang_installed.toUpperCase() + '</span>' : '') + '\
            <h4 class="block-title">' + app.name + '</h4>\
            <div class="listsvg_cont">\
                <figure id="app-logo-' + app.basename + '" class="theme-app-logo theme-placeholder">\
                    ' + get_placeholder("svg") + '\
                </figure>\
                <div class="app_title"><div class="app_rating">' + theme_star_rating(app.rating) + '</div>' + theme_price(UNIT, app.pricing) + '</div>\
            </div>\
            <div class="app-description">\
                <p>' + app.description.replace(/(\r\n|\n|\r)/g, '</p><p>') + '</p>\
            </div>\
            <div class="app_footer">' +
                '<div class="btn-group">' +
                (app.installed ?
                    '<a href="/app/' + app.basename + '" class="btn btn-primary ' + disable_buttons + '">' + lang_configure + '</a>' +
                    '<a href="/app/marketplace/uninstall/' + app.basename + '" class="btn btn-default ' + disable_buttons + '">' + lang_uninstall + '</a>'
                    : '<input type="submit" name="install" value="' + (app.incart ? lang_marketplace_remove : lang_marketplace_select_for_install) + '" id="' + app.basename + '" class="btn btn-primary  marketplace-app-event" data-appname="' + app.name + '"/>' +
                    '<input type="checkbox" name="cart" id="select-' + app.basename + '" class="theme-hidden"' + (app.incart ? ' CHECKED' : '') + '/>'
                ) +
                '<a href="/app/marketplace/view/' + app.basename + '"' + learn_more_target + ' class="btn btn-default ">' + lang_marketplace_learn_more + '</a>\
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
        learn_more_url = app.url_redirect + '/marketplace/type/?basename=' + app.basename;
    } else {
        learn_more_url = '/app/marketplace/view/' + app.basename;
    }
    col = 3;
    if (options.columns)
        col = 12 / options.columns;

    var buttons = '<div class="btn-group">' +
        '<a href="/app/' + app.basename + '" data-toggle="tooltip" data-container="body" class="btn btn-success btn-xs ' + disable_buttons + '" title="' + lang_configure + '"><i class="fa fa-gears"></i></a>' +
        '<a href="/app/marketplace/uninstall/' + app.basename + '" class="btn btn-default btn-xs ' + disable_buttons + '">' + lang_uninstall + '</a>' +
        '</div>'
    ;

    if (!app.installed)
        buttons = '<input type="submit" name="install" value="' +
            (app.incart ? lang_marketplace_remove : lang_marketplace_select_for_install) +
            '" id="' + app.basename + '" class="btn btn-primary btn-xs marketplace-app-event" data-appname="' +
            app.name + '"/>'
        ;
    else if (options.wizard)
        buttons = '<a href="#" class="btn btn-warning btn-xs disabled">' + lang_installed + '</a>';

    var font_size = '';

    if (app.name.length > 60)
        font_size = ' theme-xs';
    else if (app.name.length > 45)
        font_size = ' theme-sm';

    return '\
       <div class="col-md-' + col + '">\
          <div class="app_box" id="box-' + app.basename + '">\
            <h4 class="block-title marketplace-tile-title' + font_size + '">' + app.name + '</h4>\
            <figure id="app-logo-' + app.basename + '" class="theme-app-logo theme-placeholder">\
                ' + get_placeholder("svg") + '\
            </figure>\
            <div class="app_title">' + theme_price(UNIT, app.pricing) + '\
              <div class="app_rating">' + theme_star_rating(app.rating) + '</div>\
            </div>\
            <div class="app_footer">\
              '+ buttons +'<input type="checkbox" name="cart" id="select-' + app.basename + '" class="theme-hidden"' + (app.incart ? ' CHECKED' : '') + '/>\
              <a href="' + learn_more_url + '" data-toggle="tooltip" data-container="body" class="btn btn-default btn-xs pull-left" ' + learn_more_target + ' title="' + lang_marketplace_learn_more + '"><i class="fa fa-question"></i></a>\
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
