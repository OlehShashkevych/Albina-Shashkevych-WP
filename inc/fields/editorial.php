<?php
defined( 'ABSPATH' ) || exit;

function albina_credit_fields( $scope, $name = 'credits' ) {
	return albina_field_definition( $scope, $name, __( 'Credits', 'albina' ), 'repeater', array(
		'layout' => 'table', 'button_label' => __( 'Add credit', 'albina' ),
		'sub_fields' => array(
			albina_field_definition( $scope . '_' . $name, 'role', __( 'Role', 'albina' ) ),
			albina_field_definition( $scope . '_' . $name, 'name', __( 'Name', 'albina' ) ),
			albina_field_definition( $scope . '_' . $name, 'url', __( 'URL', 'albina' ), 'url' ),
		),
	) );
}

function albina_editorial_field() {
	$labels = array(
		'fullscreen_image' => __( 'Fullscreen image', 'albina' ),
		'portrait_image' => __( 'Portrait image', 'albina' ),
		'two_column' => __( 'Two-column images', 'albina' ),
		'three_image' => __( 'Three-image composition', 'albina' ),
		'image_text' => __( 'Image and text', 'albina' ),
		'sticky_sequence' => __( 'Sticky image sequence', 'albina' ),
		'horizontal_strip' => __( 'Horizontal image strip', 'albina' ),
		'video' => __( 'Video', 'albina' ),
		'editorial_text' => __( 'Editorial text', 'albina' ),
		'credits' => __( 'Credits', 'albina' ),
	);
	$layouts = array();
	foreach ( $labels as $name => $label ) {
		$scope = 'block_' . $name;
		$fields = array();
		if ( in_array( $name, array( 'fullscreen_image', 'portrait_image', 'two_column', 'three_image', 'image_text' ), true ) ) {
			$fields[] = albina_field_definition( $scope, 'image', __( 'Image', 'albina' ), 'image', array( 'return_format' => 'id', 'preview_size' => 'medium', 'required' => 1 ) );
		}
		if ( in_array( $name, array( 'two_column', 'three_image' ), true ) ) {
			$fields[] = albina_field_definition( $scope, 'image_2', __( 'Second image', 'albina' ), 'image', array( 'return_format' => 'id', 'required' => 1 ) );
		}
		if ( 'three_image' === $name ) {
			$fields[] = albina_field_definition( $scope, 'image_3', __( 'Third image', 'albina' ), 'image', array( 'return_format' => 'id', 'required' => 1 ) );
		}
		if ( in_array( $name, array( 'sticky_sequence', 'horizontal_strip' ), true ) ) {
			$fields[] = albina_field_definition( $scope, 'images', __( 'Images', 'albina' ), 'gallery', array( 'return_format' => 'id', 'min' => 1 ) );
		}
		if ( in_array( $name, array( 'image_text', 'editorial_text' ), true ) ) {
			$fields[] = albina_field_definition( $scope, 'heading', __( 'Heading', 'albina' ) );
			$fields[] = albina_field_definition( $scope, 'text', __( 'Text', 'albina' ), 'wysiwyg', array( 'toolbar' => 'basic', 'media_upload' => 0 ) );
		}
		if ( 'video' === $name ) {
			$fields[] = albina_field_definition( $scope, 'video', __( 'Video file', 'albina' ), 'file', array( 'return_format' => 'id', 'mime_types' => 'mp4,webm', 'required' => 1 ) );
			$fields[] = albina_field_definition( $scope, 'poster', __( 'Poster image', 'albina' ), 'image', array( 'return_format' => 'id' ) );
			$fields[] = albina_field_definition( $scope, 'captions', __( 'Caption file (WebVTT)', 'albina' ), 'url', array( 'instructions' => __( 'URL of a hosted .vtt file in this page’s language, when the video contains speech.', 'albina' ) ) );
			$fields[] = albina_field_definition( $scope, 'transcript', __( 'Video transcript', 'albina' ), 'textarea' );
		}
		if ( 'credits' === $name ) {
			$fields[] = albina_credit_fields( $scope );
		} elseif ( ! in_array( $name, array( 'image_text', 'editorial_text' ), true ) ) {
			$fields[] = albina_field_definition( $scope, 'caption', __( 'Caption', 'albina' ), 'textarea', array( 'rows' => 2 ) );
		}
		$layouts[] = array( 'key' => 'layout_albina_' . $name, 'name' => $name, 'label' => $label, 'display' => 'block', 'sub_fields' => $fields );
	}
	return albina_field_definition( 'editorial', 'editorial_blocks', __( 'Editorial blocks', 'albina' ), 'flexible_content', array(
		'layouts' => $layouts, 'button_label' => __( 'Add editorial block', 'albina' ),
	) );
}
