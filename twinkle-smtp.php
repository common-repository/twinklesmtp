<?php
/**
 * Plugin Name:       TwinkleSMTP
 * Plugin URI:        https://wpcommerz.com/twinklesmtp/
 * Description:       Connect email service providers with WordPress that resolves your email delivery issue.
 * Version:           1.0.3
 * Author:            twinklesmtp
 * Author URI:        https://wpcommerz.com/twinklesmtp/author.html
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       twinkle-smtp
 * Domain Path:       /languages
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

//require_once __DIR__ . '/vendor/autoload.php';


define( 'TWINKLE_SMTP_VERSION', '1.0.3' );
defined( 'TWINKLE_SMTP_PATH' ) or define( 'TWINKLE_SMTP_PATH', plugin_dir_path( __FILE__ ) );
defined( 'TWINKLE_SMTP_URL' ) or define( 'TWINKLE_SMTP_URL', plugin_dir_url( __FILE__ ) );
defined( 'TWINKLE_SMTP_BASE_FILE' ) or define( 'TWINKLE_SMTP_BASE_FILE', __FILE__ );
defined( 'TWINKLE_SMTP_BASE_PATH' ) or define( 'TWINKLE_SMTP_BASE_PATH', plugin_basename(__FILE__) );
defined( 'TWINKLE_SMTP_IMG_DIR' ) or define( 'TWINKLE_SMTP_IMG_DIR', plugin_dir_url( __FILE__ ) . 'assets/img/' );
defined( 'TWINKLE_SMTP_CSS_DIR' ) or define( 'TWINKLE_SMTP_CSS_DIR', plugin_dir_url( __FILE__ ) . 'assets/css/' );
defined( 'TWINKLE_SMTP_JS_DIR' ) or define( 'TWINKLE_SMTP_JS_DIR', plugin_dir_url( __FILE__ ) . 'assets/js/' );


require_once TWINKLE_SMTP_PATH . 'includes/TwinkleSMTPUtils.php';
require_once TWINKLE_SMTP_PATH . 'includes/TwinkleSMTPDB.php';
require_once TWINKLE_SMTP_PATH . 'backend/class-twinkle-smtp-ajax.php';
require_once TWINKLE_SMTP_PATH . 'backend/class-twinkle-smtp-admin.php';

  // Plugin deactivation hook
  register_deactivation_hook(__FILE__,  'pluginDeactivate');

  

  function pluginDeactivate(){
      $timestamp = wp_next_scheduled('deletelog_cron_hook');
      wp_unschedule_event($timestamp, 'deletelog_cron_hook');  
  }

