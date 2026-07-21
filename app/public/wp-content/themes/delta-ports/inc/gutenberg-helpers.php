<?php
/**
 * Pure Gutenberg block markup helpers (no Custom HTML blocks).
 * Editors can change text/images/links in the Block Editor without code.
 *
 * @package Delta_Ports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * JSON attrs for block comment.
 *
 * @param array $attrs Attributes.
 * @return string
 */
function delta_ports_gb_json( $attrs ) {
	if ( empty( $attrs ) ) {
		return '';
	}
	return ' ' . wp_json_encode( $attrs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
}

/**
 * Group block.
 *
 * @param array  $attrs Attributes.
 * @param string $inner Inner blocks.
 * @param string $tag   HTML tag.
 * @return string
 */
function delta_ports_gb_group( $attrs, $inner, $tag = 'div' ) {
	// Sections: full-width background + 1400px inner content.
	if ( empty( $attrs['align'] ) ) {
		$attrs['align'] = 'full';
	}
	if ( empty( $attrs['layout'] ) ) {
		$attrs['layout'] = array(
			'type'        => 'constrained',
			'contentSize' => '1400px',
			'wideSize'    => '1400px',
		);
	} elseif ( is_array( $attrs['layout'] ) ) {
		if ( empty( $attrs['layout']['contentSize'] ) ) {
			$attrs['layout']['contentSize'] = '1400px';
		}
		if ( empty( $attrs['layout']['wideSize'] ) ) {
			$attrs['layout']['wideSize'] = '1400px';
		}
		if ( empty( $attrs['layout']['type'] ) ) {
			$attrs['layout']['type'] = 'constrained';
		}
	}
	$class = 'wp-block-group';
	if ( ! empty( $attrs['className'] ) ) {
		$class .= ' ' . $attrs['className'];
	}
	if ( ! empty( $attrs['align'] ) ) {
		$class .= ' align' . $attrs['align'];
	}
	$a = delta_ports_gb_json( $attrs );
	return "<!-- wp:group{$a} -->\n<{$tag} class=\"{$class}\">\n{$inner}</{$tag}>\n<!-- /wp:group -->\n\n";
}

/**
 * Heading block.
 *
 * @param string $text  Text.
 * @param int    $level 1-6.
 * @param array  $attrs Extra attrs.
 * @return string
 */
function delta_ports_gb_heading( $text, $level = 2, $attrs = array() ) {
	$attrs['level'] = (int) $level;
	$class          = 'wp-block-heading';
	if ( ! empty( $attrs['className'] ) ) {
		$class .= ' ' . $attrs['className'];
	}
	if ( ! empty( $attrs['textAlign'] ) ) {
		$class .= ' has-text-align-' . $attrs['textAlign'];
	}
	$a    = delta_ports_gb_json( $attrs );
	$tag  = 'h' . max( 1, min( 6, (int) $level ) );
	$text = esc_html( $text );
	return "<!-- wp:heading{$a} -->\n<{$tag} class=\"{$class}\">{$text}</{$tag}>\n<!-- /wp:heading -->\n\n";
}

/**
 * Paragraph block.
 *
 * @param string $text  Text (may contain basic entities).
 * @param array  $attrs Attrs.
 * @return string
 */
function delta_ports_gb_paragraph( $text, $attrs = array() ) {
	$class = '';
	if ( ! empty( $attrs['className'] ) ) {
		$class = ' class="' . esc_attr( $attrs['className'] ) . '"';
	}
	if ( ! empty( $attrs['textAlign'] ) ) {
		$class = ' class="has-text-align-' . esc_attr( $attrs['textAlign'] ) . ( ! empty( $attrs['className'] ) ? ' ' . esc_attr( $attrs['className'] ) : '' ) . '"';
	}
	$a = delta_ports_gb_json( $attrs );
	// Allow limited markup from trusted seed strings.
	return "<!-- wp:paragraph{$a} -->\n<p{$class}>{$text}</p>\n<!-- /wp:paragraph -->\n\n";
}

/**
 * Image block.
 *
 * @param string $url   URL.
 * @param string $alt   Alt.
 * @param array  $attrs Attrs.
 * @return string
 */
function delta_ports_gb_image( $url, $alt = '', $attrs = array() ) {
	$defaults = array(
		'sizeSlug'        => 'large',
		'linkDestination' => 'none',
	);
	$attrs    = array_merge( $defaults, $attrs );
	$class    = 'wp-block-image size-' . $attrs['sizeSlug'];
	if ( ! empty( $attrs['align'] ) ) {
		$class .= ' align' . $attrs['align'];
	}
	if ( ! empty( $attrs['className'] ) ) {
		$class .= ' ' . $attrs['className'];
	}
	$a   = delta_ports_gb_json( $attrs );
	$url = esc_url( $url );
	$alt = esc_attr( $alt );
	return "<!-- wp:image{$a} -->\n<figure class=\"{$class}\"><img src=\"{$url}\" alt=\"{$alt}\"/></figure>\n<!-- /wp:image -->\n\n";
}

/**
 * Buttons wrapper + one button.
 *
 * @param string $label Label.
 * @param string $url   URL.
 * @param array  $attrs Button attrs.
 * @return string
 */
function delta_ports_gb_button( $label, $url, $attrs = array() ) {
	$btn_class = 'wp-block-button';
	if ( ! empty( $attrs['className'] ) ) {
		$btn_class .= ' ' . $attrs['className'];
	}
	$a     = delta_ports_gb_json( $attrs );
	$label = esc_html( $label );
	$url   = esc_url( $url );
	$inner = "<!-- wp:button{$a} -->\n<div class=\"{$btn_class}\"><a class=\"wp-block-button__link wp-element-button\" href=\"{$url}\">{$label}</a></div>\n<!-- /wp:button -->\n";
	return "<!-- wp:buttons -->\n<div class=\"wp-block-buttons\">\n{$inner}</div>\n<!-- /wp:buttons -->\n\n";
}

/**
 * Multiple buttons.
 *
 * @param array $items Array of array(label, url, attrs).
 * @return string
 */
function delta_ports_gb_buttons( $items ) {
	$inner = '';
	foreach ( $items as $item ) {
		$label = $item[0];
		$url   = $item[1];
		$attrs = isset( $item[2] ) ? $item[2] : array();
		$btn_class = 'wp-block-button';
		if ( ! empty( $attrs['className'] ) ) {
			$btn_class .= ' ' . $attrs['className'];
		}
		$a     = delta_ports_gb_json( $attrs );
		$label = esc_html( $label );
		$url   = esc_url( $url );
		$inner .= "<!-- wp:button{$a} -->\n<div class=\"{$btn_class}\"><a class=\"wp-block-button__link wp-element-button\" href=\"{$url}\">{$label}</a></div>\n<!-- /wp:button -->\n";
	}
	return "<!-- wp:buttons -->\n<div class=\"wp-block-buttons\">\n{$inner}</div>\n<!-- /wp:buttons -->\n\n";
}

/**
 * Columns block.
 *
 * @param array $columns Array of inner HTML strings (one per column).
 * @param array $attrs   Columns attrs.
 * @return string
 */
function delta_ports_gb_columns( $columns, $attrs = array() ) {
	$class = 'wp-block-columns';
	if ( ! empty( $attrs['className'] ) ) {
		$class .= ' ' . $attrs['className'];
	}
	$a     = delta_ports_gb_json( $attrs );
	$inner = '';
	foreach ( $columns as $col ) {
		$col_attrs = array();
		$col_html  = $col;
		if ( is_array( $col ) ) {
			$col_attrs = isset( $col['attrs'] ) ? $col['attrs'] : array();
			$col_html  = $col['content'];
		}
		$cc = 'wp-block-column';
		if ( ! empty( $col_attrs['className'] ) ) {
			$cc .= ' ' . $col_attrs['className'];
		}
		$ca     = delta_ports_gb_json( $col_attrs );
		$inner .= "<!-- wp:column{$ca} -->\n<div class=\"{$cc}\">\n{$col_html}</div>\n<!-- /wp:column -->\n\n";
	}
	return "<!-- wp:columns{$a} -->\n<div class=\"{$class}\">\n{$inner}</div>\n<!-- /wp:columns -->\n\n";
}

/**
 * Cover block (image or video background).
 *
 * @param string $url    Image or video URL.
 * @param string $inner  Inner blocks.
 * @param array  $attrs  Attrs.
 * @return string
 */
function delta_ports_gb_cover( $url, $inner, $attrs = array() ) {
	$defaults = array(
		'url'             => $url,
		'dimRatio'        => 50,
		'overlayColor'    => 'bg-dark',
		'minHeight'       => 480,
		'minHeightUnit'   => 'px',
		'contentPosition' => 'bottom left',
		'isDark'          => true,
		'align'           => 'full',
		'backgroundType'  => 'image',
	);
	$attrs = array_merge( $defaults, $attrs );
	$class = 'wp-block-cover';
	if ( ! empty( $attrs['align'] ) ) {
		$class .= ' align' . $attrs['align'];
	}
	if ( ! empty( $attrs['className'] ) ) {
		$class .= ' ' . $attrs['className'];
	}
	if ( ! empty( $attrs['contentPosition'] ) ) {
		$class .= ' has-custom-content-position is-position-' . str_replace( ' ', '-', $attrs['contentPosition'] );
	}
	$dim   = (int) $attrs['dimRatio'];
	$min_h = (int) $attrs['minHeight'] . ( isset( $attrs['minHeightUnit'] ) ? $attrs['minHeightUnit'] : 'px' );
	$a     = delta_ports_gb_json( $attrs );
	$url   = esc_url( $url );
	$media = '';
	if ( ! empty( $attrs['backgroundType'] ) && 'video' === $attrs['backgroundType'] ) {
		$poster = ! empty( $attrs['poster'] ) ? esc_url( $attrs['poster'] ) : '';
		$media  = '<video class="wp-block-cover__video-background intrinsic-ignore" autoplay muted loop playsinline' . ( $poster ? ' poster="' . $poster . '"' : '' ) . ' src="' . $url . '"></video>';
	} else {
		$media = '<img class="wp-block-cover__image-background" alt="" src="' . $url . '" data-object-fit="cover"/>';
	}
	return "<!-- wp:cover{$a} -->\n<div class=\"{$class}\" style=\"min-height:{$min_h}\"><span aria-hidden=\"true\" class=\"wp-block-cover__background has-bg-dark-background-color has-background-dim-{$dim} has-background-dim\"></span>{$media}<div class=\"wp-block-cover__inner-container\">\n{$inner}</div></div>\n<!-- /wp:cover -->\n\n";
}

/**
 * List block.
 *
 * @param array  $items Items.
 * @param array  $attrs Attrs.
 * @return string
 */
function delta_ports_gb_list( $items, $attrs = array() ) {
	$a     = delta_ports_gb_json( $attrs );
	$inner = '';
	foreach ( $items as $item ) {
		$inner .= '<li>' . esc_html( $item ) . '</li>';
	}
	return "<!-- wp:list{$a} -->\n<ul class=\"wp-block-list\">{$inner}</ul>\n<!-- /wp:list -->\n\n";
}

/**
 * Separator.
 *
 * @return string
 */
function delta_ports_gb_separator() {
	return "<!-- wp:separator -->\n<hr class=\"wp-block-separator has-alpha-channel-opacity\"/>\n<!-- /wp:separator -->\n\n";
}

/**
 * Spacer.
 *
 * @param string $height CSS height.
 * @return string
 */
function delta_ports_gb_spacer( $height = '40px' ) {
	$attrs = array( 'height' => $height );
	$a     = delta_ports_gb_json( $attrs );
	return "<!-- wp:spacer{$a} -->\n<div style=\"height:{$height}\" aria-hidden=\"true\" class=\"wp-block-spacer\"></div>\n<!-- /wp:spacer -->\n\n";
}

/**
 * Inner page hero as pure blocks (Cover + heading + intro).
 *
 * @param string $title Title.
 * @param string $intro Intro.
 * @param string $image Image filename under assets/images.
 * @return string
 */
function delta_ports_gb_page_hero( $title, $intro, $image ) {
	$url  = delta_ports_img( $image );
	$inner = delta_ports_gb_paragraph(
		'<a href="/">Home</a> / ' . esc_html( $title ),
		array( 'className' => 'dp-gb-crumb' )
	);
	$inner .= delta_ports_gb_heading( $title, 1, array( 'className' => 'dp-gb-hero-title' ) );
	$inner .= delta_ports_gb_paragraph( esc_html( $intro ), array( 'className' => 'dp-gb-hero-intro' ) );
	return delta_ports_gb_cover(
		$url,
		$inner,
		array(
			'className'       => 'dp-gb-page-hero aw-inner-hero',
			'minHeight'       => 420,
			'dimRatio'        => 60,
			'contentPosition' => 'bottom left',
			'align'           => 'full',
		)
	);
}

/**
 * Simple CTA section as blocks.
 *
 * @param string $title Title.
 * @param string $text  Text.
 * @param string $btn   Button label.
 * @param string $url   Button URL.
 * @return string
 */
function delta_ports_gb_cta( $title, $text, $btn = 'Contact Us', $url = '/contact-us/' ) {
	$inner  = delta_ports_gb_heading( $title, 2 );
	$inner .= delta_ports_gb_paragraph( esc_html( $text ) );
	$inner .= delta_ports_gb_button( $btn, $url, array( 'className' => 'is-style-fill' ) );
	return delta_ports_gb_group(
		array(
			'align'     => 'full',
			'className' => 'dp-gb-cta aw-section aw-section--dark',
			'layout'    => array( 'type' => 'constrained' ),
		),
		$inner
	);
}

/**
 * FAQ as details is not a core block — use Q/A groups with headings + paragraphs.
 *
 * @param array $faqs array( question => answer ).
 * @return string
 */
function delta_ports_gb_faq( $faqs ) {
	$inner  = delta_ports_gb_heading( 'Frequently asked questions', 2 );
	foreach ( $faqs as $q => $a ) {
		$card  = delta_ports_gb_heading( $q, 3, array( 'className' => 'dp-gb-faq-q' ) );
		$card .= delta_ports_gb_paragraph( esc_html( $a ), array( 'className' => 'dp-gb-faq-a' ) );
		$inner .= delta_ports_gb_group(
			array(
				'className' => 'dp-gb-faq-item',
				'layout'    => array( 'type' => 'default' ),
			),
			$card
		);
	}
	return delta_ports_gb_group(
		array(
			'className' => 'dp-gb-faq aw-section',
			'layout'    => array( 'type' => 'constrained' ),
		),
		$inner
	);
}
