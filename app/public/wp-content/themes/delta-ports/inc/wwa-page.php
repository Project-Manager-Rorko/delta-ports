<?php
/**
 * WWA page — Delta Ports home design system + reference content.
 * Reference: Home page (1).png (Worldwide Automotive).
 *
 * @package Delta_Ports
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WWA image URL under assets/images/wwa/.
 *
 * @param string $file Filename.
 * @return string
 */
function delta_ports_wwa_img( $file ) {
	return delta_ports_img( 'wwa/' . ltrim( $file, '/' ) );
}

/**
 * First existing WWA asset.
 *
 * @param string ...$files Filenames.
 * @return string URL.
 */
function delta_ports_wwa_first( ...$files ) {
	foreach ( $files as $file ) {
		$path = DELTA_PORTS_DIR . '/assets/images/wwa/' . ltrim( $file, '/' );
		if ( file_exists( $path ) && filesize( $path ) > 8000 ) {
			return delta_ports_wwa_img( $file );
		}
	}
	return delta_ports_wwa_img( $files[0] );
}

/**
 * Full WWA page markup.
 *
 * @return string
 */
function delta_ports_content_wwa() {
	$hero_poster = esc_url( delta_ports_wwa_first( 'hero.webp', 'hero-bg.webp', 'about-main.webp' ) );
	$hero_vid    = '';
	if ( file_exists( DELTA_PORTS_DIR . '/assets/video/wwa/hero.mp4' ) ) {
		$hero_vid = esc_url( delta_ports_vid( 'wwa/hero.mp4' ) );
	} elseif ( file_exists( DELTA_PORTS_DIR . '/assets/video/home-banner.mp4' ) ) {
		$hero_vid = esc_url( delta_ports_vid( 'home-banner.mp4' ) );
	}

	// Delta home pattern: <video class="dp-home-hero__media"> preferred.
	if ( $hero_vid ) {
		$hero_media = '<video class="dp-home-hero__media wwa-hero__video" src="' . $hero_vid . '" autoplay muted loop playsinline poster="' . $hero_poster . '"></video>';
	} else {
		$hero_media = '<div class="dp-home-hero__media wwa-hero__video" style="background-image:url(\'' . $hero_poster . '\')"></div>';
	}

	$trust = esc_url( delta_ports_wwa_first( 'about-main.webp', 'trust-photo.webp' ) );

	$prod_mini      = esc_url( delta_ports_wwa_first( 'r1b.webp', 'fleet-mini-excavators.webp' ) );
	$prod_wheel     = esc_url( delta_ports_wwa_first( 'r1c.webp', 'fleet-wheel-loader.webp' ) );
	$prod_attach    = esc_url( delta_ports_wwa_first( 'r2a.webp', 'card-a.webp', 'fleet-urban.webp' ) );
	$prod_mining    = esc_url( delta_ports_wwa_first( 'r2b.webp', 'card-b.webp', 'fleet-aggregate.webp' ) );
	$prod_construct = esc_url( delta_ports_wwa_first( 'r2c.webp', 'card-c.webp', 'fleet-banner.webp' ) );

	$support_team  = esc_url( delta_ports_wwa_first( 'support-team.webp', 'solution-team.webp' ) );
	$support_hands = esc_url( delta_ports_wwa_first( 'solution-service.webp', 'quality-banner.webp' ) );

	$partners = array(
		'Delta Ports',
		'Delta Global',
		'Worldwide Shipping',
		'Root Delta - Oman',
		'World wide automotive',
		'DIWL Technologies',
		'Tech Delta',
		'DIWL',
		'Delta (UAE)',
		'Ceramic Pro Mangalore',
	);
	$partner_html = '';
	foreach ( $partners as $p ) {
		$partner_html .= '<span class="wwa-pill">' . esc_html( $p ) . '</span>';
	}

	$arrow = '<span class="wwa-prod-card__arrow" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>';

	return '<!-- wp:html -->
<div class="wwa-page">

<!-- HERO: Delta home banner pattern + reference content + video -->
<section class="dp-home-hero wwa-hero" aria-label="Hero">
	' . $hero_media . '
	<div class="dp-home-hero__overlay wwa-hero__overlay" aria-hidden="true"></div>
	<div class="dp-home-hero__inner wwa-hero__inner">
		<div class="wwa-hero__main">
			<span class="wwa-hero__badge"><i aria-hidden="true"></i> Hyundai Authorized Dealer</span>
			<h1 class="wwa-hero__title">Powering Your Projects<br>with Hyundai Excellence.</h1>
		</div>
		<div class="wwa-hero__side">
			<p class="wwa-hero__lead">Providing high-performance Hyundai equipment, supported by fast-response service and application-focused guidance — optimized for demanding operations and tight execution windows.</p>
			<a class="dp-home-hero__btn wwa-btn" href="/about-us/">About Us</a>
		</div>
	</div>
</section>

<!-- BUILT ON TRUST -->
<section class="wwa-sec wwa-trust">
	<div class="wwa-wrap wwa-trust__grid">
		<div class="wwa-trust__copy">
			<h2>Built on Trust</h2>
			<p>Worldwide Automotive focuses on delivering reliable operations, scalable solutions, and long-term value for diverse environments. As part of our OEM partnerships, we are an authorized dealer for Hyundai Construction Equipment, enabling us to offer globally proven equipment alongside strong local support.</p>
			<div class="wwa-trust__stats">
				<div class="wwa-stat wwa-stat--a"><strong>500+</strong><span>Machines Delivered</span></div>
				<div class="wwa-stat wwa-stat--b"><strong>300+</strong><span>Active Customers</span></div>
				<div class="wwa-stat wwa-stat--c"><strong>90+</strong><span>Mini Excavators Supplied</span></div>
			</div>
		</div>
		<div class="wwa-trust__media">
			<img class="wwa-trust__photo" src="' . $trust . '" alt="Hyundai excavators handling aggregate" width="960" height="720" loading="eager" decoding="async" />
			<aside class="wwa-dealer-card">
				<div class="wwa-dealer-card__brand">
					<span class="wwa-dealer-card__hd">HD</span>
					<span class="wwa-dealer-card__lines">
						<strong>CONSTRUCTION EQUIPMENT</strong>
						<em>INDIA</em>
					</span>
				</div>
				<p class="wwa-dealer-card__tag">AUTHORIZED DEALER</p>
				<p class="wwa-dealer-card__name">Hyundai Construction Equipment</p>
			</aside>
		</div>
	</div>
</section>

<!-- OUR PRODUCT -->
<section class="wwa-sec wwa-products">
	<div class="wwa-wrap">
		<div class="wwa-products__grid">
			<article class="wwa-products__intro">
				<h2>Our Product</h2>
				<p>Built for durability and engineered for precision, our comprehensive range ensures maximum productivity across your most demanding operations.</p>
			</article>
			<a class="wwa-prod-card" href="/wwa/">
				<img src="' . $prod_mini . '" alt="Mini Excavators" width="720" height="480" loading="lazy" decoding="async" />
				' . $arrow . '
			</a>
			<a class="wwa-prod-card" href="/wwa/">
				<img src="' . $prod_wheel . '" alt="Wheel Loaders" width="720" height="480" loading="lazy" decoding="async" />
				' . $arrow . '
			</a>
			<a class="wwa-prod-card" href="/wwa/">
				<img src="' . $prod_attach . '" alt="Attachments" width="720" height="480" loading="lazy" decoding="async" />
				' . $arrow . '
			</a>
			<a class="wwa-prod-card" href="/wwa/">
				<img src="' . $prod_mining . '" alt="Mining Excavators" width="720" height="480" loading="lazy" decoding="async" />
				' . $arrow . '
			</a>
			<a class="wwa-prod-card" href="/wwa/">
				<img src="' . $prod_construct . '" alt="Construction Excavators" width="720" height="480" loading="lazy" decoding="async" />
				' . $arrow . '
			</a>
		</div>
	</div>
</section>

<!-- SALES, SERVICE & SUPPORT (reference layout) -->
<section class="wwa-sec wwa-support">
	<div class="wwa-wrap wwa-support__grid">
		<div class="wwa-support__copy">
			<h2>Sales, Service, &amp; Support</h2>
			<p class="wwa-support__lead">Our approach extends beyond equipment supply. Worldwide Automotive provides structured support designed to keep machines operating reliably in the field.</p>
			<ul class="wwa-support__list">
				<li>Coordinated service assistance through trained technicians</li>
				<li>Application-led sales support</li>
				<li>Spare parts availability and parts coordination</li>
				<li>Ongoing customer engagement and follow-up</li>
			</ul>
		</div>
		<div class="wwa-support__right">
			<p class="wwa-support__aside">This integrated support model helps customers reduce downtime and operate with confidence.</p>
			<div class="wwa-support__photos">
				<figure class="wwa-support__fig wwa-support__fig--main">
					<img src="' . $support_team . '" alt="Service team reviewing equipment plans" width="800" height="560" loading="lazy" decoding="async" />
				</figure>
				<figure class="wwa-support__fig wwa-support__fig--side">
					<img src="' . $support_hands . '" alt="Technician servicing machinery components" width="640" height="480" loading="lazy" decoding="async" />
				</figure>
			</div>
		</div>
	</div>
</section>

<!-- GLOBAL PRESENCE -->
<section class="wwa-sec wwa-global">
	<div class="wwa-wrap">
		<header class="wwa-global__head">
			<h2>Global Presence</h2>
			<p>With operations rooted in India and expanding across the Middle East and key trade corridors, Delta Group supports regional and international infrastructure and logistics requirements.</p>
		</header>
		<div class="wwa-global__stats">
			<div class="wwa-global__stat">
				<strong>36+</strong>
				<span>Years of Expertise</span>
			</div>
			<div class="wwa-global__map" aria-hidden="true">
				<div class="wwa-global__delta">DELTA</div>
			</div>
			<div class="wwa-global__stat">
				<strong>300+</strong>
				<span>Experts to serve</span>
			</div>
		</div>
		<div class="wwa-global__partners" aria-label="Group companies">
			' . $partner_html . '
		</div>
	</div>
</section>

</div>
<!-- /wp:html -->
';
}
