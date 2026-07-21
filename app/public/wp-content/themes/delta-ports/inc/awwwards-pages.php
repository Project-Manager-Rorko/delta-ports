<?php
/**
 * Awwwards-level Home + About markup (Gutenberg HTML blocks).
 *
 * @package Delta_Ports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Partner logo strip markup (live partnering logos).
 *
 * @return string
 */
function delta_ports_aww_logos() {
	$html  = '';
	$files = array();
	// Prefer partnering-logo set used on live; fall back to delta-port-new-updated-logo*.
	for ( $i = 1; $i <= 24; $i++ ) {
		if ( 16 === $i ) {
			continue; // missing asset on disk
		}
		$name = "partnering-logo{$i}.svg";
		$path = DELTA_PORTS_DIR . '/assets/images/' . $name;
		if ( file_exists( $path ) ) {
			$files[] = $name;
		}
	}
	if ( empty( $files ) ) {
		for ( $i = 1; $i <= 8; $i++ ) {
			$files[] = "delta-port-new-updated-logo{$i}.svg";
		}
	}
	foreach ( $files as $i => $name ) {
		$src   = delta_ports_img( $name );
		$n     = $i + 1;
		$html .= '<div class="aw-logo"><img src="' . $src . '" alt="Partner logo ' . $n . '" height="48" width="140" loading="lazy" decoding="async" /></div>';
	}
	return $html;
}

/**
 * Awwwards Home.
 *
 * @return string
 */
/**
 * Theme video URL helper.
 *
 * @param string $rel Path under assets/video.
 * @return string
 */
function delta_ports_vid( $rel ) {
	return esc_url( DELTA_PORTS_URI . '/assets/video/' . ltrim( $rel, '/' ) );
}

/**
 * Shared inner page hero.
 *
 * @param string $crumb  Current crumb label.
 * @param string $title  H1.
 * @param string $intro  Lead.
 * @param string $img    Image filename under assets/images.
 * @return string
 */
function delta_ports_aw_inner_hero( $crumb, $title, $intro, $img = 'port-led-operation-new-banner-img.webp' ) {
	$src = delta_ports_img( $img );
	$c   = esc_html( $crumb );
	$t   = esc_html( $title );
	$i   = esc_html( $intro );
	return <<<HTML
<section class="aw-inner-hero">
	<div class="aw-inner-hero__media" aria-hidden="true">
		<img src="{$src}" alt="" width="1920" height="900" fetchpriority="high" decoding="async" />
		<div class="aw-inner-hero__veil"></div>
	</div>
	<div class="aw-inner-hero__content">
		<nav class="aw-crumb" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>{$c}</span></nav>
		<h1>{$t}</h1>
		<p>{$i}</p>
	</div>
</section>
HTML;
}

function delta_ports_content_home() {
	$map   = delta_ports_img( 'delta-map-sec-bg-new-scaled-1.webp' );
	$op4   = delta_ports_img( 'our-operation-delta-port4.webp' );
	$a1    = delta_ports_img( 'Awards-new-1.webp' );
	$a8    = delta_ports_img( 'Awards-new-8.webp' );
	$a9    = delta_ports_img( 'Awards-new-9.webp' );
	$a10   = delta_ports_img( 'Awards-new-10.webp' );
	$m1    = delta_ports_img( 'media-update1.webp' );
	$m2    = delta_ports_img( 'media-update2.webp' );
	$m3    = delta_ports_img( 'media-update3.webp' );
	$lead  = file_exists( DELTA_PORTS_DIR . '/assets/images/leader-ahmed-mohiuddin.png' )
		? delta_ports_img( 'leader-ahmed-mohiuddin.png' )
		: delta_ports_img( 'leader-new2.webp' );
	$lead2 = file_exists( DELTA_PORTS_DIR . '/assets/images/leader-shamil-ahmed.png' )
		? delta_ports_img( 'leader-shamil-ahmed.png' )
		: delta_ports_img( 'leader-new1.webp' );
	$lead3 = file_exists( DELTA_PORTS_DIR . '/assets/images/leader-mohammed-shahzeer.png' )
		? delta_ports_img( 'leader-mohammed-shahzeer.png' )
		: delta_ports_img( 'leader-new3.webp' );
	/* Live ops card backgrounds (Elementor integrate-cap-new-sec). */
	$op1bg = delta_ports_img( 'our-operation-delta-port1.webp' );
	$op2bg = delta_ports_img( 'our-operation-delta-port2.webp' );
	$op3bg = delta_ports_img( 'Component-7.webp' );
	if ( ! file_exists( DELTA_PORTS_DIR . '/assets/images/Component-7.webp' ) ) {
		$op3bg = delta_ports_img( 'our-operation-delta-port3.webp' );
	}
	$vid   = delta_ports_vid( 'home-banner.mp4' );
	$vidm  = delta_ports_vid( 'home-banner-mobile.webm' );
	$logos = delta_ports_aww_logos();

	return <<<HTML
<!-- wp:html -->
<div class="aw-page aw-home" data-aw-page="home">

<section class="aw-hero" data-aw-hero>
	<div class="aw-hero__media has-video" aria-hidden="true">
		<img src="{$map}" alt="" width="1920" height="1080" fetchpriority="high" decoding="async" class="aw-hero__img" />
		<video class="aw-hero__video" autoplay muted loop playsinline poster="{$map}">
			<source src="{$vid}" type="video/mp4" media="(min-width: 768px)" />
			<source src="{$vidm}" type="video/webm" media="(max-width: 767px)" />
			<source src="{$vid}" type="video/mp4" />
		</video>
		<div class="aw-hero__veil"></div>
		<div class="aw-hero__orb aw-hero__orb--a"></div>
		<div class="aw-hero__orb aw-hero__orb--b"></div>
		<div class="aw-hero__grid"></div>
	</div>
	<div class="aw-hero__stage">
		<div class="aw-hero__meta">
			<span class="aw-pill"><i></i> Terminal ops · East &amp; West coast India</span>
			<span class="aw-hero__index">01 / Home</span>
		</div>
		<h1 class="aw-hero__title" data-aw-split>
			<span class="aw-line"><span class="aw-word">Accelerating</span></span>
			<span class="aw-line"><span class="aw-word">India’s</span> <span class="aw-word aw-word--accent">Maritime</span></span>
			<span class="aw-line"><span class="aw-word">Growth</span></span>
		</h1>
		<div class="aw-hero__bottom">
			<p class="aw-hero__lead">Providing the deep-water infrastructure that powers India’s global trade ambitions.</p>
			<div class="aw-hero__cta">
				<a class="aw-btn aw-btn--fill" href="/about-us/"><span>Know More</span><em>→</em></a>
				<a class="aw-btn aw-btn--ghost" href="/led-operation-new/"><span>Our Operations</span></a>
			</div>
		</div>
	</div>
	<div class="aw-scroll-hint" aria-hidden="true">
		<span>Scroll</span>
		<div class="aw-scroll-hint__line"></div>
	</div>
</section>

<section class="aw-marquee-band">
	<div class="aw-marquee-band__head">
		<p class="aw-kicker">Partners</p>
		<h2>Partnering with Industry Leaders</h2>
		<p class="aw-sub">Delta Group collaborates with clients and partners across infrastructure, logistics, industrial services, and technology, supporting long-term operations through reliable execution. The group serves a diverse portfolio of customers including leading industrial companies and global shipping lines, demonstrating the breadth and depth of its operational capabilities.</p>
	</div>
	<div class="aw-marquee dp-marquee" aria-label="Partner logos">
		<div class="aw-marquee__track dp-marquee__track">{$logos}{$logos}</div>
	</div>
</section>

<section class="aw-bento">
	<div class="aw-bento__intro">
		<p class="aw-kicker">Company</p>
		<h2>One-Stop Destination<br/>for Port Services</h2>
		<p class="aw-sub">Delta Ports is a port-led infrastructure and terminal operations company focused on enabling efficient cargo movement and supporting regional and international trade. The business operates and manages terminal infrastructure designed for operational reliability, safety, and long-term performance across maritime and hinterland corridors.</p>
	</div>
	<div class="aw-bento__grid">
		<article class="aw-tile aw-tile--stat" data-aw-reveal>
			<span class="aw-tile__label">Years of Legacy</span>
			<strong class="aw-tile__num" data-count-to="25" data-suffix="+">0+</strong>
			<span class="aw-tile__foot">Operational excellence</span>
		</article>
		<article class="aw-tile aw-tile--stat aw-tile--accent" data-aw-reveal>
			<span class="aw-tile__label">Professionals</span>
			<strong class="aw-tile__num" data-count-to="500" data-suffix="+">0+</strong>
			<span class="aw-tile__foot">Skilled teams</span>
		</article>
		<article class="aw-tile aw-tile--stat" data-aw-reveal>
			<span class="aw-tile__label">Warehouses</span>
			<strong class="aw-tile__num" data-count-to="50" data-suffix="+">0+</strong>
			<span class="aw-tile__foot">Storage network</span>
		</article>
		<article class="aw-tile aw-tile--wide" data-aw-reveal>
			<div class="aw-tile__copy">
				<p class="aw-kicker">Infrastructure</p>
				<h3>Designed for throughput, built for trust</h3>
				<p>Maritime and hinterland corridors aligned to keep cargo moving — vessel to yard to multimodal exit.</p>
			</div>
			<div class="aw-tile__visual">
				<img src="{$op4}" alt="Terminal operations" loading="lazy" width="900" height="600" decoding="async" />
			</div>
		</article>
	</div>
</section>

<section class="aw-split aw-split--lead">
	<div class="aw-split__media" data-aw-reveal>
		<img src="{$lead}" alt="Ahmed Mohiuddin, Managing Director" width="900" height="1100" decoding="async" fetchpriority="low" />
		<div class="aw-split__badge">
			<span>MD</span>
			<strong>Ahmed Mohiuddin</strong>
		</div>
	</div>
	<div class="aw-split__body" data-aw-reveal>
		<p class="aw-kicker">Leadership</p>
		<h2>Leadership</h2>
		<p class="aw-lead-accent">Stewardship over hierarchy</p>
		<p>Our leadership team brings deep operational expertise and strategic vision to Delta Ports. Committed to strong governance and long-term value creation, we prioritise disciplined execution, responsible stewardship of assets, and growth-oriented infrastructure development.</p>
		<p>Leadership at Delta Ports ensures we maintain high safety standards and operational reliability across all terminal and port activities.</p>
		<div class="aw-lead-strip" aria-label="Leadership team">
			<figure class="aw-lead-strip__item is-active">
				<img src="{$lead}" alt="Ahmed Mohiuddin" width="240" height="240" loading="lazy" decoding="async" />
				<figcaption><strong>Ahmed Mohiuddin</strong><span>MD</span></figcaption>
			</figure>
			<figure class="aw-lead-strip__item">
				<img src="{$lead2}" alt="Shamil Ahmed" width="240" height="240" loading="lazy" decoding="async" />
				<figcaption><strong>Shamil Ahmed</strong><span>Director</span></figcaption>
			</figure>
			<figure class="aw-lead-strip__item">
				<img src="{$lead3}" alt="Mohammed Shahzeer" width="240" height="240" loading="lazy" decoding="async" />
				<figcaption><strong>Mohammed Shahzeer</strong><span>Director</span></figcaption>
			</figure>
		</div>
		<a class="aw-btn aw-btn--fill" href="/leadership/"><span>Meet Our Leaders</span><em>→</em></a>
	</div>
</section>

<section class="aw-projects">
	<div class="aw-projects__head" data-aw-reveal>
		<p class="aw-kicker">Projects</p>
		<h2>Projects</h2>
		<p class="aw-sub">Delta Ports undertakes targeted infrastructure development, terminal upgrades, and capacity enhancement projects that strengthen operational capability. These initiatives focus on expanding cargo handling capacity, modernising equipment, and enhancing safety systems to support future-ready terminal operations.</p>
		<p class="aw-sub">Projects at Delta Ports are investment-driven, prioritising long-term reliability and improved service outcomes.</p>
	</div>
	<div class="aw-projects__rail">
		<article class="aw-project-card" data-aw-reveal>
			<span>01</span>
			<h3>Terminal upgrades</h3>
			<p>Future-ready assets and systems for reliable long-term service outcomes.</p>
		</article>
		<article class="aw-project-card" data-aw-reveal>
			<span>02</span>
			<h3>Capacity expansion</h3>
			<p>Throughput growth aligned with trade corridors on both coasts.</p>
		</article>
		<article class="aw-project-card" data-aw-reveal>
			<span>03</span>
			<h3>Safety systems</h3>
			<p>Operational readiness embedded into every project decision.</p>
		</article>
	</div>
</section>

<section class="aw-ops">
	<div class="aw-ops__head" data-aw-reveal>
		<h2>Our Operations</h2>
		<p class="aw-sub">Delta Ports’ operational framework is designed to support efficient throughput, reliable handling, and integrated logistics across port environments.</p>
	</div>
	<div class="aw-ops__grid">
		<a class="aw-ops-card hover-card integrate-cap-new-sec" href="/led-operation-new/" data-aw-reveal style="background-image:url('{$op1bg}')">
			<div class="aw-ops-card__content card-content">
				<h5>Port-Led Operations</h5>
				<p>Our terminal and berth operations focus on safe, efficient vessel handling and quick turnaround times. We leverage best practices in port operations to maintain reliability and support consistent trade flows.</p>
			</div>
		</a>
		<a class="aw-ops-card hover-card integrate-cap-new-sec" href="/cargo-handling-capabilities/" data-aw-reveal style="background-image:url('{$op2bg}')">
			<div class="aw-ops-card__content card-content">
				<h5>Cargo &amp; Terminal Infrastructure</h5>
				<p>Delta Ports provides comprehensive cargo handling &amp; yard infrastructure that supports bulk, multi-cargo, &amp; specialised operations. Facilities are equipped to handle a range of commodities with precision and efficiency.</p>
			</div>
		</a>
		<a class="aw-ops-card hover-card integrate-cap-new-sec" href="/integrated-port-logistics/" data-aw-reveal style="background-image:url('{$op3bg}')">
			<div class="aw-ops-card__content card-content">
				<h5>Integrated Port Logistics</h5>
				<p>Supported by coordinated road and rail connectivity, Delta Ports ensures smooth cargo flows between terminals and inland logistics networks. Our operations are aligned with broader transport corridors to boost supply-chain velocity.</p>
			</div>
		</a>
	</div>
</section>

<section class="aw-sustain">
	<div class="aw-sustain__panel" data-aw-reveal>
		<p class="aw-kicker">Environment</p>
		<h2>Sustainability</h2>
		<p class="aw-lead-accent" style="color:rgba(255,255,255,.9)">Lower carbon. Higher responsibility.</p>
		<p>Delta Ports has implemented impactful measures to reduce its carbon footprint, progressing toward carbon-neutral operations. Key initiatives include the introduction of battery-powered trucks, hybrid-electric harbour cranes, and electric vehicles for container operations. Additionally, solar power initiatives are being developed to reduce overall energy consumption and environmental impact.</p>
		<p>Environmental compliance and safety are embedded into daily operations. Dust suppression systems, mechanised road sweepers, and strict adherence to pollution control norms ensure responsible and sustainable terminal operations.</p>
		<a class="aw-btn aw-btn--light" href="/sustainability/"><span>Know More</span><em>→</em></a>
	</div>
	<div class="aw-sustain__visual" data-aw-reveal aria-hidden="true">
		<img src="{$op4}" alt="Sustainable terminal operations" loading="lazy" decoding="async" />
	</div>
</section>

<section class="aw-media">
	<div class="aw-media__head" data-aw-reveal>
		<p class="aw-kicker">Media &amp; Updates</p>
		<h2>Media &amp; Updates</h2>
		<p class="aw-sub">Short updates from across the Group’s operations and initiatives.</p>
	</div>
	<div class="aw-media__grid">
		<a class="aw-media-card aw-media-card--lg" href="/media-updates/acquisition-of-noatum-propels-ad-ports-group/" data-aw-reveal>
			<img src="{$m2}" alt="Acquisition of Noatum Propels AD Ports Group" loading="lazy" decoding="async" />
			<div class="aw-media-card__body">
				<span>Update</span>
				<h3>Acquisition of Noatum Propels AD Ports Group</h3>
				<em>Read More</em>
			</div>
		</a>
		<a class="aw-media-card" href="/media-updates/indias-logistics-sector-big-opportunity-for-investors/" data-aw-reveal>
			<img src="{$m1}" alt="India’s logistics sector opportunity" loading="lazy" decoding="async" />
			<div class="aw-media-card__body">
				<span>Insight</span>
				<h3>India’s logistics sector big opportunity for investors</h3>
				<em>Read More</em>
			</div>
		</a>
		<a class="aw-media-card" href="/media-updates/hello-world/" data-aw-reveal>
			<img src="{$m3}" alt="Home-grown Stevedoring Giant bags big" loading="lazy" decoding="async" />
			<div class="aw-media-card__body">
				<span>Story</span>
				<h3>Home-grown Stevedoring Giant bags big</h3>
				<em>Read More</em>
			</div>
		</a>
	</div>
</section>

<section class="aw-awards">
	<div class="aw-awards__head" data-aw-reveal>
		<h2>Awards, Recognition &amp; Coverages</h2>
		<p class="aw-sub">From its origins in shipping and logistics, Group Delta has evolved into a diversified infrastructure-led enterprise.</p>
	</div>
	<div class="aw-awards__row">
		<figure data-aw-reveal><img src="{$a1}" alt="Award coverage 1" loading="lazy" decoding="async" width="480" height="280" /></figure>
		<figure data-aw-reveal><img src="{$a8}" alt="Award coverage 2" loading="lazy" decoding="async" width="480" height="280" /></figure>
		<figure data-aw-reveal><img src="{$a9}" alt="Award coverage 3" loading="lazy" decoding="async" width="480" height="280" /></figure>
		<figure data-aw-reveal><img src="{$a10}" alt="Award coverage 4" loading="lazy" decoding="async" width="480" height="280" /></figure>
	</div>
</section>

<section class="aw-business">
	<div class="aw-business__map" aria-hidden="true">
		<img src="{$map}" alt="" width="1600" height="900" loading="lazy" decoding="async" />
	</div>
	<div class="aw-business__inner">
		<div class="aw-business__copy" data-aw-reveal>
			<h2>Our Business</h2>
			<p>Group Delta encompasses companies spanning logistics, shipping, engineering, technology solutions, and construction - united by a founding philosophy of placing the customer at the heart of every operation.</p>
		</div>
		<div class="aw-business__stats" data-aw-reveal>
			<div class="aw-business__stat">
				<strong data-count-to="2" data-suffix="+">0+</strong>
				<span class="aw-business__stat-label">Berths</span>
				<div class="aw-business__pills">
					<span class="aw-pill-soft">Delta Marmagoa Port</span>
					<span class="aw-pill-soft">Delta Vizag Port</span>
				</div>
			</div>
			<div class="aw-business__stat">
				<strong data-count-to="25" data-suffix="M+">0M+</strong>
				<span class="aw-business__stat-label">MT Cargo Handled Annually</span>
			</div>
		</div>
		<div class="aw-business__brands" data-aw-reveal aria-label="Group companies">
			<span class="aw-pill-soft">Group Delta</span>
			<span class="aw-pill-soft">Delta Global</span>
			<span class="aw-pill-soft">Worldwide Shipping</span>
			<span class="aw-pill-soft">Root Delta - Oman</span>
			<span class="aw-pill-soft">World wide automotive</span>
			<span class="aw-pill-soft">DIWL Technologies</span>
			<span class="aw-pill-soft">Tech Delta</span>
			<span class="aw-pill-soft">DIWL</span>
			<span class="aw-pill-soft">Delta (UAE)</span>
			<span class="aw-pill-soft">Ceramic Pro Mangalore</span>
		</div>
	</div>
</section>

</div>
<!-- /wp:html -->
HTML;
}

/**
 * Awwwards About Us.
 *
 * @return string
 */
function delta_ports_content_about() {
	$a1  = delta_ports_img( 'Awards-new-1.webp' );
	$a8  = delta_ports_img( 'Awards-new-8.webp' );
	$a9  = delta_ports_img( 'Awards-new-9.webp' );
	$a10 = delta_ports_img( 'Awards-new-10.webp' );
	$op  = delta_ports_img( 'our-operation-delta-port4.webp' );
	$logos = delta_ports_aww_logos();

	return <<<HTML
<!-- wp:html -->
<div class="aw-page aw-about" data-aw-page="about">

<section class="aw-about-hero">
	<div class="aw-about-hero__top">
		<nav class="aw-crumb" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>About Us</span></nav>
		<p class="aw-kicker">Who we are</p>
	</div>
	<p class="aw-about-hero__label">Delta Ports</p>
	<h1 class="aw-about-hero__title" data-aw-split>
		<span class="aw-line"><span class="aw-word">About Us</span></span>
	</h1>
	<p class="aw-about-hero__lead">Delta Ports is a port-led infrastructure and terminal operations company focused on enabling efficient cargo movement and supporting regional and international trade.</p>
	<div class="aw-about-hero__stats">
		<div class="aw-mini-stat" data-aw-reveal><strong data-count-to="25" data-suffix="+">0+</strong><span>Years of Legacy</span></div>
		<div class="aw-mini-stat" data-aw-reveal><strong data-count-to="150" data-suffix="k">0k</strong><span>TEU capacity</span></div>
		<div class="aw-mini-stat" data-aw-reveal><strong data-count-to="25" data-suffix="M">0M</strong><span>MT cargo capacity</span></div>
	</div>
</section>

<section class="aw-marquee-band aw-marquee-band--tight">
	<div class="aw-marquee-band__head">
		<p class="aw-kicker">Partners</p>
		<h2>Partnering with Industry Leaders</h2>
		<p class="aw-sub">Delta Group collaborates with clients and partners across infrastructure, logistics, industrial services, and technology — serving industrial companies and global shipping lines with reliable execution.</p>
	</div>
	<div class="aw-marquee dp-marquee"><div class="aw-marquee__track dp-marquee__track">{$logos}{$logos}</div></div>
</section>

<section class="aw-vm">
	<article class="aw-vm__card aw-vm__card--vision" data-aw-reveal>
		<h3 class="aw-vm__tag">Vision</h3>
		<p>To be a leader in the port terminal industry and the customer’s first choice for worldwide integrated maritime and port logistics services.</p>
	</article>
	<article class="aw-vm__card aw-vm__card--mission" data-aw-reveal>
		<h3 class="aw-vm__tag">Mission</h3>
		<p>To standardize operational efficiency and service effectiveness in port operations — partnering with customers as an extended arm of their business.</p>
	</article>
</section>

<section class="aw-philosophy">
	<div class="aw-philosophy__head" data-aw-reveal>
		<p class="aw-kicker">Principles</p>
		<h2>Operating Philosophy</h2>
		<p class="aw-sub">Operations at Delta Ports are guided by three core principles that ensure reliability and long-term efficiency.</p>
	</div>
	<div class="aw-philosophy__list">
		<article class="aw-ph-item" data-aw-reveal>
			<span class="aw-ph-item__num">01</span>
			<div>
				<h3>Operational Discipline</h3>
				<p>Structured processes, safety protocols, and operational readiness ensure reliable terminal performance and efficient vessel turnaround.</p>
			</div>
		</article>
		<article class="aw-ph-item" data-aw-reveal>
			<span class="aw-ph-item__num">02</span>
			<div>
				<h3>Infrastructure Stewardship</h3>
				<p>Terminal assets are managed with a long-term perspective — balancing capacity, maintenance, and upgrades for sustained efficiency.</p>
			</div>
		</article>
		<article class="aw-ph-item" data-aw-reveal>
			<span class="aw-ph-item__num">03</span>
			<div>
				<h3>Connectivity &amp; Coordination</h3>
				<p>Operations integrate road, rail, and maritime networks for coordinated cargo movement between ports and hinterland destinations.</p>
			</div>
		</article>
	</div>
</section>

<section class="aw-split aw-split--group">
	<div class="aw-split__body" data-aw-reveal>
		<p class="aw-kicker">Ecosystem</p>
		<h2>Part of Group Delta</h2>
		<p>Delta Ports operates as part of Group Delta’s integrated infrastructure and logistics ecosystem. The business complements the Group’s presence across logistics, engineering, and industrial services — enabling alignment across port-led supply chains.</p>
		<p>This integration supports coordinated planning, operational resilience, and long-term infrastructure development.</p>
	</div>
	<div class="aw-split__media" data-aw-reveal>
		<img src="{$op}" alt="Group Delta operations" loading="lazy" />
	</div>
</section>

<section class="aw-awards aw-awards--about">
	<div class="aw-awards__head" data-aw-reveal>
		<p class="aw-kicker">Recognition</p>
		<h2>Awards, Recognition &amp; Coverages</h2>
		<p class="aw-sub">From its origins in shipping and logistics, Group Delta has evolved into a diversified infrastructure-led enterprise.</p>
	</div>
	<div class="aw-awards__masonry">
		<figure data-aw-reveal><img src="{$a1}" alt="Award" loading="lazy" /></figure>
		<figure data-aw-reveal><img src="{$a8}" alt="Award" loading="lazy" /></figure>
		<figure data-aw-reveal><img src="{$a9}" alt="Award" loading="lazy" /></figure>
		<figure data-aw-reveal><img src="{$a10}" alt="Award" loading="lazy" /></figure>
	</div>
</section>

<section class="aw-safety">
	<div class="aw-safety__inner" data-aw-reveal>
		<p class="aw-kicker">Governance</p>
		<h2>Safety and Responsibility.</h2>
		<p class="aw-lead-accent" style="color:rgba(255,255,255,.9)">Secure people. Protect the environment.</p>
		<div class="aw-safety__grid">
			<div>
				<h3>Safety culture</h3>
				<p>Safety is integral to all Delta Ports operations — structured practices, trained personnel, and strict regulatory adherence for secure working environments.</p>
			</div>
			<div>
				<h3>Environmental duty</h3>
				<p>Pollution control, compliance, and continuous efforts to minimize environmental impact while supporting sustainable growth are embedded into daily operations.</p>
			</div>
		</div>
		<a class="aw-btn aw-btn--fill" href="/sustainability/"><span>Our sustainability approach</span><em>→</em></a>
	</div>
</section>

</div>
<!-- /wp:html -->
HTML;
}
