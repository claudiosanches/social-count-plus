<?php
/**
 * FeedBurner counter function.
 *
 * This functions is deprecated.
 *
 * @return int FeedBurner count.
 */
function get_scp_feed() {
    return 0;
}

/**
 * Twitter counter function.
 *
 * @return int Twitter count.
 */
function get_scp_twitter() {
    global $social_count_plus_counter;
    $count = $social_count_plus_counter->update_transients();

    return $count['twitter'];
}

/**
 * Facebook counter function.
 *
 * @return int Facebook count.
 */
function get_scp_facebook() {
    global $social_count_plus_counter;
    $count = $social_count_plus_counter->update_transients();

    return $count['facebook'];
}

/**
 * YouTube counter function.
 *
 * @return int YouTube count.
 */
function get_scp_youtube() {
    global $social_count_plus_counter;
    $count = $social_count_plus_counter->update_transients();

    return $count['youtube'];
}

/**
 * Posts counter function.
 *
 * @return int Posts count.
 */
function get_scp_posts() {
    global $social_count_plus_counter;
    $count = $social_count_plus_counter->update_transients();

    return $count['posts'];
}

/**
 * Comments counter function.
 *
 * @return int Comments count.
 */
function get_scp_comments() {
    global $social_count_plus_counter;
    $count = $social_count_plus_counter->update_transients();

    return $count['comments'];
}

/**
 * All counters function.
 *
 * @return array All counts.
 */
function get_scp_all() {
    global $social_count_plus_counter;
    $count = $social_count_plus_counter->update_transients();

    return $count;
}

/**
 * Widget counter function.
 *
 * @return int Widget count.
 */
function get_scp_widget() {
    global $social_count_plus;

    return $social_count_plus->view();
}
