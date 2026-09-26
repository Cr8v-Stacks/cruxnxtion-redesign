<?php
/**
 * Default Page Template
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
  <style>
    .mega:hover .mega-chevron { transform: rotate(180deg); }
    @media (max-width: 900px) {
      [data-m~="root"] > section:first-of-type, section[data-m~="g1"]:first-of-type, [data-m~="hero"] {
        padding-top: 74px !important;
        padding-bottom: 56px !important;
        padding-left: 20px !important;
        padding-right: 20px !important;
        min-height: 0 !important;
        gap: 28px !important;
      }
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
      .mega:hover .mega-menu { display: block !important; }
    .mega:hover .mega-chevron { transform: rotate(180deg); }
  
  /* Slanted Header Switcher Pod & Hover States */
  .crux-sw-pod { transition: transform .2s ease, box-shadow .2s ease; }
  .crux-sw-pod:hover { transform: translateY(-1px); }
  .crux-sw-tab--inactive-dark:hover { color: #FFFFFF !important; background: rgba(255,255,255,0.08) !important; }
  .crux-sw-tab--inactive-light:hover { color: #10142E !important; background: rgba(108,88,219,0.12) !important; }

  </style>
</head>
<body <?php body_class(); ?> style="background:#0A0F26; margin:0; padding:0;">
<?php wp_body_open(); ?>

<div style="width:100%; max-width:100%; margin:0; background:#0A0F26; overflow-x:clip;" data-m="root">

  <!-- SHOUT-OUT BAR -->
  <div style="background:#002671; padding:10px 20px; display:flex; align-items:center; justify-content:center; gap:10px;">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M3 11l18-7-7 18-2-8-9-3z" stroke="#FFFFFF" stroke-width="1.8" stroke-linejoin="round"></path></svg>
    <span style="font-size:12.5px; font-weight:700; color:#FFFFFF; letter-spacing:0.3px;">Crux Nxtion — Events &amp; Business Consultancy — <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" style="color:#FFFFFF; font-weight:800; border-bottom:1px solid #FFFFFF;">get in touch &rarr;</a></span>
  </div>

  <!-- HEADER -->
  <header style="position:sticky; top:0; z-index:1000; display:flex; align-items:center; justify-content:space-between; min-height:80px; padding:14px 20px; border-bottom:1px solid rgba(30,43,94,0.85); background:rgba(10,15,38,0.94); backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px);">
    <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="display:flex; align-items:center;"><img src="<?php echo crux_get_blob_url( "e4d72651b77d4c3cc1c086d9f6031149" ); ?>" alt="Crux Nxtion Events" style="height:42px; width:auto; display:block; background:#FFFFFF; padding:4px 12px 4px 12px; border-radius:8px;"></a>
    <nav style="display:flex; align-items:center; gap:28px;">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="color:#F4F5FA; font-size:14px; font-weight:600; letter-spacing:0.2px;">Home</a>
      <div class="mega" style="position:relative;">
        <a href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#F4F5FA; font-size:14px; font-weight:600; letter-spacing:0.2px; display:inline-flex; align-items:center; gap:6px;">
          <span>Services</span>
          <svg class="mega-chevron" width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg" style="transition:transform 0.2s ease;">
            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
        <div class="mega-menu" style="display:none; position:absolute; left:-180px; top:100%; width:840px; background:#0B112C; border:1px solid #1E2B5E; padding:32px; box-shadow:0 30px 60px rgba(0,0,0,0.5); border-radius:14px; z-index:9999;">
          <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:28px;">
            <!-- Column 1: EVENTS -->
            <div>
              <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px;"><span class="bebas" style="font-size:24px; color:#F4F5FA;">EVENTS</span><span style="font-size:10px; letter-spacing:1.5px; font-weight:700; color:#5B8DEF;">FOR YOUR NIGHT</span></div>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#5B8DEF; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">Event Planning &amp; Management</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">End-to-end execution</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#5B8DEF; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">Entertainment &amp; Talent</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">DJs, hosts, live performers</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#5B8DEF; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">Event Designs &amp; Production</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">Weddings, birthdays, launches</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#5B8DEF; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">Event Marketing &amp; Promotion</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">Buzz that fills the room</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#5B8DEF; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">On-Site Coordination</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">Day-of logistics &amp; support</span>
                </span>
              </a>
            </div>
            <!-- Column 2: CONSULTANCY -->
            <div>
              <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px;"><span class="bebas" style="font-size:24px; color:#F4F5FA;">CONSULTANCY</span><span style="font-size:10px; letter-spacing:1.5px; font-weight:700; color:#B7A6FF;">FOR YOUR BUSINESS</span></div>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#8C7AE6; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">Business Setup &amp; Strategy</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">From idea to a plan</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#8C7AE6; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">Branding &amp; Marketing</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">Say what you do</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#8C7AE6; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">Business Growth</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">More customers &amp; revenue</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#8C7AE6; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">Commercial Fitout &amp; Setup</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">Unit sourcing &amp; shopfitting</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#F4F5FA; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#8C7AE6; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#F4F5FA;">Specialized Visas &amp; Advisory</span>
                  <span style="display:block; font-size:11px; color:#A3A9C8; margin-top:2px;">Global talent &amp; founder visas</span>
                </span>
              </a>
            </div>
            <!-- Column 3: NOT SURE WHICH? Photo Card -->
            <div style="position:relative; border-radius:14px; overflow:hidden; min-height:240px; display:flex; flex-direction:column; justify-content:flex-end;">
              <img src="<?php echo crux_get_blob_url( 'f269f7683bdb441b9b45df1336cd1485' ); ?>" alt="Crux Nxtion Founder Bambad" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center 20%;">
              <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(10,15,38,0.95) 0%, rgba(10,15,38,0.3) 70%);"></div>
              <div style="position:relative; z-index:1; padding:20px;">
                <span class="bebas" style="font-size:24px; color:#FFFFFF; display:block; margin-bottom:8px;">NOT SURE WHICH?</span>
                <a href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="display:inline-block; background:#BA0000; color:#FFFFFF; font-weight:700; font-size:13px; padding:10px 18px; --sl:8px; text-decoration:none;" class="bx">Book A Call &rarr;</a>
              </div>
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
      <div class="site-wing-toggle crux-sw-pod crux-sw-pod--dark" style="display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #2A3F7A 0%, #15224A 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 4px 16px rgba(0,0,0,0.35); filter:drop-shadow(0 2px 6px rgba(0,0,0,0.25));">
        <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#020512; padding:3px; gap:3px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
          <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:7px 18px; font-size:12px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.5);">Events</a>
          <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-dark" style="display:inline-flex; align-items:center; justify-content:center; padding:7px 18px; font-size:12px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#8E96BB; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">Consultancy</a>
        </div>
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

      <!-- Navigation Links -->
      <div class="mdrawer-nav-links">
        <a class="mlink" href="<?php echo esc_url( home_url( "/" ) ); ?>" style="color:#F4F5FA; border-bottom:1px solid #1E2B5E;">Home</a>
        
        <!-- Accordion Services -->
        <details class="mdrawer-acc" style="border-bottom:1px solid #1E2B5E;">
          <summary style="display:flex; align-items:center; justify-content:space-between; cursor:pointer; padding:14px 0;">
            <span class="mlink" style="color:#F4F5FA !important; opacity:1 !important;">Services</span>
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

  <!-- PAGE CONTENT -->
  <main style="max-width:960px; margin:0 auto; padding:60px 20px 80px;">
    <?php while ( have_posts() ) : the_post(); ?>
      <span class="eyebrow" style="display:block; margin-bottom:12px;">Crux Nxtion</span>
      <h1 class="bebas" style="font-size: clamp(38px, 6vw, 64px); line-height: 1; color: #F4F5FA; margin: 0 0 28px;"><?php the_title(); ?></h1>
      <div class="page-content-wrapper" style="font-size: 16px; line-height: 1.8; color: #C5CADF;">
        <?php the_content(); ?>
      </div>
    <?php endwhile; ?>
  </main>

  <!-- COLOSSAL FOOTER -->
  <footer style="background:#0A0F26; padding:44px 24px; text-align:center; border-top:1px solid #1E2B5E;">
    <div style="display:flex; justify-content:center; align-items:center; flex-wrap:wrap; gap:32px; margin-bottom:24px;">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="font-size:14px; color:#A3A9C8;">Home</a>
      <a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" style="font-size:14px; color:#A3A9C8;">Services</a>
      <a href="<?php echo esc_url( home_url( '/events/' ) ); ?>" style="font-size:14px; color:#A3A9C8;">Events</a>
      <a href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>" style="font-size:14px; color:#A3A9C8;">Gallery</a>
      <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" style="font-size:14px; color:#A3A9C8;">About</a>
      <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" style="font-size:14px; color:#A3A9C8;">Blog</a>
      <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" style="font-size:14px; color:#A3A9C8;">Contact</a>
    </div>
    <p style="font-size:13px; color:#7A82A8; margin:0;">&copy; <?php echo date( "Y" ); ?> Crux Nxtion &bull; Sheffield, United Kingdom &bull; All Rights Reserved</p>
  </footer>

</div>

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
</div>

<?php wp_footer(); ?>
</body>
</html>
