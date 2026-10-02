(() => {
	'use strict';
	window.AlbinaTheme?.registerMotion('[data-motion="mask-reveal"]', (element, gsap, scrollTrigger) => {
		if (!scrollTrigger) return;
		gsap.fromTo(element, { clipPath: 'inset(0 0 12% 0)' }, {
			clipPath: 'inset(0 0 0% 0)', duration: 1.05, ease: 'power3.out',
			scrollTrigger: { trigger: element, start: 'top 90%', once: true }
		});
	});
})();
