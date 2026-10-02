<?php defined( 'ABSPATH' ) || exit; $block = $args['block']; ?>
<section class="editorial-block editorial-text prose section-pad">
	<?php if ( ! empty( $block['heading'] ) ) : ?><h2><?php echo esc_html( $block['heading'] ); ?></h2><?php endif; ?>
	<?php echo wp_kses_post( $block['text'] ?? '' ); ?>
</section>
