<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

/**
 * Social_Count_Plus_Twitter_Oauth_Authorization class.
 *
 * @since 2.3.0
 */
class Social_Count_Plus_Twitter_Oauth_Authorization {

    /**
     * Class construct.
     *
     * @param string $url                       Request URL.
     * @param string $query                     Request query.
     * @param string $method                    Request method.
     * @param string $consumer_key              Twitter customer key.
     * @param string $consumer_secret           Twitter customer secret.
     * @param string $oauth_access_token        OAuth access token.
     * @param string $oauth_access_token_secret OAuth access token secret.
     */
    public function __construct(
        $url,
        $query,
        $method,
        $consumer_key,
        $consumer_secret,
        $oauth_access_token,
        $oauth_access_token_secret ) {
        $this->url                       = $url;
        $this->query                     = $query;
        $this->method                    = $method;
        $this->consumer_key              = $consumer_key;
        $this->consumer_secret           = $consumer_secret;
        $this->oauth_access_token        = $oauth_access_token;
        $this->oauth_access_token_secret = $oauth_access_token_secret;
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

        foreach( $params as $key => $value )
            $return[] = $key . '=' . $value;

        return $method . "&" . rawurlencode( $url ) . '&' . rawurlencode( implode( '&', $return ) ) . '%26' . rawurlencode( $query );
    }

    /**
     * Build the OAuth Signature.
     *
     * @return array OAuth signature params.
     */
    private function signature() {
        $oauth = array(
            'oauth_consumer_key' => $this->consumer_key,
            'oauth_nonce' => hash_hmac( 'sha1', time(), true ),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_token' => $this->oauth_access_token,
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0'
        );

        $base_info = $this->signature_base_string( $this->url, $this->query, $this->method, $oauth );
        $composite_key = rawurlencode( $this->consumer_secret ) . '&' . rawurlencode( $this->oauth_access_token_secret );
        $oauth_signature = base64_encode( hash_hmac( 'sha1', $base_info, $composite_key, true ) );
        $oauth['oauth_signature'] = $oauth_signature;

        return $oauth;
    }

    /**
     * Build the header.
     *
     * @return string OAuth Authorization.
     */
    public function header() {
        $return = 'OAuth ';
        $values = array();

        foreach( $this->signature() as $key => $value )
            $values[] = $key . '="' . rawurlencode( $value ) . '"';

        $return .= implode( ', ', $values );

        return $return;
    }
}
