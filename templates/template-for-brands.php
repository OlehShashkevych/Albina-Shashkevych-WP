<?php
/** Template Name: For Brands */
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
<article <?php post_class( 'brands-page' ); ?>>
	<?php get_template_part( 'template-parts/components/page-opening' ); ?>
	<?php get_template_part( 'template-parts/components/services' ); ?>
	<?php $selected = albina_field( 'selected_projects', false, array() ); ?>
	<?php if ( $selected ) { get_template_part( 'template-parts/components/selected-work', null, array( 'projects' => albina_projects( $selected, 12 ) ) ); } ?>
</article>
<?php get_template_part( 'template-parts/components/cta' ); ?>
<?php endwhile; get_footer(); ?>
