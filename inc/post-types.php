<?php
defined( 'ABSPATH' ) || exit;

function albina_register_post_types() {
	register_post_type( 'project', array(
		'labels' => array(
			'name' => __( 'Projects', 'albina' ),
			'singular_name' => __( 'Project', 'albina' ),
			'add_new_item' => __( 'Add project', 'albina' ),
			'edit_item' => __( 'Edit project', 'albina' ),
			'new_item' => __( 'New project', 'albina' ),
			'view_item' => __( 'View project', 'albina' ),
			'search_items' => __( 'Search projects', 'albina' ),
			'not_found' => __( 'No projects found.', 'albina' ),
			'not_found_in_trash' => __( 'No projects in Trash.', 'albina' ),
			'all_items' => __( 'All projects', 'albina' ),
		),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'work', 'with_front' => false ),
		'show_in_rest' => true,
		'menu_icon' => 'dashicons-format-image',
		'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes' ),
	) );
}
add_action( 'init', 'albina_register_post_types' );
