(() => {
	'use strict';
	window.AlbinaTheme?.registerMotion('[data-motion="sticky-gallery"]', (element, gsap, scrollTrigger) => {
		if (!scrollTrigger) return;
		const frames = element.querySelectorAll('.sequence-frame');
		if (frames.length < 2) return;
		// Native sticky positioning preserves natural document scrolling and image order.
		frames.forEach((frame, index) => {
			gsap.set(frame, { position: 'sticky', top: '5vh', backgroundColor: 'var(--paper)' });
			if (!index) return;
			gsap.fromTo(frame, { clipPath: 'inset(0 0 6% 0)' }, {
				clipPath: 'inset(0 0 0% 0)', ease: 'none',
				scrollTrigger: { trigger: frame, start: 'top 90%', end: 'top 10%', scrub: true }
			});
		});
	}, '(min-width: 1001px) and (prefers-reduced-motion: no-preference)');
})();
