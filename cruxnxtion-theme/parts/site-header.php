<?php
/**
 * Shared header: announcement bar, site header with mega menu, and the mobile drawer.
 * Replaces the copy that every template used to carry (Customizer phase C0).
 *
 * Arguments (second argument of get_template_part):
 *   skin    'dark' (events pages) or 'light' (about, contact, FAQ, legal and consultancy pages)
 *   nav     'events' (Events and Gallery links) or 'consultancy' (Founder link), light skin only
 *   wing    'events' or 'consultancy': logo and Home address, wing switch, call to action, announcement text
 *   active  highlighted top link: home, events, gallery, about, blog, contact, founder or ''
 *
 * @package CruxNxtion
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$crux_args   = wp_parse_args( isset( $args ) ? $args : array(), array( 'skin' => 'dark', 'nav' => 'events', 'wing' => 'events', 'active' => '' ) );
$crux_skin   = 'light' === $crux_args['skin'] ? 'light' : 'dark';
$crux_nav    = 'consultancy' === $crux_args['nav'] ? 'consultancy' : 'events';
$crux_wing   = 'consultancy' === $crux_args['wing'] ? 'consultancy' : 'events';
$crux_active = (string) $crux_args['active'];
if ( 'dark' === $crux_skin ) :
?><!-- SHOUT-OUT BAR -->
  <div class="top-shoutout-bar" style="background:#002671; padding:10px 20px 10px 20px; display:flex; align-items:center; justify-content:center; gap:10px;">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M3 11l18-7-7 18-2-8-9-3z" stroke="#FFFFFF" stroke-width="1.8" stroke-linejoin="round"></path></svg>
    <span style="font-size:12.5px; font-weight:700; color:#FFFFFF; letter-spacing:0.3px;"><?php echo esc_html( crux_bar_text( "events" ) ); ?> <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="color:#FFFFFF; font-weight:800; border-bottom:1px solid #FFFFFF;"><?php echo esc_html( crux_opt( "bar_events_link" ) ); ?></a></span>
  </div>

  <!-- HEADER -->
  <header style="position:sticky; top:0; z-index:1000; display:flex; align-items:center; justify-content:space-between; min-height:80px; padding:14px 20px; border-bottom:1px solid rgba(30,43,94,0.85); background:rgba(10,15,38,0.94); backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px);">
    <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="display:flex; align-items:center;"><img src="<?php echo crux_get_blob_url( "e4d72651b77d4c3cc1c086d9f6031149" ); ?>" alt="Crux Nxtion Events" style="height:42px; width:auto; display:block; background:#FFFFFF; padding:4px 12px 4px 12px; border-radius:8px;"></a>
    <nav style="display:flex; align-items:center; gap:28px;">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="<?php echo crux_nav_style( $crux_skin, "home", $crux_active ); ?>">Home</a>
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
              <img src="<?php echo esc_url( crux_card_photo_url() ); ?>" alt="Crux Nxtion Founder Bambad" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center 20%;">
              <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(10,15,38,0.95) 0%, rgba(10,15,38,0.3) 70%);"></div>
              <div style="position:relative; z-index:1; padding:20px;">
                <span class="bebas" style="font-size:24px; color:#FFFFFF; display:block; margin-bottom:8px;"><?php echo esc_html( crux_opt( "card_title" ) ); ?></span>
                <a href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="display:inline-block; background:#BA0000; color:#FFFFFF; font-weight:700; font-size:13px; padding:10px 18px; --sl:8px; text-decoration:none;" class="bx"><?php echo esc_html( crux_opt( "card_button" ) ); ?> &rarr;</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <a href="<?php echo esc_url( home_url( "/events/" ) ); ?>" style="<?php echo crux_nav_style( $crux_skin, "events", $crux_active ); ?>">Events</a>
      <a href="<?php echo esc_url( home_url( "/gallery/" ) ); ?>" style="<?php echo crux_nav_style( $crux_skin, "gallery", $crux_active ); ?>">Gallery</a>
      <a href="<?php echo esc_url( home_url( "/about/" ) ); ?>" style="<?php echo crux_nav_style( $crux_skin, "about", $crux_active ); ?>">About</a>
      <a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" style="<?php echo crux_nav_style( $crux_skin, "blog", $crux_active ); ?>">Blog</a>
      <a href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="<?php echo crux_nav_style( $crux_skin, "contact", $crux_active ); ?>">Contact</a>
    </nav>
        <div class="header-desktop-actions" style="display:flex; align-items:center; gap:16px;">
      <div class="site-wing-toggle crux-sw-pod crux-sw-pod--dark" style="display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #2A3F7A 0%, #15224A 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 4px 16px rgba(0,0,0,0.35); filter:drop-shadow(0 2px 6px rgba(0,0,0,0.25));">
        <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#020512; padding:3px; gap:3px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
          <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:7px 18px; font-size:12px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.5);">Events</a>
          <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-dark" style="display:inline-flex; align-items:center; justify-content:center; padding:7px 18px; font-size:12px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#8E96BB; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">Consultancy</a>
        </div>
      </div>
      <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:13px; padding:12px 22px; --sl:8px;" class="bx"><?php echo esc_html( crux_opt( "cta_events_text" ) ); ?></a>
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
        <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="display:block; text-align:center; background:#BA0000; color:#FFFFFF; font-weight:700; font-size:14px; padding:15px 20px; --sl:8px; text-decoration:none;" class="bx"><?php echo esc_html( crux_opt( "cta_events_text" ) ); ?> &rarr;</a>
        <a href="<?php echo esc_url( crux_opt( "calendly_url" ) ); ?>" target="_blank" rel="noopener" style="display:block; text-align:center; background:#8C7AE6; color:#10142E; font-weight:700; font-size:14px; padding:15px 20px; --sl:8px; text-decoration:none;" class="bx"><?php echo esc_html( crux_opt( "cta_consult_text" ) ); ?> (Calendly) &rarr;</a>
      </div>

      <!-- Contact & Direct Telephony -->
      <div style="margin-top:24px; padding-top:18px; border-top:1px solid #1E2B5E; display:flex; flex-direction:column; gap:8px;">
        <div style="display:flex; align-items:center; gap:8px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#5B8DEF" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"></path></svg>
          <a href="<?php echo esc_attr( crux_tel( "phone_main" ) ); ?>" style="font-size:13px; color:#C5CADF; text-decoration:none; font-weight:600;"><?php echo esc_html( crux_opt( "phone_main" ) ); ?></a>
        </div>
        <div style="display:flex; align-items:center; gap:8px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8C7AE6" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
          <?php $c_mail = crux_opt( 'email' ); ?>
          <a href="<?php echo esc_url( 'mailto:' . antispambot( $c_mail ) ); ?>" style="font-size:13px; color:#C5CADF; text-decoration:none; font-weight:600;"><?php echo esc_html( antispambot( $c_mail ) ); ?></a>
        </div>
      </div>
    </div>
  </div>
<?php else : ?><!-- SHOUT-OUT BAR -->
  <div class="top-shoutout-bar" style="background:#8C7AE6; padding:10px 20px 10px 20px; display:flex; align-items:center; justify-content:center;">
<?php if ( "consultancy" === $crux_wing ) : ?>    <span style="font-size:12.5px; font-weight:700; color:#10142E; letter-spacing:0.3px;"><?php echo esc_html( crux_bar_text( "consult" ) ); ?> <a href="<?php echo esc_url( home_url( "/contact/?type=consultancy" ) ); ?>" style="color:#10142E; font-weight:800; border-bottom:1px solid #10142E;"><?php echo esc_html( crux_opt( "bar_consult_link" ) ); ?></a></span>
<?php else : ?>    <span style="font-size:12.5px; font-weight:700; color:#10142E; letter-spacing:0.3px;"><?php echo esc_html( crux_bar_text( "dual" ) ); ?> <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="color:#10142E; font-weight:800; border-bottom:1px solid #10142E;"><?php echo esc_html( crux_opt( "bar_dual_link" ) ); ?></a></span>
<?php endif; ?>
  </div>
  <!-- HEADER -->
  <header style="position:sticky; top:0; z-index:1000; display:flex; align-items:center; justify-content:space-between; min-height:80px; padding:14px 20px; border-bottom:1px solid rgba(225,222,243,0.85); background:rgba(255,255,255,0.95); backdrop-filter:blur(14px); -webkit-backdrop-filter:blur(14px);">
<?php if ( "consultancy" === $crux_wing ) : ?>    <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="display:flex; align-items:center;"><img src="<?php echo crux_get_blob_url( "e4d72651b77d4c3cc1c086d9f6031149" ); ?>" alt="Crux Nxtion Events" style="height:42px; width:auto; display:block; background:#FFFFFF; padding:4px 12px 4px 12px; border-radius:8px;"></a>
<?php else : ?>    <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="display:flex; align-items:center;"><img src="<?php echo crux_get_blob_url( "e4d72651b77d4c3cc1c086d9f6031149" ); ?>" alt="Crux Nxtion Events" style="height:42px; width:auto; display:block; background:#FFFFFF; padding:4px 12px 4px 12px; border-radius:8px;"></a>
<?php endif; ?>
    <nav style="display:flex; align-items:center; gap:28px;">
<?php if ( "consultancy" === $crux_wing ) : ?>      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="<?php echo crux_nav_style( $crux_skin, "home", $crux_active ); ?>">Home</a>
<?php else : ?>      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="<?php echo crux_nav_style( $crux_skin, "home", $crux_active ); ?>">Home</a>
<?php endif; ?>
      <div class="mega" style="position:relative;">
        <a href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="color:#10142E; font-size:14px; font-weight:600; letter-spacing:0.2px; display:inline-flex; align-items:center; gap:6px;">
          <span>Services</span>
          <svg class="mega-chevron" width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg" style="transition:transform 0.2s ease;">
            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
        <div class="mega-menu" style="display:none; position:absolute; left:-180px; top:100%; width:840px; background:#FFFFFF; border:1.5px solid #E1DEF3; padding:32px; box-shadow:0 30px 60px rgba(16,20,46,0.18); border-radius:14px; z-index:9999;">
          <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:28px;">
            <!-- Column 1: EVENTS -->
            <div>
              <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px;"><span class="bebas" style="font-size:24px; color:#10142E;">EVENTS</span><span style="font-size:10px; letter-spacing:1.5px; font-weight:700; color:#5B8DEF;">FOR YOUR NIGHT</span></div>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#10142E; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#002671; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#10142E;">Event Planning &amp; Management</span>
                  <span style="display:block; font-size:11px; color:#5A5F86; margin-top:2px;">End-to-end execution</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#10142E; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#002671; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#10142E;">Entertainment &amp; Talent</span>
                  <span style="display:block; font-size:11px; color:#5A5F86; margin-top:2px;">DJs, hosts, live performers</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#10142E; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#002671; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#10142E;">Event Designs &amp; Production</span>
                  <span style="display:block; font-size:11px; color:#5A5F86; margin-top:2px;">Weddings, birthdays, launches</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#10142E; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#002671; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#10142E;">Event Marketing &amp; Promotion</span>
                  <span style="display:block; font-size:11px; color:#5A5F86; margin-top:2px;">Buzz that fills the room</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#10142E; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#002671; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#10142E;">On-Site Coordination</span>
                  <span style="display:block; font-size:11px; color:#5A5F86; margin-top:2px;">Day-of logistics &amp; support</span>
                </span>
              </a>
            </div>
            <!-- Column 2: CONSULTANCY -->
            <div>
              <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px;"><span class="bebas" style="font-size:24px; color:#10142E;">CONSULTANCY</span><span style="font-size:10px; letter-spacing:1.5px; font-weight:700; color:#6C58DB;">FOR YOUR BUSINESS</span></div>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#10142E; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#8C7AE6; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#10142E;">Business Setup &amp; Strategy</span>
                  <span style="display:block; font-size:11px; color:#5A5F86; margin-top:2px;">From idea to a plan</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#10142E; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#8C7AE6; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#10142E;">Branding &amp; Marketing</span>
                  <span style="display:block; font-size:11px; color:#5A5F86; margin-top:2px;">Say what you do</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#10142E; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#8C7AE6; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#10142E;">Business Growth</span>
                  <span style="display:block; font-size:11px; color:#5A5F86; margin-top:2px;">More customers &amp; revenue</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#10142E; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#8C7AE6; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#10142E;">Commercial Fitout &amp; Setup</span>
                  <span style="display:block; font-size:11px; color:#5A5F86; margin-top:2px;">Unit sourcing &amp; shopfitting</span>
                </span>
              </a>
              <a class="mrow" href="<?php echo esc_url( home_url( "/services-consultancy/" ) ); ?>" style="display:flex; gap:12px; align-items:flex-start; padding:8px 0; color:#10142E; text-decoration:none;">
                <span style="width:7px; height:7px; border-radius:50%; background:#8C7AE6; margin-top:5px; flex:0 0 7px;"></span>
                <span>
                  <span style="display:block; font-size:13px; font-weight:700; color:#10142E;">Specialized Visas &amp; Advisory</span>
                  <span style="display:block; font-size:11px; color:#5A5F86; margin-top:2px;">Global talent &amp; founder visas</span>
                </span>
              </a>
            </div>
            <!-- Column 3: NOT SURE WHICH? Photo Card -->
            <div style="position:relative; border-radius:14px; overflow:hidden; min-height:240px; display:flex; flex-direction:column; justify-content:flex-end;">
              <img src="<?php echo esc_url( crux_card_photo_url() ); ?>" alt="Crux Nxtion Founder Bambad" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center 20%;">
              <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.95) 0%, rgba(16,20,46,0.3) 70%);"></div>
              <div style="position:relative; z-index:1; padding:20px;">
                <span class="bebas" style="font-size:24px; color:#FFFFFF; display:block; margin-bottom:8px;"><?php echo esc_html( crux_opt( "card_title" ) ); ?></span>
                <a href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="display:inline-block; background:#8C7AE6; color:#10142E; font-weight:700; font-size:13px; padding:10px 18px; --sl:8px; text-decoration:none;" class="bx"><?php echo esc_html( crux_opt( "card_button" ) ); ?> &rarr;</a>
              </div>
            </div>
          </div>
        </div>
      </div>
<?php if ( "consultancy" === $crux_nav ) : ?>      <a href="<?php echo esc_url( home_url( "/founder/" ) ); ?>" style="<?php echo crux_nav_style( $crux_skin, "founder", $crux_active ); ?>">Founder</a>
<?php else : ?>      <a href="<?php echo esc_url( home_url( "/events/" ) ); ?>" style="<?php echo crux_nav_style( $crux_skin, "events", $crux_active ); ?>">Events</a>
      <a href="<?php echo esc_url( home_url( "/gallery/" ) ); ?>" style="<?php echo crux_nav_style( $crux_skin, "gallery", $crux_active ); ?>">Gallery</a>
<?php endif; ?>
      <a href="<?php echo esc_url( home_url( "/about/" ) ); ?>" style="<?php echo crux_nav_style( $crux_skin, "about", $crux_active ); ?>">About</a>
      <a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" style="<?php echo crux_nav_style( $crux_skin, "blog", $crux_active ); ?>">Blog</a>
      <a href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="<?php echo crux_nav_style( $crux_skin, "contact", $crux_active ); ?>">Contact</a>
    </nav>
        <div class="header-desktop-actions" style="display:flex; align-items:center; gap:16px;">
      <div class="site-wing-toggle crux-sw-pod crux-sw-pod--light" style="display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #C4BAEE 0%, #A99CE0 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 2px 12px rgba(16,20,46,0.08);">
        <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#EBE7F7; padding:3px; gap:3px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
<?php if ( "consultancy" === $crux_wing ) : ?>          <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-light" style="display:inline-flex; align-items:center; justify-content:center; padding:7px 18px; font-size:12px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#4A5073; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">Events</a>
          <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-consultancy" style="display:inline-flex; align-items:center; justify-content:center; padding:7px 18px; font-size:12px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#6C58DB; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(108,88,219,0.45);">Consultancy</a>
<?php else : ?>          <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:7px 18px; font-size:12px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.4);">Events</a>
          <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-light" style="display:inline-flex; align-items:center; justify-content:center; padding:7px 18px; font-size:12px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#4A5073; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">Consultancy</a>
<?php endif; ?>
        </div>
      </div>
<?php if ( "consultancy" === $crux_wing ) : ?>      <a href="<?php echo esc_url( crux_opt( "calendly_url" ) ); ?>" target="_blank" rel="noopener" style="background:#8C7AE6; color:#10142E !important; font-weight:700; font-size:13px; padding:12px 22px; --sl:8px;" class="bx"><?php echo esc_html( crux_opt( "cta_consult_text" ) ); ?></a>
<?php else : ?>      <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:13px; padding:12px 22px; --sl:8px;" class="bx"><?php echo esc_html( crux_opt( "cta_events_text" ) ); ?></a>
<?php endif; ?>
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
<?php if ( "consultancy" === $crux_wing ) : ?>      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="display:flex; align-items:center;">
<?php else : ?>      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" style="display:flex; align-items:center;">
<?php endif; ?>
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

      <!-- Navigation Links -->
      <div class="mdrawer-nav-links">
<?php if ( "consultancy" === $crux_wing ) : ?>        <a class="mlink" href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" style="color:#10142E; border-bottom:1px solid #E1DEF3;">Home</a>
<?php else : ?>        <a class="mlink" href="<?php echo esc_url( home_url( "/" ) ); ?>" style="color:#10142E; border-bottom:1px solid #E1DEF3;">Home</a>
<?php endif; ?>
        
        <!-- Accordion Services -->
        <details class="mdrawer-acc" style="border-bottom:1px solid #E1DEF3;">
          <summary style="display:flex; align-items:center; justify-content:space-between; cursor:pointer; padding:14px 0;">
            <span class="mlink" style="color:#10142E !important; opacity:1 !important;">Services</span>
<?php if ( "consultancy" === $crux_wing ) : ?>            <span class="acc-icon" style="color:#6C58DB; font-size:22px; font-weight:700; transition:transform .2s ease;">▾</span>
<?php else : ?>            <span class="acc-icon" style="color:#FF2E3D; font-size:22px; font-weight:700; transition:transform .2s ease;">▾</span>
<?php endif; ?>
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
        <a href="<?php echo esc_url( home_url( "/contact/?type=events" ) ); ?>" style="display:block; text-align:center; background:#BA0000; color:#FFFFFF; font-weight:700; font-size:14px; padding:15px 20px; --sl:8px; text-decoration:none;" class="bx"><?php echo esc_html( crux_opt( "cta_events_text" ) ); ?> &rarr;</a>
        <a href="<?php echo esc_url( crux_opt( "calendly_url" ) ); ?>" target="_blank" rel="noopener" style="display:block; text-align:center; background:#8C7AE6; color:#10142E; font-weight:700; font-size:14px; padding:15px 20px; --sl:8px; text-decoration:none;" class="bx"><?php echo esc_html( crux_opt( "cta_consult_text" ) ); ?> (Calendly) &rarr;</a>
      </div>

      <!-- Contact & Direct Telephony -->
      <div style="margin-top:24px; padding-top:18px; border-top:1px solid #E1DEF3; display:flex; flex-direction:column; gap:8px;">
        <div style="display:flex; align-items:center; gap:8px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6C58DB" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"></path></svg>
          <a href="<?php echo esc_attr( crux_tel( "phone_main" ) ); ?>" style="font-size:13px; color:#5A5F86; text-decoration:none; font-weight:600;"><?php echo esc_html( crux_opt( "phone_main" ) ); ?></a>
        </div>
        <div style="display:flex; align-items:center; gap:8px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#BA0000" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
          <?php $c_mail = crux_opt( 'email' ); ?>
          <a href="<?php echo esc_url( 'mailto:' . antispambot( $c_mail ) ); ?>" style="font-size:13px; color:#5A5F86; text-decoration:none; font-weight:600;"><?php echo esc_html( antispambot( $c_mail ) ); ?></a>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
