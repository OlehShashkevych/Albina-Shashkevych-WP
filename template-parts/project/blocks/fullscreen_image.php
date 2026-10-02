<?php
defined( 'ABSPATH' ) || exit;
$block = $args['block'];
if ( empty( $block['image'] ) ) { return; }
?>
<figure class="editorial-block fullscreen-image" data-motion="mask-reveal">
	<?php albina_image( $block['image'], 'albina-editorial', array( 'sizes' => '100vw' ) ); ?>
	<?php get_template_part( 'template-parts/project/caption', null, array( 'caption' => $block['caption'] ?? '' ) ); ?>
</figure>
