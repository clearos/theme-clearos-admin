<?php
/**
 * Page layout handler for the theme.
 *
 * @category  Theme
 * @package   ClearOS
 * @author    ClearFoundation <developer@clearfoundation.com>
 * @copyright 2014 ClearFoundation
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link      http://www.clearfoundation.com/docs/developer/theming/ 
 */

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
    // The following is just some logic for showing some alerts in the
    // header when a developer is in development mode.

    if ($_SERVER['SERVER_PORT'] == 1501 && !preg_match('/.*hide_devel$/', $_SERVER['REQUEST_URI'])) {
        if (!preg_match('/^\/usr\/clearos/', __FILE__))
            $page['devel_alerts']['theme'] = TRUE;
    }

    if ($page['devel_app_source'] != 'Live')
        $page['devel_alerts']['app'] = TRUE;

    if ($page['devel_framework_source'] != 'Live')
        $page['devel_alerts']['framework'] = TRUE;

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
        "<div class='main-content'>".
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
        "<div class='main-content'>".
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
        "<div class='main-content'>".
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
        "<div class='main-content'>".
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
        "<div class='main-content'>".
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
        "<div class='main-content'>". 
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
 * Returns a splash page.
 *
 * @param array $page page data
 *
 * @return string HTML output
 */

function _splash_page($page)
{
    $org_css = preg_replace('/\/core\/.*/', '', realpath(__FILE__)) . '/css/theme-organization.css';

    if (!preg_match('/Community/', $page['os_name']) && ($page['type'] == MY_Page::TYPE_SPLASH_ORGANIZATION) && file_exists($org_css))
        $class = 'theme-splash-organization-logo';
    else
        $class = 'theme-splash-logo';

    return "
        <!-- Body -->
        <body>

        <!-- Page Container -->
        <div class='theme-page-splash-container'>
            <div class='$class'></div>
            <div class='theme-content-splash-container'>
                " . _get_message() . "
                " . $page['app_view'] . "
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
        "<div class='main-content'>".
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
        "<div class='main-content'>" .
        _get_wizard_menu($page) .
        "<section class='content-container'>"
    ;

    // For Wizard pages with help boxes, split page up into 8/4 col
    if ($page['page_inline_help'])
        $layout .= "<div class='col-lg-8 theme-content'>";
    else
        $layout .= "<div class='col-lg-12 theme-content'>";

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
        $layout .= "<div class='col-lg-4 theme-inline-help'>";
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
    echo "todo - console";
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
                <section class='content-header clearfix'>
                    " . _get_content_header($page) . "
                </section>
                " . _get_message().$page['app_view']." 
            </section>
        ";
    } else if ($page['type'] == MY_Page::TYPE_REPORT_OVERVIEW) {
        return "
            <section class='content-container'>
                <section class='content-header clearfix'>
                    " . _get_content_header($page) . "
                </section>
                <section class='row content clearfix'>
                    <div class='col-lg-8 theme-content'>
                " . _get_message() . "
                " . $page['app_view'] . "
                    </div>
                    <div class='col-lg-4'>
                        <div id='theme-sidebar-container'>
                            <div class='theme-sidebar-top box'>
                            " . $page['page_summary'] . "
                            </div>
                            <div class='theme-sidebar-top box'>
                            " . $page['page_report_helper'] . "
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        ";
    } else if ($page['type'] == MY_Page::TYPE_REPORTS) {
        return "
            <section class='content-container'>
                <section class='content-header clearfix'>
                    " . _get_content_header($page) . "
                </section>
                <section class='row content clearfix'>
                    <div class='col-lg-8 theme-content'>
                    " . _get_message() . "
                    " . $page['page_report_chart'] . "
                    " . $page['page_report_table'] . "
                    </div>
                    <div class='col-lg-4'>
                        <div id='theme-sidebar-container'>
                            <div class='theme-sidebar-top box'>
                            " . $page['page_report_helper'] . "
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        ";
    } else if ($page['type'] == MY_Page::TYPE_WIDE_CONFIGURATION) {
        return "
            <section class='content-container'>
                <section class='content-header clearfix'>
                    " . _get_content_header($page) . "
                </section>
                <section class='row content clearfix'>
                    <div class='theme-content'>
                    " . _get_message() . "
                    " . $page['app_view'] . "
                    </div>
                </section>
            </section>
        ";
    } else {
        return "
            <section class='content-container'>
                <section class='content-header clearfix'>
                    " . _get_content_header($page) . "
                </section>
                <section class='row content clearfix'>
                    <div class='col-lg-8 theme-content'>
                " . _get_message() . "
                " . $page['app_view'] . "
                    </div>
                    <div class='col-lg-4'>
                        <div id='theme-sidebar-container'>
                            <div class='theme-sidebar-top box'>
                            " . $page['page_summary'] . "
                            </div>
                        </div>
                    </div>
                </section>
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
    $framework =& get_instance();

    if (! isset($framework->session->userdata['wizard'])) {
        foreach ($page['menus'] as $route => $details) {
            if ($details['category'] == lang('base_category_my_account')) {
                $my_account .= "<div class='theme-banner-my-account-links'><a href='$route'>" . $details['title'] . "</a></div>\n";
            }
        }
    }

    if (isset($page['devel_alerts']) && count($page['devel_alerts']) > 0) {
        // TODO - Translate
        $alert_text = "
                        <ul class='dropdown-menu'>
                            <li class='header'>You have " . count($page['devel_alerts']) . " notification" . (count($page['devel_alerts']) >  1 ? "s" : "") . "</li>
        ";
         $alert_text = '';
        if (isset($page['devel_alerts']['framework']))
            $alert_text .= "
                <li>
                    <a href='#'><i class='fa fa-gears warning'></i> Framework is in development mode</a>
                </li>
            ";
        if (isset($page['devel_alerts']['app']))
            $alert_text .= "
                <li>
                    <a href='#'><i class='fa fa-cubes warning'></i> This app is using development code</a>
                </li>
            ";
        if (isset($page['devel_alerts']['theme']))
            $alert_text .= "
                <li>
                    <a href='#'><i class='fa fa-image warning'></i> Theme is in development mode</a>
                </li>
            ";
        //$alert_text .= "</ul>";
        $devel_alerts = "
                <li class='dropdown notifications-menu'>
                    <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
                        <i class='fa fa-warning'></i>
                        <span class='label label-warning'>" . count($page['devel_alerts']) . "</span>
                    </a>
                    $alert_text
                </li>
        ";
    }

    $title = $page['title']; 
    if (isset($framework->session->userdata['wizard'])) {
        $title = lang('base_wizard') . "<i class='breadcrumb-separator fa fa-arrow-circle-right'></i><span class='page-second-level'>" . $page['title'] . "</span>";
    } else {
        if ($page['title'] != $page['current_name'])
            $title = $page['current_name'] . "<i class='breadcrumb-separator fa fa-arrow-circle-right'></i><span class='page-second-level'>" . $title . "</span>";
    }
    // TODO Identify 'My Account Page
    // TODO Hard coded text below
    return "
             <header class='mainheader'>
             <div class='navbar-header'>
              <button data-target='.bs-navbar-collapse' data-toggle='collapse' type='button' class='navbar-toggle'>
                <span class='sr-only'>Toggle navigation</span>
                <span class='icon-bar'></span>
                <span class='icon-bar'></span>
                <span class='icon-bar'></span>
              </button>
            </div>
            
                <ul class='full_menu'>
                    <li class='ClearOS " . (($page['current_basename'] == '') ? "active" : "") . "'>
                        <a href='#' id='clearos-home' class='ci-ClearOS'>&nbsp;</a>
                    </li> 
                " . (! isset($framework->session->userdata['wizard']) ? "
                        <li class='dashboard " . (($page['current_basename'] == 'dashboard') ? "active" : "") . "'>
                            <a href='/app/dashboard'><i class='ci-dashboard'></i>" . lang('base_dashboard') . "</span></a>
                        </li>
                        <li class='marketplace " . (($page['current_basename'] == 'marketplace') ? "active" : "") . "'>
                            <a href='/app/marketplace'><i class='fa fa-cloud-download'></i> <span>" . lang('base_marketplace') . "</span></a>
                        </li>
                        <li class='support " . (($page['current_basename'] == 'support') ? "active" : "") . "'>
                            <a href='/app/support'><i class='ci-Clear_CARE'></i><span>" . lang('base_support') . "</span></a>
                        </li> 
                        <li class='my-account dropdown " . ($page['my_account'] ? "active" : "") . "'><a href='javascript:void(0);' class='dropdown-toggle' data-toggle='dropdown'><i class='ci-my-account'></i> <big>" . ((count($page['devel_alerts'])) > 0 ? count($page['devel_alerts']) : '') . "</big><span data-toggle='tooltip' data-placement='top' title='" . $page['username'] . "'>" . ((strlen($page['username']) > 10 ) ? substr($page['username'],0,10) . '...' : $page['username']) .  "</span></a>
                            <ul class='dropdown-menu' role='menu'>
                                 " . ((count($page['devel_alerts'])) > 0 ?  $alert_text : '') . "
                              <li class='divider'></li>
                              <li><a role='menuitem' href='/app/user_profile'>My Profile</a></li>
                              <li><a role='menuitem' href='/app/dashboard/settings'>Setting</a></li>
                              <li class='divider'></li>
                              <li><a role='menuitem' href='/app/base/session/logout'>Sign out</a></li>
                            </ul>
                          </li>
                            " : "<li></li><li></li><li></li><li></li>") . "
                    </ul>
                    <div class='ClearOS logo1 " . (($page['current_basename'] == '') ? "active" : "") . "'>
                        <a href='#' id='clearos-home' class='ci-ClearOS'>&nbsp;</a>
                    </div> 
                    <div class='small_menu hide'>
                        <ul>
                        " . (! isset($framework->session->userdata['wizard']) ? "
                                <li class='dashboard " . (($page['current_basename'] == 'dashboard') ? "active" : "") . "'>
                                    <a href='/app/dashboard'><i class='ci-dashboard'></i>" . lang('base_dashboard') . "</span></a>
                                </li>
                                <li class='marketplace " . (($page['current_basename'] == 'marketplace') ? "active":"") . "'>
                                    <a href='/app/marketplace'><i class='fa fa-cloud-download'></i> <span>" . lang('base_marketplace') . "</span></a>
                                </li>
                                <li class='support " . (($page['current_basename'] == 'support') ? "active" : "") . "'>
                                    <a href='/app/support'><i class='ci-Clear_CARE'></i><span>" . lang('base_support') . "</span></a>
                                </li> 
                                <li class='my-account dropdown " . ($page['my_account'] ? "active" : "") . "'><a href='javascript:void(0);' class='dropdown-toggle' data-toggle='dropdown'><i class='ci-my-account'></i> <big>" . ((count($page['devel_alerts'])) > 0 ? count($page['devel_alerts']) : '') . "</big><span data-toggle='tooltip' data-placement='top' title='" . $page['username']."'>" . ((strlen($page['username']) > 10 ) ? substr($page['username'],0,10) . '...' :$page['username']) . "</span></a>
                                    <ul class='dropdown-menu' role='menu'>
                                      " . ((count($page['devel_alerts'])) > 0 ?  $alert_text : '') . "
                                      <li class='divider'></li>
                                      <li><a role='menuitem' href='/app/user_profile'>My Profile</a></li>
                                      <li><a role='menuitem' href='/app/dashboard/settings'>Setting</a></li>
                                      <li class='divider'></li>
                                      <li><a role='menuitem' href='/app/base/session/logout'>Sign out</a></li>
                                    </ul>
                                  </li>
                                    " : "") . "
                            </ul>
                    </div>
                    <div class='clearfix'></div>
            </header>
            <div class='page-title'><h1>$title</h1>" . 
            (isset($page['breadcrumb_links']) ? _get_breadcrumb_links($page['breadcrumb_links']) : "") . "<div class='clearfix'></div>
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
    return "
      <!-- Footer -->
      <div class='clearfix'></div>
      <footer>Copyright &copy; 2009 - 2014 ClearCenter</footer>
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
    $menu_data = $page['wizard_menu'];
    $current_subcategory = NULL;

    foreach ($menu_data as $step_no => $menu) {
        // Determine sub-category icon to use
        if ($menu['subcategory'] == lang('base_network_settings'))
            $sub_class = 'fa fa-share-alt';
        else if ($menu['subcategory'] == lang('base_registration'))
            $sub_class = 'fa fa-pencil';
        else if ($menu['subcategory'] == lang('base_configuration'))
            $sub_class = 'fa fa-gear';
        else if ($menu['subcategory'] == lang('base_marketplace'))
            $sub_class = 'fa fa-cloud-download';
        else if ($menu['subcategory'] == lang('base_finish'))
            $sub_class = 'fa fa-tasks';
        else
            $sub_class = 'fa fa-angle-double-right';

        $disabled = '';
        if ($step_no > $page['wizard_current'])
            $disabled = 'theme-link-disabled';
        $active = '';
        if ($step_no == $page['wizard_current'])
            $active = 'active';

        if ($current_subcategory == NULL) {
            $current_subcategory = $menu['subcategory'];
            $steps .= "<li class='treeview" . ($step_no <= $page['wizard_current'] ? " active" : "") . "'>\n";
            $steps .= "\t<a href='#'><i class='$sub_class'></i><span>" . $menu['subcategory'] . "</span></a>\n";
            $steps .= "\t<ul class='treeview-menu' style='display: block;'>\n";
            $steps .= "\t\t<li class='$disabled $active'><a href='" . ($disabled != '' ? '#' : $menu['nav']) . "'>" . $menu['title'] . "</a></li>\n";
        } else if ($current_subcategory == $menu['subcategory']) {
            $steps .= "\t\t<li class='$disabled $active'><a href='" . ($disabled != '' ? '#' : $menu['nav']) . "'>" . $menu['title'] . "</a></li>\n";
        } else if ($current_subcategory != $menu['subcategory']) {
            $current_subcategory = $menu['subcategory'];
            $steps .= "\t</ul>\n";
            $steps .= "</li>\n";
            $steps .= "<li class='treeview" . ($step_no <= $page['wizard_current'] ? " active" : "") . "'>\n";
            $steps .= "\t<a href='#'><i class='$sub_class'></i><span>" . $menu['subcategory'] . "</span></a>\n";
            $steps .= "\t<ul class='treeview-menu' style='display: block;'>\n";
            $steps .= "\t\t<li class='$disabled $active'><a href='" . ($disabled != '' ? '#' : $menu['nav']) . "'>" . $menu['title'] . "</a></li>\n";
        }
    }

    // Close out open HTML tags
    //-------------------------

    $steps .= "\t\t</ul>\n";
    $steps .= "</li>\n";

    if (isset($page['theme_ClearOS-Admin']['menu']) && $page['theme_ClearOS-Admin']['menu'] == 2) {
        return "
            <aside class='left-side sidebar-offcanvas'>
                <section class='sidebar'>
                    <ul class='sidebar-menu-2'>
                        $steps
                    </ul>
                </section>
            </aside>
        ";
    } else {
        return "
            <aside class='theme-menu-1'>
                <ul class='wizard-progress'>
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
    $menu_data = $page['menus'];
    $main_apps = '';
    $spotlights = '';
    $img_path = clearos_theme_path('ClearOS-Admin') . '/img/';

    foreach ($menu_data as $url => $page_meta) {

        if ($page_meta['category'] === lang('base_category_my_account')) {
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
            $main_apps .= "<li class='"  . ($page_meta['category'] == $page['current_category'] ? " active" : "") . "'>";
            $main_apps .= "<a href='javascript:void(0);'><i class='coi-".strtolower($page_meta['category'])."'></i>";
            $main_apps .= $page_meta['category'];
            $main_apps .= "</a>";
            $main_apps .= "<ul class='sub_menu'>";
        }

        // Subcategory transition
        //-----------------------

        if ($current_subcategory != $page_meta['subcategory']) {
            $current_subcategory = $page_meta['subcategory'];

            $main_apps .= "<li class='"  . ($page_meta['subcategory'] == $page['current_subcategory'] ? " active" : "") . "'>";
            $main_apps .= "<a href='#'><span class='menu-item'>" . $page_meta['subcategory'] . "</span></a>";
            $main_apps .= "<ul class='nav nav-third-level'>";
        }

        // App page
        //---------
       // echo "<pre>";print_r($page_meta);
        $main_apps .= "<li><a href='" . $url . "'>" . htmlspecialchars($page_meta['title']) . " </a></li>";
    }

    // Close out open HTML tags
    //-------------------------

    $main_apps .= "</ul>";
    $main_apps .= "</li>";
    $main_apps .= "</ul>";
    $main_apps .= "</li>";

    return "
        <aside class='theme-menu-1'>
       " . form_open('base/search', NULL, NULL, array('class' => 'sidebar-form')) . "
            <div class='input-group'>
                <input type='text' name='g_search' id='g_search' class='form-control theme-sidebar-search' placeholder='" . lang('base_search') . "...' />
                <span class='input-group-btn'>
                    <button type='submit' name='btn_search' class='btn btn-flat'><i class='fa fa-search'></i></button>
                </span>
            </div>
        " . form_close() . "
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
    $no_of_categories = 0;

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
        if ($page_meta['category'] === lang('base_category_my_account')) {
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

        if ($page_meta['category'] != $current_category) {
            $no_of_categories++;
            $current_category = $page_meta['category'];
        }

        // Subcategory transition
        //-----------------------

        if ($current_subcategory != $page_meta['subcategory']) {
            $current_subcategory = $page_meta['subcategory'];

            $main_apps .= "\t\t\t\t<li class='theme-hidden category-" . $category_id . " treeview" . ($page['current_subcategory'] == $page_meta['subcategory'] ? " active" : "") . "'>\n";
            $main_apps .= "\t\t\t\t\t<a href='#'><i class='fa fa-angle-double-right'></i>" . $page_meta['subcategory'] . "</a>\n";
            $main_apps .= "\t\t\t\t\t<ul class='treeview-menu'" . ($page['current_subcategory'] == $page_meta['subcategory'] ? " style='display: block;'" : "") . ">\n";
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

    $percent_width = round(100 / $no_of_categories, 0, PHP_ROUND_HALF_UP);

    return "
<aside class='left-side sidebar-offcanvas'>
    <section class='sidebar'>
       " . form_open('base/search', NULL, NULL, array('class' => 'sidebar-form')) . "
            <div class='input-group'>
                <input type='text' name='g_search' id='g_search' class='form-control theme-sidebar-search' placeholder='" . lang('base_search') . "...' />
                <span class='input-group-btn'>
                    <button type='submit' name='btn_search' class='btn btn-flat'><i class='fa fa-search'></i></button>
                </span>
            </div>
        " . form_close() . "
        <div class='btn-toolbar theme-menu-2-list'>
            <form action='#' method='get' id='category-select'>
                <div class='btn-group' data-toggle='buttons'>
                    <label class='btn btn-default theme-menu-2-category' style='width: $percent_width%'>
                        <input type='radio' name='options' id='category-cloud'" . $active_category['cloud'] . ">
                        <div data-toggle='tooltip' data-container='body' title='" . lang('base_category_cloud') . "'>
                        " . file_get_contents($img_path . 'cloud.svg') . "
                        </div>
                    </label>
                    <label class='btn btn-default theme-menu-2-category' style='width: $percent_width%'>
                        <input type='radio' name='options' id='category-network'" . $active_category['network'] . ">
                        <div data-toggle='tooltip' data-container='body' title='" . lang('base_category_network') . "'>
                        " . file_get_contents($img_path . 'network.svg') . "
                        </div>
                    </label>
                    <label class='btn btn-default theme-menu-2-category' style='width: $percent_width%'>
                        <input type='radio' name='options' id='category-gateway'" . $active_category['gateway'] . ">
                        <div data-toggle='tooltip' data-container='body' title='" . lang('base_category_gateway') . "'>
                        " . file_get_contents($img_path . 'gateway.svg') . "
                        </div>
                    </label>
                    <label class='btn btn-default theme-menu-2-category' style='width: $percent_width%'>
                        <input type='radio' name='options' id='category-server'" . $active_category['server'] . ">
                        <div data-toggle='tooltip' data-container='body' title='" . lang('base_category_server') . "'>
                        " . file_get_contents($img_path . 'server.svg') . "
                        </div>
                    </label>
                    <label class='btn btn-default theme-menu-2-category' style='width: $percent_width%'>
                        <input type='radio' name='options' id='category-system'" . $active_category['system'] . ">
                        <div data-toggle='tooltip' data-container='body' title='" . lang('base_category_system') . "'>
                        " . file_get_contents($img_path . 'system.svg') . "
                        </div>
                    </label>
                    <label class='btn btn-default theme-menu-2-category' style='width: $percent_width%'>
                        <input type='radio' name='options' id='category-report'" . $active_category['report'] . ">
                        <div data-toggle='tooltip' data-container='body' title='" . lang('base_category_reports') . "'>
                        " . file_get_contents($img_path . 'reports.svg') . "
                        </div>
                    </label>
                </div>
            </form>
        </div>
        <ul class='sidebar-menu-2'>
$main_apps
        </ul>
    </section>
</aside>
";
}

/**
 * Returns breadcrumb.
 *
 * @param array $links link data
 *
 * @return string menu HTML output
 */

function _get_breadcrumb_links($links)
{
    $link_html;
    $button_grp = '';

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

        $target = '';
        if (isset($link['target'])) {
            $target = " target='" . $link['target'] . "'";
            $external_tip = "<i class=\"fa fa-external-link theme-text-icon-spacing\"></i>";
        }

        $id = 'bcrumb-' . rand(0 , 100);
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

        $link_html .= "<a href='" . $link['url'] . "' id='$id' class='$button_class " . (isset($link['class']) ? $link['class'] : "") . "'$target>
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
