<?php
defined( 'ABSPATH' ) || exit;
$id = absint( $args['page_id'] ?? 0 );
$image = $id ? albina_hero_id( $id ) : 0;
$intro = $id ? albina_field( 'intro_text', $id ) : get_bloginfo( 'description' );
?>
<section class="home-hero <?php echo $image ? 'has-image' : 'no-image'; ?>" data-motion="flash-in">
	<?php if ( $image ) : ?><div class="hero-photograph"><?php albina_image( $image, 'albina-editorial', array( 'loading' => 'eager', 'fetchpriority' => 'high', 'sizes' => '(max-width: 760px) 100vw, 72vw' ) ); ?></div><?php endif; ?>
	<h1 class="hero-title" data-motion="split-text"><span>Albina</span><span>Shashkevych</span></h1>
	<div class="hero-bottom">
		<?php if ( $intro ) : ?><p><?php echo nl2br( esc_html( $intro ) ); ?></p><?php endif; ?>
		<a class="text-link" href="<?php echo esc_url( ! empty( $args['has_projects'] ) ? '#selected-work' : get_post_type_archive_link( 'project' ) ); ?>"><?php esc_html_e( 'Explore work', 'albina' ); ?> <span aria-hidden="true">↓</span></a>
	</div>
	<span class="hero-flash" aria-hidden="true"></span>
</section>
