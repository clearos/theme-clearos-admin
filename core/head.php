<?php
/**
 * Head tags handler for the theme.
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

/**
 * Returns additional <head> data required for the theme.
 *
 * @param string $settings custom theme settings
 *
 * @return string HTML output
 */

function theme_page_head($settings)
{
    $framework =& get_instance();
    $theme_url = clearos_theme_url('ClearOS-Admin');
	$basepath = preg_replace('/\/core\/.*/', '', realpath(__FILE__));

    // The version is used to avoid upgrade/caching issues.  Bump when required.
    $version = '7.0.0';

    // Note: <meta> tags are in the meta.php file

    $version_theme_override = '';
    if (preg_match('/professional/i', $framework->session->userdata['os_name']))
        $version_theme_override = "<link rel='stylesheet' type='text/css' media='screen' href='$theme_url/css/theme-pro.css'>";
    else if (preg_match('/home/i', $framework->session->userdata['os_name']))
        $version_theme_override = "<link rel='stylesheet' type='text/css' media='screen' href='$theme_url/css/theme-home.css'>";
    else if (preg_match('/hosted/i', $framework->session->userdata['os_name']))
        $version_theme_override = "<link rel='stylesheet' type='text/css' media='screen' href='$theme_url/css/theme-hosted.css'>";
    
    return "
<!-- Basic Styles -->
<!-- Theme Styles -->
<link rel='stylesheet' type='text/css' media='screen' href='$theme_url/css/bootstrap.css?v=3.0'>
<link rel='stylesheet' type='text/css' media='screen' href='$theme_url/css/fontawesome.css?v=4.2.0'>
<link rel='stylesheet' type='text/css' media='screen' href='$theme_url/css/theme.css'>
$version_theme_override
<link rel='stylesheet' type='text/css' media='screen' href='$theme_url/css/colorpicker/bootstrap-colorpicker.min.css'>
<link rel='stylesheet' type='text/css' media='screen' href='$theme_url/css/lightbox.css'>


<!-- FAVICONS -->
<link rel='shortcut icon' href='$theme_url/img/favicon.ico' type='image/x-icon'>
<link rel='icon' href='$theme_url/img/favicon.ico' type='image/x-icon'>

";
}
