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
      padding: 0 64px !important;
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
    .mdrawer a.mlink {
      display: block;
      font-family: 'Bebas Neue', 'Arial Narrow', sans-serif;
      font-size: 32px;
      letter-spacing: .5px;
      text-transform: uppercase;
      padding: 12px 0;
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
      padding-top: 24px !important;
      padding-bottom: 36px !important;
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

</style>


<div style="width:100%; max-width:100%; margin:0; background:#0A0F26; overflow-x:clip;" data-m="root">

  <!-- SHOUT-OUT BAR -->
  <div style="background:#002671; padding:10px 20px 10px 20px; display:flex; align-items:center; justify-content:center; gap:10px;">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M3 11l18-7-7 18-2-8-9-3z" stroke="#FFFFFF" stroke-width="1.8" stroke-linejoin="round"></path></svg>
    <span style="font-size:12.5px; font-weight:700; color:#FFFFFF; letter-spacing:0.3px;">Now booking <?php echo date( "Y" ); ?>/<?php echo (int) date( "Y" ) + 1; ?> across the UK — <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="color:#FFFFFF; font-weight:800; border-bottom:1px solid #FFFFFF;">get in touch →</a></span>
  </div>

  <!-- HEADER -->
  <header style="position:sticky; top:0; z-index:1000; display:flex; align-items:center; justify-content:space-between; padding:0 20px; border-bottom:1px solid rgba(30,43,94,0.85); background:rgba(10,15,38,0.94); backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px);">
    <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="display:flex; align-items:center;"><img src="<?php echo crux_get_blob_url( "e4d72651b77d4c3cc1c086d9f6031149" ); ?>" alt="Crux Nxtion Events" style="height:42px; width:auto; display:block; background:#FFFFFF; padding:4px 12px 4px 12px; border-radius:8px;"></a>
    <nav style="display:flex; align-items:center; gap:28px;">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="color:#F4F5FA; font-size:14px; font-weight:600; letter-spacing:0.2px;">Home</a>
      <div class="crux-nav-dropdown">
        <a href="<?php echo esc_url( home_url( "/services/" ) ); ?>" class="crux-nav-trigger" style="color:#F4F5FA;">
          <span>Services</span>
          <svg class="crux-chevron" width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
        <div class="crux-services-card" style="background:#0B112C; border:1px solid #1E2B5E; box-shadow:0 24px 50px rgba(0,0,0,0.65), 0 0 0 1px rgba(255,255,255,0.06);">
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; padding:20px 18px 16px;">
            <!-- COLUMN 1: EVENTS WING -->
            <div style="background:rgba(255,255,255,0.02); border:1px solid #1E2B5E; border-top:3px solid #002671; border-radius:10px; padding:14px; display:flex; flex-direction:column; justify-content:space-between;">
              <div>
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                  <span style="background:#002671; color:#FFFFFF; font-size:9.5px; font-weight:800; letter-spacing:1px; padding:3px 8px; clip-path:polygon(3px 0,100% 0,calc(100% - 3px) 100%,0 100%);">EVENTS WING</span>
                  <span style="font-size:10px; font-weight:700; color:#5B8DEF; text-transform:uppercase;">Live Production</span>
                </div>
                <div style="display:flex; flex-direction:column; gap:4px;">
                  <a class="c-dlink" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#F4F5FA;">
                    <span style="width:6px; height:6px; border-radius:50%; background:#5B8DEF; flex:0 0 6px;"></span>
                    <span style="flex:1;"><strong style="display:block; font-size:12.5px; color:#F4F5FA; font-weight:700;">Event Planning &amp; Management</strong><span style="display:block; font-size:11px; color:#A3A9C8;">Weddings, Galas &amp; Festivals</span></span>
                  </a>
                  <a class="c-dlink" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#F4F5FA;">
                    <span style="width:6px; height:6px; border-radius:50%; background:#5B8DEF; flex:0 0 6px;"></span>
                    <span style="flex:1;"><strong style="display:block; font-size:12.5px; color:#F4F5FA; font-weight:700;">Entertainment &amp; Talent</strong><span style="display:block; font-size:11px; color:#A3A9C8;">Artists, DJs &amp; Cultural Acts</span></span>
                  </a>
                  <a class="c-dlink" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#F4F5FA;">
                    <span style="width:6px; height:6px; border-radius:50%; background:#5B8DEF; flex:0 0 6px;"></span>
                    <span style="flex:1;"><strong style="display:block; font-size:12.5px; color:#F4F5FA; font-weight:700;">Audio-Visual &amp; Staging</strong><span style="display:block; font-size:11px; color:#A3A9C8;">Lighting, Sound &amp; LED Setup</span></span>
                  </a>
                  <a class="c-dlink" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#F4F5FA;">
                    <span style="width:6px; height:6px; border-radius:50%; background:#5B8DEF; flex:0 0 6px;"></span>
                    <span style="flex:1;"><strong style="display:block; font-size:12.5px; color:#F4F5FA; font-weight:700;">On-Site Coordination</strong><span style="display:block; font-size:11px; color:#A3A9C8;">Floor &amp; Vendor Management</span></span>
                  </a>
                </div>
              </div>
              <div style="margin-top:12px; padding-top:10px; border-top:1px solid #1E2B5E;">
                <a href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#5B8DEF; font-size:11.5px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">All Event Services &rarr;</a>
              </div>
            </div>

            <!-- COLUMN 2: CONSULTANCY WING -->
            <div style="background:rgba(255,255,255,0.02); border:1px solid #1E2B5E; border-top:3px solid #8C7AE6; border-radius:10px; padding:14px; display:flex; flex-direction:column; justify-content:space-between;">
              <div>
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                  <span style="background:#8C7AE6; color:#10142E; font-size:9.5px; font-weight:800; letter-spacing:1px; padding:3px 8px; clip-path:polygon(3px 0,100% 0,calc(100% - 3px) 100%,0 100%);">CONSULTANCY WING</span>
                  <span style="font-size:10px; font-weight:700; color:#8C7AE6; text-transform:uppercase;">Strategy &amp; Scale</span>
                </div>
                <div style="display:flex; flex-direction:column; gap:4px;">
                  <a class="c-dlink" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#F4F5FA;">
                    <span style="width:6px; height:6px; border-radius:50%; background:#8C7AE6; flex:0 0 6px;"></span>
                    <span style="flex:1;"><strong style="display:block; font-size:12.5px; color:#F4F5FA; font-weight:700;">Business Setup &amp; UK Reg</strong><span style="display:block; font-size:11px; color:#A3A9C8;">Structure, HMRC &amp; Roadmap</span></span>
                  </a>
                  <a class="c-dlink" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#F4F5FA;">
                    <span style="width:6px; height:6px; border-radius:50%; background:#8C7AE6; flex:0 0 6px;"></span>
                    <span style="flex:1;"><strong style="display:block; font-size:12.5px; color:#F4F5FA; font-weight:700;">Commercial Fitout &amp; Setup</strong><span style="display:block; font-size:11px; color:#A3A9C8;">Unit Sourcing &amp; Shopfitting</span></span>
                  </a>
                  <a class="c-dlink" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#F4F5FA;">
                    <span style="width:6px; height:6px; border-radius:50%; background:#8C7AE6; flex:0 0 6px;"></span>
                    <span style="flex:1;"><strong style="display:block; font-size:12.5px; color:#F4F5FA; font-weight:700;">Brand Growth &amp; Scaling</strong><span style="display:block; font-size:11px; color:#A3A9C8;">Marketing &amp; Revenue Engines</span></span>
                  </a>
                  <a class="c-dlink" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#F4F5FA;">
                    <span style="width:6px; height:6px; border-radius:50%; background:#8C7AE6; flex:0 0 6px;"></span>
                    <span style="flex:1;"><strong style="display:block; font-size:12.5px; color:#F4F5FA; font-weight:700;">Specialized Visas &amp; Advisory</strong><span style="display:block; font-size:11px; color:#A3A9C8;">Global Talent &amp; Founder Visas</span></span>
                  </a>
                </div>
              </div>
              <div style="margin-top:12px; padding-top:10px; border-top:1px solid #1E2B5E;">
                <a href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#8C7AE6; font-size:11.5px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">All Strategy Services &rarr;</a>
              </div>
            </div>
          </div>
          <!-- DROPDOWN QUICK ACTION STRIP -->
          <div style="background:rgba(10,15,38,0.9); border-top:1px solid #1E2B5E; padding:12px 20px; display:flex; align-items:center; justify-content:space-between; border-radius:0 0 12px 12px;">
            <span style="font-size:11px; color:#A3A9C8; font-weight:600; letter-spacing:0.3px;">Crux Nxtion Dual-Wing Collective</span>
            <div style="display:flex; gap:8px;">
              <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="font-size:11px; font-weight:700; padding:6px 14px; background:#BA0000; color:#FFFFFF; text-decoration:none; --sl:4px;" class="bx">Plan Event</a>
              <a href="https://calendly.com/cruxnxtiongroupofcompany-info" target="_blank" rel="noopener" style="font-size:11px; font-weight:700; padding:6px 14px; background:#8C7AE6; color:#10142E; text-decoration:none; --sl:4px;" class="bx">Discovery Call</a>
            </div>
          </div>
        </div>
      </div>
      <a href="<?php echo esc_url( home_url( "/events/" ) ); ?>" style="color:#F4F5FA; font-size:14px; font-weight:600; letter-spacing:0.2px;">Events</a>
      <a href="<?php echo esc_url( home_url( "/gallery/" ) ); ?>" style="color:#F4F5FA; font-size:14px; font-weight:600; letter-spacing:0.2px;">Gallery</a>
      <a href="<?php echo esc_url( home_url( "/about/" ) ); ?>" style="color:#F4F5FA; font-size:14px; font-weight:600; letter-spacing:0.2px;">About</a>
      <a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" style="color:#F4F5FA; font-size:14px; font-weight:600; letter-spacing:0.2px;">Blog</a>
      <a href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="color:#F4F5FA; font-size:14px; font-weight:600; letter-spacing:0.2px;">Contact</a>
    </nav>
        <div class="header-desktop-actions" style="display:flex; align-items:center; gap:16px;">
      <div style="display:flex; gap:6px;">
        <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="font-size:12px; font-weight:700; padding:8px 16px; background:#1E48B0; color:#FFFFFF; --sl:7px;" class="bx">Events</a>
        <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="font-size:12px; font-weight:700; padding:8px 16px; color:#A3A9C8; --sl:8px; --bc:#A3A9C855;" class="bx">Consultancy</a>
      </div>
      <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:13px; padding:12px 22px; --sl:8px;" class="bx">Plan An Event</a>
    </div>
  <button type="button" class="crux-mnav-btn" id="crux-mnav-toggle" aria-label="Open navigation menu" aria-expanded="false" style="display:none; background:transparent; border:none; padding:10px; cursor:pointer; flex-direction:column; gap:5px; color:#F4F5FA;">
      <i style="display:block; width:24px; height:2px; background:currentColor;"></i>
      <i style="display:block; width:24px; height:2px; background:currentColor;"></i>
      <i style="display:block; width:16px; height:2px; align-self:flex-end; background:currentColor;"></i>
    </button>
  </header>
  
  <!-- MOBILE DRAWER OVERLAY -->
  <div class="mdrawer" id="crux-mobile-drawer" style="background:#0A0F26;" role="dialog" aria-modal="true" aria-label="Crux Nxtion Navigation">
    <div class="mdrawer-topbar" style="border-bottom:1px solid #1E2B5E;">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="display:flex; align-items:center;">
        <img src="<?php echo crux_get_blob_url( "e4d72651b77d4c3cc1c086d9f6031149" ); ?>" alt="Crux Nxtion" style="height:36px; width:auto; background:#FFFFFF; padding:4px 12px; border-radius:6px; display:block;">
      </a>
      <button type="button" class="mdrawer-close-btn" id="crux-mdrawer-close" aria-label="Close menu" style="background:rgba(255,255,255,0.08); border:none; color:#F4F5FA; cursor:pointer; display:flex; align-items:center; justify-content:center;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>
    
    <div class="mdrawer-body">
                  <!-- Quick Wing Switcher -->
      <div style="display:flex; gap:6px; margin:4px 0 18px;">
        <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="font-size:12px; font-weight:700; padding:8px 18px; background:#1E48B0; color:#FFFFFF; --sl:6px;" class="bx">Events</a>
        <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="font-size:12px; font-weight:700; padding:8px 18px; color:#A3A9C8; --sl:6px; --bc:#A3A9C855;" class="bx">Consultancy</a>
      </div>

      <!-- Navigation Links -->
      <div class="mdrawer-nav-links">
        <a class="mlink" href="<?php echo esc_url( home_url( "/" ) ); ?>" style="color:#F4F5FA; border-bottom:1px solid #1E2B5E;">Home</a>
        
        <!-- Accordion Services -->
        <details class="mdrawer-acc" style="border-bottom:1px solid #1E2B5E;">
          <summary style="display:flex; align-items:center; justify-content:space-between; cursor:pointer; padding:14px 0;">
            <span class="mlink" style="color:#F4F5FA;">Services</span>
            <span class="acc-icon" style="color:#FF2E3D; font-size:22px; font-weight:700; transition:transform .2s ease;">▾</span>
          </summary>
          <div style="padding:4px 0 16px;">
            <!-- Events sub-box -->
            <div style="background:rgba(0,38,113,0.22); border:1px solid rgba(91,141,239,0.3); border-radius:8px; padding:12px 14px; margin-bottom:12px;">
              <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                <span style="font-size:10px; font-weight:800; letter-spacing:1px; color:#5B8DEF; text-transform:uppercase;">EVENTS WING</span>
                <a href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="font-size:11px; font-weight:700; color:#5B8DEF; text-decoration:none;">All &rarr;</a>
              </div>
              <a class="msub" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#F4F5FA;">Event Management &amp; Planning</a>
              <a class="msub" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#F4F5FA;">Entertainment Booking &amp; Talent</a>
              <a class="msub" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#F4F5FA;">Design &amp; Audio-Visual Production</a>
              <a class="msub" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#F4F5FA;">On-Site Floor Coordination</a>
            </div>

            <!-- Consultancy sub-box -->
            <div style="background:rgba(140,122,230,0.12); border:1px solid rgba(140,122,230,0.3); border-radius:8px; padding:12px 14px;">
              <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                <span style="font-size:10px; font-weight:800; letter-spacing:1px; color:#B7A6FF; text-transform:uppercase;">CONSULTANCY WING</span>
                <a href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="font-size:11px; font-weight:700; color:#B7A6FF; text-decoration:none;">All &rarr;</a>
              </div>
              <a class="msub" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#F4F5FA;">Business Setup &amp; Strategy</a>
              <a class="msub" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#F4F5FA;">Commercial Fitout &amp; Setup</a>
              <a class="msub" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#F4F5FA;">Brand Growth &amp; Scaling</a>
              <a class="msub" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#F4F5FA;">Specialized Visas &amp; Advisory</a>
            </div>
          </div>
        </details>

        <a class="mlink" href="<?php echo esc_url( home_url( "/events/" ) ); ?>" style="color:#F4F5FA; border-bottom:1px solid #1E2B5E;">Events</a>
        <a class="mlink" href="<?php echo esc_url( home_url( "/gallery/" ) ); ?>" style="color:#F4F5FA; border-bottom:1px solid #1E2B5E;">Gallery</a>
        <a class="mlink" href="<?php echo esc_url( home_url( "/about/" ) ); ?>" style="color:#F4F5FA; border-bottom:1px solid #1E2B5E;">About</a>
        <a class="mlink" href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" style="color:#F4F5FA; border-bottom:1px solid #1E2B5E;">Blog</a>
        <a class="mlink" href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="color:#F4F5FA; border-bottom:1px solid #1E2B5E;">Contact</a>
      </div>

      <!-- Dual Action CTAs -->
      <div style="display:flex; flex-direction:column; gap:10px; margin-top:24px;">
        <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="display:block; text-align:center; background:#BA0000; color:#FFFFFF; font-weight:700; font-size:14px; padding:15px 20px; --sl:8px; text-decoration:none;" class="bx">Plan An Event &rarr;</a>
        <a href="https://calendly.com/cruxnxtiongroupofcompany-info" target="_blank" rel="noopener" style="display:block; text-align:center; background:#8C7AE6; color:#10142E; font-weight:700; font-size:14px; padding:15px 20px; --sl:8px; text-decoration:none;" class="bx">Book Discovery Call (Calendly) &rarr;</a>
      </div>

      <!-- Contact & Direct Telephony -->
      <div style="margin-top:24px; padding-top:18px; border-top:1px solid #1E2B5E; display:flex; flex-direction:column; gap:8px;">
        <div style="display:flex; align-items:center; gap:8px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#5B8DEF" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"></path></svg>
          <a href="tel:+447448614051" style="font-size:13px; color:#C5CADF; text-decoration:none; font-weight:600;">+44 7448 614051</a>
        </div>
        <div style="display:flex; align-items:center; gap:8px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8C7AE6" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
          <?php $c_mail = 'infoandsales@cruxnxtion.co.uk'; ?>
          <a href="<?php echo esc_url( 'mailto:' . antispambot( $c_mail ) ); ?>" style="font-size:13px; color:#C5CADF; text-decoration:none; font-weight:600;"><?php echo esc_html( antispambot( $c_mail ) ); ?></a>
        </div>
      </div>
    </div>
  </div>

  <!-- 404 -->
  <section style="min-height:760px; padding:44px 20px 44px 20px; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; position:relative; overflow:hidden;" data-m="nomin">
    <span aria-hidden="true" class="bebas" style="font-size:60px; line-height:.8; background:linear-gradient(180deg,#F4F5FA 0%,#5B8DEF 40%,#1E2B5E 85%,transparent 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">404</span>
    <span class="eyebrow" style="margin-top:18px;">Off The Guest List</span>
    <h1 class="bebas" style="font-size:44px; margin:14px 0px 18px 0px; color:#F4F5FA;">THIS PAGE DIDN'T MAKE THE LINE-UP.</h1>
    <p style="font-size:16px; line-height:1.6; color:#A3A9C8; max-width:520px; margin:0px 0px 30px 0px;" class="reveal">The link may be old, or the page has moved. Head back to the main room, or pick one of the doors below.</p>
    <div style="display:flex; gap:16px; justify-content:center;" class="reveal"><a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:15px; padding:16px 30px 16px 30px; --sl:10px;" class="bx">Back To Home</a><a href="<?php echo esc_url( home_url( "/events/" ) ); ?>" style="color:#F4F5FA; font-weight:700; font-size:15px; padding:14px 28px 14px 28px; --sl:10px; --bc:#5B8DEF;" class="bx">See Upcoming Events</a></div>
  </section>
  <section style=" padding:10px 20px 44px 20px;">
    <div style="display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:26px;" class="reveal" data-m="g1">
      <a href="<?php echo esc_url( home_url( "/events/" ) ); ?>" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-1deg);" class="reveal">
        <div style=" padding:26px 22px 22px 22px;"><h3 class="bebas" style="font-size:32px; margin:0px 0px 8px 0px; color:#F4F5FA;">Upcoming Events</h3><p style="font-size:13.5px; line-height:1.5; color:#A3A9C8; margin:0px 0px 0px 0px;">See what is on the ticket wall.</p></div>
        <div class="strip-stub" style="background:#002671; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF; letter-spacing:1px; text-transform:uppercase;">Take me there</span><span class="bebas" style="font-size:14px; color:#FFFFFF;">→</span></div>
      </a>
      <a href="<?php echo esc_url( home_url( "/gallery/" ) ); ?>" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(0.8deg);" class="reveal">
        <div style=" padding:26px 22px 22px 22px;"><h3 class="bebas" style="font-size:32px; margin:0px 0px 8px 0px; color:#F4F5FA;">Gallery</h3><p style="font-size:13.5px; line-height:1.5; color:#A3A9C8; margin:0px 0px 0px 0px;">Frames from nights we have run.</p></div>
        <div class="strip-stub" style="background:#BA0000; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF; letter-spacing:1px; text-transform:uppercase;">Take me there</span><span class="bebas" style="font-size:14px; color:#FFFFFF;">→</span></div>
      </a>
      <a href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-0.6deg);" class="reveal">
        <div style=" padding:26px 22px 22px 22px;"><h3 class="bebas" style="font-size:32px; margin:0px 0px 8px 0px; color:#F4F5FA;">Our Services</h3><p style="font-size:13.5px; line-height:1.5; color:#A3A9C8; margin:0px 0px 0px 0px;">Events and consultancy, side by side.</p></div>
        <div class="strip-stub" style="background:#8C7AE6; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#10142E; letter-spacing:1px; text-transform:uppercase;">Take me there</span><span class="bebas" style="font-size:14px; color:#10142E;">→</span></div>
      </a>
      <a href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(1deg);" class="reveal">
        <div style=" padding:26px 22px 22px 22px;"><h3 class="bebas" style="font-size:32px; margin:0px 0px 8px 0px; color:#F4F5FA;">Get In Touch</h3><p style="font-size:13.5px; line-height:1.5; color:#A3A9C8; margin:0px 0px 0px 0px;">Tell us the date, we will do the rest.</p></div>
        <div class="strip-stub" style="background:#002671; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF; letter-spacing:1px; text-transform:uppercase;">Take me there</span><span class="bebas" style="font-size:14px; color:#FFFFFF;">→</span></div>
      </a>
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
  <div style="background:rgba(10,15,38,0.95); border:1.5px solid #1E2B5E; box-shadow:0 12px 30px rgba(0,0,0,0.55); backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px); display:flex; padding:5px 6px; gap:6px;">
    <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="padding:11px 22px; font-size:13px; font-weight:700; background:#1E48B0; color:#FFFFFF; --sl:7px;" class="bx">Events</a>
    <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="padding:11px 22px; font-size:13px; font-weight:700; color:#A3A9C8; --sl:7px; --bc:#A3A9C855;" class="bx">Consultancy</a>
  </div>
</div></div></div>





<?php wp_footer(); ?>
</body>
</html>
