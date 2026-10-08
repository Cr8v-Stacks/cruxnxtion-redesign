<?php
/**
 * Crux Nxtion - Customizer: site-wide settings.
 *
 * Everything the client may change from Appearance > Customize that appears on EVERY page: contact details, the
 * announcement bar, header buttons and menu card, the pre-footer call to action and the footer. The original
 * wording is the default of every field, so a site that never opens the Customizer looks exactly as before.
 *
 * Not editable here on purpose: fonts, colours, slanted button shapes, layout and anything to do with tickets,
 * payments or staff. Events, tickets and enquiries are managed in their own admin menus.
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sections shown in the Customizer: id => title, description.
 */
function crux_customizer_sections() {
	return array(
		'contact'    => array( 'Contact details', 'Phone numbers, e-mail, address and booking and social links used across the site.' ),
		'bar'        => array( 'Announcement bar', 'The thin bar above the header. {year} and {next_year} are replaced by the current and next year.' ),
		'header'     => array( 'Header buttons & menu card', 'The call-to-action button in the header and the "Not sure which?" card in the Services menu.' ),
		'prefooter'  => array( 'Pre-footer band (events pages)', 'The big "Got a date?" band above the footer on the events and information pages.' ),
		'prefooter2' => array( 'Pre-footer band (consultancy)', 'The same band on the consultancy home page.' ),
		'footer'     => array( 'Footer', 'The large brand name and the line at the very bottom.' ),
	);
}

/**
 * All fields: id => section, label, type (text, textarea, url, email, tel, media), default, optional (may be empty).
 */
function crux_customizer_fields() {
	static $fields = null;
	if ( null !== $fields ) {
		return $fields;
	}
	$f = function ( $section, $label, $type, $default, $optional = false ) {
		return compact( 'section', 'label', 'type', 'default', 'optional' );
	};
	$fields = array(
		'phone_main'        => $f( 'contact', 'Main phone number', 'tel', '+44 7448 614051' ),
		'phone_events'      => $f( 'contact', 'Events phone number (contact page)', 'tel', '+44 7762 278076' ),
		'phone_consult'     => $f( 'contact', 'Consultancy phone number (contact and FAQ pages)', 'tel', '+44 7341 366400' ),
		'email'             => $f( 'contact', 'E-mail address (also receives enquiries)', 'email', 'infoandsales@cruxnxtion.co.uk' ),
		'addr_line'         => $f( 'contact', 'Address: street', 'text', '29 Dun Work' ),
		'addr_city'         => $f( 'contact', 'Address: town and postcode', 'text', 'Sheffield S3 8FB' ),
		'addr_country'      => $f( 'contact', 'Address: country', 'text', 'United Kingdom' ),
		'calendly_url'      => $f( 'contact', 'Discovery-call booking link', 'url', 'https://calendly.com/cruxnxtiongroupofcompany-info' ),
		'social_instagram'  => $f( 'contact', 'Instagram link (leave empty to hide the link target)', 'url', '', true ),
		'social_tiktok'     => $f( 'contact', 'TikTok link', 'url', '', true ),
		'social_whatsapp'   => $f( 'contact', 'WhatsApp link, e.g. https://wa.me/447448614051', 'url', '', true ),

		'bar_events_text'   => $f( 'bar', 'Events pages: message', 'text', 'Now booking {year}/{next_year} across the UK —' ),
		'bar_events_link'   => $f( 'bar', 'Events pages: link wording', 'text', 'get in touch →' ),
		'bar_dual_text'     => $f( 'bar', 'About, contact, FAQ and legal pages: message', 'text', 'Now booking {year}/{next_year} — Events & Business Consultancy —' ),
		'bar_dual_link'     => $f( 'bar', 'About, contact, FAQ and legal pages: link wording', 'text', 'get in touch →' ),
		'bar_consult_text'  => $f( 'bar', 'Consultancy pages: message', 'text', 'Crux Nxtion Consultancy — now booking discovery calls —' ),
		'bar_consult_link'  => $f( 'bar', 'Consultancy pages: link wording', 'text', "tell us where you're stuck →" ),

		'cta_events_text'   => $f( 'header', 'Header button on events pages', 'text', 'Plan An Event' ),
		'cta_consult_text'  => $f( 'header', 'Header button on consultancy pages', 'text', 'Book Discovery Call' ),
		'card_title'        => $f( 'header', 'Menu card: heading', 'text', 'NOT SURE WHICH?' ),
		'card_button'       => $f( 'header', 'Menu card: button wording', 'text', 'Book A Call' ),
		'card_photo'        => $f( 'header', 'Menu card: photo', 'media', 0, true ),

		'pf_eyebrow'        => $f( 'prefooter', 'Small heading above the title', 'text', 'Ready When You Are' ),
		'pf_events_title'   => $f( 'prefooter', 'Title', 'text', 'GOT A DATE, OR JUST A DIRECTION?' ),
		'pf_events_desc'    => $f( 'prefooter', 'Paragraph', 'textarea', 'Planning an event or building a business — tell us what you have in mind and a real person will come back to you.' ),
		'pf_events_btn1'    => $f( 'prefooter', 'First button', 'text', 'Plan An Event →' ),
		'pf_events_btn2'    => $f( 'prefooter', 'Second button', 'text', 'Talk Business Strategy →' ),

		'pf_consult_title'  => $f( 'prefooter2', 'Title', 'text', "GOT AN IDEA? LET'S TALK IT THROUGH." ),
		'pf_consult_desc'   => $f( 'prefooter2', 'Paragraph', 'textarea', "Tell us where you are stuck — we'll take it from there." ),
		'pf_consult_btn1'   => $f( 'prefooter2', 'First button', 'text', 'Book A Discovery Call →' ),
		'pf_consult_btn2'   => $f( 'prefooter2', 'Second button', 'text', 'Explore Events →' ),

		'brand_1'           => $f( 'footer', 'Large brand name, first word', 'text', 'CRUX' ),
		'brand_2'           => $f( 'footer', 'Large brand name, second word', 'text', 'NXTION' ),
		'copyright'         => $f( 'footer', 'Bottom line (the year is added in front)', 'text', 'Crux Nxtion Events • Sheffield, United Kingdom • All Rights Reserved' ),
	);
	return $fields;
}

/**
 * Value of one setting. An emptied required field falls back to the original wording, so a button is never blank.
 */
function crux_opt( $id ) {
	$fields = crux_customizer_fields();
	if ( ! isset( $fields[ $id ] ) ) {
		return '';
	}
	$field = $fields[ $id ];
	$value = get_theme_mod( 'crux_' . $id, $field['default'] );
	if ( 'media' === $field['type'] ) {
		return absint( $value );
	}
	$value = is_scalar( $value ) ? (string) $value : '';
	return ( '' === $value && ! $field['optional'] ) ? (string) $field['default'] : $value;
}

/**
 * Clean a value for its field type. Runs when the Customizer saves and again when a value is read from an import.
 */
function crux_sanitize_setting( $value, $setting = null ) {
	$id     = $setting ? preg_replace( '/^crux_/', '', $setting->id ) : '';
	$fields = crux_customizer_fields();
	$type   = isset( $fields[ $id ] ) ? $fields[ $id ]['type'] : 'text';
	switch ( $type ) {
		case 'textarea':
			return sanitize_textarea_field( $value );
		case 'url':
			return esc_url_raw( trim( (string) $value ), array( 'http', 'https' ) );
		case 'email':
			return sanitize_email( $value );
		case 'tel':
			return trim( preg_replace( '/[^0-9+()\- ]/', '', (string) $value ) );
		case 'media':
			return absint( $value );
	}
	return sanitize_text_field( $value );
}

function crux_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'crux_site',
		array(
			'title'       => __( 'Crux Nxtion: site-wide settings', 'cruxnxtion' ),
			'description' => __( 'Things that appear on every page. Events, tickets and enquiries have their own menus in the admin sidebar. Fonts, colours and layout are fixed on purpose to keep the brand consistent.', 'cruxnxtion' ),
			'priority'    => 30,
		)
	);
	$priority = 1;
	foreach ( crux_customizer_sections() as $id => $section ) {
		$wp_customize->add_section(
			'crux_' . $id,
			array(
				'title'       => $section[0],
				'description' => $section[1],
				'panel'       => 'crux_site',
				'priority'    => $priority++,
			)
		);
	}
	foreach ( crux_customizer_fields() as $id => $field ) {
		$wp_customize->add_setting(
			'crux_' . $id,
			array(
				'default'           => $field['default'],
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'crux_sanitize_setting',
				'transport'         => 'refresh',
			)
		);
		if ( 'media' === $field['type'] ) {
			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize,
					'crux_' . $id,
					array(
						'label'     => $field['label'],
						'section'   => 'crux_' . $field['section'],
						'mime_type' => 'image',
					)
				)
			);
			continue;
		}
		$wp_customize->add_control(
			'crux_' . $id,
			array(
				'label'   => $field['label'],
				'section' => 'crux_' . $field['section'],
				'type'    => 'textarea' === $field['type'] ? 'textarea' : ( 'email' === $field['type'] ? 'email' : ( 'url' === $field['type'] ? 'url' : ( 'tel' === $field['type'] ? 'tel' : 'text' ) ) ),
			)
		);
	}
}
add_action( 'customize_register', 'crux_customize_register' );

/* ---- Output helpers used by the templates and parts ---------------------------------------------------------------- */

/** "tel:" address for a phone setting. */
function crux_tel( $id ) {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', crux_opt( $id ) );
}

/** Full or short postal address as one line. */
function crux_address( $with_country = true ) {
	$parts = array( crux_opt( 'addr_line' ), crux_opt( 'addr_city' ) );
	if ( $with_country ) {
		$parts[] = crux_opt( 'addr_country' );
	}
	return implode( ', ', $parts );
}

/** Text of an announcement-bar message with {year} and {next_year} filled in. */
function crux_bar_text( $which ) {
	return str_replace( array( '{year}', '{next_year}' ), array( date( 'Y' ), (string) ( (int) date( 'Y' ) + 1 ) ), crux_opt( 'bar_' . $which . '_text' ) );
}

/** URL for a social setting, or "#" while it is empty. */
function crux_social_url( $network ) {
	$url = crux_opt( 'social_' . $network );
	return '' === $url ? '#' : $url;
}

/** Attributes that make a real social link open in a new tab (none for the "#" placeholder). */
function crux_social_attrs( $network ) {
	return '' === crux_opt( 'social_' . $network ) ? '' : ' target="_blank" rel="noopener"';
}

/** Photo of the Services menu card: the chosen picture, else the original one. */
function crux_card_photo_url() {
	$id = crux_opt( 'card_photo' );
	if ( $id ) {
		$url = wp_get_attachment_image_url( $id, 'large' );
		if ( $url ) {
			return $url;
		}
	}
	return crux_get_blob_url( 'f269f7683bdb441b9b45df1336cd1485' );
}

/* ---- Page content: the wording of each page, one panel per page ------------------------------------------------------ */

/**
 * Pages whose wording is editable: page key => panel title, template file, preview condition (slug or 'front').
 */
function crux_content_pages() {
	return array(
		'home'                 => array( 'Home page', 'front' ),
		'about'                => array( 'About page', 'about' ),
		'services'             => array( 'Event services page', 'services' ),
		'services_consultancy' => array( 'Consultancy services page', 'services-consultancy' ),
		'consultancy'          => array( 'Consultancy home page', 'consultancy' ),
		'founder'              => array( 'Founder page', 'founder' ),
		'faq'                  => array( 'FAQ page', 'faq' ),
		'gallery'              => array( 'Gallery page', 'gallery' ),
		'sponsors'             => array( 'Sponsors page', 'sponsors' ),
		'events'               => array( 'Events page', 'events' ),
		'events_archive'       => array( 'Past events page', 'past-events' ),
		'blog'                 => array( 'Blog page', 'blog' ),
		'contact'              => array( 'Contact page', 'contact' ),
	);
}

/** Fields of one page: key => array( region, label, type, original wording ). */
function crux_content_fields( $page ) {
	static $cache = array();
	if ( ! isset( $cache[ $page ] ) ) {
		$file = get_template_directory() . '/inc/content/' . $page . '.php';
		$cache[ $page ] = ( preg_match( '/^[a-z_]+$/', $page ) && file_exists( $file ) ) ? (array) include $file : array();
		$photos = get_template_directory() . '/inc/content/images/' . $page . '.php';
		if ( preg_match( '/^[a-z_]+$/', $page ) && file_exists( $photos ) ) {
			$cache[ $page ] = array_merge( $cache[ $page ], (array) include $photos );
		}
	}
	return $cache[ $page ];
}

/** Tags a client may use inside a rich field. */
function crux_rich_allowed() {
	$style = array( 'style' => true, 'class' => true );
	return array(
		'strong' => $style, 'em' => $style, 'b' => $style, 'i' => $style, 'u' => $style, 'small' => $style, 'mark' => $style,
		'br'     => array(),
		'span'   => $style,
		'a'      => array( 'href' => true, 'target' => true, 'rel' => true, 'style' => true, 'class' => true ),
	);
}

/** Saved value of a page field, or the original wording when nothing was saved. An emptied field stays empty. */
function crux_value( $page, $key ) {
	$fields = crux_content_fields( $page );
	if ( ! isset( $fields[ $key ] ) ) {
		return '';
	}
	$saved = get_theme_mod( 'crux_c_' . $page . '_' . $key, null );
	return null === $saved ? (string) $fields[ $key ][3] : (string) $saved;
}

/** Address of a replaceable photo: the Media Library picture the client chose, else the original design photo. */
function crux_img_url( $page, $key ) {
	$fields = crux_content_fields( $page );
	$saved  = absint( get_theme_mod( 'crux_c_' . $page . '_' . $key, 0 ) );
	if ( $saved ) {
		$url = wp_get_attachment_url( $saved );
		if ( $url ) {
			return $url;
		}
	}
	return isset( $fields[ $key ] ) ? crux_get_blob_url( $fields[ $key ][3] ) : '';
}

/** Print plain wording, escaped. */
function crux_h( $page, $key ) {
	return esc_html( crux_value( $page, $key ) );
}

/**
 * Print wording that may carry bold, italic, line breaks and links. The original wording is trusted; anything a client
 * saved is filtered down to the allowed tags.
 */
function crux_rich( $page, $key ) {
	$fields = crux_content_fields( $page );
	$saved  = get_theme_mod( 'crux_c_' . $page . '_' . $key, null );
	if ( null === $saved ) {
		return isset( $fields[ $key ] ) ? $fields[ $key ][3] : '';
	}
	return wp_kses( (string) $saved, crux_rich_allowed() );
}

function crux_sanitize_content( $value, $setting = null ) {
	if ( $setting && preg_match( '/^crux_c_([a-z_]+?)_([a-z0-9_]+)$/', $setting->id, $m ) ) {
		foreach ( array_keys( crux_content_pages() ) as $page ) {
			if ( 0 === strpos( $m[1] . '_' . $m[2], $page . '_' ) ) {
				$key    = substr( $m[1] . '_' . $m[2], strlen( $page ) + 1 );
				$fields = crux_content_fields( $page );
				if ( isset( $fields[ $key ] ) ) {
					if ( 'media' === $fields[ $key ][2] ) {
						return absint( $value );
					}
					if ( 'rich' === $fields[ $key ][2] ) {
						return wp_kses( (string) $value, crux_rich_allowed() );
					}
					return 'textarea' === $fields[ $key ][2] ? sanitize_textarea_field( $value ) : sanitize_text_field( $value );
				}
			}
		}
	}
	return sanitize_text_field( $value );
}

require_once __DIR__ . '/customizer-pages.php';
