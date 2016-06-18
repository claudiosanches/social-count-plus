<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus LinkedIn Counter.
 *
 * @package  Social_Count_Plus/LinkedIn_Counter
 * @category Counter
 * @author   Claudio Sanches
 */
class Social_Count_Plus_LinkedIn_Counter extends Social_Count_Plus_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'linkedin';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://api.linkedin.com/v1/companies/%s/num-followers?format=json';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return isset( $settings['linkedin_active'] ) && ! empty( $settings['linkedin_company_id'] ) && ! empty( $settings['linkedin_access_token'] );
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
				'timeout'   => 60,
				'headers'   => array(
					'Authorization' => 'Bearer ' . sanitize_text_field( $settings['linkedin_access_token'] )
				)
			);

			$this->connection = wp_remote_get( sprintf( $this->api_url, sanitize_text_field( $settings['linkedin_company_id'] ) ), $params );

			if ( is_wp_error( $this->connection ) || 200 != $this->connection['response']['code'] ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$count = intval( $this->connection['body'] );

				if ( 0 < $count ) {
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
		$linkedin_company_id = ! empty( $settings['linkedin_company_id'] ) ? $settings['linkedin_company_id'] : '';

		return $this->get_view_li( 'https://www.linkedin.com/company/' . $linkedin_company_id, $total, __( 'followers', 'social-count-plus' ), $text_color, $settings );
	}
}
