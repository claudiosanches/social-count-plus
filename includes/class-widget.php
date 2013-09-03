<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

/**
 * Register Social Count Plus widget.
 */
class SocialCountPlus extends WP_Widget {

    /**
     * Construct method.
     */
    function SocialCountPlus() {
        global $social_count_plus;

        $widget_ops = array( 'social_count_plus' => 'SocialCountPlus', 'description' => __( 'Display the counter', 'socialcountplus' ) );
        $this->WP_Widget( 'SocialCountPlus', __( 'Social Count Plus', 'socialcountplus' ), $widget_ops );

        $this->plugin_view = $social_count_plus->view();
    }

    /**
     * Create widget form.
     */
    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );

        echo sprintf( '<p><label for="%1$s">%2$s: <input class="widefat" id="%1$s" name="%3$s" type="text" value="%4$s" /></label></p>', $this->get_field_id( 'title' ), __( 'Title', 'socialcountplus' ), $this->get_field_name( 'title' ), esc_attr( $instance['title'] ) );
    }

    /**
     * Update widget options.
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );

        return $instance;
    }

    /**
     * Show widget.
     */
    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );

        echo $before_widget;

        $title = empty( $instance['title'] ) ? ' ' : apply_filters( 'widget_title', $instance['title'] );

        if ( ! empty( $title ) )
            echo $before_title . $title . $after_title;

        // Display widget
        echo $this->plugin_view;

        echo $after_widget;
    }
}

add_action( 'widgets_init', create_function( '', 'return register_widget("SocialCountPlus");' ) );
