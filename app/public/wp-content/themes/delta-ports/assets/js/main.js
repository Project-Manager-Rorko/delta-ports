/**
 * Delta Ports — scroll, menu, motion, counters
 */
(function () {
	'use strict';

	function onReady(fn) {
		if (document.readyState !== 'loading') fn();
		else document.addEventListener('DOMContentLoaded', fn);
	}

	/* ---------- Scroll safety (fix locked scroll / jank) ---------- */
	function fixScrollRoot() {
		document.documentElement.classList.add('dp-scroll-ready');
		document.documentElement.style.overflowX = 'hidden';
		document.documentElement.style.overflowY = 'auto';
		document.body.style.overflowX = 'hidden';
		document.body.style.overflowY = 'auto';
		document.body.style.height = 'auto';
		document.body.style.minHeight = '100%';
		// Remove accidental scroll locks from third parties
		if (document.body.style.position === 'fixed') {
			document.body.style.position = '';
			document.body.style.top = '';
			document.body.style.width = '';
		}
	}

	/* ---------- Sticky header ---------- */
	function initStickyHeader() {
		var header = document.getElementById('dp-site-header');
		if (!header) header = document.querySelector('.dp-site-header, .dp-header');
		if (!header) return;

		var onScroll = function () {
			var y = window.scrollY || document.documentElement.scrollTop || 0;
			header.classList.toggle('is-scrolled', y > 12);
			header.classList.toggle('is-compact', y > 80);
		};
		onScroll();
		window.addEventListener('scroll', onScroll, { passive: true });
	}

	/* ---------- Desktop dropdowns + mobile drawer ---------- */
	function initMenu() {
		var header = document.getElementById('dp-site-header');
		var nav = document.getElementById('dp-primary-nav');
		var toggle = document.getElementById('dp-nav-toggle');
		var backdrop = document.getElementById('dp-nav-backdrop');
		if (!nav) return;

		function closeAllSubmenus() {
			nav.querySelectorAll('.dp-nav__item--has-children.is-open').forEach(function (item) {
				item.classList.remove('is-open');
				var btn = item.querySelector('.dp-nav__trigger');
				if (btn) btn.setAttribute('aria-expanded', 'false');
			});
		}

		function openItem(item) {
			var btn = item.querySelector('.dp-nav__trigger');
			item.classList.add('is-open');
			if (btn) btn.setAttribute('aria-expanded', 'true');
		}

		function closeItem(item) {
			var btn = item.querySelector('.dp-nav__trigger');
			item.classList.remove('is-open');
			if (btn) btn.setAttribute('aria-expanded', 'false');
		}

		function setMobileOpen(open) {
			document.documentElement.classList.toggle('dp-nav-open', open);
			if (header) header.classList.toggle('is-nav-open', open);
			if (toggle) {
				toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
				toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
			}
			if (backdrop) {
				if (open) backdrop.removeAttribute('hidden');
				else backdrop.setAttribute('hidden', '');
			}
			// Only lock body scroll when mobile drawer is open
			if (open && window.matchMedia('(max-width: 960px)').matches) {
				document.body.style.overflow = 'hidden';
			} else {
				document.body.style.overflow = '';
				document.body.style.overflowY = 'auto';
			}
			if (!open) closeAllSubmenus();
		}

		if (toggle) {
			toggle.addEventListener('click', function () {
				var open = !document.documentElement.classList.contains('dp-nav-open');
				setMobileOpen(open);
			});
		}
		if (backdrop) {
			backdrop.addEventListener('click', function () { setMobileOpen(false); });
		}

		// Dropdown / mega-panel triggers
		nav.querySelectorAll('.dp-nav__item--has-children').forEach(function (item) {
			var btn = item.querySelector('.dp-nav__trigger');
			if (!btn) return;
			var closeTimer = null;

			btn.addEventListener('click', function (e) {
				e.preventDefault();
				var isOpen = item.classList.contains('is-open');
				item.parentElement.querySelectorAll('.dp-nav__item--has-children.is-open').forEach(function (sib) {
					if (sib !== item) closeItem(sib);
				});
				if (isOpen) closeItem(item);
				else openItem(item);
			});

			// Desktop hover intent
			item.addEventListener('mouseenter', function () {
				if (!window.matchMedia('(min-width: 961px)').matches) return;
				clearTimeout(closeTimer);
				closeAllSubmenus();
				openItem(item);
			});
			item.addEventListener('mouseleave', function () {
				if (!window.matchMedia('(min-width: 961px)').matches) return;
				closeTimer = setTimeout(function () { closeItem(item); }, 140);
			});

			// Keyboard support
			btn.addEventListener('keydown', function (e) {
				if (e.key === 'ArrowDown' || e.key === 'Enter' || e.key === ' ') {
					e.preventDefault();
					closeAllSubmenus();
					openItem(item);
					var first = item.querySelector('.dp-nav__panel a, .dp-nav__submenu a');
					if (first) first.focus();
				}
			});
		});

		// Close mobile nav on link click
		nav.querySelectorAll('a').forEach(function (a) {
			a.addEventListener('click', function () {
				if (window.matchMedia('(max-width: 960px)').matches) setMobileOpen(false);
				closeAllSubmenus();
			});
		});

		// Escape closes menus + drawer
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') {
				setMobileOpen(false);
				closeAllSubmenus();
			}
		});

		// Click outside closes desktop panels
		document.addEventListener('click', function (e) {
			if (!nav.contains(e.target)) closeAllSubmenus();
		});

		// Reset on resize to desktop
		window.addEventListener('resize', function () {
			if (window.matchMedia('(min-width: 961px)').matches) setMobileOpen(false);
		});

		// Active link highlight
		var path = window.location.pathname.replace(/\/$/, '') || '/';
		nav.querySelectorAll('a[href]').forEach(function (a) {
			try {
				var href = a.getAttribute('href');
				if (!href || href === '#') return;
				var u = href.charAt(0) === '/' ? href.replace(/\/$/, '') || '/' : new URL(href, window.location.origin).pathname.replace(/\/$/, '') || '/';
				if (u === path || (u !== '/' && path.indexOf(u) === 0)) {
					a.classList.add('is-active');
					var parent = a.closest('.dp-nav__item--has-children');
					if (parent) parent.classList.add('has-active');
				}
			} catch (err) { /* ignore */ }
		});
	}

	/* ---------- Smooth anchor scroll (no body lock) ---------- */
	function initAnchorScroll() {
		document.addEventListener('click', function (e) {
			var a = e.target.closest('a[href^="#"]');
			if (!a) return;
			var id = a.getAttribute('href');
			if (!id || id === '#') return;
			var el = document.querySelector(id);
			if (!el) return;
			e.preventDefault();
			var header = document.getElementById('dp-site-header');
			var offset = header ? header.offsetHeight + 12 : 80;
			var top = el.getBoundingClientRect().top + window.pageYOffset - offset;
			window.scrollTo({ top: top, behavior: 'smooth' });
		});
	}

	/* ---------- Reveal on scroll ---------- */
	function initReveal() {
		var nodes = document.querySelectorAll('.dp-reveal, .dp-section, .dp-card, .dp-stat, .dp-leader, .dp-media-card');
		// Always ensure visible eventually
		function showAll() {
			nodes.forEach(function (n) { n.classList.add('is-visible'); });
		}
		if (!nodes.length) return;
		if (!('IntersectionObserver' in window)) {
			showAll();
			return;
		}
		var io = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (e) {
					if (e.isIntersecting) {
						e.target.classList.add('is-visible');
						io.unobserve(e.target);
					}
				});
			},
			{ threshold: 0.08, rootMargin: '0px 0px -30px 0px' }
		);
		nodes.forEach(function (n) {
			n.classList.add('dp-reveal');
			io.observe(n);
		});
		// Failsafe: never leave content invisible
		setTimeout(showAll, 2500);
	}

	/* ---------- Counters ---------- */
	function animateValue(el, end, duration) {
		var startTs = null;
		var suffix = el.getAttribute('data-suffix') || '';
		var prefix = el.getAttribute('data-prefix') || '';
		function step(ts) {
			if (!startTs) startTs = ts;
			var p = Math.min((ts - startTs) / duration, 1);
			var eased = 1 - Math.pow(1 - p, 3);
			el.textContent = prefix + Math.floor(eased * end) + suffix;
			if (p < 1) requestAnimationFrame(step);
			else el.textContent = prefix + end + suffix;
		}
		requestAnimationFrame(step);
	}

	function initCounters() {
		var nodes = document.querySelectorAll('[data-count-to]');
		if (!nodes.length) return;
		var run = function (el) {
			if (el.dataset.counted) return;
			el.dataset.counted = '1';
			animateValue(el, parseInt(el.getAttribute('data-count-to'), 10) || 0, 1400);
		};
		if (!('IntersectionObserver' in window)) {
			nodes.forEach(run);
			return;
		}
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (e) {
				if (e.isIntersecting) {
					run(e.target);
					io.unobserve(e.target);
				}
			});
		}, { threshold: 0.35 });
		nodes.forEach(function (n) { io.observe(n); });
	}

	/* ---------- Logo marquee ---------- */
	function initMarquee() {
		document.querySelectorAll('.dp-marquee__track').forEach(function (track) {
			if (track.dataset.cloned) return;
			track.innerHTML = track.innerHTML + track.innerHTML;
			track.dataset.cloned = '1';
		});
	}

	/* ---------- Cinematic hero depth (lightweight, CSS 3D) ---------- */
	function initHeroCinema() {
		var hero = document.querySelector('.dp-hero');
		if (!hero) return;
		hero.classList.add('dp-hero--cinema');

		var onMove = function (e) {
			if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
			if (window.matchMedia('(max-width: 768px)').matches) return;
			var rect = hero.getBoundingClientRect();
			var x = (e.clientX - rect.left) / rect.width - 0.5;
			var y = (e.clientY - rect.top) / rect.height - 0.5;
			hero.style.setProperty('--dp-mx', (x * 12).toFixed(2) + 'px');
			hero.style.setProperty('--dp-my', (y * 8).toFixed(2) + 'px');
			hero.style.setProperty('--dp-rx', (y * -2).toFixed(2) + 'deg');
			hero.style.setProperty('--dp-ry', (x * 3).toFixed(2) + 'deg');
		};
		hero.addEventListener('mousemove', onMove, { passive: true });
		hero.addEventListener('mouseleave', function () {
			hero.style.setProperty('--dp-mx', '0px');
			hero.style.setProperty('--dp-my', '0px');
			hero.style.setProperty('--dp-rx', '0deg');
			hero.style.setProperty('--dp-ry', '0deg');
		});

		// Parallax on scroll
		var onScroll = function () {
			if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
			var rect = hero.getBoundingClientRect();
			if (rect.bottom < 0 || rect.top > window.innerHeight) return;
			var p = Math.min(1, Math.max(0, -rect.top / (rect.height || 1)));
			hero.style.setProperty('--dp-parallax', (p * 40).toFixed(1) + 'px');
		};
		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll();
	}

	/* ---------- Card tilt (subtle 3D) ---------- */
	function initCardTilt() {
		if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
		if (window.matchMedia('(max-width: 768px)').matches) return;
		document.querySelectorAll('.dp-card, .dp-leader, .dp-media-card').forEach(function (card) {
			card.classList.add('dp-tilt');
			card.addEventListener('mousemove', function (e) {
				var r = card.getBoundingClientRect();
				var x = (e.clientX - r.left) / r.width - 0.5;
				var y = (e.clientY - r.top) / r.height - 0.5;
				card.style.transform = 'perspective(900px) rotateX(' + (y * -4) + 'deg) rotateY(' + (x * 5) + 'deg) translateY(-4px)';
			});
			card.addEventListener('mouseleave', function () {
				card.style.transform = '';
			});
		});
	}

	/* ---------- Section title reveal stagger ---------- */
	function initPremiumTouches() {
		document.documentElement.classList.add('dp-premium');
		// Soft image load fade
		document.querySelectorAll('img').forEach(function (img) {
			if (img.complete) {
				img.classList.add('is-loaded');
				return;
			}
			img.addEventListener('load', function () { img.classList.add('is-loaded'); });
		});
	}

	/* ---------- Leadership bio drawer (slide right→left open, left→right close) ---------- */
	function initBioDrawer() {
		var drawer = document.getElementById('dp-bio-drawer');
		if (!drawer) return;

		var shell = drawer.querySelector('.dp-bio-drawer__shell');
		var panels = drawer.querySelectorAll('[data-bio-panel]');
		var openBtns = document.querySelectorAll('[data-bio-open]');
		var closeTimer = null;
		var lastFocus = null;

		function getPanel(id) {
			return drawer.querySelector('[data-bio-panel="' + id + '"]');
		}

		function openBio(id) {
			var panel = getPanel(id);
			if (!panel) return;
			if (closeTimer) {
				clearTimeout(closeTimer);
				closeTimer = null;
			}
			lastFocus = document.activeElement;
			panels.forEach(function (p) {
				p.classList.remove('is-active');
				p.setAttribute('hidden', '');
			});
			panel.classList.add('is-active');
			panel.removeAttribute('hidden');
			drawer.classList.remove('is-closing');
			// Start off-screen, then animate in (right → left)
			drawer.classList.add('is-open');
			drawer.setAttribute('aria-hidden', 'false');
			document.body.classList.add('dp-bio-open');
			// Ensure transform transition runs from 100% → 0
			requestAnimationFrame(function () {
				drawer.classList.add('is-open');
			});
			var closeBtn = panel.querySelector('[data-bio-close]');
			if (closeBtn) {
				setTimeout(function () { closeBtn.focus(); }, 50);
			}
		}

		function closeBio() {
			if (!drawer.classList.contains('is-open') || drawer.classList.contains('is-closing')) return;
			// Keep is-open so drawer stays visible; is-closing slides shell left → right
			drawer.classList.add('is-closing');
			void shell.offsetWidth; // reflow → guarantee CSS transition
			document.body.classList.remove('dp-bio-open');
			closeTimer = setTimeout(function () {
				drawer.classList.remove('is-open', 'is-closing');
				drawer.setAttribute('aria-hidden', 'true');
				panels.forEach(function (p) {
					p.classList.remove('is-active');
					p.setAttribute('hidden', '');
				});
				if (lastFocus && typeof lastFocus.focus === 'function') {
					lastFocus.focus();
				}
				closeTimer = null;
			}, 480);
		}

		openBtns.forEach(function (btn) {
			btn.addEventListener('click', function (e) {
				e.preventDefault();
				openBio(btn.getAttribute('data-bio-open'));
			});
		});

		drawer.addEventListener('click', function (e) {
			if (e.target.closest('[data-bio-close]')) {
				e.preventDefault();
				closeBio();
			}
		});

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && drawer.classList.contains('is-open')) {
				closeBio();
			}
		});
	}

	/* ---------- Contact office maps (inject iframe if KSES stripped it) ---------- */
	function initContactMaps() {
		document.querySelectorAll('.dp-contact-office__map[data-map-src]').forEach(function (box) {
			if (box.querySelector('iframe')) return;
			var src = box.getAttribute('data-map-src');
			if (!src) return;
			var iframe = document.createElement('iframe');
			iframe.title = 'Office map';
			iframe.src = src;
			iframe.loading = 'lazy';
			iframe.setAttribute('referrerpolicy', 'no-referrer-when-downgrade');
			iframe.setAttribute('frameborder', '0');
			iframe.setAttribute('scrolling', 'no');
			iframe.width = '600';
			iframe.height = '150';
			box.appendChild(iframe);
		});
	}

	/* ---------- Smooth FAQ accordion ---------- */
	function initFaqAccordion() {
		var list = document.querySelectorAll('.dp-ops-faq__list');
		if (!list.length) return;

		list.forEach(function (root) {
			// New button-based FAQ.
			root.querySelectorAll('.dp-ops-faq__item .dp-ops-faq__q').forEach(function (btn) {
				btn.addEventListener('click', function () {
					var item = btn.closest('.dp-ops-faq__item');
					if (!item) return;
					var open = item.classList.contains('is-open');
					// Accordion: close siblings.
					root.querySelectorAll('.dp-ops-faq__item.is-open').forEach(function (other) {
						if (other === item) return;
						other.classList.remove('is-open');
						var ob = other.querySelector('.dp-ops-faq__q');
						if (ob) ob.setAttribute('aria-expanded', 'false');
					});
					item.classList.toggle('is-open', !open);
					btn.setAttribute('aria-expanded', open ? 'false' : 'true');
				});
			});

			// Legacy <details> FAQ — smooth open class.
			root.querySelectorAll('details.dp-ops-faq__item').forEach(function (det) {
				det.addEventListener('toggle', function () {
					det.classList.toggle('is-open', det.open);
					if (det.open) {
						root.querySelectorAll('details.dp-ops-faq__item[open]').forEach(function (other) {
							if (other !== det) other.open = false;
						});
					}
				});
			});
		});
	}

	onReady(function () {
		fixScrollRoot();
		initStickyHeader();
		initMenu();
		initAnchorScroll();
		initReveal();
		initCounters();
		initMarquee();
		initHeroCinema();
		initCardTilt();
		initPremiumTouches();
		initBioDrawer();
		initFaqAccordion();
		initContactMaps();
	});
})();

