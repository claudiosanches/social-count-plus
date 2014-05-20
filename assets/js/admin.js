jQuery(document).ready(function($) {
	// Init the color picker.
	$( '.social-count-plus-color-field' ).wpColorPicker();

	function socialCountPlusShowHide( input ) {
		var current  = input.attr( 'id' ),
			id       = current.replace( '_active', '' ),
			elements = $( '.form-table [id^="' + id + '"]' )
						.not( '[id^="' + current + '"]' )
						.parent( 'td' )
						.parent( 'tr' );

		if ( input.is( ':checked' ) ) {
			elements.show();
		} else {
			elements.hide();
		}
	}

	$( '.form-table input[id$="_active"]' ).each( function () {
		socialCountPlusShowHide( $( this ) );
	});

	$( '.form-table input[id$="_active"]' ).on( 'click', function () {
		socialCountPlusShowHide( $( this ) );
	});
});
