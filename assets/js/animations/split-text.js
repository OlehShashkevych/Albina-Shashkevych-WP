(() => {
	'use strict';
	window.AlbinaTheme?.registerMotion('[data-motion="split-text"]', (element, gsap) => {
		let split;
		if (window.SplitText) split = new window.SplitText(element, { type: 'words', aria: 'auto' });
		gsap.from(split ? split.words : element, {
			xPercent: 2, skewX: -3, duration: 0.9, stagger: split ? 0.035 : 0, ease: 'power3.out'
		});
		return () => { if (split) split.revert(); };
	});
})();
