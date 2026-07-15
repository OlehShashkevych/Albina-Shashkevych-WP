/**
 * Hero WebGL scene
 * Three.js based 3D photo gallery with mouse parallax.
 * Falls back to static CSS on mobile/reduced motion.
 */
(function () {
    'use strict';

    const canvas = document.getElementById('hero-canvas');
    if (!canvas) return;

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const isTouch = window.matchMedia('(pointer: coarse)').matches;
    const images = JSON.parse(canvas.dataset.heroImages || '[]');

    // If no images or reduced motion/touch, skip WebGL and rely on CSS fallback
    if (!images.length || prefersReducedMotion || isTouch) {
        canvas.style.display = 'none';
        document.body.classList.add('hero-fallback-active');
        return;
    }

    if (typeof THREE === 'undefined') {
        canvas.style.display = 'none';
        document.body.classList.add('hero-fallback-active');
        return;
    }

    let renderer;
    try {
        renderer = new THREE.WebGLRenderer({
            canvas: canvas,
            alpha: true,
            antialias: true,
            powerPreference: 'high-performance',
        });
    } catch (e) {
        canvas.style.display = 'none';
        document.body.classList.add('hero-fallback-active');
        return;
    }

    const width = canvas.clientWidth || window.innerWidth;
    const height = canvas.clientHeight || window.innerHeight;

    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setSize(width, height);
    if (THREE.SRGBColorSpace) {
        renderer.outputColorSpace = THREE.SRGBColorSpace;
    } else if (THREE.sRGBEncoding) {
        renderer.outputEncoding = THREE.sRGBEncoding;
    }

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, width / height, 0.1, 1000);
    camera.position.z = 4.5;

    const group = new THREE.Group();
    scene.add(group);

    const loader = new THREE.TextureLoader();
    loader.setCrossOrigin('anonymous');

    const cols = 3;
    const rows = 2;
    const spacingX = 1.3;
    const spacingY = 1.8;
    const total = images.length;
    const count = Math.min(total, cols * rows);

    let loaded = 0;
    let processed = 0;

    function updatePreloader() {
        const progress = document.querySelector('.preloader-progress');
        if (progress) {
            const pct = Math.round((processed / count) * 100);
            progress.textContent = pct + '%';
        }
    }

    function checkComplete() {
        if (processed === count) {
            window.dispatchEvent(new CustomEvent('hero:loaded'));
        }
    }

    function onImageLoaded(texture, index) {
        loaded += 1;
        processed += 1;
        updatePreloader();

        const image = texture.image;
        const aspect = image.width / image.height;
        const height = 1.6;
        const width = height * aspect;

        const geometry = new THREE.PlaneGeometry(width, height, 1, 1);
        const material = new THREE.MeshBasicMaterial({
            map: texture,
            transparent: true,
            opacity: 0,
            side: THREE.DoubleSide,
        });

        if (THREE.SRGBColorSpace) {
            texture.colorSpace = THREE.SRGBColorSpace;
        }

        const mesh = new THREE.Mesh(geometry, material);

        const col = index % cols;
        const row = Math.floor(index / cols);
        const x = (col - (cols - 1) / 2) * spacingX;
        const y = ((rows - 1) / 2 - row) * spacingY;
        const z = (Math.random() - 0.5) * 0.8;

        mesh.position.set(x, y, z);
        mesh.rotation.z = (Math.random() - 0.5) * 0.06;

        group.add(mesh);

        // Fade in
        const start = performance.now();
        const duration = 1200;
        const delay = index * 120;

        function fade(now) {
            const elapsed = now - start - delay;
            if (elapsed < 0) {
                requestAnimationFrame(fade);
                return;
            }
            const t = Math.min(elapsed / duration, 1);
            material.opacity = t;
            if (t < 1) {
                requestAnimationFrame(fade);
            }
        }
        requestAnimationFrame(fade);

        checkComplete();
    }

    images.slice(0, count).forEach((url, index) => {
        loader.load(
            url,
            (texture) => onImageLoaded(texture, index),
            undefined,
            () => {
                processed += 1;
                updatePreloader();
                checkComplete();
            }
        );
    });

    // Mouse / gyro interaction
    let mouseX = 0;
    let mouseY = 0;
    let targetRotationX = 0;
    let targetRotationY = 0;

    if (!isTouch) {
        document.addEventListener('mousemove', (e) => {
            mouseX = (e.clientX / window.innerWidth) * 2 - 1;
            mouseY = (e.clientY / window.innerHeight) * 2 - 1;
        });
    }

    // Device orientation for mobile (basic, no permission handling)
    if (window.DeviceOrientationEvent && isTouch) {
        window.addEventListener('deviceorientation', (e) => {
            if (e.gamma === null || e.beta === null) return;
            mouseX = Math.max(-1, Math.min(1, e.gamma / 30));
            mouseY = Math.max(-1, Math.min(1, e.beta / 30));
        });
    }

    // Resize handling
    const resizeObserver = new ResizeObserver(() => {
        const width = canvas.clientWidth;
        const height = canvas.clientHeight;
        camera.aspect = width / height;
        camera.updateProjectionMatrix();
        renderer.setSize(width, height);
    });
    resizeObserver.observe(canvas);

    // Visibility / pause
    let isVisible = true;
    document.addEventListener('visibilitychange', () => {
        isVisible = document.visibilityState === 'visible';
    });

    const heroSection = document.getElementById('hero');
    const heroObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                isVisible = entry.isIntersecting;
            });
        },
        { threshold: 0.05 }
    );
    if (heroSection) heroObserver.observe(heroSection);

    // Animation loop
    let rafId;
    function animate() {
        rafId = requestAnimationFrame(animate);

        if (!isVisible) return;

        targetRotationY = mouseX * 0.15;
        targetRotationX = -mouseY * 0.1;

        group.rotation.y += (targetRotationY - group.rotation.y) * 0.05;
        group.rotation.x += (targetRotationX - group.rotation.x) * 0.05;

        // Idle drift
        group.position.y = Math.sin(performance.now() * 0.0005) * 0.05;

        renderer.render(scene, camera);
    }
    animate();

    // Cleanup on page hide / SPA transitions
    window.addEventListener('pagehide', () => {
        cancelAnimationFrame(rafId);
        resizeObserver.disconnect();
        renderer.dispose();
    });
})();
