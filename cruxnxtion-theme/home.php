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
<?php crux_use_page_css( 'dark' ); get_header( null, array( 'body_bg' => 'var(--crux-ink,#0A0F26)', 'root_bg' => 'var(--crux-ink,#0A0F26)', 'skin' => 'dark', 'nav' => 'events', 'wing' => 'events', 'active' => 'blog' ) ); ?>

  <!-- PAGE HEADING -->
  <section style=" padding:44px 20px 20px 20px;">
    <span class="eyebrow"<?php echo crux_edit_attr( 'blog', 'page_heading_small_heading_1' ); ?>><?php echo crux_h( 'blog', 'page_heading_small_heading_1' ); ?></span>
    <h1 class="bebas" style="font-size:44px; margin:14px 0px 14px 0px; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'blog', 'page_heading_heading_1' ); ?>><?php echo crux_h( 'blog', 'page_heading_heading_1' ); ?></h1>
    <p style="font-size:15px; color:#A3A9C8; max-width:540px; margin:0px 0px 0px 0px;" class="reveal"<?php echo crux_edit_attr( 'blog', 'page_heading_paragraph_1' ); ?>><?php echo crux_h( 'blog', 'page_heading_paragraph_1' ); ?></p>
  </section>

  <!-- POST LIST (real posts) -->
  <section style="min-height:560px; display:flex; flex-direction:column; justify-content:center; padding:30px 20px 44px 20px;" data-m="nomin">
    <?php if ( have_posts() ) : ?>
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:26px;" class="reveal" data-m="g1">
      <?php
      $crux_i = 0;
      while ( have_posts() ) :
	      the_post();
	      crux_render_post_card( ( 0 === $crux_i && ! is_paged() ) ? 'feature' : 'tile' );
	      $crux_i++;
      endwhile;
      ?>
    </div>
    <?php crux_pagination(); ?>
    <?php else : ?>
    <p style="font-size:16px; color:#A3A9C8; text-align:center;"<?php echo crux_edit_attr( 'blog', 'post_list_text_2' ); ?>><?php echo crux_h( 'blog', 'post_list_text_2' ); ?></p>
    <?php endif; ?>
  </section>

  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'dark', 'prefooter' => 'events', 'wing' => 'events' ) ); ?>

<div class="msw">
  <div class="crux-sw-pod crux-sw-pod--dark" style="pointer-events:auto; display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #2A3F7A 0%, #15224A 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(0,0,0,0.65); filter:drop-shadow(0 4px 12px rgba(0,0,0,0.4));">
    <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#020512; padding:4px; gap:4px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.5);">
        <span<?php echo crux_edit_attr( 'blog', 'wing_switch_text_1' ); ?>><?php echo crux_h( 'blog', 'wing_switch_text_1' ); ?></span>
      </a>
      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-dark" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#8E96BB; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">
        <span<?php echo crux_edit_attr( 'blog', 'wing_switch_text_2' ); ?>><?php echo crux_h( 'blog', 'wing_switch_text_2' ); ?></span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:6px; display:inline-block; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>
</div></div></div>





<?php get_footer(); ?>
