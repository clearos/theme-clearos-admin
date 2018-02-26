<?php
/**
 * Page layout handler for the theme.
 *
 * @category  Theme
 * @package   ClearOS
 * @author    ClearFoundation <developer@clearfoundation.com>
 * @copyright 2014-2018 ClearFoundation
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link      http://www.clearfoundation.com/docs/developer/theming/ 
 *
 **/

//////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
///////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////
// P A G E  C A L L B A C K S
//////////////////////////////////////////////////////////////////////////////

/**
 * Main call back for creating a page.
 *
 * Every app in ClearOS (indirectly) calls the theme_page() function with
 * a requested page layout.  As you can imaging, there are a few different
 * types of page layouts that an app developer can use.  See the online
 * documentation for a description and example of each:
 *
 * - http://www.clearfoundation.com/docs/developer/theming/page_layout
 *
 * @param array $page page details and content
 * @return string page in HTML 
 */

function theme_page($page)
{
    // Legacy support for 'report' instead of MY_Page::TYPE_REPORTS
    //-------------------------------------------------------------

    if ($page['type'] == 'report')
        $page['type'] = MY_Page::TYPE_REPORTS;

    // Page layout
    //------------

    if ($page['type'] == MY_Page::TYPE_CONFIGURATION)
        return _configuration_page($page);
    else if ($page['type'] == MY_Page::TYPE_WIDE_CONFIGURATION)
        return _wide_configuration_page($page);
    else if ($page['type'] == MY_Page::TYPE_REPORTS)
        return _report_page($page);
    else if ($page['type'] == MY_Page::TYPE_REPORT_OVERVIEW)
        return _report_overview_page($page);
    else if ($page['type'] == MY_Page::TYPE_SPOTLIGHT)
        return _spotlight_page($page);
    else if ($page['type'] == MY_Page::TYPE_DASHBOARD)
        return _dashboard_page($page);
    else if (($page['type'] == MY_Page::TYPE_SPLASH) || ($page['type'] == MY_Page::TYPE_SPLASH_ORGANIZATION))
        return _splash_page($page);
    else if ($page['type'] == MY_Page::TYPE_LOGIN)
        return _login_page($page);
    else if ($page['type'] == MY_Page::TYPE_2FACTOR_AUTH)
        return _2factor_auth_page($page);
    else if ($page['type'] == MY_Page::TYPE_WIZARD)
        return _wizard_page($page);
    else if ($page['type'] == MY_Page::TYPE_EXCEPTION)
        return _exception_page($page);
    else if ($page['type'] == MY_Page::TYPE_CONSOLE)
        return _console_page($page);
}

/**
 * Opening content on the page, i.e. after <head>
 *
 * @param array $settings theme settings
 * @return string HTML
 */

function theme_page_open($settings)
{   
    return "<body id='clearos-body-container' class='marketplace_page'>\n";
}

/**
 * Closing content on the page.
 *
 * @param array $page page details and content
 * @return string HTML
 */

function theme_page_close($page)
{
    return "</body></html>\n";
}

//////////////////////////////////////////////////////////////////////////////
// P A G E  L A Y O U T
//////////////////////////////////////////////////////////////////////////////

/**
 * Returns a common app page.
 *
 * @param array $page page data
 *
 * @return string HTML output
 */

function _configuration_page($page)
{
    $page_class = _get_page_class($page['current_basename']);

    $layout =
        "<div class='main-wrapper $page_class'>" .
        _get_header($page) .
        "<div class='main-content form-horizontal' style='overflow: hidden;'>".
        _get_left_menu($page) .
        _get_main_content($page) .
        "</div>" .
        _get_footer($page)
    ;

    return $layout;
}

/**
 * Returns a wide configuration page.
 *
 * @param array $page page data
 *
 * @return string HTML output
 */

function _wide_configuration_page($page)
{
    $page_class = _get_page_class($page['current_basename']);

    $layout =
        "<div class='main-wrapper $page_class'>" .
        _get_header($page) .
        "<div class='main-content form-horizontal'>".
        _get_left_menu($page) .
        _get_main_content($page) .
        "</div>" .
        _get_footer($page)
    ;

    return $layout;
}

/**
 * Returns a report page.
 *
 * @param array $page page data
 *
 * @return string HTML output
 */

function _report_page($page)
{
    $page_class = _get_page_class($page['current_basename']);

    $layout =
        "<div class='main-wrapper $page_class'>" .
        _get_header($page) .
        "<div class='main-content form-horizontal'>".
        _get_left_menu($page) .
        _get_main_content($page) .
        "</div>" .
        _get_footer($page)
    ;

    return $layout;
}

/**
 * Returns a report overview page.
 *
 * @param array $page page data
 *
 * @return string HTML output
 */

function _report_overview_page($page)
{
    $page_class = _get_page_class($page['current_basename']);

    $layout =
        "<div class='main-wrapper $page_class'>" .
        _get_header($page) .
        "<div class='main-content form-horizontal'>".
        _get_left_menu($page) .
        _get_main_content($page) .
        "</div>" .
        _get_footer($page)
    ;

    return $layout;
}

/**
 * Returns the dashboard page.
 *
 * @param array $page page data
 *
 * @return string HTML output
 */

function _dashboard_page($page)
{
    $page_class = _get_page_class($page['current_basename']);

    $layout =
        "<div class='main-wrapper $page_class'>" .
        _get_header($page) .
        "<div class='main-content form-horizontal'>".
        _get_left_menu($page) .
        _get_main_content($page) .
        "</div>" .
        _get_footer($page)
    ;

    return $layout;
}

/**
 * Returns the spotlight page.
 *
 * @param array $page page data
 *
 * @return string HTML output
 */

function _spotlight_page($page)
{
    $page_class = _get_page_class($page['current_basename']);

    $layout =
        "<div class='main-wrapper $page_class'>" .
        _get_header($page) .
        "<div class='main-content form-horizontal'>". 
        _get_left_menu($page) .
        _get_main_content($page) .
        "</div>" .
        _get_footer($page)
    ;

    return $layout;
}

/**
 * Returns the login type page.
 *
 * @param array $page page data
 *
 * @return string HTML output
 */

function _login_page($page)
{
    return "
<!-- Page Container -->
<div class='theme-login-container container'>
    <div class='theme-login-logo'></div>
    " . $page['app_view'] . "
</div>
";
}

/**
 * Returns the two-factor authentication type page.
 *
 * @param array $page page data
 *
 * @return string HTML output
 */

function _2factor_auth_page($page)
{
    return "
<!-- Page Container -->
<div class='theme-2fa-container container'>
    " . $page['app_view'] . "
</div>
";
}

/**
 * Returns a splash page.
 *
 * @param array $page page data
 *
 * @return string HTML output
 */

function _splash_page($page)
{
    // TODO - Find way to customize splash page.
    $org_css = preg_replace('/\/core\/.*/', '', realpath(__FILE__)) . '/css/theme-organization.css';

    if (!preg_match('/Community/', $page['os_name']) && ($page['type'] == MY_Page::TYPE_SPLASH_ORGANIZATION) && file_exists($org_css))
        $class = 'theme-splash-organization-logo';
    else
        $class = 'theme-splash-logo';

    return "
        <!-- Body -->
        <body>
            <!-- Page Container -->
            <div class='theme-page-splash-container container'>
                <div class='row'>
                    <div class='col-md-1'></div>
                    <div class='col-md-7'>
                        <div class='theme-content-splash-container'>
                            " . _get_message() . "
                            " . $page['app_view'] . "
                        </div>
                    </div>
                    <div class='col-md-3' style='text-align: center;'>
                        <div class='ci-ClearOS'></div>
                    </div>
                    <div class='col-md-1'></div>
                </div>
            </div>
        </body>
        </html>
    ";

}

/**
 * Returns the exception page.
 *
 * @param array $page page data
 *
 * @return string HTML output
 */

function _exception_page($page)
{
    $page_class = _get_page_class($page['current_basename']);

    $layout =
        "<div class='main-wrapper $page_class'>" .
        _get_header($page) .
        "<div class='main-content form-horizontal'>".
        _get_left_menu($page) .
        _get_main_content($page) .
        "</div>" .
        _get_footer($page)
    ;

    return $layout;
}

/**
 * Returns the wizard page.
 *
 * @param array $page page data
 *
 * @return string HTML output
 */

function _wizard_page($page)
{
    $page_class = _get_page_class($page['current_basename']);

    $layout =
        "<div class='main-wrapper $page_class'>" .
        _get_header($page) .
        "<div class='main-content form-horizontal'>" .
        _get_wizard_menu($page) .
        "<section class='content-container'>"
    ;

    // For Wizard pages with help boxes, split page up into 8/4 col
    if ($page['page_inline_help'])
        $layout .= "<div class='col-md-8 theme-content'>";
    else
        $layout .= "<div class='col-md-12 theme-content'>";

    // Add intro, as req'd
    if ($page['page_wizard_intro']) {
        $layout .= theme_box_open($page['page_wizard_name']);
        $layout .= theme_box_content($page['page_wizard_intro']);
        $layout .= theme_box_close();
    }

    // Messages and page view
    $layout .= _get_message() . $page['app_view'];

    // Add inline help
    if ($page['page_inline_help']) {
        // Close out 8 column main view
        $layout .= "</div>";
        $layout .= "<div class='col-md-4 theme-inline-help'>";
        $layout .= $page['page_inline_help'];
        $layout .= "</div>";
    } else {
        // Close out 12 column main view
        $layout .= "</div>";
    }
    // Close out section
    $layout .= "
                </section>
            </section>
    ";
    $layout .= "  </div>";
    $layout .= "</div>";
    $layout .= _get_footer($page);

    return $layout;
}

/**
 * Returns the console page.
 *
 * @param array $page page data
 *
 * @return string HTML output
 */

function _console_page($page)
{
    $page_class = _get_page_class($page['current_basename']);

    // The text and widget sizes are a lot bigger in ClearOS 7, so it makes
    // it harder to put everything on one screen.  There's really no need for
    // scrollbars on the console -- the ability to quickly see the network
    // IP addresses and link status is nice.
    //
    // TODO: Review the hacks below - shrinking vertical space as much as possible

    if ($page['current_basename'] != 'graphical_console')
        $logout = anchor_custom('/app/base/session/logout', lang('base_logout'), 'high') . " ";
    else
        $logout = '';

    $layout =
        "<div class='main-wrapper $page_class' style='margin-top: -20px'>
            <div class='page-title'>
                <h1 style='font-size: 18px; padding: 14px 0'>$page[title]</h1>
                <p style='text-align: right; padding-top: 5px; padding-right: 5px'>" .
                    $logout . " " .
                    anchor_custom('/app/graphical_console/shutdown', lang('base_exit_to_text_console'), 'high') . "
                </p>
                <div class='clearfix'></div>
            </div>
            <div class='main-content form-horizontal'>".
                _get_main_content($page) . "
                <div class='clearfix'></div>
            </div>
        </div>"
    ;

    return $layout;
}

//////////////////////////////////////////////////////////////////////////////
// L A Y O U T  H E L P E R S
//////////////////////////////////////////////////////////////////////////////

/**
 * Returns messages sent from the system
 */

function _get_message()
{
    $framework =& get_instance();

    if (! $framework->session->userdata('message_text'))
        return;

    $message = $framework->session->userdata('message_text');
    $type =  $framework->session->userdata('message_code');
    $title = $framework->session->userdata('message_title');

    $framework->session->unset_userdata('message_text');
    $framework->session->unset_userdata('message_code');
    $framework->session->unset_userdata('message_title');

    return theme_infobox($type, $title, $message);
}

/**
 * Returns main content.
 *
 * @param array $page page data
 *
 * @return string menu HTML output
 */

function _get_main_content($page)
{
    if ($page['type'] == MY_Page::TYPE_DASHBOARD || $page['type'] == MY_Page::TYPE_EXCEPTION || $page['type'] == MY_Page::TYPE_SPOTLIGHT || $page['type'] == MY_Page::TYPE_WIZARD) {
        // TODO  header (including help) section on spotlight?/
        return "
            <section class='content-container'>
                <div class='content-header clearfix'>
                    " . _get_content_header($page) . "
                </div>
                " . _get_message().$page['app_view']." 
            </section>
            <div style='clear: both;'></div>
        ";
    } else if ($page['type'] == MY_Page::TYPE_REPORT_OVERVIEW) {
        return "
            <section class='content-container'>
                <div class='content-header clearfix'>
                    " . _get_content_header($page) . "
                </div>
                <div class='row content clearfix'>
                    <div id='theme-layout-content' class='col-md-8 theme-content'>
                " . _get_message() . "
                " . $page['app_view'] . "
                    </div>
                    <div id='theme-layout-rhs' class='col-md-4'>
                        <div id='theme-sidebar-container'>
                            <div class='theme-sidebar-top box'>
                            " . $page['page_summary'] . "
                            </div>
                            <div class='theme-sidebar-top box'>
                            " . $page['page_report_helper'] . "
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        ";
    } else if ($page['type'] == MY_Page::TYPE_REPORTS) {
        return "
            <section class='content-container'>
                <div class='content-header clearfix'>
                    " . _get_content_header($page) . "
                </div>
                <div class='row content clearfix'>
                    <div id='theme-layout-content' class='col-md-8 theme-content'>
                    " . _get_message() . "
                    " . $page['page_report_chart'] . "
                    " . $page['page_report_table'] . "
                    </div>
                    <div id='theme-layout-rhs' class='col-md-4'>
                        <div id='theme-sidebar-container'>
                            <div class='theme-sidebar-top box'>
                            " . $page['page_report_helper'] . "
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        ";
    } else if ($page['type'] == MY_Page::TYPE_CONSOLE) {
        return "
            <section class='console-container'>
                <div class='row content clearfix'>
                    <div class='col-md-9 theme-content'>
                        " . _get_message() . "
                        " . $page['app_view'] . "
                    </div>
                    <div class='col-md-3 theme-inline-help'>
                        <div class='theme-sidebar-top box'>
                            $page[page_inline_help]
                        </div>
                    </div>
                </div>
            </section>
        ";
    } else if ($page['type'] == MY_Page::TYPE_WIDE_CONFIGURATION) {
        return "
            <section class='content-container'>
                <div class='content-header clearfix'>
                    " . _get_content_header($page) . "
                </div>
                <div class='content clearfix'>
                    <div class='theme-content'>
                    " . _get_message() . "
                    " . $page['app_view'] . "
                    </div>
                </div>
            </section>
        ";
    } else {
        return "
            <section class='content-container'>
                <div class='content-header clearfix'>
                    " . _get_content_header($page) . "
                </div>
                <div class='row content clearfix'>
                    <div id='theme-layout-content' class='col-md-8 theme-content'>
                " . _get_message() . "
                " . $page['app_view'] . "
                    </div>
                    <div id='theme-layout-rhs' class='col-md-4'>
                        <div id='theme-sidebar-container'>
                            <div class='theme-sidebar-top box'>
                            " . $page['page_summary'] . "
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        ";
    }
}

/**
 * Returns the header.
 *
 * @param array $page page data
 *
 * @return string banner HTML
 */

function _get_header($page, $menus = array())
{
    $theme_url = clearos_theme_url('ClearOS-Admin');

    $my_account = '';
    $alert_text = '';
    $framework =& get_instance();
    $my_account_collection = array();

    if (! isset($framework->session->userdata['wizard'])) {
        foreach ($page['menus'] as $route => $details) {
            if ($details['subcategory'] == lang('base_subcategory_my_account')) {
                $my_account .= "<li><a role='menuitem' href='$route'>" . $details['title'] . "</a></li>\n";
                $my_account_collection[] = basename($route);
            }
        }
    }

    // If OS == ClearOS, leave as is...if the version is present, strip from variable
    if ($page['os_name'] == "ClearOS")
        $os_name = $page['os_name'];
    else
        $os_name = preg_replace('/ClearOS\s*/', '', $page['os_name']);

    if (isset($page['alerts']) && count($page['alerts']['events']) > 0) {
        foreach ($page['alerts']['events'] as $alert) {
            $i = theme_icon('critical', array('class' => 'theme-text-alert'));
            if ($alert['flags'] & 2)
                $i = theme_icon('warning', array('class' => 'theme-text-warning'));
            $alert_text .= "
                <li>
                    <a href='/app/events'>$i " . $alert['desc'] . "</a>
                </li>
            ";
        }
        // If we are showing 10 alerts (the limit), add a 'View all' option to let admin know there are (maybe) more
        if ($page['alerts']['total'] > 10) {
            $alert_text .= "
                <li>
                    <a href='/app/events'><i class='fa fa-exclamation-circle theme-text-alert'></i> " . lang('base_view_all_events') . "</a>
                </li>
            ";
        }
    };

    $title = $page['title']; 
    if (isset($framework->session->userdata['wizard'])) {
        $title = lang('base_wizard') . "<i class='breadcrumb-separator fa fa-arrow-circle-right'></i>" . $page['title'];
    } else {
        if ($page['title'] != $page['current_name'])
            $title = $page['current_name'] . "<i class='breadcrumb-separator fa fa-arrow-circle-right'></i>" . $title;
    }
    
    $active_header = array();
    $active_header['dashboard'] = '';
    $active_header['marketplace'] = '';
    $active_header['support'] = '';
    $active_header['my-account'] = '';
    $active_header['home'] = '';

    if ($page['current_basename'] == 'dashboard')
        $active_header['dashboard'] = "active";
    else if ($page['current_basename'] == 'marketplace')
        $active_header['marketplace'] = "active";
    else if ($page['current_basename'] == 'support')
        $active_header['support'] = "active";
    else if (in_array($page['current_basename'], $my_account_collection))
        $active_header['my-account'] = "active";
    else 
        $active_header['home'] = "active";
        
    // TODO Hard coded text below
    $main_menu = array(
        'dashboard' => "<li class='placeholder'></li>",
        'marketplace' => "<li class='placeholder'></li>",
        'support' => "<li class='placeholder'></li>"
    );
    if ($framework->session->userdata['nav_acl']['dashboard'])
        $main_menu['dashboard'] = "
            <li class='dashboard " . $active_header['dashboard'] . "'>
                <a href='/app/dashboard'><i class='ci-dashboard'></i>" . lang('base_dashboard') . "</a>
            </li>
        ";
    if ($framework->session->userdata['nav_acl']['marketplace'])
        $main_menu['marketplace'] = "
            <li class='marketplace " . $active_header['marketplace'] . "'>
                <a href='/app/marketplace'><i class='fa fa-cloud-download'></i> " . lang('base_marketplace') . "</a>
            </li>
        ";
    if ($framework->session->userdata['nav_acl']['support'])
        $main_menu['support'] = "
            <li class='support " . $active_header['support'] . "'>
                <a href='/app/support'><i class='ci-Clear_CARE'></i>" . lang('base_support') . "</a>
            </li> 
        ";

    return "<header class='mainheader'>
              <div class='navbar-header'>
                <button data-target='.bs-navbar-collapse' data-toggle='collapse' type='button' class='navbar-toggle'>
                  <i class='fa fa-bars'></i>
                </button>
              </div>
            
              <ul class='full_menu'>
                " . (! isset($framework->session->userdata['wizard']) ? "
                <li class='ClearOS " . $active_header['home'] . "'>
                  <a href='#' class='ci-ClearOS'>&nbsp;</a>
                </li>
                " . $main_menu['dashboard'] . "
                " . $main_menu['marketplace'] . "
                " . $main_menu['support'] . "
                <li class='my-account dropdown " . $active_header['my-account'] . "'>
                  <a href='javascript:void(0);' class='dropdown-toggle' data-toggle='dropdown'>
                    <i class='ci-my-account'></i> " .
                    ((!empty($page['alerts']) && ($page['alerts']['total'] > 0)) ? "<span class='theme-alert-header'>" . $page['alerts']['total'] . "</span>" : '') . "
                    <span data-toggle='tooltip' data-placement='top' title='" . $page['username'] . "'>" . 
                    ((strlen($page['username']) > 10 ) ? substr($page['username'],0,10) . '...' : $page['username']) .  "</span>
                  </a>
                  <ul class='dropdown-menu' role='menu'>
                    " . ((!empty($page['alerts']) && ($page['alerts']['total'] > 0)) ?  $alert_text : '') . "
                    <li class='divider'></li>
                      $my_account
                    <li class='divider'></li>
                    <li><a role='menuitem' href='/app/base/session/logout'>Sign out</a></li>
                  </ul>
                </li>
                " : "
                <li class='ClearOS theme-wizard-active'>
                  <a href='#' class='ci-ClearOS'>&nbsp;</a>
                </li> 
                ") . "
              </ul>
              <div class='ClearOS logo1 " . (($page['current_basename'] == '') ? "active" : "") . "'>
                <a href='#' class='ci-ClearOS'>&nbsp;</a>
              </div> 
              <div class='small_menu'></div>
              <div class='clearfix'></div>
            </header>
          <div class='page-title'><h1 id='theme-clearos-os-name'>$os_name</h1><div class='sitepath'>$title</div>
          " . (isset($page['breadcrumb_links']) ? _get_breadcrumb_links($page['breadcrumb_links'], isset($framework->session->userdata['wizard'])) : "") . "<div class='clearfix'></div>
          </div>"
        ;
}

/**
 * Returns content header
 *
 * @return string menu HTML output
 */

function _get_content_header($page)
{
    return $page['page_help'];
}

/**
 * Returns footer
 *
 * @param array $page page data
 *
 * @return string menu HTML output
 */

function _get_footer($page)
{
    $vendor = "ClearCenter";
    if ($page['os_name'] == "ClearOS Community")
        $vendor = "ClearFoundation";

    $modals = '';
    if (isset($page['sdn_notice']) && is_array($page['sdn_notice'])) {
        $modals = theme_modal_info(
            'sdn_notice',
            $page['sdn_notice']['title'],
            $page['sdn_notice']['message'],
            array(
                'type' => $page['sdn_notice']['type'],
                'call_back' => 'acknowledge_sdn_notice(' . $page['sdn_notice']['id'] . ');'
            )
        );
        $modals .= "
            <script type='text/javascript'>
                $(document).ready(function() {
                    clearos_modal_infobox_open('sdn_notice');
                });

                function acknowledge_sdn_notice(id) {
                    $.ajax({
                        url: '/app/registration/ajax/acknowledge_sdn_notice/' + id,
                        method: 'GET',
                        dataType: 'json',
                        success : function(json) {
                        },
                        error: function (xhr, text_status, error_thrown) {
                        }
                    });
                }

            </script>
        ";
    }
    return "
      <!-- Modal Dialogs -->
      $modals " . theme_tips_and_hints($page['tooltips']) . "
      <!-- Footer -->
      <div class='clearfix'></div>
      <footer>Copyright &copy; 2009 - 2018 $vendor</footer>
    <!-- Close main-wrapper -->
    </div>
    ";
}

/**
 * Returns wizard left panel menu.
 *
 * @param array $page page data
 *
 * @return string menu HTML output
 */

function _get_wizard_menu($page)
{
    $framework =& get_instance();

    $menu_data = $page['wizard_menu'];
    $current_subcategory = NULL;
    $category_list = array();
    foreach ($menu_data as $step_no => $menu)
        $category_list[$menu['subcategory']][] = $step_no;
    foreach ($menu_data as $step_no => $menu) {
        
        // Determine sub-category icon to use

        if ($menu['subcategory'] == lang('base_network_settings'))
            $sub_class = 'fa fa-share-alt';
        else if ($menu['subcategory'] == lang('base_registration'))
            $sub_class = 'fa fa-pencil';
        else if ($menu['subcategory'] == lang('base_configuration'))
            $sub_class = 'fa fa-gears';
        else if ($menu['subcategory'] == lang('base_marketplace'))
            $sub_class = 'fa fa-cloud-download';
        else if ($menu['subcategory'] == lang('base_finish'))
            $sub_class = 'fa fa-tasks';
        else
            $sub_class = 'fa fa-angle-double-right';
        

        $disabled = '';
        if ($step_no != $page['wizard_current'])
            $disabled = 'theme-link-disabled';

        $active = '';
        $sub_active = '';

        if (isset($category_list[$menu['subcategory']]) && in_array($page['wizard_current'],$category_list[$menu['subcategory']]))
            $sub_active = 'active';
     
        if ($step_no == $page['wizard_current'])
            $active = 'active';
        
        if ($current_subcategory == NULL) {    

            $current_subcategory = $menu['subcategory'];
            $steps .= "<li class='treeview  $sub_active'>\n";
            $steps .= "\t<a href='#'><small class='$sub_class'></small><span>" . $menu['subcategory'] . "</span></a>\n";
            $steps .= "\t<ul class='sub_menu'>\n";
            $steps .= "\t\t<li class='$disabled $active'><a href='" . ($disabled != '' ? '#' : $menu['nav']) . "'>" . $menu['title'] . "</a></li>\n";
        } else if ($current_subcategory == $menu['subcategory']) { 
            
            $steps .= "\t\t<li class='$disabled $active'><a href='" . ($disabled != '' ? '#' : $menu['nav']) . "'>" . $menu['title'] . "</a></li>\n";
        } else if ($current_subcategory != $menu['subcategory']) {
            
            
            $current_subcategory = $menu['subcategory'];  
            $steps .= "\t</ul>\n";
            $steps .= "</li>\n";
            $steps .= "<li class='treeview $sub_active'>\n";
            $steps .= "\t<a href='#' class='" . (isset($framework->session->userdata['wizard']) ? "theme-link-disabled" : "") . "'><small class='$sub_class'></small><span>" . $menu['subcategory'] . "</span></a>\n";
            $steps .= "\t<ul class='sub_menu'>\n";
            $steps .= "\t\t<li class='$disabled $active'><a href='" . ($disabled != 'theme-link-disabled' ? '#' : $menu['nav']) . "'>" . $menu['title'] . "</a></li>\n";
        }
    }

    // Close out open HTML tags
    //-------------------------

    $steps .= "\t\t</ul>\n";
    $steps .= "</li>\n";

    if (isset($page['theme_ClearOS-Admin']['menu']) && $page['theme_ClearOS-Admin']['menu'] == 2) {
        return "
            <aside class='theme-menu-2'>
                <div class='sidebar'>
                    <ul class='sidebar-menu-2'>
                        $steps
                    </ul>
                </div>
            </aside>
        ";
    } else {
        return "
            <aside class='theme-menu-1'>
                <ul class='left_nav'>
                    $steps
                </ul>
            </aside>
        ";
    }
}

/**
 * Returns left panel menu.
 *
 * @param array $page page data
 *
 * @return string menu HTML output
 */

function _get_left_menu($page)
{

    // Default is Menu 1 (long sidebar)
    if (isset($page['theme_ClearOS-Admin']['menu']) && $page['theme_ClearOS-Admin']['menu'] == 2)
        return _get_left_menu_2($page);
    else
        return _get_left_menu_1($page);
}

/**
 * Returns left panel menu, type 1.
 *
 * @param array $page page data
 *
 * @return string menu HTML output
 */

function _get_left_menu_1($page)
{
    $my_account = '';
    $framework =& get_instance();
    $my_account_collection = array();

    if (! isset($framework->session->userdata['wizard'])) {
        foreach ($page['menus'] as $route => $details) {
            if ($details['subcategory'] == lang('base_subcategory_my_account')) {
                $my_account .= "<li class='dev_menu'><a role='menuitem' href='$route'>" . $details['title'] . "</a></li>\n";
                $my_account_collection[] = basename($route);
            }
        }
    }


    if (empty($page['devel_alerts']))
        $page['devel_alerts'] = [];

    $menu_data = $page['menus'];
    $main_apps = '';
    $spotlights = '';
    $img_path = clearos_theme_path('ClearOS-Admin') . '/img/';
    $current_category = '';
    $current_subcategory = '';
    $alert_text = '';

    if (isset($page['alerts']) && count($page['alerts']['events']) > 0) {
        foreach ($page['alerts']['events'] as $alert) {
            $i = theme_icon('critical', array('class' => 'theme-text-alert'));
            if ($alert['flags'] & 2)
                $i = theme_icon('warning', array('class' => 'theme-text-warning'));
            $alert_text .= "
                <li>
                    <a href='/app/events'>$i " . $alert['desc'] . "</a>
                </li>
            ";
        }
        // If we are showing 10 alerts (the limit), add a 'View all' option to let admin know there are (maybe) more
        if ($page['alerts']['total'] > 10) {
            $alert_text .= "
                <li>
                    <a href='/app/events'><i class='fa fa-exclamation-circle theme-text-alert'></i> " . lang('base_view_all_events') . "</a>
                </li>
            ";
        }
    };


    foreach ($menu_data as $url => $page_meta) {

        if ($page_meta['subcategory'] === lang('base_subcategory_my_account')) {
            continue;
        }

        $icon = 'placeholder.svg';
        if (preg_match('/.*dashboard.*/', $url) && file_exists($img_path . 'dashboard.svg'))
            $icon = 'dashboard.svg';
        else if (preg_match('/.*marketplace.*/', $url) && file_exists($img_path . 'marketplace.svg'))
            $icon = 'marketplace.svg';
        else if (lang('base_category_cloud') == $page_meta['category'] && file_exists($img_path . 'cloud.svg'))
            $icon = 'cloud.svg';
        else if (lang('base_category_network') == $page_meta['category'] && file_exists($img_path . 'network.svg'))
            $icon = 'network.svg';
        else if (lang('base_category_gateway') == $page_meta['category'] && file_exists($img_path . 'gateway.svg'))
            $icon = 'gateway.svg';
        else if (lang('base_category_server') == $page_meta['category'] && file_exists($img_path . 'server.svg'))
            $icon = 'server.svg';
        else if (lang('base_category_system') == $page_meta['category'] && file_exists($img_path . 'system.svg'))
            $icon = 'system.svg';
        else if (lang('base_category_reports') == $page_meta['category'] && file_exists($img_path . 'reports.svg'))
            $icon = 'reports.svg';
        else if (lang('base_marketplace') == $page_meta['category'] && file_exists($img_path . 'marketplace.svg'))
            $icon = 'marketplace.svg';

        // Spotlight pages (read: Dashboard and Marketplace)
        //--------------------------------------------------

        if ($page_meta['category'] === lang('base_category_spotlight')) {
            $spotlights .= "\t\t<li>\n";
            $spotlights .= "\t\t\t<a href='" . $url . "' title='" . $page_meta['title'] . "'><div class='theme-menu-2-category'>" . file_get_contents($img_path . $icon) . "</div>\n";
            $spotlights .= "\t\t\t<span class='menu-item'> " . $page_meta['title'] . " </span>\n";
            $spotlights .= "\t\t\t</a>\n";
            $spotlights .= "\t\t</li>\n";
            continue;
        }
        // Close out menus on transitions
        //-------------------------------

        $new_category = ($page_meta['category'] == $current_category) ? FALSE : TRUE;
        $new_subcategory = ($page_meta['subcategory'] == $current_subcategory) ? FALSE : TRUE;

        if (empty($main_apps)) {
            // do nothing
        } else if ($new_category && $new_subcategory) {
            // Close out subcategory and category
            $main_apps .= "</ul>";
            $main_apps .= "</li>";
            $main_apps .= "</ul>";
            $main_apps .= "</li>";
        } else if ($new_subcategory) {
            $main_apps .= "</ul>";
            $main_apps .= "</li>";
        }

        if ($page_meta['category'] != $current_category) {
            $current_category = $page_meta['category'];
            $main_apps .= "<li class='". ($page_meta['category'] == $page['current_category'] ? " active" : "") . "'>";
            $main_apps .= (((count($page['devel_alerts'])) > 0 && strtolower($page_meta['category']) == 'system') ? 
            "<div class='bubbleDrop'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>" .
            ((count($page['devel_alerts'])) > 0 ? "<span class='theme-alert-header'>" . $page['alerts']['total'] . "</span>" : '') . "</a>
            <ul class='dropdown-menu' role='menu'>
                 " . ((count($page['devel_alerts'])) > 0 ?  $alert_text : '') . "
              <li class='divider'></li>
              $my_account
              <li class='divider'></li>
              <li><a role='menuitem' href='/app/base/session/logout'>Sign out</a></li>
            </ul></div>
            " : '') . "<a href='#' class='nav-toggle'><i class='coi-" . strtolower($page_meta['category']) . "'></i>";
            $main_apps .= $page_meta['category'];
            $main_apps .= "</a>";
            $main_apps .= "<ul class='sub_menu'>";
        }

        // Subcategory transition
        //-----------------------

        if ($current_subcategory != $page_meta['subcategory']) {
            $current_subcategory = $page_meta['subcategory'];

            $main_apps .= "<li class='". ($page_meta['subcategory'] == $page['current_subcategory'] ? "active" : "") . "'>";
            $main_apps .= "<a href='#' class='nav-toggle'><span class='menu-item'>" . $page_meta['subcategory'] . "</span></a>";
            $main_apps .= "<ul class='nav nav-third-level'>";
        }


        // App page
        //---------
      //echo "<pre>";print_r($page['current_subcategory']);echo "</pre>";
       $current_sub_category  = (isset($page['current_basename'])) ? $page['current_basename'] : '';
       $title_sub_category    = (isset($url)) ? strtolower(str_replace('/app/','', $url)) : '0'; 
       //echo $title_sub_category.'<br>';

       //echo $title_sub_category;exit;
       // echo $current_subcategory.'<br>';
        $main_apps .= "<li ".(($current_sub_category == $title_sub_category) ? 'class="active"' : '')."><a href='" . $url . "'>" . htmlspecialchars($page_meta['title']) . " </a></li>";
    }

    // Close out open HTML tags
    //-------------------------

    $main_apps .= "</ul>";
    $main_apps .= "</li>";
    $main_apps .= "</ul>";
    $main_apps .= "</li>";

    $framework =& get_instance();
    $username = $framework->session->userdata('username');

    // Search form
    //-------------
    // Not used in menu 1

    if ($username === 'root') {
        $search_html =
            form_open('base/search', NULL, NULL, array('class' => 'sidebar-form')) . "
            <div class='input-group'>
                <input type='text' name='g_search' id='g_search' class='form-control theme-sidebar-search' placeholder='" . lang('base_search') . "' />
                <span class='input-group-btn'>
                    <button type='submit' name='btn_search' class='btn btn-flat'><i class='fa fa-search'></i></button>
                </span>
            </div>
            " . form_close();
    } else {
        // Left nav is inserted into sidebar-form
        $search_html = form_open('base/search', NULL, NULL, array('class' => 'sidebar-form')) . form_close();
    }

    return "
        <aside class='theme-menu-1'>
            <ul class='left_nav'>
                $spotlights
                $main_apps
            </ul>
        </aside>";
}

/**
 * Returns left panel menu, type 2.
 *
 * @param array $page page data
 *
 * @return string menu HTML output
 */

function _get_left_menu_2($page)
{
    $menu_data = $page['menus'];
    $spotlights = '';
    $main_apps = '';
    $current_category = '';
    $current_subcategory = '';

    foreach ($menu_data as $url => $page_meta) {

        // Spotlight pages (read: Dashboard and Marketplace)
        //--------------------------------------------------

        if (lang('base_category_cloud') == $page_meta['category'])
            $category_id = 'cloud';
        else if (lang('base_category_network') == $page_meta['category'])
            $category_id = 'network';
        else if (lang('base_category_gateway') == $page_meta['category'])
            $category_id = 'gateway';
        else if (lang('base_category_server') == $page_meta['category'])
            $category_id = 'server';
        else if (lang('base_category_system') == $page_meta['category'])
            $category_id = 'system';
        else if (lang('base_category_reports') == $page_meta['category'])
            $category_id = 'report';
        else
            $category_id = 'unknown';

        if ($page_meta['category'] === lang('base_category_spotlight')) {
            $spotlights .= "\t\t<li"  . ($url == $current_basename ? " class='active'" : "") . ">\n";
            $spotlights .= "\t\t\t<a href='" . $url . "' title='" . $page_meta['title'] . "'><i class='fa fa-laptop'></i>\n";
            $spotlights .= "\t\t\t<span class='title'> " . $page_meta['title'] . " </span>" . ($url == $current_base ? "<span class='selected'></span>" : "") . "\n";
            $spotlights .= "\t\t\t</a>\n";
            $spotlights .= "\t\t</li>\n";
            continue;
        }
        if ($page_meta['subcategory'] === lang('base_subcategory_my_account')) {
            continue;
        }

        $new_category = ($page_meta['category'] == $current_category) ? FALSE : TRUE;
        $new_subcategory = ($page_meta['subcategory'] == $current_subcategory) ? FALSE : TRUE;

        if (empty($main_apps)) {
            // do nothing
        } else if ($new_category && $new_subcategory) {
            // Close out subcategory and category
            $main_apps .= "\t\t\t\t\t</ul>\n";
            $main_apps .= "\t\t\t\t</li>\n";
        } else if ($new_subcategory) {
            $main_apps .= "\t\t\t\t\t</ul>\n";
            $main_apps .= "\t\t\t\t</li>\n";
        }

        if ($page_meta['category'] != $current_category)
            $current_category = $page_meta['category'];

        // Subcategory transition
        //-----------------------

        if ($current_subcategory != $page_meta['subcategory']) {
            $current_subcategory = $page_meta['subcategory'];

            $main_apps .= "\t\t\t\t<li class='category category-" . $category_id . " treeview" . ($page['current_subcategory'] == $page_meta['subcategory'] ? " active" : "") . "'>\n";
            $main_apps .= "\t\t\t\t\t<a href='#'><i class='fa fa-angle-double-right'></i>" . $page_meta['subcategory'] . "</a>\n";
            $main_apps .= "\t\t\t\t\t<ul class='sub_menu'>\n";
        }

        // App page
        //---------

        $main_apps .= "\t\t\t\t\t\t<li" . (basename($url) == $page['current_basename'] ? " class='active'" : "") . "><a href='" . $url . "'>" . $page_meta['title'] . "</a></li>\n";
    }

    // Close out open HTML tags
    //-------------------------

    $main_apps .= "\t\t\t\t</ul>\n";
    $main_apps .= "\t\t\t</li>\n";

    // Select radio button for category
    $active_category = array(
        'cloud' => '',
        'network' => '',
        'gateway' => '',
        'server' => '',
        'system' => '',
        'report' => ''
    );
    if (lang('base_category_cloud') == $page['current_category'])
        $active_category['cloud'] = ' checked';
    else if (lang('base_category_network') == $page['current_category'])
        $active_category['network'] = ' checked';
    else if (lang('base_category_gateway') == $page['current_category'])
        $active_category['gateway'] = ' checked';
    else if (lang('base_category_server') == $page['current_category'])
        $active_category['server'] = ' checked';
    else if (lang('base_category_system') == $page['current_category'])
        $active_category['system'] = ' checked';
    else if (lang('base_category_reports') == $page['current_category'])
        $active_category['report'] = ' checked';

    // If we're on a spotlight page (dashboard etc.) pick one
    if (!array_filter($active_category))
        $active_category['cloud'] = ' checked';

    $img_path = clearos_theme_path('ClearOS-Admin') . '/img/';

    $no_of_categories = 6;
    $percent_width = round(100 / $no_of_categories, 0, PHP_ROUND_HALF_UP);

    $framework =& get_instance();
    $username = $framework->session->userdata('username');

    // Search form
    //-------------

    if ($username === 'root') {
        $search_html =
            form_open('base/search', NULL, NULL, array('class' => 'sidebar-form')) . "
            <div class='input-group'>
                <input type='text' name='g_search' id='g_search' class='form-control theme-sidebar-search' placeholder='" . lang('base_search') . "' />
                <span class='input-group-btn'>
                    <button type='submit' name='btn_search' class='btn btn-flat'><i class='fa fa-search'></i></button>
                </span>
            </div>
            " . form_close();
    } else {
        $search_html = "";
    }

    return "
<aside class='theme-menu-2 clearfix'>
    <div class='sidebar'>
        $search_html
        <div class='btn-toolbar theme-menu-2-list'>
            <form action='#' method='get' id='category-select'>
                <div class='btn-group' data-toggle='buttons'>
                    <label class='btn btn-default theme-menu-2-category category-cloud col-md-2 col-sm-4 col-xs-6' data-toggle='tooltip' data-container='body' title='" . lang('base_category_cloud') . "'>
                        <input type='radio' name='options' id='category-cloud'" . $active_category['cloud'] . ">
                        " . file_get_contents($img_path . 'cloud.svg') . "
                    </label>
                    <label class='btn btn-default theme-menu-2-category category-network col-md-2 col-sm-4 col-xs-6' data-toggle='tooltip' data-container='body' title='" . lang('base_category_network') . "'>
                        <input type='radio' name='options' id='category-network'" . $active_category['network'] . ">
                        " . file_get_contents($img_path . 'network.svg') . "
                    </label>
                    <label class='btn btn-default theme-menu-2-category category-gateway col-md-2 col-sm-4 col-xs-6' data-toggle='tooltip' data-container='body' title='" . lang('base_category_gateway') . "'>
                        <input type='radio' name='options' id='category-gateway'" . $active_category['gateway'] . ">
                        " . file_get_contents($img_path . 'gateway.svg') . "
                    </label>
                    <label class='btn btn-default theme-menu-2-category category-server col-md-2 col-sm-4 col-xs-6' data-toggle='tooltip' data-container='body' title='" . lang('base_category_server') . "'>
                        <input type='radio' name='options' id='category-server'" . $active_category['server'] . ">
                        " . file_get_contents($img_path . 'server.svg') . "
                    </label>
                    <label class='btn btn-default theme-menu-2-category category-system col-md-2 col-sm-4 col-xs-6' data-toggle='tooltip' data-container='body' title='" . lang('base_category_system') . "'>
                        <input type='radio' name='options' id='category-system'" . $active_category['system'] . ">
                        " . file_get_contents($img_path . 'system.svg') . "
                    </label>
                    <label class='btn btn-default theme-menu-2-category category-report col-md-2 col-sm-4 col-xs-6' data-toggle='tooltip' data-container='body' title='" . lang('base_category_reports') . "'>
                        <input type='radio' name='options' id='category-report'" . $active_category['report'] . ">
                        " . file_get_contents($img_path . 'reports.svg') . "
                    </label>
                </div>
            </form>
        </div>
        <ul class='sidebar-menu-2'>
$main_apps
        </ul>
    </div>
</aside>
";
}

/**
 * Returns breadcrumb.
 *
 * @param array   $links link  data
 * @param boolean $wizard_mode in wizard mode?
 *
 * @return string menu HTML output
 */

function _get_breadcrumb_links($links, $wizard_mode)
{
    $link_html = '';
    $button_grp = '';

    // Tack on info widget show/hide
    if (!$wizard_mode)
        $links['rhs-toggle'] = array(
            'url' => '#',
            'id' => 'rhs-widget-toggle'
        );
    // Use buttons, images/icons or font
    foreach ($links as $type => $link) {
        $text_right = (isset($link['display_tag']) && $link['display_tag']) ? "<span style='padding: 5px'>" . $link['tag'] . "</span>" : '';
        $text_left = '';
        if (isset($link['tag_position']) && $link['tag_position'] == 'left') {
            $text_left = $text_right;
            $text_right = '';
        }
        $button_class = '';
        if (isset($link['button']) && $link['button']) {
            $button_grp = 'btn-group';
            if ($link['button'] === 'high')
                $button_class = 'btn btn-primary';
            else if ($link['button'] === 'low')
                $button_class = 'btn btn-secondary';
            else
                $button_class = 'btn';
        }

        if (isset($link['target'])) {
            $target = " target='" . $link['target'] . "'";
            $external_tip = "<i class=\"fa fa-external-link theme-text-icon-spacing\"></i>";
        } else {
            $target = '';
            $external_tip = '';
        }

        if (!isset($link['tag']))
            $link['tag'] = '';

        $id = 'bcrumb-' . rand(0 , 1000);
        if (isset($link['id']))
            $id = $link['id'];

        $icon = 'fa fa-question';
        if ($type == 'settings')
            $icon = 'fa fa-gear';
        else if ($type == 'delete')
            $icon = 'fa fa-trash-o';
        else if ($type == 'checkout')
            $icon = 'fa fa-cloud-download';
        else if ($type == 'marketplace')
            $icon = 'fa fa-th-list';
        else if ($type == 'wizard')
            $icon = 'fa fa-magic';
        else if ($type == 'cancel')
            $icon = 'fa fa-ban';
        else if ($type == 'power')
            $icon = 'fa fa-power-off';
        else if ($type == 'restart')
            $icon = 'fa fa-power-off';
        else if ($type == 'terminal')
            $icon = 'fa fa-terminal';
        else if ($type == 'qsf')
            $icon = 'fa fa-file-code-o';
        else if ($type == 'wizard_next')
            $icon = 'fa fa-arrow-circle-right';
        else if ($type == 'wizard_previous')
            $icon = 'fa fa-arrow-circle-left';
        else if ($type == 'app-info')
            continue;  //$icon = 'fa fa-info-circle';
        else if ($type == 'app-documentation')
            $icon = 'fa fa-book';
        else if ($type == 'app-tip')
            $icon = 'fa fa-lightbulb-o';
        else if ($type == 'rhs-toggle')
            $icon = 'fa fa-toggle-on';

        if ($type == 'wizard_next' || $type == 'wizard_previous')
            $disabled = ' disabled';
        else
            $disabled = '';
        $link_html .= "<a href='" . $link['url'] . "' id='$id' class='$button_class " . (isset($link['class']) ? $link['class'] : "") . "'$target$disabled>
            $text_left<i class='$icon' data-toggle='tooltip' data-container='body' title='" . $link['tag'] . $external_tip . "'></i>$text_right</a>";
    }
    return "<span class='theme-breadcrumb-links $button_grp'>" . $link_html . "</span>";
};

/**
 * Returns specific class for page loaded.
 *
 * @param string $basename basename
 *
 * @return string class
 */

function _get_page_class($basename)
{
    switch($basename) {
        case 'dashboard' : 
        $class  = 'dashboard_page'; 
        break;
        
        case 'marketplace' : 
        $class  = 'marketplace_page';
        break;
        
        case 'support' : 
        $class  = 'support_page';
        break;
        
        case 'TODO My Account Pages' : 
        $class  = 'my_account_page';
        break;
        
        default : 
        $class  = 'clearos_page';
        break;
        
    }

    return $class;
}
