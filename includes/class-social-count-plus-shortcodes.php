<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus Shortcode.
 *
 * @package  Social_Count_Plus/Shortcode
 * @category Shortcode
 * @author   Claudio Sanches
 */
class Social_Count_Plus_Shortcodes {

	/**
	 * Counter.
	 *
	 * @param  array $atts Shortcode attributes.
	 *
	 * @return string Counter in text.
	 */
	public static function counter( $atts ) {
		$count = Social_Count_Plus_Generator::get_count();

		extract(
			shortcode_atts(
				array(
					'code' => 'twitter'
				),
				$atts
			)
		);

		$counter = $count[ $code ];

		return apply_filters( 'social_count_plus_number_format', $counter );
	}
}
