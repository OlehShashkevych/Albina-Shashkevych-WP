<?php
if (!function_exists('acf_add_local_field_group')) {
    return;
}

/**
 * Global theme options (contacts, socials, footer)
 */
acf_add_local_field_group(array(
    'key' => 'group_theme_options',
    'title' => __('Theme Options', 'photographer'),
    'fields' => array(
        array(
            'key' => 'field_to_contact_email',
            'label' => __('Email', 'photographer'),
            'name' => 'contact_email',
            'type' => 'email',
        ),
        array(
            'key' => 'field_to_contact_phone',
            'label' => __('Phone', 'photographer'),
            'name' => 'contact_phone',
            'type' => 'text',
        ),
        array(
            'key' => 'field_to_contact_whatsapp',
            'label' => __('WhatsApp link', 'photographer'),
            'name' => 'contact_whatsapp',
            'type' => 'url',
        ),
        array(
            'key' => 'field_to_contact_telegram',
            'label' => __('Telegram link', 'photographer'),
            'name' => 'contact_telegram',
            'type' => 'url',
        ),
        array(
            'key' => 'field_to_socials',
            'label' => __('Social Networks', 'photographer'),
            'name' => 'socials',
            'type' => 'repeater',
            'layout' => 'table',
            'button_label' => __('Add network', 'photographer'),
            'sub_fields' => array(
                array(
                    'key' => 'field_to_social_name',
                    'label' => __('Name', 'photographer'),
                    'name' => 'name',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_to_social_url',
                    'label' => __('URL', 'photographer'),
                    'name' => 'url',
                    'type' => 'url',
                ),
                array(
                    'key' => 'field_to_social_icon',
                    'label' => __('SVG icon (optional)', 'photographer'),
                    'name' => 'icon',
                    'type' => 'text',
                    'instructions' => __('Paste SVG code or use a class name.', 'photographer'),
                ),
            ),
        ),
        array(
            'key' => 'field_to_footer_text',
            'label' => __('Footer copyright text', 'photographer'),
            'name' => 'footer_text',
            'type' => 'text',
            'default_value' => 'All Rights Reserved',
        ),
        array(
            'key' => 'field_to_preloader_text',
            'label' => __('Preloader text', 'photographer'),
            'name' => 'preloader_text',
            'type' => 'text',
            'default_value' => get_bloginfo('name'),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'theme-general-settings',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'active' => true,
));
