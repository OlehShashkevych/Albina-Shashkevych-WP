<?php
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
<article <?php post_class( 'project-story' ); ?>>
	<header class="project-heading section-pad">
		<a class="text-link" href="<?php echo esc_url( get_post_type_archive_link( 'project' ) ); ?>"><?php esc_html_e( 'All projects', 'albina' ); ?> ↗</a>
		<h1 data-motion="split-text"><?php echo esc_html( get_the_title() ); ?></h1>
		<?php $intro = albina_field( 'intro_text', false, get_the_excerpt() ); ?>
		<?php if ( $intro ) : ?><p class="project-intro"><?php echo nl2br( esc_html( $intro ) ); ?></p><?php endif; ?>
		<dl class="project-meta">
			<?php foreach ( array( 'client_name' => __( 'Client', 'albina' ), 'project_year' => __( 'Year', 'albina' ), 'project_location' => __( 'Location', 'albina' ) ) as $field => $label ) : ?>
				<?php $value = albina_field( $field ); if ( ! $value ) { continue; } ?>
				<div><dt><?php echo esc_html( $label ); ?></dt><dd><?php echo esc_html( $value ); ?></dd></div>
			<?php endforeach; ?>
		</dl>
	</header>
	<?php if ( albina_hero_id() ) : ?><figure class="project-hero" data-flip-id="project-<?php the_ID(); ?>"><?php albina_image( albina_hero_id(), 'albina-editorial', array( 'loading' => 'eager', 'fetchpriority' => 'high', 'sizes' => '100vw' ) ); ?></figure><?php endif; ?>
	<div class="prose section-pad"><?php the_content(); wp_link_pages(); ?></div>
	<?php albina_editorial( albina_field( 'editorial_blocks', false, array() ) ); ?>
	<?php get_template_part( 'template-parts/project/blocks/credits', null, array( 'block' => array( 'credits' => albina_field( 'credits', false, array() ) ) ) ); ?>
</article>
<?php get_template_part( 'template-parts/components/cta', null, array( 'fallback' => true ) ); ?>
<?php endwhile; get_footer(); ?>
