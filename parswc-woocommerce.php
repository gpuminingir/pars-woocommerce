<?php
/*

Plugin Name: ParsiCoin for WooCommerce
Plugin URI: https://github.com/parsicoin/pars-woocommerce/
Description: ParsiCoin for WooCommerce plugin allows you to accept payments in ParsiCoins for physical and digital products at your WooCommerce-powered online store.
Version: 1.0
License: BipCot NoGov Software License bipcot.org

*/


// Include everything
include (dirname(__FILE__) . '/parswc-include-all.php');

//---------------------------------------------------------------------------
// Add hooks and filters

// create custom plugin settings menu
add_action( 'admin_menu',                   'PARSWC_create_menu' );

register_activation_hook(__FILE__,          'PARSWC_activate');
register_deactivation_hook(__FILE__,        'PARSWC_deactivate');
register_uninstall_hook(__FILE__,           'PARSWC_uninstall');

add_filter ('cron_schedules',               'PARSWC__add_custom_scheduled_intervals');
add_action ('PARSWC_cron_action',             'PARSWC_cron_job_worker');     // Multiple functions can be attached to 'PARSWC_cron_action' action

PARSWC_set_lang_file();
//---------------------------------------------------------------------------

//===========================================================================
// activating the default values
function PARSWC_activate()
{
    global  $g_PARSWC__config_defaults;

    $parswc_default_options = $g_PARSWC__config_defaults;

    // This will overwrite default options with already existing options but leave new options (in case of upgrading to new version) untouched.
    $parswc_settings = PARSWC__get_settings ();

    foreach ($parswc_settings as $key=>$value)
    	$parswc_default_options[$key] = $value;

    update_option (PARSWC_SETTINGS_NAME, $parswc_default_options);

    // Re-get new settings.
    $parswc_settings = PARSWC__get_settings ();

    // Create necessary database tables if not already exists...
    PARSWC__create_database_tables ($parswc_settings);
    PARSWC__SubIns ();

    //----------------------------------
    // Setup cron jobs

    if ($parswc_settings['enable_soft_cron_job'] && !wp_next_scheduled('PARSWC_cron_action'))
    {
    	$cron_job_schedule_name = $parswc_settings['soft_cron_job_schedule_name'];
    	wp_schedule_event(time(), $cron_job_schedule_name, 'PARSWC_cron_action');
    }
    //----------------------------------

}
//---------------------------------------------------------------------------
// Cron Subfunctions
function PARSWC__add_custom_scheduled_intervals ($schedules)
{
	$schedules['seconds_30']     = array('interval'=>30,     'display'=>__('Once every 30 seconds'));
	$schedules['minutes_1']      = array('interval'=>1*60,   'display'=>__('Once every 1 minute'));
	$schedules['minutes_2.5']    = array('interval'=>2.5*60, 'display'=>__('Once every 2.5 minutes'));
	$schedules['minutes_5']      = array('interval'=>5*60,   'display'=>__('Once every 5 minutes'));

	return $schedules;
}
//---------------------------------------------------------------------------
//===========================================================================

//===========================================================================
// deactivating
function PARSWC_deactivate ()
{
    // Do deactivation cleanup. Do not delete previous settings in case user will reactivate plugin again...

    //----------------------------------
    // Clear cron jobs
    wp_clear_scheduled_hook ('PARSWC_cron_action');
    //----------------------------------
}
//===========================================================================

//===========================================================================
// uninstalling
function PARSWC_uninstall ()
{
    $parswc_settings = PARSWC__get_settings();

    if ($parswc_settings['delete_db_tables_on_uninstall'])
    {
        // delete all settings.
        delete_option(PARSWC_SETTINGS_NAME);

        // delete all DB tables and data.
        PARSWC__delete_database_tables ();
    }
}
//===========================================================================

//===========================================================================
function PARSWC_create_menu()
{

    // create new top-level menu
    // http://www.fileformat.info/info/unicode/char/e3f/index.htm
    add_menu_page (
        __('Woo ParsiCoin', PARSWC_I18N_DOMAIN),                    // Page title
        __('ParsiCoin', PARSWC_I18N_DOMAIN),                        // Menu Title - lower corner of admin menu
        'administrator',                                        // Capability
        'parswc-settings',                                        // Handle - First submenu's handle must be equal to parent's handle to avoid duplicate menu entry.
        'PARSWC__render_general_settings_page',                   // Function
        plugins_url('/images/parsicoin_16x.png', __FILE__)      // Icon URL
        );

    add_submenu_page (
        'parswc-settings',                                        // Parent
        __("WooCommerce ParsiCoin Gateway", PARSWC_I18N_DOMAIN),                   // Page title
        __("General Settings", PARSWC_I18N_DOMAIN),               // Menu Title
        'administrator',                                        // Capability
        'parswc-settings',                                        // Handle - First submenu's handle must be equal to parent's handle to avoid duplicate menu entry.
        'PARSWC__render_general_settings_page'                    // Function
        );

}
//===========================================================================

//===========================================================================
// load language files
function PARSWC_set_lang_file()
{
    # set the language file
    $currentLocale = get_locale();
    if(!empty($currentLocale))
    {
        $moFile = dirname(__FILE__) . "/lang/" . $currentLocale . ".mo";
        if (@file_exists($moFile) && is_readable($moFile))
        {
            load_textdomain(PARSWC_I18N_DOMAIN, $moFile);
        }

    }
}
//===========================================================================

