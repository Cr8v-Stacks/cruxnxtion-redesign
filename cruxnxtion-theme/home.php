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
<?php crux_use_page_css( 'dark' ); get_header( null, array( 'body_bg' => '#0A0F26', 'root_bg' => '#0A0F26', 'skin' => 'dark', 'nav' => 'events', 'wing' => 'events', 'active' => 'blog' ) ); ?>

  <!-- PAGE HEADING -->
  <section style=" padding:44px 20px 20px 20px;">
    <span class="eyebrow"<?php echo crux_edit_attr( 'blog', 'page_heading_small_heading_1' ); ?>><?php echo crux_h( 'blog', 'page_heading_small_heading_1' ); ?></span>
    <h1 class="bebas" style="font-size:44px; margin:14px 0px 14px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'blog', 'page_heading_heading_1' ); ?>><?php echo crux_h( 'blog', 'page_heading_heading_1' ); ?></h1>
    <p style="font-size:15px; color:#A3A9C8; max-width:540px; margin:0px 0px 0px 0px;" class="reveal"<?php echo crux_edit_attr( 'blog', 'page_heading_paragraph_1' ); ?>><?php echo crux_h( 'blog', 'page_heading_paragraph_1' ); ?></p>
  </section>

  <!-- TICKET GRID -->
  <section style="min-height:560px; display:flex; flex-direction:column; justify-content:center; padding:30px 20px 44px 20px;" data-m="nomin">
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:26px;" class="reveal" data-m="g1">
      <a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" class="ticket reveal" style="grid-column:span 3; display:flex; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; min-height:340px; overflow:hidden;" data-m="span tile">
        <div class="ticket-stub" style="flex:0 0 110px; background:#002671; display:flex; align-items:center; justify-content:center;"><span class="bebas" style="font-size:16px; color:#FFFFFF; writing-mode:vertical-rl; letter-spacing:2px;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_text_1' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_text_1' ); ?></span></div>
        <div style="flex:1; position:relative;"><img src="<?php echo crux_img_url( 'blog', 'ticket_grid_photo_1' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_photo_1' ); ?>><div style="position:absolute; inset:0; background:linear-gradient(90deg, rgba(10,15,38,0.94) 0%, rgba(10,15,38,0.55) 45%, rgba(10,15,38,0.15) 100%);"></div>
        <div style="position:absolute; left:0; top:0; bottom:0; display:flex; flex-direction:column; justify-content:center; padding:36px 36px 36px 36px; max-width:580px;"><span class="eyebrow"<?php echo crux_edit_attr( 'blog', 'ticket_grid_small_heading_1' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_small_heading_1' ); ?></span><h2 class="bebas" style="font-size:38px; margin:12px 0px 12px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_heading_1' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_heading_1' ); ?></h2><p style="font-size:14px; color:#C5CFF5; line-height:1.6; margin:0px 0px 16px 0px;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_paragraph_1' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_paragraph_1' ); ?></p><span style="font-weight:700; font-size:12.5px; color:#5B8DEF; border-bottom:1.5px solid #5B8DEF; padding-bottom:2px; width:fit-content;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_text_2' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_text_2' ); ?></span></div></div>
      </a>
      <a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" class="ticket reveal" style="display:flex; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; min-height:340px; overflow:hidden;" data-m="tile">
        <div class="ticket-stub" style="flex:0 0 60px; background:#BA0000; display:flex; align-items:center; justify-content:center;"><span class="bebas" style="font-size:13px; color:#FFFFFF; writing-mode:vertical-rl; letter-spacing:2px;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_text_3' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_text_3' ); ?></span></div>
        <div style="flex:1; position:relative;"><img src="<?php echo crux_img_url( 'blog', 'ticket_grid_photo_2' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_photo_2' ); ?>><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(10,15,38,0.96) 0%, rgba(10,15,38,0.5) 45%, rgba(10,15,38,0.12) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:20px 20px 20px 20px;"><span class="eyebrow"<?php echo crux_edit_attr( 'blog', 'ticket_grid_small_heading_2' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_small_heading_2' ); ?></span><h3 style="font-size:17px; margin:8px 0px 6px 0px; font-weight:700; color:#F4F5FA;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_heading_2' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_heading_2' ); ?></h3><span style="font-size:11.5px; color:#C5CFF5;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_text_4' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_text_4' ); ?></span></div></div>
      </a>
      <a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" class="ticket reveal" style="display:flex; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; min-height:340px; overflow:hidden;" data-m="tile">
        <div class="ticket-stub" style="flex:0 0 60px; background:#8C7AE6; display:flex; align-items:center; justify-content:center;"><span class="bebas" style="font-size:13px; color:#0A0F26; writing-mode:vertical-rl; letter-spacing:2px;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_text_5' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_text_5' ); ?></span></div>
        <div style="flex:1; position:relative;"><img src="<?php echo crux_img_url( 'blog', 'ticket_grid_photo_3' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_photo_3' ); ?>><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(10,15,38,0.96) 0%, rgba(10,15,38,0.5) 45%, rgba(10,15,38,0.12) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:20px 20px 20px 20px;"><span class="eyebrow"<?php echo crux_edit_attr( 'blog', 'ticket_grid_small_heading_3' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_small_heading_3' ); ?></span><h3 style="font-size:17px; margin:8px 0px 6px 0px; font-weight:700; color:#F4F5FA;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_heading_3' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_heading_3' ); ?></h3><span style="font-size:11.5px; color:#C5CFF5;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_text_6' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_text_6' ); ?></span></div></div>
      </a>
      <a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" class="ticket reveal" style="display:flex; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; min-height:340px; overflow:hidden;" data-m="tile">
        <div class="ticket-stub" style="flex:0 0 60px; background:#002671; display:flex; align-items:center; justify-content:center;"><span class="bebas" style="font-size:13px; color:#FFFFFF; writing-mode:vertical-rl; letter-spacing:2px;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_text_3' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_text_3' ); ?></span></div>
        <div style="flex:1; position:relative;"><img src="<?php echo crux_img_url( 'blog', 'ticket_grid_photo_4' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_photo_4' ); ?>><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(10,15,38,0.96) 0%, rgba(10,15,38,0.5) 45%, rgba(10,15,38,0.12) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:20px 20px 20px 20px;"><span class="eyebrow"<?php echo crux_edit_attr( 'blog', 'ticket_grid_small_heading_2' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_small_heading_2' ); ?></span><h3 style="font-size:17px; margin:8px 0px 6px 0px; font-weight:700; color:#F4F5FA;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_heading_4' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_heading_4' ); ?></h3><span style="font-size:11.5px; color:#C5CFF5;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_text_7' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_text_7' ); ?></span></div></div>
      </a>
      <a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" class="ticket reveal" style="display:flex; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; min-height:340px; overflow:hidden;" data-m="tile">
        <div class="ticket-stub" style="flex:0 0 60px; background:#BA0000; display:flex; align-items:center; justify-content:center;"><span class="bebas" style="font-size:13px; color:#FFFFFF; writing-mode:vertical-rl; letter-spacing:2px;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_text_8' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_text_8' ); ?></span></div>
        <div style="flex:1; position:relative;"><img src="<?php echo crux_img_url( 'blog', 'ticket_grid_photo_5' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_photo_5' ); ?>><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(10,15,38,0.96) 0%, rgba(10,15,38,0.5) 45%, rgba(10,15,38,0.12) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:20px 20px 20px 20px;"><span class="eyebrow"<?php echo crux_edit_attr( 'blog', 'ticket_grid_small_heading_4' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_small_heading_4' ); ?></span><h3 style="font-size:17px; margin:8px 0px 6px 0px; font-weight:700; color:#F4F5FA;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_heading_5' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_heading_5' ); ?></h3><span style="font-size:11.5px; color:#C5CFF5;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_text_9' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_text_9' ); ?></span></div></div>
      </a>
      <a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>" class="ticket reveal" style="display:flex; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; min-height:340px; overflow:hidden;" data-m="tile">
        <div class="ticket-stub" style="flex:0 0 60px; background:#8C7AE6; display:flex; align-items:center; justify-content:center;"><span class="bebas" style="font-size:13px; color:#0A0F26; writing-mode:vertical-rl; letter-spacing:2px;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_text_10' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_text_10' ); ?></span></div>
        <div style="flex:1; position:relative;"><img src="<?php echo crux_img_url( 'blog', 'ticket_grid_photo_6' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_photo_6' ); ?>><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(10,15,38,0.96) 0%, rgba(10,15,38,0.5) 45%, rgba(10,15,38,0.12) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:20px 20px 20px 20px;"><span class="eyebrow"<?php echo crux_edit_attr( 'blog', 'ticket_grid_small_heading_1' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_small_heading_1' ); ?></span><h3 style="font-size:17px; margin:8px 0px 6px 0px; font-weight:700; color:#F4F5FA;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_heading_6' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_heading_6' ); ?></h3><span style="font-size:11.5px; color:#C5CFF5;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_text_11' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_text_11' ); ?></span></div></div>
      </a>
      <div style="grid-column:span 3; display:flex; align-items:center; justify-content:space-between; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; padding:32px 36px 32px 36px;" class="reveal" data-m="span"><div><span class="eyebrow"<?php echo crux_edit_attr( 'blog', 'ticket_grid_small_heading_5' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_small_heading_5' ); ?></span><h3 class="bebas" style="font-size:28px; margin:10px 0px 0px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'blog', 'ticket_grid_heading_7' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_heading_7' ); ?></h3></div><a href="<?php echo crux_url( 'blog', 'ticket_grid_button_1_url' ); ?>" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:13.5px; padding:14px 26px 14px 26px; --sl:10px;" class="bx"<?php echo crux_edit_attr( 'blog', 'ticket_grid_button_1' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_button_1' ); ?></a></div>
    </div>
  </section>

  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'dark', 'prefooter' => 'events', 'wing' => 'events' ) ); ?>

<div class="msw">
  <div class="crux-sw-pod crux-sw-pod--dark" style="pointer-events:auto; display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #2A3F7A 0%, #15224A 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(0,0,0,0.65); filter:drop-shadow(0 4px 12px rgba(0,0,0,0.4));">
    <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#020512; padding:4px; gap:4px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.5);">
        <span<?php echo crux_edit_attr( 'blog', 'ticket_grid_text_12' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_text_12' ); ?></span>
      </a>
      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-dark" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#8E96BB; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">
        <span<?php echo crux_edit_attr( 'blog', 'ticket_grid_text_13' ); ?>><?php echo crux_h( 'blog', 'ticket_grid_text_13' ); ?></span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:6px; display:inline-block; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>
</div></div></div>





<?php get_footer(); ?>
