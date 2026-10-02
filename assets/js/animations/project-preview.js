(() => {
	'use strict';
	window.AlbinaTheme?.registerMotion('[data-motion="project-preview"]', (element, gsap) => {
		element.classList.add('preview-enabled');
		const cleanup = [];
		element.querySelectorAll('.index-link').forEach(link => {
			const preview = link.querySelector('.index-image');
			if (!preview || !preview.querySelector('img')) return;
			const moveX = gsap.quickTo(preview, 'x', { duration: 0.35, ease: 'power2.out' });
			const moveY = gsap.quickTo(preview, 'y', { duration: 0.35, ease: 'power2.out' });
			let bounds;
			const enter = () => { bounds = link.getBoundingClientRect(); };
			const move = event => {
				if (!bounds) return;
				moveX((event.clientX - bounds.left - bounds.width / 2) * 0.07);
				moveY((event.clientY - bounds.top - bounds.height / 2) * 0.15);
			};
			const leave = () => { moveX(0); moveY(0); bounds = null; };
			link.addEventListener('pointerenter', enter);
			link.addEventListener('pointermove', move);
			link.addEventListener('pointerleave', leave);
			cleanup.push(() => {
				link.removeEventListener('pointerenter', enter);
				link.removeEventListener('pointermove', move);
				link.removeEventListener('pointerleave', leave);
			});
		});
		return () => {
			element.classList.remove('preview-enabled');
			cleanup.forEach(dispose => dispose());
		};
	}, '(hover: hover) and (pointer: fine) and (min-width: 1001px) and (prefers-reduced-motion: no-preference)');
})();
