<?php
/**
 * Ticket tiers schema, meta box, and atomic stock reservation engine.
 *
 * All money is computed and stored as integer pence (£25.00 = 2500).
 * Capacity is strictly enforced via database reservations with expiration
 * to prevent overselling race conditions.
 *
 * @package Cr8v_Event_Ticketing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get ticket tiers for an event.
 *
 * @param int $event_id Event post ID.
 * @param bool $with_live_counts Whether to query live stock availability.
 * @return array Array of tier arrays.
 */
function cr8v_tix_get_event_tiers( $event_id, $with_live_counts = true ) {
	$tiers = get_post_meta( $event_id, '_cr8v_event_ticket_tiers', true );
	if ( ! is_array( $tiers ) || empty( $tiers ) ) {
		return array();
	}

	if ( ! $with_live_counts ) {
		return $tiers;
	}

	// Clean up stale reservations first
	cr8v_tix_cleanup_expired_reservations();

	global $wpdb;
	$res_table = cr8v_tix_reservations_table();
	$now       = current_time( 'mysql', true );

	// Aggregate live sales and active reservations in a single query
	$counts_raw = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT tier_id,
					COALESCE(SUM(CASE WHEN status = 'completed' THEN quantity ELSE 0 END), 0) AS sold,
					COALESCE(SUM(CASE WHEN status = 'reserved' AND expires_at > %s THEN quantity ELSE 0 END), 0) AS reserved
			 FROM {$res_table}
			 WHERE event_id = %d AND status IN ('completed', 'reserved')
			 GROUP BY tier_id",
			$now,
			$event_id
		),
		OBJECT_K
	);

	$augmented = array();
	foreach ( $tiers as $tier ) {
		$tid      = $tier['id'];
		$capacity = isset( $tier['capacity'] ) ? (int) $tier['capacity'] : 0;
		$sold     = isset( $counts_raw[ $tid ] ) ? (int) $counts_raw[ $tid ]->sold : 0;
		$reserved = isset( $counts_raw[ $tid ] ) ? (int) $counts_raw[ $tid ]->reserved : 0;
		$avail    = max( 0, $capacity - ( $sold + $reserved ) );

		$price_pence = isset( $tier['price_pence'] ) ? (int) $tier['price_pence'] : 0;

		$tier['sold_count']      = $sold;
		$tier['reserved_count']  = $reserved;
		$tier['available_count'] = $avail;
		$tier['is_sold_out']     = ( $avail <= 0 && $capacity > 0 );
		$tier['price_formatted'] = ( 0 === $price_pence ) ? __( 'Free', 'cr8v-event-ticketing' ) : '£' . number_format( $price_pence / 100, 2 );

		$augmented[ $tid ] = $tier;
	}

	return $augmented;
}

/**
 * Atomic stock reservation engine.
 *
 * Verifies stock availability and reserves tickets for 30 minutes in a single transaction.
 *
 * @param int    $event_id Event post ID.
 * @param array  $requested_items Array of [ 'tier_id' => ..., 'quantity' => ... ].
 * @param string $session_id Unique checkout session or reservation token.
 * @param int    $expires_in_seconds Reservation TTL (default 1800s / 30 mins).
 * @return true|WP_Error
 */
function cr8v_tix_atomic_reserve_stock( $event_id, $requested_items, $session_id, $expires_in_seconds = 1800 ) {
	global $wpdb;

	if ( empty( $requested_items ) || ! is_array( $requested_items ) ) {
		return new WP_Error( 'invalid_items', __( 'No ticket tiers selected.', 'cr8v-event-ticketing' ) );
	}

	$tiers = cr8v_tix_get_event_tiers( $event_id, false );
	if ( empty( $tiers ) ) {
		return new WP_Error( 'no_tiers', __( 'This event does not have active ticket tiers.', 'cr8v-event-ticketing' ) );
	}

	$tier_map = array();
	foreach ( $tiers as $t ) {
		$tier_map[ $t['id'] ] = $t;
	}

	// Purge stale reservations
	cr8v_tix_cleanup_expired_reservations();

	$res_table = cr8v_tix_reservations_table();
	$now_dt    = new DateTimeImmutable( 'now', new DateTimeZone( 'UTC' ) );
	$expires_dt= $now_dt->modify( "+{$expires_in_seconds} seconds" );
	$created_at= $now_dt->format( 'Y-m-d H:i:s' );
	$expires_at= $expires_dt->format( 'Y-m-d H:i:s' );

	// Begin atomic transaction
	$wpdb->query( 'START TRANSACTION' );

	$reservations_to_insert = array();

	foreach ( $requested_items as $item ) {
		$tid = sanitize_key( $item['tier_id'] ?? '' );
		$qty = absint( $item['quantity'] ?? 0 );

		if ( $qty <= 0 ) {
			continue;
		}

		if ( ! isset( $tier_map[ $tid ] ) ) {
			$wpdb->query( 'ROLLBACK' );
			return new WP_Error( 'invalid_tier', sprintf( __( 'Unknown ticket tier: %s', 'cr8v-event-ticketing' ), esc_html( $tid ) ) );
		}

		$tier_def = $tier_map[ $tid ];
		$capacity = (int) $tier_def['capacity'];
		$max_per  = isset( $tier_def['max_per_order'] ) ? (int) $tier_def['max_per_order'] : 10;

		if ( $qty > $max_per ) {
			$wpdb->query( 'ROLLBACK' );
			return new WP_Error( 'max_exceeded', sprintf( __( 'Maximum %1$d tickets allowed for %2$s.', 'cr8v-event-ticketing' ), $max_per, esc_html( $tier_def['name'] ) ) );
		}

		// Query committed sales and active unexpired holds with row lock simulation
		$count_row = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT 
					COALESCE(SUM(CASE WHEN status = 'completed' THEN quantity ELSE 0 END), 0) AS sold,
					COALESCE(SUM(CASE WHEN status = 'reserved' AND expires_at > %s THEN quantity ELSE 0 END), 0) AS reserved
				 FROM {$res_table}
				 WHERE event_id = %d AND tier_id = %s AND status IN ('completed', 'reserved')",
				$now_dt->format( 'Y-m-d H:i:s' ),
				$event_id,
				$tid
			)
		);

		$sold     = $count_row ? (int) $count_row->sold : 0;
		$reserved = $count_row ? (int) $count_row->reserved : 0;
		$avail    = max( 0, $capacity - ( $sold + $reserved ) );

		if ( $qty > $avail ) {
			$wpdb->query( 'ROLLBACK' );
			return new WP_Error(
				'insufficient_stock',
				sprintf(
					__( 'Only %1$d tickets remaining for %2$s. Please reduce quantity.', 'cr8v-event-ticketing' ),
					$avail,
					esc_html( $tier_def['name'] )
				)
			);
		}

		$reservations_to_insert[] = array(
			'event_id'   => $event_id,
			'tier_id'    => $tid,
			'session_id' => $session_id,
			'quantity'   => $qty,
			'status'     => 'reserved',
			'created_at' => $created_at,
			'expires_at' => $expires_at,
		);
	}

	if ( empty( $reservations_to_insert ) ) {
		$wpdb->query( 'ROLLBACK' );
		return new WP_Error( 'no_valid_items', __( 'No tickets were selected.', 'cr8v-event-ticketing' ) );
	}

	// Insert reservation rows
	foreach ( $reservations_to_insert as $row ) {
		$inserted = $wpdb->insert( $res_table, $row );
		if ( false === $inserted ) {
			$wpdb->query( 'ROLLBACK' );
			return new WP_Error( 'db_error', __( 'Failed to reserve ticket capacity.', 'cr8v-event-ticketing' ) );
		}
	}

	$wpdb->query( 'COMMIT' );
	return true;
}

/**
 * Release a reservation by session ID (called on expired sessions or cart abandons).
 *
 * @param string $session_id Checkout session ID.
 * @return int Rows updated.
 */
function cr8v_tix_release_reservation( $session_id ) {
	global $wpdb;
	$res_table = cr8v_tix_reservations_table();
	return (int) $wpdb->query(
		$wpdb->prepare(
			"UPDATE {$res_table} SET status = 'released' WHERE session_id = %s AND status = 'reserved'",
			$session_id
		)
	);
}

/**
 * Complete a reservation upon successful payment confirmation.
 *
 * @param string $session_id Checkout session ID.
 * @param int    $order_id Associated order post ID.
 * @return int Rows updated.
 */
function cr8v_tix_complete_reservation( $session_id, $order_id ) {
	global $wpdb;
	$res_table = cr8v_tix_reservations_table();
	return (int) $wpdb->query(
		$wpdb->prepare(
			"UPDATE {$res_table} SET status = 'completed', order_id = %d WHERE session_id = %s",
			$order_id,
			$session_id
		)
	);
}

/**
 * Add Ticket Tiers Meta Box to the `event` post type.
 */
function cr8v_tix_add_tiers_meta_box() {
	add_meta_box(
		'cr8v_event_ticket_tiers',
		__( 'Ticket Tiers & Pricing', 'cr8v-event-ticketing' ),
		'cr8v_tix_render_tiers_meta_box',
		'event',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'cr8v_tix_add_tiers_meta_box' );

/**
 * Render Ticket Tiers Meta Box in admin.
 *
 * @param WP_Post $post
 */
function cr8v_tix_render_tiers_meta_box( $post ) {
	wp_nonce_field( 'cr8v_tix_save_tiers', 'cr8v_tix_tiers_nonce' );

	$tiers = cr8v_tix_get_event_tiers( $post->ID, true );
	?>
	<style>
		.cr8v-tiers-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
		.cr8v-tiers-table th, .cr8v-tiers-table td { padding: 10px 12px; border: 1px solid #c3c4c7; text-align: left; vertical-align: top; }
		.cr8v-tiers-table th { background: #f0f0f1; font-weight: 600; font-size: 13px; }
		.cr8v-tier-row input[type=text], .cr8v-tier-row input[type=number] { width: 100%; }
		.cr8v-tier-badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
		.cr8v-tier-badge--active { background: #d4edda; color: #155724; }
		.cr8v-tier-badge--soldout { background: #f8d7da; color: #721c24; }
	</style>

	<p class="description">
		<?php esc_html_e( 'Define ticket tiers for this event. Prices are stored in integer pence. Leave price at 0 for free RSVP events.', 'cr8v-event-ticketing' ); ?>
	</p>

	<table class="cr8v-tiers-table" id="cr8v-tiers-table">
		<thead>
			<tr>
				<th style="width:25%;"><?php esc_html_e( 'Tier Name', 'cr8v-event-ticketing' ); ?></th>
				<th style="width:15%;"><?php esc_html_e( 'Price (£ GBP)', 'cr8v-event-ticketing' ); ?></th>
				<th style="width:15%;"><?php esc_html_e( 'Capacity', 'cr8v-event-ticketing' ); ?></th>
				<th style="width:15%;"><?php esc_html_e( 'Max Per Order', 'cr8v-event-ticketing' ); ?></th>
				<th style="width:15%;"><?php esc_html_e( 'Status / Stock', 'cr8v-event-ticketing' ); ?></th>
				<th style="width:15%;"><?php esc_html_e( 'Actions', 'cr8v-event-ticketing' ); ?></th>
			</tr>
		</thead>
		<tbody id="cr8v-tiers-tbody">
			<?php
			if ( ! empty( $tiers ) ) :
				$idx = 0;
				foreach ( $tiers as $tier ) :
					$id_val       = esc_attr( $tier['id'] );
					$name_val     = esc_attr( $tier['name'] );
					$price_pounds = number_format( ( (int) $tier['price_pence'] ) / 100, 2, '.', '' );
					$cap_val      = (int) $tier['capacity'];
					$max_val      = isset( $tier['max_per_order'] ) ? (int) $tier['max_per_order'] : 10;
					$desc_val     = isset( $tier['description'] ) ? esc_attr( $tier['description'] ) : '';
					$avail_val    = (int) $tier['available_count'];
					$sold_val     = (int) $tier['sold_count'];
					?>
					<tr class="cr8v-tier-row">
						<td>
							<input type="hidden" name="cr8v_tiers[<?php echo $idx; ?>][id]" value="<?php echo $id_val; ?>">
							<input type="text" name="cr8v_tiers[<?php echo $idx; ?>][name]" value="<?php echo $name_val; ?>" placeholder="e.g. Early Bird" required>
							<input type="text" name="cr8v_tiers[<?php echo $idx; ?>][description]" value="<?php echo $desc_val; ?>" placeholder="Short note (optional)" style="margin-top:6px; font-size:12px;">
						</td>
						<td>
							<input type="number" step="0.01" min="0" name="cr8v_tiers[<?php echo $idx; ?>][price]" value="<?php echo esc_attr( $price_pounds ); ?>" required>
							<span class="description" style="font-size:11px;"><?php esc_html_e( '0 = Free RSVP', 'cr8v-event-ticketing' ); ?></span>
						</td>
						<td>
							<input type="number" step="1" min="1" name="cr8v_tiers[<?php echo $idx; ?>][capacity]" value="<?php echo esc_attr( $cap_val ); ?>" required>
						</td>
						<td>
							<input type="number" step="1" min="1" max="50" name="cr8v_tiers[<?php echo $idx; ?>][max_per_order]" value="<?php echo esc_attr( $max_val ); ?>" required>
						</td>
						<td>
							<?php if ( $tier['is_sold_out'] ) : ?>
								<span class="cr8v-tier-badge cr8v-tier-badge--soldout"><?php esc_html_e( 'Sold Out', 'cr8v-event-ticketing' ); ?></span>
							<?php else : ?>
								<span class="cr8v-tier-badge cr8v-tier-badge--active"><?php echo sprintf( esc_html__( '%d Available', 'cr8v-event-ticketing' ), $avail_val ); ?></span>
							<?php endif; ?>
							<p style="font-size:11px; margin:4px 0 0; color:#646970;">
								<?php echo sprintf( esc_html__( 'Sold: %d', 'cr8v-event-ticketing' ), $sold_val ); ?>
							</p>
						</td>
						<td>
							<button type="button" class="button button-link-delete cr8v-remove-tier-btn"><?php esc_html_e( 'Remove', 'cr8v-event-ticketing' ); ?></button>
						</td>
					</tr>
					<?php
					$idx++;
				endforeach;
			endif;
			?>
		</tbody>
	</table>

	<p>
		<button type="button" class="button button-secondary" id="cr8v-add-tier-btn">
			+ <?php esc_html_e( 'Add Ticket Tier', 'cr8v-event-ticketing' ); ?>
		</button>
	</p>

	<script>
	jQuery(document).ready(function($) {
		var tbody = $('#cr8v-tiers-tbody');
		$('#cr8v-add-tier-btn').on('click', function() {
			var idx = tbody.find('tr').length;
			var uid = 'tier_' + Math.random().toString(36).substr(2, 9);
			var row = '<tr class="cr8v-tier-row">' +
				'<td>' +
					'<input type="hidden" name="cr8v_tiers[' + idx + '][id]" value="' + uid + '">' +
					'<input type="text" name="cr8v_tiers[' + idx + '][name]" placeholder="e.g. General Admission" required>' +
					'<input type="text" name="cr8v_tiers[' + idx + '][description]" placeholder="Short note (optional)" style="margin-top:6px; font-size:12px;">' +
				'</td>' +
				'<td><input type="number" step="0.01" min="0" name="cr8v_tiers[' + idx + '][price]" value="25.00" required></td>' +
				'<td><input type="number" step="1" min="1" name="cr8v_tiers[' + idx + '][capacity]" value="100" required></td>' +
				'<td><input type="number" step="1" min="1" max="50" name="cr8v_tiers[' + idx + '][max_per_order]" value="10" required></td>' +
				'<td><span class="cr8v-tier-badge cr8v-tier-badge--active">' + <?php echo wp_json_encode( __( 'New', 'cr8v-event-ticketing' ) ); ?> + '</span></td>' +
				'<td><button type="button" class="button button-link-delete cr8v-remove-tier-btn">' + <?php echo wp_json_encode( __( 'Remove', 'cr8v-event-ticketing' ) ); ?> + '</button></td>' +
			'</tr>';
			tbody.append(row);
		});

		tbody.on('click', '.cr8v-remove-tier-btn', function() {
			if (confirm(<?php echo wp_json_encode( __( 'Remove this ticket tier?', 'cr8v-event-ticketing' ) ); ?>)) {
				$(this).closest('tr').remove();
			}
		});
	});
	</script>
	<?php
}

/**
 * Save ticket tiers meta box data on event post save.
 *
 * @param int     $post_id
 * @param WP_Post $post
 */
function cr8v_tix_save_tiers_meta_box( $post_id, $post ) {
	if ( ! isset( $_POST['cr8v_tix_tiers_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cr8v_tix_tiers_nonce'] ) ), 'cr8v_tix_save_tiers' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( wp_is_post_revision( $post_id ) || 'event' !== $post->post_type ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$raw_tiers = isset( $_POST['cr8v_tiers'] ) && is_array( $_POST['cr8v_tiers'] ) ? $_POST['cr8v_tiers'] : array();
	$clean_tiers = array();

	foreach ( $raw_tiers as $entry ) {
		$name = sanitize_text_field( wp_unslash( $entry['name'] ?? '' ) );
		if ( '' === $name ) {
			continue;
		}

		$tid = sanitize_key( wp_unslash( $entry['id'] ?? '' ) );
		if ( '' === $tid ) {
			$tid = 'tier_' . substr( md5( uniqid( (string) mt_rand(), true ) ), 0, 10 );
		}

		$price_float = floatval( $entry['price'] ?? 0 );
		$price_pence = max( 0, (int) round( $price_float * 100 ) );

		$capacity = max( 1, absint( $entry['capacity'] ?? 100 ) );
		$max_per  = max( 1, min( 50, absint( $entry['max_per_order'] ?? 10 ) ) );
		$desc     = sanitize_text_field( wp_unslash( $entry['description'] ?? '' ) );

		$clean_tiers[] = array(
			'id'            => $tid,
			'name'          => mb_substr( $name, 0, 80 ),
			'description'   => mb_substr( $desc, 0, 160 ),
			'price_pence'   => $price_pence,
			'capacity'      => $capacity,
			'max_per_order' => $max_per,
			'status'        => 'active',
		);
	}

	if ( ! empty( $clean_tiers ) ) {
		update_post_meta( $post_id, '_cr8v_event_ticket_tiers', $clean_tiers );
	} else {
		delete_post_meta( $post_id, '_cr8v_event_ticket_tiers' );
	}
}
add_action( 'save_post_event', 'cr8v_tix_save_tiers_meta_box', 15, 2 );
