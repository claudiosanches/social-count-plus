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
		return ( isset( $settings['steam_active'] ) && isset( $settings['steam_group_name'] ) && ! empty( $settings['steam_group_name'] ) );
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

			$this->connection = wp_remote_get( $this->api_url . $settings['steam_group_name'] . '/memberslistxml/?xml=1', $params );

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
}
