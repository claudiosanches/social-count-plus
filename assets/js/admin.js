jQuery( document ).ready( function ( $ ) {
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

	$( '.form-table .social-count-plus-icons-order' ).sortable({
		items: 'div.social-icon',
		cursor: 'move',
		scrollSensitivity: 40,
		forcePlaceholderSize: true,
		forceHelperSize: false,
		helper: 'clone',
		opacity: 0.65,
		placeholder: 'social-icon-placeholder',
		start: function ( event, ui ) {
			ui.item.css('background-color', '#f6f6f6');
		}, stop: function ( event, ui ) {
			ui.item.removeAttr( 'style' );
		}, update: function () {
			var icons = $( '.social-count-plus-icons-order .social-icon' ).map( function () {
					return $( this ).data( 'icon' );
				}).get().join();

			$( 'input', $( this ) ).val( icons );
		}
	});
});
