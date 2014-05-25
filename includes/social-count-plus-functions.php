<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

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
	$count = Social_Count_Plus_Generator::get_count();

	return $count['twitter'];
}

/**
 * Facebook counter function.
 *
 * @return int Facebook count.
 */
function get_scp_facebook() {
	$count = Social_Count_Plus_Generator::get_count();

	return $count['facebook'];
}

/**
 * YouTube counter function.
 *
 * @return int YouTube count.
 */
function get_scp_youtube() {
	$count = Social_Count_Plus_Generator::get_count();

	return $count['youtube'];
}

/**
 * Google Plus counter function.
 *
 * @return int Google Plus count.
 */
function get_scp_googleplus() {
	$count = Social_Count_Plus_Generator::get_count();

	return $count['googleplus'];
}

/**
 * Instagram counter function.
 *
 * @return int Instagram Plus count.
 */
function get_scp_instagram() {
	$count = Social_Count_Plus_Generator::get_count();

	return $count['instagram'];
}

/**
 * SoundCloud counter function.
 *
 * @return int SoundCloud Plus count.
 */
function get_scp_soundcloud() {
	$count = Social_Count_Plus_Generator::get_count();

	return $count['soundcloud'];
}

/**
 * Steam Community member counter function.
 *
 * @return int Steam Community group member count.
 */
function get_scp_steam() {
	$count = Social_Count_Plus_Generator::get_count();

	return $count['steam'];
}

/**
 * Posts counter function.
 *
 * @return int Posts count.
 */
function get_scp_posts() {
	$count = Social_Count_Plus_Generator::get_count();

	return $count['posts'];
}

/**
 * Comments counter function.
 *
 * @return int Comments count.
 */
function get_scp_comments() {
	$count = Social_Count_Plus_Generator::get_count();

	return $count['comments'];
}

/**
 * All counters function.
 *
 * @return array All counts.
 */
function get_scp_all() {
	$count = Social_Count_Plus_Generator::get_count();

	return $count;
}

/**
 * Widget counter function.
 *
 * @return int Widget count.
 */
function get_scp_widget() {
	return Social_Count_Plus_View::get_view();
}
