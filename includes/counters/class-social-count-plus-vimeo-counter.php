<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus Vimeo Counter.
 *
 * @package  Social_Count_Plus/Vimeo_Counter
 * @category Counter
 * @author   Claudio Sanches
 */
class Social_Count_Plus_Vimeo_Counter extends Social_Count_Plus_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'vimeo';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://vimeo.com/api/v2/%s/info.json';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return isset( $settings['vimeo_active'] ) && ! empty( $settings['vimeo_username'] );
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
			$this->connection = wp_remote_get( sprintf( $this->api_url, sanitize_text_field( $settings['vimeo_username'] ) ), array( 'timeout' => 60 ) );

			if ( is_wp_error( $this->connection ) || 200 != $this->connection['response']['code'] ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$_data = json_decode( $this->connection['body'], true );

				if ( isset( $_data['total_contacts'] ) ) {
					$count = intval( $_data['total_contacts'] );

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
		$vimeo_username = ! empty( $settings['vimeo_username'] ) ? $settings['vimeo_username'] : '';

		return $this->get_view_li( 'https://vimeo.com/' . $vimeo_username, $total, __( 'followers', 'social-count-plus' ), $text_color, $settings );
	}
}
