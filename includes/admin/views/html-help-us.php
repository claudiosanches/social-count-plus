<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$reviews_url = 'https://wordpress.org/support/view/plugin-reviews/social-count-plus?filter=5#postform';

?>

<div class="updated">
	<p><?php printf( __( 'Help us keep the %s free making a %s or rate %s on %s. Thank you in advance!', 'social-count-plus' ), '<strong>' . __( 'Social Count Plus', 'social-count-plus' ) . '</strong>', '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Y8HP99ZJ5Z59L">' . __( 'donation', 'social-count-plus' ) . '</a>', '<a href="' . esc_url( $reviews_url ) . '" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a>', '<a href="' . esc_url( $reviews_url ) . '" target="_blank">' . __( 'WordPress.org', 'social-count-plus' ) . '</a>' ); ?></p>
</div>
