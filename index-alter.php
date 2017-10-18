<?php

/**
 * Index Autoload- Alter class
 *
 * @package Index Autoload
 * @subpackage Index Autoload Alter
 */
final class IDXALD_Alter {



	// Properties
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Single class instance
	 */
	private static $instance;



	/**
	 * WPDB object reference
	 */
	private $wpdb;



	// Initialization
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Create or retrieve instance
	 */
	public static function instance() {

		// Check instance
		if (!isset(self::$instance))
			self::$instance = new self;

		// Done
		return self::$instance;
	}



	/**
	 * Constructor
	 * Set a WPDB object reference
	 */
	private function __construct() {
		global $wpdb;
		$this->wpdb =& $wpdb;
	}



	// Methods
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Check if index currently exists
	 */
	public function check() {

		// First check
		if (!$this->exists()) {

			// Create it
			$this->create();

		// Force to re-generate if exists
		} elseif (defined('IDXALD_REGENERATE') && IDXALD_REGENERATE) {

			// Remove and create it
			$this->remove();
			$this->create();
		}
	}



	/**
	 * Remove the index
	 */
	public function remove() {

	}



	// Internal
	// ---------------------------------------------------------------------------------------------------


	private function exists() {

		// Retrieve indexes
		$indexes = $this->wpdb->get_results('SHOW INDEX FROM '.esc_sql($this->wpdb->options));
		if (empty($indexes) || !is_array($indexes))
			return false;

		// Enum and check
		foreach ($indexes as $index) {

		}
	}



	/**
	 * Attemp to create the autoload index
	 */
	private function create() {

	}



}