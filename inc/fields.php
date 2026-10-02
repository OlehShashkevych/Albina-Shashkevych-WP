<?php
defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/fields/editorial.php';
require_once __DIR__ . '/fields/projects.php';
require_once __DIR__ . '/fields/pages.php';

/** Small definition helper; keys remain deterministic and scoped to their group/layout. */
function albina_field_definition( $scope, $name, $label, $type = 'text', $options = array() ) {
	return array_merge( array(
		'key' => 'field_albina_' . $scope . '_' . $name,
		'name' => $name,
		'label' => $label,
		'type' => $type,
	), $options );
}

function albina_register_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	albina_register_project_fields();
	albina_register_page_fields();
}
add_action( 'acf/init', 'albina_register_fields' );
