<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus View.
 *
 * @package  Social_Count_Plus/View
 * @category View
 * @author   Claudio Sanches
 */
class Social_Count_Plus_View {

	/**
	 * Widget view.
	 *
	 * @return string
	 */
	public static function get_view() {
		wp_enqueue_style( 'social-count-plus' );

		$settings = get_option( 'socialcountplus_settings' );
		$design   = get_option( 'socialcountplus_design' );
		$count    = Social_Count_Plus_Generator::get_count();
		$color    = isset( $design['text_color'] ) ? $design['text_color'] : '#333333';
		$icons    = isset( $design['icons'] ) ? array_map( 'sanitize_key', explode( ',', $design['icons'] ) ) : array();

		// Sets view design.
		$style = '';
		switch ( $design['models'] ) {
			case 1:
				$style = 'default vertical';
				break;
			case 2:
				$style = 'circle';
				break;
			case 3:
				$style = 'circle vertical';
				break;
			case 4:
				$style = 'flat';
				break;
			case 5:
				$style = 'flat vertical';
				break;
			case 6:
				$style = 'custom';
				break;
			case 7:
				$style = 'custom vertical';
				break;

			default:
				$style = 'default';
				break;
		}

		$html = '<div class="social-count-plus">';
			$html .= '<ul class="' . $style . '">';

				foreach ( $icons as $icon ) {
					$class = 'social_count_plus_' . $icon . '_counter';
					if ( class_exists( $class ) && isset( $count[ $icon ] ) ) {
						$html .= $class::get_view( $settings, $count[ $icon ], $color );
					} else {
						$html .= apply_filters( 'social_count_plus_' . $icon . 'html_counter', '', $settings, $count[ $icon ], $color );
					}
				}

			$html .= '</ul>';
		$html .= '</div>';

		return $html;
	}
}
