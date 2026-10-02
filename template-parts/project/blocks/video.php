<?php
defined( 'ABSPATH' ) || exit;
$block = $args['block'];
$url = wp_get_attachment_url( absint( $block['video'] ?? 0 ) );
if ( ! $url ) { return; }
$poster = wp_get_attachment_image_url( absint( $block['poster'] ?? 0 ), 'albina-editorial' );
?>
<figure class="editorial-block editorial-video section-pad">
	<video controls playsinline preload="none" <?php if ( $poster ) : ?>poster="<?php echo esc_url( $poster ); ?>"<?php endif; ?>>
		<source src="<?php echo esc_url( $url ); ?>" type="<?php echo esc_attr( get_post_mime_type( absint( $block['video'] ) ) ); ?>">
		<?php if ( ! empty( $block['captions'] ) ) : ?><track kind="captions" src="<?php echo esc_url( $block['captions'] ); ?>" srclang="<?php echo esc_attr( str_replace( '_', '-', get_locale() ) ); ?>" label="<?php esc_attr_e( 'Captions', 'albina' ); ?>" default><?php endif; ?>
		<a href="<?php echo esc_url( $url ); ?>"><?php esc_html_e( 'Download video', 'albina' ); ?></a>
	</video>
	<?php get_template_part( 'template-parts/project/caption', null, array( 'caption' => $block['caption'] ?? '' ) ); ?>
	<?php if ( ! empty( $block['transcript'] ) ) : ?><details class="video-transcript"><summary><?php esc_html_e( 'Video transcript', 'albina' ); ?></summary><p><?php echo nl2br( esc_html( $block['transcript'] ) ); ?></p></details><?php endif; ?>
</figure>
