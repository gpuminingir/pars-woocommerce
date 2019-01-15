<?php
/*
Karbo for WooCommerce
https://github.com/Karbovanets/karbo-woocommerce/
*/

//---------------------------------------------------------------------------
// Global definitions
if (!defined('PARSWC_PLUGIN_NAME'))
  {
  define('PARSWC_VERSION',           '1.0');

  //-----------------------------------------------
  define('PARSWC_EDITION',           'Standard');    

  //-----------------------------------------------
  define('PARSWC_SETTINGS_NAME',     'PARSWC-Settings');
  define('PARSWC_PLUGIN_NAME',       'ParsiCoin for WooCommerce');   


  // i18n plugin domain for language files
  define('PARSWC_I18N_DOMAIN',       'parswc');

  }
//---------------------------------------------------------------------------

//------------------------------------------
// Load wordpress for POSTback, WebHook and API pages that are called by external services directly.
if (defined('PARSWC_MUST_LOAD_WP') && !defined('WP_USE_THEMES') && !defined('ABSPATH'))
   {
   $g_blog_dir = preg_replace ('|(/+[^/]+){4}$|', '', str_replace ('\\', '/', __FILE__)); // For love of the art of regex-ing
   define('WP_USE_THEMES', false);
   require_once ($g_blog_dir . '/wp-blog-header.php');

   // Force-elimination of header 404 for non-wordpress pages.
   header ("HTTP/1.1 200 OK");
   header ("Status: 200 OK");

   require_once ($g_blog_dir . '/wp-admin/includes/admin.php');
   }
//------------------------------------------


// This loads necessary modules
require_once (dirname(__FILE__) . '/libs/forknoteWalletdAPI.php');

require_once (dirname(__FILE__) . '/parswc-cron.php');
require_once (dirname(__FILE__) . '/parswc-utils.php');
require_once (dirname(__FILE__) . '/parswc-admin.php');
require_once (dirname(__FILE__) . '/parswc-render-settings.php');
require_once (dirname(__FILE__) . '/parswc-parsicoin-gateway.php');

?>