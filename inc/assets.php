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
		wp_register_script( 'albina-gsap', $uri . '/' . $core, array(), albina_asset_version( $core ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
		$dependencies[] = 'albina-gsap';
		foreach ( array( 'ScrollTrigger', 'Flip', 'SplitText' ) as $plugin ) {
			$path = 'assets/vendor/gsap/' . $plugin . '.min.js';
			if ( is_readable( get_template_directory() . '/' . $path ) ) {
				$handle = 'albina-gsap-' . strtolower( $plugin );
				wp_register_script( $handle, $uri . '/' . $path, array( 'albina-gsap' ), albina_asset_version( $path ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
			}
		}
	}
	if ( ! $dependencies ) {
		return;
	}
	$path = 'assets/js/animations/bootstrap.js';
	wp_register_script( 'albina-motion', $uri . '/' . $path, $dependencies, albina_asset_version( $path ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
	foreach ( albina_motion_modules() as $name => $plugin ) {
		$deps = array( 'albina-motion' );
		if ( $plugin && wp_script_is( 'albina-gsap-' . $plugin, 'registered' ) ) {
			$deps[] = 'albina-gsap-' . $plugin;
		} elseif ( $plugin && 'splittext' !== $plugin ) {
			continue;
		}
		$path = 'assets/js/animations/' . $name . '.js';
		$handle = 'albina-' . $name;
		wp_register_script( $handle, $uri . '/' . $path, $deps, albina_asset_version( $path ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
	}
}
add_action( 'wp_enqueue_scripts', 'albina_enqueue_assets' );

function albina_motion_modules() {
	return array( 'flash' => '', 'mask-reveal' => 'scrolltrigger', 'split-text' => 'splittext', 'image-expand' => 'flip', 'project-preview' => '', 'sticky-gallery' => 'scrolltrigger' );
}

/** Template parts request only effects they actually render. WordPress deduplicates them. */
function albina_enqueue_motion( $name ) {
	if ( array_key_exists( $name, albina_motion_modules() ) && wp_script_is( 'albina-' . $name, 'registered' ) ) {
		wp_enqueue_script( 'albina-' . $name );
	}
}

/** Run before WordPress prints footer scripts, after all template parts requested effects. */
function albina_enqueue_app() {
	$animations = array();
	foreach ( albina_motion_modules() as $name => $plugin ) {
		if ( wp_script_is( 'albina-' . $name, 'enqueued' ) ) {
			$animations[] = 'albina-' . $name;
		}
	}
	$path = 'assets/js/app.js';
	wp_enqueue_script( 'albina-app', get_template_directory_uri() . '/' . $path, $animations, albina_asset_version( $path ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
}
add_action( 'wp_footer', 'albina_enqueue_app', 5 );
