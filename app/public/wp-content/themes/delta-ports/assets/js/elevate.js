/**
 * Delta Ports — Cinematic HOME interactions (dpx).
 * Staged hero load + scroll reveal + impact count-up. Reduced-motion aware.
 */
(function () {
	'use strict';
	var root = document.querySelector('.dpx-home');
	if (!root) return;
	var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion:reduce)').matches;

	/* staged hero load */
	var hero = document.getElementById('dpx-hero');
	if (hero) {
		var play = function () { hero.classList.add('dpx-play'); };
		if (document.readyState === 'complete') play(); else window.addEventListener('load', play);
		setTimeout(play, 500); // fallback
	}

	/* scroll reveal */
	var reveals = root.querySelectorAll('.dpx-reveal');
	if (reduce || !('IntersectionObserver' in window)) {
		reveals.forEach(function (el) { el.classList.add('dpx-in'); });
	} else {
		var io = new IntersectionObserver(function (es) {
			es.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('dpx-in'); io.unobserve(e.target); } });
		}, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
		reveals.forEach(function (el) { io.observe(el); });
	}

	/* impact count-up (keeps the <em> suffix) */
	function suffix(el) { var em = el.querySelector('em'); return em ? em.outerHTML : ''; }
	function setFinal(el) {
		var to = parseFloat(el.getAttribute('data-to')) || 0;
		var val = el.getAttribute('data-fmt') ? to.toLocaleString('en-IN') : to;
		el.innerHTML = val + suffix(el);
	}
	function animate(el) {
		var to = parseFloat(el.getAttribute('data-to')) || 0, fmt = el.getAttribute('data-fmt'), em = suffix(el);
		var t0 = null, dur = 1400;
		function step(t) {
			if (t0 === null) t0 = t;
			var p = Math.min(1, (t - t0) / dur), n = Math.round(to * (1 - Math.pow(1 - p, 3)));
			el.innerHTML = (fmt ? n.toLocaleString('en-IN') : n) + em;
			if (p < 1) requestAnimationFrame(step); else setFinal(el);
		}
		requestAnimationFrame(step);
	}
	var nums = root.querySelectorAll('.dpx-metric__n');
	nums.forEach(setFinal); // never blank/zero
	if (!reduce && 'IntersectionObserver' in window) {
		var cio = new IntersectionObserver(function (es) {
			es.forEach(function (e) { if (e.isIntersecting) { animate(e.target); cio.unobserve(e.target); } });
		}, { threshold: 0.5 });
		nums.forEach(function (el) { cio.observe(el); });
	}
})();
