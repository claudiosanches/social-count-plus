<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus Steam Counter.
 *
 * @package  Social_Count_Plus/Steam_Counter
 * @category Counter
 * @author   Claudio Sanches
 */
class Social_Count_Plus_Steam_Counter extends Social_Count_Plus_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'steam';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://steamcommunity.com/groups/';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return isset( $settings['steam_active'] ) && ! empty( $settings['steam_group_name'] );
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
			$this->connection = wp_remote_get( $this->api_url . $settings['steam_group_name'] . '/memberslistxml/?xml=1', array( 'timeout' => 60 ) );

			if ( is_wp_error( $this->connection ) || '400' <= $this->connection['response']['code'] ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				try {
					$xml = @new SimpleXmlElement( $this->connection['body'], LIBXML_NOCDATA );
					$count = intval( $xml->groupDetails->memberCount );

					$this->total = $count;
				} catch ( Exception $e ) {
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
		$steam_group_name = ! empty( $settings['steam_group_name'] ) ? $settings['steam_group_name'] : '';

		return $this->get_view_li( $this->id, 'https://steamcommunity.com/groups/' . $steam_group_name, $total, __( 'members', 'social-count-plus' ), $text_color, $settings );
	}
}
