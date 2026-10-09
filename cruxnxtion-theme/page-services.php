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

  <!-- PAGE HEADING -->
  <section style=" padding:44px 20px 50px 20px; display:grid; grid-template-columns:1.2fr 0.8fr; gap:60px; align-items:end;" data-m="g1">
    <div class="reveal"><span class="eyebrow"<?php echo crux_edit_attr( 'services', 'page_heading_small_heading_1' ); ?>><?php echo crux_h( 'services', 'page_heading_small_heading_1' ); ?></span><h1 class="bebas" style="font-size:52px; margin:16px 0px 0px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'services', 'page_heading_heading_1' ); ?>><?php echo crux_rich( 'services', 'page_heading_heading_1' ); ?></h1></div>
    <p style="font-size:16px; line-height:1.75; color:#C5CADF; margin:0px 0px 0px 0px;" class="reveal"<?php echo crux_edit_attr( 'services', 'page_heading_paragraph_1' ); ?>><?php echo crux_h( 'services', 'page_heading_paragraph_1' ); ?></p>
  </section>

  <!-- SERVICE ROWS -->
  <section style="min-height:560px; display:flex; flex-direction:column; justify-content:center; padding:20px 20px 44px 20px;" data-m="nomin"><div style="display:flex; flex-direction:column; gap:28px;" class="reveal">
      <div style="display:grid; grid-template-columns:0.9fr 1fr; background:#111838; border:1.5px solid #1E2B5E; border-radius:22px; overflow:hidden;" data-m="g1">
        <div style="order:1; position:relative; min-height:400px;" class="reveal" data-m="tile">
          <img src="<?php echo crux_img_url( 'services', 'service_rows_photo_1' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:brightness(0.85);"<?php echo crux_edit_attr( 'services', 'service_rows_photo_1' ); ?>>
          <div style="position:absolute; inset:0; background:linear-gradient(160deg, rgba(0,38,113,0.35) 0%, rgba(10,15,38,0.55) 100%);"></div>
          <div class="ticket-stub" style="position:absolute; left:0; top:36px; background:#002671; padding:14px 22px 14px 26px; border-radius:0 10px 10px 0;"><span class="bebas" style="font-size:30px; color:#FFFFFF;">01</span></div>
        </div>
        <div style="order:2; padding:44px 20px 44px 20px;" class="reveal">
          <h3 class="bebas" style="font-size:34px; margin:0px 0px 18px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'services', 'service_rows_heading_1' ); ?>><?php echo crux_h( 'services', 'service_rows_heading_1' ); ?></h3>
          <div style="background:#0A0F26; border:1.5px solid #1E2B5E; border-radius:14px 14px 14px 4px; padding:16px 18px 16px 18px; margin-bottom:12px;"><span style="font-size:10.5px; letter-spacing:1.5px; text-transform:uppercase; color:#5B8DEF; font-weight:700;"<?php echo crux_edit_attr( 'services', 'service_rows_text_1' ); ?>><?php echo crux_h( 'services', 'service_rows_text_1' ); ?></span><p style="font-size:16px; font-weight:600; margin:6px 0px 0px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'services', 'service_rows_paragraph_1' ); ?>><?php echo crux_h( 'services', 'service_rows_paragraph_1' ); ?></p></div>
          <div style="background:#002671; border-radius:14px 14px 4px 14px; padding:16px 18px 16px 18px; margin-bottom:22px;"><span style="font-size:10.5px; letter-spacing:1.5px; text-transform:uppercase; color:#FFFFFF; font-weight:800;"<?php echo crux_edit_attr( 'services', 'service_rows_text_2' ); ?>><?php echo crux_h( 'services', 'service_rows_text_2' ); ?></span><p style="font-size:14.5px; line-height:1.6; font-weight:600; margin:6px 0px 0px 0px; color:#FFFFFF;"<?php echo crux_edit_attr( 'services', 'service_rows_paragraph_2' ); ?>><?php echo crux_h( 'services', 'service_rows_paragraph_2' ); ?></p></div>
          <span class="eyebrow"<?php echo crux_edit_attr( 'services', 'service_rows_small_heading_1' ); ?>><?php echo crux_h( 'services', 'service_rows_small_heading_1' ); ?></span>
          <div style="display:flex; gap:10px; flex-wrap:wrap; margin:12px 0px 18px 0px;" data-m="wrap"><span style="color:#D5D9EA; font-size:12px; font-weight:600; padding:8px 16px 8px 16px; --sl:6px; --bc:#2C3C78;" class="bx"<?php echo crux_edit_attr( 'services', 'service_rows_text_3' ); ?>><?php echo crux_h( 'services', 'service_rows_text_3' ); ?></span><span style="color:#D5D9EA; font-size:12px; font-weight:600; padding:8px 16px 8px 16px; --sl:6px; --bc:#2C3C78;" class="bx"<?php echo crux_edit_attr( 'services', 'service_rows_text_4' ); ?>><?php echo crux_h( 'services', 'service_rows_text_4' ); ?></span><span style="color:#D5D9EA; font-size:12px; font-weight:600; padding:8px 16px 8px 16px; --sl:6px; --bc:#2C3C78;" class="bx"<?php echo crux_edit_attr( 'services', 'service_rows_text_5' ); ?>><?php echo crux_h( 'services', 'service_rows_text_5' ); ?></span></div>
          <p style="font-size:12.5px; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'services', 'service_rows_paragraph_3' ); ?>><?php echo crux_rich( 'services', 'service_rows_paragraph_3' ); ?></p>
        </div>
      </div>
      <div style="display:grid; grid-template-columns:1fr 0.9fr; background:#111838; border:1.5px solid #1E2B5E; border-radius:22px; overflow:hidden;" data-m="g1">
        <div style="order:2; position:relative; min-height:400px;" data-m="tile">
          <img src="<?php echo crux_img_url( 'services', 'service_rows_photo_2' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:brightness(0.85);"<?php echo crux_edit_attr( 'services', 'service_rows_photo_2' ); ?>>
          <div style="position:absolute; inset:0; background:linear-gradient(160deg, rgba(0,38,113,0.35) 0%, rgba(10,15,38,0.55) 100%);"></div>
          <div class="ticket-stub" style="position:absolute; left:0; top:36px; background:#BA0000; padding:14px 22px 14px 26px; border-radius:0 10px 10px 0;"><span class="bebas" style="font-size:30px; color:#FFFFFF;">02</span></div>
        </div>
        <div style="order:1; padding:44px 20px 44px 20px;">
          <h3 class="bebas" style="font-size:34px; margin:0px 0px 18px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'services', 'service_rows_heading_2' ); ?>><?php echo crux_h( 'services', 'service_rows_heading_2' ); ?></h3>
          <div style="background:#0A0F26; border:1.5px solid #1E2B5E; border-radius:14px 14px 14px 4px; padding:16px 18px 16px 18px; margin-bottom:12px;"><span style="font-size:10.5px; letter-spacing:1.5px; text-transform:uppercase; color:#5B8DEF; font-weight:700;"<?php echo crux_edit_attr( 'services', 'service_rows_text_1' ); ?>><?php echo crux_h( 'services', 'service_rows_text_1' ); ?></span><p style="font-size:16px; font-weight:600; margin:6px 0px 0px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'services', 'service_rows_paragraph_4' ); ?>><?php echo crux_h( 'services', 'service_rows_paragraph_4' ); ?></p></div>
          <div style="background:#002671; border-radius:14px 14px 4px 14px; padding:16px 18px 16px 18px; margin-bottom:22px;"><span style="font-size:10.5px; letter-spacing:1.5px; text-transform:uppercase; color:#FFFFFF; font-weight:800;"<?php echo crux_edit_attr( 'services', 'service_rows_text_2' ); ?>><?php echo crux_h( 'services', 'service_rows_text_2' ); ?></span><p style="font-size:14.5px; line-height:1.6; font-weight:600; margin:6px 0px 0px 0px; color:#FFFFFF;"<?php echo crux_edit_attr( 'services', 'service_rows_paragraph_5' ); ?>><?php echo crux_h( 'services', 'service_rows_paragraph_5' ); ?></p></div>
          <span class="eyebrow"<?php echo crux_edit_attr( 'services', 'service_rows_small_heading_1' ); ?>><?php echo crux_h( 'services', 'service_rows_small_heading_1' ); ?></span>
          <div style="display:flex; gap:10px; flex-wrap:wrap; margin:12px 0px 18px 0px;" data-m="wrap"><span style="color:#D5D9EA; font-size:12px; font-weight:600; padding:8px 16px 8px 16px; --sl:6px; --bc:#2C3C78;" class="bx"<?php echo crux_edit_attr( 'services', 'service_rows_text_6' ); ?>><?php echo crux_h( 'services', 'service_rows_text_6' ); ?></span><span style="color:#D5D9EA; font-size:12px; font-weight:600; padding:8px 16px 8px 16px; --sl:6px; --bc:#2C3C78;" class="bx"<?php echo crux_edit_attr( 'services', 'service_rows_text_7' ); ?>><?php echo crux_h( 'services', 'service_rows_text_7' ); ?></span><span style="color:#D5D9EA; font-size:12px; font-weight:600; padding:8px 16px 8px 16px; --sl:6px; --bc:#2C3C78;" class="bx"<?php echo crux_edit_attr( 'services', 'service_rows_text_8' ); ?>><?php echo crux_h( 'services', 'service_rows_text_8' ); ?></span></div>
          <p style="font-size:12.5px; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'services', 'service_rows_paragraph_6' ); ?>><?php echo crux_rich( 'services', 'service_rows_paragraph_6' ); ?></p>
        </div>
      </div>
      <div style="display:grid; grid-template-columns:0.9fr 1fr; background:#111838; border:1.5px solid #1E2B5E; border-radius:22px; overflow:hidden;" data-m="g1">
        <div style="order:1; position:relative; min-height:400px;" data-m="tile">
          <img src="<?php echo crux_img_url( 'services', 'service_rows_photo_3' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:brightness(0.85);"<?php echo crux_edit_attr( 'services', 'service_rows_photo_3' ); ?>>
          <div style="position:absolute; inset:0; background:linear-gradient(160deg, rgba(0,38,113,0.35) 0%, rgba(10,15,38,0.55) 100%);"></div>
          <div class="ticket-stub" style="position:absolute; left:0; top:36px; background:#8C7AE6; padding:14px 22px 14px 26px; border-radius:0 10px 10px 0;"><span class="bebas" style="font-size:30px; color:#0A0F26;">03</span></div>
        </div>
        <div style="order:2; padding:44px 20px 44px 20px;">
          <h3 class="bebas" style="font-size:34px; margin:0px 0px 18px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'services', 'service_rows_heading_3' ); ?>><?php echo crux_h( 'services', 'service_rows_heading_3' ); ?></h3>
          <div style="background:#0A0F26; border:1.5px solid #1E2B5E; border-radius:14px 14px 14px 4px; padding:16px 18px 16px 18px; margin-bottom:12px;"><span style="font-size:10.5px; letter-spacing:1.5px; text-transform:uppercase; color:#5B8DEF; font-weight:700;"<?php echo crux_edit_attr( 'services', 'service_rows_text_1' ); ?>><?php echo crux_h( 'services', 'service_rows_text_1' ); ?></span><p style="font-size:16px; font-weight:600; margin:6px 0px 0px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'services', 'service_rows_paragraph_7' ); ?>><?php echo crux_h( 'services', 'service_rows_paragraph_7' ); ?></p></div>
          <div style="background:#002671; border-radius:14px 14px 4px 14px; padding:16px 18px 16px 18px; margin-bottom:22px;"><span style="font-size:10.5px; letter-spacing:1.5px; text-transform:uppercase; color:#FFFFFF; font-weight:800;"<?php echo crux_edit_attr( 'services', 'service_rows_text_2' ); ?>><?php echo crux_h( 'services', 'service_rows_text_2' ); ?></span><p style="font-size:14.5px; line-height:1.6; font-weight:600; margin:6px 0px 0px 0px; color:#FFFFFF;"<?php echo crux_edit_attr( 'services', 'service_rows_paragraph_8' ); ?>><?php echo crux_h( 'services', 'service_rows_paragraph_8' ); ?></p></div>
          <span class="eyebrow"<?php echo crux_edit_attr( 'services', 'service_rows_small_heading_1' ); ?>><?php echo crux_h( 'services', 'service_rows_small_heading_1' ); ?></span>
          <div style="display:flex; gap:10px; flex-wrap:wrap; margin:12px 0px 18px 0px;" data-m="wrap"><span style="color:#D5D9EA; font-size:12px; font-weight:600; padding:8px 16px 8px 16px; --sl:6px; --bc:#2C3C78;" class="bx"<?php echo crux_edit_attr( 'services', 'service_rows_text_9' ); ?>><?php echo crux_h( 'services', 'service_rows_text_9' ); ?></span><span style="color:#D5D9EA; font-size:12px; font-weight:600; padding:8px 16px 8px 16px; --sl:6px; --bc:#2C3C78;" class="bx"<?php echo crux_edit_attr( 'services', 'service_rows_text_10' ); ?>><?php echo crux_h( 'services', 'service_rows_text_10' ); ?></span><span style="color:#D5D9EA; font-size:12px; font-weight:600; padding:8px 16px 8px 16px; --sl:6px; --bc:#2C3C78;" class="bx"<?php echo crux_edit_attr( 'services', 'service_rows_text_11' ); ?>><?php echo crux_h( 'services', 'service_rows_text_11' ); ?></span></div>
          <p style="font-size:12.5px; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'services', 'service_rows_paragraph_9' ); ?>><?php echo crux_rich( 'services', 'service_rows_paragraph_9' ); ?></p>
        </div>
      </div>
      <div style="display:grid; grid-template-columns:1fr 0.9fr; background:#111838; border:1.5px solid #1E2B5E; border-radius:22px; overflow:hidden;" data-m="g1">
        <div style="order:2; position:relative; min-height:400px;" data-m="tile">
          <img src="<?php echo crux_img_url( 'services', 'service_rows_photo_4' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:brightness(0.85);"<?php echo crux_edit_attr( 'services', 'service_rows_photo_4' ); ?>>
          <div style="position:absolute; inset:0; background:linear-gradient(160deg, rgba(0,38,113,0.35) 0%, rgba(10,15,38,0.55) 100%);"></div>
          <div class="ticket-stub" style="position:absolute; left:0; top:36px; background:#002671; padding:14px 22px 14px 26px; border-radius:0 10px 10px 0;"><span class="bebas" style="font-size:30px; color:#FFFFFF;">04</span></div>
        </div>
        <div style="order:1; padding:44px 20px 44px 20px;">
          <h3 class="bebas" style="font-size:34px; margin:0px 0px 18px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'services', 'service_rows_heading_4' ); ?>><?php echo crux_h( 'services', 'service_rows_heading_4' ); ?></h3>
          <div style="background:#0A0F26; border:1.5px solid #1E2B5E; border-radius:14px 14px 14px 4px; padding:16px 18px 16px 18px; margin-bottom:12px;"><span style="font-size:10.5px; letter-spacing:1.5px; text-transform:uppercase; color:#5B8DEF; font-weight:700;"<?php echo crux_edit_attr( 'services', 'service_rows_text_1' ); ?>><?php echo crux_h( 'services', 'service_rows_text_1' ); ?></span><p style="font-size:16px; font-weight:600; margin:6px 0px 0px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'services', 'service_rows_paragraph_10' ); ?>><?php echo crux_h( 'services', 'service_rows_paragraph_10' ); ?></p></div>
          <div style="background:#002671; border-radius:14px 14px 4px 14px; padding:16px 18px 16px 18px; margin-bottom:22px;"><span style="font-size:10.5px; letter-spacing:1.5px; text-transform:uppercase; color:#FFFFFF; font-weight:800;"<?php echo crux_edit_attr( 'services', 'service_rows_text_2' ); ?>><?php echo crux_h( 'services', 'service_rows_text_2' ); ?></span><p style="font-size:14.5px; line-height:1.6; font-weight:600; margin:6px 0px 0px 0px; color:#FFFFFF;"<?php echo crux_edit_attr( 'services', 'service_rows_paragraph_11' ); ?>><?php echo crux_h( 'services', 'service_rows_paragraph_11' ); ?></p></div>
          <span class="eyebrow"<?php echo crux_edit_attr( 'services', 'service_rows_small_heading_1' ); ?>><?php echo crux_h( 'services', 'service_rows_small_heading_1' ); ?></span>
          <div style="display:flex; gap:10px; flex-wrap:wrap; margin:12px 0px 18px 0px;" data-m="wrap"><span style="color:#D5D9EA; font-size:12px; font-weight:600; padding:8px 16px 8px 16px; --sl:6px; --bc:#2C3C78;" class="bx"<?php echo crux_edit_attr( 'services', 'service_rows_text_12' ); ?>><?php echo crux_h( 'services', 'service_rows_text_12' ); ?></span><span style="color:#D5D9EA; font-size:12px; font-weight:600; padding:8px 16px 8px 16px; --sl:6px; --bc:#2C3C78;" class="bx"<?php echo crux_edit_attr( 'services', 'service_rows_text_13' ); ?>><?php echo crux_h( 'services', 'service_rows_text_13' ); ?></span><span style="color:#D5D9EA; font-size:12px; font-weight:600; padding:8px 16px 8px 16px; --sl:6px; --bc:#2C3C78;" class="bx"<?php echo crux_edit_attr( 'services', 'service_rows_text_14' ); ?>><?php echo crux_h( 'services', 'service_rows_text_14' ); ?></span></div>
          <p style="font-size:12.5px; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'services', 'service_rows_paragraph_12' ); ?>><?php echo crux_rich( 'services', 'service_rows_paragraph_12' ); ?></p>
        </div>
      </div>
      <div style="display:grid; grid-template-columns:0.9fr 1fr; background:#111838; border:1.5px solid #1E2B5E; border-radius:22px; overflow:hidden;" data-m="g1">
        <div style="order:1; position:relative; min-height:400px;" data-m="tile">
          <img src="<?php echo crux_img_url( 'services', 'service_rows_photo_5' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:brightness(0.85);"<?php echo crux_edit_attr( 'services', 'service_rows_photo_5' ); ?>>
          <div style="position:absolute; inset:0; background:linear-gradient(160deg, rgba(0,38,113,0.35) 0%, rgba(10,15,38,0.55) 100%);"></div>
          <div class="ticket-stub" style="position:absolute; left:0; top:36px; background:#BA0000; padding:14px 22px 14px 26px; border-radius:0 10px 10px 0;"><span class="bebas" style="font-size:30px; color:#FFFFFF;">05</span></div>
        </div>
        <div style="order:2; padding:44px 20px 44px 20px;">
          <h3 class="bebas" style="font-size:34px; margin:0px 0px 18px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'services', 'service_rows_heading_5' ); ?>><?php echo crux_h( 'services', 'service_rows_heading_5' ); ?></h3>
          <div style="background:#0A0F26; border:1.5px solid #1E2B5E; border-radius:14px 14px 14px 4px; padding:16px 18px 16px 18px; margin-bottom:12px;"><span style="font-size:10.5px; letter-spacing:1.5px; text-transform:uppercase; color:#5B8DEF; font-weight:700;"<?php echo crux_edit_attr( 'services', 'service_rows_text_1' ); ?>><?php echo crux_h( 'services', 'service_rows_text_1' ); ?></span><p style="font-size:16px; font-weight:600; margin:6px 0px 0px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'services', 'service_rows_paragraph_13' ); ?>><?php echo crux_h( 'services', 'service_rows_paragraph_13' ); ?></p></div>
          <div style="background:#002671; border-radius:14px 14px 4px 14px; padding:16px 18px 16px 18px; margin-bottom:22px;"><span style="font-size:10.5px; letter-spacing:1.5px; text-transform:uppercase; color:#FFFFFF; font-weight:800;"<?php echo crux_edit_attr( 'services', 'service_rows_text_2' ); ?>><?php echo crux_h( 'services', 'service_rows_text_2' ); ?></span><p style="font-size:14.5px; line-height:1.6; font-weight:600; margin:6px 0px 0px 0px; color:#FFFFFF;"<?php echo crux_edit_attr( 'services', 'service_rows_paragraph_14' ); ?>><?php echo crux_h( 'services', 'service_rows_paragraph_14' ); ?></p></div>
          <span class="eyebrow"<?php echo crux_edit_attr( 'services', 'service_rows_small_heading_1' ); ?>><?php echo crux_h( 'services', 'service_rows_small_heading_1' ); ?></span>
          <div style="display:flex; gap:10px; flex-wrap:wrap; margin:12px 0px 18px 0px;" data-m="wrap"><span style="color:#D5D9EA; font-size:12px; font-weight:600; padding:8px 16px 8px 16px; --sl:6px; --bc:#2C3C78;" class="bx"<?php echo crux_edit_attr( 'services', 'service_rows_text_15' ); ?>><?php echo crux_h( 'services', 'service_rows_text_15' ); ?></span><span style="color:#D5D9EA; font-size:12px; font-weight:600; padding:8px 16px 8px 16px; --sl:6px; --bc:#2C3C78;" class="bx"<?php echo crux_edit_attr( 'services', 'service_rows_text_16' ); ?>><?php echo crux_h( 'services', 'service_rows_text_16' ); ?></span><span style="color:#D5D9EA; font-size:12px; font-weight:600; padding:8px 16px 8px 16px; --sl:6px; --bc:#2C3C78;" class="bx"<?php echo crux_edit_attr( 'services', 'service_rows_text_17' ); ?>><?php echo crux_h( 'services', 'service_rows_text_17' ); ?></span></div>
          <p style="font-size:12.5px; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'services', 'service_rows_paragraph_15' ); ?>><?php echo crux_rich( 'services', 'service_rows_paragraph_15' ); ?></p>
        </div>
      </div></div></section>

  <!-- PROCESS — how we run your event -->
  <section style="min-height:560px; display:flex; flex-direction:column; justify-content:center; padding:44px 20px 44px 20px;" data-m="nomin">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:46px;" class="reveal" data-m="stack">
      <div><span class="eyebrow"<?php echo crux_edit_attr( 'services', 'process_small_heading_1' ); ?>><?php echo crux_h( 'services', 'process_small_heading_1' ); ?></span><h2 class="bebas" style="font-size:34px; margin:12px 0px 0px 0px; color:#F4F5FA;"<?php echo crux_edit_attr( 'services', 'process_heading_1' ); ?>><?php echo crux_h( 'services', 'process_heading_1' ); ?></h2></div>
      <p style="max-width:340px; font-size:14px; line-height:1.7; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'services', 'process_paragraph_1' ); ?>><?php echo crux_h( 'services', 'process_paragraph_1' ); ?></p>
    </div>
    <div style="position:relative; display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:26px;" class="reveal" data-m="g1">
      <div class="tilt-ticket reveal" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:14px; overflow:hidden; --r:-1deg; transform:rotate(var(--r));">
        <div style="height:190px; overflow:hidden;"><img src="<?php echo crux_img_url( 'services', 'process_photo_1' ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'services', 'process_photo_1' ); ?>></div>
        <div class="strip-stub" style="background:#8C7AE6; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#0A0F26;"<?php echo crux_edit_attr( 'services', 'process_text_1' ); ?>><?php echo crux_h( 'services', 'process_text_1' ); ?></span><span class="bebas" style="font-size:18px; color:#0A0F26;"<?php echo crux_edit_attr( 'services', 'process_text_2' ); ?>><?php echo crux_h( 'services', 'process_text_2' ); ?></span></div>
        <div style=" padding:24px 22px 26px 22px;"><p style="font-size:14px; line-height:1.7; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'services', 'process_paragraph_2' ); ?>><?php echo crux_h( 'services', 'process_paragraph_2' ); ?></p></div>
      </div>
      <div class="tilt-ticket reveal" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:14px; overflow:hidden; --r:0.8deg; transform:rotate(var(--r));">
        <div style="height:190px; overflow:hidden;"><img src="<?php echo crux_img_url( 'services', 'process_photo_2' ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'services', 'process_photo_2' ); ?>></div>
        <div class="strip-stub" style="background:#002671; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"<?php echo crux_edit_attr( 'services', 'process_text_3' ); ?>><?php echo crux_h( 'services', 'process_text_3' ); ?></span><span class="bebas" style="font-size:18px; color:#FFFFFF;"<?php echo crux_edit_attr( 'services', 'process_text_4' ); ?>><?php echo crux_h( 'services', 'process_text_4' ); ?></span></div>
        <div style=" padding:24px 22px 26px 22px;"><p style="font-size:14px; line-height:1.7; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'services', 'process_paragraph_3' ); ?>><?php echo crux_h( 'services', 'process_paragraph_3' ); ?></p></div>
      </div>
      <div class="tilt-ticket reveal" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:14px; overflow:hidden; --r:-0.8deg; transform:rotate(var(--r));">
        <div style="height:190px; overflow:hidden;"><img src="<?php echo crux_img_url( 'services', 'process_photo_3' ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'services', 'process_photo_3' ); ?>></div>
        <div class="strip-stub" style="background:#BA0000; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#FFFFFF;"<?php echo crux_edit_attr( 'services', 'process_text_5' ); ?>><?php echo crux_h( 'services', 'process_text_5' ); ?></span><span class="bebas" style="font-size:18px; color:#FFFFFF;"<?php echo crux_edit_attr( 'services', 'process_text_6' ); ?>><?php echo crux_h( 'services', 'process_text_6' ); ?></span></div>
        <div style=" padding:24px 22px 26px 22px;"><p style="font-size:14px; line-height:1.7; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'services', 'process_paragraph_4' ); ?>><?php echo crux_h( 'services', 'process_paragraph_4' ); ?></p></div>
      </div>
      <div class="tilt-ticket reveal" style="display:flex; flex-direction:column; background:#111838; border:1.5px solid #1E2B5E; border-radius:14px; overflow:hidden; --r:1deg; transform:rotate(var(--r));">
        <div style="height:190px; overflow:hidden;"><img src="<?php echo crux_img_url( 'services', 'process_photo_4' ); ?>" alt="" style="width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'services', 'process_photo_4' ); ?>></div>
        <div class="strip-stub" style="background:#8C7AE6; padding:12px 18px 12px 18px; display:flex; justify-content:space-between; align-items:center;"><span style="font-size:12px; font-weight:800; color:#0A0F26;"<?php echo crux_edit_attr( 'services', 'process_text_7' ); ?>><?php echo crux_h( 'services', 'process_text_7' ); ?></span><span class="bebas" style="font-size:18px; color:#0A0F26;"<?php echo crux_edit_attr( 'services', 'process_text_8' ); ?>><?php echo crux_h( 'services', 'process_text_8' ); ?></span></div>
        <div style=" padding:24px 22px 26px 22px;"><p style="font-size:14px; line-height:1.7; color:#A3A9C8; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'services', 'process_paragraph_5' ); ?>><?php echo crux_h( 'services', 'process_paragraph_5' ); ?></p></div>
      </div>
    </div>
  </section>

  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'dark', 'prefooter' => 'events', 'wing' => 'events' ) ); ?>

<div class="msw">
  <div class="crux-sw-pod crux-sw-pod--dark" style="pointer-events:auto; display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #2A3F7A 0%, #15224A 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(0,0,0,0.65); filter:drop-shadow(0 4px 12px rgba(0,0,0,0.4));">
    <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#020512; padding:4px; gap:4px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.5);">
        <span<?php echo crux_edit_attr( 'services', 'process_text_9' ); ?>><?php echo crux_h( 'services', 'process_text_9' ); ?></span>
      </a>
      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-dark" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#8E96BB; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">
        <span<?php echo crux_edit_attr( 'services', 'process_text_10' ); ?>><?php echo crux_h( 'services', 'process_text_10' ); ?></span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:6px; display:inline-block; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>
</div></div></div>





<?php get_footer(); ?>
