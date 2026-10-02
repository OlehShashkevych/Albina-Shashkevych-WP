<?php
defined( 'ABSPATH' ) || exit;

function albina_asset_version( $path ) {
	return (string) filemtime( get_template_directory() . '/' . $path );
}

function albina_enqueue_assets() {
	$uri = get_template_directory_uri();
	$previous = array();
	foreach ( array( 'variables', 'base', 'layout', 'components', 'pages', 'motion' ) as $name ) {
		$path = 'assets/css/' . $name . '.css';
		$handle = 'albina-' . $name;
		wp_enqueue_style( $handle, $uri . '/' . $path, $previous, albina_asset_version( $path ) );
		$previous = array( $handle );
	}

	$dependencies = array();
	$core = 'assets/vendor/gsap/gsap.min.js';
	if ( is_readable( get_template_directory() . '/' . $core ) ) {
		wp_enqueue_script( 'albina-gsap', $uri . '/' . $core, array(), albina_asset_version( $core ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
		$dependencies[] = 'albina-gsap';
		foreach ( array( 'ScrollTrigger', 'Flip', 'SplitText' ) as $plugin ) {
			$path = 'assets/vendor/gsap/' . $plugin . '.min.js';
			if ( is_readable( get_template_directory() . '/' . $path ) ) {
				$handle = 'albina-gsap-' . strtolower( $plugin );
				wp_enqueue_script( $handle, $uri . '/' . $path, array( 'albina-gsap' ), albina_asset_version( $path ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
				$dependencies[] = $handle;
			}
		}
	}
	$path = 'assets/js/animations/bootstrap.js';
	wp_enqueue_script( 'albina-motion', $uri . '/' . $path, $dependencies, albina_asset_version( $path ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
	$animations = array();
	foreach ( array( 'flash', 'mask-reveal', 'split-text', 'image-expand', 'project-preview', 'sticky-gallery' ) as $name ) {
		$path = 'assets/js/animations/' . $name . '.js';
		$handle = 'albina-' . $name;
		wp_enqueue_script( $handle, $uri . '/' . $path, array( 'albina-motion' ), albina_asset_version( $path ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
		$animations[] = $handle;
	}
	$path = 'assets/js/app.js';
	wp_enqueue_script( 'albina-app', $uri . '/' . $path, $animations, albina_asset_version( $path ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
}
add_action( 'wp_enqueue_scripts', 'albina_enqueue_assets' );
