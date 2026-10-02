<?php
defined( 'ABSPATH' ) || exit;

function albina_translatable_post_types( $types, $is_settings ) {
	$types['project'] = 'project';
	return $types;
}
add_filter( 'pll_get_post_types', 'albina_translatable_post_types', 10, 2 );

function albina_translatable_taxonomies( $taxonomies, $is_settings ) {
	$taxonomies['project_type'] = 'project_type';
	return $taxonomies;
}
add_filter( 'pll_get_taxonomies', 'albina_translatable_taxonomies', 10, 2 );
