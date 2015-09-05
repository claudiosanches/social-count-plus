<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus GitHub Counter.
 *
 * @package  Social_Count_Plus/GitHub_Counter
 * @category Counter
 * @author   Claudio Sanches
 */
class Social_Count_Plus_GitHub_Counter extends Social_Count_Plus_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'github';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://api.github.com/users/';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return isset( $settings['github_active'] ) && ! empty( $settings['github_username'] );
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
			$this->connection = wp_remote_get( $this->api_url . sanitize_text_field( $settings['github_username'] ), array( 'timeout' => 60 ) );

			if ( is_wp_error( $this->connection ) || 200 != $this->connection['response']['code'] ) {
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
		$github_username = ! empty( $settings['github_username'] ) ? $settings['github_username'] : '';

		return $this->get_view_li( $this->id, 'https://github.com/' . $github_username, $total, __( 'followers', 'social-count-plus' ), $text_color, $settings );
	}
}
