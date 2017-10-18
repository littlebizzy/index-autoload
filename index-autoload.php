<?php
/*
Plugin Name: Index Autoload
Plugin URI: https://www.littlebizzy.com/plugins/index-autoload
Description: Adds an index to the autoload in wp_options table via WP-Cron on a daily basis, resulting in a more efficient database and faster site performance.
Version: 1.0.3
Author: LittleBizzy
Author URI: https://www.littlebizzy.com
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.txt
*/

// Avoid script calls via plugin URL
if (!function_exists('add_action'))
	die;

// This plugin constants
define('IDXALD_FILE', __FILE__);
define('IDXALD_PATH', dirname(IDXALD_FILE));
define('IDXALD_VERSION', '1.0.3');

/* Init index check */
add_action('init', 'idxald_init');
function idxald_init() {
do_action('idxald_index_check');return;
	$timestamp = (int) get_option('idxald_timestamp');
	if (empty($timestamp) || (time() - $timestamp) > 86400) {
		update_option('idxald_timestamp', time(), true);
		if (false === wp_next_scheduled('idxald_index_check'))
			wp_schedule_single_event(time() + 30, 'idxald_index_check');
	}
}

add_action('idxald_index_check', 'idxald_index_check');
function idxald_index_check() {
	require_once IDXALD_PATH.'/index-alter.php';
	IDXALD_Alter::instance()->check();
}

register_uninstall_hook(__FILE__, 'idxald_index_uninstall');
function idxald_index_uninstall() {
	require_once IDXALD_PATH.'/index-alter.php';
	IDXALD_Alter::instance()->remove();
	delete_option('idxald_timestamp');
}





return;
/**
* This function fires the ADD INDEX AUTOLOAD query once a day.
**/
function index_autoload_execute_query() {
  global $wpdb;
  $prefix = $wpdb->prefix;
  $options_table = $prefix . 'options';
  $query_drop = "ALTER TABLE " . $options_table . " DROP INDEX autoload (autoload);";
  $query_add = "ALTER TABLE " . $options_table . " ADD INDEX autoload (autoload);";
  $wpdb->get_results( $query_drop );
  $wpdb->get_results( $query_add );
}
add_action( 'index_autoload_cron', 'index_autoload_execute_query' );

/**
* Define a custom cron schedule based on the IDXAUTOLOAD_SCHEDULE constant.
**/
function index_autoload_custom_schedule( $schedules ) {

  if( get_option('index_autoload_active') !== 'true' ) return false;

  if( IDXAUTOLOAD_SCHEDULE <> '' && is_numeric( IDXAUTOLOAD_SCHEDULE ) ) {
    $schedules['index_autoload_schedule'] = array(
      'interval' => IDXAUTOLOAD_SCHEDULE,
      'display' => __( 'Index Autoload Schedule' )
    );
  }
  return $schedules;
}
add_filter( 'cron_schedules', 'index_autoload_custom_schedule' );

/**
* Reschedule the cron if the IDXAUTOLOAD_SCHEDULE constant is defined. If it's been removed, go back to "daily" schedule.
**/
function index_autoload_reschedule() {

  if( get_option('index_autoload_active') !== 'true' ) return false;

  if( wp_next_scheduled( 'index_autoload_cron' ) ) {
    $schedule = wp_get_schedule( 'index_autoload_cron' );
    if( is_int( IDXAUTOLOAD_SCHEDULE ) && IDXAUTOLOAD_SCHEDULE <> '' ) {
      if( $schedule <> 'index_autoload_schedule' ) {
        wp_unschedule_event( 'index_autoload_cron' );
        wp_clear_scheduled_hook( 'index_autoload_cron' );
        wp_reschedule_event( time(), 'index_autoload_schedule', 'index_autoload_cron' );
      }
    }
    else if( $schedule === 'index_autoload_schedule' ) {
      wp_unschedule_event( 'index_autoload_cron' );
      wp_clear_scheduled_hook( 'index_autoload_cron' );
      wp_reschedule_event( time(), 'daily', 'index_autoload_cron' );
    }
  }
}
add_action( 'init', 'index_autoload_reschedule', 999 );

/**
* Runs on plugin activation setting up a wp-cron job.
**/
function index_autoload_activate() {

  global $wpdb;
  $version_object = $wpdb->get_results("SELECT VERSION()");
  if( isset( $version_object[0] ) )
  $version = $version_object[0]->{"VERSION()"};
  else $version = 0;

  if( (float) $version < 5.5 ) return false;

  $options_table = $wpdb->prefix . 'options';
  $get_status_query = "SHOW TABLE STATUS WHERE Name = '".$options_table."'";
  $get_status = $wpdb->get_results( $get_status_query );
  if( isset( $get_status[0] ) ) $storage_engine = $get_status[0]->Engine;
  else $storage_engine = "";

  if( $storage_engine <> 'InnoDB' ) return false;

  if( !wp_next_scheduled( 'index_autoload_cron' ) ) {
    add_option( 'index_autoload_active', 'true' );
    wp_schedule_event( time(), 'daily', 'index_autoload_cron' );
  }
}
register_activation_hook( __FILE__, 'index_autoload_activate' );

/**
* Runs on plugin deactivation. Removes the cron job.
**/
function index_autoload_deactivate() {
  if( wp_next_scheduled( 'index_autoload_cron' ) ) {
    wp_unschedule_event( 'index_autoload_cron' );
    wp_clear_scheduled_hook( 'index_autoload_cron' );
  }
  if( get_option( 'index_autoload_active' ) )
  delete_option( 'index_autoload_active' );
}
register_deactivation_hook( __FILE__, 'index_autoload_deactivate' );
