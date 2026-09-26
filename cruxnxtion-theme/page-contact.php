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
  .mega-panel a.mrow:hover { transform: translateX(4px); background: rgba(140, 122, 230, 0.08) !important; }

  /* Desktop Viewport (> 900px) */
  @media (min-width: 901px) {
    header { padding: 0 64px !important; }
    header > nav { display: flex !important; }
    header > .header-desktop-actions { display: flex !important; }
    .mnav-btn, .crux-mnav-btn { display: none !important; }
    .mdrawer { display: none !important; }
  }

  /* Mobile Viewport (<= 900px) */
  @media (max-width: 900px) {
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
    .mdrawer a.mlink {
      display: block;
      font-family: 'Bebas Neue', 'Arial Narrow', sans-serif;
      font-size: 32px;
      letter-spacing: .5px;
      text-transform: uppercase;
      padding: 14px 0;
      text-decoration: none;
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
</style>


<div style="width:100%; max-width:100%; margin:0; background:#FFFFFF; overflow-x:clip;" data-m="root">

  <!-- SHOUT-OUT BAR -->
  <div style="background:#8C7AE6; padding:10px 64px; display:flex; align-items:center; justify-content:center;">
    <span style="font-size:12.5px; font-weight:700; color:#10142E; letter-spacing:0.3px;">Now booking <?php echo date( "Y" ); ?>/<?php echo (int) date( "Y" ) + 1; ?> — Events &amp; Business Consultancy — <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="color:#10142E; font-weight:800; border-bottom:1px solid #10142E;">get in touch →</a></span>
  </div>
  <!-- HEADER -->
  <header style="position:sticky; top:0; z-index:1000; display:flex; align-items:center; justify-content:space-between; padding:0 20px; border-bottom:1px solid rgba(225,222,243,0.85); background:rgba(255,255,255,0.95); backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px);">
    <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="display:flex; align-items:center;"><img src="<?php echo crux_get_blob_url( "e4d72651b77d4c3cc1c086d9f6031149" ); ?>" alt="Crux Nxtion Events" style="height:42px; width:auto; display:block; background:#FFFFFF; padding:4px 12px 4px 12px; border-radius:8px;"></a>
    <nav style="display:flex; align-items:center; gap:28px;">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="color:#10142E; font-size:14px; font-weight:600; letter-spacing:0.2px;">Home</a>
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
      <a href="<?php echo esc_url( home_url( "/events/" ) ); ?>" style="color:#10142E; font-size:14px; font-weight:600; letter-spacing:0.2px;">Events</a>
      <a href="<?php echo esc_url( home_url( "/gallery/" ) ); ?>" style="color:#10142E; font-size:14px; font-weight:600; letter-spacing:0.2px;">Gallery</a>
      <a href="<?php echo esc_url( home_url( "/about/" ) ); ?>" style="color:#10142E; font-size:14px; font-weight:600; letter-spacing:0.2px;">About</a>
      <a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" style="color:#10142E; font-size:14px; font-weight:600; letter-spacing:0.2px;">Blog</a>
      <a href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="color:#6C58DB; font-size:14px; font-weight:600; letter-spacing:0.2px; border-bottom:1.5px solid #6C58DB;">Contact</a>
    </nav>
        <div class="header-desktop-actions" style="display:flex; align-items:center; gap:16px;">
      <div style="background:rgba(10,15,38,0.92); border:1.5px solid #1E2B5E; box-shadow:0 4px 16px rgba(0,0,0,0.3); backdrop-filter:blur(12px); -webkit-backdrop-filter:blur(12px); display:flex; padding:4px 6px; gap:6px; border-radius:4px;">
        <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="font-size:12px; font-weight:700; padding:8px 16px; background:#1E48B0; color:#FFFFFF; --sl:7px;" class="bx">Events</a>
        <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="font-size:12px; font-weight:700; padding:8px 16px; color:#A3A9C8; --sl:8px; --bc:#A3A9C855;" class="bx">Consultancy</a>
      </div>
      <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:13px; padding:12px 22px; --sl:8px;" class="bx">Plan An Event</a>
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
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="display:flex; align-items:center;">
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
        <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="font-size:12px; font-weight:700; padding:8px 18px; background:#1E48B0; color:#FFFFFF; --sl:6px;" class="bx">Events</a>
        <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="font-size:12px; font-weight:700; padding:8px 18px; color:#A3A9C8; --sl:6px; --bc:#A3A9C855;" class="bx">Consultancy</a>
      </div>

      <!-- Navigation Links -->
      <div class="mdrawer-nav-links">
        <a class="mlink" href="<?php echo esc_url( home_url( "/" ) ); ?>" style="color:#10142E; border-bottom:1px solid #E1DEF3;">Home</a>
        
        <!-- Accordion Services -->
        <details class="mdrawer-acc" style="border-bottom:1px solid #E1DEF3;">
          <summary style="display:flex; align-items:center; justify-content:space-between; cursor:pointer; padding:14px 0;">
            <span class="mlink" style="color:#F4F5FA;">Services</span>
            <span class="acc-icon" style="color:#FF2E3D; font-size:22px; font-weight:700; transition:transform .2s ease;">▾</span>
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

  <!-- 1 CONTACT -->
  <section style="min-height:860px; display:grid; grid-template-columns:1fr 1fr;">
    <div style="padding:80px 64px;" class="reveal">
      <span class="eyebrow">Get In Touch</span>
      <h1 class="bebas" style="font-size:72px; margin:14px 0 26px; color:#10142E;">LET'S TALK.</h1>
      <!-- INTAKE TABS (Slanted .bx - Click multiple to brief all together) -->
      <div class="contact-mode-tabs" id="contact-mode-tabs" role="tablist">
        <button type="button" class="contact-tab-btn bx active" data-tab="events" role="tab" aria-selected="true">Plan An Event</button>
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
            <button type="button" class="chip-btn bx selected" data-cat="e" data-name="Event planning" aria-pressed="true"><span class="chip-icon">✓</span><span>Event planning</span></button>
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

          <h2 class="bebas" style="font-size:42px; color:#10142E; margin:0 0 10px; letter-spacing:0.5px; line-height:0.95;">BRIEF RECEIVED!</h2>
          
          <div id="confirm-summary-badge" class="bx" style="display:inline-block; background:#E8EFFD; --sl:6px; --bc:#C4D3F8; padding:8px 20px; font-size:12.5px; font-weight:700; color:#002671; margin-bottom:18px;">Events Inquiry</div>

          <p id="confirm-msg-body" style="font-size:15px; line-height:1.65; color:#3A3F66; margin:0 0 28px;">Thank you! Your brief has been transmitted directly to our team. A real person will review your requirements and reply within 24 business hours.</p>
          
          <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
            <a href="https://calendly.com/cruxnxtiongroupofcompany-info" id="btn-modal-calendly" target="_blank" rel="noopener" style="display:none; background:#8C7AE6; color:#10142E !important; font-weight:700; font-size:13.5px; padding:13px 22px; --sl:8px; text-decoration:none;" class="bx">Book Discovery Call on Calendly &rarr;</a>
            <button type="button" id="btn-modal-done" style="background:#002671; color:#FFFFFF; font-weight:700; font-size:13.5px; padding:13px 26px; --sl:8px; cursor:pointer;" class="bx">Close &amp; Continue</button>
            <button type="button" id="btn-modal-reset" style="background:#8C7AE6; color:#10142E; font-weight:700; font-size:13.5px; padding:13px 24px; --sl:8px; cursor:pointer;" class="bx">Send Another Brief</button>
          </div>

        </div>
      </div>
    </div>
    <div style="position:relative; overflow:hidden;" class="reveal">
      <img src="<?php echo crux_get_blob_url( "4170d6b6009c07e37d83bae48a68917b" ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;" class="drift">
      <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.92) 0%, rgba(16,20,46,0.25) 70%);"></div>
      <div style="position:relative; height:100%; display:flex; flex-direction:column; justify-content:flex-end; padding:56px; gap:12px;">
        <div style="background:rgba(16,20,46,0.96) !important; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); padding:16px 20px; width:fit-content; max-width:100%; --sl:6px; --bc:#8C7AE6; margin-bottom:4px;" class="bx">
          <div style="font-size:11px; font-weight:800; letter-spacing:1.5px; text-transform:uppercase; color:#8C7AE6; margin-bottom:4px;">Direct Consultancy Booking</div>
          <div style="font-size:13px; font-weight:600; color:#F2F1F8; margin-bottom:12px;">Prefer to book directly with our business advisory team?</div>
          <a href="https://calendly.com/cruxnxtiongroupofcompany-info" target="_blank" rel="noopener" style="background:#8C7AE6; color:#10142E !important; font-weight:700; font-size:12.5px; padding:8px 18px; --sl:5px; display:inline-block; text-decoration:none;" class="bx">Book On Calendly &rarr;</a>
        </div>
        <div style="display:flex; align-items:center; gap:12px; background:rgba(16,20,46,0.96) !important; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); padding:11px 22px 11px 12px; width:fit-content; --sl:6px; --bc:#3A3F72;" class="bx"><span style="width:32px; height:32px; border-radius:50%; background:#8C7AE6; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:800; color:#10142E;">✆</span><span style="font-size:13px; font-weight:600; color:#F2F1F8;">+44 7762 278076</span></div><div style="display:flex; align-items:center; gap:12px; background:rgba(16,20,46,0.96) !important; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); padding:11px 22px 11px 12px; width:fit-content; --sl:6px; --bc:#3A3F72;" class="bx"><span style="width:32px; height:32px; border-radius:50%; background:#8C7AE6; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:800; color:#10142E;">✆</span><span style="font-size:13px; font-weight:600; color:#F2F1F8;">+44 7341 366400</span></div><div style="display:flex; align-items:center; gap:12px; background:rgba(16,20,46,0.96) !important; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); padding:11px 22px 11px 12px; width:fit-content; --sl:6px; --bc:#3A3F72;" class="bx"><span style="width:32px; height:32px; border-radius:50%; background:#8C7AE6; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:800; color:#10142E;">@</span><?php $c_mail = 'infoandsales@cruxnxtion.co.uk'; ?><a href="<?php echo esc_url( 'mailto:' . antispambot( $c_mail ) ); ?>" style="font-size:13px; font-weight:600; color:#F2F1F8; text-decoration:none;"><?php echo esc_html( antispambot( $c_mail ) ); ?></a></div><div style="display:flex; align-items:center; gap:12px; background:rgba(16,20,46,0.96) !important; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); padding:11px 22px 11px 12px; width:fit-content; --sl:6px; --bc:#3A3F72;" class="bx"><span style="width:32px; height:32px; border-radius:50%; background:#8C7AE6; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:800; color:#10142E;">●</span><span style="font-size:13px; font-weight:600; color:#F2F1F8;">29 Dun Work, Sheffield S3 8FB</span></div>
        <a href="#" style="color:#F2F1F8; font-weight:700; font-size:13px; border-bottom:1.5px solid #8C7AE6; padding-bottom:2px; width:fit-content; margin-top:6px;">Get directions →</a>
      </div>
    </div>
  </section>

  <!-- 2 NEXT -->
  <section style="min-height:640px; padding:100px 64px; background:#F3F1FC;">
    <div style="text-align:center; margin-bottom:50px;" class="reveal"><span class="eyebrow">What Happens Next</span><h2 class="bebas" style="font-size:56px; margin:12px 0 0; color:#10142E;">NO FORMS DISAPPEARING INTO THE VOID.</h2></div>
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:20px;" class="reveal"><div class="bento-tile reveal" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:22px; padding:34px 30px; min-height:240px; display:flex; flex-direction:column; justify-content:space-between;"><span class="bebas" style="font-size:64px; color:#6C58DB; line-height:0.9;">01</span><div><h3 class="bebas" style="font-size:30px; margin:0 0 8px; color:#10142E;">YOU SEND A BRIEF</h3><p style="font-size:14px; line-height:1.65; color:#3A3F66; margin:0;">A few lines is plenty — what you're planning, or where you're stuck.</p></div></div><div class="bento-tile reveal" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:22px; padding:34px 30px; min-height:240px; display:flex; flex-direction:column; justify-content:space-between;"><span class="bebas" style="font-size:64px; color:#6C58DB; line-height:0.9;">02</span><div><h3 class="bebas" style="font-size:30px; margin:0 0 8px; color:#10142E;">WE REPLY AND TALK IT THROUGH</h3><p style="font-size:14px; line-height:1.65; color:#3A3F66; margin:0;">A real person comes back to you, usually with a question or two.</p></div></div><div class="bento-tile reveal" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:22px; padding:34px 30px; min-height:240px; display:flex; flex-direction:column; justify-content:space-between;"><span class="bebas" style="font-size:64px; color:#6C58DB; line-height:0.9;">03</span><div><h3 class="bebas" style="font-size:30px; margin:0 0 8px; color:#10142E;">YOU GET A PLAN</h3><p style="font-size:14px; line-height:1.65; color:#3A3F66; margin:0;">A clear next step, quote or proposal — whichever fits.</p></div></div></div>
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
        <h2 class="bebas" style="font-size:clamp(44px, 5.5vw, 76px); line-height:0.95; margin:16px 0 18px; color:#FFFFFF; max-width:820px;">GOT A DATE, OR JUST A DIRECTION?</h2>
        <p style="font-size:16px; line-height:1.7; color:#C5CADF; max-width:540px; margin:0 0 32px;">Planning an event or building a business — tell us what you have in mind and a real person will come back to you.</p>
        <div style="display:flex; gap:16px;" data-m="ctas">
          <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:15px; padding:17px 32px; --sl:10px;" class="bx">Plan An Event →</a>
          <a href="<?php echo esc_url( home_url( "/contact/?type=consultancy" ) ); ?>" style="background:#8C7AE6; color:#10142E !important; font-weight:700; font-size:15px; padding:17px 32px; --sl:10px;" class="bx">Talk Business Strategy →</a>
        </div>
      </div>
      <div class="prefooter__badge" style="width:160px; height:160px; flex:0 0 160px;">
        <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" class="prefooter__badge-link" aria-label="Plan An Event" style="display:block; width:100%; height:100%; text-decoration:none; transition:transform .3s ease;">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/prefooter-badge-consultancy.svg' ); ?>" class="prefooter__badge-img" alt="Plan An Event — spinning badge" style="width:100%; height:100%; object-fit:contain; animation:rc-spin 14s linear infinite; filter:drop-shadow(0 12px 28px rgba(0,0,0,0.5));">
        </a>
      </div>
    </div>
  </section>

  <!-- COLOSSAL FOOTER -->
  <footer id="contact" style="background:#10142E; padding:90px 24px 44px; text-align:center; position:relative; overflow:hidden;">
    <div style="position:relative; margin-bottom:40px;">
      <span class="bebas" style="font-size:clamp(80px,17vw,220px); line-height:0.82; display:block; background:linear-gradient(180deg, #F2F1F8 0%, #B9AFF0 25%, #2A2F5C 65%, transparent 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; position:relative;">CRUX</span>
      <span class="bebas" style="font-size:clamp(30px,6.4vw,82px); line-height:1; display:block; background:linear-gradient(180deg, #F2F1F8 0%, #B9AFF0 25%, #2A2F5C 65%, transparent 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; position:relative; letter-spacing:0.5em; margin-top:10px; padding-left:0.5em;">NXTION</span>
    </div>
    <div style="display:flex; justify-content:center; align-items:center; flex-wrap:wrap; gap:32px; margin-bottom:32px;">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="font-size:14px; color:#9A9AC0;">Home</a>
      <a href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="font-size:14px; color:#9A9AC0;">Services</a>
      <a href="<?php echo esc_url( home_url( "/events/" ) ); ?>" style="font-size:14px; color:#9A9AC0;">Events</a>
      <a href="<?php echo esc_url( home_url( "/gallery/" ) ); ?>" style="font-size:14px; color:#9A9AC0;">Gallery</a>
      <a href="<?php echo esc_url( home_url( "/about/" ) ); ?>" style="font-size:14px; color:#9A9AC0;">About</a>
      <a href="<?php echo esc_url( home_url( "/faq/" ) ); ?>" style="font-size:14px; color:#9A9AC0;">FAQ</a>
      <a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" style="font-size:14px; color:#9A9AC0;">Blog</a>
      <a href="<?php echo esc_url( home_url( "/sponsors/" ) ); ?>" style="font-size:14px; color:#9A9AC0;">Sponsors</a>
    </div>
    <div style="display:flex; justify-content:center; gap:14px; margin-bottom:44px;">
      <a href="#" aria-label="Instagram" style="display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; background:rgba(242,241,248,0.05); color:#F2F1F8; --sl:7px; --bc:rgba(242,241,248,0.12);" class="bx"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" stroke="currentColor" stroke-width="1.5"></rect><circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5"></circle><circle cx="17.4" cy="6.6" r="1" fill="currentColor"></circle></svg></a>
      <a href="#" aria-label="TikTok" style="display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; background:rgba(242,241,248,0.05); color:#F2F1F8; --sl:7px; --bc:rgba(242,241,248,0.12);" class="bx"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M14 3v10.5a3.5 3.5 0 1 1-3-3.46" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path><path d="M14 3c.4 2.6 2.2 4.4 4.8 4.8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path></svg></a>
      <a href="#" aria-label="WhatsApp" style="display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; background:rgba(242,241,248,0.05); color:#F2F1F8; --sl:7px; --bc:rgba(242,241,248,0.12);" class="bx"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 20l1.4-4.1A8 8 0 1 1 9 19.5L4 20Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"></path><path d="M8.5 9.5c0 3.5 3 6.5 6.5 6.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path></svg></a>
    </div>
    <div style="display:flex; justify-content:center; flex-wrap:wrap; gap:8px 26px; margin-bottom:20px;">
      <a href="<?php echo esc_url( home_url( "/privacy-policy/" ) ); ?>" style="font-size:12.5px; color:#8E96BB;">Privacy Policy</a>
      <a href="<?php echo esc_url( home_url( "/cookie-policy/" ) ); ?>" style="font-size:12.5px; color:#8E96BB;">Cookie Policy</a>
      <a href="<?php echo esc_url( home_url( "/terms-conditions/" ) ); ?>" style="font-size:12.5px; color:#8E96BB;">Terms &amp; Conditions</a>
    </div>
    <div style="width:100%; max-width:900px; height:1px; background:#2A2F5C; margin:0 auto 24px;"></div>
    <p style="font-size:13px; color:#6E6E9A; margin:0;">&copy; <?php echo date( "Y" ); ?> Crux Nxtion Events • Sheffield, United Kingdom • All Rights Reserved</p>
  </footer>
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

    // Multi-tab brief state: array of selected wings (allows 1, 2, or all 3 simultaneous tabs)
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

    function toggleTab(tabName) {
      var idx = activeTabs.indexOf(tabName);
      if (idx !== -1) {
        // Toggle off if multiple tabs are active (keep at least 1)
        if (activeTabs.length > 1) {
          activeTabs.splice(idx, 1);
        }
      } else {
        // Toggle on
        activeTabs.push(tabName);
      }
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

    // Tab buttons click handler (multi-tab toggle)
    tabButtons.forEach(function(btn) {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        var tab = this.getAttribute('data-tab');
        if (tab) toggleTab(tab);
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
          var err = (data && data.data && data.data.message) ? data.data.message : 'Error submitting inquiry. Please try again or email infoandsales@cruxnxtion.co.uk directly.';
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
        showAlert('Could not connect to server. Please try again or email us directly at infoandsales@cruxnxtion.co.uk.', true);
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
      if (groupEvents) {
        var firstChip = groupEvents.querySelector('.chip-btn');
        if (firstChip) {
          firstChip.classList.add('selected');
          firstChip.setAttribute('aria-pressed', 'true');
        }
      }
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

<div class="msw">
  <div style="background:rgba(10,15,38,0.95); border:1.5px solid #1E2B5E; box-shadow:0 12px 30px rgba(0,0,0,0.55); backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px); display:flex; padding:5px 6px; gap:6px;">
    <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="padding:11px 22px; font-size:13px; font-weight:700; background:#1E48B0; color:#FFFFFF; --sl:7px;" class="bx">Events</a>
    <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="padding:11px 22px; font-size:13px; font-weight:700; color:#A3A9C8; --sl:7px; --bc:#A3A9C855;" class="bx">Consultancy</a>
  </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
