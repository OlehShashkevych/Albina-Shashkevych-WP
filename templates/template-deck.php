<?php
/** Template Name: Portfolio Deck */
defined( 'ABSPATH' ) || exit;
get_header();
while ( have_posts() ) : the_post();
	if ( post_password_required() ) {
		echo '<div class="prose section-pad">';
		the_content();
		echo '</div>';
		continue;
	}
	get_template_part( 'template-parts/components/presentation-page', null, array( 'class' => 'deck-page' ) );
endwhile;
get_footer();
