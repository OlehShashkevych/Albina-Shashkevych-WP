<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Basic SEO / Open Graph helpers
 */

function theme_document_title_separator($sep) {
    return '|';
}
add_filter('document_title_separator', 'theme_document_title_separator');

function theme_document_title_parts($title) {
    if (is_front_page()) {
        $title['title'] = get_bloginfo('name');
        $title['tagline'] = get_bloginfo('description');
    }
    return $title;
}
add_filter('document_title_parts', 'theme_document_title_parts');

function theme_open_graph_meta() {
    if (!is_singular() && !is_front_page()) return;

    $post = get_queried_object();
    $title = is_front_page() ? get_bloginfo('name') : get_the_title($post);
    $description = is_front_page() ? get_bloginfo('description') : get_the_excerpt($post);
    $url = is_front_page() ? home_url('/') : get_permalink($post);
    $image = '';

    if (is_front_page()) {
        $hero = get_field('home_hero_images');
        if ($hero && !empty($hero)) {
            $image = wp_get_attachment_image_url($hero[0], 'hero');
        }
    } elseif (is_singular('portfolio')) {
        $cover = get_field('project_cover', $post->ID);
        if ($cover) {
            $image = wp_get_attachment_image_url($cover, 'large');
        }
    } elseif (has_post_thumbnail($post)) {
        $image = get_the_post_thumbnail_url($post, 'large');
    }

    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
    echo '<meta property="og:type" content="website">' . "\n";
    if ($image) {
        echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
    }
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
}
add_action('wp_head', 'theme_open_graph_meta', 5);

function theme_preconnect_resource_hints($hints, $relation_type) {
    if ($relation_type === 'preconnect') {
        $hints[] = 'https://fonts.googleapis.com';
        $hints[] = 'https://fonts.gstatic.com';
    }
    return $hints;
}
add_filter('wp_resource_hints', 'theme_preconnect_resource_hints', 10, 2);
