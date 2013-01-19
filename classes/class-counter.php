<?php
/**
 * Social_Count_Plus_Counter class.
 */
class Social_Count_Plus_Counter {

    /**
     * Update transients and cache.
     */
    public function update_transients() {
        // Get transient.
        $count = get_transient( 'socialcountplus_counter' );

        // Test transient if exist.
        if ( false != $count ) {
            return $count;
        }

        // Get options.
        $settings = get_option( 'socialcountplus_settings' );
        $cache = get_option( 'socialcountplus_cache' );

        // Default count array.
        $count = array(
            'twitter' => 0,
            'facebook' => 0,
            'youtube' => 0,
            'posts' => 0,
            'comments' => 0,
        );

        // Twitter.
        if ( isset( $settings['twitter_active'] ) ) {
            // Test if twitter_user is empty.
            if ( ! empty( $settings['twitter_user'] ) ) {
                $twitter_user = $settings['twitter_user'];

                // Get twitter data.
                $twitter_data = wp_remote_get( 'http://api.twitter.com/1/users/show.json?screen_name=' . $twitter_user );

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

                if ( is_wp_error( $youtube_data ) || '404' == $youtube_data['response']['code'] ) {
                    $count['youtube'] = ( isset( $cache['youtube'] ) ) ? $cache['youtube'] : 0;
                } else {
                    print_r($youtube_data['response']['code']);
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
