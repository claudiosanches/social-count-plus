<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus Pinterest Counter.
 *
 * @package  Social_Count_Plus/Pinterest_Counter
 * @category Counter
 * @author   Claudio Sanches
 */
class Social_Count_Plus_Pinterest_Counter extends Social_Count_Plus_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'pinterest';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://www.pinterest.com/';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return isset( $settings['pinterest_active'] ) && ! empty( $settings['pinterest_username'] );
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
			$this->connection = wp_remote_get( $this->api_url . sanitize_text_field( $settings['pinterest_username'] ), array( 'timeout' => 60 ) );

			if ( is_wp_error( $this->connection ) ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$count = 0;

				if ( 200 == $this->connection['response']['code'] ) {
					$tags = array();
					$regex = '/property\=\"pinterestapp:followers\" name\=\"pinterestapp:followers\" content\=\"(.*?)" data-app/';
					preg_match( $regex, $this->connection['body'], $tags );

					$count = intval( $tags[1] );
				}

				if ( 0 < $count ) {
					$this->total = $count;
				} else {
					$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
				}

				// Just to make the system report more clear...
				$this->connection['body'] = '{"followers":' . $count . '}';
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
		$pinterest_username = ! empty( $settings['pinterest_username'] ) ? $settings['pinterest_username'] : '';

		return $this->get_view_li( 'https://www.pinterest.com/' . $pinterest_username, $total, __( 'followers', 'social-count-plus' ), $text_color, $settings );
	}
}
