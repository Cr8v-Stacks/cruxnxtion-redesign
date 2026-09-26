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
  .cb { opacity:0; animation-duration:8s; animation-iteration-count:infinite; animation-timing-function:ease; animation-fill-mode:both; }
  .cb1 { animation-name:cb1; } .cb2 { animation-name:cb2; } .cb3 { animation-name:cb3; } .cb4 { animation-name:cb4; } .cbt { animation-name:cbt; }
  @keyframes cb1 { 0%,2% { opacity:0; transform:translateY(12px); } 6%,93% { opacity:1; transform:none; } 98%,100% { opacity:0; transform:none; } }
  @keyframes cb2 { 0%,17% { opacity:0; transform:translateY(12px); } 21%,93% { opacity:1; transform:none; } 98%,100% { opacity:0; transform:none; } }
  @keyframes cb3 { 0%,34% { opacity:0; transform:translateY(12px); } 38%,93% { opacity:1; transform:none; } 98%,100% { opacity:0; transform:none; } }
  @keyframes cb4 { 0%,51% { opacity:0; transform:translateY(12px); } 55%,93% { opacity:1; transform:none; } 98%,100% { opacity:0; transform:none; } }
  @keyframes cbt { 0%,10%,15%,28%,32%,44%,48%,60% { opacity:0; } 11%,14%,29%,31%,45%,47%,62%,90% { opacity:1; } 96%,100% { opacity:0; } }
  .cdot { animation:cdot .8s ease-in-out infinite; } .cdot2 { animation-delay:.16s; } .cdot3 { animation-delay:.32s; }
  @keyframes cdot { 0%,70%,100% { transform:translateY(0); opacity:.45; } 35% { transform:translateY(-4px); opacity:1; } }
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
      font-size: clamp(56px, 6.8vw, 77px) !important;
      line-height: 0.92 !important;
    }
    .consultancy-hero-sub {
      font-size: clamp(62px, 7.8vw, 85px) !important;
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

    /* Consultancy Mobile Hero: Clean non-overlapping images, no awful container, hide chat */
    [data-m~=herovis] {
      height: auto !important;
      min-height: 0 !important;
      display: block !important;
      position: static !important;
      border-radius: 0 !important;
      background: transparent !important;
      padding: 0 !important;
      margin-top: 10px !important;
      overflow: visible !important;
      box-shadow: none !important;
    }
    .consultancy-hero-visual > div:first-child {
      display: grid !important;
      grid-template-columns: 1fr 1fr !important;
      gap: 12px !important;
      width: 100% !important;
      height: auto !important;
      position: static !important;
    }
    .consultancy-hero-visual .tilt-straighten {
      position: static !important;
      transform: none !important;
      width: 100% !important;
      height: auto !important;
      box-shadow: 0 4px 14px rgba(16,20,46,0.08) !important;
    }
    .consultancy-hero-visual .tilt-straighten img {
      height: 140px !important;
    }
    .consultancy-hero-visual .float {
      display: none !important;
    }
    [data-m~=hv-chat] {
      display: none !important;
    }
  }

</style>


<div style="width:100%; max-width:100%; margin:0; background:#FFFFFF; overflow-x:clip;" data-m="root">

  <!-- SHOUT-OUT BAR -->
  <div style="background:#8C7AE6; padding:10px 20px 10px 20px; display:flex; align-items:center; justify-content:center;">
    <span style="font-size:12.5px; font-weight:700; color:#10142E; letter-spacing:0.3px;">Crux Nxtion Consultancy — now booking discovery calls — <a href="<?php echo esc_url( home_url( "/contact/?type=consultancy" ) ); ?>" style="color:#10142E; font-weight:800; border-bottom:1px solid #10142E;">tell us where you're stuck →</a></span>
  </div>
  <!-- HEADER -->
  <header style="position:sticky; top:0; z-index:1000; display:flex; align-items:center; justify-content:space-between; padding:0 20px; border-bottom:1px solid rgba(225,222,243,0.85); background:rgba(255,255,255,0.95); backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px);">
    <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="display:flex; align-items:center;"><img src="<?php echo crux_get_blob_url( "e4d72651b77d4c3cc1c086d9f6031149" ); ?>" alt="Crux Nxtion Events" style="height:42px; width:auto; display:block; background:#FFFFFF; padding:4px 12px 4px 12px; border-radius:8px;"></a>
    <nav style="display:flex; align-items:center; gap:28px;">
      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="color:#6C58DB; font-size:14px; font-weight:600; letter-spacing:0.2px; border-bottom:1.5px solid #6C58DB;">Home</a>
      <div class="crux-nav-dropdown">
        <a href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" class="crux-nav-trigger" style="color:#10142E;">
          <span>Services</span>
          <svg class="crux-chevron" width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
        <div class="crux-services-card" style="background:#FFFFFF; border:1px solid #E1DEF3; box-shadow:0 24px 50px rgba(16,20,46,0.16), 0 0 0 1px rgba(0,0,0,0.04);">
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; padding:20px 18px 16px;">
            <!-- COLUMN 1: EVENTS WING -->
            <div style="background:#F8F9FE; border:1px solid #DCE5FA; border-top:3px solid #002671; border-radius:10px; padding:14px; display:flex; flex-direction:column; justify-content:space-between;">
              <div>
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                  <span style="background:#002671; color:#FFFFFF; font-size:9.5px; font-weight:800; letter-spacing:1px; padding:3px 8px; clip-path:polygon(3px 0,100% 0,calc(100% - 3px) 100%,0 100%);">EVENTS WING</span>
                  <span style="font-size:10px; font-weight:700; color:#002671; text-transform:uppercase;">Live Production</span>
                </div>
                <div style="display:flex; flex-direction:column; gap:4px;">
                  <a class="c-dlink" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#10142E;">
                    <span style="width:6px; height:6px; border-radius:50%; background:#002671; flex:0 0 6px;"></span>
                    <span style="flex:1;"><strong style="display:block; font-size:12.5px; color:#10142E; font-weight:700;">Event Planning &amp; Management</strong><span style="display:block; font-size:11px; color:#5A5F86;">Weddings, Galas &amp; Festivals</span></span>
                  </a>
                  <a class="c-dlink" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#10142E;">
                    <span style="width:6px; height:6px; border-radius:50%; background:#002671; flex:0 0 6px;"></span>
                    <span style="flex:1;"><strong style="display:block; font-size:12.5px; color:#10142E; font-weight:700;">Entertainment &amp; Talent</strong><span style="display:block; font-size:11px; color:#5A5F86;">Artists, DJs &amp; Cultural Acts</span></span>
                  </a>
                  <a class="c-dlink" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#10142E;">
                    <span style="width:6px; height:6px; border-radius:50%; background:#002671; flex:0 0 6px;"></span>
                    <span style="flex:1;"><strong style="display:block; font-size:12.5px; color:#10142E; font-weight:700;">Audio-Visual &amp; Staging</strong><span style="display:block; font-size:11px; color:#5A5F86;">Lighting, Sound &amp; LED Setup</span></span>
                  </a>
                  <a class="c-dlink" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#10142E;">
                    <span style="width:6px; height:6px; border-radius:50%; background:#002671; flex:0 0 6px;"></span>
                    <span style="flex:1;"><strong style="display:block; font-size:12.5px; color:#10142E; font-weight:700;">On-Site Coordination</strong><span style="display:block; font-size:11px; color:#5A5F86;">Floor &amp; Vendor Management</span></span>
                  </a>
                </div>
              </div>
              <div style="margin-top:12px; padding-top:10px; border-top:1px solid #DCE5FA;">
                <a href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#002671; font-size:11.5px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">All Event Services &rarr;</a>
              </div>
            </div>

            <!-- COLUMN 2: CONSULTANCY WING -->
            <div style="background:#FBF9FE; border:1px solid #E6DFF9; border-top:3px solid #8C7AE6; border-radius:10px; padding:14px; display:flex; flex-direction:column; justify-content:space-between;">
              <div>
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                  <span style="background:#8C7AE6; color:#10142E; font-size:9.5px; font-weight:800; letter-spacing:1px; padding:3px 8px; clip-path:polygon(3px 0,100% 0,calc(100% - 3px) 100%,0 100%);">CONSULTANCY WING</span>
                  <span style="font-size:10px; font-weight:700; color:#6C58DB; text-transform:uppercase;">Strategy &amp; Scale</span>
                </div>
                <div style="display:flex; flex-direction:column; gap:4px;">
                  <a class="c-dlink" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#10142E;">
                    <span style="width:6px; height:6px; border-radius:50%; background:#8C7AE6; flex:0 0 6px;"></span>
                    <span style="flex:1;"><strong style="display:block; font-size:12.5px; color:#10142E; font-weight:700;">Business Setup &amp; UK Reg</strong><span style="display:block; font-size:11px; color:#5A5F86;">Structure, HMRC &amp; Roadmap</span></span>
                  </a>
                  <a class="c-dlink" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#10142E;">
                    <span style="width:6px; height:6px; border-radius:50%; background:#8C7AE6; flex:0 0 6px;"></span>
                    <span style="flex:1;"><strong style="display:block; font-size:12.5px; color:#10142E; font-weight:700;">Commercial Fitout &amp; Setup</strong><span style="display:block; font-size:11px; color:#5A5F86;">Unit Sourcing &amp; Shopfitting</span></span>
                  </a>
                  <a class="c-dlink" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#10142E;">
                    <span style="width:6px; height:6px; border-radius:50%; background:#8C7AE6; flex:0 0 6px;"></span>
                    <span style="flex:1;"><strong style="display:block; font-size:12.5px; color:#10142E; font-weight:700;">Brand Growth &amp; Scaling</strong><span style="display:block; font-size:11px; color:#5A5F86;">Marketing &amp; Revenue Engines</span></span>
                  </a>
                  <a class="c-dlink" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#10142E;">
                    <span style="width:6px; height:6px; border-radius:50%; background:#8C7AE6; flex:0 0 6px;"></span>
                    <span style="flex:1;"><strong style="display:block; font-size:12.5px; color:#10142E; font-weight:700;">Specialized Visas &amp; Advisory</strong><span style="display:block; font-size:11px; color:#5A5F86;">Global Talent &amp; Founder Visas</span></span>
                  </a>
                </div>
              </div>
              <div style="margin-top:12px; padding-top:10px; border-top:1px solid #E6DFF9;">
                <a href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#6C58DB; font-size:11.5px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">All Strategy Services &rarr;</a>
              </div>
            </div>
          </div>
          <!-- DROPDOWN QUICK ACTION STRIP -->
          <div style="background:#F3F0FA; border-top:1px solid #E1DEF3; padding:12px 20px; display:flex; align-items:center; justify-content:space-between; border-radius:0 0 12px 12px;">
            <span style="font-size:11px; color:#5A5F86; font-weight:600; letter-spacing:0.3px;">Crux Nxtion Dual-Wing Collective</span>
            <div style="display:flex; gap:8px;">
              <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="font-size:11px; font-weight:700; padding:6px 14px; background:#BA0000; color:#FFFFFF; text-decoration:none; --sl:4px;" class="bx">Plan Event</a>
              <a href="https://calendly.com/cruxnxtiongroupofcompany-info" target="_blank" rel="noopener" style="font-size:11px; font-weight:700; padding:6px 14px; background:#8C7AE6; color:#10142E; text-decoration:none; --sl:4px;" class="bx">Discovery Call</a>
            </div>
          </div>
        </div>
      </div>
      <a href="<?php echo esc_url( home_url( "/founder/" ) ); ?>" style="color:#10142E; font-size:14px; font-weight:600; letter-spacing:0.2px;">Founder</a>
      <a href="<?php echo esc_url( home_url( "/about/" ) ); ?>" style="color:#10142E; font-size:14px; font-weight:600; letter-spacing:0.2px;">About</a>
      <a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" style="color:#10142E; font-size:14px; font-weight:600; letter-spacing:0.2px;">Blog</a>
      <a href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="color:#10142E; font-size:14px; font-weight:600; letter-spacing:0.2px;">Contact</a>
    </nav>
        <div class="header-desktop-actions" style="display:flex; align-items:center; gap:16px;">
      <div style="display:flex; gap:6px;">
        <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="font-size:12px; font-weight:700; padding:8px 16px; color:#5A5F86; --sl:8px; --bc:#5A5F8655;" class="bx">Events</a>
        <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="font-size:12px; font-weight:700; padding:8px 16px; background:#8C7AE6; color:#0A0F26; --sl:7px;" class="bx">Consultancy</a>
      </div>
      <a href="https://calendly.com/cruxnxtiongroupofcompany-info" target="_blank" rel="noopener" style="background:#8C7AE6; color:#10142E !important; font-weight:700; font-size:13px; padding:12px 22px; --sl:8px;" class="bx">Book Discovery Call</a>
    </div>
    <button type="button" class="crux-mnav-btn" id="crux-mnav-toggle" aria-label="Open navigation menu" aria-expanded="false" style="display:none; background:transparent; border:none; padding:10px; cursor:pointer; flex-direction:column; gap:5px; color:#10142E;">
      <i style="display:block; width:24px; height:2px; background:currentColor;"></i>
      <i style="display:block; width:24px; height:2px; background:currentColor;"></i>
      <i style="display:block; width:16px; height:2px; align-self:flex-end; background:currentColor;"></i>
    </button>
  </header>
  
  <!-- MOBILE DRAWER OVERLAY -->
  <div class="mdrawer" id="crux-mobile-drawer" style="background:#FFFFFF;" role="dialog" aria-modal="true" aria-label="Crux Nxtion Navigation">
    <div class="mdrawer-topbar" style="border-bottom:1px solid #E1DEF3;">
      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="display:flex; align-items:center;">
        <img src="<?php echo crux_get_blob_url( "e4d72651b77d4c3cc1c086d9f6031149" ); ?>" alt="Crux Nxtion" style="height:36px; width:auto; background:#FFFFFF; padding:4px 12px; border-radius:6px; border:1px solid #E1DEF3; display:block;">
      </a>
      <button type="button" class="mdrawer-close-btn" id="crux-mdrawer-close" aria-label="Close menu" style="background:rgba(16,20,46,0.08); border:none; color:#10142E; cursor:pointer; display:flex; align-items:center; justify-content:center;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>
    
    <div class="mdrawer-body">
                  <!-- Quick Wing Switcher -->
      <div style="display:flex; gap:6px; margin:4px 0 18px;">
        <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="font-size:12px; font-weight:700; padding:8px 18px; color:#5A5F86; --sl:6px; --bc:#5A5F8655;" class="bx">Events</a>
        <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="font-size:12px; font-weight:700; padding:8px 18px; background:#8C7AE6; color:#0A0F26; --sl:6px;" class="bx">Consultancy</a>
      </div>

      <!-- Navigation Links -->
      <div class="mdrawer-nav-links">
        <a class="mlink" href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="color:#10142E; border-bottom:1px solid #E1DEF3;">Home</a>
        
        <!-- Accordion Services -->
        <details class="mdrawer-acc" style="border-bottom:1px solid #E1DEF3;">
          <summary style="display:flex; align-items:center; justify-content:space-between; cursor:pointer; padding:14px 0;">
            <span class="mlink" style="color:#10142E;">Services</span>
            <span class="acc-icon" style="color:#6C58DB; font-size:22px; font-weight:700; transition:transform .2s ease;">▾</span>
          </summary>
          <div style="padding:4px 0 16px;">
            <!-- Events sub-box -->
            <div style="background:#F8F9FE; border:1px solid #DCE5FA; border-radius:8px; padding:12px 14px; margin-bottom:12px;">
              <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                <span style="font-size:10px; font-weight:800; letter-spacing:1px; color:#002671; text-transform:uppercase;">EVENTS WING</span>
                <a href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="font-size:11px; font-weight:700; color:#002671; text-decoration:none;">All &rarr;</a>
              </div>
              <a class="msub" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#10142E;">Event Management &amp; Planning</a>
              <a class="msub" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#10142E;">Entertainment Booking &amp; Talent</a>
              <a class="msub" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#10142E;">Design &amp; Audio-Visual Production</a>
              <a class="msub" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#10142E;">On-Site Floor Coordination</a>
            </div>

            <!-- Consultancy sub-box -->
            <div style="background:#FBF9FE; border:1px solid #E6DFF9; border-radius:8px; padding:12px 14px;">
              <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                <span style="font-size:10px; font-weight:800; letter-spacing:1px; color:#6C58DB; text-transform:uppercase;">CONSULTANCY WING</span>
                <a href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="font-size:11px; font-weight:700; color:#6C58DB; text-decoration:none;">All &rarr;</a>
              </div>
              <a class="msub" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#10142E;">Business Setup &amp; Strategy</a>
              <a class="msub" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#10142E;">Commercial Fitout &amp; Setup</a>
              <a class="msub" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#10142E;">Brand Growth &amp; Scaling</a>
              <a class="msub" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="color:#10142E;">Specialized Visas &amp; Advisory</a>
            </div>
          </div>
        </details>

        <a class="mlink" href="<?php echo esc_url( home_url( "/events/" ) ); ?>" style="color:#10142E; border-bottom:1px solid #E1DEF3;">Events</a>
        <a class="mlink" href="<?php echo esc_url( home_url( "/gallery/" ) ); ?>" style="color:#10142E; border-bottom:1px solid #E1DEF3;">Gallery</a>
        <a class="mlink" href="<?php echo esc_url( home_url( "/about/" ) ); ?>" style="color:#10142E; border-bottom:1px solid #E1DEF3;">About</a>
        <a class="mlink" href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" style="color:#10142E; border-bottom:1px solid #E1DEF3;">Blog</a>
        <a class="mlink" href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="color:#10142E; border-bottom:1px solid #E1DEF3;">Contact</a>
      </div>

      <!-- Dual Action CTAs -->
      <div style="display:flex; flex-direction:column; gap:10px; margin-top:24px;">
        <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="display:block; text-align:center; background:#BA0000; color:#FFFFFF; font-weight:700; font-size:14px; padding:15px 20px; --sl:8px; text-decoration:none;" class="bx">Plan An Event &rarr;</a>
        <a href="https://calendly.com/cruxnxtiongroupofcompany-info" target="_blank" rel="noopener" style="display:block; text-align:center; background:#8C7AE6; color:#10142E; font-weight:700; font-size:14px; padding:15px 20px; --sl:8px; text-decoration:none;" class="bx">Book Discovery Call (Calendly) &rarr;</a>
      </div>

      <!-- Contact & Direct Telephony -->
      <div style="margin-top:24px; padding-top:18px; border-top:1px solid #E1DEF3; display:flex; flex-direction:column; gap:8px;">
        <div style="display:flex; align-items:center; gap:8px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6C58DB" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"></path></svg>
          <a href="tel:+447448614051" style="font-size:13px; color:#5A5F86; text-decoration:none; font-weight:600;">+44 7448 614051</a>
        </div>
        <div style="display:flex; align-items:center; gap:8px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#BA0000" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
          <?php $c_mail = 'infoandsales@cruxnxtion.co.uk'; ?>
          <a href="<?php echo esc_url( 'mailto:' . antispambot( $c_mail ) ); ?>" style="font-size:13px; color:#5A5F86; text-decoration:none; font-weight:600;"><?php echo esc_html( antispambot( $c_mail ) ); ?></a>
        </div>
      </div>
    </div>
  </div>

      <!-- 1 HERO -->
  <section style="min-height:640px; display:grid; grid-template-columns:1.15fr 0.85fr; gap:50px; align-items:center; padding:60px clamp(24px, 5vw, 64px); background:#FFFFFF;" data-m="g1 nomin">
    <div class="reveal">
      <span class="eyebrow" style="color:#6C58DB; font-weight:700; letter-spacing:1.5px; font-size:12px;">Crux Nxtion Consultancy • Sheffield &amp; UK-Wide</span>
      <h1 class="bebas hero-title" style="margin:16px 0px 20px 0px; color:#10142E; max-width:680px;">
        <span class="consultancy-hero-main" style="display:block; font-size:clamp(56px, 6.8vw, 77px); line-height:0.92;">YOU'VE GOT THE IDEA.</span>
        <span class="consultancy-hero-sub" style="display:block; font-size:clamp(62px, 7.8vw, 85px); line-height:0.92; color:#6C58DB; margin-top:4px;">LET'S BUILD THE BUSINESS.</span>
      </h1>
      <p style="font-size:17px; line-height:1.7; color:#3A3F66; max-width:580px; margin:0px 0px 32px 0px;">Whether you're starting from scratch, trying to grow, or just need a clearer direction — sit down with us. We'll talk it through, then turn it into a plan you can actually follow.</p>
      <div style="display:flex; gap:16px; flex-wrap:wrap;">
        <a href="https://calendly.com/cruxnxtiongroupofcompany-info" target="_blank" rel="noopener" style="background:#8C7AE6; color:#10142E; font-weight:700; font-size:15px; padding:16px 30px; --sl:10px;" class="bx">Book A Discovery Call</a>
        <a href="#how" style="color:#10142E; font-weight:700; font-size:15px; padding:14.5px 28px; --sl:10px; --bc:#10142E;" class="bx">See How We Work</a>
      </div>
    </div>
    
    <!-- HERO RIGHT: DUAL RETAIL TRANSFORMATION SHOWCASE + FULL DISCOVERY CALL -->
    <div style="position:relative; height:660px; display:flex; align-items:center; justify-content:center;" class="reveal consultancy-hero-visual" data-m="herovis">
      
      <!-- Transformation Container featuring the 2 REAL client transformation photos -->
      <div style="position:relative; width:100%; height:540px; display:flex; gap:20px; align-items:center; justify-content:center;">
        
        <!-- Photo 1: Bare Retail Unit / Office -->
        <div class="tilt-straighten" style="--r:-3.5deg; transform:rotate(var(--r)); width:260px; height:370px; background:#FFFFFF; border-radius:18px; overflow:hidden; box-shadow:0 18px 40px rgba(16,20,46,0.18); border:2px solid #E1DEF3; position:absolute; left:15px; top:20px; z-index:1;">
          <div style="height:270px; overflow:hidden; background:#F4F5FA;">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/consultancy-retail-unit.jpg' ); ?>" alt="Before: Sourcing & Unit Acquisition" style="width:100%; height:100%; object-fit:cover; display:block;">
          </div>
          <div style="padding:12px 14px; background:#FFFFFF;">
            <span style="font-size:10px; font-weight:800; letter-spacing:1px; text-transform:uppercase; color:#6C58DB; display:block;">BEFORE</span>
            <strong style="font-size:13px; font-weight:700; color:#10142E; display:block; margin-top:2px;">Location &amp; Unit Acquisition</strong>
            <span style="font-size:11.5px; color:#5A5F86; display:block; margin-top:2px;">We source the retail shop/office</span>
          </div>
        </div>

        <!-- Photo 2: Stocked & Fitted Store -->
        <div class="tilt-straighten" style="--r:3deg; transform:rotate(var(--r)); width:270px; height:390px; background:#FFFFFF; border-radius:18px; overflow:hidden; box-shadow:0 22px 50px rgba(108,88,219,0.25); border:2.5px solid #8C7AE6; position:absolute; right:10px; top:10px; z-index:2;">
          <div style="height:280px; overflow:hidden; background:#F4F5FA;">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/consultancy-retail-stocked.jpg' ); ?>" alt="After: Fitout, Stocking & Launch" style="width:100%; height:100%; object-fit:cover; display:block;">
          </div>
          <div style="padding:12px 14px; background:#FFFFFF;">
            <span style="font-size:10px; font-weight:800; letter-spacing:1px; text-transform:uppercase; color:#BA0000; display:block;">AFTER</span>
            <strong style="font-size:13px; font-weight:700; color:#10142E; display:block; margin-top:2px;">Fitout, Stocking &amp; Setup</strong>
            <span style="font-size:11.5px; color:#5A5F86; display:block; margin-top:2px;">We build it, stock it &amp; launch</span>
          </div>
        </div>

      </div>

      <!-- Float Badge: From Blueprint to Launch (Top Right) -->
      <div class="float" style="--r:5deg; position:absolute; top:20px; right:-10px; background:#8C7AE6; color:#10142E; padding:12px 18px; border-radius:10px; z-index:4; box-shadow:0 10px 24px rgba(140,122,230,0.35);">
        <span class="bebas" style="font-size:20px; line-height:1.1; display:block;">FROM BLUEPRINT<br>TO FULL SETUP</span>
      </div>

      <!-- Scaled-Down Full Discovery Chat Box (Preserving All 4 Dialogue Bubbles) -->
      <div style="position:absolute; left:-10px; bottom:10px; width:360px; z-index:5;" data-m="hv-chat full">
        <div class="tilt-straighten" style="--r:-1deg; transform:rotate(var(--r)); background:rgba(16,20,46,0.96) !important; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); border:1.5px solid #3A3F72; border-radius:20px; padding:16px 18px; display:flex; flex-direction:column; gap:8px; box-shadow:0 18px 40px rgba(0,0,0,0.4);">
          <div style="display:flex; align-items:center; gap:8px; padding-bottom:8px; border-bottom:1.5px dashed #2A2F5C;">
            <span class="pulse-dot" style="width:8px; height:8px; border-radius:50%; background:#3DDC84;"></span>
            <span style="font-size:12px; font-weight:700; color:#F2F1F8;">Discovery call</span>
            <span style="font-size:11px; color:#9A9AC0; margin-left:auto;">with Crux Nxtion</span>
          </div>
          <div class="bubble-in cb cb1" style="align-self:flex-end; max-width:85%; background:#2A2F5C; color:#F2F1F8; font-size:12px; line-height:1.45; padding:9px 13px; border-radius:14px 14px 2px 14px;">I've got an idea. I just don't know where to start.</div>
          <div class="bubble-in cb cb2" style="align-self:flex-start; max-width:85%; background:#8C7AE6; color:#10142E; font-size:12px; font-weight:600; line-height:1.45; padding:9px 13px; border-radius:14px 14px 14px 2px;">Good — that's the right place to start. Tell us about it.</div>
          <div class="bubble-in cb cb3" style="align-self:flex-end; max-width:85%; background:#2A2F5C; color:#F2F1F8; font-size:12px; line-height:1.45; padding:9px 13px; border-radius:14px 14px 2px 14px;">Also… we're busy, but the business isn't really growing.</div>
          <div class="bubble-in cb cb4" style="align-self:flex-start; max-width:85%; background:#8C7AE6; color:#10142E; font-size:12px; font-weight:600; line-height:1.45; padding:9px 13px; border-radius:14px 14px 14px 2px;">We'll look at both. First: what does a good year look like for you?</div>
          <div class="cb cbt" style="align-self:flex-start; display:flex; gap:4px; padding:6px 10px; background:#2A2F5C; border-radius:8px;">
            <span class="cdot cdot1" style="width:5px; height:5px; border-radius:50%; background:#9A9AC0;"></span>
            <span class="cdot cdot2" style="width:5px; height:5px; border-radius:50%; background:#9A9AC0;"></span>
            <span class="cdot cdot3" style="width:5px; height:5px; border-radius:50%; background:#9A9AC0;"></span>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- 2 SOUND FAMILIAR -->
  <section style="min-height:671px; padding:60px 0 56px; background:#FFFFFF;" data-m="nomin">
    <div style="padding:0 clamp(24px, 5vw, 64px); display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:40px;" class="reveal">
      <div><span class="eyebrow">Sound Familiar?</span><h2 class="bebas" style="font-size:40px; margin:12px 0px 0px 0px; color:#10142E;">THINGS FOUNDERS SAY<br>BEFORE THEY CALL US.</h2></div>
      <div style="display:flex; gap:12px;" data-m="hide"><button onclick="prevSoundFamiliar()" aria-label="Previous" style="width:44px; height:44px; background:#F3F1FC; color:#10142E; font-size:18px; display:inline-flex; align-items:center; justify-content:center; --sl:7px; cursor:pointer;" class="bx">←</button><button onclick="nextSoundFamiliar()" aria-label="Next" style="width:44px; height:44px; background:#8C7AE6; color:#10142E; font-size:18px; display:inline-flex; align-items:center; justify-content:center; --sl:7px; cursor:pointer;" class="bx">→</button></div>
    </div>
    <div id="soundFamiliarScroller" style="overflow-x:auto; scrollbar-width:none; padding-left:64px;" class="reveal" data-m="scroller"><div style="display:flex; gap:24px; transition:transform .4s ease;" class="carousel-track" data-m="track">
        <div class="bento-tile" style="flex:0 0 400px; height:500px; position:relative; border-radius:22px; overflow:hidden; border:1.5px solid #E1DEF3;">
          <img src="<?php echo crux_get_blob_url( "19a249fe66d9d8620a7283402ecde11e" ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:top;">
          <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.97) 0%, rgba(16,20,46,0.55) 48%, rgba(16,20,46,0.05) 100%);"></div>
          <span class="bebas" style="position:absolute; left:26px; top:22px; font-size:40px; color:#FF2E3D; line-height:1;">“</span>
          <div style="position:absolute; left:0; right:0; bottom:0; padding:28px 28px 28px 28px;">
            <p style="font-size:24px; line-height:1.28; font-weight:700; color:#F2F1F8; margin:0px 0px 20px 0px;">I have an idea… I just don't know where to start.</p>
            <div style="border-top:2px dashed #3A3F72; padding-top:14px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; color:#9A9AC0;">We help with</span><span style="color:#8C7AE6; font-size:11px; font-weight:700; letter-spacing:1.3px; padding:6px 13px 6px 13px; --sl:6px; --bc:#8C7AE6;" class="bx">SETUP &amp; STRATEGY</span></div>
          </div>
        </div>
        <div class="bento-tile" style="flex:0 0 400px; height:500px; position:relative; border-radius:22px; overflow:hidden; border:1.5px solid #E1DEF3;">
          <img src="<?php echo crux_get_blob_url( "53d4feb181f3c6e0619a155bc4be2bf5" ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center;">
          <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.97) 0%, rgba(16,20,46,0.55) 48%, rgba(16,20,46,0.05) 100%);"></div>
          <span class="bebas" style="position:absolute; left:26px; top:22px; font-size:40px; color:#FF2E3D; line-height:1;">“</span>
          <div style="position:absolute; left:0; right:0; bottom:0; padding:28px 28px 28px 28px;">
            <p style="font-size:24px; line-height:1.28; font-weight:700; color:#F2F1F8; margin:0px 0px 20px 0px;">We're busy, but the business isn't really growing.</p>
            <div style="border-top:2px dashed #3A3F72; padding-top:14px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; color:#9A9AC0;">We help with</span><span style="color:#8C7AE6; font-size:11px; font-weight:700; letter-spacing:1.3px; padding:6px 13px 6px 13px; --sl:6px; --bc:#8C7AE6;" class="bx">BUSINESS GROWTH</span></div>
          </div>
        </div>
        <div class="bento-tile" style="flex:0 0 400px; height:500px; position:relative; border-radius:22px; overflow:hidden; border:1.5px solid #E1DEF3;">
          <img src="<?php echo crux_get_blob_url( "a4f578a4b1ff3c642674f670e1eaa25b" ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:top;">
          <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.97) 0%, rgba(16,20,46,0.55) 48%, rgba(16,20,46,0.05) 100%);"></div>
          <span class="bebas" style="position:absolute; left:26px; top:22px; font-size:40px; color:#FF2E3D; line-height:1;">“</span>
          <div style="position:absolute; left:0; right:0; bottom:0; padding:28px 28px 28px 28px;">
            <p style="font-size:24px; line-height:1.28; font-weight:700; color:#F2F1F8; margin:0px 0px 20px 0px;">Our brand doesn't say what we actually do.</p>
            <div style="border-top:2px dashed #3A3F72; padding-top:14px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; color:#9A9AC0;">We help with</span><span style="color:#8C7AE6; font-size:11px; font-weight:700; letter-spacing:1.3px; padding:6px 13px 6px 13px; --sl:6px; --bc:#8C7AE6;" class="bx">BRANDING &amp; MARKETING</span></div>
          </div>
        </div>
        <div class="bento-tile" style="flex:0 0 400px; height:500px; position:relative; border-radius:22px; overflow:hidden; border:1.5px solid #E1DEF3;">
          <img src="<?php echo crux_get_blob_url( "8f4495361437a1d1961471650d55c60a" ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center;">
          <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.97) 0%, rgba(16,20,46,0.55) 48%, rgba(16,20,46,0.05) 100%);"></div>
          <span class="bebas" style="position:absolute; left:26px; top:22px; font-size:40px; color:#FF2E3D; line-height:1;">“</span>
          <div style="position:absolute; left:0; right:0; bottom:0; padding:28px 28px 28px 28px;">
            <p style="font-size:24px; line-height:1.28; font-weight:700; color:#F2F1F8; margin:0px 0px 20px 0px;">People know us — they just don't buy.</p>
            <div style="border-top:2px dashed #3A3F72; padding-top:14px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; color:#9A9AC0;">We help with</span><span style="color:#8C7AE6; font-size:11px; font-weight:700; letter-spacing:1.3px; padding:6px 13px 6px 13px; --sl:6px; --bc:#8C7AE6;" class="bx">ACTIVATION GROWTH</span></div>
          </div>
        </div>
        <div class="bento-tile" style="flex:0 0 400px; height:500px; position:relative; border-radius:22px; overflow:hidden; border:1.5px solid #E1DEF3;">
          <img src="<?php echo crux_get_blob_url( "44b7a98d85fefb8a03f8b8e625e3bcdc" ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center;">
          <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.97) 0%, rgba(16,20,46,0.55) 48%, rgba(16,20,46,0.05) 100%);"></div>
          <span class="bebas" style="position:absolute; left:26px; top:22px; font-size:40px; color:#FF2E3D; line-height:1;">“</span>
          <div style="position:absolute; left:0; right:0; bottom:0; padding:28px 28px 28px 28px;">
            <p style="font-size:24px; line-height:1.28; font-weight:700; color:#F2F1F8; margin:0px 0px 20px 0px;">I need someone honest to look at the whole thing.</p>
            <div style="border-top:2px dashed #3A3F72; padding-top:14px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; color:#9A9AC0;">We help with</span><span style="color:#8C7AE6; font-size:11px; font-weight:700; letter-spacing:1.3px; padding:6px 13px 6px 13px; --sl:6px; --bc:#8C7AE6;" class="bx">AUDIT &amp; ADVISORY</span></div>
          </div>
        </div>
    </div></div>
  </section>

  <!-- 3 START WHERE YOU ARE -->
  <section style="min-height:593px; padding:60px clamp(24px, 5vw, 64px);" data-m="nomin">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:40px;" class="reveal" data-m="stack">
      <h2 class="bebas" style="font-size:40px; margin:0px 0px 0px 0px; color:#10142E;">START WHERE YOU ARE</h2>
      <p style="max-width:380px; font-size:14px; color:#5A5F86; margin:0px 0px 0px 0px;">We don't just give you ideas — we help you turn them into actionable plans.</p>
    </div>
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:24px;" class="reveal" data-m="g1">

      <a href="#" class="tilt-ticket reveal" style="display:flex; background:#F3F1FC; border:1.5px solid #E1DEF3; border-radius:12px; min-height:300px; --r:-1deg; transform:rotate(var(--r)); overflow:hidden;">
        <div class="ticket-stub" style="flex:0 0 90px; background:#8C7AE6; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px;"><span class="bebas" style="font-size:38px; color:#10142E; line-height:1;">01</span><span style="font-size:10px; font-weight:800; letter-spacing:1.5px; color:#10142E;">START</span></div>
        <div style="flex:1; padding:28px 24px 28px 24px; display:flex; flex-direction:column; justify-content:flex-end;">
          <span class="eyebrow">Where are you?</span>
          <h3 style="font-size:20px; margin:8px 0px 10px 0px; font-weight:700; color:#10142E;">Starting from scratch</h3>
          <p style="font-size:13px; line-height:1.65; color:#5A5F86; margin:0px 0px 0px 0px;">Business setup and strategy: structure, positioning and a launch plan.</p>
        </div>
      </a>

      <a href="#" class="tilt-ticket reveal" style="display:flex; background:#F3F1FC; border:1.5px solid #E1DEF3; border-radius:12px; min-height:300px; --r:0.8deg; transform:rotate(var(--r)); overflow:hidden;">
        <div class="ticket-stub" style="flex:0 0 90px; background:#8C7AE6; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px;"><span class="bebas" style="font-size:38px; color:#10142E; line-height:1;">02</span><span style="font-size:10px; font-weight:800; letter-spacing:1.5px; color:#10142E;">GROW</span></div>
        <div style="flex:1; padding:28px 24px 28px 24px; display:flex; flex-direction:column; justify-content:flex-end;">
          <span class="eyebrow">Where are you?</span>
          <h3 style="font-size:20px; margin:8px 0px 10px 0px; font-weight:700; color:#10142E;">Trying to grow</h3>
          <p style="font-size:13px; line-height:1.65; color:#5A5F86; margin:0px 0px 0px 0px;">Business growth and activation growth: the plan and the campaigns behind it.</p>
        </div>
      </a>

      <a href="#" class="tilt-ticket reveal" style="display:flex; background:#F3F1FC; border:1.5px solid #E1DEF3; border-radius:12px; min-height:300px; --r:-0.8deg; transform:rotate(var(--r)); overflow:hidden;">
        <div class="ticket-stub" style="flex:0 0 90px; background:#8C7AE6; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px;"><span class="bebas" style="font-size:38px; color:#10142E; line-height:1;">03</span><span style="font-size:10px; font-weight:800; letter-spacing:1.5px; color:#10142E;">CLEAR</span></div>
        <div style="flex:1; padding:28px 24px 28px 24px; display:flex; flex-direction:column; justify-content:flex-end;">
          <span class="eyebrow">Where are you?</span>
          <h3 style="font-size:20px; margin:8px 0px 10px 0px; font-weight:700; color:#10142E;">Need a clearer direction</h3>
          <p style="font-size:13px; line-height:1.65; color:#5A5F86; margin:0px 0px 0px 0px;">A business audit and advisory session, ending in an action plan you can follow.</p>
        </div>
      </a>
    </div>
  </section>

    <!-- 4 WHAT WE DO — 5 PANELS -->
  <section id="services" style="min-height:671px; padding:60px clamp(24px, 5vw, 64px); background:#FFFFFF;">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:34px;" class="reveal">
      <div><span class="eyebrow">What We Do</span><h2 class="bebas" style="font-size:60px; margin:12px 0 0; color:#10142E;">FIVE WAYS WE HELP.</h2></div>
      <p style="max-width:340px; font-size:13.5px; color:#5A5F86; margin:0;">Hover or tap a panel to open it.</p>
    </div>
    <div class="consultancy-panels-container reveal" style="display:flex; gap:14px; height:520px;">
      <div class="cpanel active" onclick="selectPanel(this)" style="position:relative; overflow:hidden; border-radius:22px; border:1.5px solid #8C7AE6; cursor:pointer; flex:5 1 0; min-width:0; transition:all .4s ease;">
        <img src="<?php echo crux_get_blob_url( '4f18304ff3dad6215b2bb23021322a98' ); ?>" alt="Setup & Strategy" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:brightness(0.85);">
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.96) 0%, rgba(16,20,46,0.35) 60%, rgba(16,20,46,0.55) 100%);"></div>
        <span class="bebas" style="position:absolute; left:22px; top:20px; font-size:34px; color:#8C7AE6;">01</span>
        <span class="bebas cpanel-label" style="position:absolute; left:50%; bottom:28px; transform:translateX(-50%) rotate(180deg); writing-mode:vertical-rl; font-size:26px; color:#F2F1F8; white-space:nowrap; display:none;">Setup &amp; Strategy</span>
        <div class="cpanel-body" style="position:absolute; left:0; right:0; bottom:0; padding:36px;"><h3 class="bebas" style="font-size:46px; margin:0 0 10px; color:#F2F1F8;">Business Setup &amp; Strategy</h3><p style="font-size:14.5px; line-height:1.65; color:#C7C7DA; margin:0 0 14px; max-width:460px;">Structure, positioning and a clear operating plan — so the idea has something solid to stand on.</p><div style="display:flex; gap:8px; flex-wrap:wrap;"><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx">Business model</span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx">Positioning</span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx">Launch plan</span></div></div>
      </div>
      <div class="cpanel" onclick="selectPanel(this)" style="position:relative; overflow:hidden; border-radius:22px; border:1.5px solid #E1DEF3; cursor:pointer; flex:1 1 0; min-width:0; transition:all .4s ease;">
        <img src="<?php echo crux_get_blob_url( 'ca942693739cdc74700f9c8d65278358' ); ?>" alt="Branding & Marketing" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:brightness(0.5);">
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.96) 0%, rgba(16,20,46,0.35) 60%, rgba(16,20,46,0.55) 100%);"></div>
        <span class="bebas" style="position:absolute; left:22px; top:20px; font-size:24px; color:#8C7AE6;">02</span>
        <span class="bebas cpanel-label" style="position:absolute; left:50%; bottom:28px; transform:translateX(-50%) rotate(180deg); writing-mode:vertical-rl; font-size:26px; color:#F2F1F8; white-space:nowrap;">Branding &amp; Marketing</span>
        <div class="cpanel-body" style="position:absolute; left:0; right:0; bottom:0; padding:36px; display:none;"><h3 class="bebas" style="font-size:46px; margin:0 0 10px; color:#F2F1F8;">Branding &amp; Marketing</h3><p style="font-size:14.5px; line-height:1.65; color:#C7C7DA; margin:0 0 14px; max-width:460px;">Brand identity, audience messaging, and campaigns that put the business in front of the right buyers.</p><div style="display:flex; gap:8px; flex-wrap:wrap;"><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx">Identity</span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx">Messaging</span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx">Campaigns</span></div></div>
      </div>
      <div class="cpanel" onclick="selectPanel(this)" style="position:relative; overflow:hidden; border-radius:22px; border:1.5px solid #E1DEF3; cursor:pointer; flex:1 1 0; min-width:0; transition:all .4s ease;">
        <img src="<?php echo crux_get_blob_url( '62f016a3e0b0dc275a615ae5af6b3b69' ); ?>" alt="Operations & Workflow" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:brightness(0.5);">
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.96) 0%, rgba(16,20,46,0.35) 60%, rgba(16,20,46,0.55) 100%);"></div>
        <span class="bebas" style="position:absolute; left:22px; top:20px; font-size:24px; color:#8C7AE6;">03</span>
        <span class="bebas cpanel-label" style="position:absolute; left:50%; bottom:28px; transform:translateX(-50%) rotate(180deg); writing-mode:vertical-rl; font-size:26px; color:#F2F1F8; white-space:nowrap;">Operations &amp; Workflow</span>
        <div class="cpanel-body" style="position:absolute; left:0; right:0; bottom:0; padding:36px; display:none;"><h3 class="bebas" style="font-size:46px; margin:0 0 10px; color:#F2F1F8;">Operations &amp; Workflow</h3><p style="font-size:14.5px; line-height:1.65; color:#C7C7DA; margin:0 0 14px; max-width:460px;">Process design, vendor coordination and everyday systems that keep delivery smooth and consistent.</p><div style="display:flex; gap:8px; flex-wrap:wrap;"><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx">Processes</span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx">Vendors</span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx">Systems</span></div></div>
      </div>
      <div class="cpanel" onclick="selectPanel(this)" style="position:relative; overflow:hidden; border-radius:22px; border:1.5px solid #E1DEF3; cursor:pointer; flex:1 1 0; min-width:0; transition:all .4s ease;">
        <img src="<?php echo crux_get_blob_url( 'b7834baeaf5a08921ea7b06e7153a0e4' ); ?>" alt="Growth & Scaling" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:brightness(0.5);">
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.96) 0%, rgba(16,20,46,0.35) 60%, rgba(16,20,46,0.55) 100%);"></div>
        <span class="bebas" style="position:absolute; left:22px; top:20px; font-size:24px; color:#8C7AE6;">04</span>
        <span class="bebas cpanel-label" style="position:absolute; left:50%; bottom:28px; transform:translateX(-50%) rotate(180deg); writing-mode:vertical-rl; font-size:26px; color:#F2F1F8; white-space:nowrap;">Growth &amp; Scaling</span>
        <div class="cpanel-body" style="position:absolute; left:0; right:0; bottom:0; padding:36px; display:none;"><h3 class="bebas" style="font-size:46px; margin:0 0 10px; color:#F2F1F8;">Growth &amp; Scaling</h3><p style="font-size:14.5px; line-height:1.65; color:#C7C7DA; margin:0 0 14px; max-width:460px;">New revenue lines, team expansion and partnerships that take an established business further.</p><div style="display:flex; gap:8px; flex-wrap:wrap;"><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx">New revenue</span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx">Expansion</span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx">Partners</span></div></div>
      </div>
      <div class="cpanel" onclick="selectPanel(this)" style="position:relative; overflow:hidden; border-radius:22px; border:1.5px solid #E1DEF3; cursor:pointer; flex:1 1 0; min-width:0; transition:all .4s ease;">
        <img src="<?php echo crux_get_blob_url( '052d83d28ee851b93069420ea3c10f8f' ); ?>" alt="Event Advisory" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:brightness(0.5);">
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.96) 0%, rgba(16,20,46,0.35) 60%, rgba(16,20,46,0.55) 100%);"></div>
        <span class="bebas" style="position:absolute; left:22px; top:20px; font-size:24px; color:#8C7AE6;">05</span>
        <span class="bebas cpanel-label" style="position:absolute; left:50%; bottom:28px; transform:translateX(-50%) rotate(180deg); writing-mode:vertical-rl; font-size:26px; color:#F2F1F8; white-space:nowrap;">Event Advisory</span>
        <div class="cpanel-body" style="position:absolute; left:0; right:0; bottom:0; padding:36px; display:none;"><h3 class="bebas" style="font-size:46px; margin:0 0 10px; color:#F2F1F8;">Event Advisory</h3><p style="font-size:14.5px; line-height:1.65; color:#C7C7DA; margin:0 0 14px; max-width:460px;">Strategic support for venues, organisers and brands looking to run tighter, higher-return events.</p><div style="display:flex; gap:8px; flex-wrap:wrap;"><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx">Venue strategy</span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx">P&amp;L model</span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx">Production</span></div></div>
      </div>
    </div>
  </section>

  <!-- 5 HOW IT WORKS — the climb -->
  <section id="how" style="min-height:702px; padding:60px clamp(24px, 5vw, 64px); background:#F3F1FC;" data-m="nomin">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:64px;" class="reveal" data-m="stack">
      <div><span class="eyebrow">How It Works</span><h2 class="bebas" style="font-size:40px; margin:12px 0px 0px 0px; color:#10142E;">FIVE STEPS.<br>ONE CLIMB. WE'RE ON THE ROPE WITH YOU.</h2></div>
      <p style="max-width:330px; font-size:14px; line-height:1.7; color:#5A5F86; margin:0px 0px 0px 0px;">No jargon, no 90-page deck. Every step builds on the last, and you always know what's next.</p>
    </div>
    <div style="display:grid; grid-template-columns:repeat(5, minmax(0, 1fr)); gap:16px; align-items:end;" class="reveal" data-m="g1">
      <div style="position:relative; height:270px; background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:20px; padding:0px 0px 0px 0px; overflow:visible; display:flex; flex-direction:column;" class="reveal">
        <div style="position:absolute; left:20px; top:-28px; width:56px; height:56px; border-radius:50%; background:#F3F1FC; border:2px dashed #6C58DB; display:flex; align-items:center; justify-content:center; z-index:2;" data-m="hide"><span class="bebas" style="font-size:22px; color:#6C58DB;">01</span></div>
        <div style="height:86px; margin:0px 0px 0px 0px; border-radius:18px 18px 0 0; overflow:hidden; position:relative;"><img src="<?php echo crux_get_blob_url( "50cb2790126aab1196125a6f09c951bf" ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.55) 0%, rgba(16,20,46,0.05) 100%);"></div></div>
        <div style=" padding:16px 20px 20px 20px; flex:1; display:flex; flex-direction:column;">
          <h3 class="bebas" style="font-size:26px; margin:6px 0px 8px 0px; color:#10142E;">WE TALK.</h3>
          <p style="font-size:13px; line-height:1.6; color:#3A3F66; margin:0 0 auto;">A relaxed first conversation. Tell us the idea, the mess or the goal — we ask the awkward questions.</p>
          <div style="border-top:1.5px dashed #D2CEEA; padding-top:10px; margin-top:12px; display:flex; flex-direction:column; gap:4px;"><span style="font-size:11px; color:#5A5F86;"><b style="letter-spacing:1px; color:#6C58DB;">YOU BRING</b> the story so far</span><span style="font-size:11px; color:#5A5F86;"><b style="letter-spacing:1px; color:#D9182A;">WE BRING</b> honest questions</span></div>
        </div>
      </div>
      <div style="position:relative; height:308px; background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:20px; padding:0px 0px 0px 0px; overflow:visible; display:flex; flex-direction:column;" class="reveal">
        <div style="position:absolute; left:20px; top:-28px; width:56px; height:56px; border-radius:50%; background:#F3F1FC; border:2px dashed #6C58DB; display:flex; align-items:center; justify-content:center; z-index:2;" data-m="hide"><span class="bebas" style="font-size:22px; color:#6C58DB;">02</span></div>
        <div style="height:86px; margin:0px 0px 0px 0px; border-radius:18px 18px 0 0; overflow:hidden; position:relative;"><img src="<?php echo crux_get_blob_url( "052d83d28ee851b93069420ea3c10f8f" ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.55) 0%, rgba(16,20,46,0.05) 100%);"></div></div>
        <div style=" padding:16px 20px 20px 20px; flex:1; display:flex; flex-direction:column;">
          <h3 class="bebas" style="font-size:26px; margin:6px 0px 8px 0px; color:#10142E;">WE DIG IN.</h3>
          <p style="font-size:13px; line-height:1.6; color:#3A3F66; margin:0 0 auto;">We look at your numbers, your market and your brand, and find what is really holding things back.</p>
          <div style="border-top:1.5px dashed #D2CEEA; padding-top:10px; margin-top:12px; display:flex; flex-direction:column; gap:4px;"><span style="font-size:11px; color:#5A5F86;"><b style="letter-spacing:1px; color:#6C58DB;">YOU BRING</b> numbers &amp; access</span><span style="font-size:11px; color:#5A5F86;"><b style="letter-spacing:1px; color:#D9182A;">WE BRING</b> a clear diagnosis</span></div>
        </div>
      </div>
      <div style="position:relative; height:346px; background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:20px; padding:0px 0px 0px 0px; overflow:visible; display:flex; flex-direction:column;" class="reveal">
        <div style="position:absolute; left:20px; top:-28px; width:56px; height:56px; border-radius:50%; background:#F3F1FC; border:2px dashed #6C58DB; display:flex; align-items:center; justify-content:center; z-index:2;" data-m="hide"><span class="bebas" style="font-size:22px; color:#6C58DB;">03</span></div>
        <div style="height:100px; margin:0px 0px 0px 0px; border-radius:18px 18px 0 0; overflow:hidden; position:relative;"><img src="<?php echo crux_get_blob_url( "e56c3376aee5c9f5027ad93a6f335536" ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.55) 0%, rgba(16,20,46,0.05) 100%);"></div></div>
        <div style=" padding:16px 20px 20px 20px; flex:1; display:flex; flex-direction:column;">
          <h3 class="bebas" style="font-size:26px; margin:6px 0px 8px 0px; color:#10142E;">WE SHAPE THE PLAN.</h3>
          <p style="font-size:13px; line-height:1.6; color:#3A3F66; margin:0 0 auto;">Priorities, in order, with owners and dates. Something you can actually follow.</p>
          <div style="border-top:1.5px dashed #D2CEEA; padding-top:10px; margin-top:12px; display:flex; flex-direction:column; gap:4px;"><span style="font-size:11px; color:#5A5F86;"><b style="letter-spacing:1px; color:#6C58DB;">YOU BRING</b> decisions</span><span style="font-size:11px; color:#5A5F86;"><b style="letter-spacing:1px; color:#D9182A;">WE BRING</b> the action plan</span></div>
        </div>
      </div>
      <div style="position:relative; height:384px; background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:20px; padding:0px 0px 0px 0px; overflow:visible; display:flex; flex-direction:column;" class="reveal">
        <div style="position:absolute; left:20px; top:-28px; width:56px; height:56px; border-radius:50%; background:#F3F1FC; border:2px dashed #6C58DB; display:flex; align-items:center; justify-content:center; z-index:2;" data-m="hide"><span class="bebas" style="font-size:22px; color:#6C58DB;">04</span></div>
        <div style="height:100px; margin:0px 0px 0px 0px; border-radius:18px 18px 0 0; overflow:hidden; position:relative;"><img src="<?php echo crux_get_blob_url( "97f6e11f46029a4f9812d43722c1bcf4" ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.55) 0%, rgba(16,20,46,0.05) 100%);"></div></div>
        <div style=" padding:16px 20px 20px 20px; flex:1; display:flex; flex-direction:column;">
          <h3 class="bebas" style="font-size:26px; margin:6px 0px 8px 0px; color:#10142E;">WE PUT IT IN MOTION.</h3>
          <p style="font-size:13px; line-height:1.6; color:#3A3F66; margin:0 0 auto;">Launch, campaign, activation — we help you start, not just advise.</p>
          <div style="border-top:1.5px dashed #D2CEEA; padding-top:10px; margin-top:12px; display:flex; flex-direction:column; gap:4px;"><span style="font-size:11px; color:#5A5F86;"><b style="letter-spacing:1px; color:#6C58DB;">YOU BRING</b> your time</span><span style="font-size:11px; color:#5A5F86;"><b style="letter-spacing:1px; color:#D9182A;">WE BRING</b> hands-on help</span></div>
        </div>
      </div>
      <div style="position:relative; height:422px; background:#8C7AE6; border:1.5px solid #8C7AE6; border-radius:20px; padding:0px 0px 0px 0px; overflow:visible; display:flex; flex-direction:column;" class="reveal">
        <div style="position:absolute; left:20px; top:-28px; width:56px; height:56px; border-radius:50%; background:#F3F1FC; border:2px dashed #6C58DB; display:flex; align-items:center; justify-content:center; z-index:2;" data-m="hide"><span class="bebas" style="font-size:22px; color:#6C58DB;">05</span></div>
        <div style="height:120px; margin:0px 0px 0px 0px; border-radius:18px 18px 0 0; overflow:hidden; position:relative;"><img src="<?php echo crux_get_blob_url( "263030a5b7aa9f782aeddd3e7f44cb13" ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(140,122,230,0.5) 0%, rgba(16,20,46,0.05) 100%);"></div></div>
        <div style=" padding:16px 20px 20px 20px; flex:1; display:flex; flex-direction:column;">
          <h3 class="bebas" style="font-size:26px; margin:6px 0px 8px 0px; color:#10142E;">WE STAY CLOSE.</h3>
          <p style="font-size:13px; line-height:1.6; color:#10142E; margin:0 0 auto;">We check in, adjust and stay close while the plan meets real life.</p>
          <div style="border-top:1.5px dashed rgba(16,20,46,0.4); padding-top:10px; margin-top:12px; display:flex; flex-direction:column; gap:4px;"><span style="font-size:11px; color:#10142E;"><b style="letter-spacing:1px; color:#10142E;">YOU BRING</b> feedback</span><span style="font-size:11px; color:#10142E;"><b style="letter-spacing:1px; color:#10142E;">WE BRING</b> ongoing support</span></div>
        </div>
      </div>
    </div>
  </section>

  <!-- 6 WHAT YOU WALK AWAY WITH -->
  <section style=" padding:60px clamp(24px, 5vw, 64px); background:#FFFFFF;">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:40px;" class="reveal" data-m="stack">
      <div><span class="eyebrow">What You Walk Away With</span><h2 class="bebas" style="font-size:40px; margin:12px 0px 0px 0px; color:#10142E;">THINGS YOU CAN ACTUALLY USE.</h2></div>
      <p style="max-width:340px; font-size:13.5px; color:#5A5F86; margin:0px 0px 0px 0px;">Samples shown for illustration.</p>
    </div>
    <div style="display:grid; grid-template-columns:repeat(12, minmax(0, 1fr)); grid-template-rows:repeat(2, 330px); gap:16px;" class="reveal" data-m="g1">

      <div class="bento-tile reveal" style="position:relative; overflow:hidden; border-radius:24px; border:1.5px solid rgba(242,241,248,0.14); grid-column:span 5; grid-row:span 2;" data-m="span tile">
        <img src="<?php echo crux_get_blob_url( "8cbbf8075ea65369e575c4f2b9fd9e4c" ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center;">
        <div style="position:absolute; inset:0; background:linear-gradient(180deg, rgba(16,20,46,0.3) 0%, rgba(16,20,46,0.9) 58%, rgba(16,20,46,0.96) 100%);"></div>
        <div style="position:relative; height:100%; padding:22px 22px 22px 22px; display:flex; flex-direction:column; justify-content:flex-end; gap:16px;"><div style="background:rgba(16,20,46,0.96) !important; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); border:1.5px solid #3A3F72; border-radius:14px; padding:16px 16px 16px 16px;"><span style="font-size:9.5px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:#8C7AE6;">Action plan</span><div style="display:flex; align-items:center; gap:10px; margin-top:9px;"><span style="width:16px; height:16px; border-radius:5px; background:#8C7AE6;"></span><span style="font-size:12.5px; color:#F2F1F8;">Define the offer</span></div><div style="display:flex; align-items:center; gap:10px; margin-top:9px;"><span style="width:16px; height:16px; border-radius:5px; background:#8C7AE6;"></span><span style="font-size:12.5px; color:#F2F1F8;">Fix the pricing</span></div><div style="display:flex; align-items:center; gap:10px; margin-top:9px;"><span style="width:16px; height:16px; border-radius:5px; background:#8C7AE6;"></span><span style="font-size:12.5px; color:#F2F1F8;">Choose the first channel</span></div><div style="display:flex; align-items:center; gap:10px; margin-top:9px;"><span class="ap4" style="width:16px; height:16px; border-radius:5px; border:1.5px solid #FF2E3D;"></span><span style="font-size:12.5px; color:#9A9AC0;">Launch the first campaign</span></div><div style="display:flex; align-items:center; gap:10px; margin-top:9px;"><span class="ap5" style="width:16px; height:16px; border-radius:5px; border:1.5px solid #FF2E3D;"></span><span style="font-size:12.5px; color:#9A9AC0;">Review and adjust</span></div><div style="height:6px; background:#3A3F72; border-radius:3px; margin-top:16px; overflow:hidden;"><div class="apbar" style="width:55%; height:100%; background:#8C7AE6;"></div></div></div><div><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:#F2F1F8;">THE ACTION PLAN</h3><p style="font-size:13px; line-height:1.6; color:#C7C7DA; margin:0px 0px 10px 0px;">A prioritised checklist with owners and dates — what to do this month, and what comes next.</p><span style="font-size:11px; letter-spacing:1.3px; font-weight:700; color:#8C7AE6;">YOU GET: A PLAN TO FOLLOW</span></div></div>
      </div>

      <div class="bento-tile reveal" style="position:relative; overflow:hidden; border-radius:24px; background:#8C7AE6; border:1.5px solid #8C7AE6; grid-column:span 4;" data-m="span">
        <div style="position:relative; height:100%; padding:22px 22px 22px 22px; display:flex; flex-direction:column; justify-content:flex-end; gap:16px;"><div style="background:#10142E; border:1.5px solid #10142E; border-radius:14px; padding:16px 16px 16px 16px;"><span style="font-size:9.5px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:#8C7AE6;">One-page strategy</span><p class="bebas" style="font-size:22px; margin:8px 0px 0px 0px; color:#F2F1F8; line-height:1;">WHO YOU SERVE. WHAT YOU SELL. <span class="ophl" style="color:#8C7AE6;">HOW YOU WIN.</span></p></div><div><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:#10142E;">THE ONE-PAGER</h3><p style="font-size:13px; line-height:1.6; color:#1E2350; margin:0px 0px 10px 0px;">Your strategy on a single page, so anyone on your team can explain it.</p><span style="font-size:11px; letter-spacing:1.3px; font-weight:700; color:#10142E;">YOU GET: CLARITY</span></div></div>
      </div>

      <div class="bento-tile reveal" style="position:relative; overflow:hidden; border-radius:24px; background:#10142E; border:1.5px solid #2A2F5C; grid-column:span 3;" data-m="span">
        <div style="position:relative; height:100%; padding:22px 22px 22px 22px; display:flex; flex-direction:column; justify-content:flex-end; gap:16px;"><div style="background:#1B2048; border:1.5px solid #3A3F72; border-radius:14px; padding:16px 16px 16px 16px;"><span style="font-size:9.5px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:#8C7AE6;">Brand direction</span><div style="display:flex; gap:6px; margin:10px 0px 8px 0px;" data-m="wrap"><span class="sw1" style="flex:1; height:26px; border-radius:7px; background:#10142E; border:1px solid #3A3F72;"></span><span class="sw2" style="flex:1; height:26px; border-radius:7px; background:#8C7AE6;"></span><span class="sw3" style="flex:1; height:26px; border-radius:7px; background:#FF2E3D;"></span></div><span class="bebas" style="font-size:20px; color:#F2F1F8;">Aa — voice &amp; look</span></div><div><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:#F2F1F8;">THE BRAND DIRECTION</h3><p style="font-size:13px; line-height:1.6; color:#C7C7DA; margin:0px 0px 10px 0px;">Look, voice and message — enough to brief any designer.</p><span style="font-size:11px; letter-spacing:1.3px; font-weight:700; color:#8C7AE6;">YOU GET: A BRAND TO BRIEF</span></div></div>
      </div>

      <div class="bento-tile reveal" style="position:relative; overflow:hidden; border-radius:24px; background:#E9E5FB; border:1.5px solid #D6D0F5; grid-column:span 3;" data-m="span">
        <div style="position:relative; height:100%; padding:22px 22px 22px 22px; display:flex; flex-direction:column; justify-content:flex-end; gap:16px;"><div style="background:#FFFFFF; border:1.5px solid #D6D0F5; border-radius:14px; padding:16px 16px 16px 16px;"><span style="font-size:9.5px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:#5B45C8;">Growth roadmap</span><div style="display:flex; align-items:center; gap:8px; margin-top:10px;"><span class="nowp bx" style="background:#8C7AE6; color:#10142E; font-size:9.5px; font-weight:800; padding:4px 9px 4px 9px; --sl:6px;">NOW</span><span class="rm1" style="display:block; height:7px; width:70%; background:#DAD6F0; border-radius:4px;"></span></div><div style="display:flex; align-items:center; gap:8px; margin-top:8px;"><span style="color:#5B45C8; font-size:9.5px; font-weight:800; padding:3px 8px 3px 8px; --sl:6px; --bc:#5B45C8;" class="bx">NEXT</span><span class="rm2" style="display:block; height:7px; width:48%; background:#DAD6F0; border-radius:4px;"></span></div><div style="display:flex; align-items:center; gap:8px; margin-top:8px;"><span style="color:#5A5F86; font-size:9.5px; font-weight:800; padding:3px 8px 3px 8px; --sl:6px; --bc:#9A9AC0;" class="bx">LATER</span><span class="rm3" style="display:block; height:7px; width:30%; background:#DAD6F0; border-radius:4px;"></span></div></div><div><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:#10142E;">THE GROWTH ROADMAP</h3><p style="font-size:13px; line-height:1.6; color:#3A3F66; margin:0px 0px 10px 0px;">Now, next, later: the sequence that gets you more customers.</p><span style="font-size:11px; letter-spacing:1.3px; font-weight:700; color:#5B45C8;">YOU GET: A ROUTE TO GROWTH</span></div></div>
      </div>

      <div class="bento-tile reveal" style="position:relative; overflow:hidden; border-radius:24px; border:1.5px solid rgba(242,241,248,0.14); grid-column:span 4;" data-m="span tile">
        <img src="<?php echo crux_get_blob_url( "d7ec7e8129482dec3e004a136575df53" ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center;">
        <div style="position:absolute; inset:0; background:linear-gradient(180deg, rgba(16,20,46,0.3) 0%, rgba(16,20,46,0.9) 58%, rgba(16,20,46,0.96) 100%);"></div>
        <div style="position:relative; height:100%; padding:22px 22px 22px 22px; display:flex; flex-direction:column; justify-content:flex-end; gap:16px;"><div style="background:rgba(16,20,46,0.96) !important; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); border:1.5px solid #3A3F72; border-radius:14px; padding:16px 16px 16px 16px;"><span style="font-size:9.5px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:#8C7AE6;">Audit scorecard</span><div style="display:flex; justify-content:space-around; margin-top:12px;" data-m="wrap"><div style="text-align:center;"><div class="rg rg72" style="--p:72; width:58px; height:58px; border-radius:50%; background:conic-gradient(#8C7AE6 calc(var(--p) * 1%), #3A3F72 0); display:flex; align-items:center; justify-content:center;"><span class="rgn" style="width:42px; height:42px; border-radius:50%; background:#10142E; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#F2F1F8;"></span></div><span style="font-size:10.5px; color:#9A9AC0; display:block; margin-top:5px;">Offer</span></div><div style="text-align:center;"><div class="rg rg45" style="--p:45; width:58px; height:58px; border-radius:50%; background:conic-gradient(#FF2E3D calc(var(--p) * 1%), #3A3F72 0); display:flex; align-items:center; justify-content:center;"><span class="rgn" style="width:42px; height:42px; border-radius:50%; background:#10142E; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#F2F1F8;"></span></div><span style="font-size:10.5px; color:#9A9AC0; display:block; margin-top:5px;">Brand</span></div><div style="text-align:center;"><div class="rg rg88" style="--p:88; width:58px; height:58px; border-radius:50%; background:conic-gradient(#8C7AE6 calc(var(--p) * 1%), #3A3F72 0); display:flex; align-items:center; justify-content:center;"><span class="rgn" style="width:42px; height:42px; border-radius:50%; background:#10142E; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#F2F1F8;"></span></div><span style="font-size:10.5px; color:#9A9AC0; display:block; margin-top:5px;">Sales</span></div></div></div><div><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:#F2F1F8;">THE AUDIT REPORT</h3><p style="font-size:13px; line-height:1.6; color:#C7C7DA; margin:0px 0px 10px 0px;">An honest read on what's working, what isn't, and what to fix first.</p><span style="font-size:11px; letter-spacing:1.3px; font-weight:700; color:#8C7AE6;">YOU GET: THE TRUTH, KINDLY</span></div></div>
      </div>
    </div>
  </section>

  <!-- 7 WHY US -->
  <section style="min-height:577px; padding:60px clamp(24px, 5vw, 64px); display:grid; grid-template-columns:1fr 1fr; gap:70px; align-items:center;" data-m="g1 nomin">
    <div class="reveal">
      <span class="eyebrow">Why Us</span>
      <h2 class="bebas" style="font-size:40px; margin:14px 0px 22px 0px; color:#10142E;">WE LEARNED TO BUILD BUSINESSES BY RUNNING ROOMS.</h2>
      <p style="font-size:15.5px; line-height:1.8; color:#3A3F66; margin:0px 0px 16px 0px;">Crux Nxtion started as an events crew in Sheffield. Every event is a small business with a deadline: a budget, a brand, a launch, a crowd to win over. Do that enough times and you learn what makes a plan hold up under pressure.</p>
      <p style="font-size:15.5px; line-height:1.8; color:#3A3F66; margin:0px 0px 26px 0px;">Consultancy is what happened when founders started asking for the same thinking behind their business, not just their party.</p>
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="font-weight:700; font-size:14px; color:#6C58DB; border-bottom:1.5px solid #6C58DB; padding-bottom:2px;">See the events side →</a>
    </div>
    <div style="position:relative; height:480px;" class="reveal why-us-collage" data-m="tile collage">
      <img class="tilt-straighten" src="<?php echo crux_get_blob_url( "c5afda4fc4e4d4b0682377d6eb272c90" ); ?>" alt="" style="--r:-6deg; transform:rotate(var(--r)); position:absolute; left:0; top:30px; width:250px; height:310px; object-fit:cover; border-radius:14px; border:2px solid #E1DEF3;">
      <img src="<?php echo crux_get_blob_url( "5d2ff88df9e44a1a073b23c7eb8ac29d" ); ?>" alt="" style="position:absolute; left:190px; top:90px; width:290px; height:350px; object-fit:cover; border-radius:14px; border:2px solid #8C7AE6; z-index:1;">
      <img class="tilt-straighten" src="<?php echo crux_get_blob_url( "b1e68ef21b53acd6fc513694c97d58cd" ); ?>" alt="" style="--r:6deg; transform:rotate(var(--r)); position:absolute; right:0; top:0; width:220px; height:290px; object-fit:cover; border-radius:14px; border:2px solid #E1DEF3;">
    </div>
  </section>

  <!-- 8 FOUNDER TEASER -->
  <section id="founder" style="padding:60px clamp(24px, 5vw, 64px); background:#FFFFFF; display:grid; grid-template-columns:auto 1fr auto; gap:48px; align-items:center; border-top:1px solid #E1DEF3; border-bottom:1px solid #E1DEF3;" data-m="g1">
    <div style="width:170px; height:210px; border-radius:16px; overflow:hidden; border:2px solid #8C7AE6;" class="reveal">
      <img src="<?php echo crux_get_blob_url( "a67d85c16f6df90ab7a657160bee9088" ); ?>" alt="Olabamidele 'Bambad' Badmos" style="width:100%; height:100%; object-fit:cover; object-position:58% 12%;">
    </div>
    <div class="reveal">
      <span class="eyebrow" style="color:#6C58DB;">Meet The Strategic Team</span>
      <h2 class="bebas" style="font-size:44px; margin:12px 0 10px; color:#10142E; line-height:0.95;">STRATEGIC DEVELOPMENT &amp; ENTERPRISE SCALING.</h2>
      <p style="font-size:15px; line-height:1.7; color:#3A3F66; margin:0 0 10px; max-width:660px;">Consultancy at Crux Nxtion is headed by <strong>Olabamidele Badmos (Bambad)</strong>, recognized community leader and business strategic development officer with extensive expertise in enterprise growth and marketing. Supported by a dedicated team of 10 active core members and specialized staff, our advisory wing has launched and scaled over <strong>143 registered companies</strong> across the UK since 2024.</p>
      <p style="font-size:14px; line-height:1.65; color:#5A5F86; margin:0; max-width:660px;">From commercial premises acquisition and turnkey shopfitting to specialized visas (Global Talent &amp; Innovator Founder), we provide the operational backbone that scales UK businesses.</p>
    </div>
    <a href="<?php echo esc_url( home_url( "/founder/" ) ); ?>" style="background:#8C7AE6; color:#10142E !important; font-weight:700; font-size:14px; padding:15px 28px; white-space:nowrap; --sl:10px;" class="reveal bx">Meet The Founder &rarr;</a>
  </section>

  <!-- 9 FAQ -->
  <section style="min-height:640px; padding:60px clamp(24px, 5vw, 64px); background:#F3F1FC; display:grid; grid-template-columns:0.8fr 1.2fr; gap:70px; align-items:start;" data-m="g1 nomin">
    <div style="position:relative; border-radius:24px; overflow:hidden; height:640px;" class="reveal" data-m="tile">
      <img src="<?php echo crux_get_blob_url( "de1f229044e51fea8eef0e8e07331cbe" ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
      <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.96) 0%, rgba(16,20,46,0.25) 65%);"></div>
      <div style="position:absolute; left:0; right:0; bottom:0; padding:32px 32px 32px 32px;">
        <span class="eyebrow" style="color:#8C7AE6 !important;">Good To Know</span>
        <h2 class="bebas" style="font-size:34px; margin:10px 0px 14px 0px; color:#F2F1F8;">STILL WONDERING?</h2>
        <a href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="background:#8C7AE6; color:#10142E; font-weight:700; font-size:14px; padding:14px 26px 14px 26px; display:inline-block; --sl:10px;" class="bx">Ask us directly</a>
      </div>
    </div>
      <div style="display:flex; flex-direction:column; gap:12px; padding-top:6px;" class="reveal">
    <details class="faq-item" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:16px; padding:0 26px; transition:border-color .25s ease;" open>
      <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
        <h3 style="font-size:17px; margin:0; font-weight:700; color:#10142E;">What if I only have an idea?</h3>
        <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:#8C7AE6; color:#10142E; display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
      </summary>
      <p style="font-size:15px; line-height:1.75; color:#3A3F66; margin:0 0 24px; max-width:680px;">That is a fine place to start. Business Setup &amp; Strategy is built for exactly that: the model, positioning and a clear launch plan.</p>
    </details>
    <details class="faq-item" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:16px; padding:0 26px; transition:border-color .25s ease;">
      <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
        <h3 style="font-size:17px; margin:0; font-weight:700; color:#10142E;">Is consultancy only for new businesses?</h3>
        <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:#8C7AE6; color:#10142E; display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
      </summary>
      <p style="font-size:15px; line-height:1.75; color:#3A3F66; margin:0 0 24px; max-width:680px;">No. Whether you are starting, growing or just need direction, we meet you where you are with scalable advisory.</p>
    </details>
    <details class="faq-item" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:16px; padding:0 26px; transition:border-color .25s ease;">
      <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
        <h3 style="font-size:17px; margin:0; font-weight:700; color:#10142E;">What happens on the discovery call?</h3>
        <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:#8C7AE6; color:#10142E; display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
      </summary>
      <p style="font-size:15px; line-height:1.75; color:#3A3F66; margin:0 0 24px; max-width:680px;">We listen, ask questions, and tell you honestly whether and how we can help. You leave knowing your exact next step.</p>
    </details>
    <details class="faq-item" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:16px; padding:0 26px; transition:border-color .25s ease;">
      <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
        <h3 style="font-size:17px; margin:0; font-weight:700; color:#10142E;">Do you just advise, or help do it?</h3>
        <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:#8C7AE6; color:#10142E; display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
      </summary>
      <p style="font-size:15px; line-height:1.75; color:#3A3F66; margin:0 0 24px; max-width:680px;">Both. We turn ideas into actionable plans and help you execute on campaigns, launches, and branding.</p>
    </details>
    <details class="faq-item" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:16px; padding:0 26px; transition:border-color .25s ease;">
      <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
        <h3 style="font-size:17px; margin:0; font-weight:700; color:#10142E;">Do you work outside Sheffield?</h3>
        <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:#8C7AE6; color:#10142E; display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
      </summary>
      <p style="font-size:15px; line-height:1.75; color:#3A3F66; margin:0 0 24px; max-width:680px;">Yes — we are Sheffield-based and advise founders, entrepreneurs, and brands across the entire UK.</p>
    </details>
    <details class="faq-item" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:16px; padding:0 26px; transition:border-color .25s ease;">
      <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
        <h3 style="font-size:17px; margin:0; font-weight:700; color:#10142E;">How do I book?</h3>
        <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:#8C7AE6; color:#10142E; display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
      </summary>
      <p style="font-size:15px; line-height:1.75; color:#3A3F66; margin:0 0 24px; max-width:680px;">Book a discovery call through our contact page and tell us where you are stuck.</p>
    </details>
  </div>
  </section>


  <div style="background:#10142E;">
    <!-- PREFOOTER CTA — cinematic band with spinning rosette badge -->
  <section style="position:relative; min-height:540px; overflow:hidden; display:flex; align-items:center;">
    <img src="<?php echo crux_get_blob_url( 'aa52e28c3ca12b7f14d33300c774fb48' ); ?>" alt="Crux Nxtion event crowd" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
    <div style="position:absolute; inset:0; background:linear-gradient(100deg, rgba(10,15,38,0.97) 0%, rgba(10,15,38,0.82) 52%, rgba(10,15,38,0.5) 100%);"></div>
    <div style="position:absolute; left:0; right:0; top:0; height:26px; background:#05081A; background-image:repeating-linear-gradient(90deg, transparent 0 18px, rgba(244,245,250,0.16) 18px 34px, transparent 34px 52px); background-size:52px 12px; background-repeat:repeat-x; background-position:0 7px; z-index:2;"></div>
    <div style="position:absolute; left:0; right:0; bottom:0; height:26px; background:#05081A; background-image:repeating-linear-gradient(90deg, transparent 0 18px, rgba(244,245,250,0.16) 18px 34px, transparent 34px 52px); background-size:52px 12px; background-repeat:repeat-x; background-position:0 7px; z-index:2;"></div>
    <div style="position:relative; z-index:1; width:100%; display:flex; justify-content:space-between; align-items:center; gap:40px; padding:0 64px; flex-wrap:wrap;" class="reveal" data-m="prefooter-inner">
      <div style="max-width:760px; padding:40px 0;">
        <span class="eyebrow" style="color:#A9C0F5 !important;">Ready When You Are</span>
        <h2 class="bebas" style="font-size:clamp(44px, 5.5vw, 76px); line-height:0.95; margin:16px 0 18px; color:#FFFFFF; max-width:820px;">GOT AN IDEA? LET'S TALK IT THROUGH.</h2>
        <p style="font-size:16px; line-height:1.7; color:#C5CADF; max-width:540px; margin:0 0 32px;">Tell us where you are stuck — we'll take it from there.</p>
        <div style="display:flex; gap:16px;" data-m="ctas">
          <a href="https://calendly.com/cruxnxtiongroupofcompany-info" target="_blank" rel="noopener" style="background:#8C7AE6; color:#10142E !important; font-weight:700; font-size:15px; padding:17px 32px; --sl:10px;" class="bx">Book A Discovery Call →</a>
          <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:15px; padding:17px 32px; --sl:10px;" class="bx">Explore Events →</a>
        </div>
      </div>
      <div class="prefooter__badge" style="width:160px; height:160px; flex:0 0 160px;">
        <a href="https://calendly.com/cruxnxtiongroupofcompany-info" target="_blank" rel="noopener" class="prefooter__badge-link" aria-label="Book A Discovery Call" style="display:block; width:100%; height:100%; text-decoration:none; transition:transform .3s ease;">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/prefooter-badge-consultancy.svg' ); ?>" class="prefooter__badge-img" alt="Book A Discovery Call — spinning badge" style="width:100%; height:100%; object-fit:contain; animation:rc-spin 14s linear infinite; filter:drop-shadow(0 12px 28px rgba(0,0,0,0.5));">
        </a>
      </div>
    </div>
  </section>

  <!-- COLOSSAL FOOTER -->
  <footer id="contact" style="background:#10142E; padding:44px 24px 44px 24px; text-align:center; position:relative; overflow:hidden;">
    <div style="position:relative; margin-bottom:40px;">
      <span class="bebas" style="font-size:clamp(80px,17vw,220px); line-height:0.82; display:block; background:linear-gradient(180deg, #F2F1F8 0%, #B9AFF0 25%, #2A2F5C 65%, transparent 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; position:relative;">CRUX</span>
      <span class="bebas" style="font-size:clamp(30px,6.4vw,82px); line-height:1; display:block; background:linear-gradient(180deg, #F2F1F8 0%, #B9AFF0 25%, #2A2F5C 65%, transparent 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; position:relative; letter-spacing:0.5em; margin-top:10px; padding-left:0.5em;">NXTION</span>
    </div>
    <div style="display:flex; justify-content:center; align-items:center; flex-wrap:wrap; gap:32px; margin-bottom:32px;" data-m="wrap">
      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="font-size:14px; color:#9A9AC0;">Home</a>
      <a href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="font-size:14px; color:#9A9AC0;">Services</a>
      <a href="<?php echo esc_url( home_url( "/events/" ) ); ?>" style="font-size:14px; color:#9A9AC0;">Events</a>
      <a href="<?php echo esc_url( home_url( "/gallery/" ) ); ?>" style="font-size:14px; color:#9A9AC0;">Gallery</a>
      <a href="<?php echo esc_url( home_url( "/about/" ) ); ?>" style="font-size:14px; color:#9A9AC0;">About</a>
      <a href="<?php echo esc_url( home_url( "/faq/" ) ); ?>" style="font-size:14px; color:#9A9AC0;">FAQ</a>
      <a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" style="font-size:14px; color:#9A9AC0;">Blog</a>
      <a href="<?php echo esc_url( home_url( "/sponsors/" ) ); ?>" style="font-size:14px; color:#9A9AC0;">Sponsors</a>
    </div>
    <div style="display:flex; justify-content:center; gap:14px; margin-bottom:44px;" data-m="wrap">
      <a href="#" aria-label="Instagram" style="display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; background:rgba(242,241,248,0.05); color:#F2F1F8; --sl:7px; --bc:rgba(242,241,248,0.12);" class="bx"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" stroke="currentColor" stroke-width="1.5"></rect><circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5"></circle><circle cx="17.4" cy="6.6" r="1" fill="currentColor"></circle></svg></a>
      <a href="#" aria-label="TikTok" style="display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; background:rgba(242,241,248,0.05); color:#F2F1F8; --sl:7px; --bc:rgba(242,241,248,0.12);" class="bx"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M14 3v10.5a3.5 3.5 0 1 1-3-3.46" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path><path d="M14 3c.4 2.6 2.2 4.4 4.8 4.8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path></svg></a>
      <a href="#" aria-label="WhatsApp" style="display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; background:rgba(242,241,248,0.05); color:#F2F1F8; --sl:7px; --bc:rgba(242,241,248,0.12);" class="bx"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 20l1.4-4.1A8 8 0 1 1 9 19.5L4 20Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"></path><path d="M8.5 9.5c0 3.5 3 6.5 6.5 6.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path></svg></a>
    </div>
    <div style="display:flex; justify-content:center; flex-wrap:wrap; gap:8px 26px; margin-bottom:20px;" data-m="wrap">
      <a href="<?php echo esc_url( home_url( "/privacy-policy/" ) ); ?>" style="font-size:12.5px; color:#8E96BB;">Privacy Policy</a>
      <a href="<?php echo esc_url( home_url( "/cookie-policy/" ) ); ?>" style="font-size:12.5px; color:#8E96BB;">Cookie Policy</a>
      <a href="<?php echo esc_url( home_url( "/terms-conditions/" ) ); ?>" style="font-size:12.5px; color:#8E96BB;">Terms &amp; Conditions</a>
    </div>
    <div style="width:100%; max-width:900px; height:1px; background:#2A2F5C; margin:0 auto 24px;"></div>
    <p style="font-size:13px; color:#6E6E9A; margin:0px 0px 0px 0px;">&copy; <?php echo date( "Y" ); ?> Crux Nxtion Events • Sheffield, United Kingdom • All Rights Reserved</p>
  </footer>
  </div>

<div class="msw">
  <div style="background:rgba(255,255,255,0.96); border:1.5px solid #E1DEF3; box-shadow:0 12px 30px rgba(16,20,46,0.18); backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px); display:flex; padding:5px 6px; gap:6px;">
    <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="padding:11px 22px; font-size:13px; font-weight:700; color:#5A5F86; --sl:7px; --bc:#5A5F8655;" class="bx">Events</a>
    <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="padding:11px 22px; font-size:13px; font-weight:700; background:#8C7AE6; color:#0A0F26; --sl:7px;" class="bx">Consultancy</a>
  </div>
</div></div></div>





<script>
function prevSoundFamiliar() {
  var el = document.getElementById('soundFamiliarScroller');
  if (el) el.scrollBy({ left: -424, behavior: 'smooth' });
}
function nextSoundFamiliar() {
  var el = document.getElementById('soundFamiliarScroller');
  if (el) el.scrollBy({ left: 424, behavior: 'smooth' });
}
function selectPanel(el) {
  document.querySelectorAll('.consultancy-panels-container .cpanel').forEach(function(p) {
    p.classList.remove('active');
    p.style.flex = '1 1 0';
    var lbl = p.querySelector('.cpanel-label'); if (lbl) lbl.style.display = 'block';
    var bdy = p.querySelector('.cpanel-body'); if (bdy) bdy.style.display = 'none';
    var img = p.querySelector('img'); if (img) img.style.filter = 'brightness(0.5)';
    p.style.borderColor = '#E1DEF3';
  });
  el.classList.add('active');
  el.style.flex = '5 1 0';
  var lbl = el.querySelector('.cpanel-label'); if (lbl) lbl.style.display = 'none';
  var bdy = el.querySelector('.cpanel-body'); if (bdy) bdy.style.display = 'block';
  var img = el.querySelector('img'); if (img) img.style.filter = 'brightness(0.85)';
  el.style.borderColor = '#8C7AE6';
}
</script>
<?php wp_footer(); ?>
</body>
</html>
