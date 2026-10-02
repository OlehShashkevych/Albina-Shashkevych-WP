<?php defined( 'ABSPATH' ) || exit; $block = $args['block']; albina_enqueue_motion( 'mask-reveal' );
?>
<section class="editorial-block image-text section-pad">
	<div data-motion="mask-reveal"><?php albina_image( $block['image'] ?? 0, 'albina-editorial', array( 'sizes' => '(max-width: 760px) 90vw, 50vw' ) ); ?></div>
	<div class="prose">
		<?php if ( ! empty( $block['heading'] ) ) : ?><h2><?php echo esc_html( $block['heading'] ); ?></h2><?php endif; ?>
		<?php echo wp_kses_post( $block['text'] ?? '' ); ?>
	</div>
</section>
