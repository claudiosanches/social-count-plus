<table id="social-count-plus-system-status" class="widefat" cellspacing="0">

	<thead>
		<tr>
			<th colspan="2"><?php _e( 'Environment', 'social-count-plus' ); ?></th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td><?php _e( 'Social Count Plus Version','social-count-plus' ); ?>:</td>
			<td><?php echo Social_Count_Plus::VERSION; ?></td>
		</tr>
		<tr>
			<td><?php _e( 'WordPress Version','social-count-plus' ); ?>:</td>
			<td><?php echo esc_attr( get_bloginfo( 'version' ) ); ?></td>
		</tr>
		<tr>
			<td><?php _e( 'WP Multisite Enabled','social-count-plus' ); ?>:</td>
			<td><?php if ( is_multisite() ) echo __( 'Yes', 'social-count-plus' ); else echo __( 'No', 'social-count-plus' ); ?></td>
		</tr>
		<tr>
			<td><?php _e( 'Web Server Info','social-count-plus' ); ?>:</td>
			<td><?php echo esc_html( $_SERVER['SERVER_SOFTWARE'] ); ?></td>
		</tr>
		<tr>
			<td><?php _e( 'PHP Version','social-count-plus' ); ?>:</td>
			<td><?php if ( function_exists( 'phpversion' ) ) { echo esc_html( phpversion() ); } ?></td>
		</tr>
	</tbody>
</table>
