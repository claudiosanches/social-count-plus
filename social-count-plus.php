<?php
/**
 * Plugin Name: Social Count Plus
 * Plugin URI: https://github.com/claudiosmweb/social-count-plus
 * Description: Display the counting Twitter followers, Facebook fans, YouTube subscribers posts and comments.
 * Author: claudiosanches, felipesantana
 * Author URI: http://claudiosmweb.com/
 * Version: 3.0.3
 * License: GPLv2 or later
 * Text Domain: social-count-plus
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Social_Count_Plus' ) ) :

/**
 * Social_Count_Plus main class.
 *
 * @package  Social_Count_Plus
 * @category Core
 * @author   Claudio Sanches
 */
class Social_Count_Plus {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '3.0.3';

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin.
	 */
	private function __construct() {
		// Load plugin text domain.
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Include classes.
		$this->includes();
		$this->include_counters();

		if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
			$this->admin_includes();
		}

		// Widget.
		add_action( 'widgets_init', array( $this, 'register_widget' ) );

		// Shortcode.
		add_shortcode( 'scp', array( 'Social_Count_Plus_Shortcodes', 'counter' ) );

		// Scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'styles_and_scripts' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @return void
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'social-count-plus' );

		load_textdomain( 'social-count-plus', trailingslashit( WP_LANG_DIR ) . 'social-count-plus/social-count-plus-' . $locale . '.mo' );
		load_plugin_textdomain( 'social-count-plus', FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Include admin actions.
	 */
	protected function admin_includes() {
		include 'includes/admin/class-social-count-plus-admin.php';
	}

	/**
	 * Include plugin functions.
	 *
	 * @return void
	 */
	protected function includes() {
		include_once 'includes/class-social-count-plus-generator.php';
		include_once 'includes/abstracts/abstract-social-count-plus-counter.php';
		include_once 'includes/class-social-count-plus-view.php';
		include_once 'includes/class-social-count-plus-widget.php';
		include_once 'includes/class-social-count-plus-shortcodes.php';
		include_once 'includes/social-count-plus-functions.php';
	}

	/**
	 * Include counters.
	 *
	 * @return void
	 */
	protected function include_counters() {
		include_once 'includes/counters/class-social-count-plus-facebook-counter.php';
		include_once 'includes/counters/class-social-count-plus-twitter-counter.php';
		include_once 'includes/counters/class-social-count-plus-youtube-counter.php';
		include_once 'includes/counters/class-social-count-plus-googleplus-counter.php';
		include_once 'includes/counters/class-social-count-plus-instagram-counter.php';
		include_once 'includes/counters/class-social-count-plus-steam-counter.php';
		include_once 'includes/counters/class-social-count-plus-soundcloud-counter.php';
		include_once 'includes/counters/class-social-count-plus-posts-counter.php';
		include_once 'includes/counters/class-social-count-plus-comments-counter.php';
	}

	/**
	 * Register widget.
	 *
	 * @return void
	 */
	public function register_widget() {
		register_widget( 'SocialCountPlus' );
	}

	/**
	 * Register public styles and scripts.
	 *
	 * @return void
	 */
	public function styles_and_scripts() {
		wp_register_style( 'social-count-plus', plugins_url( 'assets/css/counter.css', __FILE__ ), array(), Social_Count_Plus::VERSION, 'all' );
	}
}

/**
 * Init the plugin.
 */
add_action( 'plugins_loaded', array( 'Social_Count_Plus', 'get_instance' ) );

endif;

