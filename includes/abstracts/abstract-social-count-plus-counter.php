<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Social Count Plus Counter.
 *
 * @package  Social_Count_Plus/Abstracts
 * @category Abstract
 * @author   Claudio Sanches
 */
abstract class Social_Count_Plus_Counter {

	/**
	 * Total count.
	 *
	 * @var int
	 */
	protected $total = 0;

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = '';

	/**
	 * Connection.
	 *
	 * @var WP_Error|array
	 */
	protected $connection = array();

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return false;
	}

	/**
	 * Get the total.
	 *
	 * @param  array $settings Plugin settings.
	 * @param  array $cache    Counter cache.
	 *
	 * @return int
	 */
	public function get_total( $settings, $cache ) {
		return $this->total;
	}

	public function debug() {
		return $this->connection;
	}
}
