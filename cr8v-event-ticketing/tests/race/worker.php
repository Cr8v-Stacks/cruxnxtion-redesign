<?php
require __DIR__ . '/../bootstrap.php';
$eid = (int) $argv[1];
$go  = (float) $argv[2];
while ( microtime( true ) < $go ) { /* spin until the shared start time */ }
$r = cr8v_tix_atomic_reserve_stock( $eid, array( array( 'tier_id' => 'tier_race', 'quantity' => 1 ) ), 'res_w' . getmypid(), 1800 );
echo is_wp_error( $r ) ? 'REJECTED' : 'RESERVED';
