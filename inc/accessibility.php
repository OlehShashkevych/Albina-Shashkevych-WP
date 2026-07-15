<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Accessibility helpers
 */

// Add skip to content link
function theme_skip_link() {
    echo '<a class="skip-link screen-reader-text" href="#primary-content">' . __('Skip to content', 'photographer') . '</a>';
}
add_action('wp_body_open', 'theme_skip_link');

// Add aria-current to current menu item
function theme_nav_menu_aria_current($atts, $item, $args) {
    if (in_array('current-menu-item', $item->classes, true) || in_array('current_page_item', $item->classes, true)) {
        $atts['aria-current'] = 'page';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'theme_nav_menu_aria_current', 10, 3);

// Add default focus outline for keyboard users
function theme_focus_styles() {
    echo '<style>:focus-visible { outline: 2px solid var(--color-accent); outline-offset: 2px; }</style>';
}
add_action('wp_head', 'theme_focus_styles', 100);
