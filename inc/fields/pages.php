<?php
defined( 'ABSPATH' ) || exit;

function albina_register_page_fields() {
	$special_locations = array();
	foreach ( array( 'about', 'for-brands', 'contact', 'pitch', 'deck' ) as $template ) {
		$special_locations[] = array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'templates/template-' . $template . '.php' ) );
	}
	$home_location = array( array( 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ) );
	$project_location = array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'project' ) );
	acf_add_local_field_group( array(
		'key' => 'group_albina_intro', 'title' => __( 'Opening image and introduction', 'albina' ),
		'fields' => array_merge( array(
			albina_field_definition( 'intro', 'hero_image', __( 'Hero / profile image', 'albina' ), 'image', array( 'return_format' => 'id', 'instructions' => __( 'Falls back to the featured image. Add descriptive alt text in the Media Library.', 'albina' ) ) ),
		), albina_crop_fields( 'intro', 'hero' ), array(
			albina_field_definition( 'intro', 'intro_text', __( 'Short introduction', 'albina' ), 'textarea', array( 'rows' => 3 ) ),
		) ),
		'location' => array_merge( $special_locations, array( $home_location, $project_location ) ),
	) );

	$selection_locations = array( $home_location );
	foreach ( array( 'for-brands', 'pitch', 'deck' ) as $template ) {
		$selection_locations[] = array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'templates/template-' . $template . '.php' ) );
	}
	acf_add_local_field_group( array(
		'key' => 'group_albina_selection', 'title' => __( 'Selected work', 'albina' ),
		'fields' => array(
			albina_field_definition( 'selection', 'selected_projects', __( 'Selected projects', 'albina' ), 'relationship', array( 'post_type' => array( 'project' ), 'post_status' => array( 'publish' ), 'return_format' => 'id', 'max' => 12, 'instructions' => __( 'Drag to reorder. The homepage shows recent projects when this is empty; other templates omit the section.', 'albina' ) ) ),
		),
		'location' => $selection_locations,
	) );

	acf_add_local_field_group( array(
		'key' => 'group_albina_editorial', 'title' => __( 'Editorial content', 'albina' ),
		'fields' => array( albina_editorial_field() ),
		'location' => array(
			$project_location,
			array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'templates/template-pitch.php' ) ),
			array( array( 'param' => 'page_template', 'operator' => '==', 'value' => 'templates/template-deck.php' ) ),
		),
	) );

	acf_add_local_field_group( array(
		'key' => 'group_albina_cta', 'title' => __( 'Closing call to action', 'albina' ),
		'fields' => array( albina_field_definition( 'cta', 'cta_link', __( 'Call to action', 'albina' ), 'link', array( 'return_format' => 'array', 'instructions' => __( 'Optional. The homepage falls back to the Contact template page.', 'albina' ) ) ) ),
		'location' => array_merge( $special_locations, array( $home_location, $project_location ) ),
	) );

	acf_add_local_field_group( array(
		'key' => 'group_albina_about', 'title' => __( 'Selected credentials', 'albina' ),
		'fields' => array( albina_field_definition( 'about', 'facts', __( 'Facts / credentials', 'albina' ), 'repeater', array(
			'layout' => 'table', 'button_label' => __( 'Add fact', 'albina' ),
			'sub_fields' => array(
				albina_field_definition( 'about_fact', 'label', __( 'Label', 'albina' ) ),
				albina_field_definition( 'about_fact', 'value', __( 'Value', 'albina' ) ),
			),
		) ) ),
		'location' => array( $special_locations[0] ),
	) );

	acf_add_local_field_group( array(
		'key' => 'group_albina_services', 'title' => __( 'Services / proposal', 'albina' ),
		'fields' => array( albina_field_definition( 'services', 'services', __( 'Services / proposal items', 'albina' ), 'repeater', array(
			'layout' => 'block', 'button_label' => __( 'Add item', 'albina' ),
			'sub_fields' => array(
				albina_field_definition( 'service', 'title', __( 'Title', 'albina' ) ),
				albina_field_definition( 'service', 'description', __( 'Description', 'albina' ), 'textarea' ),
			),
		) ) ),
		'location' => array( $special_locations[1], $special_locations[3], $special_locations[4] ),
	) );

	acf_add_local_field_group( array(
		'key' => 'group_albina_contact', 'title' => __( 'Contact form', 'albina' ),
		'fields' => array(
			albina_field_definition( 'contact', 'form_id', __( 'Fluent Forms form ID', 'albina' ), 'number', array( 'min' => 1, 'step' => 1, 'instructions' => __( 'Create a form in Fluent Forms and enter its numeric ID. Leave empty to use a form block in the page editor.', 'albina' ) ) ),
			albina_field_definition( 'contact', 'contact_email', __( 'Public contact email', 'albina' ), 'email' ),
		),
		'location' => array( $special_locations[2] ),
	) );
}
