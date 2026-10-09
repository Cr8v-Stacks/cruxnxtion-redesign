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
<?php crux_use_page_css( 'dark' ); get_header( null, array( 'body_bg' => '#0A0F26', 'root_bg' => '#0A0F26', 'skin' => 'dark', 'nav' => 'events', 'wing' => 'events', 'active' => 'gallery' ) ); ?>

  <!-- PAGE HEADING -->
  <section style=" padding:44px 20px 20px 20px;">
    <span class="eyebrow"<?php echo crux_edit_attr( 'gallery', 'page_heading_small_heading_1' ); ?>><?php echo crux_h( 'gallery', 'page_heading_small_heading_1' ); ?></span>
    <h1 class="bebas" style="font-size:44px; margin:14px 0px 14px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'gallery', 'page_heading_heading_1' ); ?>><?php echo crux_h( 'gallery', 'page_heading_heading_1' ); ?></h1>
    <p style="font-size:15px; color:#A3A9C8; max-width:520px; margin:0px 0px 0px 0px;" class="reveal"<?php echo crux_edit_attr( 'gallery', 'page_heading_paragraph_1' ); ?>><?php echo crux_h( 'gallery', 'page_heading_paragraph_1' ); ?></p>
  </section>

  <!-- TICKET PHOTO GRID -->
  <section style=" padding:30px 20px 44px 20px;">
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:34px 26px; align-items:start;" class="reveal" data-m="g2">
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-1deg);" class="reveal">
        <div style="position:relative; height:240px;"><img src="<?php echo crux_img_url( 'gallery', 'ticket_photo_grid_photo_1' ); ?>" alt="Crux Nxtion Events frame 1" style="width:100%; height:100%; object-fit:cover; display:block;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_photo_1' ); ?>></div>
        <div class="strip-stub" style="background:#002671; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_1' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_1' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_2' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_2' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(0.8deg);" class="reveal">
        <div style="position:relative; height:280px;"><img src="<?php echo crux_img_url( 'gallery', 'ticket_photo_grid_photo_2' ); ?>" alt="Crux Nxtion Events frame 2" style="width:100%; height:100%; object-fit:cover; display:block;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_photo_2' ); ?>></div>
        <div class="strip-stub" style="background:#BA0000; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_3' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_3' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_4' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_4' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-0.8deg);" class="reveal">
        <div style="position:relative; height:220px;"><img src="<?php echo crux_img_url( 'gallery', 'ticket_photo_grid_photo_3' ); ?>" alt="Crux Nxtion Events frame 3" style="width:100%; height:100%; object-fit:cover; display:block;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_photo_3' ); ?>></div>
        <div class="strip-stub" style="background:#8C7AE6; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#0A0F26;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_5' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_5' ); ?></span><span class="bebas" style="font-size:14px; color:#0A0F26;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_6' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_6' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(0.6deg);" class="reveal">
        <div style="position:relative; height:240px;"><img src="<?php echo crux_img_url( 'gallery', 'ticket_photo_grid_photo_4' ); ?>" alt="Crux Nxtion Events frame 4" style="width:100%; height:100%; object-fit:cover; display:block;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_photo_4' ); ?>></div>
        <div class="strip-stub" style="background:#002671; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_7' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_7' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_8' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_8' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-0.6deg);" class="reveal">
        <div style="position:relative; height:280px;"><img src="<?php echo crux_img_url( 'gallery', 'ticket_photo_grid_photo_5' ); ?>" alt="Crux Nxtion Events frame 5" style="width:100%; height:100%; object-fit:cover; display:block;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_photo_5' ); ?>></div>
        <div class="strip-stub" style="background:#BA0000; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_9' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_9' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_10' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_10' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(1deg);" class="reveal">
        <div style="position:relative; height:220px;"><img src="<?php echo crux_img_url( 'gallery', 'ticket_photo_grid_photo_6' ); ?>" alt="Crux Nxtion Events frame 6" style="width:100%; height:100%; object-fit:cover; display:block;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_photo_6' ); ?>></div>
        <div class="strip-stub" style="background:#8C7AE6; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#0A0F26;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_11' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_11' ); ?></span><span class="bebas" style="font-size:14px; color:#0A0F26;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_12' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_12' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-1deg);" class="reveal">
        <div style="position:relative; height:240px;"><img src="<?php echo crux_img_url( 'gallery', 'ticket_photo_grid_photo_7' ); ?>" alt="Crux Nxtion Events frame 7" style="width:100%; height:100%; object-fit:cover; display:block;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_photo_7' ); ?>></div>
        <div class="strip-stub" style="background:#002671; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_1' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_1' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_13' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_13' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(0.8deg);" class="reveal">
        <div style="position:relative; height:280px;"><img src="<?php echo crux_img_url( 'gallery', 'ticket_photo_grid_photo_8' ); ?>" alt="Crux Nxtion Events frame 8" style="width:100%; height:100%; object-fit:cover; display:block;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_photo_8' ); ?>></div>
        <div class="strip-stub" style="background:#BA0000; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_3' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_3' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_14' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_14' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-0.8deg);" class="reveal">
        <div style="position:relative; height:220px;"><img src="<?php echo crux_img_url( 'gallery', 'ticket_photo_grid_photo_3' ); ?>" alt="Crux Nxtion Events frame 9" style="width:100%; height:100%; object-fit:cover; display:block;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_photo_3' ); ?>></div>
        <div class="strip-stub" style="background:#8C7AE6; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#0A0F26;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_5' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_5' ); ?></span><span class="bebas" style="font-size:14px; color:#0A0F26;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_15' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_15' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(0.6deg);">
        <div style="position:relative; height:240px;"><img src="<?php echo crux_img_url( 'gallery', 'ticket_photo_grid_photo_9' ); ?>" alt="Crux Nxtion Events frame 10" style="width:100%; height:100%; object-fit:cover; display:block;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_photo_9' ); ?>></div>
        <div class="strip-stub" style="background:#002671; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_7' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_7' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_16' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_16' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-0.6deg);">
        <div style="position:relative; height:280px;"><img src="<?php echo crux_img_url( 'gallery', 'ticket_photo_grid_photo_10' ); ?>" alt="Crux Nxtion Events frame 11" style="width:100%; height:100%; object-fit:cover; display:block;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_photo_10' ); ?>></div>
        <div class="strip-stub" style="background:#BA0000; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_9' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_9' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_17' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_17' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(1deg);">
        <div style="position:relative; height:220px;"><img src="<?php echo crux_img_url( 'gallery', 'ticket_photo_grid_photo_11' ); ?>" alt="Crux Nxtion Events frame 12" style="width:100%; height:100%; object-fit:cover; display:block;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_photo_11' ); ?>></div>
        <div class="strip-stub" style="background:#8C7AE6; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#0A0F26;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_11' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_11' ); ?></span><span class="bebas" style="font-size:14px; color:#0A0F26;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_18' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_18' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-1deg);">
        <div style="position:relative; height:240px;"><img src="<?php echo crux_img_url( 'gallery', 'ticket_photo_grid_photo_12' ); ?>" alt="Crux Nxtion Events frame 13" style="width:100%; height:100%; object-fit:cover; display:block;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_photo_12' ); ?>></div>
        <div class="strip-stub" style="background:#002671; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_1' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_1' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_19' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_19' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(0.8deg);">
        <div style="position:relative; height:280px;"><img src="<?php echo crux_img_url( 'gallery', 'ticket_photo_grid_photo_13' ); ?>" alt="Crux Nxtion Events frame 14" style="width:100%; height:100%; object-fit:cover; display:block;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_photo_13' ); ?>></div>
        <div class="strip-stub" style="background:#BA0000; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_3' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_3' ); ?></span><span class="bebas" style="font-size:14px; color:#FFFFFF;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_20' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_20' ); ?></span></div>
      </a>
      <a href="#" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; transform:rotate(-0.8deg);">
        <div style="position:relative; height:220px;"><img src="<?php echo crux_img_url( 'gallery', 'ticket_photo_grid_photo_14' ); ?>" alt="Crux Nxtion Events frame 15" style="width:100%; height:100%; object-fit:cover; display:block;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_photo_14' ); ?>></div>
        <div class="strip-stub" style="background:#8C7AE6; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#0A0F26;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_5' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_5' ); ?></span><span class="bebas" style="font-size:14px; color:#0A0F26;"<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_21' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_21' ); ?></span></div>
      </a>
    </div>
  </section>

  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'dark', 'prefooter' => 'events', 'wing' => 'events' ) ); ?>

<div class="msw">
  <div class="crux-sw-pod crux-sw-pod--dark" style="pointer-events:auto; display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #2A3F7A 0%, #15224A 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(0,0,0,0.65); filter:drop-shadow(0 4px 12px rgba(0,0,0,0.4));">
    <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#020512; padding:4px; gap:4px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.5);">
        <span<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_22' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_22' ); ?></span>
      </a>
      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-dark" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#8E96BB; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">
        <span<?php echo crux_edit_attr( 'gallery', 'ticket_photo_grid_text_23' ); ?>><?php echo crux_h( 'gallery', 'ticket_photo_grid_text_23' ); ?></span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:6px; display:inline-block; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>
</div></div></div>





<?php get_footer(); ?>
