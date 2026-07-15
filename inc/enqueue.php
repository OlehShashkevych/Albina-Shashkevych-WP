<?php
function my_theme_scripts() {
    // Google Fonts
    wp_enqueue_style(
        'theme-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@400;500;600&display=swap',
        array(),
        null
    );

    // Reset kept as-is
    wp_enqueue_style( 'my-theme-reset', THEME_URI . '/assets/css/reset.css', array(), THEME_VERSION );

    // Design system
    wp_enqueue_style(
        'my-theme-main',
        THEME_URI . '/assets/css/theme.css',
        array('my-theme-reset', 'theme-fonts'),
        THEME_VERSION
    );

    // Components layout
    wp_enqueue_style(
        'my-theme-components',
        THEME_URI . '/assets/css/components.css',
        array('my-theme-main'),
        THEME_VERSION
    );

    // Vendor libraries
    wp_enqueue_script(
        'three-js',
        'https://unpkg.com/three@0.160.0/build/three.min.js',
        array(),
        null,
        true
    );

    wp_enqueue_script(
        'gsap-js',
        'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js',
        array(),
        null,
        true
    );

    wp_enqueue_script(
        'gsap-scrolltrigger',
        'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js',
        array('gsap-js'),
        null,
        true
    );

    wp_enqueue_script(
        'lenis-js',
        'https://unpkg.com/lenis@1.1.18/dist/lenis.min.js',
        array(),
        null,
        true
    );

    // Theme JS (no jQuery dependency)
    wp_enqueue_script(
        'my-theme-js',
        THEME_URI . '/assets/js/theme.js',
        array(),
        THEME_VERSION,
        true
    );

    wp_enqueue_script(
        'my-theme-hero',
        THEME_URI . '/assets/js/hero.js',
        array('my-theme-js', 'three-js'),
        THEME_VERSION,
        true
    );

    wp_enqueue_script(
        'my-theme-animations',
        THEME_URI . '/assets/js/animations.js',
        array('my-theme-js', 'gsap-js', 'gsap-scrolltrigger'),
        THEME_VERSION,
        true
    );

    if (is_post_type_archive('portfolio') || is_singular('portfolio')) {
        wp_enqueue_script(
            'my-theme-portfolio',
            THEME_URI . '/assets/js/portfolio.js',
            array('my-theme-js', 'gsap-js'),
            THEME_VERSION,
            true
        );
    }

    // Pass data to JS
    wp_localize_script( 'my-theme-js', 'themeData', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'restUrl' => rest_url(),
        'nonce'   => wp_create_nonce('wp_rest'),
    ));
}
add_action( 'wp_enqueue_scripts', 'my_theme_scripts' );