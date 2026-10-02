(() => {
	'use strict';
	window.AlbinaTheme?.registerMotion('[data-motion="image-expand"]', (element, gsap, scrollTrigger) => {
		if (!scrollTrigger || !element.querySelector('img')) return;
		// The link stays a normal link. data-flip-id allows later page-transition refinement.
		gsap.fromTo(element, { clipPath: 'inset(4% 8% 4% 8%)' }, {
			clipPath: 'inset(0% 0% 0% 0%)', ease: 'none',
			scrollTrigger: { trigger: element, start: 'top 90%', end: 'top 25%', scrub: 0.5 }
		});
	});
})();
