<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Performance helpers
 */

// Add decoding="async" to all content images
function theme_image_attributes($attrs) {
    if (!isset($attrs['decoding'])) {
        $attrs['decoding'] = 'async';
    }
    return $attrs;
}
add_filter('wp_get_attachment_image_attributes', 'theme_image_attributes');

// Add defer attribute to scripts loaded in the head
function theme_defer_scripts($tag, $handle, $src) {
    $defer_handles = array('three-js', 'gsap-js', 'gsap-scrolltrigger', 'my-theme-hero', 'my-theme-animations', 'my-theme-portfolio');
    if (in_array($handle, $defer_handles, true) && false === strpos($tag, 'defer')) {
        $tag = str_replace('src=', 'defer src=', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'theme_defer_scripts', 10, 3);

// Disable the WordPress embed script if not needed
function theme_disable_embeds() {
    if (!is_admin()) {
        wp_dequeue_script('wp-embed');
    }
}
add_action('wp_enqueue_scripts', 'theme_disable_embeds', 100);

// DNS prefetch for CDNs
function theme_dns_prefetch($hints, $relation_type) {
    if ($relation_type === 'dns-prefetch') {
        $hints[] = 'https://unpkg.com';
        $hints[] = 'https://cdnjs.cloudflare.com';
    }
    return $hints;
}
add_filter('wp_resource_hints', 'theme_dns_prefetch', 10, 2);
