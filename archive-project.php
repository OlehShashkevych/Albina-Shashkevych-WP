<?php
defined( 'ABSPATH' ) || exit;
get_header();
albina_enqueue_motion( 'split-text' );
$types = get_terms( array( 'taxonomy' => 'project_type', 'hide_empty' => true ) );
?>
<header class="page-heading section-pad">
	<p class="eyebrow"><?php esc_html_e( 'Portfolio', 'albina' ); ?></p>
	<h1 data-motion="split-text"><?php echo is_tax( 'project_type' ) ? esc_html( single_term_title( '', false ) ) : esc_html__( 'Work', 'albina' ); ?></h1>
	<?php if ( is_tax( 'project_type' ) && term_description() ) : ?><div class="prose"><?php echo wp_kses_post( term_description() ); ?></div><?php endif; ?>
	<?php if ( $types && ! is_wp_error( $types ) ) : ?>
		<nav class="work-filters" aria-label="<?php esc_attr_e( 'Project types', 'albina' ); ?>">
			<a href="<?php echo esc_url( get_post_type_archive_link( 'project' ) ); ?>" <?php if ( ! is_tax() ) : ?>aria-current="page"<?php endif; ?>><?php esc_html_e( 'All', 'albina' ); ?></a>
			<?php foreach ( $types as $type ) : ?>
				<?php $url = get_term_link( $type ); if ( is_wp_error( $url ) ) { continue; } ?>
				<a href="<?php echo esc_url( $url ); ?>" <?php if ( is_tax( 'project_type', $type->term_id ) ) : ?>aria-current="page"<?php endif; ?>><?php echo esc_html( $type->name ); ?></a>
			<?php endforeach; ?>
		</nav>
	<?php endif; ?>
</header>
<section class="section-pad archive-work" aria-label="<?php esc_attr_e( 'Projects', 'albina' ); ?>">
	<?php if ( have_posts() ) : ?>
		<div class="work-composition">
		<?php $index = ( max( 1, get_query_var( 'paged' ) ) - 1 ) * (int) get_query_var( 'posts_per_page' ); ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/components/project', null, array( 'project' => get_post(), 'number' => ++$index, 'heading' => 'h2' ) ); ?>
		<?php endwhile; ?>
		</div>
		<?php the_posts_pagination( array( 'prev_text' => __( 'Previous', 'albina' ), 'next_text' => __( 'Next', 'albina' ) ) ); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'New work will appear here soon.', 'albina' ); ?></p>
	<?php endif; ?>
</section>
<?php get_template_part( 'template-parts/components/cta', null, array( 'link' => '', 'fallback' => true ) ); ?>
<?php get_footer(); ?>
