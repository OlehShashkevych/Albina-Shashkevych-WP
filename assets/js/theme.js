/**
 * Theme main JS
 * Handles preloader, mobile nav, custom cursor, scroll reveals.
 * GSAP/Three.js are loaded in later phases when needed.
 */
(function () {
  'use strict';

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const isTouch = window.matchMedia('(pointer: coarse)').matches;

  // ── PRELOADER ───────────────────────────────────────────────
  const preloader = document.querySelector('.site-preloader');
  if (preloader) {
    document.body.classList.add('is-loading');

    const preloaderText = preloader.querySelector('.preloader-name');
    if (preloaderText && !prefersReducedMotion) {
      // simple split/reveal effect
      const text = preloaderText.textContent.trim();
      preloaderText.innerHTML = text
        .split('')
        .map((char) => `<span>${char === ' ' ? '&nbsp;' : char}</span>`)
        .join('');
    }

    const hidePreloader = () => {
      preloader.classList.add('is-hidden');
      document.body.classList.remove('is-loading');
    };

    const heroCanvas = document.getElementById('hero-canvas');
    const hasHero = heroCanvas && heroCanvas.dataset.heroImages;

    if (hasHero) {
      window.addEventListener('hero:loaded', hidePreloader);
      // Fallback if hero takes too long
      setTimeout(hidePreloader, 5000);
    } else {
      window.addEventListener('load', () => {
        setTimeout(hidePreloader, 500);
      });
    }

    // Safari/iOS back-button cache fix
    window.addEventListener('pageshow', (e) => {
      if (e.persisted) {
        preloader.classList.remove('is-hidden');
        document.body.classList.add('is-loading');
        void preloader.offsetWidth;
        preloader.classList.add('is-hidden');
        document.body.classList.remove('is-loading');
      }
    });
  }

  // ── HEADER SCROLL ───────────────────────────────────────────
  const header = document.querySelector('.site-header');
  if (header) {
    let lastY = 0;
    let ticking = false;

    const onScroll = () => {
      const y = window.scrollY;
      header.classList.toggle('is-scrolled', y > 50);
      header.classList.toggle('is-hidden', y > lastY && y > 200);
      lastY = y;
      ticking = false;
    };

    window.addEventListener('scroll', () => {
      if (!ticking) {
        window.requestAnimationFrame(onScroll);
        ticking = true;
      }
    });
  }

  // ── MOBILE NAV ──────────────────────────────────────────────
  const burger = document.querySelector('.burger-btn');
  const nav = document.querySelector('.main-navigation');

  if (burger && nav) {
    burger.addEventListener('click', () => {
      const open = nav.classList.toggle('is-open');
      burger.classList.toggle('active', open);
      document.body.style.overflow = open ? 'hidden' : '';
    });

    nav.querySelectorAll('a').forEach((link) => {
      link.addEventListener('click', () => {
        nav.classList.remove('is-open');
        burger.classList.remove('active');
        document.body.style.overflow = '';
      });
    });
  }

  // ── CUSTOM CURSOR (desktop, no reduced motion) ───────────────
  if (!isTouch && !prefersReducedMotion) {
    document.body.classList.add('cursor-enabled');
    const cursor = document.createElement('div');
    cursor.className = 'custom-cursor';
    cursor.setAttribute('aria-hidden', 'true');
    cursor.innerHTML = '<span class="custom-cursor__label">View</span>';
    document.body.appendChild(cursor);

    let cursorX = 0;
    let cursorY = 0;
    let targetX = 0;
    let targetY = 0;
    let cursorVisible = false;

    document.addEventListener('mousemove', (e) => {
      targetX = e.clientX;
      targetY = e.clientY;
      if (!cursorVisible) {
        cursor.classList.add('is-active');
        cursorVisible = true;
      }
    });

    document.addEventListener('mouseleave', () => {
      cursor.classList.remove('is-active');
      cursorVisible = false;
    });

    const animateCursor = () => {
      cursorX += (targetX - cursorX) * 0.15;
      cursorY += (targetY - cursorY) * 0.15;
      cursor.style.left = cursorX + 'px';
      cursor.style.top = cursorY + 'px';
      requestAnimationFrame(animateCursor);
    };
    animateCursor();

    // Cursor labels
    const cursorLabels = [
      { selector: '[data-cursor="view"]', label: 'View' },
      { selector: '[data-cursor="play"]', label: 'Play' },
      { selector: '[data-cursor="next"]', label: 'Next' },
      { selector: '[data-cursor="drag"]', label: 'Drag' },
    ];

    cursorLabels.forEach(({ selector, label }) => {
      document.querySelectorAll(selector).forEach((el) => {
        el.addEventListener('mouseenter', () => {
          cursor.classList.add('has-label');
          cursor.querySelector('.custom-cursor__label').textContent = label;
        });
        el.addEventListener('mouseleave', () => {
          cursor.classList.remove('has-label');
        });
      });
    });
  }

  // ── SCROLL REVEALS (CSS fallback if GSAP is not loaded) ─────
  if (!prefersReducedMotion && !window.gsap) {
    const revealElements = document.querySelectorAll('.reveal');
    if (revealElements.length) {
      const observer = new IntersectionObserver(
        (entries, obs) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.add('is-visible');
              obs.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
      );

      revealElements.forEach((el) => observer.observe(el));

      // Reveal elements already in viewport
      window.addEventListener('load', () => {
        revealElements.forEach((el) => {
          const rect = el.getBoundingClientRect();
          if (rect.top < window.innerHeight && rect.bottom > 0) {
            el.classList.add('is-visible');
            observer.unobserve(el);
          }
        });
      });
    }
  } else {
    document.querySelectorAll('.reveal').forEach((el) => {
      el.classList.add('is-visible');
    });
  }
    // ── CONTACT FORM AJAX ───────────────────────────────────────
    const contactForm = document.getElementById('contact-form');
    if (contactForm && typeof themeData !== 'undefined') {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const notice = contactForm.querySelector('.contact-form__notice');
            const formData = new FormData(contactForm);
            formData.append('action', 'theme_contact_form');

            fetch(themeData.ajaxurl, {
                method: 'POST',
                body: formData,
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.success) {
                        contactForm.reset();
                        notice.textContent = data.data.message || 'Message sent!';
                        notice.style.color = 'var(--color-accent)';
                    } else {
                        notice.textContent = data.data.message || 'Something went wrong.';
                        notice.style.color = 'var(--color-accent)';
                    }
                })
                .catch(() => {
                    notice.textContent = 'Something went wrong.';
                    notice.style.color = 'var(--color-accent)';
                });
        });
    }
})();
