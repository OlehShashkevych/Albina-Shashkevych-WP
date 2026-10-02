<?php
defined( 'ABSPATH' ) || exit;
$projects = $args['projects'] ?? array();
if ( ! $projects ) {
	return;
}
?>
<section id="selected-work" class="selected-work section-pad" aria-labelledby="selected-heading">
	<div class="section-heading"><h2 id="selected-heading"><?php esc_html_e( 'Selected work', 'albina' ); ?></h2><span aria-hidden="true">(<?php echo esc_html( sprintf( '%02d', count( $projects ) ) ); ?>)</span></div>
	<div class="work-composition">
		<?php foreach ( $projects as $index => $project ) : ?>
			<?php get_template_part( 'template-parts/components/project', null, array( 'project' => $project, 'number' => $index + 1 ) ); ?>
		<?php endforeach; ?>
	</div>
</section>
