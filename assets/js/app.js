(() => {
	'use strict';
	const init = () => {
		const header = document.querySelector('.site-header');
		const toggle = header?.querySelector('.menu-toggle');
		const navigation = header?.querySelector('#site-navigation');
		if (toggle && navigation && !header.dataset.initialized) {
			header.dataset.initialized = 'true';
			const mobile = window.matchMedia('(max-width: 760px)');
			const setOpen = open => {
				toggle.setAttribute('aria-expanded', String(open));
				navigation.classList.toggle('is-open', open);
			};
			const sync = () => {
				// Do not hide the focused mobile menu when the viewport changes.
				toggle.hidden = !mobile.matches;
				if (mobile.matches && navigation.contains(document.activeElement)) toggle.focus();
				header.classList.toggle('has-menu-toggle', mobile.matches);
				setOpen(false);
			};
			toggle.addEventListener('click', () => setOpen(toggle.getAttribute('aria-expanded') !== 'true'));
			header.addEventListener('keydown', event => {
				if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
					setOpen(false);
					toggle.focus();
				}
			});
			navigation.addEventListener('click', event => {
				if (mobile.matches && event.target.closest('a')) {
					setOpen(false);
					toggle.focus();
				}
			});
			mobile.addEventListener('change', sync);
			sync();
		}
		window.AlbinaTheme?.initMotion();
	};
	if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init, { once: true });
	else init();
})();
