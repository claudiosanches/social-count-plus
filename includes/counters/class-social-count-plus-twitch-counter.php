<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus Twitch Counter.
 *
 * @package  Social_Count_Plus/Twitch_Counter
 * @category Counter
 * @author   Claudio Sanches
 */
class Social_Count_Plus_Twitch_Counter extends Social_Count_Plus_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'twitch';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://api.twitch.tv/kraken/channels/';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return isset( $settings['twitch_active'] ) && ! empty( $settings['twitch_username'] );
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
				'timeout' => 60,
				'headers' => array(
					'accept' => 'application/vnd.twitchtv.v3+json'
				)
			);

			$this->connection = wp_remote_get( $this->api_url . sanitize_text_field( $settings['twitch_username'] ), $params );

			if ( is_wp_error( $this->connection ) || ( isset( $this->connection['response']['code'] ) && 200 != $this->connection['response']['code'] ) ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$_data = json_decode( $this->connection['body'], true );

				if ( isset( $_data['followers'] ) ) {
					$count = intval( $_data['followers'] );

					$this->total = $count;
				} else {
					$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
				}
			}
		}

		return $this->total;
	}

	/**
	 * Get conter view.
	 *
	 * @param  array  $settings   Plugin settings.
	 * @param  int    $total      Counter total.
	 * @param  string $text_color Text color.
	 *
	 * @return string
	 */
	public function get_view( $settings, $total, $text_color ) {
		$twitch_username = ! empty( $settings['twitch_username'] ) ? $settings['twitch_username'] : '';

		return $this->get_view_li( 'http://www.twitch.tv/' . $twitch_username . '/profile', $total, __( 'followers', 'social-count-plus' ), $text_color, $settings );
	}
}
