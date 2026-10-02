<?php defined( 'ABSPATH' ) || exit; ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'albina' ); ?></a>
<header class="site-header">
	<a class="site-brand" href="<?php echo esc_url( albina_home_url() ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
	<button class="menu-toggle" type="button" aria-expanded="false" aria-controls="site-navigation" hidden><?php esc_html_e( 'Menu', 'albina' ); ?><span aria-hidden="true"> +</span></button>
	<nav id="site-navigation" class="site-navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'albina' ); ?>">
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'depth' => 1, 'fallback_cb' => 'albina_fallback_menu' ) ); ?>
		<?php get_template_part( 'template-parts/global/languages' ); ?>
	</nav>
</header>
<main id="main" tabindex="-1">
