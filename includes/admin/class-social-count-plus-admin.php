<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Social Count Plus Admin.
 *
 * @package  Social_Count_Plus/Admin
 * @category Admin
 * @author   Claudio Sanches
 */
class Social_Count_Plus_Admin {

	/**
	 * Plugin settings screen.
	 *
	 * @var string
	 */
	public $settings_screen = null;

	/**
	 * Plugin settings.
	 *
	 * @var array
	 */
	public $plugin_settings = array();

	/**
	 * Plugin settings.
	 *
	 * @var array
	 */
	public $plugin_design = array();

	/**
	 * Initialize the plugin admin.
	 */
	public function __construct() {
		// Adds admin menu.
		add_action( 'admin_menu', array( $this, 'settings_menu' ) );

		// Init plugin options form.
		add_action( 'admin_init', array( $this, 'plugin_settings' ) );

		// Style and scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'styles_and_scripts' ) );

		// Actions links.
		add_filter( 'plugin_action_links_social-count-plus/social-count-plus.php', array( $this, 'action_links' ) );
	}

	/**
	 * Plugin options.
	 *
	 * @return array
	 */
	protected function plugin_options() {
		$twitter_oauth_description = sprintf( __( 'Create an APP on Twitter in %s and get this information', 'social-count-plus' ), '<a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a>' );

		$instagram_access_token = sprintf( __( 'Get the this information in %s', 'social-count-plus' ), '<a href="http://www.pinceladasdaweb.com.br/instagram/access-token/" target="_blank">http://www.pinceladasdaweb.com.br/instagram/access-token/</a>' );

		$settings = array(
			'socialcountplus_settings' => array(
				'twitter' => array(
					'title'  => __( 'Twitter', 'social-count-plus' ),
					'fields' => array(
						'twitter_active' => array(
							'title'   => __( 'Display Twitter counter', 'social-count-plus' ),
							'type'    => 'checkbox'
						),
						'twitter_user' => array(
							'title'       => __( 'Twitter username', 'social-count-plus' ),
							'type'        => 'text',
							'description' => __( 'Insert the Twitter username. Example: ferramentasblog', 'social-count-plus' )
						),
						'twitter_consumer_key' => array(
							'title'       => __( 'Twitter Consumer key', 'social-count-plus' ),
							'type'        => 'text',
							'description' => $twitter_oauth_description
						),
						'twitter_consumer_secret' => array(
							'title'       => __( 'Twitter Consumer secret', 'social-count-plus' ),
							'type'        => 'text',
							'description' => $twitter_oauth_description
						),
						'twitter_access_token' => array(
							'title'       => __( 'Twitter Access token', 'social-count-plus' ),
							'type'        => 'text',
							'description' => $twitter_oauth_description
						),
						'twitter_access_token_secret' => array(
							'title'       => __( 'Twitter Access token secret', 'social-count-plus' ),
							'type'        => 'text',
							'description' => $twitter_oauth_description
						)
					)
				),
				'facebook' => array(
					'title'  => __( 'Facebook', 'social-count-plus' ),
					'fields' => array(
						'facebook_active' => array(
							'title'   => __( 'Display Facebook counter', 'social-count-plus' ),
							'type'    => 'checkbox'
						),
						'facebook_id' => array(
							'title'   => __( 'Facebook Page ID', 'social-count-plus' ),
							'type'    => 'text',
							'description' => __( 'ID Facebook page. Must be the numeric ID.<br />You can find this information clicking to edit your page on Facebook. The URL will be similar to this:<br />https://www.facebook.com/pages/edit/?id=<strong>162354720442454</strong>', 'social-count-plus' )
						)
					)
				),
				'youtube' => array(
					'title'  => __( 'YouTube', 'social-count-plus' ),
					'fields' => array(
						'youtube_active' => array(
							'title'   => __( 'Display YouTube counter', 'social-count-plus' ),
							'type'    => 'checkbox'
						),
						'youtube_user' => array(
							'title'       => __( 'YouTube username', 'social-count-plus' ),
							'type'        => 'text',
							'description' => __( 'Insert the YouTube username. Example: UCWGz8KbT5IE7PxhSN1jjimw', 'social-count-plus' )
						),
						'youtube_url' => array(
							'title'       => __( 'YouTube Channel URL', 'social-count-plus' ),
							'type'        => 'text',
							'description' => __( 'Insert the YouTube channel URL. Example: https://www.youtube.com/channel/UCWGz8KbT5IE7PxhSN1jjimw', 'social-count-plus' )
						)
					)
				),
				'googleplus' => array(
					'title'  => __( 'Google+', 'social-count-plus' ),
					'fields' => array(
						'googleplus_active' => array(
							'title' => __( 'Display Google+ counter', 'social-count-plus' ),
							'type'  => 'checkbox'
						),
						'googleplus_id' => array(
							'title'       => __( 'Google+ ID', 'social-count-plus' ),
							'type'        => 'text',
							'description' => __( 'Google+ page or profile ID. <br />Example:<br />https://plus.google.com/<strong>115161266310935247804</strong> or https://plus.google.com/<strong>+Ferramentasblog1</strong>', 'social-count-plus' )
						),
						'googleplus_api_key' => array(
							'title'       => __( 'Google API Key', 'social-count-plus' ),
							'type'        => 'text',
							'description' => sprintf(
								__( 'Get your API key creating a project/app in %s, then inside your project go to "APIs & auth > APIs" and turn on the "Google+ API", finally go to "APIs & auth > APIs > Credentials > Public API access" and click in the "CREATE A NEW KEY" button, select the "Browser key" option and click in the "CREATE" button, now just copy your API key and paste here.', 'social-count-plus' ),
								'<a href="https://console.developers.google.com/project">https://console.developers.google.com/project</a>'
							)
						)
					)
				),
				'instagram' => array(
					'title'  => __( 'Instagram', 'social-count-plus' ),
					'fields' => array(
						'instagram_active' => array(
							'title' => __( 'Display Instagram counter', 'social-count-plus' ),
							'type'  => 'checkbox'
						),
						'instagram_username' => array(
							'title'       => __( 'Instagram Username', 'social-count-plus' ),
							'type'        => 'text',
							'description' => __( 'Insert the Instagram Username.', 'social-count-plus' )
						),
						'instagram_user_id' => array(
							'title'       => __( 'Instagram User ID', 'social-count-plus' ),
							'type'        => 'text',
							'description' => __( 'Insert the Instagram User ID.', 'social-count-plus' ) . ' ' . $instagram_access_token
						),
						'instagram_access_token' => array(
							'title'       => __( 'Instagram Access Token', 'social-count-plus' ),
							'type'        => 'text',
							'description' => __( 'Insert the Instagram Access Token.', 'social-count-plus' ) . ' ' . $instagram_access_token
						)
					)
				),
				'steam' => array(
					'title'  => __( 'Steam', 'social-count-plus' ),
					'fields' => array(
						'steam_active' => array(
							'title' => __( 'Display Steam counter', 'social-count-plus' ),
							'type'  => 'checkbox'
						),
						'steam_group_name' => array(
							'title'       => __( 'Steam group name', 'social-count-plus' ),
							'type'        => 'text',
							'description' => __( 'Insert the Steam Community group name. Example: DOTALT', 'social-count-plus' )
						)
					)
				),
				'soundcloud' => array(
					'title'  => __( 'SoundCloud', 'social-count-plus' ),
					'fields' => array(
						'soundcloud_active' => array(
							'title' => __( 'Display SoundCloud counter', 'social-count-plus' ),
							'type'  => 'checkbox'
						),
						'soundcloud_username' => array(
							'title'       => __( 'SoundCloud Username', 'social-count-plus' ),
							'type'        => 'text',
							'description' => __( 'Insert the SoundCloud Username.', 'social-count-plus' )
						),
						'soundcloud_client_id' => array(
							'title'       => __( 'SoundCloud Client ID', 'social-count-plus' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Insert the SoundCloud APP Client ID. Generate this information in %s', 'social-count-plus' ), '<a href="http://soundcloud.com/you/apps/new" target="_blank">http://soundcloud.com/you/apps/new</a>' )
						)
					)
				),
				'posts' => array(
					'title'  => __( 'Posts', 'social-count-plus' ),
					'fields' => array(
						'posts_active' => array(
							'title'   => __( 'Display Posts counter', 'social-count-plus' ),
							'default' => true,
							'type'    => 'checkbox'
						)
					)
				),
				'comments' => array(
					'title'  => __( 'Comments', 'social-count-plus' ),
					'fields' => array(
						'comments_active' => array(
							'title'   => __( 'Display Comments counter', 'social-count-plus' ),
							'default' => true,
							'type'    => 'checkbox'
						)
					)
				),
				'settings' => array(
					'title'  => __( 'Settings', 'social-count-plus' ),
					'fields' => array(
						'target_blank' => array(
							'title'       => __( 'Open URLs in new tab/window', 'social-count-plus' ),
							'type'        => 'checkbox',
							'description' => __( 'This option add target="_blank" in all counters URLs.', 'social-count-plus' )
						),
						'rel_nofollow' => array(
							'title'       => __( 'Add nofollow in URLs', 'social-count-plus' ),
							'type'        => 'checkbox',
							'description' => __( 'This option add rel="nofollow" in all counters URLs.', 'social-count-plus' )
						),
					)
				)
			),
			'socialcountplus_design' => array(
				'design' => array(
					'title'  => __( 'Design', 'social-count-plus' ),
					'fields' => array(
						'models' => array(
							'title'   => __( 'Layout Models', 'social-count-plus' ),
							'default' => 0,
							'type'    => 'models',
							'options' => array(
								'design-default.png',
								'design-default-vertical.png',
								'design-circle.png',
								'design-circle-vertical.png',
								'design-flat.png',
								'design-flat-vertical.png',
							)
						),
						'text_color' => array(
							'title'   => __( 'Text Color', 'social-count-plus' ),
							'default' => '#333333',
							'type'    => 'color'
						)
					)
				)
			)
		);

		return $settings;
	}

	/**
	 * Add plugin settings menu.
	 *
	 * @return void
	 */
	public function settings_menu() {
		$this->settings_screen = add_options_page(
			__( 'Social Count Plus', 'social-count-plus' ),
			__( 'Social Count Plus', 'social-count-plus' ),
			'manage_options',
			'social-count-plus',
			array( $this, 'settings_page' )
		);
	}

	/**
	 * Plugin settings page.
	 *
	 * @return string
	 */
	public function settings_page() {
		$screen = get_current_screen();

		if ( ! $this->settings_screen || $screen->id !== $this->settings_screen ) {
			return;
		}

		// Load the plugin options.
		$this->plugin_settings = get_option( 'socialcountplus_settings' );
		$this->plugin_design   = get_option( 'socialcountplus_design' );

		// Create tabs current class.
		$current_tab = '';
		if ( isset( $_GET['tab'] ) ) {
			$current_tab = $_GET['tab'];
		} else {
			$current_tab = 'settings';
		}

		// Reset transients when save settings page.
		if ( isset( $_GET['settings-updated'] ) ) {
			if ( true == $_GET['settings-updated'] ) {
				Social_Count_Plus_Generator::reset_count();
			}
		}

		include 'views/html-settings-page.php';
	}

	/**
	 * Plugin settings form fields.
	 *
	 * @return void
	 */
	public function plugin_settings() {

		// Process the settings.
		foreach ( $this->plugin_options() as $settings_id => $sections ) {

			// Create the sections.
			foreach ( $sections as $section_id => $section ) {
				add_settings_section(
					$section_id,
					$section['title'],
					'__return_false',
					$settings_id
				);

				// Create the fields.
				foreach ( $section['fields'] as $field_id => $field ) {
					switch ( $field['type'] ) {
						case 'text':
							add_settings_field(
								$field_id,
								$field['title'],
								array( $this, 'text_element_callback' ),
								$settings_id,
								$section_id,
								array(
									'tab'         => $settings_id,
									'id'          => $field_id,
									'class'       => 'regular-text',
									'description' => isset( $field['description'] ) ? $field['description'] : ''
								)
							);
							break;
						case 'checkbox':
							add_settings_field(
								$field_id,
								$field['title'],
								array( $this, 'checkbox_element_callback' ),
								$settings_id,
								$section_id,
								array(
									'tab'         => $settings_id,
									'id'          => $field_id,
									'description' => isset( $field['description'] ) ? $field['description'] : ''
								)
							);
							break;
						case 'models':
							add_settings_field(
								$field_id,
								$field['title'],
								array( $this, 'models_element_callback' ),
								$settings_id,
								$section_id,
								array(
									'tab'         => $settings_id,
									'id'          => $field_id,
									'description' => isset( $field['description'] ) ? $field['description'] : '',
									'options'     => $field['options']
								)
							);
							break;
						case 'color':
							add_settings_field(
								$field_id,
								$field['title'],
								array( $this, 'color_element_callback' ),
								$settings_id,
								$section_id,
								array(
									'tab'         => $settings_id,
									'id'          => $field_id,
									'description' => isset( $field['description'] ) ? $field['description'] : ''
								)
							);
							break;

						default:
							break;
					}
				}
			}

			// Register the setting.
			register_setting( $settings_id, $settings_id, array( $this, 'validate_options' ) );
		}
	}

	/**
	 * Get option value.
	 *
	 * @param  string $id      Option ID.
	 * @param  mixed  $default Default value.
	 *
	 * @return string
	 */
	protected function get_option_value( $id, $default = '' ) {
		$options = array_merge( $this->plugin_settings, $this->plugin_design );

		return ( isset( $options[ $id ] ) ) ? $options[ $id ] : $default;
	}

	/**
	 * Text element fallback.
	 *
	 * @param  array $args Field arguments.
	 *
	 * @return string      Text field.
	 */
	public function text_element_callback( $args ) {
		$tab     = $args['tab'];
		$id      = $args['id'];
		$class   = isset( $args['class'] ) ? $args['class'] : 'small-text';
		$default = isset( $args['default'] ) ? $args['default'] : '';
		$current = $this->get_option_value( $id, $default );
		$html    = sprintf( '<input type="text" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="%4$s" />', $id, $tab, $current, $class );

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Checkbox field fallback.
	 *
	 * @param  array $args Field arguments.
	 *
	 * @return string      Checkbox field.
	 */
	public function checkbox_element_callback( $args ) {
		$tab     = $args['tab'];
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : '';
		$current = $this->get_option_value( $id, $default );
		$html    = sprintf( '<input type="checkbox" id="%1$s" name="%2$s[%1$s]" value="1"%3$s />', $id, $tab, checked( 1, $current, false ) );
		$html   .= sprintf( '<label for="%s"> %s</label><br />', $id, __( 'Activate/Deactivate', 'social-count-plus' ) );

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Models element fallback.
	 *
	 * @param  array $args Field arguments.
	 *
	 * @return string      Models field.
	 */
	function models_element_callback( $args ) {
		$tab     = $args['tab'];
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : 0;
		$current = $this->get_option_value( $id, $default );
		$html    = '';
		$key     = 0;

		foreach ( $args['options'] as $label ) {
			$html .= sprintf( '<input type="radio" id="%1$s_%2$s_%3$s" name="%1$s[%2$s]" value="%3$s"%4$s style="display: block; float: left; margin: 10px 10px 0 0;" />', $tab, $id, $key, checked( $current, $key, false ) );
			$html .= sprintf( '<label for="%1$s_%2$s_%3$s"> <img src="%4$s" alt="%1$s_%2$s_%3$s" /></label><br style="clear: both;margin-bottom: 20px;" />', $tab, $id, $key, plugins_url( 'demos/' . $label, plugin_dir_path( dirname( __FILE__ ) ) ) );
			$key++;
		}

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Color element fallback.
	 *
	 * @param  array $args Field arguments.
	 *
	 * @return string      Color field.
	 */
	public function color_element_callback( $args ) {
		$tab     = $args['tab'];
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : '#333333';
		$current = $this->get_option_value( $id, $default );
		$html    = sprintf( '<input type="text" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="social-count-plus-color-field" />', $id, $tab, $current );

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Valid options.
	 *
	 * @param  array $input options to valid.
	 *
	 * @return array        validated options.
	 */
	public function validate_options( $input ) {
		$output = array();

		foreach ( $input as $key => $value ) {
			if ( isset( $input[ $key ] ) ) {
				$output[ $key ] = sanitize_text_field( $input[ $key ] );
			}
		}

		return $output;
	}

	/**
	 * Register admin styles and scripts.
	 *
	 * @return void
	 */
	public function styles_and_scripts() {
		$screen = get_current_screen();

		if ( $this->settings_screen && $screen->id === $this->settings_screen ) {
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'social-count-plus-admin', plugins_url( 'assets/js/admin.min.js', plugin_dir_path( dirname( __FILE__ ) ) ), array( 'jquery', 'wp-color-picker' ), null, true );
		}
	}

	/**
	 * Adds custom settings url in plugins page.
	 *
	 * @param  array $links Default links.
	 *
	 * @return array        Default links and settings link.
	 */
	public function action_links( $links ) {
		$settings = array(
			'settings' => sprintf(
				'<a href="%s">%s</a>',
				admin_url( 'options-general.php?page=social-count-plus' ),
				__( 'Settings', 'social-count-plus' )
			)
		);

		return array_merge( $settings, $links );
	}
}

new Social_Count_Plus_Admin;
