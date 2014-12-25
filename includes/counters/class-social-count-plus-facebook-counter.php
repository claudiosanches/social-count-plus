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
	protected $api_url = 'https://graph.facebook.com/';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return ( isset( $settings['facebook_active'] ) && isset( $settings['facebook_id'] ) && ! empty( $settings['facebook_id'] ) );
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
			$params = array(
				'sslverify' => false,
				'timeout'   => 60
			);

			$this->connection = wp_remote_get( $this->api_url . $settings['facebook_id'], $params );

			if ( is_wp_error( $this->connection ) ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$_data = json_decode( $this->connection['body'], true );

				if ( isset( $_data['likes'] ) ) {
					$count = intval( $_data['likes'] );

					$this->total = $count;
				} else {
					$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
				}
			}
		}

		return $this->total;
	}
}
