<?php
/*
Plugin Name: Index Autoload
Plugin URI: https://www.littlebizzy.com/plugins/index-autoload
Description: Adds an index to the autoload in wp_options table via WP-Cron on a daily basis, resulting in a more efficient database and faster site performance.
Version: 1.0.0
Author: LittleBizzy
Author URI: https://www.littlebizzy.com
License: GPL3
License URI: http://www.gnu.org/licenses/gpl-3.0.txt
*/

/**
* This function fires the ADD INDEX AUTOLOAD query once a day.
**/
function index_autoload_execute_query() {
  global $wpdb;
  $prefix = $wpdb->prefix;
  $options_table = $prefix . 'options';
  $query_string = "ALTER TABLE " . $options_table . " ADD INDEX autoload (autoload);";
  $wpdb->get_results( $query_string );
}
add_action( 'index_autoload_cron', 'index_autoload_execute_query' );

/**
* Runs on plugin activation setting up a wp-cron job.
**/
function index_autoload_activate() {
  if( !wp_next_scheduled( 'index_autoload_cron' ) ) {
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
}
register_deactivation_hook( __FILE__, 'index_autoload_deactivate' );