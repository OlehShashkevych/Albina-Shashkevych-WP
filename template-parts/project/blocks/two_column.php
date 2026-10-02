<?php
defined( 'ABSPATH' ) || exit;
$block = $args['block'];
albina_enqueue_motion( 'mask-reveal' );
?>
<figure class="editorial-block image-pair section-pad">
	<div class="image-composition">
		<?php foreach ( array( 'image', 'image_2' ) as $key ) : ?><div data-motion="mask-reveal"><?php albina_image( $block[ $key ] ?? 0, 'albina-editorial', array( 'sizes' => '(max-width: 760px) 90vw, 45vw' ) ); ?></div><?php endforeach; ?>
	</div>
	<?php get_template_part( 'template-parts/project/caption', null, array( 'caption' => $block['caption'] ?? '' ) ); ?>
</figure>
