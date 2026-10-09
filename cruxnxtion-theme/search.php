<?php
/**
 * Search results: the number of results, a search box, a card for each result and page links.
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $wp_query;
crux_use_page_css( 'dark' );
get_header( null, array( 'body_bg' => '#0A0F26', 'root_bg' => '#0A0F26', 'skin' => 'dark', 'nav' => 'events', 'wing' => 'events', 'active' => '' ) );
?>

  <!-- SEARCH HEADING -->
  <section style=" padding:44px 20px 20px 20px;">
    <span class="eyebrow"<?php echo crux_edit_attr( 'search', 'heading_small_heading_1' ); ?>><?php echo crux_h( 'search', 'heading_small_heading_1' ); ?></span>
    <h1 class="bebas" style="font-size:44px; margin:14px 0px 8px 0px; color:#F4F5FA;"><?php echo esc_html( sprintf( /* translators: %s: search words. */ __( 'Results for "%s"', 'cruxnxtion' ), get_search_query( false ) ) ); ?></h1>
    <p style="font-size:14px; color:#A3A9C8; margin:0;"><?php echo esc_html( sprintf( /* translators: %d: number of results. */ _n( '%d result', '%d results', (int) $wp_query->found_posts, 'cruxnxtion' ), (int) $wp_query->found_posts ) ); ?></p>
    <form class="crux-searchform" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
      <input type="search" name="s" value="<?php echo esc_attr( get_search_query( false ) ); ?>" aria-label="<?php esc_attr_e( 'Search', 'cruxnxtion' ); ?>">
      <button type="submit"<?php echo crux_edit_attr( 'search', 'heading_text_2' ); ?>><?php echo crux_h( 'search', 'heading_text_2' ); ?></button>
    </form>
  </section>

  <!-- RESULTS -->
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
    <p style="font-size:16px; color:#A3A9C8; text-align:center;"<?php echo crux_edit_attr( 'search', 'heading_text_1' ); ?>><?php echo crux_h( 'search', 'heading_text_1' ); ?></p>
    <?php endif; ?>
  </section>

  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'dark', 'prefooter' => 'events', 'wing' => 'events' ) ); ?>
</div>

<?php get_footer(); ?>
