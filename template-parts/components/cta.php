<?php
defined( 'ABSPATH' ) || exit;
$link = $args['link'] ?? albina_field( 'cta_link' );
if ( ! is_array( $link ) || empty( $link['url'] ) ) {
	if ( empty( $args['fallback'] ) ) {
		return;
	}
	$link = array( 'url' => albina_template_url( 'templates/template-contact.php' ), 'title' => __( 'Start a project', 'albina' ) );
}
if ( empty( $link['url'] ) ) {
	return;
}
?>
<section class="closing-cta section-pad">
	<p class="eyebrow"><?php esc_html_e( 'Let’s create together', 'albina' ); ?></p>
	<h2><a href="<?php echo esc_url( $link['url'] ); ?>" <?php if ( '_blank' === ( $link['target'] ?? '' ) ) : ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>><?php echo esc_html( $link['title'] ?: __( 'Start a project', 'albina' ) ); ?><span aria-hidden="true"> ↗</span></a></h2>
</section>
