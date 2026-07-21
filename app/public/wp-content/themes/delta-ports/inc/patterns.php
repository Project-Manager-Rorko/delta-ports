<?php
/**
 * Register Delta Ports block patterns (insertable in Gutenberg).
 *
 * @package Delta_Ports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Pattern category.
 */
function delta_ports_register_pattern_category() {
	register_block_pattern_category(
		'delta-ports',
		array( 'label' => __( 'Delta Ports', 'delta-ports' ) )
	);
}
add_action( 'init', 'delta_ports_register_pattern_category' );

/**
 * Register patterns from seeded page builders (core blocks only).
 */
function delta_ports_register_patterns() {
	if ( ! function_exists( 'delta_ports_content_home' ) ) {
		return;
	}

	$patterns = array(
		array(
			'name'        => 'delta-ports/home',
			'title'       => __( 'Home page (full)', 'delta-ports' ),
			'description' => __( 'Full marketing homepage as pure Gutenberg blocks.', 'delta-ports' ),
			'content'     => delta_ports_content_home(),
		),
		array(
			'name'        => 'delta-ports/about',
			'title'       => __( 'About page (full)', 'delta-ports' ),
			'description' => __( 'About page content as pure Gutenberg blocks.', 'delta-ports' ),
			'content'     => delta_ports_content_about(),
		),
		array(
			'name'        => 'delta-ports/leadership',
			'title'       => __( 'Leadership page (full)', 'delta-ports' ),
			'description' => __( 'Leadership team page as pure Gutenberg blocks.', 'delta-ports' ),
			'content'     => delta_ports_content_leadership(),
		),
		array(
			'name'        => 'delta-ports/port-led',
			'title'       => __( 'Port-Led Operations (full)', 'delta-ports' ),
			'description' => __( 'Port-led operations page as pure Gutenberg blocks.', 'delta-ports' ),
			'content'     => delta_ports_content_port_led(),
		),
		array(
			'name'        => 'delta-ports/cargo',
			'title'       => __( 'Cargo Handling (full)', 'delta-ports' ),
			'description' => __( 'Cargo handling page as pure Gutenberg blocks.', 'delta-ports' ),
			'content'     => delta_ports_content_cargo(),
		),
		array(
			'name'        => 'delta-ports/logistics',
			'title'       => __( 'Integrated Port Logistics (full)', 'delta-ports' ),
			'description' => __( 'Logistics page as pure Gutenberg blocks.', 'delta-ports' ),
			'content'     => delta_ports_content_logistics(),
		),
		array(
			'name'        => 'delta-ports/sustainability',
			'title'       => __( 'Sustainability (full)', 'delta-ports' ),
			'description' => __( 'Sustainability page as pure Gutenberg blocks.', 'delta-ports' ),
			'content'     => delta_ports_content_sustainability(),
		),
		array(
			'name'        => 'delta-ports/contact',
			'title'       => __( 'Contact (full)', 'delta-ports' ),
			'description' => __( 'Contact page as pure Gutenberg blocks.', 'delta-ports' ),
			'content'     => delta_ports_content_contact(),
		),
	);

	foreach ( $patterns as $pattern ) {
		register_block_pattern(
			$pattern['name'],
			array(
				'title'       => $pattern['title'],
				'description' => $pattern['description'],
				'categories'  => array( 'delta-ports' ),
				'content'     => $pattern['content'],
			)
		);
	}
}
add_action( 'init', 'delta_ports_register_patterns', 20 );
