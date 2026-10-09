<?php
/**
 * Archives: category, tag, author, date and any other list of posts. category.php, tag.php, author.php and date.php use this
 * template too, so all of them look the same.
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );
$crux_title  = wp_strip_all_tags( get_the_archive_title() );
$crux_desc   = get_the_archive_description();
$crux_author = is_author() ? (int) get_queried_object_id() : 0;
crux_use_page_css( 'dark' );
get_header( null, array( 'body_bg' => 'var(--crux-ink,#0A0F26)', 'root_bg' => 'var(--crux-ink,#0A0F26)', 'skin' => 'dark', 'nav' => 'events', 'wing' => 'events', 'active' => 'blog' ) );
?>

  <!-- ARCHIVE HEADING -->
  <section style=" padding:44px 20px 20px 20px;">
    <span class="eyebrow"<?php echo crux_edit_attr( 'archive', 'heading_small_heading_1' ); ?>><?php echo crux_h( 'archive', 'heading_small_heading_1' ); ?></span>
    <?php if ( $crux_author ) : ?>
    <div class="crux-author" style="margin:14px 0 0; max-width:720px;">
      <?php echo get_avatar( $crux_author, 72 ); ?>
      <div><h1 class="bebas" style="font-size:40px; margin:0 0 8px; color:var(--crux-text,#F4F5FA);"><?php echo esc_html( $crux_title ); ?></h1><?php if ( get_the_author_meta( 'description', $crux_author ) ) : ?><p><?php echo esc_html( get_the_author_meta( 'description', $crux_author ) ); ?></p><?php endif; ?></div>
    </div>
    <?php else : ?>
    <h1 class="bebas" style="font-size:44px; margin:14px 0px 14px 0px; color:var(--crux-text,#F4F5FA);"><?php echo esc_html( $crux_title ); ?></h1>
    <?php if ( $crux_desc ) : ?><div style="font-size:15px; color:#A3A9C8; max-width:620px;"><?php echo wp_kses_post( $crux_desc ); ?></div><?php endif; ?>
    <?php endif; ?>
  </section>

  <!-- POSTS -->
  <section style="min-height:420px; display:flex; flex-direction:column; justify-content:center; padding:30px 20px 44px 20px;" data-m="nomin">
    <?php if ( have_posts() ) : ?>
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:26px;" class="reveal" data-m="g1">
      <?php
      while ( have_posts() ) :
	      the_post();
	      crux_render_post_card( 'tile' );
      endwhile;
      ?>
    </div>
    <?php crux_pagination(); ?>
    <?php else : ?>
    <p style="font-size:16px; color:#A3A9C8; text-align:center;"<?php echo crux_edit_attr( 'archive', 'heading_text_1' ); ?>><?php echo crux_h( 'archive', 'heading_text_1' ); ?></p>
    <?php endif; ?>
  </section>

  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'dark', 'prefooter' => 'events', 'wing' => 'events' ) ); ?>
</div>

<?php get_footer(); ?>
