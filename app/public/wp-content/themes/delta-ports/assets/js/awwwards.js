/**
 * Awwwards Home + About interactions
 */
(function () {
	'use strict';

	function ready(fn) {
		if (document.readyState !== 'loading') fn();
		else document.addEventListener('DOMContentLoaded', fn);
	}

	function prefersReduced() {
		return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	}

	function initReveal() {
		var nodes = document.querySelectorAll('[data-aw-reveal]');
		if (!nodes.length) return;
		if (prefersReduced() || !('IntersectionObserver' in window)) {
			nodes.forEach(function (n) { n.classList.add('is-in'); });
			return;
		}
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (e) {
				if (e.isIntersecting) {
					e.target.classList.add('is-in');
					io.unobserve(e.target);
				}
			});
		}, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });
		nodes.forEach(function (n) { io.observe(n); });
		setTimeout(function () {
			nodes.forEach(function (n) { n.classList.add('is-in'); });
		}, 2800);
	}

	function initHeroParallax() {
		var hero = document.querySelector('[data-aw-hero]');
		if (!hero || prefersReduced()) return;
		var img = hero.querySelector('.aw-hero__img');
		if (!img) return;

		var onScroll = function () {
			var rect = hero.getBoundingClientRect();
			if (rect.bottom < 0 || rect.top > window.innerHeight) return;
			var p = Math.min(1, Math.max(0, -rect.top / (rect.height || 1)));
			img.style.transform = 'scale(' + (1.08 + p * 0.06) + ') translate3d(0,' + (p * 40) + 'px,0)';
		};
		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll();

		if (window.matchMedia('(min-width: 900px)').matches) {
			hero.addEventListener('mousemove', function (e) {
				var r = hero.getBoundingClientRect();
				var x = (e.clientX - r.left) / r.width - 0.5;
				var y = (e.clientY - r.top) / r.height - 0.5;
				var orbA = hero.querySelector('.aw-hero__orb--a');
				var orbB = hero.querySelector('.aw-hero__orb--b');
				if (orbA) orbA.style.transform = 'translate3d(' + (x * -30) + 'px,' + (y * -20) + 'px,0)';
				if (orbB) orbB.style.transform = 'translate3d(' + (x * 24) + 'px,' + (y * 18) + 'px,0)';
			}, { passive: true });
		}
	}

	function initMagneticButtons() {
		if (prefersReduced() || window.matchMedia('(max-width: 900px)').matches) return;
		document.querySelectorAll('.aw-btn').forEach(function (btn) {
			btn.addEventListener('mousemove', function (e) {
				var r = btn.getBoundingClientRect();
				var x = e.clientX - (r.left + r.width / 2);
				var y = e.clientY - (r.top + r.height / 2);
				btn.style.transform = 'translate(' + (x * 0.15) + 'px,' + (y * 0.2) + 'px)';
			});
			btn.addEventListener('mouseleave', function () {
				btn.style.transform = '';
			});
		});
	}

	function initOpsTilt() {
		if (prefersReduced() || window.matchMedia('(max-width: 900px)').matches) return;
		// Skip live-style hover-card ops (needs clean hover transform for content panel).
		document.querySelectorAll('.aw-ops-card:not(.hover-card), .aw-vm__card, .aw-tile').forEach(function (card) {
			card.addEventListener('mousemove', function (e) {
				var r = card.getBoundingClientRect();
				var x = (e.clientX - r.left) / r.width - 0.5;
				var y = (e.clientY - r.top) / r.height - 0.5;
				card.style.transform = 'perspective(1000px) rotateX(' + (y * -4) + 'deg) rotateY(' + (x * 5) + 'deg) translateY(-4px)';
			});
			card.addEventListener('mouseleave', function () {
				card.style.transform = '';
			});
		});
	}

	function ensureMarquee() {
		document.querySelectorAll('.aw-marquee__track').forEach(function (track) {
			if (track.dataset.awCloned) return;
			// content already doubled in markup sometimes
			if (track.children.length < 10) {
				track.innerHTML = track.innerHTML + track.innerHTML;
			}
			track.dataset.awCloned = '1';
		});
	}

	ready(function () {
		if (!document.querySelector('.aw-page')) return;
		document.documentElement.classList.add('aw-mode');
		// Enable progressive reveal only when motion is OK
		if (!prefersReduced()) {
			document.documentElement.classList.add('aw-motion');
		}
		initReveal();
		initHeroParallax();
		initMagneticButtons();
		initOpsTilt();
		ensureMarquee();
		// Force any stuck hidden text visible quickly
		setTimeout(function () {
			document.querySelectorAll('[data-aw-reveal]').forEach(function (n) {
				n.classList.add('is-in');
			});
			document.querySelectorAll('.aw-word').forEach(function (n) {
				n.style.opacity = '1';
				n.style.transform = 'none';
			});
		}, 1200);
	});
})();
