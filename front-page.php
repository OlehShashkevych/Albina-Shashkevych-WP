<?php
defined( 'ABSPATH' ) || exit;
get_header();
$page_id = is_page() ? get_queried_object_id() : 0;
if ( $page_id && post_password_required( $page_id ) ) {
	echo '<div class="prose section-pad">' . get_the_password_form() . '</div>';
	get_footer();
	return;
}
$selected = $page_id ? albina_field( 'selected_projects', $page_id, array() ) : array();
$projects = albina_projects( $selected, $selected ? 12 : 6 );
get_template_part( 'template-parts/home/hero', null, array( 'page_id' => $page_id, 'has_projects' => (bool) $projects ) );
if ( $page_id && have_posts() ) {
	the_post();
	if ( get_the_content() ) {
		echo '<div class="prose home-intro section-pad">';
		the_content();
		echo '</div>';
	}
}
get_template_part( 'template-parts/components/selected-work', null, array( 'projects' => $projects ) );
get_template_part( 'template-parts/home/project-index', null, array( 'projects' => $projects ) );
get_template_part( 'template-parts/components/cta', null, array( 'link' => $page_id ? albina_field( 'cta_link', $page_id ) : '', 'fallback' => true ) );
get_footer();
