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

/** Recognize only this theme's fields, including SCF's private field-key references. */
function albina_translation_meta_root( $key ) {
	$name = ltrim( $key, '_' );
	$fields = array( 'hero_image', 'cover_image', 'intro_text', 'client_name', 'project_year', 'project_location', 'selected_projects', 'cta_link', 'form_id', 'contact_email' );
	foreach ( array( 'hero', 'cover' ) as $prefix ) {
		foreach ( array( 'mobile_image', 'focus_x', 'focus_y', 'mobile_focus_x', 'mobile_focus_y' ) as $suffix ) {
			$fields[] = $prefix . '_' . $suffix;
		}
	}
	if ( in_array( $name, $fields, true ) ) {
		return $name;
	}
	if ( preg_match( '/^(editorial_blocks|credits|facts|services)(?:_\d+_.+)?$/', $name, $matches ) ) {
		return $matches[1];
	}
	return '';
}

/** Copy the whole SCF tree once, never synchronize it or overwrite an existing target tree. */
function albina_copy_translation_fields( $metas, $sync, $from, $to, $lang ) {
	if ( ! in_array( get_post_type( $from ), array( 'page', 'project' ), true ) ) {
		return $metas;
	}
	// Remove theme-owned entries even when blanket custom-field sync is enabled.
	$metas = array_values( array_filter( $metas, static function ( $key ) {
		return ! albina_translation_meta_root( $key );
	} ) );
	if ( $sync ) {
		return $metas;
	}
	$existing = array();
	foreach ( (array) get_post_custom_keys( $to ) as $key ) {
		$root = albina_translation_meta_root( $key );
		if ( $root ) {
			$existing[ $root ] = true;
		}
	}
	foreach ( (array) get_post_custom_keys( $from ) as $key ) {
		$root = albina_translation_meta_root( $key );
		if ( $root && ! isset( $existing[ $root ] ) ) {
			$metas[] = $key;
		}
	}
	return array_values( array_unique( $metas ) );
}
// After Polylang's XML preferences: theme fields remain independent after the initial copy.
add_filter( 'pll_copy_post_metas', 'albina_copy_translation_fields', 100, 5 );

function albina_translate_selection_meta( $value, $key, $lang, $from, $to ) {
	if ( 'selected_projects' !== $key || ! is_array( $value ) || ! function_exists( 'pll_get_post' ) || ! in_array( get_post_type( $from ), array( 'page', 'project' ), true ) ) {
		return $value;
	}
	// Retain unresolved IDs: the frontend resolves them when a translation is published later.
	return array_map( static function ( $id ) use ( $lang ) {
		return pll_get_post( absint( $id ), $lang ) ?: absint( $id );
	}, $value );
}
add_filter( 'pll_translate_post_meta', 'albina_translate_selection_meta', 100, 5 );
