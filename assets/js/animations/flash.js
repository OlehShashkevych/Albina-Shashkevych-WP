(() => {
	'use strict';
	window.AlbinaTheme?.registerMotion('[data-motion="flash-in"]', (element, gsap) => {
		const flash = element.querySelector('.hero-flash');
		if (!flash) return;
		// One brief shutter entrance, never a repeating flash or loading screen.
		gsap.fromTo(flash, { opacity: 0.55 }, { opacity: 0, duration: 0.4, ease: 'power2.out' });
	});
})();
