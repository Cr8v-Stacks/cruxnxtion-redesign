<?php
require __DIR__ . '/../bootstrap.php';
global $wpdb;
$eid = (int) $argv[1];
$wpdb->delete( cr8v_tix_reservations_table(), array( 'event_id' => $eid ) );
wp_delete_post( $eid, true );
echo 'cleaned event ' . $eid;
