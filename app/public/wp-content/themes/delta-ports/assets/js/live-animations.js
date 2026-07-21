/**
 * Live-site style scroll animations + smooth scrolling + text reveal.
 * Mirrors vipaccounts.org/delta-ports fade-up behaviour.
 */
(function () {
	'use strict';

	function prefersReduced() {
		return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	}

	function ready(fn) {
		if (document.readyState !== 'loading') fn();
		else document.addEventListener('DOMContentLoaded', fn);
	}

	/**
	 * Smooth in-page anchor scrolling (accounts for sticky header).
	 */
	function initSmoothScroll() {
		if (prefersReduced()) return;
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

	/**
	 * Mark block children for reveal (no HTML edit required).
	 */
	function prepareTargets() {
		var selectors = [
			'.dp-gb-section > .wp-block-heading',
			'.dp-gb-section > .wp-block-paragraph',
			'.dp-gb-section > .wp-block-columns',
			'.dp-gb-section > .wp-block-image',
			'.dp-gb-section > .wp-block-buttons',
			'.dp-gb-section .wp-block-column',
			'.dp-gb-ops-card',
			'.dp-home-ops-card',
			'.dp-home-counter',
			'.dp-home-onestop__stat',
			'.dp-home-onestop__media',
			'.dp-home-awards__item',
			'.dp-home-business__stat',
			'.dp-home-business__brands span',
			'.dp-home-lead__photo',
			'.dp-home-sustain__media',
			'.dp-home-sustain__copy',
			'.dp-home-hero__left h1',
			'.dp-home-hero__right p',
			'.dp-home-hero__btn',
			'.dp-about-hero__inner h1',
			'.dp-about-hero__lead',
			'.dp-about-hero__stat',
			'.dp-about-vm__card',
			'.dp-about-phil__card',
			'.dp-about-phil__media',
			'.dp-about-phil__head h2',
			'.dp-about-phil__head p',
			'.dp-about-safety__copy h2',
			'.dp-about-safety__text p',
			'.dp-about-safety__images figure',
			'.dp-home-business__copy h2',
			'.dp-home-business__copy p',
			'.dp-gb-cta > .wp-block-heading',
			'.dp-gb-cta > .wp-block-paragraph',
			'.dp-gb-cta > .wp-block-buttons',
			'.dp-gb-faq-item',
			'.dp-gb-page-hero .wp-block-heading',
			'.dp-gb-page-hero .wp-block-paragraph',
			'.dp-gb-sustain > .wp-block-column'
		];

		document.querySelectorAll(selectors.join(',')).forEach(function (el, i) {
			if (el.hasAttribute('data-aos')) return;
			// Text elements get text-reveal; others fade-up.
			var isText = el.matches('h1, h2, h3, h4, h5, h6, p, .wp-block-heading, .wp-block-paragraph') ||
				el.classList.contains('dp-home-hero__btn');
			el.setAttribute('data-aos', isText ? 'fade-up' : 'fade-up');
			el.classList.add('dp-reveal');
			if (isText) el.classList.add('dp-reveal--text');
			var delay = (i % 5) * 70;
			if (delay) el.setAttribute('data-aos-delay', String(delay));
		});
	}

	/**
	 * Word-level text reveal for hero titles.
	 */
	function prepareTextReveal() {
		if (prefersReduced()) return;
		var titles = document.querySelectorAll(
			'.dp-home-hero__left h1, .dp-about-hero__inner h1, .dp-gb-section > .wp-block-heading'
		);
		titles.forEach(function (el) {
			if (el.dataset.revealReady) return;
			var text = el.textContent.trim();
			if (!text || text.length > 90) return;
			var words = text.split(/(\s+)/);
			el.innerHTML = words.map(function (w) {
				if (/^\s+$/.test(w)) return w;
				return '<span class="dp-reveal-word"><span class="dp-reveal-word__inner">' + w + '</span></span>';
			}).join('');
			el.dataset.revealReady = '1';
			el.classList.add('dp-text-reveal');
		});
	}

	function initAOS() {
		if (prefersReduced()) {
			document.querySelectorAll('[data-aos], .dp-reveal, .dp-text-reveal').forEach(function (el) {
				el.classList.add('aos-animate', 'is-in', 'dp-reveal-in');
			});
			return;
		}

		if (window.AOS && typeof window.AOS.init === 'function') {
			window.AOS.init({
				duration: 900,
				easing: 'ease-out-cubic',
				once: true,
				offset: 50,
				delay: 0
			});
		}

		// Custom reveal observer (works with or without AOS).
		var nodes = document.querySelectorAll('.dp-reveal, .dp-text-reveal, [data-aos]');
		if (!nodes.length) return;

		if (!('IntersectionObserver' in window)) {
			nodes.forEach(function (n) {
				n.classList.add('aos-animate', 'is-in', 'dp-reveal-in');
			});
			return;
		}

		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) return;
				entry.target.classList.add('aos-animate', 'is-in', 'dp-reveal-in');
				io.unobserve(entry.target);
			});
		}, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });

		nodes.forEach(function (n) { io.observe(n); });

		// Safety: never leave content invisible
		setTimeout(function () {
			nodes.forEach(function (n) {
				if (!n.classList.contains('aos-animate') && !n.classList.contains('dp-reveal-in')) {
					n.classList.add('aos-animate', 'is-in', 'dp-reveal-in');
				}
			});
		}, 2800);
	}

	function initCounters() {
		var nums = document.querySelectorAll('[data-count-to]');
		if (!nums.length || prefersReduced()) return;

		function run(el) {
			var to = parseFloat(el.getAttribute('data-count-to')) || 0;
			var suffix = el.getAttribute('data-suffix') || '';
			var start = 0;
			var dur = 1300;
			var t0 = null;
			function frame(t) {
				if (!t0) t0 = t;
				var p = Math.min(1, (t - t0) / dur);
				var eased = 1 - Math.pow(1 - p, 3);
				var val = Math.round(start + (to - start) * eased);
				el.textContent = val + suffix;
				if (p < 1) requestAnimationFrame(frame);
			}
			requestAnimationFrame(frame);
		}

		if (!('IntersectionObserver' in window)) {
			nums.forEach(run);
			return;
		}
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (e) {
				if (!e.isIntersecting) return;
				run(e.target);
				io.unobserve(e.target);
			});
		}, { threshold: 0.35 });
		nums.forEach(function (n) { io.observe(n); });
	}

	/**
	 * Ensure banner videos play (autoplay policies / missing attrs).
	 */
	function initVideos() {
		document.querySelectorAll('.dp-home-hero__media, .dp-about-hero__media, .dp-home-onestop__video').forEach(function (v) {
			if (v.tagName !== 'VIDEO') return;
			v.muted = true;
			v.setAttribute('playsinline', '');
			v.setAttribute('webkit-playsinline', '');
			var p = v.play();
			if (p && typeof p.catch === 'function') {
				p.catch(function () { /* autoplay blocked — silent */ });
			}
		});
	}

	ready(function () {
		initSmoothScroll();
		if (!document.querySelector('.wp-block-post-content, .entry-content, .dp-gb-section, .dp-home-hero, .dp-about-hero')) {
			initVideos();
			return;
		}
		prepareTextReveal();
		prepareTargets();
		initAOS();
		initCounters();
		initVideos();
	});
})();
