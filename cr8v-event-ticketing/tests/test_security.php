<?php
/**
 * Account and sign-in security tests.
 *
 * Question answered: what stops a door staff member from becoming (or signing in as) an administrator, and
 * what stops a stranger from guessing their way in?
 *
 *   php cr8v-event-ticketing/tests/test_security.php
 */
require __DIR__ . '/bootstrap.php';
require_once ABSPATH . 'wp-admin/includes/admin.php';
global $wpdb;

$pass = 0;
$fail = 0;
function t( $name, $ok, $detail = '' ) {
	global $pass, $fail;
	if ( $ok ) { $pass++; echo "PASS  $name\n"; } else { $fail++; echo "FAIL  $name  $detail\n"; }
}

$mk = function ( $login, $role ) {
	$old = get_user_by( 'login', $login );
	if ( $old ) { wp_delete_user( $old->ID ); }
	$id = wp_insert_user( array( 'user_login' => $login, 'user_pass' => 'Zz-Pass-' . wp_generate_password( 12, false ), 'user_email' => $login . '@example.com', 'role' => $role ) );
	return new WP_User( $id );
};
$known_pass = 'Correct-Horse-Battery-9!';
$staff = $mk( 'zz_sec_staff', 'event_staff' );
$admin = $mk( 'zz_sec_admin', 'administrator' );
wp_set_password( $known_pass, $staff->ID );

echo "== 1. A staff member cannot become an administrator\n";
foreach ( array( 'promote_users', 'promote_user', 'edit_users', 'create_users', 'delete_users', 'list_users', 'manage_options', 'activate_plugins', 'install_plugins', 'edit_plugins', 'switch_themes', 'edit_theme_options', 'unfiltered_html', 'upload_files', 'edit_posts', 'edit_pages', 'publish_posts', 'manage_woocommerce', 'export', 'import' ) as $cap ) {
	$args = in_array( $cap, array( 'promote_user' ), true ) ? array( $cap, $admin->ID ) : array( $cap );
	t( "staff does not hold: $cap", ! call_user_func_array( 'user_can', array_merge( array( $staff ), $args ) ) );
}
t( 'staff role holds exactly two capabilities (read, edit_event_orders)', array( 'read', 'edit_event_orders' ) === array_keys( array_filter( get_role( 'event_staff' )->capabilities ) ) );
t( 'staff cannot edit, promote or delete the administrator account', ! user_can( $staff, 'edit_user', $admin->ID ) && ! user_can( $staff, 'promote_user', $admin->ID ) && ! user_can( $staff, 'delete_user', $admin->ID ) );

// Real attempts through the REST API, signed in as the staff member (this is what a stolen staff login could try).
wp_set_current_user( $staff->ID );
$attempt = function ( $method, $route, $params ) {
	$req = new WP_REST_Request( $method, $route );
	foreach ( $params as $k => $v ) { $req->set_param( $k, $v ); }
	return rest_do_request( $req );
};
$r = $attempt( 'POST', '/wp/v2/users/' . $staff->ID, array( 'roles' => array( 'administrator' ) ) );
t( 'staff asking the API to make THEMSELVES an administrator is refused (' . $r->get_status() . ')', in_array( $r->get_status(), array( 401, 403 ), true ) );
t( '...and the role did not change', in_array( 'event_staff', (array) ( new WP_User( $staff->ID ) )->roles, true ) && ! in_array( 'administrator', (array) ( new WP_User( $staff->ID ) )->roles, true ) );
$r = $attempt( 'POST', '/wp/v2/users/' . $admin->ID, array( 'password' => 'Hacked-Password-1!' ) );
t( "staff changing the administrator's password through the API is refused (" . $r->get_status() . ')', in_array( $r->get_status(), array( 401, 403 ), true ) );
$r = $attempt( 'POST', '/wp/v2/users', array( 'username' => 'zz_sec_new_admin', 'email' => 'zz_sec_new_admin@example.com', 'password' => 'Hacked-Password-1!', 'roles' => array( 'administrator' ) ) );
t( 'staff creating a brand new administrator through the API is refused (' . $r->get_status() . ')', in_array( $r->get_status(), array( 401, 403 ), true ) && ! get_user_by( 'login', 'zz_sec_new_admin' ) );
$r = $attempt( 'DELETE', '/wp/v2/users/' . $admin->ID, array( 'force' => true, 'reassign' => $staff->ID ) );
t( 'staff deleting the administrator through the API is refused (' . $r->get_status() . ')', in_array( $r->get_status(), array( 401, 403 ), true ) && (bool) get_user_by( 'id', $admin->ID ) );
$r = $attempt( 'GET', '/wp/v2/plugins', array() );
t( 'staff cannot list or manage plugins through the API (' . $r->get_status() . ')', in_array( $r->get_status(), array( 401, 403, 404 ), true ) );

echo "== 2. Usernames are not handed to strangers\n";
wp_set_current_user( 0 );
$r = $attempt( 'GET', '/wp/v2/users', array() );
t( 'a visitor cannot list users through the API (' . $r->get_status() . ')', in_array( $r->get_status(), array( 401, 403, 404 ), true ), (string) wp_json_encode( $r->get_data() ) );
wp_set_current_user( $admin->ID );
$r = $attempt( 'GET', '/wp/v2/users', array() );
t( 'a signed-in administrator still can (the editor needs it)', 200 === $r->get_status() );
wp_set_current_user( 0 );

$curl = ( DIRECTORY_SEPARATOR === '\\' ) ? 'curl.exe' : 'curl';
$nul  = ( DIRECTORY_SEPARATOR === '\\' ) ? 'NUL' : '/dev/null';
$head = function ( $url ) use ( $curl, $nul ) {
	$f = wp_tempnam();
	shell_exec( $curl . ' -s -D ' . escapeshellarg( $f ) . ' -o ' . $nul . ' --max-time 40 ' . escapeshellarg( $url ) );
	$h = file_exists( $f ) ? (string) file_get_contents( $f ) : '';
	@unlink( $f ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
	return $h;
};
$h = $head( home_url( '/?author=1' ) );
t( 'over real HTTP, /?author=1 no longer redirects to the username address', (bool) preg_match( '#^HTTP/\S+\s+(301|302)#m', $h ) && ! preg_match( '#^Location:[^\r\n]*/author/#mi', $h ), $h );
$h = $head( home_url( '/wp-json/wp/v2/users' ) );
t( 'over real HTTP, /wp-json/wp/v2/users does not list users to a visitor', ! preg_match( '#^HTTP/\S+\s+200#m', $h ), $h );

echo "== 3. XML-RPC (bulk password guessing) is off\n";
t( 'xmlrpc_enabled filter returns false', false === apply_filters( 'xmlrpc_enabled', true ) );
$f = wp_tempnam();
file_put_contents( $f, "<?xml version='1.0'?><methodCall><methodName>wp.getUsersBlogs</methodName><params><param><value>zz_sec_staff</value></param><param><value>x</value></param></params></methodCall>" );
$body = (string) shell_exec( $curl . ' -s --max-time 40 -X POST -H "Content-Type: text/xml" --data-binary @' . escapeshellarg( $f ) . ' ' . escapeshellarg( home_url( '/xmlrpc.php' ) ) );
@unlink( $f ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
t( 'over real HTTP, a login attempt through xmlrpc.php is refused as disabled', false !== stripos( $body, 'disabled' ) || false !== stripos( $body, 'faultCode' ), $body );

echo "== 4. Password guessing is stopped\n";
$_SERVER['REMOTE_ADDR'] = '203.0.113.77';
$clear = function ( $login, $ip ) {
	$old = $_SERVER['REMOTE_ADDR'];
	$_SERVER['REMOTE_ADDR'] = $ip;
	delete_transient( cr8v_sec_login_key( $login ) );
	$_SERVER['REMOTE_ADDR'] = $old;
};
$clear( 'zz_sec_staff', '203.0.113.77' );
$clear( 'zz_sec_staff', '203.0.113.78' );
$clear( 'zz_sec_admin', '203.0.113.77' );

for ( $i = 1; $i <= 4; $i++ ) { wp_authenticate( 'zz_sec_staff', 'wrong-guess-' . $i ); }
$ok4 = wp_authenticate( 'zz_sec_staff', $known_pass );
t( 'four wrong guesses do not lock, and the right password then signs in', $ok4 instanceof WP_User );
$clear( 'zz_sec_staff', '203.0.113.77' );

for ( $i = 1; $i <= 5; $i++ ) { wp_authenticate( 'zz_sec_staff', 'wrong-guess-' . $i ); }
$locked = wp_authenticate( 'zz_sec_staff', $known_pass );
t( 'after five wrong guesses even the CORRECT password is refused (locked)', is_wp_error( $locked ) && 'cr8v_locked' === $locked->get_error_code() );
t( 'the lock message is shown to the guesser', is_wp_error( $locked ) && false !== strpos( $locked->get_error_message(), '15 minutes' ) );

$other_user = wp_authenticate( 'zz_sec_admin', 'wrong-guess' );
t( 'a different account from the same address is not locked by that', is_wp_error( $other_user ) && 'cr8v_locked' !== $other_user->get_error_code() );

$_SERVER['REMOTE_ADDR'] = '203.0.113.78';
$other_ip = wp_authenticate( 'zz_sec_staff', $known_pass );
t( 'the real owner, signing in from a different address, is not locked out by a stranger', $other_ip instanceof WP_User );
$_SERVER['REMOTE_ADDR'] = '203.0.113.77';

$state1 = get_transient( cr8v_sec_login_key( 'zz_sec_staff' ) );
wp_authenticate( 'zz_sec_staff', 'still-guessing' );
$state2 = get_transient( cr8v_sec_login_key( 'zz_sec_staff' ) );
t( 'further attempts while locked do not extend the lock', $state1['until'] === $state2['until'] && $state1['count'] === $state2['count'] );

// Expire the lock, as the clock would.
set_transient( cr8v_sec_login_key( 'zz_sec_staff' ), array( 'count' => 5, 'until' => time() - 1 ), 900 );
$back = wp_authenticate( 'zz_sec_staff', $known_pass );
t( 'once the lock time has passed the correct password works again', $back instanceof WP_User );
do_action( 'wp_login', 'zz_sec_staff', $back ); // wp_signon (the real sign-in) fires this; wp_authenticate alone does not.
t( 'a successful sign-in clears the failure count', false === get_transient( cr8v_sec_login_key( 'zz_sec_staff' ) ) );

echo "== 5. The sign-in form does not reveal which usernames exist\n";
global $errors;
$errors = new WP_Error( 'invalid_username', 'Unknown username.' );
$m1 = cr8v_sec_generic_login_error( 'Error: The username zz is not registered on this site.' );
$errors = new WP_Error( 'incorrect_password', 'Wrong password for zz_sec_staff.' );
$m2 = cr8v_sec_generic_login_error( 'Error: The password you entered for the username zz_sec_staff is incorrect.' );
t( '"no such user" and "wrong password" show the same message', $m1 === $m2 && false !== strpos( $m1, 'username or password is incorrect' ) );
$errors = new WP_Error( 'cr8v_locked', 'Too many failed sign-in attempts.' );
t( 'the lock message is kept as it is', 'KEEP' === cr8v_sec_generic_login_error( 'KEEP' ) );
$errors = null;

echo "== 6. Every check-in records WHO did it\n";
$event = wp_insert_post( array( 'post_type' => 'event', 'post_title' => 'ZZ SEC EVENT', 'post_status' => 'publish' ) );
$items = array( array( 'tier_id' => 'tier_free', 'tier_name' => 'Free', 'quantity' => 1, 'unit_price_pence' => 0, 'total_pence' => 0 ) );
$order = cr8v_tix_create_order( $event, 'Door Guest', 'zz-sec-guest@example.com', '', 0, 'completed', $items, 'res_' . bin2hex( random_bytes( 6 ) ) );
$tix   = cr8v_tix_issue_tickets( $order, $items, 'Door Guest' );
$code  = $tix[0]['ticket_code'];
wp_set_current_user( $staff->ID );
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = array( 'cr8v_do_checkin' => '1', 'ticket_code' => $code, 'ticket_secret' => cr8v_tix_ticket_secret( $code ), 'order_id' => $order, '_cr8v_checkin_nonce' => wp_create_nonce( 'cr8v_checkin_' . $code ) );
$_GET  = array( 'cr8v_ticket' => $code );
$grab  = function () { throw new RuntimeException( 'redirect' ); };
add_filter( 'wp_redirect', $grab, 1, 2 );
ob_start();
try { include get_template_directory() . '/page-booking-confirmation.php'; } catch ( RuntimeException $e ) { /* redirected, as expected */ }
ob_end_clean();
remove_filter( 'wp_redirect', $grab, 1 );
$_POST = array(); $_GET = array(); $_SERVER['REQUEST_METHOD'] = 'GET';
$after = get_post_meta( $order, '_cr8v_order_tickets', true );
t( 'the ticket records which staff member checked it in', ! empty( $after[0]['checked_in'] ) && (int) $staff->ID === (int) ( $after[0]['checked_in_by'] ?? 0 ) );
wp_set_current_user( $admin->ID );
$csv = cr8v_tix_build_attendee_csv( $event );
t( 'the attendee export has a "Checked In By" column with that person', false !== strpos( $csv, 'Checked In By' ) && false !== strpos( $csv, $staff->display_name ) );
ob_start();
cr8v_tix_render_order_details_meta_box( get_post( $order ) );
$screen = ob_get_clean();
t( 'the order screen shows "by <name>" next to the check-in time', false !== strpos( $screen, 'by ' . $staff->display_name ) );

echo "== Cleanup\n";
wp_delete_post( $order, true );
wp_delete_post( $event, true );
$wpdb->delete( cr8v_tix_reservations_table(), array( 'event_id' => $event ) );
foreach ( array( '203.0.113.77', '203.0.113.78' ) as $ip ) { foreach ( array( 'zz_sec_staff', 'zz_sec_admin' ) as $u ) { $clear( $u, $ip ); } }
wp_set_current_user( 0 );
require_once ABSPATH . 'wp-admin/includes/user.php';
wp_delete_user( $staff->ID );
wp_delete_user( $admin->ID );
t( 'no test accounts left behind', ! get_user_by( 'login', 'zz_sec_staff' ) && ! get_user_by( 'login', 'zz_sec_admin' ) );
echo "\nRESULT: $pass passed, $fail failed\n";
exit( $fail ? 1 : 0 );
