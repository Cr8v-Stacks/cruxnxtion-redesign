<?php
require __DIR__ . '/../bootstrap.php';
$cap = isset( $argv[1] ) ? (int) $argv[1] : 1;
$id  = wp_insert_post( array( 'post_type' => 'event', 'post_title' => 'ZZ RACE TEST EVENT', 'post_status' => 'publish' ) );
update_post_meta( $id, '_cr8v_event_ticket_tiers', array(
	array( 'id' => 'tier_race', 'name' => 'Last Ticket', 'description' => '', 'price_pence' => 0, 'capacity' => $cap, 'max_per_order' => 5, 'status' => 'active' ),
) );
echo 'EID=' . $id;
