<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'THEME_VERSION', '2.0.0' );
define( 'THEME_DIR', get_template_directory() );
define( 'THEME_URI', get_template_directory_uri() );

// Подключение инклудов
require_once THEME_DIR . '/inc/setup.php';
require_once THEME_DIR . '/inc/enqueue.php';
require_once THEME_DIR . '/inc/polylang.php';
require_once THEME_DIR . '/inc/helpers.php';
require_once THEME_DIR . '/inc/post-types.php';
require_once THEME_DIR . '/inc/taxonomies.php';
require_once THEME_DIR . '/inc/ajax.php';
require_once THEME_DIR . '/inc/seo.php';
require_once THEME_DIR . '/inc/accessibility.php';
require_once THEME_DIR . '/inc/performance.php';
require_once THEME_DIR . '/inc/demo-content.php';

// Подключение ACF полей (проверяем, активен ли плагин, чтобы не ронять сайт)
if ( function_exists('acf_add_local_field_group') ) {
    require_once THEME_DIR . '/inc/acf/loader.php';
}

// Регистрация страницы опций ACF
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title'    => 'Theme General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}

// Отключаем автоматические <p> и <br> в Contact Form 7
add_filter( 'wpcf7_autop_or_not', '__return_false' );