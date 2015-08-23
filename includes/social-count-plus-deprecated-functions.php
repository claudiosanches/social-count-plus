<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * FeedBurner counter function.
 *
 * This functions is deprecated.
 *
 * @deprecated since ever!
 *
 * @return int FeedBurner count.
 */
function get_scp_feed() {
	_deprecated_function( 'get_scp_feed', 'ever!' );

	return 0;
}

/**
 * Twitter counter function.
 *
 * @deprecated since 3.2.0
 *
 * @return int Twitter count.
 */
function get_scp_twitter() {
	_deprecated_function( 'get_scp_twitter', '3.2.0', 'get_scp_counter' );

	$count = Social_Count_Plus_Generator::get_count();

	return $count['twitter'];
}

/**
 * Facebook counter function.
 *
 * @deprecated since 3.2.0
 *
 * @return int Facebook count.
 */
function get_scp_facebook() {
	_deprecated_function( 'get_scp_facebook', '3.2.0', 'get_scp_counter' );

	$count = Social_Count_Plus_Generator::get_count();

	return $count['facebook'];
}

/**
 * YouTube counter function.
 *
 * @deprecated since 3.2.0
 *
 * @return int YouTube count.
 */
function get_scp_youtube() {
	_deprecated_function( 'get_scp_youtube', '3.2.0', 'get_scp_counter' );

	$count = Social_Count_Plus_Generator::get_count();

	return $count['youtube'];
}

/**
 * Google Plus counter function.
 *
 * @deprecated since 3.2.0
 *
 * @return int Google Plus count.
 */
function get_scp_googleplus() {
	_deprecated_function( 'get_scp_googleplus', '3.2.0', 'get_scp_counter' );

	$count = Social_Count_Plus_Generator::get_count();

	return $count['googleplus'];
}

/**
 * Instagram counter function.
 *
 * @deprecated since 3.2.0
 *
 * @return int Instagram Plus count.
 */
function get_scp_instagram() {
	_deprecated_function( 'get_scp_instagram', '3.2.0', 'get_scp_counter' );

	$count = Social_Count_Plus_Generator::get_count();

	return $count['instagram'];
}

/**
 * SoundCloud counter function.
 *
 * @deprecated since 3.2.0
 *
 * @return int SoundCloud Plus count.
 */
function get_scp_soundcloud() {
	_deprecated_function( 'get_scp_soundcloud', '3.2.0', 'get_scp_counter' );

	$count = Social_Count_Plus_Generator::get_count();

	return $count['soundcloud'];
}

/**
 * Twitch counter function.
 *
 * @deprecated since 3.2.0
 *
 * @return int Twitch count.
 */
function get_scp_twitch() {
	_deprecated_function( 'get_scp_twitch', '3.2.0', 'get_scp_counter' );

	$count = Social_Count_Plus_Generator::get_count();

	return $count['twitch'];
}

/**
 * Steam Community member counter function.
 *
 * @deprecated since 3.2.0
 *
 * @return int Steam Community group member count.
 */
function get_scp_steam() {
	_deprecated_function( 'get_scp_steam', '3.2.0', 'get_scp_counter' );

	$count = Social_Count_Plus_Generator::get_count();

	return $count['steam'];
}

/**
 * Posts counter function.
 *
 * @deprecated since 3.2.0
 *
 * @return int Posts count.
 */
function get_scp_posts() {
	_deprecated_function( 'get_scp_posts', '3.2.0', 'get_scp_counter' );

	$count = Social_Count_Plus_Generator::get_count();

	return $count['posts'];
}

/**
 * Comments counter function.
 *
 * @deprecated since 3.2.0
 *
 * @return int Comments count.
 */
function get_scp_comments() {
	_deprecated_function( 'get_scp_comments', '3.2.0', 'get_scp_counter' );

	$count = Social_Count_Plus_Generator::get_count();

	return $count['comments'];
}
