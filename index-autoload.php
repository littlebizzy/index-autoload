<?php
/*
Plugin Name: Index Autoload
Plugin URI: https://www.littlebizzy.com/plugins/index-autoload
Description: Adds an index to the autoload in wp_options table and verifies it exists on a daily basis (using WP Cron), resulting in a more efficient database.
Version: 1.0.3
Author: LittleBizzy
Author URI: https://www.littlebizzy.com
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.txt
Prefix: IDXALD
*/



/**
 * Plugin initialization
 */

// Avoid script calls via plugin URL
if (!function_exists('add_action'))
	die;

// This plugin constants
define('IDXALD_FILE', __FILE__);
define('IDXALD_PATH', dirname(IDXALD_FILE));
define('IDXALD_VERSION', '1.0.3');



/**
 * Initial index check
 */

// Register action for init hook
add_action('init', 'idxald_init');

// Handle WP init hook
function idxald_init() {

	// Check timestamp
	$timestamp = (int) get_option('idxald_timestamp');
	if (empty($timestamp) || (time() - $timestamp) > 86400) {

		// Clean old plugin data
		if (empty($timestamp)) {
			delete_option('index_autoload_active');
			wp_clear_scheduled_hook('index_autoload_cron');
		}

		// Updates timestamp
		update_option('idxald_timestamp', time(), true);

		// Check schedule
		if (false === wp_next_scheduled('idxald_index_check'))
			wp_schedule_single_event(time() + 30, 'idxald_index_check');
	}
}



/**
 * WP-CRON triggered hook
 */

// Action for custom hook
add_action('idxald_index_check', 'idxald_index_check');

// Executes the scheduled action
function idxald_index_check() {
	require_once IDXALD_PATH.'/index-alter.php';
	IDXALD_Alter::instance()->check();
}



/**
 * Deactivation plugin hook
 */

// Deactivation WP hook
register_deactivation_hook(__FILE__, 'idxald_index_deactivation');

// Triggered on deactivation
function idxald_index_deactivation() {
	wp_clear_scheduled_hook('idxald_index_check');
}



/**
 * Uninstall plugin hook
 */

// Uninstall WP hook
register_uninstall_hook(__FILE__, 'idxald_index_uninstall');

// Triggered on uninstall
function idxald_index_uninstall() {

	// Remove the index
	require_once IDXALD_PATH.'/index-alter.php';
	IDXALD_Alter::instance()->remove();

	// Removes options and cron hooks
	delete_option('idxald_timestamp');
	wp_clear_scheduled_hook('idxald_index_check');
}
