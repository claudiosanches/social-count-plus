<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<p><?php _e( 'Use this library to generate your own model layout or display specific data counters.', 'social-count-plus' ); ?></p>

<h3><?php _e( 'Shortcodes', 'social-count-plus' ); ?></h3>

<p><?php _e( 'Note: the shortcodes displays only the count in plain text.', 'social-count-plus' ); ?></p>

<table class="form-table">
	<?php foreach ( $this->get_i18n_counters() as $slug => $name ) : ?>
		<tr>
			<th scope="row"><?php printf( __( '%s counter', 'social-count-plus' ), esc_html( $name ) ); ?></th>
			<td><p><code>[scp code=&quot;<?php echo esc_html( $slug ); ?>&quot;]</code></p></td>
		</tr>
	<?php endforeach; ?>
</table>

<h3><?php _e( 'Functions', 'social-count-plus' ); ?></h3>

<p><?php _e( 'Note: the functions displays only the count in plain text, except the <code>get_scp_widget()</code> function that displays with images.', 'social-count-plus' ); ?></p>

<table class="form-table">
	<?php foreach ( $this->get_i18n_counters() as $slug => $name ) : ?>
		<tr>
			<th scope="row"><?php printf( __( '%s counter', 'social-count-plus' ), esc_html( $name ) ); ?></th>
			<td><p><code>&lt;?php echo get_scp_counter( '<?php echo esc_html( $slug ); ?>' ); ?&gt;</code></p></td>
		</tr>
	<?php endforeach; ?>
	<tr>
		<th scope="row"><?php _e( 'Full widget', 'social-count-plus' ); ?></th>
		<td><p><code>&lt;?php echo get_scp_widget(); ?&gt;</code></p></td>
	</tr>
</table>
