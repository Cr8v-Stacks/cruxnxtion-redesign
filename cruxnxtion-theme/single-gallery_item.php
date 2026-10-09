<?php
/**
 * A single gallery photograph: the full photo, its caption details (kicker, location, notes) and a way back to the gallery.
 * Details come from the Gallery Print Studio box of the shared events plugin.
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
the_post();
$crux_gid      = get_the_ID();
$crux_photo    = get_the_post_thumbnail_url( $crux_gid, 'full' );
$crux_kicker   = (string) get_post_meta( $crux_gid, '_cr8v_gallery_kicker', true );
$crux_location = (string) get_post_meta( $crux_gid, '_cr8v_gallery_location', true );
$crux_notes    = (string) get_post_meta( $crux_gid, '_cr8v_gallery_notes', true );
crux_use_page_css( 'dark' );
get_header( null, array( 'body_bg' => 'var(--crux-ink,#0A0F26)', 'root_bg' => 'var(--crux-ink,#0A0F26)', 'skin' => 'dark', 'nav' => 'events', 'wing' => 'events', 'active' => 'gallery' ) );
?>

  <div style=" padding:20px 20px 0px 20px;"><span style="font-size:13px; color:#7A82A8;"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:#7A82A8;"><?php esc_html_e( 'Home', 'cruxnxtion' ); ?></a> / <a href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>" style="color:#7A82A8;"><?php esc_html_e( 'Gallery', 'cruxnxtion' ); ?></a> / <span style="color:var(--crux-text,#F4F5FA); font-weight:600;"><?php echo esc_html( get_the_title() ); ?></span></span></div>

  <section style=" padding:40px 20px 30px 20px; max-width:1000px;">
    <?php if ( $crux_kicker ) : ?><span class="eyebrow"><?php echo esc_html( $crux_kicker ); ?></span><?php endif; ?>
    <h1 class="bebas" style="font-size:40px; margin:14px 0 8px; color:var(--crux-text,#F4F5FA); line-height:0.95;"><?php echo esc_html( get_the_title() ); ?></h1>
    <?php if ( $crux_location ) : ?><p style="font-size:13px; color:#A3A9C8; margin:0;"><?php echo esc_html( $crux_location ); ?></p><?php endif; ?>
  </section>
  <?php if ( $crux_photo ) : ?>
  <section style=" margin:0 20px; border-radius:16px; overflow:hidden; border:1.5px solid var(--crux-line,#1E2B5E); background:var(--crux-surface,#111838);"><img src="<?php echo esc_url( $crux_photo ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" style="display:block; width:100%; height:auto; max-height:80vh; object-fit:contain;"></section>
  <?php endif; ?>
  <section style=" padding:36px 20px 44px 20px; max-width:760px;">
    <?php if ( $crux_notes ) : ?><div class="crux-prose"><p><?php echo esc_html( $crux_notes ); ?></p></div><?php endif; ?>
    <?php crux_share_bar( get_permalink(), get_the_title() ); ?>
    <p style="margin:24px 0 0;"><a href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>" style="color:var(--crux-blue,#5B8DEF); font-weight:700;">&larr; <?php esc_html_e( 'Back to the gallery', 'cruxnxtion' ); ?></a></p>
  </section>

  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'dark', 'prefooter' => 'events', 'wing' => 'events' ) ); ?>
</div>

<?php get_footer(); ?>
