<?php
/**
 * Assets — performance-first conditional loading.
 *
 * @package Delta_Ports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front-end assets.
 */
function delta_ports_enqueue_assets() {
	if ( is_admin() ) {
		return;
	}

	$ver = DELTA_PORTS_VERSION;

	// Critical: main + premium on every page.
	wp_enqueue_style(
		'delta-ports-main',
		DELTA_PORTS_URI . '/assets/css/main.css',
		array(),
		$ver
	);

	wp_enqueue_style(
		'delta-ports-premium',
		DELTA_PORTS_URI . '/assets/css/premium.css',
		array( 'delta-ports-main' ),
		$ver
	);

	wp_enqueue_style(
		'delta-ports-live-parity',
		DELTA_PORTS_URI . '/assets/css/live-parity.css',
		array( 'delta-ports-main' ),
		$ver
	);

	// Homepage + About styles.
	if ( is_front_page() || is_page( array( 'about-us', 'home', 'home-upgrade' ) ) ) {
		wp_enqueue_style(
			'delta-ports-home-live',
			DELTA_PORTS_URI . '/assets/css/home-live.css',
			array( 'delta-ports-live-parity' ),
			$ver
		);
	}

	// Ops / leadership / contact / sustainability inner pages.
	$ops_pages = array(
		'led-operation-new',
		'led-operations',
		'cargo-handling-capabilities',
		'integrated-port-logistics',
		'sustainability',
		'contact-us',
		'leadership',
		'about-us',
	);
	if ( is_page( $ops_pages ) || is_front_page() ) {
		// Home uses some ops shared classes (business); about uses ops heroes elsewhere.
		wp_enqueue_style(
			'delta-ports-ops-live',
			DELTA_PORTS_URI . '/assets/css/ops-live.css',
			array( 'delta-ports-live-parity' ),
			$ver
		);
	}

	// Media & Updates, search, 404, single posts, archives.
	if ( is_home() || is_singular( 'post' ) || is_search() || is_404() || is_archive() || is_category() || is_tag() || is_page( array( 'media-updates', 'blog' ) ) ) {
		wp_enqueue_style(
			'delta-ports-ops-live',
			DELTA_PORTS_URI . '/assets/css/ops-live.css',
			array( 'delta-ports-live-parity' ),
			$ver
		);
		wp_enqueue_style(
			'delta-ports-media-live',
			DELTA_PORTS_URI . '/assets/css/media-live.css',
			array( 'delta-ports-live-parity' ),
			$ver
		);
	}

	wp_enqueue_style(
		'delta-ports-wide-screen',
		DELTA_PORTS_URI . '/assets/css/wide-screen.css',
		array( 'delta-ports-live-parity' ),
		$ver
	);

	// Core interactions (defer).
	wp_enqueue_script(
		'delta-ports-main',
		DELTA_PORTS_URI . '/assets/js/main.js',
		array(),
		$ver,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	// Lightweight scroll animations (no external AOS CDN — local fallback in live-animations.js).
	wp_enqueue_script(
		'delta-ports-live-animations',
		DELTA_PORTS_URI . '/assets/js/live-animations.js',
		array( 'delta-ports-main' ),
		$ver,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	// Home Our Business fluid map (WebGL) — front page only.
	if ( is_front_page() || is_page( array( 'home', 'home-upgrade' ) ) ) {
		wp_enqueue_script(
			'delta-ports-fluid-map',
			DELTA_PORTS_URI . '/assets/js/fluid-map.js',
			array(),
			$ver,
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);
	}

	// Contact Form 7 styles only on contact page (already enqueued by CF7 when shortcode present).
}
add_action( 'wp_enqueue_scripts', 'delta_ports_enqueue_assets' );

/**
 * Preload only critical font (one file) for LCP speed.
 */
function delta_ports_perf_preload() {
	$href = DELTA_PORTS_URI . '/assets/fonts/geist/Geist-Regular.woff2';
	echo '<link rel="preload" href="' . esc_url( $href ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
}
add_action( 'wp_head', 'delta_ports_perf_preload', 1 );

/**
 * Defer non-critical styles (optional polyfill via media swap).
 * Keeps main/premium as render-blocking; others can print.
 *
 * @param string $html   Link HTML.
 * @param string $handle Handle.
 * @param string $href   Href.
 * @param string $media  Media.
 * @return string
 */
function delta_ports_style_loader_tag( $html, $handle, $href, $media ) {
	$defer = array(
		'delta-ports-awwwards',
		'delta-ports-aos',
	);
	if ( in_array( $handle, $defer, true ) ) {
		$html = sprintf(
			'<link rel="stylesheet" id="%s-css" href="%s" media="print" onload="this.media=\'all\'" />' . "\n" .
			'<noscript><link rel="stylesheet" href="%s" /></noscript>' . "\n",
			esc_attr( $handle ),
			esc_url( $href ),
			esc_url( $href )
		);
	}
	return $html;
}
add_filter( 'style_loader_tag', 'delta_ports_style_loader_tag', 10, 4 );

/**
 * Elevated home (dpx) layer — front page only. filemtime version busts cache on edit.
 */
function delta_ports_enqueue_elevate() {
	if ( is_admin() || ! is_front_page() ) {
		return;
	}
	$css = DELTA_PORTS_DIR . '/assets/css/elevate.css';
	$js  = DELTA_PORTS_DIR . '/assets/js/elevate.js';
	wp_enqueue_style(
		'delta-ports-elevate',
		DELTA_PORTS_URI . '/assets/css/elevate.css',
		array( 'delta-ports-live-parity' ),
		file_exists( $css ) ? filemtime( $css ) : DELTA_PORTS_VERSION
	);
	wp_enqueue_script(
		'delta-ports-elevate',
		DELTA_PORTS_URI . '/assets/js/elevate.js',
		array(),
		file_exists( $js ) ? filemtime( $js ) : DELTA_PORTS_VERSION,
		array( 'in_footer' => true, 'strategy' => 'defer' )
	);
}
add_action( 'wp_enqueue_scripts', 'delta_ports_enqueue_elevate', 20 );

/**
 * Global elevation layer — all front-end pages, loaded last.
 */
function delta_ports_enqueue_elevate_global() {
	if ( is_admin() ) {
		return;
	}
	$css = DELTA_PORTS_DIR . '/assets/css/elevate-global.css';
	wp_enqueue_style(
		'delta-ports-elevate-global',
		DELTA_PORTS_URI . '/assets/css/elevate-global.css',
		array( 'delta-ports-wide-screen' ),
		file_exists( $css ) ? filemtime( $css ) : DELTA_PORTS_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'delta_ports_enqueue_elevate_global', 30 );

/**
 * Global elevation JS — eager-load critical/dark-framed images (all pages).
 */
function delta_ports_enqueue_elevate_global_js() {
	if ( is_admin() ) {
		return;
	}
	$js = DELTA_PORTS_DIR . '/assets/js/elevate-global.js';
	wp_enqueue_script(
		'delta-ports-elevate-global-js',
		DELTA_PORTS_URI . '/assets/js/elevate-global.js',
		array(),
		file_exists( $js ) ? filemtime( $js ) : DELTA_PORTS_VERSION,
		array( 'in_footer' => true, 'strategy' => 'defer' )
	);
}
add_action( 'wp_enqueue_scripts', 'delta_ports_enqueue_elevate_global_js', 31 );

/**
 * Slide-in drawer menu JS (all pages).
 */
function delta_ports_enqueue_nav_drawer() {
	if ( is_admin() ) {
		return;
	}
	$js = DELTA_PORTS_DIR . '/assets/js/nav-drawer.js';
	wp_enqueue_script(
		'delta-ports-nav-drawer',
		DELTA_PORTS_URI . '/assets/js/nav-drawer.js',
		array(),
		file_exists( $js ) ? filemtime( $js ) : DELTA_PORTS_VERSION,
		array( 'in_footer' => true, 'strategy' => 'defer' )
	);
}
add_action( 'wp_enqueue_scripts', 'delta_ports_enqueue_nav_drawer', 32 );
