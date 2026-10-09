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
<?php crux_use_page_css( 'light' ); get_header( null, array( 'body_bg' => '#FFFFFF', 'root_bg' => '#FFFFFF', 'skin' => 'light', 'nav' => 'events', 'wing' => 'events', 'active' => 'about' ) ); ?>

  <!-- 1 HERO -->
  <section style="min-height:800px; display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:center; padding:44px 20px 44px 20px;" data-m="g1 nomin">
    <div class="reveal">
      <span class="eyebrow"<?php echo crux_edit_attr( 'about', 'hero_small_heading_1' ); ?>><?php echo crux_h( 'about', 'hero_small_heading_1' ); ?></span>
      <h1 class="bebas" style="font-size:40px; line-height:0.98; white-space:nowrap; margin:18px 0px 22px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'about', 'hero_heading_1' ); ?>><?php echo crux_rich( 'about', 'hero_heading_1' ); ?></h1>
      <p style="font-size:17px; line-height:1.7; color:#3A3F66; max-width:540px; margin:0px 0px 30px 0px;"<?php echo crux_edit_attr( 'about', 'hero_paragraph_1' ); ?>><?php echo crux_h( 'about', 'hero_paragraph_1' ); ?></p>
      <div style="display:flex; gap:16px;"><a href="<?php echo crux_url( 'about', 'hero_button_1_url' ); ?>" style="background:var(--crux-purple,#8C7AE6); color:var(--crux-ink2,#10142E); font-weight:700; font-size:15px; padding:16px 30px 16px 30px; --sl:10px;" class="bx"<?php echo crux_edit_attr( 'about', 'hero_button_1' ); ?>><?php echo crux_h( 'about', 'hero_button_1' ); ?></a><a href="<?php echo crux_url( 'about', 'hero_button_2_url' ); ?>" style="color:var(--crux-ink2,#10142E); font-weight:700; font-size:15px; padding:14.5px 28px 14.5px 28px; --sl:10px; --bc:var(--crux-ink2,#10142E);" class="bx"<?php echo crux_edit_attr( 'about', 'hero_button_2' ); ?>><?php echo crux_h( 'about', 'hero_button_2' ); ?></a></div>
    </div>
    <div style="position:relative; height:640px;" class="reveal why-us-collage" data-m="tile collage">
      <img src="<?php echo crux_img_url( 'about', 'hero_photo_1' ); ?>" alt="" style="position:absolute; right:0; top:0; width:400px; height:500px; object-fit:cover; border-radius:26px;"<?php echo crux_edit_attr( 'about', 'hero_photo_1' ); ?>>
      <img class="tilt-straighten" src="<?php echo crux_img_url( 'about', 'hero_photo_2' ); ?>" alt="" style="--r:-5deg; transform:rotate(var(--r)); position:absolute; left:0; bottom:0; width:340px; height:260px; object-fit:cover; border-radius:20px; border:4px solid #FFFFFF;"<?php echo crux_edit_attr( 'about', 'hero_photo_2' ); ?>>
      <img class="tilt-straighten" src="<?php echo crux_img_url( 'about', 'hero_photo_3' ); ?>" alt="" style="--r:6deg; transform:rotate(var(--r)); position:absolute; left:120px; top:30px; width:200px; height:250px; object-fit:cover; border-radius:16px; border:4px solid #FFFFFF;"<?php echo crux_edit_attr( 'about', 'hero_photo_3' ); ?>>
      <div class="float" style="--r:6deg; position:absolute; right:-6px; bottom:60px; background:#FF2E3D; color:#FFFFFF; padding:12px 18px 12px 18px; border-radius:10px;"><span class="bebas" style="font-size:20px;"<?php echo crux_edit_attr( 'about', 'hero_text_1' ); ?>><?php echo crux_h( 'about', 'hero_text_1' ); ?></span></div>
    </div>
  </section>

  <!-- 2 STORY -->
  <section style="min-height:760px; padding:44px 20px 44px 20px; background:#F3F1FC; display:grid; grid-template-columns:0.9fr 1.1fr; gap:80px; align-items:center;" data-m="g1 nomin">
    <h2 class="bebas reveal" style="font-size:40px; margin:0px 0px 0px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'about', 'story_heading_1' ); ?>><?php echo crux_rich( 'about', 'story_heading_1' ); ?></h2>
    <div class="reveal">
      <p style="font-size:16px; line-height:1.85; color:#3A3F66; margin:0px 0px 18px 0px;"<?php echo crux_edit_attr( 'about', 'story_paragraph_1' ); ?>><?php echo crux_h( 'about', 'story_paragraph_1' ); ?></p>
      <p style="font-size:16px; line-height:1.85; color:#3A3F66; margin:0px 0px 28px 0px;"<?php echo crux_edit_attr( 'about', 'story_paragraph_2' ); ?>><?php echo crux_h( 'about', 'story_paragraph_2' ); ?></p>
      <div style="display:flex; gap:12px; flex-wrap:wrap;" data-m="wrap"><span style="background:#FFFFFF; color:#3A3F66; font-size:12.5px; font-weight:600; padding:10px 18px 10px 18px; --sl:6px; --bc:#D2CEEA;" class="bx"<?php echo crux_edit_attr( 'about', 'story_text_1' ); ?>><?php echo crux_h( 'about', 'story_text_1' ); ?></span><span style="background:#FFFFFF; color:#3A3F66; font-size:12.5px; font-weight:600; padding:10px 18px 10px 18px; --sl:6px; --bc:#D2CEEA;" class="bx"<?php echo crux_edit_attr( 'about', 'story_text_2' ); ?>><?php echo crux_h( 'about', 'story_text_2' ); ?></span><span style="background:#FFFFFF; color:#3A3F66; font-size:12.5px; font-weight:600; padding:10px 18px 10px 18px; --sl:6px; --bc:#D2CEEA;" class="bx"<?php echo crux_edit_attr( 'about', 'story_text_3' ); ?>><?php echo crux_h( 'about', 'story_text_3' ); ?></span><span style="background:#FFFFFF; color:#3A3F66; font-size:12.5px; font-weight:600; padding:10px 18px 10px 18px; --sl:6px; --bc:#D2CEEA;" class="bx"<?php echo crux_edit_attr( 'about', 'story_text_4' ); ?>><?php echo crux_h( 'about', 'story_text_4' ); ?></span></div>
    </div>
  </section>

  <!-- 3 WHAT WE DO — tabs -->
  <section style="min-height:820px; padding:44px 20px 44px 20px;" data-m="nomin">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:40px;" class="reveal" data-m="stack">
      <div><span class="eyebrow"<?php echo crux_edit_attr( 'about', 'what_we_do_small_heading_1' ); ?>><?php echo crux_h( 'about', 'what_we_do_small_heading_1' ); ?></span><h2 class="bebas" style="font-size:40px; margin:12px 0px 0px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'about', 'what_we_do_heading_1' ); ?>><?php echo crux_h( 'about', 'what_we_do_heading_1' ); ?></h2></div>
      <div style="display:inline-flex; gap:4px; gap:6px;"><button onclick="{{pickEvents}}" style="{{eventsTabStyle}:{{eventsTabStyle}}; --sl:8px; --bc:#88888855;" class="bx"<?php echo crux_edit_attr( 'about', 'what_we_do_button_1' ); ?>><?php echo crux_h( 'about', 'what_we_do_button_1' ); ?></button><button onclick="{{pickConsult}}" style="{{consultTabStyle}:{{consultTabStyle}}; --sl:8px; --bc:#88888855;" class="bx"<?php echo crux_edit_attr( 'about', 'what_we_do_button_2' ); ?>><?php echo crux_h( 'about', 'what_we_do_button_2' ); ?></button></div>
    </div>
    <sc-if value="{{isEvents}}" hint-placeholder-val="{{true}}"><div style="display:grid; grid-template-columns:repeat(6, minmax(0, 1fr)); grid-template-rows:repeat(2, 320px); gap:16px;" data-m="g1">
      <a href="#" class="bento-tile reveal" style="grid-column:span 3; position:relative; overflow:hidden; border-radius:22px; display:block;" data-m="span tile">
        <img src="<?php echo crux_img_url( 'about', 'what_we_do_photo_1' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'about', 'what_we_do_photo_1' ); ?>>
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.95) 0%, rgba(16,20,46,0.35) 65%, rgba(16,20,46,0.15) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:26px 26px 26px 26px;"><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:#F2F1F8;"<?php echo crux_edit_attr( 'about', 'what_we_do_heading_2' ); ?>><?php echo crux_h( 'about', 'what_we_do_heading_2' ); ?></h3><p style="font-size:13px; line-height:1.6; color:#C7C7DA; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'about', 'what_we_do_paragraph_1' ); ?>><?php echo crux_h( 'about', 'what_we_do_paragraph_1' ); ?></p></div>
      </a>
      <a href="#" class="bento-tile reveal" style="grid-column:span 3; position:relative; overflow:hidden; border-radius:22px; display:block;" data-m="span tile">
        <img src="<?php echo crux_img_url( 'about', 'what_we_do_photo_2' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'about', 'what_we_do_photo_2' ); ?>>
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.95) 0%, rgba(16,20,46,0.35) 65%, rgba(16,20,46,0.15) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:26px 26px 26px 26px;"><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:#F2F1F8;"<?php echo crux_edit_attr( 'about', 'what_we_do_heading_3' ); ?>><?php echo crux_h( 'about', 'what_we_do_heading_3' ); ?></h3><p style="font-size:13px; line-height:1.6; color:#C7C7DA; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'about', 'what_we_do_paragraph_2' ); ?>><?php echo crux_h( 'about', 'what_we_do_paragraph_2' ); ?></p></div>
      </a>
      <a href="#" class="bento-tile reveal" style="grid-column:span 2; position:relative; overflow:hidden; border-radius:22px; display:block;" data-m="span tile">
        <img src="<?php echo crux_img_url( 'about', 'what_we_do_photo_3' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'about', 'what_we_do_photo_3' ); ?>>
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.95) 0%, rgba(16,20,46,0.35) 65%, rgba(16,20,46,0.15) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:26px 26px 26px 26px;"><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:#F2F1F8;"<?php echo crux_edit_attr( 'about', 'what_we_do_heading_4' ); ?>><?php echo crux_h( 'about', 'what_we_do_heading_4' ); ?></h3><p style="font-size:13px; line-height:1.6; color:#C7C7DA; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'about', 'what_we_do_paragraph_3' ); ?>><?php echo crux_h( 'about', 'what_we_do_paragraph_3' ); ?></p></div>
      </a>
      <a href="#" class="bento-tile reveal" style="grid-column:span 2; position:relative; overflow:hidden; border-radius:22px; display:block;" data-m="span tile">
        <img src="<?php echo crux_img_url( 'about', 'what_we_do_photo_4' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'about', 'what_we_do_photo_4' ); ?>>
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.95) 0%, rgba(16,20,46,0.35) 65%, rgba(16,20,46,0.15) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:26px 26px 26px 26px;"><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:#F2F1F8;"<?php echo crux_edit_attr( 'about', 'what_we_do_heading_5' ); ?>><?php echo crux_h( 'about', 'what_we_do_heading_5' ); ?></h3><p style="font-size:13px; line-height:1.6; color:#C7C7DA; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'about', 'what_we_do_paragraph_4' ); ?>><?php echo crux_h( 'about', 'what_we_do_paragraph_4' ); ?></p></div>
      </a>
      <a href="#" class="bento-tile reveal" style="grid-column:span 2; position:relative; overflow:hidden; border-radius:22px; display:block;" data-m="span tile">
        <img src="<?php echo crux_img_url( 'about', 'what_we_do_photo_5' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'about', 'what_we_do_photo_5' ); ?>>
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.95) 0%, rgba(16,20,46,0.35) 65%, rgba(16,20,46,0.15) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:26px 26px 26px 26px;"><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:#F2F1F8;"<?php echo crux_edit_attr( 'about', 'what_we_do_heading_6' ); ?>><?php echo crux_h( 'about', 'what_we_do_heading_6' ); ?></h3><p style="font-size:13px; line-height:1.6; color:#C7C7DA; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'about', 'what_we_do_paragraph_5' ); ?>><?php echo crux_h( 'about', 'what_we_do_paragraph_5' ); ?></p></div>
      </a></div></sc-if>
    <sc-if value="{{isConsult}}" hint-placeholder-val="{{false}}"><div style="display:grid; grid-template-columns:repeat(6, minmax(0, 1fr)); grid-template-rows:repeat(2, 320px); gap:16px;" data-m="g1">
      <a href="#" class="bento-tile" style="grid-column:span 3; position:relative; overflow:hidden; border-radius:22px; display:block;" data-m="span tile">
        <img src="<?php echo crux_img_url( 'about', 'what_we_do_photo_6' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'about', 'what_we_do_photo_6' ); ?>>
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.95) 0%, rgba(16,20,46,0.35) 65%, rgba(16,20,46,0.15) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:26px 26px 26px 26px;"><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:#F2F1F8;"<?php echo crux_edit_attr( 'about', 'what_we_do_heading_7' ); ?>><?php echo crux_h( 'about', 'what_we_do_heading_7' ); ?></h3><p style="font-size:13px; line-height:1.6; color:#C7C7DA; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'about', 'what_we_do_paragraph_6' ); ?>><?php echo crux_h( 'about', 'what_we_do_paragraph_6' ); ?></p></div>
      </a>
      <a href="#" class="bento-tile" style="grid-column:span 3; position:relative; overflow:hidden; border-radius:22px; display:block;" data-m="span tile">
        <img src="<?php echo crux_img_url( 'about', 'what_we_do_photo_7' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'about', 'what_we_do_photo_7' ); ?>>
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.95) 0%, rgba(16,20,46,0.35) 65%, rgba(16,20,46,0.15) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:26px 26px 26px 26px;"><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:#F2F1F8;"<?php echo crux_edit_attr( 'about', 'what_we_do_heading_8' ); ?>><?php echo crux_h( 'about', 'what_we_do_heading_8' ); ?></h3><p style="font-size:13px; line-height:1.6; color:#C7C7DA; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'about', 'what_we_do_paragraph_7' ); ?>><?php echo crux_h( 'about', 'what_we_do_paragraph_7' ); ?></p></div>
      </a>
      <a href="#" class="bento-tile" style="grid-column:span 2; position:relative; overflow:hidden; border-radius:22px; display:block;" data-m="span tile">
        <img src="<?php echo crux_img_url( 'about', 'what_we_do_photo_8' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'about', 'what_we_do_photo_8' ); ?>>
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.95) 0%, rgba(16,20,46,0.35) 65%, rgba(16,20,46,0.15) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:26px 26px 26px 26px;"><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:#F2F1F8;"<?php echo crux_edit_attr( 'about', 'what_we_do_heading_9' ); ?>><?php echo crux_h( 'about', 'what_we_do_heading_9' ); ?></h3><p style="font-size:13px; line-height:1.6; color:#C7C7DA; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'about', 'what_we_do_paragraph_8' ); ?>><?php echo crux_h( 'about', 'what_we_do_paragraph_8' ); ?></p></div>
      </a>
      <a href="#" class="bento-tile" style="grid-column:span 2; position:relative; overflow:hidden; border-radius:22px; display:block;" data-m="span tile">
        <img src="<?php echo crux_img_url( 'about', 'what_we_do_photo_9' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'about', 'what_we_do_photo_9' ); ?>>
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.95) 0%, rgba(16,20,46,0.35) 65%, rgba(16,20,46,0.15) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:26px 26px 26px 26px;"><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:#F2F1F8;"<?php echo crux_edit_attr( 'about', 'what_we_do_heading_10' ); ?>><?php echo crux_h( 'about', 'what_we_do_heading_10' ); ?></h3><p style="font-size:13px; line-height:1.6; color:#C7C7DA; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'about', 'what_we_do_paragraph_9' ); ?>><?php echo crux_h( 'about', 'what_we_do_paragraph_9' ); ?></p></div>
      </a>
      <a href="#" class="bento-tile" style="grid-column:span 2; position:relative; overflow:hidden; border-radius:22px; display:block;" data-m="span tile">
        <img src="<?php echo crux_img_url( 'about', 'what_we_do_photo_10' ); ?>" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;"<?php echo crux_edit_attr( 'about', 'what_we_do_photo_10' ); ?>>
        <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(16,20,46,0.95) 0%, rgba(16,20,46,0.35) 65%, rgba(16,20,46,0.15) 100%);"></div>
        <div style="position:absolute; left:0; right:0; bottom:0; padding:26px 26px 26px 26px;"><h3 class="bebas" style="font-size:30px; margin:0px 0px 6px 0px; color:#F2F1F8;"<?php echo crux_edit_attr( 'about', 'what_we_do_heading_11' ); ?>><?php echo crux_h( 'about', 'what_we_do_heading_11' ); ?></h3><p style="font-size:13px; line-height:1.6; color:#C7C7DA; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'about', 'what_we_do_paragraph_10' ); ?>><?php echo crux_h( 'about', 'what_we_do_paragraph_10' ); ?></p></div>
      </a></div></sc-if>
  </section>

  <!-- 4 DIFFERENCE -->
  <section style="min-height:760px; padding:44px 20px 44px 20px; background:#F3F1FC;" data-m="nomin">
    <div style="text-align:center; margin-bottom:50px;" class="reveal"><span class="eyebrow"<?php echo crux_edit_attr( 'about', 'difference_small_heading_1' ); ?>><?php echo crux_h( 'about', 'difference_small_heading_1' ); ?></span><h2 class="bebas" style="font-size:40px; margin:12px 0px 0px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'about', 'difference_heading_1' ); ?>><?php echo crux_h( 'about', 'difference_heading_1' ); ?></h2></div>
    <div style="display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:18px;" class="reveal" data-m="g1">
      <div class="bento-tile reveal" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:22px; padding:32px 28px 32px 28px; min-height:300px; display:flex; flex-direction:column; justify-content:space-between;"><span class="bebas" style="font-size:40px; color:var(--crux-violet,#6C58DB); line-height:0.9;">01</span><div><h3 class="bebas" style="font-size:30px; margin:0px 0px 10px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'about', 'difference_heading_2' ); ?>><?php echo crux_h( 'about', 'difference_heading_2' ); ?></h3><p style="font-size:14px; line-height:1.7; color:#3A3F66; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'about', 'difference_paragraph_1' ); ?>><?php echo crux_h( 'about', 'difference_paragraph_1' ); ?></p></div></div>
      <div class="bento-tile reveal" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:22px; padding:32px 28px 32px 28px; min-height:300px; display:flex; flex-direction:column; justify-content:space-between;"><span class="bebas" style="font-size:40px; color:var(--crux-violet,#6C58DB); line-height:0.9;">02</span><div><h3 class="bebas" style="font-size:30px; margin:0px 0px 10px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'about', 'difference_heading_3' ); ?>><?php echo crux_h( 'about', 'difference_heading_3' ); ?></h3><p style="font-size:14px; line-height:1.7; color:#3A3F66; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'about', 'difference_paragraph_2' ); ?>><?php echo crux_h( 'about', 'difference_paragraph_2' ); ?></p></div></div>
      <div class="bento-tile reveal" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:22px; padding:32px 28px 32px 28px; min-height:300px; display:flex; flex-direction:column; justify-content:space-between;"><span class="bebas" style="font-size:40px; color:var(--crux-violet,#6C58DB); line-height:0.9;">03</span><div><h3 class="bebas" style="font-size:30px; margin:0px 0px 10px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'about', 'difference_heading_4' ); ?>><?php echo crux_h( 'about', 'difference_heading_4' ); ?></h3><p style="font-size:14px; line-height:1.7; color:#3A3F66; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'about', 'difference_paragraph_3' ); ?>><?php echo crux_h( 'about', 'difference_paragraph_3' ); ?></p></div></div>
      <div class="bento-tile reveal" style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:22px; padding:32px 28px 32px 28px; min-height:300px; display:flex; flex-direction:column; justify-content:space-between;"><span class="bebas" style="font-size:40px; color:var(--crux-violet,#6C58DB); line-height:0.9;">04</span><div><h3 class="bebas" style="font-size:30px; margin:0px 0px 10px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'about', 'difference_heading_5' ); ?>><?php echo crux_h( 'about', 'difference_heading_5' ); ?></h3><p style="font-size:14px; line-height:1.7; color:#3A3F66; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'about', 'difference_paragraph_4' ); ?>><?php echo crux_h( 'about', 'difference_paragraph_4' ); ?></p></div></div>
    </div>
  </section>

  <!-- 5 FOUNDER — original design -->
  <section id="founder" style="padding:64px 20px; background:var(--crux-surface,#111838); display:grid; grid-template-columns:0.8fr 1.2fr; gap:60px; align-items:center;" data-m="g1">
    <div class="tilt-straighten reveal" style="--r:-2deg; transform:rotate(var(--r)); border-radius:22px; overflow:hidden; border:2px solid var(--crux-blue,#5B8DEF); height:470px;">
      <img src="<?php echo crux_img_url( 'about', 'founder_photo_1' ); ?>" alt="Olabamidele 'Bambad' Badmos, founder of Crux Nxtion" style="width:100%; height:100%; object-fit:cover; object-position:58% 12%;"<?php echo crux_edit_attr( 'about', 'founder_photo_1' ); ?>>
    </div>
    <div class="reveal">
      <span class="eyebrow" style="color:var(--crux-blue,#5B8DEF);"<?php echo crux_edit_attr( 'about', 'founder_small_heading_1' ); ?>><?php echo crux_h( 'about', 'founder_small_heading_1' ); ?></span>
      <h2 class="bebas" style="font-size:62px; margin:14px 0 20px; color:var(--crux-text,#F4F5FA); line-height:0.95;"<?php echo crux_edit_attr( 'about', 'founder_heading_1' ); ?>><?php echo crux_h( 'about', 'founder_heading_1' ); ?></h2>
      <p style="font-size:16px; line-height:1.8; color:#C5CADF; max-width:620px; margin:0 0 14px;"<?php echo crux_edit_attr( 'about', 'founder_paragraph_1' ); ?>><?php echo crux_h( 'about', 'founder_paragraph_1' ); ?></p>
      <p style="font-size:16px; line-height:1.8; color:#C5CADF; max-width:620px; margin:0 0 26px;"<?php echo crux_edit_attr( 'about', 'founder_paragraph_2' ); ?>><?php echo crux_rich( 'about', 'founder_paragraph_2' ); ?></p>
      <div style="display:flex; gap:12px; flex-wrap:wrap; margin-bottom:28px;" data-m="wrap">
        <span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12.5px; padding:9px 18px;"<?php echo crux_edit_attr( 'about', 'founder_text_1' ); ?>><?php echo crux_h( 'about', 'founder_text_1' ); ?></span>
        <span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12.5px; padding:9px 18px;"<?php echo crux_edit_attr( 'about', 'founder_text_2' ); ?>><?php echo crux_h( 'about', 'founder_text_2' ); ?></span>
        <span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12.5px; padding:9px 18px;"<?php echo crux_edit_attr( 'about', 'founder_text_3' ); ?>><?php echo crux_h( 'about', 'founder_text_3' ); ?></span>
        <span style="border:1.5px solid #2C3C78; color:#D5D9EA; font-weight:600; font-size:12.5px; padding:9px 18px;"<?php echo crux_edit_attr( 'about', 'founder_text_4' ); ?>><?php echo crux_h( 'about', 'founder_text_4' ); ?></span>
      </div>
      <a href="<?php echo crux_url( 'about', 'founder_button_1_url' ); ?>" style="background:var(--crux-red,#BA0000); color:#FFFFFF; font-weight:700; font-size:14px; padding:15px 28px; --sl:10px;" class="bx"<?php echo crux_edit_attr( 'about', 'founder_button_1' ); ?>><?php echo crux_h( 'about', 'founder_button_1' ); ?></a>
    </div>
  </section>

  <!-- 6 JOURNEY -->
  <section style="min-height:760px; padding:44px 20px 44px 20px; background:#F3F1FC;" data-m="nomin">
    <div style="margin-bottom:60px;" class="reveal"><span class="eyebrow"<?php echo crux_edit_attr( 'about', 'journey_small_heading_1' ); ?>><?php echo crux_h( 'about', 'journey_small_heading_1' ); ?></span><h2 class="bebas" style="font-size:40px; margin:12px 0px 0px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'about', 'journey_heading_1' ); ?>><?php echo crux_h( 'about', 'journey_heading_1' ); ?></h2></div>
    <div style="position:relative; display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:22px;" class="reveal" data-m="g1">
      <div class="timeline-connecting-line" style="position:absolute; left:28px; right:28px; top:28px; border-top:2px dashed #D2CEEA;"></div>

      <div style="position:relative;" class="reveal"><div style="width:56px; height:56px; border-radius:50%; background:#F3F1FC; border:2px dashed var(--crux-violet,#6C58DB); display:flex; align-items:center; justify-content:center; margin-bottom:22px; position:relative;"><span class="bebas" style="font-size:22px; color:var(--crux-violet,#6C58DB);">1</span></div><div style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:18px; padding:24px 24px 24px 24px;"><h3 class="bebas" style="font-size:28px; margin:0px 0px 8px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'about', 'journey_heading_2' ); ?>><?php echo crux_h( 'about', 'journey_heading_2' ); ?></h3><p style="font-size:13.5px; line-height:1.65; color:#3A3F66; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'about', 'journey_paragraph_1' ); ?>><?php echo crux_h( 'about', 'journey_paragraph_1' ); ?></p></div></div>
      <div style="position:relative;" class="reveal"><div style="width:56px; height:56px; border-radius:50%; background:#F3F1FC; border:2px dashed var(--crux-violet,#6C58DB); display:flex; align-items:center; justify-content:center; margin-bottom:22px; position:relative;"><span class="bebas" style="font-size:22px; color:var(--crux-violet,#6C58DB);">2</span></div><div style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:18px; padding:24px 24px 24px 24px;"><h3 class="bebas" style="font-size:28px; margin:0px 0px 8px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'about', 'journey_heading_3' ); ?>><?php echo crux_h( 'about', 'journey_heading_3' ); ?></h3><p style="font-size:13.5px; line-height:1.65; color:#3A3F66; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'about', 'journey_paragraph_2' ); ?>><?php echo crux_h( 'about', 'journey_paragraph_2' ); ?></p></div></div>
      <div style="position:relative;" class="reveal"><div style="width:56px; height:56px; border-radius:50%; background:#F3F1FC; border:2px dashed var(--crux-violet,#6C58DB); display:flex; align-items:center; justify-content:center; margin-bottom:22px; position:relative;"><span class="bebas" style="font-size:22px; color:var(--crux-violet,#6C58DB);">3</span></div><div style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:18px; padding:24px 24px 24px 24px;"><h3 class="bebas" style="font-size:28px; margin:0px 0px 8px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'about', 'journey_heading_4' ); ?>><?php echo crux_h( 'about', 'journey_heading_4' ); ?></h3><p style="font-size:13.5px; line-height:1.65; color:#3A3F66; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'about', 'journey_paragraph_3' ); ?>><?php echo crux_h( 'about', 'journey_paragraph_3' ); ?></p></div></div>
      <div style="position:relative;" class="reveal"><div style="width:56px; height:56px; border-radius:50%; background:#F3F1FC; border:2px dashed var(--crux-violet,#6C58DB); display:flex; align-items:center; justify-content:center; margin-bottom:22px; position:relative;"><span class="bebas" style="font-size:22px; color:var(--crux-violet,#6C58DB);">4</span></div><div style="background:#FFFFFF; border:1.5px solid #E1DEF3; border-radius:18px; padding:24px 24px 24px 24px;"><h3 class="bebas" style="font-size:28px; margin:0px 0px 8px 0px; color:var(--crux-ink2,#10142E);"<?php echo crux_edit_attr( 'about', 'journey_heading_5' ); ?>><?php echo crux_h( 'about', 'journey_heading_5' ); ?></h3><p style="font-size:13.5px; line-height:1.65; color:#3A3F66; margin:0px 0px 0px 0px;"<?php echo crux_edit_attr( 'about', 'journey_paragraph_4' ); ?>><?php echo crux_h( 'about', 'journey_paragraph_4' ); ?></p></div></div>
    </div>
  </section>


  <div style="background:var(--crux-ink2,#10142E);">
  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'light', 'prefooter' => 'events-light', 'wing' => 'events' ) ); ?>
  </div>

<div class="msw">
  <div class="crux-sw-pod crux-sw-pod--light" style="pointer-events:auto; display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #C4BAEE 0%, #A99CE0 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(16,20,46,0.22); filter:drop-shadow(0 4px 12px rgba(16,20,46,0.12));">
    <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#EBE7F7; padding:4px; gap:4px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.4);">
        <span<?php echo crux_edit_attr( 'about', 'journey_text_1' ); ?>><?php echo crux_h( 'about', 'journey_text_1' ); ?></span>
      </a>
      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-light" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#4A5073; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">
        <span<?php echo crux_edit_attr( 'about', 'journey_text_2' ); ?>><?php echo crux_h( 'about', 'journey_text_2' ); ?></span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:6px; display:inline-block; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>
</div></div></div>





<?php get_footer(); ?>
