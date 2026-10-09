<?php
/**
 * Template Name: Single Event Template
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Query events from the database
$all_events = function_exists( 'crux_get_all_events' ) ? crux_get_all_events() : array();

// Resolve requested event
$req_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
$parts = array_filter( explode( '/', trim( parse_url( $req_uri, PHP_URL_PATH ), '/' ) ) );
$current_slug = end( $parts );

// Prefer the queried post (works for draft previews), fall back to the URL slug.
$queried = get_queried_object();
$ev_data  = function_exists( 'crux_get_event_data' )
	? crux_get_event_data( ( $queried instanceof WP_Post && 'event' === $queried->post_type ) ? $queried : $current_slug )
	: null;

// If event does not exist, trigger 404
if ( ! $ev_data ) {
	global $wp_query;
	$wp_query->set_404();
	status_header( 404 );
	nocache_headers();
	include get_404_template();
	exit;
}
?>
<?php crux_use_page_css( 'dark' ); get_header( null, array( 'body_bg' => 'var(--crux-ink,#0A0F26)', 'root_bg' => 'var(--crux-ink,#0A0F26)', 'skin' => 'dark', 'nav' => 'events', 'wing' => 'events', 'active' => 'events' ) ); ?>

  <!-- BREADCRUMB -->
  <div style=" padding:20px 20px 0px 20px;"><span style="font-size:13px; color:#7A82A8;"><a href="<?php echo crux_url( 'single_event', 'breadcrumb_link_1_url' ); ?>" style="color:#7A82A8;"<?php echo crux_edit_attr( 'single_event', 'breadcrumb_link_1' ); ?>><?php echo crux_h( 'single_event', 'breadcrumb_link_1' ); ?></a> / <a href="<?php echo crux_url( 'single_event', 'breadcrumb_link_2_url' ); ?>" style="color:#7A82A8;"<?php echo crux_edit_attr( 'single_event', 'breadcrumb_link_2' ); ?>><?php echo crux_h( 'single_event', 'breadcrumb_link_2' ); ?></a> / <span style="color:var(--crux-text,#F4F5FA); font-weight:600;"><?php echo esc_html( $ev_data["short_title"] ); ?></span></span></div>

  <!-- HERO BANNER -->
  <section style="position:relative; margin:24px 20px 0px 20px; overflow:hidden; height:460px; clip-path:polygon(0 0,100% 0,100% 94%,0 100%); border:1.5px solid var(--crux-line,#1E2B5E);">
    <img src="<?php echo esc_url( $ev_data['hero_url'] ); ?>" alt="<?php echo esc_attr( $ev_data['short_title'] ); ?>" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;" class="drift">
    <div style="position:absolute; inset:0; background:linear-gradient(0deg, rgba(10,15,38,0.94) 0%, rgba(10,15,38,0.2) 60%);"></div>
    <div class="float" style="--r:-8deg; position:absolute; top:24px; right:24px; width:96px; height:96px; border-radius:50%; border:2px dashed var(--crux-blue,#5B8DEF); display:flex; align-items:center; justify-content:center; background:rgba(10,15,38,0.55);" data-m="hide"><span class="bebas" style="font-size:16px; color:var(--crux-blue,#5B8DEF); text-align:center; line-height:1.1;"><?php echo esc_html( $ev_data['date_badge_day'] ); ?><br><?php echo esc_html( $ev_data['date_badge_month'] ); ?></span></div>
    <div style="position:absolute; left:0; right:0; bottom:0; padding:36px 36px 36px 36px;"><span class="eyebrow"><?php echo esc_html( $ev_data['category'] ); ?></span><h1 class="bebas" style="font-size:40px; margin:12px 0px 0px 0px; color:var(--crux-text,#F4F5FA);"><?php echo esc_html( $ev_data['title'] ); ?></h1></div>
  </section>

  <!-- EVENT DETAILS -->
  <section style="min-height:560px; padding:56px 20px 56px 20px; display:grid; grid-template-columns:1.6fr 1fr; gap:56px; align-items:start;" data-m="g1 nomin">
    <div class="reveal">
      <h2 class="bebas" style="font-size:32px; margin:0px 0px 16px 0px; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'single_event', 'event_details_heading_1' ); ?>><?php echo crux_h( 'single_event', 'event_details_heading_1' ); ?></h2>
      <?php if ( ! empty( $ev_data['desc_1'] ) ) : ?><p style="font-size:15px; line-height:1.8; color:#B4BCDD; margin:0px 0px 20px 0px;"><?php echo esc_html( $ev_data['desc_1'] ); ?></p><?php endif; ?>
      <?php if ( ! empty( $ev_data['desc_2'] ) ) : ?><p style="font-size:15px; line-height:1.8; color:#B4BCDD; margin:0px 0px 32px 0px;"><?php echo esc_html( $ev_data['desc_2'] ); ?></p><?php endif; ?>
      <h3 style="font-size:16px; margin:0px 0px 14px 0px; font-weight:700; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'single_event', 'event_details_heading_2' ); ?>><?php echo crux_h( 'single_event', 'event_details_heading_2' ); ?></h3>
      <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:14px;" data-m="g1">
        <?php foreach ( $ev_data['gallery_urls'] as $g_url ) : ?>
        <img src="<?php echo esc_url( $g_url ); ?>" alt="" style="width:100%; height:170px; object-fit:cover; border-radius:10px; border:1.5px solid var(--crux-line,#1E2B5E);" class="reveal">
        <?php endforeach; ?>
      </div>
    </div>
    <div style="background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:16px; padding:28px 28px 28px 28px;" class="reveal">
      <div style="display:flex; flex-direction:column; gap:16px; margin-bottom:22px;">
        <div style="display:flex; gap:18px; align-items:center;">
          <div class="ticket-stub" style="width:52px; height:52px; border-radius:8px; background:var(--crux-navy,#002671); display:flex; flex-direction:column; align-items:center; justify-content:center; flex:0 0 52px;">
            <span style="font-size:9px; font-weight:800; letter-spacing:1px; color:#FFFFFF;"><?php echo esc_html( $ev_data['date_badge_month'] ); ?></span>
            <span class="bebas" style="font-size:20px; color:#FFFFFF;"><?php echo esc_html( $ev_data['date_badge_day'] ); ?></span>
          </div>
          <div>
            <div style="font-size:13.5px; font-weight:700; color:var(--crux-text,#F4F5FA);"><?php echo esc_html( $ev_data['date_str'] ); ?></div>
            <div style="font-size:12.5px; color:#A3A9C8;"><?php echo esc_html( $ev_data['time_str'] ); ?></div>
          </div>
        </div>
        <div style="display:flex; gap:14px; align-items:center;">
          <div style="width:44px; height:44px; border-radius:10px; background:rgba(91,141,239,0.12); display:flex; align-items:center; justify-content:center; flex:0 0 44px;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 21s7-6.5 7-12a7 7 0 1 0-14 0c0 5.5 7 12 7 12z" stroke="#5B8DEF" stroke-width="1.6"></path><circle cx="12" cy="9" r="2.4" stroke="#5B8DEF" stroke-width="1.6"></circle></svg></div>
          <div>
            <div style="font-size:13.5px; font-weight:700; color:var(--crux-text,#F4F5FA);"><?php echo esc_html( $ev_data['location'] ); ?></div>
            <div style="font-size:12.5px; color:#A3A9C8;"><?php echo esc_html( $ev_data['country'] ); ?></div>
          </div>
        </div>
      </div>
      <?php
      $event_id    = ! empty( $ev_data['id'] ) ? absint( $ev_data['id'] ) : 0;
      $event_tiers = ( $event_id && function_exists( 'cr8v_tix_get_event_tiers' ) ) ? cr8v_tix_get_event_tiers( $event_id, true ) : array();
      // Past events never show the booking modal (the server also refuses the booking).
      $has_tiers   = ! empty( $event_tiers ) && empty( $ev_data['is_past'] );
      if ( $has_tiers ) : ?>
        <button type="button" id="cr8v-open-modal-btn" style="display:block; width:100%; text-align:center; background:var(--crux-red,#BA0000); color:#FFFFFF; font-weight:700; font-size:15px; padding:16px 16px; margin-bottom:12px; --sl:10px; cursor:pointer;" class="bx">
          <?php esc_html_e( 'Reserve Your Spot', 'cruxnxtion' ); ?>
        </button>
      <?php else : ?>
        <a href="<?php echo !empty($ev_data['eventbrite']) ? esc_url($ev_data['eventbrite']) : esc_url( home_url('/contact/') ); ?>" style="display:block; text-align:center; background:var(--crux-red,#BA0000); color:#FFFFFF; font-weight:700; font-size:15px; padding:16px 16px 16px 16px; margin-bottom:12px; --sl:10px;" class="bx" <?php echo !empty($ev_data['eventbrite']) ? 'target="_blank" rel="noopener"' : ''; ?><?php echo crux_edit_attr( 'single_event', 'event_details_button_1' ); ?>><?php echo crux_h( 'single_event', 'event_details_button_1' ); ?></a>
      <?php endif; ?>
      <a href="<?php echo crux_url( 'single_event', 'event_details_button_2_url' ); ?>" style="display:block; text-align:center; color:var(--crux-text,#F4F5FA); font-weight:700; font-size:14px; padding:14px 14px 14px 14px; --sl:10px; --bc:var(--crux-text,#F4F5FA);" class="bx"<?php echo crux_edit_attr( 'single_event', 'event_details_button_2' ); ?>><?php echo crux_h( 'single_event', 'event_details_button_2' ); ?></a>
      <?php crux_share_bar( get_permalink( $ev_data['id'] ), get_the_title( $ev_data['id'] ) ); ?>
    </div>
  </section>

  <!-- YOU MIGHT ALSO LIKE -->
  <section style=" padding:20px 20px 44px 20px;">
    <h2 class="bebas reveal" style="font-size:36px; margin:0px 0px 28px 0px; color:var(--crux-text,#F4F5FA);"<?php echo crux_edit_attr( 'single_event', 'you_might_also_like_heading_1' ); ?>><?php echo crux_h( 'single_event', 'you_might_also_like_heading_1' ); ?></h2>
    <div style="display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:24px;" class="reveal" data-m="g1">
      <?php
      $rendered_count = 0;
      foreach ( $all_events as $slug => $e_item ) :
          if ( $slug === $current_slug ) continue;
          if ( $rendered_count >= 2 ) break;
          $rendered_count++;
      ?>
      <a href="<?php echo esc_url( home_url( "/event/" . $slug . "/" ) ); ?>" style="display:flex; flex-direction:column; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:14px; overflow:hidden;" class="reveal">
        <div style="height:200px;"><img src="<?php echo esc_url( $e_item['hero_url'] ); ?>" alt="<?php echo esc_attr( $e_item['short_title'] ); ?>" style="width:100%; height:100%; object-fit:cover; display:block;"></div>
        <div style=" padding:20px 20px 20px 20px; display:flex; flex-direction:column; gap:8px;">
          <span class="eyebrow"><?php echo esc_html( $e_item['category'] . ' • ' . $e_item['date_str'] ); ?></span>
          <h3 style="font-size:17px; margin:0px 0px 0px 0px; font-weight:700; color:var(--crux-text,#F4F5FA);"><?php echo esc_html( $e_item['short_title'] ); ?></h3>
          <p style="font-size:12.5px; color:#A3A9C8; margin:0px 0px 0px 0px;"><?php echo esc_html( $e_item['location'] ); ?></p>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </section>

  <?php get_template_part( 'parts/site-footer', null, array( 'skin' => 'dark', 'prefooter' => 'events', 'wing' => 'events' ) ); ?>

<div class="msw">
  <div class="crux-sw-pod crux-sw-pod--dark" style="pointer-events:auto; display:inline-flex; align-items:center; padding:1.5px; background:linear-gradient(135deg, #2A3F7A 0%, #15224A 100%); clip-path:polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%); box-shadow:0 14px 36px rgba(0,0,0,0.65); filter:drop-shadow(0 4px 12px rgba(0,0,0,0.4));">
    <div class="crux-sw-inner" style="display:inline-flex; align-items:center; background:#020512; padding:4px; gap:4px; clip-path:polygon(7px 0, 100% 0, calc(100% - 7px) 100%, 0 100%);">
      <a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="crux-sw-tab crux-sw-tab--active-events" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:#1E48B0; color:#FFFFFF; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); box-shadow:0 2px 8px rgba(30,72,176,0.5);">
        <span<?php echo crux_edit_attr( 'single_event', 'you_might_also_like_text_1' ); ?>><?php echo crux_h( 'single_event', 'you_might_also_like_text_1' ); ?></span>
      </a>
      <a href="<?php echo esc_url( home_url( "/consultancy/" ) ); ?>" class="crux-sw-tab crux-sw-tab--inactive-dark" style="display:inline-flex; align-items:center; justify-content:center; padding:11px 22px; min-width:140px; font-size:13px; font-weight:600; letter-spacing:0.3px; text-transform:uppercase; text-decoration:none; line-height:1.2; background:transparent; color:#8E96BB; clip-path:polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%); transition:all .2s ease;">
        <span<?php echo crux_edit_attr( 'single_event', 'you_might_also_like_text_2' ); ?>><?php echo crux_h( 'single_event', 'you_might_also_like_text_2' ); ?></span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:6px; display:inline-block; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>
</div></div></div>





<?php if ( ! empty( $has_tiers ) ) : ?>
<!-- ========================================================================= -->
<!-- CR8V EVENT TICKETING - SLANTED BOOKING MODAL (PHASE 2)                    -->
<style>
  @media (max-width: 600px) {
    .cr8v-modal-overlay { padding: 16px 12px !important; }
    .cr8v-modal-dialog { padding: 22px 16px !important; border-radius: 12px !important; }
    #cr8v-modal-title { font-size: 26px !important; }
    .cr8v-modal-tier-row { padding: 12px 14px !important; gap: 10px !important; }
  }
</style>
<div id="cr8v-booking-modal" class="cr8v-modal-overlay" style="display:<?php echo isset( $_GET['book'] ) ? 'flex' : 'none'; ?>; position:fixed; inset:0; z-index:99999; background:rgba(5,8,26,0.88); backdrop-filter:blur(10px); -webkit-backdrop-filter:blur(10px); overflow-y:auto; padding:24px 16px; align-items:center; justify-content:center; box-sizing:border-box;" role="dialog" aria-modal="true" aria-labelledby="cr8v-modal-title">
  <div class="cr8v-modal-dialog" style="position:relative; width:100%; max-width:600px; background:var(--crux-surface,#111838); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:16px; padding:32px 28px; box-shadow:0 24px 50px rgba(0,0,0,0.6); margin:auto; box-sizing:border-box;">
    <!-- Close button -->
    <button type="button" id="cr8v-close-modal-btn" aria-label="<?php esc_attr_e( 'Close booking modal', 'cruxnxtion' ); ?>" style="position:absolute; top:20px; right:20px; background:rgba(255,255,255,0.06); border:1px solid var(--crux-line,#1E2B5E); border-radius:50%; width:36px; height:36px; color:var(--crux-text,#F4F5FA); font-size:18px; line-height:34px; text-align:center; cursor:pointer;">✕</button>

    <!-- Modal Header -->
    <div style="margin-bottom:24px; padding-right:40px;">
      <span class="eyebrow" style="color:var(--crux-blue,#5B8DEF); font-size:11px;"><?php esc_html_e( 'SECURE TICKETING', 'cruxnxtion' ); ?></span>
      <h2 id="cr8v-modal-title" class="bebas" style="font-size:32px; color:#FFFFFF; margin:6px 0 4px 0;"><?php echo esc_html( $ev_data['title'] ); ?></h2>
      <p style="font-size:13.5px; color:#A3A9C8; margin:0;"><?php echo esc_html( $ev_data['date_str'] . ( ! empty( $ev_data['time_str'] ) ? ' • ' . $ev_data['time_str'] : '' ) . ( ! empty( $ev_data['location'] ) ? ' • ' . $ev_data['location'] : '' ) ); ?></p>
    </div>

    <!-- Error message alert -->
    <div id="cr8v-modal-error" style="display:none; background:#721c24; border:1px solid #f5c6cb; color:#FFFFFF; padding:12px 16px; border-radius:8px; font-size:13.5px; margin-bottom:18px; line-height:1.5;" role="alert"></div>

    <form id="cr8v-booking-form">
      <!-- Honeypot: must remain empty -->
      <div style="display:none !important; position:absolute; left:-9999px;">
        <label for="cr8v-hp-website"><?php esc_html_e( 'Leave this field empty', 'cruxnxtion' ); ?></label>
        <input type="text" id="cr8v-hp-website" name="website" tabindex="-1" autocomplete="off" value="">
      </div>

      <!-- Ticket Tiers List -->
      <div style="margin-bottom:22px;">
        <label style="display:block; font-size:11px; font-weight:700; color:#7A82A8; text-transform:uppercase; letter-spacing:1px; margin-bottom:10px;"><?php esc_html_e( 'Select Tickets', 'cruxnxtion' ); ?></label>
        <div style="display:flex; flex-direction:column; gap:12px;">
          <?php foreach ( $event_tiers as $tier ) :
            $is_sold_out = ! empty( $tier['is_sold_out'] );
            $avail       = isset( $tier['available_count'] ) ? (int) $tier['available_count'] : 0;
            $max_order   = isset( $tier['max_per_order'] ) ? (int) $tier['max_per_order'] : 10;
            $max_select  = min( $max_order, $avail, 20 );
          ?>
          <div class="cr8v-modal-tier-row" style="background:#0D1330; border:1.5px solid <?php echo $is_sold_out ? '#242a47' : 'var(--crux-line,#1E2B5E)'; ?>; border-radius:10px; padding:16px 18px; display:flex; justify-content:space-between; align-items:center; gap:16px; opacity:<?php echo $is_sold_out ? '0.6' : '1'; ?>; box-sizing:border-box;">
            <div style="flex:1; min-width:0;">
              <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:4px;">
                <span style="font-weight:700; font-size:15px; color:#FFFFFF;"><?php echo esc_html( $tier['name'] ); ?></span>
                <?php if ( $is_sold_out ) : ?>
                  <span style="background:#dc3545; color:#FFFFFF; font-size:10px; font-weight:800; padding:2px 8px; border-radius:4px; text-transform:uppercase; letter-spacing:0.5px;"><?php esc_html_e( 'Sold Out', 'cruxnxtion' ); ?></span>
                <?php else : ?>
                  <span style="background:rgba(91,141,239,0.15); color:var(--crux-blue,#5B8DEF); font-size:10px; font-weight:800; padding:2px 8px; border-radius:4px; text-transform:uppercase; letter-spacing:0.5px;">
                    <?php echo sprintf( esc_html__( '%d remaining', 'cruxnxtion' ), $avail ); ?>
                  </span>
                <?php endif; ?>
              </div>
              <?php if ( ! empty( $tier['description'] ) ) : ?>
                <div style="font-size:12px; color:#A3A9C8; line-height:1.4; margin-bottom:6px;"><?php echo esc_html( $tier['description'] ); ?></div>
              <?php endif; ?>
              <div style="font-size:14px; font-weight:700; color:var(--crux-blue,#5B8DEF);"><?php echo esc_html( $tier['price_formatted'] ); ?></div>
            </div>

            <div>
              <?php if ( $is_sold_out ) : ?>
                <span style="font-size:12px; color:#7A82A8; font-weight:600;"><?php esc_html_e( 'Unavailable', 'cruxnxtion' ); ?></span>
              <?php else : ?>
                <select class="cr8v-tier-qty" data-tier-id="<?php echo esc_attr( $tier['id'] ); ?>" data-price-pence="<?php echo esc_attr( (int) $tier['price_pence'] ); ?>" style="background:var(--crux-surface,#111838); color:var(--crux-text,#F4F5FA); border:1.5px solid var(--crux-line,#1E2B5E); border-radius:6px; padding:8px 12px; font-weight:700; font-size:14px; cursor:pointer;">
                  <option value="0">0</option>
                  <?php for ( $q = 1; $q <= $max_select; $q++ ) : ?>
                    <option value="<?php echo esc_attr( $q ); ?>"><?php echo esc_html( $q ); ?></option>
                  <?php endfor; ?>
                </select>
              <?php endif; ?>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Attendee Contact Information -->
      <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:22px;">
        <label style="display:block; font-size:11px; font-weight:700; color:#7A82A8; text-transform:uppercase; letter-spacing:1px;"><?php esc_html_e( 'Your Contact Details', 'cruxnxtion' ); ?></label>
        <div>
          <input type="text" id="cr8v-buyer-name" required placeholder="<?php esc_attr_e( 'Full Name *', 'cruxnxtion' ); ?>" maxlength="100" style="width:100%; background:#0D1330; border:1.5px solid var(--crux-line,#1E2B5E); border-radius:8px; padding:12px 14px; color:var(--crux-text,#F4F5FA); font-size:14px; box-sizing:border-box;">
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;" data-m="g1">
          <div>
            <input type="email" id="cr8v-buyer-email" required placeholder="<?php esc_attr_e( 'Email Address *', 'cruxnxtion' ); ?>" style="width:100%; background:#0D1330; border:1.5px solid var(--crux-line,#1E2B5E); border-radius:8px; padding:12px 14px; color:var(--crux-text,#F4F5FA); font-size:14px; box-sizing:border-box;">
          </div>
          <div>
            <input type="tel" id="cr8v-buyer-phone" placeholder="<?php esc_attr_e( 'Phone (Optional)', 'cruxnxtion' ); ?>" maxlength="30" style="width:100%; background:#0D1330; border:1.5px solid var(--crux-line,#1E2B5E); border-radius:8px; padding:12px 14px; color:var(--crux-text,#F4F5FA); font-size:14px; box-sizing:border-box;">
          </div>
        </div>
      </div>

      <!-- Live Order Summary Badge -->
      <div style="background:#0D1330; border:1px solid var(--crux-line,#1E2B5E); border-radius:8px; padding:14px 18px; margin-bottom:22px; display:flex; justify-content:space-between; align-items:center;">
        <div>
          <span style="font-size:12px; color:#7A82A8;"><?php esc_html_e( 'Estimated Total:', 'cruxnxtion' ); ?></span>
          <div id="cr8v-summary-tickets" style="font-size:12px; color:var(--crux-blue,#5B8DEF); font-weight:600;"><?php esc_html_e( '0 tickets selected', 'cruxnxtion' ); ?></div>
        </div>
        <div id="cr8v-summary-price" style="font-size:22px; font-weight:700; color:#FFFFFF;">£0.00</div>
      </div>

      <!-- Submit CTA button -->
      <button type="submit" id="cr8v-submit-booking-btn" class="bx" style="width:100%; background:var(--crux-red,#BA0000); color:#FFFFFF; font-weight:700; font-size:15px; padding:16px 20px; --sl:10px; cursor:pointer;" disabled>
        <span id="cr8v-btn-text"><?php esc_html_e( 'Select Tickets To Continue', 'cruxnxtion' ); ?></span>
      </button>

      <p style="font-size:11.5px; color:#7A82A8; text-align:center; margin:12px 0 0 0; line-height:1.5;">
        <?php esc_html_e( 'All pricing computed securely on server. Payments processed via encrypted Stripe checkout.', 'cruxnxtion' ); ?>
      </p>
    </form>
  </div>
</div>

<script>
(function() {
  var modal = document.getElementById('cr8v-booking-modal');
  var openBtn = document.getElementById('cr8v-open-modal-btn');
  var closeBtn = document.getElementById('cr8v-close-modal-btn');
  var form = document.getElementById('cr8v-booking-form');
  var submitBtn = document.getElementById('cr8v-submit-booking-btn');
  var btnText = document.getElementById('cr8v-btn-text');
  var errorBox = document.getElementById('cr8v-modal-error');
  var qtySelects = document.querySelectorAll('.cr8v-tier-qty');
  var summaryQty = document.getElementById('cr8v-summary-tickets');
  var summaryPrice = document.getElementById('cr8v-summary-price');

  if (!modal || !openBtn) return;

  function updateTotals() {
    var totalQty = 0;
    var totalPence = 0;
    qtySelects.forEach(function(sel) {
      var q = parseInt(sel.value, 10) || 0;
      var pricePence = parseInt(sel.getAttribute('data-price-pence'), 10) || 0;
      totalQty += q;
      totalPence += (q * pricePence);
    });

    if (summaryQty) {
      summaryQty.textContent = totalQty === 1 ? '1 ticket selected' : totalQty + ' tickets selected';
    }
    if (summaryPrice) {
      summaryPrice.textContent = totalPence === 0 ? '£0.00' : '£' + (totalPence / 100).toFixed(2);
    }

    if (submitBtn) {
      if (totalQty > 0) {
        submitBtn.removeAttribute('disabled');
        submitBtn.style.opacity = '1';
        submitBtn.style.cursor = 'pointer';
        if (btnText) {
          btnText.textContent = totalPence === 0 ? 'Confirm Free RSVP →' : 'Proceed to Checkout (' + '£' + (totalPence / 100).toFixed(2) + ') →';
        }
      } else {
        submitBtn.setAttribute('disabled', 'disabled');
        submitBtn.style.opacity = '0.5';
        submitBtn.style.cursor = 'not-allowed';
        if (btnText) {
          btnText.textContent = 'Select Tickets To Continue';
        }
      }
    }
  }

  qtySelects.forEach(function(sel) {
    sel.addEventListener('change', updateTotals);
  });

  function openModal() {
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    updateTotals();
    var firstInput = document.getElementById('cr8v-buyer-name');
    if (firstInput) firstInput.focus();
  }

  function closeModal() {
    modal.style.display = 'none';
    document.body.style.overflow = '';
    if (errorBox) {
      errorBox.style.display = 'none';
      errorBox.textContent = '';
    }
    openBtn.focus();
  }

  openBtn.addEventListener('click', openModal);
  if (closeBtn) closeBtn.addEventListener('click', closeModal);

  modal.addEventListener('click', function(e) {
    if (e.target === modal) {
      closeModal();
    }
  });

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && modal.style.display === 'flex') {
      closeModal();
    }
  });

  if (window.location.hash === '#book' || window.location.search.indexOf('book=1') !== -1) {
    openModal();
  }

  if (form) {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      if (errorBox) {
        errorBox.style.display = 'none';
        errorBox.textContent = '';
      }

      var items = [];
      qtySelects.forEach(function(sel) {
        var q = parseInt(sel.value, 10) || 0;
        if (q > 0) {
          items.push({
            tier_id: sel.getAttribute('data-tier-id'),
            quantity: q
          });
        }
      });

      if (items.length === 0) {
        if (errorBox) {
          errorBox.textContent = 'Please select at least one ticket.';
          errorBox.style.display = 'block';
        }
        return;
      }

      var customerName = (document.getElementById('cr8v-buyer-name') || {}).value || '';
      var customerEmail = (document.getElementById('cr8v-buyer-email') || {}).value || '';
      var customerPhone = (document.getElementById('cr8v-buyer-phone') || {}).value || '';
      var websiteHp = (document.getElementById('cr8v-hp-website') || {}).value || '';

      var payload = {
        event_id: <?php echo absint( $event_id ); ?>,
        customer_name: customerName.trim(),
        customer_email: customerEmail.trim(),
        customer_phone: customerPhone.trim(),
        items: items,
        website: websiteHp
      };

      if (submitBtn) {
        submitBtn.setAttribute('disabled', 'disabled');
        submitBtn.style.opacity = '0.7';
      }
      if (btnText) {
        btnText.textContent = 'Securing Tickets...';
      }

      fetch('<?php echo esc_url_raw( rest_url( 'cr8v-ticketing/v1/checkout' ) ); ?>', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
      })
      .then(function(res) {
        return res.json().then(function(data) {
          return { status: res.status, ok: res.ok, data: data };
        });
      })
      .then(function(result) {
        if (result.ok && result.data && result.data.success && result.data.redirect_url) {
          window.location.href = result.data.redirect_url;
        } else {
          var msg = (result.data && result.data.message) ? result.data.message : 'Unable to reserve tickets. Please try again.';
          if (errorBox) {
            errorBox.textContent = msg;
            errorBox.style.display = 'block';
          }
          if (submitBtn) {
            submitBtn.removeAttribute('disabled');
            submitBtn.style.opacity = '1';
          }
          updateTotals();
        }
      })
      .catch(function(err) {
        if (errorBox) {
          errorBox.textContent = 'A network error occurred. Please check your connection and try again.';
          errorBox.style.display = 'block';
        }
        if (submitBtn) {
          submitBtn.removeAttribute('disabled');
          submitBtn.style.opacity = '1';
        }
        updateTotals();
      });
    });
  }
})();
</script>
<?php endif; ?>

<?php get_footer(); ?>
