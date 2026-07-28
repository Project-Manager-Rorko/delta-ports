<?php
/**
 * Canonical redirects — keep the linked Port-Led Operations page canonical
 * and 301 the stale duplicate to it. Reversible: delete this file + require.
 *
 * @package Delta_Ports
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function delta_ports_canonical_redirects() {
	if ( is_admin() ) {
		return;
	}
	if ( is_page( 'led-operations' ) ) {
		wp_safe_redirect( home_url( '/led-operation-new/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'delta_ports_canonical_redirects' );
