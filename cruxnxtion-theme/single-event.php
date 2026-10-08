<?php
/**
 * Template Name: Single Event Template
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Query events from the database
$all_events = function_exists( 'crux_get_all_events' ) ? crux_get_all_events() : array();

// Resolve requested event
$req_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
$parts = array_filter( explode( '/', trim( parse_url( $req_uri, PHP_URL_PATH ), '/' ) ) );
$current_slug = end( $parts );

// Prefer the queried post (works for draft previews), fall back to the URL slug.
$queried = get_queried_object();
$ev_data  = function_exists( 'crux_get_event_data' )
	? crux_get_event_data( ( $queried instanceof WP_Post && 'event' === $queried->post_type ) ? $queried : $current_slug )
	: null;

// If event does not exist, trigger 404
if ( ! $ev_data ) {
	global $wp_query;
	$wp_query->set_404();
	status_header( 404 );
	nocache_headers();
	include get_404_template();
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> style="background:#0A0F26; margin:0; padding:0;">
<?php wp_body_open(); ?>



<style>
  @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Space+Grotesk:wght@400;500;600;700&display=swap');
  * { box-sizing: border-box; }
  body { margin: 0; font-family: 'Space Grotesk', system-ui, sans-serif; background: #0A0F26; color: #F4F5FA; }
  a { color: #5B8DEF; text-decoration: none; }
  a:hover { color: #E5383B; }
  .bebas { font-family: 'Bebas Neue', 'Arial Narrow', sans-serif; letter-spacing: 0.5px; line-height: 0.9; text-transform: uppercase; }
  .eyebrow { font-weight: 600; letter-spacing: 3px; text-transform: uppercase; font-size: 11px; color: #5B8DEF; }
  .ticket-stub { position: relative; }
  .ticket-stub::before, .ticket-stub::after { content: ''; position: absolute; right: -11px; width: 20px; height: 20px; border-radius: 50%; background: #0A0F26; z-index: 2; }
  .ticket-stub::before { top: -10px; }
  .ticket-stub::after { bottom: -10px; }
  @keyframes rc-spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
  @keyframes rc-marquee { from { transform: translateX(0); } to { transform: translateX(-50%); } }
  /* Micro-animations */
  body { animation: rcFadeIn .5s ease-out; }
  @keyframes rcFadeIn { from { opacity: 0; } to { opacity: 1; } }
  img { transition: transform .5s ease; }
  a:hover img { transform: scale(1.05); }
  a { transition: color .2s ease, filter .3s ease, box-shadow .3s ease, border-color .25s ease; }
  a:hover { filter: brightness(1.08); }
  a:active { filter: brightness(0.94); }
  .ticket { transition: box-shadow .3s ease, filter .3s ease; }
  .ticket:hover { box-shadow: 0 18px 34px rgba(0,0,0,0.22); }
  header nav a { position: relative; }
  header nav a::after { content: ''; position: absolute; left: 0; bottom: -6px; width: 0; height: 2px; background: currentColor; transition: width .3s ease; }
  header nav a:hover::after { width: 100%; }
  a[style*="border-radius:999px"], a[style*="clip-path:polygon"] { transition: transform .25s ease, box-shadow .25s ease, filter .25s ease; }
  a[style*="border-radius:999px"]:hover, a[style*="clip-path:polygon"]:hover { transform: translateY(-3px); box-shadow: 0 14px 26px rgba(0,0,0,0.22); }
  .tilt-ticket { transition: transform .3s ease, box-shadow .3s ease; }
  .tilt-ticket:hover { transform: rotate(calc(var(--r) * 1.8)) translateY(-4px) !important; box-shadow: 0 18px 34px rgba(0,0,0,0.22); }
  .tilt-straighten { transition: transform .35s ease; }
  .tilt-straighten:hover { transform: rotate(0deg) scale(1.04) !important; }
  .tilt-in { transition: transform .35s ease; }
  .tilt-in:hover { transform: rotate(var(--r, 3deg)) scale(1.03) !important; }
  .pill { border:1.5px solid #1E2B5E; color:#D5D9EA; font-weight:600; font-size:12.5px; padding:10px 20px; border-radius:999px; }
  .pill.on { background:#F4F5FA; color:#0A0F26; border-color:#F4F5FA; }
  .strip-stub { position: relative; }
  .strip-stub::before, .strip-stub::after { content: ''; position: absolute; bottom: -11px; width: 22px; height: 22px; border-radius: 50%; background: #0A0F26; z-index: 2; }
  .strip-stub::before { left: 24%; }
  .strip-stub::after { left: 68%; }

    /* Services Dropdown (Focused Floating Card) */
  .crux-nav-dropdown { position: relative !important; display: inline-flex !important; align-items: center !important; height: 100% !important; padding: 18px 0 !important; }
  .crux-nav-trigger { display: inline-flex !important; align-items: center !important; gap: 6px !important; font-size: 14px !important; font-weight: 600 !important; letter-spacing: 0.2px !important; text-decoration: none !important; line-height: 1 !important; cursor: pointer !important; transition: color .2s ease !important; }
  .crux-nav-trigger::after { content: '' !important; position: absolute !important; left: 0 !important; bottom: 8px !important; width: 0 !important; height: 2px !important; background: currentColor !important; transition: width .3s ease !important; }
  .crux-nav-dropdown:hover .crux-nav-trigger::after, .crux-nav-dropdown:focus-within .crux-nav-trigger::after { width: 100% !important; }
  .crux-nav-dropdown:hover .crux-chevron, .crux-nav-dropdown:focus-within .crux-chevron { transform: rotate(180deg) !important; }
  .crux-services-card { position: absolute !important; top: calc(100% - 6px) !important; left: 50% !important; transform: translateX(-50%) translateY(8px) !important; width: 580px !important; opacity: 0 !important; visibility: hidden !important; pointer-events: none !important; transition: opacity 0.22s ease, transform 0.22s ease, visibility 0.22s !important; border-radius: 12px !important; z-index: 1000 !important; }
  .crux-nav-dropdown:hover .crux-services-card, .crux-nav-dropdown:focus-within .crux-services-card { opacity: 1 !important; visibility: visible !important; pointer-events: auto !important; transform: translateX(-50%) translateY(0) !important; }
  .c-dlink { display: flex !important; align-items: center !important; gap: 10px !important; padding: 7px 8px !important; border-radius: 6px !important; text-decoration: none !important; transition: transform .2s ease, background .2s ease !important; }
  .c-dlink:hover { transform: translateX(4px) !important; }
  body.drawer-open, html.drawer-open { overflow: hidden !important; }
  .mdrawer { display: flex !important; flex-direction: column !important; position: fixed !important; top: 0 !important; left: 0 !important; right: 0 !important; bottom: 0 !important; width: 100vw !important; height: 100vh !important; z-index: 99999 !important; overflow-y: auto !important; -webkit-overflow-scrolling: touch; padding: 0 !important; box-sizing: border-box !important; opacity: 0; visibility: hidden; pointer-events: none; transform: translateY(-8px); transition: opacity .25s ease, transform .25s ease, visibility .25s; }
  .mdrawer.is-open { opacity: 1 !important; visibility: visible !important; pointer-events: auto !important; transform: translateY(0) !important; }
  details.mdrawer-acc summary::-webkit-details-marker { display: none; }
  details.mdrawer-acc summary { list-style: none; }
  details.mdrawer-acc[open] .acc-icon { transform: rotate(45deg); color: #BA0000 !important; }
  .mdrawer-body .msub { display: block; padding: 6px 0; font-size: 13.5px; text-decoration: none; border-bottom: 1px solid rgba(255,255,255,0.05); }
  .mdrawer-body .msub:last-child { border-bottom: none; }
  /* ---- motion ---- */
  @property --p { syntax:'<integer>'; inherits:false; initial-value:0; }
  @keyframes apT4 { 0%,20% { background:transparent; border-color:#FF2E3D; } 28%,86% { background:#8C7AE6; border-color:#8C7AE6; } 94%,100% { background:transparent; border-color:#FF2E3D; } }
  @keyframes apT5 { 0%,44% { background:transparent; border-color:#FF2E3D; } 52%,86% { background:#8C7AE6; border-color:#8C7AE6; } 94%,100% { background:transparent; border-color:#FF2E3D; } }
  @keyframes apBar { 0%,18% { width:55%; } 30% { width:78%; } 54% { width:100%; } 86% { width:100%; } 96%,100% { width:55%; } }
  .ap4 { animation:apT4 7s ease infinite; } .ap5 { animation:apT5 7s ease infinite; } .apbar { animation:apBar 7s ease infinite; }
  @keyframes opSweep { 0%,10% { background-size:0% 3px; } 45%,85% { background-size:100% 3px; } 100% { background-size:0% 3px; } }
  .ophl { background-image:linear-gradient(#8C7AE6,#8C7AE6); background-repeat:no-repeat; background-position:0 100%; background-size:0% 3px; padding-bottom:3px; animation:opSweep 4.5s ease infinite; }
  @keyframes swUp { 0%,100% { transform:scaleY(1); } 30% { transform:scaleY(1.45); } 60% { transform:scaleY(1); } }
  .sw1, .sw2, .sw3 { transform-origin:bottom; animation:swUp 3.2s ease-in-out infinite; } .sw2 { animation-delay:.25s; } .sw3 { animation-delay:.5s; }
  @keyframes rmA { 0%,6% { transform:scaleX(0); } 26%,88% { transform:scaleX(1); } 100% { transform:scaleX(0); } }
  @keyframes rmB { 0%,22% { transform:scaleX(0); } 42%,88% { transform:scaleX(1); } 100% { transform:scaleX(0); } }
  @keyframes rmC { 0%,38% { transform:scaleX(0); } 58%,88% { transform:scaleX(1); } 100% { transform:scaleX(0); } }
  .rm1, .rm2, .rm3 { transform-origin:left; animation:rmA 6s ease infinite; } .rm2 { animation-name:rmB; } .rm3 { animation-name:rmC; }
  @keyframes nowPulse { 0%,100% { box-shadow:0 0 0 0 rgba(140,122,230,.55); } 50% { box-shadow:0 0 0 7px rgba(140,122,230,0); } }
  .nowp { animation:nowPulse 2s ease infinite; }
  @keyframes ring72 { 0%,6% { --p:0; } 30%,88% { --p:72; } 100% { --p:0; } }
  @keyframes ring45 { 0%,6% { --p:0; } 30%,88% { --p:45; } 100% { --p:0; } }
  @keyframes ring88 { 0%,6% { --p:0; } 30%,88% { --p:88; } 100% { --p:0; } }
  .rg { animation-duration:6s; animation-timing-function:ease-out; animation-iteration-count:infinite; counter-reset:n var(--p); }
  .rg72 { animation-name:ring72; } .rg45 { animation-name:ring45; } .rg88 { animation-name:ring88; }
  .rgn::after { content:counter(n); }
  @keyframes revealUp { from { opacity:0; transform:translateY(26px); } to { opacity:1; transform:none; } }
  @supports (animation-timeline: view()) { .reveal { animation:revealUp linear both; animation-timeline:view(); animation-range: entry 0% cover 18%; } }
  @keyframes drift { from { transform:scale(1.02); } to { transform:scale(1.09) translate(-1%,-1%); } }
  .drift { animation:drift 18s ease-in-out infinite alternate; }
  @keyframes sheen { 0% { transform:translateX(-120%); } 60%,100% { transform:translateX(220%); } }
  /* ---- one button shape ---- */
  .bx { position:relative; clip-path:polygon(var(--sl,10px) 0, 100% 0, calc(100% - var(--sl,10px)) 100%, 0 100%); border:0 !important; border-radius:0 !important; --bw:1.5px; text-align:center; }
  .bx::before { content:''; position:absolute; inset:0; background:var(--bc,transparent); pointer-events:none; clip-path:polygon(evenodd, var(--sl,10px) 0, 100% 0, calc(100% - var(--sl,10px)) 100%, 0 100%, var(--sl,10px) 0, calc(var(--sl,10px) + var(--bw)) var(--bw), calc(100% - var(--bw)) var(--bw), calc(100% - var(--sl,10px) - var(--bw)) calc(100% - var(--bw)), var(--bw) calc(100% - var(--bw)), calc(var(--sl,10px) + var(--bw)) var(--bw), var(--sl,10px) 0); }
  .bx:hover { filter:brightness(1.1); transform:translateY(-2px); }
  .bx:active { transform:none; filter:brightness(.95); }
  .bx { transition:transform .2s ease, filter .2s ease; }

  

  

  html, body {
    margin: 0;
    padding: 0;
    width: 100%;
    /* USE overflow-x: clip so horizontal scroll is prevented WITHOUT breaking position: sticky! */
    overflow-x: clip !important;
    box-sizing: border-box;
    scroll-behavior: smooth;
  }
  *, *::before, *::after {
    box-sizing: border-box;
  }
  img {
    max-width: 100%;
    height: auto;
  }

  /* Full-bleed 100% root container — edge-to-edge layout, never pillarboxed */
  [data-m~=root] {
    width: 100% !important;
    max-width: 100% !important;
    margin: 0 !important;
    position: relative;
    box-sizing: border-box;
    overflow-x: clip !important;
    overflow-y: visible !important;
  }

  /* Sticky Navigation Header with Glassmorphism */
  header {
    position: sticky !important;
    top: 0 !important;
    z-index: 1000 !important;
    backdrop-filter: blur(14px) !important;
    -webkit-backdrop-filter: blur(14px) !important;
    transition: background 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease !important;
  }
  header nav a {
    position: relative;
    transition: color .2s ease;
  }
  header nav a::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -6px;
    width: 0;
    height: 2px;
    background: currentColor;
    transition: width .3s ease;
  }
  header nav a:hover::after {
    width: 100%;
  }

  /* Slanted Header Switcher Frame */
  .header-switcher {
    transition: all .2s ease;
  }
  .header-switcher a.crux-sw-inactive:hover {
    color: #FFFFFF !important;
  }
  .header-switcher--light a.crux-sw-inactive:hover {
    color: #10142E !important;
  }

  /* Rotating Rosette Badge Animation (Matching Red Cap Entertainment) */
  .prefooter__badge-link:hover {
    transform: scale(1.08);
  }
  @keyframes rc-spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
  }
  @media (prefers-reduced-motion: reduce) {
    .prefooter__badge-img { animation: none !important; }
  }

  /* Scroll-Driven Reveal Engine (Fast 18% viewport entry threshold) */
  @keyframes revealUp {
    from { opacity: 0; transform: translateY(22px); }
    to { opacity: 1; transform: none; }
  }
  @supports (animation-timeline: view()) {
    .reveal {
      animation: revealUp linear both;
      animation-timeline: view();
      animation-range: entry 0% cover 18%;
    }
  }

  /* TICKET MOTION ENGINE:
     - Straight in resting state -> becomes tilted on hover (-1.5deg)
     - Tilted in resting state (--r set) -> becomes straight (0deg) on hover!
     - Entire ticket (frame, notch, stub, image, text) moves as ONE single solid object!
  */
  .tilt-ticket, .ticket {
    transition: transform .35s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow .35s ease, filter .3s ease !important;
    will-change: transform;
  }
  .tilt-ticket[style*="--r"]:hover, .tilt-ticket[style*="rotate"]:hover {
    transform: rotate(0deg) translateY(-6px) scale(1.02) !important;
    box-shadow: 0 20px 38px rgba(0,0,0,0.32) !important;
  }
  .tilt-ticket:not([style*="--r"]):hover {
    transform: rotate(-1.5deg) translateY(-6px) scale(1.02) !important;
    box-shadow: 0 20px 38px rgba(0,0,0,0.32) !important;
  }
  .tilt-ticket img, .ticket img,
  .tilt-ticket:hover img, .ticket:hover img,
  a.tilt-ticket:hover img, a.ticket:hover img {
    transform: none !important;
    transition: none !important;
  }

  /* Card and tile hover elevation */
  .bento-tile {
    transition: transform .3s ease, box-shadow .3s ease;
  }
  .bento-tile:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 34px rgba(0,0,0,0.28);
  }

  /* Accordion details styling */
  details > summary::-webkit-details-marker {
    display: none;
  }
  details[open] {
    border-color: #5B8DEF !important;
  }
  details[open] .fq-plus {
    transform: rotate(45deg);
    background: #BA0000 !important;
  }

  /* Subtle interactive feedback on touch devices */
  @media (hover: none) {
    .bx:active, .tilt-ticket:active, .bento-tile:active {
      transform: scale(0.98) !important;
    }
  }

  /* Desktop Viewport (> 900px) */
  @media (min-width: 901px) {
    header {
      min-height: 80px !important;
      padding: 14px 64px !important;
    }
    header > nav {
      display: flex !important;
    }
    header > .header-desktop-actions, header > div.header-desktop-actions {
      display: flex !important;
    }
    .mnav-btn, .crux-mnav-btn {
      display: none !important;
    }
    .mdrawer {
      display: none !important;
    }
    .msw {
      display: none !important;
    }
    .carousel-track {
      display: flex !important;
      gap: 24px !important;
    }
    .consultancy-panels-container .cpanel:hover {
      flex: 5 1 0 !important;
      border-color: #8C7AE6 !important;
    }
    .consultancy-panels-container .cpanel:hover .cpanel-label {
      display: none !important;
    }
    .consultancy-panels-container .cpanel:hover .cpanel-body {
      display: block !important;
    }
    .consultancy-panels-container .cpanel:hover img {
      filter: brightness(0.85) !important;
    }

    /* Desktop Section Padding & Typography: Restores full 64px side breathing room */
    [data-m~=root] > section, [data-m~=root] > div > section {
      padding-left: 64px !important;
      padding-right: 64px !important;
    }
    .hero-content {
      padding: 0 64px !important;
    }
    h1.hero-title, [data-m~=root] section h1 {
      font-size: clamp(56px, 6.8vw, 104px) !important;
      line-height: 0.92 !important;
    }
  }

  /* Mobile Viewport / Minimized Browser (<= 900px) */
  @media (max-width: 900px) {
    [data-m~=root] {
      width: 100% !important;
      max-width: 100% !important;
      margin: 0 !important;
      overflow-x: clip !important;
    }
    header {
      padding: 10px 20px !important;
    }
    header > nav {
      display: none !important;
    }
    header > .header-desktop-actions, header > div.header-desktop-actions {
      display: none !important;
    }
    .mnav-btn, .crux-mnav-btn {
      display: flex !important;
    }
    body.drawer-open, html.drawer-open { overflow: hidden !important; }
    .mdrawer {
      display: none;
      position: fixed !important;
      inset: 0 !important;
      width: 100vw !important;
      height: 100vh !important;
      z-index: 99999 !important;
      padding: 0 !important;
      box-sizing: border-box !important;
      overflow-y: auto !important;
      -webkit-overflow-scrolling: touch;
    }
    
    .mdrawer-topbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 20px;
      flex-shrink: 0;
    }
    .mdrawer-close-btn {
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
      font-size: 24px;
      line-height: 1;
      cursor: pointer;
      user-select: none;
    }
    .mdrawer-body {
      padding: 10px 24px 40px;
      flex: 1;
      overflow-y: auto;
    }
    @keyframes mslide {
      from { opacity: 0; transform: translateY(-8px); }
      to { opacity: 1; transform: none; }
    }
    .mdrawer a.mlink, .mdrawer span.mlink, .mdrawer .mlink {
      display: block;
      font-family: 'Bebas Neue', 'Arial Narrow', sans-serif !important;
      font-size: 32px !important;
      letter-spacing: .5px !important;
      text-transform: uppercase !important;
      padding: 12px 0;
      opacity: 1 !important;
      -webkit-text-fill-color: initial !important;
    }
    .mdrawer details summary {
      list-style: none;
      cursor: pointer;
    }
    .mdrawer details summary::-webkit-details-marker {
      display: none;
    }
    .mdrawer .msub {
      display: block;
      padding: 9px 0 9px 14px;
      font-size: 14.5px;
    }

    /* Fixed Bottom Switcher */
    .msw {
      position: fixed !important;
      bottom: 20px !important;
      top: auto !important;
      left: 0 !important;
      right: 0 !important;
      height: auto !important;
      z-index: 900 !important;
      display: flex !important;
      justify-content: center !important;
      align-items: center !important;
      pointer-events: none !important;
    }
    .msw > div {
      pointer-events: auto !important;
    }

    /* Prefooter badge responsive scaling */
    [data-m~=prefooter-inner] {
      padding-left: 20px !important;
      padding-right: 20px !important;
      flex-direction: column !important;
      align-items: flex-start !important;
    }
    .prefooter__badge {
      width: 130px !important;
      height: 130px !important;
      flex: 0 0 130px !important;
      margin-top: 10px !important;
    }

    /* Grid columns collapsing without overflow */
    [data-m~=g1] {
      display: grid !important;
      grid-template-columns: 1fr !important;
      grid-template-rows: none !important;
      grid-auto-rows: auto !important;
      gap: 18px !important;
    }
    [data-m~=g2] {
      display: grid !important;
      grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
      grid-template-rows: none !important;
      grid-auto-rows: auto !important;
      gap: 12px !important;
    }
    [data-m~=span] {
      grid-column: auto !important;
      grid-row: auto !important;
    }
    [data-m~=tile] {
      min-height: 260px;
    }
    [data-m~=g1] > *:not([data-m~=tile]):not([data-m~=herovis]):not([data-m~=collage]),
    [data-m~=g2] > *:not([data-m~=tile]):not([data-m~=herovis]):not([data-m~=collage]) {
      height: auto !important;
      min-height: 0 !important;
    }
    [data-m~=imgfirst] {
      order: -1 !important;
    }
    [data-m~=stack] {
      display: flex !important;
      flex-direction: column !important;
      align-items: flex-start !important;
      justify-content: flex-start !important;
      gap: 16px !important;
    }
    [data-m~=stack] > * {
      text-align: left !important;
      max-width: 100% !important;
    }
    [data-m~=ctas] {
      display: flex !important;
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 12px !important;
    }
    [data-m~=ctas] > * {
      text-align: center !important;
    }
    [data-m~=wrap] {
      flex-wrap: wrap !important;
      gap: 10px !important;
    }
    [data-m~=full] {
      width: 100% !important;
      max-width: 100% !important;
      min-width: 0 !important;
      flex: none !important;
    }
    [data-m~=nomin] {
      min-height: 0 !important;
    }
    [data-m~=hide] {
      display: none !important;
    }
    [data-m~=static] {
      position: static !important;
    }
    [data-m~=scroller] {
      overflow-x: auto !important;
      padding-left: 20px !important;
      scroll-snap-type: x mandatory;
      scrollbar-width: none;
    }
    [data-m~=track] {
      transform: none !important;
      padding-right: 20px;
      gap: 14px !important;
    }
    [data-m~=track] > * {
      flex: 0 0 290px !important;
      height: 430px !important;
      scroll-snap-align: start;
    }
    [data-m~=svcrow] {
      display: grid !important;
      grid-template-columns: auto minmax(0, 1fr) auto !important;
      column-gap: 14px !important;
      row-gap: 14px !important;
      align-items: center !important;
      flex-wrap: nowrap !important;
      padding: 16px 0 !important;
    }
    [data-m~=svcrow] > img {
      grid-column: 1 / -1 !important;
      grid-row: 1 !important;
      width: 100% !important;
      height: 200px !important;
    }
    [data-m~=svcrow] > [data-m~=price] {
      grid-column: 1 / -1 !important;
      justify-self: start !important;
      font-size: 28px !important;
    }
    [data-m~=imgtop] {
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 14px !important;
    }
    [data-m~=imgtop] > img {
      width: 100% !important;
      height: 220px !important;
      flex: none !important;
    }
    [data-m~=imgtop] > * {
      flex: none !important;
      max-width: 100% !important;
    }
    [data-m~=hero] {
      min-height: 520px !important;
    }
    h1 {
      line-height: 0.95 !important;
      font-size: clamp(34px, 8.5vw, 68px) !important;
    }
    .mega-panel {
      display: none !important;
    }

    /* Mobile panel accordion */
    .consultancy-panels-container {
      flex-direction: column !important;
      height: auto !important;
    }
    .consultancy-panels-container .cpanel {
      flex: none !important;
      width: 100% !important;
      height: 260px !important;
    }
    .consultancy-panels-container .cpanel .cpanel-label {
      display: none !important;
    }
    .consultancy-panels-container .cpanel .cpanel-body {
      display: block !important;
    }

    /* Fixed wide padding overrides */
    [style*="padding:0 64px"], [style*="padding: 0 64px"], [style*="padding:0px 64px"],
    [style*="padding:10px 64px"], [style*="padding: 10px 64px"],
    [style*="padding:20px 64px"], [style*="padding: 20px 64px"],
    [style*="padding:44px 64px"], [style*="padding: 44px 64px"],
    [style*="padding:60px 64px"], [style*="padding: 60px 64px"],
    [style*="padding:65px 64px"], [style*="padding: 65px 64px"],
    [style*="padding:70px 64px"], [style*="padding: 70px 64px"],
    [style*="padding:72px 64px"], [style*="padding: 72px 64px"],
    [style*="padding:80px 64px"], [style*="padding: 80px 64px"] {
      padding-left: 20px !important;
      padding-right: 20px !important;
    }
    section[style*="grid-template-columns"] {
      grid-template-columns: 1fr !important;
      gap: 24px !important;
    }

    /* Faster mobile reveal (12% viewport entry threshold) */
    @supports (animation-timeline: view()) {
      .reveal {
        animation-range: entry 0% cover 12% !important;
      }
    }

    /* Mobile Hero Tightening & White Space Removal */
    [data-m~=root] > section:first-of-type,
    section[data-m~=g1]:first-of-type,
    [data-m~=hero] {
      padding-top: 74px !important;
    padding-bottom: 56px !important;
      padding-left: 20px !important;
      padding-right: 20px !important;
      min-height: 0 !important;
      gap: 28px !important;
    }

    /* Consultancy Mobile Hero: Hide consultant photo, display discovery card + action badge */
    [data-m~=hv-img] {
      display: none !important;
    }
    [data-m~=herovis] {
      height: auto !important;
      min-height: 0 !important;
      display: block !important;
      position: relative !important;
      border-radius: 24px !important;
      overflow: hidden !important;
      background: linear-gradient(160deg, #F3F1FC, #E6E0FA) !important;
      padding: 64px 14px 16px !important;
      margin-top: 14px !important;
    }
    [data-m~=hv-chat] {
      position: relative !important;
      left: auto !important;
      right: auto !important;
      bottom: auto !important;
      top: auto !important;
      width: 100% !important;
      margin: 0 !important;
    }
    [data-m~=hv-chat] .tilt-straighten {
      transform: none !important;
      background: rgba(16,20,46,0.96) !important;
      backdrop-filter: blur(16px) !important;
      -webkit-backdrop-filter: blur(16px) !important;
      padding: 20px !important;
    }
    [data-m~=hv-chat] .cb {
      font-size: 13px !important;
      padding: 10px 14px !important;
    }
    [data-m~=hv-badge] {
      position: absolute !important;
      top: 12px !important;
      right: 12px !important;
      left: auto !important;
      margin: 0 !important;
    }
  }

    .mega:hover .mega-menu { display: block !important; }
    .mega:hover .mega-chevron { transform: rotate(180deg); }
  
  /* Slanted Header Switcher Pod & Hover States */
  .crux-sw-pod { transition: transform .2s ease, box-shadow .2s ease; }
  .crux-sw-pod:hover { transform: translateY(-1px); }
  .crux-sw-tab--inactive-dark:hover { color: #FFFFFF !important; background: rgba(255,255,255,0.08) !important; }
  .crux-sw-tab--inactive-light:hover { color: #10142E !important; background: rgba(108,88,219,0.12) !important; }

  </style>


<div style="width:100%; max-width:100%; margin:0; background:#0A0F26; overflow-x:clip;" data-m="root">

  <?php get_template_part( 'parts/site-header', null, array( 'skin' => 'dark', 'nav' => 'events', 'wing' => 'events', 'active' => 'events' ) ); ?>

  <!-- BREADCRUMB -->
  <div style=" padding:20px 20px 0px 20px;"><span style="font-size:13px; color:#7A82A8;"><a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="color:#7A82A8;">Home</a> / <a href="<?php echo esc_url( home_url( "/events/" ) ); ?>" style="color:#7A82A8;">Events</a> / <span style="color:#F4F5FA; font-weight:600;"><?php echo esc_html( $ev_data["short_title"] ); ?></span></span></div>

  <!-- HERO BANNER -->
  <section style="position:relative; margin:24px 20px 0px 20px; overflow:hidden; height:460px; clip-path:polygon(0 0,100% 0,100% 94%,0 100%); border:1.5px solid #1E2B5E;">
    <img src="<?php echo esc_url( $ev_data['hero_url'] ); ?>" alt="<?php echo esc_attr( $ev_data['short_title'] ); ?>" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;" class="drift">
    <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(10,15,38,0.94) 0%, rgba(10,15,38,0.2) 60%);"></div>
    <div class="float" style="--r:-8deg; position:absolute; top:24px; right:24px; width:96px; height:96px; border-radius:50%; border:2px dashed #5B8DEF; display:flex; align-items:center; justify-content:center; background:rgba(10,15,38,0.55);" data-m="hide"><span class="bebas" style="font-size:16px; color:#5B8DEF; text-align:center; line-height:1.1;"><?php echo esc_html( $ev_data['date_badge_day'] ); ?><br><?php echo esc_html( $ev_data['date_badge_month'] ); ?></span></div>
    <div style="position:absolute; left:0; right:0; bottom:0; padding:36px 36px 36px 36px;"><span class="eyebrow"><?php echo esc_html( $ev_data['category'] ); ?></span><h1 class="bebas" style="font-size:40px; margin:12px 0px 0px 0px; color:#F4F5FA;"><?php echo esc_html( $ev_data['title'] ); ?></h1></div>
  </section>

  <!-- EVENT DETAILS -->
  <section style="min-height:560px; padding:56px 20px 56px 20px; display:grid; grid-template-columns:1.6fr 1fr; gap:56px; align-items:start;" data-m="g1 nomin">
    <div class="reveal">
      <h2 class="bebas" style="font-size:32px; margin:0px 0px 16px 0px; color:#F4F5FA;">ABOUT THIS EVENT</h2>
      <?php if ( ! empty( $ev_data['desc_1'] ) ) : ?><p style="font-size:15px; line-height:1.8; color:#B4BCDD; margin:0px 0px 20px 0px;"><?php echo esc_html( $ev_data['desc_1'] ); ?></p><?php endif; ?>
      <?php if ( ! empty( $ev_data['desc_2'] ) ) : ?><p style="font-size:15px; line-height:1.8; color:#B4BCDD; margin:0px 0px 32px 0px;"><?php echo esc_html( $ev_data['desc_2'] ); ?></p><?php endif; ?>
      <h3 style="font-size:16px; margin:0px 0px 14px 0px; font-weight:700; color:#F4F5FA;">From The Gallery</h3>
      <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:14px;" data-m="g1">
        <?php foreach ( $ev_data['gallery_urls'] as $g_url ) : ?>
        <img src="<?php echo esc_url( $g_url ); ?>" alt="" style="width:100%; height:170px; object-fit:cover; border-radius:10px; border:1.5px solid #1E2B5E;" class="reveal">
        <?php endforeach; ?>
      </div>
    </div>
    <div style="background:#111838; border:1.5px solid #1E2B5E; border-radius:16px; padding:28px 28px 28px 28px;" class="reveal">
      <div style="display:flex; flex-direction:column; gap:16px; margin-bottom:22px;">
        <div style="display:flex; gap:18px; align-items:center;">
          <div class="ticket-stub" style="width:52px; height:52px; border-radius:8px; background:#002671; display:flex; flex-direction:column; align-items:center; justify-content:center; flex:0 0 52px;">
            <span style="font-size:9px; font-weight:800; letter-spacing:1px; color:#FFFFFF;"><?php echo esc_html( $ev_data['date_badge_month'] ); ?></span>
            <span class="bebas" style="font-size:20px; color:#FFFFFF;"><?php echo esc_html( $ev_data['date_badge_day'] ); ?></span>
          </div>
          <div>
            <div style="font-size:13.5px; font-weight:700; color:#F4F5FA;"><?php echo esc_html( $ev_data['date_str'] ); ?></div>
            <div style="font-size:12.5px; color:#A3A9C8;"><?php echo esc_html( $ev_data['time_str'] ); ?></div>
          </div>
        </div>
        <div style="display:flex; gap:14px; align-items:center;">
          <div style="width:44px; height:44px; border-radius:10px; background:rgba(91,141,239,0.12); display:flex; align-items:center; justify-content:center; flex:0 0 44px;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 21s7-6.5 7-12a7 7 0 1 0-14 0c0 5.5 7 12 7 12z" stroke="#5B8DEF" stroke-width="1.6"></path><circle cx="12" cy="9" r="2.4" stroke="#5B8DEF" stroke-width="1.6"></circle></svg></div>
          <div>
            <div style="font-size:13.5px; font-weight:700; color:#F4F5FA;"><?php echo esc_html( $ev_data['location'] ); ?></div>
            <div style="font-size:12.5px; color:#A3A9C8;"><?php echo esc_html( $ev_data['country'] ); ?></div>
          </div>
        </div>
      </div>
      <?php
      $event_id    = ! empty( $ev_data['id'] ) ? absint( $ev_data['id'] ) : 0;
      $event_tiers = ( $event_id && function_exists( 'cr8v_tix_get_event_tiers' ) ) ? cr8v_tix_get_event_tiers( $event_id, true ) : array();
      // Past events never show the booking modal (the server also refuses the booking).
      $has_tiers   = ! empty( $event_tiers ) && empty( $ev_data['is_past'] );
      if ( $has_tiers ) : ?>
        <button type="button" id="cr8v-open-modal-btn" style="display:block; width:100%; text-align:center; background:#BA0000; color:#FFFFFF; font-weight:700; font-size:15px; padding:16px 16px; margin-bottom:12px; --sl:10px; cursor:pointer;" class="bx">
          <?php esc_html_e( 'Reserve Your Spot', 'cruxnxtion' ); ?>
        </button>
      <?php else : ?>
        <a href="<?php echo !empty($ev_data['eventbrite']) ? esc_url($ev_data['eventbrite']) : esc_url( home_url('/contact/') ); ?>" style="display:block; text-align:center; background:#BA0000; color:#FFFFFF; font-weight:700; font-size:15px; padding:16px 16px 16px 16px; margin-bottom:12px; --sl:10px;" class="bx" <?php echo !empty($ev_data['eventbrite']) ? 'target="_blank" rel="noopener"' : ''; ?>>Reserve Your Spot</a>
      <?php endif; ?>
      <a href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="display:block; text-align:center; color:#F4F5FA; font-weight:700; font-size:14px; padding:14px 14px 14px 14px; --sl:10px; --bc:#F4F5FA;" class="bx">Ask A Question</a>
    </div>
  </section>

  <!-- YOU MIGHT ALSO LIKE -->
  <section style=" padding:20px 20px 44px 20px;">
    <h2 class="bebas reveal" style="font-size:36px; margin:0px 0px 28px 0px; color:#F4F5FA;">YOU MIGHT ALSO LIKE</h2>
    <div style="display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:24px;" class="reveal" data-m="g1">
      <?php
      $rendered_count = 0;
      foreach ( $all_events as $slug => $e_item ) :
          if ( $slug === $current_slug ) continue;
          if ( $rendered_count >= 2 ) break;
          $rendered_count++;
      ?>
      <a href="<?php echo esc_url( home_url( "/event/" . $slug . "/" ) ); ?>" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:14px; overflow:hidden;" class="reveal">
        <div style="height:200px;"><img src="<?php echo esc_url( $e_item['hero_url'] ); ?>" alt="<?php echo esc_attr( $e_item['short_title'] ); ?>" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div style=" padding:20px 20px 20px 20px; display:flex; flex-direction:column; gap:8px;">
          <span class="eyebrow"><?php echo esc_html( $e_item['category'] . ' • ' . $e_item['date_str'] ); ?></span>
          <h3 style="font-size:17px; margin:0px 0px 0px 0px; font-weight:700; color:#F4F5FA;"><?php echo esc_html( $e_item['short_title'] ); ?></h3>
          <p style="font-size:12.5px; color:#A3A9C8; margin:0px 0px 0px 0px;"><?php echo esc_html( $e_item['location'] ); ?></p>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- PREFOOTER CTA — cinematic band with spinning rosette badge -->
  <section style="position:relative; min-height:540px; overflow:hidden; display:flex; align-items:center;">
    <img src="<?php echo crux_get_blob_url( 'aa52e28c3ca12b7f14d33300c774fb48' ); ?>" alt="Crux Nxtion event crowd" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
    <div style="position:absolute; inset:0; background:linear-gradient(100deg, rgba(10,15,38,0.97) 0%, rgba(10,15,38,0.82) 52%, rgba(10,15,38,0.5) 100%);"></div>
    <div style="position:absolute; left:0; right:0; top:0; height:26px; background:#05081A; background-image:repeating-linear-gradient(90deg, transparent 0 18px, rgba(244,245,250,0.16) 18px 34px, transparent 34px 52px); background-size:52px 12px; background-repeat:repeat-x; background-position:0 7px; z-index:2;"></div>
    <div style="position:absolute; left:0; right:0; bottom:0; height:26px; background:#05081A; background-image:repeating-linear-gradient(90deg, transparent 0 18px, rgba(244,245,250,0.16) 18px 34px, transparent 34px 52px); background-size:52px 12px; background-repeat:repeat-x; background-position:0 7px; z-index:2;"></div>
    <div style="position:relative; z-index:1; width:100%; display:flex; justify-content:space-between; align-items:center; gap:40px; padding:0 64px; flex-wrap:wrap;" class="reveal" data-m="prefooter-inner">
      <div style="max-width:760px; padding:40px 0;">
        <span class="eyebrow" style="color:#A9C0F5 !important;">Ready When You Are</span>
        <h2 class="bebas" style="font-size:clamp(44px, 5.5vw, 76px); line-height:0.95; margin:16px 0 18px; color:#FFFFFF; max-width:820px;">GOT A DATE, OR JUST A DIRECTION?</h2>
        <p style="font-size:16px; line-height:1.7; color:#C5CADF; max-width:540px; margin:0 0 32px;">Planning an event or building a business — tell us what you have in mind and a real person will come back to you.</p>
        <div style="display:flex; gap:16px;" data-m="ctas">
          <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:15px; padding:17px 32px; --sl:10px;" class="bx">Plan An Event →</a>
          <a href="<?php echo esc_url( home_url( "/contact/?type=consultancy" ) ); ?>" style="background:#8C7AE6; color:#10142E !important; font-weight:700; font-size:15px; padding:17px 32px; --sl:10px;" class="bx">Talk Business Strategy →</a>
        </div>
      </div>
      <div class="prefooter__badge" style="width:160px; height:160px; flex:0 0 160px;">
        <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" class="prefooter__badge-link" aria-label="Plan An Event" style="display:block; width:100%; height:100%; text-decoration:none; transition:transform .3s ease;">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/prefooter-badge-events.svg' ); ?>" class="prefooter__badge-img" alt="Plan An Event — spinning badge" style="width:100%; height:100%; object-fit:contain; animation:rc-spin 14s linear infinite; filter:drop-shadow(0 12px 28px rgba(0,0,0,0.5));">
        </a>
      </div>
    </div>
  </section>

  <!-- COLOSSAL FOOTER -->
  <footer id="contact" style="background:#0A0F26; padding:44px 24px 44px 24px; text-align:center; position:relative; overflow:hidden;">
    <div style="position:relative; margin-bottom:40px;">
      <span class="bebas" style="font-size:clamp(80px,17vw,220px); line-height:0.82; display:block; background:linear-gradient(180deg, #F4F5FA 0%, #A9C0F5 25%, #1E2B5E 65%, transparent 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; position:relative;">CRUX</span>
      <span class="bebas" style="font-size:clamp(30px,6.4vw,82px); line-height:1; display:block; background:linear-gradient(180deg, #F4F5FA 0%, #A9C0F5 25%, #1E2B5E 65%, transparent 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; position:relative; letter-spacing:0.5em; margin-top:10px; padding-left:0.5em;">NXTION</span>
    </div>
    <div style="display:flex; justify-content:center; align-items:center; flex-wrap:wrap; gap:32px; margin-bottom:32px;" data-m="wrap">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="font-size:14px; color:#A3A9C8;">Home</a>
      <a href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="font-size:14px; color:#A3A9C8;">Services</a>
      <a href="<?php echo esc_url( home_url( "/events/" ) ); ?>" style="font-size:14px; color:#A3A9C8;">Events</a>
      <a href="<?php echo esc_url( home_url( "/gallery/" ) ); ?>" style="font-size:14px; color:#A3A9C8;">Gallery</a>
      <a href="<?php echo esc_url( home_url( "/about/" ) ); ?>" style="font-size:14px; color:#A3A9C8;">About</a>
      <a href="<?php echo esc_url( home_url( "/faq/" ) ); ?>" style="font-size:14px; color:#A3A9C8;">FAQ</a>
      <a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" style="font-size:14px; color:#A3A9C8;">Blog</a>
      <a href="<?php echo esc_url( home_url( "/sponsors/" ) ); ?>" style="font-size:14px; color:#A3A9C8;">Sponsors</a>
    </div>
    <div style="display:flex; justify-content:center; gap:14px; margin-bottom:44px;" data-m="wrap">
      <a href="#" aria-label="Instagram" style="display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; background:rgba(244,245,250,0.05); color:#F4F5FA; --sl:7px; --bc:rgba(244,245,250,0.12);" class="bx"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" stroke="currentColor" stroke-width="1.5"></rect><circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5"></circle><circle cx="17.4" cy="6.6" r="1" fill="currentColor"></circle></svg></a>
      <a href="#" aria-label="TikTok" style="display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; background:rgba(244,245,250,0.05); color:#F4F5FA; --sl:7px; --bc:rgba(244,245,250,0.12);" class="bx"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M14 3v10.5a3.5 3.5 0 1 1-3-3.46" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path><path d="M14 3c.4 2.6 2.2 4.4 4.8 4.8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path></svg></a>
      <a href="#" aria-label="WhatsApp" style="display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; background:rgba(244,245,250,0.05); color:#F4F5FA; --sl:7px; --bc:rgba(244,245,250,0.12);" class="bx"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 20l1.4-4.1A8 8 0 1 1 9 19.5L4 20Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"></path><path d="M8.5 9.5c0 3.5 3 6.5 6.5 6.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path></svg></a>
    </div>
    <div style="display:flex; justify-content:center; flex-wrap:wrap; gap:8px 26px; margin-bottom:20px;" data-m="wrap">
      <a href="<?php echo esc_url( home_url( "/privacy-policy/" ) ); ?>" style="font-size:12.5px; color:#8E96BB;">Privacy Policy</a>
      <a href="<?php echo esc_url( home_url( "/cookie-policy/" ) ); ?>" style="font-size:12.5px; color:#8E96BB;">Cookie Policy</a>
      <a href="<?php echo esc_url( home_url( "/terms-conditions/" ) ); ?>" style="font-size:12.5px; color:#8E96BB;">Terms &amp; Conditions</a>
    </div>
    <div style="width:100%; max-width:900px; height:1px; background:#1E2B5E; margin:0 auto 24px;"></div>
    <p style="font-size:13px; color:#7A82A8; margin:0px 0px 0px 0px;">&copy; <?php echo date( "Y" ); ?> Crux Nxtion Events • Sheffield, United Kingdom • All Rights Reserved</p>
  </footer>

<div class="msw">
  <div class="crux-sw-pod crux-sw-pod--dark" style="pointer-events:auto; display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #2A3F7A 0%, #15224A 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(0,0,0,0.65); filter:drop-shadow(0 4px 12px rgba(0,0,0,0.4));">
    <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#020512; padding:4px; gap:4px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.5);">
        <span>Events</span>
      </a>
      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-dark" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#8E96BB; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">
        <span>Consultancy</span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:6px; display:inline-block; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>
</div></div></div>





<?php if ( ! empty( $has_tiers ) ) : ?>
<!-- ========================================================================= -->
<!-- CR8V EVENT TICKETING - SLANTED BOOKING MODAL (PHASE 2)                    -->
<style>
  @media (max-width: 600px) {
    .cr8v-modal-overlay { padding: 16px 12px !important; }
    .cr8v-modal-dialog { padding: 22px 16px !important; border-radius: 12px !important; }
    #cr8v-modal-title { font-size: 26px !important; }
    .cr8v-modal-tier-row { padding: 12px 14px !important; gap: 10px !important; }
  }
</style>
<div id="cr8v-booking-modal" class="cr8v-modal-overlay" style="display:<?php echo isset( $_GET['book'] ) ? 'flex' : 'none'; ?>; position:fixed; inset:0; z-index:99999; background:rgba(5,8,26,0.88); backdrop-filter:blur(10px); -webkit-backdrop-filter:blur(10px); overflow-y:auto; padding:24px 16px; align-items:center; justify-content:center; box-sizing:border-box;" role="dialog" aria-modal="true" aria-labelledby="cr8v-modal-title">
  <div class="cr8v-modal-dialog" style="position:relative; width:100%; max-width:600px; background:#111838; border:1.5px solid #1E2B5E; border-radius:16px; padding:32px 28px; box-shadow:0 24px 50px rgba(0,0,0,0.6); margin:auto; box-sizing:border-box;">
    <!-- Close button -->
    <button type="button" id="cr8v-close-modal-btn" aria-label="<?php esc_attr_e( 'Close booking modal', 'cruxnxtion' ); ?>" style="position:absolute; top:20px; right:20px; background:rgba(255,255,255,0.06); border:1px solid #1E2B5E; border-radius:50%; width:36px; height:36px; color:#F4F5FA; font-size:18px; line-height:34px; text-align:center; cursor:pointer;">✕</button>

    <!-- Modal Header -->
    <div style="margin-bottom:24px; padding-right:40px;">
      <span class="eyebrow" style="color:#5B8DEF; font-size:11px;"><?php esc_html_e( 'SECURE TICKETING', 'cruxnxtion' ); ?></span>
      <h2 id="cr8v-modal-title" class="bebas" style="font-size:32px; color:#FFFFFF; margin:6px 0 4px 0;"><?php echo esc_html( $ev_data['title'] ); ?></h2>
      <p style="font-size:13.5px; color:#A3A9C8; margin:0;"><?php echo esc_html( $ev_data['date_str'] . ( ! empty( $ev_data['time_str'] ) ? ' • ' . $ev_data['time_str'] : '' ) . ( ! empty( $ev_data['location'] ) ? ' • ' . $ev_data['location'] : '' ) ); ?></p>
    </div>

    <!-- Error message alert -->
    <div id="cr8v-modal-error" style="display:none; background:#721c24; border:1px solid #f5c6cb; color:#FFFFFF; padding:12px 16px; border-radius:8px; font-size:13.5px; margin-bottom:18px; line-height:1.5;" role="alert"></div>

    <form id="cr8v-booking-form">
      <!-- Honeypot: must remain empty -->
      <div style="display:none !important; position:absolute; left:-9999px;">
        <label for="cr8v-hp-website"><?php esc_html_e( 'Leave this field empty', 'cruxnxtion' ); ?></label>
        <input type="text" id="cr8v-hp-website" name="website" tabindex="-1" autocomplete="off" value="">
      </div>

      <!-- Ticket Tiers List -->
      <div style="margin-bottom:22px;">
        <label style="display:block; font-size:11px; font-weight:700; color:#7A82A8; text-transform:uppercase; letter-spacing:1px; margin-bottom:10px;"><?php esc_html_e( 'Select Tickets', 'cruxnxtion' ); ?></label>
        <div style="display:flex; flex-direction:column; gap:12px;">
          <?php foreach ( $event_tiers as $tier ) :
            $is_sold_out = ! empty( $tier['is_sold_out'] );
            $avail       = isset( $tier['available_count'] ) ? (int) $tier['available_count'] : 0;
            $max_order   = isset( $tier['max_per_order'] ) ? (int) $tier['max_per_order'] : 10;
            $max_select  = min( $max_order, $avail, 20 );
          ?>
          <div class="cr8v-modal-tier-row" style="background:#0D1330; border:1.5px solid <?php echo $is_sold_out ? '#242a47' : '#1E2B5E'; ?>; border-radius:10px; padding:16px 18px; display:flex; justify-content:space-between; align-items:center; gap:16px; opacity:<?php echo $is_sold_out ? '0.6' : '1'; ?>; box-sizing:border-box;">
            <div style="flex:1; min-width:0;">
              <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:4px;">
                <span style="font-weight:700; font-size:15px; color:#FFFFFF;"><?php echo esc_html( $tier['name'] ); ?></span>
                <?php if ( $is_sold_out ) : ?>
                  <span style="background:#dc3545; color:#FFFFFF; font-size:10px; font-weight:800; padding:2px 8px; border-radius:4px; text-transform:uppercase; letter-spacing:0.5px;"><?php esc_html_e( 'Sold Out', 'cruxnxtion' ); ?></span>
                <?php else : ?>
                  <span style="background:rgba(91,141,239,0.15); color:#5B8DEF; font-size:10px; font-weight:800; padding:2px 8px; border-radius:4px; text-transform:uppercase; letter-spacing:0.5px;">
                    <?php echo sprintf( esc_html__( '%d remaining', 'cruxnxtion' ), $avail ); ?>
                  </span>
                <?php endif; ?>
              </div>
              <?php if ( ! empty( $tier['description'] ) ) : ?>
                <div style="font-size:12px; color:#A3A9C8; line-height:1.4; margin-bottom:6px;"><?php echo esc_html( $tier['description'] ); ?></div>
              <?php endif; ?>
              <div style="font-size:14px; font-weight:700; color:#5B8DEF;"><?php echo esc_html( $tier['price_formatted'] ); ?></div>
            </div>

            <div>
              <?php if ( $is_sold_out ) : ?>
                <span style="font-size:12px; color:#7A82A8; font-weight:600;"><?php esc_html_e( 'Unavailable', 'cruxnxtion' ); ?></span>
              <?php else : ?>
                <select class="cr8v-tier-qty" data-tier-id="<?php echo esc_attr( $tier['id'] ); ?>" data-price-pence="<?php echo esc_attr( (int) $tier['price_pence'] ); ?>" style="background:#111838; color:#F4F5FA; border:1.5px solid #1E2B5E; border-radius:6px; padding:8px 12px; font-weight:700; font-size:14px; cursor:pointer;">
                  <option value="0">0</option>
                  <?php for ( $q = 1; $q <= $max_select; $q++ ) : ?>
                    <option value="<?php echo esc_attr( $q ); ?>"><?php echo esc_html( $q ); ?></option>
                  <?php endfor; ?>
                </select>
              <?php endif; ?>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Attendee Contact Information -->
      <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:22px;">
        <label style="display:block; font-size:11px; font-weight:700; color:#7A82A8; text-transform:uppercase; letter-spacing:1px;"><?php esc_html_e( 'Your Contact Details', 'cruxnxtion' ); ?></label>
        <div>
          <input type="text" id="cr8v-buyer-name" required placeholder="<?php esc_attr_e( 'Full Name *', 'cruxnxtion' ); ?>" maxlength="100" style="width:100%; background:#0D1330; border:1.5px solid #1E2B5E; border-radius:8px; padding:12px 14px; color:#F4F5FA; font-size:14px; box-sizing:border-box;">
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" data-m="g1">
          <div>
            <input type="email" id="cr8v-buyer-email" required placeholder="<?php esc_attr_e( 'Email Address *', 'cruxnxtion' ); ?>" style="width:100%; background:#0D1330; border:1.5px solid #1E2B5E; border-radius:8px; padding:12px 14px; color:#F4F5FA; font-size:14px; box-sizing:border-box;">
          </div>
          <div>
            <input type="tel" id="cr8v-buyer-phone" placeholder="<?php esc_attr_e( 'Phone (Optional)', 'cruxnxtion' ); ?>" maxlength="30" style="width:100%; background:#0D1330; border:1.5px solid #1E2B5E; border-radius:8px; padding:12px 14px; color:#F4F5FA; font-size:14px; box-sizing:border-box;">
          </div>
        </div>
      </div>

      <!-- Live Order Summary Badge -->
      <div style="background:#0D1330; border:1px solid #1E2B5E; border-radius:8px; padding:14px 18px; margin-bottom:22px; display:flex; justify-content:space-between; align-items:center;">
        <div>
          <span style="font-size:12px; color:#7A82A8;"><?php esc_html_e( 'Estimated Total:', 'cruxnxtion' ); ?></span>
          <div id="cr8v-summary-tickets" style="font-size:12px; color:#5B8DEF; font-weight:600;"><?php esc_html_e( '0 tickets selected', 'cruxnxtion' ); ?></div>
        </div>
        <div id="cr8v-summary-price" style="font-size:22px; font-weight:700; color:#FFFFFF;">£0.00</div>
      </div>

      <!-- Submit CTA button -->
      <button type="submit" id="cr8v-submit-booking-btn" class="bx" style="width:100%; background:#BA0000; color:#FFFFFF; font-weight:700; font-size:15px; padding:16px 20px; --sl:10px; cursor:pointer;" disabled>
        <span id="cr8v-btn-text"><?php esc_html_e( 'Select Tickets To Continue', 'cruxnxtion' ); ?></span>
      </button>

      <p style="font-size:11.5px; color:#7A82A8; text-align:center; margin:12px 0 0 0; line-height:1.5;">
        <?php esc_html_e( 'All pricing computed securely on server. Payments processed via encrypted Stripe checkout.', 'cruxnxtion' ); ?>
      </p>
    </form>
  </div>
</div>

<script>
(function() {
  var modal = document.getElementById('cr8v-booking-modal');
  var openBtn = document.getElementById('cr8v-open-modal-btn');
  var closeBtn = document.getElementById('cr8v-close-modal-btn');
  var form = document.getElementById('cr8v-booking-form');
  var submitBtn = document.getElementById('cr8v-submit-booking-btn');
  var btnText = document.getElementById('cr8v-btn-text');
  var errorBox = document.getElementById('cr8v-modal-error');
  var qtySelects = document.querySelectorAll('.cr8v-tier-qty');
  var summaryQty = document.getElementById('cr8v-summary-tickets');
  var summaryPrice = document.getElementById('cr8v-summary-price');

  if (!modal || !openBtn) return;

  function updateTotals() {
    var totalQty = 0;
    var totalPence = 0;
    qtySelects.forEach(function(sel) {
      var q = parseInt(sel.value, 10) || 0;
      var pricePence = parseInt(sel.getAttribute('data-price-pence'), 10) || 0;
      totalQty += q;
      totalPence += (q * pricePence);
    });

    if (summaryQty) {
      summaryQty.textContent = totalQty === 1 ? '1 ticket selected' : totalQty + ' tickets selected';
    }
    if (summaryPrice) {
      summaryPrice.textContent = totalPence === 0 ? '£0.00' : '£' + (totalPence / 100).toFixed(2);
    }

    if (submitBtn) {
      if (totalQty > 0) {
        submitBtn.removeAttribute('disabled');
        submitBtn.style.opacity = '1';
        submitBtn.style.cursor = 'pointer';
        if (btnText) {
          btnText.textContent = totalPence === 0 ? 'Confirm Free RSVP →' : 'Proceed to Checkout (' + '£' + (totalPence / 100).toFixed(2) + ') →';
        }
      } else {
        submitBtn.setAttribute('disabled', 'disabled');
        submitBtn.style.opacity = '0.5';
        submitBtn.style.cursor = 'not-allowed';
        if (btnText) {
          btnText.textContent = 'Select Tickets To Continue';
        }
      }
    }
  }

  qtySelects.forEach(function(sel) {
    sel.addEventListener('change', updateTotals);
  });

  function openModal() {
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    updateTotals();
    var firstInput = document.getElementById('cr8v-buyer-name');
    if (firstInput) firstInput.focus();
  }

  function closeModal() {
    modal.style.display = 'none';
    document.body.style.overflow = '';
    if (errorBox) {
      errorBox.style.display = 'none';
      errorBox.textContent = '';
    }
    openBtn.focus();
  }

  openBtn.addEventListener('click', openModal);
  if (closeBtn) closeBtn.addEventListener('click', closeModal);

  modal.addEventListener('click', function(e) {
    if (e.target === modal) {
      closeModal();
    }
  });

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && modal.style.display === 'flex') {
      closeModal();
    }
  });

  if (window.location.hash === '#book' || window.location.search.indexOf('book=1') !== -1) {
    openModal();
  }

  if (form) {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      if (errorBox) {
        errorBox.style.display = 'none';
        errorBox.textContent = '';
      }

      var items = [];
      qtySelects.forEach(function(sel) {
        var q = parseInt(sel.value, 10) || 0;
        if (q > 0) {
          items.push({
            tier_id: sel.getAttribute('data-tier-id'),
            quantity: q
          });
        }
      });

      if (items.length === 0) {
        if (errorBox) {
          errorBox.textContent = 'Please select at least one ticket.';
          errorBox.style.display = 'block';
        }
        return;
      }

      var customerName = (document.getElementById('cr8v-buyer-name') || {}).value || '';
      var customerEmail = (document.getElementById('cr8v-buyer-email') || {}).value || '';
      var customerPhone = (document.getElementById('cr8v-buyer-phone') || {}).value || '';
      var websiteHp = (document.getElementById('cr8v-hp-website') || {}).value || '';

      var payload = {
        event_id: <?php echo absint( $event_id ); ?>,
        customer_name: customerName.trim(),
        customer_email: customerEmail.trim(),
        customer_phone: customerPhone.trim(),
        items: items,
        website: websiteHp
      };

      if (submitBtn) {
        submitBtn.setAttribute('disabled', 'disabled');
        submitBtn.style.opacity = '0.7';
      }
      if (btnText) {
        btnText.textContent = 'Securing Tickets...';
      }

      fetch('<?php echo esc_url_raw( rest_url( 'cr8v-ticketing/v1/checkout' ) ); ?>', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
      })
      .then(function(res) {
        return res.json().then(function(data) {
          return { status: res.status, ok: res.ok, data: data };
        });
      })
      .then(function(result) {
        if (result.ok && result.data && result.data.success && result.data.redirect_url) {
          window.location.href = result.data.redirect_url;
        } else {
          var msg = (result.data && result.data.message) ? result.data.message : 'Unable to reserve tickets. Please try again.';
          if (errorBox) {
            errorBox.textContent = msg;
            errorBox.style.display = 'block';
          }
          if (submitBtn) {
            submitBtn.removeAttribute('disabled');
            submitBtn.style.opacity = '1';
          }
          updateTotals();
        }
      })
      .catch(function(err) {
        if (errorBox) {
          errorBox.textContent = 'A network error occurred. Please check your connection and try again.';
          errorBox.style.display = 'block';
        }
        if (submitBtn) {
          submitBtn.removeAttribute('disabled');
          submitBtn.style.opacity = '1';
        }
        updateTotals();
      });
    });
  }
})();
</script>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
