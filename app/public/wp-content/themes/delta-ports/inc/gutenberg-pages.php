<?php
/**
 * Pure Gutenberg page content (core blocks only — no Custom HTML).
 * Live site copy preserved for editors.
 *
 * @package Delta_Ports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once DELTA_PORTS_DIR . '/inc/gutenberg-helpers.php';
require_once DELTA_PORTS_DIR . '/inc/ops-pages-content.php';

/**
 * Video URL helper (if not already defined).
 */
if ( ! function_exists( 'delta_ports_vid' ) ) {
	/**
	 * Theme video URL.
	 *
	 * @param string $rel Relative path.
	 * @return string
	 */
	function delta_ports_vid( $rel ) {
		return esc_url( DELTA_PORTS_URI . '/assets/video/' . ltrim( $rel, '/' ) );
	}
}

/**
 * Home page — matches live vipaccounts.org/delta-ports homepage design.
 *
 * @return string
 */
function delta_ports_content_home() {
	$map  = delta_ports_img( 'delta-map-sec-bg-new-scaled-1.webp' );
	$vid  = delta_ports_vid( 'home-banner.mp4' );
	// Prefer sharper live photos over tiny mobile webps when available.
	$op1  = file_exists( DELTA_PORTS_DIR . '/assets/images/new-delta-port-new1.webp' )
		? delta_ports_img( 'new-delta-port-new1.webp' )
		: delta_ports_img( 'our-operation-delta-port1.webp' );
	$op2  = file_exists( DELTA_PORTS_DIR . '/assets/images/Component-23.webp' )
		? delta_ports_img( 'Component-23.webp' )
		: delta_ports_img( 'our-operation-delta-port2.webp' );
	$op3  = file_exists( DELTA_PORTS_DIR . '/assets/images/Component-24.webp' )
		? delta_ports_img( 'Component-24.webp' )
		: ( file_exists( DELTA_PORTS_DIR . '/assets/images/Component-7.webp' )
			? delta_ports_img( 'Component-7.webp' )
			: delta_ports_img( 'our-operation-delta-port3.webp' ) );
	$op4  = delta_ports_img( 'our-operation-delta-port4.webp' );
	// Live company-section video (3rd section).
	$company_vid = '';
	if ( file_exists( DELTA_PORTS_DIR . '/assets/video/company-section.mp4' ) ) {
		$company_vid = delta_ports_vid( 'company-section.mp4' );
	} elseif ( file_exists( DELTA_PORTS_DIR . '/assets/video/company-section.webm' ) ) {
		$company_vid = delta_ports_vid( 'company-section.webm' );
	} elseif ( file_exists( DELTA_PORTS_DIR . '/assets/video/home-banner-alt.mp4' ) ) {
		$company_vid = delta_ports_vid( 'home-banner-alt.mp4' );
	}
	$sus  = file_exists( DELTA_PORTS_DIR . '/assets/images/sustanability-new-banner5.webp' )
		? delta_ports_img( 'sustanability-new-banner5.webp' )
		: $op4;
	$a1   = delta_ports_img( 'Awards-new-1.webp' );
	$a8   = delta_ports_img( 'Awards-new-8.webp' );
	$a9   = delta_ports_img( 'Awards-new-9.webp' );
	$a10  = delta_ports_img( 'Awards-new-10.webp' );

	$out = '';

	// Hero — video src attribute (survives WP KSES better than nested <source>).
	$hero_media = file_exists( DELTA_PORTS_DIR . '/assets/video/home-banner.mp4' )
		? '<video class="dp-home-hero__media" src="' . esc_url( $vid ) . '" autoplay muted loop playsinline poster="' . esc_url( $map ) . '"></video>'
		: '<div class="dp-home-hero__media" style="background-image:url(\'' . esc_url( $map ) . '\')"></div>';
	$hero_html  = '<!-- wp:html -->
<section class="dp-home-hero">
	' . $hero_media . '
	<div class="dp-home-hero__overlay" aria-hidden="true"></div>
	<div class="dp-home-hero__inner">
		<div class="dp-home-hero__left">
			<h1>Accelerating India\'s Maritime Growth</h1>
		</div>
		<div class="dp-home-hero__right">
			<p>Providing the deep-water infrastructure that powers India\'s global trade ambitions.</p>
			<a class="dp-home-hero__btn" href="/about-us/">Know More</a>
		</div>
	</div>
</section>
<!-- /wp:html -->
';
	$out .= $hero_html;

	// Partners marquee.
	$logo_imgs = '';
	for ( $i = 1; $i <= 8; $i++ ) {
		$fn = "delta-port-new-updated-logo{$i}.svg";
		if ( ! file_exists( DELTA_PORTS_DIR . '/assets/images/' . $fn ) ) {
			$fn = "partnering-logo{$i}.svg";
		}
		if ( file_exists( DELTA_PORTS_DIR . '/assets/images/' . $fn ) ) {
			$src        = delta_ports_img( $fn );
			$logo_imgs .= '<div class="dp-home-marquee__item"><img src="' . esc_url( $src ) . '" alt="Partner logo ' . $i . '" height="48" loading="lazy" decoding="async" /></div>';
		}
	}
	$partners_head  = delta_ports_gb_heading( 'Partnering with Industry Leaders', 2, array( 'textAlign' => 'center' ) );
	$partners_head .= delta_ports_gb_paragraph(
		'Delta Group collaborates with clients and partners across infrastructure, logistics, industrial services, and technology, supporting long-term operations through reliable execution. The group serves a diverse portfolio of customers including leading industrial companies and global shipping lines, demonstrating the breadth and depth of its operational capabilities.',
		array( 'align' => 'center', 'className' => 'has-text-align-center' )
	);
	$marquee = '<!-- wp:html -->
<div class="dp-home-marquee" aria-label="Partner logos">
	<div class="dp-home-marquee__track">' . $logo_imgs . $logo_imgs . '</div>
</div>
<!-- /wp:html -->
';
	$out .= delta_ports_gb_group(
		array(
			'align'     => 'full',
			'className' => 'dp-gb-section dp-home-partners',
			'layout'    => array(
				'type'        => 'constrained',
				'contentSize' => '1400px',
				'wideSize'    => '1400px',
			),
		),
		$partners_head . $marquee
	);

	// One-Stop — copy + inline stats left | live video right.
	$company_left  = delta_ports_gb_paragraph( 'Company', array( 'className' => 'dp-home-kicker' ) );
	$company_left .= delta_ports_gb_heading( 'One-Stop Destination for Port Services', 2 );
	$company_left .= delta_ports_gb_paragraph( 'Delta Ports is a port-led infrastructure and terminal operations company focused on enabling efficient cargo movement and supporting regional and international trade. The business operates and manages terminal infrastructure designed for operational reliability, safety, and long-term performance across maritime and hinterland corridors.' );
	$company_left .= '<!-- wp:html -->
<div class="dp-home-onestop__stats">
	<div class="dp-home-onestop__stat">
		<strong class="dp-home-onestop__num" data-count-to="25" data-suffix="+">0+</strong>
		<span>Years of Legacy</span>
	</div>
	<div class="dp-home-onestop__stat">
		<strong class="dp-home-onestop__num" data-count-to="500" data-suffix="+">0+</strong>
		<span>Professionals</span>
	</div>
	<div class="dp-home-onestop__stat">
		<strong class="dp-home-onestop__num" data-count-to="50" data-suffix="+">0+</strong>
		<span>Warehouses</span>
	</div>
</div>
<!-- /wp:html -->
';
	if ( $company_vid ) {
		$company_right = '<!-- wp:html -->
<div class="dp-home-onestop__media">
	<video class="dp-home-onestop__video" src="' . esc_url( $company_vid ) . '" autoplay muted loop playsinline poster="' . esc_url( $op4 ) . '"></video>
</div>
<!-- /wp:html -->
';
	} else {
		$company_right = delta_ports_gb_image( $op4, 'Terminal operations aerial view', array( 'className' => 'dp-home-onestop__img' ) );
	}

	$out .= delta_ports_gb_group(
		array(
			'align'     => 'full',
			'className' => 'dp-gb-section dp-home-onestop',
			'layout'    => array(
				'type'        => 'constrained',
				'contentSize' => '1400px',
				'wideSize'    => '1400px',
			),
		),
		delta_ports_gb_columns(
			array(
				array( 'content' => $company_left, 'attrs' => array( 'className' => 'dp-home-onestop__copy', 'width' => 48 ) ),
				array( 'content' => $company_right, 'attrs' => array( 'className' => 'dp-home-onestop__aside', 'width' => 52 ) ),
			),
			array( 'className' => 'dp-home-onestop__row' )
		)
	);

	// Leadership teaser (live homepage section).
	$lead1 = file_exists( DELTA_PORTS_DIR . '/assets/images/leader-ahmed-mohiuddin.png' )
		? delta_ports_img( 'leader-ahmed-mohiuddin.png' )
		: delta_ports_img( 'leader-new2.webp' );
	$out .= '<!-- wp:html -->
<section class="dp-home-lead">
	<div class="dp-home-lead__inner">
		<figure class="dp-home-lead__photo">
			<img src="' . esc_url( $lead1 ) . '" alt="Ahmed Mohiuddin, Managing Director" loading="lazy" decoding="async" />
			<figcaption><span>MD</span><strong>Ahmed Mohiuddin</strong></figcaption>
		</figure>
		<div class="dp-home-lead__copy">
			<p class="dp-home-kicker">Leadership</p>
			<h2>Leadership</h2>
			<p class="dp-home-lead__accent">Stewardship over hierarchy</p>
			<p>Our leadership team brings deep operational expertise and strategic vision to Delta Ports. Committed to strong governance and long-term value creation, we prioritise disciplined execution, responsible stewardship of assets, and growth-oriented infrastructure development.</p>
			<p>Leadership at Delta Ports ensures we maintain high safety standards and operational reliability across all terminal and port activities.</p>
			<a class="dp-home-lead__btn" href="/leadership/">Meet Our Leaders →</a>
		</div>
	</div>
</section>
<section class="dp-home-projects">
	<div class="dp-home-projects__inner">
		<div class="dp-home-projects__head">
			<p class="dp-home-kicker">Projects</p>
			<h2>Projects</h2>
			<p>Delta Ports undertakes targeted infrastructure development, terminal upgrades, and capacity enhancement projects that strengthen operational capability. These initiatives focus on expanding cargo handling capacity, modernising equipment, and enhancing safety systems to support future-ready terminal operations.</p>
			<p>Projects at Delta Ports are investment-driven, prioritising long-term reliability and improved service outcomes.</p>
		</div>
		<div class="dp-home-projects__rail">
			<article><span>01</span><h3>Terminal upgrades</h3><p>Future-ready assets and systems for reliable long-term service outcomes.</p></article>
			<article><span>02</span><h3>Capacity expansion</h3><p>Throughput growth aligned with trade corridors on both coasts.</p></article>
			<article><span>03</span><h3>Safety systems</h3><p>Operational readiness embedded into every project decision.</p></article>
		</div>
	</div>
</section>
<!-- /wp:html -->
';

	// Our Operations — 3 hover cards, titles at bottom.
	$ops_head  = delta_ports_gb_heading( 'Our Operations', 2, array( 'textAlign' => 'center' ) );
	$ops_head .= delta_ports_gb_paragraph(
		"Delta Ports' operational framework is designed to support efficient throughput, reliable handling, and integrated logistics across port environments.",
		array( 'align' => 'center', 'className' => 'has-text-align-center' )
	);
	$ops_cards = '<!-- wp:html -->
<div class="dp-home-ops-grid">
	<a class="dp-home-ops-card" href="/led-operation-new/" style="background-image:url(\'' . esc_url( $op1 ) . '\')">
		<div class="dp-home-ops-card__content">
			<h3>Port-Led Operations</h3>
			<p>Our terminal and berth operations focus on safe, efficient vessel handling and quick turnaround times. We leverage best practices in port operations to maintain reliability and support consistent trade flows.</p>
		</div>
	</a>
	<a class="dp-home-ops-card" href="/cargo-handling-capabilities/" style="background-image:url(\'' . esc_url( $op2 ) . '\')">
		<div class="dp-home-ops-card__content">
			<h3>Cargo &amp; Terminal Infrastructure</h3>
			<p>Delta Ports provides comprehensive cargo handling &amp; yard infrastructure that supports bulk, multi-cargo, &amp; specialised operations. Facilities are equipped to handle a range of commodities with precision and efficiency.</p>
		</div>
	</a>
	<a class="dp-home-ops-card" href="/integrated-port-logistics/" style="background-image:url(\'' . esc_url( $op3 ) . '\')">
		<div class="dp-home-ops-card__content">
			<h3>Integrated Port Logistics</h3>
			<p>Supported by coordinated road and rail connectivity, Delta Ports ensures smooth cargo flows between terminals and inland logistics networks. Our operations are aligned with broader transport corridors to boost supply-chain velocity.</p>
		</div>
	</a>
</div>
<!-- /wp:html -->
';
	$out .= delta_ports_gb_group(
		array(
			'align'     => 'full',
			'className' => 'dp-gb-section dp-home-ops',
			'layout'    => array(
				'type'        => 'constrained',
				'contentSize' => '1400px',
				'wideSize'    => '1400px',
			),
		),
		$ops_head . $ops_cards
	);

	// Sustainability — live uses our-operation-delta-port4.webp (plant / green hands).
	$sus_img = file_exists( DELTA_PORTS_DIR . '/assets/images/our-operation-delta-port4.webp' )
		? delta_ports_img( 'our-operation-delta-port4.webp' )
		: ( file_exists( DELTA_PORTS_DIR . '/assets/images/continies-improvement-scaled.webp' )
			? delta_ports_img( 'continies-improvement-scaled.webp' )
			: $sus );
	$out    .= '<!-- wp:html -->
<section class="dp-home-sustain">
	<div class="dp-home-sustain__inner">
		<figure class="dp-home-sustain__media-wrap">
			<img class="dp-home-sustain__img" src="' . esc_url( $sus_img ) . '" alt="Sustainability at Delta Ports" loading="lazy" decoding="async" />
		</figure>
		<div class="dp-home-sustain__copy">
			<h2>Sustainability</h2>
			<p>Delta Ports has implemented impactful measures to reduce its carbon footprint, progressing toward carbon-neutral operations. Key initiatives include the introduction of battery-powered trucks, hybrid-electric harbour cranes, and electric vehicles for container operations. Additionally, solar power initiatives are being developed to reduce overall energy consumption and environmental impact.</p>
		</div>
	</div>
</section>
<!-- /wp:html -->
';

	// Awards — natural image height (auto / 100%).
	$awards  = delta_ports_gb_heading( 'Awards, Recognition & Coverages', 2, array( 'textAlign' => 'center' ) );
	$awards .= delta_ports_gb_paragraph(
		'From its origins in shipping and logistics, Group Delta has evolved into a diversified infrastructure-led enterprise.',
		array( 'align' => 'center', 'className' => 'has-text-align-center' )
	);
	$awards .= '<!-- wp:html -->
<div class="dp-home-awards">
	<figure class="dp-home-awards__item"><img src="' . esc_url( $a1 ) . '" alt="Award coverage 1" loading="lazy" decoding="async" /></figure>
	<figure class="dp-home-awards__item"><img src="' . esc_url( $a8 ) . '" alt="Award coverage 2" loading="lazy" decoding="async" /></figure>
	<figure class="dp-home-awards__item"><img src="' . esc_url( $a9 ) . '" alt="Award coverage 3" loading="lazy" decoding="async" /></figure>
	<figure class="dp-home-awards__item"><img src="' . esc_url( $a10 ) . '" alt="Award coverage 4" loading="lazy" decoding="async" /></figure>
</div>
<!-- /wp:html -->
';
	$out .= delta_ports_gb_group(
		array(
			'align'     => 'full',
			'className' => 'dp-gb-section dp-home-awards-sec dp-home-awards-sec--pad',
			'layout'    => array(
				'type'        => 'constrained',
				'contentSize' => '1400px',
				'wideSize'    => '1400px',
			),
		),
		$awards
	);

	// Our Business — live map with WebGL fluid animation (delta-map-sec-bg-new-scaled-1.webp).
	$map_global = file_exists( DELTA_PORTS_DIR . '/assets/images/delta-map-sec-bg-new-scaled-1.webp' )
		? delta_ports_img( 'delta-map-sec-bg-new-scaled-1.webp' )
		: $map;
	$biz = '<!-- wp:html -->
<section class="dp-home-business dp-home-business--map">
	<div class="dp-home-business__fluid container-dot-animation" data-src="' . esc_url( $map_global ) . '" data-map-src="' . esc_url( $map_global ) . '" style="background-image:url(\'' . esc_url( $map_global ) . '\')" aria-hidden="true">
		<canvas id="fluidCanvas" data-src="' . esc_url( $map_global ) . '" width="1280" height="520"></canvas>
	</div>
	<div class="dp-home-business__inner">
		<div class="dp-home-business__copy">
			<h2>Our Business</h2>
			<p>Group Delta encompasses companies spanning logistics, shipping, engineering, technology solutions, and construction — united by a founding philosophy of placing the customer at the heart of every operation.</p>
		</div>
		<div class="dp-home-business__stats">
			<div class="dp-home-business__stat">
				<strong class="dp-home-business__num" data-count-to="2" data-suffix="+">0+</strong>
				<span class="dp-home-business__label">Berths</span>
				<div class="dp-home-business__sub-pills">
					<span>Delta Marmagoa Port</span>
					<span>Delta Vizag Port</span>
				</div>
			</div>
			<div class="dp-home-business__stat dp-home-business__stat--right">
				<strong class="dp-home-business__num" data-count-to="25" data-suffix="M+">0M+</strong>
				<span class="dp-home-business__label">MT Cargo Handled Annually</span>
			</div>
		</div>
		<div class="dp-home-business__brands" aria-label="Group companies">
			<span>Group Delta</span>
			<span>Delta Global</span>
			<span>Worldwide Shipping</span>
			<span>Root Delta - Oman</span>
			<span>World wide automotive</span>
			<span>DIWL Technologies</span>
			<span>Tech Delta</span>
			<span>Delta Construction</span>
			<span>Delta (UAE)</span>
		</div>
	</div>
</section>
<!-- /wp:html -->
';
	$out .= $biz;

	return $out;
}

/**
 * About page — matches live vipaccounts.org/delta-ports/about-us design.
 *
 * @return string
 */
function delta_ports_content_about() {
	$map     = delta_ports_img( 'delta-map-sec-bg-new-scaled-1.webp' );
	$banner  = file_exists( DELTA_PORTS_DIR . '/assets/images/port-led-operation-new-banner-img.webp' )
		? delta_ports_img( 'port-led-operation-new-banner-img.webp' )
		: $map;
	$vid     = file_exists( DELTA_PORTS_DIR . '/assets/video/about-banner.mp4' )
		? delta_ports_vid( 'about-banner.mp4' )
		: '';
	// Prefer high-res port photography — tiny live vision webps blur when full-bleed.
	$vision  = file_exists( DELTA_PORTS_DIR . '/assets/images/our-operation-img2.png' )
		? delta_ports_img( 'our-operation-img2.png' )
		: ( file_exists( DELTA_PORTS_DIR . '/assets/images/vision-new-sec-img.webp' )
			? delta_ports_img( 'vision-new-sec-img.webp' )
			: delta_ports_img( 'vision-missino-new-updated-img2.webp' ) );
	$mission = file_exists( DELTA_PORTS_DIR . '/assets/images/our-operation-img3.png' )
		? delta_ports_img( 'our-operation-img3.png' )
		: ( file_exists( DELTA_PORTS_DIR . '/assets/images/vision-new-sec-img1.webp' )
			? delta_ports_img( 'vision-new-sec-img1.webp' )
			: delta_ports_img( 'vision-missino-new-updated-img1.webp' ) );
	$phil_img = file_exists( DELTA_PORTS_DIR . '/assets/images/mask-new-imga.webp' )
		? delta_ports_img( 'mask-new-imga.webp' )
		: delta_ports_img( 'mob-operation-6.webp' );
	if ( file_exists( DELTA_PORTS_DIR . '/assets/images/mob-operation-6.webp' ) && filesize( DELTA_PORTS_DIR . '/assets/images/mob-operation-6.webp' ) > 5000 ) {
		// Live philosophy side image.
		$phil_img = delta_ports_img( 'mob-operation-6.webp' );
	}
	// Prefer larger philosophy photos if present.
	foreach ( array( 'Component-23.webp', 'operation-philosyphi-updated2.webp', 'mask-new-imga.webp' ) as $cand ) {
		$path = DELTA_PORTS_DIR . '/assets/images/' . $cand;
		if ( file_exists( $path ) && filesize( $path ) > 20000 ) {
			$phil_img = delta_ports_img( $cand );
			break;
		}
	}
	$safe1 = file_exists( DELTA_PORTS_DIR . '/assets/images/safety-resposibility-new1.webp' )
		? delta_ports_img( 'safety-resposibility-new1.webp' )
		: delta_ports_img( 'our-operation-delta-port1.webp' );
	$safe2 = file_exists( DELTA_PORTS_DIR . '/assets/images/safety-resposibility-new2.webp' )
		? delta_ports_img( 'safety-resposibility-new2.webp' )
		: delta_ports_img( 'our-operation-delta-port2.webp' );
	$a1    = delta_ports_img( 'Awards-new-1.webp' );
	$a8    = delta_ports_img( 'Awards-new-8.webp' );
	$a9    = delta_ports_img( 'Awards-new-9.webp' );
	$a10   = delta_ports_img( 'Awards-new-10.webp' );

	// Hero with video (src attr survives KSES), breadcrumb, title, lead, stats.
	$media = $vid
		? '<video class="dp-about-hero__media" src="' . esc_url( $vid ) . '" autoplay muted loop playsinline poster="' . esc_url( $banner ) . '"></video>'
		: '<div class="dp-about-hero__media" style="background-image:url(\'' . esc_url( $banner ) . '\')"></div>';

	$out = '<!-- wp:html -->
<section class="dp-about-hero">
	' . $media . '
	<div class="dp-about-hero__overlay" aria-hidden="true"></div>
	<div class="dp-about-hero__inner">
		<nav class="dp-about-hero__crumb" aria-label="Breadcrumb"><a href="/">Home</a><span aria-hidden="true">›</span><span>About Us</span></nav>
		<h1>Delta Ports</h1>
		<p class="dp-about-hero__lead">Delta Ports is a port-led infrastructure and terminal operations company focused on enabling efficient cargo movement and supporting regional and international trade.</p>
		<div class="dp-about-hero__stats">
			<div class="dp-about-hero__stat">
				<strong data-count-to="40" data-suffix="+">40+</strong>
				<span>Years of Legacy</span>
			</div>
			<div class="dp-about-hero__stat">
				<strong data-count-to="150" data-suffix="k TEUs">150k TEUs</strong>
				<span>Container Handling Capacity</span>
			</div>
			<div class="dp-about-hero__stat">
				<strong data-count-to="6" data-suffix="million">6million</strong>
				<span>MT Cargo Capacity</span>
			</div>
		</div>
	</div>
</section>
<!-- /wp:html -->
';

	// Partners marquee (same as home).
	$logo_imgs = '';
	for ( $i = 1; $i <= 8; $i++ ) {
		$fn = "delta-port-new-updated-logo{$i}.svg";
		if ( ! file_exists( DELTA_PORTS_DIR . '/assets/images/' . $fn ) ) {
			$fn = "partnering-logo{$i}.svg";
		}
		if ( file_exists( DELTA_PORTS_DIR . '/assets/images/' . $fn ) ) {
			$src        = delta_ports_img( $fn );
			$logo_imgs .= '<div class="dp-home-marquee__item"><img src="' . esc_url( $src ) . '" alt="Partner logo ' . $i . '" height="48" loading="lazy" decoding="async" /></div>';
		}
	}
	$partners  = delta_ports_gb_heading( 'Partnering with Industry Leaders', 2, array( 'textAlign' => 'center' ) );
	$partners .= delta_ports_gb_paragraph(
		'Delta Group collaborates with clients and partners across infrastructure, logistics, industrial services, and technology, supporting long-term operations through reliable execution. The group serves a diverse portfolio of customers including leading industrial companies and global shipping lines, demonstrating the breadth and depth of its operational capabilities.',
		array( 'align' => 'center', 'className' => 'has-text-align-center' )
	);
	$partners .= '<!-- wp:html -->
<div class="dp-home-marquee" aria-label="Partner logos">
	<div class="dp-home-marquee__track">' . $logo_imgs . $logo_imgs . '</div>
</div>
<!-- /wp:html -->
';
	$out .= delta_ports_gb_group(
		array(
			'align'     => 'full',
			'className' => 'dp-gb-section dp-home-partners dp-about-partners',
			'layout'    => array(
				'type'        => 'constrained',
				'contentSize' => '1400px',
				'wideSize'    => '1400px',
			),
		),
		$partners
	);

	// Vision / Mission dual cards.
	$vm = '<!-- wp:html -->
<section class="dp-about-vm">
	<div class="dp-about-vm__inner">
		<article class="dp-about-vm__card dp-about-vm__card--vision" style="background-image:url(\'' . esc_url( $vision ) . '\')">
			<div class="dp-about-vm__shade"></div>
			<div class="dp-about-vm__body">
				<h2>Vision</h2>
				<p>To be a leader in the port terminal industry and the customer\'s first choice for worldwide integrated maritime and port logistics services</p>
			</div>
		</article>
		<article class="dp-about-vm__card dp-about-vm__card--mission" style="background-image:url(\'' . esc_url( $mission ) . '\')">
			<div class="dp-about-vm__shade"></div>
			<div class="dp-about-vm__body">
				<h2>Mission</h2>
				<p>To standardize operational efficiency and service effectiveness in port operations, with an intent to partnering with our customers as an extended arm of their business</p>
			</div>
		</article>
	</div>
</section>
<!-- /wp:html -->
';
	$out .= $vm;

	// Operating Philosophy — CSS icons (SVG is stripped by WP KSES).
	$phil = '<!-- wp:html -->
<section class="dp-about-phil">
	<div class="dp-about-phil__inner">
		<div class="dp-about-phil__head">
			<h2>Operating Philosophy</h2>
			<p><span class="dp-about-phil__accent"></span>Operations at Delta Ports are guided by three core principles that ensure reliability and long-term efficiency.</p>
		</div>
		<div class="dp-about-phil__grid">
			<figure class="dp-about-phil__media">
				<img src="' . esc_url( $phil_img ) . '" alt="Operating philosophy at Delta Ports" loading="lazy" decoding="async" />
			</figure>
			<div class="dp-about-phil__cards">
				<article class="dp-about-phil__card">
					<div class="dp-about-phil__icon dp-about-phil__icon--discipline" aria-hidden="true"></div>
					<div>
						<h3>Operational Discipline</h3>
						<p>Structured processes, safety protocols, and operational readiness ensure reliable terminal performance and efficient vessel turnaround.</p>
					</div>
				</article>
				<article class="dp-about-phil__card">
					<div class="dp-about-phil__icon dp-about-phil__icon--infra" aria-hidden="true"></div>
					<div>
						<h3>Infrastructure Stewardship</h3>
						<p>Terminal assets are managed with a long-term perspective, balancing capacity, maintenance, &amp; upgrades to support sustained efficiency and operational continuity.</p>
					</div>
				</article>
				<article class="dp-about-phil__card">
					<div class="dp-about-phil__icon dp-about-phil__icon--connect" aria-hidden="true"></div>
					<div>
						<h3>Connectivity &amp; Coordination</h3>
						<p>Operations are integrated with road, rail, and maritime networks, enabling coordinated cargo movement between ports and hinterland destinations through seamless multimodal connectivity.</p>
					</div>
				</article>
			</div>
		</div>
	</div>
</section>
<!-- /wp:html -->
';
	$out .= $phil;

	// Awards.
	$awards  = delta_ports_gb_heading( 'Awards, Recognition & Coverages', 2, array( 'textAlign' => 'center' ) );
	$awards .= delta_ports_gb_paragraph(
		'From its origins in shipping and logistics, Group Delta has evolved into a diversified infrastructure-led enterprise.',
		array( 'align' => 'center', 'className' => 'has-text-align-center' )
	);
	$awards .= '<!-- wp:html -->
<div class="dp-home-awards">
	<figure class="dp-home-awards__item"><img src="' . esc_url( $a1 ) . '" alt="Award coverage 1" loading="lazy" decoding="async" /></figure>
	<figure class="dp-home-awards__item"><img src="' . esc_url( $a8 ) . '" alt="Award coverage 2" loading="lazy" decoding="async" /></figure>
	<figure class="dp-home-awards__item"><img src="' . esc_url( $a9 ) . '" alt="Award coverage 3" loading="lazy" decoding="async" /></figure>
	<figure class="dp-home-awards__item"><img src="' . esc_url( $a10 ) . '" alt="Award coverage 4" loading="lazy" decoding="async" /></figure>
</div>
<!-- /wp:html -->
';
	$out .= delta_ports_gb_group(
		array(
			'align'     => 'full',
			'className' => 'dp-gb-section dp-home-awards-sec dp-about-awards-sec',
			'layout'    => array(
				'type'        => 'constrained',
				'contentSize' => '1400px',
				'wideSize'    => '1400px',
			),
		),
		$awards
	);

	// Safety and Responsibility.
	$safety = '<!-- wp:html -->
<section class="dp-about-safety dp-section--no-top-pad">
	<div class="dp-about-safety__inner">
		<div class="dp-about-safety__copy">
			<h2>Safety and<br/>Responsibility.</h2>
			<div class="dp-about-safety__text">
				<p>Safety is integral to all Delta Ports operations, with structured safety practices, trained personnel, and strict adherence to regulatory standards ensuring secure working environments.</p>
				<p>Environmental responsibility is embedded into daily operations through compliance with applicable regulations, implementation of pollution control measures, and continuous efforts to minimize environmental impact while supporting sustainable port activities.</p>
			</div>
		</div>
		<div class="dp-about-safety__images">
			<figure><img src="' . esc_url( $safe1 ) . '" alt="Port safety operations" loading="lazy" decoding="async" /></figure>
			<figure><img src="' . esc_url( $safe2 ) . '" alt="Responsible terminal operations" loading="lazy" decoding="async" /></figure>
		</div>
	</div>
</section>
<!-- /wp:html -->
';
	$out .= $safety;

	return $out;
}

/**
 * Leadership — 3 leaders + Read Bio slide panel (live parity).
 *
 * @return string
 */
function delta_ports_content_leadership() {
	// Live site hero (Elementor post-895).
	$hero_file = 'delta-port-leadership-new-img1.webp';
	if ( ! file_exists( DELTA_PORTS_DIR . '/assets/images/' . $hero_file ) ) {
		$hero_file = 'des-banner-Port-leadership-1.webp';
	}
	$hero = delta_ports_img( $hero_file );
	$people = array(
		array(
			'id'    => 'ahmed-mohiuddin',
			'name'  => 'Ahmed Mohiuddin',
			'role'  => 'MD',
			'img'   => file_exists( DELTA_PORTS_DIR . '/assets/images/leader-ahmed-mohiuddin.png' )
				? 'leader-ahmed-mohiuddin.png'
				: 'leader-new2.webp',
			'quote' => 'A journey of a thousand miles begins with a single step',
			'bio'   => array(
				'Every great enterprise is built twice — first in vision, then in perseverance. At Group Delta, we started with a clear purpose: to deliver port services of the highest standard, with integrity at every step. Over the years, that purpose has expanded across industries and geographies, but the core of who we are has never changed. We build on trust. We grow through people. And we measure success not just by what we achieve, but by the value we create for those we serve.',
				'To our clients, partners, and teams: you are the reason we strive for more. The journey ahead is our most exciting yet.',
			),
		),
		array(
			'id'    => 'shamil-ahmed',
			'name'  => 'Shamil Ahmed',
			'role'  => 'Director',
			'img'   => file_exists( DELTA_PORTS_DIR . '/assets/images/leader-shamil-ahmed.png' )
				? 'leader-shamil-ahmed.png'
				: 'leader-new1.webp',
			'quote' => 'Change is the only Constant in Life',
			'bio'   => array(
				'The businesses that endure are not those that resist change, they are those that lead it.',
				'At Group Delta, innovation is not a department or a strategy. It is a mindset that runs through everything we do. We invest in technology, in people, and in ideas that keep us ahead, so that our clients always have a partner who is ready for what comes next.',
				'We are grateful for the trust that has brought us this far, and energised by the possibilities that lie ahead.',
			),
		),
		array(
			'id'    => 'mohammed-shahzeer',
			'name'  => 'Mohammed Shahzeer',
			'role'  => 'Director',
			'img'   => file_exists( DELTA_PORTS_DIR . '/assets/images/leader-mohammed-shahzeer.png' )
				? 'leader-mohammed-shahzeer.png'
				: 'leader-new3.webp',
			'quote' => '',
			'bio'   => array(
				'Diversification is often seen as a business strategy. For us, it is a reflection of curiosity, a genuine desire to learn, adapt and contribute across new frontiers.',
				'Paired with a deep commitment to technology, it has allowed Group Delta to grow in ways that are both broad and meaningful. We are present across sectors and markets that matter and we are constantly asking how we can do more, serve better and reach further.',
				'The future belongs to those willing to build it. We intend to be among them, and we are honoured to have you alongside us as we do.',
			),
		),
	);

	$cards  = '';
	$panels = '';
	foreach ( $people as $p ) {
		$img    = delta_ports_img( $p['img'] );
		$cards .= '<article class="dp-lead-card">
			<figure class="dp-lead-card__photo"><img src="' . esc_url( $img ) . '" alt="' . esc_attr( $p['name'] ) . '" loading="lazy" decoding="async" /></figure>
			<h3>' . esc_html( $p['name'] ) . '</h3>
			<p class="dp-lead-card__role">' . esc_html( $p['role'] ) . '</p>
			<button type="button" class="dp-lead-card__bio" data-bio-open="' . esc_attr( $p['id'] ) . '" aria-haspopup="dialog" aria-controls="dp-bio-' . esc_attr( $p['id'] ) . '">Read Bio →</button>
		</article>';

		$paras = '';
		foreach ( $p['bio'] as $para ) {
			$paras .= '<p>' . esc_html( $para ) . '</p>';
		}
		$quote = $p['quote']
			? '<h4 class="dp-bio-drawer__quote">' . esc_html( $p['quote'] ) . '</h4>'
			: '';

		$panels .= '<div class="dp-bio-drawer__panel" id="dp-bio-' . esc_attr( $p['id'] ) . '" data-bio-panel="' . esc_attr( $p['id'] ) . '" role="dialog" aria-modal="true" aria-labelledby="dp-bio-title-' . esc_attr( $p['id'] ) . '" hidden>
			<button type="button" class="dp-bio-drawer__close" data-bio-close aria-label="Close bio">
				<span aria-hidden="true">×</span>
			</button>
			<div class="dp-bio-drawer__scroll">
				<div class="dp-bio-drawer__meta">
					<h3 id="dp-bio-title-' . esc_attr( $p['id'] ) . '">' . esc_html( $p['name'] ) . '</h3>
					<p class="dp-bio-drawer__role">' . esc_html( $p['role'] ) . '</p>
				</div>
				' . $quote . '
				<div class="dp-bio-drawer__body">' . $paras . '</div>
			</div>
		</div>';
	}

	return '<!-- wp:html -->
<section class="dp-ops-hero dp-lead-hero" style="background-image:url(\'' . esc_url( $hero ) . '\')">
	<div class="dp-ops-hero__overlay" aria-hidden="true"></div>
	<div class="dp-ops-hero__inner">
		<nav class="dp-ops-hero__crumb" aria-label="Breadcrumb"><a href="/">Home</a><span aria-hidden="true">›</span><span>Leadership</span></nav>
		<h1>Our Leadership<br/>Philosophy</h1>
		<p class="dp-ops-hero__lead">At Delta Group, leadership is defined by stewardship rather than hierarchy. Leaders are expected to act with integrity, prioritise safety, and take ownership of outcomes across every function and business.</p>
	</div>
</section>
<section class="dp-lead-team">
	<div class="dp-lead-team__inner">
		<div class="dp-lead-team__head">
			<h2>Meet our team</h2>
			<p>This philosophy ensures that decisions are made with a long-term perspective, balancing operational excellence with responsibility to people, partners, and the environments in which the Group operates.</p>
		</div>
		<div class="dp-lead-team__grid">' . $cards . '</div>
	</div>
</section>

<div class="dp-bio-drawer" id="dp-bio-drawer" aria-hidden="true">
	<div class="dp-bio-drawer__backdrop" data-bio-close tabindex="-1"></div>
	<div class="dp-bio-drawer__shell">
		' . $panels . '
	</div>
</div>
<!-- /wp:html -->
';
}

/* Port-led, cargo, logistics, sustainability, contact → ops-pages-content.php */

/**
 * Privacy policy.
 *
 * @return string
 */
function delta_ports_content_privacy() {
	$body  = delta_ports_gb_heading( 'Privacy Policy', 1 );
	$body .= delta_ports_gb_paragraph( 'Website: https://www.groupdelta.in' );
	$body .= delta_ports_gb_paragraph( 'Group Delta operates the website https://www.groupdelta.in. We are committed to protecting the privacy of visitors and users of our Website. By accessing or using the Website, you agree to the terms of this Privacy Policy.' );
	$body .= delta_ports_gb_heading( 'Sources and Categories of Personal Data Concerned', 2 );
	$body .= delta_ports_gb_paragraph( 'We may collect personal information that you voluntarily provide when you contact us through forms, email, or other communication channels. This may include your name, email address, phone number, company details, and any other information you choose to share. We may also automatically collect technical information such as your IP address, browser type, pages visited, and date and time of access to improve website functionality and security.' );
	$body .= delta_ports_gb_heading( 'Use of Information', 2 );
	$body .= delta_ports_gb_paragraph( 'The information collected is used to respond to inquiries, provide and improve our services, communicate with you, operate and maintain the Website, and ensure its proper functioning.' );
	$body .= delta_ports_gb_paragraph( 'We do not sell, rent, or trade your personal information to third parties. Information may be shared with trusted service providers or disclosed where required by law.' );
	$body .= delta_ports_gb_heading( 'Cookies', 2 );
	$body .= delta_ports_gb_paragraph( 'Our Website may use cookies and similar technologies to enhance your browsing experience and analyze website traffic. Cookies are small text files stored on your device. You may disable cookies through your browser settings; however, some features of the Website may not function properly if cookies are disabled.' );
	$body .= delta_ports_gb_heading( 'Data Security', 2 );
	$body .= delta_ports_gb_paragraph( 'We implement reasonable administrative and technical safeguards to protect your personal information from unauthorized access, disclosure, alteration, or destruction. However, no method of online transmission is completely secure, and we cannot guarantee absolute security.' );
	$body .= delta_ports_gb_heading( 'Third-Party Links', 2 );
	$body .= delta_ports_gb_paragraph( 'The Website may contain links to external websites for your convenience. We are not responsible for the privacy practices or content of such third-party websites.' );
	$body .= delta_ports_gb_heading( 'User Rights – Access to Your Personal Data', 2 );
	$body .= delta_ports_gb_paragraph( 'Subject to applicable laws, you may request access to, correction of, or deletion of your personal information by contacting us using the details below.' );
	$body .= delta_ports_gb_heading( 'Changes to This Policy', 2 );
	$body .= delta_ports_gb_paragraph( 'We reserve the right to update or modify this Privacy Policy at any time. Any changes will be posted on this page with an updated effective date.' );
	$body .= delta_ports_gb_heading( 'Contact Us', 2 );
	$body .= delta_ports_gb_paragraph( 'Email: enquiries@groupdelta.in' );
	$body .= delta_ports_gb_paragraph( 'Phone: +91 99023 95555' );

	return delta_ports_gb_group(
		array(
			'className' => 'dp-gb-section dp-gb-legal',
			'layout'    => array( 'type' => 'constrained', 'contentSize' => '800px' ),
		),
		$body
	);
}

/**
 * Terms.
 *
 * @return string
 */
function delta_ports_content_terms() {
	$body  = delta_ports_gb_heading( 'Terms & Conditions', 1 );
	$body .= delta_ports_gb_paragraph( 'Last updated: May 03, 2026' );
	$body .= delta_ports_gb_paragraph( 'Please read these terms and conditions carefully before using our service.' );
	$body .= delta_ports_gb_heading( '1. Introduction', 2 );
	$body .= delta_ports_gb_paragraph( 'Visitors to this website are bound by the following Terms and Conditions (“Terms”). Please read them carefully before using this site. If you do not agree with any of these Terms, please discontinue use of the website immediately.' );
	$body .= delta_ports_gb_paragraph( 'The content of this website is provided for general information and use only and is subject to change without notice.' );
	$body .= delta_ports_gb_heading( '2. Cookies and Information Processing', 2 );
	$body .= delta_ports_gb_paragraph( 'This website may use cookies to monitor browsing preferences. By continuing to use the website, you consent to such usage. Certain information may be stored and processed in accordance with applicable laws.' );
	$body .= delta_ports_gb_heading( '3. Warranties and Limitation of Liability', 2 );
	$body .= delta_ports_gb_paragraph( 'Neither Delta Group nor any third parties make any warranty or guarantee as to the accuracy, timeliness, completeness, performance, or suitability of the information and materials available on this website for any particular purpose.' );
	$body .= delta_ports_gb_paragraph( 'The information may contain inaccuracies or errors, and Delta Group expressly excludes liability for any such inaccuracies or errors to the fullest extent permitted by law. Your use of any information or materials on this website is entirely at your own risk.' );
	$body .= delta_ports_gb_heading( '4. Intellectual Property', 2 );
	$body .= delta_ports_gb_paragraph( 'All content on this website, including but not limited to design, layout, appearance, graphics, and logos, is owned by or licensed to Delta Group. Unauthorized reproduction or use is strictly prohibited.' );
	$body .= delta_ports_gb_heading( '5. Links to Other Websites', 2 );
	$body .= delta_ports_gb_paragraph( 'This website may include links to third-party websites for convenience. Delta Group does not endorse and is not responsible for the content, availability, or accuracy of such external websites.' );
	$body .= delta_ports_gb_heading( '6. Unauthorized Use', 2 );
	$body .= delta_ports_gb_paragraph( 'Unauthorized use of this website may result in a claim for damages and/or constitute a criminal offence.' );
	$body .= delta_ports_gb_heading( '7. Governing Law and Dispute Resolution', 2 );
	$body .= delta_ports_gb_paragraph( 'These Terms shall be governed by and interpreted in accordance with the laws of India, excluding its conflicts of law rules. Any disputes arising in connection with this website shall be subject to the exclusive jurisdiction of the competent courts in Ahmedabad, India.' );
	$body .= delta_ports_gb_heading( 'Contact Us', 2 );
	$body .= delta_ports_gb_paragraph( 'Email: enquiries@groupdelta.in' );
	$body .= delta_ports_gb_paragraph( 'Phone: +91 99023 95555' );

	return delta_ports_gb_group(
		array(
			'className' => 'dp-gb-section dp-gb-legal',
			'layout'    => array( 'type' => 'constrained', 'contentSize' => '800px' ),
		),
		$body
	);
}
