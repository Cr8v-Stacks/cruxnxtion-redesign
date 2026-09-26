<?php
/**
 * Plugin Name: Crux Nxtion Core
 * Plugin URI: https://cruxnxtion.co.uk/
 * Description: Core functionality plugin for Crux Nxtion Events & Consultancy. Manages Custom Post Types (Inquiries, Events, Gallery), lead capture intake, and email notifications.
 * Version: 1.1.1
 * Author: Cr8v Stacks
 * Author URI: https://cr8vstacks.com/
 * Text Domain: crux-nxtion-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Register Custom Post Types
 */
function crux_core_register_cpts() {
	// A. Inquiries CPT (Leads Intake)
	$inquiry_labels = array(
		'name'               => __( 'Inquiries & Leads', 'crux-nxtion-core' ),
		'singular_name'      => __( 'Inquiry', 'crux-nxtion-core' ),
		'menu_name'          => __( 'Crux Inquiries', 'crux-nxtion-core' ),
		'name_admin_bar'     => __( 'Inquiry', 'crux-nxtion-core' ),
		'add_new'            => __( 'Add New Lead', 'crux-nxtion-core' ),
		'add_new_item'       => __( 'Add New Inquiry', 'crux-nxtion-core' ),
		'edit_item'          => __( 'View / Edit Inquiry', 'crux-nxtion-core' ),
		'view_item'          => __( 'View Inquiry', 'crux-nxtion-core' ),
		'all_items'          => __( 'All Inquiries', 'crux-nxtion-core' ),
		'search_items'       => __( 'Search Inquiries', 'crux-nxtion-core' ),
		'not_found'          => __( 'No inquiries found.', 'crux-nxtion-core' ),
		'not_found_in_trash' => __( 'No inquiries found in Trash.', 'crux-nxtion-core' ),
	);

	register_post_type( 'inquiry', array(
		'labels'             => $inquiry_labels,
		'public'             => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => false,
		'rewrite'            => false,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 26,
		'menu_icon'          => 'dashicons-email-alt2',
		'supports'           => array( 'title' ),
	) );

	// B. Events CPT
	register_post_type( 'event', array(
		'labels'             => array(
			'name'          => __( 'Events', 'crux-nxtion-core' ),
			'singular_name' => __( 'Event', 'crux-nxtion-core' ),
			'add_new_item'  => __( 'Add New Event', 'crux-nxtion-core' ),
			'edit_item'     => __( 'Edit Event', 'crux-nxtion-core' ),
		),
		'public'             => true,
		'has_archive'        => false,
		'rewrite'            => array( 'slug' => 'event', 'with_front' => false ),
		'menu_position'      => 27,
		'menu_icon'          => 'dashicons-calendar-alt',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'show_in_rest'       => true,
	) );

	// C. Gallery CPT
	register_post_type( 'gallery_item', array(
		'labels'             => array(
			'name'          => __( 'Gallery Items', 'crux-nxtion-core' ),
			'singular_name' => __( 'Gallery Item', 'crux-nxtion-core' ),
		),
		'public'             => true,
		'has_archive'        => false,
		'rewrite'            => array( 'slug' => 'gallery-item', 'with_front' => false ),
		'menu_position'      => 28,
		'menu_icon'          => 'dashicons-format-gallery',
		'supports'           => array( 'title', 'thumbnail' ),
		'show_in_rest'       => true,
	) );
}
add_action( 'init', 'crux_core_register_cpts' );

/**
 * 2. Inquiries Admin Columns & Status Styling
 */
function crux_inquiry_columns( $columns ) {
	$new_columns = array(
		'cb'        => '<input type="checkbox" />',
		'title'     => __( 'Client Name', 'crux-nxtion-core' ),
		'lead_type' => __( 'Wing', 'crux-nxtion-core' ),
		'services'  => __( 'Services Requested', 'crux-nxtion-core' ),
		'email'     => __( 'Email Address', 'crux-nxtion-core' ),
		'phone'     => __( 'Phone Number', 'crux-nxtion-core' ),
		'status'    => __( 'Lead Status', 'crux-nxtion-core' ),
		'date'      => __( 'Date Submitted', 'crux-nxtion-core' ),
	);
	return $new_columns;
}
add_filter( 'manage_inquiry_posts_columns', 'crux_inquiry_columns' );

function crux_inquiry_custom_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'lead_type':
			$saved_tabs = get_post_meta( $post_id, '_crux_selected_tabs', true );
			$type       = get_post_meta( $post_id, '_crux_lead_type', true );
			$types_arr  = array();

			if ( is_array( $saved_tabs ) && ! empty( $saved_tabs ) ) {
				$types_arr = $saved_tabs;
			} elseif ( $type === 'all' ) {
				$types_arr = array( 'events', 'consultancy', 'partner' );
			} elseif ( $type === 'both' ) {
				$types_arr = array( 'events', 'consultancy' );
			} elseif ( ! empty( $type ) && strpos( $type, ',' ) !== false ) {
				$types_arr = explode( ',', $type );
			} elseif ( ! empty( $type ) ) {
				$types_arr = array( $type );
			} else {
				// Legacy fallback check
				$legacy_srv = get_post_meta( $post_id, '_cr8v_inquiry_services', true ) ?: get_post_meta( $post_id, '_cr8v_inquiry_discipline', true );
				$types_arr  = array( 'events' );
			}

			echo '<div style="display:flex; gap:4px; flex-wrap:wrap;">';
			foreach ( $types_arr as $t ) {
				$t = trim( (string) $t );
				if ( $t === 'events' ) {
					echo '<span style="background:#002671; color:#fff; font-weight:700; padding:3px 8px; font-size:11px; display:inline-block; clip-path:polygon(4px 0,100% 0,calc(100% - 4px) 100%,0 100%);">EVENTS</span>';
				} elseif ( $t === 'consultancy' ) {
					echo '<span style="background:#8C7AE6; color:#10142E; font-weight:700; padding:3px 8px; font-size:11px; display:inline-block; clip-path:polygon(4px 0,100% 0,calc(100% - 4px) 100%,0 100%);">CONSULTANCY</span>';
				} elseif ( $t === 'partner' || $t === 'sponsorship' ) {
					echo '<span style="background:#BA0000; color:#fff; font-weight:700; padding:3px 8px; font-size:11px; display:inline-block; clip-path:polygon(4px 0,100% 0,calc(100% - 4px) 100%,0 100%);">PARTNERSHIP</span>';
				}
			}
			echo '</div>';
			break;

		case 'services':
			$services = get_post_meta( $post_id, '_crux_services', true );
			if ( empty( $services ) ) {
				$legacy = get_post_meta( $post_id, '_cr8v_inquiry_services', true ) ?: get_post_meta( $post_id, '_cr8v_inquiry_discipline', true );
				if ( ! empty( $legacy ) ) {
					$services = is_array( $legacy ) ? $legacy : array_filter( array_map( 'trim', explode( ',', (string) $legacy ) ) );
				}
			}

			if ( is_array( $services ) && ! empty( $services ) ) {
				echo esc_html( implode( ', ', array_slice( $services, 0, 3 ) ) );
				if ( count( $services ) > 3 ) {
					echo ' <em>(+' . ( count( $services ) - 3 ) . ' more)</em>';
				}
			} elseif ( ! empty( $services ) && is_string( $services ) ) {
				echo esc_html( $services );
			} else {
				echo '<span style="color:#888;">—</span>';
			}
			break;

		case 'email':
			$email = get_post_meta( $post_id, '_crux_email', true ) ?: get_post_meta( $post_id, '_cr8v_inquiry_email', true );
			echo $email ? '<a href="mailto:' . esc_attr( $email ) . '" style="color:#002671; font-weight:600;">' . esc_html( $email ) . '</a>' : '<span style="color:#888;">—</span>';
			break;

		case 'phone':
			$phone = get_post_meta( $post_id, '_crux_phone', true ) ?: get_post_meta( $post_id, '_cr8v_inquiry_phone', true );
			echo $phone ? '<a href="tel:' . esc_attr( $phone ) . '">' . esc_html( $phone ) . '</a>' : '<span style="color:#888;">—</span>';
			break;

		case 'status':
			$status = get_post_meta( $post_id, '_crux_status', true ) ?: get_post_meta( $post_id, '_cr8v_inquiry_status', true ) ?: 'New';
			$color = '#2271b1';
			if ( $status === 'New' ) $color = '#d63638';
			if ( $status === 'Contacted' ) $color = '#e49e00';
			if ( $status === 'Proposal Sent' ) $color = '#8C7AE6';
			if ( $status === 'Booked' || $status === 'Concluded' ) $color = '#00a32a';
			echo '<span style="font-weight:700; color:' . esc_attr( $color ) . ';">● ' . esc_html( $status ) . '</span>';
			break;
	}
}
add_action( 'manage_inquiry_posts_custom_column', 'crux_inquiry_custom_column_content', 10, 2 );

/**
 * 3. Inquiry Meta Box: Full Lead Brief Details & Executive Dossier
 */
function crux_add_inquiry_meta_boxes() {
	add_meta_box(
		'crux_inquiry_details',
		__( 'Inquiry Dossier & Commercial Specification', 'crux-nxtion-core' ),
		'crux_render_inquiry_meta_box',
		'inquiry',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'crux_add_inquiry_meta_boxes' );

function crux_render_inquiry_meta_box( $post ) {
	wp_nonce_field( 'crux_save_inquiry_meta', 'crux_inquiry_meta_nonce' );

	$name       = get_post_meta( $post->ID, '_crux_name', true ) ?: get_the_title( $post->ID );
	$email      = get_post_meta( $post->ID, '_crux_email', true ) ?: get_post_meta( $post->ID, '_cr8v_inquiry_email', true );
	$phone      = get_post_meta( $post->ID, '_crux_phone', true ) ?: get_post_meta( $post->ID, '_cr8v_inquiry_phone', true );
	$services   = get_post_meta( $post->ID, '_crux_services', true );
	if ( empty( $services ) ) {
		$legacy_srv = get_post_meta( $post->ID, '_cr8v_inquiry_services', true ) ?: get_post_meta( $post->ID, '_cr8v_inquiry_discipline', true );
		if ( ! empty( $legacy_srv ) ) {
			$services = is_array( $legacy_srv ) ? $legacy_srv : array_filter( array_map( 'trim', explode( ',', (string) $legacy_srv ) ) );
		}
	}
	$lead_type  = get_post_meta( $post->ID, '_crux_lead_type', true );
	$saved_tabs = get_post_meta( $post->ID, '_crux_selected_tabs', true );
	$status     = get_post_meta( $post->ID, '_crux_status', true ) ?: get_post_meta( $post->ID, '_cr8v_inquiry_status', true ) ?: 'New';
	$message    = get_post_meta( $post->ID, '_crux_message', true ) ?: get_post_meta( $post->ID, '_cr8v_inquiry_scope', true ) ?: $post->post_content;
	$ip         = get_post_meta( $post->ID, '_crux_ip', true ) ?: get_post_meta( $post->ID, '_cr8v_inquiry_ip', true ) ?: '127.0.0.1';

	// Event details
	$ev_type    = get_post_meta( $post->ID, '_crux_ev_type', true );
	$ev_date    = get_post_meta( $post->ID, '_crux_ev_date', true );
	$ev_guests  = get_post_meta( $post->ID, '_crux_ev_guests', true );
	$ev_venue   = get_post_meta( $post->ID, '_crux_ev_venue', true );

	// Consultancy details
	$biz_name   = get_post_meta( $post->ID, '_crux_biz_name', true );
	$biz_stage  = get_post_meta( $post->ID, '_crux_biz_stage', true );

	// Partnership details
	$partner_company  = get_post_meta( $post->ID, '_crux_partner_company', true );
	$partner_interest = get_post_meta( $post->ID, '_crux_partner_interest', true );

	// Production & internal notes
	$director       = get_post_meta( $post->ID, '_crux_director', true ) ?: get_post_meta( $post->ID, '_cr8v_inquiry_director', true );
	$budget         = get_post_meta( $post->ID, '_crux_budget', true ) ?: get_post_meta( $post->ID, '_cr8v_inquiry_budget', true );
	$internal_notes = get_post_meta( $post->ID, '_crux_internal_notes', true ) ?: get_post_meta( $post->ID, '_cr8v_inquiry_internal_notes', true );

	// Determine active wings
	$types_arr = array();
	if ( is_array( $saved_tabs ) && ! empty( $saved_tabs ) ) {
		$types_arr = $saved_tabs;
	} elseif ( $lead_type === 'all' ) {
		$types_arr = array( 'events', 'consultancy', 'partner' );
	} elseif ( $lead_type === 'both' ) {
		$types_arr = array( 'events', 'consultancy' );
	} elseif ( ! empty( $lead_type ) && strpos( $lead_type, ',' ) !== false ) {
		$types_arr = explode( ',', $lead_type );
	} elseif ( ! empty( $lead_type ) ) {
		$types_arr = array( $lead_type );
	} else {
		$types_arr = array( 'events' );
	}

	// Normalize services into array
	if ( is_string( $services ) ) {
		$services = array_filter( array_map( 'trim', explode( ',', $services ) ) );
	} elseif ( ! is_array( $services ) ) {
		$services = array();
	}

	// Robust Wing Detection
	$ev_services_sel   = array();
	$biz_services_sel  = array();
	$part_services_sel = array();
	$other_services    = array();

	foreach ( $services as $s ) {
		$s_clean = trim( (string) $s );
		$s_lower = strtolower( $s_clean );

		if (
			in_array( $s_clean, array( 'Event sponsorship', 'Brand partnership', 'Brand activation partner', 'Talent collaboration', 'Media & press partnership', 'Media & talent collaboration', 'Vendor / Supplier', 'Vendor & catering partner', 'Partnership', 'Sponsorship' ), true )
			|| strpos( $s_lower, 'sponsor' ) !== false
			|| strpos( $s_lower, 'partner' ) !== false
			|| strpos( $s_lower, 'vendor' ) !== false
			|| strpos( $s_lower, 'catering' ) !== false
		) {
			$part_services_sel[] = $s_clean;
		} elseif (
			in_array( $s_clean, array( 'Business setup & strategy', 'Branding & marketing', 'Business growth', 'Activation growth', 'Audit & advisory', 'Consultancy' ), true )
			|| strpos( $s_lower, 'business' ) !== false
			|| strpos( $s_lower, 'consult' ) !== false
			|| strpos( $s_lower, 'advisory' ) !== false
			|| strpos( $s_lower, 'strategy' ) !== false
			|| strpos( $s_lower, 'audit' ) !== false
			|| strpos( $s_lower, 'growth' ) !== false
		) {
			$biz_services_sel[] = $s_clean;
		} elseif (
			in_array( $s_clean, array( 'Event planning', 'Entertainment & talent', 'Design & production', 'Marketing & promotion', 'On-site coordination', 'Events' ), true )
			|| strpos( $s_lower, 'event' ) !== false
			|| strpos( $s_lower, 'entertainment' ) !== false
			|| strpos( $s_lower, 'talent' ) !== false
			|| strpos( $s_lower, 'production' ) !== false
			|| strpos( $s_lower, 'coordination' ) !== false
		) {
			$ev_services_sel[] = $s_clean;
		} else {
			$other_services[] = $s_clean;
		}
	}

	$has_event_wing   = in_array( 'events', $types_arr, true ) || ! empty( $ev_services_sel ) || ! empty( $ev_type ) || ! empty( $ev_date ) || ! empty( $ev_guests ) || ! empty( $ev_venue );
	$has_consult_wing = in_array( 'consultancy', $types_arr, true ) || ! empty( $biz_services_sel ) || ! empty( $biz_name ) || ! empty( $biz_stage );
	$has_partner_wing = in_array( 'partner', $types_arr, true ) || in_array( 'sponsorship', $types_arr, true ) || ! empty( $part_services_sel ) || ! empty( $partner_company ) || ! empty( $partner_interest );

	$list_url = admin_url( 'edit.php?post_type=inquiry' );
	?>
	<div class="crux-inquiry-dashboard" style="font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color:#10142E; margin:-6px -12px -12px; background:#F8FAFD; border-radius:4px; overflow:hidden;">

		<!-- TOP COMMAND BAR -->
		<div style="background:#0A0F26; color:#FFFFFF; padding:20px 24px; display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:16px; border-bottom:3px solid #8C7AE6;">
			<div>
				<div style="font-size:11px; font-weight:700; letter-spacing:2px; text-transform:uppercase; color:#8C7AE6; margin-bottom:6px;">
					CRUX NXTION LEAD DOSSIER &bull; #<?php echo esc_html( $post->ID ); ?>
				</div>
				<h2 style="font-size:22px; margin:0; font-weight:700; color:#FFFFFF; display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
					<span>Lead Contact: <strong style="color:#FFFFFF;"><?php echo esc_html( $name ?: 'Anonymous Client' ); ?></strong></span>
					<?php if ( $has_event_wing && $has_consult_wing && $has_partner_wing ) : ?>
						<span style="font-size:11px; font-weight:700; letter-spacing:0.5px; text-transform:uppercase; background:rgba(140,122,230,0.3); color:#D5CEFA; padding:4px 10px; border-radius:4px;">All 3 Wings Selected</span>
					<?php endif; ?>
				</h2>
			</div>

			<div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
				<div style="display:flex; align-items:center; gap:8px;">
					<label for="_crux_status" style="font-size:12px; font-weight:700; color:#A3A9C8; text-transform:uppercase; letter-spacing:0.5px;">Status:</label>
					<select name="_crux_status" id="_crux_status" style="font-weight:700; font-size:13px; padding:7px 34px 7px 14px; border-radius:6px; border:1.5px solid #2A3B72; background:#111838 url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%238C7AE6' d='M1.4 0L6 4.6 10.6 0 12 1.4l-6 6-6-6z'/%3E%3C/svg%3E&quot;) no-repeat right 12px center; color:#FFFFFF; cursor:pointer; -webkit-appearance:none; appearance:none;">
						<?php
						$statuses = array( 'New', 'Contacted', 'Proposal Sent', 'Booked', 'Archived' );
						foreach ( $statuses as $st ) {
							echo '<option value="' . esc_attr( $st ) . '" ' . selected( $status, $st, false ) . '>' . esc_html( $st ) . '</option>';
						}
						?>
					</select>
				</div>
				<?php if ( $email ) : ?>
					<a href="mailto:<?php echo esc_attr( $email ); ?>?subject=Crux%20Nxtion%20Lead%20Brief%20-%20<?php echo rawurlencode( $name ); ?>" class="button" style="background:#8C7AE6; border-color:#8C7AE6; color:#10142E; font-weight:700; padding:6px 14px; height:auto; line-height:1.5;">
						✉ Reply via Email
					</a>
				<?php endif; ?>
				<?php if ( $phone ) : ?>
					<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="button" style="background:#111838; border-color:#2A3B72; color:#FFFFFF; font-weight:700; padding:6px 14px; height:auto; line-height:1.5;">
						✆ Call Client
					</a>
				<?php endif; ?>
				<button type="button" onclick="window.print()" class="button" style="background:#111838; border-color:#2A3B72; color:#A3A9C8; padding:6px 12px; height:auto; line-height:1.5;">
					🖶 Print
				</button>
				<a href="<?php echo esc_url( $list_url ); ?>" class="button" style="background:transparent; border-color:#2A3B72; color:#A3A9C8; padding:6px 12px; height:auto; line-height:1.5;">
					&larr; All Inquiries
				</a>
			</div>
		</div>

		<!-- PIPELINE LIFECYCLE PROGRESS BAR -->
		<div style="background:#0F1635; padding:12px 24px; border-bottom:1px solid #1E2B5E; display:flex; align-items:center; gap:8px; overflow-x:auto;">
			<span style="font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase; color:#7A82A8; margin-right:8px; white-space:nowrap;">Pipeline Stage:</span>
			<?php
			$stages = array( 'New', 'Contacted', 'Proposal Sent', 'Booked', 'Archived' );
			$reached = true;
			foreach ( $stages as $idx => $st ) {
				$is_curr = ( $status === $st );
				$bg_dot = $is_curr ? '#3DDC84' : ( $reached ? '#8C7AE6' : '#2A3356' );
				$text_color = $is_curr ? '#FFFFFF' : ( $reached ? '#CCD3EE' : '#5A6384' );
				$font_weight = $is_curr ? '800' : '600';
				echo '<div style="display:flex; align-items:center; gap:6px; font-size:12px; color:' . esc_attr( $text_color ) . '; font-weight:' . esc_attr( $font_weight ) . '; white-space:nowrap;">';
				echo '<span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:' . esc_attr( $bg_dot ) . ';"></span>';
				echo esc_html( $st );
				if ( $idx < count( $stages ) - 1 ) {
					echo '<span style="color:#2A3356; margin:0 4px;">&rarr;</span>';
				}
				echo '</div>';
				if ( $is_curr ) {
					$reached = false;
				}
			}
			?>
		</div>

		<!-- WINGS & CONTACT COORDINATES -->
		<div style="padding:22px 24px; background:#FFFFFF; border-bottom:1px solid #E1DEF3; display:grid; grid-template-columns:1.2fr 1fr; gap:24px;">
			<!-- Active Wings -->
			<div>
				<div style="font-size:11px; font-weight:800; letter-spacing:1.5px; text-transform:uppercase; color:#5A5F86; margin-bottom:10px;">
					REQUESTED COMMERCIAL WINGS
				</div>
				<div style="display:flex; gap:8px; flex-wrap:wrap;">
					<?php
					if ( $has_event_wing ) {
						echo '<span style="background:#002671; color:#FFFFFF; font-weight:700; padding:6px 14px; font-size:12px; display:inline-block; clip-path:polygon(6px 0,100% 0,calc(100% - 6px) 100%,0 100%);">● EVENTS WING</span>';
					}
					if ( $has_consult_wing ) {
						echo '<span style="background:#8C7AE6; color:#10142E; font-weight:700; padding:6px 14px; font-size:12px; display:inline-block; clip-path:polygon(6px 0,100% 0,calc(100% - 6px) 100%,0 100%);">● BUSINESS CONSULTANCY</span>';
					}
					if ( $has_partner_wing ) {
						echo '<span style="background:#BA0000; color:#FFFFFF; font-weight:700; padding:6px 14px; font-size:12px; display:inline-block; clip-path:polygon(6px 0,100% 0,calc(100% - 6px) 100%,0 100%);">● SPONSORSHIP &amp; PARTNERSHIP</span>';
					}
					?>
				</div>
			</div>

			<!-- Direct Contact Details -->
			<div>
				<div style="font-size:11px; font-weight:800; letter-spacing:1.5px; text-transform:uppercase; color:#5A5F86; margin-bottom:10px;">
					CLIENT CONTACT INFO &amp; ORIGIN
				</div>
				<div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; font-size:13px;">
					<div>
						<div style="color:#5A5F86; font-size:11px; font-weight:700; text-transform:uppercase;">Email Address</div>
						<div style="margin-top:2px;">
							<?php echo $email ? '<a href="mailto:' . esc_attr( $email ) . '" style="color:#002671; font-weight:700;">' . esc_html( $email ) . '</a>' : '<em style="color:#888;">Not provided</em>'; ?>
						</div>
					</div>
					<div>
						<div style="color:#5A5F86; font-size:11px; font-weight:700; text-transform:uppercase;">Phone Number</div>
						<div style="margin-top:2px;">
							<?php echo $phone ? '<a href="tel:' . esc_attr( $phone ) . '" style="color:#002671; font-weight:700;">' . esc_html( $phone ) . '</a>' : '<em style="color:#888;">Not provided</em>'; ?>
						</div>
					</div>
					<div>
						<div style="color:#5A5F86; font-size:11px; font-weight:700; text-transform:uppercase;">Date Received</div>
						<div style="margin-top:2px; font-weight:600; color:#10142E;">
							<?php echo get_the_date( 'd M Y, H:i T', $post->ID ); ?>
						</div>
					</div>
					<div>
						<div style="color:#5A5F86; font-size:11px; font-weight:700; text-transform:uppercase;">Origin IP Address</div>
						<div style="margin-top:2px; font-family:monospace; font-size:12px; color:#5A5F86;">
							<?php echo esc_html( $ip ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- SELECTED SERVICES SHOWCASE -->
		<div style="padding:22px 24px; background:#FFFFFF; border-bottom:1px solid #E1DEF3;">
			<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
				<div style="font-size:11px; font-weight:800; letter-spacing:1.5px; text-transform:uppercase; color:#5A5F86;">
					SELECTED SERVICES BY DISCIPLINE (<?php echo count( $services ); ?> TOTAL SELECTED)
				</div>
			</div>
			<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:18px;">

				<!-- Event Services Box -->
				<div style="background:#F4F6FC; border:1.5px solid #CCD8F5; border-top:4px solid #002671; border-radius:8px; padding:16px 18px;">
					<div style="font-size:11.5px; font-weight:800; color:#002671; letter-spacing:1px; margin-bottom:12px; display:flex; align-items:center; justify-content:space-between;">
						<span>EVENTS SERVICES (<?php echo count( $ev_services_sel ); ?>)</span>
						<span style="display:inline-block; width:8px; height:8px; background:#002671; border-radius:50%;"></span>
					</div>
					<?php if ( ! empty( $ev_services_sel ) ) : ?>
						<div style="display:flex; flex-wrap:wrap; gap:6px;">
							<?php foreach ( $ev_services_sel as $s ) : ?>
								<span style="background:#002671; color:#FFFFFF; font-weight:700; font-size:12px; padding:4px 10px; clip-path:polygon(4px 0,100% 0,calc(100% - 4px) 100%,0 100%);"><?php echo esc_html( $s ); ?></span>
							<?php endforeach; ?>
						</div>
					<?php else : ?>
						<p style="margin:0; font-size:12.5px; color:#888; font-style:italic;">None specifically ticked</p>
					<?php endif; ?>
				</div>

				<!-- Consultancy Services Box -->
				<div style="background:#F7F5FE; border:1.5px solid #D5CEFA; border-top:4px solid #8C7AE6; border-radius:8px; padding:16px 18px;">
					<div style="font-size:11.5px; font-weight:800; color:#6C58DB; letter-spacing:1px; margin-bottom:12px; display:flex; align-items:center; justify-content:space-between;">
						<span>CONSULTANCY SERVICES (<?php echo count( $biz_services_sel ); ?>)</span>
						<span style="display:inline-block; width:8px; height:8px; background:#8C7AE6; border-radius:50%;"></span>
					</div>
					<?php if ( ! empty( $biz_services_sel ) ) : ?>
						<div style="display:flex; flex-wrap:wrap; gap:6px;">
							<?php foreach ( $biz_services_sel as $s ) : ?>
								<span style="background:#8C7AE6; color:#10142E; font-weight:700; font-size:12px; padding:4px 10px; clip-path:polygon(4px 0,100% 0,calc(100% - 4px) 100%,0 100%);"><?php echo esc_html( $s ); ?></span>
							<?php endforeach; ?>
						</div>
					<?php else : ?>
						<p style="margin:0; font-size:12.5px; color:#888; font-style:italic;">None specifically ticked</p>
					<?php endif; ?>
				</div>

				<!-- Partnership Services Box -->
				<div style="background:#FFF5F5; border:1.5px solid #F5C6C6; border-top:4px solid #BA0000; border-radius:8px; padding:16px 18px;">
					<div style="font-size:11.5px; font-weight:800; color:#BA0000; letter-spacing:1px; margin-bottom:12px; display:flex; align-items:center; justify-content:space-between;">
						<span>PARTNERSHIP SERVICES (<?php echo count( $part_services_sel ); ?>)</span>
						<span style="display:inline-block; width:8px; height:8px; background:#BA0000; border-radius:50%;"></span>
					</div>
					<?php if ( ! empty( $part_services_sel ) ) : ?>
						<div style="display:flex; flex-wrap:wrap; gap:6px;">
							<?php foreach ( $part_services_sel as $s ) : ?>
								<span style="background:#BA0000; color:#FFFFFF; font-weight:700; font-size:12px; padding:4px 10px; clip-path:polygon(4px 0,100% 0,calc(100% - 4px) 100%,0 100%);"><?php echo esc_html( $s ); ?></span>
							<?php endforeach; ?>
						</div>
					<?php else : ?>
						<p style="margin:0; font-size:12.5px; color:#888; font-style:italic;">None specifically ticked</p>
					<?php endif; ?>
				</div>

				<!-- Additional / Special Services (if any) -->
				<?php if ( ! empty( $other_services ) ) : ?>
				<div style="background:#F0F2F9; border:1.5px solid #CCD2E8; border-top:4px solid #1E2B5E; border-radius:8px; padding:16px 18px;">
					<div style="font-size:11.5px; font-weight:800; color:#1E2B5E; letter-spacing:1px; margin-bottom:12px; display:flex; align-items:center; justify-content:space-between;">
						<span>ADDITIONAL DISCIPLINES (<?php echo count( $other_services ); ?>)</span>
						<span style="display:inline-block; width:8px; height:8px; background:#1E2B5E; border-radius:50%;"></span>
					</div>
					<div style="display:flex; flex-wrap:wrap; gap:6px;">
						<?php foreach ( $other_services as $s ) : ?>
							<span style="background:#1E2B5E; color:#FFFFFF; font-weight:700; font-size:12px; padding:4px 10px; clip-path:polygon(4px 0,100% 0,calc(100% - 4px) 100%,0 100%);"><?php echo esc_html( $s ); ?></span>
						<?php endforeach; ?>
					</div>
				</div>
				<?php endif; ?>

			</div>
		</div>

		<!-- SPECIFICATION CARDS -->
		<div style="padding:22px 24px; background:#F8FAFD; border-bottom:1px solid #E1DEF3; display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:20px;">

			<!-- Event Specs -->
			<div style="background:#FFFFFF; border:1.5px solid #CCD8F5; border-top:4px solid #002671; border-radius:8px; padding:18px;">
				<div style="font-size:12px; font-weight:800; color:#002671; letter-spacing:1px; margin-bottom:12px; text-transform:uppercase; display:flex; justify-content:space-between;">
					<span>EVENT SPECIFICATIONS</span>
					<?php if ( $has_event_wing ) : ?>
						<span style="font-size:10px; background:#002671; color:#fff; padding:2px 6px; border-radius:3px;">ACTIVE</span>
					<?php endif; ?>
				</div>
				<div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; font-size:13px;">
					<div>
						<div style="color:#5A5F86; font-size:11px; font-weight:700; text-transform:uppercase;">Event Type</div>
						<div style="font-weight:600; margin-top:2px; color:#10142E;"><?php echo esc_html( $ev_type ?: ( $has_event_wing ? 'Standard Production' : 'Not specified' ) ); ?></div>
					</div>
					<div>
						<div style="color:#5A5F86; font-size:11px; font-weight:700; text-transform:uppercase;">Target Date</div>
						<div style="font-weight:600; margin-top:2px; color:#10142E;"><?php echo esc_html( $ev_date ?: 'Flexible / TBD' ); ?></div>
					</div>
					<div>
						<div style="color:#5A5F86; font-size:11px; font-weight:700; text-transform:uppercase;">Approx Guests</div>
						<div style="font-weight:600; margin-top:2px; color:#10142E;"><?php echo esc_html( $ev_guests ?: 'TBD' ); ?></div>
					</div>
					<div>
						<div style="color:#5A5F86; font-size:11px; font-weight:700; text-transform:uppercase;">City / Venue</div>
						<div style="font-weight:600; margin-top:2px; color:#10142E;"><?php echo esc_html( $ev_venue ?: 'Not specified' ); ?></div>
					</div>
				</div>
			</div>

			<!-- Consultancy Specs -->
			<div style="background:#FFFFFF; border:1.5px solid #D5CEFA; border-top:4px solid #8C7AE6; border-radius:8px; padding:18px;">
				<div style="font-size:12px; font-weight:800; color:#6C58DB; letter-spacing:1px; margin-bottom:12px; text-transform:uppercase; display:flex; justify-content:space-between;">
					<span>BUSINESS CONSULTANCY SPECS</span>
					<?php if ( $has_consult_wing ) : ?>
						<span style="font-size:10px; background:#8C7AE6; color:#10142E; padding:2px 6px; border-radius:3px;">ACTIVE</span>
					<?php endif; ?>
				</div>
				<div style="display:grid; grid-template-columns:1fr; gap:12px; font-size:13px;">
					<div>
						<div style="color:#5A5F86; font-size:11px; font-weight:700; text-transform:uppercase;">Business / Brand Name</div>
						<div style="font-weight:600; margin-top:2px; color:#10142E;"><?php echo esc_html( $biz_name ?: ( $has_consult_wing ? 'Confidential Client' : 'Not provided' ) ); ?></div>
					</div>
					<div>
						<div style="color:#5A5F86; font-size:11px; font-weight:700; text-transform:uppercase;">Company Stage</div>
						<div style="font-weight:600; margin-top:2px; color:#10142E;"><?php echo esc_html( $biz_stage ?: 'Not specified' ); ?></div>
					</div>
				</div>
			</div>

			<!-- Partnership Specs -->
			<div style="background:#FFFFFF; border:1.5px solid #F5C6C6; border-top:4px solid #BA0000; border-radius:8px; padding:18px;">
				<div style="font-size:12px; font-weight:800; color:#BA0000; letter-spacing:1px; margin-bottom:12px; text-transform:uppercase; display:flex; justify-content:space-between;">
					<span>SPONSORSHIP &amp; PARTNERSHIP SPECS</span>
					<?php if ( $has_partner_wing ) : ?>
						<span style="font-size:10px; background:#BA0000; color:#fff; padding:2px 6px; border-radius:3px;">ACTIVE</span>
					<?php endif; ?>
				</div>
				<div style="display:grid; grid-template-columns:1fr; gap:12px; font-size:13px;">
					<div>
						<div style="color:#5A5F86; font-size:11px; font-weight:700; text-transform:uppercase;">Brand / Organization Name</div>
						<div style="font-weight:600; margin-top:2px; color:#10142E;"><?php echo esc_html( $partner_company ?: ( $has_partner_wing ? 'Brand / Sponsor' : 'Not provided' ) ); ?></div>
					</div>
					<div>
						<div style="color:#5A5F86; font-size:11px; font-weight:700; text-transform:uppercase;">Partnership Interest</div>
						<div style="font-weight:600; margin-top:2px; color:#10142E;"><?php echo esc_html( $partner_interest ?: 'General Collaboration / Sponsorship' ); ?></div>
					</div>
				</div>
			</div>

		</div>

		<!-- CLIENT BRIEF / STATEMENT OF REQUIREMENTS (CLEAN CARD BOX, NEVER FLOATING) -->
		<div style="padding:22px 24px; background:#FFFFFF; border-bottom:1px solid #E1DEF3;">
			<div style="border:1.5px solid #CCD2E8; border-radius:8px; overflow:hidden; background:#F8FAFD; box-shadow:inset 0 1px 3px rgba(0,0,0,0.03);">
				<div style="display:flex; justify-content:space-between; align-items:center; padding:12px 18px; background:#EEF2FA; border-bottom:1px solid #CCD2E8;">
					<span style="font-size:11.5px; font-weight:800; letter-spacing:1.5px; text-transform:uppercase; color:#0A0F26;">
						CLIENT'S WRITTEN BRIEF &amp; MESSAGE
					</span>
					<span style="font-size:11px; font-weight:600; color:#5A5F86;">
						Verbatim Lead Intake
					</span>
				</div>
				<div style="padding:20px 22px; font-size:14.5px; line-height:1.75; color:#10142E; white-space:pre-wrap; background:#FFFFFF; min-height:90px;">
					<?php echo esc_html( $message ?: 'No additional message or notes were provided with this brief.' ); ?>
				</div>
			</div>
		</div>

		<!-- INTERNAL PRODUCTION ASSIGNMENT, QUOTE LEDGER & TEAM NOTES -->
		<div style="padding:22px 24px; background:#F8FAFD;">
			<div style="font-size:11.5px; font-weight:800; letter-spacing:1.5px; text-transform:uppercase; color:#0A0F26; margin-bottom:14px;">
				INTERNAL PRODUCTION ASSIGNMENT &amp; COMMERCIAL LEDGER
			</div>

			<div style="display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:16px;">
				<div>
					<label for="_crux_director" style="display:block; font-size:11px; font-weight:700; text-transform:uppercase; color:#5A5F86; margin-bottom:6px;">
						Lead Technical Director Assigned:
					</label>
					<input type="text" id="_crux_director" name="_crux_director" value="<?php echo esc_attr( $director ); ?>" placeholder="e.g. Olabamidele Badmos / Marcus Vance" class="widefat" style="padding:8px 12px; font-weight:600; border-radius:4px; border:1px solid #CCD2E8;">
				</div>
				<div>
					<label for="_crux_budget" style="display:block; font-size:11px; font-weight:700; text-transform:uppercase; color:#5A5F86; margin-bottom:6px;">
						Estimated Project Budget / Quote (£ GBP):
					</label>
					<input type="text" id="_crux_budget" name="_crux_budget" value="<?php echo esc_attr( $budget ); ?>" placeholder="e.g. £25,000" class="widefat" style="padding:8px 12px; font-weight:600; font-family:monospace; border-radius:4px; border:1px solid #CCD2E8;">
				</div>
			</div>

			<div style="margin-bottom:18px;">
				<label for="_crux_internal_notes" style="display:block; font-size:11px; font-weight:700; text-transform:uppercase; color:#5A5F86; margin-bottom:6px;">
					Internal Team Working Log &amp; Private Status Notes:
				</label>
				<textarea id="_crux_internal_notes" name="_crux_internal_notes" rows="4" class="widefat" placeholder="Add confidential notes on phone calls, discovery call feedback, client budget discussions, next steps..." style="padding:10px 12px; font-size:13px; line-height:1.6; border-radius:4px; border:1px solid #CCD2E8; background:#FFFFFF;"><?php echo esc_textarea( $internal_notes ); ?></textarea>
			</div>

			<div style="display:flex; justify-content:space-between; align-items:center; padding-top:12px; border-top:1px solid #E1DEF3;">
				<span style="font-size:12px; color:#5A5F86;">
					Click "Save Dossier" to store updated status, director assignment, budget, and internal notes.
				</span>
				<button type="submit" class="button button-primary button-large" style="background:#002671; border-color:#002671; font-weight:700; padding:4px 22px;">
					Save Dossier Changes
				</button>
			</div>
		</div>

	</div>
	<?php
}

function crux_save_inquiry_meta( $post_id ) {
	if ( ! isset( $_POST['crux_inquiry_meta_nonce'] ) || ! wp_verify_nonce( $_POST['crux_inquiry_meta_nonce'], 'crux_save_inquiry_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( isset( $_POST['_crux_status'] ) ) {
		update_post_meta( $post_id, '_crux_status', sanitize_text_field( $_POST['_crux_status'] ) );
	}
	if ( isset( $_POST['_crux_director'] ) ) {
		update_post_meta( $post_id, '_crux_director', sanitize_text_field( $_POST['_crux_director'] ) );
	}
	if ( isset( $_POST['_crux_budget'] ) ) {
		update_post_meta( $post_id, '_crux_budget', sanitize_text_field( $_POST['_crux_budget'] ) );
	}
	if ( isset( $_POST['_crux_internal_notes'] ) ) {
		update_post_meta( $post_id, '_crux_internal_notes', sanitize_textarea_field( $_POST['_crux_internal_notes'] ) );
	}
}
add_action( 'save_post_inquiry', 'crux_save_inquiry_meta' );

/**
 * 4. AJAX Endpoint: Submit Contact Brief
 */
function crux_ajax_submit_inquiry() {
	// 1. Honeypot Anti-Spam Check (Silently drop bots without saving or mailing)
	$honeypot = isset( $_POST['crux_hp'] ) ? sanitize_text_field( wp_unslash( $_POST['crux_hp'] ) ) : '';
	if ( ! empty( $honeypot ) ) {
		wp_send_json_success( array(
			'message'   => __( 'Your brief has been transmitted directly to our team. A real person will review it and reply shortly.', 'crux-nxtion-core' ),
			'name'      => sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) ),
			'lead_type' => 'events',
		) );
	}

	// 2. Time-Gate Spam Defense (Bots submit form unrealistically fast < 3 seconds)
	$form_time = isset( $_POST['form_timestamp'] ) ? intval( $_POST['form_timestamp'] ) : 0;
	if ( $form_time > 0 && ( time() - $form_time ) < 3 ) {
		wp_send_json_success( array(
			'message'   => __( 'Your brief has been transmitted directly to our team. A real person will review it and reply shortly.', 'crux-nxtion-core' ),
			'name'      => sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) ),
			'lead_type' => 'events',
		) );
	}

	// 3. IP Rate Limiting Check (Max 5 submissions per 10 minutes)
	$user_ip       = ! empty( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '127.0.0.1';
	$transient_key = 'crux_sub_rate_' . md5( $user_ip );
	$sub_count     = intval( get_transient( $transient_key ) );
	if ( $sub_count >= 5 ) {
		wp_send_json_error( array(
			'message' => __( 'Too many submissions detected from your connection. Please wait a few minutes before submitting another brief.', 'crux-nxtion-core' ),
		) );
	}
	set_transient( $transient_key, $sub_count + 1, 10 * MINUTE_IN_SECONDS );

	// Graceful Nonce Check (prevents 403 Forbidden on cached pages)
	$nonce_valid = ! empty( $_POST['security'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['security'] ) ), 'crux_inquiry_nonce' );

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['phone'] ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( $_POST['message'] ) : '';

	// Service chips (array)
	$services = array();
	if ( isset( $_POST['services'] ) && is_array( $_POST['services'] ) ) {
		$services = array_map( 'sanitize_text_field', $_POST['services'] );
	}

	// Dynamic Event details
	$ev_type   = isset( $_POST['ev_type'] ) ? sanitize_text_field( $_POST['ev_type'] ) : '';
	$ev_date   = isset( $_POST['ev_date'] ) ? sanitize_text_field( $_POST['ev_date'] ) : '';
	$ev_guests = isset( $_POST['ev_guests'] ) ? sanitize_text_field( $_POST['ev_guests'] ) : '';
	$ev_venue  = isset( $_POST['ev_venue'] ) ? sanitize_text_field( $_POST['ev_venue'] ) : '';

	// Dynamic Business details
	$biz_name  = isset( $_POST['biz_name'] ) ? sanitize_text_field( $_POST['biz_name'] ) : '';
	$biz_stage = isset( $_POST['biz_stage'] ) ? sanitize_text_field( $_POST['biz_stage'] ) : '';

	// Dynamic Partnership details
	$partner_company  = isset( $_POST['partner_company'] ) ? sanitize_text_field( $_POST['partner_company'] ) : '';
	$partner_interest = isset( $_POST['partner_interest'] ) ? sanitize_text_field( $_POST['partner_interest'] ) : '';

	if ( empty( $name ) || empty( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Please provide your name and email address.', 'crux-nxtion-core' ) ) );
	}

	// Parse Selected Tabs (allows selecting 1, 2, or all 3 tabs simultaneously)
	$tabs = array();
	if ( isset( $_POST['selected_tabs'] ) ) {
		if ( is_array( $_POST['selected_tabs'] ) ) {
			$tabs = array_map( 'sanitize_text_field', wp_unslash( $_POST['selected_tabs'] ) );
		} else {
			$tabs = array_filter( array_map( 'trim', explode( ',', sanitize_text_field( wp_unslash( $_POST['selected_tabs'] ) ) ) ) );
		}
	} elseif ( isset( $_POST['inquiry_type'] ) ) {
		$raw_type = sanitize_text_field( wp_unslash( $_POST['inquiry_type'] ) );
		if ( $raw_type === 'all' ) {
			$tabs = array( 'events', 'consultancy', 'partner' );
		} elseif ( $raw_type === 'both' ) {
			$tabs = array( 'events', 'consultancy' );
		} else {
			$tabs = array_filter( array_map( 'trim', explode( ',', $raw_type ) ) );
		}
	}

	// Determine Wing Associations
	$event_services       = array( 'Event planning', 'Entertainment & talent', 'Design & production', 'Marketing & promotion', 'On-site coordination' );
	$consultancy_services = array( 'Business setup & strategy', 'Branding & marketing', 'Business growth', 'Activation growth', 'Audit & advisory' );
	$partner_services     = array( 'Event sponsorship', 'Brand partnership', 'Brand activation partner', 'Talent collaboration', 'Media & press partnership', 'Media & talent collaboration', 'Vendor / Supplier', 'Vendor & catering partner', 'Partnership', 'Sponsorship' );

	$has_event       = in_array( 'events', $tabs, true ) || ! empty( array_intersect( $services, $event_services ) ) || $ev_type || $ev_date || $ev_guests || $ev_venue;
	$has_consultancy = in_array( 'consultancy', $tabs, true ) || ! empty( array_intersect( $services, $consultancy_services ) ) || $biz_name || $biz_stage;
	$has_partner     = in_array( 'partner', $tabs, true ) || in_array( 'sponsorship', $tabs, true ) || ! empty( array_intersect( $services, $partner_services ) ) || $partner_company || $partner_interest;

	$active_wings = array();
	if ( $has_event ) $active_wings[] = 'events';
	if ( $has_consultancy ) $active_wings[] = 'consultancy';
	if ( $has_partner ) $active_wings[] = 'partner';

	if ( count( $active_wings ) === 3 ) {
		$lead_type = 'all';
		$brief_title_wing = 'All Wings Brief (Events, Consultancy & Partnership)';
	} elseif ( count( $active_wings ) === 2 ) {
		if ( in_array( 'events', $active_wings, true ) && in_array( 'consultancy', $active_wings, true ) ) {
			$lead_type = 'both';
			$brief_title_wing = 'Events & Consultancy Brief';
		} elseif ( in_array( 'events', $active_wings, true ) && in_array( 'partner', $active_wings, true ) ) {
			$lead_type = 'events,partner';
			$brief_title_wing = 'Events & Partnership Brief';
		} else {
			$lead_type = 'consultancy,partner';
			$brief_title_wing = 'Consultancy & Partnership Brief';
		}
	} elseif ( count( $active_wings ) === 1 ) {
		$lead_type = $active_wings[0];
		$brief_title_wing = ucfirst( $lead_type === 'partner' ? 'Partnership' : $lead_type ) . ' Brief';
	} else {
		$lead_type = 'events';
		$brief_title_wing = 'Events Brief';
	}

	// Insert Post into WordPress CPT
	$post_title = $name . ' — ' . $brief_title_wing;
	$post_id = wp_insert_post( array(
		'post_type'    => 'inquiry',
		'post_title'   => $post_title,
		'post_status'  => 'publish',
		'post_content' => $message,
	) );

	if ( is_wp_error( $post_id ) ) {
		wp_send_json_error( array( 'message' => __( 'Database error. Please try again or email us directly.', 'crux-nxtion-core' ) ) );
	}

	// Save Post Meta
	update_post_meta( $post_id, '_crux_name', $name );
	update_post_meta( $post_id, '_crux_email', $email );
	update_post_meta( $post_id, '_crux_phone', $phone );
	update_post_meta( $post_id, '_crux_message', $message );
	update_post_meta( $post_id, '_crux_services', $services );
	update_post_meta( $post_id, '_crux_lead_type', $lead_type );
	update_post_meta( $post_id, '_crux_selected_tabs', $active_wings );
	update_post_meta( $post_id, '_crux_status', 'New' );
	update_post_meta( $post_id, '_crux_ev_type', $ev_type );
	update_post_meta( $post_id, '_crux_ev_date', $ev_date );
	update_post_meta( $post_id, '_crux_ev_guests', $ev_guests );
	update_post_meta( $post_id, '_crux_ev_venue', $ev_venue );
	update_post_meta( $post_id, '_crux_biz_name', $biz_name );
	update_post_meta( $post_id, '_crux_biz_stage', $biz_stage );
	update_post_meta( $post_id, '_crux_partner_company', $partner_company );
	update_post_meta( $post_id, '_crux_partner_interest', $partner_interest );
	$ip = ! empty( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '127.0.0.1';
	update_post_meta( $post_id, '_crux_ip', $ip );

	// Dispatch Email Notifications
	$admin_recipient = 'infoandsales@cruxnxtion.co.uk';
	$subject = '[' . strtoupper( $lead_type ) . '] New Crux Nxtion Brief from ' . $name;
	$headers = array( 'Content-Type: text/html; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>' );

	$body = '<h2>New Client Brief Received</h2>';
	$body .= '<p><strong>Lead Type:</strong> ' . strtoupper( $lead_type ) . ' (' . esc_html( $brief_title_wing ) . ')</p>';
	$body .= '<p><strong>Client:</strong> ' . esc_html( $name ) . ' (' . esc_html( $email ) . ', ' . esc_html( $phone ) . ')</p>';
	$body .= '<p><strong>Services:</strong> ' . esc_html( implode( ', ', $services ) ) . '</p>';
	if ( $has_event && ( $ev_type || $ev_date || $ev_guests || $ev_venue ) ) {
		$body .= '<p><strong>Event Specs:</strong> ' . esc_html( $ev_type ) . ' | Date: ' . esc_html( $ev_date ) . ' | Guests: ' . esc_html( $ev_guests ) . ' | Venue: ' . esc_html( $ev_venue ) . '</p>';
	}
	if ( $has_consultancy && ( $biz_name || $biz_stage ) ) {
		$body .= '<p><strong>Consultancy Specs:</strong> ' . esc_html( $biz_name ) . ' | Stage: ' . esc_html( $biz_stage ) . '</p>';
	}
	if ( $has_partner && ( $partner_company || $partner_interest ) ) {
		$body .= '<p><strong>Partnership Specs:</strong> ' . esc_html( $partner_company ) . ' | Interest: ' . esc_html( $partner_interest ) . '</p>';
	}
	$body .= '<p><strong>Message:</strong><br>' . nl2br( esc_html( $message ) ) . '</p>';
	$body .= '<hr><p><a href="' . admin_url( 'post.php?post=' . $post_id . '&action=edit' ) . '">View Full Brief in WP Admin &rarr;</a></p>';

	@wp_mail( $admin_recipient, $subject, $body, $headers );

	// Client confirmation receipt
	$client_subject = 'Crux Nxtion — We have received your brief';
	$client_body = '<div style="font-family:sans-serif; max-width:600px; margin:0 auto; padding:24px; color:#10142E;">';
	$client_body .= '<h1 style="color:#002671;">CRUX NXTION</h1>';
	$client_body .= '<p>Hello ' . esc_html( $name ) . ',</p>';
	$client_body .= '<p>Thank you for reaching out. We have received your brief and our team will review the details and come back to you shortly.</p>';
	$client_body .= '<p style="color:#5A5F86; font-size:13px;">Crux Nxtion • 29 Dun Work, Sheffield S3 8FB • infoandsales@cruxnxtion.co.uk</p>';
	$client_body .= '</div>';

	@wp_mail( $email, $client_subject, $client_body, array( 'Content-Type: text/html; charset=UTF-8' ) );

	wp_send_json_success( array(
		'message'   => __( 'Your brief has been transmitted directly to our team. A real person will review it and reply shortly.', 'crux-nxtion-core' ),
		'name'      => $name,
		'lead_type' => $lead_type
	) );
}
add_action( 'wp_ajax_crux_submit_inquiry', 'crux_ajax_submit_inquiry' );
add_action( 'wp_ajax_nopriv_crux_submit_inquiry', 'crux_ajax_submit_inquiry' );
