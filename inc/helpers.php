<?php
defined( 'ABSPATH' ) || exit;

/** SCF is optional at render time. Core content remains available without it. */
function albina_field( $name, $post_id = false, $default = '' ) {
	$value = function_exists( 'get_field' ) ? get_field( $name, $post_id ) : null;
	return null === $value || false === $value || '' === $value ? $default : $value;
}

function albina_home_url() {
	return function_exists( 'pll_home_url' ) ? pll_home_url() : home_url( '/' );
}

/** Resolve published pages by template, respecting the current language. */
function albina_template_url( $template ) {
	static $urls = array();
	$lang = function_exists( 'pll_current_language' ) ? pll_current_language() : '';
	$key = $template . ':' . $lang;
	if ( ! array_key_exists( $key, $urls ) ) {
		$pages = get_posts( array(
			'post_type' => 'page', 'post_status' => 'publish', 'posts_per_page' => 1,
			'fields' => 'ids', 'meta_key' => '_wp_page_template', 'meta_value' => $template,
			'orderby' => 'menu_order ID', 'order' => 'ASC', 'suppress_filters' => false,
		) );
		$urls[ $key ] = $pages ? get_permalink( $pages[0] ) : '';
	}
	return $urls[ $key ];
}

function albina_fallback_menu() {
	$links = array(
		array( get_post_type_archive_link( 'project' ), __( 'Work', 'albina' ) ),
		array( albina_template_url( 'templates/template-about.php' ), __( 'About', 'albina' ) ),
		array( albina_template_url( 'templates/template-for-brands.php' ), __( 'For Brands', 'albina' ) ),
		array( albina_template_url( 'templates/template-contact.php' ), __( 'Contact', 'albina' ) ),
	);
	echo '<ul class="menu">';
	foreach ( $links as $link ) {
		if ( $link[0] ) {
			echo '<li><a href="' . esc_url( $link[0] ) . '">' . esc_html( $link[1] ) . '</a></li>';
		}
	}
	echo '</ul>';
}

function albina_image( $id, $size = 'albina-editorial', $attrs = array() ) {
	if ( ! $id ) {
		return;
	}
	$attrs = wp_parse_args( $attrs, array( 'loading' => 'lazy', 'decoding' => 'async', 'sizes' => '(max-width: 760px) 100vw, 90vw' ) );
	echo wp_get_attachment_image( absint( $id ), $size, false, $attrs ); // Core escapes attachment attributes.
}

function albina_hero_id( $post_id = false ) {
	$post_id = $post_id ?: get_the_ID();
	if ( post_password_required( $post_id ) ) {
		return 0;
	}
	return absint( albina_field( 'hero_image', $post_id, get_post_thumbnail_id( $post_id ) ) );
}

function albina_cover_id( $post_id ) {
	return post_password_required( $post_id ) ? 0 : absint( albina_field( 'cover_image', $post_id, albina_hero_id( $post_id ) ) );
}

/** Native picture/srcset art direction: the browser downloads the matching source only. */
function albina_art_directed_image( $post_id = false, $context = 'hero', $attrs = array() ) {
	$post_id = $post_id ?: get_the_ID();
	$context = 'cover' === $context ? 'cover' : 'hero';
	$id = 'cover' === $context ? albina_cover_id( $post_id ) : albina_hero_id( $post_id );
	if ( ! $id ) {
		return;
	}
	$mobile_id = absint( albina_field( $context . '_mobile_image', $post_id ) );
	if ( ! $mobile_id && 'cover' === $context && ! albina_field( 'cover_image', $post_id ) ) {
		$mobile_id = absint( albina_field( 'hero_mobile_image', $post_id ) );
	}
	$style = '';
	foreach ( array( 'focus_x', 'focus_y', 'mobile_focus_x', 'mobile_focus_y' ) as $axis ) {
		$value = albina_field( $context . '_' . $axis, $post_id, 50 );
		$value = is_numeric( $value ) ? max( 0, min( 100, (float) $value ) ) : 50;
		$style .= '--' . str_replace( '_', '-', $axis ) . ':' . $value . '%;';
	}
	$attrs['class'] = trim( ( $attrs['class'] ?? '' ) . ' art-directed-image' );
	$attrs['style'] = $style;
	$size = $attrs['image_size'] ?? 'albina-editorial';
	unset( $attrs['image_size'] );
	echo '<picture class="art-directed-media">';
	$mobile = $mobile_id ? wp_get_attachment_image_src( $mobile_id, $size ) : false;
	if ( $mobile ) {
		$srcset = wp_get_attachment_image_srcset( $mobile_id, $size ) ?: $mobile[0];
		echo '<source media="(max-width: 760px)" srcset="' . esc_attr( $srcset ) . '" sizes="' . esc_attr( $attrs['sizes'] ?? '100vw' ) . '" width="' . absint( $mobile[1] ) . '" height="' . absint( $mobile[2] ) . '">';
	}
	albina_image( $id, $size, $attrs );
	echo '</picture>';
}

/** Explicit selections retain editorial order; fallback is limited to recent projects. */
function albina_projects( $ids = array(), $limit = 6 ) {
	$args = array(
		'post_type' => 'project', 'post_status' => 'publish', 'posts_per_page' => $limit,
		'no_found_rows' => true, 'ignore_sticky_posts' => true, 'suppress_filters' => false,
	);
	if ( $ids ) {
		$ids = array_map( 'absint', (array) $ids );
		if ( function_exists( 'pll_get_post' ) ) {
			$ids = array_filter( array_map( 'pll_get_post', $ids ) );
		}
		if ( ! $ids ) {
			return array();
		}
		$args['post__in'] = $ids;
		$args['orderby'] = 'post__in';
	}
	return get_posts( $args );
}

/** Only known layout names may resolve to template files. */
function albina_editorial( $blocks ) {
	$layouts = array( 'fullscreen_image', 'portrait_image', 'two_column', 'three_image', 'image_text', 'sticky_sequence', 'horizontal_strip', 'video', 'editorial_text', 'credits' );
	foreach ( (array) $blocks as $block ) {
		if ( is_array( $block ) && in_array( $block['acf_fc_layout'] ?? '', $layouts, true ) ) {
			get_template_part( 'template-parts/project/blocks/' . $block['acf_fc_layout'], null, array( 'block' => $block ) );
		}
	}
}
