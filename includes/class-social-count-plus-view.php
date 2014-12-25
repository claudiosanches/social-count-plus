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
	 * Get the Twitter counter.
	 *
	 * @param  array  $settings Plugin settings.
	 * @param  int    $total    Counter total.
	 * @param  string $color    Text color.
	 *
	 * @return string           Counter html.
	 */
	protected static function get_twitter_counter( $settings, $total, $color ) {
		return self::get_view_li( 'twitter', 'https://twitter.com/' . $settings['twitter_user'], $total, __( 'followers', 'social-count-plus' ), $color, $settings );
	}

	/**
	 * Get the Facebook counter.
	 *
	 * @param  array  $settings Plugin settings.
	 * @param  int    $total    Counter total.
	 * @param  string $color    Text color.
	 *
	 * @return string           Counter html.
	 */
	protected static function get_facebook_counter( $settings, $total, $color ) {
		return self::get_view_li( 'facebook', 'https://www.facebook.com/' . $settings['facebook_id'], $total, __( 'likes', 'social-count-plus' ), $color, $settings );
	}

	/**
	 * Get the YouTube counter.
	 *
	 * @param  array  $settings Plugin settings.
	 * @param  int    $total    Counter total.
	 * @param  string $color    Text color.
	 *
	 * @return string           Counter html.
	 */
	protected static function get_youtube_counter( $settings, $total, $color ) {
		return self::get_view_li( 'youtube', esc_url( $settings['youtube_url'] ), $total, __( 'subscribers', 'social-count-plus' ), $color, $settings );
	}

	/**
	 * Get the Google+ counter.
	 *
	 * @param  array  $settings Plugin settings.
	 * @param  int    $total    Counter total.
	 * @param  string $color    Text color.
	 *
	 * @return string           Counter html.
	 */
	protected static function get_googleplus_counter( $settings, $total, $color ) {
		return self::get_view_li( 'googleplus', 'https://plus.google.com/' . $settings['googleplus_id'], $total, __( 'followers', 'social-count-plus' ), $color, $settings );
	}

	/**
	 * Get the Instagram counter.
	 *
	 * @param  array  $settings Plugin settings.
	 * @param  int    $total    Counter total.
	 * @param  string $color    Text color.
	 *
	 * @return string           Counter html.
	 */
	protected static function get_instagram_counter( $settings, $total, $color ) {
		return self::get_view_li( 'instagram', 'https://instagram.com/' . $settings['instagram_username'], $total, __( 'followers', 'social-count-plus' ), $color, $settings );
	}

	/**
	 * Get the Steam counter.
	 *
	 * @param  array  $settings Plugin settings.
	 * @param  int    $total    Counter total.
	 * @param  string $color    Text color.
	 *
	 * @return string           Counter html.
	 */
	protected static function get_steam_counter( $settings, $total, $color ) {
		return self::get_view_li( 'steam', 'https://steamcommunity.com/groups/' . $settings['steam_group_name'], $total, __( 'members', 'social-count-plus' ), $color, $settings );
	}

	/**
	 * Get the SoundCloud counter.
	 *
	 * @param  array  $settings Plugin settings.
	 * @param  int    $total    Counter total.
	 * @param  string $color    Text color.
	 *
	 * @return string           Counter html.
	 */
	protected static function get_soundcloud_counter( $settings, $total, $color ) {
		return self::get_view_li( 'soundcloud', 'https://soundcloud.com/' . $settings['soundcloud_username'], $total, __( 'followers', 'social-count-plus' ), $color, $settings );
	}

	/**
	 * Get the Posts counter.
	 *
	 * @param  array  $settings Plugin settings.
	 * @param  int    $total    Counter total.
	 * @param  string $color    Text color.
	 *
	 * @return string           Counter html.
	 */
	protected static function get_posts_counter( $settings, $total, $color ) {
		$post_type = ( isset( $settings['posts_post_type'] ) && ! empty( $settings['posts_post_type'] ) ) ? $settings['posts_post_type'] : 'post';
		$post_object = get_post_type_object( $post_type );

		unset( $settings['target_blank'] );
		unset( $settings['rel_nofollow'] );

		return self::get_view_li( 'posts', get_home_url(), $total, strtolower( $post_object->label ), $color, $settings );
	}

	/**
	 * Get the Comments counter.
	 *
	 * @param  array  $settings Plugin settings.
	 * @param  int    $total    Counter total.
	 * @param  string $color    Text color.
	 *
	 * @return string           Counter html.
	 */
	protected static function get_comments_counter( $settings, $total, $color ) {
		unset( $settings['target_blank'] );
		unset( $settings['rel_nofollow'] );

		return self::get_view_li( 'comments', get_home_url(), $total, __( 'comments', 'social-count-plus' ), $color, $settings );
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
		$icons    = isset( $design['icons'] ) ? explode( ',', $design['icons'] ) : array();

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
					$method = 'get_' . $icon . '_counter';
					$html .= self::$method( $settings, $count[ $icon ], $color );
				}

			$html .= '</ul>';
		$html .= '</div>';

		return $html;
	}
}
