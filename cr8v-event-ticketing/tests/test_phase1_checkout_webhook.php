<?php
// End-to-end checks for checkout + webhook. Uses a throw-away event and removes everything it creates.
define( 'CRUX_STRIPE_WEBHOOK_SECRET', 'whsec_test_not_a_real_secret' );
require __DIR__ . '/bootstrap.php';
global $wpdb;

$pass = 0; $fail = 0;
function t( $name, $ok, $detail = '' ) {
	global $pass, $fail;
	if ( $ok ) { $pass++; echo "PASS  $name\n"; } else { $fail++; echo "FAIL  $name  $detail\n"; }
}
function post_checkout( $params ) {
	$req = new WP_REST_Request( 'POST', '/cr8v-ticketing/v1/checkout' );
	foreach ( $params as $k => $v ) { $req->set_param( $k, $v ); }
	return rest_do_request( $req );
}
function post_webhook( $payload, $secret = 'whsec_test_not_a_real_secret', $ts = null, $sig_override = null ) {
	$ts   = $ts ?? time();
	$body = wp_json_encode( $payload );
	$sig  = $sig_override ?? hash_hmac( 'sha256', $ts . '.' . $body, $secret );
	$req  = new WP_REST_Request( 'POST', '/cr8v-ticketing/v1/stripe-webhook' );
	$req->set_body( $body );
	$req->set_header( 'stripe_signature', "t={$ts},v1={$sig}" );
	return rest_do_request( $req );
}
function clear_rate() {
	delete_transient( 'cr8v_rate_' . md5( $_SERVER['REMOTE_ADDR'] ) );
}

// ---- Fixture: event with a free tier (cap 3, max 5) and a paid tier (cap 10, £25)
$eid = wp_insert_post( array( 'post_type' => 'event', 'post_title' => 'ZZ E2E TEST EVENT', 'post_status' => 'publish' ) );
update_post_meta( $eid, '_cr8v_event_ticket_tiers', array(
	array( 'id' => 'tier_free', 'name' => 'Free RSVP', 'description' => '', 'price_pence' => 0,    'capacity' => 3,  'max_per_order' => 5, 'status' => 'active' ),
	array( 'id' => 'tier_paid', 'name' => 'Standard',  'description' => '', 'price_pence' => 2500, 'capacity' => 10, 'max_per_order' => 4, 'status' => 'active' ),
) );
$cust = array( 'event_id' => $eid, 'customer_name' => 'Test Buyer', 'customer_email' => 'e2e-buyer@example.com', 'customer_phone' => '07000000000' );
$created_orders = array();

echo "== Checkout validation\n";
clear_rate();
$r = post_checkout( $cust + array( 'items' => array( array( 'tier_id' => 'tier_free', 'quantity' => 6 ) ) ) );
t( 'quantity above tier max_per_order is rejected', 400 === $r->get_status(), 'status ' . $r->get_status() );

clear_rate();
$r = post_checkout( $cust + array( 'items' => array( array( 'tier_id' => 'tier_free', 'quantity' => 3 ), array( 'tier_id' => 'tier_free', 'quantity' => 3 ) ) ) );
t( 'same tier sent twice cannot bypass max_per_order (merged to 6)', 400 === $r->get_status(), 'status ' . $r->get_status() );

clear_rate();
$r = post_checkout( $cust + array( 'website' => 'http://spam.example', 'items' => array( array( 'tier_id' => 'tier_free', 'quantity' => 1 ) ) ) );
t( 'honeypot field rejects bots', 400 === $r->get_status(), 'status ' . $r->get_status() );

clear_rate();
$r = post_checkout( array_merge( $cust, array( 'customer_email' => 'not-an-email', 'items' => array( array( 'tier_id' => 'tier_free', 'quantity' => 1 ) ) ) ) );
t( 'invalid email rejected', 400 === $r->get_status() );

clear_rate();
$r = post_checkout( $cust + array( 'items' => array( array( 'tier_id' => 'tier_does_not_exist', 'quantity' => 1 ) ) ) );
t( 'unknown tier rejected', 400 === $r->get_status() );

clear_rate();
$r = post_checkout( $cust + array( 'items' => array( array( 'tier_id' => 'tier_paid', 'quantity' => 1, 'price' => 1 ) ) ) );
t( 'paid order without a Stripe key returns 503 and takes no stock', 503 === $r->get_status(), 'status ' . $r->get_status() );
$held = (int) $wpdb->get_var( $wpdb->prepare( 'SELECT COALESCE(SUM(quantity),0) FROM ' . cr8v_tix_reservations_table() . " WHERE event_id=%d AND tier_id='tier_paid'", $eid ) );
t( '  ...and no reservation row was written', 0 === $held, "held=$held" );

echo "== Free RSVP flow\n";
clear_rate();
delete_transient( 'cr8v_free_' . md5( 'e2e-buyer@example.com|' . $eid ) );
$r = post_checkout( $cust + array( 'items' => array( array( 'tier_id' => 'tier_free', 'quantity' => 2 ) ) ) );
$d = $r->get_data();
t( 'free RSVP for 2 succeeds', 200 === $r->get_status() && ! empty( $d['is_free'] ), 'status ' . $r->get_status() . ' ' . wp_json_encode( $d ) );
$order = get_posts( array( 'post_type' => 'event_order', 'post_status' => 'any', 'posts_per_page' => 1, 'meta_key' => '_cr8v_order_event_id', 'meta_value' => $eid, 'fields' => 'ids' ) );
$oid = $order ? (int) $order[0] : 0; $created_orders[] = $oid;
$tix = $oid ? get_post_meta( $oid, '_cr8v_order_tickets', true ) : array();
t( 'two tickets issued', is_array( $tix ) && 2 === count( $tix ) );
t( 'ticket secret verifies for the real code', ! empty( $tix[0] ) && cr8v_tix_verify_ticket_secret( $tix[0]['ticket_code'], cr8v_tix_ticket_secret( $tix[0]['ticket_code'] ) ) );
t( 'ticket secret does NOT verify for a forged value', ! empty( $tix[0] ) && ! cr8v_tix_verify_ticket_secret( $tix[0]['ticket_code'], 'forged' ) );
t( 'order total is 0 and status completed', 0 === (int) get_post_meta( $oid, '_cr8v_order_total_pence', true ) && 'completed' === get_post_meta( $oid, '_cr8v_order_status', true ) );

clear_rate();
$r = post_checkout( array_merge( $cust, array( 'customer_email' => 'second@example.com', 'items' => array( array( 'tier_id' => 'tier_free', 'quantity' => 2 ) ) ) ) );
t( 'second RSVP for 2 is refused (only 1 free ticket left)', 409 === $r->get_status(), 'status ' . $r->get_status() );

clear_rate();
$r = post_checkout( array_merge( $cust, array( 'customer_email' => 'third@example.com', 'items' => array( array( 'tier_id' => 'tier_free', 'quantity' => 1 ) ) ) ) );
t( 'last free ticket can still be taken', 200 === $r->get_status() );
$order2 = get_posts( array( 'post_type' => 'event_order', 'post_status' => 'any', 'posts_per_page' => 5, 'meta_key' => '_cr8v_order_customer_email', 'meta_value' => 'third@example.com', 'fields' => 'ids' ) );
foreach ( $order2 as $o ) { $created_orders[] = (int) $o; }
clear_rate();
$r = post_checkout( array_merge( $cust, array( 'customer_email' => 'fourth@example.com', 'items' => array( array( 'tier_id' => 'tier_free', 'quantity' => 1 ) ) ) ) );
t( 'event is now sold out for the free tier', 409 === $r->get_status(), 'status ' . $r->get_status() );

// Per-email limit
$k = 'cr8v_free_' . md5( 'spammer@example.com|' . $eid ); set_transient( $k, 3, HOUR_IN_SECONDS );
clear_rate();
$r = post_checkout( array_merge( $cust, array( 'customer_email' => 'spammer@example.com', 'items' => array( array( 'tier_id' => 'tier_free', 'quantity' => 1 ) ) ) ) );
t( 'same email cannot make more than 3 free bookings per hour', 429 === $r->get_status(), 'status ' . $r->get_status() );
delete_transient( $k );

// Rate limit
set_transient( 'cr8v_rate_' . md5( $_SERVER['REMOTE_ADDR'] ), 15, 300 );
$r = post_checkout( $cust + array( 'items' => array( array( 'tier_id' => 'tier_free', 'quantity' => 1 ) ) ) );
t( 'per-IP rate limit returns 429', 429 === $r->get_status(), 'status ' . $r->get_status() );
clear_rate();

echo "== Webhook\n";
// Paid order fixture (what checkout stores after Stripe returns a session)
$res_token = 'res_' . bin2hex( random_bytes( 8 ) );
$items     = array( array( 'tier_id' => 'tier_paid', 'tier_name' => 'Standard', 'quantity' => 2, 'unit_price_pence' => 2500, 'total_pence' => 5000 ) );
cr8v_tix_atomic_reserve_stock( $eid, $items, $res_token, 2100 );
$paid_oid = cr8v_tix_create_order( $eid, 'Paid Buyer', 'paid@example.com', '', 5000, 'pending', $items, $res_token );
$created_orders[] = $paid_oid;
$sess = 'cs_test_' . bin2hex( random_bytes( 6 ) );
update_post_meta( $paid_oid, '_cr8v_order_stripe_session_id', $sess );
$wpdb->update( cr8v_tix_reservations_table(), array( 'session_id' => $sess, 'order_id' => $paid_oid ), array( 'session_id' => $res_token ) );

$session = array( 'id' => $sess, 'object' => 'checkout.session', 'payment_status' => 'paid', 'amount_total' => 5000, 'currency' => 'gbp', 'payment_intent' => 'pi_test_123', 'metadata' => array( 'order_id' => (string) $paid_oid ), 'client_reference_id' => (string) $paid_oid );
$evt = function ( $id, $type, $obj ) { return array( 'id' => $id, 'type' => $type, 'data' => array( 'object' => $obj ) ); };

$r = post_webhook( $evt( 'evt_bad_sig', 'checkout.session.completed', $session ), 'whsec_test_not_a_real_secret', null, str_repeat( 'a', 64 ) );
t( 'wrong signature rejected with 400', 400 === $r->get_status(), 'status ' . $r->get_status() );
$r = post_webhook( $evt( 'evt_old', 'checkout.session.completed', $session ), 'whsec_test_not_a_real_secret', time() - 3600 );
t( 'stale timestamp rejected with 400', 400 === $r->get_status(), 'status ' . $r->get_status() );
$r = post_webhook( $evt( 'evt_wrong_secret', 'checkout.session.completed', $session ), 'whsec_attacker_guess' );
t( 'payload signed with a different secret rejected', 400 === $r->get_status() );
t( 'rejected events did not touch the order', 'pending' === get_post_meta( $paid_oid, '_cr8v_order_status', true ) );

// Amount mismatch must not issue tickets
$bad = $session; $bad['amount_total'] = 100;
$r = post_webhook( $evt( 'evt_mismatch', 'checkout.session.completed', $bad ) );
t( 'amount mismatch accepted (200) but flagged needs_review', 200 === $r->get_status() && 'needs_review' === get_post_meta( $paid_oid, '_cr8v_order_status', true ), get_post_meta( $paid_oid, '_cr8v_order_status', true ) );
t( '  ...and no tickets were issued', empty( get_post_meta( $paid_oid, '_cr8v_order_tickets', true ) ) );
update_post_meta( $paid_oid, '_cr8v_order_status', 'pending' );

// Unpaid session must not issue tickets
$unpaid = $session; $unpaid['payment_status'] = 'unpaid';
$r = post_webhook( $evt( 'evt_unpaid', 'checkout.session.completed', $unpaid ) );
t( 'unpaid completed session does not issue tickets', 'awaiting_payment' === get_post_meta( $paid_oid, '_cr8v_order_status', true ) && empty( get_post_meta( $paid_oid, '_cr8v_order_tickets', true ) ) );
update_post_meta( $paid_oid, '_cr8v_order_status', 'pending' );

// Failure then retry: the claim must be released so Stripe's retry is processed
$boom = function () { throw new Exception( 'simulated email failure' ); };
add_action( 'cr8v_tix_order_completed', $boom );
$r = post_webhook( $evt( 'evt_retry', 'checkout.session.completed', $session ) );
t( 'processing failure returns 500 so Stripe retries', 500 === $r->get_status(), 'status ' . $r->get_status() );
$claim = (int) $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM ' . cr8v_tix_webhooks_table() . ' WHERE stripe_event_id=%s', 'evt_retry' ) );
t( '  ...and the idempotency claim was released', 0 === $claim, "claim rows=$claim" );
remove_action( 'cr8v_tix_order_completed', $boom );
update_post_meta( $paid_oid, '_cr8v_order_status', 'pending' );
delete_post_meta( $paid_oid, '_cr8v_order_tickets' );
$r = post_webhook( $evt( 'evt_retry', 'checkout.session.completed', $session ) );
t( 'the retry of the same event is now processed (order completed)', 200 === $r->get_status() && 'completed' === get_post_meta( $paid_oid, '_cr8v_order_status', true ), 'status ' . $r->get_status() );
$ptix = get_post_meta( $paid_oid, '_cr8v_order_tickets', true );
t( '  ...2 tickets issued', is_array( $ptix ) && 2 === count( $ptix ) );
$comp = (int) $wpdb->get_var( $wpdb->prepare( 'SELECT COALESCE(SUM(quantity),0) FROM ' . cr8v_tix_reservations_table() . " WHERE session_id=%s AND status='completed'", $sess ) );
t( '  ...stock hold converted to a completed sale', 2 === $comp, "completed=$comp" );

// Duplicate delivery
$count = 0; add_action( 'cr8v_tix_order_completed', function () use ( &$count ) { $count++; } );
$r = post_webhook( $evt( 'evt_retry', 'checkout.session.completed', $session ) );
$d = $r->get_data();
t( 'duplicate delivery returns already_processed', 200 === $r->get_status() && 'already_processed' === ( $d['status'] ?? '' ) );
$r = post_webhook( $evt( 'evt_dup_new_id', 'checkout.session.completed', $session ) );
t( 'same session under a new event id does not re-fulfil (no second email hook)', 0 === $count );
t( '  ...and ticket count is unchanged', 2 === count( get_post_meta( $paid_oid, '_cr8v_order_tickets', true ) ) );

// Refunds
$r = post_webhook( $evt( 'evt_partial', 'charge.refunded', array( 'payment_intent' => 'pi_test_123', 'amount' => 5000, 'amount_refunded' => 2500 ) ) );
t( 'partial refund marks partially_refunded and keeps tickets valid', 'partially_refunded' === get_post_meta( $paid_oid, '_cr8v_order_status', true ) && empty( get_post_meta( $paid_oid, '_cr8v_order_tickets', true )[0]['void'] ) );
$r = post_webhook( $evt( 'evt_full', 'charge.refunded', array( 'payment_intent' => 'pi_test_123', 'amount' => 5000, 'amount_refunded' => 5000 ) ) );
t( 'full refund marks refunded and voids tickets', 'refunded' === get_post_meta( $paid_oid, '_cr8v_order_status', true ) && ! empty( get_post_meta( $paid_oid, '_cr8v_order_tickets', true )[0]['void'] ) );

// Expiry releases stock
$res2 = 'res_' . bin2hex( random_bytes( 8 ) );
cr8v_tix_atomic_reserve_stock( $eid, array( array( 'tier_id' => 'tier_paid', 'quantity' => 3 ) ), $res2, 2100 );
$sess2 = 'cs_test_' . bin2hex( random_bytes( 6 ) );
$wpdb->update( cr8v_tix_reservations_table(), array( 'session_id' => $sess2 ), array( 'session_id' => $res2 ) );
$tiers = cr8v_tix_get_event_tiers( $eid, true );
$before = $tiers['tier_paid']['available_count'];
post_webhook( $evt( 'evt_expired', 'checkout.session.expired', array( 'id' => $sess2 ) ) );
$tiers = cr8v_tix_get_event_tiers( $eid, true );
t( 'expired checkout session releases its held stock', $tiers['tier_paid']['available_count'] === $before + 3, 'before ' . $before . ' after ' . $tiers['tier_paid']['available_count'] );

echo "== Order privacy\n";
$pto = get_post_type_object( 'event_order' );
t( 'order post type is not public and not in REST', ! $pto->public && ! $pto->show_in_rest && ! $pto->publicly_queryable );
t( 'order post type uses its own capabilities', 'edit_event_orders' === $pto->cap->edit_posts, $pto->cap->edit_posts );
$contrib = get_role( 'contributor' ); $author = get_role( 'author' ); $editor = get_role( 'editor' ); $admin = get_role( 'administrator' );
t( 'Contributor, Author and Editor cannot read orders', ! $contrib->has_cap( 'edit_event_orders' ) && ! $author->has_cap( 'edit_event_orders' ) && ! $editor->has_cap( 'edit_event_orders' ) );
t( 'Administrator can manage orders', $admin->has_cap( 'edit_event_orders' ) );
t( 'nobody was granted the do_not_allow capability', ! $admin->has_cap( 'do_not_allow' ) );

echo "== Cleanup\n";
foreach ( array_filter( array_unique( $created_orders ) ) as $o ) { wp_delete_post( $o, true ); }
$wpdb->delete( cr8v_tix_reservations_table(), array( 'event_id' => $eid ) );
wp_delete_post( $eid, true );
foreach ( array( 'evt_bad_sig', 'evt_old', 'evt_wrong_secret', 'evt_mismatch', 'evt_unpaid', 'evt_retry', 'evt_dup_new_id', 'evt_partial', 'evt_full', 'evt_expired' ) as $e ) {
	$wpdb->delete( cr8v_tix_webhooks_table(), array( 'stripe_event_id' => $e ) );
}
echo "\nRESULT: $pass passed, $fail failed\n";
