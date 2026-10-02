<?php
/** Template Name: Contact */
defined( 'ABSPATH' ) || exit;
get_header();
while ( have_posts() ) : the_post();
	if ( post_password_required() ) {
		echo '<div class="prose section-pad">';
		the_content();
		echo '</div>';
		continue;
	}
?>
<article <?php post_class( 'contact-page' ); ?>>
	<?php get_template_part( 'template-parts/components/page-opening' ); ?>
	<div class="contact-details section-pad">
		<?php $email = sanitize_email( albina_field( 'contact_email' ) ); ?>
		<?php if ( $email ) : ?><a class="contact-email" href="<?php echo esc_url( 'mailto:' . $email ); ?>"><?php echo esc_html( $email ); ?></a><?php endif; ?>
		<?php $form_id = absint( albina_field( 'form_id' ) ); ?>
		<?php if ( $form_id && shortcode_exists( 'fluentform' ) ) : ?>
			<div class="contact-form"><?php echo do_shortcode( '[fluentform id="' . $form_id . '"]' ); // Trusted plugin renderer; ID is strictly numeric. ?></div>
		<?php elseif ( $form_id && current_user_can( 'edit_pages' ) ) : ?>
			<p><?php esc_html_e( 'Activate Fluent Forms to display the selected form.', 'albina' ); ?></p>
		<?php endif; ?>
	</div>
</article>
<?php get_template_part( 'template-parts/components/cta' ); ?>
<?php endwhile; get_footer(); ?>
