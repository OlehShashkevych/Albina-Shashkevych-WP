<?php
defined( 'ABSPATH' ) || exit;
$image = albina_hero_id();
$intro = albina_field( 'intro_text' );
?>
<header class="page-heading section-pad">
	<h1 data-motion="split-text"><?php echo esc_html( get_the_title() ); ?></h1>
	<?php if ( $intro ) : ?><p class="page-intro"><?php echo nl2br( esc_html( $intro ) ); ?></p><?php endif; ?>
</header>
<?php if ( $image ) : ?><figure class="page-hero"><?php albina_image( $image, 'albina-editorial', array( 'loading' => 'eager', 'fetchpriority' => 'high', 'sizes' => '(max-width: 760px) 100vw, 85vw' ) ); ?></figure><?php endif; ?>
<div class="prose section-pad"><?php the_content(); wp_link_pages(); ?></div>
