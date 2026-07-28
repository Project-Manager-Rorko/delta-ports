/**
 * Local enhancements that do not alter content visibility or structure.
 */
(function () {
	'use strict';

	function ready(fn) {
		if (document.readyState !== 'loading') fn();
		else document.addEventListener('DOMContentLoaded', fn);
	}

	function initVideos() {
		document.querySelectorAll('.dp-home-hero__media, .dp-about-hero__media, .dp-home-onestop__video').forEach(function (video) {
			if (video.tagName !== 'VIDEO') return;
			video.muted = true;
			video.setAttribute('playsinline', '');
			var playback = video.play();
			if (playback && typeof playback.catch === 'function') playback.catch(function () {});
		});
	}

	function initSectionMotion() {
		var sections = document.querySelectorAll('.dp-gb-section, .dp-section, .dp-ops-section, .dp-ops-stats, .dp-lead-team, .dp-contact-offices, .dp-contact-talent, .dp-media-shell, .dp-media-single__content, .dp-about-hero, .dp-about-phil, .dp-home-lead, .dp-home-ops, .dp-home-onestop, .dp-home-projects, .dp-home-sustain, .dp-home-business');
		if (!sections.length) return;

		function reveal(section) {
			section.classList.add('dp-section-in-view');
		}

		if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) {
			sections.forEach(reveal);
			return;
		}

		var observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) return;
				reveal(entry.target);
				observer.unobserve(entry.target);
			});
		}, { threshold: 0.2, rootMargin: '0px 0px -10% 0px' });

		sections.forEach(function (section) { observer.observe(section); });
	}

	function initCounters() {
		var numbers = document.querySelectorAll('[data-count-to]');
		if (!numbers.length) return;

		function finalText(number) {
			var target = Number(number.getAttribute('data-count-to')) || 0;
			return target + (number.getAttribute('data-suffix') || '');
		}

		// Fallback: show the real value immediately so a counter never sticks at 0.
		numbers.forEach(function (number) { number.textContent = finalText(number); });

		// No motion (or no observer): keep the real values, skip the animation.
		if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) {
			return;
		}

		function run(number) {
			if (number.dataset.counted) return;
			number.dataset.counted = '1';
			var target = Number(number.getAttribute('data-count-to')) || 0;
			var suffix = number.getAttribute('data-suffix') || '';
			var siblings = number.parentElement ? number.parentElement.parentElement.querySelectorAll('[data-count-to]') : [];
			var index = Array.prototype.indexOf.call(siblings, number);

			window.setTimeout(function () {
				var startedAt = null;
				number.textContent = '0' + suffix;

				function frame(now) {
					if (!startedAt) startedAt = now;
					var progress = Math.min(1, (now - startedAt) / 1000);
					number.textContent = Math.round(target * (1 - Math.pow(1 - progress, 3))) + suffix;
					if (progress < 1) requestAnimationFrame(frame);
					else number.textContent = finalText(number);
				}

				requestAnimationFrame(frame);
			}, Math.max(0, index) * 130);
		}

		var observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) return;
				run(entry.target);
				observer.unobserve(entry.target);
			});
		}, { threshold: 0.35 });

		numbers.forEach(function (number) { observer.observe(number); });
	}

	ready(function () {
		initVideos();
		initSectionMotion();
		initCounters();
	});
})();
