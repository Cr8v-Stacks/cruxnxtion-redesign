( function ( $ ) {
	'use strict';

	var frame;
	var $ids = $( '#cr8v_event_gallery_ids' );
	var $thumbs = $( '#cr8v-tix-thumbs' );

	$( '#cr8v-tix-pick' ).on( 'click', function ( e ) {
		e.preventDefault();
		if ( frame ) {
			frame.open();
			return;
		}
		frame = wp.media( {
			title: 'Choose gallery images',
			button: { text: 'Use these images' },
			library: { type: 'image' },
			multiple: 'add'
		} );
		frame.on( 'open', function () {
			var selection = frame.state().get( 'selection' );
			( $ids.val() || '' ).split( ',' ).forEach( function ( id ) {
				if ( id ) {
					var attachment = wp.media.attachment( id );
					attachment.fetch();
					selection.add( attachment );
				}
			} );
		} );
		frame.on( 'select', function () {
			var ids = [];
			$thumbs.empty();
			frame.state().get( 'selection' ).each( function ( attachment ) {
				var data = attachment.toJSON();
				var src = ( data.sizes && data.sizes.thumbnail ) ? data.sizes.thumbnail.url : data.url;
				ids.push( data.id );
				$thumbs.append( $( '<img>' ).attr( 'src', src ) );
			} );
			$ids.val( ids.slice( 0, 12 ).join( ',' ) );
		} );
		frame.open();
	} );

	$( '#cr8v-tix-clear' ).on( 'click', function ( e ) {
		e.preventDefault();
		$ids.val( '' );
		$thumbs.empty();
	} );
}( jQuery ) );
