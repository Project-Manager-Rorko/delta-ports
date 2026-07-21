<?php
/**
 * Page content builders — pure Gutenberg core blocks only.
 * No Custom HTML blocks: fully editable in the Block Editor.
 *
 * @package Delta_Ports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme image URL.
 *
 * @param string $rel Path under assets/images.
 * @return string
 */
function delta_ports_img( $rel ) {
	return esc_url( DELTA_PORTS_URI . '/assets/images/' . ltrim( $rel, '/' ) );
}

require_once DELTA_PORTS_DIR . '/inc/gutenberg-pages.php';
require_once DELTA_PORTS_DIR . '/inc/wwa-page.php';
