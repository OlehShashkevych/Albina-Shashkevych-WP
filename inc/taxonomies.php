<?php
defined( 'ABSPATH' ) || exit;

function albina_register_taxonomies() {
	register_taxonomy( 'project_type', 'project', array(
		'labels' => array(
			'name' => __( 'Project types', 'albina' ),
			'singular_name' => __( 'Project type', 'albina' ),
			'search_items' => __( 'Search project types', 'albina' ),
			'all_items' => __( 'All project types', 'albina' ),
			'edit_item' => __( 'Edit project type', 'albina' ),
			'update_item' => __( 'Update project type', 'albina' ),
			'add_new_item' => __( 'Add project type', 'albina' ),
			'new_item_name' => __( 'New project type name', 'albina' ),
		),
		'public' => true,
		'hierarchical' => true,
		'show_in_rest' => true,
		'show_admin_column' => true,
		'rewrite' => array( 'slug' => 'project-type', 'with_front' => false ),
	) );
}
add_action( 'init', 'albina_register_taxonomies' );
