<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus YouTube Counter.
 *
 * @package  Social_Count_Plus/YouTube_Counter
 * @category Counter
 * @author   Claudio Sanches
 */
class Social_Count_Plus_YouTube_Counter extends Social_Count_Plus_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'youtube';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://www.googleapis.com/youtube/v3/channels';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return isset( $settings['youtube_active'] ) && ! empty( $settings['youtube_user'] ) && ! empty( $settings['youtube_api_key'] );
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
			$url = sprintf(
				'%s?part=statistics&id=%s&key=%s',
				$this->api_url,
				sanitize_text_field( $settings['youtube_user'] ),
				sanitize_text_field( $settings['youtube_api_key'] )
			);

			$this->connection = wp_remote_get( $url, array( 'timeout' => 60 ) );

			if ( is_wp_error( $this->connection ) || 400 <= $this->connection['response']['code'] ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$_data = json_decode( $this->connection['body'], true );

				if ( isset( $_data['items'][0]['statistics']['subscriberCount'] ) ) {
					$count = intval( $_data['items'][0]['statistics']['subscriberCount'] );

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
		$youtube_url = ! empty( $settings['youtube_url'] ) ? $settings['youtube_url'] : '';

		return $this->get_view_li( $this->id, $youtube_url, $total, __( 'subscribers', 'social-count-plus' ), $text_color, $settings );
	}
}
