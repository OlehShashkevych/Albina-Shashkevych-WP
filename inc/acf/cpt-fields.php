<?php
if (!function_exists('acf_add_local_field_group')) {
    return;
}

/**
 * ACF fields for custom post types
 */

// Portfolio Project
acf_add_local_field_group(array(
    'key' => 'group_portfolio_project',
    'title' => __('Project Details', 'photographer'),
    'fields' => array(
        array(
            'key' => 'field_port_project_cover',
            'label' => __('Cover Image', 'photographer'),
            'name' => 'project_cover',
            'type' => 'image',
            'return_format' => 'id',
            'preview_size' => 'large',
            'required' => 1,
        ),
        array(
            'key' => 'field_port_project_gallery',
            'label' => __('Project Gallery', 'photographer'),
            'name' => 'project_gallery',
            'type' => 'gallery',
            'return_format' => 'id',
            'preview_size' => 'medium',
            'insert' => 'append',
            'library' => 'all',
            'min' => 1,
        ),
        array(
            'key' => 'field_port_project_year',
            'label' => __('Year', 'photographer'),
            'name' => 'project_year',
            'type' => 'text',
            'default_value' => date('Y'),
        ),
        array(
            'key' => 'field_port_project_credits',
            'label' => __('Credits', 'photographer'),
            'name' => 'project_credits',
            'type' => 'group',
            'layout' => 'block',
            'sub_fields' => array(
                array(
                    'key' => 'field_port_credit_model',
                    'label' => __('Model', 'photographer'),
                    'name' => 'model',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_port_credit_stylist',
                    'label' => __('Stylist', 'photographer'),
                    'name' => 'stylist',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_port_credit_mua',
                    'label' => __('MUA / Hair', 'photographer'),
                    'name' => 'mua',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_port_credit_brand',
                    'label' => __('Brand / Magazine', 'photographer'),
                    'name' => 'brand',
                    'type' => 'text',
                ),
            ),
        ),
        array(
            'key' => 'field_port_project_order',
            'label' => __('Order', 'photographer'),
            'name' => 'project_order',
            'type' => 'number',
            'default_value' => 0,
            'instructions' => __('Lower numbers appear first.', 'photographer'),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'portfolio',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'hide_on_screen' => array(),
    'active' => true,
));

// Service
acf_add_local_field_group(array(
    'key' => 'group_service',
    'title' => __('Service Details', 'photographer'),
    'fields' => array(
        array(
            'key' => 'field_service_price',
            'label' => __('Price / "from" price', 'photographer'),
            'name' => 'service_price',
            'type' => 'text',
            'instructions' => __('Leave empty for "price on request".', 'photographer'),
        ),
        array(
            'key' => 'field_service_duration',
            'label' => __('Duration', 'photographer'),
            'name' => 'service_duration',
            'type' => 'text',
        ),
        array(
            'key' => 'field_service_includes',
            'label' => __('What is included', 'photographer'),
            'name' => 'service_includes',
            'type' => 'repeater',
            'layout' => 'table',
            'button_label' => __('Add item', 'photographer'),
            'sub_fields' => array(
                array(
                    'key' => 'field_service_include_item',
                    'label' => __('Item', 'photographer'),
                    'name' => 'item',
                    'type' => 'text',
                ),
            ),
        ),
        array(
            'key' => 'field_service_order',
            'label' => __('Order', 'photographer'),
            'name' => 'service_order',
            'type' => 'number',
            'default_value' => 0,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'service',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'active' => true,
));

// Testimonial
acf_add_local_field_group(array(
    'key' => 'group_testimonial',
    'title' => __('Testimonial Details', 'photographer'),
    'fields' => array(
        array(
            'key' => 'field_testimonial_author',
            'label' => __('Author Name', 'photographer'),
            'name' => 'testimonial_author',
            'type' => 'text',
            'required' => 1,
        ),
        array(
            'key' => 'field_testimonial_company',
            'label' => __('Company / Brand', 'photographer'),
            'name' => 'testimonial_company',
            'type' => 'text',
        ),
        array(
            'key' => 'field_testimonial_photo',
            'label' => __('Author Photo / Logo', 'photographer'),
            'name' => 'testimonial_photo',
            'type' => 'image',
            'return_format' => 'id',
            'preview_size' => 'thumbnail',
        ),
        array(
            'key' => 'field_testimonial_text',
            'label' => __('Testimonial Text', 'photographer'),
            'name' => 'testimonial_text',
            'type' => 'textarea',
            'rows' => 5,
            'required' => 1,
        ),
        array(
            'key' => 'field_testimonial_type',
            'label' => __('Client Type', 'photographer'),
            'name' => 'testimonial_type',
            'type' => 'select',
            'choices' => array(
                'brand' => __('Brand / Agency', 'photographer'),
                'private' => __('Private Client', 'photographer'),
            ),
            'default_value' => 'private',
            'allow_null' => 0,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'testimonial',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'active' => true,
));
