(() => {
	'use strict';
	let active = false;
	window.AlbinaTheme?.registerMotion('[data-motion="image-expand"]', (element, gsap) => {
		if (!window.Flip || !element.querySelector('img')) return;
		let overlay, animation, timer, destination;
		const reset = () => {
			clearTimeout(timer);
			animation?.kill();
			overlay?.remove();
			overlay = animation = destination = null;
			active = false;
		};
		const navigate = () => {
			if (!destination) return;
			const url = destination;
			destination = null;
			clearTimeout(timer);
			window.location.assign(url);
			// Keep the expanded frame during native loading, but never strand it on this page.
			timer = window.setTimeout(reset, 1200);
		};
		const click = event => {
			if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || element.hasAttribute('download') || (element.target && element.target !== '_self')) return;
			const url = new URL(element.href, window.location.href);
			if (url.origin !== window.location.origin || url.href === window.location.href || url.hash) return;
			const image = element.querySelector('img');
			if (!image.complete || !image.naturalWidth || active) return;
			const rect = element.getBoundingClientRect();
			if (!rect.width || !rect.height) return;
			try {
				overlay = document.createElement('div');
				overlay.className = 'project-transition';
				overlay.setAttribute('aria-hidden', 'true');
				const clone = document.createElement('img');
				clone.src = image.currentSrc || image.src;
				clone.alt = '';
				clone.style.objectPosition = getComputedStyle(image).objectPosition;
				overlay.append(clone);
				document.body.append(overlay);
				gsap.set(overlay, { left: rect.left, top: rect.top, width: rect.width, height: rect.height });
				const state = window.Flip.getState(overlay);
				gsap.set(overlay, { left: 0, top: 0, width: window.innerWidth, height: window.innerHeight });
				destination = url.href;
				active = true;
				animation = window.Flip.from(state, { duration: 0.45, ease: 'power2.inOut', onComplete: navigate });
				event.preventDefault();
				// Native navigation still runs if a tween is interrupted or the tab is backgrounded.
				timer = window.setTimeout(navigate, 800);
			} catch {
				reset();
			}
		};
		element.addEventListener('click', click);
		window.addEventListener('pageshow', reset);
		return () => {
			element.removeEventListener('click', click);
			window.removeEventListener('pageshow', reset);
			if (destination) navigate();
			else reset();
		};
	});
})();
