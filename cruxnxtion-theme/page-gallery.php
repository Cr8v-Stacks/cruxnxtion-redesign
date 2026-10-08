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

  <?php get_template_part( 'parts/site-header', null, array( 'skin' => 'dark', 'nav' => 'events', 'wing' => 'events', 'active' => 'gallery' ) ); ?>

  <!-- PAGE HEADING -->
  <section style=" padding:44px 20px 20px 20px;">
    <span class="eyebrow"><?php echo crux_h( 'gallery', 'page_heading_small_heading_1' ); ?></span>
    <h1 class="bebas" style="font-size:44px; margin:14px 0px 14px 0px; color:#F4F5FA;"><?php echo crux_h( 'gallery', 'page_heading_heading_1' ); ?></h1>
    <p style="font-size:15px; color:#A3A9C8; max-width:520px; margin:0px 0px 0px 0px;" class="reveal"><?php echo crux_h( 'gallery', 'page_heading_paragraph_1' ); ?></p>
  </section>

  <!-- TICKET PHOTO GRID -->
  <section style=" padding:30px 20px 44px 20px;">
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:34px 26px; align-items:start;" class="reveal" data-m="g2">
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-1deg);" class="reveal">
        <div style="position:relative; height:240px;"><img src="<?php echo crux_get_blob_url( "feb81852032e2798160126ebf0d3c7f6" ); ?>" alt="Crux Nxtion Events frame 1" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:#002671; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_1' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_2' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(0.8deg);" class="reveal">
        <div style="position:relative; height:280px;"><img src="<?php echo crux_get_blob_url( "4170d6b6009c07e37d83bae48a68917b" ); ?>" alt="Crux Nxtion Events frame 2" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:#BA0000; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_3' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_4' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-0.8deg);" class="reveal">
        <div style="position:relative; height:220px;"><img src="<?php echo crux_get_blob_url( "c5afda4fc4e4d4b0682377d6eb272c90" ); ?>" alt="Crux Nxtion Events frame 3" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:#8C7AE6; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#0A0F26;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_5' ); ?></span><span class="bebas" style="font-size:14px; color:#0A0F26;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_6' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(0.6deg);" class="reveal">
        <div style="position:relative; height:240px;"><img src="<?php echo crux_get_blob_url( "b670d3a0bfa370687d246a6ab941625c" ); ?>" alt="Crux Nxtion Events frame 4" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:#002671; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_7' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_8' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-0.6deg);" class="reveal">
        <div style="position:relative; height:280px;"><img src="<?php echo crux_get_blob_url( "2fe0208788cf2d50763c85dd2a44de66" ); ?>" alt="Crux Nxtion Events frame 5" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:#BA0000; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_9' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_10' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(1deg);" class="reveal">
        <div style="position:relative; height:220px;"><img src="<?php echo crux_get_blob_url( "1d5292715423e2e83b56b3330a94b3b8" ); ?>" alt="Crux Nxtion Events frame 6" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:#8C7AE6; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#0A0F26;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_11' ); ?></span><span class="bebas" style="font-size:14px; color:#0A0F26;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_12' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-1deg);" class="reveal">
        <div style="position:relative; height:240px;"><img src="<?php echo crux_get_blob_url( "99a3c292f4b3a38d253144801b4a9ae3" ); ?>" alt="Crux Nxtion Events frame 7" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:#002671; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_1' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_13' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(0.8deg);" class="reveal">
        <div style="position:relative; height:280px;"><img src="<?php echo crux_get_blob_url( "8f947f32de7fe00cf711036348e00351" ); ?>" alt="Crux Nxtion Events frame 8" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:#BA0000; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_3' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_14' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-0.8deg);" class="reveal">
        <div style="position:relative; height:220px;"><img src="<?php echo crux_get_blob_url( "c5afda4fc4e4d4b0682377d6eb272c90" ); ?>" alt="Crux Nxtion Events frame 9" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:#8C7AE6; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#0A0F26;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_5' ); ?></span><span class="bebas" style="font-size:14px; color:#0A0F26;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_15' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(0.6deg);">
        <div style="position:relative; height:240px;"><img src="<?php echo crux_get_blob_url( "2b696c907bf5b4d0dc14a80e8cd60e15" ); ?>" alt="Crux Nxtion Events frame 10" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:#002671; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_7' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_16' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-0.6deg);">
        <div style="position:relative; height:280px;"><img src="<?php echo crux_get_blob_url( "e6e06da1a649b213d8dd573ea6511302" ); ?>" alt="Crux Nxtion Events frame 11" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:#BA0000; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_9' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_17' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(1deg);">
        <div style="position:relative; height:220px;"><img src="<?php echo crux_get_blob_url( "b094675514894aa0d8e7dd735d187b22" ); ?>" alt="Crux Nxtion Events frame 12" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:#8C7AE6; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#0A0F26;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_11' ); ?></span><span class="bebas" style="font-size:14px; color:#0A0F26;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_18' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-1deg);">
        <div style="position:relative; height:240px;"><img src="<?php echo crux_get_blob_url( "00a901525823b7149b4ebb66e5a9678f" ); ?>" alt="Crux Nxtion Events frame 13" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:#002671; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_1' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_19' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(0.8deg);">
        <div style="position:relative; height:280px;"><img src="<?php echo crux_get_blob_url( "5e2df00e7ead10292f7266fc033953c3" ); ?>" alt="Crux Nxtion Events frame 14" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:#BA0000; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_3' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_20' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-0.8deg);">
        <div style="position:relative; height:220px;"><img src="<?php echo crux_get_blob_url( "2643e6061a232eeda4f8344fe6df6166" ); ?>" alt="Crux Nxtion Events frame 15" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div class="strip-stub" style="background:#8C7AE6; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#0A0F26;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_5' ); ?></span><span class="bebas" style="font-size:14px; color:#0A0F26;"><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_21' ); ?></span></div>
      </a>
    </div>
  </section>

  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'dark', 'prefooter' => 'events', 'wing' => 'events' ) ); ?>

<div class="msw">
  <div class="crux-sw-pod crux-sw-pod--dark" style="pointer-events:auto; display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #2A3F7A 0%, #15224A 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(0,0,0,0.65); filter:drop-shadow(0 4px 12px rgba(0,0,0,0.4));">
    <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#020512; padding:4px; gap:4px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.5);">
        <span><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_22' ); ?></span>
      </a>
      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-dark" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#8E96BB; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">
        <span><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_23' ); ?></span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:6px; display:inline-block; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>
</div></div></div>





<?php wp_footer(); ?>
</body>
</html>
