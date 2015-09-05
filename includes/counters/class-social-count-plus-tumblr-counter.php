<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus Tumblr Counter.
 *
 * @package  Social_Count_Plus/Tumblr_Counter
 * @category Counter
 * @author   Claudio Sanches
 */
class Social_Count_Plus_Tumblr_Counter extends Social_Count_Plus_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'tumblr';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://api.tumblr.com/v2/blog/%s/followers';

	/**
	 * Authorization.
	 *
	 * @param  string $hostname                  hostname.
	 * @param  string $consumer_key              Ccustomer key.
	 * @param  string $consumer_secret           Customer secret.
	 * @param  string $oaut_haccess_token        OAuth access token.
	 * @param  string $oauth_access_token_secret OAuth access token secret.
	 *
	 * @return string
	 */
	protected function authorization( $hostname, $consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret ) {
		$signature = $this->signature( $hostname, $consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret );

		return $this->header( $signature );
	}

	/**
	 * Build the Signature base string.
	 *
	 * @param  string $url     Request URL.
	 * @param  string $query   Request query.
	 * @param  string $method  Request method.
	 * @param  string $params  OAuth params.
	 *
	 * @return string          OAuth Signature base.
	 */
	private function signature_base_string( $url, $method, $params ) {
		$return = array();
		ksort( $params );

		foreach( $params as $key => $value ) {
			$return[] = $key . '=' . $value;
		}

		return $method . '&' . rawurlencode( $url ) . '&' . rawurlencode( implode( '&', $return ) );
	}

	/**
	 * Build the OAuth Signature.
	 *
	 * @param  string $hostname                  hostname.
	 * @param  string $consumer_key              Twitter customer key.
	 * @param  string $consumer_secret           Twitter customer secret.
	 * @param  string $oauth_access_token        OAuth access token.
	 * @param  string $oauth_access_token_secret OAuth access token secret.
	 *
	 * @return array                             OAuth signature params.
	 */
	private function signature( $hostname, $consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret ) {
		$oauth = array(
			'oauth_consumer_key'     => $consumer_key,
			'oauth_nonce'            => hash_hmac( 'sha1', time(), '1', false ),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_token'            => $oauth_access_token,
			'oauth_timestamp'        => time(),
			'oauth_version'          => '1.0'
		);

		$base_info = $this->signature_base_string( sprintf( $this->api_url, $hostname ), 'GET', $oauth );
		$composite_key = rawurlencode( $consumer_secret ) . '&' . rawurlencode( $oauth_access_token_secret );
		$oauth_signature = base64_encode( hash_hmac( 'sha1', $base_info, $composite_key, true ) );
		$oauth['oauth_signature'] = $oauth_signature;

		return $oauth;
	}

	/**
	 * Build the header.
	 *
	 * @param  array $signature OAuth signature.
	 *
	 * @return string           OAuth Authorization.
	 */
	public function header( $signature ) {
		$return = 'OAuth ';
		$values = array();

		foreach( $signature as $key => $value ) {
			$values[] = $key . '="' . rawurlencode( $value ) . '"';
		}

		$return .= implode( ', ', $values );

		return $return;
	}

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return isset( $settings['tumblr_active'] ) && ! empty( $settings['tumblr_hostname'] ) && ! empty( $settings['tumblr_consumer_key'] ) && ! empty( $settings['tumblr_consumer_secret'] ) && ! empty( $settings['tumblr_token'] ) && ! empty( $settings['tumblr_token_secret'] );
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
			$hostname = str_replace( array( 'http:', 'https:', '/' ), '', sanitize_text_field( $settings['tumblr_hostname'] ) );

			$params = array(
				'method'    => 'GET',
				'timeout'   => 60,
				'headers'   => array(
					'Content-Type'  => 'application/x-www-form-urlencoded',
					'Authorization' => $this->authorization(
						$hostname,
						$settings['tumblr_consumer_key'],
						$settings['tumblr_consumer_secret'],
						$settings['tumblr_token'],
						$settings['tumblr_token_secret']
					)
				)
			);

			$this->connection = wp_remote_get( sprintf( $this->api_url, $hostname ), $params );

			if ( is_wp_error( $this->connection ) || ( isset( $this->connection['response']['code'] ) && 200 != $this->connection['response']['code'] ) ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$_data = json_decode( $this->connection['body'], true );

				if ( isset( $_data['response']['total_users'] ) ) {
					$count = intval( $_data['response']['total_users'] );

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
		$tumblr_hostname = ! empty( $settings['tumblr_hostname'] ) ? $settings['tumblr_hostname'] : '';

		return $this->get_view_li( $this->id, $tumblr_hostname, $total, __( 'followers', 'social-count-plus' ), $text_color, $settings );
	}
}
