<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

/**
 * Social_Count_Plus_Counter class.
 */
class Social_Count_Plus_Counter {

    protected function twitter_oauth( $user, $key, $key_secret, $access_token, $access_secret ) {
        require_once SOCIAL_COUNT_PLUS_PATH . 'classes/class-twitter-oauth-authorization.php';

        $screen_name = 'screen_name=' . $user;
        $oauth = new Social_Count_Plus_Twitter_Oauth_Authorization(
            'https://api.twitter.com/1.1/users/show.json',
            $screen_name,
            'GET',
            $key,
            $key_secret,
            $access_token,
            $access_secret
        );

        return $oauth->header();
    }

    /**
     * Update transients and cache.
     */
    public function update_transients() {
        // Get transient.
        $count = get_transient( 'socialcountplus_counter' );

        // Test transient if exist.
        if ( false != $count )
            return $count;

        // Get options.
        $settings = get_option( 'socialcountplus_settings' );
        $cache = get_option( 'socialcountplus_cache' );

        // Default count array.
        $count = array(
            'twitter'    => 0,
            'facebook'   => 0,
            'youtube'    => 0,
            'googleplus' => 0,
            'steam'      => 0,
            'posts'      => 0,
            'comments'   => 0,
        );

        // Twitter.
        if (
            isset( $settings['twitter_active'] )
            && ! empty( $settings['twitter_consumer_key'] )
            && ! empty( $settings['twitter_consumer_secret'] )
            && ! empty( $settings['twitter_access_token'] )
            && ! empty( $settings['twitter_access_token_secret'] )
        ) {
            // Test if twitter_user is empty.
            if ( ! empty( $settings['twitter_user'] ) ) {
                $twitter_user = $settings['twitter_user'];

                $twitter_data_params = array(
                    'method'    => 'GET',
                    'sslverify' => false,
                    'timeout'   => 30,
                    'headers'   => array(
                        'Content-Type'  => 'application/x-www-form-urlencoded',
                        'Authorization' => $this->twitter_oauth(
                            $twitter_user,
                            $settings['twitter_consumer_key'],
                            $settings['twitter_consumer_secret'],
                            $settings['twitter_access_token'],
                            $settings['twitter_access_token_secret']
                        )
                    )
                );

                // Get twitter data.
                $twitter_data = wp_remote_get( 'https://api.twitter.com/1.1/users/show.json?screen_name=' . $twitter_user, $twitter_data_params );

                if ( is_wp_error( $twitter_data ) ) {
                    $count['twitter'] = ( isset( $cache['twitter'] ) ) ? $cache['twitter'] : 0;
                } else {
                    $twitter_response = json_decode( $twitter_data['body'], true );

                    if ( isset( $twitter_response['followers_count'] ) ) {
                        $twitter_count = $twitter_response['followers_count'];

                        $count['twitter'] = $twitter_count;
                        $cache['twitter'] = $twitter_count;
                    } else {
                        $count['twitter'] = ( isset( $cache['twitter'] ) ) ? $cache['twitter'] : 0;
                    }
                }
            }
        }

        // Facebook.
        if ( isset( $settings['facebook_active'] ) ) {
            // Test if facebook_id is empty.
            if ( ! empty( $settings['facebook_id'] ) ) {
                $facebook_id = $settings['facebook_id'];

                // Get facebook data.
                $facebook_data = wp_remote_get( 'http://api.facebook.com/restserver.php?method=facebook.fql.query&query=SELECT%20fan_count%20FROM%20page%20WHERE%20page_id=' . $facebook_id );

                if ( is_wp_error( $facebook_data ) ) {
                    $count['facebook'] = ( isset( $cache['facebook'] ) ) ? $cache['facebook'] : 0;
                } else {
                    $facebook_xml = new SimpleXmlElement( $facebook_data['body'], LIBXML_NOCDATA );
                    $facebook_count = (string) $facebook_xml->page->fan_count;

                    if ( $facebook_count ) {
                        $count['facebook'] = $facebook_count;
                        $cache['facebook'] = $facebook_count;
                    } else {
                        $count['facebook'] = ( isset( $cache['facebook'] ) ) ? $cache['facebook'] : 0;
                    }
                }
            }
        }

        // YouTube.
        if ( isset( $settings['youtube_active'] ) ) {
            // Test if youtube_user is empty.
            if ( ! empty( $settings['youtube_user'] ) ) {
                $youtube_user = $settings['youtube_user'];

                // Get youtube data.
                $youtube_data = wp_remote_get( 'http://gdata.youtube.com/feeds/api/users/' . $youtube_user );

                if ( is_wp_error( $youtube_data ) || '400' <= $youtube_data['response']['code'] ) {
                    $count['youtube'] = ( isset( $cache['youtube'] ) ) ? $cache['youtube'] : 0;
                } else {
                    $youtube_body = str_replace( 'yt:', '', $youtube_data['body'] );
                    $youtube_xml = new SimpleXmlElement( $youtube_body, LIBXML_NOCDATA );
                    $youtube_count = (string) $youtube_xml->statistics['subscriberCount'];

                    if ( $youtube_count ) {
                        $count['youtube'] = $youtube_count;
                        $cache['youtube'] = $youtube_count;
                    } else {
                        $count['youtube'] = ( isset( $cache['youtube'] ) ) ? $cache['youtube'] : 0;
                    }
                }
            }
        }

        // Google Plus.
        if ( isset( $settings['googleplus_active'] ) ) {
            // Test if googleplus_id is empty.
            if ( ! empty( $settings['googleplus_id'] ) ) {
                $googleplus_id = 'https://plus.google.com/' . $settings['googleplus_id'];

                $googleplus_data_params = array(
                    'method'    => 'POST',
                    'sslverify' => false,
                    'timeout'   => 30,
                    'headers'   => array( 'Content-Type' => 'application/json' ),
                    'body'      => '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $googleplus_id . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]'
                );

                // Get googleplus data.
                $googleplus_data = wp_remote_get( 'https://clients6.google.com/rpc', $googleplus_data_params );

                if ( is_wp_error( $googleplus_data ) || '400' <= $googleplus_data['response']['code'] ) {
                    $count['googleplus'] = ( isset( $cache['googleplus'] ) ) ? $cache['googleplus'] : 0;
                } else {
                    $googleplus_response = json_decode( $googleplus_data['body'], true );

                    if ( isset( $googleplus_response[0]['result']['metadata']['globalCounts']['count'] ) ) {
                        $googleplus_count = $googleplus_response[0]['result']['metadata']['globalCounts']['count'];

                        $count['googleplus'] = $googleplus_count;
                        $cache['googleplus'] = $googleplus_count;
                    } else {
                        $count['googleplus'] = ( isset( $cache['googleplus'] ) ) ? $cache['googleplus'] : 0;
                    }
                }
            }
        }

        // Steam
        if (
            isset( $settings['steam_active'] )
            && ! empty( $settings['steam_group_name'] ) ) {
            $steam_group_page_http_rq = wp_remote_get( 'http://steamcommunity.com/groups/' . $settings['steam_group_name'] . '/memberslistxml/?xml=1' );
            if ( is_wp_error( $steam_group_page_http_rq ) ) {
                $count['steam'] = ( isset( $cache['steam'] ) ) ? $cache['steam'] : 0;
            } else {
                $steam_group_page = wp_remote_retrieve_body( $steam_group_page_http_rq );
                $dom = new DomDocument();
                $dom->loadXML( $steam_group_page );
                $xpath = new DOMXPath( $dom );
                $members_node = $xpath->query('//memberList/groupDetails/memberCount');
                if ( !empty ( $members_node ) ) {
                    $member_count = $members_node->item(0)->nodeValue;
                    $count['steam'] = $member_count;
                    $cache['steam'] = $member_count;
                } else {
                    $count['steam'] = ( isset( $cache['steam'] ) ) ? $cache['steam'] : 0;
                }
            }

        // Posts.
        if ( isset( $settings['posts_active'] ) ) {
            $count_posts = wp_count_posts();

            if ( is_wp_error( $count_posts->publish ) ) {
                $count['posts'] = ( isset( $cache['posts'] ) ) ? $cache['posts'] : 0;;
            } else {
                $count['posts'] = $count_posts->publish;
                $cache['posts'] = $count_posts->publish;
            }
        }

        // Comments.
        if ( isset( $settings['comments_active'] ) ) {
            $comments_count = wp_count_comments();

            if ( is_wp_error( $comments_count->approved ) ) {
                $count['comments'] = ( isset( $cache['comments'] ) ) ? $cache['comments'] : 0;;
            } else {
                $count['comments'] = $comments_count->approved;
                $cache['comments'] = $comments_count->approved;
            }
        }

        // Update plugin extra cache.
        update_option( 'socialcountplus_cache', $cache );

        // Update counter transient.
        set_transient( 'socialcountplus_counter', $count, 60*60*24 ); // 24 horas de cache

        return $count;
    }

    /**
     * Delete transients.
     */
    public function delete_transients() {
        delete_transient( 'socialcountplus_counter' );
    }

    /**
     * Reset transients.
     */
    public function reset_transients() {
        $this->delete_transients();
        $this->update_transients();
    }

} // Close Social_Count_Plus_Counter class.
