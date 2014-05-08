<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus Facebook Counter.
 *
 * @package  Social_Count_Plus/Facebook_Counter
 * @category Counter
 * @author   Claudio Sanches
 */
class Social_Count_Plus_Facebook_Counter extends Social_Count_Plus_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'facebook';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'http://graph.facebook.com/';

	/**
	 * Get the total.
	 *
	 * @param  array $settings Plugin settings.
	 * @param  array $cache    Counter cache.
	 *
	 * @return int
	 */
	public function get_total( $settings, $cache ) {
		if (
			isset( $settings['facebook_active'] )
			&& isset( $settings['facebook_id'] )
			&& ! empty( $settings['facebook_id'] )
		) {

			// Get facebook data.
			$facebook_data = wp_remote_get( $this->api_url . $settings['facebook_id'] );

			if ( is_wp_error( $facebook_data ) ) {
				$this->total = ( isset( $cache['facebook'] ) ) ? $cache['facebook'] : 0;
			} else {
				$facebook_response = json_decode( $facebook_data['body'], true );

				if ( isset( $facebook_response['likes'] ) ) {
					$facebook_count = intval( $facebook_response['likes'] );

					$this->total = $facebook_count;
				} else {
					$this->total = ( isset( $cache['facebook'] ) ) ? $cache['facebook'] : 0;
				}
			}
		}

		return $this->total;
	}
}
