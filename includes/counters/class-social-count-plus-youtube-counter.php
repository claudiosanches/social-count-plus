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
	protected $api_url = 'https://gdata.youtube.com/feeds/api/users/';

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return ( isset( $settings['youtube_active'] ) && isset( $settings['youtube_user'] ) && ! empty( $settings['youtube_user'] ) );
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

			$this->connection = wp_remote_get( $this->api_url . $settings['youtube_user'], $params );

			if ( is_wp_error( $this->connection ) || '400' <= $this->connection['response']['code'] ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				try {
					$body  = str_replace( 'yt:', '', $this->connection['body'] );
					$xml   = @new SimpleXmlElement( $body, LIBXML_NOCDATA );
					$count = intval( $xml->statistics['subscriberCount'] );

					$this->total = $count;
				} catch ( Exception $e ) {
					$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
				}
			}
		}

		return $this->total;
	}
}
