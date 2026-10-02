<?php
defined( 'ABSPATH' ) || exit;

function albina_setup() {
	load_theme_textdomain( 'albina', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	register_nav_menus( array( 'primary' => __( 'Primary navigation', 'albina' ) ) );
	add_image_size( 'albina-editorial', 1920, 0, false );
	add_image_size( 'albina-preview', 720, 960, true );
}
add_action( 'after_setup_theme', 'albina_setup' );

function albina_activate() {
	albina_register_post_types();
	albina_register_taxonomies();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'albina_activate' );
