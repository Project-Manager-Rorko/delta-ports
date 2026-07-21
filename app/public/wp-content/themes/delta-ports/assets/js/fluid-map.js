/**
 * Our Business map — WebGL fluid distortion (live vipaccounts parity).
 * Canvas #fluidCanvas with data-src map image.
 */
(function () {
	'use strict';

	function prefersReduced() {
		return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	}

	function ready(fn) {
		if (document.readyState !== 'loading') fn();
		else document.addEventListener('DOMContentLoaded', fn);
	}

	ready(function () {
		var host = document.querySelector('.dp-home-business__fluid, .container-dot-animation');
		var canvas = document.getElementById('fluidCanvas');

		// WP KSES may strip <canvas> from post content — recreate it.
		if (!canvas && host) {
			var mapSrc =
				host.getAttribute('data-src') ||
				(host.style && host.style.backgroundImage
					? (host.style.backgroundImage.match(/url\(["']?([^"')]+)/) || [])[1]
					: '') ||
				'';
			// Prefer map URL from page if data-src missing.
			if (!mapSrc) {
				var pageMap = document.querySelector('.dp-home-business [data-map-src]');
				if (pageMap) mapSrc = pageMap.getAttribute('data-map-src') || '';
			}
			if (!mapSrc) {
				// Fallback to known theme asset path.
				var link = document.querySelector('link[href*="/themes/delta-ports/"]');
				var base = link ? link.href.replace(/assets\/css\/.*$/, '') : '/wp-content/themes/delta-ports/';
				mapSrc = base + 'assets/images/delta-map-sec-bg-new-scaled-1.webp';
			}
			canvas = document.createElement('canvas');
			canvas.id = 'fluidCanvas';
			canvas.setAttribute('data-src', mapSrc);
			canvas.setAttribute('width', '1280');
			canvas.setAttribute('height', '520');
			host.appendChild(canvas);
			host.setAttribute('data-src', mapSrc);
		}

		if (!canvas) return;

		var src = canvas.getAttribute('data-src') || (host && host.getAttribute('data-src')) || '';
		var fallback = canvas.parentElement || host;

		// Static fallback if reduced motion or no WebGL.
		function showStatic() {
			if (!fallback) return;
			fallback.classList.add('is-static');
			if (src) {
				fallback.style.backgroundImage = 'url("' + src + '")';
			}
			canvas.style.display = 'none';
		}

		if (prefersReduced()) {
			showStatic();
			return;
		}

		var gl =
			canvas.getContext('webgl', { antialias: false, alpha: false }) ||
			canvas.getContext('experimental-webgl', { antialias: false, alpha: false });

		if (!gl) {
			showStatic();
			return;
		}

		var vertexShaderSrc =
			'attribute vec2 a_position;' +
			'varying vec2 v_uv;' +
			'void main() {' +
			'  v_uv = a_position * 0.5 + 0.5;' +
			'  v_uv.y = 1.0 - v_uv.y;' +
			'  gl_Position = vec4(a_position, 0.0, 1.0);' +
			'}';

		var fragmentShaderSrc =
			'precision highp float;' +
			'uniform sampler2D u_image;' +
			'uniform vec2 u_scale;' +
			'uniform float u_aspect;' +
			'uniform vec2 u_mouse[20];' +
			'uniform float u_time;' +
			'uniform float u_strength;' +
			'varying vec2 v_uv;' +
			'void main() {' +
			'  vec2 uv = v_uv;' +
			'  vec2 distortion = vec2(0.0);' +
			'  distortion.x += sin(uv.y * 3.0 + u_time * 0.3) * 0.003;' +
			'  distortion.y += cos(uv.x * 3.0 + u_time * 0.3) * 0.003;' +
			'  for (int i = 0; i < 20; i++) {' +
			'    if (u_mouse[i].x < 0.0) continue;' +
			'    vec2 aspectUV = uv * vec2(u_aspect, 1.0);' +
			'    vec2 aspectMouse = u_mouse[i] * vec2(u_aspect, 1.0);' +
			'    vec2 dir = aspectUV - aspectMouse;' +
			'    float dist = length(dir);' +
			'    if (dist > 0.0 && dist < 0.4) {' +
			'      float trailStrength = float(20 - i) / 20.0;' +
			'      float wave = sin(dist * 20.0 - u_time * 2.8);' +
			'      float falloff = exp(-dist * 14.0);' +
			'      vec2 displacementDir = normalize(dir) / vec2(u_aspect, 1.0);' +
			'      distortion += displacementDir * wave * falloff * 0.010 * trailStrength * u_strength;' +
			'    }' +
			'  }' +
			'  vec2 distorted_uv = uv + distortion;' +
			'  vec2 image_uv = (distorted_uv - 0.5) / u_scale + 0.5;' +
			'  if (image_uv.x < 0.0 || image_uv.x > 1.0 || image_uv.y < 0.0 || image_uv.y > 1.0) {' +
			'    gl_FragColor = vec4(1.0, 1.0, 1.0, 1.0);' +
			'  } else {' +
			'    vec4 texColor = texture2D(u_image, image_uv);' +
			'    gl_FragColor = vec4(mix(vec3(1.0), texColor.rgb, texColor.a), 1.0);' +
			'  }' +
			'}';

		function compileShader(type, source) {
			var shader = gl.createShader(type);
			gl.shaderSource(shader, source);
			gl.compileShader(shader);
			if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
				console.error(gl.getShaderInfoLog(shader));
				gl.deleteShader(shader);
				return null;
			}
			return shader;
		}

		var vs = compileShader(gl.VERTEX_SHADER, vertexShaderSrc);
		var fs = compileShader(gl.FRAGMENT_SHADER, fragmentShaderSrc);
		if (!vs || !fs) {
			showStatic();
			return;
		}

		var program = gl.createProgram();
		gl.attachShader(program, vs);
		gl.attachShader(program, fs);
		gl.linkProgram(program);
		if (!gl.getProgramParameter(program, gl.LINK_STATUS)) {
			showStatic();
			return;
		}

		var positionBuffer = gl.createBuffer();
		gl.bindBuffer(gl.ARRAY_BUFFER, positionBuffer);
		gl.bufferData(
			gl.ARRAY_BUFFER,
			new Float32Array([-1, -1, 1, -1, -1, 1, -1, 1, 1, -1, 1, 1]),
			gl.STATIC_DRAW
		);

		var posLocation = gl.getAttribLocation(program, 'a_position');
		gl.enableVertexAttribArray(posLocation);
		gl.vertexAttribPointer(posLocation, 2, gl.FLOAT, false, 0, 0);

		var uScaleLoc = gl.getUniformLocation(program, 'u_scale');
		var uAspectLoc = gl.getUniformLocation(program, 'u_aspect');
		var uMouseLoc = gl.getUniformLocation(program, 'u_mouse');
		var uTimeLoc = gl.getUniformLocation(program, 'u_time');
		var uStrengthLoc = gl.getUniformLocation(program, 'u_strength');

		var texture = gl.createTexture();
		gl.bindTexture(gl.TEXTURE_2D, texture);
		gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, 1, 1, 0, gl.RGBA, gl.UNSIGNED_BYTE, new Uint8Array([255, 255, 255, 255]));
		gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
		gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
		gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);

		var mouseTrail = new Float32Array(20 * 2).fill(-1.0);
		var imageAspect = 2.5;
		var startTime = Date.now();
		var targetMouse = { x: -1, y: -1 };
		var currentMouse = { x: -1, y: -1 };
		var prevMouse = { x: -1, y: -1 };
		var effectStrength = 0.0;
		var lastMoveTime = Date.now();
		var running = true;

		var image = new Image();
		image.decoding = 'async';
		image.src = src;
		image.onload = function () {
			gl.bindTexture(gl.TEXTURE_2D, texture);
			gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, image);
			imageAspect = image.width / image.height || 2.5;
			resize();
		};
		image.onerror = function () {
			showStatic();
			running = false;
		};

		function getCanvasSize() {
			var parent = canvas.parentElement || canvas;
			var rect = parent.getBoundingClientRect();
			var w = Math.max(1, Math.floor(rect.width || parent.clientWidth || window.innerWidth));
			var h = Math.max(1, Math.floor(rect.height || parent.clientHeight || 420));
			return { w: w, h: h, rect: rect };
		}

		function updateMouseTrail() {
			if (targetMouse.x >= 0 && currentMouse.x < 0) {
				currentMouse.x = targetMouse.x;
				currentMouse.y = targetMouse.y;
			} else if (targetMouse.x >= 0) {
				currentMouse.x += (targetMouse.x - currentMouse.x) * 0.12;
				currentMouse.y += (targetMouse.y - currentMouse.y) * 0.12;
			}

			if (prevMouse.x >= 0 && currentMouse.x >= 0) {
				var dx = currentMouse.x - prevMouse.x;
				var dy = currentMouse.y - prevMouse.y;
				var movement = Math.sqrt(dx * dx + dy * dy);
				if (movement > 0.004) {
					effectStrength = Math.min(1.0, effectStrength + 0.15);
					lastMoveTime = Date.now();
				} else if (Date.now() - lastMoveTime > 100) {
					effectStrength *= 0.92;
				}
			}

			prevMouse.x = currentMouse.x;
			prevMouse.y = currentMouse.y;

			for (var i = 19; i > 0; i--) {
				mouseTrail[i * 2] = mouseTrail[(i - 1) * 2];
				mouseTrail[i * 2 + 1] = mouseTrail[(i - 1) * 2 + 1];
			}

			if (targetMouse.x < 0) {
				mouseTrail[0] = -1.0;
				mouseTrail[1] = -1.0;
				effectStrength *= 0.85;
			} else {
				mouseTrail[0] = currentMouse.x;
				mouseTrail[1] = currentMouse.y;
			}
		}

		function resize() {
			var size = getCanvasSize();
			var dpr = Math.min(window.devicePixelRatio || 1, 2);
			canvas.width = Math.floor(size.w * dpr);
			canvas.height = Math.floor(size.h * dpr);
			canvas.style.width = size.w + 'px';
			canvas.style.height = size.h + 'px';

			var canvasAspect = size.w / size.h;
			var maxW = Math.min(size.w, 1280);
			var targetW = size.w;
			var targetH = size.w / imageAspect;

			if (targetH > size.h) {
				targetH = size.h;
				targetW = size.h * imageAspect;
			}
			if (targetW > maxW) {
				targetW = maxW;
				targetH = maxW / imageAspect;
			}

			gl.useProgram(program);
			gl.uniform2f(uScaleLoc, targetW / size.w, targetH / size.h);
			gl.uniform1f(uAspectLoc, canvasAspect);
			gl.viewport(0, 0, canvas.width, canvas.height);
		}

		function render() {
			if (!running) return;
			var time = (Date.now() - startTime) / 1000.0;
			updateMouseTrail();

			gl.clearColor(1.0, 1.0, 1.0, 1.0);
			gl.clear(gl.COLOR_BUFFER_BIT);
			gl.useProgram(program);
			gl.uniform1f(uTimeLoc, time);
			gl.uniform2fv(uMouseLoc, mouseTrail);
			gl.uniform1f(uStrengthLoc, effectStrength);
			gl.drawArrays(gl.TRIANGLES, 0, 6);
			requestAnimationFrame(render);
		}

		function onMove(e) {
			var size = getCanvasSize();
			var x = e.clientX - size.rect.left;
			var y = e.clientY - size.rect.top;
			if (x < 0 || y < 0 || x > size.w || y > size.h) {
				targetMouse.x = -1;
				targetMouse.y = -1;
				return;
			}
			targetMouse.x = x / size.w;
			targetMouse.y = y / size.h;
		}

		function onLeave() {
			targetMouse.x = -1;
			targetMouse.y = -1;
		}

		window.addEventListener('resize', resize);
		window.addEventListener('mousemove', onMove, { passive: true });
		document.addEventListener('mouseleave', onLeave);
		canvas.addEventListener('mouseleave', onLeave);

		// Idle ambient motion even without mouse.
		effectStrength = 0.35;
		resize();
		render();
	});
})();
