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
<?php crux_use_page_css( 'dark' ); get_header( null, array( 'body_bg' => 'var(--crux-ink,#0A0F26)', 'root_bg' => 'var(--crux-ink,#0A0F26)', 'skin' => 'dark', 'nav' => 'events', 'wing' => 'events', 'active' => 'events' ) ); ?>

  <!-- PAGE HEADING -->
  <section style=" padding:44px 20px 20px 20px;">
    <span class="eyebrow">The Ticket Wall</span>
    <h1 class="bebas" style="font-size:44px; margin:14px 0px 14px 0px; color:var(--crux-text,#F4F5FA);">EVENTS</h1>
    <p style="font-size:15px; color:#A3A9C8; max-width:560px; margin:0px 0px 0px 0px;" class="reveal">Every ticket we've printed, punched by the same crew — weddings, dance nights, awards and festivals across the UK.</p>
  </section>

  <!-- TICKET GRID -->
  <section style="min-height:560px; display:flex; flex-direction:column; justify-content:center; padding:30px 20px 44px 20px;" data-m="nomin">
    <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:26px;" data-m="g1">
      <?php
      $events_list = function_exists( 'crux_get_all_events' ) ? crux_get_all_events() : array();
      foreach ( $events_list as $e_slug => $e_item ) :
          $stub_bg = ! empty( $e_item['badge_bg'] ) ? $e_item['badge_bg'] : 'var(--crux-navy,#002671)';
          $stub_txt = ! empty( $e_item['badge_color'] ) ? $e_item['badge_color'] : '#FFFFFF';
          $rot = ! empty( $e_item['rotation'] ) ? $e_item['rotation'] : '0deg';
          $target_url = ! empty( $e_item['permalink'] ) ? $e_item['permalink'] : home_url( '/event/' . $e_slug . '/' );
          $sub_meta = ! empty( $e_item['eventbrite'] ) ? 'Tickets on Eventbrite' : ( ! empty( $e_item['time_str'] ) ? $e_item['time_str'] : $e_item['location'] );
      ?>
      <a href="<?php echo esc_url( $target_url ); ?>" class="tilt-ticket" style="display:flex; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; min-height:400px; --r:<?php echo esc_attr( $rot ); ?>; transform:rotate(var(--r)); overflow:hidden;" data-m="tile">
        <div class="ticket-stub" style="flex:0 0 90px; background:<?php echo esc_attr( $stub_bg ); ?>; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px;">
          <span class="bebas" style="font-size:38px; color:<?php echo esc_attr( $stub_txt ); ?>; line-height:1;"><?php echo esc_html( $e_item['date_badge_day'] ); ?></span>
          <span style="font-size:10px; font-weight:800; letter-spacing:1.5px; color:<?php echo esc_attr( $stub_txt ); ?>; text-align:center;"><?php echo esc_html( $e_item['date_badge_month'] . ' ' . $e_item['year'] ); ?></span>
        </div>
        <div style="flex:1; display:flex; flex-direction:column; min-width:0;">
          <div style="flex:1; position:relative; min-height:250px;"><img src="<?php echo esc_url( $e_item['hero_url'] ); ?>" alt="<?php echo esc_attr( $e_item['short_title'] ); ?>" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:center top;"></div>
          <div style=" padding:18px 20px 20px 20px; background:#0D1330; border-top:1.5px dashed var(--crux-line,#1E2B5E);">
            <span class="eyebrow" style="color:var(--crux-blue,#5B8DEF);"><?php echo esc_html( $e_item['category'] ); ?></span>
            <h3 style="font-size:19px; margin:8px 0px 4px 0px; font-weight:700; color:#FFFFFF;"><?php echo esc_html( $e_item['short_title'] ); ?></h3>
            <p style="font-size:12.5px; color:#C5CFF5; margin:0px 0px 10px 0px;"><?php echo esc_html( $sub_meta ); ?></p>
            <span style="font-weight:700; font-size:12.5px; color:var(--crux-blue,#5B8DEF); border-bottom:1.5px solid var(--crux-blue,#5B8DEF); padding-bottom:2px;">View Details →</span>
          </div>
        </div>
      </a>
      <?php endforeach; ?>
      <div style="display:flex; flex-direction:column; justify-content:center; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:12px; padding:32px 30px 32px 30px;">
        <span class="eyebrow">Your Night Next</span>
        <h3 class="bebas" style="font-size:30px; margin:10px 0px 8px 0px; color:var(--crux-text,#F4F5FA);">PUT YOUR EVENT ON THE WALL.</h3>
        <p style="font-size:13px; line-height:1.6; color:#A3A9C8; margin:0px 0px 18px 0px;">Send us a brief and we will plan, book and run it.</p>
        <a href="<?php echo esc_url( home_url( "/contact/" ) ); ?>" style="background:var(--crux-red,#BA0000); color:#FFFFFF; font-weight:700; font-size:13.5px; padding:14px 26px 14px 26px; width:fit-content; --sl:10px;" class="bx">Get In Touch</a>
      </div>
    </div>
  </section>

  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'dark', 'prefooter' => 'events', 'wing' => 'events' ) ); ?>

<div class="msw">
  <div class="crux-sw-pod crux-sw-pod--dark" style="pointer-events:auto; display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #2A3F7A 0%, #15224A 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(0,0,0,0.65); filter:drop-shadow(0 4px 12px rgba(0,0,0,0.4));">
    <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#020512; padding:4px; gap:4px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.5);">
        <span>Events</span>
      </a>
      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-dark" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#8E96BB; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">
        <span>Consultancy</span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:6px; display:inline-block; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>
</div></div></div>





<?php get_footer(); ?>
