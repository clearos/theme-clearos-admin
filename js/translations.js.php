<?php

/**
 * Javascript helper for site-wide access.
 *
 * @category   Apps
 * @package    framework
 * @subpackage Javascript
 * @author     ClearCenter <developer@clearcenter.com>
 * @copyright  2011-2014 ClearCenter
 * @license    http://www.clearcenter.com/Company/terms.html ClearSDN license
 * @link       http://www.clearcenter.com/support/documentation/clearos/system_monitor/
 */

///////////////////////////////////////////////////////////////////////////////
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

///////////////////////////////////////////////////////////////////////////////
// B O O T S T R A P
///////////////////////////////////////////////////////////////////////////////

$bootstrap = getenv('CLEAROS_BOOTSTRAP') ? getenv('CLEAROS_BOOTSTRAP') : '/usr/clearos/framework/shared';
require_once $bootstrap . '/bootstrap.php';

clearos_load_language('base');
clearos_load_language('marketplace');

header('Content-Type: application/x-javascript');

echo "
// Globally defined object for changing the way the SDN auth dialog handles
var UNIT = [];
UNIT[0] = '';
UNIT[9] = '';
UNIT[100] = '" . lang('marketplace_monthly') . "';
UNIT[1000] = '" . lang('marketplace_1_year') . "';
UNIT[2000] = '" . lang('marketplace_2_year') . "';
UNIT[3000] = '" . lang('marketplace_3_year') . "';
var lang_yes = '" . lang("base_yes") . "';
var lang_no = '" . lang("base_no") . "';
var lang_gb = '" . lang("base_gigabytes") . "';
var lang_ghz = '" . lang("base_gigahertz") . "';
var lang_disk = '" . lang("base_disk") . "';
var lang_cpu_vt = '" . lang("base_cpu_vt") . "';
var lang_ram = '" . lang("base_ram") . "';
var lang_cancel = '" . lang("base_cancel") . "';
var lang_cpu_cores = '" . lang("base_cpu_cores") . "';
var lang_close = '" . lang("base_close") . "';
var lang_authenticate = '" . lang("base_authenticate") . "';
var lang_sdn_authentication_required = '" . lang("base_sdn_authentication_required") . "';
var lang_sdn_authentication_required_help = '" . lang("base_sdn_authentication_required_help") . "';
var lang_username = '" . lang("base_username") . "';
var lang_password = '" . lang("base_password") . "';
var lang_forgot_password = '" . lang("base_forgot_password") . "';
var lang_sdn_email = '" . lang("base_sdn_email") . "';
var lang_sdn_password_invalid = '" . lang("base_sdn_password_invalid") . "';
var lang_login = '" . lang("base_login") . "';
var lang_success = '" . lang("base_success") . "';
var lang_reset_password_and_send = '" . lang("base_reset_password_and_send") . "';
var lang_sdn_email_invalid = '" . lang("base_sdn_email_invalid") . "';
var lang_sdn_email_mismatch = '" . lang("base_sdn_email_mismatch") . "';
var lang_sdn_password_reset = '" . lang("base_sdn_password_reset") . "';
var lang_status = '" . lang('base_status') . "';
var lang_install = '" . lang('base_install') . "';
var lang_uninstall = '" . lang('base_uninstall') . "';
var lang_configure = '" . lang('base_configure') . "';
var lang_internet_down = '" . lang('base_check_internet_connection') . "';
var lang_installed = '" . lang('base_installed') . "';
var lang_marketplace_connection_failure = '" . lang('marketplace_connection_failure') . "';
var lang_marketplace_redemption = '" . lang('marketplace_redemption') . "';
var lang_min_hardware_requirements = '" . lang('base_min_hardware_requirements') . "';
var lang_more_info = '" . lang('marketplace_more_info') . "';
var lang_marketplace_expired_no_subscription = '" . lang('marketplace_expired_no_subscription') . "';
var lang_marketplace_billing_cycle_monthly = '" . lang('marketplace_billing_cycle_monthly') . "';
var lang_marketplace_billing_cycle_yearly = '" . lang('marketplace_billing_cycle_yearly') . "';
var lang_marketplace_billing_cycle_2_years = '" . lang('marketplace_billing_cycle_2_years') . "';
var lang_marketplace_billing_cycle_3_years = '" . lang('marketplace_billing_cycle_3_years') . "';
var lang_marketplace_billing_cycle_4_years = '" . lang('marketplace_billing_cycle_4_years') . "';
var lang_marketplace_billing_cycle_5_years = '" . lang('marketplace_billing_cycle_5_years') . "';
var lang_marketplace_billing_cycle = '" . lang('marketplace_billing_cycle') . "';
var lang_marketplace_renewal_date = '" . lang('marketplace_renewal_date') . "';
var lang_marketplace_upgrade = '" . lang('marketplace_upgrade') . "';
var lang_marketplace_free = '" . lang('marketplace_free') . "';
var lang_marketplace_purchase = '" . lang('marketplace_purchase') . "';
var lang_marketplace_trial_ended= '" . lang('marketplace_trial_ended') . "';
var lang_marketplace_activate = '" . lang('marketplace_activate') . "';
var lang_marketplace_select_for_install = '" . lang('marketplace_select_for_install') . "';
var lang_marketplace_subscription_expired = '" . lang('marketplace_subscription_expired') . "';
var lang_marketplace_remove = '" . lang('marketplace_remove') . "';
var lang_marketplace_sidebar_recommended_apps = '" . lang('marketplace_sidebar_recommended_apps') . "';
var lang_marketplace_recommended_apps = '" . lang('marketplace_recommended_apps') . "';
var lang_marketplace_evaluation = '" . lang('marketplace_evaluation') . "';
var lang_marketplace_trial_ends = '" . lang('marketplace_trial_ends') . "';
var lang_marketplace_search_marketplace = '" . lang('marketplace_search_marketplace') . "';
var lang_marketplace_search_no_results = '" . lang('marketplace_search_no_results') . "';
var lang_marketplace_eval_limitations = '" . lang('marketplace_eval_limitations') . "';
var lang_marketplace_support_1_title = '" . lang('marketplace_support_1_title') . "';
var lang_marketplace_support_2_title = '" . lang('marketplace_support_2_title') . "';
var lang_marketplace_support_4_title = '" . lang('marketplace_support_4_title') . "';
var lang_marketplace_support_8_title = '" . lang('marketplace_support_8_title') . "';
var lang_marketplace_support_16_title = '" . lang('marketplace_support_16_title') . "';
var lang_marketplace_support_1_description = '" . lang('marketplace_support_1_description') . "';
var lang_marketplace_support_2_description = '" . lang('marketplace_support_2_description') . "';
var lang_marketplace_support_4_description = '" . lang('marketplace_support_4_description') . "';
var lang_marketplace_support_8_description = '" . lang('marketplace_support_8_description') . "';
var lang_marketplace_support_16_description = '" . lang('marketplace_support_16_description') . "';
var lang_marketplace_support_policy = '" . lang('marketplace_support_policy') . "';
var lang_marketplace_support_legend = '" . lang('marketplace_support_legend') . "';
var lang_marketplace_learn_more = '" . lang('marketplace_learn_more') . "';
var lang_marketplace_sdn_account_setup_help_1 = '" . lang("marketplace_sdn_account_setup_help_1") . "';
var lang_marketplace_sdn_account_setup_help_2 = '" . lang("marketplace_sdn_account_setup_help_2") . "';
var lang_marketplace_sdn_account_setup = '" . lang('marketplace_sdn_account_setup') . "';
var lang_marketplace_setup_payment_on_clear = '" . lang('marketplace_setup_payment_on_clear') . "';
var lang_marketplace_displaying = '" . lang('marketplace_displaying') . "';
var lang_of = '" . lang("base_of") . "';
var lang_warning = '" . lang("base_warning") . "';
var lang_information = '" . lang("base_information") . "';
var lang_menu_no_access = '" . lang("base_menu_no_access") . "';

";
// vim: syntax=javascript ts=4
