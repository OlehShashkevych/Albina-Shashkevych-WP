<?php defined( 'ABSPATH' ) || exit; ?>
<article <?php post_class( $args['class'] ); ?>>
	<?php get_template_part( 'template-parts/components/page-opening' ); ?>
	<?php $selected = albina_field( 'selected_projects', false, array() ); ?>
	<?php if ( $selected ) { get_template_part( 'template-parts/components/selected-work', null, array( 'projects' => albina_projects( $selected, 12 ) ) ); } ?>
	<?php albina_editorial( albina_field( 'editorial_blocks', false, array() ) ); ?>
	<?php get_template_part( 'template-parts/components/services' ); ?>
</article>
<?php get_template_part( 'template-parts/components/cta' ); ?>
