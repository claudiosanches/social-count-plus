<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus Google+ Counter.
 *
 * @package  Social_Count_Plus/GooglePlus_Counter
 * @category Counter
 * @author   Claudio Sanches
 */
class Social_Count_Plus_GooglePlus_Counter extends Social_Count_Plus_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'googleplus';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://www.googleapis.com/plus/v1/people/';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return ( isset( $settings['googleplus_active'] ) && isset( $settings['googleplus_id'] ) && ! empty( $settings['googleplus_id'] ) && isset( $settings['googleplus_api_key'] ) && ! empty( $settings['googleplus_api_key'] ) );
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
			$id = 'https://plus.google.com/' . $settings['googleplus_id'];

			$params = array(
				'sslverify' => false,
				'timeout'   => 60
			);

			$this->connection = wp_remote_get( $this->api_url . $settings['googleplus_id'] . '?key=' . $settings['googleplus_api_key'], $params );

			if ( is_wp_error( $this->connection ) || '400' <= $this->connection['response']['code'] ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$_data = json_decode( $this->connection['body'], true );

				if ( isset( $_data['circledByCount'] ) ) {
					$count = intval( $_data['circledByCount'] );

					$this->total = $count;
				} else {
					$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
				}
			}
		}

		return $this->total;
	}
}
