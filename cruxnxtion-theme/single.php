<?php
/**
 * Template Name: Single Blog Template
 *
 * The real WordPress post: its title, category, date, author, featured image and full content, then tags, share
 * buttons, author box, previous and next article, comments and the latest other articles.
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

the_post();
$crux_post_id  = get_the_ID();
$crux_category = crux_post_category_name( $crux_post_id );
$crux_hero     = get_the_post_thumbnail_url( $crux_post_id, 'full' );
$crux_author   = (int) get_post_field( 'post_author', $crux_post_id );
$crux_bio      = get_the_author_meta( 'description', $crux_author );
$crux_more     = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 5,
		'post__not_in'        => array( $crux_post_id ),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);
crux_use_page_css( 'dark' );
get_header( null, array( 'body_bg' => 'var(--crux-ink,#0A0F26)', 'root_bg' => 'var(--crux-ink,#0A0F26)', 'skin' => 'dark', 'nav' => 'events', 'wing' => 'events', 'active' => 'blog' ) );
?>

  <!-- BREADCRUMB -->
  <div style=" padding:20px 20px 0px 20px;"><span style="font-size:13px; color:#7A82A8;"><a href="<?php echo crux_url( 'single_post', 'breadcrumb_link_1_url' ); ?>" style="color:#7A82A8;"<?php echo crux_edit_attr( 'single_post', 'breadcrumb_link_1' ); ?>><?php echo crux_h( 'single_post', 'breadcrumb_link_1' ); ?></a> / <a href="<?php echo crux_url( 'single_post', 'breadcrumb_link_2_url' ); ?>" style="color:#7A82A8;"<?php echo crux_edit_attr( 'single_post', 'breadcrumb_link_2' ); ?>><?php echo crux_h( 'single_post', 'breadcrumb_link_2' ); ?></a> / <span style="color:var(--crux-text,#F4F5FA); font-weight:600;"><?php echo esc_html( get_the_title() ); ?></span></span></div>

  <!-- ARTICLE HEADER -->
  <section style=" padding:40px 20px 30px 20px; max-width:1000px;">
    <span class="eyebrow"><?php echo esc_html( strtoupper( $crux_category ) ); ?></span>
    <h1 class="bebas" style="font-size:40px; margin:14px 0px 18px 0px; color:var(--crux-text,#F4F5FA); line-height:0.95;"><?php echo esc_html( get_the_title() ); ?></h1>
    <p style="font-size:13px; color:#A3A9C8; margin:0px;" class="reveal"><?php echo esc_html( get_the_author_meta( 'display_name', $crux_author ) ); ?> &nbsp;·&nbsp; <?php echo esc_html( get_the_date() ); ?> &nbsp;·&nbsp; <?php echo esc_html( crux_read_minutes( get_the_content() ) ); ?> min read</p>
  </section>
  <?php if ( $crux_hero ) : ?>
  <section style=" margin:0px 20px 0px 20px; height:420px; overflow:hidden; border-radius:16px; border:1.5px solid var(--crux-line,#1E2B5E);"><img src="<?php echo esc_url( $crux_hero ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" style="width:100%; height:100%; object-fit:cover;"></section>
  <?php endif; ?>

  <!-- ARTICLE -->
  <section style=" padding:56px 20px 44px 20px; display:grid; grid-template-columns:1.6fr 0.8fr; gap:70px; align-items:start;" data-m="g1">
    <div class="reveal">
      <article class="crux-prose"><?php the_content(); ?></article>
      <?php wp_link_pages(); ?>
      <?php if ( has_tag() ) : ?>
      <div class="crux-tags"><?php foreach ( get_the_tags() as $crux_tag ) : ?><a href="<?php echo esc_url( get_tag_link( $crux_tag ) ); ?>">#<?php echo esc_html( $crux_tag->name ); ?></a><?php endforeach; ?></div>
      <?php endif; ?>
      <?php crux_share_bar( get_permalink(), get_the_title() ); ?>
      <?php if ( $crux_bio ) : ?>
      <div class="crux-author">
        <?php echo get_avatar( $crux_author, 64 ); ?>
        <div><h3><?php echo esc_html( get_the_author_meta( 'display_name', $crux_author ) ); ?></h3><p><?php echo esc_html( $crux_bio ); ?></p></div>
      </div>
      <?php endif; ?>
      <?php
      $crux_prev = get_previous_post();
      $crux_next = get_next_post();
      if ( $crux_prev || $crux_next ) :
      ?>
      <nav class="crux-postnav" aria-label="Articles">
        <?php if ( $crux_prev ) : ?><a href="<?php echo esc_url( get_permalink( $crux_prev ) ); ?>" class="prev"><small>&larr; <?php esc_html_e( 'Previous', 'cruxnxtion' ); ?></small><?php echo esc_html( get_the_title( $crux_prev ) ); ?></a><?php endif; ?>
        <?php if ( $crux_next ) : ?><a href="<?php echo esc_url( get_permalink( $crux_next ) ); ?>" class="next"><small><?php esc_html_e( 'Next', 'cruxnxtion' ); ?> &rarr;</small><?php echo esc_html( get_the_title( $crux_next ) ); ?></a><?php endif; ?>
      </nav>
      <?php endif; ?>
      <?php
      if ( comments_open() || get_comments_number() ) {
	      comments_template();
      }
      ?>
    </div>
    <div style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:16px; padding:28px;" class="reveal">
      <span class="eyebrow"<?php echo crux_edit_attr( 'single_post', 'article_small_heading_1' ); ?>><?php echo crux_h( 'single_post', 'article_small_heading_1' ); ?></span>
      <?php
      while ( $crux_more->have_posts() ) :
	      $crux_more->the_post();
      ?>
      <a href="<?php echo esc_url( get_permalink() ); ?>" style="display:block; padding:16px 0; border-bottom:1px solid var(--crux-line,#1E2B5E); color:var(--crux-text,#F4F5FA);">
        <span style="font-size:11px; letter-spacing:1.5px; color:var(--crux-blue,#5B8DEF); font-weight:700;"><?php echo esc_html( strtoupper( crux_post_category_name() ) ); ?></span>
        <span style="display:block; font-size:15px; font-weight:700; margin-top:6px;"><?php echo esc_html( get_the_title() ); ?></span>
      </a>
      <?php
      endwhile;
      wp_reset_postdata();
      ?>
    </div>
  </section>

  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'dark', 'prefooter' => 'events', 'wing' => 'events' ) ); ?>

<div class="msw">
  <div class="crux-sw-pod crux-sw-pod--dark" style="pointer-events:auto; display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #2A3F7A 0%, #15224A 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(0,0,0,0.65); filter:drop-shadow(0 4px 12px rgba(0,0,0,0.4));">
    <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#020512; padding:4px; gap:4px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.5);">
        <span<?php echo crux_edit_attr( 'single_post', 'article_text_1' ); ?>><?php echo crux_h( 'single_post', 'article_text_1' ); ?></span>
      </a>
      <a href="<?php echo esc_url( home_url( '/consultancy/' ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-dark" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#8E96BB; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">
        <span<?php echo crux_edit_attr( 'single_post', 'article_text_2' ); ?>><?php echo crux_h( 'single_post', 'article_text_2' ); ?></span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:6px; display:inline-block; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>
</div></div></div>

<?php get_footer(); ?>
