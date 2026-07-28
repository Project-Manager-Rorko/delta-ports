/**
 * Delta Ports — slide-in drawer menu (dpx). Replaces the old mega-menu.
 * Open/close, accordion sub-menus, backdrop + Esc close, scroll-lock, focus.
 */
(function () {
	'use strict';
	function ready(fn) {
		if (document.readyState !== 'loading') fn();
		else document.addEventListener('DOMContentLoaded', fn);
	}
	ready(function () {
		var body = document.body;
		var openBtn = document.getElementById('dpx-menu-open');
		var closeBtn = document.getElementById('dpx-menu-close');
		var drawer = document.getElementById('dpx-drawer');
		var backdrop = document.getElementById('dpx-drawer-backdrop');
		if (!openBtn || !drawer) return;

		var lastFocused = null;

		function isOpen() { return body.classList.contains('dpx-nav-open'); }

		function open() {
			lastFocused = document.activeElement;
			body.classList.add('dpx-nav-open');
			body.style.overflow = 'hidden';
			openBtn.setAttribute('aria-expanded', 'true');
			drawer.setAttribute('aria-hidden', 'false');
			if (backdrop) backdrop.hidden = false;
			setTimeout(function () { if (closeBtn) closeBtn.focus(); }, 60);
		}
		function close() {
			body.classList.remove('dpx-nav-open');
			body.style.overflow = '';
			openBtn.setAttribute('aria-expanded', 'false');
			drawer.setAttribute('aria-hidden', 'true');
			if (backdrop) setTimeout(function () { backdrop.hidden = true; }, 500);
			if (lastFocused && lastFocused.focus) lastFocused.focus();
		}

		openBtn.addEventListener('click', open);
		if (closeBtn) closeBtn.addEventListener('click', close);
		if (backdrop) backdrop.addEventListener('click', close);
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && isOpen()) close();
		});

		/* accordions */
		drawer.querySelectorAll('[data-dpx-acc]').forEach(function (btn) {
			btn.addEventListener('click', function () {
				var item = btn.parentElement;
				var willOpen = !item.classList.contains('is-open');
				item.classList.toggle('is-open', willOpen);
				btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
			});
		});

		/* simple focus trap while open */
		drawer.addEventListener('keydown', function (e) {
			if (e.key !== 'Tab' || !isOpen()) return;
			var f = drawer.querySelectorAll('a[href], button:not([disabled])');
			if (!f.length) return;
			var first = f[0], last = f[f.length - 1];
			if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
			else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
		});

		/* close after navigating to an in-page anchor */
		drawer.querySelectorAll('a[href^="/#"], a[href^="#"]').forEach(function (a) {
			a.addEventListener('click', function () { close(); });
		});
	});
})();
