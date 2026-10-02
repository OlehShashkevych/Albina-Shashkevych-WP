<?php
/** Template Name: About */
defined( 'ABSPATH' ) || exit;
get_header();
while ( have_posts() ) : the_post();
	if ( post_password_required() ) {
		echo '<div class="prose section-pad">';
		the_content();
		echo '</div>';
		continue;
	}
?>
<article <?php post_class( 'about-page' ); ?>>
	<?php get_template_part( 'template-parts/components/page-opening' ); ?>
	<?php $facts = albina_field( 'facts', false, array() ); ?>
	<?php if ( $facts ) : ?>
		<dl class="facts section-pad">
			<?php foreach ( $facts as $fact ) : ?><div><dt><?php echo esc_html( $fact['label'] ?? '' ); ?></dt><dd><?php echo esc_html( $fact['value'] ?? '' ); ?></dd></div><?php endforeach; ?>
		</dl>
	<?php endif; ?>
</article>
<?php get_template_part( 'template-parts/components/cta' ); ?>
<?php endwhile; get_footer(); ?>
