<?php
/**
 * Template Name: Crux Nxtion - Template
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php crux_use_page_css( 'home' ); get_header( null, array( 'body_bg' => 'var(--crux-ink,#0A0F26)', 'root_bg' => 'var(--crux-ink,#0A0F26)', 'skin' => 'dark', 'nav' => 'events', 'wing' => 'events', 'active' => 'home' ) ); ?>

  <!-- HERO -->
  <section style="position:relative; height:700px; overflow:hidden; clip-path:polygon(0 0,100% 0,100% 92%,0 100%);">
    <img src="<?php echo crux_img_url( 'home', 'hero_photo_1' ); ?>" alt="Crowd dancing at a Crux Nxtion Events event" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:saturate(1.05) contrast(1.05);" class="drift"<?php echo crux_edit_attr( 'home', 'hero_photo_1' ); ?>>
    <div class="hero-dark-overlay" style="position:absolute; inset:0; background:linear-gradient(90deg, rgba(10,15,38,0.96) 0%, rgba(10,15,38,0.78) 42%, rgba(10,15,38,0.2) 78%);"></div>
    
    <div style="position:relative; height:100%; display:flex; flex-direction:column; justify-content:center; padding:0px 20px 0px 20px; max-width:760px;" class="reveal">
      <span class="eyebrow" style="font-size:11.5px !important; letter-spacing:0.8px !important; text-transform:none !important; font-weight:700 !important; color:var(--crux-blue,#5B8DEF); margin-bottom:14px; display:inline-block;"<?php echo crux_edit_attr( 'home', 'hero_small_heading_1' ); ?>><?php echo crux_h( 'home', 'hero_small_heading_1' ); ?></span>

      <h1 class="bebas" style="font-size:52px; margin:0px 0px 18px 0px; color:var(--crux-text,#F4F5FA); line-height:0.95;"<?php echo crux_edit_attr( 'home', 'hero_heading_1' ); ?>><?php echo crux_rich( 'home', 'hero_heading_1' ); ?></h1>
      <p class="hero-desc" style="font-size:16px !important; line-height:1.65; color:#C5CADF; max-width:580px; margin:0px 0px 28px 0px;"<?php echo crux_edit_attr( 'home', 'hero_paragraph_1' ); ?>><?php echo crux_h( 'home', 'hero_paragraph_1' ); ?></p>
      <div style="display:flex; gap:16px; flex-wrap:wrap;">
        <a href="<?php echo crux_url( 'home', 'hero_button_1_url' ); ?>" style="background:var(--crux-red,#BA0000); color:#FFFFFF; font-weight:700; font-size:15px; padding:16px 30px; --sl:10px;" class="bx"<?php echo crux_edit_attr( 'home', 'hero_button_1' ); ?>><?php echo crux_h( 'home', 'hero_button_1' ); ?></a>
        <a href="<?php echo crux_url( 'home', 'hero_button_2_url' ); ?>" style="background:var(--crux-purple,#8C7AE6); color:var(--crux-ink2,#10142E); font-weight:700; font-size:15px; padding:16px 28px; --sl:10px;" class="bx"<?php echo crux_edit_attr( 'home', 'hero_button_2' ); ?>><?php echo crux_h( 'home', 'hero_button_2' ); ?></a>
      </div>
    </div>
  </section>

    <!-- MARQUEE — SLANTED TO MATCH HERO CUT -->
  <div class="hero-slanted-marquee" style="background:var(--crux-navy,#002671); padding:18px 0; overflow:hidden; white-space:nowrap; margin-top:-53px; transform:skewY(-2.1deg); transform-origin:left top; z-index:2; position:relative; box-shadow:0 12px 30px rgba(0,0,0,0.4); border-top:1.5px solid rgba(91,141,239,0.4); border-bottom:1.5px solid rgba(91,141,239,0.2);">
    <div style="display:inline-flex; transform:skewY(2.1deg); animation:rc-marquee 22s linear infinite;">
      <span class="bebas" style="font-size:26px; color:#FFFFFF; letter-spacing:1.2px; padding-right:1ch;"<?php echo crux_edit_attr( 'home', 'marquee_text_1' ); ?>><?php echo crux_h( 'home', 'marquee_text_1' ); ?></span>
      <span class="bebas" style="font-size:26px; color:#FFFFFF; letter-spacing:1.2px; padding-right:1ch;" aria-hidden="true"<?php echo crux_edit_attr( 'home', 'marquee_text_1' ); ?>><?php echo crux_h( 'home', 'marquee_text_1' ); ?></span>
    </div>
  </div>

  <!-- SERVICES — rider / setlist rows -->
  <section id="services" style="min-height:560px; display:flex; flex-direction:column; justify-content:center; padding:44px 20px 44px 20px;" data-m="nomin">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:8px;" class="reveal" data-m="stack">
      <h2 class="bebas" style="font-size:34px; margin:0px 0px 0px 0px; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'services_heading_1' ); ?>><?php echo crux_h( 'home', 'services_heading_1' ); ?></h2>
      <span style="font-size:12px; color:#7A82A8; letter-spacing:2px; text-transform:uppercase;"<?php echo crux_edit_attr( 'home', 'services_text_1' ); ?>><?php echo crux_h( 'home', 'services_text_1' ); ?></span>
    </div>
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;" class="reveal" data-m="stack">
      <p style="max-width:500px; font-size:13px; color:#8E96BB; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'home', 'services_paragraph_1' ); ?>><?php echo crux_h( 'home', 'services_paragraph_1' ); ?></p>
      <a href="<?php echo crux_url( 'home', 'services_link_1_url' ); ?>" style="font-weight:700; font-size:13px; color:var(--crux-blue,#5B8DEF); border-bottom:1.5px solid var(--crux-blue,#5B8DEF); padding-bottom:2px;"<?php echo crux_edit_attr( 'home', 'services_link_1' ); ?>><?php echo crux_h( 'home', 'services_link_1' ); ?></a>
    </div>
    <div style="border-top:1.5px solid var(--crux-line,#1E2B5E);" class="reveal">

      <div style="display:flex; align-items:center; gap:22px; padding:22px 28px 22px 28px; border-bottom:1.5px solid var(--crux-line,#1E2B5E);" data-m="svcrow">
        <span class="bebas" style="font-size:36px; color:var(--crux-blue,#5B8DEF); flex:0 0 54px;">01</span>
        <img src="<?php echo crux_img_url( 'home', 'services_photo_1' ); ?>" alt="" style="width:64px; height:64px; object-fit:cover; border-radius:10px; flex:0 0 64px;"<?php echo crux_edit_attr( 'home', 'services_photo_1' ); ?>>
        <div style="flex:1;">
          <h3 style="font-size:17px; margin:0px 0px 4px 0px; font-weight:700;"<?php echo crux_edit_attr( 'home', 'services_heading_2' ); ?>><?php echo crux_h( 'home', 'services_heading_2' ); ?></h3>
          <p style="font-size:13px; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'home', 'services_paragraph_2' ); ?>><?php echo crux_h( 'home', 'services_paragraph_2' ); ?></p>
        </div>
        <span class="bebas" style="font-size:26px; color:var(--crux-blue,#5B8DEF); flex:0 0 auto;">→</span>
      </div>

      <div style="display:flex; align-items:center; gap:22px; padding:22px 28px 22px 28px; border-bottom:1.5px solid var(--crux-line,#1E2B5E); background:rgba(244,245,250,0.02);" data-m="svcrow">
        <span class="bebas" style="font-size:36px; color:var(--crux-crimson,#E5383B); flex:0 0 54px;">02</span>
        <img src="<?php echo crux_img_url( 'home', 'services_photo_2' ); ?>" alt="" style="width:64px; height:64px; object-fit:cover; border-radius:10px; flex:0 0 64px;"<?php echo crux_edit_attr( 'home', 'services_photo_2' ); ?>>
        <div style="flex:1;">
          <h3 style="font-size:17px; margin:0px 0px 4px 0px; font-weight:700;"<?php echo crux_edit_attr( 'home', 'services_heading_3' ); ?>><?php echo crux_h( 'home', 'services_heading_3' ); ?></h3>
          <p style="font-size:13px; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'home', 'services_paragraph_3' ); ?>><?php echo crux_h( 'home', 'services_paragraph_3' ); ?></p>
        </div>
        <span class="bebas" style="font-size:26px; color:var(--crux-blue,#5B8DEF); flex:0 0 auto;">→</span>
      </div>

      <div style="display:flex; align-items:center; gap:22px; padding:22px 28px 22px 28px; border-bottom:1.5px solid var(--crux-line,#1E2B5E);" data-m="svcrow">
        <span class="bebas" style="font-size:36px; color:var(--crux-blue,#5B8DEF); flex:0 0 54px;">03</span>
        <img src="<?php echo crux_img_url( 'home', 'services_photo_3' ); ?>" alt="" style="width:64px; height:64px; object-fit:cover; border-radius:10px; flex:0 0 64px;"<?php echo crux_edit_attr( 'home', 'services_photo_3' ); ?>>
        <div style="flex:1;">
          <h3 style="font-size:17px; margin:0px 0px 4px 0px; font-weight:700;"<?php echo crux_edit_attr( 'home', 'services_heading_4' ); ?>><?php echo crux_h( 'home', 'services_heading_4' ); ?></h3>
          <p style="font-size:13px; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'home', 'services_paragraph_4' ); ?>><?php echo crux_h( 'home', 'services_paragraph_4' ); ?></p>
        </div>
        <span class="bebas" style="font-size:26px; color:var(--crux-blue,#5B8DEF); flex:0 0 auto;">→</span>
      </div>

      <div style="display:flex; align-items:center; gap:22px; padding:22px 28px 22px 28px; border-bottom:1.5px solid var(--crux-line,#1E2B5E); background:rgba(244,245,250,0.02);" data-m="svcrow">
        <span class="bebas" style="font-size:36px; color:var(--crux-crimson,#E5383B); flex:0 0 54px;">04</span>
        <img src="<?php echo crux_img_url( 'home', 'services_photo_4' ); ?>" alt="" style="width:64px; height:64px; object-fit:cover; border-radius:10px; flex:0 0 64px;"<?php echo crux_edit_attr( 'home', 'services_photo_4' ); ?>>
        <div style="flex:1;">
          <h3 style="font-size:17px; margin:0px 0px 4px 0px; font-weight:700;"<?php echo crux_edit_attr( 'home', 'services_heading_5' ); ?>><?php echo crux_h( 'home', 'services_heading_5' ); ?></h3>
          <p style="font-size:13px; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'home', 'services_paragraph_5' ); ?>><?php echo crux_h( 'home', 'services_paragraph_5' ); ?></p>
        </div>
        <span class="bebas" style="font-size:26px; color:var(--crux-blue,#5B8DEF); flex:0 0 auto;">→</span>
      </div>

      <div style="display:flex; align-items:center; gap:22px; padding:22px 28px 22px 28px; border-bottom:1.5px solid var(--crux-line,#1E2B5E);" data-m="svcrow">
        <span class="bebas" style="font-size:36px; color:var(--crux-blue,#5B8DEF); flex:0 0 54px;">05</span>
        <img src="<?php echo crux_img_url( 'home', 'services_photo_5' ); ?>" alt="" style="width:64px; height:64px; object-fit:cover; border-radius:10px; flex:0 0 64px;"<?php echo crux_edit_attr( 'home', 'services_photo_5' ); ?>>
        <div style="flex:1;">
          <h3 style="font-size:17px; margin:0px 0px 4px 0px; font-weight:700;"<?php echo crux_edit_attr( 'home', 'services_heading_6' ); ?>><?php echo crux_h( 'home', 'services_heading_6' ); ?></h3>
          <p style="font-size:13px; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'home', 'services_paragraph_6' ); ?>><?php echo crux_h( 'home', 'services_paragraph_6' ); ?></p>
        </div>
        <span class="bebas" style="font-size:26px; color:var(--crux-blue,#5B8DEF); flex:0 0 auto;">→</span>
      </div>
    </div>
  </section>

  <!-- EVENTS — ticket stub -->
  <section id="events" style="min-height:560px; display:flex; flex-direction:column; justify-content:center; padding:20px 20px 44px 20px;" data-m="nomin">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:30px;" class="reveal" data-m="stack">
      <h2 class="bebas" style="font-size:34px; margin:0px 0px 0px 0px; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'events_heading_1' ); ?>><?php echo crux_h( 'home', 'events_heading_1' ); ?></h2>
      <div style="text-align:right;">
        <p style="max-width:360px; font-size:13.5px; color:#A3A9C8; margin:0px 0px 8px 0px;"<?php echo crux_edit_attr( 'home', 'events_paragraph_1' ); ?>><?php echo crux_h( 'home', 'events_paragraph_1' ); ?></p>
        <a href="<?php echo crux_url( 'home', 'events_link_1_url' ); ?>" style="font-weight:700; font-size:13px; color:var(--crux-blue,#5B8DEF); border-bottom:1.5px solid var(--crux-blue,#5B8DEF); padding-bottom:2px;"<?php echo crux_edit_attr( 'home', 'events_link_1' ); ?>><?php echo crux_h( 'home', 'events_link_1' ); ?></a>
      </div>
    </div>

    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:22px;" data-m="g1">
      <?php
      $featured_events = function_exists( 'crux_get_all_events' ) ? crux_get_all_events( array( 'posts_per_page' => 3 ) ) : array();
      $feat_idx = 0;
      $default_rotations = array( '-1deg', '0.8deg', '-0.6deg' );
      foreach ( $featured_events as $fe_slug => $fe_item ) :
          if ( $feat_idx >= 3 ) break;
          $stub_bg = ! empty( $fe_item['badge_bg'] ) ? $fe_item['badge_bg'] : 'var(--crux-navy,#002671)';
          $stub_txt = ! empty( $fe_item['badge_color'] ) ? $fe_item['badge_color'] : '#FFFFFF';
          $rot = $default_rotations[ $feat_idx % 3 ];
          $target_url = ! empty( $fe_item['permalink'] ) ? $fe_item['permalink'] : home_url( '/event/' . $fe_slug . '/' );
          $sub_meta = ! empty( $fe_item['eventbrite'] ) ? 'Tickets on Eventbrite' : ( ! empty( $fe_item['time_str'] ) ? $fe_item['time_str'] : $fe_item['location'] );
          $feat_idx++;
      ?>
      <a href="<?php echo esc_url( $target_url ); ?>" class="tilt-ticket" style="display:flex; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; min-height:330px; --r:<?php echo esc_attr( $rot ); ?>; transform:rotate(var(--r)); overflow:hidden;" data-m="tile">
        <div class="ticket-stub" style="flex:0 0 90px; background:<?php echo esc_attr( $stub_bg ); ?>; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px;">
          <span class="bebas" style="font-size:38px; color:<?php echo esc_attr( $stub_txt ); ?>; line-height:1;"><?php echo esc_html( $fe_item['date_badge_day'] ); ?></span>
          <span style="font-size:10px; font-weight:800; letter-spacing:1.5px; color:<?php echo esc_attr( $stub_txt ); ?>; text-align:center;"><?php echo esc_html( $fe_item['date_badge_month'] . ' ' . $fe_item['year'] ); ?></span>
        </div>
        <div style="flex:1; display:flex; flex-direction:column; min-width:0;">
          <div style="flex:1; position:relative; min-height:180px;"><img src="<?php echo esc_url( $fe_item['hero_url'] ); ?>" alt="<?php echo esc_attr( $fe_item['short_title'] ); ?>" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center top;"></div>
          <div style=" padding:16px 18px 18px 18px; background:#0D1330; border-top:1.5px dashed var(--crux-line,#1E2B5E);">
            <span class="eyebrow" style="color:var(--crux-blue,#5B8DEF);"><?php echo esc_html( $fe_item['category'] ); ?></span>
            <h3 style="font-size:19px; margin:8px 0px 4px 0px; font-weight:700; color:#FFFFFF;"><?php echo esc_html( $fe_item['short_title'] ); ?></h3>
            <p style="font-size:12.5px; color:#C5CFF5; margin:0px 0px 10px 0px;"><?php echo esc_html( $sub_meta ); ?></p>
            <span style="font-weight:700; font-size:12.5px; color:var(--crux-blue,#5B8DEF); border-bottom:1.5px solid var(--crux-blue,#5B8DEF); padding-bottom:2px;"<?php echo crux_edit_attr( 'home', 'events_text_1' ); ?>><?php echo crux_h( 'home', 'events_text_1' ); ?></span>
          </div>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </section>

    <!-- ALSO FROM CRUX — consultancy fork -->
  <section style="min-height:560px; display:flex; flex-direction:column; justify-content:center; padding:40px 20px 44px 20px;" data-m="nomin">
    <div style="display:grid; grid-template-columns:1fr 1fr; min-height:660px; border-radius:26px; overflow:hidden; border:1.5px solid var(--crux-line,#1E2B5E); background:var(--crux-surface,#111838);" class="reveal" data-m="g1">
      <div style=" padding:44px 50px 44px 60px; display:flex; flex-direction:column; justify-content:center;" class="reveal also-from-crux-content">
        <span class="eyebrow" style="color:#B7A6FF !important;"<?php echo crux_edit_attr( 'home', 'also_from_crux_small_heading_1' ); ?>><?php echo crux_h( 'home', 'also_from_crux_small_heading_1' ); ?></span>
        <h2 class="bebas" style="font-size:40px; margin:14px 0px 18px 0px; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'also_from_crux_heading_1' ); ?>><?php echo crux_h( 'home', 'also_from_crux_heading_1' ); ?></h2>
        <p style="font-size:16px; line-height:1.75; color:#C5CADF; max-width:480px; margin:0px 0px 26px 0px;"<?php echo crux_edit_attr( 'home', 'also_from_crux_paragraph_1' ); ?>><?php echo crux_h( 'home', 'also_from_crux_paragraph_1' ); ?></p>
        <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:34px;">
          <div style="display:flex; align-items:center; gap:14px;"><span class="bebas" style="font-size:22px; color:#B7A6FF; width:32px;">01</span><span style="font-size:14.5px; font-weight:600; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'also_from_crux_text_1' ); ?>><?php echo crux_h( 'home', 'also_from_crux_text_1' ); ?></span></div>
          <div style="display:flex; align-items:center; gap:14px;"><span class="bebas" style="font-size:22px; color:#B7A6FF; width:32px;">02</span><span style="font-size:14.5px; font-weight:600; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'also_from_crux_text_2' ); ?>><?php echo crux_h( 'home', 'also_from_crux_text_2' ); ?></span></div>
          <div style="display:flex; align-items:center; gap:14px;"><span class="bebas" style="font-size:22px; color:#B7A6FF; width:32px;">03</span><span style="font-size:14.5px; font-weight:600; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'also_from_crux_text_3' ); ?>><?php echo crux_h( 'home', 'also_from_crux_text_3' ); ?></span></div>
          <div style="display:flex; align-items:center; gap:14px;"><span class="bebas" style="font-size:22px; color:#B7A6FF; width:32px;">04</span><span style="font-size:14.5px; font-weight:600; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'also_from_crux_text_4' ); ?>><?php echo crux_h( 'home', 'also_from_crux_text_4' ); ?></span></div>
        </div>
        <a href="<?php echo crux_url( 'home', 'also_from_crux_button_1_url' ); ?>" style="background:var(--crux-purple,#8C7AE6); color:var(--crux-ink,#0A0F26); font-weight:700; font-size:15px; padding:16px 30px 16px 30px; display:inline-block; width:fit-content; --sl:10px;" class="bx"<?php echo crux_edit_attr( 'home', 'also_from_crux_button_1' ); ?>><?php echo crux_h( 'home', 'also_from_crux_button_1' ); ?></a>
      </div>
      <div style="position:relative; overflow:hidden;" class="reveal" data-m="tile">
        <img src="<?php echo crux_img_url( 'home', 'also_from_crux_photo_1' ); ?>" alt="A Crux Nxtion Consultancy session" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'home', 'also_from_crux_photo_1' ); ?>>
        <div style="position:absolute; inset:0; background:linear-gradient(90deg, rgba(27,32,72,0.85) 0%, rgba(91,141,239,0.12) 60%);"></div>



        <div style="position:absolute; left:30px; bottom:30px; right:30px; display:flex; flex-direction:column; gap:10px; z-index:2;">
          <div class="float" style="--r:0deg; align-self:flex-end; max-width:85%; background:var(--crux-line,#1E2B5E); color:var(--crux-text,#F4F5FA); font-size:13px; line-height:1.5; padding:11px 15px; border-radius:16px 16px 4px 16px;"<?php echo crux_edit_attr( 'home', 'also_from_crux_text_5' ); ?>><?php echo crux_h( 'home', 'also_from_crux_text_5' ); ?></div>
          <div style="align-self:flex-start; max-width:85%; background:var(--crux-purple,#8C7AE6); color:var(--crux-ink,#0A0F26); font-size:13px; font-weight:600; line-height:1.5; padding:11px 15px; border-radius:16px 16px 16px 4px;"<?php echo crux_edit_attr( 'home', 'also_from_crux_text_6' ); ?>><?php echo crux_h( 'home', 'also_from_crux_text_6' ); ?></div>
        </div>
      </div>
    </div>
  </section>

  <!-- GALLERY — ticket wall (matches the Gallery page) -->
  <section id="gallery" style=" padding:30px 20px 44px 20px;">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:30px;" class="reveal" data-m="stack">
      <div><span class="eyebrow"<?php echo crux_edit_attr( 'home', 'gallery_small_heading_1' ); ?>><?php echo crux_h( 'home', 'gallery_small_heading_1' ); ?></span><h2 class="bebas" style="font-size:40px; margin:12px 0px 0px 0px; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'gallery_heading_1' ); ?>><?php echo crux_h( 'home', 'gallery_heading_1' ); ?></h2><p style="font-size:15px; color:#A3A9C8; max-width:520px; margin:12px 0px 0px 0px;"<?php echo crux_edit_attr( 'home', 'gallery_paragraph_1' ); ?>><?php echo crux_h( 'home', 'gallery_paragraph_1' ); ?></p></div>
      <a href="<?php echo crux_url( 'home', 'gallery_link_1_url' ); ?>" style="font-weight:700; font-size:13px; color:var(--crux-blue,#5B8DEF); border-bottom:1.5px solid var(--crux-blue,#5B8DEF); padding-bottom:2px; white-space:nowrap;"<?php echo crux_edit_attr( 'home', 'gallery_link_1' ); ?>><?php echo crux_h( 'home', 'gallery_link_1' ); ?></a>
    </div>
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:34px 26px; align-items:start;" class="reveal" data-m="g2">
      <a href="#" style="display:flex; flex-direction:column; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; overflow:hidden; transform:rotate(-1deg);" class="reveal">
        <div style="position:relative; height:240px;"><img src="<?php echo crux_img_url( 'home', 'gallery_photo_1' ); ?>" alt="Crux Nxtion Events frame 1" style="width:100%; height:100%; object-fit:cover; display:block;"<?php echo crux_edit_attr( 'home', 'gallery_photo_1' ); ?>></div>
        <div class="strip-stub" style="background:var(--crux-navy,#002671); padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"<?php echo crux_edit_attr( 'home', 'gallery_text_1' ); ?>><?php echo crux_h( 'home', 'gallery_text_1' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"<?php echo crux_edit_attr( 'home', 'gallery_text_2' ); ?>><?php echo crux_h( 'home', 'gallery_text_2' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; overflow:hidden; transform:rotate(0.8deg);" class="reveal">
        <div style="position:relative; height:280px;"><img src="<?php echo crux_img_url( 'home', 'gallery_photo_2' ); ?>" alt="Crux Nxtion Events frame 2" style="width:100%; height:100%; object-fit:cover; display:block;"<?php echo crux_edit_attr( 'home', 'gallery_photo_2' ); ?>></div>
        <div class="strip-stub" style="background:var(--crux-red,#BA0000); padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"<?php echo crux_edit_attr( 'home', 'gallery_text_3' ); ?>><?php echo crux_h( 'home', 'gallery_text_3' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"<?php echo crux_edit_attr( 'home', 'gallery_text_4' ); ?>><?php echo crux_h( 'home', 'gallery_text_4' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; overflow:hidden; transform:rotate(-0.8deg);" class="reveal">
        <div style="position:relative; height:220px;"><img src="<?php echo crux_img_url( 'home', 'gallery_photo_3' ); ?>" alt="Crux Nxtion Events frame 3" style="width:100%; height:100%; object-fit:cover; display:block;"<?php echo crux_edit_attr( 'home', 'gallery_photo_3' ); ?>></div>
        <div class="strip-stub" style="background:var(--crux-purple,#8C7AE6); padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:var(--crux-ink,#0A0F26);"<?php echo crux_edit_attr( 'home', 'gallery_text_5' ); ?>><?php echo crux_h( 'home', 'gallery_text_5' ); ?></span><span class="bebas" style="font-size:14px; color:var(--crux-ink,#0A0F26);"<?php echo crux_edit_attr( 'home', 'gallery_text_6' ); ?>><?php echo crux_h( 'home', 'gallery_text_6' ); ?></span></div>
      </a>
    </div>
  </section>

  <!-- WHY CRUX -->
  <section style="min-height:560px; display:flex; flex-direction:column; justify-content:center; padding:20px 20px 44px 20px;" data-m="nomin">
    <div style="text-align:center; margin-bottom:44px;" class="reveal"><span class="eyebrow"<?php echo crux_edit_attr( 'home', 'why_crux_small_heading_1' ); ?>><?php echo crux_h( 'home', 'why_crux_small_heading_1' ); ?></span><h2 class="bebas" style="font-size:34px; margin:14px 0px 0px 0px; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'why_crux_heading_1' ); ?>><?php echo crux_h( 'home', 'why_crux_heading_1' ); ?></h2></div>
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:22px;" class="reveal" data-m="g1">
      <div style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:18px; overflow:hidden;" class="reveal">
        <div style="height:220px; overflow:hidden;"><img src="<?php echo crux_img_url( 'home', 'why_crux_photo_1' ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'home', 'why_crux_photo_1' ); ?>></div>
        <div style=" padding:26px 28px 30px 28px;"><h3 class="bebas" style="font-size:30px; margin:0px 0px 10px 0px; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'why_crux_heading_2' ); ?>><?php echo crux_h( 'home', 'why_crux_heading_2' ); ?></h3><p style="font-size:14px; line-height:1.65; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'home', 'why_crux_paragraph_1' ); ?>><?php echo crux_h( 'home', 'why_crux_paragraph_1' ); ?></p></div>
      </div>
      <div style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:18px; overflow:hidden;" class="reveal">
        <div style="height:220px; overflow:hidden;"><img src="<?php echo crux_img_url( 'home', 'why_crux_photo_2' ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'home', 'why_crux_photo_2' ); ?>></div>
        <div style=" padding:26px 28px 30px 28px;"><h3 class="bebas" style="font-size:30px; margin:0px 0px 10px 0px; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'why_crux_heading_3' ); ?>><?php echo crux_h( 'home', 'why_crux_heading_3' ); ?></h3><p style="font-size:14px; line-height:1.65; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'home', 'why_crux_paragraph_2' ); ?>><?php echo crux_h( 'home', 'why_crux_paragraph_2' ); ?></p></div>
      </div>
      <div style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:18px; overflow:hidden;" class="reveal">
        <div style="height:220px; overflow:hidden;"><img src="<?php echo crux_img_url( 'home', 'why_crux_photo_3' ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'home', 'why_crux_photo_3' ); ?>></div>
        <div style=" padding:26px 28px 30px 28px;"><h3 class="bebas" style="font-size:30px; margin:0px 0px 10px 0px; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'why_crux_heading_4' ); ?>><?php echo crux_h( 'home', 'why_crux_heading_4' ); ?></h3><p style="font-size:14px; line-height:1.65; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'home', 'why_crux_paragraph_3' ); ?>><?php echo crux_h( 'home', 'why_crux_paragraph_3' ); ?></p></div>
      </div>
    </div>
  </section>

  <!-- PROCESS — how we run your event -->
  <section style="min-height:560px; display:flex; flex-direction:column; justify-content:center; padding:44px 20px 44px 20px;" data-m="nomin">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:46px;" class="reveal" data-m="stack">
      <div><span class="eyebrow"<?php echo crux_edit_attr( 'home', 'process_small_heading_1' ); ?>><?php echo crux_h( 'home', 'process_small_heading_1' ); ?></span><h2 class="bebas" style="font-size:34px; margin:12px 0px 0px 0px; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'process_heading_1' ); ?>><?php echo crux_h( 'home', 'process_heading_1' ); ?></h2></div>
      <p style="max-width:340px; font-size:14px; line-height:1.7; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'home', 'process_paragraph_1' ); ?>><?php echo crux_h( 'home', 'process_paragraph_1' ); ?></p>
    </div>
    <div style="position:relative; display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:26px;" class="reveal" data-m="g1">
      <div class="tilt-ticket reveal" style="display:flex; flex-direction:column; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; overflow:hidden; --r:-1deg; transform:rotate(var(--r));">
        <div style="height:190px; overflow:hidden;"><img src="<?php echo crux_img_url( 'home', 'process_photo_1' ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'home', 'process_photo_1' ); ?>></div>
        <div class="strip-stub" style="background:var(--crux-navy,#002671); padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"<?php echo crux_edit_attr( 'home', 'process_text_1' ); ?>><?php echo crux_h( 'home', 'process_text_1' ); ?></span><span class="bebas" style="font-size:18px; color:#FFFFFF;"<?php echo crux_edit_attr( 'home', 'process_text_2' ); ?>><?php echo crux_h( 'home', 'process_text_2' ); ?></span></div>
        <div style=" padding:24px 22px 26px 22px;"><p style="font-size:14px; line-height:1.7; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'home', 'process_paragraph_2' ); ?>><?php echo crux_h( 'home', 'process_paragraph_2' ); ?></p></div>
      </div>
      <div class="tilt-ticket reveal" style="display:flex; flex-direction:column; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; overflow:hidden; --r:0.8deg; transform:rotate(var(--r));">
        <div style="height:190px; overflow:hidden;"><img src="<?php echo crux_img_url( 'home', 'process_photo_2' ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'home', 'process_photo_2' ); ?>></div>
        <div class="strip-stub" style="background:var(--crux-red,#BA0000); padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"<?php echo crux_edit_attr( 'home', 'process_text_3' ); ?>><?php echo crux_h( 'home', 'process_text_3' ); ?></span><span class="bebas" style="font-size:18px; color:#FFFFFF;"<?php echo crux_edit_attr( 'home', 'process_text_4' ); ?>><?php echo crux_h( 'home', 'process_text_4' ); ?></span></div>
        <div style=" padding:24px 22px 26px 22px;"><p style="font-size:14px; line-height:1.7; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'home', 'process_paragraph_3' ); ?>><?php echo crux_h( 'home', 'process_paragraph_3' ); ?></p></div>
      </div>
      <div class="tilt-ticket reveal" style="display:flex; flex-direction:column; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; overflow:hidden; --r:-0.8deg; transform:rotate(var(--r));">
        <div style="height:190px; overflow:hidden;"><img src="<?php echo crux_img_url( 'home', 'process_photo_3' ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'home', 'process_photo_3' ); ?>></div>
        <div class="strip-stub" style="background:var(--crux-purple,#8C7AE6); padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:var(--crux-ink,#0A0F26);"<?php echo crux_edit_attr( 'home', 'process_text_5' ); ?>><?php echo crux_h( 'home', 'process_text_5' ); ?></span><span class="bebas" style="font-size:18px; color:var(--crux-ink,#0A0F26);"<?php echo crux_edit_attr( 'home', 'process_text_6' ); ?>><?php echo crux_h( 'home', 'process_text_6' ); ?></span></div>
        <div style=" padding:24px 22px 26px 22px;"><p style="font-size:14px; line-height:1.7; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'home', 'process_paragraph_4' ); ?>><?php echo crux_h( 'home', 'process_paragraph_4' ); ?></p></div>
      </div>
      <div class="tilt-ticket reveal" style="display:flex; flex-direction:column; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; overflow:hidden; --r:1deg; transform:rotate(var(--r));">
        <div style="height:190px; overflow:hidden;"><img src="<?php echo crux_img_url( 'home', 'process_photo_4' ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'home', 'process_photo_4' ); ?>></div>
        <div class="strip-stub" style="background:var(--crux-navy,#002671); padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"<?php echo crux_edit_attr( 'home', 'process_text_7' ); ?>><?php echo crux_h( 'home', 'process_text_7' ); ?></span><span class="bebas" style="font-size:18px; color:#FFFFFF;"<?php echo crux_edit_attr( 'home', 'process_text_8' ); ?>><?php echo crux_h( 'home', 'process_text_8' ); ?></span></div>
        <div style=" padding:24px 22px 26px 22px;"><p style="font-size:14px; line-height:1.7; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'home', 'process_paragraph_5' ); ?>><?php echo crux_h( 'home', 'process_paragraph_5' ); ?></p></div>
      </div>
    </div>
  </section>

  <!-- MINI ABOUT — centered manifesto + photo strip -->
  <section id="about" style="min-height:560px; display:flex; flex-direction:column; justify-content:center; background:var(--crux-surface,#111838); padding:44px 20px 44px 20px; text-align:center;" data-m="nomin">
    <span class="eyebrow"<?php echo crux_edit_attr( 'home', 'mini_about_small_heading_1' ); ?>><?php echo crux_h( 'home', 'mini_about_small_heading_1' ); ?></span>
    <p class="bebas reveal" style="font-size:34px; line-height:1.08; margin:18px auto 20px; max-width:840px; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'mini_about_paragraph_1' ); ?>><?php echo crux_h( 'home', 'mini_about_paragraph_1' ); ?></p>
    <p style="font-size:14.5px; line-height:1.7; color:#A3A9C8; max-width:480px; margin:0 auto 46px;" class="reveal"<?php echo crux_edit_attr( 'home', 'mini_about_paragraph_2' ); ?>><?php echo crux_h( 'home', 'mini_about_paragraph_2' ); ?></p>

    <div class="mini-about-strip reveal" style="display:flex; justify-content:center; align-items:center; gap:18px; margin-bottom:44px;">
      <img class="tilt-straighten" src="<?php echo crux_img_url( 'home', 'mini_about_photo_1' ); ?>" alt="" style="width:150px; height:190px; object-fit:cover; border-radius:10px; --r:-4deg; transform:rotate(var(--r)); border:2px solid var(--crux-line,#1E2B5E);"<?php echo crux_edit_attr( 'home', 'mini_about_photo_1' ); ?>>
      <img src="<?php echo crux_img_url( 'home', 'mini_about_photo_2' ); ?>" alt="" style="width:170px; height:220px; object-fit:cover; border-radius:10px; z-index:1; border:2px solid var(--crux-blue,#5B8DEF);"<?php echo crux_edit_attr( 'home', 'mini_about_photo_2' ); ?>>
      <img class="tilt-straighten" src="<?php echo crux_img_url( 'home', 'mini_about_photo_3' ); ?>" alt="" style="width:150px; height:190px; object-fit:cover; border-radius:10px; --r:4deg; transform:rotate(var(--r)); border:2px solid var(--crux-line,#1E2B5E);"<?php echo crux_edit_attr( 'home', 'mini_about_photo_3' ); ?>>
    </div>

    <div style="display:flex; gap:12px; justify-content:center;" class="reveal" data-m="wrap">
      <span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12px; padding:10px 18px 10px 18px;"<?php echo crux_edit_attr( 'home', 'mini_about_text_1' ); ?>><?php echo crux_h( 'home', 'mini_about_text_1' ); ?></span>
      <span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12px; padding:10px 18px 10px 18px;"<?php echo crux_edit_attr( 'home', 'mini_about_text_2' ); ?>><?php echo crux_h( 'home', 'mini_about_text_2' ); ?></span>
      <span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12px; padding:10px 18px 10px 18px;"<?php echo crux_edit_attr( 'home', 'mini_about_text_3' ); ?>><?php echo crux_h( 'home', 'mini_about_text_3' ); ?></span>
    </div>
  </section>

    <!-- FOUNDER — Curated Best Bits for Events -->
  <section id="founder" style="padding:64px 20px; background:var(--crux-surface,#111838); display:grid; grid-template-columns:0.8fr 1.2fr; gap:60px; align-items:center;" data-m="g1">
    <div class="tilt-straighten reveal" style="--r:-2deg; transform:rotate(var(--r)); border-radius:22px; overflow:hidden; border:2px solid var(--crux-blue,#5B8DEF); height:470px;">
      <img src="<?php echo crux_img_url( 'home', 'founder_photo_1' ); ?>" alt="Olabamidele 'Bambad' Badmos, founder of Crux Nxtion" style="width:100%; height:100%; object-fit:cover; object-position:58% 12%;"<?php echo crux_edit_attr( 'home', 'founder_photo_1' ); ?>>
    </div>
    <div class="reveal">
      <span class="eyebrow" style="color:var(--crux-blue,#5B8DEF);"<?php echo crux_edit_attr( 'home', 'founder_small_heading_1' ); ?>><?php echo crux_h( 'home', 'founder_small_heading_1' ); ?></span>
      <h2 class="bebas" style="font-size:54px; margin:14px 0 20px; color:var(--crux-text,#F4F5FA); line-height:0.95;"<?php echo crux_edit_attr( 'home', 'founder_heading_1' ); ?>><?php echo crux_h( 'home', 'founder_heading_1' ); ?></h2>
      <p style="font-size:16px; line-height:1.75; color:#C5CADF; max-width:620px; margin:0 0 14px;"<?php echo crux_edit_attr( 'home', 'founder_paragraph_1' ); ?>><?php echo crux_rich( 'home', 'founder_paragraph_1' ); ?></p>
      <p style="font-size:16px; line-height:1.75; color:#C5CADF; max-width:620px; margin:0 0 26px;"<?php echo crux_edit_attr( 'home', 'founder_paragraph_2' ); ?>><?php echo crux_rich( 'home', 'founder_paragraph_2' ); ?></p>
      <div style="display:flex; gap:12px; flex-wrap:wrap; margin-bottom:28px;" data-m="wrap">
        <span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12.5px; padding:9px 18px;"<?php echo crux_edit_attr( 'home', 'founder_text_1' ); ?>><?php echo crux_h( 'home', 'founder_text_1' ); ?></span>
        <span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12.5px; padding:9px 18px;"<?php echo crux_edit_attr( 'home', 'founder_text_2' ); ?>><?php echo crux_h( 'home', 'founder_text_2' ); ?></span>
        <span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12.5px; padding:9px 18px;"<?php echo crux_edit_attr( 'home', 'founder_text_3' ); ?>><?php echo crux_h( 'home', 'founder_text_3' ); ?></span>
        <span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12.5px; padding:9px 18px;"<?php echo crux_edit_attr( 'home', 'founder_text_4' ); ?>><?php echo crux_h( 'home', 'founder_text_4' ); ?></span>
      </div>
      <a href="<?php echo crux_url( 'home', 'founder_button_1_url' ); ?>" style="background:var(--crux-red,#BA0000); color:#FFFFFF; font-weight:700; font-size:14px; padding:15px 28px; --sl:10px;" class="bx"<?php echo crux_edit_attr( 'home', 'founder_button_1' ); ?>><?php echo crux_h( 'home', 'founder_button_1' ); ?></a>
    </div>
  </section>

    <!-- FAQ — interactive accordion (matching FAQS page design) -->
  <section id="faq" style="min-height:560px; display:flex; flex-direction:column; justify-content:center; padding:65px 64px;" data-m="nomin">
    <div style="text-align:center; margin-bottom:46px;" class="reveal">
      <span class="eyebrow"<?php echo crux_edit_attr( 'home', 'faq_small_heading_1' ); ?>><?php echo crux_h( 'home', 'faq_small_heading_1' ); ?></span>
      <h2 class="bebas" style="font-size:56px; margin:14px 0 10px; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'faq_heading_1' ); ?>><?php echo crux_h( 'home', 'faq_heading_1' ); ?></h2>
      <p style="font-size:14px; color:#A3A9C8; margin:0;"><?php echo crux_h( 'home', 'faq_paragraph_1' ); ?> <a href="<?php echo crux_url( 'home', 'faq_link_1_url' ); ?>" style="color:var(--crux-blue,#5B8DEF); font-weight:700;"<?php echo crux_edit_attr( 'home', 'faq_link_1' ); ?>><?php echo crux_h( 'home', 'faq_link_1' ); ?></a></p>
    </div>
    <div style="max-width:960px; width:100%; margin:0 auto; display:flex; flex-direction:column; gap:14px;" class="reveal">
      <details style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; padding:0 26px; transition:border-color .25s ease;">
        <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
          <h3 style="font-size:17px; margin:0; font-weight:700; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'faq_heading_2' ); ?>><?php echo crux_h( 'home', 'faq_heading_2' ); ?></h3>
          <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:var(--crux-navy,#002671); color:#FFFFFF; display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
        </summary>
        <p style="font-size:15px; line-height:1.75; color:#A3A9C8; margin:0 0 24px; max-width:820px;"<?php echo crux_edit_attr( 'home', 'faq_paragraph_2' ); ?>><?php echo crux_h( 'home', 'faq_paragraph_2' ); ?></p>
      </details>
      <details style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; padding:0 26px; transition:border-color .25s ease;">
        <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
          <h3 style="font-size:17px; margin:0; font-weight:700; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'faq_heading_3' ); ?>><?php echo crux_h( 'home', 'faq_heading_3' ); ?></h3>
          <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:var(--crux-navy,#002671); color:#FFFFFF; display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
        </summary>
        <p style="font-size:15px; line-height:1.75; color:#A3A9C8; margin:0 0 24px; max-width:820px;"<?php echo crux_edit_attr( 'home', 'faq_paragraph_3' ); ?>><?php echo crux_h( 'home', 'faq_paragraph_3' ); ?></p>
      </details>
      <details style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; padding:0 26px; transition:border-color .25s ease;">
        <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
          <h3 style="font-size:17px; margin:0; font-weight:700; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'faq_heading_4' ); ?>><?php echo crux_h( 'home', 'faq_heading_4' ); ?></h3>
          <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:var(--crux-navy,#002671); color:#FFFFFF; display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
        </summary>
        <p style="font-size:15px; line-height:1.75; color:#A3A9C8; margin:0 0 24px; max-width:820px;"<?php echo crux_edit_attr( 'home', 'faq_paragraph_4' ); ?>><?php echo crux_h( 'home', 'faq_paragraph_4' ); ?></p>
      </details>
      <details style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; padding:0 26px; transition:border-color .25s ease;">
        <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
          <h3 style="font-size:17px; margin:0; font-weight:700; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'faq_heading_5' ); ?>><?php echo crux_h( 'home', 'faq_heading_5' ); ?></h3>
          <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:var(--crux-navy,#002671); color:#FFFFFF; display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
        </summary>
        <p style="font-size:15px; line-height:1.75; color:#A3A9C8; margin:0 0 24px; max-width:820px;"<?php echo crux_edit_attr( 'home', 'faq_paragraph_5' ); ?>><?php echo crux_h( 'home', 'faq_paragraph_5' ); ?></p>
      </details>
      <details style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; padding:0 26px; transition:border-color .25s ease;">
        <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
          <h3 style="font-size:17px; margin:0; font-weight:700; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'faq_heading_6' ); ?>><?php echo crux_h( 'home', 'faq_heading_6' ); ?></h3>
          <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:var(--crux-navy,#002671); color:#FFFFFF; display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
        </summary>
        <p style="font-size:15px; line-height:1.75; color:#A3A9C8; margin:0 0 24px; max-width:820px;">Our office is at <?php echo esc_html( crux_address( false ) ); ?>. We plan and run events across the entire UK, and our on-site coordination covers destination weddings and corporate retreats as well.</p>
      </details>
      <details style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; padding:0 26px; transition:border-color .25s ease;">
        <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
          <h3 style="font-size:17px; margin:0; font-weight:700; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'home', 'faq_heading_7' ); ?>><?php echo crux_h( 'home', 'faq_heading_7' ); ?></h3>
          <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:var(--crux-navy,#002671); color:#FFFFFF; display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
        </summary>
        <p style="font-size:15px; line-height:1.75; color:#A3A9C8; margin:0 0 24px; max-width:820px;"<?php echo crux_edit_attr( 'home', 'faq_paragraph_6' ); ?>><?php echo crux_h( 'home', 'faq_paragraph_6' ); ?></p>
      </details>
    </div>
  </section>

  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'dark', 'prefooter' => 'events', 'wing' => 'events' ) ); ?>

<div class="msw">
  <div class="crux-sw-pod crux-sw-pod--dark" style="pointer-events:auto; display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #2A3F7A 0%, #15224A 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(0,0,0,0.65); filter:drop-shadow(0 4px 12px rgba(0,0,0,0.4));">
    <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#020512; padding:4px; gap:4px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.5);">
        <span<?php echo crux_edit_attr( 'home', 'faq_text_1' ); ?>><?php echo crux_h( 'home', 'faq_text_1' ); ?></span>
      </a>
      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-dark" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#8E96BB; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">
        <span<?php echo crux_edit_attr( 'home', 'faq_text_2' ); ?>><?php echo crux_h( 'home', 'faq_text_2' ); ?></span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:6px; display:inline-block; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>
</div></div></div>





<?php get_footer(); ?>
