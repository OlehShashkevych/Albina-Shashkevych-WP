<?php
defined( 'ABSPATH' ) || exit;
$block = $args['block'];
if ( empty( $block['image'] ) ) { return; }
?>
<figure class="editorial-block portrait-image" data-motion="mask-reveal">
	<?php albina_image( $block['image'], 'albina-editorial', array( 'sizes' => '(max-width: 760px) 85vw, 48vw' ) ); ?>
	<?php get_template_part( 'template-parts/project/caption', null, array( 'caption' => $block['caption'] ?? '' ) ); ?>
</figure>
