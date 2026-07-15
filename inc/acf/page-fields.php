<?php
if (!function_exists('acf_add_local_field_group')) {
    return;
}

/**
 * ACF fields for page templates
 */

// Home page
acf_add_local_field_group(array(
    'key' => 'group_home_page',
    'title' => __('Home Page', 'photographer'),
    'fields' => array(
        array(
            'key' => 'field_home_hero_name',
            'label' => __('Hero name', 'photographer'),
            'name' => 'home_hero_name',
            'type' => 'text',
            'default_value' => get_bloginfo('name'),
        ),
        array(
            'key' => 'field_home_hero_tagline',
            'label' => __('Hero tagline', 'photographer'),
            'name' => 'home_hero_tagline',
            'type' => 'text',
            'default_value' => 'Fashion & Editorial Photographer',
        ),
        array(
            'key' => 'field_home_hero_subline',
            'label' => __('Hero subline / location', 'photographer'),
            'name' => 'home_hero_subline',
            'type' => 'text',
        ),
        array(
            'key' => 'field_home_hero_images',
            'label' => __('Hero images (for WebGL / fallback grid)', 'photographer'),
            'name' => 'home_hero_images',
            'type' => 'gallery',
            'return_format' => 'id',
            'preview_size' => 'medium',
            'min' => 1,
            'max' => 12,
        ),
        array(
            'key' => 'field_home_selected_works',
            'label' => __('Selected works', 'photographer'),
            'name' => 'home_selected_works',
            'type' => 'relationship',
            'post_type' => array('portfolio'),
            'filters' => array('search', 'taxonomy'),
            'elements' => array(),
            'min' => 0,
            'max' => 6,
            'return_format' => 'id',
        ),
        array(
            'key' => 'field_home_about_text',
            'label' => __('About teaser text', 'photographer'),
            'name' => 'home_about_text',
            'type' => 'textarea',
            'rows' => 3,
        ),
        array(
            'key' => 'field_home_about_link',
            'label' => __('About teaser link label', 'photographer'),
            'name' => 'home_about_link_label',
            'type' => 'text',
            'default_value' => 'Learn more',
        ),
        array(
            'key' => 'field_home_about_page',
            'label' => __('About teaser link page', 'photographer'),
            'name' => 'home_about_link',
            'type' => 'page_link',
            'post_type' => array('page'),
        ),
        array(
            'key' => 'field_home_services_title',
            'label' => __('Services teaser title', 'photographer'),
            'name' => 'home_services_title',
            'type' => 'text',
            'default_value' => 'Services',
        ),
        array(
            'key' => 'field_home_services_link',
            'label' => __('Services teaser link page', 'photographer'),
            'name' => 'home_services_link',
            'type' => 'page_link',
            'post_type' => array('page'),
        ),
        array(
            'key' => 'field_home_testimonials_title',
            'label' => __('Testimonials title', 'photographer'),
            'name' => 'home_testimonials_title',
            'type' => 'text',
            'default_value' => 'Clients say',
        ),
        array(
            'key' => 'field_home_cta_text',
            'label' => __('CTA text', 'photographer'),
            'name' => 'home_cta_text',
            'type' => 'text',
            'default_value' => 'Ready to shoot?',
        ),
        array(
            'key' => 'field_home_cta_button',
            'label' => __('CTA button label', 'photographer'),
            'name' => 'home_cta_button',
            'type' => 'text',
            'default_value' => 'Book a shoot',
        ),
        array(
            'key' => 'field_home_cta_link',
            'label' => __('CTA button link', 'photographer'),
            'name' => 'home_cta_link',
            'type' => 'page_link',
            'post_type' => array('page'),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'page_type',
                'operator' => '==',
                'value' => 'front_page',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'active' => true,
));

// About page
acf_add_local_field_group(array(
    'key' => 'group_about_page',
    'title' => __('About Page', 'photographer'),
    'fields' => array(
        array(
            'key' => 'field_about_hero_image',
            'label' => __('Hero portrait image', 'photographer'),
            'name' => 'about_hero_image',
            'type' => 'image',
            'return_format' => 'id',
            'preview_size' => 'large',
        ),
        array(
            'key' => 'field_about_bio',
            'label' => __('Biography', 'photographer'),
            'name' => 'about_bio',
            'type' => 'wysiwyg',
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 0,
        ),
        array(
            'key' => 'field_about_equipment',
            'label' => __('Equipment', 'photographer'),
            'name' => 'about_equipment',
            'type' => 'repeater',
            'layout' => 'table',
            'button_label' => __('Add item', 'photographer'),
            'sub_fields' => array(
                array(
                    'key' => 'field_about_equipment_item',
                    'label' => __('Item', 'photographer'),
                    'name' => 'item',
                    'type' => 'text',
                ),
            ),
        ),
        array(
            'key' => 'field_about_timeline',
            'label' => __('Timeline', 'photographer'),
            'name' => 'about_timeline',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => __('Add milestone', 'photographer'),
            'sub_fields' => array(
                array(
                    'key' => 'field_about_timeline_year',
                    'label' => __('Year', 'photographer'),
                    'name' => 'year',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_about_timeline_title',
                    'label' => __('Title', 'photographer'),
                    'name' => 'title',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_about_timeline_desc',
                    'label' => __('Description', 'photographer'),
                    'name' => 'description',
                    'type' => 'textarea',
                    'rows' => 2,
                ),
            ),
        ),
        array(
            'key' => 'field_about_clients',
            'label' => __('Client / brand logos', 'photographer'),
            'name' => 'about_clients',
            'type' => 'gallery',
            'return_format' => 'id',
            'preview_size' => 'thumbnail',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-about.php',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'active' => true,
));

// Services page
acf_add_local_field_group(array(
    'key' => 'group_services_page',
    'title' => __('Services Page', 'photographer'),
    'fields' => array(
        array(
            'key' => 'field_services_intro',
            'label' => __('Intro text', 'photographer'),
            'name' => 'services_intro',
            'type' => 'textarea',
            'rows' => 3,
        ),
        array(
            'key' => 'field_services_process',
            'label' => __('Process steps', 'photographer'),
            'name' => 'services_process',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => __('Add step', 'photographer'),
            'sub_fields' => array(
                array(
                    'key' => 'field_services_process_title',
                    'label' => __('Step title', 'photographer'),
                    'name' => 'title',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_services_process_desc',
                    'label' => __('Step description', 'photographer'),
                    'name' => 'description',
                    'type' => 'textarea',
                    'rows' => 2,
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-services.php',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'active' => true,
));

// Contact page
acf_add_local_field_group(array(
    'key' => 'group_contact_page',
    'title' => __('Contact Page', 'photographer'),
    'fields' => array(
        array(
            'key' => 'field_contact_title',
            'label' => __('Title', 'photographer'),
            'name' => 'contact_title',
            'type' => 'text',
            'default_value' => "Let's Connect",
        ),
        array(
            'key' => 'field_contact_intro',
            'label' => __('Intro text', 'photographer'),
            'name' => 'contact_intro',
            'type' => 'textarea',
            'rows' => 3,
        ),
        array(
            'key' => 'field_contact_form_shortcode',
            'label' => __('Contact form shortcode', 'photographer'),
            'name' => 'contact_form_shortcode',
            'type' => 'text',
            'instructions' => __('Paste CF7 or any shortcode. Leave empty to use the built-in AJAX form.', 'photographer'),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-contact.php',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'active' => true,
));
