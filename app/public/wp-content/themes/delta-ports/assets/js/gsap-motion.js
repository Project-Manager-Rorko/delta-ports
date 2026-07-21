/**
 * GSAP scroll + smooth motion (live parity).
 * Loaded deferred / after idle so LCP is not blocked.
 */
(function () {
	'use strict';

	function prefersReduced() {
		return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	}

	function whenIdle(fn) {
		if (typeof window.requestIdleCallback === 'function') {
			window.requestIdleCallback(fn, { timeout: 1800 });
		} else {
			window.setTimeout(fn, 400);
		}
	}

	function loadScript(src) {
		return new Promise(function (resolve, reject) {
			if (document.querySelector('script[src="' + src + '"]')) {
				resolve();
				return;
			}
			var s = document.createElement('script');
			s.src = src;
			s.async = true;
			s.onload = function () { resolve(); };
			s.onerror = function () { reject(new Error('load fail ' + src)); };
			document.head.appendChild(s);
		});
	}

	function revealFallback() {
		document.querySelectorAll('.dp-reveal, [data-aos], .dp-text-reveal, .dp-gsap').forEach(function (el) {
			el.classList.add('aos-animate', 'is-in', 'dp-reveal-in', 'is-visible');
		});
	}

	function initSmoothScroll() {
		if (prefersReduced()) return;
		// Native smooth for in-page anchors (cheap, no Lenis weight).
		document.documentElement.style.scrollBehavior = 'smooth';

		document.addEventListener('click', function (e) {
			var a = e.target.closest('a[href^="#"]');
			if (!a) return;
			var id = a.getAttribute('href');
			if (!id || id === '#') return;
			var target = document.querySelector(id);
			if (!target) return;
			e.preventDefault();
			var header = document.querySelector('.dp-site-header');
			var offset = header ? header.offsetHeight + 12 : 84;
			var top = target.getBoundingClientRect().top + window.pageYOffset - offset;
			window.scrollTo({ top: top, behavior: 'smooth' });
		});
	}

	function prepareGsapTargets() {
		var selectors = [
			'.dp-gb-section > .wp-block-heading',
			'.dp-gb-section > .wp-block-paragraph',
			'.dp-gb-section > .wp-block-columns',
			'.dp-home-ops-card',
			'.dp-home-onestop__stat',
			'.dp-home-awards__item',
			'.dp-home-lead__photo',
			'.dp-home-lead__copy',
			'.dp-home-projects__rail article',
			'.dp-home-sustain__media-wrap',
			'.dp-home-sustain__copy',
			'.dp-home-business__copy',
			'.dp-home-business__stat',
			'.dp-home-business__brands span',
			'.dp-ops-section h2',
			'.dp-ops-section p',
			'.dp-ops-stat-tile',
			'.dp-ops-cap-card',
			'.dp-ops-storage-card',
			'.dp-ops-mosaic__card',
			'.dp-ops-mosaic > .dp-ops-rounded',
			'.dp-ops-bento',
			'.dp-ops-faq__item',
			'.dp-lead-card',
			'.dp-contact-office',
			'.dp-contact-talent__panel',
			'.dp-contact-talent__form',
			'.dp-about-vm__card',
			'.dp-about-phil__card'
		];
		document.querySelectorAll(selectors.join(',')).forEach(function (el) {
			if (el.classList.contains('dp-gsap')) return;
			el.classList.add('dp-gsap');
		});
	}

	function initGsapMotion() {
		if (!window.gsap) {
			revealFallback();
			return;
		}
		var gsap = window.gsap;
		var ScrollTrigger = window.ScrollTrigger;
		if (ScrollTrigger) {
			gsap.registerPlugin(ScrollTrigger);
		}

		// Hero title soft entrance.
		var heroes = document.querySelectorAll(
			'.dp-home-hero__left h1, .dp-about-hero__inner h1, .dp-ops-hero__inner h1, .dp-contact-hero h1'
		);
		heroes.forEach(function (el) {
			gsap.fromTo(
				el,
				{ y: 36, opacity: 0 },
				{ y: 0, opacity: 1, duration: 0.9, ease: 'power3.out', delay: 0.08 }
			);
		});

		var heroSubs = document.querySelectorAll(
			'.dp-home-hero__right p, .dp-ops-hero__lead, .dp-contact-hero__lead, .dp-home-hero__btn'
		);
		if (heroSubs.length) {
			gsap.fromTo(
				heroSubs,
				{ y: 24, opacity: 0 },
				{ y: 0, opacity: 1, duration: 0.8, ease: 'power2.out', delay: 0.2, stagger: 0.08 }
			);
		}

		// Scroll reveals — once only. immediateRender:false keeps layout/spacing intact
		// (never leave whole sections opacity:0 while waiting for scroll).
		if (!ScrollTrigger) {
			revealFallback();
			return;
		}

		document.querySelectorAll('.dp-gsap').forEach(function (el, i) {
			gsap.from(el, {
				y: 22,
				autoAlpha: 0,
				duration: 0.65,
				ease: 'power2.out',
				delay: (i % 4) * 0.03,
				immediateRender: false,
				clearProps: 'transform,opacity,visibility',
				scrollTrigger: {
					trigger: el,
					start: 'top 90%',
					toggleActions: 'play none none none',
					once: true
				},
				onComplete: function () {
					el.classList.add('aos-animate', 'is-in', 'dp-reveal-in', 'is-visible');
				}
			});
		});

		// Soft hero media parallax only (does not change document flow/spacing).
		document.querySelectorAll('.dp-home-hero__media, .dp-about-hero__media').forEach(function (el) {
			gsap.to(el, {
				yPercent: 6,
				ease: 'none',
				scrollTrigger: {
					trigger: el.closest('section') || el,
					start: 'top top',
					end: 'bottom top',
					scrub: true
				}
			});
		});
	}

	function boot() {
		initSmoothScroll();
		if (prefersReduced()) {
			revealFallback();
			return;
		}
		prepareGsapTargets();

		// Load GSAP after first paint / idle — does not block LCP.
		whenIdle(function () {
			var base = 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/';
			loadScript(base + 'gsap.min.js')
				.then(function () { return loadScript(base + 'ScrollTrigger.min.js'); })
				.then(function () { initGsapMotion(); })
				.catch(function () { revealFallback(); });
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
