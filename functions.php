<?php
/** Theme entry point. */
defined( 'ABSPATH' ) || exit;

foreach ( array( 'setup', 'post-types', 'taxonomies', 'helpers', 'polylang', 'fields', 'assets' ) as $albina_module ) {
	require_once get_template_directory() . '/inc/' . $albina_module . '.php';
}
unset( $albina_module );
