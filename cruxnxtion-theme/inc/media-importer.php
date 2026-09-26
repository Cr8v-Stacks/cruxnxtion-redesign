<?php
/**
 * Crux Nxtion - Media Library Importer & Sync Engine
 * Imports theme images, event flyers, logos, and favicons into the WordPress Media Library
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Automatic Seeder on Theme Switch
 */
function crux_maybe_auto_import_media() {
	if ( ! get_option( 'crux_media_imported_v1' ) ) {
		crux_sync_all_media_to_library( false );
	}
}
add_action( 'after_switch_theme', 'crux_maybe_auto_import_media' );

/**
 * 2. Admin Notice & 1-Click Trigger
 */
function crux_register_media_sync_admin_menu() {
	add_theme_page(
		__( 'Crux Media Library Sync', 'cruxnxtion' ),
		__( 'Sync Media Library', 'cruxnxtion' ),
		'manage_options',
		'crux-media-sync',
		'crux_render_media_sync_admin_page'
	);
}
add_action( 'admin_menu', 'crux_register_media_sync_admin_menu' );

function crux_render_media_sync_admin_page() {
	if ( isset( $_POST['crux_run_sync'] ) && check_admin_referer( 'crux_sync_media_action', 'crux_sync_nonce' ) ) {
		$count = crux_sync_all_media_to_library( true );
		echo '<div class="notice notice-success is-dismissible"><p>' . sprintf( esc_html__( 'Successfully synced %d images to the WordPress Media Library.', 'cruxnxtion' ), $count ) . '</p></div>';
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Crux Nxtion Media Library Sync', 'cruxnxtion' ); ?></h1>
		<p><?php esc_html_e( 'Click the button below to register all Crux Nxtion logos, favicons, event flyers, and photo assets into the WordPress Media Library so you can search, view, and replace them natively in WP Admin > Media.', 'cruxnxtion' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( 'crux_sync_media_action', 'crux_sync_nonce' ); ?>
			<p><input type="submit" name="crux_run_sync" class="button button-primary" value="<?php esc_attr_e( 'Sync All Images to Media Library Now', 'cruxnxtion' ); ?>"></p>
		</form>
	</div>
	<?php
}

/**
 * 3. Core Engine: Syncs disk assets to WP Attachment posts in wp_posts
 */
function crux_sync_all_media_to_library( $force = false ) {
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );

	$theme_dir = get_template_directory();
	$images_root = $theme_dir . '/assets/images';

	if ( ! is_dir( $images_root ) ) {
		return 0;
	}

	$blob_map = get_option( 'crux_media_blob_map', array() );
	if ( ! is_array( $blob_map ) ) {
		$blob_map = array();
	}

	$imported_count = 0;
	$wp_upload_dir = wp_upload_dir();

	// Target folders to scan
	$folders = array(
		$images_root . '/by-blob-id',
		$images_root,
	);

	// Known primary logo blob ID
	$logo_blob_id = 'e4d72651b77d4c3cc1c086d9f6031149';

	foreach ( $folders as $folder ) {
		if ( ! is_dir( $folder ) ) {
			continue;
		}

		$files = scandir( $folder );
		foreach ( $files as $file ) {
			if ( $file === '.' || $file === '..' ) {
				continue;
			}

			$ext = strtolower( pathinfo( $file, PATHINFO_EXTENSION ) );
			if ( ! in_array( $ext, array( 'jpg', 'jpeg', 'png', 'webp', 'gif', 'svg', 'ico' ), true ) ) {
				continue;
			}

			$file_path = $folder . '/' . $file;
			$blob_id = pathinfo( $file, PATHINFO_FILENAME );

			// Check if already mapped
			if ( ! $force && isset( $blob_map[ $blob_id ] ) && get_post( $blob_map[ $blob_id ] ) ) {
				continue;
			}

			// Copy file into WordPress uploads directory
			$file_content = file_get_contents( $file_path );
			if ( false === $file_content ) {
				continue;
			}

			$filename = wp_unique_filename( $wp_upload_dir['path'], $file );
			$new_file = $wp_upload_dir['path'] . '/' . $filename;
			file_put_contents( $new_file, $file_content );

			$wp_filetype = wp_check_filetype( $filename, null );
			$attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_title'     => sanitize_text_field( preg_replace( '/\.[^.]+$/', '', $filename ) ),
				'post_content'   => '',
				'post_status'    => 'inherit',
			);

			$attach_id = wp_insert_attachment( $attachment, $new_file );
			if ( ! is_wp_error( $attach_id ) && $attach_id ) {
				$attach_data = wp_generate_attachment_metadata( $attach_id, $new_file );
				wp_update_attachment_metadata( $attach_id, $attach_data );

				$blob_map[ $blob_id ] = $attach_id;
				$imported_count++;

				// If this is the primary logo, set custom_logo theme mod
				if ( $blob_id === $logo_blob_id ) {
					set_theme_mod( 'custom_logo', $attach_id );
					update_option( 'site_icon', $attach_id );
				}
			}
		}
	}

	update_option( 'crux_media_blob_map', $blob_map );
	update_option( 'crux_media_imported_v1', 1 );

	return $imported_count;
}

/**
 * 4. Helper to get URL (checks media library first, falls back to theme assets)
 */
function crux_get_blob_url( $blob_id ) {
	$blob_id = strtolower( trim( $blob_id ) );
	$blob_map = get_option( 'crux_media_blob_map', array() );

	if ( isset( $blob_map[ $blob_id ] ) ) {
		$url = wp_get_attachment_url( $blob_map[ $blob_id ] );
		if ( $url ) {
			return $url;
		}
	}

	return get_template_directory_uri() . '/assets/images/by-blob-id/' . $blob_id . '.jpg';
}
