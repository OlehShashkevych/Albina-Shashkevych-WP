<?php
defined( 'ABSPATH' ) || exit;
$block = $args['block'];
if ( empty( $block['images'] ) ) { return; }
albina_enqueue_motion( 'sticky-gallery' );
?>
<figure class="editorial-block sticky-sequence" data-motion="sticky-gallery">
	<div class="sticky-images">
		<?php foreach ( $block['images'] as $image ) : ?><div class="sequence-frame"><?php albina_image( $image, 'albina-editorial', array( 'sizes' => '(max-width: 760px) 100vw, 80vw' ) ); ?></div><?php endforeach; ?>
	</div>
	<?php get_template_part( 'template-parts/project/caption', null, array( 'caption' => $block['caption'] ?? '' ) ); ?>
</figure>
