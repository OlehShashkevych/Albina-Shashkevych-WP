<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Custom taxonomies
 */
function theme_register_taxonomies() {
    register_taxonomy('portfolio_category', 'portfolio', array(
        'labels' => array(
            'name'                       => __('Categories', 'photographer'),
            'singular_name'              => __('Category', 'photographer'),
            'search_items'               => __('Search Categories', 'photographer'),
            'all_items'                  => __('All Categories', 'photographer'),
            'parent_item'                => __('Parent Category', 'photographer'),
            'parent_item_colon'          => __('Parent Category:', 'photographer'),
            'edit_item'                  => __('Edit Category', 'photographer'),
            'update_item'                => __('Update Category', 'photographer'),
            'add_new_item'               => __('Add New Category', 'photographer'),
            'new_item_name'              => __('New Category Name', 'photographer'),
            'menu_name'                  => __('Categories', 'photographer'),
        ),
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'portfolio/category', 'with_front' => false),
    ));
}
add_action('init', 'theme_register_taxonomies', 0);
