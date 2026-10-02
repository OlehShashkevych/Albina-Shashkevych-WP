(() => {
	'use strict';
	const theme = window.AlbinaTheme = window.AlbinaTheme || {};
	const modules = [];
	let initialized = false;
	theme.registerMotion = (selector, setup, media = '(prefers-reduced-motion: no-preference)') => {
		modules.push({ selector, setup, media });
	};
	theme.initMotion = () => {
		if (initialized || !window.gsap || typeof window.gsap.matchMedia !== 'function') return;
		initialized = true;
		const gsap = window.gsap;
		[window.ScrollTrigger, window.Flip, window.SplitText].filter(Boolean).forEach(plugin => gsap.registerPlugin(plugin));
		const media = gsap.matchMedia();
		modules.forEach(({ selector, setup, media: query }) => {
			const targets = document.querySelectorAll(selector);
			if (!targets.length) return;
			media.add(query, () => {
				const cleanup = [];
				targets.forEach(element => {
					const dispose = setup(element, gsap, window.ScrollTrigger);
					if (typeof dispose === 'function') cleanup.push(dispose);
				});
				return () => cleanup.forEach(dispose => dispose());
			});
		});
		if (window.ScrollTrigger) {
			if (document.readyState === 'complete') window.ScrollTrigger.refresh();
			else window.addEventListener('load', () => window.ScrollTrigger.refresh(), { once: true });
			if (document.fonts) document.fonts.ready.then(() => window.ScrollTrigger.refresh());
		}
	};
})();
