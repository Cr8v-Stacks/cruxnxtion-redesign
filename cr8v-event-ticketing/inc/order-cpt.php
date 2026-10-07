<?php
/**
 * Private `event_order` post type and admin management.
 *
 * Fully protected: not public, not publicly queryable, not exposed via REST.
 *
 * @package Cr8v_Event_Ticketing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register private `event_order` post type.
 */
function cr8v_tix_register_order_cpt() {
	register_post_type(
		'event_order',
		array(
			'labels'              => array(
				'name'               => __( 'Event Orders', 'cr8v-event-ticketing' ),
				'singular_name'      => __( 'Event Order', 'cr8v-event-ticketing' ),
				'menu_name'          => __( 'Ticket Orders', 'cr8v-event-ticketing' ),
				'all_items'          => __( 'Ticket Orders', 'cr8v-event-ticketing' ),
				'add_new'            => __( 'Add New Order', 'cr8v-event-ticketing' ),
				'add_new_item'       => __( 'Add New Order', 'cr8v-event-ticketing' ),
				'edit_item'          => __( 'View / Edit Order', 'cr8v-event-ticketing' ),
				'view_item'          => __( 'View Order', 'cr8v-event-ticketing' ),
				'search_items'       => __( 'Search Orders', 'cr8v-event-ticketing' ),
				'not_found'          => __( 'No orders found', 'cr8v-event-ticketing' ),
				'not_found_in_trash' => __( 'No orders found in Trash', 'cr8v-event-ticketing' ),
			),
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_menu'        => 'edit.php?post_type=event',
			'show_in_nav_menus'   => false,
			'show_in_rest'        => false, // ZERO PII exposed in REST
			'has_archive'         => false,
			'hierarchical'        => false,
			'supports'            => array( 'title' ),
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
		)
	);
}
add_action( 'init', 'cr8v_tix_register_order_cpt', 20 );

/**
 * Custom admin columns for `event_order`.
 */
function cr8v_tix_order_columns( $columns ) {
	$new_columns = array(
		'cb'             => '<input type="checkbox" />',
		'title'          => __( 'Order', 'cr8v-event-ticketing' ),
		'order_event'    => __( 'Event', 'cr8v-event-ticketing' ),
		'order_customer' => __( 'Customer', 'cr8v-event-ticketing' ),
		'order_items'    => __( 'Tickets', 'cr8v-event-ticketing' ),
		'order_total'    => __( 'Total (£)', 'cr8v-event-ticketing' ),
		'order_status'   => __( 'Status', 'cr8v-event-ticketing' ),
		'date'           => __( 'Date', 'cr8v-event-ticketing' ),
	);
	return $new_columns;
}
add_filter( 'manage_event_order_posts_columns', 'cr8v_tix_order_columns' );

/**
 * Render custom column content for `event_order`.
 */
function cr8v_tix_render_order_columns( $column, $post_id ) {
	switch ( $column ) {
		case 'order_event':
			$event_id = (int) get_post_meta( $post_id, '_cr8v_order_event_id', true );
			if ( $event_id ) {
				$title = get_the_title( $event_id );
				echo '<a href="' . esc_url( get_edit_post_link( $event_id ) ) . '"><strong>' . esc_html( $title ) . '</strong></a>';
			} else {
				echo '&mdash;';
			}
			break;

		case 'order_customer':
			$name  = get_post_meta( $post_id, '_cr8v_order_customer_name', true );
			$email = get_post_meta( $post_id, '_cr8v_order_customer_email', true );
			$phone = get_post_meta( $post_id, '_cr8v_order_customer_phone', true );
			echo '<strong>' . esc_html( $name ?: '&mdash;' ) . '</strong><br>';
			if ( $email ) {
				echo '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>';
			}
			if ( $phone ) {
				echo '<br><span style="color:#646970; font-size:11px;">' . esc_html( $phone ) . '</span>';
			}
			break;

		case 'order_items':
			$items = get_post_meta( $post_id, '_cr8v_order_items', true );
			if ( is_array( $items ) && ! empty( $items ) ) {
				foreach ( $items as $it ) {
					$qty  = (int) ( $it['quantity'] ?? 0 );
					$name = esc_html( $it['tier_name'] ?? 'Ticket' );
					echo esc_html( "{$qty}x {$name}" ) . '<br>';
				}
			} else {
				echo '&mdash;';
			}
			break;

		case 'order_total':
			$total_pence = (int) get_post_meta( $post_id, '_cr8v_order_total_pence', true );
			if ( 0 === $total_pence ) {
				echo '<span style="color:#007cba; font-weight:700;">' . esc_html__( 'FREE', 'cr8v-event-ticketing' ) . '</span>';
			} else {
				echo '<strong>£' . esc_html( number_format( $total_pence / 100, 2 ) ) . '</strong>';
			}
			break;

		case 'order_status':
			$status = get_post_meta( $post_id, '_cr8v_order_status', true ) ?: 'pending';
			$status_styles = array(
				'completed' => 'background:#d4edda; color:#155724;',
				'pending'   => 'background:#fff3cd; color:#856404;',
				'failed'    => 'background:#f8d7da; color:#721c24;',
				'refunded'  => 'background:#e2e3e5; color:#383d41;',
				'cancelled' => 'background:#f8d7da; color:#721c24;',
			);
			$style = $status_styles[ $status ] ?? 'background:#f0f0f1; color:#3c434a;';
			echo '<span style="display:inline-block; padding:3px 8px; border-radius:4px; font-weight:700; font-size:11px; text-transform:uppercase; ' . esc_attr( $style ) . '">' . esc_html( $status ) . '</span>';
			break;
	}
}
add_action( 'manage_event_order_posts_custom_column', 'cr8v_tix_render_order_columns', 10, 2 );

/**
 * Add Order Details Meta Box.
 */
function cr8v_tix_add_order_details_meta_box() {
	add_meta_box(
		'cr8v_order_details',
		__( 'Order Information & Tickets', 'cr8v-event-ticketing' ),
		'cr8v_tix_render_order_details_meta_box',
		'event_order',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'cr8v_tix_add_order_details_meta_box' );

/**
 * Render Order Details Meta Box.
 *
 * @param WP_Post $post
 */
function cr8v_tix_render_order_details_meta_box( $post ) {
	$event_id    = (int) get_post_meta( $post->ID, '_cr8v_order_event_id', true );
	$name        = get_post_meta( $post->ID, '_cr8v_order_customer_name', true );
	$email       = get_post_meta( $post->ID, '_cr8v_order_customer_email', true );
	$phone       = get_post_meta( $post->ID, '_cr8v_order_customer_phone', true );
	$total_pence = (int) get_post_meta( $post->ID, '_cr8v_order_total_pence', true );
	$status      = get_post_meta( $post->ID, '_cr8v_order_status', true ) ?: 'pending';
	$stripe_sid  = get_post_meta( $post->ID, '_cr8v_order_stripe_session_id', true );
	$stripe_pi   = get_post_meta( $post->ID, '_cr8v_order_stripe_payment_intent', true );
	$items       = get_post_meta( $post->ID, '_cr8v_order_items', true ) ?: array();
	$tickets     = get_post_meta( $post->ID, '_cr8v_order_tickets', true ) ?: array();
	?>
	<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
		<div style="background:#f9f9f9; padding:15px; border-radius:6px; border:1px solid #ccd0d4;">
			<h4 style="margin-top:0;"><?php esc_html_e( 'Customer Details', 'cr8v-event-ticketing' ); ?></h4>
			<p><strong><?php esc_html_e( 'Name:', 'cr8v-event-ticketing' ); ?></strong> <?php echo esc_html( $name ); ?></p>
			<p><strong><?php esc_html_e( 'Email:', 'cr8v-event-ticketing' ); ?></strong> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
			<p><strong><?php esc_html_e( 'Phone:', 'cr8v-event-ticketing' ); ?></strong> <?php echo esc_html( $phone ?: '&mdash;' ); ?></p>
		</div>

		<div style="background:#f9f9f9; padding:15px; border-radius:6px; border:1px solid #ccd0d4;">
			<h4 style="margin-top:0;"><?php esc_html_e( 'Order Status & Payment', 'cr8v-event-ticketing' ); ?></h4>
			<p><strong><?php esc_html_e( 'Status:', 'cr8v-event-ticketing' ); ?></strong> <span style="font-weight:700; text-transform:uppercase;"><?php echo esc_html( $status ); ?></span></p>
			<p><strong><?php esc_html_e( 'Total Paid:', 'cr8v-event-ticketing' ); ?></strong> £<?php echo esc_html( number_format( $total_pence / 100, 2 ) ); ?></p>
			<?php if ( $stripe_sid ) : ?>
				<p><strong><?php esc_html_e( 'Stripe Session:', 'cr8v-event-ticketing' ); ?></strong> <code><?php echo esc_html( $stripe_sid ); ?></code></p>
			<?php endif; ?>
			<?php if ( $stripe_pi ) : ?>
				<p><strong><?php esc_html_e( 'Payment Intent:', 'cr8v-event-ticketing' ); ?></strong> <code><?php echo esc_html( $stripe_pi ); ?></code></p>
			<?php endif; ?>
		</div>
	</div>

	<h4><?php esc_html_e( 'Purchased Tickets & Passes', 'cr8v-event-ticketing' ); ?></h4>
	<table class="widefat striped">
		<thead>
			<tr>
				<th><?php esc_html_e( 'Ticket Code', 'cr8v-event-ticketing' ); ?></th>
				<th><?php esc_html_e( 'Tier', 'cr8v-event-ticketing' ); ?></th>
				<th><?php esc_html_e( 'Attendee', 'cr8v-event-ticketing' ); ?></th>
				<th><?php esc_html_e( 'Check-in Status', 'cr8v-event-ticketing' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php if ( ! empty( $tickets ) ) : ?>
				<?php foreach ( $tickets as $tix ) : ?>
					<tr>
						<td><code><?php echo esc_html( $tix['ticket_code'] ?? '&mdash;' ); ?></code></td>
						<td><strong><?php echo esc_html( $tix['tier_name'] ?? 'General' ); ?></strong></td>
						<td><?php echo esc_html( $tix['attendee_name'] ?? $name ); ?></td>
						<td>
							<?php if ( ! empty( $tix['checked_in'] ) ) : ?>
								<span style="color:#28a745; font-weight:700;"><?php echo sprintf( esc_html__( 'Checked in at %s', 'cr8v-event-ticketing' ), esc_html( $tix['checked_in_at'] ?? 'Door' ) ); ?></span>
							<?php else : ?>
								<span style="color:#6c757d;"><?php esc_html_e( 'Not checked in', 'cr8v-event-ticketing' ); ?></span>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td colspan="4"><?php esc_html_e( 'No individual tickets issued yet.', 'cr8v-event-ticketing' ); ?></td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<?php
}
