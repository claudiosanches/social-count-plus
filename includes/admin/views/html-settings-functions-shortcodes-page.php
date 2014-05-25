<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<p><?php _e( 'Use this library to generate your own model layout or display specific data counters.', 'social-count-plus' ); ?></p>

<h3><?php _e( 'Shortcodes', 'social-count-plus' ); ?></h3>

<p><?php _e( 'Note: the shortcodes displays only the count in plain text.', 'social-count-plus' ); ?></p>

<table class="form-table">
	<tr>
		<th scope="row"><?php _e( 'Twitter counter', 'social-count-plus' ); ?></th>
		<td><p><code>[scp code=&quot;twitter&quot;]</code></p></td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Facebook counter', 'social-count-plus' ); ?></th>
		<td><p><code>[scp code=&quot;facebook&quot;]</code></p></td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'YouTube counter', 'social-count-plus' ); ?></th>
		<td><p><code>[scp code=&quot;youtube&quot;]</code></p></td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Google Plus counter', 'social-count-plus' ); ?></th>
		<td><p><code>[scp code=&quot;googleplus&quot;]</code></p></td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Instagram counter', 'social-count-plus' ); ?></th>
		<td><p><code>[scp code=&quot;instagram&quot;]</code></p></td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Steam counter', 'social-count-plus' ); ?></th>
		<td><p><code>[scp code=&quot;steam&quot;]</code></p></td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'SoundCloud counter', 'social-count-plus' ); ?></th>
		<td><p><code>[scp code=&quot;soundcloud&quot;]</code></p></td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Posts counter', 'social-count-plus' ); ?></th>
		<td><p><code>[scp code=&quot;posts&quot;]</code></p></td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Comments counter', 'social-count-plus' ); ?></th>
		<td><p><code>[scp code=&quot;comments&quot;]</code></p></td>
	</tr>
</table>

<h3><?php _e( 'Functions', 'social-count-plus' ); ?></h3>

<p><?php _e( 'Note: the functions displays only the count in plain text, except the <code>get_scp_widget()</code> function that displays with images.', 'social-count-plus' ); ?></p>

<table class="form-table">
	<tr>
		<th scope="row"><?php _e( 'Twitter counter', 'social-count-plus' ); ?></th>
		<td><p><code>&lt;?php echo get_scp_twitter(); ?&gt;</code></p></td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Facebook counter', 'social-count-plus' ); ?></th>
		<td><p><code>&lt;?php echo get_scp_facebook(); ?&gt;</code></p></td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'YouTube counter', 'social-count-plus' ); ?></th>
		<td><p><code>&lt;?php echo get_scp_youtube(); ?&gt;</code></p></td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Google Plus counter', 'social-count-plus' ); ?></th>
		<td><p><code>&lt;?php echo get_scp_googleplus(); ?&gt;</code></p></td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Instagram counter', 'social-count-plus' ); ?></th>
		<td><p><code>&lt;?php echo get_scp_instagram(); ?&gt;</code></p></td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Steam counter', 'social-count-plus' ); ?></th>
		<td><p><code>&lt;?php echo get_scp_steam(); ?&gt;</code></p></td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'SoundCloud counter', 'social-count-plus' ); ?></th>
		<td><p><code>&lt;?php echo get_scp_soundcloud(); ?&gt;</code></p></td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Posts counter', 'social-count-plus' ); ?></th>
		<td><p><code>&lt;?php echo get_scp_posts(); ?&gt;</code></p></td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Comments counter', 'social-count-plus' ); ?></th>
		<td><p><code>&lt;?php echo get_scp_comments(); ?&gt;</code></p></td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Full widget', 'social-count-plus' ); ?></th>
		<td><p><code>&lt;?php echo get_scp_widget(); ?&gt;</code></p></td>
	</tr>
</table>
