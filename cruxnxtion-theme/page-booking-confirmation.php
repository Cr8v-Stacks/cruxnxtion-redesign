<?php
/**
 * Template Name: Booking Confirmation & Ticket Verification
 *
 * Handles order confirmation display, bare session_id security notices,
 * and ticket QR scan verification / door check-in.
 *
 * Security Guarantee: Never shows tickets for a bare session_id.
 * Verifies order_token before displaying tickets.
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// This page carries secret tokens in its URL and shows personal data and tickets. Never let a page
// cache store it, never let search engines index it, and never leak the URL through the Referer header.
if ( ! defined( 'DONOTCACHEPAGE' ) ) {
	define( 'DONOTCACHEPAGE', true );
}
nocache_headers();
header( 'X-Robots-Tag: noindex, nofollow, noarchive' );
header( 'Referrer-Policy: no-referrer' );

// -----------------------------------------------------------------------------
// 1. Process Staff Door Check-In Action (POST only, gated by capability & nonce)
// -----------------------------------------------------------------------------
$checkin_message = '';
$checkin_status  = '';
$staff_landing_url = function_exists( 'cr8v_tix_staff_landing_url' ) ? cr8v_tix_staff_landing_url() : home_url( '/booking-confirmation/' );

if ( 'POST' === ( $_SERVER['REQUEST_METHOD'] ?? '' ) && isset( $_POST['cr8v_do_checkin'] ) ) {
	$p_code  = cr8v_tix_normalize_ticket_code( sanitize_text_field( wp_unslash( $_POST['ticket_code'] ?? '' ) ) );
	$p_sec   = sanitize_text_field( wp_unslash( $_POST['ticket_secret'] ?? '' ) );
	$p_order = absint( $_POST['order_id'] ?? 0 );
	$nonce   = sanitize_text_field( wp_unslash( $_POST['_cr8v_checkin_nonce'] ?? '' ) );

	if ( ! current_user_can( 'edit_event_orders' ) && ! current_user_can( 'manage_options' ) ) {
		$checkin_message = __( 'Permission denied. Staff login required for check-in.', 'cr8v-event-ticketing' );
		$checkin_status  = 'error';
	} elseif ( ! wp_verify_nonce( $nonce, 'cr8v_checkin_' . $p_code ) ) {
		$checkin_message = __( 'Security check failed. Please refresh and try again.', 'cr8v-event-ticketing' );
		$checkin_status  = 'error';
	} elseif ( ! function_exists( 'cr8v_tix_verify_ticket_secret' ) || ! cr8v_tix_verify_ticket_secret( $p_code, $p_sec ) ) {
		$checkin_message = __( 'Ticket cryptographic verification failed.', 'cr8v-event-ticketing' );
		$checkin_status  = 'error';
	} else {
		// Serialise check-ins per order. Tickets live in one array, so two staff scanning the same
			// pass at the same moment could otherwise both read "not checked in" and both succeed.
			// The lock is released automatically when this request's database connection closes.
			global $wpdb;
			$checkin_lock = 'cr8v_checkin_' . DB_NAME . '_' . $wpdb->prefix . $p_order;
			$got_lock     = (int) $wpdb->get_var( $wpdb->prepare( 'SELECT GET_LOCK( %s, 5 )', $checkin_lock ) );
			if ( 1 === $got_lock ) {
				wp_cache_delete( $p_order, 'post_meta' ); // Re-read tickets after taking the lock.
				$order_tickets = get_post_meta( $p_order, '_cr8v_order_tickets', true );
			} else {
				$order_tickets   = null;
				$checkin_message = __( 'The system is busy. Please try the check-in again.', 'cr8v-event-ticketing' );
				$checkin_status  = 'error';
			}
		if ( is_array( $order_tickets ) ) {
			$found = false;
			foreach ( $order_tickets as $idx => $t ) {
				if ( ( $t['ticket_code'] ?? '' ) === $p_code ) {
					if ( ! empty( $t['void'] ) ) {
						$checkin_message = __( 'Cannot check in: this ticket has been VOIDED / refunded.', 'cr8v-event-ticketing' );
						$checkin_status  = 'error';
						$found = true;
						break;
					}
					if ( ! empty( $t['checked_in'] ) ) {
						$checkin_message = sprintf( __( 'Ticket was ALREADY checked in at %s.', 'cr8v-event-ticketing' ), esc_html( $t['checked_in_at'] ?? 'door' ) );
						$checkin_status  = 'warning';
						$found = true;
						break;
					}
					$order_tickets[ $idx ]['checked_in']    = true;
					$order_tickets[ $idx ]['checked_in_at'] = current_time( 'mysql' );
					$order_tickets[ $idx ]['checked_in_by'] = get_current_user_id(); // Accountability: which staff member admitted this ticket.
					update_post_meta( $p_order, '_cr8v_order_tickets', $order_tickets );
					$checkin_message = __( 'Attendee successfully CHECKED IN!', 'cr8v-event-ticketing' );
					$checkin_status  = 'success';
					$found = true;

					// Post-Redirect-Get (PRG) for Door Staff Check-In
					$redirect_staff_id = get_current_user_id();
					$redirect_time     = time();
					$redirect_token    = cr8v_tix_generate_checkin_token( $p_code, $redirect_staff_id, $redirect_time );
					$redirect_args     = array(
						'cr8v_ticket' => $p_code,
						'checked'     => '1',
						'chk_staff'   => $redirect_staff_id,
						'chk_time'    => $redirect_time,
						'chk_token'   => $redirect_token,
					);
					if ( ! empty( $p_sec ) ) {
						$redirect_args['tix_secret'] = $p_sec;
					}
					$redirect_url = add_query_arg( $redirect_args, $staff_landing_url );
					// 303 See Other: the browser then loads the result with a GET, so refreshing never re-submits the form.
					wp_safe_redirect( $redirect_url, 303 );
					exit;
					break;
				}
			}
			if ( ! $found && empty( $checkin_message ) ) {
				$checkin_message = __( 'Ticket code not found on order record.', 'cr8v-event-ticketing' );
				$checkin_status  = 'error';
			}
		}
	}
}

// -----------------------------------------------------------------------------
// 2. Parse Query Parameters
// -----------------------------------------------------------------------------
$req_order_token = sanitize_text_field( wp_unslash( $_GET['order_token'] ?? '' ) );
$req_session_id  = sanitize_text_field( wp_unslash( $_GET['session_id'] ?? '' ) );
$ticket_raw      = sanitize_text_field( wp_unslash( $_GET['cr8v_ticket'] ?? '' ) );
// Strict format (TIX- plus 12 hex characters); '' when the typed or scanned text is not a real code.
$req_ticket_code = cr8v_tix_normalize_ticket_code( $ticket_raw );
$req_tix_secret  = sanitize_text_field( wp_unslash( $_GET['tix_secret'] ?? '' ) );
// Door staff may look a code up by typing it. Visitors need the secret that is inside the QR link.
$staff_lookup    = '' !== $ticket_raw && current_user_can( 'edit_event_orders' );

// PRG Check-In Flag Verification
$req_checked   = sanitize_text_field( wp_unslash( $_GET['checked'] ?? '' ) );
$req_chk_staff = (int) ( $_GET['chk_staff'] ?? 0 );
$req_chk_time  = (int) ( $_GET['chk_time'] ?? 0 );
$req_chk_token = sanitize_text_field( wp_unslash( $_GET['chk_token'] ?? '' ) );

if ( '1' === $req_checked && '' !== $req_ticket_code ) {
	if ( cr8v_tix_verify_checkin_token( $req_ticket_code, $req_chk_staff, $req_chk_time, $req_chk_token ) ) {
		$found_chk = cr8v_tix_find_ticket( $req_ticket_code );
		if ( $found_chk && ! empty( $found_chk['ticket']['checked_in'] ) ) {
			$checkin_status  = 'success';
			$checkin_message = __( 'Attendee successfully CHECKED IN!', 'cr8v-event-ticketing' );
		}
	}
}

// View mode state
$view_mode   = 'default';
$order_post  = null;
$event_post  = null;
$event_data  = array();
$verified_ticket = null;

// Derive the secret for a staff lookup ONLY after the ticket is confirmed to exist. Deriving it for any
// typed text would make every made-up code look genuine.
if ( '' !== $req_ticket_code && empty( $req_tix_secret ) && $staff_lookup && cr8v_tix_find_ticket( $req_ticket_code ) ) {
	$req_tix_secret = cr8v_tix_ticket_secret( $req_ticket_code );
}

if ( ( ! empty( $req_ticket_code ) && ! empty( $req_tix_secret ) ) || $staff_lookup ) {
	// Mode 1: Individual Ticket QR Verification
	$view_mode = 'verify_ticket';
} elseif ( ! empty( $req_order_token ) ) {
	// Mode 2: Full Order Confirmation (order_token verified)
	$view_mode = 'order_confirmed';
	$found_orders = get_posts(
		array(
			'post_type'      => 'event_order',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_key'       => '_cr8v_order_token',
			'meta_value'     => $req_order_token,
		)
	);
	if ( ! empty( $found_orders ) ) {
		$order_post = $found_orders[0];
	}
} elseif ( ! empty( $req_session_id ) ) {
	// Mode 3: Bare session_id (Payment Return from Stripe)
	// Security constraint: NEVER show tickets for a bare session_id!
	$view_mode = 'bare_session';
	$found_orders = get_posts(
		array(
			'post_type'      => 'event_order',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_key'       => '_cr8v_order_stripe_session_id',
			'meta_value'     => $req_session_id,
		)
	);
	if ( ! empty( $found_orders ) ) {
		$order_post = $found_orders[0];
	}
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow, noarchive">
  <title><?php esc_html_e( 'Booking Confirmation & Tickets — Crux Nxtion', 'cruxnxtion' ); ?></title>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> style="background:#0A0F26; margin:0; padding:0; color:#F4F5FA; font-family:'Space Grotesk', system-ui, sans-serif;">
<?php wp_body_open(); ?>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Space+Grotesk:wght@400;500;600;700&display=swap');
  * {
    box-sizing: border-box !important;
  }
  html, body {
    margin: 0;
    padding: 0;
    width: 100% !important;
    max-width: 100vw !important;
    background: #0A0F26;
    color: #F4F5FA;
    overflow-x: hidden !important;
    box-sizing: border-box;
  }
  a { color: #5B8DEF; text-decoration: none; }
  a:hover { color: #BA0000; }
  .bebas { font-family: 'Bebas Neue', 'Arial Narrow', sans-serif; letter-spacing: 0.5px; line-height: 0.95; text-transform: uppercase; }
  .eyebrow { font-weight: 700; letter-spacing: 2px; text-transform: uppercase; font-size: 11px; color: #5B8DEF; }

  /* Slanted button token */
  .bx { position:relative; clip-path:polygon(var(--sl,10px) 0, 100% 0, calc(100% - var(--sl,10px)) 100%, 0 100%); border:0 !important; border-radius:0 !important; --bw:1.5px; text-align:center; transition:transform .2s ease, filter .2s ease; cursor:pointer; }
  .bx::before { content:''; position:absolute; inset:0; background:var(--bc,transparent); pointer-events:none; clip-path:polygon(evenodd, var(--sl,10px) 0, 100% 0, calc(100% - var(--sl,10px)) 100%, 0 100%, var(--sl,10px) 0, calc(var(--sl,10px) + var(--bw)) var(--bw), calc(100% - var(--bw)) var(--bw), calc(100% - var(--sl,10px) - var(--bw)) calc(100% - var(--bw)), var(--bw) calc(100% - var(--bw)), calc(var(--sl,10px) + var(--bw)) var(--bw), var(--sl,10px) 0); }
  .bx:hover { filter:brightness(1.1); transform:translateY(-2px); }
  .bx:active { transform:none; filter:brightness(.95); }

  /* Ticket notch stub */
  .ticket-stub { position: relative; }
  .ticket-stub::before, .ticket-stub::after { content: ''; position: absolute; right: -11px; width: 20px; height: 20px; border-radius: 50%; background: #0A0F26; z-index: 2; }
  .ticket-stub::before { top: -10px; }
  .ticket-stub::after { bottom: -10px; }

  /* Confirmation container */
  .conf-container { width: 100% !important; max-width: 900px; margin: 0 auto; padding: 40px 20px 80px; box-sizing: border-box; }
  .conf-card { width: 100% !important; background: #111838; border: 1.5px solid #1E2B5E; border-radius: 16px; padding: 36px; margin-bottom: 30px; box-sizing: border-box; overflow-wrap: break-word; word-break: break-word; }

  /* Mobile Responsive Optimization (<= 640px) */
  @media (max-width: 640px) {
    header.no-print {
      padding: 14px 16px !important;
      gap: 12px !important;
    }
    footer.no-print {
      padding: 24px 14px !important;
      font-size: 11.5px !important;
      line-height: 1.6 !important;
      word-break: break-word !important;
    }
    .conf-container { padding: 16px 12px 48px !important; }
    .conf-card { padding: 20px 14px !important; border-radius: 12px !important; margin-bottom: 18px !important; }
    .staff-result-card { padding: 20px 14px !important; }
    h1.bebas, .conf-card h1.bebas { font-size: 26px !important; line-height: 1.1 !important; }
    .door-verify-box { padding: 14px 12px !important; max-width: 100% !important; width: 100% !important; box-sizing: border-box !important; }
    .door-verify-box > div { display: flex !important; flex-direction: column !important; gap: 4px !important; margin-bottom: 12px !important; }
    
    /* Ticket Card: Stacks cleanly as a mobile pass */
    .ticket-card {
      flex-direction: column !important;
      min-height: auto !important;
      border-radius: 12px !important;
      box-sizing: border-box !important;
      width: 100% !important;
    }
    .ticket-card .ticket-stub {
      flex: 0 0 auto !important;
      width: 100% !important;
      flex-direction: row !important;
      justify-content: space-between !important;
      align-items: center !important;
      padding: 12px 16px !important;
      box-sizing: border-box !important;
    }
    .ticket-card .ticket-stub::before,
    .ticket-card .ticket-stub::after {
      display: none !important;
    }
    .ticket-card .ticket-details {
      padding: 18px 14px !important;
      box-sizing: border-box !important;
    }
    .ticket-card .ticket-qr-area {
      flex: 0 0 auto !important;
      width: 100% !important;
      border-left: 0 !important;
      border-top: 1.5px dashed #1E2B5E !important;
      padding: 22px 14px !important;
      box-sizing: border-box !important;
      position: relative !important;
    }
    .ticket-card .ticket-qr-area::before,
    .ticket-card .ticket-qr-area::after {
      content: '';
      position: absolute;
      top: -10px;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background: #0A0F26;
      z-index: 2;
    }
    .ticket-card .ticket-qr-area::before { left: -10px; }
    .ticket-card .ticket-qr-area::after { right: -10px; }
    
    /* Action toolbars */
    .conf-actions {
      flex-direction: column !important;
      width: 100% !important;
    }
    .conf-actions .bx {
      width: 100% !important;
      display: block !important;
      box-sizing: border-box !important;
    }
  }

  /* Print Stylesheet */
  @media print {
    header, footer, .no-print, .msw { display: none !important; }
    body { background: #FFFFFF !important; color: #000000 !important; }
    .conf-container { padding: 0 !important; max-width: 100% !important; }
    .conf-card { border: 2px solid #000000 !important; background: #FFFFFF !important; color: #000000 !important; page-break-inside: avoid; }
    .ticket-card { border: 2px dashed #000000 !important; background: #FFFFFF !important; color: #000000 !important; page-break-after: always; }
    .ticket-stub::before, .ticket-stub::after { background: #FFFFFF !important; border: 1px solid #000 !important; }
    * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
  }
</style>

<!-- Minimal Site Header -->
<header style="background:rgba(10,15,38,0.92); border-bottom:1px solid #1E2B5E; padding:18px 24px; display:flex; align-items:center; justify-content:space-between; box-sizing:border-box; width:100%;" class="no-print">
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="text-decoration:none;">
    <span class="bebas" style="font-size:26px; color:#F4F5FA; letter-spacing:1px;">CRUX<span style="color:#5B8DEF;">NXTION</span></span>
  </a>
  <div style="display:flex; gap:20px; align-items:center;">
    <a href="<?php echo esc_url( home_url( '/events/' ) ); ?>" style="font-size:14px; font-weight:600; color:#D5D9EA;">&larr; <?php esc_html_e( 'All Events', 'cruxnxtion' ); ?></a>
  </div>
</header>

<main class="conf-container">

<?php
// =============================================================================
// VIEW 1: INDIVIDUAL TICKET QR VERIFICATION (DOOR SCAN / ATTENDEE PASS)
// =============================================================================
if ( 'verify_ticket' === $view_mode ) :
	$is_secret_valid = '' !== $req_ticket_code && '' !== $req_tix_secret && cr8v_tix_verify_ticket_secret( $req_ticket_code, $req_tix_secret );
	// A valid secret is not enough: the ticket must actually exist.
	$ticket_found = '' !== $req_ticket_code ? cr8v_tix_find_ticket( $req_ticket_code ) : null;

	// Lookup order containing this ticket
	$order_match = null;
	$tix_record  = null;

	if ( $is_secret_valid && $ticket_found ) {
		$order_match = get_post( $ticket_found['order_id'] );
		$tix_record  = $ticket_found['ticket'];
	}


	$v_event_id    = $order_match ? (int) get_post_meta( $order_match->ID, '_cr8v_order_event_id', true ) : 0;
	$v_event       = $v_event_id ? get_post( $v_event_id ) : null;
	$v_event_title = $v_event ? sanitize_text_field( $v_event->post_title ) : __( 'Crux Nxtion Event', 'cruxnxtion' );
	$v_venue       = (string) get_post_meta( $v_event_id, '_cr8v_event_venue', true );
	$v_date_raw    = (string) get_post_meta( $v_event_id, '_cr8v_event_date', true );
	// Show a readable date (the stored value is Y-m-d).
	if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $v_date_raw ) ) {
		$v_date_raw = wp_date( 'l, j F Y', strtotime( $v_date_raw . ' 12:00:00' ) );
	}
	$v_time        = (string) get_post_meta( $v_event_id, '_cr8v_event_time', true );
?>

	<?php if ( ! empty( $checkin_message ) ) : ?>
		<div style="background:<?php echo 'success' === $checkin_status ? '#155724' : ( 'warning' === $checkin_status ? '#856404' : '#721c24' ); ?>; color:#FFFFFF; padding:16px 20px; border-radius:8px; margin-bottom:24px; font-weight:700;">
			<?php echo esc_html( $checkin_message ); ?>
		</div>
	<?php endif; ?>

	<?php if ( current_user_can( 'edit_event_orders' ) ) : ?>
		<div style="background:rgba(91,141,239,0.12); border:1px solid #1E2B5E; border-radius:8px; padding:12px 18px; margin-bottom:20px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;" class="no-print">
			<span style="font-size:13px; color:#5B8DEF; font-weight:700;">
				✓ <?php esc_html_e( 'You are logged in as door staff.', 'cruxnxtion' ); ?>
			</span>
			<a href="<?php echo esc_url( $staff_landing_url ); ?>" style="font-size:13px; color:#D5D9EA; text-decoration:underline; font-weight:600;">
				&larr; <?php esc_html_e( 'Back to Door Staff Check-In', 'cruxnxtion' ); ?>
			</a>
		</div>
	<?php endif; ?>

	<div class="conf-card" style="text-align:center;">
		<?php if ( ! $ticket_found && ( $is_secret_valid || $staff_lookup ) ) : ?>
			<div class="staff-result-card" style="border:2px solid #dc3545; background:#1A0709; border-radius:14px; padding:28px 20px; box-shadow:0 4px 24px rgba(220,53,69,0.15);">
				<div style="display:inline-block; width:80px; height:80px; border-radius:50%; background:rgba(220,53,69,0.2); border:2px solid #dc3545; line-height:80px; font-size:36px; margin-bottom:18px; color:#FF2E3D;">✕</div>
				<div class="eyebrow" style="color:#FF2E3D; font-size:12px; letter-spacing:2px;"><?php esc_html_e( 'DO NOT ADMIT', 'cruxnxtion' ); ?></div>
				<h1 class="bebas" style="font-size:42px; margin:10px 0; color:#FFFFFF;"><?php esc_html_e( 'TICKET NOT FOUND', 'cruxnxtion' ); ?></h1>
				<div style="background:rgba(220,53,69,0.18); border-left:4px solid #dc3545; border-radius:6px; padding:14px 16px; margin:18px auto 24px; max-width:520px; text-align:left; font-size:14px; color:#F4F5FA; line-height:1.5;">
					<strong style="color:#FF2E3D;"><?php esc_html_e( 'Reason:', 'cruxnxtion' ); ?></strong>
					<?php
					if ( '' !== $ticket_raw ) {
						/* translators: %s: ticket code string */
						echo ' ' . sprintf( esc_html__( 'No ticket with code "%s" exists in the database. Check the code and try again. If it is correct, this is not a valid ticket.', 'cruxnxtion' ), esc_html( $ticket_raw ) );
					} else {
						esc_html_e( 'No ticket with this code exists. Check the code and try again. If it is correct, this is not a valid ticket.', 'cruxnxtion' );
					}
					?>
				</div>
				<?php if ( current_user_can( 'edit_event_orders' ) ) : ?>
					<a href="<?php echo esc_url( $staff_landing_url ); ?>" class="bx no-print" style="display:block; width:100%; max-width:400px; margin:0 auto; background:#dc3545; color:#FFFFFF; font-weight:700; font-size:15px; padding:15px 24px; min-height:48px; box-sizing:border-box; text-decoration:none; text-transform:uppercase; --sl:8px;">
						<?php esc_html_e( 'Scan next →', 'cruxnxtion' ); ?>
					</a>
				<?php endif; ?>
			</div>
		<?php elseif ( ! $is_secret_valid ) : ?>
			<div class="staff-result-card" style="border:2px solid #dc3545; background:#1A0709; border-radius:14px; padding:28px 20px; box-shadow:0 4px 24px rgba(220,53,69,0.15);">
				<div style="display:inline-block; width:80px; height:80px; border-radius:50%; background:rgba(220,53,69,0.2); border:2px solid #dc3545; line-height:80px; font-size:36px; margin-bottom:18px; color:#FF2E3D;">✕</div>
				<div class="eyebrow" style="color:#FF2E3D; font-size:12px; letter-spacing:2px;"><?php esc_html_e( 'AUTHENTICATION FAILED', 'cruxnxtion' ); ?></div>
				<h1 class="bebas" style="font-size:42px; margin:10px 0; color:#FFFFFF;"><?php esc_html_e( 'INVALID TICKET TOKEN', 'cruxnxtion' ); ?></h1>
				<div style="background:rgba(220,53,69,0.18); border-left:4px solid #dc3545; border-radius:6px; padding:14px 16px; margin:18px auto 24px; max-width:520px; text-align:left; font-size:14px; color:#F4F5FA; line-height:1.5;">
					<strong style="color:#FF2E3D;"><?php esc_html_e( 'Reason:', 'cruxnxtion' ); ?></strong>
					<?php esc_html_e( 'The ticket cryptographic secret does not match. This ticket pass is invalid or has been tampered with.', 'cruxnxtion' ); ?>
				</div>
				<?php if ( current_user_can( 'edit_event_orders' ) ) : ?>
					<a href="<?php echo esc_url( $staff_landing_url ); ?>" class="bx no-print" style="display:block; width:100%; max-width:400px; margin:0 auto; background:#dc3545; color:#FFFFFF; font-weight:700; font-size:15px; padding:15px 24px; min-height:48px; box-sizing:border-box; text-decoration:none; text-transform:uppercase; --sl:8px;">
						<?php esc_html_e( 'Scan next →', 'cruxnxtion' ); ?>
					</a>
				<?php endif; ?>
			</div>
		<?php elseif ( ! empty( $tix_record['void'] ) ) : ?>
			<div class="staff-result-card" style="border:2px solid #dc3545; background:#1A0709; border-radius:14px; padding:28px 20px; box-shadow:0 4px 24px rgba(220,53,69,0.15);">
				<div style="display:inline-block; width:80px; height:80px; border-radius:50%; background:rgba(220,53,69,0.2); border:2px solid #dc3545; line-height:80px; font-size:36px; margin-bottom:18px;">⛔</div>
				<div class="eyebrow" style="color:#dc3545; font-size:12px; letter-spacing:2px;"><?php esc_html_e( 'TICKET VOIDED', 'cruxnxtion' ); ?></div>
				<h1 class="bebas" style="font-size:42px; margin:10px 0; color:#FFFFFF;"><?php esc_html_e( 'TICKET REFUNDED OR CANCELLED', 'cruxnxtion' ); ?></h1>
				<div style="background:rgba(220,53,69,0.18); border-left:4px solid #dc3545; border-radius:6px; padding:14px 16px; margin:18px auto 24px; max-width:520px; text-align:left; font-size:14px; color:#F4F5FA; line-height:1.5;">
					<strong style="color:#FF2E3D;"><?php esc_html_e( 'Reason:', 'cruxnxtion' ); ?></strong>
					<?php esc_html_e( 'This ticket was refunded or voided. It is no longer valid for venue entry.', 'cruxnxtion' ); ?>
				</div>
				<?php if ( current_user_can( 'edit_event_orders' ) ) : ?>
					<a href="<?php echo esc_url( $staff_landing_url ); ?>" class="bx no-print" style="display:block; width:100%; max-width:400px; margin:0 auto; background:#dc3545; color:#FFFFFF; font-weight:700; font-size:15px; padding:15px 24px; min-height:48px; box-sizing:border-box; text-decoration:none; text-transform:uppercase; --sl:8px;">
						<?php esc_html_e( 'Scan next →', 'cruxnxtion' ); ?>
					</a>
				<?php endif; ?>
			</div>
		<?php elseif ( 'success' === $checkin_status ) : ?>
			<?php
			$checkin_time_display   = ! empty( $tix_record['checked_in_at'] ) ? $tix_record['checked_in_at'] : current_time( 'mysql' );
			$checkin_time_formatted = ( 'Door' !== $checkin_time_display && false !== strtotime( $checkin_time_display ) ) ? wp_date( 'g:i A, j F Y', strtotime( $checkin_time_display ) ) : $checkin_time_display;
			$attendee_display       = ! empty( $tix_record['attendee_name'] ) ? $tix_record['attendee_name'] : 'Guest';
			$tier_display           = ! empty( $tix_record['tier_name'] ) ? $tix_record['tier_name'] : 'General';
			?>
			<div class="staff-result-card" style="border:2px solid #28a745; background:#071D0F; border-radius:14px; padding:28px 20px; box-shadow:0 4px 24px rgba(40,167,69,0.15);">
				<div style="display:inline-block; width:80px; height:80px; border-radius:50%; background:rgba(40,167,69,0.25); border:2px solid #28a745; line-height:80px; font-size:36px; margin-bottom:18px; color:#28a745;">✓</div>
				<div class="eyebrow" style="color:#28a745; font-size:12px; letter-spacing:2px;"><?php esc_html_e( 'DOOR CHECK-IN SUCCESSFUL', 'cruxnxtion' ); ?></div>
				<h1 class="bebas" style="font-size:46px; margin:8px 0 6px 0; color:#FFFFFF;"><?php esc_html_e( 'CHECKED IN', 'cruxnxtion' ); ?></h1>
				<div style="font-size:14px; color:#A3A9C8; margin-bottom:20px; word-break:break-word; line-height:1.5;">
					<?php echo esc_html( $v_event_title ); ?>
				</div>

				<a href="<?php echo esc_url( $staff_landing_url ); ?>" class="bx no-print" style="display:block; width:100%; max-width:400px; margin:0 auto 22px; background:#28a745; color:#FFFFFF; font-weight:700; font-size:16px; padding:16px 24px; min-height:48px; box-sizing:border-box; text-decoration:none; text-transform:uppercase; --sl:8px;">
					<?php esc_html_e( 'Scan next →', 'cruxnxtion' ); ?>
				</a>

				<div class="door-verify-box" style="background:#0D1330; border:1px solid #1E2B5E; border-radius:12px; padding:20px; max-width:520px; margin:0 auto 24px; text-align:left; box-sizing:border-box;">
					<div style="display:flex; justify-content:space-between; margin-bottom:12px; border-bottom:1px solid #1E2B5E; padding-bottom:10px;">
						<span style="color:#7A82A8; font-size:13px;"><?php esc_html_e( 'Attendee Name:', 'cruxnxtion' ); ?></span>
						<strong style="color:#FFFFFF; font-size:15px;"><?php echo esc_html( $attendee_display ); ?></strong>
					</div>
					<div style="display:flex; justify-content:space-between; margin-bottom:12px; border-bottom:1px solid #1E2B5E; padding-bottom:10px;">
						<span style="color:#7A82A8; font-size:13px;"><?php esc_html_e( 'Ticket Tier:', 'cruxnxtion' ); ?></span>
						<strong style="color:#5B8DEF; font-size:14px;"><?php echo esc_html( $tier_display ); ?></strong>
					</div>
					<div style="display:flex; justify-content:space-between; margin-bottom:12px; border-bottom:1px solid #1E2B5E; padding-bottom:10px;">
						<span style="color:#7A82A8; font-size:13px;"><?php esc_html_e( 'Check-In Time:', 'cruxnxtion' ); ?></span>
						<strong style="color:#28a745; font-size:14px;"><?php echo esc_html( $checkin_time_formatted ); ?></strong>
					</div>
					<div style="display:flex; justify-content:space-between; margin-bottom:12px; border-bottom:1px solid #1E2B5E; padding-bottom:10px;">
						<span style="color:#7A82A8; font-size:13px;"><?php esc_html_e( 'Pass Code:', 'cruxnxtion' ); ?></span>
						<code style="color:#FFFFFF; font-weight:700;"><?php echo esc_html( $req_ticket_code ); ?></code>
					</div>
					<div style="display:flex; justify-content:space-between;">
						<span style="color:#7A82A8; font-size:13px;"><?php esc_html_e( 'Gate Status:', 'cruxnxtion' ); ?></span>
						<span style="color:#28a745; font-weight:700;"><?php esc_html_e( 'ADMITTED • PASS VERIFIED', 'cruxnxtion' ); ?></span>
					</div>
				</div>

				
			</div>
		<?php elseif ( ! empty( $tix_record['checked_in'] ) ) : ?>
			<?php
			$checkin_time_display   = ! empty( $tix_record['checked_in_at'] ) ? $tix_record['checked_in_at'] : 'Door';
			$checkin_time_formatted = ( 'Door' !== $checkin_time_display && false !== strtotime( $checkin_time_display ) ) ? wp_date( 'g:i A, j F Y', strtotime( $checkin_time_display ) ) : $checkin_time_display;
			$attendee_display       = ! empty( $tix_record['attendee_name'] ) ? $tix_record['attendee_name'] : 'Guest';
			$tier_display           = ! empty( $tix_record['tier_name'] ) ? $tix_record['tier_name'] : 'General';
			?>
			<div class="staff-result-card" style="border:2px solid #ffc107; background:#1C1604; border-radius:14px; padding:28px 20px; box-shadow:0 4px 24px rgba(255,193,7,0.15);">
				<div style="display:inline-block; width:80px; height:80px; border-radius:50%; background:rgba(255,193,7,0.2); border:2px solid #ffc107; line-height:80px; font-size:36px; margin-bottom:18px;">⚠️</div>
				<div class="eyebrow" style="color:#ffc107; font-size:12px; letter-spacing:2px;"><?php echo current_user_can( 'edit_event_orders' ) ? esc_html__( 'DO NOT ADMIT • DUPLICATE ENTRY', 'cruxnxtion' ) : esc_html__( 'TICKET ALREADY USED', 'cruxnxtion' ); ?></div>
				<h1 class="bebas" style="font-size:44px; margin:8px 0 6px 0; color:#FFFFFF;"><?php esc_html_e( 'ALREADY CHECKED IN', 'cruxnxtion' ); ?></h1>
				<div style="font-size:14px; color:#A3A9C8; margin-bottom:18px; word-break:break-word; line-height:1.5;">
					<?php echo esc_html( $v_event_title ); ?>
				</div>

				<div style="background:rgba(255,193,7,0.18); border-left:4px solid #ffc107; border-radius:6px; padding:14px 16px; margin:0 auto 20px; max-width:520px; text-align:left; font-size:14px; color:#F4F5FA; line-height:1.5;">
					<strong style="color:#ffc107;"><?php esc_html_e( 'Reason:', 'cruxnxtion' ); ?></strong>
					<?php
					/* translators: %s: check-in timestamp */
					echo ' ' . sprintf( current_user_can( 'edit_event_orders' ) ? esc_html__( 'This ticket was already checked in at %s. Do not admit a duplicate entry.', 'cruxnxtion' ) : esc_html__( 'This ticket was checked in at %s.', 'cruxnxtion' ), esc_html( $checkin_time_formatted ) );
					?>
				</div>

				<?php if ( current_user_can( 'edit_event_orders' ) ) : ?>
					<a href="<?php echo esc_url( $staff_landing_url ); ?>" class="bx no-print" style="display:block; width:100%; max-width:400px; margin:0 auto 22px; background:#ffc107; color:#0A0F26; font-weight:700; font-size:16px; padding:16px 24px; min-height:48px; box-sizing:border-box; text-decoration:none; text-transform:uppercase; --sl:8px;">
						<?php esc_html_e( 'Scan next →', 'cruxnxtion' ); ?>
					</a>
				<?php endif; ?>

				<div class="door-verify-box" style="background:#0D1330; border:1px solid #1E2B5E; border-radius:12px; padding:20px; max-width:520px; margin:0 auto 24px; text-align:left; box-sizing:border-box;">
					<div style="display:flex; justify-content:space-between; margin-bottom:12px; border-bottom:1px solid #1E2B5E; padding-bottom:10px;">
						<span style="color:#7A82A8; font-size:13px;"><?php esc_html_e( 'Attendee Name:', 'cruxnxtion' ); ?></span>
						<strong style="color:#FFFFFF; font-size:15px;"><?php echo esc_html( $attendee_display ); ?></strong>
					</div>
					<div style="display:flex; justify-content:space-between; margin-bottom:12px; border-bottom:1px solid #1E2B5E; padding-bottom:10px;">
						<span style="color:#7A82A8; font-size:13px;"><?php esc_html_e( 'Ticket Tier:', 'cruxnxtion' ); ?></span>
						<strong style="color:#5B8DEF; font-size:14px;"><?php echo esc_html( $tier_display ); ?></strong>
					</div>
					<div style="display:flex; justify-content:space-between; margin-bottom:12px; border-bottom:1px solid #1E2B5E; padding-bottom:10px;">
						<span style="color:#7A82A8; font-size:13px;"><?php esc_html_e( 'Checked In At:', 'cruxnxtion' ); ?></span>
						<strong style="color:#ffc107; font-size:14px;"><?php echo esc_html( $checkin_time_formatted ); ?></strong>
					</div>
					<div style="display:flex; justify-content:space-between; margin-bottom:12px; border-bottom:1px solid #1E2B5E; padding-bottom:10px;">
						<span style="color:#7A82A8; font-size:13px;"><?php esc_html_e( 'Pass Code:', 'cruxnxtion' ); ?></span>
						<code style="color:#FFFFFF; font-weight:700;"><?php echo esc_html( $req_ticket_code ); ?></code>
					</div>
					<div style="display:flex; justify-content:space-between;">
						<span style="color:#7A82A8; font-size:13px;"><?php esc_html_e( 'Gate Status:', 'cruxnxtion' ); ?></span>
						<span style="color:#ffc107; font-weight:700;"><?php echo sprintf( esc_html__( 'Already Checked In (%s)', 'cruxnxtion' ), esc_html( $checkin_time_formatted ) ); ?></span>
					</div>
				</div>

				
			</div>
		<?php else : ?>
			<div style="display:inline-block; width:72px; height:72px; border-radius:50%; background:rgba(40,167,69,0.2); border:2px solid #28a745; line-height:72px; font-size:32px; margin-bottom:18px; color:#28a745;">✓</div>

			<div class="eyebrow" style="color:#28a745;">
				<?php esc_html_e( 'OFFICIAL VERIFIED PASS', 'cruxnxtion' ); ?>
			</div>

			<h1 class="bebas" style="font-size:38px; margin:10px 0 6px 0; color:#FFFFFF;"><?php echo esc_html( $v_event_title ); ?></h1>
			<div style="font-size:14px; color:#A3A9C8; margin-bottom:24px; word-break:break-word; line-height:1.5;">
				<?php echo esc_html( $v_date_raw . ( $v_time ? ' • ' . $v_time : '' ) . ( $v_venue ? ' • ' . $v_venue : '' ) ); ?>
			</div>

			<div class="door-verify-box" style="background:#0D1330; border:1px solid #1E2B5E; border-radius:12px; padding:24px; max-width:520px; margin:0 auto 28px; text-align:left; box-sizing:border-box;">
				<div style="display:flex; justify-content:space-between; margin-bottom:12px; border-bottom:1px solid #1E2B5E; padding-bottom:10px;">
					<span style="color:#7A82A8; font-size:13px;"><?php esc_html_e( 'Attendee Name:', 'cruxnxtion' ); ?></span>
					<strong style="color:#FFFFFF;"><?php echo esc_html( $tix_record['attendee_name'] ?? 'Guest' ); ?></strong>
				</div>
				<div style="display:flex; justify-content:space-between; margin-bottom:12px; border-bottom:1px solid #1E2B5E; padding-bottom:10px;">
					<span style="color:#7A82A8; font-size:13px;"><?php esc_html_e( 'Ticket Tier:', 'cruxnxtion' ); ?></span>
					<strong style="color:#5B8DEF;"><?php echo esc_html( $tix_record['tier_name'] ?? 'General' ); ?></strong>
				</div>
				<div style="display:flex; justify-content:space-between; margin-bottom:12px; border-bottom:1px solid #1E2B5E; padding-bottom:10px;">
					<span style="color:#7A82A8; font-size:13px;"><?php esc_html_e( 'Pass Code:', 'cruxnxtion' ); ?></span>
					<code style="color:#FFFFFF; font-weight:700;"><?php echo esc_html( $req_ticket_code ); ?></code>
				</div>
				<div style="display:flex; justify-content:space-between;">
					<span style="color:#7A82A8; font-size:13px;"><?php esc_html_e( 'Gate Status:', 'cruxnxtion' ); ?></span>
					<span style="color:#28a745; font-weight:700;"><?php esc_html_e( 'VALID FOR ENTRY', 'cruxnxtion' ); ?></span>
				</div>
			</div>

			<!-- Staff Door Check-In Action Button -->
			<?php if ( current_user_can( 'edit_event_orders' ) || current_user_can( 'manage_options' ) ) : ?>
				<form method="post" style="max-width:400px; margin:0 auto;" class="no-print">
					<?php wp_nonce_field( 'cr8v_checkin_' . $req_ticket_code, '_cr8v_checkin_nonce' ); ?>
					<input type="hidden" name="ticket_code" value="<?php echo esc_attr( $req_ticket_code ); ?>">
					<input type="hidden" name="ticket_secret" value="<?php echo esc_attr( $req_tix_secret ); ?>">
					<input type="hidden" name="order_id" value="<?php echo esc_attr( $order_match ? $order_match->ID : 0 ); ?>">
					<input type="hidden" name="cr8v_do_checkin" value="1">
					<button type="submit" class="bx" style="width:100%; min-height:48px; display:block; background:#28a745; color:#FFFFFF; font-weight:700; font-size:16px; padding:15px 24px; --sl:8px; box-sizing:border-box;">
						<?php esc_html_e( '✓ CONFIRM DOOR CHECK-IN', 'cruxnxtion' ); ?>
					</button>
				</form>
			<?php else : ?>
				<p style="font-size:12.5px; color:#7A82A8;">
					<?php esc_html_e( 'Door staff: log in to your account to record check-in attendance.', 'cruxnxtion' ); ?>
				</p>
			<?php endif; ?>
		<?php endif; ?>
	</div>

<?php
// =============================================================================
// VIEW 2: BARE SESSION_ID RETURN (SECURITY GATE - DO NOT DISPLAY TICKETS)
// =============================================================================
elseif ( 'bare_session' === $view_mode ) :
	$o_email = $order_post ? (string) get_post_meta( $order_post->ID, '_cr8v_order_customer_email', true ) : '';
	$o_name  = $order_post ? (string) get_post_meta( $order_post->ID, '_cr8v_order_customer_name', true ) : '';
	$o_ev_id = $order_post ? (int) get_post_meta( $order_post->ID, '_cr8v_order_event_id', true ) : 0;
	$o_event = $o_ev_id ? get_post( $o_ev_id ) : null;

	// Mask email address for security: j***@domain.com
	$masked_email = '';
	if ( $o_email ) {
		$e_parts = explode( '@', $o_email );
		$name_part = $e_parts[0] ?? '';
		$domain_part = $e_parts[1] ?? '';
		$masked_email = substr( $name_part, 0, 1 ) . '***@' . $domain_part;
	}
?>

	<div class="conf-card" style="text-align:center;">
		<div style="display:inline-block; width:64px; height:64px; border-radius:50%; background:rgba(91,141,239,0.15); border:2px solid #5B8DEF; line-height:64px; font-size:28px; margin-bottom:18px;">✓</div>
		<div class="eyebrow" style="color:#5B8DEF;"><?php esc_html_e( 'PAYMENT RECEIVED', 'cruxnxtion' ); ?></div>
		<h1 class="bebas" style="font-size:42px; margin:10px 0; color:#FFFFFF;"><?php esc_html_e( 'BOOKING CONFIRMED', 'cruxnxtion' ); ?></h1>
		
		<?php if ( $o_event ) : ?>
			<h2 style="font-size:20px; font-weight:700; color:#D5D9EA; margin:0 0 18px 0;"><?php echo esc_html( $o_event->post_title ); ?></h2>
		<?php endif; ?>

		<div style="background:#0D1330; border:1px solid #1E2B5E; border-radius:12px; padding:24px; max-width:600px; margin:0 auto 28px; text-align:left;">
			<div style="font-size:14.5px; line-height:1.7; color:#D5D9EA;">
				<strong style="color:#5B8DEF; display:block; margin-bottom:6px;"><?php esc_html_e( 'SECURITY & TICKET DISPATCH NOTICE', 'cruxnxtion' ); ?></strong>
				<?php esc_html_e( 'Your payment was confirmed. For your security and ticket protection, digital passes with scannable QR codes are never displayed directly on payment return links.', 'cruxnxtion' ); ?>
			</div>
			<div style="margin-top:16px; padding-top:14px; border-top:1px solid #1E2B5E; font-size:14px; color:#A3A9C8;">
				<?php if ( $masked_email ) : ?>
					<?php echo sprintf( esc_html__( 'Your verified tickets and scannable QR passes have been sent to %s.', 'cruxnxtion' ), '<strong style="color:#FFFFFF;">' . esc_html( $masked_email ) . '</strong>' ); ?>
				<?php else : ?>
					<?php esc_html_e( 'Your verified tickets have been dispatched to the email address provided during checkout.', 'cruxnxtion' ); ?>
				<?php endif; ?>
				<br><span style="font-size:12.5px; color:#7A82A8;"><?php esc_html_e( 'Please check your inbox (and junk / spam folder) to view and download your tickets.', 'cruxnxtion' ); ?></span>
			</div>
		</div>

		<div style="display:flex; justify-content:center; gap:14px; flex-wrap:wrap;" class="no-print">
			<?php if ( $o_ev_id ) : ?>
				<a href="<?php echo esc_url( add_query_arg( array( 'cr8v_tix_download_ics' => '1', 'event_id' => $o_ev_id ), home_url( '/' ) ) ); ?>" class="bx" style="background:#002671; border:1px solid #5B8DEF; color:#FFFFFF; font-weight:700; font-size:14px; padding:14px 24px; --sl:8px;">
					📅 <?php esc_html_e( 'Add to Calendar (.ics)', 'cruxnxtion' ); ?>
				</a>
			<?php endif; ?>
			<a href="<?php echo esc_url( home_url( '/events/' ) ); ?>" class="bx" style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:14px; padding:14px 24px; --sl:8px;">
				<?php esc_html_e( 'Explore More Events →', 'cruxnxtion' ); ?>
			</a>
		</div>
	</div>

<?php
// =============================================================================
// VIEW 3: FULL VERIFIED ORDER PASSES (ORDER_TOKEN VERIFIED)
// =============================================================================
elseif ( 'order_confirmed' === $view_mode && $order_post ) :
	$o_id       = $order_post->ID;
	$o_status   = get_post_meta( $o_id, '_cr8v_order_status', true ) ?: 'pending';
	$o_ev_id    = (int) get_post_meta( $o_id, '_cr8v_order_event_id', true );
	$o_event    = $o_ev_id ? get_post( $o_ev_id ) : null;
	$o_name     = sanitize_text_field( (string) get_post_meta( $o_id, '_cr8v_order_customer_name', true ) );
	$o_email    = sanitize_email( (string) get_post_meta( $o_id, '_cr8v_order_customer_email', true ) );
	$o_total    = (int) get_post_meta( $o_id, '_cr8v_order_total_pence', true );
	$o_tickets  = get_post_meta( $o_id, '_cr8v_order_tickets', true );

	$ev_title   = $o_event ? sanitize_text_field( $o_event->post_title ) : __( 'Crux Nxtion Event', 'cruxnxtion' );
	$ev_date    = (string) get_post_meta( $o_ev_id, '_cr8v_event_date', true );
	// Show a readable date (the stored value is Y-m-d).
	if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $ev_date ) ) {
		$ev_date = wp_date( 'l, j F Y', strtotime( $ev_date . ' 12:00:00' ) );
	}
	$ev_time    = (string) get_post_meta( $o_ev_id, '_cr8v_event_time', true );
	$ev_venue   = (string) get_post_meta( $o_ev_id, '_cr8v_event_venue', true );
	$ev_loc     = (string) get_post_meta( $o_ev_id, '_cr8v_event_location', true );
	$ev_place   = trim( $ev_venue . ( ( $ev_venue && $ev_loc ) ? ', ' : '' ) . $ev_loc );
	$order_ref  = strtoupper( substr( $req_order_token, 4, 8 ) );
?>

	<?php if ( 'completed' !== $o_status ) : ?>
		<div class="conf-card" style="text-align:center;">
			<div class="eyebrow" style="color:#ffc107;"><?php esc_html_e( 'STATUS UPDATE', 'cruxnxtion' ); ?></div>
			<h1 class="bebas" style="font-size:36px; margin:10px 0; color:#FFFFFF;"><?php echo esc_html( strtoupper( $o_status ) ); ?></h1>
			<p style="font-size:15px; color:#A3A9C8; max-width:550px; margin:0 auto 20px; line-height:1.6;">
				<?php if ( 'pending' === $o_status || 'awaiting_payment' === $o_status ) : ?>
					<?php esc_html_e( 'Your order is currently processing. As soon as Stripe confirms payment, your verified tickets will appear here.', 'cruxnxtion' ); ?>
				<?php else : ?>
					<?php esc_html_e( 'This order is not completed. Any held tickets have been released.', 'cruxnxtion' ); ?>
				<?php endif; ?>
			</p>
			<a href="<?php echo esc_url( home_url( '/events/' ) ); ?>" class="bx" style="display:inline-block; background:#BA0000; color:#FFFFFF; font-weight:700; padding:12px 24px; --sl:8px;">
				&larr; <?php esc_html_e( 'Return to Events', 'cruxnxtion' ); ?>
			</a>
		</div>
	<?php else : ?>

		<!-- Success Banner Header -->
		<div class="conf-card" style="padding:28px 36px;">
			<div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:16px;">
				<div>
					<span class="eyebrow"><?php esc_html_e( 'ORDER CONFIRMED & ISSUED', 'cruxnxtion' ); ?></span>
					<h1 class="bebas" style="font-size:38px; margin:8px 0 4px 0; color:#FFFFFF;"><?php echo esc_html( $ev_title ); ?></h1>
					<p style="font-size:14.5px; color:#A3A9C8; margin:0;">
						<?php echo esc_html( $ev_date . ( $ev_time ? ' • ' . $ev_time : '' ) . ( $ev_place ? ' • ' . $ev_place : '' ) ); ?>
					</p>
				</div>
				<div style="text-align:right;" class="no-print">
					<div style="font-size:12px; color:#7A82A8; text-transform:uppercase; letter-spacing:1px;"><?php esc_html_e( 'Order Reference', 'cruxnxtion' ); ?></div>
					<div style="font-size:20px; font-weight:700; color:#5B8DEF; font-family:monospace;">#<?php echo esc_html( $order_ref ); ?></div>
				</div>
			</div>

			<!-- Customer and Order summary bar -->
			<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:16px; margin-top:24px; padding-top:20px; border-top:1px solid #1E2B5E; font-size:13.5px;">
				<div><span style="color:#7A82A8;"><?php esc_html_e( 'Primary Contact:', 'cruxnxtion' ); ?></span> <strong style="color:#FFFFFF;"><?php echo esc_html( $o_name ); ?></strong></div>
				<div><span style="color:#7A82A8;"><?php esc_html_e( 'Email:', 'cruxnxtion' ); ?></span> <strong style="color:#FFFFFF;"><?php echo esc_html( $o_email ); ?></strong></div>
				<div><span style="color:#7A82A8;"><?php esc_html_e( 'Total Paid:', 'cruxnxtion' ); ?></span> <strong style="color:#28a745;"><?php echo 0 === $o_total ? esc_html__( 'Free RSVP', 'cruxnxtion' ) : '£' . esc_html( number_format( $o_total / 100, 2 ) ); ?></strong></div>
			</div>

			<!-- Action Toolbar -->
			<div class="conf-actions no-print" style="display:flex; gap:12px; margin-top:24px; flex-wrap:wrap;">
				<?php if ( $o_ev_id ) : ?>
					<a href="<?php echo esc_url( add_query_arg( array( 'cr8v_tix_download_ics' => '1', 'event_id' => $o_ev_id ), home_url( '/' ) ) ); ?>" class="bx" style="background:#002671; border:1px solid #5B8DEF; color:#FFFFFF; font-weight:700; font-size:13.5px; padding:12px 20px; --sl:8px;">
						📅 <?php esc_html_e( 'Add to Calendar (.ics)', 'cruxnxtion' ); ?>
					</a>
				<?php endif; ?>
				<button type="button" onclick="window.print()" class="bx" style="background:#1E2B5E; color:#FFFFFF; font-weight:700; font-size:13.5px; padding:12px 20px; --sl:8px;">
					🖶 <?php esc_html_e( 'Print Ticket Passes', 'cruxnxtion' ); ?>
				</button>
			</div>
		</div>

		<!-- List of Issued Tickets -->
		<h2 class="bebas" style="font-size:28px; margin:32px 0 18px 0; color:#FFFFFF;"><?php esc_html_e( 'INDIVIDUAL TICKET PASSES', 'cruxnxtion' ); ?></h2>

		<?php if ( is_array( $o_tickets ) && ! empty( $o_tickets ) ) : ?>
			<div style="display:flex; flex-direction:column; gap:20px;">
				<?php foreach ( $o_tickets as $idx => $tix ) :
					$t_code   = sanitize_text_field( $tix['ticket_code'] ?? '' );
					$t_tier   = sanitize_text_field( $tix['tier_name'] ?? 'General Admission' );
					$t_guest  = sanitize_text_field( $tix['attendee_name'] ?? $o_name );
					$t_qr_url = function_exists( 'cr8v_tix_ticket_qr_link' ) ? cr8v_tix_ticket_qr_link( $t_code ) : home_url( '/booking-confirmation/?cr8v_ticket=' . $t_code );
					$is_void  = ! empty( $tix['void'] );
					$is_in    = ! empty( $tix['checked_in'] );
				?>
				<div class="ticket-card" style="display:flex; background:#111838; border:1.5px solid #1E2B5E; border-radius:12px; overflow:hidden; min-height:180px;">
					<!-- Notch Stub -->
					<div class="ticket-stub" style="flex:0 0 100px; background:#002671; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:12px; text-align:center;">
						<span style="font-size:10px; font-weight:800; letter-spacing:1px; color:#5B8DEF; text-transform:uppercase;"><?php esc_html_e( 'PASS', 'cruxnxtion' ); ?></span>
						<span class="bebas" style="font-size:32px; color:#FFFFFF; line-height:1; margin:6px 0;"><?php echo esc_html( '#' . ( $idx + 1 ) ); ?></span>
						<span style="font-size:9px; color:#A3A9C8; font-family:monospace;"><?php echo esc_html( substr( $t_code, 4, 6 ) ); ?></span>
					</div>

					<!-- Details -->
					<div class="ticket-details" style="flex:1; padding:24px 28px; display:flex; flex-direction:column; justify-content:center; min-width:0;">
						<div style="font-size:11px; font-weight:700; color:#5B8DEF; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;"><?php echo esc_html( $t_tier ); ?></div>
						<h3 style="font-size:22px; margin:0 0 8px 0; color:#FFFFFF; font-weight:700;"><?php echo esc_html( $t_guest ); ?></h3>
						<div style="font-size:13px; color:#A3A9C8; font-family:monospace; margin-bottom:12px;">
							<?php esc_html_e( 'Ticket Code:', 'cruxnxtion' ); ?> <strong style="color:#FFFFFF;"><?php echo esc_html( $t_code ); ?></strong>
						</div>
						<div>
							<?php if ( $is_void ) : ?>
								<span style="display:inline-block; padding:4px 10px; background:#721c24; color:#FFFFFF; font-size:11px; font-weight:700; border-radius:4px; text-transform:uppercase;"><?php esc_html_e( 'VOID / REFUNDED', 'cruxnxtion' ); ?></span>
							<?php elseif ( $is_in ) : ?>
								<span style="display:inline-block; padding:4px 10px; background:#856404; color:#FFFFFF; font-size:11px; font-weight:700; border-radius:4px; text-transform:uppercase;"><?php echo sprintf( esc_html__( 'CHECKED IN (%s)', 'cruxnxtion' ), esc_html( $tix['checked_in_at'] ?? 'Door' ) ); ?></span>
							<?php else : ?>
								<span style="display:inline-block; padding:4px 10px; background:#155724; color:#FFFFFF; font-size:11px; font-weight:700; border-radius:4px; text-transform:uppercase;"><?php esc_html_e( 'VALID PASS', 'cruxnxtion' ); ?></span>
							<?php endif; ?>
						</div>
					</div>

					<!-- QR Code Area -->
					<div class="ticket-qr-area" style="flex:0 0 180px; padding:20px; display:flex; flex-direction:column; align-items:center; justify-content:center; border-left:1.5px dashed #1E2B5E; background:#0D1330;">
						<?php if ( function_exists( 'cr8v_tix_render_svg_qr' ) ) : ?>
							<?php echo cr8v_tix_render_svg_qr( $t_qr_url, 130 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php endif; ?>
						<a href="<?php echo esc_url( $t_qr_url ); ?>" style="font-size:10px; color:#5B8DEF; margin-top:8px; text-transform:uppercase; letter-spacing:0.5px; font-weight:700;" class="no-print" target="_blank" rel="noopener">
							<?php esc_html_e( 'Verify Link →', 'cruxnxtion' ); ?>
						</a>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	<?php endif; ?>

<?php
// =============================================================================
// VIEW 4: DEFAULT FALLBACK (NO PARAMETERS)
// =============================================================================
else :
?>

	<?php if ( current_user_can( 'edit_event_orders' ) ) :
		$current_staff = wp_get_current_user();
	?>
		<!-- Staff Door Check-In Control Center -->
		<div class="conf-card" style="text-align:left; border:2px solid #5B8DEF; background:#0D163F; padding:32px;">
			<div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; border-bottom:1px solid #1E2B5E; padding-bottom:16px; margin-bottom:20px;">
				<div style="display:flex; align-items:center; gap:10px;">
					<span style="display:inline-block; width:12px; height:12px; border-radius:50%; background:#28a745; box-shadow:0 0 8px #28a745;"></span>
					<span style="font-size:12.5px; font-weight:700; color:#5B8DEF; text-transform:uppercase; letter-spacing:1.5px;">
						<?php esc_html_e( 'Door Check-In Active', 'cruxnxtion' ); ?>
					</span>
				</div>
				<div style="font-size:13px; color:#A3A9C8;">
					<?php echo sprintf( esc_html__( 'Logged in as %s', 'cruxnxtion' ), '<strong style="color:#FFFFFF;">' . esc_html( $current_staff->display_name ?: $current_staff->user_login ) . '</strong>' ); ?>
					&bull; <a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>" style="color:#FF8A8A; font-weight:600; text-decoration:underline; padding:8px 0; display:inline-block;"><?php esc_html_e( 'Log out', 'cruxnxtion' ); ?></a>
				</div>
			</div>

			<div style="background:rgba(91,141,239,0.12); border-left:4px solid #5B8DEF; padding:16px 20px; margin-bottom:28px; border-radius:4px;">
				<h2 style="font-size:18px; margin:0 0 6px 0; color:#FFFFFF; font-weight:700;">
					<?php esc_html_e( 'You are logged in as door staff.', 'cruxnxtion' ); ?>
				</h2>
				<p style="margin:0; font-size:14px; color:#D5D9EA; line-height:1.5;">
					<?php esc_html_e( 'Scan an attendee’s QR pass with your mobile camera to verify and check them in automatically, or look up their ticket code below to confirm entry.', 'cruxnxtion' ); ?>
				</p>
			</div>

			<form method="GET" action="<?php echo esc_url( $staff_landing_url ); ?>" style="max-width:540px; width:100%;">
				<label for="cr8v_staff_tix_input" style="display:block; font-size:12.5px; font-weight:700; color:#D5D9EA; margin-bottom:10px; text-transform:uppercase; letter-spacing:0.5px;">
					<?php esc_html_e( 'Manual Ticket Code Lookup:', 'cruxnxtion' ); ?>
				</label>
				<div style="display:flex; flex-direction:column; gap:12px; width:100%;">
					<input type="text" id="cr8v_staff_tix_input" name="cr8v_ticket" placeholder="TIX-XXXXXXXXXXXX" required style="width:100%; min-height:48px; height:52px; padding:12px 16px; background:#0A0F26; border:1.5px solid #1E2B5E; border-radius:6px; color:#FFFFFF; font-family:monospace; font-size:16px; font-weight:600; text-transform:uppercase; box-sizing:border-box;" autocomplete="off" autocorrect="off" autocapitalize="characters" inputmode="text" spellcheck="false">
					<button type="submit" class="bx" style="width:100%; min-height:48px; display:block; background:#002671; border:1px solid #5B8DEF; color:#FFFFFF; font-weight:700; font-size:15px; padding:14px 24px; --sl:8px; box-sizing:border-box;">
						<?php esc_html_e( 'Look Up Ticket →', 'cruxnxtion' ); ?>
					</button>
				</div>
			</form>
		</div>
	<?php else : ?>
		<div class="conf-card" style="text-align:center;">
			<div class="eyebrow"><?php esc_html_e( 'TICKET PORTAL', 'cruxnxtion' ); ?></div>
			<h1 class="bebas" style="font-size:38px; margin:10px 0; color:#FFFFFF;"><?php esc_html_e( 'BOOKING LOOKUP', 'cruxnxtion' ); ?></h1>
			<p style="font-size:15px; color:#A3A9C8; max-width:550px; margin:0 auto 28px; line-height:1.6;">
				<?php esc_html_e( 'No booking reference was provided. If you recently purchased tickets, please check the link sent to your confirmation email or browse upcoming events below.', 'cruxnxtion' ); ?>
			</p>
			<a href="<?php echo esc_url( home_url( '/events/' ) ); ?>" class="bx" style="display:inline-block; background:#BA0000; color:#FFFFFF; font-weight:700; font-size:14.5px; padding:15px 32px; --sl:10px;">
				<?php esc_html_e( 'Explore All Events →', 'cruxnxtion' ); ?>
			</a>
		</div>
	<?php endif; ?>

<?php endif; ?>

</main>

<footer style="background:#0A0F26; border-top:1px solid #1E2B5E; padding:32px 24px; text-align:center; font-size:13px; color:#7A82A8; box-sizing:border-box; width:100%;" class="no-print">
  &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Crux Nxtion Events &bull; Sheffield &amp; London, United Kingdom &bull; All Rights Reserved
</footer>

<?php wp_footer(); ?>
</body>
</html>
