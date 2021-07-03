<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Social Count Plus Counter.
 *
 * @package  Social_Count_Plus/Abstracts
 * @category Abstract
 * @author   Claudio Sanches
 */
abstract class Social_Count_Plus_Counter {

	/**
	 * Total count.
	 *
	 * @var int
	 */
	protected $total = 0;

	/**
	 * Counter ID.
	 *
	 * @var string
	 */
	public $id = '';

	/**
	 * Connection.
	 *
	 * @var WP_Error|array
	 */
	protected $connection = array();

	/**
	 * Test the counter is available.
	 *
	 * @param  array $settings Plugin settings.
	 *
	 * @return bool
	 */
	public function is_available( $settings ) {
		return false;
	}

	/**
	 * Get the total.
	 *
	 * @param  array $settings Plugin settings.
	 * @param  array $cache    Counter cache.
	 *
	 * @return int
	 */
	public function get_total( $settings, $cache ) {
		return $this->total;
	}

	/**
	 * Get the li element.
	 *
	 * @param  string $url      Item url.
	 * @param  int    $count    Item count.
	 * @param  string $label    Item label.
	 * @param  array  $settings Item settings.
	 *
	 * @return string           HTML li element.
	 */
	protected function get_view_li( $url, $count, $label, $color, $settings ) {
		$target_blank = isset( $settings['target_blank'] ) ? ' target="_blank"' : '';
		$styles       = ! empty( $color ) ? ' style="color: ' . $color . ' !important;"' : '';

		$html = sprintf( '<li class="count-%s">', $this->id );
			$html .= sprintf( '<a class="icon" href="%s" rel="nofollow noopener noreferrer"%s>%s</a>', esc_url( $url ), $target_blank, '<span class="sr-only">' . $this->id . ' counter widget</span>' );
			$html .= '<span class="items">';
				$html .= sprintf( '<span class="count"%s>%s</span>', $styles, apply_filters( 'social_count_plus_number_format', $count ) );
				$html .= sprintf( '<span class="label"%s>%s</span>', $styles, apply_filters( 'social_count_plus_label', $label, $this->id ) );
			$html .= '</span>';
		$html .= '</li>';

		return apply_filters( 'social_count_plus_get_view_li', $html, $url, $count, $label, $color, $settings, $this->id );
	}

	/**
	 * Get conter view.
	 *
	 * @param  array  $settings   Plugin settings.
	 * @param  int    $total      Counter total.
	 * @param  string $text_color Text color.
	 *
	 * @return string
	 */
	public function get_view( $settings, $total, $text_color ) {
		return '';
	}

	/**
	 * Debug.
	 *
	 * @return array
	 */
	public function debug() {
		return $this->connection;
	}
}
