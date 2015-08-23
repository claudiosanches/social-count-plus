<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
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
 * Get counter function.
 *
 * @param  string $counter
 *
 * @return int
 */
function get_scp_counter( $counter = '' ) {
	$count = get_scp_all();

	return isset( $count[ $counter ] ) ? $count[ $counter ] : 0;
}


/**
 * Get widget counter function.
 *
 * @return string Widget count.
 */
function get_scp_widget() {
	return Social_Count_Plus_View::get_view();
}
