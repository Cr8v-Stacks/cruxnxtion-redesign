<?php
/**
 * Shared pre-footer call to action band and footer (Customizer phase C0b).
 *
 * Arguments (second argument of get_template_part):
 *   skin       'dark' or 'light'
 *   prefooter  key understood by crux_prefooter_data(): events, events-light, idea, founder, services
 *   wing       'events' or 'consultancy': footer Home and Services addresses
 *   pad        footer padding (the contact page needs extra space above)
 *
 * @package CruxNxtion
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$crux_args = wp_parse_args( isset( $args ) ? $args : array(), array( 'skin' => 'dark', 'prefooter' => 'events', 'wing' => 'events', 'pad' => '44px 24px 44px 24px' ) );
$crux_p    = crux_footer_palette( $crux_args['skin'] );
$crux_pf   = crux_prefooter_data( $crux_args['prefooter'] );
$crux_fw   = 'consultancy' === $crux_args['wing'] ? array( 'home' => '/consultancy/', 'services' => '/services-consultancy/' ) : array( 'home' => '/', 'services' => '/services/' );
$crux_pad  = (string) $crux_args['pad'];
?><!-- PREFOOTER CTA — cinematic band with spinning rosette badge -->
  <section style="position:relative; min-height:540px; overflow:hidden; display:flex; align-items:center;">
    <img<?php echo crux_edit_attr_opt( 'prefooter_bg' ); ?> src="<?php echo esc_url( crux_prefooter_bg_url() ); ?>" alt="Crux Nxtion event crowd" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
    <div style="position:absolute; inset:0; background:linear-gradient(100deg, rgba(10,15,38,0.97) 0%, rgba(10,15,38,0.82) 52%, rgba(10,15,38,0.5) 100%);"></div>
    <div style="position:absolute; left:0; right:0; top:0; height:26px; background:#05081A; background-image:repeating-linear-gradient(90deg, transparent 0 18px, rgba(244,245,250,0.16) 18px 34px, transparent 34px 52px); background-size:52px 12px; background-repeat:repeat-x; background-position:0 7px; z-index:2;"></div>
    <div style="position:absolute; left:0; right:0; bottom:0; height:26px; background:#05081A; background-image:repeating-linear-gradient(90deg, transparent 0 18px, rgba(244,245,250,0.16) 18px 34px, transparent 34px 52px); background-size:52px 12px; background-repeat:repeat-x; background-position:0 7px; z-index:2;"></div>
    <div style="position:relative; z-index:1; width:100%; display:flex; justify-content:space-between; align-items:center; gap:40px; padding:0 64px; flex-wrap:wrap;" class="reveal" data-m="prefooter-inner">
      <div style="max-width:760px; padding:40px 0;">
        <span class="eyebrow" style="color:#A9C0F5 !important;"<?php echo crux_edit_attr_opt( 'pf_eyebrow' ); ?>><?php echo esc_html( crux_opt( "pf_eyebrow" ) ); ?></span>
        <h2 class="bebas" style="font-size:clamp(44px, 5.5vw, 76px); line-height:0.95; margin:16px 0 18px; color:#FFFFFF; max-width:820px;"<?php echo crux_edit_attr_opt( $crux_pf["ids"]["title"] ); ?>><?php echo esc_html( $crux_pf["title"] ); ?></h2>
        <p style="font-size:16px; line-height:1.7; color:#C5CADF; max-width:540px; margin:0 0 32px;"<?php echo crux_edit_attr_opt( $crux_pf["ids"]["desc"] ); ?>><?php echo esc_html( $crux_pf["desc"] ); ?></p>
        <div style="display:flex; gap:16px;" data-m="ctas">
          <?php echo crux_prefooter_button( $crux_pf["btn1"] ); ?>
          <?php echo crux_prefooter_button( $crux_pf["btn2"] ); ?>
        </div>
      </div>
      <div class="prefooter__badge" style="width:160px; height:160px; flex:0 0 160px;">
        <a <?php echo crux_link_attrs( $crux_pf["badge_link"] ); ?> class="prefooter__badge-link" aria-label="<?php echo esc_attr( $crux_pf["aria"] ); ?>" style="display:block; width:100%; height:100%; text-decoration:none; transition:transform .3s ease;">
          <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/prefooter-badge-' . $crux_pf["badge_img"] . '.svg' ); ?>" class="prefooter__badge-img" alt="<?php echo esc_attr( $crux_pf["alt"] ); ?>" style="width:100%; height:100%; object-fit:contain; animation:rc-spin 14s linear infinite; filter:drop-shadow(0 12px 28px rgba(0,0,0,0.5));">
        </a>
      </div>
    </div>
  </section>

  <!-- COLOSSAL FOOTER -->
  <footer id="contact" style="background:<?php echo $crux_p["bg"]; ?>; padding:<?php echo esc_attr( $crux_pad ); ?>; text-align:center; position:relative; overflow:hidden;">
    <div style="position:relative; margin-bottom:40px;">
      <span class="bebas" style="font-size:clamp(80px,17vw,220px); line-height:0.82; display:block; background:linear-gradient(180deg, <?php echo $crux_p["hi"]; ?> 0%, <?php echo $crux_p["mid"]; ?> 25%, <?php echo $crux_p["lo"]; ?> 65%, transparent 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; position:relative;"<?php echo crux_edit_attr_opt( 'brand_1' ); ?>><?php echo esc_html( crux_opt( "brand_1" ) ); ?></span>
      <span class="bebas" style="font-size:clamp(30px,6.4vw,82px); line-height:1; display:block; background:linear-gradient(180deg, <?php echo $crux_p["hi"]; ?> 0%, <?php echo $crux_p["mid"]; ?> 25%, <?php echo $crux_p["lo"]; ?> 65%, transparent 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; position:relative; letter-spacing:0.5em; margin-top:10px; padding-left:0.5em;"<?php echo crux_edit_attr_opt( 'brand_2' ); ?>><?php echo esc_html( crux_opt( "brand_2" ) ); ?></span>
    </div>
    <div style="display:flex; justify-content:center; align-items:center; flex-wrap:wrap; gap:32px; margin-bottom:32px;" data-m="wrap">
      <a href="<?php echo esc_url( home_url( $crux_fw["home"] ) ); ?>" style="font-size:14px; color:<?php echo $crux_p["nav"]; ?>;">Home</a>
      <a href="<?php echo esc_url( home_url( $crux_fw["services"] ) ); ?>" style="font-size:14px; color:<?php echo $crux_p["nav"]; ?>;">Services</a>
      <a href="<?php echo esc_url( home_url( "/events/" ) ); ?>" style="font-size:14px; color:<?php echo $crux_p["nav"]; ?>;">Events</a>
      <a href="<?php echo esc_url( home_url( "/gallery/" ) ); ?>" style="font-size:14px; color:<?php echo $crux_p["nav"]; ?>;">Gallery</a>
      <a href="<?php echo esc_url( home_url( "/about/" ) ); ?>" style="font-size:14px; color:<?php echo $crux_p["nav"]; ?>;">About</a>
      <a href="<?php echo esc_url( home_url( "/faq/" ) ); ?>" style="font-size:14px; color:<?php echo $crux_p["nav"]; ?>;">FAQ</a>
      <a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" style="font-size:14px; color:<?php echo $crux_p["nav"]; ?>;">Blog</a>
      <a href="<?php echo esc_url( home_url( "/sponsors/" ) ); ?>" style="font-size:14px; color:<?php echo $crux_p["nav"]; ?>;">Sponsors</a>
    </div>
    <div style="display:flex; justify-content:center; gap:14px; margin-bottom:44px;" data-m="wrap">
      <a href="<?php echo esc_url( crux_social_url( "instagram" ) ); ?>"<?php echo crux_social_attrs( "instagram" ); ?><?php echo crux_edit_attr_opt( 'social_instagram' ); ?> aria-label="Instagram" style="display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; background:<?php echo $crux_p["soc_bg"]; ?>; color:<?php echo $crux_p["hi"]; ?>; --sl:7px; --bc:<?php echo $crux_p["soc_bc"]; ?>;" class="bx"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" stroke="currentColor" stroke-width="1.5"></rect><circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5"></circle><circle cx="17.4" cy="6.6" r="1" fill="currentColor"></circle></svg></a>
      <a href="<?php echo esc_url( crux_social_url( "tiktok" ) ); ?>"<?php echo crux_social_attrs( "tiktok" ); ?><?php echo crux_edit_attr_opt( 'social_tiktok' ); ?> aria-label="TikTok" style="display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; background:<?php echo $crux_p["soc_bg"]; ?>; color:<?php echo $crux_p["hi"]; ?>; --sl:7px; --bc:<?php echo $crux_p["soc_bc"]; ?>;" class="bx"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M14 3v10.5a3.5 3.5 0 1 1-3-3.46" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path><path d="M14 3c.4 2.6 2.2 4.4 4.8 4.8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path></svg></a>
      <a href="<?php echo esc_url( crux_social_url( "whatsapp" ) ); ?>"<?php echo crux_social_attrs( "whatsapp" ); ?><?php echo crux_edit_attr_opt( 'social_whatsapp' ); ?> aria-label="WhatsApp" style="display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; background:<?php echo $crux_p["soc_bg"]; ?>; color:<?php echo $crux_p["hi"]; ?>; --sl:7px; --bc:<?php echo $crux_p["soc_bc"]; ?>;" class="bx"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 20l1.4-4.1A8 8 0 1 1 9 19.5L4 20Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"></path><path d="M8.5 9.5c0 3.5 3 6.5 6.5 6.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path></svg></a>
    </div>
    <div style="display:flex; justify-content:center; flex-wrap:wrap; gap:8px 26px; margin-bottom:20px;" data-m="wrap">
      <a href="<?php echo esc_url( home_url( "/privacy-policy/" ) ); ?>" style="font-size:12.5px; color:#8E96BB;">Privacy Policy</a>
      <a href="<?php echo esc_url( home_url( "/cookie-policy/" ) ); ?>" style="font-size:12.5px; color:#8E96BB;">Cookie Policy</a>
      <a href="<?php echo esc_url( home_url( "/terms-conditions/" ) ); ?>" style="font-size:12.5px; color:#8E96BB;">Terms &amp; Conditions</a>
    </div>
    <div style="width:100%; max-width:900px; height:1px; background:<?php echo $crux_p["lo"]; ?>; margin:0 auto 24px;"></div>
    <p style="font-size:13px; color:<?php echo $crux_p["copy"]; ?>; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr_opt( 'copyright' ); ?>>&copy; <?php echo date( "Y" ); ?> <?php echo esc_html( crux_opt( "copyright" ) ); ?></p>
  </footer>
