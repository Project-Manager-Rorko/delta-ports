<?php
/**
 * Delta Ports block theme functions.
 *
 * @package Delta_Ports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DELTA_PORTS_VERSION', '4.5.48' );
define( 'DELTA_PORTS_DIR', get_template_directory() );
define( 'DELTA_PORTS_URI', get_template_directory_uri() );

require_once DELTA_PORTS_DIR . '/inc/setup.php';
require_once DELTA_PORTS_DIR . '/inc/enqueue.php';
require_once DELTA_PORTS_DIR . '/inc/seo-performance.php';
require_once DELTA_PORTS_DIR . '/inc/patterns.php';
require_once DELTA_PORTS_DIR . '/inc/seed-content.php';
require_once DELTA_PORTS_DIR . '/inc/staging-guard.php';
require_once DELTA_PORTS_DIR . '/inc/redirects.php';

