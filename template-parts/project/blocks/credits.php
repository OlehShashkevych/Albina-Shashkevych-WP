<?php
defined( 'ABSPATH' ) || exit;
$credits = $args['block']['credits'] ?? array();
if ( ! $credits ) { return; }
?>
<section class="editorial-block credits section-pad">
	<h2><?php esc_html_e( 'Credits', 'albina' ); ?></h2>
	<dl>
		<?php foreach ( $credits as $credit ) : ?>
			<div><dt><?php echo esc_html( $credit['role'] ?? '' ); ?></dt><dd>
				<?php if ( ! empty( $credit['url'] ) ) : ?><a href="<?php echo esc_url( $credit['url'] ); ?>"><?php echo esc_html( $credit['name'] ?? '' ); ?></a><?php else : ?><?php echo esc_html( $credit['name'] ?? '' ); ?><?php endif; ?>
			</dd></div>
		<?php endforeach; ?>
	</dl>
</section>
