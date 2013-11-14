<?php
/**
 * Plugin Name: Social Count Plus
 * Plugin URI: https://github.com/claudiosmweb/social-count-plus
 * Description: Display the counting Twitter followers, Facebook fans, YouTube subscribers posts and comments.
 * Author: claudiosanches, felipesantana
 * Author URI: http://claudiosmweb.com/
 * Version: 2.7.5
 * License: GPLv2 or later
 * Text Domain: social-count-plus
 * Domain Path: /languages/
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

// Sets the plugin path.
define( 'SOCIAL_COUNT_PLUS_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Social_Count_Plus class.
 */
class Social_Count_Plus {

    /**
     * Class construct.
     */
    public function __construct( $counter ) {
        $this->counter = $counter;

        // Load textdomain.
        add_action( 'plugins_loaded', array( &$this, 'languages' ), 0 );

        // Adds admin menu.
        add_action( 'admin_menu', array( &$this, 'menu' ) );

        // Init plugin options form.
        add_action( 'admin_init', array( &$this, 'plugin_settings' ) );

        // Reset transients when save a post.
        // add_action( 'publish_post', array( &$this, 'reset_transients' ) );

        // Scripts.
        add_action( 'wp_enqueue_scripts', array( &$this, 'scripts' ) );
        add_action( 'admin_enqueue_scripts', array( &$this, 'admin_scripts' ) );

        // Adds shortcode.
        add_shortcode( 'scp', array( &$this, 'shortcode' ) );

        // Install default settings.
        register_activation_hook( __FILE__, array( &$this, 'install' ) );

        // Actions links.
        add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( &$this, 'action_links' ) );
    }

    /**
     * Load translations.
     */
    public function languages() {
        load_plugin_textdomain( 'social-count-plus', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
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
     * Register scripts.
     */
    public function scripts() {
        wp_enqueue_style( 'socialcountplus-style', plugins_url( 'assets/css/counter.css', __FILE__ ), array(), '2.0', 'all' );
    }

    /**
     * Register admin scripts.
     */
    public function admin_scripts() {
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'socialcountplus-admin', plugins_url( 'assets/js/admin.min.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), null, true );
    }

    /**
     * Sets default settings
     *
     * @return array Plugin default settings.
     */
    protected function default_settings() {

        $twitter_oauth_description = sprintf( __( 'Create an APP on Twitter in %s and get this information', 'social-count-plus' ), '<a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a>' );

        $instagram_access_token = sprintf( __( 'Get the this information in %s', 'social-count-plus' ), '<a href="http://www.pinceladasdaweb.com.br/instagram/access-token/" target="_blank">http://www.pinceladasdaweb.com.br/instagram/access-token/</a>' );

        $settings = array(
            'twitter' => array(
                'title' => __( 'Twitter', 'social-count-plus' ),
                'type' => 'section',
                'menu' => 'socialcountplus_settings'
            ),
            'twitter_active' => array(
                'title' => __( 'Display Twitter counter', 'social-count-plus' ),
                'default' => null,
                'type' => 'checkbox',
                'section' => 'twitter',
                'menu' => 'socialcountplus_settings'
            ),
            'twitter_user' => array(
                'title' => __( 'Twitter username', 'social-count-plus' ),
                'default' => null,
                'type' => 'text',
                'description' => __( 'Insert the Twitter username. Example: ferramentasblog', 'social-count-plus' ),
                'section' => 'twitter',
                'menu' => 'socialcountplus_settings'
            ),
            'twitter_consumer_key' => array(
                'title' => __( 'Twitter Consumer key', 'social-count-plus' ),
                'default' => null,
                'type' => 'text',
                'description' => $twitter_oauth_description,
                'section' => 'twitter',
                'menu' => 'socialcountplus_settings'
            ),
            'twitter_consumer_secret' => array(
                'title' => __( 'Twitter Consumer secret', 'social-count-plus' ),
                'default' => null,
                'type' => 'text',
                'description' => $twitter_oauth_description,
                'section' => 'twitter',
                'menu' => 'socialcountplus_settings'
            ),
            'twitter_access_token' => array(
                'title' => __( 'Twitter Access token', 'social-count-plus' ),
                'default' => null,
                'type' => 'text',
                'description' => $twitter_oauth_description,
                'section' => 'twitter',
                'menu' => 'socialcountplus_settings'
            ),
            'twitter_access_token_secret' => array(
                'title' => __( 'Twitter Access token secret', 'social-count-plus' ),
                'default' => null,
                'type' => 'text',
                'description' => $twitter_oauth_description,
                'section' => 'twitter',
                'menu' => 'socialcountplus_settings'
            ),
            'facebook' => array(
                'title' => __( 'Facebook', 'social-count-plus' ),
                'type' => 'section',
                'menu' => 'socialcountplus_settings'
            ),
            'facebook_active' => array(
                'title' => __( 'Display Facebook counter', 'social-count-plus' ),
                'default' => null,
                'type' => 'checkbox',
                'section' => 'facebook',
                'menu' => 'socialcountplus_settings'
            ),
            'facebook_id' => array(
                'title' => __( 'Facebook Page ID', 'social-count-plus' ),
                'default' => null,
                'type' => 'text',
                'description' => __( 'ID Facebook page. Must be the numeric ID.<br />You can find this information clicking to edit your page on Facebook. The URL will be similar to this:<br />https://www.facebook.com/pages/edit/?id=<strong>162354720442454</strong>', 'social-count-plus' ),
                'section' => 'facebook',
                'menu' => 'socialcountplus_settings'
            ),
            'youtube' => array(
                'title' => __( 'YouTube', 'social-count-plus' ),
                'type' => 'section',
                'menu' => 'socialcountplus_settings'
            ),
            'youtube_active' => array(
                'title' => __( 'Display YouTube counter', 'social-count-plus' ),
                'default' => null,
                'type' => 'checkbox',
                'section' => 'youtube',
                'menu' => 'socialcountplus_settings'
            ),
            'youtube_user' => array(
                'title' => __( 'YouTube username', 'social-count-plus' ),
                'default' => null,
                'type' => 'text',
                'description' => __( 'Insert the YouTube username. Example: lemos81', 'social-count-plus' ),
                'section' => 'youtube',
                'menu' => 'socialcountplus_settings'
            ),
            'googleplus' => array(
                'title' => __( 'Google Plus', 'social-count-plus' ),
                'type' => 'section',
                'menu' => 'socialcountplus_settings'
            ),
            'googleplus_active' => array(
                'title' => __( 'Display Google Plus counter', 'social-count-plus' ),
                'default' => null,
                'type' => 'checkbox',
                'section' => 'googleplus',
                'menu' => 'socialcountplus_settings'
            ),
            'googleplus_id' => array(
                'title' => __( 'Google Plus page ID', 'social-count-plus' ),
                'default' => null,
                'type' => 'text',
                'description' => __( 'Google Plus page ID. Must be the numeric ID.<br />You can find this information clicking to edit your page on Google Plus. The URL will be similar to this:<br />https://plus.google.com/<strong>115161266310935247804</strong>', 'social-count-plus' ),
                'section' => 'googleplus',
                'menu' => 'socialcountplus_settings'
            ),
            'instagram' => array(
                'title' => __( 'Instagram', 'social-count-plus' ),
                'type' => 'section',
                'menu' => 'socialcountplus_settings'
            ),
            'instagram_active' => array(
                'title' => __( 'Display Instagram counter', 'social-count-plus' ),
                'default' => null,
                'type' => 'checkbox',
                'section' => 'instagram',
                'menu' => 'socialcountplus_settings'
            ),
            'instagram_username' => array(
                'title' => __( 'Instagram Username', 'social-count-plus' ),
                'default' => null,
                'type' => 'text',
                'description' => __( 'Insert the Instagram Username.', 'social-count-plus' ),
                'section' => 'instagram',
                'menu' => 'socialcountplus_settings'
            ),
            'instagram_user_id' => array(
                'title' => __( 'Instagram User ID', 'social-count-plus' ),
                'default' => null,
                'type' => 'text',
                'description' => __( 'Insert the Instagram User ID.', 'social-count-plus' ) . ' ' . $instagram_access_token,
                'section' => 'instagram',
                'menu' => 'socialcountplus_settings'
            ),
            'instagram_access_token' => array(
                'title' => __( 'Instagram Access Token', 'social-count-plus' ),
                'default' => null,
                'type' => 'text',
                'description' => __( 'Insert the Instagram Access Token.', 'social-count-plus' ) . ' ' . $instagram_access_token,
                'section' => 'instagram',
                'menu' => 'socialcountplus_settings'
            ),
            'steam' => array(
                'title' => __( 'Steam', 'social-count-plus' ),
                'type' => 'section',
                'menu' => 'socialcountplus_settings'
            ),
            'steam_active' => array(
                'title' => __( 'Display Steam counter', 'social-count-plus' ),
                'default' => null,
                'type' => 'checkbox',
                'section' => 'steam',
                'menu' => 'socialcountplus_settings'
            ),
            'steam_group_name' => array(
                'title' => __( 'Steam group name', 'social-count-plus' ),
                'default' => null,
                'type' => 'text',
                'description' => __( 'Insert the Steam Community group name. Example: DOTALT', 'social-count-plus' ),
                'section' => 'steam',
                'menu' => 'socialcountplus_settings'
            ),
            'soundcloud' => array(
                'title' => __( 'SoundCloud', 'social-count-plus' ),
                'type' => 'section',
                'menu' => 'socialcountplus_settings'
            ),
            'soundcloud_active' => array(
                'title' => __( 'Display SoundCloud counter', 'social-count-plus' ),
                'default' => null,
                'type' => 'checkbox',
                'section' => 'soundcloud',
                'menu' => 'socialcountplus_settings'
            ),
            'soundcloud_username' => array(
                'title' => __( 'SoundCloud Username', 'social-count-plus' ),
                'default' => null,
                'type' => 'text',
                'description' => __( 'Insert the SoundCloud Username.', 'social-count-plus' ),
                'section' => 'soundcloud',
                'menu' => 'socialcountplus_settings'
            ),
            'soundcloud_client_id' => array(
                'title' => __( 'SoundCloud Client ID', 'social-count-plus' ),
                'default' => null,
                'type' => 'text',
                'description' => sprintf( __( 'Insert the SoundCloud APP Client ID. Generate this information in %s', 'social-count-plus' ), '<a href="http://soundcloud.com/you/apps/new" target="_blank">http://soundcloud.com/you/apps/new</a>' ),
                'section' => 'soundcloud',
                'menu' => 'socialcountplus_settings'
            ),
            'posts' => array(
                'title' => __( 'Posts', 'social-count-plus' ),
                'type' => 'section',
                'menu' => 'socialcountplus_settings'
            ),
            'posts_active' => array(
                'title' => __( 'Display Posts counter', 'social-count-plus' ),
                'default' => 1,
                'type' => 'checkbox',
                'section' => 'posts',
                'menu' => 'socialcountplus_settings'
            ),
            'comments' => array(
                'title' => __( 'Comments', 'social-count-plus' ),
                'type' => 'section',
                'menu' => 'socialcountplus_settings'
            ),
            'comments_active' => array(
                'title' => __( 'Display Comments counter', 'social-count-plus' ),
                'default' => 1,
                'type' => 'checkbox',
                'section' => 'comments',
                'menu' => 'socialcountplus_settings'
            ),
            'design' => array(
                'title' => __( 'Design', 'social-count-plus' ),
                'type' => 'section',
                'menu' => 'socialcountplus_design'
            ),
            'models' => array(
                'title' => __( 'Layout Models', 'social-count-plus' ),
                'default' => 0,
                'type' => 'models',
                'options' => array(
                    'design-default.png',
                    'design-default-vertical.png',
                    'design-circle.png',
                    'design-circle-vertical.png',
                    'design-flat.png',
                    'design-flat-vertical.png',
                ),
                'section' => 'design',
                'menu' => 'socialcountplus_design'
            ),
            'text_color' => array(
                'title' => __( 'Text Color', 'social-count-plus' ),
                'default' => '#333333',
                'type' => 'color',
                'section' => 'design',
                'menu' => 'socialcountplus_design'
            )
        );

        return $settings;
    }

    /**
     * Installs default settings on plugin activation.
     */
    public function install() {
        $settings = array();
        $design = array();

        foreach ( $this->default_settings() as $key => $value ) {
            if ( 'section' != $value['type'] ) {
                if ( 'socialcountplus_design' == $value['menu'] )
                    $design[ $key ] = $value['default'];
                else
                    $settings[ $key ] = $value['default'];
            }
        }

        add_option( 'socialcountplus_settings', $settings );
        add_option( 'socialcountplus_design', $design );
    }

    /**
     * Update plugin settings.
     */
    public function update() {
        if ( get_option( 'scp_show_twitter' ) ) {

            $settings = array(
                'twitter_active'         => ( 'true' == get_option( 'scp_show_twitter' ) ) ? 1 : '',
                'twitter_user'           => get_option( 'scp_twitter' ),
                'facebook_active'        => ( 'true' == get_option( 'scp_show_facebook' ) ) ? 1 : '',
                'facebook_id'            => get_option( 'scp_facebook' ),
                // 'youtube_active'         => '',
                'youtube_user'           => '',
                // 'googleplup_active'      => '',
                'googleplus_id'          => '',
                // 'instagram_active'       => '',
                'instagram_username'     => '',
                'instagram_user_id'      => '',
                'instagram_access_token' => '',
                // 'steam_active'           => '',
                'steam_group_name'       => '',
                // 'soundcloud_active'      => '',
                'soundcloud_username'    => '',
                'soundcloud_client_id'   => '',
                'posts_active'           => ( 'true' == get_option( 'scp_show_posts' ) ) ? 1 : '',
                'comments_active'        => ( 'true' == get_option( 'scp_show_comment' ) ) ? 1 : '',
            );

            $model = 0;
            switch ( get_option( 'scp_layout' ) ) {
                case 'vertical-square':
                    $model = 1;
                    break;
                case 'circle':
                    $model = 2;
                    break;
                case 'vertical-circle':
                    $model = 3;
                    break;

                default:
                    $model = 0;
                    break;
            }

            $design = array(
                'models' => $model
            );

            // Updates options
            update_option( 'socialcountplus_settings', $settings );
            update_option( 'socialcountplus_design', $design );

            // Removes old options.
            delete_option( 'scp_feed');
            delete_option( 'scp_twitter' );
            delete_option( 'scp_facebook' );
            delete_option( 'scp_show_feed' );
            delete_option( 'scp_show_twitter' );
            delete_option( 'scp_show_facebook' );
            delete_option( 'scp_show_posts' );
            delete_option( 'scp_show_comment' );
            delete_option( 'scp_layout' );
            delete_option( 'scp_feed_cache' );
            delete_option( 'scp_twitter_cache' );
            delete_option( 'scp_facebook_cache' );
            delete_transient( 'fan_count' );
            delete_transient( 'follower_count' );
            delete_transient( 'feed_count' );
            delete_transient( 'posts_count' );
            delete_transient( 'comments_count' );

        } else {
            $settings_options = get_option( 'socialcountplus_settings' );

            if ( isset( $settings_options['twitter_user'] ) && ! isset( $settings_options['instagram_username'] ) ) {
                // Update to version 2.7.0.
                $new_options = array(
                    'instagram_username'     => '',
                    'instagram_user_id'      => '',
                    'instagram_access_token' => '',
                    'steam_group_name'       => '',
                    'soundcloud_username'    => '',
                    'soundcloud_client_id'   => '',
                );

                update_option( 'socialcountplus_settings', array_merge( $new_options, $settings ) );
            } else {
                // Install default options.
                $this->install();
            }
        }
    }

    /**
     * Add plugin settings menu.
     */
    public function menu() {
        add_options_page(
            __( 'Social Count Plus', 'social-count-plus' ),
            __( 'Social Count Plus', 'social-count-plus' ),
            'manage_options',
            'social-count-plus',
            array( &$this, 'settings_page' )
        );
    }

    /**
     * Plugin settings page.
     */
    public function settings_page() {
        $settings = get_option( 'socialcountplus_settings' );

        // Create tabs current class.
        $current_tab = '';
        if ( isset( $_GET['tab'] ) )
            $current_tab = $_GET['tab'];
        else
            $current_tab = 'settings';

        // Reset transients when save settings page.
        if ( isset( $_GET['settings-updated'] ) ) {
            if ( true == $_GET['settings-updated'] )
                $this->counter->reset_transients();
        }

        ?>

        <div class="wrap">
            <?php screen_icon( 'options-general' ); ?>
            <h2 class="nav-tab-wrapper">
                <a href="admin.php?page=social-count-plus&amp;tab=settings" class="nav-tab <?php echo $current_tab == 'settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Settings', 'social-count-plus' ); ?></a><a href="admin.php?page=social-count-plus&amp;tab=design" class="nav-tab <?php echo $current_tab == 'design' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Design', 'social-count-plus' ); ?></a><a href="admin.php?page=social-count-plus&amp;tab=shortcodes" class="nav-tab <?php echo $current_tab == 'shortcodes' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Shortcodes and Functions', 'social-count-plus' ); ?></a>
            </h2>

            <?php
                if ( isset( $settings['twitter_active'] ) && (
                    empty( $settings['twitter_user'] )
                    || empty( $settings['twitter_consumer_key'] )
                    || empty( $settings['twitter_consumer_secret'] )
                    || empty( $settings['twitter_access_token'] )
                    || empty( $settings['twitter_access_token_secret'] )
                ) ) :
             ?>
                <div class="error">
                    <p><?php _e( 'To use the counter of Twitter you need to fill the fields:', 'social-count-plus' ); ?></p>
                    <ul style="list-style: disc; margin-left: 20px;">
                        <li><strong><?php _e( 'Twitter username', 'social-count-plus' ); ?></strong></li>
                        <li><strong><?php _e( 'Twitter Consumer key', 'social-count-plus' ); ?></strong></li>
                        <li><strong><?php _e( 'Twitter Consumer secret', 'social-count-plus' ); ?></strong></li>
                        <li><strong><?php _e( 'Twitter Access token', 'social-count-plus' ); ?></strong></li>
                        <li><strong><?php _e( 'Twitter Access token secret', 'social-count-plus' ); ?></strong></li>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" action="options.php">
                <?php
                    if ( 'design' == $current_tab ) {
                        settings_fields( 'socialcountplus_design' );
                        do_settings_sections( 'socialcountplus_design' );
                        submit_button();
                    } else if ( 'shortcodes' == $current_tab ) {
                        $this->page_shortcodes();
                    } else {
                        settings_fields( 'socialcountplus_settings' );
                        do_settings_sections( 'socialcountplus_settings' );
                        submit_button();
                    }
                ?>
            </form>
        </div>

        <?php
    }

    /**
     * Shortcode pages.
     */
    private function page_shortcodes() {
        $html = '<p>' . __( 'Use this library to generate your own model layout or display specific data counters.', 'social-count-plus' ) . '</p>';

        $html .= '<h3>' . __( 'Shortcodes', 'social-count-plus' ) . '</h3>';

        $html .= '<table class="form-table">';
            $html .= '<tr>';
                $html .= '<th scope="row">' . __( 'Twitter counter', 'social-count-plus' ) . '</th>';
                $html .= '<td><p><code>[scp code=&quot;twitter&quot;]</code></p></td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<th scope="row">' . __( 'Facebook counter', 'social-count-plus' ) . '</th>';
                $html .= '<td><p><code>[scp code=&quot;facebook&quot;]</code></p></td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<th scope="row">' . __( 'YouTube counter', 'social-count-plus' ) . '</th>';
                $html .= '<td><p><code>[scp code=&quot;youtube&quot;]</code></p></td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<th scope="row">' . __( 'Google Plus counter', 'social-count-plus' ) . '</th>';
                $html .= '<td><p><code>[scp code=&quot;googleplus&quot;]</code></p></td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<th scope="row">' . __( 'Instagram counter', 'social-count-plus' ) . '</th>';
                $html .= '<td><p><code>[scp code=&quot;instagram&quot;]</code></p></td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<th scope="row">' . __( 'Steam counter', 'social-count-plus' ) . '</th>';
                $html .= '<td><p><code>[scp code=&quot;steam&quot;]</code></p></td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<th scope="row">' . __( 'SoundCloud counter', 'social-count-plus' ) . '</th>';
                $html .= '<td><p><code>[scp code=&quot;soundcloud&quot;]</code></p></td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<th scope="row">' . __( 'Posts counter', 'social-count-plus' ) . '</th>';
                $html .= '<td><p><code>[scp code=&quot;posts&quot;]</code></p></td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<th scope="row">' . __( 'Comments counter', 'social-count-plus' ) . '</th>';
                $html .= '<td><p><code>[scp code=&quot;comments&quot;]</code></p></td>';
            $html .= '</tr>';
        $html .= '</table>';

        $html .= '<h3>' . __( 'Functions', 'social-count-plus' ) . '</h3>';

        $html .= '<table class="form-table">';
            $html .= '<tr>';
                $html .= '<th scope="row">' . __( 'Twitter counter', 'social-count-plus' ) . '</th>';
                $html .= '<td><p><code>&lt;?php echo get_scp_twitter(); ?&gt;</code></p></td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<th scope="row">' . __( 'Facebook counter', 'social-count-plus' ) . '</th>';
                $html .= '<td><p><code>&lt;?php echo get_scp_facebook(); ?&gt;</code></p></td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<th scope="row">' . __( 'YouTube counter', 'social-count-plus' ) . '</th>';
                $html .= '<td><p><code>&lt;?php echo get_scp_youtube(); ?&gt;</code></p></td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<th scope="row">' . __( 'Google Plus counter', 'social-count-plus' ) . '</th>';
                $html .= '<td><p><code>&lt;?php echo get_scp_googleplus(); ?&gt;</code></p></td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<th scope="row">' . __( 'Instagram counter', 'social-count-plus' ) . '</th>';
                $html .= '<td><p><code>&lt;?php echo get_scp_instagram(); ?&gt;</code></p></td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<th scope="row">' . __( 'Steam counter', 'social-count-plus' ) . '</th>';
                $html .= '<td><p><code>&lt;?php echo get_scp_steam(); ?&gt;</code></p></td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<th scope="row">' . __( 'SoundCloud counter', 'social-count-plus' ) . '</th>';
                $html .= '<td><p><code>&lt;?php echo get_scp_soundcloud(); ?&gt;</code></p></td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<th scope="row">' . __( 'Posts counter', 'social-count-plus' ) . '</th>';
                $html .= '<td><p><code>&lt;?php echo get_scp_posts(); ?&gt;</code></p></td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<th scope="row">' . __( 'Comments counter', 'social-count-plus' ) . '</th>';
                $html .= '<td><p><code>&lt;?php echo get_scp_comments(); ?&gt;</code></p></td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<th scope="row">' . __( 'Full widget', 'social-count-plus' ) . '</th>';
                $html .= '<td><p><code>&lt;?php echo get_scp_widget(); ?&gt;</code></p></td>';
            $html .= '</tr>';
        $html .= '</table>';

        echo $html;
    }

    /**
     * Plugin settings form fields.
     */
    public function plugin_settings() {
        $design = 'socialcountplus_design';
        $settings = 'socialcountplus_settings';
        $settings_options = get_option( $settings );

        // Create option in wp_options.
        if ( false == $settings_options || ! isset( $settings_options['instagram_username'] ) )
            $this->update();

        foreach ( $this->default_settings() as $key => $value ) {

            switch ( $value['type'] ) {
                case 'section':
                    add_settings_section(
                        $key,
                        $value['title'],
                        '__return_false',
                        $value['menu']
                    );
                    break;
                case 'text':
                    add_settings_field(
                        $key,
                        $value['title'],
                        array( &$this , 'text_element_callback' ),
                        $value['menu'],
                        $value['section'],
                        array(
                            'menu' => $value['menu'],
                            'id' => $key,
                            'class' => 'regular-text',
                            'description' => isset( $value['description'] ) ? $value['description'] : ''
                        )
                    );
                    break;
                case 'checkbox':
                    add_settings_field(
                        $key,
                        $value['title'],
                        array( &$this , 'checkbox_element_callback' ),
                        $value['menu'],
                        $value['section'],
                        array(
                            'menu' => $value['menu'],
                            'id' => $key,
                            'description' => isset( $value['description'] ) ? $value['description'] : ''
                        )
                    );
                    break;
                case 'models':
                    add_settings_field(
                        $key,
                        $value['title'],
                        array( &$this , 'models_element_callback' ),
                        $value['menu'],
                        $value['section'],
                        array(
                            'menu' => $value['menu'],
                            'id' => $key,
                            'description' => isset( $value['description'] ) ? $value['description'] : '',
                            'options' => $value['options']
                        )
                    );
                    break;
                case 'color':
                    add_settings_field(
                        $key,
                        $value['title'],
                        array( &$this , 'color_element_callback' ),
                        $value['menu'],
                        $value['section'],
                        array(
                            'menu' => $value['menu'],
                            'id' => $key,
                            'description' => isset( $value['description'] ) ? $value['description'] : ''
                        )
                    );
                    break;

                default:
                    break;
            }

        }

        // Register settings.
        register_setting( $design, $design, array( &$this, 'validate_options' ) );
        register_setting( $settings, $settings, array( &$this, 'validate_options' ) );
    }

    /**
     * Text element fallback.
     *
     * @param  array $args Field arguments.
     *
     * @return string      Text field.
     */
    public function text_element_callback( $args ) {
        $menu = $args['menu'];
        $id = $args['id'];
        $class = isset( $args['class'] ) ? $args['class'] : 'small-text';

        $options = get_option( $menu );

        if ( isset( $options[ $id ] ) )
            $current = $options[ $id ];
        else
            $current = isset( $args['default'] ) ? $args['default'] : '';

        $html = sprintf( '<input type="text" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="%4$s" />', $id, $menu, $current, $class );

        // Displays option description.
        if ( isset( $args['description'] ) )
            $html .= sprintf( '<p class="description">%s</p>', $args['description'] );

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
        $menu = $args['menu'];
        $id = $args['id'];

        $options = get_option( $menu );

        if ( isset( $options[ $id ] ) )
            $current = $options[ $id ];
        else
            $current = isset( $args['default'] ) ? $args['default'] : '';

        $html = sprintf( '<input type="checkbox" id="%1$s" name="%2$s[%1$s]" value="1"%3$s />', $id, $menu, checked( 1, $current, false ) );

        $html .= sprintf( '<label for="%s"> %s</label><br />', $id, __( 'Activate/Deactivate', 'social-count-plus' ) );

        // Displays option description.
        if ( isset( $args['description'] ) )
            $html .= sprintf( '<p class="description">%s</p>', $args['description'] );

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
        $menu = $args['menu'];
        $id = $args['id'];

        $options = get_option( $menu );

        if ( isset( $options[ $id ] ) )
            $current = $options[ $id ];
        else
            $current = isset( $args['default'] ) ? $args['default'] : '#ffffff';

        $html = '';
        $key = 0;
        foreach( $args['options'] as $label ) {

            $html .= sprintf( '<input type="radio" id="%1$s_%2$s_%3$s" name="%1$s[%2$s]" value="%3$s"%4$s style="display: block; float: left; margin: 10px 10px 0 0;" />', $menu, $id, $key, checked( $current, $key, false ) );
            $html .= sprintf( '<label for="%1$s_%2$s_%3$s"> <img src="%4$s" alt="%1$s_%2$s_%3$s" /></label><br style="clear: both;margin-bottom: 20px;" />', $menu, $id, $key, plugins_url( 'demos/' . $label , __FILE__ ) );
            $key++;
        }

        // Displays option description.
        if ( isset( $args['description'] ) )
            $html .= sprintf( '<p class="description">%s</p>', $args['description'] );

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
        $menu = $args['menu'];
        $id = $args['id'];

        $options = get_option( $menu );

        if ( isset( $options[ $id ] ) )
            $current = $options[ $id ];
        else
            $current = isset( $args['default'] ) ? $args['default'] : '#333333';

        $html = sprintf( '<input type="text" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="social-count-plus-color-field" />', $id, $menu, $current );

        // Displays option description.
        if ( isset( $args['description'] ) )
            $html .= sprintf( '<p class="description">%s</p>', $args['description'] );

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
        // Create our array for storing the validated options.
        $output = array();

        // Loop through each of the incoming options.
        foreach ( $input as $key => $value ) {

            // Check to see if the current option has a value. If so, process it.
            if ( isset( $input[ $key ] ) ) {

                // Strip all HTML and PHP tags and properly handle quoted strings.
                $output[ $key ] = sanitize_text_field( $input[ $key ] );
            }
        }

        // Return the array processing any additional functions filtered by this action.
        return apply_filters( 'social_count_plus_validate_input', $output, $input );
    }

    /**
     * Construct view li element.
     *
     * @param  string $slug   Item slug.
     * @param  string $url    Item url.
     * @param  int    $count  Item count.
     * @param  string $title  Item title.
     *
     * @return string         HTML li element.
     */
    public function get_view_li( $slug, $url, $count, $title, $color ) {
        $html = sprintf( '<li class="count-%s">', $slug );
            $html .= sprintf( '<a class="icon" href="%s" target="_blank"></a>', esc_url( $url ) );
            $html .= '<span class="items">';
                $html .= sprintf( '<span class="count" style="color: %s !important;">%s</span>', $color, apply_filters( 'social_count_plus_number_format', $count ) );
                $html .= sprintf( '<span class="label" style="color: %s !important;">%s</span>', $color, $title );
            $html .= '</span>';
        $html .= '</li>';

        return $html;
    }

    /**
     * Construct plugin HTML view.
     *
     * @return string Plugin HTML view.
     */
    public function view() {
        $settings = get_option( 'socialcountplus_settings' );
        $design = get_option( 'socialcountplus_design' );
        $count = $this->counter->update_transients();
        $color = isset( $design['text_color'] ) ? $design['text_color'] : '#333333';

        // Sets widget design.
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
                $html .= ( isset( $settings['twitter_active'] ) ) ? $this->get_view_li( 'twitter', 'http://twitter.com/' . $settings['twitter_user'], $count['twitter'], __( 'followers', 'social-count-plus' ), $color ) : '';

                // Facebook counter.
                $html .= ( isset( $settings['facebook_active'] ) ) ? $this->get_view_li( 'facebook', 'http://www.facebook.com/' . $settings['facebook_id'], $count['facebook'], __( 'likes', 'social-count-plus' ), $color ) : '';

                // YouTube counter.
                $html .= ( isset( $settings['youtube_active'] ) ) ? $this->get_view_li( 'youtube', 'http://www.youtube.com/user/' . $settings['youtube_user'], $count['youtube'], __( 'subscribers', 'social-count-plus' ), $color ) : '';

                // Google Plus counter.
                $html .= ( isset( $settings['googleplus_active'] ) ) ? $this->get_view_li( 'googleplus', 'https://plus.google.com/' . $settings['googleplus_id'], $count['googleplus'], __( 'followers', 'social-count-plus' ), $color ) : '';

                // Instagram counter.
                $html .= ( isset( $settings['instagram_active'] ) ) ? $this->get_view_li( 'instagram', 'http://instagram.com/' . $settings['instagram_username'], $count['instagram'], __( 'followers', 'social-count-plus' ), $color ) : '';

                // Steam counter
                $html .= ( isset( $settings['steam_active'] ) ) ? $this->get_view_li( 'steam', 'http://steamcommunity.com/groups/' . $settings['steam_group_name'], $count['steam'], __( 'members', 'social-count-plus' ), $color ) : '';

                // SoundCloud counter.
                $html .= ( isset( $settings['soundcloud_active'] ) ) ? $this->get_view_li( 'soundcloud', 'https://soundcloud.com/' . $settings['soundcloud_username'], $count['soundcloud'], __( 'followers', 'social-count-plus' ), $color ) : '';

                // Posts counter.
                $html .= ( isset( $settings['posts_active'] ) ) ? $this->get_view_li( 'posts', get_home_url(), $count['posts'], __( 'posts', 'social-count-plus' ), $color ) : '';

                // Comments counter.
                $html .= ( isset( $settings['comments_active'] ) ) ? $this->get_view_li( 'comments', get_home_url(), $count['comments'], __( 'comments', 'social-count-plus' ), $color ) : '';

            $html .= '</ul>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Shortcodes.
     *
     * @param  array $atts  Shortcode attributes.
     *
     * @return int          Count.
     */
    public function shortcode( $atts ) {
        $count = $this->counter->update_transients();

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

} // Close Social_Count_Plus class.

// Include classes.
require_once SOCIAL_COUNT_PLUS_PATH . 'includes/class-widget.php';
require_once SOCIAL_COUNT_PLUS_PATH . 'includes/class-counter.php';

// Init classes.
$social_count_plus_counter = new Social_Count_Plus_Counter;
$social_count_plus = new Social_Count_Plus( $social_count_plus_counter );

// Include front-end helper functions.
require_once SOCIAL_COUNT_PLUS_PATH . 'includes/front-end-helpers.php';
