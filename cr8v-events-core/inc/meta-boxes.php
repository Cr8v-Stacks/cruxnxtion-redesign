<?php
/**
 * Bespoke Visual Studio & Logistics Meta Boxes for Events and Gallery
 *
 * @package Cr8v_Events_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Enqueue WordPress Media Scripts & Admin Styles
 */
if ( ! function_exists( 'cr8v_enqueue_meta_box_media_scripts' ) ) {
	function cr8v_enqueue_meta_box_media_scripts( $hook ) {
		global $post_type;
		if ( ( $hook === 'post.php' || $hook === 'post-new.php' ) && ( $post_type === 'gallery_item' || $post_type === 'event' ) ) {
			wp_enqueue_media();
		}
	}
	add_action( 'admin_enqueue_scripts', 'cr8v_enqueue_meta_box_media_scripts' );
}

/**
 * 2. Register Dedicated Studio Meta Boxes
 */
if ( ! function_exists( 'cr8v_add_custom_meta_boxes' ) ) {
	function cr8v_add_custom_meta_boxes() {
		// Event Logistics Studio Meta Box
		add_meta_box(
			'cr8v_event_studio_box',
			__( 'Event Staging, Schedule & Technical Studio', 'cr8v-events-core' ),
			'cr8v_render_event_studio_meta_box',
			'event',
			'normal',
			'high'
		);

		// Gallery Print Studio Meta Box
		add_meta_box(
			'cr8v_gallery_studio_box',
			__( 'Gallery Print Studio & Visual Settings', 'cr8v-events-core' ),
			'cr8v_render_gallery_studio_meta_box',
			'gallery_item',
			'normal',
			'high'
		);
	}
	add_action( 'add_meta_boxes', 'cr8v_add_custom_meta_boxes' );
}

/**
 * 3. Render Bespoke Event Logistics & Staging Studio Meta Box
 */
if ( ! function_exists( 'cr8v_render_event_studio_meta_box' ) ) {
	function cr8v_render_event_studio_meta_box( $post ) {
		wp_nonce_field( 'cr8v_save_event_meta', 'cr8v_event_meta_nonce' );

		$event_date      = get_post_meta( $post->ID, '_cr8v_event_date', true );
		$event_time      = get_post_meta( $post->ID, '_cr8v_event_time', true );
		$event_venue     = get_post_meta( $post->ID, '_cr8v_event_venue', true );
		$event_kicker    = get_post_meta( $post->ID, '_cr8v_event_kicker', true );
		$event_capacity  = get_post_meta( $post->ID, '_cr8v_event_capacity', true );
		$event_lead_prod = get_post_meta( $post->ID, '_cr8v_event_lead_prod', true );
		$event_excerpt   = get_post_meta( $post->ID, '_cr8v_event_excerpt', true );
		$event_scope     = get_post_meta( $post->ID, '_cr8v_event_scope', true );
		$specs_raw       = get_post_meta( $post->ID, '_cr8v_event_specs', true );
		$spec_audio      = get_post_meta( $post->ID, '_cr8v_spec_audio', true );
		$spec_lighting   = get_post_meta( $post->ID, '_cr8v_spec_lighting', true );
		$spec_staging    = get_post_meta( $post->ID, '_cr8v_spec_staging', true );
		$spec_crew       = get_post_meta( $post->ID, '_cr8v_spec_crew', true );
		$event_cta_txt   = get_post_meta( $post->ID, '_cr8v_event_cta_txt', true );
		$event_cta_url   = get_post_meta( $post->ID, '_cr8v_event_cta_url', true );
		$event_gallery_ids = get_post_meta( $post->ID, '_cr8v_event_gallery_ids', true );

		$thumb_id  = get_post_thumbnail_id( $post->ID );
		$image_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'large' ) : '';
		if ( empty( $image_url ) ) {
			$image_url = get_post_meta( $post->ID, '_cr8v_event_image_url', true );
		}

		// Backward-compatibility fallbacks for existing posts
		if ( empty( $event_excerpt ) && ! empty( $post->post_excerpt ) ) {
			$event_excerpt = $post->post_excerpt;
		}
		if ( empty( $event_scope ) && ! empty( $post->post_content ) ) {
			$event_scope = $post->post_content;
		}

		// Parse legacy structured specs array if individual spec fields are empty
		if ( is_array( $specs_raw ) ) {
			foreach ( $specs_raw as $s ) {
				if ( is_array( $s ) && isset( $s['label'] ) && isset( $s['val'] ) ) {
					$lbl = strtolower( $s['label'] );
					if ( empty( $spec_audio ) && ( strpos( $lbl, 'audio' ) !== false || strpos( $lbl, 'sound' ) !== false || strpos( $lbl, 'acoustic' ) !== false ) ) {
						$spec_audio = $s['val'];
					}
					if ( empty( $spec_lighting ) && ( strpos( $lbl, 'light' ) !== false || strpos( $lbl, 'laser' ) !== false || strpos( $lbl, 'project' ) !== false ) ) {
						$spec_lighting = $s['val'];
					}
					if ( empty( $spec_staging ) && ( strpos( $lbl, 'truss' ) !== false || strpos( $lbl, 'rig' ) !== false || strpos( $lbl, 'stage' ) !== false || strpos( $lbl, 'deck' ) !== false ) ) {
						$spec_staging = $s['val'];
					}
					if ( empty( $spec_crew ) && ( strpos( $lbl, 'power' ) !== false || strpos( $lbl, 'crew' ) !== false || strpos( $lbl, 'dispatch' ) !== false || strpos( $lbl, 'grid' ) !== false || strpos( $lbl, 'ops' ) !== false ) ) {
						$spec_crew = $s['val'];
					}
				}
			}
		}

		// Calendar Status
		$is_past = false;
		if ( ! empty( $event_date ) ) {
			$is_past = ( strtotime( $event_date . ' 23:59:59' ) < current_time( 'timestamp' ) );
		}

		?>
		<style>
			.bwc-studio-section { margin-bottom: 22px; padding-bottom: 18px; border-bottom: 1.5px solid #E5E5E5; }
			.bwc-studio-section:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }
			.bwc-studio-heading { font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #000; margin: 0 0 12px; display: flex; align-items: center; gap: 6px; }
			.bwc-studio-heading .dashicons { font-size: 18px; color: #C85C38; }
			.bwc-meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
			@media (max-width: 782px) { .bwc-meta-grid { grid-template-columns: 1fr; } }
			.bwc-field-label { display: block; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.04em; color: #333; margin-bottom: 5px; }
			.bwc-field-input { width: 100%; border: 1.5px solid #000 !important; border-radius: 4px !important; padding: 8px 10px !important; font-size: 13px !important; }
			.bwc-field-input:focus { border-color: #C85C38 !important; box-shadow: 0 0 0 1px #C85C38 !important; }
			.bwc-status-pill { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 4px; font-family: monospace; font-size: 11px; font-weight: 700; }
			.bwc-status-active { background: #EBF7EE; color: #1E6B37; border: 1.5px solid #1E6B37; }
			.bwc-status-concluded { background: #F0F0F0; color: #666666; border: 1.5px solid #CCCCCC; }
		</style>

		<!-- 1. Visual Staging Poster / Artwork -->
		<div class="bwc-studio-section">
			<div class="bwc-studio-heading">
				<span class="dashicons dashicons-format-image"></span> 1. Visual Staging Poster Artwork
			</div>
			
			<input type="hidden" id="cr8v_event_image_id" name="cr8v_event_image_id" value="<?php echo esc_attr( $thumb_id ); ?>">
			<input type="hidden" id="cr8v_event_image_url" name="cr8v_event_image_url" value="<?php echo esc_attr( $image_url ); ?>">

			<div id="bwc_event_preview_container" style="<?php echo empty( $image_url ) ? 'display:none;' : ''; ?>">
				<div style="max-width: 480px; margin: 0 auto 14px; border: 2px solid #000; box-shadow: 5px 5px 0px #000; border-radius: 6px; overflow: hidden; background: #FFF;">
					<img id="bwc_event_preview_img" src="<?php echo esc_url( $image_url ); ?>" alt="Event Poster Preview" style="width:100%; height:auto; max-height:260px; object-fit:cover; display:block;">
				</div>
				<div style="display:flex; justify-content:center; gap:10px;">
					<button type="button" id="bwc_event_upload_btn" class="button button-secondary" style="border:1.5px solid #000; font-weight:700;">
						<span class="dashicons dashicons-update" style="vertical-align:middle;"></span> Replace Poster Artwork
					</button>
					<button type="button" id="bwc_event_remove_btn" class="button" style="color:#B4282D; border:1.5px solid #B4282D; font-weight:700;">
						<span class="dashicons dashicons-trash" style="vertical-align:middle;"></span> Remove Poster
					</button>
				</div>
			</div>

			<div id="bwc_event_empty_upload" style="border: 2px dashed #000; background: #FAF8F5; border-radius: 6px; padding: 24px; text-align: center; <?php echo ! empty( $image_url ) ? 'display:none;' : ''; ?>">
				<div style="margin-bottom: 8px;">
					<span class="dashicons dashicons-calendar-alt" style="font-size: 36px; width: 36px; height: 36px; color: #C85C38;"></span>
				</div>
				<h4 style="margin: 0 0 4px; font-size: 14px; font-weight: 700; text-transform: uppercase;">Select Event Poster Artwork</h4>
				<p style="font-size: 12px; color: #666; margin: 0 0 14px;">Upload hero artwork or stagecraft photography for this production showcase.</p>
				<button type="button" id="bwc_event_empty_btn" class="button button-primary" style="background:#000; border-color:#000; border-radius:50px; padding:6px 20px; font-weight:700; text-transform:uppercase;">
					<span class="dashicons dashicons-upload" style="vertical-align:middle;"></span> Choose Event Poster
				</button>
			</div>
		</div>

		<!-- 2. Date, Timing & Automated Status -->
		<div class="bwc-studio-section">
			<div class="bwc-studio-heading">
				<span class="dashicons dashicons-calendar-alt"></span> 2. Date, Timing &amp; Calendar Synchronization
			</div>
			
			<div class="bwc-meta-grid">
				<div>
					<label class="bwc-field-label" for="cr8v_event_date"><?php _e( 'Event Staging Date or Year *', 'cr8v-events-core' ); ?></label>
					<?php $date_is_exact = ( '' === (string) $event_date ) || null !== cr8v_event_iso_date( $event_date ); /* A loose value already saved (for example a bare year) keeps the text box, so saving an existing event never changes its date. */ ?>
						<input type="<?php echo $date_is_exact ? 'date' : 'text'; ?>" id="cr8v_event_date" name="cr8v_event_date" value="<?php echo esc_attr( $event_date ); ?>" placeholder="e.g. 2026 or 2024-02-24" class="bwc-field-input" required>
					<p style="font-size:11px; color:#666; margin:4px 0 0;"><?php echo $date_is_exact ? 'Pick the exact date. Ticket sales, calendar files and the Past/Upcoming status all use it.' : 'This event has a loose date. Keep it as it is, or type an exact date such as <strong>2024-02-24</strong> to enable ticket sales and calendar files.'; ?></p>
				</div>
				<div>
					<label class="bwc-field-label" for="cr8v_event_time"><?php _e( 'Event Operating Hours', 'cr8v-events-core' ); ?></label>
					<input type="text" id="cr8v_event_time" name="cr8v_event_time" value="<?php echo esc_attr( $event_time ); ?>" placeholder="e.g. 18:00 – 23:30 BST" class="bwc-field-input">
					<div style="margin-top: 8px;">
						<?php if ( ! empty( $event_date ) ) : ?>
							<?php if ( $is_past ) : ?>
								<span class="bwc-status-pill bwc-status-concluded"><span class="dashicons dashicons-yes-alt" style="font-size:14px;width:14px;height:14px;color:#666;"></span> CALENDAR STATUS: CONCLUDED</span>
							<?php else : ?>
								<span class="bwc-status-pill bwc-status-active"><span class="dashicons dashicons-update" style="font-size:14px;width:14px;height:14px;color:#1E6B37;"></span> CALENDAR STATUS: ACTIVE / LIVE (ICS SYNC ENABLED)</span>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<!-- 3. Staging Venue & Capacity Logistics -->
		<div class="bwc-studio-section">
			<div class="bwc-studio-heading">
				<span class="dashicons dashicons-location"></span> 3. Staging Venue, Capacity &amp; Event Category Tag
			</div>
			
			<div class="bwc-meta-grid" style="margin-bottom: 14px;">
				<div>
					<label class="bwc-field-label" for="cr8v_event_venue"><?php _e( 'Staging Venue & Street Address *', 'cr8v-events-core' ); ?></label>
					<input type="text" id="cr8v_event_venue" name="cr8v_event_venue" value="<?php echo esc_attr( $event_venue ); ?>" placeholder="e.g. Somerset House, Strand, London WC2R 1LA" class="bwc-field-input" required>
				</div>
				<div>
					<label class="bwc-field-label" for="cr8v_event_kicker"><?php _e( 'Event Category / Header Tag', 'cr8v-events-core' ); ?></label>
					<input type="text" id="cr8v_event_kicker" name="cr8v_event_kicker" value="<?php echo esc_attr( $event_kicker ); ?>" placeholder="e.g. Live Concert // Stage Production" class="bwc-field-input">
				</div>
			</div>

			<div class="bwc-meta-grid">
				<div>
					<label class="bwc-field-label" for="cr8v_event_capacity"><?php _e( 'Capacity & Audience Format', 'cr8v-events-core' ); ?></label>
					<input type="text" id="cr8v_event_capacity" name="cr8v_event_capacity" value="<?php echo esc_attr( $event_capacity ); ?>" placeholder="e.g. 1,200 Attendees // Live Electronic Arena" class="bwc-field-input">
				</div>
				<div>
					<label class="bwc-field-label" for="cr8v_event_lead_prod"><?php _e( 'Lead Production Direction', 'cr8v-events-core' ); ?></label>
					<input type="text" id="cr8v_event_lead_prod" name="cr8v_event_lead_prod" value="<?php echo esc_attr( $event_lead_prod ); ?>" placeholder="e.g. Technical Staging & Acoustic Direction" class="bwc-field-input">
				</div>
			</div>
		</div>

		<!-- 4. Production Narrative & Scope -->
		<div class="bwc-studio-section">
			<div class="bwc-studio-heading">
				<span class="dashicons dashicons-editor-alignleft"></span> 4. Production Scope &amp; Architecture Narrative
			</div>

			<div style="margin-bottom: 14px;">
				<label class="bwc-field-label" for="cr8v_event_excerpt"><?php _e( 'Short Docket Summary (Excerpt)', 'cr8v-events-core' ); ?></label>
				<textarea id="cr8v_event_excerpt" name="cr8v_event_excerpt" rows="2" class="bwc-field-input" placeholder="A bespoke multi-tiered LED monolith stage installation featuring headline electronic acts..."><?php echo esc_textarea( $event_excerpt ); ?></textarea>
				<p style="font-size:11px; color:#666; margin:4px 0 0;">Rendered on the Homepage and Events Archive docket cards.</p>
			</div>

			<div>
				<label class="bwc-field-label" for="cr8v_event_scope"><?php _e( 'Full Production Architecture & Technical Scope Narrative', 'cr8v-events-core' ); ?></label>
				<textarea id="cr8v_event_scope" name="cr8v_event_scope" rows="5" class="bwc-field-input" placeholder="Staged in the neoclassical courtyard of Somerset House, The Obsidian Pavilion transforms historic architecture into an immersive acoustic environment..."><?php echo esc_textarea( $event_scope ); ?></textarea>
				<p style="font-size:11px; color:#666; margin:4px 0 0;">Rendered on the single event page under the "Production Architecture & Technical Scope" heading.</p>
			</div>
		</div>

		<!-- 5. Structured Technical Staging Breakdown -->
		<div class="bwc-studio-section">
			<div class="bwc-studio-heading">
				<span class="dashicons dashicons-admin-tools"></span> 5. Structured Technical Staging Breakdown (4 Core Pillars)
			</div>
			
			<div class="bwc-meta-grid" style="margin-bottom: 14px;">
				<div>
					<label class="bwc-field-label" for="cr8v_spec_audio"><?php _e( 'Audio Engineering Spec', 'cr8v-events-core' ); ?></label>
					<input type="text" id="cr8v_spec_audio" name="cr8v_spec_audio" value="<?php echo esc_attr( $spec_audio ); ?>" placeholder="e.g. 360-degree d&b audiotechnik Soundscape spatial array" class="bwc-field-input">
				</div>
				<div>
					<label class="bwc-field-label" for="cr8v_spec_lighting"><?php _e( 'Lighting Rig & Lasers Spec', 'cr8v-events-core' ); ?></label>
					<input type="text" id="cr8v_spec_lighting" name="cr8v_spec_lighting" value="<?php echo esc_attr( $spec_lighting ); ?>" placeholder="e.g. 48x Robe MegaPointe moving heads + amber laser array" class="bwc-field-input">
				</div>
			</div>

			<div class="bwc-meta-grid">
				<div>
					<label class="bwc-field-label" for="cr8v_spec_staging"><?php _e( 'Stage Decking & Rigging Spec', 'cr8v-events-core' ); ?></label>
					<input type="text" id="cr8v_spec_staging" name="cr8v_spec_staging" value="<?php echo esc_attr( $spec_staging ); ?>" placeholder="e.g. Bespoke modular steel decking with anti-vibration isolation" class="bwc-field-input">
				</div>
				<div>
					<label class="bwc-field-label" for="cr8v_spec_crew"><?php _e( 'Operations & Crew Size Spec', 'cr8v-events-core' ); ?></label>
					<input type="text" id="cr8v_spec_crew" name="cr8v_spec_crew" value="<?php echo esc_attr( $spec_crew ); ?>" placeholder="e.g. 24-person on-site stage ops, security liaison, and VIP hospitality" class="bwc-field-input">
				</div>
			</div>
		</div>

		<!-- 6. Call to Action & Commission Settings -->
		<div class="bwc-studio-section">
			<div class="bwc-studio-heading">
				<span class="dashicons dashicons-external"></span> 6. Call to Action &amp; Commission Link
			</div>
			
			<div class="bwc-meta-grid">
				<div>
					<label class="bwc-field-label" for="cr8v_event_cta_txt"><?php _e( 'CTA Button Label', 'cr8v-events-core' ); ?></label>
					<input type="text" id="cr8v_event_cta_txt" name="cr8v_event_cta_txt" value="<?php echo esc_attr( $event_cta_txt ); ?>" placeholder="e.g. Commission Similar Production" class="bwc-field-input">
				</div>
				<div>
					<label class="bwc-field-label" for="cr8v_event_cta_url"><?php _e( 'CTA Target Link URL', 'cr8v-events-core' ); ?></label>
					<input type="text" id="cr8v_event_cta_url" name="cr8v_event_cta_url" value="<?php echo esc_attr( $event_cta_url ); ?>" placeholder="Leave blank to use default /contact/ page" class="bwc-field-input">
				</div>
			</div>
		</div>

		<!-- 7. Dedicated Event Production Gallery (Optional) -->
		<div class="bwc-studio-section">
			<div class="bwc-studio-heading">
				<span class="dashicons dashicons-images-alt2"></span> 7. Dedicated Event Production Gallery Visuals (Optional)
			</div>
			<p style="font-size:12px; color:#666; margin:0 0 10px;">Select photography specific to this production showcase. If empty, the dossier seamlessly displays the Curatorial Archive &amp; Studio Portfolio Highlights with transparent attribution.</p>
			
			<input type="hidden" id="cr8v_event_gallery_ids" name="cr8v_event_gallery_ids" value="<?php echo esc_attr( $event_gallery_ids ); ?>">
			
			<div id="cr8v_event_gallery_preview" style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:12px;">
				<?php
				if ( ! empty( $event_gallery_ids ) ) {
					$g_ids = array_filter( array_map( 'trim', explode( ',', $event_gallery_ids ) ) );
					foreach ( $g_ids as $gid ) {
						if ( is_numeric( $gid ) ) {
							$src = wp_get_attachment_image_url( intval( $gid ), 'thumbnail' );
						} else {
							$src = esc_url( $gid );
						}
						if ( $src ) {
							echo '<div class="cr8v-gal-item" style="position:relative; width:80px; height:80px; border:1.5px solid #000; border-radius:6px; overflow:hidden;"><img src="' . esc_url( $src ) . '" style="width:100%; height:100%; object-fit:cover;"></div>';
						}
					}
				}
				?>
			</div>
			
			<button type="button" id="cr8v_select_event_gallery_btn" class="button button-secondary" style="border-radius:50px; font-weight:700;">
				<span class="dashicons dashicons-plus-alt" style="vertical-align:middle;"></span> Add Event Gallery Images
			</button>
			<button type="button" id="cr8v_clear_event_gallery_btn" class="button" style="border-radius:50px; color:#c82333; margin-left:6px; <?php echo empty( $event_gallery_ids ) ? 'display:none;' : ''; ?>">
				Clear Gallery
			</button>
		</div>

		<!-- 8. Card Details (Optional) -->
		<?php
		$event_short_title = get_post_meta( $post->ID, '_cr8v_event_short_title', true );
		$event_location    = get_post_meta( $post->ID, '_cr8v_event_location', true );
		$event_badge_style = get_post_meta( $post->ID, '_cr8v_event_badge_style', true );
		?>
		<div class="bwc-studio-section">
			<div class="bwc-studio-heading">
				<span class="dashicons dashicons-tag"></span> 8. Card Details (Optional)
			</div>
			<div class="bwc-meta-grid">
				<div>
					<label class="bwc-field-label" for="cr8v_event_short_title"><?php _e( 'Short Title (Cards)', 'cr8v-events-core' ); ?></label>
					<input type="text" id="cr8v_event_short_title" name="cr8v_event_short_title" value="<?php echo esc_attr( $event_short_title ); ?>" maxlength="80" placeholder="e.g. Dance OUT 2023" class="bwc-field-input">
				</div>
				<div>
					<label class="bwc-field-label" for="cr8v_event_location"><?php _e( 'Country / Region', 'cr8v-events-core' ); ?></label>
					<input type="text" id="cr8v_event_location" name="cr8v_event_location" value="<?php echo esc_attr( $event_location ); ?>" maxlength="80" placeholder="e.g. United Kingdom" class="bwc-field-input">
				</div>
				<div>
					<label class="bwc-field-label" for="cr8v_event_badge_style"><?php _e( 'Ticket Colour', 'cr8v-events-core' ); ?></label>
					<select id="cr8v_event_badge_style" name="cr8v_event_badge_style" class="bwc-field-input">
						<option value=""><?php esc_html_e( 'Default', 'cr8v-events-core' ); ?></option>
						<?php foreach ( cr8v_event_badge_styles() as $value => $label ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $event_badge_style, $value ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
					<p style="font-size:11px; color:#666; margin:4px 0 0;">Used by sites whose event cards are colour coded. Sites that do not use it ignore it.</p>
				</div>
			</div>
		</div>

		<script>
		jQuery(document).ready(function($){
			var eventMediaUploader;
			var eventGalleryUploader;

			function openEventMediaModal() {
				if (eventMediaUploader) {
					eventMediaUploader.open();
					return;
				}
				eventMediaUploader = wp.media({
					title: 'Select Event Poster Artwork',
					button: { text: 'Set as Event Poster' },
					multiple: false
				});
				eventMediaUploader.on('select', function() {
					var attachment = eventMediaUploader.state().get('selection').first().toJSON();
					$('#cr8v_event_image_id').val(attachment.id);
					$('#cr8v_event_image_url').val(attachment.url);
					$('#bwc_event_preview_img').attr('src', attachment.url);
					$('#bwc_event_preview_container').show();
					$('#bwc_event_empty_upload').hide();

					if ($('#_thumbnail_id').length) {
						$('#_thumbnail_id').val(attachment.id);
					}
				});
				eventMediaUploader.open();
			}

			$('#bwc_event_empty_btn, #bwc_event_upload_btn').on('click', function(e){
				e.preventDefault();
				openEventMediaModal();
			});

			$('#bwc_event_remove_btn').on('click', function(e){
				e.preventDefault();
				$('#cr8v_event_image_id').val('');
				$('#cr8v_event_image_url').val('');
				$('#bwc_event_preview_img').attr('src', '');
				$('#bwc_event_preview_container').hide();
				$('#bwc_event_empty_upload').show();
				if ($('#_thumbnail_id').length) {
					$('#_thumbnail_id').val('-1');
				}
			});

			// Multi-Image Event Gallery Picker
			$('#cr8v_select_event_gallery_btn').on('click', function(e){
				e.preventDefault();
				if (eventGalleryUploader) {
					eventGalleryUploader.open();
					return;
				}
				eventGalleryUploader = wp.media({
					title: 'Select Event Gallery Photographs',
					button: { text: 'Add to Event Gallery' },
					multiple: true
				});
				eventGalleryUploader.on('select', function() {
					var selection = eventGalleryUploader.state().get('selection');
					var currentIds = $('#cr8v_event_gallery_ids').val() ? $('#cr8v_event_gallery_ids').val().split(',') : [];
					selection.each(function(attachment){
						var att = attachment.toJSON();
						if (currentIds.indexOf(String(att.id)) === -1) {
							currentIds.push(att.id);
							var thumb = att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url;
							$('#cr8v_event_gallery_preview').append('<div class="cr8v-gal-item" style="position:relative; width:80px; height:80px; border:1.5px solid #000; border-radius:6px; overflow:hidden;"><img src="' + thumb + '" style="width:100%; height:100%; object-fit:cover;"></div>');
						}
					});
					$('#cr8v_event_gallery_ids').val(currentIds.join(','));
					$('#cr8v_clear_event_gallery_btn').show();
				});
				eventGalleryUploader.open();
			});

			$('#cr8v_clear_event_gallery_btn').on('click', function(e){
				e.preventDefault();
				$('#cr8v_event_gallery_ids').val('');
				$('#cr8v_event_gallery_preview').empty();
				$(this).hide();
			});
		});
		</script>
		<?php
	}
}

/**
 * 4. Render Bespoke Visual Gallery Print Studio Meta Box
 */
if ( ! function_exists( 'cr8v_render_gallery_studio_meta_box' ) ) {
	function cr8v_render_gallery_studio_meta_box( $post ) {
		wp_nonce_field( 'cr8v_save_gallery_meta', 'cr8v_gallery_meta_nonce' );

		$gallery_span     = get_post_meta( $post->ID, '_cr8v_gallery_span', true );
		$gallery_location = get_post_meta( $post->ID, '_cr8v_gallery_location', true );
		$gallery_kicker   = get_post_meta( $post->ID, '_cr8v_gallery_kicker', true );
		$gallery_notes    = get_post_meta( $post->ID, '_cr8v_gallery_notes', true );
		$ribbon_color     = get_post_meta( $post->ID, '_cr8v_ribbon_color', true );
		
		$thumb_id  = get_post_thumbnail_id( $post->ID );
		$image_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'large' ) : '';
		if ( empty( $image_url ) ) {
			$image_url = get_post_meta( $post->ID, '_cr8v_gallery_image_url', true );
		}

		// Backward-compatibility fallbacks for legacy posts
		if ( empty( $gallery_span ) ) {
			$legacy_span = get_post_meta( $post->ID, '_cr8v_gallery_grid_span', true );
			$gallery_span = ( $legacy_span === 'span-2' || $legacy_span === 'col-8' ) ? 'col-8' : 'col-6';
		}
		if ( empty( $ribbon_color ) ) {
			$legacy_color = get_post_meta( $post->ID, '_cr8v_gallery_ribbon_color', true );
			$color_map = array(
				'terracotta' => '#C85C38',
				'gold'       => '#C29532',
				'green'      => '#2F6647',
				'forest'     => '#2F6647',
				'crimson'    => '#B4282D',
				'red'        => '#B4282D',
				'cerulean'   => '#1E7898',
				'blue'       => '#1E7898',
				'black'      => '#000000',
				'obsidian'   => '#000000',
			);
			$ribbon_color = ( isset( $color_map[ strtolower( (string) $legacy_color ) ] ) ) ? $color_map[ strtolower( (string) $legacy_color ) ] : '#C85C38';
		}
		if ( empty( $gallery_notes ) && ! empty( $post->post_content ) ) {
			$gallery_notes = $post->post_content;
		}

		$colors = array(
			'#C85C38' => 'Terracotta (#C85C38)',
			'#C29532' => 'Ochre Gold (#C29532)',
			'#2F6647' => 'Forest Green (#2F6647)',
			'#B4282D' => 'Crimson (#B4282D)',
			'#1E7898' => 'Cerulean (#1E7898)',
			'#000000' => 'Obsidian Black (#000000)',
		);

		$is_col6 = in_array( $gallery_span, array( 'col-6', 'col-4', 'col-5', 'normal' ) );
		$is_col8 = in_array( $gallery_span, array( 'col-8', 'col-7', 'span-2' ) );

		?>
		<style>
			.bwc-gallery-section-box { margin-bottom: 22px; padding-bottom: 20px; border-bottom: 1.5px solid #E5E5E5; }
			.bwc-gallery-section-box:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }
			.bwc-studio-heading { font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #000; margin: 0 0 14px; display: flex; align-items: center; gap: 6px; }
			.bwc-studio-heading .dashicons { font-size: 18px; color: #C85C38; }
			.bwc-meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
			@media (max-width: 782px) { .bwc-meta-grid { grid-template-columns: 1fr; } }
			.bwc-field-label { display: block; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.04em; color: #222; margin-bottom: 6px; }
			.bwc-field-input { width: 100%; border: 1.5px solid #000 !important; border-radius: 4px !important; padding: 8px 12px !important; font-size: 13px !important; background: #FFF !important; box-sizing: border-box !important; }
			.bwc-field-input:focus { border-color: #C85C38 !important; box-shadow: 0 0 0 1px #C85C38 !important; outline: none !important; }
			
			.bwc-span-radio { display: block; border: 1.5px solid #CCC; border-radius: 6px; padding: 12px 8px; text-align: center; cursor: pointer; background: #FFF; transition: all 0.15s ease; }
			.bwc-span-radio.is-selected { border: 2px solid #000 !important; background: #FAF8F5 !important; box-shadow: 3px 3px 0px #000 !important; }
			
			.bwc-swatch-badge { display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px; border: 1.5px solid #DDD; border-radius: 30px; cursor: pointer; font-size: 12px; font-weight: 600; background: #FFF; transition: all 0.15s ease; user-select: none; }
			.bwc-swatch-badge.is-selected { border-color: #000 !important; background: #000 !important; color: #FFF !important; box-shadow: 2px 2px 0px #C85C38 !important; }
		</style>

		<!-- 1. Master Photograph Studio -->
		<div class="bwc-gallery-section-box">
			<div class="bwc-studio-heading">
				<span class="dashicons dashicons-format-image"></span> 1. Master Print Photograph
			</div>

			<input type="hidden" id="cr8v_gallery_image_id" name="cr8v_gallery_image_id" value="<?php echo esc_attr( $thumb_id ); ?>">
			<input type="hidden" id="cr8v_gallery_image_url" name="cr8v_gallery_image_url" value="<?php echo esc_attr( $image_url ); ?>">

			<div id="bwc_preview_container" style="<?php echo empty( $image_url ) ? 'display:none;' : ''; ?>">
				<div style="max-width: 480px; margin: 0 auto 14px; border: 2.5px solid #000; box-shadow: 5px 5px 0px #000; border-radius: 6px; overflow: hidden; background: #FFF;">
					<img id="bwc_preview_img" src="<?php echo esc_url( $image_url ); ?>" alt="Print Preview" style="width:100%; height:auto; max-height:260px; object-fit:cover; display:block;">
				</div>
				<div style="display:flex; justify-content:center; gap:10px;">
					<button type="button" id="bwc_upload_btn" class="button button-secondary" style="border:1.5px solid #000; font-weight:700;">
						<span class="dashicons dashicons-update" style="vertical-align:middle;"></span> Replace Print Photograph
					</button>
					<button type="button" id="bwc_remove_btn" class="button" style="color:#B4282D; border:1.5px solid #B4282D; font-weight:700;">
						<span class="dashicons dashicons-trash" style="vertical-align:middle;"></span> Remove Photograph
					</button>
				</div>
			</div>

			<div id="bwc_empty_upload" style="border: 2px dashed #000; background: #FAF8F5; border-radius: 6px; padding: 24px; text-align: center; <?php echo ! empty( $image_url ) ? 'display:none;' : ''; ?>">
				<div style="margin-bottom: 8px;">
					<span class="dashicons dashicons-format-image" style="font-size: 36px; width: 36px; height: 36px; color: #C85C38;"></span>
				</div>
				<h4 style="margin: 0 0 4px; font-size: 14px; font-weight: 700; text-transform: uppercase;">Upload Master Print Photograph</h4>
				<p style="font-size: 12px; color: #666; margin: 0 0 14px;">Select the master print photograph from your Media Library or upload directly from your device.</p>
				<button type="button" id="bwc_empty_upload_btn" class="button button-primary" style="background:#000; border-color:#000; border-radius:50px; padding:6px 20px; font-weight:700; text-transform:uppercase;">
					<span class="dashicons dashicons-upload" style="vertical-align:middle;"></span> Choose Photo Print
				</button>
			</div>
		</div>

		<!-- 2. Grid Span & Location -->
		<div class="bwc-gallery-section-box">
			<div class="bwc-studio-heading">
				<span class="dashicons dashicons-grid-view"></span> 2. Layout Width, Kicker &amp; Production Location
			</div>

			<div class="bwc-meta-grid">
				<div>
					<label class="bwc-field-label"><?php _e( 'Grid Column Span (Masonry Layout)', 'cr8v-events-core' ); ?></label>
					<div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
						<label class="bwc-span-radio <?php echo $is_col6 ? 'is-selected' : ''; ?>">
							<input type="radio" name="cr8v_gallery_span" value="col-6" <?php checked( $is_col6 ); ?>>
							<span class="dashicons dashicons-grid-view" style="display:block; font-size:20px; width:20px; height:20px; margin:4px auto;"></span>
							<span style="font-size:12px; font-weight:700;">1 Column (Standard Tile)</span>
						</label>
						<label class="bwc-span-radio <?php echo $is_col8 ? 'is-selected' : ''; ?>">
							<input type="radio" name="cr8v_gallery_span" value="col-8" <?php checked( $is_col8 ); ?>>
							<span class="dashicons dashicons-format-gallery" style="display:block; font-size:20px; width:20px; height:20px; margin:4px auto;"></span>
							<span style="font-size:12px; font-weight:700;">2 Columns (Wide Hero)</span>
						</label>
					</div>
				</div>

				<div>
					<label class="bwc-field-label" for="cr8v_gallery_kicker"><?php _e( 'Print Kicker Tag', 'cr8v-events-core' ); ?></label>
					<input type="text" id="cr8v_gallery_kicker" name="cr8v_gallery_kicker" value="<?php echo esc_attr( $gallery_kicker ); ?>" placeholder="e.g. PRINT 01 // ARENA MONOLITH RIG" class="bwc-field-input" style="margin-bottom: 10px;">
					
					<label class="bwc-field-label" for="cr8v_gallery_location"><?php _e( 'Production City / Venue Tag', 'cr8v-events-core' ); ?></label>
					<input type="text" id="cr8v_gallery_location" name="cr8v_gallery_location" value="<?php echo esc_attr( $gallery_location ); ?>" placeholder="e.g. LONDON UK or MANCHESTER" class="bwc-field-input">
				</div>
			</div>
		</div>

		<!-- 3. Ribbon Accent Color Selector -->
		<div class="bwc-gallery-section-box">
			<div class="bwc-studio-heading">
				<span class="dashicons dashicons-tag"></span> 3. Pinned Paperclip / Ribbon Accent Color
			</div>
			
			<div style="display:flex; flex-wrap:wrap; gap:10px;">
				<?php foreach ( $colors as $hex => $cname ) : ?>
					<?php $is_sel = ( $ribbon_color === $hex ); ?>
					<label class="bwc-swatch-badge <?php echo $is_sel ? 'is-selected' : ''; ?>">
						<input type="radio" name="cr8v_ribbon_color" value="<?php echo esc_attr( $hex ); ?>" <?php checked( $is_sel ); ?> style="display:none;">
						<span style="width:12px; height:12px; border-radius:50%; background:<?php echo esc_attr( $hex ); ?>; border:1px solid rgba(255,255,255,0.5); display:inline-block;"></span>
						<span><?php echo esc_html( $cname ); ?></span>
					</label>
				<?php endforeach; ?>
			</div>
		</div>

		<!-- 4. Production Notes & Print Details -->
		<div class="bwc-gallery-section-box">
			<div class="bwc-studio-heading">
				<span class="dashicons dashicons-editor-paste-text"></span> 4. Production Notes &amp; Print Details
			</div>
			<textarea id="cr8v_gallery_notes" name="cr8v_gallery_notes" rows="3" class="bwc-field-input" placeholder="High-resolution production print documenting live stage operations, rigging accuracy, and spatial architecture..."><?php echo esc_textarea( $gallery_notes ); ?></textarea>
		</div>

		<script>
		jQuery(document).ready(function($){
			var galleryMediaUploader;

			function openGalleryMediaModal() {
				if (galleryMediaUploader) {
					galleryMediaUploader.open();
					return;
				}
				galleryMediaUploader = wp.media({
					title: 'Select Print Photograph',
					button: { text: 'Use this Photograph' },
					multiple: false
				});
				galleryMediaUploader.on('select', function() {
					var attachment = galleryMediaUploader.state().get('selection').first().toJSON();
					$('#cr8v_gallery_image_id').val(attachment.id);
					$('#cr8v_gallery_image_url').val(attachment.url);
					$('#bwc_preview_img').attr('src', attachment.url);
					$('#bwc_preview_container').show();
					$('#bwc_empty_upload').hide();

					if ($('#_thumbnail_id').length) {
						$('#_thumbnail_id').val(attachment.id);
					}
				});
				galleryMediaUploader.open();
			}

			$('#bwc_empty_upload_btn, #bwc_upload_btn').on('click', function(e){
				e.preventDefault();
				openGalleryMediaModal();
			});

			$('#bwc_remove_btn').on('click', function(e){
				e.preventDefault();
				$('#cr8v_gallery_image_id').val('');
				$('#cr8v_gallery_image_url').val('');
				$('#bwc_preview_img').attr('src', '');
				$('#bwc_preview_container').hide();
				$('#bwc_empty_upload').show();
				if ($('#_thumbnail_id').length) {
					$('#_thumbnail_id').val('-1');
				}
			});

			// Interactive Span Radio Cards
			$('input[name="cr8v_gallery_span"]').on('change', function(){
				$('.bwc-span-radio').removeClass('is-selected');
				$(this).closest('.bwc-span-radio').addClass('is-selected');
			});

			// Interactive Swatches
			$('.bwc-swatch-badge input[type="radio"]').on('change', function(){
				$('.bwc-swatch-badge').removeClass('is-selected');
				$(this).closest('.bwc-swatch-badge').addClass('is-selected');
			});
		});
		</script>
		<?php
	}
}

/**
 * 5. Save Meta Box Data
 */
if ( ! function_exists( 'cr8v_save_custom_meta' ) ) {
	function cr8v_save_custom_meta( $post_id ) {
		// 1. Save Event Meta
		if ( isset( $_POST['cr8v_event_meta_nonce'] ) && wp_verify_nonce( $_POST['cr8v_event_meta_nonce'], 'cr8v_save_event_meta' ) ) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
			if ( ! current_user_can( 'edit_post', $post_id ) ) return;

			$event_fields = array(
				'cr8v_event_date', 'cr8v_event_time', 'cr8v_event_venue',
				'cr8v_event_kicker', 'cr8v_event_capacity', 'cr8v_event_lead_prod',
				'cr8v_event_excerpt', 'cr8v_event_scope',
				'cr8v_spec_audio', 'cr8v_spec_lighting', 'cr8v_spec_staging', 'cr8v_spec_crew',
				'cr8v_event_cta_txt', 'cr8v_event_cta_url', 'cr8v_event_gallery_ids'
			);

			foreach ( $event_fields as $ef ) {
				if ( isset( $_POST[ $ef ] ) ) {
					$val = ( $ef === 'cr8v_event_scope' || $ef === 'cr8v_event_excerpt' ) ? sanitize_textarea_field( $_POST[ $ef ] ) : sanitize_text_field( $_POST[ $ef ] );
					update_post_meta( $post_id, '_' . $ef, $val );
				}
			}

			// Optional card details: an emptied field removes the value, so nothing old lingers.
			foreach ( array( 'short_title', 'location' ) as $optional ) {
				if ( isset( $_POST[ 'cr8v_event_' . $optional ] ) ) {
					$opt_val = mb_substr( sanitize_text_field( wp_unslash( $_POST[ 'cr8v_event_' . $optional ] ) ), 0, 80 );
					if ( '' === $opt_val ) {
						delete_post_meta( $post_id, '_cr8v_event_' . $optional );
					} else {
						update_post_meta( $post_id, '_cr8v_event_' . $optional, $opt_val );
					}
				}
			}
			if ( isset( $_POST['cr8v_event_badge_style'] ) ) {
				$badge = sanitize_key( wp_unslash( $_POST['cr8v_event_badge_style'] ) );
				if ( isset( cr8v_event_badge_styles()[ $badge ] ) ) {
					update_post_meta( $post_id, '_cr8v_event_badge_style', $badge );
				} else {
					delete_post_meta( $post_id, '_cr8v_event_badge_style' );
				}
			}

			// Synchronize Event Poster
			if ( isset( $_POST['cr8v_event_image_id'] ) ) {
				$img_id = intval( $_POST['cr8v_event_image_id'] );
				if ( $img_id > 0 ) {
					set_post_thumbnail( $post_id, $img_id );
					delete_post_meta( $post_id, '_cr8v_event_image_url' );
				} elseif ( empty( $_POST['cr8v_event_image_id'] ) ) {
					if ( isset( $_POST['cr8v_event_image_url'] ) && ! empty( $_POST['cr8v_event_image_url'] ) ) {
						update_post_meta( $post_id, '_cr8v_event_image_url', esc_url_raw( $_POST['cr8v_event_image_url'] ) );
					} else {
						delete_post_thumbnail( $post_id );
						delete_post_meta( $post_id, '_cr8v_event_image_url' );
					}
				}
			}
		}

		// 2. Save Gallery Meta
		if ( isset( $_POST['cr8v_gallery_meta_nonce'] ) && wp_verify_nonce( $_POST['cr8v_gallery_meta_nonce'], 'cr8v_save_gallery_meta' ) ) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
			if ( ! current_user_can( 'edit_post', $post_id ) ) return;

			$gallery_fields = array(
				'cr8v_gallery_span', 'cr8v_ribbon_color', 'cr8v_gallery_location',
				'cr8v_gallery_kicker', 'cr8v_gallery_notes'
			);

			foreach ( $gallery_fields as $gf ) {
				if ( isset( $_POST[ $gf ] ) ) {
					$val = ( $gf === 'cr8v_gallery_notes' ) ? sanitize_textarea_field( $_POST[ $gf ] ) : sanitize_text_field( $_POST[ $gf ] );
					update_post_meta( $post_id, '_' . $gf, $val );
				}
			}

			// Synchronize Gallery Print Image
			if ( isset( $_POST['cr8v_gallery_image_id'] ) ) {
				$g_img_id = intval( $_POST['cr8v_gallery_image_id'] );
				if ( $g_img_id > 0 ) {
					set_post_thumbnail( $post_id, $g_img_id );
					delete_post_meta( $post_id, '_cr8v_gallery_image_url' );
				} elseif ( empty( $_POST['cr8v_gallery_image_id'] ) ) {
					if ( isset( $_POST['cr8v_gallery_image_url'] ) && ! empty( $_POST['cr8v_gallery_image_url'] ) ) {
						update_post_meta( $post_id, '_cr8v_gallery_image_url', esc_url_raw( $_POST['cr8v_gallery_image_url'] ) );
					} else {
						delete_post_thumbnail( $post_id );
						delete_post_meta( $post_id, '_cr8v_gallery_image_url' );
					}
				}
			}
		}
	}
	add_action( 'save_post', 'cr8v_save_custom_meta' );
}
