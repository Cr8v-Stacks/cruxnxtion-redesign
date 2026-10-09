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
<?php crux_use_page_css( 'dark' ); get_header( null, array( 'body_bg' => '#0A0F26', 'root_bg' => '#0A0F26', 'skin' => 'dark', 'nav' => 'events', 'wing' => 'events', 'active' => '' ) ); ?>

  <!-- 404 -->
  <section style="min-height:760px; padding:44px 20px 44px 20px; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; position:relative; overflow:hidden;" data-m="nomin">
    <span aria-hidden="true" class="bebas" style="font-size:60px; line-height:.8; background:linear-gradient(180deg,#F4F5FA 0%,#5B8DEF 40%,#1E2B5E 85%,transparent 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">404</span>
    <span class="eyebrow" style="margin-top:18px;"<?php echo crux_edit_attr( 'not_found', 'page_small_heading_1' ); ?>><?php echo crux_h( 'not_found', 'page_small_heading_1' ); ?></span>
    <h1 class="bebas" style="font-size:44px; margin:14px 0px 18px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'not_found', 'page_heading_1' ); ?>><?php echo crux_h( 'not_found', 'page_heading_1' ); ?></h1>
    <p style="font-size:16px; line-height:1.6; color:#A3A9C8; max-width:520px; margin:0px 0px 30px 0px;" class="reveal"<?php echo crux_edit_attr( 'not_found', 'page_paragraph_1' ); ?>><?php echo crux_h( 'not_found', 'page_paragraph_1' ); ?></p>
    <div style="display:flex; gap:16px; justify-content:center;" class="reveal"><a href="<?php echo crux_url( 'not_found', 'page_button_1_url' ); ?>" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:15px; padding:16px 30px 16px 30px; --sl:10px;" class="bx"<?php echo crux_edit_attr( 'not_found', 'page_button_1' ); ?>><?php echo crux_h( 'not_found', 'page_button_1' ); ?></a><a href="<?php echo crux_url( 'not_found', 'page_button_2_url' ); ?>" style="color:#F4F5FA; font-weight:700; font-size:15px; padding:14px 28px 14px 28px; --sl:10px; --bc:#5B8DEF;" class="bx"<?php echo crux_edit_attr( 'not_found', 'page_button_2' ); ?>><?php echo crux_h( 'not_found', 'page_button_2' ); ?></a></div>
  </section>
  <section style=" padding:10px 20px 44px 20px;">
    <div style="display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:26px;" class="reveal" data-m="g1">
      <a href="<?php echo esc_url( home_url( "/events/" ) ); ?>" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-1deg);" class="reveal">
        <div style=" padding:26px 22px 22px 22px;"><h3 class="bebas" style="font-size:32px; margin:0px 0px 8px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'not_found', 'page_heading_2' ); ?>><?php echo crux_h( 'not_found', 'page_heading_2' ); ?></h3><p style="font-size:13.5px; line-height:1.5; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'not_found', 'page_paragraph_2' ); ?>><?php echo crux_h( 'not_found', 'page_paragraph_2' ); ?></p></div>
        <div class="strip-stub" style="background:#002671; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF; letter-spacing:1px; text-transform:uppercase;"<?php echo crux_edit_attr( 'not_found', 'page_text_1' ); ?>><?php echo crux_h( 'not_found', 'page_text_1' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;">→</span></div>
      </a>
      <a href="<?php echo esc_url( home_url( "/gallery/" ) ); ?>" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(0.8deg);" class="reveal">
        <div style=" padding:26px 22px 22px 22px;"><h3 class="bebas" style="font-size:32px; margin:0px 0px 8px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'not_found', 'page_heading_3' ); ?>><?php echo crux_h( 'not_found', 'page_heading_3' ); ?></h3><p style="font-size:13.5px; line-height:1.5; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'not_found', 'page_paragraph_3' ); ?>><?php echo crux_h( 'not_found', 'page_paragraph_3' ); ?></p></div>
        <div class="strip-stub" style="background:#BA0000; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF; letter-spacing:1px; text-transform:uppercase;"<?php echo crux_edit_attr( 'not_found', 'page_text_1' ); ?>><?php echo crux_h( 'not_found', 'page_text_1' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;">→</span></div>
      </a>
      <a href="<?php echo esc_url( home_url( "/services/" ) ); ?>" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-0.6deg);" class="reveal">
        <div style=" padding:26px 22px 22px 22px;"><h3 class="bebas" style="font-size:32px; margin:0px 0px 8px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'not_found', 'page_heading_4' ); ?>><?php echo crux_h( 'not_found', 'page_heading_4' ); ?></h3><p style="font-size:13.5px; line-height:1.5; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'not_found', 'page_paragraph_4' ); ?>><?php echo crux_h( 'not_found', 'page_paragraph_4' ); ?></p></div>
        <div class="strip-stub" style="background:#8C7AE6; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#10142E; letter-spacing:1px; text-transform:uppercase;"<?php echo crux_edit_attr( 'not_found', 'page_text_1' ); ?>><?php echo crux_h( 'not_found', 'page_text_1' ); ?></span><span class="bebas" style="font-size:14px; color:#10142E;">→</span></div>
      </a>
      <a href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(1deg);" class="reveal">
        <div style=" padding:26px 22px 22px 22px;"><h3 class="bebas" style="font-size:32px; margin:0px 0px 8px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'not_found', 'page_heading_5' ); ?>><?php echo crux_h( 'not_found', 'page_heading_5' ); ?></h3><p style="font-size:13.5px; line-height:1.5; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'not_found', 'page_paragraph_5' ); ?>><?php echo crux_h( 'not_found', 'page_paragraph_5' ); ?></p></div>
        <div class="strip-stub" style="background:#002671; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF; letter-spacing:1px; text-transform:uppercase;"<?php echo crux_edit_attr( 'not_found', 'page_text_1' ); ?>><?php echo crux_h( 'not_found', 'page_text_1' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;">→</span></div>
      </a>
    </div>
  </section>

  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'dark', 'prefooter' => 'events', 'wing' => 'events' ) ); ?>

<div class="msw">
  <div class="crux-sw-pod crux-sw-pod--dark" style="pointer-events:auto; display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #2A3F7A 0%, #15224A 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(0,0,0,0.65); filter:drop-shadow(0 4px 12px rgba(0,0,0,0.4));">
    <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#020512; padding:4px; gap:4px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.5);">
        <span<?php echo crux_edit_attr( 'not_found', 'page_text_2' ); ?>><?php echo crux_h( 'not_found', 'page_text_2' ); ?></span>
      </a>
      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-dark" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#8E96BB; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">
        <span<?php echo crux_edit_attr( 'not_found', 'page_text_3' ); ?>><?php echo crux_h( 'not_found', 'page_text_3' ); ?></span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:6px; display:inline-block; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>
</div></div></div>





<?php get_footer(); ?>
