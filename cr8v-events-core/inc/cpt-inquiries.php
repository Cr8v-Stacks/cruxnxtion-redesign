<?php
/**
 * Custom Post Type & Clean Agency Dashboard: Project Inquiries & Client Briefs
 *
 * @package Cr8v_Events_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Register Project Inquiries Post Type (Internal Data Storage)
 */
function cr8v_register_inquiries_cpt() {
	$labels = array(
		'name'                  => _x( 'Project Inquiries', 'Post type general name', 'cr8v-events-core' ),
		'singular_name'         => _x( 'Project Inquiry', 'Post type singular name', 'cr8v-events-core' ),
		'menu_name'             => _x( 'Project Inquiries', 'Admin Menu text', 'cr8v-events-core' ),
		'name_admin_bar'        => _x( 'Inquiry', 'Add New on Toolbar', 'cr8v-events-core' ),
		'all_items'             => __( 'All Inquiries', 'cr8v-events-core' ),
		'add_new_item'          => __( 'Add New Inquiry', 'cr8v-events-core' ),
		'edit_item'             => __( 'View / Edit Inquiry Dossier', 'cr8v-events-core' ),
		'view_item'             => __( 'View Inquiry', 'cr8v-events-core' ),
		'search_items'          => __( 'Search Inquiries', 'cr8v-events-core' ),
		'not_found'             => __( 'No project briefs or inquiries found.', 'cr8v-events-core' ),
		'not_found_in_trash'    => __( 'No inquiries in Trash.', 'cr8v-events-core' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => false, // Handled via clean bespoke dashboard
		'show_in_menu'       => false,
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'supports'           => array( 'title' ),
		'show_in_rest'       => false,
	);

	register_post_type( 'cr8v_inquiry', $args );
}
add_action( 'init', 'cr8v_register_inquiries_cpt', 0 );

/**
 * 2. Register Dedicated Admin Menu & Submenus
 */
function cr8v_register_inquiries_admin_menu() {
	$new_count = cr8v_get_inquiries_count( 'New' );
	$badge     = $new_count > 0 ? sprintf( ' <span class="update-plugins count-%1$d" style="background:#C85C38; color:#fff; border-radius:10px; font-weight:700; padding:1px 6px; font-size:10px;"><span class="plugin-count">%1$d</span></span>', $new_count ) : '';

	// Top Level Menu
	add_menu_page(
		__( 'Project Inquiries', 'cr8v-events-core' ),
		__( 'Project Inquiries', 'cr8v-events-core' ) . $badge,
		'manage_options',
		'cr8v-inquiries',
		'cr8v_render_inquiries_dashboard_page',
		'dashicons-clipboard',
		28
	);

	// Submenu 1: All Inquiries
	add_submenu_page(
		'cr8v-inquiries',
		__( 'All Inquiries', 'cr8v-events-core' ),
		__( 'All Inquiries', 'cr8v-events-core' ),
		'manage_options',
		'cr8v-inquiries',
		'cr8v_render_inquiries_dashboard_page'
	);

	// Submenu 2: Add New Inquiry
	add_submenu_page(
		'cr8v-inquiries',
		__( 'Add New Inquiry', 'cr8v-events-core' ),
		__( 'Add New Inquiry', 'cr8v-events-core' ),
		'manage_options',
		'cr8v-inquiries-new',
		'cr8v_render_inquiries_new_page'
	);

	// Submenu 3: Analytics & Pipeline Reports
	add_submenu_page(
		'cr8v-inquiries',
		__( 'Analytics & Reports', 'cr8v-events-core' ),
		__( 'Analytics & Reports', 'cr8v-events-core' ),
		'manage_options',
		'cr8v-inquiries-reports',
		'cr8v_render_inquiries_reports_page'
	);

	// Submenu 4: Email & Notification Services
	add_submenu_page(
		'cr8v-inquiries',
		__( 'Email Services & Notifications', 'cr8v-events-core' ),
		__( 'Email Services', 'cr8v-events-core' ),
		'manage_options',
		'cr8v-inquiries-email',
		'cr8v_render_inquiries_email_page'
	);
}
add_action( 'admin_menu', 'cr8v_register_inquiries_admin_menu' );

/**
 * 3. Handle CSV Export of Inquiries
 */
function cr8v_handle_inquiries_csv_export() {
	if ( ! isset( $_GET['cr8v_action'] ) || 'export_inquiries_csv' !== $_GET['cr8v_action'] ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'Unauthorized action.', 'cr8v-events-core' ) );
	}

	check_admin_referer( 'cr8v_export_csv_nonce' );

	$args = array(
		'post_type'      => 'cr8v_inquiry',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	$inquiries = get_posts( $args );
	$filename  = 'project-inquiries-report-' . gmdate( 'Y-m-d' ) . '.csv';

	header( 'Content-Type: text/csv; charset=UTF-8' );
	header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
	header( 'Pragma: no-cache' );
	header( 'Expires: 0' );

	$output = fopen( 'php://output', 'w' );
	fputs( $output, "\xEF\xBB\xBF" ); // UTF-8 BOM

	fputcsv( $output, array(
		'Inquiry ID',
		'Date Received',
		'Client / Organization',
		'Email Address',
		'Phone Number',
		'Services Requested',
		'Lifecycle Status',
		'Assigned Director',
		'Estimated Budget / Quote',
		'Project Brief & Specifications',
		'Internal Notes',
		'Client IP',
	) );

	foreach ( $inquiries as $inq ) {
		$p_id     = $inq->ID;
		$services = get_post_meta( $p_id, '_cr8v_inquiry_services', true );
		if ( empty( $services ) ) {
			$services = get_post_meta( $p_id, '_cr8v_inquiry_discipline', true );
		}

		fputcsv( $output, array(
			$p_id,
			get_the_date( 'Y-m-d H:i:s', $p_id ),
			$inq->post_title,
			get_post_meta( $p_id, '_cr8v_inquiry_email', true ),
			get_post_meta( $p_id, '_cr8v_inquiry_phone', true ),
			$services,
			get_post_meta( $p_id, '_cr8v_inquiry_status', true ) ?: 'New',
			get_post_meta( $p_id, '_cr8v_inquiry_director', true ),
			get_post_meta( $p_id, '_cr8v_inquiry_budget', true ),
			get_post_meta( $p_id, '_cr8v_inquiry_scope', true ),
			get_post_meta( $p_id, '_cr8v_inquiry_internal_notes', true ),
			get_post_meta( $p_id, '_cr8v_inquiry_ip', true ),
		) );
	}

	fclose( $output );
	exit;
}
add_action( 'admin_init', 'cr8v_handle_inquiries_csv_export' );

/**
 * Helper: Count inquiries by status
 */
function cr8v_get_inquiries_count( $status = 'all' ) {
	$args = array(
		'post_type'      => 'cr8v_inquiry',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'fields'         => 'ids',
	);

	if ( 'all' !== $status ) {
		$args['meta_query'] = array(
			array(
				'key'   => '_cr8v_inquiry_status',
				'value' => $status,
			),
		);
	}

	$query = new WP_Query( $args );
	return $query->found_posts;
}

/**
 * Available Services Master List
 */
function cr8v_get_available_services_list() {
	$default_services = array(
		'Site-Specific & Promenade Theatre Direction',
		'Socially Engaged Art (SEA) & Community Curation',
		'Cross-Continental Creative Direction (UK/Africa)',
		'Creative Mentorship & Arts Advocacy Programs',
		'Stage Architecture & Technical Production',
		'Outdoor Acoustic Arrays & Wireless RF Networks',
		'Atmospheric & Botanical Landscape Lighting',
		'Waterfront & Buoyant Deck Staging Solutions',
		'Marketplace & Public Arena Living Art',
		'Multi-Currency Budget Hedging & Fiscal Governance',
		'Community Dramaturgy & Testimonial Theatre',
		'Turnkey Live Event Production Management',
	);

	return apply_filters( 'cr8v_theme_services_list', $default_services );
}

/**
 * 3. Render Dedicated Inquiries Dashboard Controller
 */
function cr8v_render_inquiries_dashboard_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have permission to view project inquiries.', 'cr8v-events-core' ) );
	}

	// Handle Save Action in Dossier View
	if ( isset( $_POST['cr8v_save_dossier_nonce'] ) && wp_verify_nonce( $_POST['cr8v_save_dossier_nonce'], 'cr8v_save_dossier_action' ) ) {
		$dossier_id = intval( $_POST['inquiry_id'] ?? 0 );
		if ( $dossier_id ) {
			if ( isset( $_POST['inquiry_status'] ) ) {
				update_post_meta( $dossier_id, '_cr8v_inquiry_status', sanitize_text_field( $_POST['inquiry_status'] ) );
			}
			if ( isset( $_POST['inquiry_director'] ) ) {
				update_post_meta( $dossier_id, '_cr8v_inquiry_director', sanitize_text_field( $_POST['inquiry_director'] ) );
			}
			if ( isset( $_POST['inquiry_budget'] ) ) {
				update_post_meta( $dossier_id, '_cr8v_inquiry_budget', sanitize_text_field( $_POST['inquiry_budget'] ) );
			}
			if ( isset( $_POST['inquiry_internal_notes'] ) ) {
				update_post_meta( $dossier_id, '_cr8v_inquiry_internal_notes', sanitize_textarea_field( $_POST['inquiry_internal_notes'] ) );
			}
			echo '<div class="notice notice-success is-dismissible" style="margin-top:14px;"><p><strong>' . __( 'Inquiry dossier updated successfully.', 'cr8v-events-core' ) . '</strong></p></div>';
		}
	}

	// Handle Trash / Delete Action
	$delete_id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;
	if ( isset( $_GET['action'] ) && 'delete' === $_GET['action'] && $delete_id > 0 && check_admin_referer( 'cr8v_delete_inquiry_' . $delete_id ) ) {
		wp_trash_post( $delete_id );
		echo '<div class="notice notice-warning is-dismissible" style="margin-top:14px;"><p>' . sprintf( __( 'Inquiry #%d moved to trash.', 'cr8v-events-core' ), $delete_id ) . '</p></div>';
	}

	$action     = isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] ) : 'list';
	$inquiry_id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

	if ( 'view' === $action && $inquiry_id ) {
		cr8v_render_single_inquiry_dossier_view( $inquiry_id );
	} elseif ( 'new' === $action ) {
		cr8v_render_inquiries_new_page();
	} else {
		cr8v_render_inquiries_list_view();
	}
}

/**
 * 4. Shared Bespoke White Studio Dashboard CSS & Canvas Takeover
 */
function cr8v_render_inquiries_shared_css() {
	?>
	<style>
	/* 100% Bespoke White Studio Dashboard - Complete WordPress UI Reset */
	html, body, #wpbody, #wpcontent {
		background: #F8FAFC !important;
		color: #0F172A !important;
		font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
		-webkit-font-smoothing: antialiased !important;
	}
	#wpcontent {
		padding-left: 0 !important;
		padding-right: 0 !important;
		padding-top: 0 !important;
	}
	#wpbody-content {
		padding-bottom: 40px !important;
		float: none !important;
		width: 100% !important;
	}
	#wpfooter {
		display: none !important;
	}
	#wpbody-content > .notice:not(.cr8v-inq-notice),
	#wpbody-content > .updated:not(.cr8v-inq-notice),
	#wpbody-content > .error:not(.cr8v-inq-notice) {
		display: none !important;
	}

	/* Core Application Container */
	.cr8v-app-wrap {
		max-width: 1400px;
		margin: 0 auto;
		padding: 24px 28px 40px;
		box-sizing: border-box;
	}
	.cr8v-app-wrap * {
		box-sizing: border-box;
	}

	/* Top Command Bar */
	.cr8v-topbar {
		display: flex;
		justify-content: space-between;
		align-items: center;
		flex-wrap: wrap;
		gap: 16px;
		background: #FFFFFF;
		border: 1px solid #E2E8F0;
		border-radius: 14px;
		padding: 18px 24px;
		margin-bottom: 24px;
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
	}
	.cr8v-brand-cluster {
		display: flex;
		align-items: center;
		gap: 14px;
	}
	.cr8v-brand-logo {
		width: 40px;
		height: 40px;
		background: #09090B;
		color: #FFFFFF;
		border-radius: 10px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 16px;
		font-weight: 900;
		letter-spacing: -0.05em;
		box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
	}
	.cr8v-brand-meta {
		display: flex;
		flex-direction: column;
		gap: 2px;
	}
	.cr8v-brand-kicker {
		font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
		font-size: 11px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.08em;
		color: #64748B;
		display: flex;
		align-items: center;
		gap: 6px;
	}
	.cr8v-brand-title {
		font-size: 20px;
		font-weight: 800;
		color: #0F172A;
		margin: 0;
		letter-spacing: -0.02em;
	}
	.cr8v-topbar-nav {
		display: flex;
		align-items: center;
		gap: 8px;
		flex-wrap: wrap;
	}

	/* Interactive Buttons */
	.cr8v-btn {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		font-size: 13px;
		font-weight: 600;
		padding: 8px 16px;
		border-radius: 8px;
		text-decoration: none;
		cursor: pointer;
		transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
		line-height: 1.4;
		border: 1px solid transparent;
	}
	.cr8v-btn-primary {
		background: #09090B;
		color: #FFFFFF !important;
		border-color: #09090B;
		font-weight: 700;
	}
	.cr8v-btn-primary:hover {
		background: #27272A;
		border-color: #27272A;
		color: #FFFFFF !important;
		transform: translateY(-1px);
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
	}
	.cr8v-btn-secondary {
		background: #FFFFFF;
		color: #0F172A !important;
		border-color: #CBD5E1;
		box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
	}
	.cr8v-btn-secondary:hover {
		background: #F8FAFC;
		border-color: #94A3B8;
		color: #09090B !important;
		transform: translateY(-1px);
	}
	.cr8v-btn-danger {
		background: #FFFFFF;
		color: #DC2626 !important;
		border-color: #FCA5A5;
	}
	.cr8v-btn-danger:hover {
		background: #FEF2F2;
		border-color: #EF4444;
	}

	/* KPI Cards Grid */
	.cr8v-kpi-grid {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
		gap: 16px;
		margin-bottom: 24px;
	}
	.cr8v-kpi-card {
		background: #FFFFFF;
		border: 1px solid #E2E8F0;
		border-radius: 12px;
		padding: 20px 22px;
		position: relative;
		overflow: hidden;
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
		transition: all 0.2s ease;
	}
	.cr8v-kpi-card:hover {
		border-color: #CBD5E1;
		transform: translateY(-2px);
		box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
	}
	.cr8v-kpi-label {
		font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
		font-size: 11px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.06em;
		color: #64748B;
		display: flex;
		align-items: center;
		gap: 6px;
		margin-bottom: 8px;
	}
	.cr8v-kpi-num {
		font-size: 32px;
		font-weight: 800;
		color: #0F172A;
		line-height: 1.1;
		letter-spacing: -0.02em;
		font-variant-numeric: tabular-nums;
	}
	.cr8v-kpi-hint {
		font-size: 11.5px;
		color: #64748B;
		margin-top: 6px;
		display: block;
	}

	/* Controls Row & Segmented Filters */
	.cr8v-controls-row {
		display: flex;
		justify-content: space-between;
		align-items: center;
		flex-wrap: wrap;
		gap: 14px;
		margin-bottom: 18px;
	}
	.cr8v-segmented-bar {
		display: inline-flex;
		background: #F1F5F9;
		border: 1px solid #E2E8F0;
		padding: 4px;
		border-radius: 10px;
		gap: 3px;
	}
	.cr8v-seg-pill {
		padding: 6px 14px;
		font-size: 12.5px;
		font-weight: 600;
		color: #64748B;
		text-decoration: none;
		border-radius: 7px;
		display: inline-flex;
		align-items: center;
		gap: 6px;
		transition: all 0.15s ease;
	}
	.cr8v-seg-pill:hover {
		color: #0F172A;
	}
	.cr8v-seg-pill.is-active {
		background: #FFFFFF;
		color: #0F172A;
		font-weight: 700;
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
	}
	.cr8v-seg-count {
		font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
		font-size: 10.5px;
		padding: 1px 6px;
		background: rgba(0, 0, 0, 0.05);
		border-radius: 999px;
		color: #475569;
	}
	.cr8v-seg-pill.is-active .cr8v-seg-count {
		background: #09090B;
		color: #FFFFFF;
	}

	/* Search Box */
	.cr8v-search-wrapper {
		display: flex;
		align-items: center;
		background: #FFFFFF;
		border: 1px solid #CBD5E1;
		border-radius: 8px;
		overflow: hidden;
		box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
	}
	.cr8v-search-wrapper:focus-within {
		border-color: #09090B;
		box-shadow: 0 0 0 2px rgba(9, 9, 11, 0.08);
	}
	.cr8v-search-field {
		border: none !important;
		padding: 8px 14px !important;
		font-size: 13px !important;
		width: 250px !important;
		background: transparent !important;
		color: #0F172A !important;
		outline: none !important;
		box-shadow: none !important;
	}
	.cr8v-search-field::placeholder {
		color: #94A3B8 !important;
	}
	.cr8v-search-submit {
		background: #F8FAFC !important;
		border: none !important;
		border-left: 1px solid #E2E8F0 !important;
		padding: 8px 14px !important;
		cursor: pointer !important;
		font-size: 12.5px !important;
		font-weight: 600 !important;
		color: #0F172A !important;
	}
	.cr8v-search-submit:hover {
		background: #F1F5F9 !important;
	}

	/* Table Panel */
	.cr8v-table-panel {
		background: #FFFFFF;
		border: 1px solid #E2E8F0;
		border-radius: 14px;
		overflow: hidden;
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
	}
	.cr8v-ledger-table {
		width: 100%;
		border-collapse: collapse;
		text-align: left;
	}
	.cr8v-ledger-table th {
		background: #F8FAFC;
		padding: 14px 20px;
		font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
		font-size: 11px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.06em;
		color: #64748B;
		border-bottom: 1px solid #E2E8F0;
	}
	.cr8v-ledger-table td {
		padding: 16px 20px;
		border-bottom: 1px solid #F1F5F9;
		vertical-align: middle;
		font-size: 13.5px;
		color: #334155;
		transition: background 0.15s ease;
	}
	.cr8v-ledger-table tr:last-child td {
		border-bottom: none;
	}
	.cr8v-ledger-table tr:hover td {
		background: #F8FAFC;
	}

	/* Status Chips */
	.cr8v-status-chip {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		padding: 4px 11px;
		border-radius: 999px;
		font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
		font-size: 11px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.04em;
		background: #09090B;
		color: #FFFFFF;
	}
	.cr8v-status-chip.is-concluded {
		background: #F1F5F9;
		border: 1px solid #E2E8F0;
		color: #64748B;
	}
	.cr8v-neon-dot {
		width: 7px;
		height: 7px;
		border-radius: 50%;
		display: inline-block;
	}
	.neon-emerald { background: #10B981; box-shadow: 0 0 6px #10B981; }
	.neon-amber { background: #F59E0B; box-shadow: 0 0 6px #F59E0B; }
	.neon-blue { background: #3B82F6; box-shadow: 0 0 6px #3B82F6; }
	.neon-slate { background: #94A3B8; }

	/* Tag Pills */
	.cr8v-tag-pill {
		display: inline-block;
		background: #F1F5F9;
		border: 1px solid #E2E8F0;
		color: #1E293B;
		padding: 3px 8px;
		border-radius: 5px;
		font-size: 11.5px;
		font-weight: 600;
		margin: 2px 4px 2px 0;
	}
	.cr8v-tag-overflow {
		display: inline-block;
		background: #E2E8F0;
		color: #475569;
		padding: 3px 7px;
		border-radius: 5px;
		font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
		font-size: 10.5px;
		font-weight: 700;
		cursor: help;
	}

	/* Form & Box Cards */
	.cr8v-card-box {
		background: #FFFFFF;
		border: 1px solid #E2E8F0;
		border-radius: 14px;
		padding: 28px;
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
	}
	.cr8v-field-label {
		display: block;
		font-size: 11.5px;
		font-weight: 700;
		color: #475569;
		margin-bottom: 6px;
		text-transform: uppercase;
		letter-spacing: 0.06em;
		font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
	}
	.cr8v-studio-input, .cr8v-studio-select, .cr8v-studio-textarea {
		width: 100%;
		padding: 10px 14px;
		border: 1px solid #CBD5E1;
		border-radius: 8px;
		font-size: 13.5px;
		background: #FFFFFF;
		color: #0F172A;
		outline: none;
		transition: all 0.2s ease;
	}
	.cr8v-studio-input:focus, .cr8v-studio-select:focus, .cr8v-studio-textarea:focus {
		border-color: #09090B;
		box-shadow: 0 0 0 2px rgba(9, 9, 11, 0.08);
	}
	.cr8v-services-checkbox-grid {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
		gap: 10px;
		background: #F8FAFC;
		border: 1px solid #E2E8F0;
		border-radius: 8px;
		padding: 16px;
	}
	.cr8v-checkbox-cell {
		display: flex;
		align-items: center;
		gap: 8px;
		font-size: 13px;
		color: #334155;
		cursor: pointer;
	}

	/* App Footer */
	.cr8v-app-footer {
		margin-top: 32px;
		padding: 20px 24px;
		background: #FFFFFF;
		border: 1px solid #E2E8F0;
		border-radius: 12px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		flex-wrap: wrap;
		gap: 14px;
		font-size: 12.5px;
		color: #64748B;
		box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
	}
	.cr8v-app-footer a {
		color: #0F172A;
		font-weight: 600;
		text-decoration: none;
	}
	.cr8v-app-footer a:hover {
		text-decoration: underline;
	}

	@media print {
		#adminmenumain, #wpadminbar, #wpfooter, .cr8v-no-print { display: none !important; }
		#wpcontent, #wpbody-content { margin: 0 !important; padding: 0 !important; }
		.cr8v-app-wrap { max-width: 100% !important; margin: 0 !important; padding: 0 !important; }
	}
	</style>
	<?php
}

/**
 * 5. Render Shared App Footer
 */
function cr8v_render_inquiries_shared_footer() {
	$site_title = get_bloginfo( 'name' );
	?>
	<footer class="cr8v-app-footer cr8v-no-print">
		<div style="display:flex; align-items:center; gap:8px;">
			<span style="font-weight:700; color:#0F172A;"><?php echo esc_html( $site_title ); ?></span>
			<span>&bull;</span>
			<span><?php _e( 'Event Briefs & Quote Pipeline Engine', 'cr8v-events-core' ); ?></span>
		</div>
		<div style="display:flex; align-items:center; gap:6px;">
			<span class="cr8v-neon-dot neon-emerald"></span>
			<span><?php _e( 'All Systems Operational &bull; Live Intake Ingestion Active', 'cr8v-events-core' ); ?></span>
		</div>
		<div>
			<span style="font-family:ui-monospace, monospace; font-size:11.5px; color:#94A3B8;">Cr8v Events Core v1.0.0</span>
			<span style="margin:0 6px;">&bull;</span>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank"><?php _e( 'View Live Site &rarr;', 'cr8v-events-core' ); ?></a>
		</div>
	</footer>
	<?php
}

/**
 * 6. Add New Inquiry Page / Form (Studio Edition)
 */
function cr8v_render_inquiries_new_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have permission to add project inquiries.', 'cr8v-events-core' ) );
	}

	// Handle Form Submission
	if ( isset( $_POST['cr8v_create_inquiry_nonce'] ) && wp_verify_nonce( $_POST['cr8v_create_inquiry_nonce'], 'cr8v_create_inquiry_action' ) ) {
		$client_name    = sanitize_text_field( $_POST['client_name'] ?? '' );
		$client_email   = sanitize_email( $_POST['client_email'] ?? '' );
		$client_phone   = sanitize_text_field( $_POST['client_phone'] ?? '' );
		$services_arr   = isset( $_POST['services'] ) && is_array( $_POST['services'] ) ? array_map( 'sanitize_text_field', $_POST['services'] ) : array();
		$services_str   = implode( ', ', $services_arr );
		$event_desc     = sanitize_textarea_field( $_POST['event_desc'] ?? '' );
		$inquiry_status = sanitize_text_field( $_POST['inquiry_status'] ?? 'New' );
		$director       = sanitize_text_field( $_POST['inquiry_director'] ?? '' );
		$budget         = sanitize_text_field( $_POST['inquiry_budget'] ?? '' );
		$notes          = sanitize_textarea_field( $_POST['inquiry_internal_notes'] ?? '' );

		if ( ! empty( $client_name ) ) {
			$post_id = wp_insert_post( array(
				'post_title'   => $client_name,
				'post_type'    => 'cr8v_inquiry',
				'post_status'  => 'publish',
				'post_content' => $event_desc,
			) );

			if ( $post_id && ! is_wp_error( $post_id ) ) {
				update_post_meta( $post_id, '_cr8v_inquiry_email', $client_email );
				update_post_meta( $post_id, '_cr8v_inquiry_phone', $client_phone );
				update_post_meta( $post_id, '_cr8v_inquiry_discipline', $services_str );
				update_post_meta( $post_id, '_cr8v_inquiry_services', $services_str );
				update_post_meta( $post_id, '_cr8v_inquiry_scope', $event_desc );
				update_post_meta( $post_id, '_cr8v_inquiry_status', $inquiry_status );
				update_post_meta( $post_id, '_cr8v_inquiry_director', $director );
				update_post_meta( $post_id, '_cr8v_inquiry_budget', $budget );
				update_post_meta( $post_id, '_cr8v_inquiry_internal_notes', $notes );
				update_post_meta( $post_id, '_cr8v_inquiry_ip', 'Manual Intake' );

				$view_url = admin_url( 'admin.php?page=cr8v-inquiries&action=view&id=' . $post_id );
				wp_safe_redirect( $view_url );
				exit;
			}
		}
	}

	$all_services = cr8v_get_available_services_list();
	$list_url     = admin_url( 'admin.php?page=cr8v-inquiries' );
	$site_title   = get_bloginfo( 'name' );

	cr8v_render_inquiries_shared_css();
	?>
	<div class="wrap cr8v-app-wrap" style="max-width:1050px;">
		
		<!-- Command Top Bar -->
		<div class="cr8v-topbar cr8v-no-print">
			<div class="cr8v-brand-cluster">
				<div class="cr8v-brand-logo">C8</div>
				<div class="cr8v-brand-meta">
					<span class="cr8v-brand-kicker"><span class="cr8v-neon-dot neon-emerald"></span> <?php _e( 'Manual Brief Intake', 'cr8v-events-core' ); ?> &bull; <?php echo esc_html( $site_title ); ?></span>
					<h1 class="cr8v-brand-title"><?php _e( 'Log New Project Inquiry', 'cr8v-events-core' ); ?></h1>
				</div>
			</div>

			<div class="cr8v-topbar-nav">
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=cr8v-inquiries-email' ) ); ?>" class="cr8v-btn cr8v-btn-secondary">
					<span class="dashicons dashicons-email-alt" style="font-size:15px; margin-top:2px;"></span> <?php _e( 'Email Services', 'cr8v-events-core' ); ?>
				</a>
				<a href="<?php echo esc_url( $list_url ); ?>" class="cr8v-btn cr8v-btn-secondary">
					&larr; <?php _e( 'Back to Ledger', 'cr8v-events-core' ); ?>
				</a>
			</div>
		</div>

		<div class="cr8v-card-box">
			
			<form method="post" action="">
				<?php wp_nonce_field( 'cr8v_create_inquiry_action', 'cr8v_create_inquiry_nonce' ); ?>

				<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
					<div>
						<label class="cr8v-field-label" for="client_name">
							<?php _e( 'Client / Organization Name', 'cr8v-events-core' ); ?> <span style="color:#DC2626;">*</span>
						</label>
						<input type="text" id="client_name" name="client_name" class="cr8v-studio-input" placeholder="e.g. Victoria Warehouse / Redline Events" required>
					</div>

					<div>
						<label class="cr8v-field-label" for="client_email">
							<?php _e( 'Client Email Address', 'cr8v-events-core' ); ?>
						</label>
						<input type="email" id="client_email" name="client_email" class="cr8v-studio-input" placeholder="e.g. client@organization.co.uk">
					</div>
				</div>

				<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px;">
					<div>
						<label class="cr8v-field-label" for="client_phone">
							<?php _e( 'Phone / WhatsApp Number', 'cr8v-events-core' ); ?>
						</label>
						<input type="text" id="client_phone" name="client_phone" class="cr8v-studio-input" placeholder="e.g. +44 7760 000000">
					</div>

					<div>
						<label class="cr8v-field-label" for="inquiry_status">
							<?php _e( 'Initial Lifecycle Stage', 'cr8v-events-core' ); ?>
						</label>
						<select id="inquiry_status" name="inquiry_status" class="cr8v-studio-select" style="font-weight:600;">
							<option value="New"><?php _e( 'New (Requires Review)', 'cr8v-events-core' ); ?></option>
							<option value="In Review"><?php _e( 'In Review with Team', 'cr8v-events-core' ); ?></option>
							<option value="Contacted"><?php _e( 'Client Contacted / Proposal Sent', 'cr8v-events-core' ); ?></option>
							<option value="Concluded"><?php _e( 'Concluded / Booked', 'cr8v-events-core' ); ?></option>
						</select>
					</div>
				</div>

				<div style="margin-bottom:24px;">
					<label class="cr8v-field-label">
						<?php _e( 'Requested Services & Disciplines:', 'cr8v-events-core' ); ?>
					</label>
					<div class="cr8v-services-checkbox-grid">
						<?php foreach ( $all_services as $srv ) : ?>
							<label class="cr8v-checkbox-cell">
								<input type="checkbox" name="services[]" value="<?php echo esc_attr( $srv ); ?>" style="border-radius:4px;">
								<span><?php echo esc_html( $srv ); ?></span>
							</label>
						<?php endforeach; ?>
					</div>
				</div>

				<div style="margin-bottom:24px;">
					<label class="cr8v-field-label" for="event_desc">
						<?php _e( 'Project Scope, Dates & Venue Specifications', 'cr8v-events-core' ); ?>
					</label>
					<textarea id="event_desc" name="event_desc" rows="5" class="cr8v-studio-textarea" placeholder="Enter venue location, target dates, capacity, staging & audio/lighting specifications..."></textarea>
				</div>

				<div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:10px; padding:22px; margin-bottom:28px;">
					<h3 style="font-family:ui-monospace, monospace; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:#0F172A; margin:0 0 16px;">
						<?php _e( 'Internal Production Assignment & Quote Ledger', 'cr8v-events-core' ); ?>
					</h3>

					<div style="display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:16px;">
						<div>
							<label class="cr8v-field-label" for="inquiry_director">
								<?php _e( 'Lead Technical Director Assigned:', 'cr8v-events-core' ); ?>
							</label>
							<input type="text" id="inquiry_director" name="inquiry_director" placeholder="e.g. Marcus Vance" class="cr8v-studio-input">
						</div>
						<div>
							<label class="cr8v-field-label" for="inquiry_budget">
								<?php _e( 'Estimated Project Budget / Quote (£ GBP):', 'cr8v-events-core' ); ?>
							</label>
							<input type="text" id="inquiry_budget" name="inquiry_budget" placeholder="e.g. £45,000" class="cr8v-studio-input" style="font-family:ui-monospace, monospace;">
						</div>
					</div>

					<div>
						<label class="cr8v-field-label" for="inquiry_internal_notes">
							<?php _e( 'Private Production Notes:', 'cr8v-events-core' ); ?>
						</label>
						<textarea id="inquiry_internal_notes" name="inquiry_internal_notes" rows="3" placeholder="Enter private site-visit logs, staging calculations, or rider notes..." class="cr8v-studio-textarea"></textarea>
					</div>
				</div>

				<div style="display:flex; justify-content:flex-end; gap:12px;">
					<a href="<?php echo esc_url( $list_url ); ?>" class="cr8v-btn cr8v-btn-secondary">
						<?php _e( 'Cancel', 'cr8v-events-core' ); ?>
					</a>
					<button type="submit" class="cr8v-btn cr8v-btn-primary">
						<?php _e( 'Create Intake Dossier', 'cr8v-events-core' ); ?> &rarr;
					</button>
				</div>

			</form>

		</div>

		<?php cr8v_render_inquiries_shared_footer(); ?>

	</div>
	<?php
}

/**
 * 7. Studio Inquiries List View (100% Bespoke White Studio Dashboard)
 */
function cr8v_render_inquiries_list_view() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have permission to access project inquiries.', 'cr8v-events-core' ) );
	}

	$current_status = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : 'all';
	$search_query   = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';

	$count_all       = cr8v_get_inquiries_count( 'all' );
	$count_new       = cr8v_get_inquiries_count( 'New' );
	$count_in_review = cr8v_get_inquiries_count( 'In Review' );
	$count_contacted = cr8v_get_inquiries_count( 'Contacted' );
	$count_concluded = cr8v_get_inquiries_count( 'Concluded' );

	$args = array(
		'post_type'      => 'cr8v_inquiry',
		'post_status'    => 'publish',
		'posts_per_page' => 50,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	if ( 'all' !== $current_status ) {
		$args['meta_query'] = array(
			array(
				'key'   => '_cr8v_inquiry_status',
				'value' => $current_status,
			),
		);
	}

	if ( ! empty( $search_query ) ) {
		$args['s'] = $search_query;
	}

	$inquiries  = new WP_Query( $args );
	$base_url   = admin_url( 'admin.php?page=cr8v-inquiries' );
	$new_url    = admin_url( 'admin.php?page=cr8v-inquiries-new' );
	$report_url = admin_url( 'admin.php?page=cr8v-inquiries-reports' );
	$export_url = wp_nonce_url( admin_url( 'admin.php?cr8v_action=export_inquiries_csv' ), 'cr8v_export_csv_nonce' );
	$site_title = get_bloginfo( 'name' );

	cr8v_render_inquiries_shared_css();
	?>
	<div class="wrap cr8v-app-wrap">
		
		<!-- Top Command Bar -->
		<div class="cr8v-topbar">
			<div class="cr8v-brand-cluster">
				<div class="cr8v-brand-logo">C8</div>
				<div class="cr8v-brand-meta">
					<span class="cr8v-brand-kicker"><span class="cr8v-neon-dot neon-emerald"></span> <?php _e( 'Live Intake Engine', 'cr8v-events-core' ); ?> &bull; <?php echo esc_html( $site_title ); ?></span>
					<h1 class="cr8v-brand-title"><?php _e( 'Project Briefs & Intake Ledger', 'cr8v-events-core' ); ?></h1>
				</div>
			</div>

			<div class="cr8v-topbar-nav">
				<a href="<?php echo esc_url( $export_url ); ?>" class="cr8v-btn cr8v-btn-secondary">
					<span class="dashicons dashicons-download" style="font-size:16px; margin-top:2px;"></span> <?php _e( 'Export CSV', 'cr8v-events-core' ); ?>
				</a>
				<a href="<?php echo esc_url( $report_url ); ?>" class="cr8v-btn cr8v-btn-secondary">
					<span class="dashicons dashicons-chart-bar" style="font-size:16px; margin-top:2px;"></span> <?php _e( 'Pipeline Reports', 'cr8v-events-core' ); ?>
				</a>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=cr8v-inquiries-email' ) ); ?>" class="cr8v-btn cr8v-btn-secondary">
					<span class="dashicons dashicons-email-alt" style="font-size:16px; margin-top:2px;"></span> <?php _e( 'Email Services', 'cr8v-events-core' ); ?>
				</a>
				<a href="<?php echo esc_url( $new_url ); ?>" class="cr8v-btn cr8v-btn-primary">
					<span class="dashicons dashicons-plus-alt2" style="font-size:16px; margin-top:2px;"></span> <?php _e( 'Add Inquiry Brief', 'cr8v-events-core' ); ?>
				</a>
			</div>
		</div>

		<!-- Executive KPI Grid -->
		<div class="cr8v-kpi-grid">
			<div class="cr8v-kpi-card" style="border-top: 3px solid #09090B;">
				<span class="cr8v-kpi-label"><?php _e( 'Total Intake Briefs', 'cr8v-events-core' ); ?></span>
				<div class="cr8v-kpi-num"><?php echo intval( $count_all ); ?></div>
				<span class="cr8v-kpi-hint"><?php _e( '100% Real-time ingestion', 'cr8v-events-core' ); ?></span>
			</div>
			<div class="cr8v-kpi-card" style="border-top: 3px solid #10B981;">
				<span class="cr8v-kpi-label"><span class="cr8v-neon-dot neon-emerald"></span> <?php _e( 'New / Unread', 'cr8v-events-core' ); ?></span>
				<div class="cr8v-kpi-num" style="color: #059669;"><?php echo intval( $count_new ); ?></div>
				<span class="cr8v-kpi-hint"><?php _e( 'Awaiting director review', 'cr8v-events-core' ); ?></span>
			</div>
			<div class="cr8v-kpi-card" style="border-top: 3px solid #F59E0B;">
				<span class="cr8v-kpi-label"><span class="cr8v-neon-dot neon-amber"></span> <?php _e( 'In Review', 'cr8v-events-core' ); ?></span>
				<div class="cr8v-kpi-num" style="color: #D97706;"><?php echo intval( $count_in_review ); ?></div>
				<span class="cr8v-kpi-hint"><?php _e( 'Technical quote calculation', 'cr8v-events-core' ); ?></span>
			</div>
			<div class="cr8v-kpi-card" style="border-top: 3px solid #3B82F6;">
				<span class="cr8v-kpi-label"><span class="cr8v-neon-dot neon-blue"></span> <?php _e( 'Contacted', 'cr8v-events-core' ); ?></span>
				<div class="cr8v-kpi-num" style="color: #2563EB;"><?php echo intval( $count_contacted ); ?></div>
				<span class="cr8v-kpi-hint"><?php _e( 'Proposal dispatched', 'cr8v-events-core' ); ?></span>
			</div>
			<div class="cr8v-kpi-card" style="border-top: 3px solid #64748B;">
				<span class="cr8v-kpi-label"><span class="cr8v-neon-dot neon-slate"></span> <?php _e( 'Concluded', 'cr8v-events-core' ); ?></span>
				<div class="cr8v-kpi-num" style="color: #475569;"><?php echo intval( $count_concluded ); ?></div>
				<span class="cr8v-kpi-hint"><?php _e( 'Confirmed productions', 'cr8v-events-core' ); ?></span>
			</div>
		</div>

		<!-- Segmented Filter Bar & Search -->
		<div class="cr8v-controls-row">
			<div class="cr8v-segmented-bar">
				<?php
				$filters = array(
					'all'       => array( 'label' => __( 'All Briefs', 'cr8v-events-core' ), 'count' => $count_all ),
					'New'       => array( 'label' => __( 'New', 'cr8v-events-core' ), 'count' => $count_new ),
					'In Review' => array( 'label' => __( 'In Review', 'cr8v-events-core' ), 'count' => $count_in_review ),
					'Contacted' => array( 'label' => __( 'Contacted', 'cr8v-events-core' ), 'count' => $count_contacted ),
					'Concluded' => array( 'label' => __( 'Concluded', 'cr8v-events-core' ), 'count' => $count_concluded ),
				);
				foreach ( $filters as $f_key => $f_val ) :
					$is_current = ( $current_status === $f_key );
					$f_url      = add_query_arg( array( 'status' => $f_key, 's' => $search_query ), $base_url );
					?>
					<a href="<?php echo esc_url( $f_url ); ?>" class="cr8v-seg-pill <?php echo $is_current ? 'is-active' : ''; ?>">
						<?php echo esc_html( $f_val['label'] ); ?>
						<span class="cr8v-seg-count"><?php echo intval( $f_val['count'] ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>

			<form method="get" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>" class="cr8v-search-wrapper">
				<input type="hidden" name="page" value="cr8v-inquiries">
				<input type="hidden" name="status" value="<?php echo esc_attr( $current_status ); ?>">
				<input type="search" name="s" value="<?php echo esc_attr( $search_query ); ?>" placeholder="<?php esc_attr_e( 'Search client, email or service...', 'cr8v-events-core' ); ?>" class="cr8v-search-field">
				<button type="submit" class="cr8v-search-submit">
					<?php _e( 'Search', 'cr8v-events-core' ); ?>
				</button>
			</form>
		</div>

		<!-- Bespoke Data Table Panel -->
		<div class="cr8v-table-panel">
			<?php if ( $inquiries->have_posts() ) : ?>
				<table class="cr8v-ledger-table">
					<thead>
						<tr>
							<th style="width:26%;"><?php _e( 'Client / Organization', 'cr8v-events-core' ); ?></th>
							<th style="width:16%;"><?php _e( 'Date Received', 'cr8v-events-core' ); ?></th>
							<th style="width:20%;"><?php _e( 'Contact Coordinates', 'cr8v-events-core' ); ?></th>
							<th style="width:20%;"><?php _e( 'Disciplines Requested', 'cr8v-events-core' ); ?></th>
							<th style="width:10%;"><?php _e( 'Pipeline Stage', 'cr8v-events-core' ); ?></th>
							<th style="width:8%; text-align:right;"><?php _e( 'Actions', 'cr8v-events-core' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						while ( $inquiries->have_posts() ) :
							$inquiries->the_post();
							$p_id     = get_the_ID();
							$c_name   = get_the_title();
							$email    = get_post_meta( $p_id, '_cr8v_inquiry_email', true );
							$phone    = get_post_meta( $p_id, '_cr8v_inquiry_phone', true );
							$services = get_post_meta( $p_id, '_cr8v_inquiry_services', true );
							if ( empty( $services ) ) {
								$services = get_post_meta( $p_id, '_cr8v_inquiry_discipline', true );
							}
							$status   = get_post_meta( $p_id, '_cr8v_inquiry_status', true ) ?: 'New';
							$budget   = get_post_meta( $p_id, '_cr8v_inquiry_budget', true );
							$director = get_post_meta( $p_id, '_cr8v_inquiry_director', true );
							$view_url = add_query_arg( array( 'action' => 'view', 'id' => $p_id ), $base_url );
							$del_url  = wp_nonce_url( add_query_arg( array( 'action' => 'delete', 'id' => $p_id ), $base_url ), 'cr8v_delete_inquiry_' . $p_id );

							$srv_items  = array_filter( array_map( 'trim', explode( ',', (string) $services ) ) );
							$srv_count  = count( $srv_items );
							$badge_html = '';

							if ( $srv_count > 0 ) {
								$first_two = array_slice( $srv_items, 0, 2 );
								foreach ( $first_two as $srv_name ) {
									$badge_html .= '<span class="cr8v-tag-pill">' . esc_html( $srv_name ) . '</span>';
								}
								if ( $srv_count > 2 ) {
									$remaining_count = $srv_count - 2;
									$remaining_list  = implode( ', ', array_slice( $srv_items, 2 ) );
									$badge_html     .= '<span title="' . esc_attr( $remaining_list ) . '" class="cr8v-tag-overflow">+' . intval( $remaining_count ) . ( $remaining_count === 1 ? ' other' : ' others' ) . '</span>';
								}
							} else {
								$badge_html = '<span style="color:#94A3B8; font-size:12px;">General Production</span>';
							}

							$dots = array(
								'New'       => 'neon-emerald',
								'In Review' => 'neon-amber',
								'Contacted' => 'neon-blue',
								'Concluded' => 'neon-slate',
							);
							$dot_class = $dots[ $status ] ?? 'neon-emerald';
							$is_conc   = ( 'Concluded' === $status );
							?>
							<tr>
								<!-- Client -->
								<td>
									<strong>
										<a href="<?php echo esc_url( $view_url ); ?>" style="color:#0F172A; font-size:14px; font-weight:700; text-decoration:none;">
											<?php echo esc_html( $c_name ); ?>
										</a>
									</strong>
									<div style="font-family:ui-monospace, monospace; font-size:11px; color:#64748B; margin-top:2px;">
										#<?php echo esc_html( $p_id ); ?> &bull; <?php echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ); ?> ago
									</div>
								</td>

								<!-- Date -->
								<td>
									<div style="font-family:ui-monospace, monospace; font-size:12.5px; font-weight:700; color:#0F172A;"><?php echo get_the_date( 'd M Y', $p_id ); ?></div>
									<div style="font-family:ui-monospace, monospace; font-size:11px; color:#64748B;"><?php echo get_the_date( 'H:i T', $p_id ); ?></div>
								</td>

								<!-- Coordinates -->
								<td>
									<?php if ( $email ) : ?>
										<a href="mailto:<?php echo esc_attr( $email ); ?>" style="font-size:12.5px; font-weight:600; color:#0F172A; text-decoration:underline; display:block;">
											<?php echo esc_html( $email ); ?>
										</a>
									<?php endif; ?>
									<?php if ( $phone ) : ?>
										<span style="font-family:ui-monospace, monospace; font-size:11.5px; color:#64748B; display:block; margin-top:2px;">
											<?php echo esc_html( $phone ); ?>
										</span>
									<?php endif; ?>
								</td>

								<!-- Services -->
								<td>
									<div style="display:flex; flex-wrap:wrap; align-items:center;">
										<?php echo $badge_html; ?>
									</div>
								</td>

								<!-- Status -->
								<td>
									<span class="cr8v-status-chip <?php echo $is_conc ? 'is-concluded' : ''; ?>">
										<span class="cr8v-neon-dot <?php echo esc_attr( $dot_class ); ?>"></span>
										<?php echo esc_html( $status ); ?>
									</span>
								</td>

								<!-- Actions -->
								<td style="text-align:right; white-space:nowrap;">
									<a href="<?php echo esc_url( $view_url ); ?>" class="cr8v-btn cr8v-btn-secondary" style="padding:4px 10px; font-size:12px;">
										<?php _e( 'Dossier', 'cr8v-events-core' ); ?>
									</a>
									<a href="<?php echo esc_url( $del_url ); ?>" onclick="return confirm('Move this project inquiry to trash?');" class="cr8v-btn cr8v-btn-danger" style="padding:4px 8px; font-size:12px; margin-left:4px;" title="<?php esc_attr_e( 'Delete', 'cr8v-events-core' ); ?>">
										<span class="dashicons dashicons-trash" style="font-size:14px; margin-top:2px;"></span>
									</a>
								</td>
							</tr>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</tbody>
				</table>
			<?php else : ?>
				<div style="padding:64px 20px; text-align:center; color:#64748B;">
					<div style="font-size:38px; margin-bottom:12px;">📋</div>
					<h3 style="font-size:16px; margin:0 0 6px; font-weight:700; color:#0F172A;">
						<?php _e( 'No Project Inquiries Found', 'cr8v-events-core' ); ?>
					</h3>
					<p style="font-size:13px; margin:0; max-width:440px; margin:0 auto 18px;">
						<?php _e( 'Inquiries submitted through your website contact worksheet will automatically populate here.', 'cr8v-events-core' ); ?>
					</p>
					<a href="<?php echo esc_url( $new_url ); ?>" class="cr8v-btn cr8v-btn-primary">
						<?php _e( '+ Create Manual Inquiry', 'cr8v-events-core' ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>

		<?php cr8v_render_inquiries_shared_footer(); ?>

	</div>
	<?php
}

/**
 * 8. Single Inquiry Dossier View (Studio Edition)
 */
function cr8v_render_single_inquiry_dossier_view( $post_id ) {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have permission to view this project inquiry.', 'cr8v-events-core' ) );
	}

	$post = get_post( $post_id );
	if ( ! $post || 'cr8v_inquiry' !== $post->post_type ) {
		echo '<div class="notice notice-error"><p>' . __( 'Project inquiry not found.', 'cr8v-events-core' ) . '</p></div>';
		return;
	}

	$client_name    = get_the_title( $post_id );
	$email          = get_post_meta( $post_id, '_cr8v_inquiry_email', true );
	$phone          = get_post_meta( $post_id, '_cr8v_inquiry_phone', true );
	$services       = get_post_meta( $post_id, '_cr8v_inquiry_services', true );
	if ( empty( $services ) ) {
		$services = get_post_meta( $post_id, '_cr8v_inquiry_discipline', true );
	}
	$scope          = get_post_meta( $post_id, '_cr8v_inquiry_scope', true );
	$ip             = get_post_meta( $post_id, '_cr8v_inquiry_ip', true );
	$status         = get_post_meta( $post_id, '_cr8v_inquiry_status', true ) ?: 'New';
	$director       = get_post_meta( $post_id, '_cr8v_inquiry_director', true );
	$budget         = get_post_meta( $post_id, '_cr8v_inquiry_budget', true );
	$internal_notes = get_post_meta( $post_id, '_cr8v_inquiry_internal_notes', true );

	$list_url   = admin_url( 'admin.php?page=cr8v-inquiries' );
	$del_url    = wp_nonce_url( add_query_arg( array( 'action' => 'delete', 'id' => $post_id ), $list_url ), 'cr8v_delete_inquiry_' . $post_id );
	$srv_items  = array_filter( array_map( 'trim', explode( ',', (string) $services ) ) );
	$site_title = get_bloginfo( 'name' );

	cr8v_render_inquiries_shared_css();
	?>
	<div class="wrap cr8v-app-wrap" style="max-width:1150px;">
		
		<!-- Command Top Bar -->
		<div class="cr8v-topbar cr8v-no-print">
			<div class="cr8v-brand-cluster">
				<div class="cr8v-brand-logo">C8</div>
				<div class="cr8v-brand-meta">
					<span class="cr8v-brand-kicker"><span class="cr8v-neon-dot neon-emerald"></span> <?php _e( 'Event Specification Brief', 'cr8v-events-core' ); ?> &bull; #<?php echo esc_html( $post_id ); ?></span>
					<h1 class="cr8v-brand-title"><?php echo esc_html( $client_name ); ?></h1>
				</div>
			</div>

			<div class="cr8v-topbar-nav">
				<?php if ( $email ) : ?>
					<a href="mailto:<?php echo esc_attr( $email ); ?>?subject=Re:%20Event%20Production%20Brief%20-%20<?php echo rawurlencode( $site_title ); ?>" class="cr8v-btn cr8v-btn-primary">
						<span class="dashicons dashicons-email-alt" style="font-size:15px; margin-top:2px;"></span> <?php _e( 'Reply via Email', 'cr8v-events-core' ); ?>
					</a>
				<?php endif; ?>
				<?php if ( $phone ) : ?>
					<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="cr8v-btn cr8v-btn-secondary">
						<span class="dashicons dashicons-phone" style="font-size:15px; margin-top:2px;"></span> <?php _e( 'Call Client', 'cr8v-events-core' ); ?>
					</a>
				<?php endif; ?>
				<button type="button" onclick="window.print()" class="cr8v-btn cr8v-btn-secondary">
					<span class="dashicons dashicons-printer" style="font-size:15px; margin-top:2px;"></span> <?php _e( 'Print Dossier', 'cr8v-events-core' ); ?>
				</button>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=cr8v-inquiries-email' ) ); ?>" class="cr8v-btn cr8v-btn-secondary">
					<span class="dashicons dashicons-email-alt" style="font-size:15px; margin-top:2px;"></span> <?php _e( 'Email Settings', 'cr8v-events-core' ); ?>
				</a>
				<a href="<?php echo esc_url( $list_url ); ?>" class="cr8v-btn cr8v-btn-secondary">
					&larr; <?php _e( 'Back to Ledger', 'cr8v-events-core' ); ?>
				</a>
				<a href="<?php echo esc_url( $del_url ); ?>" onclick="return confirm('Move this project inquiry to trash?');" class="cr8v-btn cr8v-btn-danger" title="<?php esc_attr_e( 'Delete', 'cr8v-events-core' ); ?>">
					<span class="dashicons dashicons-trash" style="font-size:14px; margin-top:2px;"></span>
				</a>
			</div>
		</div>

		<div class="cr8v-card-box">
			
			<form method="post" action="<?php echo esc_url( add_query_arg( array( 'action' => 'view', 'id' => $post_id ), $list_url ) ); ?>">
				<?php wp_nonce_field( 'cr8v_save_dossier_action', 'cr8v_save_dossier_nonce' ); ?>
				<input type="hidden" name="inquiry_id" value="<?php echo esc_attr( $post_id ); ?>">

				<!-- 2-Column Info Grid -->
				<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px;">
					
					<!-- Client Coordinates -->
					<div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:10px; padding:20px;">
						<h3 class="cr8v-field-label" style="margin-bottom:14px; color:#0F172A;">
							<?php _e( 'Client Coordinates', 'cr8v-events-core' ); ?>
						</h3>
						<p style="margin:0 0 8px; font-size:13.5px;"><strong>Organization / Name:</strong> <span style="color:#0F172A; font-weight:600;"><?php echo esc_html( $client_name ); ?></span></p>
						<p style="margin:0 0 8px; font-size:13.5px;"><strong>Work Email:</strong> <a href="mailto:<?php echo esc_attr( $email ); ?>" style="color:#0F172A; font-weight:700; text-decoration:underline;"><?php echo esc_html( $email ); ?></a></p>
						<p style="margin:0 0 8px; font-size:13.5px;"><strong>Phone / WhatsApp:</strong> <span style="color:#0F172A;"><?php echo $phone ? esc_html( $phone ) : '<em>Not provided</em>'; ?></span></p>
						<p style="margin:0; font-family:ui-monospace, monospace; font-size:11.5px; color:#64748B;">Received: <?php echo get_the_date( 'd M Y, H:i T', $post_id ); ?> (IP: <?php echo esc_html( $ip ? $ip : '127.0.0.1' ); ?>)</p>
					</div>

					<!-- Status & Lifecycle -->
					<div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:10px; padding:20px;">
						<h3 class="cr8v-field-label" style="margin-bottom:14px; color:#0F172A;">
							<?php _e( 'Lifecycle Pipeline Stage', 'cr8v-events-core' ); ?>
						</h3>
						<select name="inquiry_status" class="cr8v-studio-select" style="font-weight:700; margin-bottom:10px;">
							<option value="New" <?php selected( $status, 'New' ); ?>><?php _e( 'New (Requires Review)', 'cr8v-events-core' ); ?></option>
							<option value="In Review" <?php selected( $status, 'In Review' ); ?>><?php _e( 'In Review with Team', 'cr8v-events-core' ); ?></option>
							<option value="Contacted" <?php selected( $status, 'Contacted' ); ?>><?php _e( 'Client Contacted / Proposal Sent', 'cr8v-events-core' ); ?></option>
							<option value="Concluded" <?php selected( $status, 'Concluded' ); ?>><?php _e( 'Concluded / Booked', 'cr8v-events-core' ); ?></option>
						</select>
						<p style="margin:0; font-size:12px; color:#64748B;">
							<?php _e( 'Change stage and click "Save Changes" to update tracking records.', 'cr8v-events-core' ); ?>
						</p>
					</div>

				</div>

				<!-- Requested Services -->
				<div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:10px; padding:20px; margin-bottom:24px;">
					<h3 class="cr8v-field-label" style="margin-bottom:12px; color:#0F172A;">
						<?php printf( __( 'Requested Disciplines (%d Specified)', 'cr8v-events-core' ), count( $srv_items ) ); ?>
					</h3>
					<div style="display:flex; flex-wrap:wrap; gap:6px;">
						<?php
						if ( ! empty( $srv_items ) ) {
							foreach ( $srv_items as $srv ) {
								echo '<span class="cr8v-tag-pill" style="font-size:12.5px; padding:5px 12px; background:#FFFFFF;">' . esc_html( $srv ) . '</span>';
							}
						} else {
							echo '<span style="color:#64748B; font-size:13px;">General Live Production</span>';
						}
						?>
					</div>
				</div>

				<!-- Scope / Description -->
				<div style="margin-bottom:24px;">
					<h3 class="cr8v-field-label" style="margin-bottom:8px; color:#0F172A;">
						<?php _e( 'Project Brief & Specifications', 'cr8v-events-core' ); ?>
					</h3>
					<div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:10px; padding:20px; font-size:13.5px; line-height:1.75; color:#0F172A; white-space:pre-wrap; font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;">
<?php echo esc_html( $scope ); ?>
					</div>
				</div>

				<!-- Production Assignment & Notes -->
				<div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:10px; padding:22px; margin-bottom:28px;">
					<h3 style="font-family:ui-monospace, monospace; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:#0F172A; margin:0 0 16px;">
						<?php _e( 'Internal Production Assignment & Quote Ledger', 'cr8v-events-core' ); ?>
					</h3>

					<div style="display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:16px;">
						<div>
							<label class="cr8v-field-label" for="inquiry_director">
								<?php _e( 'Lead Technical Director Assigned:', 'cr8v-events-core' ); ?>
							</label>
							<input type="text" id="inquiry_director" name="inquiry_director" value="<?php echo esc_attr( $director ); ?>" placeholder="e.g. Marcus Vance" class="cr8v-studio-input">
						</div>
						<div>
							<label class="cr8v-field-label" for="inquiry_budget">
								<?php _e( 'Estimated Project Budget / Quote (£ GBP):', 'cr8v-events-core' ); ?>
							</label>
							<input type="text" id="inquiry_budget" name="inquiry_budget" value="<?php echo esc_attr( $budget ); ?>" placeholder="e.g. £45,000" class="cr8v-studio-input" style="font-family:ui-monospace, monospace;">
						</div>
					</div>

					<div>
						<label class="cr8v-field-label" for="inquiry_internal_notes">
							<?php _e( 'Private Production Notes:', 'cr8v-events-core' ); ?>
						</label>
						<textarea id="inquiry_internal_notes" name="inquiry_internal_notes" rows="4" placeholder="Enter private site-visit logs, staging calculations, or notes..." class="cr8v-studio-textarea"><?php echo esc_textarea( $internal_notes ); ?></textarea>
					</div>
				</div>

				<div style="text-align:right;" class="cr8v-no-print">
					<button type="submit" class="cr8v-btn cr8v-btn-primary" style="padding:10px 24px;">
						<?php _e( 'Save Changes', 'cr8v-events-core' ); ?>
					</button>
				</div>

			</form>

		</div>

		<?php cr8v_render_inquiries_shared_footer(); ?>

	</div>
	<?php
}

/**
 * 9. Dedicated Analytics & Pipeline Reports Page (Studio Edition)
 */
function cr8v_render_inquiries_reports_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have permission to view project reports.', 'cr8v-events-core' ) );
	}

	$count_all       = cr8v_get_inquiries_count( 'all' );
	$count_new       = cr8v_get_inquiries_count( 'New' );
	$count_in_review = cr8v_get_inquiries_count( 'In Review' );
	$count_contacted = cr8v_get_inquiries_count( 'Contacted' );
	$count_concluded = cr8v_get_inquiries_count( 'Concluded' );

	$conversion_rate = $count_all > 0 ? round( ( $count_concluded / $count_all ) * 100, 1 ) : 0;

	// Calculate Services Frequency Breakdown
	$all_inquiries = get_posts( array(
		'post_type'      => 'cr8v_inquiry',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	) );

	$services_tally = array();
	$total_budget   = 0;
	$budget_count   = 0;

	foreach ( $all_inquiries as $inq ) {
		$srv_str = get_post_meta( $inq->ID, '_cr8v_inquiry_services', true );
		if ( empty( $srv_str ) ) {
			$srv_str = get_post_meta( $inq->ID, '_cr8v_inquiry_discipline', true );
		}
		if ( $srv_str ) {
			$items = array_filter( array_map( 'trim', explode( ',', $srv_str ) ) );
			foreach ( $items as $item ) {
				$services_tally[ $item ] = ( $services_tally[ $item ] ?? 0 ) + 1;
			}
		}

		$raw_budget = get_post_meta( $inq->ID, '_cr8v_inquiry_budget', true );
		if ( $raw_budget ) {
			$clean_num = floatval( preg_replace( '/[^0-9.]/', '', $raw_budget ) );
			if ( $clean_num > 0 ) {
				$total_budget += $clean_num;
				$budget_count++;
			}
		}
	}

	arsort( $services_tally );

	$list_url   = admin_url( 'admin.php?page=cr8v-inquiries' );
	$export_url = wp_nonce_url( admin_url( 'admin.php?cr8v_action=export_inquiries_csv' ), 'cr8v_export_csv_nonce' );
	$site_title = get_bloginfo( 'name' );

	cr8v_render_inquiries_shared_css();
	?>
	<div class="wrap cr8v-app-wrap">
		
		<!-- Top Command Bar -->
		<div class="cr8v-topbar">
			<div class="cr8v-brand-cluster">
				<div class="cr8v-brand-logo">C8</div>
				<div class="cr8v-brand-meta">
					<span class="cr8v-brand-kicker"><span class="cr8v-neon-dot neon-emerald"></span> <?php _e( 'Analytics & Conversion Suite', 'cr8v-events-core' ); ?> &bull; <?php echo esc_html( $site_title ); ?></span>
					<h1 class="cr8v-brand-title"><?php _e( 'Pipeline Analytics & Demand Reports', 'cr8v-events-core' ); ?></h1>
				</div>
			</div>

			<div class="cr8v-topbar-nav">
				<a href="<?php echo esc_url( $export_url ); ?>" class="cr8v-btn cr8v-btn-secondary">
					<span class="dashicons dashicons-download" style="font-size:16px; margin-top:2px;"></span> <?php _e( 'Download Complete CSV', 'cr8v-events-core' ); ?>
				</a>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=cr8v-inquiries-email' ) ); ?>" class="cr8v-btn cr8v-btn-secondary">
					<span class="dashicons dashicons-email-alt" style="font-size:16px; margin-top:2px;"></span> <?php _e( 'Email Services', 'cr8v-events-core' ); ?>
				</a>
				<a href="<?php echo esc_url( $list_url ); ?>" class="cr8v-btn cr8v-btn-primary">
					&larr; <?php _e( 'Back to Ledger', 'cr8v-events-core' ); ?>
				</a>
			</div>
		</div>

		<!-- Executive Metrics Cards -->
		<div class="cr8v-kpi-grid" style="margin-bottom:28px;">
			<div class="cr8v-kpi-card" style="border-top: 3px solid #09090B;">
				<span class="cr8v-kpi-label"><?php _e( 'Total Briefs Received', 'cr8v-events-core' ); ?></span>
				<div class="cr8v-kpi-num"><?php echo intval( $count_all ); ?></div>
				<span class="cr8v-kpi-hint" style="color:#059669; font-weight:600;"><?php _e( '100% In-house Live Ingestion', 'cr8v-events-core' ); ?></span>
			</div>

			<div class="cr8v-kpi-card" style="border-top: 3px solid #3B82F6;">
				<span class="cr8v-kpi-label"><?php _e( 'Pipeline Conversion Rate', 'cr8v-events-core' ); ?></span>
				<div class="cr8v-kpi-num" style="color:#2563EB;"><?php echo esc_html( $conversion_rate ); ?>%</div>
				<span class="cr8v-kpi-hint"><?php echo intval( $count_concluded ); ?> <?php _e( 'Booked & Confirmed', 'cr8v-events-core' ); ?></span>
			</div>

			<div class="cr8v-kpi-card" style="border-top: 3px solid #F59E0B;">
				<span class="cr8v-kpi-label"><?php _e( 'Pipeline Quote Value (£)', 'cr8v-events-core' ); ?></span>
				<div class="cr8v-kpi-num" style="color:#D97706; font-family:ui-monospace, monospace;">
					£<?php echo number_format( $total_budget, 0 ); ?>
				</div>
				<span class="cr8v-kpi-hint"><?php printf( __( 'Across %d quoted briefs', 'cr8v-events-core' ), intval( $budget_count ) ); ?></span>
			</div>

			<div class="cr8v-kpi-card" style="border-top: 3px solid #10B981;">
				<span class="cr8v-kpi-label"><?php _e( 'Active Deals In Pipeline', 'cr8v-events-core' ); ?></span>
				<div class="cr8v-kpi-num" style="color:#059669;"><?php echo intval( $count_new + $count_in_review + $count_contacted ); ?></div>
				<span class="cr8v-kpi-hint"><?php _e( 'Currently in active negotiation', 'cr8v-events-core' ); ?></span>
			</div>
		</div>

		<!-- 2-Column Analytics Breakdown -->
		<div style="display:grid; grid-template-columns:1.3fr 1fr; gap:24px; align-items:start;">
			
			<!-- Services Demand Breakdown -->
			<div class="cr8v-card-box">
				<h3 style="font-family:ui-monospace, monospace; font-size:12px; font-weight:700; color:#0F172A; margin:0 0 20px; text-transform:uppercase; letter-spacing:0.06em;">
					<?php _e( 'Services Demand Breakdown', 'cr8v-events-core' ); ?>
				</h3>

				<?php if ( ! empty( $services_tally ) ) : ?>
					<div style="display:flex; flex-direction:column; gap:16px;">
						<?php
						$max_val = max( $services_tally );
						foreach ( $services_tally as $srv_name => $srv_count ) :
							$pct = $count_all > 0 ? round( ( $srv_count / $count_all ) * 100, 1 ) : 0;
							$bar_width = $max_val > 0 ? round( ( $srv_count / $max_val ) * 100 ) : 0;
							?>
							<div>
								<div style="display:flex; justify-content:space-between; font-size:13px; font-weight:600; margin-bottom:6px; color:#1E293B;">
									<span><?php echo esc_html( $srv_name ); ?></span>
									<span style="font-family:ui-monospace, monospace; color:#64748B;"><?php echo intval( $srv_count ); ?> (<?php echo esc_html( $pct ); ?>%)</span>
								</div>
								<div style="width:100%; height:8px; background:#F1F5F9; border-radius:999px; overflow:hidden;">
									<div style="width:<?php echo intval( $bar_width ); ?>%; height:100%; background:linear-gradient(90deg, #09090B 0%, #64748B 100%); border-radius:999px;"></div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php else : ?>
					<p style="color:#64748B; font-size:13px; margin:0;"><?php _e( 'No services data recorded yet.', 'cr8v-events-core' ); ?></p>
				<?php endif; ?>
			</div>

			<!-- Status Funnel & Operations -->
			<div class="cr8v-card-box">
				<h3 style="font-family:ui-monospace, monospace; font-size:12px; font-weight:700; color:#0F172A; margin:0 0 20px; text-transform:uppercase; letter-spacing:0.06em;">
					<?php _e( 'Production Pipeline Funnel', 'cr8v-events-core' ); ?>
				</h3>

				<div style="display:flex; flex-direction:column; gap:12px;">
					<div style="display:flex; justify-content:space-between; align-items:center; padding:14px 18px; background:#F8FAFC; border:1px solid #E2E8F0; border-left:4px solid #10B981; border-radius:8px;">
						<div>
							<strong style="color:#0F172A; font-size:13.5px; display:block;">Stage 01: New / Unread</strong>
							<span style="font-size:12px; color:#64748B;">Awaiting initial specification review</span>
						</div>
						<span style="font-size:22px; font-weight:800; color:#059669; font-family:ui-monospace, monospace;"><?php echo intval( $count_new ); ?></span>
					</div>

					<div style="display:flex; justify-content:space-between; align-items:center; padding:14px 18px; background:#F8FAFC; border:1px solid #E2E8F0; border-left:4px solid #F59E0B; border-radius:8px;">
						<div>
							<strong style="color:#0F172A; font-size:13.5px; display:block;">Stage 02: In Review</strong>
							<span style="font-size:12px; color:#64748B;">Technical planning & quote estimation</span>
						</div>
						<span style="font-size:22px; font-weight:800; color:#D97706; font-family:ui-monospace, monospace;"><?php echo intval( $count_in_review ); ?></span>
					</div>

					<div style="display:flex; justify-content:space-between; align-items:center; padding:14px 18px; background:#F8FAFC; border:1px solid #E2E8F0; border-left:4px solid #3B82F6; border-radius:8px;">
						<div>
							<strong style="color:#0F172A; font-size:13.5px; display:block;">Stage 03: Client Contacted</strong>
							<span style="font-size:12px; color:#64748B;">Proposal dispatched & negotiation</span>
						</div>
						<span style="font-size:22px; font-weight:800; color:#2563EB; font-family:ui-monospace, monospace;"><?php echo intval( $count_contacted ); ?></span>
					</div>

					<div style="display:flex; justify-content:space-between; align-items:center; padding:14px 18px; background:#F8FAFC; border:1px solid #E2E8F0; border-left:4px solid #64748B; border-radius:8px;">
						<div>
							<strong style="color:#0F172A; font-size:13.5px; display:block;">Stage 04: Concluded / Booked</strong>
							<span style="font-size:12px; color:#64748B;">Contract signed & production confirmed</span>
						</div>
						<span style="font-size:22px; font-weight:800; color:#475569; font-family:ui-monospace, monospace;"><?php echo intval( $count_concluded ); ?></span>
					</div>
				</div>
			</div>

		</div>

		<?php cr8v_render_inquiries_shared_footer(); ?>

	</div>
	<?php
}

/**
 * 10. Dedicated Email & Notification Services Admin Page (Studio Edition)
 */
function cr8v_render_inquiries_email_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have permission to configure email services.', 'cr8v-events-core' ) );
	}

	$save_notice = '';
	$test_notice = '';
	$test_error  = '';

	// Handle Settings Save
	if ( isset( $_POST['cr8v_save_email_settings_nonce'] ) && wp_verify_nonce( $_POST['cr8v_save_email_settings_nonce'], 'cr8v_save_email_settings_action' ) ) {
		$admin_email   = sanitize_email( $_POST['cr8v_admin_email'] ?? '' );
		$cc_emails     = sanitize_text_field( $_POST['cr8v_cc_emails'] ?? '' );
		$from_name     = sanitize_text_field( $_POST['cr8v_from_name'] ?? '' );
		$from_email    = sanitize_email( $_POST['cr8v_from_email'] ?? '' );
		$enable_receipt= isset( $_POST['cr8v_enable_receipt'] ) ? '1' : '0';
		$admin_subj    = sanitize_text_field( $_POST['cr8v_admin_subject'] ?? '' );
		$client_subj   = sanitize_text_field( $_POST['cr8v_client_subject'] ?? '' );

		if ( is_email( $admin_email ) ) {
			update_option( 'cr8v_admin_notification_email', $admin_email );
			update_option( 'cr8v_cc_notification_emails', $cc_emails );
			update_option( 'cr8v_email_from_name', $from_name );
			update_option( 'cr8v_email_from_address', $from_email );
			update_option( 'cr8v_email_enable_client_receipt', $enable_receipt );
			update_option( 'cr8v_email_admin_subject', $admin_subj );
			update_option( 'cr8v_email_client_subject', $client_subj );

			$save_notice = __( 'Email dispatch settings saved successfully.', 'cr8v-events-core' );
		} else {
			$test_error = __( 'Please provide a valid primary admin email address.', 'cr8v-events-core' );
		}
	}

	// Handle Test Email Dispatch
	if ( isset( $_POST['cr8v_test_email_nonce'] ) && wp_verify_nonce( $_POST['cr8v_test_email_nonce'], 'cr8v_test_email_action' ) ) {
		$test_recipient = sanitize_email( $_POST['test_recipient_email'] ?? '' );
		if ( is_email( $test_recipient ) ) {
			$test_services = array( 'Stage & Technical Production', 'Concert Sound & Acoustic Design' );
			$test_scope    = "This is an automated live test dispatch from the Cr8v Events Core Email Engine.\n\nEverything is operational and ready to receive client event briefs.";
			
			$result = cr8v_dispatch_inquiry_emails(
				'Apex Production Group (Test Ingestion)',
				$test_recipient,
				'+44 7760 000000',
				$test_services,
				$test_scope
			);

			if ( $result['admin_sent'] || $result['client_sent'] ) {
				$test_notice = sprintf( __( 'Test email dispatched successfully to %s at %s!', 'cr8v-events-core' ), esc_html( $test_recipient ), current_time( 'H:i:s T' ) );
			} else {
				$test_error = sprintf( __( 'WordPress was unable to dispatch the email to %s. Please verify your SMTP server or hosting mail service.', 'cr8v-events-core' ), esc_html( $test_recipient ) );
			}
		} else {
			$test_error = __( 'Please enter a valid recipient email address for testing.', 'cr8v-events-core' );
		}
	}

	$settings   = cr8v_get_email_notification_settings();
	$list_url   = admin_url( 'admin.php?page=cr8v-inquiries' );
	$report_url = admin_url( 'admin.php?page=cr8v-inquiries-reports' );
	$site_title = get_bloginfo( 'name' );

	// Determine Active Mail Transport
	$smtp_active = class_exists( 'WPMailSMTP\Core' ) || class_exists( 'WPMailSMTP\WP' ) || has_action( 'phpmailer_init' );
	$transport_label = $smtp_active ? 'Active (Custom SMTP / Transport Filter)' : 'PHP mail() Native Transport';

	cr8v_render_inquiries_shared_css();
	?>
	<div class="wrap cr8v-app-wrap">
		
		<!-- Top Command Bar -->
		<div class="cr8v-topbar cr8v-no-print">
			<div class="cr8v-brand-cluster">
				<div class="cr8v-brand-logo">C8</div>
				<div class="cr8v-brand-meta">
					<span class="cr8v-brand-kicker"><span class="cr8v-neon-dot neon-emerald"></span> <?php _e( 'Email & Notification Engine', 'cr8v-events-core' ); ?> &bull; <?php echo esc_html( $site_title ); ?></span>
					<h1 class="cr8v-brand-title"><?php _e( 'Email Services & Notification Settings', 'cr8v-events-core' ); ?></h1>
				</div>
			</div>

			<div class="cr8v-topbar-nav">
				<a href="<?php echo esc_url( $report_url ); ?>" class="cr8v-btn cr8v-btn-secondary">
					<span class="dashicons dashicons-chart-bar" style="font-size:16px; margin-top:2px;"></span> <?php _e( 'Pipeline Reports', 'cr8v-events-core' ); ?>
				</a>
				<a href="<?php echo esc_url( $list_url ); ?>" class="cr8v-btn cr8v-btn-secondary">
					&larr; <?php _e( 'Back to Ledger', 'cr8v-events-core' ); ?>
				</a>
			</div>
		</div>

		<?php if ( ! empty( $save_notice ) ) : ?>
			<div style="background:#F0FDF4; border:1px solid #BBF7D0; border-left:4px solid #10B981; padding:14px 18px; border-radius:8px; margin-bottom:20px; color:#166534; font-size:13.5px; font-weight:600;">
				✓ <?php echo esc_html( $save_notice ); ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $test_notice ) ) : ?>
			<div style="background:#F0FDF4; border:1px solid #BBF7D0; border-left:4px solid #10B981; padding:14px 18px; border-radius:8px; margin-bottom:20px; color:#166534; font-size:13.5px; font-weight:600;">
				🚀 <?php echo esc_html( $test_notice ); ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $test_error ) ) : ?>
			<div style="background:#FEF2F2; border:1px solid #FECACA; border-left:4px solid #EF4444; padding:14px 18px; border-radius:8px; margin-bottom:20px; color:#991B1B; font-size:13.5px; font-weight:600;">
				⚠️ <?php echo esc_html( $test_error ); ?>
			</div>
		<?php endif; ?>

		<!-- System Diagnostics KPI Cards -->
		<div class="cr8v-kpi-grid" style="margin-bottom:24px;">
			<div class="cr8v-kpi-card" style="border-top: 3px solid #09090B;">
				<span class="cr8v-kpi-label"><?php _e( 'Primary Target Email', 'cr8v-events-core' ); ?></span>
				<div style="font-size:16px; font-weight:800; color:#0F172A; word-break:break-all; margin:6px 0 2px;">
					<?php echo esc_html( $settings['admin_email'] ); ?>
				</div>
				<span class="cr8v-kpi-hint" style="color:#059669; font-weight:600;">✓ Active Brief Dispatch Target</span>
			</div>

			<div class="cr8v-kpi-card" style="border-top: 3px solid #10B981;">
				<span class="cr8v-kpi-label"><span class="cr8v-neon-dot neon-emerald"></span> <?php _e( 'Outbound Mail Engine', 'cr8v-events-core' ); ?></span>
				<div style="font-size:18px; font-weight:800; color:#059669; margin:6px 0 2px;">
					wp_mail() Ready
				</div>
				<span class="cr8v-kpi-hint"><?php echo esc_html( $transport_label ); ?></span>
			</div>

			<div class="cr8v-kpi-card" style="border-top: 3px solid #3B82F6;">
				<span class="cr8v-kpi-label"><span class="cr8v-neon-dot neon-blue"></span> <?php _e( 'Client Auto-Receipt', 'cr8v-events-core' ); ?></span>
				<div style="font-size:18px; font-weight:800; color:#2563EB; margin:6px 0 2px;">
					<?php echo ( '1' === (string) $settings['enable_client_receipt'] ) ? __( 'Enabled (100% Automated)', 'cr8v-events-core' ) : __( 'Disabled', 'cr8v-events-core' ); ?>
				</div>
				<span class="cr8v-kpi-hint"><?php _e( 'Rich HTML Stationery Dispatch', 'cr8v-events-core' ); ?></span>
			</div>

			<div class="cr8v-kpi-card" style="border-top: 3px solid #64748B;">
				<span class="cr8v-kpi-label"><?php _e( 'Active Brand Theme', 'cr8v-events-core' ); ?></span>
				<div style="font-size:16px; font-weight:800; color:#0F172A; margin:6px 0 2px;">
					<?php echo esc_html( $site_title ); ?>
				</div>
				<span class="cr8v-kpi-hint"><?php echo esc_html( wp_get_theme()->get( 'Name' ) ); ?> v<?php echo esc_html( wp_get_theme()->get( 'Version' ) ); ?></span>
			</div>
		</div>

		<!-- 2-Column Settings & Testing Grid -->
		<div style="display:grid; grid-template-columns:1.35fr 1fr; gap:24px; align-items:start;">
			
			<!-- Left Column: Main Configuration Form -->
			<div class="cr8v-card-box">
				<h3 style="font-family:ui-monospace, monospace; font-size:12px; font-weight:700; color:#0F172A; margin:0 0 20px; text-transform:uppercase; letter-spacing:0.06em;">
					<?php _e( 'Notification Routing & Dispatchers', 'cr8v-events-core' ); ?>
				</h3>

				<form method="post" action="">
					<?php wp_nonce_field( 'cr8v_save_email_settings_action', 'cr8v_save_email_settings_nonce' ); ?>

					<div style="margin-bottom:20px;">
						<label class="cr8v-field-label" for="cr8v_admin_email">
							<?php _e( 'Default Admin Notification Email (Primary Ingestion):', 'cr8v-events-core' ); ?> <span style="color:#DC2626;">*</span>
						</label>
						<input type="email" id="cr8v_admin_email" name="cr8v_admin_email" value="<?php echo esc_attr( $settings['admin_email'] ); ?>" class="cr8v-studio-input" required>
						<span style="font-size:12px; color:#64748B; margin-top:4px; display:block;">
							<?php _e( 'All incoming website briefs, intake dossiers, and emergency specifications will be dispatched here.', 'cr8v-events-core' ); ?>
						</span>
					</div>

					<div style="margin-bottom:20px;">
						<label class="cr8v-field-label" for="cr8v_cc_emails">
							<?php _e( 'Secondary / CC Notification Emails (Optional):', 'cr8v-events-core' ); ?>
						</label>
						<input type="text" id="cr8v_cc_emails" name="cr8v_cc_emails" value="<?php echo esc_attr( $settings['cc_emails'] ); ?>" placeholder="e.g. director@agency.co.uk, production@agency.co.uk" class="cr8v-studio-input">
						<span style="font-size:12px; color:#64748B; margin-top:4px; display:block;">
							<?php _e( 'Comma-separated list of additional team members or directors to receive copies of all briefs.', 'cr8v-events-core' ); ?>
						</span>
					</div>

					<div style="display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:24px;">
						<div>
							<label class="cr8v-field-label" for="cr8v_from_name">
								<?php _e( 'Sender "From" Display Name:', 'cr8v-events-core' ); ?>
							</label>
							<input type="text" id="cr8v_from_name" name="cr8v_from_name" value="<?php echo esc_attr( $settings['from_name'] ); ?>" class="cr8v-studio-input">
						</div>
						<div>
							<label class="cr8v-field-label" for="cr8v_from_email">
								<?php _e( 'Sender "From" Email Address:', 'cr8v-events-core' ); ?>
							</label>
							<input type="email" id="cr8v_from_email" name="cr8v_from_email" value="<?php echo esc_attr( $settings['from_email'] ); ?>" class="cr8v-studio-input">
						</div>
					</div>

					<div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:10px; padding:20px; margin-bottom:24px;">
						<label style="display:flex; align-items:center; gap:10px; cursor:pointer; font-weight:700; color:#0F172A; font-size:13.5px; margin-bottom:8px;">
							<input type="checkbox" name="cr8v_enable_receipt" value="1" <?php checked( $settings['enable_client_receipt'], '1' ); ?> style="border-radius:4px; transform:scale(1.15);">
							<span><?php _e( 'Send Automated Confirmation Receipt to Clients', 'cr8v-events-core' ); ?></span>
						</label>
						<span style="font-size:12.5px; color:#64748B; display:block; margin-left:26px;">
							<?php _e( 'When enabled, the client immediately receives a beautiful tactile branded HTML receipt confirming that their brief was successfully logged.', 'cr8v-events-core' ); ?>
						</span>
					</div>

					<div style="margin-bottom:20px;">
						<label class="cr8v-field-label" for="cr8v_admin_subject">
							<?php _e( 'Admin Email Subject Line Template:', 'cr8v-events-core' ); ?>
						</label>
						<input type="text" id="cr8v_admin_subject" name="cr8v_admin_subject" value="<?php echo esc_attr( $settings['admin_subject_template'] ); ?>" class="cr8v-studio-input" style="font-family:ui-monospace, monospace;">
					</div>

					<div style="margin-bottom:24px;">
						<label class="cr8v-field-label" for="cr8v_client_subject">
							<?php _e( 'Client Receipt Subject Line Template:', 'cr8v-events-core' ); ?>
						</label>
						<input type="text" id="cr8v_client_subject" name="cr8v_client_subject" value="<?php echo esc_attr( $settings['client_subject_template'] ); ?>" class="cr8v-studio-input" style="font-family:ui-monospace, monospace;">
						<span style="font-size:11.5px; color:#64748B; margin-top:6px; display:block; font-family:ui-monospace, monospace;">
							Tokens: {client_name} &bull; {services} &bull; {site_name}
						</span>
					</div>

					<div style="display:flex; justify-content:flex-end;">
						<button type="submit" class="cr8v-btn cr8v-btn-primary" style="padding:10px 24px;">
							<?php _e( 'Save Email Configuration', 'cr8v-events-core' ); ?>
						</button>
					</div>
				</form>
			</div>

			<!-- Right Column: Live Testing & Stationer Preview -->
			<div style="display:flex; flex-direction:column; gap:24px;">
				
				<!-- Live Dispatch Tester -->
				<div class="cr8v-card-box">
					<h3 style="font-family:ui-monospace, monospace; font-size:12px; font-weight:700; color:#0F172A; margin:0 0 16px; text-transform:uppercase; letter-spacing:0.06em;">
						<?php _e( 'Live Dispatch Tester', 'cr8v-events-core' ); ?>
					</h3>
					<p style="font-size:13px; color:#64748B; margin:0 0 16px; line-height:1.5;">
						<?php _e( 'Send an instant branded test email through your current server/SMTP configuration to verify live deliverability.', 'cr8v-events-core' ); ?>
					</p>

					<form method="post" action="">
						<?php wp_nonce_field( 'cr8v_test_email_action', 'cr8v_test_email_nonce' ); ?>
						
						<div style="margin-bottom:14px;">
							<label class="cr8v-field-label" for="test_recipient_email">
								<?php _e( 'Test Recipient Address:', 'cr8v-events-core' ); ?>
							</label>
							<input type="email" id="test_recipient_email" name="test_recipient_email" value="<?php echo esc_attr( $settings['admin_email'] ); ?>" class="cr8v-studio-input" required>
						</div>

						<button type="submit" class="cr8v-btn cr8v-btn-primary" style="width:100%; justify-content:center;">
							🚀 <?php _e( 'Dispatch Live Test Email', 'cr8v-events-core' ); ?>
						</button>
					</form>
				</div>

				<!-- Email Stationery Overview -->
				<div class="cr8v-card-box">
					<h3 style="font-family:ui-monospace, monospace; font-size:12px; font-weight:700; color:#0F172A; margin:0 0 16px; text-transform:uppercase; letter-spacing:0.06em;">
						<?php _e( 'Stationery & Template Specs', 'cr8v-events-core' ); ?>
					</h3>

					<div style="font-size:13px; color:#334155; line-height:1.6;">
						<p style="margin:0 0 12px;">
							<strong>Brand Architecture:</strong> All emails use custom tactile stationery with responsive HTML tables, dark header washi bars, monospace coordinates badges, and brand seals.
						</p>
						<ul style="margin:0; padding-left:18px; color:#64748B; font-size:12.5px;">
							<li><strong>Admin Brief:</strong> Dispatched with full client contact details, selected disciplines, project requirements, and quick-reply action triggers.</li>
							<li style="margin-top:6px;"><strong>Client Receipt:</strong> Dispatched with official confirmation seal, team contact info, and production desk contact details.</li>
						</ul>
					</div>
				</div>

			</div>

		</div>

		<?php cr8v_render_inquiries_shared_footer(); ?>

	</div>
	<?php
}

/**
 * 11. Helper: Unified Email Settings Getter
 */
function cr8v_get_email_notification_settings() {
	$theme   = wp_get_theme();
	$is_rce  = ( strpos( strtolower( $theme->get_template() ), 'red-cap' ) !== false );
	$default_email = $is_rce ? get_theme_mod( 'rce_contact_email', 'info@redcapentertainment.co.uk' ) : get_theme_mod( 'cr8v_contact_email', 'info@blackandwhitecraft.co.uk' );
	if ( empty( $default_email ) ) {
		$default_email = get_option( 'admin_email' );
	}

	return array(
		'admin_email'             => get_option( 'cr8v_admin_notification_email', $default_email ),
		'cc_emails'               => get_option( 'cr8v_cc_notification_emails', '' ),
		'from_name'               => get_option( 'cr8v_email_from_name', get_bloginfo( 'name' ) ),
		'from_email'              => get_option( 'cr8v_email_from_address', $default_email ),
		'enable_client_receipt'   => get_option( 'cr8v_email_enable_client_receipt', '1' ),
		'admin_subject_template'  => get_option( 'cr8v_email_admin_subject', 'New Event Brief from {client_name} [{services}]' ),
		'client_subject_template' => get_option( 'cr8v_email_client_subject', 'We have received your event brief — {site_name}' ),
	);
}

/**
 * 12. Helper: Unified Email Dispatcher for Both Themes
 */
function cr8v_dispatch_inquiry_emails( $client_name, $client_email, $client_phone, $selected_services, $scope ) {
	$settings  = cr8v_get_email_notification_settings();
	$site_name = get_bloginfo( 'name' );

	if ( is_string( $selected_services ) ) {
		$selected_services = array_filter( array_map( 'trim', explode( ',', $selected_services ) ) );
	}
	$services_string = ! empty( $selected_services ) ? implode( ', ', $selected_services ) : 'General Event Production';

	// 1. Admin & CC Recipients
	$raw_recipients = $settings['admin_email'];
	if ( ! empty( $settings['cc_emails'] ) ) {
		$raw_recipients .= ',' . $settings['cc_emails'];
	}
	$admin_recipients = array_filter( array_map( 'trim', explode( ',', $raw_recipients ) ) );

	$admin_subj = str_replace(
		array( '{client_name}', '{services}', '{site_name}' ),
		array( $client_name, $services_string, $site_name ),
		$settings['admin_subject_template']
	);

	$admin_html = function_exists( 'cr8v_generate_intake_html_email' )
		? cr8v_generate_intake_html_email( $client_name, $client_email, $client_phone, $selected_services, $scope, true )
		: nl2br( esc_html( $scope ) );

	$clean_from_name   = str_replace( array( '"', '<', '>', "\r", "\n" ), '', $settings['from_name'] );
	$from_header       = "From: {$clean_from_name} <{$settings['from_email']}>";
	$clean_client_name = str_replace( array( '"', '<', '>', "\r", "\n" ), '', $client_name );
	
	$admin_headers = array(
		'Content-Type: text/html; charset=UTF-8',
		$from_header,
	);
	if ( is_email( $client_email ) ) {
		$admin_headers[] = "Reply-To: {$clean_client_name} <{$client_email}>";
	}

	$admin_sent = false;
	if ( ! empty( $admin_recipients ) ) {
		$admin_sent = @wp_mail( $admin_recipients, $admin_subj, $admin_html, $admin_headers );
	}

	// 2. Client Confirmation Receipt
	$client_sent = false;
	if ( '1' === (string) $settings['enable_client_receipt'] && is_email( $client_email ) ) {
		$client_subj = str_replace(
			array( '{client_name}', '{services}', '{site_name}' ),
			array( $client_name, $services_string, $site_name ),
			$settings['client_subject_template']
		);

		$client_html = function_exists( 'cr8v_generate_intake_html_email' )
			? cr8v_generate_intake_html_email( $client_name, $client_email, $client_phone, $selected_services, $scope, false )
			: nl2br( esc_html( $scope ) );

		$client_headers = array(
			'Content-Type: text/html; charset=UTF-8',
			$from_header,
		);

		$client_sent = @wp_mail( $client_email, $client_subj, $client_html, $client_headers );
	}

	return array(
		'admin_sent'  => $admin_sent,
		'client_sent' => $client_sent,
	);
}

/**
 * 13. Helper: Save New Inquiry Programmatically
 */
function cr8v_save_project_inquiry( $name, $email, $phone, $services, $scope ) {
	$ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

	$post_id = wp_insert_post( array(
		'post_title'   => sanitize_text_field( $name ),
		'post_type'    => 'cr8v_inquiry',
		'post_status'  => 'publish',
		'post_content' => sanitize_textarea_field( $scope ),
	) );

	if ( $post_id && ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, '_cr8v_inquiry_email', sanitize_email( $email ) );
		update_post_meta( $post_id, '_cr8v_inquiry_phone', sanitize_text_field( $phone ) );
		update_post_meta( $post_id, '_cr8v_inquiry_discipline', sanitize_text_field( $services ) );
		update_post_meta( $post_id, '_cr8v_inquiry_services', sanitize_text_field( $services ) );
		update_post_meta( $post_id, '_cr8v_inquiry_scope', sanitize_textarea_field( $scope ) );
		update_post_meta( $post_id, '_cr8v_inquiry_ip', sanitize_text_field( $ip ) );
		update_post_meta( $post_id, '_cr8v_inquiry_status', 'New' );
		return $post_id;
	}

	return false;
}


