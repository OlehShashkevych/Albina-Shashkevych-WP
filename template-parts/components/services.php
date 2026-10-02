<?php
defined( 'ABSPATH' ) || exit;
$services = albina_field( 'services', false, array() );
if ( ! $services ) {
	return;
}
?>
<section class="services section-pad" aria-label="<?php esc_attr_e( 'Services / proposal', 'albina' ); ?>">
	<?php foreach ( $services as $index => $service ) : ?>
		<div class="service-row">
			<span class="eyebrow" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span>
			<h2><?php echo esc_html( $service['title'] ?? '' ); ?></h2>
			<p><?php echo nl2br( esc_html( $service['description'] ?? '' ) ); ?></p>
		</div>
	<?php endforeach; ?>
</section>
