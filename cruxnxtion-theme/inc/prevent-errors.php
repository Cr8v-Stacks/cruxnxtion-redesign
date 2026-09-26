<?php
/**
 * Crux Nxtion - 404 & 403 Prevention, URL Aliases, Rewrite Rules & Fallbacks
 *
 * @package CruxNxtion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. URL Alias & 301 Redirect Engine for Legacy Live-Site URLs
 * Maps existing URLs on cruxnxtion.co.uk to new canonical endpoints.
 */
function crux_legacy_url_redirects() {
	if ( is_admin() || wp_doing_ajax() ) {
		return;
	}

	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	$path = trim( parse_url( $request_uri, PHP_URL_PATH ), '/' );

	// If page exists natively in WordPress, do not redirect
	$existing_page = get_page_by_path( $path );
	if ( $existing_page && $existing_page->post_status === 'publish' ) {
		return;
	}

	// 1A. Wildcard redirect for legacy individual event services
	if ( preg_match( '#^(services?)/([a-z0-9-]+)#i', $path, $matches ) ) {
		$sub = strtolower( $matches[2] );
		if ( $sub !== 'consultancy' ) {
			wp_safe_redirect( home_url( '/services/' ), 301 );
			exit;
		}
	}

	// 1B. Mapping of legacy URLs to new canonical URLs
	$redirect_map = array(
		'sponsor'                                      => '/sponsors/',
		'sponsorship'                                  => '/sponsors/',
		'partners'                                     => '/sponsors/',
		'career'                                       => '/about/',
		'careers'                                      => '/about/',
		'faqs'                                         => '/faq/',
		'frequently-asked-questions'                   => '/faq/',
		'our-services'                                 => '/services/',
		'event-services'                               => '/services/',
		'events-services'                              => '/services/',
		'service'                                      => '/services/',
		'what-we-do'                                   => '/services/',
		'consulting'                                   => '/consultancy/',
		'business-consulting'                          => '/consultancy/',
		'business-consultancy'                         => '/consultancy/',
		'consultancy-services'                         => '/services-consultancy/',
		'our-events'                                   => '/events/',
		'plan'                                         => '/contact/?type=events',
		'plan-an-event'                                => '/contact/?type=events',
		'book'                                         => '/contact/?type=events',
		'booking'                                      => '/contact/?type=events',
		'event-management-and-planning'                => '/services/',
		'event-management'                             => '/services/',
		'entertainment-booking-and-talent-acquisition' => '/services/',
		'entertainment-booking'                        => '/services/',
		'event-designs-and-production'                 => '/services/',
		'event-designs'                                => '/services/',
		'event-marketing-and-promotion'                => '/services/',
		'event-marketing'                              => '/services/',
		'on-site-coordination'                         => '/services/',
		'business-setup-and-strategy'                  => '/services-consultancy/',
		'branding-and-marketing'                       => '/services-consultancy/',
		'business-growth'                              => '/services-consultancy/',
		'activation-growth'                            => '/services-consultancy/',
		'business-audit-and-advisory'                  => '/services-consultancy/',
	);

	if ( isset( $redirect_map[ $path ] ) ) {
		wp_safe_redirect( home_url( $redirect_map[ $path ] ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'crux_legacy_url_redirects', 1 );

/**
 * 2. Virtual Template Fallback Router (Zero 404s Guarantee)
 * Guarantees that /gallery/, /about/, /founder/, /contact/, single events, and blog posts
 * ALWAYS render their dedicated templates with HTTP 200 OK, never falling back to front-page or 404.
 */
function crux_virtual_template_fallback( $template ) {
	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	$slug = trim( parse_url( $request_uri, PHP_URL_PATH ), '/' );

	// Do not intercept root homepage or admin/ajax
	if ( empty( $slug ) || is_admin() || wp_doing_ajax() ) {
		return $template;
	}

	// 2A. Single event wildcard routing (/event/slug/ or /events/slug/)
	if ( preg_match( '#^event(?:s)?/(.+)$#i', $slug ) ) {
		$candidate = locate_template( array( 'single-event.php' ) );
		if ( $candidate ) {
			global $wp_query;
			$wp_query->is_404 = false;
			$wp_query->is_single = true;
			$wp_query->is_singular = true;
			status_header( 200 );
			return $candidate;
		}
	}

	// 2B. Blog single post wildcard routing (/blog/slug/)
	if ( preg_match( '#^blog/(.+)$#i', $slug ) ) {
		$candidate = locate_template( array( 'single.php' ) );
		if ( $candidate ) {
			global $wp_query;
			$wp_query->is_404 = false;
			$wp_query->is_single = true;
			$wp_query->is_singular = true;
			status_header( 200 );
			return $candidate;
		}
	}

	// 2C. Static page templates
	$slug_template_map = array(
		'consultancy'          => 'page-consultancy.php',
		'consulting'           => 'page-consultancy.php',
		'business-consultancy' => 'page-consultancy.php',
		'services'             => 'page-services.php',
		'our-services'         => 'page-services.php',
		'event-services'       => 'page-services.php',
		'what-we-do'           => 'page-services.php',
		'services-consultancy' => 'page-services-consultancy.php',
		'consultancy-services' => 'page-services-consultancy.php',
		'events'               => 'page-events.php',
		'our-events'           => 'page-events.php',
		'events-archive'       => 'page-events-archive.php',
		'past-events'          => 'page-events-archive.php',
		'gallery'              => 'page-gallery.php',
		'about'                => 'page-about.php',
		'about-us'             => 'page-about.php',
		'founder'              => 'page-founder.php',
		'contact'              => 'page-contact.php',
		'contact-us'           => 'page-contact.php',
		'faq'                  => 'page-faq.php',
		'faqs'                 => 'page-faq.php',
		'sponsors'             => 'page-sponsors.php',
		'blog'                 => 'page-blog.php',
		'privacy-policy'       => 'page-privacy-policy.php',
		'cookie-policy'        => 'page-cookie-policy.php',
		'terms-conditions'     => 'page-terms-conditions.php',
	);

	if ( isset( $slug_template_map[ $slug ] ) ) {
		$template_filename = $slug_template_map[ $slug ];
		// If current template is 404, front-page, index, or empty, force designated template
		$cur_base = basename( (string) $template );
		if ( is_404() || empty( $template ) || $cur_base === '404.php' || $cur_base === 'front-page.php' || $cur_base === 'index.php' || $cur_base === 'page.php' ) {
			$candidate = locate_template( array( $template_filename ) );
			if ( $candidate ) {
				global $wp_query;
				$wp_query->is_404 = false;
				$wp_query->is_page = true;
				$wp_query->is_singular = true;
				status_header( 200 );
				return $candidate;
			}
		}
	}

	return $template;
}
add_filter( 'template_include', 'crux_virtual_template_fallback', 99 );

/**
 * 3. Enforce Correct Document Title for Virtual Templates & Single Pages
 * Prevents "Page not found" from appearing in browser headers when virtual fallback is active.
 */
function crux_custom_document_title( $title_parts ) {
	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	$slug = trim( parse_url( $request_uri, PHP_URL_PATH ), '/' );

	$title_map = array(
		'founder'              => 'Founder Story — Crux Nxtion',
		'about'                => 'About Us — Crux Nxtion',
		'about-us'             => 'About Us — Crux Nxtion',
		'contact'              => 'Contact Us — Crux Nxtion',
		'contact-us'           => 'Contact Us — Crux Nxtion',
		'gallery'              => 'Ticket Wall & Event Gallery — Crux Nxtion',
		'events'               => 'Events & Tickets — Crux Nxtion',
		'past-events'          => 'Past Events Archive — Crux Nxtion',
		'events-archive'       => 'Past Events Archive — Crux Nxtion',
		'services'             => 'Event Services & Production — Crux Nxtion',
		'services-consultancy' => 'Business Consultancy Services — Crux Nxtion',
		'consultancy'          => 'Business Consultancy — Crux Nxtion',
		'faq'                  => 'FAQ & Inquiries — Crux Nxtion',
		'faqs'                 => 'FAQ & Inquiries — Crux Nxtion',
		'sponsors'             => 'Sponsors & Brand Partners — Crux Nxtion',
		'blog'                 => 'Journal & Event Recaps — Crux Nxtion',
		'privacy-policy'       => 'Privacy Policy — Crux Nxtion',
		'cookie-policy'        => 'Cookie Policy — Crux Nxtion',
		'terms-conditions'     => 'Terms & Conditions — Crux Nxtion',
	);

	if ( isset( $title_map[ $slug ] ) ) {
		if ( is_array( $title_parts ) ) {
			$title_parts['title'] = $title_map[ $slug ];
			return $title_parts;
		}
		return $title_map[ $slug ];
	}

	if ( preg_match( '#^event(?:s)?/(.+)$#i', $slug, $em ) ) {
		$raw_name = ucwords( str_replace( array( '-', '_' ), ' ', $em[1] ) );
		$t = $raw_name . ' — Past Event Experience — Crux Nxtion';
		if ( is_array( $title_parts ) ) {
			$title_parts['title'] = $t;
			return $title_parts;
		}
		return $t;
	}

	if ( preg_match( '#^blog/(.+)$#i', $slug, $bm ) ) {
		$raw_title = ucwords( str_replace( array( '-', '_' ), ' ', $bm[1] ) );
		$t = $raw_title . ' — Journal — Crux Nxtion';
		if ( is_array( $title_parts ) ) {
			$title_parts['title'] = $t;
			return $title_parts;
		}
		return $t;
	}

	return $title_parts;
}
add_filter( 'document_title_parts', 'crux_custom_document_title', 99 );
add_filter( 'pre_get_document_title', function ( $title ) {
	$parts = crux_custom_document_title( array( 'title' => '' ) );
	if ( ! empty( $parts['title'] ) ) {
		return $parts['title'];
	}
	return $title;
}, 99 );

/**
 * 4. Self-Healing Rewrite Rules Flush on Theme Activation
 */
function crux_flush_rewrite_on_activation() {
	flush_rewrite_rules( false );
}
add_action( 'after_switch_theme', 'crux_flush_rewrite_on_activation' );

/**
 * 5. Security & WAF Protection Headers
 */
function crux_security_waf_headers() {
	if ( ! headers_sent() ) {
		header( 'X-Content-Type-Options: nosniff' );
		header( 'X-Frame-Options: SAMEORIGIN' );
	}
}
add_action( 'send_headers', 'crux_security_waf_headers' );
