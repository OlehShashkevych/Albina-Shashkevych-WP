/**
 * Portfolio archive filter + lightbox
 */
(function () {
    'use strict';

    const archive = document.querySelector('.portfolio-archive-grid');

    // ── AJAX FILTER ─────────────────────────────────────────────
    if (archive) {
        const filters = document.querySelectorAll('.portfolio-filter__link');
        const grid = archive.querySelector('.portfolio-grid');

        filters.forEach((link) => {
            link.addEventListener('click', (e) => {
                e.preventDefault();

                if (typeof themeData === 'undefined' || !grid) return;

                const category = link.dataset.category || '';
                const formData = new FormData();
                formData.append('action', 'photographer_filter_portfolio');
                formData.append('category', category);
                formData.append('nonce', themeData.nonce);

                // Update active state
                filters.forEach((f) => f.classList.remove('is-active'));
                link.classList.add('is-active');

                // Fade out
                gsap.to(grid, {
                    opacity: 0,
                    y: 20,
                    duration: 0.3,
                    onComplete: () => {
                        fetch(themeData.ajaxurl, {
                            method: 'POST',
                            body: formData,
                        })
                            .then((res) => res.text())
                            .then((html) => {
                                grid.innerHTML = html;
                                // Fade in
                                gsap.fromTo(
                                    grid,
                                    { opacity: 0, y: 20 },
                                    { opacity: 1, y: 0, duration: 0.4 }
                                );
                                gsap.from(
                                    grid.querySelectorAll('.project-card'),
                                    {
                                        opacity: 0,
                                        y: 40,
                                        duration: 0.6,
                                        stagger: 0.08,
                                        ease: 'power2.out',
                                    }
                                );
                            })
                            .catch(() => {
                                grid.innerHTML = '<p class="text-muted">' + 'Unable to load projects.' + '</p>';
                            });
                    },
                });
            });
        });
    }

    // ── LIGHTBOX ────────────────────────────────────────────────
    const lightbox = document.getElementById('lightbox');
    if (lightbox) {
        const img = document.getElementById('lightbox-img');
        const close = document.querySelector('.lightbox-close');
        const prev = document.querySelector('.lightbox-prev');
        const next = document.querySelector('.lightbox-next');
        const overlay = document.querySelector('.lightbox-overlay');

        let images = [];
        let current = 0;
        let isAnimating = false;

        const galleryImages = document.querySelectorAll('.project-gallery__img, .grid-img');
        if (galleryImages.length === 0) return;

        images = Array.from(galleryImages).map((img) => img.getAttribute('src'));

        function open(index) {
            current = index;
            img.src = images[current];
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(() => img.classList.add('visible'), 50);
        }

        function close() {
            img.classList.remove('visible');
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
            setTimeout(() => {
                img.src = '';
            }, 500);
        }

        function change(direction) {
            if (isAnimating) return;
            isAnimating = true;
            img.classList.remove('visible');

            setTimeout(() => {
                if (direction === 'next') {
                    current = (current + 1) % images.length;
                } else {
                    current = (current - 1 + images.length) % images.length;
                }

                img.src = images[current];
                img.onload = () => {
                    img.classList.add('visible');
                    isAnimating = false;
                };
                if (img.complete) {
                    img.classList.add('visible');
                    isAnimating = false;
                }
            }, 400);
        }

        galleryImages.forEach((image, index) => {
            const item = image.closest('figure, .grid-item, a') || image;
            item.style.cursor = 'zoom-in';
            item.addEventListener('click', (e) => {
                e.preventDefault();
                open(index);
            });
        });

        if (close) close.addEventListener('click', close);
        if (overlay) overlay.addEventListener('click', close);
        if (next) next.addEventListener('click', () => change('next'));
        if (prev) prev.addEventListener('click', () => change('prev'));

        document.addEventListener('keydown', (e) => {
            if (!lightbox.classList.contains('active')) return;
            if (e.key === 'Escape') close();
            if (e.key === 'ArrowRight') change('next');
            if (e.key === 'ArrowLeft') change('prev');
        });

        // Swipe support
        let touchStartX = 0;
        let touchEndX = 0;
        lightbox.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });
        lightbox.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            const diff = touchStartX - touchEndX;
            if (Math.abs(diff) > 50) {
                change(diff > 0 ? 'next' : 'prev');
            }
        });
    }
})();
