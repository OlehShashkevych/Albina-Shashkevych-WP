<?php
defined( 'ABSPATH' ) || exit;
$block = $args['block'];
if ( empty( $block['images'] ) ) { return; }
?>
<figure class="editorial-block horizontal-gallery">
	<div class="horizontal-track" tabindex="0" role="region" aria-label="<?php esc_attr_e( 'Image sequence — scroll horizontally', 'albina' ); ?>">
		<?php foreach ( $block['images'] as $image ) : ?><div><?php albina_image( $image, 'albina-editorial', array( 'sizes' => '(max-width: 760px) 85vw, 60vw' ) ); ?></div><?php endforeach; ?>
	</div>
	<?php get_template_part( 'template-parts/project/caption', null, array( 'caption' => $block['caption'] ?? '' ) ); ?>
</figure>
