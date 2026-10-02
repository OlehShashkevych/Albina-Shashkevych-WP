<?php
defined( 'ABSPATH' ) || exit;
$project = $args['project'];
$id = $project->ID;
$number = $args['number'] ?? 1;
$heading = 'h2' === ( $args['heading'] ?? '' ) ? 'h2' : 'h3';
$image = albina_cover_id( $id );
$types = get_the_terms( $id, 'project_type' );
if ( $image ) { albina_enqueue_motion( 'image-expand' ); }
?>
<article class="work-item">
	<a class="work-image" href="<?php echo esc_url( get_permalink( $id ) ); ?>" aria-label="<?php echo esc_attr( get_the_title( $id ) ); ?>" data-motion="image-expand" data-flip-id="project-<?php echo esc_attr( $id ); ?>">
		<?php if ( $image ) : ?>
			<?php albina_art_directed_image( $id, 'cover', array( 'sizes' => '(max-width: 760px) 100vw, 72vw' ) ); ?>
		<?php else : ?>
			<span class="image-placeholder" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $number ) ); ?></span>
		<?php endif; ?>
	</a>
	<div class="work-caption">
		<span class="work-number" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $number ) ); ?></span>
		<<?php echo $heading; ?>><a href="<?php echo esc_url( get_permalink( $id ) ); ?>"><?php echo esc_html( get_the_title( $id ) ); ?></a></<?php echo $heading; ?>>
		<?php if ( $types && ! is_wp_error( $types ) ) : ?><p><?php echo esc_html( implode( ' / ', wp_list_pluck( $types, 'name' ) ) ); ?></p><?php endif; ?>
	</div>
</article>
