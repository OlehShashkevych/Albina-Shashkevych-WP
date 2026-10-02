<?php
defined( 'ABSPATH' ) || exit;

function albina_register_project_fields() {
	acf_add_local_field_group( array(
		'key' => 'group_albina_project', 'title' => __( 'Project details', 'albina' ),
		'fields' => array(
			albina_field_definition( 'project', 'client_name', __( 'Client / project name', 'albina' ) ),
			albina_field_definition( 'project', 'project_year', __( 'Year', 'albina' ), 'number', array( 'min' => 1900, 'max' => 2100, 'step' => 1 ) ),
			albina_field_definition( 'project', 'project_location', __( 'Location', 'albina' ) ),
			albina_credit_fields( 'project' ),
		),
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'project' ) ) ),
	) );
}
