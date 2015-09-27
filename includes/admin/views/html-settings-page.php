<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="wrap">
	<h2 class="nav-tab-wrapper">
		<a href="options-general.php?page=social-count-plus&amp;tab=settings" class="nav-tab <?php echo $current_tab == 'settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Settings', 'social-count-plus' ); ?></a><a href="options-general.php?page=social-count-plus&amp;tab=design" class="nav-tab <?php echo $current_tab == 'design' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Design', 'social-count-plus' ); ?></a><a href="options-general.php?page=social-count-plus&amp;tab=shortcodes" class="nav-tab <?php echo $current_tab == 'shortcodes' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Shortcodes and Functions', 'social-count-plus' ); ?></a><a href="options-general.php?page=social-count-plus&amp;tab=system_status" class="nav-tab <?php echo $current_tab == 'system_status' ? 'nav-tab-active' : ''; ?>"><?php _e( 'System Status', 'social-count-plus' ); ?></a>
	</h2>

	<?php include 'html-help-us.php'; ?>

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
				$options      = self::get_plugin_options();
				$options      = $options['socialcountplus_settings'];
				$options_keys = array_keys( $options );
				$last         = end( $options_keys );

				echo '<ul class="subsubsub">';
				foreach ( $options as $section => $data ) {
					echo '<li><a href="#section-' . esc_attr( $section ) . '">' . esc_html( $data['title'] ) .  '</a>';
					echo $last !== $section ? ' | ' : '';
					echo '</li>';
				}
				echo '</ul><br class="clear">';

				settings_fields( 'socialcountplus_settings' );
				do_settings_sections( 'socialcountplus_settings' );
				submit_button();
			}
		?>
	</form>
</div>
