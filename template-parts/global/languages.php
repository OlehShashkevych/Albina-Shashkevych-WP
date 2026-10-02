<?php
defined( 'ABSPATH' ) || exit;
if ( ! function_exists( 'pll_the_languages' ) ) {
	return;
}
$languages = pll_the_languages( array( 'raw' => 1, 'hide_if_empty' => 0, 'hide_if_no_translation' => 1 ) );
if ( ! $languages ) {
	return;
}
?>
<ul class="languages" aria-label="<?php esc_attr_e( 'Languages', 'albina' ); ?>">
	<?php foreach ( $languages as $language ) : ?>
		<li><a href="<?php echo esc_url( $language['url'] ); ?>" lang="<?php echo esc_attr( str_replace( '_', '-', $language['locale'] ) ); ?>" hreflang="<?php echo esc_attr( str_replace( '_', '-', $language['locale'] ) ); ?>" aria-label="<?php echo esc_attr( $language['name'] ); ?>" <?php if ( $language['current_lang'] ) : ?>aria-current="true"<?php endif; ?>><?php echo esc_html( strtoupper( $language['slug'] ) ); ?></a></li>
	<?php endforeach; ?>
</ul>
