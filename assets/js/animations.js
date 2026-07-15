/**
 * GSAP + ScrollTrigger animations
 */
(function () {
    'use strict';

    if (typeof gsap === 'undefined') return;
    if (typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
    }

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) return;

    // ── LENIS SMOOTH SCROLL ─────────────────────────────────────
    if (typeof Lenis !== 'undefined') {
        const lenis = new Lenis();

        lenis.on('scroll', ScrollTrigger.update);

        gsap.ticker.add((time) => {
            lenis.raf(time * 1000);
        });

        gsap.ticker.lagSmoothing(0);
    }

    // Hero entrance
    const heroTitle = document.querySelector('.hero__title');
    const heroTagline = document.querySelector('.hero__tagline');
    const heroLabel = document.querySelector('.hero__label');

    if (heroTitle) {
        const heroTl = gsap.timeline({ delay: 0.3 });

        if (heroLabel) {
            heroTl.from(heroLabel, {
                y: 20,
                opacity: 0,
                duration: 0.8,
                ease: 'power2.out',
            });
        }

        heroTl.from(
            heroTitle,
            {
                y: 60,
                opacity: 0,
                duration: 1.2,
                ease: 'power3.out',
            },
            '-=0.4'
        );

        if (heroTagline) {
            heroTl.from(
                heroTagline,
                {
                    y: 20,
                    opacity: 0,
                    duration: 0.8,
                    ease: 'power2.out',
                },
                '-=0.6'
            );
        }
    }

    // Scroll reveals
    const revealElements = document.querySelectorAll('.reveal');
    if (revealElements.length) {
        gsap.set(revealElements, { opacity: 0, y: 30 });

        ScrollTrigger.batch('.reveal', {
            onEnter: (elements) => {
                gsap.to(elements, {
                    opacity: 1,
                    y: 0,
                    duration: 0.8,
                    ease: 'power2.out',
                    stagger: 0.1,
                    overwrite: 'auto',
                });
            },
            start: 'top 85%',
            once: true,
        });
    }

    // Parallax for full-bleed images
    const parallaxImages = document.querySelectorAll('.project-hero__img, .about-hero__img');
    parallaxImages.forEach((img) => {
        gsap.to(img, {
            yPercent: 15,
            ease: 'none',
            scrollTrigger: {
                trigger: img.parentElement,
                start: 'top top',
                end: 'bottom top',
                scrub: true,
            },
        });
    });

    // Header hide/show on scroll
    const header = document.querySelector('.site-header');
    if (header) {
        ScrollTrigger.create({
            start: 'top -100',
            onUpdate: (self) => {
                header.classList.toggle('is-scrolled', self.progress > 0);
            },
        });
    }
})();
