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
  button {
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
    color: inherit;
    cursor: pointer;
    border: none;
    background: transparent;
    padding: 0;
    margin: 0;
    -webkit-appearance: none;
    appearance: none;
  }
  .float { animation: floaty 5s ease-in-out infinite; }
  .pulse-dot { animation: pulse 2s infinite; }
  a[style*="clip-path"]:active { transform: translateY(0) scale(.98); }
  body { background:#FFFFFF; color:#10142E; }
  .eyebrow { color:#6C58DB !important; }
  .ticket-stub::before, .ticket-stub::after { background:#FFFFFF !important; }

  /* Slanted Architecture (.bx) */
  .bx {
    position: relative;
    clip-path: polygon(var(--sl, 10px) 0, 100% 0, calc(100% - var(--sl, 10px)) 100%, 0 100%);
    border: 0 !important;
    border-radius: 0 !important;
    --bw: 1.5px;
    text-align: center;
    transition: transform .2s ease, filter .2s ease, background .2s ease, color .2s ease, box-shadow .2s ease;
  }
  .bx::before {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--bc, transparent);
    pointer-events: none;
    clip-path: polygon(evenodd,
      var(--sl, 10px) 0, 100% 0, calc(100% - var(--sl, 10px)) 100%, 0 100%,
      var(--sl, 10px) 0,
      calc(var(--sl, 10px) + var(--bw)) var(--bw),
      calc(100% - var(--bw)) var(--bw),
      calc(100% - var(--sl, 10px) - var(--bw)) calc(100% - var(--bw)),
      var(--bw) calc(100% - var(--bw)),
      calc(var(--sl, 10px) + var(--bw)) var(--bw),
      var(--sl, 10px) 0
    );
  }
  .bx:hover {
    filter: brightness(1.08);
    transform: translateY(-2px);
  }
  .bx:active {
    transform: translateY(0);
    filter: brightness(0.95);
  }

  /* Contact Mode Tabs */
  .contact-mode-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 24px;
  }
  .contact-tab-btn {
    font-family: 'Space Grotesk', system-ui, sans-serif !important;
    font-weight: 700 !important;
    font-size: 13.5px !important;
    letter-spacing: 0.2px !important;
    padding: 12px 22px !important;
    --sl: 8px !important;
    cursor: pointer !important;
    background: #F3F1FC !important;
    color: #4A5073 !important;
    --bc: #DCD7F5 !important;
    --bw: 1.5px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    user-select: none;
    border: none !important;
    outline: none !important;
  }
  .contact-tab-btn:hover {
    background: #E8E4F8 !important;
    color: #10142E !important;
    --bc: #C8BFF0 !important;
    transform: translateY(-2px) !important;
  }
  .contact-tab-btn[data-tab="events"].active {
    background: #002671 !important;
    color: #FFFFFF !important;
    --bc: #002671 !important;
    box-shadow: 0 4px 14px rgba(0, 38, 113, 0.28) !important;
  }
  .contact-tab-btn[data-tab="consultancy"].active {
    background: #8C7AE6 !important;
    color: #10142E !important;
    --bc: #8C7AE6 !important;
    box-shadow: 0 4px 14px rgba(140, 122, 230, 0.35) !important;
  }
  .contact-tab-btn[data-tab="partner"].active {
    background: #BA0000 !important;
    color: #FFFFFF !important;
    --bc: #BA0000 !important;
    box-shadow: 0 4px 14px rgba(186, 0, 0, 0.28) !important;
  }

  /* Dynamic Service Chips */
  .chips-group {
    display: flex;
    gap: 9px;
    flex-wrap: wrap;
  }
  .chip-btn {
    font-family: 'Space Grotesk', system-ui, sans-serif !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 7px !important;
    padding: 9px 16px !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    cursor: pointer !important;
    --sl: 6px !important;
    --bw: 1px !important;
    background: #F4F3FA !important;
    color: #4A5073 !important;
    --bc: #E1DEF3 !important;
    user-select: none;
    border: none !important;
    outline: none !important;
  }
  .chip-btn:hover {
    background: #ECE9F7 !important;
    color: #10142E !important;
    --bc: #D2CBF2 !important;
    transform: translateY(-1.5px) !important;
  }
  .chip-icon {
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 800;
    line-height: 1;
    width: 13px;
    height: 13px;
    margin-right: 2px;
  }
  .chip-btn.selected {
    transform: translateY(-1px) !important;
  }
  .chip-btn.selected .chip-icon {
    display: inline-flex !important;
  }
  .chip-btn[data-cat="e"].selected {
    background: #002671 !important;
    color: #FFFFFF !important;
    --bc: #002671 !important;
    box-shadow: 0 3px 10px rgba(0, 38, 113, 0.25) !important;
  }
  .chip-btn[data-cat="c"].selected {
    background: #8C7AE6 !important;
    color: #10142E !important;
    --bc: #8C7AE6 !important;
    box-shadow: 0 3px 10px rgba(140, 122, 230, 0.3) !important;
  }
  .chip-btn[data-cat="p"].selected {
    background: #BA0000 !important;
    color: #FFFFFF !important;
    --bc: #BA0000 !important;
    box-shadow: 0 3px 10px rgba(186, 0, 0, 0.25) !important;
  }

  /* Submit Brief Button */
  #btn-submit-brief {
    font-family: 'Space Grotesk', system-ui, sans-serif !important;
    font-weight: 700 !important;
    letter-spacing: 0.4px !important;
    text-transform: uppercase !important;
    font-size: 14px !important;
    outline: none !important;
    box-shadow: 0 4px 16px rgba(0, 38, 113, 0.2);
    transition: transform .2s ease, filter .2s ease, background .25s ease, box-shadow .2s ease !important;
  }
  #btn-submit-brief:hover {
    filter: brightness(1.1) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 24px rgba(0, 38, 113, 0.3) !important;
  }
  #btn-submit-brief:active {
    transform: translateY(0) !important;
    filter: brightness(0.95) !important;
  }

  /* Form Inputs Focus & Error Shake */
  #crux-intake-form input:focus,
  #crux-intake-form textarea:focus {
    border-color: #6C58DB !important;
    outline: none !important;
    box-shadow: 0 0 0 3px rgba(108, 88, 219, 0.15) !important;
  }
  @keyframes inputShake {
    0%, 100% { transform: translateX(0); }
    20%, 60% { transform: translateX(-6px); }
    40%, 80% { transform: translateX(6px); }
  }
  .input-error-shake {
    animation: inputShake 0.4s ease !important;
    border-color: #E5383B !important;
    box-shadow: 0 0 0 3px rgba(229, 56, 59, 0.15) !important;
  }

  /* Loading Spinner */
  .crux-spinner {
    display: inline-block;
    width: 14px;
    height: 14px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: #FFFFFF;
    animation: rc-spin 0.6s linear infinite;
    margin-right: 8px;
    vertical-align: middle;
  }
  .crux-spinner--dark {
    border-color: rgba(16, 20, 46, 0.25);
    border-top-color: #10142E;
  }

  /* Modal Buttons */
  #btn-modal-close:hover {
    background: #E4E0F7 !important;
    transform: scale(1.08);
  }
  #btn-modal-done:hover,
  #btn-modal-reset:hover,
  #btn-modal-calendly:hover {
    filter: brightness(1.1) !important;
    transform: translateY(-2px) !important;
  }

  /* Bottom Sticky Consultancy Booking Button - Perfectly Centered Sitewide */
  .contact-sticky-booking {
    position: fixed !important;
    bottom: 24px !important;
    left: 0 !important;
    right: 0 !important;
    width: 100% !important;
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    z-index: 990 !important;
    pointer-events: none !important;
    transition: transform .25s ease, opacity .25s ease;
  }
  .contact-sticky-booking .crux-sw-pod {
    margin: 0 auto !important;
    pointer-events: auto !important;
    transition: transform .2s ease, filter .2s ease;
  }
  .contact-sticky-booking .crux-sw-pod:hover {
    transform: translateY(-2px);
    filter: brightness(1.08);
  }
  .contact-sticky-booking-btn:hover {
    background: #9D8DF0 !important;
  }
  .contact-sticky-booking-btn:active {
    transform: translateY(0);
    filter: brightness(0.95);
  }

  /* Small Mobile Tabs Stack */
  @media (max-width: 600px) {
    .contact-mode-tabs {
      flex-direction: column !important;
      gap: 8px !important;
    }
    .contact-tab-btn {
      width: 100% !important;
      box-sizing: border-box !important;
      justify-content: center !important;
    }
  }

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
  .mega-panel a.mrow:hover { transform: translateX(4px); background: rgba(140, 122, 230, 0.08) !important; }

  /* Desktop Viewport (> 900px) */
  @media (min-width: 901px) {
    header { min-height: 80px !important;
      padding: 14px 64px !important; }
    header > nav { display: flex !important; }
    header > .header-desktop-actions { display: flex !important; }
    .mnav-btn, .crux-mnav-btn { display: none !important; }
    .mdrawer { display: none !important; }
  }

  /* Mobile Viewport (<= 900px) */
  @media (max-width: 900px) {
    [data-m~="root"] > section:first-of-type, section[data-m~="g1"]:first-of-type, [data-m~="hero"] {
      grid-template-columns: 1fr !important;
      padding-top: 74px !important;
      padding-bottom: 56px !important;
      padding-left: 20px !important;
      padding-right: 20px !important;
      min-height: 0 !important;
      gap: 36px !important;
    }
    [data-m~="root"] > section:first-of-type > div:first-child {
      padding: 0 !important;
    }
    [data-m~="root"] > section:first-of-type > div:nth-child(2) {
      min-height: 420px !important;
      border-radius: 16px;
      overflow: hidden;
    }
    [data-m~="root"] > section:first-of-type > div:nth-child(2) > div:last-child {
      padding: 32px 20px !important;
    }
    [data-m~="g1"] {
      grid-template-columns: 1fr !important;
      gap: 12px !important;
    }
    [data-m~="root"] > section:nth-of-type(2) {
      padding: 60px 20px !important;
      min-height: 0 !important;
    }
    [data-m~="root"] > section:nth-of-type(2) > div:nth-of-type(2) {
      grid-template-columns: 1fr !important;
    }
    [data-m~="prefooter-inner"] {
      padding: 40px 20px !important;
      flex-direction: column !important;
      align-items: flex-start !important;
    }
    [data-m~="ctas"] {
      flex-direction: column !important;
      width: 100% !important;
    }
    [data-m~="ctas"] a {
      width: 100% !important;
      box-sizing: border-box !important;
    }
    .contact-sticky-booking {
      bottom: 20px !important;
      left: 0 !important;
      right: 0 !important;
      width: 100% !important;
      justify-content: center !important;
      align-items: center !important;
      padding: 0 16px !important;
      box-sizing: border-box !important;
    }
    .contact-sticky-booking-btn {
      padding: 10px 18px !important;
      font-size: 12px !important;
    }
    header { padding: 10px 20px !important; }
    header > nav { display: none !important; }
    header > .header-desktop-actions { display: none !important; }
    .mnav-btn, .crux-mnav-btn { display: flex !important; }
    input.mnav { display: none; }
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
      padding: 10px 0 10px 14px;
      font-size: 15px;
      text-decoration: none;
    }
  }

  /* Contact Confirmation Popup Modal Animations */
  @keyframes cruxModalFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  @keyframes cruxModalScaleIn {
    from { opacity: 0; transform: scale(0.92) translateY(16px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
  }
  .crux-modal-backdrop {
    animation: cruxModalFadeIn 0.25s ease both;
  }
  .crux-modal-card {
    animation: cruxModalScaleIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) both;
  }
  @keyframes strokeCircle {
    from { stroke-dashoffset: 220; }
    to { stroke-dashoffset: 0; }
  }
  @keyframes strokeCheck {
    from { stroke-dashoffset: 50; }
    to { stroke-dashoffset: 0; }
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

  <?php get_template_part( 'parts/site-header', null, array( 'skin' => 'light', 'nav' => 'events', 'wing' => 'events', 'active' => 'contact' ) ); ?>

  <!-- 1 CONTACT -->
  <section style="min-height:860px; display:grid; grid-template-columns:1fr 1fr;">
    <div style="padding:80px 64px;" class="reveal">
      <span class="eyebrow"><?php echo crux_h( 'contact', 'contact_small_heading_1' ); ?></span>
      <h1 class="bebas" style="font-size:72px; margin:14px 0 26px; color:#10142E;"><?php echo crux_h( 'contact', 'contact_heading_1' ); ?></h1>
      <!-- INTAKE TABS (Slanted .bx - Click multiple to brief all together) -->
      <div class="contact-mode-tabs" id="contact-mode-tabs" role="tablist">
        <button type="button" class="contact-tab-btn bx active" data-tab="events" role="tab" aria-selected="true"><?php echo crux_h( 'contact', 'contact_button_1' ); ?></button>
        <button type="button" class="contact-tab-btn bx" data-tab="consultancy" role="tab" aria-selected="false">Business Strategy</button>
        <button type="button" class="contact-tab-btn bx" data-tab="partner" role="tab" aria-selected="false">Sponsorship &amp; Partnership</button>
      </div>

      <form id="crux-intake-form" onsubmit="event.preventDefault(); return false;" style="display:flex; flex-direction:column; gap:16px; max-width:560px;">
        <input type="hidden" name="inquiry_type" id="inquiry_type" value="events">
        <input type="hidden" name="form_timestamp" value="<?php echo time(); ?>">
        <div id="hidden-services-inputs"></div>
        <div style="display:none;"><input type="text" name="crux_hp" value=""></div>

        <!-- Alert messages box -->
        <div id="contact-alert-box" style="display:none; padding:14px 18px; border-radius:12px; font-size:14px; font-weight:600; line-height:1.5;"></div>
        
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;" data-m="g1">
          <div>
            <input type="text" name="name" id="inp-name" required placeholder="Your full name *" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
          </div>
          <div>
            <input type="email" name="email" id="inp-email" required placeholder="Email address *" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
          </div>
        </div>

        <input type="tel" name="phone" id="inp-phone" placeholder="Phone number (optional)" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">

        <!-- Dynamic Service Chips Section -->
        <div>
          <div id="chips-section-title" style="font-size:12px; font-weight:700; letter-spacing:1.6px; text-transform:uppercase; color:#5A5F86; margin-bottom:12px;">
            What do you need help with? <span style="text-transform:none; letter-spacing:0; font-weight:500;">Select any that fit:</span>
          </div>

          <!-- Group 1: Events Chips -->
          <div id="chips-group-events" class="chips-group" style="display:flex; gap:9px; flex-wrap:wrap;">
            <button type="button" class="chip-btn bx" data-cat="e" data-name="Event planning" aria-pressed="false"><span class="chip-icon">✓</span><span>Event planning</span></button>
            <button type="button" class="chip-btn bx" data-cat="e" data-name="Entertainment & talent" aria-pressed="false"><span class="chip-icon">✓</span><span>Entertainment &amp; talent</span></button>
            <button type="button" class="chip-btn bx" data-cat="e" data-name="Design & production" aria-pressed="false"><span class="chip-icon">✓</span><span>Design &amp; production</span></button>
            <button type="button" class="chip-btn bx" data-cat="e" data-name="Marketing & promotion" aria-pressed="false"><span class="chip-icon">✓</span><span>Marketing &amp; promotion</span></button>
            <button type="button" class="chip-btn bx" data-cat="e" data-name="On-site coordination" aria-pressed="false"><span class="chip-icon">✓</span><span>On-site coordination</span></button>
          </div>

          <!-- Group 2: Consultancy Chips -->
          <div id="chips-group-consultancy" class="chips-group" style="display:none; gap:9px; flex-wrap:wrap;">
            <button type="button" class="chip-btn bx" data-cat="c" data-name="Business setup & strategy" aria-pressed="false"><span class="chip-icon">✓</span><span>Business setup &amp; strategy</span></button>
            <button type="button" class="chip-btn bx" data-cat="c" data-name="Branding & marketing" aria-pressed="false"><span class="chip-icon">✓</span><span>Branding &amp; marketing</span></button>
            <button type="button" class="chip-btn bx" data-cat="c" data-name="Business growth" aria-pressed="false"><span class="chip-icon">✓</span><span>Business growth</span></button>
            <button type="button" class="chip-btn bx" data-cat="c" data-name="Activation growth" aria-pressed="false"><span class="chip-icon">✓</span><span>Activation growth</span></button>
            <button type="button" class="chip-btn bx" data-cat="c" data-name="Audit & advisory" aria-pressed="false"><span class="chip-icon">✓</span><span>Audit &amp; advisory</span></button>
          </div>

          <!-- Group 3: Partner Chips -->
          <div id="chips-group-partner" class="chips-group" style="display:none; gap:9px; flex-wrap:wrap;">
            <button type="button" class="chip-btn bx" data-cat="p" data-name="Event sponsorship" aria-pressed="false"><span class="chip-icon">✓</span><span>Event sponsorship</span></button>
            <button type="button" class="chip-btn bx" data-cat="p" data-name="Brand activation partner" aria-pressed="false"><span class="chip-icon">✓</span><span>Brand activation partner</span></button>
            <button type="button" class="chip-btn bx" data-cat="p" data-name="Vendor & catering partner" aria-pressed="false"><span class="chip-icon">✓</span><span>Vendor &amp; catering partner</span></button>
            <button type="button" class="chip-btn bx" data-cat="p" data-name="Media & talent collaboration" aria-pressed="false"><span class="chip-icon">✓</span><span>Media &amp; talent collaboration</span></button>
          </div>
        </div>

        <!-- Panel 1: Event Details -->
        <div id="panel-event-details" class="intake-panel" style="display:flex; flex-direction:column; gap:12px; padding:20px; border:1.5px solid #D6DDF3; clip-path:polygon(10px 0, 100% 0, calc(100% - 10px) 100%, 0 100%); background:#F6F8FE;">
          <span class="bx" style="display:inline-block; font-size:11px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:#FFFFFF; background:#002671; padding:4px 12px; width:fit-content; --sl:5px;">About your event</span>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" data-m="g1">
            <input type="text" name="ev_type" placeholder="Event type (wedding, gala, party...)" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
            <input type="text" name="ev_date" placeholder="Preferred date / month" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
          </div>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" data-m="g1">
            <input type="text" name="ev_guests" placeholder="Approx. number of guests" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
            <input type="text" name="ev_venue" placeholder="City or prospective venue" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
          </div>
        </div>

        <!-- Panel 2: Business Details -->
        <div id="panel-business-details" class="intake-panel" style="display:none; flex-direction:column; gap:12px; padding:20px; border:1.5px solid #E1DEF3; clip-path:polygon(10px 0, 100% 0, calc(100% - 10px) 100%, 0 100%); background:#F7F5FE;">
          <span class="bx" style="display:inline-block; font-size:11px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:#10142E; background:#8C7AE6; padding:4px 12px; width:fit-content; --sl:5px;">About your business</span>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" data-m="g1">
            <input type="text" name="biz_name" placeholder="Business name (if trading)" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
            <input type="text" name="biz_stage" placeholder="Stage: idea / trading / scaling" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
          </div>
        </div>

        <!-- Panel 3: Partnership Details -->
        <div id="panel-partner-details" class="intake-panel" style="display:none; flex-direction:column; gap:12px; padding:20px; border:1.5px solid #F5C6C6; clip-path:polygon(10px 0, 100% 0, calc(100% - 10px) 100%, 0 100%); background:#FFF7F7;">
          <span class="bx" style="display:inline-block; font-size:11px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:#FFFFFF; background:#BA0000; padding:4px 12px; width:fit-content; --sl:5px;">Sponsorship &amp; Collaboration</span>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" data-m="g1">
            <input type="text" name="partner_company" placeholder="Brand / Organization name" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
            <input type="text" name="partner_interest" placeholder="Interest: Sponsor / Vendor / Co-Host" style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;">
          </div>
        </div>

        <textarea name="message" id="inp-message" rows="4" placeholder="Tell us what you have in mind, where you are stuck, or what you would like to achieve." style="width:100%; font-family:'Space Grotesk',sans-serif; font-size:14px; padding:15px 18px; border:1.5px solid #E1DEF3; border-radius:12px; background:#FFFFFF; color:#10142E; box-sizing:border-box;"></textarea>
        
        <p id="route-note-label" class="routeNote" style="font-size:12.5px; color:#5A5F86; margin:0; line-height:1.5;">
          Direct connection: This goes straight to our events crew. We respond within 24 business hours.
        </p>

        <button type="button" id="btn-submit-brief" style="display:flex; align-items:center; justify-content:center; text-align:center; background:#002671; color:#FFFFFF; font-weight:700; font-size:15px; padding:17px; margin-top:6px; --sl:10px; cursor:pointer; width:100%;" class="bx">Submit</button>
      </form>

      <!-- CONTACT CONFIRMATION POPUP MODAL (Executive Dialog) -->
      <div id="contact-confirmation-modal" class="crux-modal-backdrop" style="display:none; position:fixed; inset:0; z-index:100000; background:rgba(10,15,38,0.85); backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px); align-items:center; justify-content:center; padding:20px; box-sizing:border-box;">
        <div class="crux-modal-card" style="background:#FFFFFF; border:2px solid #002671; border-radius:18px; max-width:540px; width:100%; padding:44px 36px 40px; text-align:center; position:relative; box-shadow:0 30px 80px rgba(0,38,113,0.35); box-sizing:border-box;">
          
          <!-- Close icon button -->
          <button type="button" id="btn-modal-close" style="position:absolute; top:18px; right:18px; width:36px; height:36px; border-radius:50%; background:#F3F1FC; border:1px solid #D2CEEA; color:#10142E; font-size:22px; line-height:1; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:transform .2s ease, background .2s ease;" aria-label="Close dialog">&times;</button>
          
          <!-- Animated SVG Success Badge -->
          <div style="width:76px; height:76px; margin:0 auto 20px; display:flex; align-items:center; justify-content:center;">
            <svg class="crux-modal-check-svg" width="76" height="76" viewBox="0 0 76 76" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="38" cy="38" r="35" stroke="#27AE60" stroke-width="4" stroke-linecap="round" class="crux-circle-animate" style="stroke-dasharray: 220; stroke-dashoffset: 0; animation: strokeCircle 0.6s ease forwards; fill: rgba(39,174,96,0.08);"/>
              <path d="M23 38.5L33 48.5L53 28.5" stroke="#27AE60" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" class="crux-check-animate" style="stroke-dasharray: 50; stroke-dashoffset: 0; animation: strokeCheck 0.4s ease 0.45s forwards;"/>
            </svg>
          </div>

          <h2 class="bebas" style="font-size:42px; color:#10142E; margin:0 0 10px; letter-spacing:0.5px; line-height:0.95;"><?php echo crux_h( 'contact', 'contact_heading_2' ); ?></h2>
          
          <div id="confirm-summary-badge" class="bx" style="display:inline-block; background:#E8EFFD; --sl:6px; --bc:#C4D3F8; padding:8px 20px; font-size:12.5px; font-weight:700; color:#002671; margin-bottom:18px;"><?php echo crux_h( 'contact', 'contact_text_1' ); ?></div>

          <p id="confirm-msg-body" style="font-size:15px; line-height:1.65; color:#3A3F66; margin:0 0 28px;"><?php echo crux_h( 'contact', 'contact_paragraph_1' ); ?></p>
          
          <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
            <a href="<?php echo esc_url( crux_opt( 'calendly_url' ) ); ?>" id="btn-modal-calendly" target="_blank" rel="noopener" style="display:none; background:#8C7AE6; color:#10142E !important; font-weight:700; font-size:13.5px; padding:13px 22px; --sl:8px; text-decoration:none;" class="bx"><?php echo crux_h( 'contact', 'contact_button_2' ); ?></a>
            <button type="button" id="btn-modal-done" style="background:#002671; color:#FFFFFF; font-weight:700; font-size:13.5px; padding:13px 26px; --sl:8px; cursor:pointer;" class="bx"><?php echo crux_h( 'contact', 'contact_button_3' ); ?></button>
            <button type="button" id="btn-modal-reset" style="background:#8C7AE6; color:#10142E; font-weight:700; font-size:13.5px; padding:13px 24px; --sl:8px; cursor:pointer;" class="bx"><?php echo crux_h( 'contact', 'contact_button_4' ); ?></button>
          </div>

        </div>
      </div>
    </div>
    <div style="position:relative; overflow:hidden;" class="reveal">
      <img src="<?php echo crux_get_blob_url( "4170d6b6009c07e37d83bae48a68917b" ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;" class="drift">
      <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.92) 0%, rgba(16,20,46,0.25) 70%);"></div>
      <div style="position:relative; height:100%; display:flex; flex-direction:column; justify-content:flex-end; padding:56px; gap:12px;">
        <div style="display:flex; align-items:center; gap:12px; background:rgba(16,20,46,0.96) !important; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); padding:11px 22px 11px 12px; width:fit-content; --sl:6px; --bc:#3A3F72;" class="bx"><span style="width:32px; height:32px; border-radius:50%; background:#8C7AE6; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:800; color:#10142E;">✆</span><span style="font-size:13px; font-weight:600; color:#F2F1F8;"><?php echo esc_html( crux_opt( 'phone_events' ) ); ?></span></div><div style="display:flex; align-items:center; gap:12px; background:rgba(16,20,46,0.96) !important; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); padding:11px 22px 11px 12px; width:fit-content; --sl:6px; --bc:#3A3F72;" class="bx"><span style="width:32px; height:32px; border-radius:50%; background:#8C7AE6; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:800; color:#10142E;">✆</span><span style="font-size:13px; font-weight:600; color:#F2F1F8;"><?php echo esc_html( crux_opt( 'phone_consult' ) ); ?></span></div><div style="display:flex; align-items:center; gap:12px; background:rgba(16,20,46,0.96) !important; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); padding:11px 22px 11px 12px; width:fit-content; --sl:6px; --bc:#3A3F72;" class="bx"><span style="width:32px; height:32px; border-radius:50%; background:#8C7AE6; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:800; color:#10142E;">@</span><?php $c_mail = crux_opt( 'email' ); ?><a href="<?php echo esc_url( 'mailto:' . antispambot( $c_mail ) ); ?>" style="font-size:13px; font-weight:600; color:#F2F1F8; text-decoration:none;"><?php echo esc_html( antispambot( $c_mail ) ); ?></a></div><div style="display:flex; align-items:center; gap:12px; background:rgba(16,20,46,0.96) !important; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); padding:11px 22px 11px 12px; width:fit-content; --sl:6px; --bc:#3A3F72;" class="bx"><span style="width:32px; height:32px; border-radius:50%; background:#8C7AE6; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:800; color:#10142E;">●</span><span style="font-size:13px; font-weight:600; color:#F2F1F8;"><?php echo esc_html( crux_address( false ) ); ?></span></div>
        <a href="#" style="color:#F2F1F8; font-weight:700; font-size:13px; border-bottom:1.5px solid #8C7AE6; padding-bottom:2px; width:fit-content; margin-top:6px;"><?php echo crux_h( 'contact', 'contact_link_1' ); ?></a>
      </div>
    </div>
  </section>

  <!-- 2 NEXT -->
  <section style="min-height:640px; padding:100px 64px; background:#F3F1FC;">
    <div style="text-align:center; margin-bottom:50px;" class="reveal"><span class="eyebrow"><?php echo crux_h( 'contact', 'next_small_heading_1' ); ?></span><h2 class="bebas" style="font-size:56px; margin:12px 0 0; color:#10142E;"><?php echo crux_h( 'contact', 'next_heading_1' ); ?></h2></div>
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:20px;" class="reveal"><div class="bento-tile reveal" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:22px; padding:34px 30px; min-height:240px; display:flex; flex-direction:column; justify-content:space-between;"><span class="bebas" style="font-size:64px; color:#6C58DB; line-height:0.9;">01</span><div><h3 class="bebas" style="font-size:30px; margin:0 0 8px; color:#10142E;"><?php echo crux_h( 'contact', 'next_heading_2' ); ?></h3><p style="font-size:14px; line-height:1.65; color:#3A3F66; margin:0;"><?php echo crux_h( 'contact', 'next_paragraph_1' ); ?></p></div></div><div class="bento-tile reveal" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:22px; padding:34px 30px; min-height:240px; display:flex; flex-direction:column; justify-content:space-between;"><span class="bebas" style="font-size:64px; color:#6C58DB; line-height:0.9;">02</span><div><h3 class="bebas" style="font-size:30px; margin:0 0 8px; color:#10142E;"><?php echo crux_h( 'contact', 'next_heading_3' ); ?></h3><p style="font-size:14px; line-height:1.65; color:#3A3F66; margin:0;"><?php echo crux_h( 'contact', 'next_paragraph_2' ); ?></p></div></div><div class="bento-tile reveal" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:22px; padding:34px 30px; min-height:240px; display:flex; flex-direction:column; justify-content:space-between;"><span class="bebas" style="font-size:64px; color:#6C58DB; line-height:0.9;">03</span><div><h3 class="bebas" style="font-size:30px; margin:0 0 8px; color:#10142E;"><?php echo crux_h( 'contact', 'next_heading_4' ); ?></h3><p style="font-size:14px; line-height:1.65; color:#3A3F66; margin:0;"><?php echo crux_h( 'contact', 'next_paragraph_3' ); ?></p></div></div></div>
  </section>


  <div style="background:#10142E;">
  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'light', 'prefooter' => 'events-light', 'wing' => 'events', 'pad' => '90px 24px 44px' ) ); ?>
  </div>

</div>





<script>
(function() {
  function initCruxContactEngine() {
    var tabsContainer = document.getElementById('contact-mode-tabs');
    var contactForm = document.getElementById('crux-intake-form');
    if (!tabsContainer || !contactForm) return;
    if (contactForm.getAttribute('data-engine-ready') === 'true') return;
    contactForm.setAttribute('data-engine-ready', 'true');

    var tabButtons = tabsContainer.querySelectorAll('.contact-tab-btn');
    var groupEvents = document.getElementById('chips-group-events');
    var groupConsultancy = document.getElementById('chips-group-consultancy');
    var groupPartner = document.getElementById('chips-group-partner');

    var panelEvents = document.getElementById('panel-event-details');
    var panelConsultancy = document.getElementById('panel-business-details');
    var panelPartner = document.getElementById('panel-partner-details');

    var typeInput = document.getElementById('inquiry_type');
    var hiddenServices = document.getElementById('hidden-services-inputs');
    var routeNote = document.getElementById('route-note-label');
    var submitBtn = document.getElementById('btn-submit-brief');
    var confirmModal = document.getElementById('contact-confirmation-modal');
    var confirmBadge = document.getElementById('confirm-summary-badge');
    var confirmBody = document.getElementById('confirm-msg-body');
    var modalCloseBtn = document.getElementById('btn-modal-close');
    var modalDoneBtn = document.getElementById('btn-modal-done');
    var modalResetBtn = document.getElementById('btn-modal-reset');

    var nameInput = document.getElementById('inp-name');
    var emailInput = document.getElementById('inp-email');
    var alertBox = document.getElementById('contact-alert-box');

    // Tab brief state: array of selected wings (allows clean switching and multi-service selection)
    var activeTabs = ['events'];

    function updateTabsUI() {
      // 1. Update tab buttons
      tabButtons.forEach(function(btn) {
        var t = btn.getAttribute('data-tab');
        if (activeTabs.indexOf(t) !== -1) {
          btn.classList.add('active');
          btn.setAttribute('aria-selected', 'true');
        } else {
          btn.classList.remove('active');
          btn.setAttribute('aria-selected', 'false');
        }
      });

      // 2. Show/Hide chip groups
      var hasEvents = activeTabs.indexOf('events') !== -1;
      var hasConsultancy = activeTabs.indexOf('consultancy') !== -1;
      var hasPartner = activeTabs.indexOf('partner') !== -1;

      if (groupEvents) groupEvents.style.display = hasEvents ? 'flex' : 'none';
      if (groupConsultancy) groupConsultancy.style.display = hasConsultancy ? 'flex' : 'none';
      if (groupPartner) groupPartner.style.display = hasPartner ? 'flex' : 'none';

      // 3. Show/Hide detail panels
      if (panelEvents) panelEvents.style.display = hasEvents ? 'flex' : 'none';
      if (panelConsultancy) panelConsultancy.style.display = hasConsultancy ? 'flex' : 'none';
      if (panelPartner) panelPartner.style.display = hasPartner ? 'flex' : 'none';

      // 4. Update route note & button styling
      if (activeTabs.length === 3) {
        if (routeNote) routeNote.textContent = 'Direct connection: Your multi-wing brief will be transmitted directly to our events, business consultancy, and partnership teams. We respond within 24 business hours.';
        if (submitBtn) {
          submitBtn.style.background = '#002671';
          submitBtn.style.color = '#FFFFFF';
        }
      } else if (hasEvents && hasConsultancy) {
        if (routeNote) routeNote.textContent = 'Direct connection: This brief connects directly with both our events and business strategy leads. We respond within 24 business hours.';
        if (submitBtn) {
          submitBtn.style.background = '#002671';
          submitBtn.style.color = '#FFFFFF';
        }
      } else if (hasEvents && hasPartner) {
        if (routeNote) routeNote.textContent = 'Direct connection: This brief connects directly with our events and partnership leads. We respond within 24 business hours.';
        if (submitBtn) {
          submitBtn.style.background = '#002671';
          submitBtn.style.color = '#FFFFFF';
        }
      } else if (hasConsultancy && hasPartner) {
        if (routeNote) routeNote.textContent = 'Direct connection: This brief connects directly with our business consultancy and partnership leads. We respond within 24 business hours.';
        if (submitBtn) {
          submitBtn.style.background = '#8C7AE6';
          submitBtn.style.color = '#10142E';
        }
      } else if (hasEvents) {
        if (routeNote) routeNote.textContent = 'Direct connection: This goes straight to our events crew. We respond within 24 business hours.';
        if (submitBtn) {
          submitBtn.style.background = '#002671';
          submitBtn.style.color = '#FFFFFF';
        }
      } else if (hasConsultancy) {
        if (routeNote) routeNote.textContent = 'Direct connection: This goes straight to our consultancy & business advisory team. We respond within 24 business hours.';
        if (submitBtn) {
          submitBtn.style.background = '#8C7AE6';
          submitBtn.style.color = '#10142E';
        }
      } else if (hasPartner) {
        if (routeNote) routeNote.textContent = 'Direct connection: This goes straight to our executive partnerships & sponsorship team. We respond within 24 business hours.';
        if (submitBtn) {
          submitBtn.style.background = '#BA0000';
          submitBtn.style.color = '#FFFFFF';
        }
      }

      // Ensure button text is strictly Submit
      if (submitBtn && submitBtn.textContent !== 'Submitting...') {
        submitBtn.textContent = 'Submit';
      }

      syncServicesAndTabsInputs();
    }

    function selectTab(tabName) {
      activeTabs = [tabName];
      updateTabsUI();
    }

    function syncServicesAndTabsInputs() {
      if (!hiddenServices) return;
      hiddenServices.innerHTML = '';

      // Determine active wings based on active tabs, selected chips, and filled fields
      var effectiveTabs = [].concat(activeTabs);
      var allSelectedChips = document.querySelectorAll('.chip-btn.selected');

      allSelectedChips.forEach(function(chip) {
        var cat = chip.getAttribute('data-cat');
        if (cat === 'e' && effectiveTabs.indexOf('events') === -1) effectiveTabs.push('events');
        if (cat === 'c' && effectiveTabs.indexOf('consultancy') === -1) effectiveTabs.push('consultancy');
        if (cat === 'p' && effectiveTabs.indexOf('partner') === -1) effectiveTabs.push('partner');
      });

      // 1. Synchronize selected_tabs[]
      effectiveTabs.forEach(function(t) {
        var tInput = document.createElement('input');
        tInput.type = 'hidden';
        tInput.name = 'selected_tabs[]';
        tInput.value = t;
        hiddenServices.appendChild(tInput);
      });

      // 2. Synchronize inquiry_type
      if (typeInput) {
        if (effectiveTabs.length === 3) {
          typeInput.value = 'all';
        } else if (effectiveTabs.length === 2) {
          if (effectiveTabs.indexOf('events') !== -1 && effectiveTabs.indexOf('consultancy') !== -1) {
            typeInput.value = 'both';
          } else {
            typeInput.value = effectiveTabs.join(',');
          }
        } else {
          typeInput.value = effectiveTabs[0] || 'events';
        }
      }

      // 3. Synchronize service chips across ALL groups
      allSelectedChips.forEach(function(chip) {
        var sName = chip.getAttribute('data-name');
        if (sName) {
          var sInput = document.createElement('input');
          sInput.type = 'hidden';
          sInput.name = 'services[]';
          sInput.value = sName;
          hiddenServices.appendChild(sInput);
        }
      });
    }

    // Tab buttons click handler (switch active wing)
    tabButtons.forEach(function(btn) {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        var tab = this.getAttribute('data-tab');
        if (tab) selectTab(tab);
      });
    });

    // Chip click handlers (multi-select)
    var allChips = document.querySelectorAll('.chip-btn');
    allChips.forEach(function(chip) {
      chip.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.toggle('selected');
        this.setAttribute('aria-pressed', this.classList.contains('selected') ? 'true' : 'false');
        syncServicesAndTabsInputs();
      });
    });

    // Handle initial state from URL query or hash
    var searchParams = new URLSearchParams(window.location.search);
    var qType = (searchParams.get('type') || '').toLowerCase();
    var hash = (window.location.hash || '').toLowerCase();

    if (qType === 'consultancy' || qType === 'business' || hash.indexOf('consultancy') !== -1 || hash.indexOf('business') !== -1) {
      activeTabs = ['consultancy'];
    } else if (qType === 'partner' || qType === 'sponsorship' || qType === 'sponsor' || hash.indexOf('partner') !== -1 || hash.indexOf('sponsor') !== -1) {
      activeTabs = ['partner'];
    } else {
      activeTabs = ['events'];
    }
    updateTabsUI();

    function showAlert(msg, isError) {
      if (!alertBox) return;
      alertBox.textContent = msg;
      alertBox.style.display = 'block';
      if (isError) {
        alertBox.style.background = '#FFF0F0';
        alertBox.style.border = '1.5px solid #E5383B';
        alertBox.style.color = '#BA0000';
      } else {
        alertBox.style.background = '#E8F8F0';
        alertBox.style.border = '1.5px solid #27AE60';
        alertBox.style.color = '#10142E';
      }
      alertBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function hideAlert() {
      if (alertBox) alertBox.style.display = 'none';
    }

    function triggerShake(el) {
      if (!el) return;
      el.classList.add('input-error-shake');
      setTimeout(function() {
        el.classList.remove('input-error-shake');
      }, 500);
      el.focus();
    }

    // Submit handler
    function doSubmit() {
      hideAlert();

      if (!nameInput || !nameInput.value.trim()) {
        showAlert('Please provide your name so we know who to address.', true);
        triggerShake(nameInput);
        return;
      }

      if (!emailInput || !emailInput.value.trim() || !emailInput.value.includes('@')) {
        showAlert('Please provide a valid email address so we can reply to you.', true);
        triggerShake(emailInput);
        return;
      }

      // Check honeypot
      var hp = contactForm.querySelector('input[name="crux_hp"]');
      if (hp && hp.value.trim()) {
        return; // Spambot silently ignored
      }

      // Loading state
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.style.pointerEvents = 'none';
        submitBtn.style.opacity = '0.75';
        var isDarkText = (activeTabs.length === 1 && activeTabs[0] === 'consultancy');
        var spinnerClass = isDarkText ? 'crux-spinner crux-spinner--dark' : 'crux-spinner';
        submitBtn.innerHTML = '<span class="' + spinnerClass + '"></span> Submitting...';
      }

      syncServicesAndTabsInputs();

      var formData = new FormData(contactForm);
      formData.append('action', 'crux_submit_inquiry');
      if (window.crux_ajax_obj && window.crux_ajax_obj.nonce) {
        formData.append('security', window.crux_ajax_obj.nonce);
      }

      var ajaxUrl = (window.crux_ajax_obj && window.crux_ajax_obj.ajax_url) ? window.crux_ajax_obj.ajax_url : '/wp-admin/admin-ajax.php';

      fetch(ajaxUrl, {
        method: 'POST',
        body: formData
      })
      .then(function(res) {
        return res.json();
      })
      .then(function(data) {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.style.pointerEvents = 'auto';
          submitBtn.style.opacity = '1';
          submitBtn.innerHTML = 'Submit';
        }

        if (data && data.success) {
          // Keep form accessible in background, open popup modal
          if (confirmBadge) {
            if (activeTabs.length === 3) {
              confirmBadge.textContent = 'All Wings Brief (Events, Consultancy & Partnership)';
              confirmBadge.style.color = '#FFFFFF';
              confirmBadge.style.background = '#002671';
              confirmBadge.style.borderColor = '#002671';
            } else if (activeTabs.length === 2) {
              if (activeTabs.indexOf('events') !== -1 && activeTabs.indexOf('consultancy') !== -1) {
                confirmBadge.textContent = 'Events & Consultancy Brief';
                confirmBadge.style.color = '#FFFFFF';
                confirmBadge.style.background = '#002671';
              } else if (activeTabs.indexOf('events') !== -1 && activeTabs.indexOf('partner') !== -1) {
                confirmBadge.textContent = 'Events & Partnership Brief';
                confirmBadge.style.color = '#FFFFFF';
                confirmBadge.style.background = '#002671';
              } else {
                confirmBadge.textContent = 'Consultancy & Partnership Brief';
                confirmBadge.style.color = '#10142E';
                confirmBadge.style.background = '#8C7AE6';
              }
            } else if (activeTabs[0] === 'consultancy') {
              confirmBadge.textContent = 'Business Strategy Inquiry';
              confirmBadge.style.color = '#10142E';
              confirmBadge.style.background = '#8C7AE6';
              confirmBadge.style.borderColor = '#D5CEFA';
            } else if (activeTabs[0] === 'partner') {
              confirmBadge.textContent = 'Sponsorship & Partnership Inquiry';
              confirmBadge.style.color = '#FFFFFF';
              confirmBadge.style.background = '#BA0000';
              confirmBadge.style.borderColor = '#F5C6C6';
            } else {
              confirmBadge.textContent = 'Event Planning Inquiry';
              confirmBadge.style.color = '#FFFFFF';
              confirmBadge.style.background = '#002671';
              confirmBadge.style.borderColor = '#C4D3F8';
            }
          }

          if (confirmBody && data.data && data.data.message) {
            confirmBody.textContent = data.data.message;
          }

          var modalCalBtn = document.getElementById('btn-modal-calendly');
          if (modalCalBtn) {
            modalCalBtn.style.display = (activeTabs.indexOf('consultancy') !== -1 || activeTabs.length === 3) ? 'inline-block' : 'none';
          }

          if (confirmModal) {
            confirmModal.style.display = 'flex';
          }
        } else {
          var err = (data && data.data && data.data.message) ? data.data.message : 'Error submitting inquiry. Please try again or email <?php echo esc_js( crux_opt( 'email' ) ); ?> directly.';
          showAlert(err, true);
        }
      })
      .catch(function(err) {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.style.pointerEvents = 'auto';
          submitBtn.style.opacity = '1';
          submitBtn.innerHTML = 'Submit';
        }
        showAlert('Could not connect to server. Please try again or email us directly at <?php echo esc_js( crux_opt( 'email' ) ); ?>.', true);
      });
    }

    if (submitBtn) {
      submitBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        doSubmit();
      });
    }

    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();
      e.stopPropagation();
      doSubmit();
    });

    // Modal Control Functions
    function closeModal() {
      if (confirmModal) confirmModal.style.display = 'none';
    }

    function resetFormState() {
      contactForm.reset();
      allChips.forEach(function(c) {
        c.classList.remove('selected');
        c.setAttribute('aria-pressed', 'false');
      });
      activeTabs = ['events'];
      updateTabsUI();
      syncServicesAndTabsInputs();
      closeModal();
      tabsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    if (modalCloseBtn) {
      modalCloseBtn.addEventListener('click', function(e) {
        e.preventDefault();
        closeModal();
      });
    }

    if (modalDoneBtn) {
      modalDoneBtn.addEventListener('click', function(e) {
        e.preventDefault();
        closeModal();
      });
    }

    if (modalResetBtn) {
      modalResetBtn.addEventListener('click', function(e) {
        e.preventDefault();
        resetFormState();
      });
    }

    if (confirmModal) {
      confirmModal.addEventListener('click', function(e) {
        if (e.target === confirmModal) {
          closeModal();
        }
      });
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCruxContactEngine);
  } else {
    initCruxContactEngine();
  }
})();
</script>

<!-- BOTTOM STICKY CONSULTANCY BOOKING BUTTON -->
<div class="contact-sticky-booking" id="contact-sticky-booking">
  <div class="crux-sw-pod crux-sw-pod--light" style="pointer-events:auto; margin:0 auto; display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #C4BAEE 0%, #8C7AE6 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(16,20,46,0.28); filter:drop-shadow(0 6px 16px rgba(16,20,46,0.18));">
    <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#10142E; padding:4px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
      <a href="<?php echo esc_url( crux_opt( 'calendly_url' ) ); ?>" target="_blank" rel="noopener" class="contact-sticky-booking-btn" style="display:inline-flex; align-items:center; justify-content:center; gap:10px; padding:11px 22px; font-family:'Space Grotesk',system-ui,sans-serif; font-size:13px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#8C7AE6; color:#10142E; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 10px rgba(140,122,230,0.45); transition:all .2s ease;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#10142E" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle; flex-shrink:0;">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
          <line x1="16" y1="2" x2="16" y2="6"></line>
          <line x1="8" y1="2" x2="8" y2="6"></line>
          <line x1="3" y1="10" x2="21" y2="10"></line>
        </svg>
        <span style="font-weight:800; letter-spacing:0.4px;"><?php echo crux_h( 'contact', 'bottom_sticky_consultancy_bo_text_1' ); ?></span>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#10142E" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle; flex-shrink:0;">
          <line x1="5" y1="12" x2="19" y2="12"></line>
          <polyline points="12 5 19 12 12 19"></polyline>
        </svg>
      </a>
    </div>
  </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
