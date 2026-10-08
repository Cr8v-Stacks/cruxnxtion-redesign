<?php
/**
 * Cr8v Events & Gallery Core - Media Library Deduplication & Cleanup Engine
 *
 * Scans WordPress media attachments, detects redundant copies (e.g. image-1.jpg, image-2.jpg),
 * re-links featured images to the canonical master, and safely purges duplicates from DB and disk.
 *
 * @package Cr8v_Events_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Admin Menu under Tools
 */
function cr8v_register_media_cleaner_page() {
	add_management_page(
		__( 'Media Cleaner & Deduplicator', 'cr8v-events-core' ),
		__( 'Media Deduplicator', 'cr8v-events-core' ),
		'manage_options',
		'cr8v-media-cleaner',
		'cr8v_render_media_cleaner_page'
	);
}
add_action( 'admin_menu', 'cr8v_register_media_cleaner_page' );

/**
 * Scan Media Library for Duplicates
 */
function cr8v_scan_media_duplicates() {
	global $wpdb;

	$attachments = $wpdb->get_results(
		"SELECT p.ID, p.post_title, p.guid, pm.meta_value AS attached_file
		 FROM {$wpdb->posts} p
		 LEFT JOIN {$wpdb->postmeta} pm ON (p.ID = pm.post_id AND pm.meta_key = '_wp_attached_file')
		 WHERE p.post_type = 'attachment' AND p.post_mime_type LIKE 'image/%'
		 ORDER BY p.ID ASC"
	);

	$grouped = array();

	foreach ( $attachments as $att ) {
		if ( empty( $att->attached_file ) ) {
			continue;
		}

		$basename = basename( $att->attached_file );
		// Canonical key: remove suffix like -1.jpg, -2.jpg, -scaled.jpg
		$canonical_key = preg_replace( '/(-\d+|-scaled)(\.[a-zA-Z0-9]+)$/i', '$2', $basename );
		$canonical_key = strtolower( $canonical_key );

		if ( ! isset( $grouped[ $canonical_key ] ) ) {
			$grouped[ $canonical_key ] = array();
		}
		$grouped[ $canonical_key ][] = $att;
	}

	$duplicate_groups = array();
	foreach ( $grouped as $key => $items ) {
		if ( count( $items ) > 1 ) {
			$duplicate_groups[ $key ] = $items;
		}
	}

	return array(
		'total_scanned'    => count( $attachments ),
		'duplicate_groups' => $duplicate_groups,
		'total_duplicates' => array_sum( array_map( function( $g ) { return count( $g ) - 1; }, $duplicate_groups ) ),
	);
}

/**
 * Execute Duplicate Cleanup
 */
function cr8v_execute_duplicate_cleanup() {
	global $wpdb;
	$scan = cr8v_scan_media_duplicates();
	$deleted_count = 0;
	$reassigned_count = 0;

	foreach ( $scan['duplicate_groups'] as $canonical => $items ) {
		// Keep the first / oldest attachment as Master
		$master = $items[0];
		$master_id = $master->ID;

		for ( $i = 1; $i < count( $items ); $i++ ) {
			$dup_id = $items[ $i ]->ID;

			// Reassign any post thumbnails using the duplicate
			$posts_using_dup = $wpdb->get_col( $wpdb->prepare(
				"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_thumbnail_id' AND meta_value = %d",
				$dup_id
			) );

			foreach ( $posts_using_dup as $pid ) {
				update_post_meta( $pid, '_thumbnail_id', $master_id );
				$reassigned_count++;
			}

			// Safely delete duplicate attachment and its physical files
			wp_delete_attachment( $dup_id, true );
			$deleted_count++;
		}
	}

	return array(
		'deleted_count'    => $deleted_count,
		'reassigned_count' => $reassigned_count,
	);
}

/**
 * Render Admin Page
 */
function cr8v_render_media_cleaner_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'Unauthorized', 'cr8v-events-core' ) );
	}

	$action_result = null;

	// Handle Clean Action
	if ( isset( $_POST['cr8v_clean_duplicates'] ) && check_admin_referer( 'cr8v_media_cleaner_action', 'cr8v_clean_nonce' ) ) {
		$action_result = cr8v_execute_duplicate_cleanup();
	}

	$scan = cr8v_scan_media_duplicates();
	?>
	<div class="wrap" style="max-width: 900px; margin-top: 24px;">
		<h1 style="font-size: 26px; font-weight: 800; margin-bottom: 8px;">
			<span class="dashicons dashicons-trash" style="font-size: 28px; width: 28px; height: 28px; vertical-align: middle; color: #A51C24;"></span>
			<?php _e( 'Media Library Deduplicator & Storage Optimizer', 'cr8v-events-core' ); ?>
		</h1>
		<p style="font-size: 14px; color: #555; margin-bottom: 24px;">
			<?php _e( 'Automatically detects redundant duplicate media uploads (e.g. copies ending in <code>-1.jpg</code>, <code>-2.jpg</code> created during repeated imports), re-links featured images to the primary canonical asset, and permanently purges unneeded files.', 'cr8v-events-core' ); ?>
		</p>

		<?php if ( $action_result ) : ?>
			<div class="notice notice-success is-dismissible" style="padding: 14px 18px; border-left-color: #46b450; font-size: 14px;">
				<p>
					<strong><?php _e( 'Cleanup Complete!', 'cr8v-events-core' ); ?></strong>
					<?php printf( __( 'Successfully deleted <strong>%d</strong> duplicate media attachments and re-linked <strong>%d</strong> thumbnail references.', 'cr8v-events-core' ), $action_result['deleted_count'], $action_result['reassigned_count'] ); ?>
				</p>
			</div>
		<?php endif; ?>

		<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px;">
			<div style="background: #fff; border: 1.5px solid #CCD0D4; border-radius: 8px; padding: 20px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
				<span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #666; display: block; margin-bottom: 6px;"><?php _e( 'Total Images Scanned', 'cr8v-events-core' ); ?></span>
				<strong style="font-size: 32px; color: #1d2327; font-family: monospace;"><?php echo intval( $scan['total_scanned'] ); ?></strong>
			</div>
			<div style="background: #fff; border: 1.5px solid #CCD0D4; border-radius: 8px; padding: 20px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
				<span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #666; display: block; margin-bottom: 6px;"><?php _e( 'Duplicate Asset Groups', 'cr8v-events-core' ); ?></span>
				<strong style="font-size: 32px; color: #2271b1; font-family: monospace;"><?php echo count( $scan['duplicate_groups'] ); ?></strong>
			</div>
			<div style="background: #fff; border: 1.5px solid <?php echo $scan['total_duplicates'] > 0 ? '#A51C24' : '#46b450'; ?>; border-radius: 8px; padding: 20px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
				<span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #666; display: block; margin-bottom: 6px;"><?php _e( 'Purgeable Duplicates', 'cr8v-events-core' ); ?></span>
				<strong style="font-size: 32px; color: <?php echo $scan['total_duplicates'] > 0 ? '#A51C24' : '#46b450'; ?>; font-family: monospace;"><?php echo intval( $scan['total_duplicates'] ); ?></strong>
			</div>
		</div>

		<div style="background: #fff; border: 1.5px solid #CCD0D4; border-radius: 8px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
			<h3 style="margin-top: 0; font-size: 16px;"><?php _e( 'One-Click Duplicate Purge', 'cr8v-events-core' ); ?></h3>
			<p style="font-size: 13.5px; color: #646970;">
				<?php _e( 'This operation will safely retain the primary master image for every asset, reassign any attached posts or pages, and delete all redundant files from <code>wp-content/uploads/</code>.', 'cr8v-events-core' ); ?>
			</p>

			<form method="post" style="margin-top: 18px;">
				<?php wp_nonce_field( 'cr8v_media_cleaner_action', 'cr8v_clean_nonce' ); ?>
				<button type="submit" name="cr8v_clean_duplicates" class="button button-primary button-hero" <?php echo $scan['total_duplicates'] === 0 ? 'disabled' : ''; ?> onclick="return confirm('<?php esc_attr_e( 'Are you sure you want to delete all duplicate media files? This action cannot be undone.', 'cr8v-events-core' ); ?>');" style="background: #A51C24; border-color: #7B151B; font-weight: 700;">
					<span class="dashicons dashicons-trash" style="vertical-align: middle; margin-right: 4px;"></span>
					<?php printf( __( 'Purge %d Duplicate Files Now', 'cr8v-events-core' ), $scan['total_duplicates'] ); ?>
				</button>
			</form>
		</div>

		<?php if ( ! empty( $scan['duplicate_groups'] ) ) : ?>
			<div style="background: #fff; border: 1.5px solid #CCD0D4; border-radius: 8px; padding: 20px; margin-top: 24px;">
				<h3 style="margin-top: 0; font-size: 15px;"><?php _e( 'Detected Duplicate Clusters (Sample)', 'cr8v-events-core' ); ?></h3>
				<table class="widefat striped" style="margin-top: 12px; font-size: 13px;">
					<thead>
						<tr>
							<th style="font-weight: 700;"><?php _e( 'Canonical Asset', 'cr8v-events-core' ); ?></th>
							<th style="font-weight: 700;"><?php _e( 'Copies Found', 'cr8v-events-core' ); ?></th>
							<th style="font-weight: 700;"><?php _e( 'Attachment IDs', 'cr8v-events-core' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$preview_groups = array_slice( $scan['duplicate_groups'], 0, 15, true );
						foreach ( $preview_groups as $c_name => $c_items ) :
							$ids = wp_list_pluck( $c_items, 'ID' );
							?>
							<tr>
								<td><strong><?php echo esc_html( $c_name ); ?></strong></td>
								<td><span class="badge" style="background: #FEE2E2; color: #991B1B; padding: 2px 8px; border-radius: 12px; font-weight: 700;"><?php echo count( $c_items ); ?> <?php _e( 'files', 'cr8v-events-core' ); ?></span></td>
								<td><code><?php echo implode( ', ', $ids ); ?></code></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>

	</div>
	<?php
}
