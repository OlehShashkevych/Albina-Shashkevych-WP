<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Custom post types
 */

// Portfolio projects
function theme_register_post_types() {
    register_post_type('portfolio', array(
        'labels' => array(
            'name'                  => __('Portfolio', 'photographer'),
            'singular_name'         => __('Project', 'photographer'),
            'add_new'               => __('Add Project', 'photographer'),
            'add_new_item'          => __('Add New Project', 'photographer'),
            'edit_item'             => __('Edit Project', 'photographer'),
            'new_item'              => __('New Project', 'photographer'),
            'view_item'             => __('View Project', 'photographer'),
            'search_items'          => __('Search Projects', 'photographer'),
            'not_found'             => __('No projects found', 'photographer'),
            'not_found_in_trash'    => __('No projects found in trash', 'photographer'),
            'all_items'             => __('All Projects', 'photographer'),
        ),
        'public'            => true,
        'publicly_queryable' => true,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_rest'      => true,
        'menu_position'     => 5,
        'menu_icon'         => 'dashicons-camera',
        'supports'          => array('title', 'editor', 'thumbnail', 'revisions'),
        'has_archive'       => true,
        'rewrite'           => array('slug' => 'portfolio', 'with_front' => false),
        'taxonomies'        => array('portfolio_category'),
    ));

    register_post_type('testimonial', array(
        'labels' => array(
            'name'                  => __('Testimonials', 'photographer'),
            'singular_name'         => __('Testimonial', 'photographer'),
            'add_new'               => __('Add Testimonial', 'photographer'),
            'add_new_item'          => __('Add New Testimonial', 'photographer'),
            'edit_item'             => __('Edit Testimonial', 'photographer'),
            'new_item'              => __('New Testimonial', 'photographer'),
            'view_item'             => __('View Testimonial', 'photographer'),
            'search_items'          => __('Search Testimonials', 'photographer'),
            'not_found'             => __('No testimonials found', 'photographer'),
            'all_items'             => __('All Testimonials', 'photographer'),
        ),
        'public'            => false,
        'publicly_queryable' => false,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'menu_icon'         => 'dashicons-format-quote',
        'supports'          => array('title', 'editor'),
        'has_archive'       => false,
        'rewrite'           => false,
    ));

    register_post_type('service', array(
        'labels' => array(
            'name'                  => __('Services', 'photographer'),
            'singular_name'         => __('Service', 'photographer'),
            'add_new'               => __('Add Service', 'photographer'),
            'add_new_item'          => __('Add New Service', 'photographer'),
            'edit_item'             => __('Edit Service', 'photographer'),
            'new_item'              => __('New Service', 'photographer'),
            'view_item'             => __('View Service', 'photographer'),
            'search_items'          => __('Search Services', 'photographer'),
            'not_found'             => __('No services found', 'photographer'),
            'all_items'             => __('All Services', 'photographer'),
        ),
        'public'            => false,
        'publicly_queryable' => false,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'menu_icon'         => 'dashicons-admin-generic',
        'supports'          => array('title', 'editor'),
        'has_archive'       => false,
        'rewrite'           => false,
    ));
}
add_action('init', 'theme_register_post_types', 0);
