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
	public static function get_count() {
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
			'Social_Count_Plus_Comments_Counter',
			'Social_Count_Plus_Facebook_Counter',
			'Social_Count_Plus_GitHub_Counter',
			'Social_Count_Plus_GooglePlus_Counter',
			'Social_Count_Plus_Instagram_Counter',
			'Social_Count_Plus_LinkedIn_Counter',
			'Social_Count_Plus_Pinterest_Counter',
			'Social_Count_Plus_Posts_Counter',
			'Social_Count_Plus_SoundCloud_Counter',
			'Social_Count_Plus_Steam_Counter',
			'Social_Count_Plus_Tumblr_Counter',
			'Social_Count_Plus_Twitch_Counter',
			'Social_Count_Plus_Twitter_Counter',
			'Social_Count_Plus_Users_Counter',
			'Social_Count_Plus_Vimeo_Counter',
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
	 */
	public static function delete_count() {
		delete_transient( self::$transient );
	}

	/**
	 * Reset the counters.
	 */
	public static function reset_count() {
		self::delete_count();
		self::get_count();
	}
}
