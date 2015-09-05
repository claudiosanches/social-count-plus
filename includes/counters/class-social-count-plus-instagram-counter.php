<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus Instagram Counter.
 *
 * @package  Social_Count_Plus/Instagram_Counter
 * @category Counter
 * @author   Claudio Sanches
 */
class Social_Count_Plus_Instagram_Counter extends Social_Count_Plus_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'instagram';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://api.instagram.com/v1/users/';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return ( isset( $settings['instagram_active'] ) && ! empty( $settings['instagram_user_id'] ) && ! empty( $settings['instagram_access_token'] ) );
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
			$this->connection = wp_remote_get( $this->api_url . $settings['instagram_user_id'] . '/?access_token=' . $settings['instagram_access_token'], array( 'timeout' => 60 ) );

			if ( is_wp_error( $this->connection ) || '400' <= $this->connection['response']['code'] ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$response = json_decode( $this->connection['body'], true );

				if (
					isset( $response['meta']['code'] )
					&& 200 == $response['meta']['code']
					&& isset( $response['data']['counts']['followed_by'] )
				) {
					$count = intval( $response['data']['counts']['followed_by'] );

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
		$instagram_username = ! empty( $settings['instagram_username'] ) ? $settings['instagram_username'] : '';

		return $this->get_view_li( $this->id, 'https://instagram.com/' . $instagram_username, $total, __( 'followers', 'social-count-plus' ), $text_color, $settings );
	}
}
