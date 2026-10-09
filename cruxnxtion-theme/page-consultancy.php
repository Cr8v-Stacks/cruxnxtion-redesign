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
<?php crux_use_page_css( 'consultancy' ); get_header( null, array( 'body_bg' => '#FFFFFF', 'root_bg' => '#FFFFFF', 'skin' => 'light', 'nav' => 'consultancy', 'wing' => 'consultancy', 'active' => 'home' ) ); ?>

      <!-- 1 HERO -->
  <section style="min-height:640px; display:grid; grid-template-columns:1.15fr 0.85fr; gap:50px; align-items:center; padding:60px clamp(24px, 5vw, 64px); background:#FFFFFF;" data-m="g1 nomin">
    <div class="reveal">
      <span class="eyebrow" style="color:var(--crux-violet,#6C58DB); font-weight:700; letter-spacing:1.5px; font-size:12px;"<?php echo crux_edit_attr( 'consultancy', 'page_small_heading_1' ); ?>><?php echo crux_h( 'consultancy', 'page_small_heading_1' ); ?></span>
      <h1 class="bebas hero-title" style="margin:16px 0px 20px 0px; color:var(--crux-ink2,#10142E); max-width:680px;"<?php echo crux_edit_attr( 'consultancy', 'page_heading_1' ); ?>><?php echo crux_rich( 'consultancy', 'page_heading_1' ); ?></h1>
      <p style="font-size:17px; line-height:1.7; color:#3A3F66; max-width:580px; margin:0px 0px 32px 0px;"<?php echo crux_edit_attr( 'consultancy', 'page_paragraph_1' ); ?>><?php echo crux_h( 'consultancy', 'page_paragraph_1' ); ?></p>
      <div style="display:flex; gap:16px; flex-wrap:wrap;">
        <a href="<?php echo esc_url( crux_opt( 'calendly_url' ) ); ?>" target="_blank" rel="noopener" style="background:var(--crux-purple,#8C7AE6); color:var(--crux-ink2,#10142E); font-weight:700; font-size:15px; padding:16px 30px; --sl:10px;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'page_button_1' ); ?>><?php echo crux_h( 'consultancy', 'page_button_1' ); ?></a>
        <a href="#how" style="color:var(--crux-ink2,#10142E); font-weight:700; font-size:15px; padding:14.5px 28px; --sl:10px; --bc:var(--crux-ink2,#10142E);" class="bx"<?php echo crux_edit_attr( 'consultancy', 'page_button_2' ); ?>><?php echo crux_h( 'consultancy', 'page_button_2' ); ?></a>
      </div>
    </div>
    
    <!-- HERO RIGHT: DUAL RETAIL TRANSFORMATION SHOWCASE + FULL DISCOVERY CALL -->
    <div style="position:relative; min-height:560px; display:flex; align-items:center; justify-content:center;" class="reveal consultancy-hero-visual" data-m="herovis">
      
      <!-- Option 2 Desktop: Side-by-Side Split Showcase + Bottom Tray -->
      <div class="opt2-container">
        
        <div class="opt2-cards-row">
          <!-- Blueprint Badge -->
          <div class="badge-blueprint opt2-badge">
            <span class="bebas" style="font-size:17px; line-height:1.1; display:block;"><?php echo crux_h( 'consultancy', 'hero_right_text_1' ); ?><br><?php echo crux_h( 'consultancy', 'hero_right_text_2' ); ?></span>
          </div>

          <!-- Card Before (Tilted Left) -->
          <div class="opt2-card before">
            <div style="height:210px; overflow:hidden; background:var(--crux-text,#F4F5FA);">
              <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/consultancy-retail-unit.jpg' ); ?>" alt="Before: We find the retail shop/unit/office" style="width:100%; height:100%; object-fit:cover; display:block;">
            </div>
            <div style="padding:10px 14px; background:#F8F9FE; border-top:1px solid #E1DEF3;">
              <span style="font-size:10px; font-weight:800; letter-spacing:1px; color:var(--crux-violet,#6C58DB); display:block;"<?php echo crux_edit_attr( 'consultancy', 'hero_right_text_3' ); ?>><?php echo crux_h( 'consultancy', 'hero_right_text_3' ); ?></span>
              <p style="font-size:12px; color:var(--crux-ink2,#10142E); font-weight:600; margin-top:2px; line-height:1.35;"<?php echo crux_edit_attr( 'consultancy', 'hero_right_paragraph_1' ); ?>><?php echo crux_h( 'consultancy', 'hero_right_paragraph_1' ); ?></p>
            </div>
          </div>

          <!-- Card After (Tilted Right) -->
          <div class="opt2-card after">
            <div style="height:210px; overflow:hidden; background:var(--crux-text,#F4F5FA);">
              <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/consultancy-retail-stocked.jpg' ); ?>" alt="After: We build it/stock it/set up" style="width:100%; height:100%; object-fit:cover; display:block;">
            </div>
            <div style="padding:10px 14px; background:#FFFFFF; border-top:1px solid #E1DEF3;">
              <span style="font-size:10px; font-weight:800; letter-spacing:1px; color:var(--crux-red,#BA0000); display:block;"<?php echo crux_edit_attr( 'consultancy', 'hero_right_text_4' ); ?>><?php echo crux_h( 'consultancy', 'hero_right_text_4' ); ?></span>
              <p style="font-size:12px; color:var(--crux-ink2,#10142E); font-weight:600; margin-top:2px; line-height:1.35;"<?php echo crux_edit_attr( 'consultancy', 'hero_right_paragraph_2' ); ?>><?php echo crux_h( 'consultancy', 'hero_right_paragraph_2' ); ?></p>
            </div>
          </div>
        </div>

        <!-- Discovery Call Tray (Animated dialogue loop + subtle gentle bounce) -->
        <div class="discovery-chat-bounce opt2-chat" style="--r:-0.5deg; transform:rotate(var(--r)); background:rgba(16,20,46,0.96) !important; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); border:1.5px solid #3A3F72; border-radius:18px; padding:14px 16px; display:flex; flex-direction:column; gap:7px; box-shadow:0 18px 40px rgba(0,0,0,0.35);" data-m="hv-chat full">
          <div style="display:flex; align-items:center; gap:8px; padding-bottom:7px; border-bottom:1.5px dashed #2A2F5C;">
            <span class="pulse-dot" style="width:8px; height:8px; border-radius:50%; background:#3DDC84;"></span>
            <span style="font-size:12px; font-weight:700; color:#F2F1F8;"<?php echo crux_edit_attr( 'consultancy', 'hero_right_text_5' ); ?>><?php echo crux_h( 'consultancy', 'hero_right_text_5' ); ?></span>
            <span style="font-size:11px; color:#9A9AC0; margin-left:auto;"<?php echo crux_edit_attr( 'consultancy', 'hero_right_text_6' ); ?>><?php echo crux_h( 'consultancy', 'hero_right_text_6' ); ?></span>
          </div>
          <div class="cb cb1" style="align-self:flex-end; max-width:85%; background:#2A2F5C; color:#F2F1F8; font-size:12px; line-height:1.45; padding:8px 12px; border-radius:14px 14px 2px 14px;"<?php echo crux_edit_attr( 'consultancy', 'hero_right_text_7' ); ?>><?php echo crux_h( 'consultancy', 'hero_right_text_7' ); ?></div>
          <div class="cb cb2" style="align-self:flex-start; max-width:85%; background:var(--crux-purple,#8C7AE6); color:var(--crux-ink2,#10142E); font-size:12px; font-weight:600; line-height:1.45; padding:8px 12px; border-radius:14px 14px 14px 2px;"<?php echo crux_edit_attr( 'consultancy', 'hero_right_text_8' ); ?>><?php echo crux_h( 'consultancy', 'hero_right_text_8' ); ?></div>
          <div class="cb cb3" style="align-self:flex-end; max-width:85%; background:#2A2F5C; color:#F2F1F8; font-size:12px; line-height:1.45; padding:8px 12px; border-radius:14px 14px 2px 14px;"<?php echo crux_edit_attr( 'consultancy', 'hero_right_text_9' ); ?>><?php echo crux_h( 'consultancy', 'hero_right_text_9' ); ?></div>
          <div class="cb cb4" style="align-self:flex-start; max-width:85%; background:var(--crux-purple,#8C7AE6); color:var(--crux-ink2,#10142E); font-size:12px; font-weight:600; line-height:1.45; padding:8px 12px; border-radius:14px 14px 14px 2px;"<?php echo crux_edit_attr( 'consultancy', 'hero_right_text_10' ); ?>><?php echo crux_h( 'consultancy', 'hero_right_text_10' ); ?></div>
          <div class="cb cbt" style="align-self:flex-start; display:flex; gap:4px; padding:5px 9px; background:#2A2F5C; border-radius:8px;">
            <span class="cdot cdot1" style="width:5px; height:5px; border-radius:50%; background:#9A9AC0;"></span>
            <span class="cdot cdot2" style="width:5px; height:5px; border-radius:50%; background:#9A9AC0;"></span>
            <span class="cdot cdot3" style="width:5px; height:5px; border-radius:50%; background:#9A9AC0;"></span>
          </div>
        </div>

      </div>

      <!-- Option 1 Mobile: Clean 50/50 Side-by-Side Grid with subtle tilt & exact owner text -->
      <div class="mobile-hero-grid">
        <!-- Before Card -->
        <div class="photo-card before" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:12px; overflow:hidden;">
          <div style="height:140px; background:var(--crux-text,#F4F5FA); overflow:hidden;">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/consultancy-retail-unit.jpg' ); ?>" alt="Before: We find the retail shop/unit/office" style="width:100%; height:100%; object-fit:cover; display:block;">
          </div>
          <div style="padding:8px 10px;">
            <span style="font-size:9.5px; font-weight:800; color:var(--crux-violet,#6C58DB); display:block;"<?php echo crux_edit_attr( 'consultancy', 'hero_right_text_3' ); ?>><?php echo crux_h( 'consultancy', 'hero_right_text_3' ); ?></span>
            <strong style="font-size:11.5px; color:var(--crux-ink2,#10142E); display:block; line-height:1.2; margin-top:2px;"<?php echo crux_edit_attr( 'consultancy', 'hero_right_paragraph_1' ); ?>><?php echo crux_h( 'consultancy', 'hero_right_paragraph_1' ); ?></strong>
          </div>
        </div>
        <!-- After Card -->
        <div class="photo-card after" style="background:#FFFFFF; border:2px solid var(--crux-purple,#8C7AE6); border-radius:12px; overflow:hidden;">
          <div style="height:140px; background:var(--crux-text,#F4F5FA); overflow:hidden;">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/consultancy-retail-stocked.jpg' ); ?>" alt="After: We build it/stock it/set up" style="width:100%; height:100%; object-fit:cover; display:block;">
          </div>
          <div style="padding:8px 10px;">
            <span style="font-size:9.5px; font-weight:800; color:var(--crux-red,#BA0000); display:block;"<?php echo crux_edit_attr( 'consultancy', 'hero_right_text_4' ); ?>><?php echo crux_h( 'consultancy', 'hero_right_text_4' ); ?></span>
            <strong style="font-size:11.5px; color:var(--crux-ink2,#10142E); display:block; line-height:1.2; margin-top:2px;"<?php echo crux_edit_attr( 'consultancy', 'hero_right_paragraph_2' ); ?>><?php echo crux_h( 'consultancy', 'hero_right_paragraph_2' ); ?></strong>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- 2 SOUND FAMILIAR -->
  <section id="soundFamiliarSection" style="min-height:671px; padding:60px 0 56px; background:#FFFFFF; width:100%; max-width:100%;" data-m="nomin">
    <div class="sound-familiar-header reveal" style="padding:0 64px; display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:40px;">
      <div><span class="eyebrow"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_small_heading_1' ); ?>><?php echo crux_h( 'consultancy', 'sound_familiar_small_heading_1' ); ?></span><h2 class="bebas" style="font-size:40px; margin:12px 0px 0px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_heading_1' ); ?>><?php echo crux_rich( 'consultancy', 'sound_familiar_heading_1' ); ?></h2></div>
      <div style="display:flex; gap:12px;" data-m="hide"><button onclick="prevSoundFamiliar()" aria-label="Previous" style="width:44px; height:44px; background:#F3F1FC; color:var(--crux-ink2,#10142E); font-size:18px; display:inline-flex; align-items:center; justify-content:center; --sl:7px; cursor:pointer;" class="bx">←</button><button onclick="nextSoundFamiliar()" aria-label="Next" style="width:44px; height:44px; background:var(--crux-purple,#8C7AE6); color:var(--crux-ink2,#10142E); font-size:18px; display:inline-flex; align-items:center; justify-content:center; --sl:7px; cursor:pointer;" class="bx">→</button></div>
    </div>
    <div id="soundFamiliarScroller" style="overflow-x:auto; scrollbar-width:none; padding-left:64px; padding-right:64px; width:100%;" class="reveal" data-m="scroller"><div style="display:flex; gap:24px; transition:transform .4s ease;" class="carousel-track" data-m="track">
        <div class="bento-tile" style="flex:0 0 400px; height:500px; position:relative; border-radius:22px; overflow:hidden; border:1.5px solid #E1DEF3;">
          <img src="<?php echo crux_img_url( 'consultancy', 'sound_familiar_photo_1' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:top;"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_photo_1' ); ?>>
          <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.97) 0%, rgba(16,20,46,0.55) 48%, rgba(16,20,46,0.05) 100%);"></div>
          <span class="bebas" style="position:absolute; left:26px; top:22px; font-size:40px; color:#FF2E3D; line-height:1;">“</span>
          <div style="position:absolute; left:0; right:0; bottom:0; padding:28px 28px 28px 28px;">
            <p style="font-size:24px; line-height:1.28; font-weight:700; color:#F2F1F8; margin:0px 0px 20px 0px;"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_paragraph_1' ); ?>><?php echo crux_h( 'consultancy', 'sound_familiar_paragraph_1' ); ?></p>
            <div style="border-top:2px dashed #3A3F72; padding-top:14px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; color:#9A9AC0;"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_text_1' ); ?>><?php echo crux_h( 'consultancy', 'sound_familiar_text_1' ); ?></span><span style="color:var(--crux-purple,#8C7AE6); font-size:11px; font-weight:700; letter-spacing:1.3px; padding:6px 13px 6px 13px; --sl:6px; --bc:var(--crux-purple,#8C7AE6);" class="bx"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_text_2' ); ?>><?php echo crux_h( 'consultancy', 'sound_familiar_text_2' ); ?></span></div>
          </div>
        </div>
        <div class="bento-tile" style="flex:0 0 400px; height:500px; position:relative; border-radius:22px; overflow:hidden; border:1.5px solid #E1DEF3;">
          <img src="<?php echo crux_img_url( 'consultancy', 'sound_familiar_photo_2' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center;"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_photo_2' ); ?>>
          <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.97) 0%, rgba(16,20,46,0.55) 48%, rgba(16,20,46,0.05) 100%);"></div>
          <span class="bebas" style="position:absolute; left:26px; top:22px; font-size:40px; color:#FF2E3D; line-height:1;">“</span>
          <div style="position:absolute; left:0; right:0; bottom:0; padding:28px 28px 28px 28px;">
            <p style="font-size:24px; line-height:1.28; font-weight:700; color:#F2F1F8; margin:0px 0px 20px 0px;"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_paragraph_2' ); ?>><?php echo crux_h( 'consultancy', 'sound_familiar_paragraph_2' ); ?></p>
            <div style="border-top:2px dashed #3A3F72; padding-top:14px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; color:#9A9AC0;"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_text_1' ); ?>><?php echo crux_h( 'consultancy', 'sound_familiar_text_1' ); ?></span><span style="color:var(--crux-purple,#8C7AE6); font-size:11px; font-weight:700; letter-spacing:1.3px; padding:6px 13px 6px 13px; --sl:6px; --bc:var(--crux-purple,#8C7AE6);" class="bx"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_text_3' ); ?>><?php echo crux_h( 'consultancy', 'sound_familiar_text_3' ); ?></span></div>
          </div>
        </div>
        <div class="bento-tile" style="flex:0 0 400px; height:500px; position:relative; border-radius:22px; overflow:hidden; border:1.5px solid #E1DEF3;">
          <img src="<?php echo crux_img_url( 'consultancy', 'sound_familiar_photo_3' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:top;"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_photo_3' ); ?>>
          <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.97) 0%, rgba(16,20,46,0.55) 48%, rgba(16,20,46,0.05) 100%);"></div>
          <span class="bebas" style="position:absolute; left:26px; top:22px; font-size:40px; color:#FF2E3D; line-height:1;">“</span>
          <div style="position:absolute; left:0; right:0; bottom:0; padding:28px 28px 28px 28px;">
            <p style="font-size:24px; line-height:1.28; font-weight:700; color:#F2F1F8; margin:0px 0px 20px 0px;"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_paragraph_3' ); ?>><?php echo crux_h( 'consultancy', 'sound_familiar_paragraph_3' ); ?></p>
            <div style="border-top:2px dashed #3A3F72; padding-top:14px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; color:#9A9AC0;"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_text_1' ); ?>><?php echo crux_h( 'consultancy', 'sound_familiar_text_1' ); ?></span><span style="color:var(--crux-purple,#8C7AE6); font-size:11px; font-weight:700; letter-spacing:1.3px; padding:6px 13px 6px 13px; --sl:6px; --bc:var(--crux-purple,#8C7AE6);" class="bx"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_text_4' ); ?>><?php echo crux_h( 'consultancy', 'sound_familiar_text_4' ); ?></span></div>
          </div>
        </div>
        <div class="bento-tile" style="flex:0 0 400px; height:500px; position:relative; border-radius:22px; overflow:hidden; border:1.5px solid #E1DEF3;">
          <img src="<?php echo crux_img_url( 'consultancy', 'sound_familiar_photo_4' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center;"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_photo_4' ); ?>>
          <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.97) 0%, rgba(16,20,46,0.55) 48%, rgba(16,20,46,0.05) 100%);"></div>
          <span class="bebas" style="position:absolute; left:26px; top:22px; font-size:40px; color:#FF2E3D; line-height:1;">“</span>
          <div style="position:absolute; left:0; right:0; bottom:0; padding:28px 28px 28px 28px;">
            <p style="font-size:24px; line-height:1.28; font-weight:700; color:#F2F1F8; margin:0px 0px 20px 0px;"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_paragraph_4' ); ?>><?php echo crux_h( 'consultancy', 'sound_familiar_paragraph_4' ); ?></p>
            <div style="border-top:2px dashed #3A3F72; padding-top:14px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; color:#9A9AC0;"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_text_1' ); ?>><?php echo crux_h( 'consultancy', 'sound_familiar_text_1' ); ?></span><span style="color:var(--crux-purple,#8C7AE6); font-size:11px; font-weight:700; letter-spacing:1.3px; padding:6px 13px 6px 13px; --sl:6px; --bc:var(--crux-purple,#8C7AE6);" class="bx"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_text_5' ); ?>><?php echo crux_h( 'consultancy', 'sound_familiar_text_5' ); ?></span></div>
          </div>
        </div>
        <div class="bento-tile" style="flex:0 0 400px; height:500px; position:relative; border-radius:22px; overflow:hidden; border:1.5px solid #E1DEF3;">
          <img src="<?php echo crux_img_url( 'consultancy', 'sound_familiar_photo_5' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center;"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_photo_5' ); ?>>
          <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.97) 0%, rgba(16,20,46,0.55) 48%, rgba(16,20,46,0.05) 100%);"></div>
          <span class="bebas" style="position:absolute; left:26px; top:22px; font-size:40px; color:#FF2E3D; line-height:1;">“</span>
          <div style="position:absolute; left:0; right:0; bottom:0; padding:28px 28px 28px 28px;">
            <p style="font-size:24px; line-height:1.28; font-weight:700; color:#F2F1F8; margin:0px 0px 20px 0px;"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_paragraph_5' ); ?>><?php echo crux_h( 'consultancy', 'sound_familiar_paragraph_5' ); ?></p>
            <div style="border-top:2px dashed #3A3F72; padding-top:14px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; color:#9A9AC0;"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_text_1' ); ?>><?php echo crux_h( 'consultancy', 'sound_familiar_text_1' ); ?></span><span style="color:var(--crux-purple,#8C7AE6); font-size:11px; font-weight:700; letter-spacing:1.3px; padding:6px 13px 6px 13px; --sl:6px; --bc:var(--crux-purple,#8C7AE6);" class="bx"<?php echo crux_edit_attr( 'consultancy', 'sound_familiar_text_6' ); ?>><?php echo crux_h( 'consultancy', 'sound_familiar_text_6' ); ?></span></div>
          </div>
        </div>
    </div></div>
  </section>

  <!-- 3 START WHERE YOU ARE -->
  <section style="min-height:593px; padding:60px clamp(24px, 5vw, 64px);" data-m="nomin">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:40px;" class="reveal" data-m="stack">
      <h2 class="bebas" style="font-size:40px; margin:0px 0px 0px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'start_where_you_are_heading_1' ); ?>><?php echo crux_h( 'consultancy', 'start_where_you_are_heading_1' ); ?></h2>
      <p style="max-width:380px; font-size:14px; color:#5A5F86; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'consultancy', 'start_where_you_are_paragraph_1' ); ?>><?php echo crux_h( 'consultancy', 'start_where_you_are_paragraph_1' ); ?></p>
    </div>
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:24px;" class="reveal" data-m="g1">

      <a href="#" class="tilt-ticket reveal" style="display:flex; background:#F3F1FC; border:1.5px solid #E1DEF3; border-radius:12px; min-height:300px; --r:-1deg; transform:rotate(var(--r)); overflow:hidden;">
        <div class="ticket-stub" style="flex:0 0 90px; background:var(--crux-purple,#8C7AE6); display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px;"><span class="bebas" style="font-size:38px; color:var(--crux-ink2,#10142E); line-height:1;">01</span><span style="font-size:10px; font-weight:800; letter-spacing:1.5px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'start_where_you_are_text_1' ); ?>><?php echo crux_h( 'consultancy', 'start_where_you_are_text_1' ); ?></span></div>
        <div style="flex:1; padding:28px 24px 28px 24px; display:flex; flex-direction:column; justify-content:flex-end;">
          <span class="eyebrow"<?php echo crux_edit_attr( 'consultancy', 'start_where_you_are_small_heading_1' ); ?>><?php echo crux_h( 'consultancy', 'start_where_you_are_small_heading_1' ); ?></span>
          <h3 style="font-size:20px; margin:8px 0px 10px 0px; font-weight:700; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'start_where_you_are_heading_2' ); ?>><?php echo crux_h( 'consultancy', 'start_where_you_are_heading_2' ); ?></h3>
          <p style="font-size:13px; line-height:1.65; color:#5A5F86; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'consultancy', 'start_where_you_are_paragraph_2' ); ?>><?php echo crux_h( 'consultancy', 'start_where_you_are_paragraph_2' ); ?></p>
        </div>
      </a>

      <a href="#" class="tilt-ticket reveal" style="display:flex; background:#F3F1FC; border:1.5px solid #E1DEF3; border-radius:12px; min-height:300px; --r:0.8deg; transform:rotate(var(--r)); overflow:hidden;">
        <div class="ticket-stub" style="flex:0 0 90px; background:var(--crux-purple,#8C7AE6); display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px;"><span class="bebas" style="font-size:38px; color:var(--crux-ink2,#10142E); line-height:1;">02</span><span style="font-size:10px; font-weight:800; letter-spacing:1.5px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'start_where_you_are_text_2' ); ?>><?php echo crux_h( 'consultancy', 'start_where_you_are_text_2' ); ?></span></div>
        <div style="flex:1; padding:28px 24px 28px 24px; display:flex; flex-direction:column; justify-content:flex-end;">
          <span class="eyebrow"<?php echo crux_edit_attr( 'consultancy', 'start_where_you_are_small_heading_1' ); ?>><?php echo crux_h( 'consultancy', 'start_where_you_are_small_heading_1' ); ?></span>
          <h3 style="font-size:20px; margin:8px 0px 10px 0px; font-weight:700; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'start_where_you_are_heading_3' ); ?>><?php echo crux_h( 'consultancy', 'start_where_you_are_heading_3' ); ?></h3>
          <p style="font-size:13px; line-height:1.65; color:#5A5F86; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'consultancy', 'start_where_you_are_paragraph_3' ); ?>><?php echo crux_h( 'consultancy', 'start_where_you_are_paragraph_3' ); ?></p>
        </div>
      </a>

      <a href="#" class="tilt-ticket reveal" style="display:flex; background:#F3F1FC; border:1.5px solid #E1DEF3; border-radius:12px; min-height:300px; --r:-0.8deg; transform:rotate(var(--r)); overflow:hidden;">
        <div class="ticket-stub" style="flex:0 0 90px; background:var(--crux-purple,#8C7AE6); display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px;"><span class="bebas" style="font-size:38px; color:var(--crux-ink2,#10142E); line-height:1;">03</span><span style="font-size:10px; font-weight:800; letter-spacing:1.5px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'start_where_you_are_text_3' ); ?>><?php echo crux_h( 'consultancy', 'start_where_you_are_text_3' ); ?></span></div>
        <div style="flex:1; padding:28px 24px 28px 24px; display:flex; flex-direction:column; justify-content:flex-end;">
          <span class="eyebrow"<?php echo crux_edit_attr( 'consultancy', 'start_where_you_are_small_heading_1' ); ?>><?php echo crux_h( 'consultancy', 'start_where_you_are_small_heading_1' ); ?></span>
          <h3 style="font-size:20px; margin:8px 0px 10px 0px; font-weight:700; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'start_where_you_are_heading_4' ); ?>><?php echo crux_h( 'consultancy', 'start_where_you_are_heading_4' ); ?></h3>
          <p style="font-size:13px; line-height:1.65; color:#5A5F86; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'consultancy', 'start_where_you_are_paragraph_4' ); ?>><?php echo crux_h( 'consultancy', 'start_where_you_are_paragraph_4' ); ?></p>
        </div>
      </a>
    </div>
  </section>

    <!-- 4 WHAT WE DO — 5 PANELS -->
  <section id="services" style="min-height:671px; padding:60px clamp(24px, 5vw, 64px); background:#FFFFFF;">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:34px;" class="reveal" data-m="stack">
      <div><span class="eyebrow"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_small_heading_1' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_small_heading_1' ); ?></span><h2 class="bebas" style="font-size:clamp(38px, 8vw, 60px); line-height:0.95; margin:12px 0 0; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_heading_1' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_heading_1' ); ?></h2></div>
      <p style="max-width:340px; font-size:13.5px; color:#5A5F86; margin:0;"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_paragraph_1' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_paragraph_1' ); ?></p>
    </div>
    <div class="consultancy-panels-container reveal" style="display:flex; gap:14px; height:520px;">
      <div class="cpanel active" onclick="selectPanel(this)" style="position:relative; overflow:hidden; border-radius:22px; border:1.5px solid var(--crux-purple,#8C7AE6); cursor:pointer; flex:5 1 0; min-width:0; transition:all .4s ease;">
        <img src="<?php echo crux_img_url( 'consultancy', 'what_we_do_photo_1' ); ?>" alt="Setup & Strategy" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:brightness(0.85);"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_photo_1' ); ?>>
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.96) 0%, rgba(16,20,46,0.35) 60%, rgba(16,20,46,0.55) 100%);"></div>
        <span class="bebas" style="position:absolute; left:22px; top:20px; font-size:34px; color:var(--crux-purple,#8C7AE6);">01</span>
        <span class="bebas cpanel-label" style="position:absolute; left:50%; bottom:28px; transform:translateX(-50%) rotate(180deg); writing-mode:vertical-rl; font-size:26px; color:#F2F1F8; white-space:nowrap; display:none;"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_1' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_1' ); ?></span>
        <div class="cpanel-body" style="position:absolute; left:0; right:0; bottom:0; padding:36px;"><h3 class="bebas" style="font-size:46px; margin:0 0 10px; color:#F2F1F8;"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_heading_2' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_heading_2' ); ?></h3><p style="font-size:14.5px; line-height:1.65; color:#C7C7DA; margin:0 0 14px; max-width:460px;"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_paragraph_2' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_paragraph_2' ); ?></p><div style="display:flex; gap:8px; flex-wrap:wrap;"><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_2' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_2' ); ?></span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_3' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_3' ); ?></span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_4' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_4' ); ?></span></div></div>
      </div>
      <div class="cpanel" onclick="selectPanel(this)" style="position:relative; overflow:hidden; border-radius:22px; border:1.5px solid #E1DEF3; cursor:pointer; flex:1 1 0; min-width:0; transition:all .4s ease;">
        <img src="<?php echo crux_img_url( 'consultancy', 'what_we_do_photo_2' ); ?>" alt="Branding & Marketing" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:brightness(0.5);"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_photo_2' ); ?>>
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.96) 0%, rgba(16,20,46,0.35) 60%, rgba(16,20,46,0.55) 100%);"></div>
        <span class="bebas" style="position:absolute; left:22px; top:20px; font-size:24px; color:var(--crux-purple,#8C7AE6);">02</span>
        <span class="bebas cpanel-label" style="position:absolute; left:50%; bottom:28px; transform:translateX(-50%) rotate(180deg); writing-mode:vertical-rl; font-size:26px; color:#F2F1F8; white-space:nowrap;"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_5' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_5' ); ?></span>
        <div class="cpanel-body" style="position:absolute; left:0; right:0; bottom:0; padding:36px; display:none;"><h3 class="bebas" style="font-size:46px; margin:0 0 10px; color:#F2F1F8;"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_5' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_5' ); ?></h3><p style="font-size:14.5px; line-height:1.65; color:#C7C7DA; margin:0 0 14px; max-width:460px;"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_paragraph_3' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_paragraph_3' ); ?></p><div style="display:flex; gap:8px; flex-wrap:wrap;"><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_6' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_6' ); ?></span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_7' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_7' ); ?></span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_8' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_8' ); ?></span></div></div>
      </div>
      <div class="cpanel" onclick="selectPanel(this)" style="position:relative; overflow:hidden; border-radius:22px; border:1.5px solid #E1DEF3; cursor:pointer; flex:1 1 0; min-width:0; transition:all .4s ease;">
        <img src="<?php echo crux_img_url( 'consultancy', 'what_we_do_photo_3' ); ?>" alt="Operations & Workflow" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:brightness(0.5);"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_photo_3' ); ?>>
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.96) 0%, rgba(16,20,46,0.35) 60%, rgba(16,20,46,0.55) 100%);"></div>
        <span class="bebas" style="position:absolute; left:22px; top:20px; font-size:24px; color:var(--crux-purple,#8C7AE6);">03</span>
        <span class="bebas cpanel-label" style="position:absolute; left:50%; bottom:28px; transform:translateX(-50%) rotate(180deg); writing-mode:vertical-rl; font-size:26px; color:#F2F1F8; white-space:nowrap;"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_9' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_9' ); ?></span>
        <div class="cpanel-body" style="position:absolute; left:0; right:0; bottom:0; padding:36px; display:none;"><h3 class="bebas" style="font-size:46px; margin:0 0 10px; color:#F2F1F8;"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_9' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_9' ); ?></h3><p style="font-size:14.5px; line-height:1.65; color:#C7C7DA; margin:0 0 14px; max-width:460px;"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_paragraph_4' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_paragraph_4' ); ?></p><div style="display:flex; gap:8px; flex-wrap:wrap;"><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_10' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_10' ); ?></span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_11' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_11' ); ?></span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_12' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_12' ); ?></span></div></div>
      </div>
      <div class="cpanel" onclick="selectPanel(this)" style="position:relative; overflow:hidden; border-radius:22px; border:1.5px solid #E1DEF3; cursor:pointer; flex:1 1 0; min-width:0; transition:all .4s ease;">
        <img src="<?php echo crux_img_url( 'consultancy', 'what_we_do_photo_4' ); ?>" alt="Growth & Scaling" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:brightness(0.5);"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_photo_4' ); ?>>
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.96) 0%, rgba(16,20,46,0.35) 60%, rgba(16,20,46,0.55) 100%);"></div>
        <span class="bebas" style="position:absolute; left:22px; top:20px; font-size:24px; color:var(--crux-purple,#8C7AE6);">04</span>
        <span class="bebas cpanel-label" style="position:absolute; left:50%; bottom:28px; transform:translateX(-50%) rotate(180deg); writing-mode:vertical-rl; font-size:26px; color:#F2F1F8; white-space:nowrap;"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_13' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_13' ); ?></span>
        <div class="cpanel-body" style="position:absolute; left:0; right:0; bottom:0; padding:36px; display:none;"><h3 class="bebas" style="font-size:46px; margin:0 0 10px; color:#F2F1F8;"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_13' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_13' ); ?></h3><p style="font-size:14.5px; line-height:1.65; color:#C7C7DA; margin:0 0 14px; max-width:460px;"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_paragraph_5' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_paragraph_5' ); ?></p><div style="display:flex; gap:8px; flex-wrap:wrap;"><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_14' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_14' ); ?></span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_15' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_15' ); ?></span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_16' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_16' ); ?></span></div></div>
      </div>
      <div class="cpanel" onclick="selectPanel(this)" style="position:relative; overflow:hidden; border-radius:22px; border:1.5px solid #E1DEF3; cursor:pointer; flex:1 1 0; min-width:0; transition:all .4s ease;">
        <img src="<?php echo crux_img_url( 'consultancy', 'what_we_do_photo_5' ); ?>" alt="Event Advisory" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:brightness(0.5);"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_photo_5' ); ?>>
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.96) 0%, rgba(16,20,46,0.35) 60%, rgba(16,20,46,0.55) 100%);"></div>
        <span class="bebas" style="position:absolute; left:22px; top:20px; font-size:24px; color:var(--crux-purple,#8C7AE6);">05</span>
        <span class="bebas cpanel-label" style="position:absolute; left:50%; bottom:28px; transform:translateX(-50%) rotate(180deg); writing-mode:vertical-rl; font-size:26px; color:#F2F1F8; white-space:nowrap;"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_17' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_17' ); ?></span>
        <div class="cpanel-body" style="position:absolute; left:0; right:0; bottom:0; padding:36px; display:none;"><h3 class="bebas" style="font-size:46px; margin:0 0 10px; color:#F2F1F8;"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_17' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_17' ); ?></h3><p style="font-size:14.5px; line-height:1.65; color:#C7C7DA; margin:0 0 14px; max-width:460px;"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_paragraph_6' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_paragraph_6' ); ?></p><div style="display:flex; gap:8px; flex-wrap:wrap;"><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_18' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_18' ); ?></span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_19' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_19' ); ?></span><span style="color:#D6D6E8; font-size:11.5px; font-weight:600; padding:6px 13px; --sl:6px; --bc:#5A5FA0;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'what_we_do_text_20' ); ?>><?php echo crux_h( 'consultancy', 'what_we_do_text_20' ); ?></span></div></div>
      </div>
    </div>
  </section>

  <!-- 5 HOW IT WORKS — the climb -->
  <section id="how" style="min-height:702px; padding:60px clamp(24px, 5vw, 64px); background:#F3F1FC;" data-m="nomin">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:64px;" class="reveal" data-m="stack">
      <div><span class="eyebrow"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_small_heading_1' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_small_heading_1' ); ?></span><h2 class="bebas" style="font-size:40px; margin:12px 0px 0px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_heading_1' ); ?>><?php echo crux_rich( 'consultancy', 'how_it_works_heading_1' ); ?></h2></div>
      <p style="max-width:330px; font-size:14px; line-height:1.7; color:#5A5F86; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_paragraph_1' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_paragraph_1' ); ?></p>
    </div>
    <div style="display:grid; grid-template-columns:repeat(5, minmax(0, 1fr)); gap:16px; align-items:end;" class="reveal" data-m="g1">
      <div style="position:relative; height:270px; background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:20px; padding:0px 0px 0px 0px; overflow:visible; display:flex; flex-direction:column;" class="reveal">
        <div style="position:absolute; left:20px; top:-28px; width:56px; height:56px; border-radius:50%; background:#F3F1FC; border:2px dashed var(--crux-violet,#6C58DB); display:flex; align-items:center; justify-content:center; z-index:2;" data-m="hide"><span class="bebas" style="font-size:22px; color:var(--crux-violet,#6C58DB);">01</span></div>
        <div style="height:86px; margin:0px 0px 0px 0px; border-radius:18px 18px 0 0; overflow:hidden; position:relative;"><img src="<?php echo crux_img_url( 'consultancy', 'how_it_works_photo_1' ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_photo_1' ); ?>><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.55) 0%, rgba(16,20,46,0.05) 100%);"></div></div>
        <div style=" padding:16px 20px 20px 20px; flex:1; display:flex; flex-direction:column;">
          <h3 class="bebas" style="font-size:26px; margin:6px 0px 8px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_heading_2' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_heading_2' ); ?></h3>
          <p style="font-size:13px; line-height:1.6; color:#3A3F66; margin:0 0 auto;"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_paragraph_2' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_paragraph_2' ); ?></p>
          <div style="border-top:1.5px dashed #D2CEEA; padding-top:10px; margin-top:12px; display:flex; flex-direction:column; gap:4px;"><span style="font-size:11px; color:#5A5F86;"><b style="letter-spacing:1px; color:var(--crux-violet,#6C58DB);"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_emphasis_1' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_emphasis_1' ); ?></b> <?php echo crux_h( 'consultancy', 'how_it_works_text_1' ); ?></span><span style="font-size:11px; color:#5A5F86;"><b style="letter-spacing:1px; color:#D9182A;"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_emphasis_2' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_emphasis_2' ); ?></b> <?php echo crux_h( 'consultancy', 'how_it_works_text_2' ); ?></span></div>
        </div>
      </div>
      <div style="position:relative; height:308px; background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:20px; padding:0px 0px 0px 0px; overflow:visible; display:flex; flex-direction:column;" class="reveal">
        <div style="position:absolute; left:20px; top:-28px; width:56px; height:56px; border-radius:50%; background:#F3F1FC; border:2px dashed var(--crux-violet,#6C58DB); display:flex; align-items:center; justify-content:center; z-index:2;" data-m="hide"><span class="bebas" style="font-size:22px; color:var(--crux-violet,#6C58DB);">02</span></div>
        <div style="height:86px; margin:0px 0px 0px 0px; border-radius:18px 18px 0 0; overflow:hidden; position:relative;"><img src="<?php echo crux_img_url( 'consultancy', 'how_it_works_photo_2' ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_photo_2' ); ?>><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.55) 0%, rgba(16,20,46,0.05) 100%);"></div></div>
        <div style=" padding:16px 20px 20px 20px; flex:1; display:flex; flex-direction:column;">
          <h3 class="bebas" style="font-size:26px; margin:6px 0px 8px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_heading_3' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_heading_3' ); ?></h3>
          <p style="font-size:13px; line-height:1.6; color:#3A3F66; margin:0 0 auto;"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_paragraph_3' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_paragraph_3' ); ?></p>
          <div style="border-top:1.5px dashed #D2CEEA; padding-top:10px; margin-top:12px; display:flex; flex-direction:column; gap:4px;"><span style="font-size:11px; color:#5A5F86;"><b style="letter-spacing:1px; color:var(--crux-violet,#6C58DB);"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_emphasis_1' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_emphasis_1' ); ?></b> <?php echo crux_h( 'consultancy', 'how_it_works_text_3' ); ?></span><span style="font-size:11px; color:#5A5F86;"><b style="letter-spacing:1px; color:#D9182A;"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_emphasis_2' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_emphasis_2' ); ?></b> <?php echo crux_h( 'consultancy', 'how_it_works_text_4' ); ?></span></div>
        </div>
      </div>
      <div style="position:relative; height:346px; background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:20px; padding:0px 0px 0px 0px; overflow:visible; display:flex; flex-direction:column;" class="reveal">
        <div style="position:absolute; left:20px; top:-28px; width:56px; height:56px; border-radius:50%; background:#F3F1FC; border:2px dashed var(--crux-violet,#6C58DB); display:flex; align-items:center; justify-content:center; z-index:2;" data-m="hide"><span class="bebas" style="font-size:22px; color:var(--crux-violet,#6C58DB);">03</span></div>
        <div style="height:100px; margin:0px 0px 0px 0px; border-radius:18px 18px 0 0; overflow:hidden; position:relative;"><img src="<?php echo crux_img_url( 'consultancy', 'how_it_works_photo_3' ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_photo_3' ); ?>><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.55) 0%, rgba(16,20,46,0.05) 100%);"></div></div>
        <div style=" padding:16px 20px 20px 20px; flex:1; display:flex; flex-direction:column;">
          <h3 class="bebas" style="font-size:26px; margin:6px 0px 8px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_heading_4' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_heading_4' ); ?></h3>
          <p style="font-size:13px; line-height:1.6; color:#3A3F66; margin:0 0 auto;"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_paragraph_4' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_paragraph_4' ); ?></p>
          <div style="border-top:1.5px dashed #D2CEEA; padding-top:10px; margin-top:12px; display:flex; flex-direction:column; gap:4px;"><span style="font-size:11px; color:#5A5F86;"><b style="letter-spacing:1px; color:var(--crux-violet,#6C58DB);"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_emphasis_1' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_emphasis_1' ); ?></b> <?php echo crux_h( 'consultancy', 'how_it_works_text_5' ); ?></span><span style="font-size:11px; color:#5A5F86;"><b style="letter-spacing:1px; color:#D9182A;"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_emphasis_2' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_emphasis_2' ); ?></b> <?php echo crux_h( 'consultancy', 'how_it_works_text_6' ); ?></span></div>
        </div>
      </div>
      <div style="position:relative; height:384px; background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:20px; padding:0px 0px 0px 0px; overflow:visible; display:flex; flex-direction:column;" class="reveal">
        <div style="position:absolute; left:20px; top:-28px; width:56px; height:56px; border-radius:50%; background:#F3F1FC; border:2px dashed var(--crux-violet,#6C58DB); display:flex; align-items:center; justify-content:center; z-index:2;" data-m="hide"><span class="bebas" style="font-size:22px; color:var(--crux-violet,#6C58DB);">04</span></div>
        <div style="height:100px; margin:0px 0px 0px 0px; border-radius:18px 18px 0 0; overflow:hidden; position:relative;"><img src="<?php echo crux_img_url( 'consultancy', 'how_it_works_photo_4' ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_photo_4' ); ?>><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.55) 0%, rgba(16,20,46,0.05) 100%);"></div></div>
        <div style=" padding:16px 20px 20px 20px; flex:1; display:flex; flex-direction:column;">
          <h3 class="bebas" style="font-size:26px; margin:6px 0px 8px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_heading_5' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_heading_5' ); ?></h3>
          <p style="font-size:13px; line-height:1.6; color:#3A3F66; margin:0 0 auto;"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_paragraph_5' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_paragraph_5' ); ?></p>
          <div style="border-top:1.5px dashed #D2CEEA; padding-top:10px; margin-top:12px; display:flex; flex-direction:column; gap:4px;"><span style="font-size:11px; color:#5A5F86;"><b style="letter-spacing:1px; color:var(--crux-violet,#6C58DB);"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_emphasis_1' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_emphasis_1' ); ?></b> <?php echo crux_h( 'consultancy', 'how_it_works_text_7' ); ?></span><span style="font-size:11px; color:#5A5F86;"><b style="letter-spacing:1px; color:#D9182A;"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_emphasis_2' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_emphasis_2' ); ?></b> <?php echo crux_h( 'consultancy', 'how_it_works_text_8' ); ?></span></div>
        </div>
      </div>
      <div style="position:relative; height:422px; background:var(--crux-purple,#8C7AE6); border:1.5px solid var(--crux-purple,#8C7AE6); border-radius:20px; padding:0px 0px 0px 0px; overflow:visible; display:flex; flex-direction:column;" class="reveal">
        <div style="position:absolute; left:20px; top:-28px; width:56px; height:56px; border-radius:50%; background:#F3F1FC; border:2px dashed var(--crux-violet,#6C58DB); display:flex; align-items:center; justify-content:center; z-index:2;" data-m="hide"><span class="bebas" style="font-size:22px; color:var(--crux-violet,#6C58DB);">05</span></div>
        <div style="height:120px; margin:0px 0px 0px 0px; border-radius:18px 18px 0 0; overflow:hidden; position:relative;"><img src="<?php echo crux_img_url( 'consultancy', 'how_it_works_photo_5' ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_photo_5' ); ?>><div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(140,122,230,0.5) 0%, rgba(16,20,46,0.05) 100%);"></div></div>
        <div style=" padding:16px 20px 20px 20px; flex:1; display:flex; flex-direction:column;">
          <h3 class="bebas" style="font-size:26px; margin:6px 0px 8px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_heading_6' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_heading_6' ); ?></h3>
          <p style="font-size:13px; line-height:1.6; color:var(--crux-ink2,#10142E); margin:0 0 auto;"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_paragraph_6' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_paragraph_6' ); ?></p>
          <div style="border-top:1.5px dashed rgba(16,20,46,0.4); padding-top:10px; margin-top:12px; display:flex; flex-direction:column; gap:4px;"><span style="font-size:11px; color:var(--crux-ink2,#10142E);"><b style="letter-spacing:1px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_emphasis_1' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_emphasis_1' ); ?></b> <?php echo crux_h( 'consultancy', 'how_it_works_text_9' ); ?></span><span style="font-size:11px; color:var(--crux-ink2,#10142E);"><b style="letter-spacing:1px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'how_it_works_emphasis_2' ); ?>><?php echo crux_h( 'consultancy', 'how_it_works_emphasis_2' ); ?></b> <?php echo crux_h( 'consultancy', 'how_it_works_text_10' ); ?></span></div>
        </div>
      </div>
    </div>
  </section>

  <!-- 6 WHAT YOU WALK AWAY WITH -->
  <section style=" padding:60px clamp(24px, 5vw, 64px); background:#FFFFFF;">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:40px;" class="reveal" data-m="stack">
      <div><span class="eyebrow"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_small_heading_1' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_small_heading_1' ); ?></span><h2 class="bebas" style="font-size:40px; margin:12px 0px 0px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_heading_1' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_heading_1' ); ?></h2></div>
      <p style="max-width:340px; font-size:13.5px; color:#5A5F86; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_paragraph_1' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_paragraph_1' ); ?></p>
    </div>
    <div style="display:grid; grid-template-columns:repeat(12, minmax(0, 1fr)); grid-template-rows:repeat(2, 330px); gap:16px;" class="reveal" data-m="g1">

      <div class="bento-tile reveal" style="position:relative; overflow:hidden; border-radius:24px; border:1.5px solid rgba(242,241,248,0.14); grid-column:span 5; grid-row:span 2;" data-m="span tile">
        <img src="<?php echo crux_img_url( 'consultancy', 'what_you_walk_away_with_photo_1' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_photo_1' ); ?>>
        <div style="position:absolute; inset:0; background:linear-gradient(180deg, rgba(16,20,46,0.3) 0%, rgba(16,20,46,0.9) 58%, rgba(16,20,46,0.96) 100%);"></div>
        <div style="position:relative; height:100%; padding:22px 22px 22px 22px; display:flex; flex-direction:column; justify-content:flex-end; gap:16px;"><div style="background:rgba(16,20,46,0.96) !important; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); border:1.5px solid #3A3F72; border-radius:14px; padding:16px 16px 16px 16px;"><span style="font-size:9.5px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--crux-purple,#8C7AE6);"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_1' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_1' ); ?></span><div style="display:flex; align-items:center; gap:10px; margin-top:9px;"><span style="width:16px; height:16px; border-radius:5px; background:var(--crux-purple,#8C7AE6);"></span><span style="font-size:12.5px; color:#F2F1F8;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_2' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_2' ); ?></span></div><div style="display:flex; align-items:center; gap:10px; margin-top:9px;"><span style="width:16px; height:16px; border-radius:5px; background:var(--crux-purple,#8C7AE6);"></span><span style="font-size:12.5px; color:#F2F1F8;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_3' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_3' ); ?></span></div><div style="display:flex; align-items:center; gap:10px; margin-top:9px;"><span style="width:16px; height:16px; border-radius:5px; background:var(--crux-purple,#8C7AE6);"></span><span style="font-size:12.5px; color:#F2F1F8;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_4' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_4' ); ?></span></div><div style="display:flex; align-items:center; gap:10px; margin-top:9px;"><span class="ap4" style="width:16px; height:16px; border-radius:5px; border:1.5px solid #FF2E3D;"></span><span style="font-size:12.5px; color:#9A9AC0;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_5' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_5' ); ?></span></div><div style="display:flex; align-items:center; gap:10px; margin-top:9px;"><span class="ap5" style="width:16px; height:16px; border-radius:5px; border:1.5px solid #FF2E3D;"></span><span style="font-size:12.5px; color:#9A9AC0;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_6' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_6' ); ?></span></div><div style="height:6px; background:#3A3F72; border-radius:3px; margin-top:16px; overflow:hidden;"><div class="apbar" style="width:55%; height:100%; background:var(--crux-purple,#8C7AE6);"></div></div></div><div><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:#F2F1F8;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_heading_2' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_heading_2' ); ?></h3><p style="font-size:13px; line-height:1.6; color:#C7C7DA; margin:0px 0px 10px 0px;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_paragraph_2' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_paragraph_2' ); ?></p><span style="font-size:11px; letter-spacing:1.3px; font-weight:700; color:var(--crux-purple,#8C7AE6);"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_7' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_7' ); ?></span></div></div>
      </div>

      <div class="bento-tile reveal" style="position:relative; overflow:hidden; border-radius:24px; background:var(--crux-purple,#8C7AE6); border:1.5px solid var(--crux-purple,#8C7AE6); grid-column:span 4;" data-m="span">
        <div style="position:relative; height:100%; padding:22px 22px 22px 22px; display:flex; flex-direction:column; justify-content:flex-end; gap:16px;"><div style="background:var(--crux-ink2,#10142E); border:1.5px solid var(--crux-ink2,#10142E); border-radius:14px; padding:16px 16px 16px 16px;"><span style="font-size:9.5px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--crux-purple,#8C7AE6);"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_8' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_8' ); ?></span><p class="bebas" style="font-size:22px; margin:8px 0px 0px 0px; color:#F2F1F8; line-height:1;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_paragraph_3' ); ?>><?php echo crux_rich( 'consultancy', 'what_you_walk_away_with_paragraph_3' ); ?></p></div><div><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_heading_3' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_heading_3' ); ?></h3><p style="font-size:13px; line-height:1.6; color:#1E2350; margin:0px 0px 10px 0px;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_paragraph_4' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_paragraph_4' ); ?></p><span style="font-size:11px; letter-spacing:1.3px; font-weight:700; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_9' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_9' ); ?></span></div></div>
      </div>

      <div class="bento-tile reveal" style="position:relative; overflow:hidden; border-radius:24px; background:var(--crux-ink2,#10142E); border:1.5px solid #2A2F5C; grid-column:span 3;" data-m="span">
        <div style="position:relative; height:100%; padding:22px 22px 22px 22px; display:flex; flex-direction:column; justify-content:flex-end; gap:16px;"><div style="background:#1B2048; border:1.5px solid #3A3F72; border-radius:14px; padding:16px 16px 16px 16px;"><span style="font-size:9.5px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--crux-purple,#8C7AE6);"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_10' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_10' ); ?></span><div style="display:flex; gap:6px; margin:10px 0px 8px 0px;" data-m="wrap"><span class="sw1" style="flex:1; height:26px; border-radius:7px; background:var(--crux-ink2,#10142E); border:1px solid #3A3F72;"></span><span class="sw2" style="flex:1; height:26px; border-radius:7px; background:var(--crux-purple,#8C7AE6);"></span><span class="sw3" style="flex:1; height:26px; border-radius:7px; background:#FF2E3D;"></span></div><span class="bebas" style="font-size:20px; color:#F2F1F8;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_11' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_11' ); ?></span></div><div><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:#F2F1F8;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_heading_4' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_heading_4' ); ?></h3><p style="font-size:13px; line-height:1.6; color:#C7C7DA; margin:0px 0px 10px 0px;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_paragraph_5' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_paragraph_5' ); ?></p><span style="font-size:11px; letter-spacing:1.3px; font-weight:700; color:var(--crux-purple,#8C7AE6);"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_12' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_12' ); ?></span></div></div>
      </div>

      <div class="bento-tile reveal" style="position:relative; overflow:hidden; border-radius:24px; background:#E9E5FB; border:1.5px solid #D6D0F5; grid-column:span 3;" data-m="span">
        <div style="position:relative; height:100%; padding:22px 22px 22px 22px; display:flex; flex-direction:column; justify-content:flex-end; gap:16px;"><div style="background:#FFFFFF; border:1.5px solid #D6D0F5; border-radius:14px; padding:16px 16px 16px 16px;"><span style="font-size:9.5px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:#5B45C8;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_13' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_13' ); ?></span><div style="display:flex; align-items:center; gap:8px; margin-top:10px;"><span class="nowp bx" style="background:var(--crux-purple,#8C7AE6); color:var(--crux-ink2,#10142E); font-size:9.5px; font-weight:800; padding:4px 9px 4px 9px; --sl:6px;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_14' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_14' ); ?></span><span class="rm1" style="display:block; height:7px; width:70%; background:#DAD6F0; border-radius:4px;"></span></div><div style="display:flex; align-items:center; gap:8px; margin-top:8px;"><span style="color:#5B45C8; font-size:9.5px; font-weight:800; padding:3px 8px 3px 8px; --sl:6px; --bc:#5B45C8;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_15' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_15' ); ?></span><span class="rm2" style="display:block; height:7px; width:48%; background:#DAD6F0; border-radius:4px;"></span></div><div style="display:flex; align-items:center; gap:8px; margin-top:8px;"><span style="color:#5A5F86; font-size:9.5px; font-weight:800; padding:3px 8px 3px 8px; --sl:6px; --bc:#9A9AC0;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_16' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_16' ); ?></span><span class="rm3" style="display:block; height:7px; width:30%; background:#DAD6F0; border-radius:4px;"></span></div></div><div><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_heading_5' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_heading_5' ); ?></h3><p style="font-size:13px; line-height:1.6; color:#3A3F66; margin:0px 0px 10px 0px;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_paragraph_6' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_paragraph_6' ); ?></p><span style="font-size:11px; letter-spacing:1.3px; font-weight:700; color:#5B45C8;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_17' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_17' ); ?></span></div></div>
      </div>

      <div class="bento-tile reveal" style="position:relative; overflow:hidden; border-radius:24px; border:1.5px solid rgba(242,241,248,0.14); grid-column:span 4;" data-m="span tile">
        <img src="<?php echo crux_img_url( 'consultancy', 'what_you_walk_away_with_photo_2' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_photo_2' ); ?>>
        <div style="position:absolute; inset:0; background:linear-gradient(180deg, rgba(16,20,46,0.3) 0%, rgba(16,20,46,0.9) 58%, rgba(16,20,46,0.96) 100%);"></div>
        <div style="position:relative; height:100%; padding:22px 22px 22px 22px; display:flex; flex-direction:column; justify-content:flex-end; gap:16px;"><div style="background:rgba(16,20,46,0.96) !important; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); border:1.5px solid #3A3F72; border-radius:14px; padding:16px 16px 16px 16px;"><span style="font-size:9.5px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:var(--crux-purple,#8C7AE6);"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_18' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_18' ); ?></span><div style="display:flex; justify-content:space-around; margin-top:12px;" data-m="wrap"><div style="text-align:center;"><div class="rg rg72" style="--p:72; width:58px; height:58px; border-radius:50%; background:conic-gradient(var(--crux-purple,#8C7AE6) calc(var(--p) * 1%), #3A3F72 0); display:flex; align-items:center; justify-content:center;"><span class="rgn" style="width:42px; height:42px; border-radius:50%; background:var(--crux-ink2,#10142E); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#F2F1F8;"></span></div><span style="font-size:10.5px; color:#9A9AC0; display:block; margin-top:5px;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_19' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_19' ); ?></span></div><div style="text-align:center;"><div class="rg rg45" style="--p:45; width:58px; height:58px; border-radius:50%; background:conic-gradient(#FF2E3D calc(var(--p) * 1%), #3A3F72 0); display:flex; align-items:center; justify-content:center;"><span class="rgn" style="width:42px; height:42px; border-radius:50%; background:var(--crux-ink2,#10142E); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#F2F1F8;"></span></div><span style="font-size:10.5px; color:#9A9AC0; display:block; margin-top:5px;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_20' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_20' ); ?></span></div><div style="text-align:center;"><div class="rg rg88" style="--p:88; width:58px; height:58px; border-radius:50%; background:conic-gradient(var(--crux-purple,#8C7AE6) calc(var(--p) * 1%), #3A3F72 0); display:flex; align-items:center; justify-content:center;"><span class="rgn" style="width:42px; height:42px; border-radius:50%; background:var(--crux-ink2,#10142E); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#F2F1F8;"></span></div><span style="font-size:10.5px; color:#9A9AC0; display:block; margin-top:5px;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_21' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_21' ); ?></span></div></div></div><div><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:#F2F1F8;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_heading_6' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_heading_6' ); ?></h3><p style="font-size:13px; line-height:1.6; color:#C7C7DA; margin:0px 0px 10px 0px;"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_paragraph_7' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_paragraph_7' ); ?></p><span style="font-size:11px; letter-spacing:1.3px; font-weight:700; color:var(--crux-purple,#8C7AE6);"<?php echo crux_edit_attr( 'consultancy', 'what_you_walk_away_with_text_22' ); ?>><?php echo crux_h( 'consultancy', 'what_you_walk_away_with_text_22' ); ?></span></div></div>
      </div>
    </div>
  </section>

  <!-- 7 WHY US -->
  <section style="min-height:577px; padding:60px clamp(24px, 5vw, 64px); display:grid; grid-template-columns:1fr 1fr; gap:70px; align-items:center;" data-m="g1 nomin">
    <div class="reveal">
      <span class="eyebrow"<?php echo crux_edit_attr( 'consultancy', 'why_us_small_heading_1' ); ?>><?php echo crux_h( 'consultancy', 'why_us_small_heading_1' ); ?></span>
      <h2 class="bebas" style="font-size:40px; margin:14px 0px 22px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'why_us_heading_1' ); ?>><?php echo crux_h( 'consultancy', 'why_us_heading_1' ); ?></h2>
      <p style="font-size:15.5px; line-height:1.8; color:#3A3F66; margin:0px 0px 16px 0px;"<?php echo crux_edit_attr( 'consultancy', 'why_us_paragraph_1' ); ?>><?php echo crux_h( 'consultancy', 'why_us_paragraph_1' ); ?></p>
      <p style="font-size:15.5px; line-height:1.8; color:#3A3F66; margin:0px 0px 26px 0px;"<?php echo crux_edit_attr( 'consultancy', 'why_us_paragraph_2' ); ?>><?php echo crux_h( 'consultancy', 'why_us_paragraph_2' ); ?></p>
      <a href="<?php echo crux_url( 'consultancy', 'why_us_link_1_url' ); ?>" style="font-weight:700; font-size:14px; color:var(--crux-violet,#6C58DB); border-bottom:1.5px solid var(--crux-violet,#6C58DB); padding-bottom:2px;"<?php echo crux_edit_attr( 'consultancy', 'why_us_link_1' ); ?>><?php echo crux_h( 'consultancy', 'why_us_link_1' ); ?></a>
    </div>
    <div style="position:relative; height:480px;" class="reveal why-us-collage" data-m="tile collage">
      <img class="tilt-straighten" src="<?php echo crux_img_url( 'consultancy', 'why_us_photo_1' ); ?>" alt="" style="--r:-6deg; transform:rotate(var(--r)); position:absolute; left:0; top:30px; width:250px; height:310px; object-fit:cover; border-radius:14px; border:2px solid #E1DEF3;"<?php echo crux_edit_attr( 'consultancy', 'why_us_photo_1' ); ?>>
      <img src="<?php echo crux_img_url( 'consultancy', 'why_us_photo_2' ); ?>" alt="" style="position:absolute; left:190px; top:90px; width:290px; height:350px; object-fit:cover; border-radius:14px; border:2px solid var(--crux-purple,#8C7AE6); z-index:1;"<?php echo crux_edit_attr( 'consultancy', 'why_us_photo_2' ); ?>>
      <img class="tilt-straighten" src="<?php echo crux_img_url( 'consultancy', 'why_us_photo_3' ); ?>" alt="" style="--r:6deg; transform:rotate(var(--r)); position:absolute; right:0; top:0; width:220px; height:290px; object-fit:cover; border-radius:14px; border:2px solid #E1DEF3;"<?php echo crux_edit_attr( 'consultancy', 'why_us_photo_3' ); ?>>
    </div>
  </section>

  <!-- 8 MEET THE STRATEGIC TEAM / FOUNDER -->
  <section id="founder" style="padding:70px clamp(24px, 5vw, 64px); background:#FFFFFF; border-top:1px solid #E1DEF3; border-bottom:1px solid #E1DEF3;">
    <div class="founder-section-wrap reveal" style="max-width:1120px; margin:0 auto; display:grid; grid-template-columns:280px 1fr; gap:52px; align-items:center;">
      <div class="founder-img-col" style="width:280px; height:340px; border-radius:18px; overflow:hidden; border:2.5px solid var(--crux-purple,#8C7AE6); box-shadow:0 18px 44px rgba(140,122,230,0.22); flex-shrink:0;">
        <img src="<?php echo crux_img_url( 'consultancy', 'meet_the_strategic_team_foun_photo_1' ); ?>" alt="Olabamidele 'Bambad' Badmos" style="width:100%; height:100%; object-fit:cover; object-position:58% 12%;"<?php echo crux_edit_attr( 'consultancy', 'meet_the_strategic_team_foun_photo_1' ); ?>>
      </div>
      <div class="founder-info-col">
        <span class="eyebrow" style="color:var(--crux-violet,#6C58DB);"<?php echo crux_edit_attr( 'consultancy', 'meet_the_strategic_team_foun_small_heading_1' ); ?>><?php echo crux_h( 'consultancy', 'meet_the_strategic_team_foun_small_heading_1' ); ?></span>
        <h2 class="bebas" style="font-size:clamp(36px, 4.5vw, 48px); margin:12px 0 14px; color:var(--crux-ink2,#10142E); line-height:0.95;"<?php echo crux_edit_attr( 'consultancy', 'meet_the_strategic_team_foun_heading_1' ); ?>><?php echo crux_h( 'consultancy', 'meet_the_strategic_team_foun_heading_1' ); ?></h2>
        <p style="font-size:15px; line-height:1.75; color:#3A3F66; margin:0 0 12px; max-width:700px;"<?php echo crux_edit_attr( 'consultancy', 'meet_the_strategic_team_foun_paragraph_1' ); ?>><?php echo crux_rich( 'consultancy', 'meet_the_strategic_team_foun_paragraph_1' ); ?></p>
        <p style="font-size:14.5px; line-height:1.7; color:#5A5F86; margin:0 0 24px; max-width:700px;"<?php echo crux_edit_attr( 'consultancy', 'meet_the_strategic_team_foun_paragraph_2' ); ?>><?php echo crux_h( 'consultancy', 'meet_the_strategic_team_foun_paragraph_2' ); ?></p>
        <div class="founder-cta-wrap" style="display:flex; align-items:center; gap:16px;">
          <a href="<?php echo crux_url( 'consultancy', 'meet_the_strategic_team_foun_button_1_url' ); ?>" style="background:var(--crux-purple,#8C7AE6); color:var(--crux-ink2,#10142E) !important; font-weight:700; font-size:14px; padding:15px 32px; display:inline-block; --sl:10px; text-decoration:none;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'meet_the_strategic_team_foun_button_1' ); ?>><?php echo crux_h( 'consultancy', 'meet_the_strategic_team_foun_button_1' ); ?></a>
        </div>
      </div>
    </div>
  </section>

  <!-- 9 FAQ -->
  <section style="min-height:640px; padding:60px clamp(24px, 5vw, 64px); background:#F3F1FC; display:grid; grid-template-columns:0.8fr 1.2fr; gap:70px; align-items:start;" data-m="g1 nomin">
    <div style="position:relative; border-radius:24px; overflow:hidden; height:640px;" class="reveal" data-m="tile">
      <img src="<?php echo crux_img_url( 'consultancy', 'faq_photo_1' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'consultancy', 'faq_photo_1' ); ?>>
      <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.96) 0%, rgba(16,20,46,0.25) 65%);"></div>
      <div style="position:absolute; left:0; right:0; bottom:0; padding:32px 32px 32px 32px;">
        <span class="eyebrow" style="color:var(--crux-purple,#8C7AE6) !important;"<?php echo crux_edit_attr( 'consultancy', 'faq_small_heading_1' ); ?>><?php echo crux_h( 'consultancy', 'faq_small_heading_1' ); ?></span>
        <h2 class="bebas" style="font-size:34px; margin:10px 0px 14px 0px; color:#F2F1F8;"<?php echo crux_edit_attr( 'consultancy', 'faq_heading_1' ); ?>><?php echo crux_h( 'consultancy', 'faq_heading_1' ); ?></h2>
        <a href="<?php echo crux_url( 'consultancy', 'faq_button_1_url' ); ?>" style="background:var(--crux-purple,#8C7AE6); color:var(--crux-ink2,#10142E); font-weight:700; font-size:14px; padding:14px 26px 14px 26px; display:inline-block; --sl:10px;" class="bx"<?php echo crux_edit_attr( 'consultancy', 'faq_button_1' ); ?>><?php echo crux_h( 'consultancy', 'faq_button_1' ); ?></a>
      </div>
    </div>
      <div style="display:flex; flex-direction:column; gap:12px; padding-top:6px;" class="reveal">
    <details class="faq-item" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:16px; padding:0 26px; transition:border-color .25s ease;" open>
      <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
        <h3 style="font-size:17px; margin:0; font-weight:700; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'faq_heading_2' ); ?>><?php echo crux_h( 'consultancy', 'faq_heading_2' ); ?></h3>
        <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:var(--crux-purple,#8C7AE6); color:var(--crux-ink2,#10142E); display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
      </summary>
      <p style="font-size:15px; line-height:1.75; color:#3A3F66; margin:0 0 24px; max-width:680px;"<?php echo crux_edit_attr( 'consultancy', 'faq_paragraph_1' ); ?>><?php echo crux_h( 'consultancy', 'faq_paragraph_1' ); ?></p>
    </details>
    <details class="faq-item" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:16px; padding:0 26px; transition:border-color .25s ease;">
      <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
        <h3 style="font-size:17px; margin:0; font-weight:700; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'faq_heading_3' ); ?>><?php echo crux_h( 'consultancy', 'faq_heading_3' ); ?></h3>
        <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:var(--crux-purple,#8C7AE6); color:var(--crux-ink2,#10142E); display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
      </summary>
      <p style="font-size:15px; line-height:1.75; color:#3A3F66; margin:0 0 24px; max-width:680px;"<?php echo crux_edit_attr( 'consultancy', 'faq_paragraph_2' ); ?>><?php echo crux_h( 'consultancy', 'faq_paragraph_2' ); ?></p>
    </details>
    <details class="faq-item" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:16px; padding:0 26px; transition:border-color .25s ease;">
      <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
        <h3 style="font-size:17px; margin:0; font-weight:700; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'faq_heading_4' ); ?>><?php echo crux_h( 'consultancy', 'faq_heading_4' ); ?></h3>
        <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:var(--crux-purple,#8C7AE6); color:var(--crux-ink2,#10142E); display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
      </summary>
      <p style="font-size:15px; line-height:1.75; color:#3A3F66; margin:0 0 24px; max-width:680px;"<?php echo crux_edit_attr( 'consultancy', 'faq_paragraph_3' ); ?>><?php echo crux_h( 'consultancy', 'faq_paragraph_3' ); ?></p>
    </details>
    <details class="faq-item" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:16px; padding:0 26px; transition:border-color .25s ease;">
      <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
        <h3 style="font-size:17px; margin:0; font-weight:700; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'faq_heading_5' ); ?>><?php echo crux_h( 'consultancy', 'faq_heading_5' ); ?></h3>
        <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:var(--crux-purple,#8C7AE6); color:var(--crux-ink2,#10142E); display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
      </summary>
      <p style="font-size:15px; line-height:1.75; color:#3A3F66; margin:0 0 24px; max-width:680px;"<?php echo crux_edit_attr( 'consultancy', 'faq_paragraph_4' ); ?>><?php echo crux_h( 'consultancy', 'faq_paragraph_4' ); ?></p>
    </details>
    <details class="faq-item" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:16px; padding:0 26px; transition:border-color .25s ease;">
      <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
        <h3 style="font-size:17px; margin:0; font-weight:700; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'faq_heading_6' ); ?>><?php echo crux_h( 'consultancy', 'faq_heading_6' ); ?></h3>
        <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:var(--crux-purple,#8C7AE6); color:var(--crux-ink2,#10142E); display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
      </summary>
      <p style="font-size:15px; line-height:1.75; color:#3A3F66; margin:0 0 24px; max-width:680px;"<?php echo crux_edit_attr( 'consultancy', 'faq_paragraph_5' ); ?>><?php echo crux_h( 'consultancy', 'faq_paragraph_5' ); ?></p>
    </details>
    <details class="faq-item" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:16px; padding:0 26px; transition:border-color .25s ease;">
      <summary style="list-style:none; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:20px; padding:22px 0;">
        <h3 style="font-size:17px; margin:0; font-weight:700; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'consultancy', 'faq_heading_7' ); ?>><?php echo crux_h( 'consultancy', 'faq_heading_7' ); ?></h3>
        <span class="fq-plus" style="flex:0 0 32px; height:32px; border-radius:50%; background:var(--crux-purple,#8C7AE6); color:var(--crux-ink2,#10142E); display:flex; align-items:center; justify-content:center; font-size:20px; line-height:1; transition:transform .25s ease;">+</span>
      </summary>
      <p style="font-size:15px; line-height:1.75; color:#3A3F66; margin:0 0 24px; max-width:680px;"<?php echo crux_edit_attr( 'consultancy', 'faq_paragraph_6' ); ?>><?php echo crux_h( 'consultancy', 'faq_paragraph_6' ); ?></p>
    </details>
  </div>
  </section>


  <div style="background:var(--crux-ink2,#10142E);">
  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'light', 'prefooter' => 'idea', 'wing' => 'consultancy' ) ); ?>
  </div>

<div class="msw">
  <div class="crux-sw-pod crux-sw-pod--light" style="pointer-events:auto; display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #C4BAEE 0%, #A99CE0 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(16,20,46,0.22); filter:drop-shadow(0 4px 12px rgba(16,20,46,0.12));">
    <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#EBE7F7; padding:4px; gap:4px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-light" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#4A5073; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">
        <span<?php echo crux_edit_attr( 'consultancy', 'faq_text_1' ); ?>><?php echo crux_h( 'consultancy', 'faq_text_1' ); ?></span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:6px; display:inline-block; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-consultancy" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:var(--crux-violet,#6C58DB); color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(108,88,219,0.45);">
        <span<?php echo crux_edit_attr( 'consultancy', 'faq_text_2' ); ?>><?php echo crux_h( 'consultancy', 'faq_text_2' ); ?></span>
      </a>
    </div>
  </div>
</div></div></div>





<script>
function prevSoundFamiliar() {
  var el = document.getElementById('soundFamiliarScroller');
  if (el) el.scrollBy({ left: -424, behavior: 'smooth' });
}
function nextSoundFamiliar() {
  var el = document.getElementById('soundFamiliarScroller');
  if (el) el.scrollBy({ left: 424, behavior: 'smooth' });
}
function selectPanel(el) {
  document.querySelectorAll('.consultancy-panels-container .cpanel').forEach(function(p) {
    p.classList.remove('active');
    p.style.flex = '1 1 0';
    var lbl = p.querySelector('.cpanel-label'); if (lbl) lbl.style.display = 'block';
    var bdy = p.querySelector('.cpanel-body'); if (bdy) bdy.style.display = 'none';
    var img = p.querySelector('img'); if (img) img.style.filter = 'brightness(0.5)';
    p.style.borderColor = '#E1DEF3';
  });
  el.classList.add('active');
  el.style.flex = '5 1 0';
  var lbl = el.querySelector('.cpanel-label'); if (lbl) lbl.style.display = 'none';
  var bdy = el.querySelector('.cpanel-body'); if (bdy) bdy.style.display = 'block';
  var img = el.querySelector('img'); if (img) img.style.filter = 'brightness(0.85)';
  el.style.borderColor = 'var(--crux-purple,#8C7AE6)';
}
</script>
<?php get_footer(); ?>
