<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
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

		// System status report.
		add_action( 'admin_init', array( $this, 'report_file' ) );

		// Install/update plugin options.
		$this->maybe_install();
	}

	/**
	 * Get the plugin options.
	 *
	 * @return array
	 */
	protected static function get_plugin_options() {
		$twitter_oauth_description = sprintf( __( 'Create an App on Twitter in %s and get this data.', 'social-count-plus' ), '<a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a>' );

		$facebook_app_description = sprintf( __( 'Create an App on Facebook in %s and get this data.', 'social-count-plus' ), '<a href="https://developers.facebook.com/" target="_blank">https://developers.facebook.com/</a>' );

		$instagram_access_token = sprintf( __( 'Get the this data in %s.', 'social-count-plus' ), '<a href="https://socialcountplus-instagram.herokuapp.com/" target="_blank">https://socialcountplus-instagram.herokuapp.com/</a>' );

		$tumblr_oauth_description = sprintf( __( 'Register an App on Tumblr in %s, when the app is ready click in "Explore API" and allow your app access your Tumblr account and get this data.', 'social-count-plus' ), '<a href="https://www.tumblr.com/oauth/apps" target="_blank">https://www.tumblr.com/oauth/apps</a>' );

		$settings = array(
			'socialcountplus_settings' => array(
				'comments' => array(
					'title'  => __( 'Comments', 'social-count-plus' ),
					'fields' => array(
						'comments_active' => array(
							'title'   => __( 'Display Comments Counter', 'social-count-plus' ),
							'default' => true,
							'type'    => 'checkbox'
						),
						'comments_url' => array(
							'title'   => __( 'URL', 'social-count-plus' ),
							'default' => get_home_url(),
							'type'    => 'text'
						)
					)
				),
				'facebook' => array(
					'title'  => __( 'Facebook', 'social-count-plus' ),
					'fields' => array(
						'facebook_active' => array(
							'title'   => __( 'Display Facebook Counter', 'social-count-plus' ),
							'type'    => 'checkbox'
						),
						'facebook_id'     => array(
							'title'       => __( 'Facebook Page ID', 'social-count-plus' ),
							'type'        => 'text',
							'description' => sprintf(
								'%s<br />%s<br /><code>https://www.facebook.com/pages/edit/?id=<strong>162354720442454</strong></code> %s <code>https://www.facebook.com/<strong>WordPress</strong></code>.',
								__( 'ID Facebook page. Must be the numeric ID or your page slug.', 'social-count-plus' ),
								__( 'You can find this data clicking to edit your page on Facebook. The URL will be similar to this:', 'social-count-plus' ),
								__( 'or', 'social-count-plus' )
							)
						),
						'facebook_app_id' => array(
							'title'       => __( 'Facebook App ID', 'social-count-plus' ),
							'type'        => 'text',
							'description' => $facebook_app_description
						),
						'facebook_app_secret' => array(
							'title'       => __( 'Facebook App Secret', 'social-count-plus' ),
							'type'        => 'text',
							'description' => $facebook_app_description
						)
					)
				),
				'github' => array(
					'title'  => __( 'GitHub', 'social-count-plus' ),
					'fields' => array(
						'github_active' => array(
							'title'   => __( 'Display GitHub Counter', 'social-count-plus' ),
							'type'    => 'checkbox'
						),
						'github_username' => array(
							'title'       => __( 'GitHub Username', 'social-count-plus' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Insert your GitHub username. Example: %s.', 'social-count-plus' ), '<code>claudiosmweb</code>' )
						),
					)
				),
				'googleplus' => array(
					'title'  => __( 'Google+', 'social-count-plus' ),
					'fields' => array(
						'googleplus_active' => array(
							'title' => __( 'Display Google+ Counter', 'social-count-plus' ),
							'type'  => 'checkbox'
						),
						'googleplus_id' => array(
							'title'       => __( 'Google+ ID', 'social-count-plus' ),
							'type'        => 'text',
							'description' => sprintf(
								'%s<br />%s <code>https://plus.google.com/<strong>106146333300678794719</strong></code> or <code>https://plus.google.com/<strong>+ClaudioSanches</strong></code>',
								__( 'Google+ page or profile ID.', 'social-count-plus' ),
								__( 'Example:', 'social-count-plus' )
							)
						),
						'googleplus_api_key' => array(
							'title'       => __( 'Google API Key', 'social-count-plus' ),
							'type'        => 'text',
							'description' => sprintf(
								__( 'Get your API key creating a project/app in %s, then inside your project go to "APIs & auth > APIs" and turn on the "Google+ API", finally go to "APIs & auth > APIs > Credentials > Public API access" and click in the "CREATE A NEW KEY" button, select the "Browser key" option and click in the "CREATE" button, now just copy your API key and paste here.', 'social-count-plus' ),
								'<a href="https://console.developers.google.com/project" target="_blank">https://console.developers.google.com/project</a>'
							)
						)
					)
				),
				'instagram' => array(
					'title'  => __( 'Instagram', 'social-count-plus' ),
					'fields' => array(
						'instagram_active' => array(
							'title' => __( 'Display Instagram Counter', 'social-count-plus' ),
							'type'  => 'checkbox'
						),
						'instagram_username' => array(
							'title'       => __( 'Instagram Username', 'social-count-plus' ),
							'type'        => 'text',
							'description' => __( 'Insert your Instagram Username.', 'social-count-plus' )
						),
						'instagram_user_id' => array(
							'title'       => __( 'Instagram User ID', 'social-count-plus' ),
							'type'        => 'text',
							'description' => __( 'Insert your Instagram User ID.', 'social-count-plus' ) . ' ' . $instagram_access_token
						),
						'instagram_access_token' => array(
							'title'       => __( 'Instagram Access Token', 'social-count-plus' ),
							'type'        => 'text',
							'description' => __( 'Insert your Instagram Access Token.', 'social-count-plus' ) . ' ' . $instagram_access_token
						)
					)
				),
				'linkedin' => array(
					'title'  => __( 'LinkedIn', 'social-count-plus' ),
					'fields' => array(
						'linkedin_active' => array(
							'title' => __( 'Display LinkedIn counter', 'social-count-plus' ),
							'type'  => 'checkbox'
						),
						'linkedin_company_id' => array(
							'title'       => __( 'LinkedIn Company ID', 'social-count-plus' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Insert your LinkedIn Company ID. Get your Company ID in %s.', 'social-count-plus' ), '<a href="https://socialcountplus-linkedin.herokuapp.com/" target="_blank">https://socialcountplus-linkedin.herokuapp.com/</a>' )
						),
						'linkedin_access_token' => array(
							'title'       => __( 'LinkedIn Access Token', 'social-count-plus' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Get your Access Token in %s.', 'social-count-plus' ), '<a href="https://socialcountplus-linkedin.herokuapp.com/" target="_blank">https://socialcountplus-linkedin.herokuapp.com/</a>' )
						)
					)
				),
				'pinterest' => array(
					'title'  => __( 'Pinterest', 'social-count-plus' ),
					'fields' => array(
						'pinterest_active' => array(
							'title' => __( 'Display Pinterest Counter', 'social-count-plus' ),
							'type'  => 'checkbox'
						),
						'pinterest_username' => array(
							'title'       => __( 'Pinterest Username', 'social-count-plus' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Insert your Pinterest username. Example: %s.', 'social-count-plus' ), '<code>claudiosmweb</code>' )
						)
					)
				),
				'posts' => array(
					'title'  => __( 'Posts', 'social-count-plus' ),
					'fields' => array(
						'posts_active' => array(
							'title'   => __( 'Display Posts Counter', 'social-count-plus' ),
							'default' => true,
							'type'    => 'checkbox'
						),
						'posts_post_type' => array(
							'title'   => __( 'Post Type', 'social-count-plus' ),
							'default' => 'post',
							'type'    => 'post_type'
						),
						'posts_url' => array(
							'title'   => __( 'URL', 'social-count-plus' ),
							'default' => get_home_url(),
							'type'    => 'text'
						)
					)
				),
				'soundcloud' => array(
					'title'  => __( 'SoundCloud', 'social-count-plus' ),
					'fields' => array(
						'soundcloud_active' => array(
							'title' => __( 'Display SoundCloud Counter', 'social-count-plus' ),
							'type'  => 'checkbox'
						),
						'soundcloud_username' => array(
							'title'       => __( 'SoundCloud Username', 'social-count-plus' ),
							'type'        => 'text',
							'description' => __( 'Insert your SoundCloud Username.', 'social-count-plus' )
						),
						'soundcloud_client_id' => array(
							'title'       => __( 'SoundCloud Client ID', 'social-count-plus' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Insert your SoundCloud App Client ID. Generate this data in %s.', 'social-count-plus' ), '<a href="http://soundcloud.com/you/apps/new" target="_blank">http://soundcloud.com/you/apps/new</a>' )
						)
					)
				),
				'steam' => array(
					'title'  => __( 'Steam', 'social-count-plus' ),
					'fields' => array(
						'steam_active' => array(
							'title' => __( 'Display Steam Counter', 'social-count-plus' ),
							'type'  => 'checkbox'
						),
						'steam_group_name' => array(
							'title'       => __( 'Steam Group Name', 'social-count-plus' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Insert your Steam Community group name. Example: %s.', 'social-count-plus' ), '<code>DOTALT</code>' )
						)
					)
				),
				'tumblr' => array(
					'title'  => __( 'Tumblr', 'social-count-plus' ),
					'fields' => array(
						'tumblr_active' => array(
							'title' => __( 'Display Tumblr counter', 'social-count-plus' ),
							'type'  => 'checkbox'
						),
						'tumblr_hostname' => array(
							'title'       => __( 'Tumblr Hostname', 'social-count-plus' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Insert your Tumblr Hostname. Example: %s.', 'social-count-plus' ), '<code>http://claudiosmweb.tumblr.com/</code>' )
						),
						'tumblr_consumer_key' => array(
							'title'       => __( 'Tumblr Consumer Key', 'social-count-plus' ),
							'type'        => 'text',
							'description' => $tumblr_oauth_description
						),
						'tumblr_consumer_secret' => array(
							'title'       => __( 'Tumblr Consumer Secret', 'social-count-plus' ),
							'type'        => 'text',
							'description' => $tumblr_oauth_description
						),
						'tumblr_token' => array(
							'title'       => __( 'Tumblr Token', 'social-count-plus' ),
							'type'        => 'text',
							'description' => $tumblr_oauth_description
						),
						'tumblr_token_secret' => array(
							'title'       => __( 'Tumblr Token Secret', 'social-count-plus' ),
							'type'        => 'text',
							'description' => $tumblr_oauth_description
						)
					)
				),
				'twitch' => array(
					'title'  => __( 'Twitch', 'social-count-plus' ),
					'fields' => array(
						'twitch_active' => array(
							'title' => __( 'Display Twitch Counter', 'social-count-plus' ),
							'type'  => 'checkbox'
						),
						'twitch_username' => array(
							'title'       => __( 'Twitch Username', 'social-count-plus' ),
							'type'        => 'text',
							'description' => __( 'Insert your Twitch username.', 'social-count-plus' )
						)
					)
				),
				'twitter' => array(
					'title'  => __( 'Twitter', 'social-count-plus' ),
					'fields' => array(
						'twitter_active' => array(
							'title'   => __( 'Display Twitter Counter', 'social-count-plus' ),
							'type'    => 'checkbox'
						),
						'twitter_user' => array(
							'title'       => __( 'Twitter Username', 'social-count-plus' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Insert the Twitter username. Example: %s.', 'social-count-plus' ), '<code>claudiosmweb</code>' )
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
				'users' => array(
					'title'  => __( 'Users', 'social-count-plus' ),
					'fields' => array(
						'users_active' => array(
							'title'   => __( 'Display Users Counter', 'social-count-plus' ),
							'default' => true,
							'type'    => 'checkbox'
						),
						'users_user_role' => array(
							'title'   => __( 'User Role', 'social-count-plus' ),
							'default' => 'subscriber',
							'type'    => 'user_role'
						),
						'users_label' => array(
							'title'   => __( 'Label', 'social-count-plus' ),
							'default' => __( 'users', 'social-count-plus' ),
							'type'    => 'text'
						),
						'users_url' => array(
							'title'   => __( 'URL', 'social-count-plus' ),
							'default' => get_home_url(),
							'type'    => 'text'
						)
					)
				),
				'vimeo' => array(
					'title'  => __( 'Vimeo', 'social-count-plus' ),
					'fields' => array(
						'vimeo_active' => array(
							'title' => __( 'Display Vimeo Counter', 'social-count-plus' ),
							'type'  => 'checkbox'
						),
						'vimeo_username' => array(
							'title'       => __( 'Vimeo Username', 'social-count-plus' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Insert your Vimeo username. Example: %s.', 'social-count-plus' ), '<code>claudiosmweb</code>' )
						)
					)
				),
				'youtube' => array(
					'title'  => __( 'YouTube', 'social-count-plus' ),
					'fields' => array(
						'youtube_active' => array(
							'title'   => __( 'Display YouTube Counter', 'social-count-plus' ),
							'type'    => 'checkbox'
						),
						'youtube_user' => array(
							'title'       => __( 'YouTube Channel ID', 'social-count-plus' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Insert the YouTube Channel ID. Example: %s.', 'social-count-plus' ), '<code>UCWGz8KbT5IE7PxhSN1jjimw</code>' )
						),
						'youtube_url' => array(
							'title'       => __( 'YouTube Channel URL', 'social-count-plus' ),
							'type'        => 'text',
							'description' => sprintf( __( 'Insert the YouTube channel URL. Example: %s.', 'social-count-plus' ), '<code>https://www.youtube.com/user/theclaudiosmweb</code>' )
						),
						'youtube_api_key' => array(
							'title'       => __( 'Google API Key', 'social-count-plus' ),
							'type'        => 'text',
							'description' => sprintf(
								__( 'Get your API key creating a project/app in %s, then inside your project go to "APIs & auth > APIs" and turn on the "YouTube API", finally go to "APIs & auth > APIs > Credentials > Public API access" and click in the "CREATE A NEW KEY" button, select the "Browser key" option and click in the "CREATE" button, now just copy your API key and paste here.', 'social-count-plus' ),
								'<a href="https://console.developers.google.com/project" target="_blank">https://console.developers.google.com/project</a>'
							)
						)
					)
				),
				'settings' => array(
					'title'  => __( 'Settings', 'social-count-plus' ),
					'fields' => array(
						'target_blank' => array(
							'title'       => __( 'Open URLs in new tab/window', 'social-count-plus' ),
							'type'        => 'checkbox',
							'description' => sprintf( __( 'This option add %s in all counters URLs.', 'social-count-plus' ), '<code>target="_blank"</code>' )
						),
						'rel_nofollow' => array(
							'title'       => __( 'Add nofollow in URLs', 'social-count-plus' ),
							'type'        => 'checkbox',
							'description' => sprintf( __( 'This option add %s in all counters URLs.', 'social-count-plus' ), '<code>rel="nofollow"</code>' )
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
							'default' => '0',
							'type'    => 'models',
							'options' => array( 0 ,1, 2, 3, 4, 5, 6, 7 )
						),
						'text_color' => array(
							'title'   => __( 'Text Color', 'social-count-plus' ),
							'default' => '#333333',
							'type'    => 'color'
						),
						'icons' => array(
							'title' => __( 'Order', 'social-count-plus' ),
							'type'  => 'icons_order',
							'description' => __( 'This option controls the order of the icons in the widget.', 'social-count-plus' )
						)
					)
				)
			)
		);

		return $settings;
	}

	/**
	 * Add plugin settings menu.
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
		if ( isset( $_GET['settings-updated'] ) && ! ( isset( $_GET['tab'] ) && 'design' == $_GET['tab'] ) ) {
			if ( true == $_GET['settings-updated'] ) {
				// Set transients.
				Social_Count_Plus_Generator::reset_count();

				// Set the icons order.
				$icons           = self::get_current_icons();
				$design          = get_option( 'socialcountplus_design', array() );
				$design['icons'] = implode( ',', $icons );
				update_option( 'socialcountplus_design', $design );
			}
		}

		include 'views/html-settings-page.php';
	}

	/**
	 * Plugin settings form fields.
	 */
	public function plugin_settings() {

		// Process the settings.
		foreach ( self::get_plugin_options() as $settings_id => $sections ) {

			// Create the sections.
			foreach ( $sections as $section_id => $section ) {
				add_settings_section(
					$section_id,
					$section['title'],
					array( $this, 'title_element_callback' ),
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
						case 'post_type':
							add_settings_field(
								$field_id,
								$field['title'],
								array( $this, 'post_type_element_callback' ),
								$settings_id,
								$section_id,
								array(
									'tab'         => $settings_id,
									'id'          => $field_id,
									'description' => isset( $field['description'] ) ? $field['description'] : ''
								)
							);
							break;
						case 'user_role':
							add_settings_field(
								$field_id,
								$field['title'],
								array( $this, 'user_role_element_callback' ),
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
						case 'icons_order':
							add_settings_field(
								$field_id,
								$field['title'],
								array( $this, 'icons_order_element_callback' ),
								$settings_id,
								$section_id,
								array(
									'tab'         => $settings_id,
									'id'          => $field_id,
									'description' => isset( $field['description'] ) ? $field['description'] : ''
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
	 * Title element callback.
	 *
	 * @param array $args Field arguments.
	 */
	public function title_element_callback( $args ) {
		echo ! empty( $args['id'] ) ? '<div id="section-' . esc_attr( $args['id'] ) . '"></div>' : '';
	}

	/**
	 * Text element callback.
	 *
	 * @param array $args Field arguments.
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
	 * Checkbox field callback.
	 *
	 * @param array $args Field arguments.
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
	 * Post Type element callback.
	 *
	 * @param array $args Field arguments.
	 */
	public function post_type_element_callback( $args ) {
		$tab     = $args['tab'];
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : 'post';
		$current = $this->get_option_value( $id, $default );
		$html    = '';

		$html = sprintf( '<select id="%1$s" name="%2$s[%1$s]">', $id, $tab );
		foreach ( get_post_types( array( 'public' => true ), 'objects' ) as $key => $value ) {
			$html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $current, $key, false ), $value->label );
		}
		$html .= '</select>';

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * User Role element callback.
	 *
	 * @param array $args Field arguments.
	 */
	public function user_role_element_callback( $args ) {
		global $wp_roles;

		$tab     = $args['tab'];
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : 'subscriber';
		$current = $this->get_option_value( $id, $default );
		$html    = '';

		$html = sprintf( '<select id="%1$s" name="%2$s[%1$s]">', $id, $tab );
		foreach ( $wp_roles->get_names() as $key => $value ) {
			$html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $current, $key, false ), $value );
		}
		$html .= sprintf( '<option value="%s"%s>%s</option>', 'all', selected( $current, 'all', false ), __( 'All Roles', 'social-count-plus' ) );
		$html .= '</select>';

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Models element callback.
	 *
	 * @param array $args Field arguments.
	 */
	public function models_element_callback( $args ) {
		$tab     = $args['tab'];
		$id      = $args['id'];
		$default = isset( $args['default'] ) ? $args['default'] : 0;
		$current = $this->get_option_value( $id, $default );
		$html    = '';

		foreach ( $args['options'] as $option ) {
			$html .= sprintf( '<input type="radio" name="%1$s[%2$s]" class="social-count-plus-model-input" value="%3$s"%4$s />', $tab, $id, $option, checked( $current, $option, false ) );

			$style = Social_Count_Plus_View::get_view_model( $option );

			$html .= '<div class="social-count-plus">';
				$html .= '<ul class="' . $style . '">';

					foreach ( $this->get_i18n_counters() as $slug => $name ) {
						$class = 'social_count_plus_' . $slug . '_counter';
						if ( class_exists( $class ) ) {
							$_class = new $class();

							$html .= $_class->get_view( array(), 100, '#333333' );
						}
					}

				$html .= '</ul>';
			$html .= '</div>';
		}

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Icons order element callback.
	 *
	 * @param array $args Field arguments.
	 */
	public function icons_order_element_callback( $args ) {
		$tab       = $args['tab'];
		$id        = $args['id'];
		$current   = $this->get_option_value( $id );
		$html      = '';

		$html .= '<div class="social-count-plus-icons-order">';
		$html .= sprintf( '<input type="hidden" id="%1$s" name="%2$s[%1$s]" value="%3$s" />', $id, $tab, $current );
		foreach ( explode( ',', $current ) as $icon ) {
			$html .= '<div class="social-icon" data-icon="' . $icon . '">' . $this->get_icon_name_i18n( $icon ) . '</div>';
		}
		$html .= '</div>';

		// Displays option description.
		if ( isset( $args['description'] ) ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Color element callback.
	 *
	 * @param array $args Field arguments.
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
	 */
	public function styles_and_scripts() {
		$screen = get_current_screen();

		if ( $this->settings_screen && $screen->id === $this->settings_screen ) {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			wp_enqueue_style( 'social-count-plus', plugins_url( 'assets/css/counter.css', plugin_dir_path( dirname( __FILE__ ) ) ), array(), Social_Count_Plus::VERSION, 'all' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_style( 'social-count-plus-admin', plugins_url( 'assets/css/admin.css', plugin_dir_path( dirname( __FILE__ ) ) ), array(), Social_Count_Plus::VERSION, 'all' );
			wp_enqueue_script( 'social-count-plus-admin', plugins_url( 'assets/js/admin' . $suffix . '.js', plugin_dir_path( dirname( __FILE__ ) ) ), array( 'jquery', 'wp-color-picker' ), Social_Count_Plus::VERSION, true );
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

	/**
	 * Generate a system report file.
	 *
	 * @return string
	 */
	public function report_file() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( ! isset( $_GET['page'] ) || ! isset( $_GET['tab'] ) || ! isset( $_GET['debug_file'] ) ) {
			return;
		}

		@ob_clean();

		$debug    = array();
		$settings = get_option( 'socialcountplus_settings' );
		$cache    = get_option( Social_Count_Plus_Generator::$cache );
		$content  = '';
		$counters = apply_filters( 'social_count_plus_counters_test', array(
			'Social_Count_Plus_Facebook_Counter',
			'Social_Count_Plus_GitHub_Counter',
			'Social_Count_Plus_GooglePlus_Counter',
			'Social_Count_Plus_Instagram_Counter',
			'Social_Count_Plus_LinkedIn_Counter',
			'Social_Count_Plus_Pinterest_Counter',
			'Social_Count_Plus_SoundCloud_Counter',
			'Social_Count_Plus_Steam_Counter',
			'Social_Count_Plus_Tumblr_Counter',
			'Social_Count_Plus_Twitch_Counter',
			'Social_Count_Plus_Twitter_Counter',
			'Social_Count_Plus_Vimeo_Counter',
			'Social_Count_Plus_YouTube_Counter',
		) );

		foreach ( $counters as $counter ) {
			$_counter = new $counter();

			if ( $_counter->is_available( $settings ) ) {
				$_counter->get_total( $settings, $cache );
				$debug[ $_counter->id ] = $_counter->debug();
			}
		}

		// Set the content.
		$content .= '# ' .  __( 'General Info', 'social-count-plus' ) . ' #' . PHP_EOL . PHP_EOL;
		$content .= __( 'Social Count Plus Version', 'social-count-plus' ) . ': ' . Social_Count_Plus::VERSION . PHP_EOL;
		$content .= __( 'WordPress Version', 'social-count-plus' ) . ': ' . esc_attr( get_bloginfo( 'version' ) ) . PHP_EOL;
		$content .= __( 'WP Multisite Enabled', 'social-count-plus' ) . ': ' . ( ( is_multisite() ) ? __( 'Yes', 'social-count-plus' ) : __( 'No', 'social-count-plus' ) ) . PHP_EOL;
		$content .= __( 'Web Server Info', 'social-count-plus' ) . ': ' . esc_html( $_SERVER['SERVER_SOFTWARE'] ) . PHP_EOL;
		$content .= __( 'PHP Version', 'social-count-plus' ) . ': ' . ( function_exists( 'phpversion' ) ? esc_html( phpversion() ) : '' ) . PHP_EOL;
		$content .= 'fsockopen: ' . ( function_exists( 'fsockopen' ) ? __( 'Yes', 'social-count-plus' ) : __( 'No', 'social-count-plus' ) ) . PHP_EOL;
		$content .= 'cURL: ' . ( function_exists( 'curl_init' ) ? __( 'Yes', 'social-count-plus' ) : __( 'No', 'social-count-plus' ) ) . PHP_EOL . PHP_EOL;
		$content .= '# ' . __( 'Social Connections', 'social-count-plus' ) . ' #';
		$content .= PHP_EOL . PHP_EOL;

		if ( ! empty( $debug ) ) {
			foreach ( $debug as $key => $value ) {
				$content .= '### ' . strtoupper( esc_attr( $key ) ) . ' ###' . PHP_EOL;
				$content .= print_r( $value, true );
				$content .= PHP_EOL . PHP_EOL;
			}
		} else {
			$content .= __( 'You do not have any counter that needs to connect remotely currently active', 'social-count-plus' );
		}

		header( 'Cache-Control: public' );
		header( 'Content-Description: File Transfer' );
		header( 'Content-Disposition: attachment; filename=social-count-plus-debug-' . date( 'y-m-d-H-i' ) . '.txt' );
		header( 'Content-Type: text/plain' );
		header( 'Content-Transfer-Encoding: binary' );

		echo $content;
		exit;
	}

	/**
	 * Maybe install.
	 */
	public static function maybe_install() {
		$version = get_option( 'socialcountplus_version', '0' );

		if ( version_compare( $version, Social_Count_Plus::VERSION, '<' ) ) {

			// Install options and updated old versions for 3.0.0.
			if ( version_compare( $version, '3.0.0', '<' ) ) {
				foreach ( self::get_plugin_options() as $settings_id => $sections ) {
					$saved = get_option( $settings_id, array() );

					foreach ( $sections as $section_id => $section ) {
						foreach ( $section['fields'] as $field_id => $field ) {
							$default = isset( $field['default'] ) ? $field['default'] : '';

							if ( isset( $saved[ $field_id ] ) || '' === $default ) {
								continue;
							}

							$saved[ $field_id ] = $default;
						}
					}

					update_option( $settings_id, $saved );
				}

				// Set the icons order.
				$icons           = self::get_current_icons();
				$design          = get_option( 'socialcountplus_design', array() );
				$design['icons'] = implode( ',', $icons );
				update_option( 'socialcountplus_design', $design );
			}

			// Save plugin version.
			update_option( 'socialcountplus_version', Social_Count_Plus::VERSION );

			// Reset the counters.
			Social_Count_Plus_Generator::reset_count();
		}
	}

	/**
	 * Get current icons.
	 *
	 * @return array
	 */
	protected static function get_current_icons() {
		$settings = get_option( 'socialcountplus_settings', array() );
		$design   = get_option( 'socialcountplus_design', array() );
		$current  = isset( $design['icons'] ) ? explode( ',', $design['icons'] ) : array();
		$icons    = array();

		if ( function_exists( 'preg_filter' ) ) {
			$saved = array_values( preg_filter('/^(.*)_active/', '$1', array_keys( $settings ) ) );
		} else {
			$saved = array_values( array_diff( preg_replace( '/^(.*)_active/', '$1', array_keys( $settings ) ), array_keys( $settings ) ) );
		}

		$icons = array_unique( array_filter( array_merge( $current, $saved ) ) );

		// Exclude extra values.
		$diff = array_diff( $current, $saved );
		foreach ( $diff as $key => $value ) {
			unset( $icons[ $key ] );
		}

		return $icons;
	}

	/**
	 * Get i18n counters.
	 *
	 * @return array
	 */
	public function get_i18n_counters() {
		return apply_filters( 'social_count_plus_icon_name_i18n', array(
			'comments'   => __( 'Comments', 'social-count-plus' ),
			'facebook'   => __( 'Facebook', 'social-count-plus' ),
			'github'     => __( 'GitHub', 'social-count-plus' ),
			'googleplus' => __( 'Google+', 'social-count-plus' ),
			'instagram'  => __( 'Instagram', 'social-count-plus' ),
			'linkedin'   => __( 'LinkedIn', 'social-count-plus' ),
			'pinterest'  => __( 'Pinterest', 'social-count-plus' ),
			'posts'      => __( 'Posts', 'social-count-plus' ),
			'soundcloud' => __( 'SoundCloud', 'social-count-plus' ),
			'steam'      => __( 'Steam', 'social-count-plus' ),
			'tumblr'     => __( 'Tumblr', 'social-count-plus' ),
			'twitch'     => __( 'Twitch', 'social-count-plus' ),
			'twitter'    => __( 'Twitter', 'social-count-plus' ),
			'users'      => __( 'Users', 'social-count-plus' ),
			'vimeo'      => __( 'Vimeo', 'social-count-plus' ),
			'youtube'    => __( 'YouTube', 'social-count-plus' ),
		) );
	}

	/**
	 * Get icons names.
	 *
	 * @param  string $slug
	 *
	 * @return string
	 */
	protected function get_icon_name_i18n( $slug ) {
		$names = $this->get_i18n_counters();

		if ( ! isset( $names[ $slug ] ) ) {
			return $slug;
		}

		return $names[ $slug ];
	}
}

new Social_Count_Plus_Admin;
