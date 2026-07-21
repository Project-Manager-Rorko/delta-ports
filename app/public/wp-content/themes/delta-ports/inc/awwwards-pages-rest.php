<?php
/**
 * Awwwards-level remaining pages.
 *
 * @package Delta_Ports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Leadership.
 */
function delta_ports_content_leadership() {
	$imgs = array(
		'Ahmed Mohiuddin'   => file_exists( DELTA_PORTS_DIR . '/assets/images/leader-ahmed-mohiuddin.png' ) ? 'leader-ahmed-mohiuddin.png' : 'leader-new2.webp',
		'Shamil Ahmed'      => file_exists( DELTA_PORTS_DIR . '/assets/images/leader-shamil-ahmed.png' ) ? 'leader-shamil-ahmed.png' : 'leader-new1.webp',
		'Mohammed Shahzeer' => file_exists( DELTA_PORTS_DIR . '/assets/images/leader-mohammed-shahzeer.png' ) ? 'leader-mohammed-shahzeer.png' : 'leader-new3.webp',
		'Raghoba Kotkar'    => 'leader-new2.webp',
		'Saurabh Kanchan'   => 'leader-new3.webp',
		'Sudhir Hegde'      => 'leader-new1.webp',
	);
	$roles = array(
		'Ahmed Mohiuddin'   => 'MD',
		'Shamil Ahmed'      => 'Director',
		'Mohammed Shahzeer' => 'Director',
		'Raghoba Kotkar'    => 'Head of Logistics',
		'Saurabh Kanchan'   => 'Chief Financial Officer',
		'Sudhir Hegde'      => 'Head of Infrastructure',
	);
	$cards = '';
	foreach ( $roles as $name => $role ) {
		$src    = delta_ports_img( $imgs[ $name ] );
		$cards .= '<article class="aw-person" data-aw-reveal><img src="' . $src . '" alt="' . esc_attr( $name ) . '" loading="lazy" width="600" height="600"/><h3>' . esc_html( $name ) . '</h3><p>' . esc_html( $role ) . '</p></article>';
	}
	$hero = delta_ports_aw_inner_hero(
		'Leadership',
		'Leadership',
		'At Delta Group, leadership is defined by stewardship rather than hierarchy. Leaders act with integrity, prioritise safety, and own outcomes across every function.',
		'des-banner-Port-leadership-1.webp'
	);

	return <<<HTML
<!-- wp:html -->
<div class="aw-page aw-leadership" data-aw-page="leadership">
{$hero}
<section class="aw-section">
	<div data-aw-reveal>
		<p class="aw-kicker">Philosophy</p>
		<h2 style="font-size:clamp(2rem,4vw,3rem);letter-spacing:-.035em;margin:0 0 1rem;max-width:18ch">Our Leadership Philosophy</h2>
		<p class="aw-sub">Decisions are made with a long-term perspective — balancing operational excellence with responsibility to people, partners, and the environments we operate in.</p>
		<h2 style="font-size:clamp(1.6rem,3vw,2.2rem);letter-spacing:-.03em;margin:2rem 0 1rem">Meet our team</h2>
	</div>
	<div class="aw-team" style="margin-top:1rem">{$cards}</div>
</section>
<section class="aw-section aw-section--dark">
	<div class="aw-section__inner" data-aw-reveal>
		<p class="aw-kicker">Next step</p>
		<h2 style="font-size:clamp(2rem,4vw,3rem);letter-spacing:-.035em;margin:0 0 1rem">Move Your Business Forward</h2>
		<p style="max-width:36rem;margin:0 0 1.5rem">Partner with Delta Ports for reliable port operations, automotive logistics, and global trade support.</p>
		<a class="aw-btn aw-btn--fill" href="/contact-us/"><span>Explore More</span><em>→</em></a>
	</div>
</section>
</div>
<!-- /wp:html -->
HTML;
}

/**
 * Port-Led Operations — full live content parity.
 */
function delta_ports_content_port_led() {
	$hero = delta_ports_aw_inner_hero(
		'Port-Led Operation',
		'Port-Led Operation',
		"Integrated Terminal Operations Across India's Strategic Maritime Gateways. Delta Ports delivers terminal operations, cargo handling, warehousing, vessel services, and multimodal logistics through strategically located terminal assets on India's East and West Coasts.",
		'port-led-operation-new-banner-img.webp'
	);
	$term1 = delta_ports_img( 'our-operation-delta-port1.webp' );
	$term2 = delta_ports_img( 'our-operation-delta-port2.webp' );
	$morm  = delta_ports_img( 'new-delta-port-new1.webp' );
	$eq3   = delta_ports_img( 'new-delta-port-new2.webp' );
	$infra = delta_ports_img( 'Terminal-Infrastructure-And-Yard-Facilities-scaled.webp' );
	$flow  = delta_ports_img( 'our-operation-delta-port4.webp' );
	$i1    = delta_ports_img( 'delta-port-new-page4.webp' );
	$i2    = delta_ports_img( 'delta-port-new-page5.webp' );
	$i3    = delta_ports_img( 'delta-port-new-page6.webp' );

	return <<<HTML
<!-- wp:html -->
<div class="aw-page aw-portled" data-aw-page="portled">
{$hero}

<section class="aw-section">
	<div data-aw-reveal>
		<p class="aw-kicker">Network</p>
		<h2 class="aw-h2">A Growing Terminal Network Built For Modern Trade</h2>
		<p class="aw-sub">Delta Ports operates strategic terminal assets across India's east and west coasts, forming a robust maritime infrastructure backbone for modern trade.</p>
	</div>
	<div class="aw-grid-4 aw-stat-row" style="margin-top:1.75rem">
		<div class="aw-card aw-stat-card" data-aw-reveal><span class="aw-kicker">Assets</span><strong class="aw-stat-num">2</strong><p>Terminal Assets</p></div>
		<div class="aw-card aw-card--dark aw-stat-card" data-aw-reveal><span class="aw-kicker">Coast</span><strong class="aw-stat-num">E&amp;W</strong><p>Coast Presence</p></div>
		<div class="aw-card aw-stat-card" data-aw-reveal><span class="aw-kicker">Cargo</span><strong class="aw-stat-num">Multi</strong><p>Cargo Handling</p></div>
		<div class="aw-card aw-stat-card" data-aw-reveal><span class="aw-kicker">Ops</span><strong class="aw-stat-num">24/7</strong><p>Operations</p></div>
	</div>
</section>

<section class="aw-section aw-section--soft">
	<div class="aw-section__inner">
		<div data-aw-reveal>
			<p class="aw-kicker">Locations</p>
			<h2 class="aw-h2">Our Terminal Network</h2>
			<p class="aw-sub">Our locations are specifically chosen to support optimal cargo movement, efficient vessel operations, secure storage, and seamless multimodal logistics connectivity.</p>
		</div>
		<div class="aw-grid-2 aw-media-cards" style="margin-top:1.75rem">
			<article class="aw-card aw-media-card" data-aw-reveal>
				<img src="{$term1}" alt="Mormugao, Goa terminal" loading="lazy" width="900" height="560" />
				<div class="aw-media-card__body">
					<span class="aw-kicker">West Coast</span>
					<h3>Mormugao, Goa</h3>
					<p>West Coast Multi-Cargo Gateway</p>
				</div>
			</article>
			<article class="aw-card aw-media-card" data-aw-reveal>
				<img src="{$term2}" alt="Visakhapatnam Vizag terminal" loading="lazy" width="900" height="560" />
				<div class="aw-media-card__body">
					<span class="aw-kicker">East Coast</span>
					<h3>Visakhapatnam (Vizag)</h3>
					<p>East Coast Operations &amp; Maintenance</p>
				</div>
			</article>
		</div>
	</div>
</section>

<section class="aw-section">
	<div class="aw-feature-row" data-aw-reveal>
		<div class="aw-feature-row__copy">
			<p class="aw-kicker">West Coast Gateway</p>
			<h2 class="aw-h2">Mormugao Terminal</h2>
			<p class="aw-sub">Strategically positioned on India's west coast, supporting bulk cargo, containerized cargo, and general operations with integrated logistics infrastructure.</p>
		</div>
		<div class="aw-feature-row__media">
			<img src="{$morm}" alt="Mormugao Terminal operations" loading="lazy" width="960" height="640" />
		</div>
	</div>
	<div class="aw-spec-row" data-aw-reveal>
		<div class="aw-spec"><span>Berths</span><strong>10 &amp; 11</strong></div>
		<div class="aw-spec"><span>Berth Length</span><strong>520 m</strong></div>
		<div class="aw-spec"><span>Draft</span><strong>12.80 m</strong></div>
		<div class="aw-spec"><span>Open Storage</span><strong>116k sq.m</strong></div>
		<div class="aw-spec"><span>Covered</span><strong>17.4k sq.m</strong></div>
	</div>
	<h3 data-aw-reveal class="aw-h3">Major Imports</h3>
	<div class="aw-chips" data-aw-reveal>
		<span class="aw-chip">Limestone</span><span class="aw-chip">Bauxite</span><span class="aw-chip">Fertilizers</span><span class="aw-chip">Iron Ore</span><span class="aw-chip">Gypsum</span>
	</div>
	<h3 data-aw-reveal class="aw-h3">Major Exports</h3>
	<div class="aw-chips" data-aw-reveal>
		<span class="aw-chip">Iron Ore</span><span class="aw-chip">Steel Coils</span><span class="aw-chip">Steel Slabs</span><span class="aw-chip">CR/HR Coils</span><span class="aw-chip">Pig Iron</span><span class="aw-chip">Molasses</span>
	</div>
	<h2 data-aw-reveal class="aw-h2" style="margin-top:2.25rem">Operational Capabilities</h2>
	<div class="aw-grid-3">
		<article class="aw-card" data-aw-reveal>
			<img class="aw-card__icon" src="{$i1}" alt="" width="64" height="64" loading="lazy" />
			<h3>Container Operations</h3>
			<p class="aw-card__lead">0.15 Million TEU Capacity</p>
			<ul class="aw-list">
				<li>Dedicated Container Infrastructure</li>
				<li>Container Yard Facilities</li>
				<li>Reach Stackers &amp; Empty Handlers</li>
				<li>Rail Connectivity &amp; Customs</li>
			</ul>
		</article>
		<article class="aw-card" data-aw-reveal>
			<img class="aw-card__icon" src="{$i2}" alt="" width="64" height="64" loading="lazy" />
			<h3>Bulk Cargo Operations</h3>
			<p class="aw-card__lead">6 Million MT Capacity</p>
			<ul class="aw-list">
				<li>Mobile Harbour Cranes</li>
				<li>Railway Sidings</li>
				<li>Fertilizer Handling</li>
				<li>Project Cargo Handling</li>
			</ul>
		</article>
		<article class="aw-card" data-aw-reveal>
			<img class="aw-card__icon" src="{$i3}" alt="" width="64" height="64" loading="lazy" />
			<h3>Storage &amp; Distribution</h3>
			<p class="aw-card__lead">Open &amp; covered multi-cargo capacity</p>
			<ul class="aw-list">
				<li>Open Storage Yards</li>
				<li>Covered Warehousing</li>
				<li>Container Storage</li>
				<li>Domestic Distribution Support</li>
			</ul>
		</article>
	</div>
</section>

<section class="aw-section aw-section--soft">
	<div class="aw-section__inner">
		<div class="aw-feature-row aw-feature-row--flip" data-aw-reveal>
			<div class="aw-feature-row__copy">
				<p class="aw-kicker">East Coast Specialized Terminal</p>
				<h2 class="aw-h2">EQ-3 Terminal</h2>
				<p class="aw-sub">A dedicated operation and maintenance terminal in Visakhapatnam focused on clean bulk commodities, agricultural cargo, and industrial products.</p>
			</div>
			<div class="aw-feature-row__media">
				<img src="{$eq3}" alt="EQ-3 Terminal Visakhapatnam" loading="lazy" width="960" height="640" />
			</div>
		</div>
		<div class="aw-grid-4" style="margin-top:1.5rem">
			<div class="aw-card aw-stat-card" data-aw-reveal><span class="aw-kicker">Contract</span><strong class="aw-stat-num aw-stat-num--sm">10-Year O&amp;M</strong><p>Long-term operations mandate</p></div>
			<div class="aw-card aw-stat-card" data-aw-reveal><span class="aw-kicker">Crane Capacity</span><strong class="aw-stat-num aw-stat-num--sm">120 Ton</strong><p>Heavy-lift capability</p></div>
			<div class="aw-card aw-stat-card" data-aw-reveal><span class="aw-kicker">Backup Area</span><strong class="aw-stat-num aw-stat-num--sm">1.43 Acres</strong><p>Core plot</p></div>
			<div class="aw-card aw-stat-card" data-aw-reveal><span class="aw-kicker">Expansion Land</span><strong class="aw-stat-num aw-stat-num--sm">2–3 Acres</strong><p>Growth potential</p></div>
		</div>
		<div class="aw-grid-2" style="margin-top:1.25rem">
			<article class="aw-card" data-aw-reveal>
				<h3>Clean Bulk Expertise</h3>
				<p>Specialized handling protocols to maintain commodity integrity for sensitive agricultural goods.</p>
				<div class="aw-chips">
					<span class="aw-chip">Rice</span><span class="aw-chip">Wheat</span><span class="aw-chip">Maize</span><span class="aw-chip">Sugar</span><span class="aw-chip">Food Grains</span>
				</div>
			</article>
			<article class="aw-card" data-aw-reveal>
				<h3>Industrial &amp; Project Cargo</h3>
				<p>Heavy-lift capabilities and robust infrastructure for industrial commodities and break bulk.</p>
				<div class="aw-chips">
					<span class="aw-chip">Fertilizers</span><span class="aw-chip">Steel Products</span><span class="aw-chip">Alumina Bags</span><span class="aw-chip">Project Cargo</span>
				</div>
			</article>
		</div>
		<h2 data-aw-reveal class="aw-h2" style="margin-top:2.25rem">Operational Capabilities</h2>
		<div class="aw-grid-4">
			<article class="aw-card" data-aw-reveal>
				<h3>Cargo Handling</h3>
				<ul class="aw-list">
					<li>Harbour Mobile Crane Ops</li>
					<li>Vessel Discharge</li>
					<li>Cargo Planning</li>
					<li>Throughput Management</li>
					<li>24/7 Operations</li>
				</ul>
			</article>
			<article class="aw-card" data-aw-reveal>
				<h3>Equipment Fleet</h3>
				<ul class="aw-list">
					<li>Italgru IHC 2120 Crane</li>
					<li>Mobile Hoppers</li>
					<li>Portable Conveyors</li>
					<li>Loaders &amp; Dumpers</li>
					<li>Heavy Trailers</li>
				</ul>
			</article>
			<article class="aw-card" data-aw-reveal>
				<h3>Storage Infrastructure</h3>
				<ul class="aw-list">
					<li>Cargo Stacking Areas</li>
					<li>Covered Storage</li>
					<li>Future Warehouse Dev</li>
					<li>Backup Storage Areas</li>
					<li>Cargo Evacuation</li>
				</ul>
			</article>
			<article class="aw-card" data-aw-reveal>
				<h3>Compliance &amp; Safety</h3>
				<ul class="aw-list">
					<li>Dust Suppression Systems</li>
					<li>Dry Fog Systems</li>
					<li>Fire Protection</li>
					<li>Environmental Compliance</li>
					<li>Safety Standards</li>
				</ul>
			</article>
		</div>
	</div>
</section>

<section class="aw-section">
	<div class="aw-feature-row" data-aw-reveal>
		<div class="aw-feature-row__copy">
			<p class="aw-kicker">Infrastructure</p>
			<h2 class="aw-h2">Integrated Port Infrastructure Capabilities</h2>
			<p class="aw-sub">Comprehensive logistics and terminal services driving efficiency across our network — berth operations, yard management, cargo handling systems, and multimodal interfaces designed for reliable throughput.</p>
		</div>
		<div class="aw-feature-row__media">
			<img src="{$infra}" alt="Integrated port infrastructure" loading="lazy" width="960" height="640" />
		</div>
	</div>
	<div class="aw-icon-grid" data-aw-reveal>
		<span class="aw-icon-tile">Berth Operations</span>
		<span class="aw-icon-tile">Cargo Handling</span>
		<span class="aw-icon-tile">Bulk Handling</span>
		<span class="aw-icon-tile">Container Operations</span>
		<span class="aw-icon-tile">Warehousing</span>
		<span class="aw-icon-tile">Open Storage</span>
		<span class="aw-icon-tile">Rail Connectivity</span>
		<span class="aw-icon-tile">Road Connectivity</span>
		<span class="aw-icon-tile">Vessel Coordination</span>
		<span class="aw-icon-tile">Cargo Planning</span>
		<span class="aw-icon-tile">Terminal Management</span>
		<span class="aw-icon-tile">Port Equipment</span>
	</div>
	<div data-aw-reveal style="margin-top:2.5rem">
		<h2 class="aw-h2">Specialized Equipment</h2>
		<p class="aw-sub">Heavy-duty assets supporting high-volume, efficient cargo movement across container, bulk, and project cargo requirements.</p>
		<div class="aw-chips" style="margin-top:1rem">
			<span class="aw-chip">Harbour Mobile Cranes</span>
			<span class="aw-chip">Reach Stackers</span>
			<span class="aw-chip">Mobile Hoppers</span>
			<span class="aw-chip">Portable Conveyors</span>
			<span class="aw-chip">Loaders</span>
			<span class="aw-chip">Dumpers</span>
			<span class="aw-chip">Rail Infrastructure</span>
			<span class="aw-chip">Trailers</span>
			<span class="aw-chip">Storage Facilities</span>
			<span class="aw-chip">Integrated Warehousing</span>
		</div>
	</div>
	<div data-aw-reveal style="margin-top:2.5rem">
		<h2 class="aw-h2">Cargo Categories We Handle</h2>
	</div>
	<div class="aw-grid-4" style="margin-top:1.25rem">
		<article class="aw-card" data-aw-reveal>
			<h3>Agricultural Cargo</h3>
			<div class="aw-chips"><span class="aw-chip">Rice</span><span class="aw-chip">Wheat</span><span class="aw-chip">Sugar</span><span class="aw-chip">Maize</span></div>
		</article>
		<article class="aw-card" data-aw-reveal>
			<h3>Minerals &amp; Bulk</h3>
			<div class="aw-chips"><span class="aw-chip">Iron Ore</span><span class="aw-chip">Bauxite</span><span class="aw-chip">Gypsum</span><span class="aw-chip">Limestone</span></div>
		</article>
		<article class="aw-card" data-aw-reveal>
			<h3>Industrial Cargo</h3>
			<div class="aw-chips"><span class="aw-chip">Steel</span><span class="aw-chip">Alumina</span><span class="aw-chip">Fertilizers</span></div>
		</article>
		<article class="aw-card" data-aw-reveal>
			<h3>Project Cargo</h3>
			<div class="aw-chips"><span class="aw-chip">Heavy Equipment</span><span class="aw-chip">Industrial Components</span><span class="aw-chip">Break Bulk Cargo</span></div>
		</article>
	</div>
</section>

<section class="aw-section aw-section--soft">
	<div class="aw-section__inner">
		<div class="aw-feature-row" data-aw-reveal>
			<div class="aw-feature-row__copy">
				<p class="aw-kicker">Flow</p>
				<h2 class="aw-h2">How Cargo Moves Through Delta Ports</h2>
				<p class="aw-sub">A seamless, integrated workflow from vessel arrival to inland dispatch.</p>
			</div>
			<div class="aw-feature-row__media">
				<img src="{$flow}" alt="Cargo movement workflow" loading="lazy" width="960" height="640" />
			</div>
		</div>
		<div class="aw-process" data-aw-reveal>
			<div class="aw-process__step"><span>1</span><h4>Vessel Arrival</h4><p>Arrival coordination and readiness</p></div>
			<div class="aw-process__step"><span>2</span><h4>Berth Allocation</h4><p>Efficient berth planning</p></div>
			<div class="aw-process__step"><span>3</span><h4>Cargo Handling</h4><p>Discharge &amp; load operations</p></div>
			<div class="aw-process__step"><span>4</span><h4>Storage &amp; Warehousing</h4><p>Secure yard &amp; covered capacity</p></div>
			<div class="aw-process__step"><span>5</span><h4>Rail Loading</h4><p>Direct rail evacuation</p></div>
			<div class="aw-process__step"><span>6</span><h4>Road Dispatch</h4><p>Highway corridor connectivity</p></div>
			<div class="aw-process__step"><span>7</span><h4>Final Delivery</h4><p>Hinterland last-mile completion</p></div>
		</div>
	</div>
</section>

<section class="aw-section aw-section--dark">
	<div class="aw-section__inner" data-aw-reveal>
		<p class="aw-kicker">Next step</p>
		<h2 class="aw-h2">Move Your Business Forward</h2>
		<p style="max-width:36rem;margin:0 0 1.5rem">Partner with Delta Ports for reliable port operations, cargo handling, and integrated logistics across India’s maritime gateways.</p>
		<a class="aw-btn aw-btn--fill" href="/contact-us/"><span>Contact Us</span><em>→</em></a>
	</div>
</section>
</div>
<!-- /wp:html -->
HTML;
}

/**
 * Cargo handling — full live content parity.
 */
function delta_ports_content_cargo() {
	$hero = delta_ports_aw_inner_hero(
		'Cargo Handling Capabilities',
		'Cargo Handling Capabilities',
		'We provide comprehensive cargo handling services across breakbulk, project cargo, and container operations.',
		'Terminal-Infrastructure-And-Yard-Facilities-scaled.webp'
	);
	$yard  = delta_ports_img( 'Terminal-Infrastructure-And-Yard-Facilities-scaled.webp' );
	$eq1   = delta_ports_img( 'mob-Port-let-Operating-Philosophy-01.webp' );
	$eq2   = delta_ports_img( 'mob-Port-let-Operating-Philosophy-2.webp' );
	$store = delta_ports_img( 'cargo-new-img-4.webp' );
	$safe  = delta_ports_img( 'cargo-handleing9.webp' );
	$env   = delta_ports_img( 'cargo-handleing8.webp' );
	$prof  = delta_ports_img( 'cargo-new-img-5.webp' );

	return <<<HTML
<!-- wp:html -->
<div class="aw-page aw-cargo" data-aw-page="cargo">
{$hero}

<section class="aw-section">
	<div data-aw-reveal>
		<p class="aw-kicker">Capacity</p>
		<h2 class="aw-h2">Cargo Handling Capabilities</h2>
		<p class="aw-sub">Efficient handling of bulk, breakbulk, and containerised cargo supported by modern equipment, structured workflows, and dedicated storage infrastructure.</p>
	</div>
	<div class="aw-grid-4 aw-stat-row" style="margin-top:1.75rem">
		<div class="aw-card aw-stat-card" data-aw-reveal><strong class="aw-stat-num aw-stat-num--sm">6 Million MT</strong><p>Bulk Cargo Handling Capacity</p></div>
		<div class="aw-card aw-card--dark aw-stat-card" data-aw-reveal><strong class="aw-stat-num aw-stat-num--sm">0.15 Million TEU</strong><p>Container Handling Capacity</p></div>
		<div class="aw-card aw-stat-card" data-aw-reveal><strong class="aw-stat-num aw-stat-num--sm">~0.2 Million TEU</strong><p>Covered Storage Capacity</p></div>
		<div class="aw-card aw-stat-card" data-aw-reveal><strong class="aw-stat-num aw-stat-num--sm">4–5 Lakh MT</strong><p>Yard Storage Capacity</p></div>
	</div>
</section>

<section class="aw-section aw-section--soft">
	<div class="aw-section__inner">
		<div class="aw-feature-row" data-aw-reveal>
			<div class="aw-feature-row__copy">
				<p class="aw-kicker">Infrastructure</p>
				<h2 class="aw-h2">Terminal Infrastructure And Yard Facilities</h2>
				<p class="aw-sub">Terminal infrastructure is designed to support operational efficiency and safety across cargo handling zones. Facilities include paved yard areas, defined operational zones, and internal circulation systems that support orderly cargo movement and staging.</p>
			</div>
			<div class="aw-feature-row__media">
				<img src="{$yard}" alt="Terminal infrastructure and yard facilities" loading="lazy" width="960" height="640" />
			</div>
		</div>
	</div>
</section>

<section class="aw-section">
	<div data-aw-reveal>
		<p class="aw-kicker">Equipment</p>
		<h2 class="aw-h2">Equipment &amp; Handling Systems</h2>
		<p class="aw-sub">Delta Ports deploys a range of handling &amp; support equipment to meet operational requirements.</p>
	</div>
	<div class="aw-grid-2" style="margin-top:1.5rem">
		<article class="aw-card aw-media-card" data-aw-reveal>
			<img src="{$eq1}" alt="Port maintenance and cargo equipment" loading="lazy" width="800" height="500" />
			<div class="aw-media-card__body">
				<h3>Port Maintenance Vehicles</h3>
				<p>Road sweepers and mist cannon vehicles for dust suppression and cleanliness.</p>
			</div>
		</article>
		<article class="aw-card aw-media-card" data-aw-reveal>
			<img src="{$eq2}" alt="Cargo handling equipment" loading="lazy" width="800" height="500" />
			<div class="aw-media-card__body">
				<h3>Cargo Handling Equipment</h3>
				<p>Forklifts, loaders, excavators, tippers, and trailers supporting yard and vessel-side workflows.</p>
			</div>
		</article>
		<article class="aw-card" data-aw-reveal>
			<h3>Mobile Harbour Cranes</h3>
			<p>2 units with <strong>125 MT</strong> lifting capacity each for high-volume vessel operations.</p>
		</article>
		<article class="aw-card" data-aw-reveal>
			<h3>Heavy-Lift and Project Cargo Cranes</h3>
			<p>Jib and knuckle cranes for oversized and project cargo requirements.</p>
		</article>
	</div>
</section>

<section class="aw-section aw-section--soft">
	<div class="aw-section__inner">
		<div class="aw-feature-row aw-feature-row--flip" data-aw-reveal>
			<div class="aw-feature-row__copy">
				<p class="aw-kicker">Storage</p>
				<h2 class="aw-h2">Storage &amp; Support Infrastructure</h2>
				<p class="aw-sub">The terminal provides ample storage capacity for varied cargo requirements.</p>
				<div class="aw-grid-2" style="margin-top:1.25rem">
					<article class="aw-card">
						<h3>Covered Storage</h3>
						<ul class="aw-list">
							<li>3 covered sheds</li>
							<li>Individual capacities ranging from approximately 15,000 to 20,000 MT</li>
						</ul>
					</article>
					<article class="aw-card">
						<h3>Open Storage</h3>
						<ul class="aw-list">
							<li>Extensive open yard space</li>
							<li>Total capacity of approximately 4 to 5 lakh tonnes</li>
						</ul>
					</article>
				</div>
			</div>
			<div class="aw-feature-row__media">
				<img src="{$store}" alt="Storage and support infrastructure" loading="lazy" width="960" height="640" />
			</div>
		</div>
	</div>
</section>

<section class="aw-section">
	<div class="aw-feature-row" data-aw-reveal>
		<div class="aw-feature-row__copy">
			<p class="aw-kicker">Safety</p>
			<h2 class="aw-h2">Terminal Safety &amp; Security Infrastructure</h2>
			<p class="aw-sub">Security and surveillance are integral to terminal operations, with systems designed to ensure controlled access, operational safety, and compliance with regulatory standards across all cargo handling zones.</p>
			<ul class="aw-list">
				<li>CCTV surveillance across operational and storage zones</li>
				<li>24/7 security personnel</li>
				<li>Boom barriers with integrated scanners at entry points</li>
				<li>Rigorous traffic inspections for inbound and outbound vehicles</li>
			</ul>
		</div>
		<div class="aw-feature-row__media">
			<img src="{$safe}" alt="Terminal safety and security" loading="lazy" width="960" height="640" />
		</div>
	</div>
</section>

<section class="aw-section aw-section--soft">
	<div class="aw-section__inner">
		<div class="aw-grid-2">
			<article class="aw-card aw-media-card" data-aw-reveal>
				<img src="{$env}" alt="Environmental standards" loading="lazy" width="800" height="500" />
				<div class="aw-media-card__body">
					<h3>Environmental Standards</h3>
					<p>Terminal operations adhere to environmental best practices. Environmental responsibility is integrated into daily terminal activities.</p>
					<ul class="aw-list">
						<li>Dust suppression using mist cannon vehicles</li>
						<li>Mechanised road sweeping</li>
						<li>Compliance with pollution control norms</li>
					</ul>
				</div>
			</article>
			<article class="aw-card aw-media-card" data-aw-reveal>
				<img src="{$prof}" alt="Cargo profiles supported" loading="lazy" width="800" height="500" />
				<div class="aw-media-card__body">
					<h3>Cargo Profiles Supported</h3>
					<p>The terminal is equipped to handle a wide range of cargo categories across imports and exports.</p>
					<ul class="aw-list">
						<li>Minerals and ores: iron ore, bauxite, gypsum, limestone</li>
						<li>Industrial and construction cargo: steel coils, project cargo</li>
						<li>General and bulk cargo: woodchips, containers, and other bulk cargo</li>
					</ul>
				</div>
			</article>
		</div>
	</div>
</section>

<section class="aw-section">
	<div data-aw-reveal>
		<p class="aw-kicker">FAQ</p>
		<h2 class="aw-h2">Frequently asked questions</h2>
	</div>
	<div class="aw-faq" data-aw-reveal style="margin-top:1.25rem">
		<details open>
			<summary>What cargo handling facilities are available at Delta Ports terminals?</summary>
			<p>Delta Ports terminals are equipped with modern cargo handling systems, including mobile harbour cranes, cargo handling equipment, and heavy-lift cranes to support diverse cargo requirements.</p>
		</details>
		<details>
			<summary>What types of cargo can be handled at the terminal?</summary>
			<p>The terminal supports minerals and ores, industrial and construction cargo, general cargo, bulk cargo, and containers, subject to operational conditions.</p>
		</details>
		<details>
			<summary>Is storage available for weather-sensitive cargo?</summary>
			<p>Yes. The terminal provides covered storage sheds suitable for weather-sensitive cargo, along with extensive open storage areas for bulk and non-perishable cargo.</p>
		</details>
		<details>
			<summary>What security measures are in place at the terminal?</summary>
			<p>Security infrastructure includes CCTV surveillance, 24/7 security personnel, controlled access points with scanners, and strict vehicle inspection procedures.</p>
		</details>
	</div>
</section>

<section class="aw-section aw-section--dark">
	<div class="aw-section__inner" data-aw-reveal>
		<p class="aw-kicker">Next step</p>
		<h2 class="aw-h2">Move Your Business Forward</h2>
		<p style="max-width:36rem;margin:0 0 1.5rem">Partner with Delta Ports for reliable cargo handling, yard capacity, and terminal infrastructure.</p>
		<a class="aw-btn aw-btn--fill" href="/contact-us/"><span>Contact Us</span><em>→</em></a>
	</div>
</section>
</div>
<!-- /wp:html -->
HTML;
}

/**
 * Logistics — full live content parity.
 */
function delta_ports_content_logistics() {
	$hero = delta_ports_aw_inner_hero(
		'Integrated Port Logistics',
		'Integrated Port Logistics',
		'Streamline operations across terminals, warehouses and transport networks. Real-time visibility, predictive analytics, and automated workflows help you move cargo faster, reduce costs, and improve safety.',
		'mob-operation-01.webp'
	);
	$rail = delta_ports_img( 'integraded-port-logistic-new-img1.webp' );
	$road = delta_ports_img( 'Road-Highway-Access-scaled.webp' );
	$std  = delta_ports_img( 'mob-Port-let-Operating-Philosophy-3.webp' );
	$foc  = delta_ports_img( 'mob-Port-let-Operating-Philosophy-4.webp' );
	$resp = delta_ports_img( 'mob-Responsible-Compliant-Operations-01.webp' );

	return <<<HTML
<!-- wp:html -->
<div class="aw-page aw-logistics" data-aw-page="logistics">
{$hero}

<section class="aw-section">
	<div data-aw-reveal>
		<p class="aw-kicker">Overview</p>
		<p class="aw-lead">Delta Ports supports integrated port logistics that enable efficient movement of cargo beyond terminal boundaries. Connectivity infrastructure is designed to reduce dwell time, improve evacuation speed, and support supply-chain continuity.</p>
	</div>
</section>

<section class="aw-section aw-section--soft">
	<div class="aw-section__inner">
		<div class="aw-feature-row" data-aw-reveal>
			<div class="aw-feature-row__copy">
				<p class="aw-kicker">Rail</p>
				<h2 class="aw-h2">Rail Connectivity</h2>
				<p class="aw-sub">The terminal features dedicated rail infrastructure to support efficient cargo evacuation.</p>
				<ul class="aw-list">
					<li>2 railway sidings within the port premises</li>
					<li>Direct loading and unloading at terminal locations</li>
					<li>Supports smooth rail evacuation and reduced cargo congestion</li>
					<li>Rail connectivity enables integration with inland logistics and consumption centres</li>
				</ul>
			</div>
			<div class="aw-feature-row__media">
				<img src="{$rail}" alt="Rail connectivity at Delta Ports" loading="lazy" width="960" height="640" />
			</div>
		</div>
	</div>
</section>

<section class="aw-section">
	<div class="aw-feature-row aw-feature-row--flip" data-aw-reveal>
		<div class="aw-feature-row__copy">
			<p class="aw-kicker">Road</p>
			<h2 class="aw-h2">Road &amp; Highway Access</h2>
			<p class="aw-sub">Road infrastructure enhances terminal accessibility and operational efficiency. This infrastructure supports faster cargo movement and improved turnaround times.</p>
			<ul class="aw-list">
				<li>Traffic bypass system to avoid city congestion</li>
				<li>Newly constructed curved cable-stayed bridge providing direct port access</li>
				<li>Uninterrupted highway connectivity from port to road networks</li>
			</ul>
		</div>
		<div class="aw-feature-row__media">
			<img src="{$road}" alt="Road and highway access" loading="lazy" width="960" height="640" />
		</div>
	</div>
</section>

<section class="aw-section aw-section--soft">
	<div class="aw-section__inner">
		<div class="aw-feature-row" data-aw-reveal>
			<div class="aw-feature-row__copy">
				<p class="aw-kicker">Governance</p>
				<h2 class="aw-h2">Responsible &amp; Compliant Operations</h2>
				<p class="aw-sub">Terminal operations are governed by structured sustainability practices, regulatory compliance, and accountable frameworks that support efficient performance, environmental responsibility, and long-term operational reliability.</p>
			</div>
			<div class="aw-feature-row__media">
				<img src="{$resp}" alt="Responsible and compliant operations" loading="lazy" width="960" height="640" />
			</div>
		</div>
		<div class="aw-grid-2" style="margin-top:1.5rem">
			<article class="aw-card aw-media-card" data-aw-reveal>
				<img src="{$std}" alt="World-class port operations" loading="lazy" width="800" height="500" />
				<div class="aw-media-card__body">
					<h3>World-Class Port Operations &amp; International Standards</h3>
					<p>We deliver world-class port operations built to international standards, utilizing advanced infrastructure and modern handling equipment for high efficiency.</p>
				</div>
			</article>
			<article class="aw-card aw-media-card" data-aw-reveal>
				<img src="{$foc}" alt="Logistics focus" loading="lazy" width="800" height="500" />
				<div class="aw-media-card__body">
					<h3>Logistics Focus</h3>
					<p>Our systems are optimized to reduce vessel turnaround time, enhance throughput, and minimize operational costs through flow optimization and advanced cargo allocation.</p>
				</div>
			</article>
		</div>
	</div>
</section>

<section class="aw-section">
	<div data-aw-reveal>
		<p class="aw-kicker">FAQ</p>
		<h2 class="aw-h2">Frequently asked questions</h2>
	</div>
	<div class="aw-faq" data-aw-reveal style="margin-top:1.25rem">
		<details open>
			<summary>What is integrated port logistics at Delta Ports?</summary>
			<p>Integrated port logistics refers to the coordination of port operations with road and rail connectivity to enable efficient movement of cargo between the terminal and hinterland destinations.</p>
		</details>
		<details>
			<summary>Does the terminal have rail connectivity?</summary>
			<p>Yes. The terminal includes two railway sidings within the port premises, allowing direct loading and unloading of cargo for rail evacuation.</p>
		</details>
		<details>
			<summary>How is road access to the terminal managed?</summary>
			<p>The terminal is connected via a dedicated curved cable-stayed bridge that provides direct highway access and bypasses city traffic, reducing congestion and delays.</p>
		</details>
		<details>
			<summary>How does integrated logistics improve cargo movement?</summary>
			<p>By coordinating port operations with rail and road infrastructure, integrated logistics reduces dwell time, improves cargo flow, and enhances overall supply-chain efficiency.</p>
		</details>
	</div>
</section>

<section class="aw-section aw-section--dark">
	<div class="aw-section__inner" data-aw-reveal>
		<p class="aw-kicker">Next step</p>
		<h2 class="aw-h2">Move Your Business Forward</h2>
		<p style="max-width:36rem;margin:0 0 1.5rem">Partner with Delta Ports for multimodal connectivity and reliable hinterland cargo flow.</p>
		<a class="aw-btn aw-btn--fill" href="/contact-us/"><span>Contact Us</span><em>→</em></a>
	</div>
</section>
</div>
<!-- /wp:html -->
HTML;
}

/**
 * Sustainability.
 */
function delta_ports_content_sustainability() {
	$hero = delta_ports_aw_inner_hero(
		'Sustainability',
		'Sustainability',
		"We're committed to reducing our environmental impact across operations, supply chains, and communities.",
		'mobile-banner-Port-Sustainability.webp'
	);
	$img_approach = delta_ports_img( 'mob-Our-App-roach-to-Sustainability.webp' );
	$img_safety   = delta_ports_img( 'mob-Terminal-Safety.webp' );
	$img_term     = delta_ports_img( 'mob-Sustainable-Terminal-Operations.webp' );
	$img_home     = delta_ports_img( 'mob-Sustainability-home.webp' );

	return <<<HTML
<!-- wp:html -->
<div class="aw-page aw-sustain-page" data-aw-page="sustainability">
{$hero}
<section class="aw-section">
	<div class="aw-grid-2">
		<article class="aw-card" data-aw-reveal>
			<img src="{$img_approach}" alt="Our approach to sustainability" loading="lazy" width="800" height="520" style="border-radius:.75rem;margin-bottom:1rem;width:100%;height:auto;object-fit:cover" />
			<h3>Our Approach to Sustainability</h3>
			<p>Sustainability is embedded into day-to-day operations rather than positioned as a standalone initiative — guiding port-led ops, cargo infrastructure, and logistics.</p>
		</article>
		<article class="aw-card" data-aw-reveal>
			<img src="{$img_safety}" alt="Terminal safety" loading="lazy" width="800" height="520" style="border-radius:.75rem;margin-bottom:1rem;width:100%;height:auto;object-fit:cover" />
			<h3>Safety and Occupational Responsibility</h3>
			<p>We prioritise safe working environments for employees, contractors, and partners through structured protocols and continuous training.</p>
		</article>
		<article class="aw-card aw-card--dark" data-aw-reveal>
			<img src="{$img_home}" alt="Sustainable operations" loading="lazy" width="800" height="520" style="border-radius:.75rem;margin-bottom:1rem;width:100%;height:auto;object-fit:cover;opacity:.92" />
			<h3>Committed to Sustainable Operations</h3>
			<p>Battery-powered trucks, hybrid-electric harbour cranes, EVs for container ops, and solar initiatives under development.</p>
		</article>
		<article class="aw-card" data-aw-reveal>
			<img src="{$img_term}" alt="Sustainable terminal operations" loading="lazy" width="800" height="520" style="border-radius:.75rem;margin-bottom:1rem;width:100%;height:auto;object-fit:cover" />
			<h3>Sustainable Terminal Operations</h3>
			<p>Terminal infrastructure managed for efficient resource utilisation and reduced environmental impact across berth, yard, and logistics workflows.</p>
		</article>
	</div>
	<div class="aw-grid-2" style="margin-top:1rem">
		<article class="aw-card" data-aw-reveal><h4>Dust and Emission Control</h4><p>Mist cannon vehicles for effective dust suppression across operational zones.</p></article>
		<article class="aw-card" data-aw-reveal><h4>Clean &amp; Orderly Operations</h4><p>Mechanised road sweeping and strict pollution-control compliance.</p></article>
	</div>
	<div class="aw-grid-2" style="margin-top:1rem">
		<article class="aw-card" data-aw-reveal><h3>Compliance &amp; Governance</h3><p>Environmental and safety governance embedded into operational decision-making and upgrades.</p></article>
		<article class="aw-card" data-aw-reveal><h3>Continuous Improvement</h3><p>Sustainability integrated into planning, maintenance, and infrastructure upgrades.</p></article>
	</div>
	<h2 data-aw-reveal style="font-size:clamp(1.6rem,3vw,2.2rem);letter-spacing:-.03em;margin:2rem 0 1rem">Frequently asked questions</h2>
	<div class="aw-faq" data-aw-reveal>
		<details open><summary>What sustainability initiatives are underway?</summary><p>Electrified equipment, EV container ops, solar initiatives, dust suppression, and pollution-control systems.</p></details>
		<details><summary>How is environmental compliance ensured?</summary><p>Through operational controls, monitoring, and adherence to applicable pollution norms.</p></details>
	</div>
</section>
<section class="aw-section aw-section--dark"><div class="aw-section__inner" data-aw-reveal>
	<h2 style="font-size:clamp(2rem,4vw,3rem);letter-spacing:-.035em;margin:0 0 1rem">Move Your Business Forward</h2>
	<p style="max-width:34rem;margin:0 0 1.5rem">Partner with Delta Ports for reliable port operations and responsible terminal infrastructure.</p>
	<a class="aw-btn aw-btn--fill" href="/contact-us/"><span>Contact Us</span><em>→</em></a>
</div></section>
</div>
<!-- /wp:html -->
HTML;
}

/**
 * Contact.
 */
function delta_ports_content_contact() {
	$hero = delta_ports_aw_inner_hero(
		'Contact Us',
		'Contact Us',
		'Reach Delta Ports in Mangalore, Bangalore, and Dammam for port operations, logistics services, and business enquiries.',
		'des-banner-Port-leadership.webp'
	);

	$map_hq  = 'https://www.openstreetmap.org/export/embed.html?bbox=74.84%2C12.88%2C74.90%2C12.93&layer=mapnik&marker=12.905%2C74.870';
	$map_blr = 'https://www.openstreetmap.org/export/embed.html?bbox=77.60%2C12.96%2C77.63%2C12.98&layer=mapnik&marker=12.9716%2C77.6197';
	$map_sa  = 'https://www.openstreetmap.org/export/embed.html?bbox=50.07%2C26.38%2C50.15%2C26.45&layer=mapnik&marker=26.4207%2C50.0888';

	$contact_id = function_exists( 'delta_ports_get_or_create_contact_form' ) ? (int) delta_ports_get_or_create_contact_form() : 0;
	$talent_id  = function_exists( 'delta_ports_get_or_create_talent_form' ) ? (int) delta_ports_get_or_create_talent_form() : 0;

	if ( ! $contact_id && ! $talent_id ) {
		$forms = get_posts(
			array(
				'post_type'      => 'wpcf7_contact_form',
				'posts_per_page' => 1,
				'post_status'    => 'publish',
				'fields'         => 'ids',
			)
		);
		$contact_id = $forms ? (int) $forms[0] : 0;
	}

	$contact_shortcode = $contact_id
		? '[contact-form-7 id="' . $contact_id . '" title="Business Enquiry"]'
		: '';
	$talent_shortcode  = $talent_id
		? '[contact-form-7 id="' . $talent_id . '" title="Talent Network"]'
		: '';

	return <<<HTML
<!-- wp:html -->
<div class="aw-page aw-contact" data-aw-page="contact">
{$hero}
<section class="aw-section">
	<div class="aw-office-grid aw-office-grid--maps">
		<article class="aw-card aw-office-card" data-aw-reveal>
			<div class="aw-map"><iframe title="Head Quarters map" src="{$map_hq}" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
			<div class="aw-office-card__body">
				<h3>Head Quarters</h3>
				<p>Delta House, 6th Floor, Bangra Kulur Road, Kulur, Mangalore - 575013, Karnataka, India.</p>
				<p class="aw-office-meta"><strong>Office hours</strong><br>9am - 5.30pm Monday - Friday<br>9am - 2pm Saturday</p>
				<p class="aw-office-meta"><a href="tel:+919902395555">99023 95555</a></p>
				<p class="aw-office-meta"><a href="https://www.google.com/maps/search/?api=1&amp;query=Delta+House+Bangra+Kulur+Road+Mangalore" target="_blank" rel="noopener">Open in Google Maps</a></p>
			</div>
		</article>
		<article class="aw-card aw-office-card" data-aw-reveal>
			<div class="aw-map"><iframe title="Bangalore Office map" src="{$map_blr}" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
			<div class="aw-office-card__body">
				<h3>Bangalore Office</h3>
				<p>Tower-B, Unit No. 407, No.84, Mahatma Gandhi Rd, Shanthala Nagar, Ashok Nagar, Bengaluru, Karnataka 560001</p>
				<p class="aw-office-meta"><strong>Office hours</strong><br>10am - 6pm Monday - Friday<br>10am - 4pm Saturday</p>
				<p class="aw-office-meta"><a href="tel:+919480849765">+91 94808 49765</a></p>
				<p class="aw-office-meta"><a href="https://www.google.com/maps/search/?api=1&amp;query=Mahatma+Gandhi+Rd+Ashok+Nagar+Bengaluru+560001" target="_blank" rel="noopener">Open in Google Maps</a></p>
			</div>
		</article>
		<article class="aw-card aw-office-card" data-aw-reveal>
			<div class="aw-map"><iframe title="Saudi Arabia Office map" src="{$map_sa}" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
			<div class="aw-office-card__body">
				<h3>Saudi Arabia Office</h3>
				<p>King Faisal Ibn Abd Al Aziz, Al Khalidiyyah Al Janubiyyah, Dammam 32221, Saudi Arabia</p>
				<p class="aw-office-meta"><strong>Office hours</strong><br>8am - 5pm Sunday - Thursday</p>
				<p class="aw-office-meta"><a href="tel:+966561416184">+966 561 416 184</a></p>
				<p class="aw-office-meta"><a href="https://www.google.com/maps/search/?api=1&amp;query=King+Faisal+Ibn+Abd+Al+Aziz+Dammam+32221" target="_blank" rel="noopener">Open in Google Maps</a></p>
			</div>
		</article>
	</div>
</section>
<section class="aw-section aw-section--soft"><div class="aw-section__inner" data-aw-reveal>
	<p class="aw-kicker">Enquiries</p>
	<h2 style="font-size:clamp(1.9rem,3.5vw,2.8rem);letter-spacing:-.03em;margin:0 0 .75rem">Send a Business Enquiry</h2>
	<p class="aw-sub">Tell us about your cargo, terminal, or logistics requirements and our team will respond promptly.</p>
	<p style="margin:1rem 0 0"><a href="mailto:info@deltaports.com" style="color:#ec2633;font-weight:700;text-decoration:none">info@deltaports.com</a> · <a href="tel:+919902395555" style="color:#ec2633;font-weight:700;text-decoration:none">99023 95555</a></p>
</div></section>
</div>
<!-- /wp:html -->

<!-- wp:group {"className":"aw-cf7-section","layout":{"type":"constrained","contentSize":"840px"}} -->
<div class="wp-block-group aw-cf7-section">
	<!-- wp:shortcode -->
	{$contact_shortcode}
	<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->

<!-- wp:html -->
<div class="aw-page aw-contact">
<section class="aw-section aw-section--soft"><div class="aw-section__inner" data-aw-reveal>
	<p class="aw-kicker">Careers</p>
	<h2 style="font-size:clamp(1.9rem,3.5vw,2.8rem);letter-spacing:-.03em;margin:0 0 .75rem">Join Our Talent Network</h2>
	<p class="aw-sub">We are always interested in engaging with professionals who share our values and wish to grow with an infrastructure-led organisation.</p>
	<p class="aw-sub" style="margin-top:.75rem">Fields: Full Name · Email · Mobile · Business Vertical · Years of Experience · Resume</p>
</div></section>
</div>
<!-- /wp:html -->

<!-- wp:group {"className":"aw-cf7-section aw-cf7-section--talent","layout":{"type":"constrained","contentSize":"840px"}} -->
<div class="wp-block-group aw-cf7-section aw-cf7-section--talent">
	<!-- wp:shortcode -->
	{$talent_shortcode}
	<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->
HTML;
}


/**
 * Privacy — keep readable legal layout but premium shell.
 */
function delta_ports_content_privacy() {
	return <<<HTML
<!-- wp:html -->
<div class="aw-page">
<section class="aw-section" style="max-width:860px">
	<nav class="aw-crumb"><a href="/">Home</a><span>/</span><span>Privacy Policy</span></nav>
	<h1 style="font-size:clamp(2.2rem,4vw,3.2rem);letter-spacing:-.035em;margin:.5rem 0 1rem;color:#0c0c12">Privacy Policy</h1>
	<div class="aw-card" style="padding:2rem">
		<p>We are committed to protecting the privacy of visitors and users of our Website. By accessing or using the Website, you agree to the terms of this Privacy Policy.</p>
		<h2 style="margin-top:1.75rem;font-size:1.25rem">Sources and Categories of Personal Data Concerned</h2>
		<p>We may collect personal information that you voluntarily provide when you contact us through forms, email, or other communication channels, including name, contact details, professional information, and any other information you choose to share.</p>
		<h2 style="margin-top:1.5rem;font-size:1.25rem">Use of Information</h2>
		<p>The information collected is used to respond to inquiries, provide and improve our services, communicate with you, operate the website, and comply with legal obligations. We do not sell, rent, or trade your personal information to third parties.</p>
		<h2 style="margin-top:1.5rem;font-size:1.25rem">Cookies</h2>
		<p>Our Website may use cookies and similar technologies to enhance your browsing experience and analyze website traffic. You may disable cookies through your browser settings.</p>
		<h2 style="margin-top:1.5rem;font-size:1.25rem">Data Security</h2>
		<p>We implement reasonable administrative and technical safeguards to protect your personal information. No method of online transmission is completely secure.</p>
		<h2 style="margin-top:1.5rem;font-size:1.25rem">Third-Party Links</h2>
		<p>The Website may contain links to external websites. We are not responsible for their privacy practices or content.</p>
		<h2 style="margin-top:1.5rem;font-size:1.25rem">User Rights – Access to Your Personal Data</h2>
		<p>Subject to applicable laws, you may request access to, correction of, or deletion of your personal information by contacting us.</p>
		<h2 style="margin-top:1.5rem;font-size:1.25rem">Changes to This Policy</h2>
		<p>We may update this Privacy Policy at any time. Changes will be posted on this page.</p>
		<h2 style="margin-top:1.5rem;font-size:1.25rem">Contact Us</h2>
		<p>Email: enquiries@groupdelta.in<br>Phone: +91 99023 95555</p>
	</div>
</section>
</div>
<!-- /wp:html -->
HTML;
}

/**
 * Terms.
 */
function delta_ports_content_terms() {
	return <<<HTML
<!-- wp:html -->
<div class="aw-page">
<section class="aw-section" style="max-width:860px">
	<nav class="aw-crumb"><a href="/">Home</a><span>/</span><span>Terms &amp; Conditions</span></nav>
	<h1 style="font-size:clamp(2.2rem,4vw,3.2rem);letter-spacing:-.035em;margin:.5rem 0 1rem;color:#0c0c12">Terms and Conditions</h1>
	<div class="aw-card" style="padding:2rem">
		<p><strong>Last updated:</strong> May 03, 2026</p>
		<p>Please read these terms and conditions carefully before using our service.</p>
		<h2 style="margin-top:1.5rem;font-size:1.25rem">1. Introduction</h2>
		<p>Visitors to this website are bound by the following Terms and Conditions ("Terms"). If you do not agree, discontinue use of the website immediately. Content is for general information and may change without notice.</p>
		<h2 style="margin-top:1.5rem;font-size:1.25rem">2. Cookies and Information Processing</h2>
		<p>This website may use cookies to monitor browsing preferences. By continuing to use the website, you consent to such usage where required.</p>
		<h2 style="margin-top:1.5rem;font-size:1.25rem">3. Warranties and Limitation of Liability</h2>
		<p>Neither Delta Group nor third parties guarantee accuracy, completeness, or suitability of materials. Use of information is at your own risk.</p>
		<h2 style="margin-top:1.5rem;font-size:1.25rem">4. Intellectual Property</h2>
		<p>All content including design, graphics, and logos is owned by or licensed to Delta Group. Unauthorized reproduction is prohibited.</p>
		<h2 style="margin-top:1.5rem;font-size:1.25rem">5. Links to Other Websites</h2>
		<p>Third-party links are for convenience. Delta Group does not endorse external websites.</p>
		<h2 style="margin-top:1.5rem;font-size:1.25rem">6. Unauthorized Use</h2>
		<p>Unauthorized use may result in claims for damages and/or constitute a criminal offence.</p>
		<h2 style="margin-top:1.5rem;font-size:1.25rem">7. Governing Law and Dispute Resolution</h2>
		<p>These Terms are governed by the laws of India. Disputes are subject to the exclusive jurisdiction of competent courts in Ahmedabad, India.</p>
		<h2 style="margin-top:1.5rem;font-size:1.25rem">Contact Us</h2>
		<p>Email: enquiries@groupdelta.in<br>Phone: +91 99023 95555</p>
	</div>
</section>
</div>
<!-- /wp:html -->
HTML;
}

