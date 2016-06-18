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
		return isset( $settings['facebook_active'] ) && ! empty( $settings['facebook_id'] ) && ! empty( $settings['facebook_app_id'] ) && ! empty( $settings['facebook_app_secret'] );
	}

	/**
	 * Get access token.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return string
	 */
	protected function get_access_token( $settings ) {
		$url = sprintf(
			'%s/oauth/access_token?client_id=%s&client_secret=%s&grant_type=client_credentials',
			$this->api_url,
			sanitize_text_field( $settings['facebook_app_id'] ),
			sanitize_text_field( $settings['facebook_app_secret'] )
		);
		$access_token = wp_remote_get( $url, array( 'timeout' => 60 ) );

		if ( is_wp_error( $access_token ) || ( isset( $access_token['response']['code'] ) && 200 != $access_token['response']['code'] ) ) {
			return '';
		} else {
			return sanitize_text_field( $access_token['body'] );
		}
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
			$access_token = $this->get_access_token( $settings );
			$url = sprintf(
				'%s%s?fields=fan_count&%s',
				$this->api_url . 'v2.6/',
				sanitize_text_field( $settings['facebook_id'] ),
				$access_token
			);

			$this->connection = wp_remote_get( $url, array( 'timeout' => 60 ) );

			if ( is_wp_error( $this->connection ) || ( isset( $this->connection['response']['code'] ) && 200 != $this->connection['response']['code'] ) ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$_data = json_decode( $this->connection['body'], true );

				if ( isset( $_data['fan_count'] ) ) {
					$count = intval( $_data['fan_count'] );

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
		$facebook_id = ! empty( $settings['facebook_id'] ) ? $settings['facebook_id'] : '';

		return $this->get_view_li( 'https://www.facebook.com/' . $facebook_id, $total, __( 'likes', 'social-count-plus' ), $text_color, $settings );
	}
}
