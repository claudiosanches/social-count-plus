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
	 * Construct view li element.
	 *
	 * @param  string $slug     Item slug.
	 * @param  string $url      Item url.
	 * @param  int    $count    Item count.
	 * @param  string $title    Item title.
	 * @param  array  $settings Item settings.
	 *
	 * @return string           HTML li element.
	 */
	protected static function get_view_li( $slug, $url, $count, $title, $color, $settings ) {
		$target_blank = isset( $settings['target_blank'] ) ? ' target="_blank"' : '';
		$rel_nofollow = isset( $settings['rel_nofollow'] ) ? ' rel="nofollow"' : '';

		$html = sprintf( '<li class="count-%s">', $slug );
			$html .= sprintf( '<a class="icon" href="%s"%s%s></a>', esc_url( $url ), $target_blank, $rel_nofollow );
			$html .= '<span class="items">';
				$html .= sprintf( '<span class="count" style="color: %s !important;">%s</span>', $color, apply_filters( 'social_count_plus_number_format', $count ) );
				$html .= sprintf( '<span class="label" style="color: %s !important;">%s</span>', $color, $title );
			$html .= '</span>';
		$html .= '</li>';

		return $html;
	}

	/**
	 * Widget view.
	 *
	 * @return string
	 */
	public static function get_view() {
		$settings = get_option( 'socialcountplus_settings' );
		$design   = get_option( 'socialcountplus_design' );
		$count    = Social_Count_Plus_Generator::get_count();
		$color    = isset( $design['text_color'] ) ? $design['text_color'] : '#333333';

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

			default:
				$style = 'default';
				break;
		}

		$html = '<div class="social-count-plus">';
			$html .= '<ul class="' . $style . '">';

				// Twitter counter.
				$html .= ( isset( $settings['twitter_active'] ) ) ? self::get_view_li( 'twitter', 'http://twitter.com/' . $settings['twitter_user'], $count['twitter'], __( 'followers', 'social-count-plus' ), $color, $settings ) : '';

				// Facebook counter.
				$html .= ( isset( $settings['facebook_active'] ) ) ? self::get_view_li( 'facebook', 'http://www.facebook.com/' . $settings['facebook_id'], $count['facebook'], __( 'likes', 'social-count-plus' ), $color, $settings ) : '';

				// YouTube counter.
				$html .= ( isset( $settings['youtube_active'] ) ) ? self::get_view_li( 'youtube', esc_url( $settings['youtube_url'] ), $count['youtube'], __( 'subscribers', 'social-count-plus' ), $color, $settings ) : '';

				// Google Plus counter.
				$html .= ( isset( $settings['googleplus_active'] ) ) ? self::get_view_li( 'googleplus', 'https://plus.google.com/' . $settings['googleplus_id'], $count['googleplus'], __( 'followers', 'social-count-plus' ), $color, $settings ) : '';

				// Instagram counter.
				$html .= ( isset( $settings['instagram_active'] ) ) ? self::get_view_li( 'instagram', 'http://instagram.com/' . $settings['instagram_username'], $count['instagram'], __( 'followers', 'social-count-plus' ), $color, $settings ) : '';

				// Steam counter
				$html .= ( isset( $settings['steam_active'] ) ) ? self::get_view_li( 'steam', 'http://steamcommunity.com/groups/' . $settings['steam_group_name'], $count['steam'], __( 'members', 'social-count-plus' ), $color, $settings ) : '';

				// SoundCloud counter.
				$html .= ( isset( $settings['soundcloud_active'] ) ) ? self::get_view_li( 'soundcloud', 'https://soundcloud.com/' . $settings['soundcloud_username'], $count['soundcloud'], __( 'followers', 'social-count-plus' ), $color, $settings ) : '';

				// Posts counter.
				$html .= ( isset( $settings['posts_active'] ) ) ? self::get_view_li( 'posts', get_home_url(), $count['posts'], __( 'posts', 'social-count-plus' ), $color, $settings ) : '';

				// Comments counter.
				$html .= ( isset( $settings['comments_active'] ) ) ? self::get_view_li( 'comments', get_home_url(), $count['comments'], __( 'comments', 'social-count-plus' ), $color, $settings ) : '';

			$html .= '</ul>';
		$html .= '</div>';

		return $html;
	}
}
