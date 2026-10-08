<?php
/**
 * Event Details meta box for the `event` post type.
 *
 * Meta keys (shared across all Cr8v event sites):
 *   _cr8v_event_date          Y-m-d
 *   _cr8v_event_time          text, e.g. "10:00 PM - Late"
 *   _cr8v_event_venue         text, venue and city
 *   _cr8v_event_location      text, country / region
 *   _cr8v_event_category      text
 *   _cr8v_event_short_title   text, used on cards
 *   _cr8v_event_eventbrite    http(s) URL, external booking link
 *   _cr8v_event_badge_style   blue | red | purple
 *   _cr8v_event_gallery_ids   comma separated Media Library attachment IDs
 * The hero image is the post's featured image.
 *
 * @package Cr8v_Event_Ticketing
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Text fields: meta key suffix => label, max length, placeholder.
 */
function cr8v_tix_text_fields() {
	return array(
		'short_title' => array( 'Short title (cards)', 80, 'e.g. Dance OUT 2023' ),
		'category'    => array( 'Category', 60, 'e.g. Dance Night' ),
		'time'        => array( 'Time', 60, 'e.g. 10:00 PM - Late' ),
		'venue'       => array( 'Venue / city', 120, 'e.g. Sheffield' ),
		'location'    => array( 'Country / region', 80, 'e.g. United Kingdom' ),
	);
}

function cr8v_tix_badge_styles() {
	return array(
		'blue'   => 'Blue',
		'red'    => 'Red',
		'purple' => 'Purple',
	);
}

function cr8v_tix_add_meta_box() {
	// On a site running the shared Cr8v events plugin, its Studio box already holds these fields. Showing both would
	// post the same field names twice, so this box steps aside and only the ticket tiers box is added.
	if ( function_exists( 'cr8v_render_event_studio_meta_box' ) ) {
		return;
	}
	add_meta_box(
		'cr8v_event_details',
		__( 'Event Details', 'cr8v-event-ticketing' ),
		'cr8v_tix_render_meta_box',
		'event',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'cr8v_tix_add_meta_box' );

function cr8v_tix_render_meta_box( $post ) {
	wp_nonce_field( 'cr8v_tix_save_event', 'cr8v_tix_nonce' );

	// Tell the editor where each part of the event page comes from, so nothing looks hidden.
	echo '<p class="description" style="margin:0 0 12px;">' . esc_html__( 'Where things come from: the event name is the title above; the short summary is the Excerpt (right-hand panel); the main text is the editor above; the main photo is the Featured Image. Everything else is in this box.', 'cr8v-event-ticketing' ) . '</p>';

	$get = function ( $key ) use ( $post ) {
		$value = get_post_meta( $post->ID, '_cr8v_event_' . $key, true );
		if ( '' === $value ) {
			$value = get_post_meta( $post->ID, '_crux_event_' . $key, true );
		}
		return is_scalar( $value ) ? (string) $value : '';
	};

	$badge = $get( 'badge_style' );
	if ( '' === $badge ) {
		$legacy = strtoupper( (string) get_post_meta( $post->ID, '_cr8v_event_badge_bg', true ) );
		$badge  = array( '#002671' => 'blue', '#BA0000' => 'red', '#8C7AE6' => 'purple' )[ $legacy ] ?? 'blue';
	}

	$gallery_ids = array_filter( array_map( 'absint', explode( ',', (string) get_post_meta( $post->ID, '_cr8v_event_gallery_ids', true ) ) ) );
	?>
	<style>
		.cr8v-tix-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px 20px}
		.cr8v-tix-grid label{display:block;font-weight:600;margin-bottom:4px}
		.cr8v-tix-grid input[type=text],.cr8v-tix-grid input[type=date],.cr8v-tix-grid input[type=url],.cr8v-tix-grid select{width:100%}
		.cr8v-tix-full{grid-column:1/-1}
		.cr8v-tix-hint{color:#646970;font-size:12px;margin:4px 0 0}
		.cr8v-tix-thumbs{display:flex;flex-wrap:wrap;gap:8px;margin:8px 0}
		.cr8v-tix-thumbs img{width:80px;height:80px;object-fit:cover;border-radius:4px;border:1px solid #c3c4c7}
	</style>
	<div class="cr8v-tix-grid">
		<div>
			<label for="cr8v_event_date"><?php esc_html_e( 'Event date', 'cr8v-event-ticketing' ); ?></label>
			<input type="date" id="cr8v_event_date" name="cr8v_event_date" value="<?php echo esc_attr( $get( 'date' ) ); ?>">
			<p class="cr8v-tix-hint"><?php esc_html_e( 'Events are listed newest first by this date.', 'cr8v-event-ticketing' ); ?></p>
		</div>
		<div>
			<label for="cr8v_event_badge_style"><?php esc_html_e( 'Ticket colour', 'cr8v-event-ticketing' ); ?></label>
			<select id="cr8v_event_badge_style" name="cr8v_event_badge_style">
				<?php foreach ( cr8v_tix_badge_styles() as $value => $label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $badge, $value ); ?>><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<?php foreach ( cr8v_tix_text_fields() as $key => $field ) : ?>
			<div>
				<label for="cr8v_event_<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field[0] ); ?></label>
				<input type="text" id="cr8v_event_<?php echo esc_attr( $key ); ?>" name="cr8v_event_<?php echo esc_attr( $key ); ?>" maxlength="<?php echo (int) $field[1]; ?>" placeholder="<?php echo esc_attr( $field[2] ); ?>" value="<?php echo esc_attr( $get( $key ) ); ?>">
			</div>
		<?php endforeach; ?>
		<div class="cr8v-tix-full">
			<label for="cr8v_event_eventbrite"><?php esc_html_e( 'Booking link (optional)', 'cr8v-event-ticketing' ); ?></label>
			<input type="url" id="cr8v_event_eventbrite" name="cr8v_event_eventbrite" placeholder="https://" value="<?php echo esc_attr( $get( 'eventbrite' ) ); ?>">
			<p class="cr8v-tix-hint"><?php esc_html_e( 'External ticket page (for example Eventbrite). Leave empty to send visitors to the contact page.', 'cr8v-event-ticketing' ); ?></p>
		</div>
		<div class="cr8v-tix-full">
			<label><?php esc_html_e( 'Gallery images', 'cr8v-event-ticketing' ); ?></label>
			<input type="hidden" id="cr8v_event_gallery_ids" name="cr8v_event_gallery_ids" value="<?php echo esc_attr( implode( ',', $gallery_ids ) ); ?>">
			<div class="cr8v-tix-thumbs" id="cr8v-tix-thumbs">
				<?php foreach ( $gallery_ids as $att_id ) : ?>
					<?php echo wp_get_attachment_image( $att_id, array( 80, 80 ) ); ?>
				<?php endforeach; ?>
			</div>
			<button type="button" class="button" id="cr8v-tix-pick"><?php esc_html_e( 'Choose images', 'cr8v-event-ticketing' ); ?></button>
			<button type="button" class="button-link-delete" id="cr8v-tix-clear"><?php esc_html_e( 'Clear', 'cr8v-event-ticketing' ); ?></button>
			<p class="cr8v-tix-hint"><?php esc_html_e( 'The main picture is the Featured Image (right-hand panel). The gallery photos are shown under From the Gallery on the event page.', 'cr8v-event-ticketing' ); ?></p>
		</div>
	</div>
	<?php
}

function cr8v_tix_admin_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( ! $screen || 'event' !== $screen->post_type ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_script( 'cr8v-tix-admin', CR8V_TICKETING_URL . 'assets/admin-event.js', array( 'jquery' ), CR8V_TICKETING_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'cr8v_tix_admin_assets' );

/**
 * Write or remove one meta value. Empty values delete the key.
 */
function cr8v_tix_store( $post_id, $key, $value ) {
	if ( '' === $value || null === $value ) {
		delete_post_meta( $post_id, '_cr8v_event_' . $key );
	} else {
		update_post_meta( $post_id, '_cr8v_event_' . $key, $value );
	}
	// Seeded Crux posts also carry legacy `_crux_event_*` copies. Remove them so a
	// cleared field cannot fall back to an old value.
	delete_post_meta( $post_id, '_crux_event_' . $key );
}

function cr8v_tix_save_event( $post_id, $post ) {
	if ( ! isset( $_POST['cr8v_tix_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cr8v_tix_nonce'] ) ), 'cr8v_tix_save_event' ) ) {
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

	// Date: must be a real calendar date in Y-m-d.
	$date = isset( $_POST['cr8v_event_date'] ) ? sanitize_text_field( wp_unslash( $_POST['cr8v_event_date'] ) ) : '';
	if ( ! preg_match( '/^(\d{4})-(\d{2})-(\d{2})$/', $date, $m ) || ! checkdate( (int) $m[2], (int) $m[3], (int) $m[1] ) ) {
		$date = '';
	}
	cr8v_tix_store( $post_id, 'date', $date );

	// Plain text fields.
	foreach ( cr8v_tix_text_fields() as $key => $field ) {
		$raw   = isset( $_POST[ 'cr8v_event_' . $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'cr8v_event_' . $key ] ) ) : '';
		cr8v_tix_store( $post_id, $key, mb_substr( $raw, 0, $field[1] ) );
	}

	// Booking URL: http(s) only.
	$url = isset( $_POST['cr8v_event_eventbrite'] ) ? esc_url_raw( wp_unslash( $_POST['cr8v_event_eventbrite'] ), array( 'http', 'https' ) ) : '';
	cr8v_tix_store( $post_id, 'eventbrite', $url );

	// Badge: whitelist only.
	$style = isset( $_POST['cr8v_event_badge_style'] ) ? sanitize_key( wp_unslash( $_POST['cr8v_event_badge_style'] ) ) : '';
	if ( ! isset( cr8v_tix_badge_styles()[ $style ] ) ) {
		$style = 'blue';
	}
	update_post_meta( $post_id, '_cr8v_event_badge_style', $style );

	// Gallery: real attachments only, capped at 12.
	$ids   = isset( $_POST['cr8v_event_gallery_ids'] ) ? explode( ',', sanitize_text_field( wp_unslash( $_POST['cr8v_event_gallery_ids'] ) ) ) : array();
	$clean = array();
	foreach ( array_slice( array_filter( array_map( 'absint', $ids ) ), 0, 12 ) as $att_id ) {
		if ( 'attachment' === get_post_type( $att_id ) ) {
			$clean[] = $att_id;
		}
	}
	if ( $clean ) {
		update_post_meta( $post_id, '_cr8v_event_gallery_ids', implode( ',', $clean ) );
	} else {
		delete_post_meta( $post_id, '_cr8v_event_gallery_ids' );
	}
}
add_action( 'save_post_event', 'cr8v_tix_save_event', 10, 2 );

/**
 * Admin list: show the event date and make it sortable.
 */
function cr8v_tix_columns( $columns ) {
	$columns['cr8v_event_date'] = __( 'Event date', 'cr8v-event-ticketing' );
	return $columns;
}
add_filter( 'manage_event_posts_columns', 'cr8v_tix_columns' );

function cr8v_tix_column_content( $column, $post_id ) {
	if ( 'cr8v_event_date' === $column ) {
		$date = get_post_meta( $post_id, '_cr8v_event_date', true );
		echo $date ? esc_html( $date ) : '&mdash;';
	}
}
add_action( 'manage_event_posts_custom_column', 'cr8v_tix_column_content', 10, 2 );

function cr8v_tix_sortable_columns( $columns ) {
	$columns['cr8v_event_date'] = 'cr8v_event_date';
	return $columns;
}
add_filter( 'manage_edit-event_sortable_columns', 'cr8v_tix_sortable_columns' );

function cr8v_tix_sort_query( $query ) {
	if ( is_admin() && $query->is_main_query() && 'cr8v_event_date' === $query->get( 'orderby' ) ) {
		$query->set( 'meta_key', '_cr8v_event_date' );
		$query->set( 'orderby', 'meta_value' );
	}
}
add_action( 'pre_get_posts', 'cr8v_tix_sort_query' );
