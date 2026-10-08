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

  <?php get_template_part( 'parts/site-header', null, array( 'skin' => 'dark', 'nav' => 'events', 'wing' => 'events', 'active' => '' ) ); ?>

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
