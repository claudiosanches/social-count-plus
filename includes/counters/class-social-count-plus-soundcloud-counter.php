<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus SoundCloud Counter.
 *
 * @package  Social_Count_Plus/SoundCloud_Counter
 * @category Counter
 * @author   Claudio Sanches
 */
class Social_Count_Plus_SoundCloud_Counter extends Social_Count_Plus_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'soundcloud';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://api.soundcloud.com/users/';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return ( isset( $settings['soundcloud_active'] ) && isset( $settings['soundcloud_username'] ) && ! empty( $settings['soundcloud_username'] ) && isset( $settings['soundcloud_client_id'] ) && ! empty( $settings['soundcloud_client_id'] ) );
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

			$this->connection = wp_remote_get( $this->api_url . $settings['soundcloud_username'] . '.json?client_id=' . $settings['soundcloud_client_id'], $params );

			if ( is_wp_error( $this->connection ) || '400' <= $this->connection['response']['code'] ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$response = json_decode( $this->connection['body'], true );

				if ( isset( $response['followers_count'] ) ) {
					$count = intval( $response['followers_count'] );

					$this->total = $count;
				} else {
					$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
				}
			}
		}

		return $this->total;
	}
}
