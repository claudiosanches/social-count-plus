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
	 * Get view model.
	 *
	 * @param  int $model
	 *
	 * @return string
	 */
	public static function get_view_model( $model ) {
		$models = array(
			'default',
			'default vertical',
			'circle',
			'circle vertical',
			'flat',
			'flat vertical',
			'custom',
			'custom vertical'
		);

		return isset( $models[ $model ] ) ? $models[ $model ] : 'default';
	}

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
		$style    = self::get_view_model( $design['models'] );

		$html = '<div class="social-count-plus">';
			$html .= '<ul class="' . $style . '">';

				foreach ( $icons as $icon ) {
					$class = 'social_count_plus_' . $icon . '_counter';

					if ( ! isset( $count[ $icon ] ) ) {
						continue;
					}

					$total = apply_filters( 'social_count_plus_number_format', $count[ $icon ] );

					if ( class_exists( $class ) ) {
						$_class = new $class();
						$html  .= $_class->get_view( $settings, $total, $color );
					} else {
						$html .= apply_filters( 'social_count_plus_' . $icon . 'html_counter', '', $settings, $total, $color );
					}
				}

			$html .= '</ul>';
		$html .= '</div>';

		return $html;
	}
}
