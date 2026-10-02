<?php defined( 'ABSPATH' ) || exit; get_header(); ?>
<section class="not-found section-pad">
	<p class="eyebrow">404</p>
	<h1><?php esc_html_e( 'Outside the frame.', 'albina' ); ?></h1>
	<p><?php esc_html_e( 'This page could not be found.', 'albina' ); ?></p>
	<a class="text-link" href="<?php echo esc_url( albina_home_url() ); ?>"><?php esc_html_e( 'Return home', 'albina' ); ?> ↗</a>
</section>
<?php get_footer(); ?>
