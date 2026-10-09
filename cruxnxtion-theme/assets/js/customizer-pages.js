/**
 * Crux Nxtion Customizer: load the wording panel of a page only when that page is shown in the preview.
 * The server sends each page's panel, sections and controls on request (action crux_page_controls).
 */
( function ( api, $ ) {
	'use strict';
	if ( ! window.cruxPages ) { return; }
	var cfg = window.cruxPages, loaded = {}, loading = {};

	function pageFor( url ) {
		var path, base;
		try {
			path = new URL( url, cfg.home ).pathname.replace( /\/+$/, '' ) + '/';
			base = new URL( cfg.home ).pathname.replace( /\/+$/, '' );
		} catch ( e ) { return ''; }
		if ( base && 0 === path.indexOf( base + '/' ) ) { path = path.substr( base.length ); }
		return cfg.map[ path ] || '';
	}

	function showOnly( page ) {
		api.panel.each( function ( panel ) {
			if ( 0 === panel.id.indexOf( 'crux_page_' ) ) { panel.active( panel.id === 'crux_page_' + page ); }
		} );
	}

	function add( data ) {
		var id, params;
		for ( id in data.panels ) {
			if ( ! api.panel.has( id ) ) {
				params = data.panels[ id ];
				api.panel.add( new ( api.panelConstructor[ params.type ] || api.Panel )( id, { params: params } ) );
			}
		}
		for ( id in data.sections ) {
			if ( ! api.section.has( id ) ) {
				params = data.sections[ id ];
				api.section.add( new ( api.sectionConstructor[ params.type ] || api.Section )( id, { params: params } ) );
			}
		}
		for ( id in data.controls ) {
			if ( ! api.control.has( id ) ) {
				params = data.controls[ id ];
				api.control.add( new ( api.controlConstructor[ params.type ] || api.Control )( id, { params: params, previewer: api.previewer } ) );
			}
		}
	}

	function load( page ) {
		if ( ! page ) { showOnly( '' ); return; }
		if ( loaded[ page ] ) { showOnly( page ); return; }
		if ( loading[ page ] ) { return; }
		loading[ page ] = true;
		$.post( cfg.ajaxUrl, { action: 'crux_page_controls', page: page, nonce: cfg.nonce } ).done( function ( r ) {
			if ( r && r.success ) {
				add( r.data );
				loaded[ page ] = true;
				showOnly( page );
			}
		} ).always( function () { loading[ page ] = false; } );
	}

	// A pencil clicked in the preview asks for its field; page fields may still be arriving, so try a few times.
	function focusControl( id, tries ) {
		var control = api.control( id );
		if ( control ) { control.focus(); return; }
		if ( tries < 10 ) { setTimeout( function () { focusControl( id, tries + 1 ); }, 400 ); }
	}

	api.bind( 'ready', function () {
		api.previewer.bind( 'crux-focus', function ( id ) { focusControl( id, 0 ); } );
		api.previewer.bind( 'crux-page', function ( page ) { load( page ); } );
		// The preview may have announced its page before this panel was ready: ask again, now and once it reports ready.
		function askPage() { try { api.previewer.send( 'crux-request-page' ); } catch ( e ) {} }
		api.previewer.bind( 'ready', askPage );
		askPage();
		setTimeout( askPage, 2500 );
		api.previewer.previewUrl.bind( function ( url ) { load( pageFor( url ) ); } );
		load( pageFor( api.previewer.previewUrl.get() ) );
	} );
}( wp.customize, jQuery ) );
