<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus Comments Counter.
 *
 * @package  Social_Count_Plus/Comments_Counter
 * @category Counter
 * @author   Claudio Sanches
 */
class Social_Count_Plus_Comments_Counter extends Social_Count_Plus_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'comments';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = '';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return ( isset( $settings['comments_active'] ) );
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
		if ( $this->is_available( $settings ) ) {
			$data = wp_count_comments();

			if ( is_wp_error( $data ) ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$count = intval( $data->approved );

				$this->total = $count;
			}
		}

		return $this->total;
	}
}
