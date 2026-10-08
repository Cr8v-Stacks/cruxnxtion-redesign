<?php
/**
 * Test bootstrap: loads WordPress for command-line tests. Set CR8V_WP_LOAD to the path of wp-load.php if
 * your site is elsewhere. Run with the LocalWP PHP and the flags shown in tests/README.md.
 */
$_SERVER['HTTP_HOST']   = 'dev-playground.local';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['REMOTE_ADDR'] = '203.0.113.' . ( getmypid() % 250 );
define( 'WP_USE_THEMES', false );
require getenv( 'CR8V_WP_LOAD' ) ?: 'C:/Users/user/Local Sites/dev-playground/app/public/wp-load.php';

/**
 * Remove automated-test accounts left behind by a run that crashed before it could tidy up.
 * Only accounts that match BOTH a test username prefix and an example email address, and that are more than
 * ten minutes old (so a suite that is running right now is never affected). Real accounts never match.
 */
function cr8v_tests_remove_stale_test_users() {
	require_once ABSPATH . 'wp-admin/includes/user.php';
	$cutoff = gmdate( 'Y-m-d H:i:s', time() - 600 );
	foreach ( get_users( array( 'fields' => 'all' ) ) as $u ) {
		if ( $u->user_registered < $cutoff
			&& preg_match( '/^(mobstaff_|staff2_|staff_|sub_|editor_|zz_)/', $u->user_login )
			&& preg_match( '/@example\.(com|test)$/', $u->user_email ) ) {
			wp_delete_user( $u->ID );
		}
	}
}
// Only the test suites sweep (race workers and helper scripts do not).
if ( isset( $argv[0] ) && 0 === strpos( basename( (string) $argv[0] ), 'test_' ) ) {
	cr8v_tests_remove_stale_test_users();
}
