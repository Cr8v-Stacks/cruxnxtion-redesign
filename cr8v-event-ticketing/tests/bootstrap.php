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