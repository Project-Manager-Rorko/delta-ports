<?php
/**
 * Operations / Sustainability / Contact page content — live design parity.
 * Uses hybrid HTML for complex layouts (KSES-safe: no nested source/svg).
 *
 * @package Delta_Ports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme image URL if file exists, else fallback.
 *
 * @param string $file     Filename.
 * @param string $fallback Fallback filename.
 * @return string
 */
function delta_ports_img_or( $file, $fallback = 'our-operation-delta-port1.webp' ) {
	$path = DELTA_PORTS_DIR . '/assets/images/' . ltrim( $file, '/' );
	if ( file_exists( $path ) ) {
		return delta_ports_img( $file );
	}
	return delta_ports_img( $fallback );
}

/**
 * Bullet list HTML.
 *
 * @param array $items Items.
 * @return string
 */
function delta_ports_html_bullets( $items ) {
	$html = '<ul class="dp-ops-bullets">';
	foreach ( $items as $item ) {
		$html .= '<li>' . esc_html( $item ) . '</li>';
	}
	$html .= '</ul>';
	return $html;
}

/**
 * Check list HTML.
 *
 * @param array $items Items.
 * @return string
 */
function delta_ports_html_checks( $items ) {
	$html = '<ul class="dp-ops-checks">';
	foreach ( $items as $item ) {
		$html .= '<li>' . esc_html( $item ) . '</li>';
	}
	$html .= '</ul>';
	return $html;
}

/**
 * FAQ accordion HTML.
 *
 * @param array  $faqs  Q=>A.
 * @param string $intro Optional left intro.
 * @return string
 */
function delta_ports_html_faq( $faqs, $intro = '' ) {
	$items = '';
	foreach ( $faqs as $q => $a ) {
		// Smooth accordion: button + panel (JS toggles .is-open); CSS grid-rows animation.
		$items .= '<div class="dp-ops-faq__item">'
			. '<button type="button" class="dp-ops-faq__q" aria-expanded="false">'
			. '<span>' . esc_html( $q ) . '</span>'
			. '</button>'
			. '<div class="dp-ops-faq__a" role="region">'
			. '<div class="dp-ops-faq__a-inner"><p>' . esc_html( $a ) . '</p></div>'
			. '</div>'
			. '</div>';
	}
	$left = $intro
		? '<div class="dp-ops-faq__intro"><h2>Frequently asked questions</h2><p>' . esc_html( $intro ) . '</p></div>'
		: '<div class="dp-ops-faq__intro"><h2>Frequently asked questions</h2></div>';
	return '<!-- wp:html -->
<section class="dp-ops-faq">
	<div class="dp-ops-faq__inner">
		' . $left . '
		<div class="dp-ops-faq__list">' . $items . '</div>
	</div>
</section>
<!-- /wp:html -->
';
}

/**
 * Inner page hero (full-bleed image + breadcrumb + title + lead).
 *
 * @param string $crumb Current page label.
 * @param string $title H1.
 * @param string $lead  Intro text.
 * @param string $image Image filename.
 * @return string
 */
function delta_ports_ops_hero( $crumb, $title, $lead, $image ) {
	$url = delta_ports_img_or( $image, 'port-led-operation-new-banner-img.webp' );
	return '<!-- wp:html -->
<section class="dp-ops-hero" style="background-image:url(\'' . esc_url( $url ) . '\')">
	<div class="dp-ops-hero__overlay" aria-hidden="true"></div>
	<div class="dp-ops-hero__inner">
		<nav class="dp-ops-hero__crumb" aria-label="Breadcrumb"><a href="/">Home</a><span aria-hidden="true">›</span><span>' . esc_html( $crumb ) . '</span></nav>
		<h1>' . esc_html( $title ) . '</h1>
		<p class="dp-ops-hero__lead">' . esc_html( $lead ) . '</p>
	</div>
</section>
<!-- /wp:html -->
';
}

/**
 * Port-led operations — matches live screenshot.
 *
 * @return string
 */
function delta_ports_content_port_led() {
	// Prefer newest banner from live reference; fall back to earlier assets.
	if ( file_exists( DELTA_PORTS_DIR . '/assets/images/port-led-operation-newer-banner-img-scaled.webp' ) ) {
		$hero_img = 'port-led-operation-newer-banner-img-scaled.webp';
	} elseif ( file_exists( DELTA_PORTS_DIR . '/assets/images/PLO-banner-scaled.webp' ) ) {
		$hero_img = 'PLO-banner-scaled.webp';
	} else {
		$hero_img = 'port-led-operation-new-banner-img.webp';
	}
	// Live parity (vipaccounts Elementor post-4919):
	// Network map = backgrounlocation.webp | Mormugao = new-delta-port-new1.webp | EQ-3 = new-delta-port-new2.webp
	$map      = delta_ports_img_or( 'backgrounlocation.webp', 'empowering-with-india.png' );
	$morm     = delta_ports_img_or( 'new-delta-port-new1.webp', 'terminal-portfolio-new-img.webp' );
	$eq3      = delta_ports_img_or( 'new-delta-port-new2.webp', 'our-operation-delta-port3.webp' );
	$cap1     = delta_ports_img_or( 'delta-port-new-page4.webp', 'our-operation-delta-port1.webp' );
	$cap2     = delta_ports_img_or( 'delta-port-new-page5.webp', 'our-operation-delta-port2.webp' );
	$cap3     = delta_ports_img_or( 'delta-port-new-page6.webp', 'our-operation-delta-port3.webp' );

	$out  = delta_ports_ops_hero(
		'Port-Led Operation',
		"Integrated Terminal Operations Across India's Strategic Maritime Gateways",
		"Delta Ports delivers terminal operations, cargo handling, warehousing, vessel services, and multimodal logistics through strategically located terminal assets on India's East and West Coasts.",
		$hero_img
	);

	// Stats strip.
	$out .= '<!-- wp:html -->
<section class="dp-ops-stats">
	<div class="dp-ops-stats__inner">
		<h2>A Growing Terminal Network Built For Modern Trade</h2>
		<div class="dp-ops-stats__grid">
			<div class="dp-ops-stats__card"><strong>2</strong><span>Terminal Assets</span></div>
			<div class="dp-ops-stats__card"><strong>E&amp;W</strong><span>Coast Presence</span></div>
			<div class="dp-ops-stats__card"><strong>Multi</strong><span>Cargo Handling</span></div>
			<div class="dp-ops-stats__card"><strong>24/7</strong><span>Operations</span></div>
		</div>
	</div>
</section>
<!-- /wp:html -->
';

	// Terminal network.
	$out .= '<!-- wp:html -->
<section class="dp-ops-section">
	<div class="dp-ops-section__inner dp-ops-network">
		<div class="dp-ops-network__copy">
			<h2>Our Terminal Network</h2>
			<p>Delta Ports operates strategic terminal assets across India\'s east and west coasts, forming a robust maritime infrastructure backbone. Our locations are specifically chosen to support optimal cargo movement, efficient vessel operations, secure storage, and seamless multimodal logistics connectivity.</p>
			<a class="dp-ops-network__link" href="#mormugao"><span>Mormugao, Goa</span><em>West Coast Multi-Cargo Gateway</em><span class="dp-ops-network__arrow" aria-hidden="true">›</span></a>
			<a class="dp-ops-network__link" href="#eq3"><span>Visakhapatnam (Vizag)</span><em>East Coast Operations &amp; Maintenance</em><span class="dp-ops-network__arrow" aria-hidden="true">›</span></a>
		</div>
		<div class="dp-ops-network__map">
			<img src="' . esc_url( $map ) . '" alt="India terminal network map" loading="lazy" decoding="async" />
		</div>
	</div>
</section>
<!-- /wp:html -->
';

	// Mormugao.
	$out .= '<!-- wp:html -->
<section class="dp-ops-section dp-ops-section--soft" id="mormugao">
	<div class="dp-ops-section__inner">
		<div class="dp-ops-terminal">
			<figure class="dp-ops-terminal__media"><img src="' . esc_url( $morm ) . '" alt="Mormugao Terminal" loading="lazy" decoding="async" /></figure>
			<div class="dp-ops-terminal__card">
				<p class="dp-ops-kicker">WEST COAST GATEWAY</p>
				<h2>Mormugao Terminal</h2>
				<p>Strategically positioned on India\'s west coast, supporting bulk cargo, containerized cargo, and general operations with integrated logistics infrastructure.</p>
				<div class="dp-ops-metrics">
					<div><span>Berths</span><strong>10 &amp; 11</strong></div>
					<div><span>Berth Length</span><strong>520 m</strong></div>
					<div><span>Draft</span><strong>12.80 m</strong></div>
					<div><span>Open Storage</span><strong>116k sq.m</strong></div>
					<div><span>Covered</span><strong>17.4k sq.m</strong></div>
				</div>
				<div class="dp-ops-tags-row">
					<div>
						<h3>Major Imports</h3>
						<div class="dp-ops-tags"><span>Limestone</span><span>Bauxite</span><span>Fertilizers</span><span>Iron Ore</span><span>Gypsum</span></div>
					</div>
					<div>
						<h3>Major Exports</h3>
						<div class="dp-ops-tags"><span>Iron Ore</span><span>Steel Coils</span><span>Steel slabs</span><span>CR/HR Coils</span><span>Pig Iron</span><span>Molasses</span></div>
					</div>
				</div>
			</div>
		</div>
		<h2 class="dp-ops-center-title">Operational Capabilities</h2>
		<div class="dp-ops-cap-grid">
			<article class="dp-ops-cap-card">
				<img src="' . esc_url( $cap1 ) . '" alt="Container Operations" loading="lazy" decoding="async" />
				<div>
					<h3>Container Operations</h3>
					<p class="dp-ops-cap-meta">0.15 Million TEU Capacity</p>
					' . delta_ports_html_checks( array( 'Dedicated Container Infrastructure', 'Container Yard Facilities', 'Reach Stackers & Empty Handlers', 'Rail Connectivity & Customs' ) ) . '
				</div>
			</article>
			<article class="dp-ops-cap-card">
				<img src="' . esc_url( $cap2 ) . '" alt="Bulk Cargo Operations" loading="lazy" decoding="async" />
				<div>
					<h3>Bulk Cargo Operations</h3>
					<p class="dp-ops-cap-meta">6 Million MT Capacity</p>
					' . delta_ports_html_checks( array( 'Mobile Harbour Cranes', 'Railway Sidings', 'Fertilizer Handling', 'Project Cargo Handling' ) ) . '
				</div>
			</article>
			<article class="dp-ops-cap-card">
				<img src="' . esc_url( $cap3 ) . '" alt="Storage & Distribution" loading="lazy" decoding="async" />
				<div>
					<h3>Storage &amp; Distribution</h3>
					' . delta_ports_html_checks( array( 'Open Storage Yards', 'Covered Warehousing', 'Container Storage', 'Domestic Distribution Support' ) ) . '
				</div>
			</article>
		</div>
	</div>
</section>
<!-- /wp:html -->
';

	// EQ-3.
	$out .= '<!-- wp:html -->
<section class="dp-ops-section" id="eq3">
	<div class="dp-ops-section__inner">
		<div class="dp-ops-terminal">
			<figure class="dp-ops-terminal__media"><img src="' . esc_url( $eq3 ) . '" alt="EQ-3 Terminal Visakhapatnam" loading="lazy" decoding="async" /></figure>
			<div class="dp-ops-terminal__card">
				<p class="dp-ops-kicker">EAST COAST SPECIALIZED TERMINAL</p>
				<h2>EQ-3 Terminal</h2>
				<p>A dedicated operation and maintenance terminal in Visakhapatnam focused on clean bulk commodities, agricultural cargo, and industrial products.</p>
				<div class="dp-ops-metrics">
					<div><span>Contract</span><strong>10-Year O&amp;M</strong></div>
					<div><span>Crane Capacity</span><strong>120 Ton</strong></div>
					<div><span>Backup Area</span><strong>1.43 Acres</strong></div>
					<div><span>Expansion Land</span><strong>2-3 Acres</strong></div>
				</div>
				<div class="dp-ops-tags-row">
					<div>
						<h3>Clean Bulk Expertise</h3>
						<p class="dp-ops-soft">Specialized handling protocols to maintain commodity integrity for sensitive agricultural goods.</p>
						<div class="dp-ops-tags"><span>Rice</span><span>Wheat</span><span>Maize</span><span>Sugar</span><span>Food Grains</span></div>
					</div>
					<div>
						<h3>Industrial &amp; Project Cargo</h3>
						<p class="dp-ops-soft">Heavy-lift capabilities and robust infrastructure for industrial commodities and break-bulk.</p>
						<div class="dp-ops-tags"><span>Fertilizers</span><span>Steel Products</span><span>Alumina Bags</span><span>Project Cargo</span></div>
					</div>
				</div>
			</div>
		</div>
		<h2 class="dp-ops-center-title">Operational Capabilities</h2>
		<div class="dp-ops-quad">
			<article><h3>Cargo Handling</h3>' . delta_ports_html_checks( array( 'Harbour Mobile Crane Ops', 'Vessel Discharge', 'Cargo Planning', 'Throughput Management', '24/7 Operations' ) ) . '</article>
			<article><h3>Equipment Fleet</h3>' . delta_ports_html_checks( array( 'Italgru IHC 2120 Crane', 'Mobile Hoppers', 'Portable Conveyors', 'Loaders & Dumpers', 'Heavy Trailers' ) ) . '</article>
			<article><h3>Storage Infrastructure</h3>' . delta_ports_html_checks( array( 'Cargo Stacking Areas', 'Covered Storage', 'Future Warehouse Dev', 'Backup Storage Areas', 'Cargo Evacuation' ) ) . '</article>
			<article><h3>Compliance &amp; Safety</h3>' . delta_ports_html_checks( array( 'Dust Suppression Systems', 'Dry Fog Systems', 'Fire Protection', 'Environmental Compliance', 'Safety Standards' ) ) . '</article>
		</div>
	</div>
</section>
<!-- /wp:html -->
';

	// Integrated capabilities + equipment + cargo categories + flow.
	$out .= '<!-- wp:html -->
<section class="dp-ops-section dp-ops-section--dark">
	<div class="dp-ops-section__inner">
		<div class="dp-ops-center">
			<h2>Integrated Port Infrastructure Capabilities</h2>
			<p>Comprehensive logistics and terminal services driving efficiency across our network.</p>
		</div>
		<div class="dp-ops-pill-grid">
			<span>Berth Operations</span><span>Cargo Handling</span><span>Bulk Handling</span><span>Container Operations</span>
			<span>Warehousing</span><span>Open Storage</span><span>Rail Connectivity</span><span>Road Connectivity</span>
			<span>Vessel Coordination</span><span>Cargo Planning</span><span>Terminal Management</span><span>Port Equipment</span>
		</div>
	</div>
</section>
<section class="dp-ops-section">
	<div class="dp-ops-section__inner">
		<div class="dp-ops-center">
			<h2>Specialized Equipment</h2>
			<p>Heavy-duty assets supporting high-volume, efficient cargo movement.</p>
		</div>
		<div class="dp-ops-equip">
			<span>Harbour Mobile Cranes</span><span>Reach Stackers</span><span>Mobile Hoppers</span><span>Portable Conveyors</span>
			<span>Loaders</span><span>Dumpers</span><span>Rail Infrastructure</span><span>Trailers</span>
			<span>Storage Facilities</span><span>Integrated Warehousing</span>
		</div>
		<div class="dp-ops-center" style="margin-top:3rem">
			<h2>Cargo Categories We Handle</h2>
		</div>
		<div class="dp-ops-cat-grid">
			<article><h3>Agricultural Cargo</h3><p>Rice · Sugar · Wheat · Maize</p></article>
			<article><h3>Minerals &amp; Bulk</h3><p>Iron Ore · Gypsum · Bauxite · Limestone · Fertilizers</p></article>
			<article><h3>Industrial Cargo</h3><p>Steel · Alumina</p></article>
			<article><h3>Project Cargo</h3><p>Heavy Equipment · Industrial Components · Break Bulk Cargo</p></article>
		</div>
		<div class="dp-ops-center" style="margin-top:3rem">
			<h2>How Cargo Moves Through Delta Ports</h2>
			<p>A seamless, integrated workflow from vessel arrival to inland dispatch.</p>
		</div>
		<ol class="dp-ops-flow">
			<li><span>1</span><strong>Vessel Arrival</strong></li>
			<li><span>2</span><strong>Berth Allocation</strong></li>
			<li><span>3</span><strong>Cargo Handling</strong></li>
			<li><span>4</span><strong>Storage &amp; Warehousing</strong></li>
			<li><span>5</span><strong>Rail Loading</strong></li>
			<li><span>6</span><strong>Road Dispatch</strong></li>
			<li><span>7</span><strong>Final Delivery</strong></li>
		</ol>
	</div>
</section>
<!-- /wp:html -->
';

	return $out;
}

/**
 * Cargo handling capabilities.
 *
 * @return string
 */
function delta_ports_content_cargo() {
	$hero   = 'sustanability-new-banner3.webp';
	if ( ! file_exists( DELTA_PORTS_DIR . '/assets/images/' . $hero ) ) {
		$hero = 'Terminal-Infrastructure-And-Yard-Facilities-scaled.webp';
	}
	$yard   = delta_ports_img_or( 'Terminal-Infrastructure-And-Yard-Facilities-scaled.webp' );
	$img1   = delta_ports_img_or( 'cargo-new-img-4.webp' );
	$cover  = delta_ports_img_or( 'cargo-new-img-5.webp', 'cargo-new-img-4.webp' );
	$open   = delta_ports_img_or( 'cargo-new-img-4.webp' );
	$eq1    = delta_ports_img_or( 'mob-Port-let-Operating-Philosophy-01.webp' );
	$eq2    = delta_ports_img_or( 'mob-Port-let-Operating-Philosophy-2.webp' );
	$eq3    = delta_ports_img_or( 'cargo-handleing9.webp' );
	$eq4    = delta_ports_img_or( 'cargo-handleing8.webp' );
	$safety = delta_ports_img_or( 'our-operation-delta-port1.webp' );
	$prof   = delta_ports_img_or( 'our-operation-delta-port2.webp' );

	$out  = delta_ports_ops_hero(
		'Cargo Handling Capabilities',
		'Cargo Handling Capabilities',
		'We provide comprehensive cargo handling services across breakbulk, project cargo, and container operations.',
		$hero
	);

	$out .= '<!-- wp:html -->
<section class="dp-ops-section">
	<div class="dp-ops-section__inner dp-ops-split dp-ops-split--cargo">
		<div>
			<h2>Cargo Handling Capabilities</h2>
			<p>Efficient handling of bulk, breakbulk, and containerised cargo supported by modern equipment, structured workflows, and dedicated storage infrastructure.</p>
			<figure class="dp-ops-rounded"><img src="' . esc_url( $img1 ) . '" alt="Cargo handling at terminal" loading="lazy" decoding="async" /></figure>
		</div>
		<div class="dp-ops-stat-tiles dp-ops-stat-tiles--center">
			<div class="dp-ops-stat-tile"><strong>6</strong><em>Million MT</em><span>Bulk Cargo Handling Capacity</span></div>
			<div class="dp-ops-stat-tile"><strong>0.15</strong><em>Million TEU</em><span>Container Handling Capacity</span></div>
			<div class="dp-ops-stat-tile"><strong>~0.2</strong><em>Million TEU</em><span>Covered Storage Capacity</span></div>
			<div class="dp-ops-stat-tile"><strong>4-5</strong><em>Lakh MT</em><span>Yard Storage Capacity</span></div>
		</div>
	</div>
</section>

<section class="dp-ops-section dp-ops-section--dark">
	<div class="dp-ops-section__inner dp-ops-split dp-ops-split--center">
		<figure class="dp-ops-rounded"><img src="' . esc_url( $yard ) . '" alt="Terminal infrastructure and yard" loading="lazy" decoding="async" /></figure>
		<div>
			<h2>Terminal Infrastructure And Yard Facilities</h2>
			<p>Terminal infrastructure is designed to support operational efficiency and safety across cargo handling zones. Facilities include paved yard areas, defined operational zones, and internal circulation systems that support orderly cargo movement and staging.</p>
		</div>
	</div>
</section>

<section class="dp-ops-section">
	<div class="dp-ops-section__inner">
		<div class="dp-ops-equip-head">
			<div>
				<h2>Equipment &amp; Handling Systems</h2>
				<p>Delta Ports deploys a range of handling &amp; support equipment to meet operational requirements.</p>
			</div>
		</div>
		<div class="dp-ops-equip-bento">
			<article class="dp-ops-bento dp-ops-bento--light">
				<h3>Cargo Handling Equipment</h3>
				<p>Forklifts, loaders, excavators, tippers, and trailers</p>
			</article>
			<article class="dp-ops-bento dp-ops-bento--photo" style="background-image:url(\'' . esc_url( $eq1 ) . '\')">
				<div class="dp-ops-bento__shade"></div>
				<div class="dp-ops-bento__body">
					<h3>Port Maintenance Vehicles</h3>
					<p>Road sweepers and mist cannon vehicles for dust suppression and cleanliness</p>
				</div>
			</article>
			<article class="dp-ops-bento dp-ops-bento--photo" style="background-image:url(\'' . esc_url( $eq2 ) . '\')">
				<div class="dp-ops-bento__shade"></div>
				<div class="dp-ops-bento__body"><h3>Support Equipment</h3></div>
			</article>
			<article class="dp-ops-bento dp-ops-bento--photo" style="background-image:url(\'' . esc_url( $eq3 ) . '\')">
				<div class="dp-ops-bento__shade"></div>
				<div class="dp-ops-bento__body">
					<h3>Mobile Harbour Cranes</h3>
					<p>2 units with 125 MT lifting capacity each</p>
				</div>
			</article>
			<article class="dp-ops-bento dp-ops-bento--dark">
				<h3>Heavy-Lift and Project Cargo Cranes</h3>
				<p>Jib and Knuckle cranes for oversized and project cargo</p>
			</article>
		</div>
	</div>
</section>

<section class="dp-ops-section dp-ops-section--soft">
	<div class="dp-ops-section__inner">
		<div class="dp-ops-center">
			<h2>Storage &amp; Support Infrastructure</h2>
			<p>The terminal provides ample storage capacity for varied cargo requirements.</p>
		</div>
		<div class="dp-ops-storage-grid">
			<article class="dp-ops-storage-card">
				<h3>Covered Storage</h3>
				' . delta_ports_html_bullets( array( '3 covered sheds', 'Individual capacities ranging from approximately 15,000 to 20,000 MT' ) ) . '
			</article>
			<figure class="dp-ops-rounded"><img src="' . esc_url( $cover ) . '" alt="Covered storage" loading="lazy" decoding="async" /></figure>
			<figure class="dp-ops-rounded"><img src="' . esc_url( $open ) . '" alt="Open storage" loading="lazy" decoding="async" /></figure>
			<article class="dp-ops-storage-card">
				<h3>Open Storage</h3>
				' . delta_ports_html_bullets( array( 'Extensive open yard space', 'Total capacity of approximately 4 to 5 lakh tonnes' ) ) . '
			</article>
		</div>
	</div>
</section>

<section class="dp-ops-section dp-ops-section--dark">
	<div class="dp-ops-section__inner dp-ops-split dp-ops-split--center">
		<figure class="dp-ops-rounded"><img src="' . esc_url( $safety ) . '" alt="Terminal safety" loading="lazy" decoding="async" /></figure>
		<div>
			<h2>Terminal Safety &amp; Security Infrastructure</h2>
			<p>Security and surveillance are integral to terminal operations, with systems designed to ensure controlled access, operational safety, and compliance with regulatory standards across all cargo handling zones.</p>
			' . delta_ports_html_bullets( array(
				'CCTV surveillance across operational and storage zones',
				'24/7 security personnel',
				'Boom barriers with integrated scanners at entry points',
				'Rigorous traffic inspections for inbound and outbound vehicles',
			) ) . '
		</div>
	</div>
</section>

<section class="dp-ops-section">
	<div class="dp-ops-section__inner dp-ops-split dp-ops-split--center">
		<div>
			<h2>Cargo Profiles Supported</h2>
			<p>The terminal is equipped to handle a wide range of cargo categories across imports and exports, supported by infrastructure and handling systems designed for different cargo characteristics and operational requirements.</p>
			' . delta_ports_html_bullets( array(
				'Minerals and ores: iron ore, bauxite, gypsum, limestone',
				'Industrial and construction cargo: steel coils, project cargo',
				'General and bulk cargo: woodchips, containers, and other bulk cargo',
			) ) . '
		</div>
		<figure class="dp-ops-rounded"><img src="' . esc_url( $prof ) . '" alt="Cargo profiles" loading="lazy" decoding="async" /></figure>
	</div>
</section>
<!-- /wp:html -->
';

	$out .= delta_ports_html_faq(
		array(
			'What cargo handling facilities are available at Delta Ports terminals?' => 'Delta Ports terminals are equipped with modern cargo handling systems, including mobile harbour cranes, cargo handling equipment, and heavy-lift cranes to support diverse cargo requirements.',
			'What types of cargo can be handled at the terminal?' => 'The terminal supports minerals and ores, industrial and construction cargo, general cargo, bulk cargo, and containers, subject to operational conditions.',
			'Is storage available for weather-sensitive cargo?' => 'Yes. The terminal provides covered storage sheds suitable for weather-sensitive cargo, along with extensive open storage areas for bulk and non-perishable cargo.',
			'What security measures are in place at the terminal?' => 'Security infrastructure includes CCTV surveillance, 24/7 security personnel, controlled access points with scanners, and strict vehicle inspection procedures.',
		),
		'Answers to common questions about our terminal operations, cargo handling, and logistics.'
	);

	return $out;
}

/**
 * Integrated port logistics.
 *
 * @return string
 */
function delta_ports_content_logistics() {
	$hero  = file_exists( DELTA_PORTS_DIR . '/assets/images/integrated-port-scaled.webp' )
		? 'integrated-port-scaled.webp'
		: 'integraded-port-logistic-new-img1.webp';
	$rail  = delta_ports_img_or( 'integraded-port-logistic-new-img1.webp' );
	$road  = delta_ports_img_or( 'Road-Highway-Access-scaled.webp' );
	$std1  = delta_ports_img_or( 'mob-Port-let-Operating-Philosophy-3.webp', 'our-operation-delta-port1.webp' );
	$std2  = delta_ports_img_or( 'mob-Port-let-Operating-Philosophy-4.webp', 'our-operation-delta-port2.webp' );
	// Prefer larger photos for mosaic if available.
	$mos1  = delta_ports_img_or( 'our-operation-delta-port2.webp' );
	$mos2  = delta_ports_img_or( 'our-operation-delta-port1.webp' );

	$out  = delta_ports_ops_hero(
		'Integrated Port Logistics',
		'Integrated Port Logistics',
		'Streamline operations across terminals, warehouses and transport networks. Real-time visibility, predictive analytics, & automated workflows help you move cargo faster, reduce costs, and improve safety.',
		$hero
	);

	$out .= '<!-- wp:html -->
<section class="dp-ops-section">
	<div class="dp-ops-section__inner">
		<p class="dp-ops-lead-center">Delta Ports supports integrated port logistics that enable efficient movement of cargo beyond terminal boundaries. Connectivity infrastructure is designed to reduce dwell time, improve evacuation speed, and support supply-chain continuity.</p>
		<div class="dp-ops-split dp-ops-split--center" style="margin-top:2.5rem">
			<figure class="dp-ops-rounded"><img src="' . esc_url( $rail ) . '" alt="Rail connectivity" loading="lazy" decoding="async" /></figure>
			<div>
				<h2>Rail Connectivity</h2>
				<p>The terminal features dedicated rail infrastructure to support efficient cargo evacuation.</p>
				' . delta_ports_html_bullets( array(
					'2 railway sidings within the port premises',
					'Direct loading and unloading at terminal locations',
					'Supports smooth rail evacuation and reduced cargo congestion',
				) ) . '
				<p>Rail connectivity enables integration with inland logistics and consumption centres</p>
			</div>
		</div>
	</div>
</section>

<section class="dp-ops-section dp-ops-section--dark">
	<div class="dp-ops-section__inner dp-ops-split dp-ops-split--center">
		<div>
			<h2>Road &amp; Highway Access</h2>
			<p>Road infrastructure enhances terminal accessibility and operational efficiency. This infrastructure supports faster cargo movement and improved turnaround times.</p>
			' . delta_ports_html_bullets( array(
				'Traffic bypass system to avoid city congestion',
				'Newly constructed curved cable-stayed bridge providing direct port access',
				'Uninterrupted highway connectivity from port to road networks',
			) ) . '
			<p>This infrastructure supports faster cargo movement and improved turnaround times.</p>
		</div>
		<figure class="dp-ops-rounded"><img src="' . esc_url( $road ) . '" alt="Road and highway access" loading="lazy" decoding="async" /></figure>
	</div>
</section>

<section class="dp-ops-section">
	<div class="dp-ops-section__inner">
		<div class="dp-ops-center">
			<h2>Responsible &amp; Compliant Operations</h2>
			<p>Terminal operations are governed by structured sustainability practices, regulatory compliance, and accountable frameworks that support efficient performance, environmental responsibility, and long-term operational reliability.</p>
		</div>
		<div class="dp-ops-mosaic">
			<article class="dp-ops-mosaic__card">
				<h3>World-Class Port Operations &amp; International Standards</h3>
				<p>We deliver world-class port operations built to international standards, utilizing advanced infrastructure and modern handling equipment for high efficiency.</p>
			</article>
			<figure class="dp-ops-rounded"><img src="' . esc_url( $mos1 ) . '" alt="Port operations at sunset" loading="lazy" decoding="async" /></figure>
			<figure class="dp-ops-rounded"><img src="' . esc_url( $mos2 ) . '" alt="Aerial port view" loading="lazy" decoding="async" /></figure>
			<article class="dp-ops-mosaic__card">
				<h3>Logistics Focus</h3>
				<p>Our systems are optimized to reduce vessel turnaround time, enhance throughput, and minimize operational costs through flow optimization and advanced cargo allocation.</p>
			</article>
		</div>
	</div>
</section>
<!-- /wp:html -->
';

	$out .= delta_ports_html_faq(
		array(
			'What is integrated port logistics at Delta Ports?' => 'Integrated port logistics refers to the coordination of port operations with road and rail connectivity to enable efficient movement of cargo between the terminal and hinterland destinations.',
			'Does the terminal have rail connectivity?' => 'Yes. The terminal includes two railway sidings within the port premises, allowing direct loading and unloading of cargo for rail evacuation.',
			'How is road access to the terminal managed?' => 'The terminal is connected via a dedicated curved cable-stayed bridge that provides direct highway access and bypasses city traffic, reducing congestion and delays.',
			'How does integrated logistics improve cargo movement?' => 'By coordinating port operations with rail and road infrastructure, integrated logistics reduces dwell time, improves cargo flow, and enhances overall supply-chain efficiency.',
		),
		'Answers to common questions about our terminal operations, cargo handling, and logistics.'
	);

	return $out;
}

/**
 * Sustainability page.
 *
 * @return string
 */
function delta_ports_content_sustainability() {
	// Live website images only.
	$hero  = file_exists( DELTA_PORTS_DIR . '/assets/images/sustanability-new-banner1.webp' )
		? 'sustanability-new-banner1.webp'
		: 'mobile-banner-Port-Sustainability.webp';
	$appr  = delta_ports_img_or( 'mob-Our-App-roach-to-Sustainability.webp', 'sustanability-new-banner5.webp' );
	// Prefer larger live terminal photos.
	$term1 = delta_ports_img_or( 'commit-sustanability-new-1.webp', 'mob-Sustainable-Terminal-Operations.webp' );
	$term2 = delta_ports_img_or( 'commit-sustanability-new-2.webp', 'sustanability8.webp' );
	$imp   = delta_ports_img_or( 'continies-improvement-scaled.webp', 'sustanability-new-banner5.webp' );
	$safe  = delta_ports_img_or( 'mob-Safety-and-Occupational-Responsibility.webp', 'mob-Terminal-Safety.webp' );

	$out  = delta_ports_ops_hero(
		'Sustainability',
		'Sustainability',
		"We're committed to reducing our environmental impact across operations, supply chains, and communities. This section outlines our approach, progress, and goals for a more sustainable future.",
		$hero
	);

	$out .= '<!-- wp:html -->
<section class="dp-ops-section dp-sus-page">
	<div class="dp-ops-section__inner">
		<p class="dp-ops-lead-center">At Delta Ports, sustainability is embedded into day-to-day operations rather than positioned as a standalone initiative. Our approach focuses on safe working environments, responsible environmental practices, and compliance with applicable regulations across all port and terminal activities. Sustainability at Delta Ports supports long-term operational reliability and responsible infrastructure stewardship.</p>
		<div class="dp-ops-split dp-ops-split--center dp-sus-approach" style="margin-top:2.75rem">
			<figure class="dp-ops-rounded dp-sus-media"><img src="' . esc_url( $appr ) . '" alt="Our approach to sustainability" loading="lazy" decoding="async" /></figure>
			<div>
				<h2>Our Approach to Sustainability</h2>
				<p>Delta Ports\' sustainability framework is built around key operational priorities that guide decision-making across port-led operations, cargo and terminal infrastructure, and integrated logistics activities.</p>
				' . delta_ports_html_bullets( array(
					'Regulatory compliance & governance',
					'Environmental responsibility',
					'Safety-led operations',
				) ) . '
			</div>
		</div>
	</div>
</section>

<section class="dp-ops-section dp-ops-section--dark dp-sus-terminal">
	<div class="dp-ops-section__inner">
		<div class="dp-ops-sustain-ops">
			<div class="dp-ops-sustain-ops__title">
				<h2>Sustainable Terminal Operations</h2>
				<figure class="dp-ops-rounded dp-sus-media"><img src="' . esc_url( $term1 ) . '" alt="Sustainable terminal operations" loading="lazy" decoding="async" /></figure>
			</div>
			<div class="dp-ops-sustain-ops__copy">
				<p class="dp-ops-sustain-ops__lead">Terminal infrastructure and operations are managed to support efficient resource utilisation and reduced environmental impact.</p>
				<p>Equipment deployment, yard operations, and cargo movement practices are designed to balance operational performance with environmental responsibility.</p>
				<p>Sustainability considerations are integrated into operational planning, maintenance activities, and infrastructure upgrades.</p>
			</div>
			<figure class="dp-ops-rounded dp-ops-sustain-ops__side dp-sus-media"><img src="' . esc_url( $term2 ) . '" alt="Harbour sustainability" loading="lazy" decoding="async" /></figure>
		</div>
	</div>
</section>

<section class="dp-ops-section dp-ops-section--soft">
	<div class="dp-ops-section__inner dp-ops-split dp-ops-split--center">
		<figure class="dp-ops-rounded dp-sus-media"><img src="' . esc_url( $safe ) . '" alt="Safety and occupational responsibility" loading="lazy" decoding="async" /></figure>
		<div>
			<h2>Safety and Occupational Responsibility</h2>
			<p>Safety is foundational to sustainable operations. Delta Ports prioritises safe working environments through structured procedures, training, and continuous monitoring across terminal activities.</p>
			' . delta_ports_html_bullets( array(
				'Safety-led operating procedures',
				'Training and competency development',
				'Incident prevention and reporting discipline',
				'Protective systems across cargo zones',
			) ) . '
		</div>
	</div>
</section>

<section class="dp-ops-section">
	<div class="dp-ops-section__inner">
		<div class="dp-ops-center">
			<h2>Committed to Sustainable Operations.</h2>
			<p>We embed environmental responsibility into everyday terminal performance — from equipment choices to yard practices and compliance frameworks.</p>
		</div>
	</div>
</section>

<section class="dp-ops-section dp-ops-section--dark">
	<div class="dp-ops-section__inner dp-ops-split dp-ops-split--center">
		<div>
			<h2>Compliance &amp; Governance</h2>
			<p>Sustainability at Delta Ports is supported by regulatory compliance and accountable governance. Operational controls, documentation, and oversight frameworks help ensure environmental and safety standards are met consistently.</p>
			' . delta_ports_html_bullets( array(
				'Regulatory compliance frameworks',
				'Environmental monitoring practices',
				'Operational governance and accountability',
				'Continuous improvement of controls',
			) ) . '
		</div>
		<figure class="dp-ops-rounded dp-sus-media"><img src="' . esc_url( $term2 ) . '" alt="Compliance and governance" loading="lazy" decoding="async" /></figure>
	</div>
</section>

<section class="dp-ops-section dp-sus-improve">
	<div class="dp-ops-section__inner dp-ops-split dp-ops-split--center">
		<div>
			<h2>Continuous Improvement</h2>
			<p>Delta Ports is committed to continuous improvement in safety and environmental practices. Operational learnings, technological upgrades, and process enhancements are evaluated regularly to strengthen sustainability outcomes over time.</p>
			<p>This measured approach ensures that sustainability supports both operational resilience and long-term infrastructure value.</p>
		</div>
		<figure class="dp-ops-rounded dp-sus-media"><img src="' . esc_url( $imp ) . '" alt="Continuous improvement" loading="lazy" decoding="async" /></figure>
	</div>
</section>
<!-- /wp:html -->
';

	$out .= delta_ports_html_faq(
		array(
			'How does Delta Ports approach sustainability?' => 'Sustainability is embedded into day-to-day terminal operations through safety, environmental responsibility, and regulatory compliance rather than treated as a standalone programme.',
			'What sustainability initiatives are underway?' => 'Key initiatives include electrified and hybrid equipment pathways, solar energy development, dust suppression systems, and continuous process improvements that reduce environmental impact.',
			'How is safety linked to sustainability?' => 'Safe working environments, training, and operational discipline are foundational to sustainable performance across cargo handling and terminal infrastructure.',
			'Does Delta Ports follow environmental regulations?' => 'Yes. Compliance with applicable environmental and safety regulations is a core part of governance across port-led operations.',
		),
		'Questions about our environmental and safety commitments.'
	);

	return $out;
}

/**
 * Contact us — live reference design (offices + talent form).
 *
 * @return string
 */
function delta_ports_content_contact() {
	// Ensure CF7 forms exist with mail1/mail2.
	if ( function_exists( 'delta_ports_get_or_create_talent_form' ) ) {
		delta_ports_get_or_create_talent_form( true );
	}
	if ( function_exists( 'delta_ports_get_or_create_contact_form' ) ) {
		delta_ports_get_or_create_contact_form( true );
	}

	$map_hq  = 'https://www.openstreetmap.org/export/embed.html?bbox=74.84%2C12.88%2C74.90%2C12.93&layer=mapnik&marker=12.905%2C74.870';
	$map_blr = 'https://www.openstreetmap.org/export/embed.html?bbox=77.60%2C12.96%2C77.63%2C12.98&layer=mapnik&marker=12.9716%2C77.6197';
	$map_sa  = 'https://www.openstreetmap.org/export/embed.html?bbox=50.07%2C26.38%2C50.15%2C26.45&layer=mapnik&marker=26.4207%2C50.0888';

	$out  = '<!-- wp:html -->
<section class="dp-contact-hero">
	<div class="dp-contact-hero__inner">
		<nav class="dp-ops-hero__crumb" aria-label="Breadcrumb"><a href="/">Home</a><span aria-hidden="true">›</span><span>Contact Us</span></nav>
		<h1>Contact us</h1>
	</div>
</section>

<section class="dp-contact-offices">
	<div class="dp-contact-offices__inner">
		<article class="dp-contact-office">
			<div class="dp-contact-office__map" data-map-src="' . esc_url( $map_hq ) . '"><iframe title="Head Quarters map" src="' . esc_url( $map_hq ) . '" width="600" height="150" loading="lazy" referrerpolicy="no-referrer-when-downgrade" frameborder="0" scrolling="no"></iframe></div>
			<div class="dp-contact-office__body">
				<h3>Head Quarters</h3>
				<p class="dp-contact-office__row"><span class="dp-contact-ico dp-contact-ico--pin" aria-hidden="true"></span><span>Delta House, 6th Floor, Bangra Kulur Road, Kulur, Mangalore - 575013, Karnataka, India.</span></p>
				<p class="dp-contact-office__row"><span class="dp-contact-ico dp-contact-ico--phone" aria-hidden="true"></span><a href="tel:+919902395555">99023 95555</a></p>
			</div>
		</article>
		<article class="dp-contact-office">
			<div class="dp-contact-office__map" data-map-src="' . esc_url( $map_blr ) . '"><iframe title="Bangalore Office map" src="' . esc_url( $map_blr ) . '" width="600" height="150" loading="lazy" referrerpolicy="no-referrer-when-downgrade" frameborder="0" scrolling="no"></iframe></div>
			<div class="dp-contact-office__body">
				<h3>Bangalore Office</h3>
				<p class="dp-contact-office__row"><span class="dp-contact-ico dp-contact-ico--pin" aria-hidden="true"></span><span>Tower-B, Unit No. 407, No.84, Mahatma Gandhi Rd, Shanthala Nagar, Ashok Nagar, Bengaluru, Karnataka 560001</span></p>
				<p class="dp-contact-office__row"><span class="dp-contact-ico dp-contact-ico--phone" aria-hidden="true"></span><a href="tel:+919480849765">+91 94808 49765</a></p>
			</div>
		</article>
		<article class="dp-contact-office">
			<div class="dp-contact-office__map" data-map-src="' . esc_url( $map_sa ) . '"><iframe title="Saudi Arabia Office map" src="' . esc_url( $map_sa ) . '" width="600" height="150" loading="lazy" referrerpolicy="no-referrer-when-downgrade" frameborder="0" scrolling="no"></iframe></div>
			<div class="dp-contact-office__body">
				<h3>Saudi Arabia Office</h3>
				<p class="dp-contact-office__row"><span class="dp-contact-ico dp-contact-ico--pin" aria-hidden="true"></span><span>King Faisal Ibn Abd Al Aziz, Al Khalidiyyah Al Janubiyyah, Dammam 32221, Saudi Arabia</span></p>
				<p class="dp-contact-office__row"><span class="dp-contact-ico dp-contact-ico--phone" aria-hidden="true"></span><a href="tel:+966561416184">+966561416184</a></p>
			</div>
		</article>
	</div>
</section>

<section class="dp-contact-talent">
	<div class="dp-contact-talent__inner">
		<div class="dp-contact-talent__panel">
			<h2>Join Our Talent Network</h2>
			<p>We are always interested in engaging with professionals who share our values and wish to grow with an infrastructure-led organisation.</p>
			<p><a class="dp-contact-mail" href="mailto:info@deltaports.com">info@deltaports.com</a></p>
		</div>
		<div class="dp-contact-talent__form">
<!-- /wp:html -->

<!-- wp:shortcode -->
[contact-form-7 title="Talent Network"]
<!-- /wp:shortcode -->

<!-- wp:html -->
		</div>
	</div>
</section>
<!-- /wp:html -->
';

	return $out;
}
