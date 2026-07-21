<?php
/**
 * Theme setup.
 *
 * @package Delta_Ports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme supports and menus.
 */
function delta_ports_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/main.css' );
	add_editor_style( 'assets/css/premium.css' );
	add_editor_style( 'assets/css/awwwards.css' );
	add_editor_style( 'assets/css/live-parity.css' );
	// Align wide/full in editor for marketing layouts.
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'delta-ports' ),
			'footer'  => __( 'Footer Menu', 'delta-ports' ),
		)
	);

	// Customizer supports (Additional CSS under Appearance → Customize).
	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'delta_ports_setup' );

/**
 * Allow <canvas> in post content (Our Business fluid map).
 *
 * @param array  $tags    Allowed tags.
 * @param string $context Context.
 * @return array
 */
function delta_ports_kses_allow_canvas( $tags, $context ) {
	if ( 'post' === $context ) {
		$tags['canvas'] = array(
			'id'          => true,
			'class'       => true,
			'width'       => true,
			'height'      => true,
			'data-src'    => true,
			'style'       => true,
			'aria-hidden' => true,
		);
		// Contact office maps (OpenStreetMap embeds).
		$tags['iframe'] = array(
			'src'             => true,
			'width'           => true,
			'height'          => true,
			'title'           => true,
			'class'           => true,
			'id'              => true,
			'style'           => true,
			'loading'         => true,
			'referrerpolicy'  => true,
			'allowfullscreen' => true,
			'frameborder'     => true,
			'scrolling'       => true,
			'aria-hidden'     => true,
		);
	}
	return $tags;
}
add_filter( 'wp_kses_allowed_html', 'delta_ports_kses_allow_canvas', 10, 2 );

/**
 * Appearance → Theme Stylesheets — lists editable CSS files for this theme.
 * (Block themes hide the classic Theme File Editor; this page is the guide.)
 */
function delta_ports_stylesheets_admin_menu() {
	add_theme_page(
		__( 'Theme Stylesheets', 'delta-ports' ),
		__( 'Theme Stylesheets', 'delta-ports' ),
		'edit_theme_options',
		'delta-ports-stylesheets',
		'delta_ports_stylesheets_admin_page'
	);
}
add_action( 'admin_menu', 'delta_ports_stylesheets_admin_menu' );

/**
 * Admin page: stylesheet locations + links.
 */
function delta_ports_stylesheets_admin_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	$base = trailingslashit( get_template_directory() ) . 'assets/css/';
	$uri  = trailingslashit( get_template_directory_uri() ) . 'assets/css/';
	$files = array(
		'main.css'        => 'Header, base typography, global layout, banners overlay',
		'premium.css'     => 'Footer styles',
		'live-parity.css' => 'Gutenberg section spacing / live parity',
		'home-live.css'   => 'Homepage + About sections',
		'ops-live.css'    => 'Port-led, Cargo, Logistics, Leadership, Sustainability, Contact',
		'awwwards.css'    => 'Extra page system styles',
	);
	echo '<div class="wrap"><h1>Delta Ports — Theme Stylesheets</h1>';
	echo '<p>This is a <strong>block theme</strong>. WordPress does not show classic <em>Appearance → Theme File Editor</em> for FSE themes by default.</p>';
	echo '<p>Edit CSS files on disk (VS Code / Cursor), or add quick overrides via <a href="' . esc_url( admin_url( 'customize.php?autofocus[section]=custom_css' ) ) . '"><strong>Appearance → Customize → Additional CSS</strong></a>.</p>';
	echo '<h2>CSS files (edit these)</h2><table class="widefat striped"><thead><tr><th>File</th><th>Purpose</th><th>Open</th></tr></thead><tbody>';
	foreach ( $files as $file => $desc ) {
		$path = $base . $file;
		$link = $uri . $file . '?ver=' . ( defined( 'DELTA_PORTS_VERSION' ) ? DELTA_PORTS_VERSION : '1' );
		$ok   = file_exists( $path ) ? '✓' : 'missing';
		echo '<tr><td><code>assets/css/' . esc_html( $file ) . '</code> ' . esc_html( $ok ) . '</td>';
		echo '<td>' . esc_html( $desc ) . '</td>';
		echo '<td><a href="' . esc_url( $link ) . '" target="_blank" rel="noopener">View in browser</a></td></tr>';
	}
	echo '</tbody></table>';
	echo '<p style="margin-top:1.25rem"><strong>Folder path:</strong><br><code>' . esc_html( $base ) . '</code></p>';
	echo '<p><strong>After editing:</strong> hard-refresh the site (Ctrl+F5). To bust cache, bump <code>DELTA_PORTS_VERSION</code> in <code>functions.php</code>.</p>';
	echo '<p><a class="button button-primary" href="' . esc_url( admin_url( 'customize.php?autofocus[section]=custom_css' ) ) . '">Open Additional CSS</a> ';
	echo '<a class="button" href="' . esc_url( admin_url( 'site-editor.php' ) ) . '">Site Editor</a></p>';
	echo '</div>';
}

/* Font preload handled once in enqueue.php (performance). */

/**
 * Allow video/source/SVG needed for marketing page HTML (WP KSES strips them by default for non-admins / CLI).
 *
 * @param array $tags Allowed tags.
 * @return array
 */
function delta_ports_allow_kses_media( $tags ) {
	$tags['video'] = array(
		'autoplay'    => true,
		'controls'    => true,
		'height'      => true,
		'loop'        => true,
		'muted'       => true,
		'poster'      => true,
		'preload'     => true,
		'src'         => true,
		'width'       => true,
		'class'       => true,
		'playsinline' => true,
		'id'          => true,
		'style'       => true,
	);
	$tags['source'] = array(
		'src'   => true,
		'type'  => true,
		'media' => true,
	);
	$tags['svg'] = array(
		'class'       => true,
		'aria-hidden' => true,
		'width'       => true,
		'height'      => true,
		'viewbox'     => true,
		'fill'        => true,
		'xmlns'       => true,
		'role'        => true,
		'focusable'   => true,
	);
	$tags['path'] = array(
		'd'            => true,
		'fill'         => true,
		'stroke'       => true,
		'stroke-width' => true,
		'stroke-linecap' => true,
		'stroke-linejoin' => true,
		'opacity'      => true,
	);
	$tags['circle'] = array(
		'cx'     => true,
		'cy'     => true,
		'r'      => true,
		'fill'   => true,
		'stroke' => true,
		'stroke-width' => true,
		'opacity' => true,
	);
	$tags['rect'] = array(
		'x'      => true,
		'y'      => true,
		'width'  => true,
		'height' => true,
		'rx'     => true,
		'ry'     => true,
		'fill'   => true,
		'stroke' => true,
		'stroke-width' => true,
	);
	return $tags;
}
add_filter( 'wp_kses_allowed_html', 'delta_ports_allow_kses_media', 10, 1 );

/**
 * Yoast breadcrumbs wrapper for patterns if needed.
 */
function delta_ports_breadcrumb() {
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<nav class="dp-breadcrumb" aria-label="Breadcrumb">', '</nav>' );
	}
}
