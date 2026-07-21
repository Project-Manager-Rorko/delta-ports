<?php
/**
 * Favicon, SEO meta titles/descriptions, front-end performance.
 *
 * @package Delta_Ports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * SEO map: slug => array( title, description ).
 *
 * @return array
 */
function delta_ports_seo_map() {
	return array(
		'home-upgrade'                 => array(
			'Delta Ports | Terminal Operations & Port Logistics',
			'Delta Ports provides deep-water terminal infrastructure and port logistics powering India\'s maritime trade.',
		),
		'home'                         => array(
			'Delta Ports | Terminal Operations & Port Logistics',
			'Delta Ports provides deep-water terminal infrastructure and port logistics powering India\'s maritime trade.',
		),
		'about-us'                     => array(
			'About Delta Ports | Port Terminal Operations India',
			'Learn about Delta Ports — port-led infrastructure and terminal operations across India.',
		),
		'leadership'                   => array(
			'Delta Ports Leadership | Vision & Management Team',
			'Meet the Delta Ports leadership team driving terminal excellence and governance.',
		),
		'led-operation-new'            => array(
			'Port-Led Operations | Delta Ports Terminal Services',
			'Integrated terminal operations across India\'s strategic maritime gateways.',
		),
		'led-operations'               => array(
			'Port-Led Operations | Delta Ports Terminal Services',
			'Terminal network, cargo capabilities, and multimodal port operations.',
		),
		'cargo-handling-capabilities'  => array(
			'Cargo Handling Services | Delta Ports Infrastructure',
			'Cargo handling, yard facilities, equipment, storage, and safety infrastructure.',
		),
		'integrated-port-logistics'    => array(
			'Integrated Port Logistics | Rail & Road Connectivity',
			'Road and rail connectivity for seamless cargo movement from Delta Ports terminals.',
		),
		'sustainability'               => array(
			'Delta Ports Sustainability | Safe & Responsible Operations',
			'Lower-carbon terminal operations, safety, and environmental compliance at Delta Ports.',
		),
		'contact-us'                   => array(
			'Contact Delta Ports | Mangalore, Bangalore & Dammam',
			'Contact Delta Ports offices or join our talent network.',
		),
		'privacy-policy'               => array(
			'Privacy Policy - Delta Ports',
			'Privacy policy for the Delta Ports website.',
		),
		'terms-conditions'             => array(
			'Terms & Conditions - Delta Ports',
			'Terms and conditions for using the Delta Ports website.',
		),
		'blog'                         => array(
			'Blog - Delta Ports',
			'Media updates and news from Delta Ports and Group Delta.',
		),
	);
}

/**
 * Apply SEO title/description to a post (Yoast + theme meta).
 *
 * @param int    $post_id Post ID.
 * @param string $title   SEO title.
 * @param string $desc    Meta description.
 */
function delta_ports_apply_seo( $post_id, $title, $desc ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		return;
	}
	if ( $title ) {
		update_post_meta( $post_id, '_yoast_wpseo_title', $title );
		update_post_meta( $post_id, '_dp_seo_title', $title );
	}
	if ( $desc ) {
		update_post_meta( $post_id, '_yoast_wpseo_metadesc', $desc );
		update_post_meta( $post_id, '_dp_seo_desc', $desc );
	}
}

/**
 * Ensure all known pages have SEO meta.
 */
function delta_ports_ensure_all_seo() {
	$map = delta_ports_seo_map();

	// Front page by ID (slug may be home-upgrade).
	$front = (int) get_option( 'page_on_front' );
	if ( $front ) {
		$seo = $map['home-upgrade'];
		delta_ports_apply_seo( $front, $seo[0], $seo[1] );
	}

	foreach ( $map as $slug => $seo ) {
		$page = get_page_by_path( $slug );
		if ( $page ) {
			delta_ports_apply_seo( $page->ID, $seo[0], $seo[1] );
		}
	}

	// Blog posts without meta get a sensible default.
	$posts = get_posts(
		array(
			'post_type'      => 'post',
			'posts_per_page' => 50,
			'post_status'    => 'publish',
			'fields'         => 'ids',
		)
	);
	foreach ( $posts as $pid ) {
		if ( ! get_post_meta( $pid, '_yoast_wpseo_metadesc', true ) ) {
			$t = get_the_title( $pid ) . ' - Delta Ports';
			$d = wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', $pid ) ), 28, '…' );
			if ( ! $d ) {
				$d = 'News and updates from Delta Ports.';
			}
			delta_ports_apply_seo( $pid, $t, $d );
		}
	}
}

/**
 * Document title fallback when Yoast title empty / not applied.
 *
 * @param array $parts Title parts.
 * @return array
 */
function delta_ports_document_title_parts( $parts ) {
	if ( is_singular() ) {
		$custom = get_post_meta( get_queried_object_id(), '_dp_seo_title', true );
		if ( ! $custom ) {
			$custom = get_post_meta( get_queried_object_id(), '_yoast_wpseo_title', true );
		}
		if ( $custom ) {
			// Yoast may store %%title%% templates; only use plain titles.
			if ( false === strpos( $custom, '%%' ) ) {
				$parts['title'] = $custom;
				unset( $parts['site'] );
				unset( $parts['tagline'] );
			}
		}
	} elseif ( is_front_page() ) {
		$parts['title'] = 'Delta Ports | Terminal Operations & Port Logistics';
		unset( $parts['tagline'] );
	}
	return $parts;
}
add_filter( 'document_title_parts', 'delta_ports_document_title_parts', 20 );

/**
 * Output meta description if Yoast did not.
 */
function delta_ports_meta_description_fallback() {
	if ( defined( 'WPSEO_VERSION' ) ) {
		// Yoast active — still ensure description exists for current singular.
		if ( is_singular() ) {
			$desc = get_post_meta( get_queried_object_id(), '_yoast_wpseo_metadesc', true );
			if ( ! $desc ) {
				$desc = get_post_meta( get_queried_object_id(), '_dp_seo_desc', true );
			}
			if ( $desc ) {
				// Yoast should print it; if missing from head filters, we add once.
				// Avoid duplicate: only when empty in Yoast storage we set meta above.
			}
		}
		return;
	}

	$desc = '';
	if ( is_singular() ) {
		$desc = get_post_meta( get_queried_object_id(), '_dp_seo_desc', true );
		if ( ! $desc ) {
			$desc = get_post_meta( get_queried_object_id(), '_yoast_wpseo_metadesc', true );
		}
	} elseif ( is_front_page() ) {
		$desc = 'Delta Ports provides deep-water terminal infrastructure and port logistics powering India\'s maritime trade.';
	}
	if ( $desc ) {
		echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $desc ) ) . '" />' . "\n";
	}
}
add_action( 'wp_head', 'delta_ports_meta_description_fallback', 1 );

/**
 * Favicon / apple-touch icons from theme assets (always available).
 */
function delta_ports_favicon_links() {
	$base = DELTA_PORTS_URI . '/assets/images/';
	$ico32  = $base . 'cropped-delta-fav-icon-32x32.png';
	$ico180 = $base . 'cropped-delta-fav-icon-180x180.png';
	$ico192 = $base . 'cropped-delta-fav-icon-192x192.png';
	$ico270 = $base . 'cropped-delta-fav-icon-270x270.png';

	// If WP site icon is set, core already prints icons — still add apple-touch for consistency.
	echo '<link rel="icon" href="' . esc_url( $ico32 ) . '" sizes="32x32" />' . "\n";
	echo '<link rel="icon" href="' . esc_url( $ico192 ) . '" sizes="192x192" />' . "\n";
	echo '<link rel="apple-touch-icon" href="' . esc_url( $ico180 ) . '" />' . "\n";
	echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url( $ico180 ) . '" />' . "\n";
	echo '<meta name="msapplication-TileImage" content="' . esc_url( $ico270 ) . '" />' . "\n";
	echo '<link rel="shortcut icon" href="' . esc_url( $ico32 ) . '" />' . "\n";
}
add_action( 'wp_head', 'delta_ports_favicon_links', 2 );

/**
 * Import theme favicon into Media Library and set as Site Icon (once).
 *
 * @return int Attachment ID or 0.
 */
function delta_ports_ensure_site_icon() {
	$existing = (int) get_option( 'site_icon' );
	if ( $existing > 0 && get_post( $existing ) ) {
		return $existing;
	}

	$file = DELTA_PORTS_DIR . '/assets/images/cropped-delta-fav-icon-270x270.png';
	if ( ! file_exists( $file ) ) {
		$file = DELTA_PORTS_DIR . '/assets/images/cropped-delta-fav-icon-192x192.png';
	}
	if ( ! file_exists( $file ) ) {
		return 0;
	}

	// Reuse if we already imported.
	$found = get_posts(
		array(
			'post_type'      => 'attachment',
			'posts_per_page' => 1,
			'post_status'    => 'inherit',
			'meta_key'       => '_delta_ports_favicon',
			'meta_value'     => '1',
			'fields'         => 'ids',
		)
	);
	if ( $found ) {
		update_option( 'site_icon', (int) $found[0] );
		return (int) $found[0];
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$upload = wp_upload_bits( basename( $file ), null, file_get_contents( $file ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	if ( ! empty( $upload['error'] ) ) {
		return 0;
	}

	$filetype  = wp_check_filetype( $upload['file'], null );
	$attach_id = wp_insert_attachment(
		array(
			'post_mime_type' => $filetype['type'],
			'post_title'     => 'Delta Ports Favicon',
			'post_content'   => '',
			'post_status'    => 'inherit',
		),
		$upload['file']
	);
	if ( is_wp_error( $attach_id ) || ! $attach_id ) {
		return 0;
	}

	$meta = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
	wp_update_attachment_metadata( $attach_id, $meta );
	update_post_meta( $attach_id, '_delta_ports_favicon', '1' );
	update_option( 'site_icon', (int) $attach_id );

	return (int) $attach_id;
}

/**
 * Run favicon + SEO ensure on admin and once per day on front.
 */
function delta_ports_bootstrap_seo_favicon() {
	$flag = get_option( 'delta_ports_seo_favicon_v1' );
	if ( '1' === $flag && (int) get_option( 'site_icon' ) > 0 ) {
		return;
	}
	delta_ports_ensure_site_icon();
	delta_ports_ensure_all_seo();
	update_option( 'delta_ports_seo_favicon_v1', '1', true );
}
add_action( 'init', 'delta_ports_bootstrap_seo_favicon', 20 );

/**
 * Performance: strip emoji, embeds, bloat.
 */
function delta_ports_perf_cleanup() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'init', 'delta_ports_perf_cleanup' );

/**
 * Disable wp-embed on front.
 */
function delta_ports_deregister_embed() {
	if ( is_admin() ) {
		return;
	}
	wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'delta_ports_deregister_embed' );

/**
 * Resource hints: only self + nothing extra.
 *
 * @param array  $urls          URLs.
 * @param string $relation_type Type.
 * @return array
 */
function delta_ports_resource_hints( $urls, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		// Drop remote dns-prefetch noise for speed.
		$urls = array_filter(
			(array) $urls,
			function ( $u ) {
				return is_string( $u ) && false === strpos( $u, 'unpkg.com' ) && false === strpos( $u, 'googleapis' ) && false === strpos( $u, 'gstatic' );
			}
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'delta_ports_resource_hints', 10, 2 );

/**
 * Videos: force preload=metadata for faster first paint.
 *
 * @param string $content Content.
 * @return string
 */
function delta_ports_video_perf( $content ) {
	if ( false === strpos( $content, '<video' ) ) {
		return $content;
	}
	// Ensure preload="metadata" (or none) and muted playsinline stay.
	$content = preg_replace( '/<video(?![^>]*\bpreload=)/i', '<video preload="metadata"', $content );
	return $content;
}
add_filter( 'the_content', 'delta_ports_video_perf', 20 );

/**
 * Lazy-load images missing loading attr (except first hero if needed).
 *
 * @param string $content Content.
 * @return string
 */
function delta_ports_img_lazy( $content ) {
	if ( false === strpos( $content, '<img' ) ) {
		return $content;
	}
	$content = preg_replace_callback(
		'/<img\b([^>]*)>/i',
		function ( $m ) {
			$attrs = $m[1];
			if ( false !== stripos( $attrs, 'loading=' ) ) {
				return $m[0];
			}
			// Skip tiny tracking pixels.
			if ( preg_match( '/width=["\']1["\']/', $attrs ) ) {
				return $m[0];
			}
			return '<img loading="lazy" decoding="async"' . $attrs . '>';
		},
		$content
	);
	return $content;
}
add_filter( 'the_content', 'delta_ports_img_lazy', 25 );
