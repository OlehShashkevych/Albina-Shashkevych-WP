<?php
defined( 'ABSPATH' ) || exit;
$projects = $args['projects'] ?? array();
if ( ! $projects ) {
	return;
}
albina_enqueue_motion( 'project-preview' );
?>
<section class="project-index section-pad" aria-labelledby="index-heading" data-motion="project-preview">
	<div class="section-heading"><h2 id="index-heading"><?php esc_html_e( 'Project index', 'albina' ); ?></h2><a class="text-link" href="<?php echo esc_url( get_post_type_archive_link( 'project' ) ); ?>"><?php esc_html_e( 'All projects', 'albina' ); ?> ↗</a></div>
	<ol class="index-list">
		<?php foreach ( $projects as $index => $project ) : ?>
			<li><a class="index-link" href="<?php echo esc_url( get_permalink( $project->ID ) ); ?>">
				<span class="index-number" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span>
				<span class="index-title"><?php echo esc_html( get_the_title( $project->ID ) ); ?></span>
				<span class="index-image" aria-hidden="true"><?php albina_art_directed_image( $project->ID, 'cover', array( 'image_size' => 'medium_large', 'alt' => '', 'sizes' => '(max-width: 760px) 22vw, 280px' ) ); ?></span>
				<span class="index-arrow" aria-hidden="true">↗</span>
			</a></li>
		<?php endforeach; ?>
	</ol>
</section>
