<?php
/**
 * Staging guard — force noindex while the site is served from the raw
 * staging host/IP (or *.local). Auto-clears on the production domain.
 * Remove / adjust at go-live once the real domain is canonical.
 *
 * @package Delta_Ports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * True when the current request is served from a non-production host.
 *
 * @return bool
 */
function delta_ports_is_staging() {
	$host = isset( $_SERVER['HTTP_HOST'] ) ? strtolower( sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) ) : '';
	return ( '' === $host )
		|| ( false !== strpos( $host, '200.97.162.215' ) )
		|| ( false !== strpos( $host, ':8082' ) )
		|| ( false !== strpos( $host, '.local' ) );
}

/**
 * Force noindex/nofollow on staging (priority 99 to run after Yoast).
 *
 * @param array $robots Robots directives.
 * @return array
 */
function delta_ports_staging_noindex( $robots ) {
	if ( delta_ports_is_staging() ) {
		return array(
			'noindex'  => true,
			'nofollow' => true,
		);
	}
	return $robots;
}
add_filter( 'wp_robots', 'delta_ports_staging_noindex', 99 );

/**
 * Staging only: stop browsers caching the HTML so edits show on the plain URL.
 * Static assets keep their own (filemtime-versioned) caching.
 */
function delta_ports_staging_no_html_cache() {
	if ( is_admin() || ! delta_ports_is_staging() ) {
		return;
	}
	if ( ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || ( function_exists( 'wp_doing_ajax' ) && wp_doing_ajax() ) ) {
		return;
	}
	if ( ! headers_sent() ) {
		header( 'Cache-Control: no-cache, no-store, must-revalidate' );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );
	}
}
add_action( 'send_headers', 'delta_ports_staging_no_html_cache' );
