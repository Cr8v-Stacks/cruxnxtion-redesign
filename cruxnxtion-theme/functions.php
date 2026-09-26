<?php
/**
 * Crux Nxtion Theme Functions & Definitions
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CRUX_THEME_VERSION', '1.5.3' );

// Include Core Theme Engines
require_once get_template_directory() . '/inc/prevent-errors.php';
require_once get_template_directory() . '/inc/media-importer.php';
require_once get_template_directory() . '/inc/demo-importer.php';

/**
 * Theme Setup
 */
function crux_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 220,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
}
add_action( 'after_setup_theme', 'crux_theme_setup' );

/**
 * Enqueue Styles and Scripts
 */
function crux_enqueue_assets() {
	// Google Fonts: Bebas Neue & Space Grotesk
	wp_enqueue_style(
		'crux-fonts',
		'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Space+Grotesk:wght@400;500;600;700;800&display=swap',
		array(),
		null
	);

	// Root Theme Stylesheet
	wp_enqueue_style(
		'crux-style',
		get_stylesheet_uri(),
		array( 'crux-fonts' ),
		CRUX_THEME_VERSION
	);

	// Main Custom Interaction & AJAX Script
	wp_enqueue_script(
		'crux-main-js',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		CRUX_THEME_VERSION,
		true
	);

	// Pass AJAX parameters to frontend
	wp_localize_script( 'crux-main-js', 'crux_ajax_obj', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce'    => wp_create_nonce( 'crux_inquiry_nonce' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'crux_enqueue_assets' );

/**
 * Self-healing rewrite rules flush for custom events and pages
 */
function crux_maybe_flush_rewrites() {
	if ( get_option( 'crux_theme_flushed_version' ) !== CRUX_THEME_VERSION ) {
		flush_rewrite_rules( false );
		update_option( 'crux_theme_flushed_version', CRUX_THEME_VERSION );
	}
}
add_action( 'init', 'crux_maybe_flush_rewrites', 99 );

/**
 * AJAX Handler for Contact Brief Inquiries (Theme Fallback)
 */
if ( ! function_exists( 'crux_ajax_submit_inquiry' ) ) {
	function crux_ajax_submit_inquiry() {
		// 1. Honeypot Anti-Spam Check (Silently drop bots without saving or mailing)
		$honeypot = isset( $_POST['crux_hp'] ) ? sanitize_text_field( wp_unslash( $_POST['crux_hp'] ) ) : '';
		if ( ! empty( $honeypot ) ) {
			wp_send_json_success( array(
				'message'   => __( 'Your brief has been transmitted directly to our team. A real person will review it and reply within 24 business hours.', 'cruxnxtion' ),
				'name'      => sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) ),
				'lead_type' => 'events',
			) );
		}

		// 2. Time-Gate Spam Defense (Bots submit form unrealistically fast < 3 seconds)
		$form_time = isset( $_POST['form_timestamp'] ) ? intval( $_POST['form_timestamp'] ) : 0;
		if ( $form_time > 0 && ( time() - $form_time ) < 3 ) {
			wp_send_json_success( array(
				'message'   => __( 'Your brief has been transmitted directly to our team. A real person will review it and reply within 24 business hours.', 'cruxnxtion' ),
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
				'message' => __( 'Too many submissions detected from your connection. Please wait a few minutes before submitting another brief.', 'cruxnxtion' ),
			) );
		}
		set_transient( $transient_key, $sub_count + 1, 10 * MINUTE_IN_SECONDS );

		// Nonce Check
		$nonce_valid = ! empty( $_POST['security'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['security'] ) ), 'crux_inquiry_nonce' );

		$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
		$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
		$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
		$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

		if ( empty( $name ) || empty( $email ) ) {
			wp_send_json_error( array( 'message' => __( 'Please provide your name and email address.', 'cruxnxtion' ) ) );
		}

		$services = array();
		if ( isset( $_POST['services'] ) && is_array( $_POST['services'] ) ) {
			$services = array_map( 'sanitize_text_field', wp_unslash( $_POST['services'] ) );
		}

		$ev_type   = isset( $_POST['ev_type'] ) ? sanitize_text_field( wp_unslash( $_POST['ev_type'] ) ) : '';
		$ev_date   = isset( $_POST['ev_date'] ) ? sanitize_text_field( wp_unslash( $_POST['ev_date'] ) ) : '';
		$ev_guests = isset( $_POST['ev_guests'] ) ? sanitize_text_field( wp_unslash( $_POST['ev_guests'] ) ) : '';
		$ev_venue  = isset( $_POST['ev_venue'] ) ? sanitize_text_field( wp_unslash( $_POST['ev_venue'] ) ) : '';

		$biz_name  = isset( $_POST['biz_name'] ) ? sanitize_text_field( wp_unslash( $_POST['biz_name'] ) ) : '';
		$biz_stage = isset( $_POST['biz_stage'] ) ? sanitize_text_field( wp_unslash( $_POST['biz_stage'] ) ) : '';

		$partner_company  = isset( $_POST['partner_company'] ) ? sanitize_text_field( wp_unslash( $_POST['partner_company'] ) ) : '';
		$partner_interest = isset( $_POST['partner_interest'] ) ? sanitize_text_field( wp_unslash( $_POST['partner_interest'] ) ) : '';

		// Parse Selected Tabs
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

		$event_services       = array( 'Event planning', 'Entertainment & talent', 'Design & production', 'Marketing & promotion', 'On-site coordination' );
		$consultancy_services = array( 'Business setup & strategy', 'Branding & marketing', 'Business growth', 'Activation growth', 'Audit & advisory' );
		$partner_services     = array( 'Event sponsorship', 'Brand partnership', 'Talent collaboration', 'Media & press partnership', 'Vendor / Supplier' );

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

		if ( post_type_exists( 'inquiry' ) ) {
			$post_title = $name . ' — ' . $brief_title_wing;
			$post_id = wp_insert_post( array(
				'post_type'    => 'inquiry',
				'post_title'   => $post_title,
				'post_status'  => 'publish',
				'post_content' => $message,
			) );
			if ( ! is_wp_error( $post_id ) ) {
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
			}
		}

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

		@wp_mail( $admin_recipient, $subject, $body, $headers );

		$client_subject = 'Crux Nxtion — We have received your brief';
		$client_body = '<div style="font-family:sans-serif; max-width:600px; margin:0 auto; padding:24px; color:#10142E;">';
		$client_body .= '<h1 style="color:#002671;">CRUX NXTION</h1>';
		$client_body .= '<p>Hello ' . esc_html( $name ) . ',</p>';
		$client_body .= '<p>Thank you for reaching out. We have received your brief and our team will review the details and come back to you within 24 business hours.</p>';
		$client_body .= '<p style="color:#5A5F86; font-size:13px;">Crux Nxtion • 29 Dun Work, Sheffield S3 8FB • infoandsales@cruxnxtion.co.uk</p>';
		$client_body .= '</div>';

		@wp_mail( $email, $client_subject, $client_body, array( 'Content-Type: text/html; charset=UTF-8' ) );

		wp_send_json_success( array(
			'message'   => __( 'Your brief has been transmitted directly to our team. A real person will review it and reply within 24 business hours.', 'cruxnxtion' ),
			'name'      => $name,
			'lead_type' => $lead_type
		) );
	}
	add_action( 'wp_ajax_crux_submit_inquiry', 'crux_ajax_submit_inquiry' );
	add_action( 'wp_ajax_nopriv_crux_submit_inquiry', 'crux_ajax_submit_inquiry' );
}
