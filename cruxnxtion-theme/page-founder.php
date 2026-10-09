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
<?php crux_use_page_css( 'light' ); get_header( null, array( 'body_bg' => '#FFFFFF', 'root_bg' => '#FFFFFF', 'skin' => 'light', 'nav' => 'consultancy', 'wing' => 'events', 'active' => 'founder' ) ); ?>

  <!-- ABOUT / MEET THE TEAM HERO -->
  <section style="padding:54px 20px 54px 20px; display:grid; grid-template-columns:0.82fr 1.18fr; gap:64px; align-items:center;" data-m="g1">
    <div class="tilt-straighten reveal" style="--r:-2deg; transform:rotate(var(--r)); border-radius:24px; overflow:hidden; border:2px solid #8C7AE6; height:620px;">
      <img src="<?php echo crux_img_url( 'founder', 'about_meet_the_team_hero_photo_1' ); ?>" alt="Olabamidele 'Bambad' Badmos" style="width:100%; height:100%; object-fit:cover; object-position:58% 12%;"<?php echo crux_edit_attr( 'founder', 'about_meet_the_team_hero_photo_1' ); ?>>
    </div>
    <div class="reveal">
      <span class="eyebrow" style="color:#6C58DB;"<?php echo crux_edit_attr( 'founder', 'about_meet_the_team_hero_small_heading_1' ); ?>><?php echo crux_h( 'founder', 'about_meet_the_team_hero_small_heading_1' ); ?></span>
      <h1 class="bebas" style="font-size:52px; margin:14px 0px 8px 0px; color:#10142E; line-height:0.95;"<?php echo crux_edit_attr( 'founder', 'about_meet_the_team_hero_heading_1' ); ?>><?php echo crux_h( 'founder', 'about_meet_the_team_hero_heading_1' ); ?></h1>
      <p style="font-size:14px; font-weight:700; letter-spacing:1.8px; text-transform:uppercase; color:#5A5F86; margin:0px 0px 22px 0px;"<?php echo crux_edit_attr( 'founder', 'about_meet_the_team_hero_paragraph_1' ); ?>><?php echo crux_h( 'founder', 'about_meet_the_team_hero_paragraph_1' ); ?></p>
      
      <p style="font-size:16.5px; line-height:1.8; color:#3A3F66; max-width:620px; margin:0px 0px 20px 0px;"<?php echo crux_edit_attr( 'founder', 'about_meet_the_team_hero_paragraph_2' ); ?>><?php echo crux_h( 'founder', 'about_meet_the_team_hero_paragraph_2' ); ?></p>

      <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:28px;" data-m="wrap">
        <span style="background:#FFFFFF; color:#3A3F66; font-size:12px; font-weight:700; padding:9px 18px; --sl:6px; --bc:#D2CEEA;" class="bx"<?php echo crux_edit_attr( 'founder', 'about_meet_the_team_hero_text_1' ); ?>><?php echo crux_h( 'founder', 'about_meet_the_team_hero_text_1' ); ?></span>
        <span style="background:#FFFFFF; color:#3A3F66; font-size:12px; font-weight:700; padding:9px 18px; --sl:6px; --bc:#D2CEEA;" class="bx"<?php echo crux_edit_attr( 'founder', 'about_meet_the_team_hero_text_2' ); ?>><?php echo crux_h( 'founder', 'about_meet_the_team_hero_text_2' ); ?></span>
        <span style="background:#FFFFFF; color:#3A3F66; font-size:12px; font-weight:700; padding:9px 18px; --sl:6px; --bc:#D2CEEA;" class="bx"<?php echo crux_edit_attr( 'founder', 'about_meet_the_team_hero_text_3' ); ?>><?php echo crux_h( 'founder', 'about_meet_the_team_hero_text_3' ); ?></span>
        <span style="background:#FFFFFF; color:#3A3F66; font-size:12px; font-weight:700; padding:9px 18px; --sl:6px; --bc:#D2CEEA;" class="bx"<?php echo crux_edit_attr( 'founder', 'about_meet_the_team_hero_text_4' ); ?>><?php echo crux_h( 'founder', 'about_meet_the_team_hero_text_4' ); ?></span>
      </div>

      <div style="display:flex; gap:14px; flex-wrap:wrap;">
        <a href="<?php echo crux_url( 'founder', 'about_meet_the_team_hero_button_1_url' ); ?>" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:14.5px; padding:15px 28px; --sl:10px;" class="bx"<?php echo crux_edit_attr( 'founder', 'about_meet_the_team_hero_button_1' ); ?>><?php echo crux_h( 'founder', 'about_meet_the_team_hero_button_1' ); ?></a>
        <a href="<?php echo esc_url( crux_opt( 'calendly_url' ) ); ?>" target="_blank" rel="noopener" style="background:#8C7AE6; color:#10142E; font-weight:700; font-size:14.5px; padding:15px 28px; --sl:10px;" class="bx"<?php echo crux_edit_attr( 'founder', 'about_meet_the_team_hero_button_2' ); ?>><?php echo crux_h( 'founder', 'about_meet_the_team_hero_button_2' ); ?></a>
      </div>
    </div>
  </section>

  <!-- EVENT LEGACY SECTION -->
  <section style="padding:60px 20px; background:#F3F1FC;">
    <div style="max-width:1100px; margin:0 auto;">
      <div class="reveal" style="text-align:center; margin-bottom:44px;">
        <span class="eyebrow"<?php echo crux_edit_attr( 'founder', 'event_legacy_section_small_heading_1' ); ?>><?php echo crux_h( 'founder', 'event_legacy_section_small_heading_1' ); ?></span>
        <h2 class="bebas" style="font-size:42px; margin:12px 0 10px; color:#10142E;"<?php echo crux_edit_attr( 'founder', 'event_legacy_section_heading_1' ); ?>><?php echo crux_h( 'founder', 'event_legacy_section_heading_1' ); ?></h2>
        <p style="font-size:15.5px; color:#5A5F86; max-width:680px; margin:0 auto; line-height:1.7;"<?php echo crux_edit_attr( 'founder', 'event_legacy_section_paragraph_1' ); ?>><?php echo crux_h( 'founder', 'event_legacy_section_paragraph_1' ); ?></p>
      </div>

      <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:22px;" class="reveal" data-m="g1">
        <div class="bento-tile" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:18px; padding:28px 26px;">
          <span class="bebas" style="font-size:32px; color:#BA0000; display:block; margin-bottom:8px;">01</span>
          <h3 class="bebas" style="font-size:24px; color:#10142E; margin:0 0 10px;"<?php echo crux_edit_attr( 'founder', 'event_legacy_section_heading_2' ); ?>><?php echo crux_h( 'founder', 'event_legacy_section_heading_2' ); ?></h3>
          <p style="font-size:13.5px; line-height:1.65; color:#5A5F86; margin:0;"<?php echo crux_edit_attr( 'founder', 'event_legacy_section_paragraph_2' ); ?>><?php echo crux_h( 'founder', 'event_legacy_section_paragraph_2' ); ?></p>
        </div>

        <div class="bento-tile" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:18px; padding:28px 26px;">
          <span class="bebas" style="font-size:32px; color:#6C58DB; display:block; margin-bottom:8px;">02</span>
          <h3 class="bebas" style="font-size:24px; color:#10142E; margin:0 0 10px;"<?php echo crux_edit_attr( 'founder', 'event_legacy_section_heading_3' ); ?>><?php echo crux_h( 'founder', 'event_legacy_section_heading_3' ); ?></h3>
          <p style="font-size:13.5px; line-height:1.65; color:#5A5F86; margin:0;"<?php echo crux_edit_attr( 'founder', 'event_legacy_section_paragraph_3' ); ?>><?php echo crux_h( 'founder', 'event_legacy_section_paragraph_3' ); ?></p>
        </div>

        <div class="bento-tile" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:18px; padding:28px 26px;">
          <span class="bebas" style="font-size:32px; color:#002671; display:block; margin-bottom:8px;">03</span>
          <h3 class="bebas" style="font-size:24px; color:#10142E; margin:0 0 10px;"<?php echo crux_edit_attr( 'founder', 'event_legacy_section_heading_4' ); ?>><?php echo crux_h( 'founder', 'event_legacy_section_heading_4' ); ?></h3>
          <p style="font-size:13.5px; line-height:1.65; color:#5A5F86; margin:0;"<?php echo crux_edit_attr( 'founder', 'event_legacy_section_paragraph_4' ); ?>><?php echo crux_h( 'founder', 'event_legacy_section_paragraph_4' ); ?></p>
        </div>

        <div class="bento-tile" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:18px; padding:28px 26px;">
          <span class="bebas" style="font-size:32px; color:#BA0000; display:block; margin-bottom:8px;">04</span>
          <h3 class="bebas" style="font-size:24px; color:#10142E; margin:0 0 10px;"<?php echo crux_edit_attr( 'founder', 'event_legacy_section_heading_5' ); ?>><?php echo crux_h( 'founder', 'event_legacy_section_heading_5' ); ?></h3>
          <p style="font-size:13.5px; line-height:1.65; color:#5A5F86; margin:0;"<?php echo crux_edit_attr( 'founder', 'event_legacy_section_paragraph_5' ); ?>><?php echo crux_h( 'founder', 'event_legacy_section_paragraph_5' ); ?></p>
        </div>

        <div class="bento-tile" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:18px; padding:28px 26px; grid-column:span 2;" data-m="span">
          <span class="bebas" style="font-size:32px; color:#6C58DB; display:block; margin-bottom:8px;">05</span>
          <h3 class="bebas" style="font-size:24px; color:#10142E; margin:0 0 10px;"<?php echo crux_edit_attr( 'founder', 'event_legacy_section_heading_6' ); ?>><?php echo crux_h( 'founder', 'event_legacy_section_heading_6' ); ?></h3>
          <p style="font-size:13.5px; line-height:1.65; color:#5A5F86; margin:0;"<?php echo crux_edit_attr( 'founder', 'event_legacy_section_paragraph_6' ); ?>><?php echo crux_h( 'founder', 'event_legacy_section_paragraph_6' ); ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- GLOBAL BUSINESS CONSULTANCY & ENTERPRISE GROWTH -->
  <section style="padding:64px 20px; background:#FFFFFF;">
    <div style="max-width:1100px; margin:0 auto;">
      <div class="reveal" style="margin-bottom:44px;">
        <span class="eyebrow" style="color:#6C58DB;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__small_heading_1' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__small_heading_1' ); ?></span>
        <h2 class="bebas" style="font-size:42px; margin:12px 0 14px; color:#10142E;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__heading_1' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__heading_1' ); ?></h2>
        <p style="font-size:16px; line-height:1.8; color:#3A3F66; max-width:820px; margin:0;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__paragraph_1' ); ?>><?php echo crux_rich( 'founder', 'global_business_consultancy__paragraph_1' ); ?></p>
      </div>

      <!-- 5 Pillars Grid -->
      <div style="display:grid; grid-template-columns:repeat(5, minmax(0, 1fr)); gap:18px; margin-bottom:48px;" class="reveal" data-m="g1">
        <div style="background:#F4F5FA; border:1.5px solid #E1DEF3; border-radius:16px; padding:24px 20px; display:flex; flex-direction:column; justify-content:space-between;">
          <div>
            <span class="bebas" style="font-size:26px; color:#6C58DB;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__text_1' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__text_1' ); ?></span>
            <h3 style="font-size:15px; font-weight:800; color:#10142E; margin:8px 0 8px;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__heading_2' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__heading_2' ); ?></h3>
            <p style="font-size:13px; line-height:1.6; color:#5A5F86; margin:0;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__paragraph_2' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__paragraph_2' ); ?></p>
          </div>
        </div>

        <div style="background:#F4F5FA; border:1.5px solid #E1DEF3; border-radius:16px; padding:24px 20px; display:flex; flex-direction:column; justify-content:space-between;">
          <div>
            <span class="bebas" style="font-size:26px; color:#BA0000;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__text_2' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__text_2' ); ?></span>
            <h3 style="font-size:15px; font-weight:800; color:#10142E; margin:8px 0 8px;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__heading_3' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__heading_3' ); ?></h3>
            <p style="font-size:13px; line-height:1.6; color:#5A5F86; margin:0;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__paragraph_3' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__paragraph_3' ); ?></p>
          </div>
        </div>

        <div style="background:#F4F5FA; border:1.5px solid #E1DEF3; border-radius:16px; padding:24px 20px; display:flex; flex-direction:column; justify-content:space-between;">
          <div>
            <span class="bebas" style="font-size:26px; color:#002671;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__text_3' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__text_3' ); ?></span>
            <h3 style="font-size:15px; font-weight:800; color:#10142E; margin:8px 0 8px;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__heading_4' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__heading_4' ); ?></h3>
            <p style="font-size:13px; line-height:1.6; color:#5A5F86; margin:0;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__paragraph_4' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__paragraph_4' ); ?></p>
          </div>
        </div>

        <div style="background:#F4F5FA; border:1.5px solid #E1DEF3; border-radius:16px; padding:24px 20px; display:flex; flex-direction:column; justify-content:space-between;">
          <div>
            <span class="bebas" style="font-size:26px; color:#6C58DB;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__text_4' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__text_4' ); ?></span>
            <h3 style="font-size:15px; font-weight:800; color:#10142E; margin:8px 0 8px;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__heading_5' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__heading_5' ); ?></h3>
            <p style="font-size:13px; line-height:1.6; color:#5A5F86; margin:0;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__paragraph_5' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__paragraph_5' ); ?></p>
          </div>
        </div>

        <div style="background:#F4F5FA; border:1.5px solid #E1DEF3; border-radius:16px; padding:24px 20px; display:flex; flex-direction:column; justify-content:space-between;">
          <div>
            <span class="bebas" style="font-size:26px; color:#BA0000;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__text_5' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__text_5' ); ?></span>
            <h3 style="font-size:15px; font-weight:800; color:#10142E; margin:8px 0 8px;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__heading_6' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__heading_6' ); ?></h3>
            <p style="font-size:13px; line-height:1.6; color:#5A5F86; margin:0;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__paragraph_6' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__paragraph_6' ); ?></p>
          </div>
        </div>
      </div>

      <!-- Infrastructure Transformation Real Evidence -->
      <div style="background:#111838; border-radius:22px; padding:36px 32px; border:1.5px solid #1E2B5E;" class="reveal">
        <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:24px; flex-wrap:wrap; gap:16px;">
          <div>
            <span class="eyebrow" style="color:#B7A6FF !important;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__small_heading_2' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__small_heading_2' ); ?></span>
            <h3 class="bebas" style="font-size:32px; color:#FFFFFF; margin:8px 0 0;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__heading_7' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__heading_7' ); ?></h3>
          </div>
          <p style="font-size:14px; color:#A3A9C8; max-width:440px; margin:0;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__paragraph_7' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__paragraph_7' ); ?></p>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;" data-m="g1">
          <div style="background:#0D1330; border-radius:14px; overflow:hidden; border:1px solid #1E2B5E;">
            <div style="height:320px; overflow:hidden;"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/consultancy-retail-unit.jpg' ); ?>" alt="Before: We find the retail shop/unit/office" style="width:100%; height:100%; object-fit:cover; object-position:center; display:block;"></div>
            <div style="padding:14px 18px; display:flex; justify-content:space-between; align-items:center;">
              <span style="font-size:11px; font-weight:800; color:#8C7AE6; letter-spacing:1px; text-transform:uppercase; background:rgba(140,122,230,0.15); padding:4px 10px; border-radius:4px;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__text_6' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__text_6' ); ?></span>
              <span style="font-size:13.5px; color:#FFFFFF; font-weight:700;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__text_7' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__text_7' ); ?></span>
            </div>
          </div>

          <div style="background:#0D1330; border-radius:14px; overflow:hidden; border:1px solid #1E2B5E;">
            <div style="height:320px; overflow:hidden;"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/consultancy-retail-stocked.jpg' ); ?>" alt="After: We build it/stock it/set up" style="width:100%; height:100%; object-fit:cover; object-position:center; display:block;"></div>
            <div style="padding:14px 18px; display:flex; justify-content:space-between; align-items:center;">
              <span style="font-size:11px; font-weight:800; color:#BA0000; letter-spacing:1px; text-transform:uppercase; background:rgba(186,0,0,0.15); padding:4px 10px; border-radius:4px;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__text_8' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__text_8' ); ?></span>
              <span style="font-size:13.5px; color:#FFFFFF; font-weight:700;"<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__text_9' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__text_9' ); ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'light', 'prefooter' => 'founder', 'wing' => 'events' ) ); ?>
  </div>

<div class="msw">
  <div class="crux-sw-pod crux-sw-pod--light" style="pointer-events:auto; display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #C4BAEE 0%, #A99CE0 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(16,20,46,0.22); filter:drop-shadow(0 4px 12px rgba(16,20,46,0.12));">
    <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#EBE7F7; padding:4px; gap:4px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.4);">
        <span<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__text_10' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__text_10' ); ?></span>
      </a>
      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-light" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#4A5073; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">
        <span<?php echo crux_edit_attr( 'founder', 'global_business_consultancy__text_11' ); ?>><?php echo crux_h( 'founder', 'global_business_consultancy__text_11' ); ?></span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:6px; display:inline-block; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>
</div></div></div>





<?php get_footer(); ?>
