<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus Twitter Counter.
 *
 * @package  Social_Count_Plus/Twitter_Counter
 * @category Counter
 * @author   Claudio Sanches
 */
class Social_Count_Plus_Twitter_Counter extends Social_Count_Plus_Counter {

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = 'twitter';

	/**
	 * API URL.
	 *
	 * @var string
	 */
	protected $api_url = 'https://api.twitter.com/1.1/users/show.json';

	/**
	 * Authorization.
	 *
	 * @param  string $user                      Twitter username.
	 * @param  string $consumer_key              Twitter customer key.
	 * @param  string $consumer_secret           Twitter customer secret.
	 * @param  string $oaut_haccess_token        OAuth access token.
	 * @param  string $oauth_access_token_secret OAuth access token secret.
	 *
	 * @return string
	 */
	protected function authorization( $user, $consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret ) {
		$query     = 'screen_name=' . $user;
		$signature = $this->signature( $query, $consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret );

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
	private function signature_base_string( $url, $query, $method, $params ) {
		$return = array();
		ksort( $params );

		foreach( $params as $key => $value ) {
			$return[] = $key . '=' . $value;
		}

		return $method . '&' . rawurlencode( $url ) . '&' . rawurlencode( implode( '&', $return ) ) . '%26' . rawurlencode( $query );
	}

	/**
	 * Build the OAuth Signature.
	 *
	 * @param  string $query                     Request query.
	 * @param  string $consumer_key              Twitter customer key.
	 * @param  string $consumer_secret           Twitter customer secret.
	 * @param  string $oauth_access_token        OAuth access token.
	 * @param  string $oauth_access_token_secret OAuth access token secret.
	 *
	 * @return array                             OAuth signature params.
	 */
	private function signature( $query, $consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret ) {
		$oauth = array(
			'oauth_consumer_key'     => $consumer_key,
			'oauth_nonce'            => hash_hmac( 'sha1', time(), '1', false ),
			'oauth_signature_method' => 'HMAC-SHA1',
			'oauth_token'            => $oauth_access_token,
			'oauth_timestamp'        => time(),
			'oauth_version'          => '1.0'
		);

		$base_info = $this->signature_base_string( $this->api_url, $query, 'GET', $oauth );
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
		return ( isset( $settings['twitter_active'] ) && ! empty( $settings['twitter_user'] ) && ! empty( $settings['twitter_consumer_key'] ) && ! empty( $settings['twitter_consumer_secret'] ) && ! empty( $settings['twitter_access_token'] ) && ! empty( $settings['twitter_access_token_secret'] ) );
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
			$user = $settings['twitter_user'];

			$params = array(
				'method'    => 'GET',
				'timeout'   => 60,
				'headers'   => array(
					'Content-Type'  => 'application/x-www-form-urlencoded',
					'Authorization' => $this->authorization(
						$user,
						$settings['twitter_consumer_key'],
						$settings['twitter_consumer_secret'],
						$settings['twitter_access_token'],
						$settings['twitter_access_token_secret']
					)
				)
			);

			$this->connection = wp_remote_get( $this->api_url . '?screen_name=' . $user, $params );

			if ( is_wp_error( $this->connection ) ) {
				$this->total = ( isset( $cache[ $this->id ] ) ) ? $cache[ $this->id ] : 0;
			} else {
				$_data = json_decode( $this->connection['body'], true );

				if ( isset( $_data['followers_count'] ) ) {
					$count = intval( $_data['followers_count'] );

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
		$twitter_user = ! empty( $settings['twitter_user'] ) ? $settings['twitter_user'] : '';

		return $this->get_view_li( $this->id, 'https://twitter.com/' . $twitter_user, $total, __( 'followers', 'social-count-plus' ), $text_color, $settings );
	}
}
