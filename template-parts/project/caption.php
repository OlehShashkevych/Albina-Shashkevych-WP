<?php
defined( 'ABSPATH' ) || exit;
if ( ! empty( $args['caption'] ) ) :
?>
<figcaption><?php echo esc_html( $args['caption'] ); ?></figcaption>
<?php endif; ?>
