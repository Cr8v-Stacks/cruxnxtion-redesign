/**
 * Crux Nxtion Customizer preview: visual editing.
 *  - Hover any marked piece of the page (headings, text, buttons, photos, footer, announcement bar) and a pencil appears.
 *  - Click the pencil and the matching field opens in the left-hand panel.
 *  - Plain text fields update on the page instantly while you type; everything else reloads the preview.
 * The server marks elements with data-crux-edit="page.field" (or "opt.field" for site-wide settings) only inside the Customizer.
 */
( function ( api ) {
	'use strict';
	var cfg = window.cruxPreview || { live: [] };

	var css = document.createElement( 'style' );
	css.textContent =
		'.crux-edit-hover{outline:2px dashed #3858e9 !important;outline-offset:3px !important;cursor:default}' +
		'#crux-pencil{position:fixed;z-index:2147483000;width:34px;height:34px;border-radius:50%;border:2px solid #fff;background:#3858e9;' +
		'box-shadow:0 2px 8px rgba(0,0,0,.35);cursor:pointer;display:none;padding:0;align-items:center;justify-content:center}' +
		'#crux-pencil.on{display:flex}#crux-pencil:hover{background:#1d3ad0}#crux-pencil svg{width:16px;height:16px;fill:#fff;pointer-events:none}';
	document.head.appendChild( css );

	var pencil = document.createElement( 'button' );
	pencil.id = 'crux-pencil';
	pencil.type = 'button';
	pencil.setAttribute( 'aria-label', 'Edit this in the Customizer' );
	pencil.title = 'Edit this';
	pencil.innerHTML = '<svg viewBox="0 0 20 20" aria-hidden="true"><path d="M13.9 2.3a2.1 2.1 0 013 3L6.6 15.6l-4 .9.9-4L13.9 2.3z"/></svg>';
	document.body.appendChild( pencil );

	var current = null, timer = 0;

	function place( el ) {
		var r = el.getBoundingClientRect();
		var left = Math.min( Math.max( r.right - 17, 6 ), window.innerWidth - 40 );
		var top = Math.min( Math.max( r.top - 17, 6 ), window.innerHeight - 40 );
		pencil.style.left = left + 'px';
		pencil.style.top = top + 'px';
	}

	function show( el ) {
		clearTimeout( timer );
		if ( current && current !== el ) { current.classList.remove( 'crux-edit-hover' ); }
		current = el;
		el.classList.add( 'crux-edit-hover' );
		place( el );
		pencil.classList.add( 'on' );
	}

	function hide() {
		clearTimeout( timer );
		timer = setTimeout( function () {
			if ( current ) { current.classList.remove( 'crux-edit-hover' ); current = null; }
			pencil.classList.remove( 'on' );
		}, 300 );
	}

	function controlId( value ) {
		var i = value.indexOf( '.' );
		var page = value.slice( 0, i ), key = value.slice( i + 1 );
		return 'opt' === page ? 'crux_' + key : 'crux_c_' + page + '_' + key;
	}

	document.addEventListener( 'mouseover', function ( e ) {
		if ( e.target === pencil || pencil.contains( e.target ) ) { clearTimeout( timer ); return; }
		var el = e.target.closest ? e.target.closest( '[data-crux-edit]' ) : null;
		if ( el ) { show( el ); } else { hide(); }
	} );
	window.addEventListener( 'scroll', function () { if ( current ) { place( current ); } }, { passive: true } );
	window.addEventListener( 'resize', function () { if ( current ) { place( current ); } } );

	pencil.addEventListener( 'click', function ( e ) {
		e.preventDefault();
		e.stopPropagation();
		if ( current ) { api.preview.send( 'crux-focus', controlId( current.getAttribute( 'data-crux-edit' ) ) ); }
	} );

	// Instant text updates.
	( cfg.live || [] ).forEach( function ( entry ) {
		api( 'crux_c_' + entry.replace( '.', '_' ), function ( setting ) {
			setting.bind( function ( value ) {
				var nodes = document.querySelectorAll( '[data-crux-edit="' + entry + '"]' );
				Array.prototype.forEach.call( nodes, function ( node ) { node.textContent = value; } );
			} );
		} );
	} );
}( wp.customize ) );
