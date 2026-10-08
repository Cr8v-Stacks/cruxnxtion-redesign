<?php
/**
 * Template Name: Crux Nxtion - Template
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> style="background:#FFFFFF; margin:0; padding:0;">
<?php wp_body_open(); ?>



<style>
  @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Space+Grotesk:wght@400;500;600;700&display=swap');
  * { box-sizing: border-box; }
  body { margin: 0; font-family: 'Space Grotesk', system-ui, sans-serif; background:#FFFFFF; color:#10142E; }
  a { color: #FF2E3D; text-decoration: none; }
  a:hover { color: #8C7AE6; }
  .bebas { font-family: 'Bebas Neue', 'Arial Narrow', sans-serif; letter-spacing: 0.5px; line-height: 0.9; text-transform: uppercase; }
  .eyebrow { font-weight: 600; letter-spacing: 3px; text-transform: uppercase; font-size: 11px; color: #FF2E3D; }
  .ticket-stub { position: relative; }
  .ticket-stub::before, .ticket-stub::after { content: ''; position: absolute; right: -11px; width: 20px; height: 20px; border-radius: 50%; background: #10142E; z-index: 2; }
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

  .bento-tile { transition: transform .3s ease, box-shadow .3s ease; }
  .bento-tile:hover { transform: translateY(-4px); box-shadow: 0 18px 34px rgba(0,0,0,0.28); }
  .bubble-in { animation: rcFadeIn .6s ease-out both; }
  @keyframes rise { from { opacity:0; transform:translateY(18px); } to { opacity:1; transform:none; } }
  @keyframes floaty { 0%,100% { transform: translateY(0) rotate(var(--r,0deg)); } 50% { transform: translateY(-8px) rotate(var(--r,0deg)); } }
  @keyframes pulse { 0% { box-shadow:0 0 0 0 rgba(61,220,132,.6); } 70% { box-shadow:0 0 0 8px rgba(61,220,132,0); } 100% { box-shadow:0 0 0 0 rgba(61,220,132,0); } }
  h1, .eyebrow { animation: rise .8s ease both; }
  h1 { animation-delay: .12s; }
  section h2 { animation: rise .7s ease both; }
  .bento-tile img { transition: transform .6s ease; }
  .bento-tile:hover img { transform: scale(1.06); }
  button { transition: transform .2s ease, background .2s ease, opacity .2s ease; }
  button:hover { transform: scale(1.08); }
  .float { animation: floaty 5s ease-in-out infinite; }
  .pulse-dot { animation: pulse 2s infinite; }
  a[style*="clip-path"]:active { transform: translateY(0) scale(.98); }
  body { background:#FFFFFF; color:#10142E; }
  .eyebrow { color:#6C58DB !important; }
  .ticket-stub::before, .ticket-stub::after { background:#FFFFFF !important; }

    /* Services Dropdown (Focused Floating Card - Light Theme) */
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
  .mdrawer-body .msub { display: block; padding: 6px 0; font-size: 13.5px; text-decoration: none; border-bottom: 1px solid rgba(16,20,46,0.06); }
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
      top: 0 !important;
      left: 0 !important;
      right: 0 !important;
      bottom: 0 !important;
      width: 100% !important;
      height: 100vh !important;
      z-index: 99999 !important;
      overflow-y: auto !important;
      -webkit-overflow-scrolling: touch;
      padding: 0 !important;
      box-sizing: border-box;
    }
    
    .mdrawer-topbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 20px;
      flex-shrink: 0;
    }
    .mdrawer-close-btn {
      width: 44px;
      height: 44px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 26px;
      line-height: 1;
      border-radius: 8px;
      transition: transform .2s ease, background .2s ease;
    }
    .mdrawer-close-btn:active {
      transform: scale(0.92);
    }
    .mdrawer-body {
      flex: 1;
      padding: 14px 20px 36px;
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


<div style="width:100%; max-width:100%; margin:0; background:#FFFFFF; overflow-x:clip;" data-m="root">

  <?php get_template_part( 'parts/site-header', null, array( 'skin' => 'light', 'nav' => 'consultancy', 'wing' => 'events', 'active' => 'founder' ) ); ?>

  <!-- ABOUT / MEET THE TEAM HERO -->
  <section style="padding:54px 20px 54px 20px; display:grid; grid-template-columns:0.82fr 1.18fr; gap:64px; align-items:center;" data-m="g1">
    <div class="tilt-straighten reveal" style="--r:-2deg; transform:rotate(var(--r)); border-radius:24px; overflow:hidden; border:2px solid #8C7AE6; height:620px;">
      <img src="<?php echo crux_get_blob_url( 'a67d85c16f6df90ab7a657160bee9088' ); ?>" alt="Olabamidele 'Bambad' Badmos" style="width:100%; height:100%; object-fit:cover; object-position:58% 12%;">
    </div>
    <div class="reveal">
      <span class="eyebrow" style="color:#6C58DB;"><?php echo crux_h( 'founder', 'about_meet_the_team_hero_small_heading_1' ); ?></span>
      <h1 class="bebas" style="font-size:52px; margin:14px 0px 8px 0px; color:#10142E; line-height:0.95;"><?php echo crux_h( 'founder', 'about_meet_the_team_hero_heading_1' ); ?></h1>
      <p style="font-size:14px; font-weight:700; letter-spacing:1.8px; text-transform:uppercase; color:#5A5F86; margin:0px 0px 22px 0px;"><?php echo crux_h( 'founder', 'about_meet_the_team_hero_paragraph_1' ); ?></p>
      
      <p style="font-size:16.5px; line-height:1.8; color:#3A3F66; max-width:620px; margin:0px 0px 20px 0px;"><?php echo crux_h( 'founder', 'about_meet_the_team_hero_paragraph_2' ); ?></p>

      <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:28px;" data-m="wrap">
        <span style="background:#FFFFFF; color:#3A3F66; font-size:12px; font-weight:700; padding:9px 18px; --sl:6px; --bc:#D2CEEA;" class="bx"><?php echo crux_h( 'founder', 'about_meet_the_team_hero_text_1' ); ?></span>
        <span style="background:#FFFFFF; color:#3A3F66; font-size:12px; font-weight:700; padding:9px 18px; --sl:6px; --bc:#D2CEEA;" class="bx"><?php echo crux_h( 'founder', 'about_meet_the_team_hero_text_2' ); ?></span>
        <span style="background:#FFFFFF; color:#3A3F66; font-size:12px; font-weight:700; padding:9px 18px; --sl:6px; --bc:#D2CEEA;" class="bx"><?php echo crux_h( 'founder', 'about_meet_the_team_hero_text_3' ); ?></span>
        <span style="background:#FFFFFF; color:#3A3F66; font-size:12px; font-weight:700; padding:9px 18px; --sl:6px; --bc:#D2CEEA;" class="bx"><?php echo crux_h( 'founder', 'about_meet_the_team_hero_text_4' ); ?></span>
      </div>

      <div style="display:flex; gap:14px; flex-wrap:wrap;">
        <a href="<?php echo esc_url( home_url( '/contact/?type=events' ) ); ?>" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:14.5px; padding:15px 28px; --sl:10px;" class="bx"><?php echo crux_h( 'founder', 'about_meet_the_team_hero_button_1' ); ?></a>
        <a href="<?php echo esc_url( crux_opt( 'calendly_url' ) ); ?>" target="_blank" rel="noopener" style="background:#8C7AE6; color:#10142E; font-weight:700; font-size:14.5px; padding:15px 28px; --sl:10px;" class="bx"><?php echo crux_h( 'founder', 'about_meet_the_team_hero_button_2' ); ?></a>
      </div>
    </div>
  </section>

  <!-- EVENT LEGACY SECTION -->
  <section style="padding:60px 20px; background:#F3F1FC;">
    <div style="max-width:1100px; margin:0 auto;">
      <div class="reveal" style="text-align:center; margin-bottom:44px;">
        <span class="eyebrow"><?php echo crux_h( 'founder', 'event_legacy_section_small_heading_1' ); ?></span>
        <h2 class="bebas" style="font-size:42px; margin:12px 0 10px; color:#10142E;"><?php echo crux_h( 'founder', 'event_legacy_section_heading_1' ); ?></h2>
        <p style="font-size:15.5px; color:#5A5F86; max-width:680px; margin:0 auto; line-height:1.7;"><?php echo crux_h( 'founder', 'event_legacy_section_paragraph_1' ); ?></p>
      </div>

      <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:22px;" class="reveal" data-m="g1">
        <div class="bento-tile" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:18px; padding:28px 26px;">
          <span class="bebas" style="font-size:32px; color:#BA0000; display:block; margin-bottom:8px;">01</span>
          <h3 class="bebas" style="font-size:24px; color:#10142E; margin:0 0 10px;"><?php echo crux_h( 'founder', 'event_legacy_section_heading_2' ); ?></h3>
          <p style="font-size:13.5px; line-height:1.65; color:#5A5F86; margin:0;"><?php echo crux_h( 'founder', 'event_legacy_section_paragraph_2' ); ?></p>
        </div>

        <div class="bento-tile" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:18px; padding:28px 26px;">
          <span class="bebas" style="font-size:32px; color:#6C58DB; display:block; margin-bottom:8px;">02</span>
          <h3 class="bebas" style="font-size:24px; color:#10142E; margin:0 0 10px;"><?php echo crux_h( 'founder', 'event_legacy_section_heading_3' ); ?></h3>
          <p style="font-size:13.5px; line-height:1.65; color:#5A5F86; margin:0;"><?php echo crux_h( 'founder', 'event_legacy_section_paragraph_3' ); ?></p>
        </div>

        <div class="bento-tile" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:18px; padding:28px 26px;">
          <span class="bebas" style="font-size:32px; color:#002671; display:block; margin-bottom:8px;">03</span>
          <h3 class="bebas" style="font-size:24px; color:#10142E; margin:0 0 10px;"><?php echo crux_h( 'founder', 'event_legacy_section_heading_4' ); ?></h3>
          <p style="font-size:13.5px; line-height:1.65; color:#5A5F86; margin:0;"><?php echo crux_h( 'founder', 'event_legacy_section_paragraph_4' ); ?></p>
        </div>

        <div class="bento-tile" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:18px; padding:28px 26px;">
          <span class="bebas" style="font-size:32px; color:#BA0000; display:block; margin-bottom:8px;">04</span>
          <h3 class="bebas" style="font-size:24px; color:#10142E; margin:0 0 10px;"><?php echo crux_h( 'founder', 'event_legacy_section_heading_5' ); ?></h3>
          <p style="font-size:13.5px; line-height:1.65; color:#5A5F86; margin:0;"><?php echo crux_h( 'founder', 'event_legacy_section_paragraph_5' ); ?></p>
        </div>

        <div class="bento-tile" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:18px; padding:28px 26px; grid-column:span 2;" data-m="span">
          <span class="bebas" style="font-size:32px; color:#6C58DB; display:block; margin-bottom:8px;">05</span>
          <h3 class="bebas" style="font-size:24px; color:#10142E; margin:0 0 10px;"><?php echo crux_h( 'founder', 'event_legacy_section_heading_6' ); ?></h3>
          <p style="font-size:13.5px; line-height:1.65; color:#5A5F86; margin:0;"><?php echo crux_h( 'founder', 'event_legacy_section_paragraph_6' ); ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- GLOBAL BUSINESS CONSULTANCY & ENTERPRISE GROWTH -->
  <section style="padding:64px 20px; background:#FFFFFF;">
    <div style="max-width:1100px; margin:0 auto;">
      <div class="reveal" style="margin-bottom:44px;">
        <span class="eyebrow" style="color:#6C58DB;"><?php echo crux_h( 'founder', 'global_business_consultancy__small_heading_1' ); ?></span>
        <h2 class="bebas" style="font-size:42px; margin:12px 0 14px; color:#10142E;"><?php echo crux_h( 'founder', 'global_business_consultancy__heading_1' ); ?></h2>
        <p style="font-size:16px; line-height:1.8; color:#3A3F66; max-width:820px; margin:0;"><?php echo crux_rich( 'founder', 'global_business_consultancy__paragraph_1' ); ?></p>
      </div>

      <!-- 5 Pillars Grid -->
      <div style="display:grid; grid-template-columns:repeat(5, minmax(0, 1fr)); gap:18px; margin-bottom:48px;" class="reveal" data-m="g1">
        <div style="background:#F4F5FA; border:1.5px solid #E1DEF3; border-radius:16px; padding:24px 20px; display:flex; flex-direction:column; justify-content:space-between;">
          <div>
            <span class="bebas" style="font-size:26px; color:#6C58DB;"><?php echo crux_h( 'founder', 'global_business_consultancy__text_1' ); ?></span>
            <h3 style="font-size:15px; font-weight:800; color:#10142E; margin:8px 0 8px;"><?php echo crux_h( 'founder', 'global_business_consultancy__heading_2' ); ?></h3>
            <p style="font-size:13px; line-height:1.6; color:#5A5F86; margin:0;"><?php echo crux_h( 'founder', 'global_business_consultancy__paragraph_2' ); ?></p>
          </div>
        </div>

        <div style="background:#F4F5FA; border:1.5px solid #E1DEF3; border-radius:16px; padding:24px 20px; display:flex; flex-direction:column; justify-content:space-between;">
          <div>
            <span class="bebas" style="font-size:26px; color:#BA0000;"><?php echo crux_h( 'founder', 'global_business_consultancy__text_2' ); ?></span>
            <h3 style="font-size:15px; font-weight:800; color:#10142E; margin:8px 0 8px;"><?php echo crux_h( 'founder', 'global_business_consultancy__heading_3' ); ?></h3>
            <p style="font-size:13px; line-height:1.6; color:#5A5F86; margin:0;"><?php echo crux_h( 'founder', 'global_business_consultancy__paragraph_3' ); ?></p>
          </div>
        </div>

        <div style="background:#F4F5FA; border:1.5px solid #E1DEF3; border-radius:16px; padding:24px 20px; display:flex; flex-direction:column; justify-content:space-between;">
          <div>
            <span class="bebas" style="font-size:26px; color:#002671;"><?php echo crux_h( 'founder', 'global_business_consultancy__text_3' ); ?></span>
            <h3 style="font-size:15px; font-weight:800; color:#10142E; margin:8px 0 8px;"><?php echo crux_h( 'founder', 'global_business_consultancy__heading_4' ); ?></h3>
            <p style="font-size:13px; line-height:1.6; color:#5A5F86; margin:0;"><?php echo crux_h( 'founder', 'global_business_consultancy__paragraph_4' ); ?></p>
          </div>
        </div>

        <div style="background:#F4F5FA; border:1.5px solid #E1DEF3; border-radius:16px; padding:24px 20px; display:flex; flex-direction:column; justify-content:space-between;">
          <div>
            <span class="bebas" style="font-size:26px; color:#6C58DB;"><?php echo crux_h( 'founder', 'global_business_consultancy__text_4' ); ?></span>
            <h3 style="font-size:15px; font-weight:800; color:#10142E; margin:8px 0 8px;"><?php echo crux_h( 'founder', 'global_business_consultancy__heading_5' ); ?></h3>
            <p style="font-size:13px; line-height:1.6; color:#5A5F86; margin:0;"><?php echo crux_h( 'founder', 'global_business_consultancy__paragraph_5' ); ?></p>
          </div>
        </div>

        <div style="background:#F4F5FA; border:1.5px solid #E1DEF3; border-radius:16px; padding:24px 20px; display:flex; flex-direction:column; justify-content:space-between;">
          <div>
            <span class="bebas" style="font-size:26px; color:#BA0000;"><?php echo crux_h( 'founder', 'global_business_consultancy__text_5' ); ?></span>
            <h3 style="font-size:15px; font-weight:800; color:#10142E; margin:8px 0 8px;"><?php echo crux_h( 'founder', 'global_business_consultancy__heading_6' ); ?></h3>
            <p style="font-size:13px; line-height:1.6; color:#5A5F86; margin:0;"><?php echo crux_h( 'founder', 'global_business_consultancy__paragraph_6' ); ?></p>
          </div>
        </div>
      </div>

      <!-- Infrastructure Transformation Real Evidence -->
      <div style="background:#111838; border-radius:22px; padding:36px 32px; border:1.5px solid #1E2B5E;" class="reveal">
        <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:24px; flex-wrap:wrap; gap:16px;">
          <div>
            <span class="eyebrow" style="color:#B7A6FF !important;"><?php echo crux_h( 'founder', 'global_business_consultancy__small_heading_2' ); ?></span>
            <h3 class="bebas" style="font-size:32px; color:#FFFFFF; margin:8px 0 0;"><?php echo crux_h( 'founder', 'global_business_consultancy__heading_7' ); ?></h3>
          </div>
          <p style="font-size:14px; color:#A3A9C8; max-width:440px; margin:0;"><?php echo crux_h( 'founder', 'global_business_consultancy__paragraph_7' ); ?></p>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;" data-m="g1">
          <div style="background:#0D1330; border-radius:14px; overflow:hidden; border:1px solid #1E2B5E;">
            <div style="height:320px; overflow:hidden;"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/consultancy-retail-unit.jpg' ); ?>" alt="Before: We find the retail shop/unit/office" style="width:100%; height:100%; object-fit:cover; object-position:center; display:block;"></div>
            <div style="padding:14px 18px; display:flex; justify-content:space-between; align-items:center;">
              <span style="font-size:11px; font-weight:800; color:#8C7AE6; letter-spacing:1px; text-transform:uppercase; background:rgba(140,122,230,0.15); padding:4px 10px; border-radius:4px;"><?php echo crux_h( 'founder', 'global_business_consultancy__text_6' ); ?></span>
              <span style="font-size:13.5px; color:#FFFFFF; font-weight:700;"><?php echo crux_h( 'founder', 'global_business_consultancy__text_7' ); ?></span>
            </div>
          </div>

          <div style="background:#0D1330; border-radius:14px; overflow:hidden; border:1px solid #1E2B5E;">
            <div style="height:320px; overflow:hidden;"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/consultancy-retail-stocked.jpg' ); ?>" alt="After: We build it/stock it/set up" style="width:100%; height:100%; object-fit:cover; object-position:center; display:block;"></div>
            <div style="padding:14px 18px; display:flex; justify-content:space-between; align-items:center;">
              <span style="font-size:11px; font-weight:800; color:#BA0000; letter-spacing:1px; text-transform:uppercase; background:rgba(186,0,0,0.15); padding:4px 10px; border-radius:4px;"><?php echo crux_h( 'founder', 'global_business_consultancy__text_8' ); ?></span>
              <span style="font-size:13.5px; color:#FFFFFF; font-weight:700;"><?php echo crux_h( 'founder', 'global_business_consultancy__text_9' ); ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'light', 'prefooter' => 'founder', 'wing' => 'events' ) ); ?>
  </div>

<div class="msw">
  <div class="crux-sw-pod crux-sw-pod--light" style="pointer-events:auto; display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #C4BAEE 0%, #A99CE0 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(16,20,46,0.22); filter:drop-shadow(0 4px 12px rgba(16,20,46,0.12));">
    <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#EBE7F7; padding:4px; gap:4px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.4);">
        <span><?php echo crux_h( 'founder', 'global_business_consultancy__text_10' ); ?></span>
      </a>
      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-light" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#4A5073; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">
        <span><?php echo crux_h( 'founder', 'global_business_consultancy__text_11' ); ?></span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:6px; display:inline-block; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>
</div></div></div>





<?php wp_footer(); ?>
</body>
</html>
