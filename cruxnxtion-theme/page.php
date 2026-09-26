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
      <div class="site-wing-toggle" style="display:inline-flex; align-items:center; background:rgba(10,15,38,0.7); border:1px solid #1E2B5E; border-radius:999px; padding:3px; gap:2px;">
        <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="padding:6px 16px; border-radius:999px; font-size:12px; font-weight:700; text-decoration:none; transition:all .2s ease; line-height:1.2; background:#1E48B0; color:#FFFFFF;">Events</a>
        <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="padding:6px 16px; border-radius:999px; font-size:12px; font-weight:700; text-decoration:none; transition:all .2s ease; line-height:1.2; color:#A3A9C8; background:transparent;">Consultancy</a>
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
  <div style="pointer-events:auto; display:inline-flex; align-items:center; background:rgba(10,15,38,0.94); border:1.5px solid #1E2B5E; border-radius:999px; padding:4px; gap:4px; box-shadow:0 14px 36px rgba(0,0,0,0.6); backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px);">
    <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 22px; min-width:130px; border-radius:999px; font-size:13px; font-weight:700; text-decoration:none; transition:all .2s ease; background:#1E48B0; color:#FFFFFF;">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
      <span>Events</span>
    </a>
    <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:11px 22px; min-width:130px; border-radius:999px; font-size:13px; font-weight:700; text-decoration:none; transition:all .2s ease; color:#A3A9C8; background:transparent;">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
      <span>Consultancy</span>
    </a>
  </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
