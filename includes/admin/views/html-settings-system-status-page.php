<table id="social-count-plus-system-status" class="widefat" cellspacing="0">

	<thead>
		<tr>
			<th colspan="2"><?php _e( 'Environment', 'social-count-plus' ); ?></th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td><?php _e( 'Social Count Plus Version', 'social-count-plus' ); ?>:</td>
			<td><?php echo Social_Count_Plus::VERSION; ?></td>
		</tr>
		<tr>
			<td><?php _e( 'WordPress Version', 'social-count-plus' ); ?>:</td>
			<td><?php echo esc_attr( get_bloginfo( 'version' ) ); ?></td>
		</tr>
		<tr>
			<td><?php _e( 'WP Multisite Enabled', 'social-count-plus' ); ?>:</td>
			<td><?php if ( is_multisite() ) echo __( 'Yes', 'social-count-plus' ); else echo __( 'No', 'social-count-plus' ); ?></td>
		</tr>
		<tr>
			<td><?php _e( 'Web Server Info', 'social-count-plus' ); ?>:</td>
			<td><?php echo esc_html( $_SERVER['SERVER_SOFTWARE'] ); ?></td>
		</tr>
		<tr>
			<td><?php _e( 'PHP Version', 'social-count-plus' ); ?>:</td>
			<td><?php if ( function_exists( 'phpversion' ) ) { echo esc_html( phpversion() ); } ?></td>
		</tr>
		<tr>
			<?php
				$connection_status = 'error';
				$connection_note   = __( 'Your server does not have fsockopen or cURL enabled. The scripts which communicate with the social APIs will not work. Contact your hosting provider.', 'social-count-plus' );

				if ( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ) {
					if ( function_exists( 'fsockopen' ) && function_exists( 'curl_init' ) ) {
						$connection_note = __( 'Your server has fsockopen and cURL enabled.', 'social-count-plus' );
					} elseif ( function_exists( 'fsockopen' ) ) {
						$connection_note = __( 'Your server has fsockopen enabled, cURL is disabled.', 'social-count-plus' );
					} else {
						$connection_note = __( 'Your server has cURL enabled, fsockopen is disabled.', 'social-count-plus' );
					}

					$connection_status = 'yes';
				}
			?>
			<td><?php _e( 'fsockopen/cURL', 'social-count-plus' ); ?>:</td>
			<td>
				<mark class="<?php echo $connection_status; ?>">
					<?php echo $connection_note; ?>
				</mark>
			</td>
		</tr>
		<tr>
			<?php
				$remote_status = 'error';
				$remote_note   = __( 'wp_remote_get() failed. This may not work with your server.', 'social-count-plus' );
				$response      = wp_remote_get( 'https://httpbin.org/ip', array( 'timeout' => 60 ) );

				if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
					$remote_status = 'yes';
					$remote_note   = __( 'wp_remote_get() was successful.', 'social-count-plus' );
				} elseif ( is_wp_error( $response ) ) {
					$remote_note = __( 'wp_remote_get() failed. This plugin won\'t work with your server. Contact your hosting provider. Error:', 'social-count-plus' ) . ' ' . $response->get_error_message();
				}
			?>
			<td><?php _e( 'WP Remote Get', 'social-count-plus' ); ?>:</td>
			<td>
				<mark class="<?php echo $remote_status; ?>">
					<?php echo $remote_note; ?>
				</mark>
			</td>
		</tr>
	</tbody>
</table>

<p class="submit"><a href="<?php echo esc_url( add_query_arg( array( 'page' => 'social-count-plus', 'tab' => 'system_status', 'debug_file' => 'true' ), admin_url( 'admin.php' ) ) ); ?>" class="button-primary"><?php _e( 'Get System Report', 'social-count-plus' ); ?></a></p>
