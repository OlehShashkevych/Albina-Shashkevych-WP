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

/** Separate desktop/mobile focal points; existing image field keys stay unchanged. */
function albina_crop_fields( $scope, $prefix ) {
	$fields = array( albina_field_definition( $scope, $prefix . '_mobile_image', __( 'Mobile image (optional)', 'albina' ), 'image', array(
		'return_format' => 'id', 'instructions' => __( 'Used up to 760px. Leave empty to use the desktop image.', 'albina' ),
	) ) );
	$labels = array(
		'_focus_x' => __( 'Desktop focus — horizontal', 'albina' ),
		'_focus_y' => __( 'Desktop focus — vertical', 'albina' ),
		'_mobile_focus_x' => __( 'Mobile focus — horizontal', 'albina' ),
		'_mobile_focus_y' => __( 'Mobile focus — vertical', 'albina' ),
	);
	foreach ( $labels as $suffix => $label ) {
		$fields[] = albina_field_definition( $scope, $prefix . $suffix, $label, 'range', array(
			'min' => 0, 'max' => 100, 'step' => 1, 'default_value' => 50, 'append' => '%',
			'wrapper' => array( 'width' => '50' ),
			'instructions' => __( '0 = left / top, 50 = center, 100 = right / bottom. Applies where the image is cropped.', 'albina' ),
		) );
	}
	return $fields;
}

function albina_register_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	albina_register_project_fields();
	albina_register_page_fields();
}
add_action( 'acf/init', 'albina_register_fields' );
