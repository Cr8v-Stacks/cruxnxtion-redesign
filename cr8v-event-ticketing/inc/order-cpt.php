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
			// Own capability set: orders hold customer names, emails and phone numbers, so they
			// must not be readable by every user who can edit ordinary posts (Authors, Contributors).
			'capability_type'     => array( 'event_order', 'event_orders' ),
			'map_meta_cap'        => true,
			'capabilities'        => array( 'create_posts' => 'do_not_allow' ), // Orders are only created by checkout.
		)
	);
}
add_action( 'init', 'cr8v_tix_register_order_cpt', 20 );

/**
 * Give the Administrator role the order capabilities (once per capability-set version).
 * Other roles can be granted them with a role-editor plugin if the client wants staff access.
 */
function cr8v_tix_grant_order_caps() {
	if ( '1' === get_option( 'cr8v_tix_order_caps_v' ) ) {
		return;
	}
	$type = get_post_type_object( 'event_order' );
	$role = get_role( 'administrator' );
	if ( ! $type || ! $role ) {
		return;
	}
	foreach ( (array) $type->cap as $cap ) {
		if ( 'do_not_allow' !== $cap ) { // Never grant the capability that blocks manual order creation.
			$role->add_cap( $cap );
		}
	}
	update_option( 'cr8v_tix_order_caps_v', '1' );
}
add_action( 'init', 'cr8v_tix_grant_order_caps', 30 );

/**
 * Register the `event_staff` role with only `edit_event_orders` (and `read` for login/profile).
 *
 * Door staff log in with this role to scan passes and confirm door check-ins without
 * needing an administrator account. They have NO access to posts, pages, plugins, themes,
 * settings, users, or any other wp-admin management features.
 */
function cr8v_tix_register_staff_role() {
	if ( '1' === get_option( 'cr8v_tix_staff_role_v' ) ) {
		return;
	}
	$staff_role = get_role( 'event_staff' );
	if ( ! $staff_role ) {
		add_role(
			'event_staff',
			__( 'Event Staff', 'cr8v-event-ticketing' ),
			array(
				'read'              => true,
				'edit_event_orders' => true,
			)
		);
	} else {
		$staff_role->add_cap( 'read' );
		$staff_role->add_cap( 'edit_event_orders' );
	}
	update_option( 'cr8v_tix_staff_role_v', '1' );
}
add_action( 'init', 'cr8v_tix_register_staff_role', 30 );

/**
 * Restrict wp-admin menus for users with the event_staff role.
 *
 * Prevents staff from seeing standard admin screens; they only have access
 * to their profile and the front-end door check-in workflow.
 */
function cr8v_tix_restrict_staff_admin_menus() {
	if ( ! current_user_can( 'manage_options' ) && current_user_can( 'edit_event_orders' ) ) {
		remove_menu_page( 'index.php' );
		remove_menu_page( 'nativus-dashboard-pro' );
	}
}
add_action( 'admin_menu', 'cr8v_tix_restrict_staff_admin_menus', 999 );

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
			echo '<strong>' . esc_html( $name ?: '—' ) . '</strong><br>';
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
				'awaiting_payment'   => 'background:#fff3cd; color:#856404;',
				'partially_refunded' => 'background:#e2e3e5; color:#383d41;',
				'disputed'           => 'background:#f8d7da; color:#721c24;',
				'needs_review'       => 'background:#f8d7da; color:#721c24; outline:2px solid #dc3545;',
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
			<p><strong><?php esc_html_e( 'Phone:', 'cr8v-event-ticketing' ); ?></strong> <?php echo $phone ? esc_html( $phone ) : '&mdash;'; ?></p>
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
			<?php
			$email_sent = get_post_meta( $post->ID, '_cr8v_order_email_sent', true );
			?>
			<p>
				<strong><?php esc_html_e( 'Confirmation Email:', 'cr8v-event-ticketing' ); ?></strong>
				<?php if ( $email_sent ) : ?>
					<span style="color:#28a745; font-weight:700;"><?php echo sprintf( esc_html__( 'Sent on %s', 'cr8v-event-ticketing' ), esc_html( $email_sent ) ); ?></span>
				<?php else : ?>
					<span style="color:#6c757d;"><?php esc_html_e( 'Not sent yet', 'cr8v-event-ticketing' ); ?></span>
				<?php endif; ?>
			</p>
			<?php if ( 'completed' === $status ) : ?>
				<form method="post" style="margin-top:10px;">
					<?php wp_nonce_field( 'cr8v_resend_order_' . $post->ID, '_cr8v_resend_nonce' ); ?>
					<input type="hidden" name="order_id" value="<?php echo esc_attr( $post->ID ); ?>">
					<input type="hidden" name="cr8v_resend_order_email" value="1">
					<button type="submit" class="button button-secondary button-small"><?php esc_html_e( 'Resend Confirmation Email', 'cr8v-event-ticketing' ); ?></button>
				</form>
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
						<td><code><?php echo esc_html( $tix['ticket_code'] ?? '' ); ?></code><?php echo ! empty( $tix['void'] ) ? ' <strong style="color:#dc3545;">' . esc_html__( 'VOID', 'cr8v-event-ticketing' ) . '</strong>' : ''; ?></td>
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

/**
 * Neutralise CSV / Spreadsheet formula injection (CWE-1236).
 *
 * Any cell value whose first character is =, +, -, or @ (or tab \t / carriage return \r)
 * is prefixed with a single quote (') so that spreadsheet programs (Excel, Calc, Google Sheets)
 * treat it strictly as literal text rather than an executable formula or command.
 *
 * @param mixed $val Raw cell value.
 * @return string Neutralized cell string.
 */
function cr8v_tix_csv_escape( $val ) {
	$str = (string) $val;
	if ( '' === $str ) {
		return '';
	}
	$first = substr( $str, 0, 1 );
	if ( in_array( $first, array( '=', '+', '-', '@', "\t", "\r" ), true ) ) {
		return "'" . $str;
	}
	return $str;
}

/**
 * Build CSV string containing attendees and ticket passes.
 *
 * @param int $event_id Optional. Specific event ID to filter by. Defaults to 0 (all events).
 * @return string CSV file content.
 */
function cr8v_tix_build_attendee_csv( $event_id = 0 ) {
	$headers = array(
		'Order ID',
		'Order Date',
		'Order Status',
		'Event Title',
		'Event ID',
		'Attendee Name',
		'Tier Name',
		'Ticket Code',
		'Check-in Status',
		'Check-in Time',
		'Purchaser Name',
		'Purchaser Email',
		'Purchaser Phone',
		'Total Paid (£)',
	);

	$output = fopen( 'php://temp', 'r+' );
	fputcsv( $output, array_map( 'cr8v_tix_csv_escape', $headers ) );

	$args = array(
		'post_type'      => 'event_order',
		'post_status'    => array( 'publish', 'draft' ),
		'posts_per_page' => -1,
		'orderby'        => 'ID',
		'order'          => 'DESC',
	);
	if ( $event_id > 0 ) {
		$args['meta_key']   = '_cr8v_order_event_id';
		$args['meta_value'] = $event_id;
	}

	$orders = get_posts( $args );

	foreach ( $orders as $order ) {
		$oid         = $order->ID;
		$ev_id       = (int) get_post_meta( $oid, '_cr8v_order_event_id', true );
		$ev_title    = $ev_id ? get_the_title( $ev_id ) : '';
		$c_name      = (string) get_post_meta( $oid, '_cr8v_order_customer_name', true );
		$c_email     = (string) get_post_meta( $oid, '_cr8v_order_customer_email', true );
		$c_phone     = (string) get_post_meta( $oid, '_cr8v_order_customer_phone', true );
		$status      = (string) get_post_meta( $oid, '_cr8v_order_status', true ) ?: 'pending';
		$total_pence = (int) get_post_meta( $oid, '_cr8v_order_total_pence', true );
		$total_fmt   = number_format( $total_pence / 100, 2 );
		$tickets     = get_post_meta( $oid, '_cr8v_order_tickets', true );

		if ( is_array( $tickets ) && ! empty( $tickets ) ) {
			foreach ( $tickets as $tix ) {
				$checkin_status = 'Not Checked In';
				if ( ! empty( $tix['void'] ) ) {
					$checkin_status = 'VOID';
				} elseif ( ! empty( $tix['checked_in'] ) ) {
					$checkin_status = 'Checked In';
				}

				$row = array(
					$oid,
					$order->post_date,
					$status,
					$ev_title,
					$ev_id,
					$tix['attendee_name'] ?? $c_name,
					$tix['tier_name'] ?? 'Ticket',
					$tix['ticket_code'] ?? '',
					$checkin_status,
					$tix['checked_in_at'] ?? '',
					$c_name,
					$c_email,
					$c_phone,
					$total_fmt,
				);
				fputcsv( $output, array_map( 'cr8v_tix_csv_escape', $row ) );
			}
		} else {
			$row = array(
				$oid,
				$order->post_date,
				$status,
				$ev_title,
				$ev_id,
				$c_name,
				'—',
				'—',
				'—',
				'',
				$c_name,
				$c_email,
				$c_phone,
				$total_fmt,
			);
			fputcsv( $output, array_map( 'cr8v_tix_csv_escape', $row ) );
		}
	}

	rewind( $output );
	$csv = stream_get_contents( $output );
	fclose( $output );
	return $csv;
}

/**
 * Stream attendee CSV as downloadable file attachment.
 *
 * @param int $event_id Optional. Specific event ID to filter by.
 */
function cr8v_tix_stream_attendee_csv( $event_id = 0 ) {
	$date     = gmdate( 'Y-m-d' );
	$filename = $event_id ? "attendees-event-{$event_id}-{$date}.csv" : "attendees-all-{$date}.csv";

	nocache_headers();
	header( 'Content-Type: text/csv; charset=UTF-8' );
	header( 'Content-Disposition: attachment; filename="' . sanitize_file_name( $filename ) . '"' );
	header( 'X-Content-Type-Options: nosniff' );

	// Output UTF-8 BOM so Microsoft Excel opens UTF-8 encoded text cleanly
	echo "\xEF\xBB\xBF";
	echo cr8v_tix_build_attendee_csv( $event_id );
}

/**
 * Add "Export Attendees (CSV)" button to the event_order admin list table.
 *
 * @param string $which Table navigation position ('top' or 'bottom').
 */
function cr8v_tix_order_export_button( $which ) {
	if ( 'top' !== $which ) {
		return;
	}
	global $typenow;
	if ( 'event_order' !== $typenow ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$export_url = wp_nonce_url(
		add_query_arg(
			array(
				'action'    => 'cr8v_export_attendees_csv',
				'post_type' => 'event_order',
			),
			admin_url( 'edit.php' )
		),
		'cr8v_export_attendees_csv'
	);
	echo '<div class="alignleft actions"><a href="' . esc_url( $export_url ) . '" class="button button-secondary">' . esc_html__( 'Export Attendees (CSV)', 'cr8v-event-ticketing' ) . '</a></div>';
}
add_action( 'manage_posts_extra_tablenav', 'cr8v_tix_order_export_button' );

/**
 * Handle CSV attendee export request.
 * Strictly admin-only (manage_options) and nonce protected.
 */
function cr8v_tix_handle_csv_export() {
	if ( ! isset( $_GET['action'] ) || 'cr8v_export_attendees_csv' !== $_GET['action'] ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Permission denied. Administrator access required.', 'cr8v-event-ticketing' ), 403 );
	}
	$nonce = sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ?? '' ) );
	if ( ! wp_verify_nonce( $nonce, 'cr8v_export_attendees_csv' ) ) {
		wp_die( esc_html__( 'Security check failed. Please refresh and try again.', 'cr8v-event-ticketing' ), 403 );
	}

	$event_id = isset( $_GET['event_id'] ) ? absint( $_GET['event_id'] ) : 0;
	cr8v_tix_stream_attendee_csv( $event_id );
	exit;
}
add_action( 'admin_init', 'cr8v_tix_handle_csv_export' );
