/**
 * Delta Ports — global front-end fixes.
 * Eager-load the images most likely to be seen immediately or that sit on
 * dark frames, so heavy lazy images never flash as black/blank holes.
 */
(function () {
	'use strict';
	function run() {
		var critical = [
			'.dp-lead-card__photo img',
			'.dp-about-hero__media img', '.dp-about-hero__media video',
			'.dp-ops-hero__media img', '.dp-ops-hero__media video',
			'.dp-gb-page-hero img', '.dp-gb-page-hero video',
			'.dp-contact-hero img', '.dp-contact-office img', '.dp-contact-office iframe',
			'.dp-hero__bg img', '.dp-hero__bg video'
		].join(',');
		try {
			document.querySelectorAll(critical).forEach(function (el) {
				if (el.getAttribute('loading') === 'lazy') el.setAttribute('loading', 'eager');
				el.setAttribute('decoding', 'async');
				if (el.tagName === 'IMG') el.setAttribute('fetchpriority', 'high');
				if (el.dataset && el.dataset.src && !el.getAttribute('src')) el.setAttribute('src', el.dataset.src);
			});
		} catch (e) {}

		// Near-viewport lazy images -> eager (measured after first layout).
		try {
			var reach = Math.max(window.innerHeight || 800, 800) * 1.4;
			document.querySelectorAll('img[loading="lazy"]').forEach(function (img) {
				var top = img.getBoundingClientRect().top + (window.scrollY || 0);
				if (top < reach) { img.setAttribute('loading', 'eager'); img.setAttribute('fetchpriority', 'high'); }
			});
		} catch (e) {}
	}
	if (document.readyState !== 'loading') run();
	else document.addEventListener('DOMContentLoaded', run);
})();

/* scroll reveal for cinematic inner pages (.dpx-page .dpx-reveal) */
(function () {
	'use strict';
	var els = document.querySelectorAll('.dpx-page .dpx-reveal');
	if (!els.length) return;
	var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion:reduce)').matches;
	if (reduce || !('IntersectionObserver' in window)) {
		els.forEach(function (e) { e.classList.add('dpx-in'); });
		return;
	}
	var io = new IntersectionObserver(function (en) {
		en.forEach(function (x) { if (x.isIntersecting) { x.target.classList.add('dpx-in'); io.unobserve(x.target); } });
	}, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
	els.forEach(function (e) { io.observe(e); });
})();
