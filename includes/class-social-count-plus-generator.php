<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus Generator.
 *
 * @package  Social_Count_Plus/Generator
 * @category Generator
 * @author   Claudio Sanches
 */
class Social_Count_Plus_Generator {

	/**
	 * Transient name.
	 *
	 * @var string
	 */
	public static $transient = 'socialcountplus_counter';

	/**
	 * Cache option name.
	 *
	 * @var string
	 */
	public static $cache = 'socialcountplus_cache';

	/**
	 * Update the counters.
	 *
	 * @return array
	 */
	public static function update() {
		// Get transient.
		$total = get_transient( self::$transient );

		// Test transient if exist.
		if ( false != $total ) {
			return $total;
		}

		$total    = array();
		$settings = get_option( 'socialcountplus_settings' );
		$cache    = get_option( self::$cache );
		$counters = apply_filters( 'social_count_plus_counters', array(
			'Social_Count_Plus_Twitter_Counter',
			'Social_Count_Plus_Facebook_Counter',
			'Social_Count_Plus_YouTube_Counter',
		) );

		foreach ( $counters as $counter ) {
			$_counter = new $counter();
			$total[ $_counter->id ] = $_counter->get_total( $settings, $cache );
		}

		// Update plugin extra cache.
		update_option( self::$cache, $total );

		// Update counter transient.
		set_transient( self::$transient, $total, apply_filters( 'social_count_plus_transient_time', 60*60*24 ) ); // 24 hours.

		return $total;
	}

	/**
	 * Delete the counters.
	 *
	 * @return void
	 */
	public static function delete() {
		delete_transient( self::$transient );
	}

	/**
	 * Reset the counters.
	 *
	 * @return void
	 */
	public static function reset() {
		self::delete();
		self::update();
	}

}
