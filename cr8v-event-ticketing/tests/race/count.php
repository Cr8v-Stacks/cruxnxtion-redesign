<?php
require __DIR__ . '/../bootstrap.php';
global $wpdb;
$eid = (int) $argv[1];
$tb  = cr8v_tix_reservations_table();
echo 'reserved ticket rows in DB: ' . (int) $wpdb->get_var( $wpdb->prepare( "SELECT COALESCE(SUM(quantity),0) FROM {$tb} WHERE event_id=%d AND status='reserved'", $eid ) );
