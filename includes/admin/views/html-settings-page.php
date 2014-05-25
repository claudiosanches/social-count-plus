<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="wrap">
	<h2 class="nav-tab-wrapper">
		<a href="options-general.php?page=social-count-plus&amp;tab=settings" class="nav-tab <?php echo $current_tab == 'settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Settings', 'social-count-plus' ); ?></a><a href="options-general.php?page=social-count-plus&amp;tab=design" class="nav-tab <?php echo $current_tab == 'design' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Design', 'social-count-plus' ); ?></a><a href="options-general.php?page=social-count-plus&amp;tab=shortcodes" class="nav-tab <?php echo $current_tab == 'shortcodes' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Shortcodes and Functions', 'social-count-plus' ); ?></a><a href="options-general.php?page=social-count-plus&amp;tab=system_status" class="nav-tab <?php echo $current_tab == 'system_status' ? 'nav-tab-active' : ''; ?>"><?php _e( 'System Status', 'social-count-plus' ); ?></a>
	</h2>

	<?php
		if ( isset( $this->plugin_settings['twitter_active'] ) && (
			empty( $this->plugin_settings['twitter_user'] )
			|| empty( $this->plugin_settings['twitter_consumer_key'] )
			|| empty( $this->plugin_settings['twitter_consumer_secret'] )
			|| empty( $this->plugin_settings['twitter_access_token'] )
			|| empty( $this->plugin_settings['twitter_access_token_secret'] )
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
				include 'html-settings-functions-shortcodes-page.php';
			} else if ( 'system_status' == $current_tab ) {
				include 'html-settings-system-status-page.php';
			} else {
				settings_fields( 'socialcountplus_settings' );
				do_settings_sections( 'socialcountplus_settings' );
				submit_button();
			}
		?>
	</form>
</div>
