<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * AJAX handlers
 */

function theme_handle_contact_form() {
    if (!wp_verify_nonce($_POST['contact_nonce'] ?? '', 'theme_contact_form')) {
        wp_send_json_error(array('message' => __('Security check failed.', 'photographer')));
    }

    $name    = sanitize_text_field($_POST['name'] ?? '');
    $contact = sanitize_text_field($_POST['contact'] ?? '');
    $type    = sanitize_text_field($_POST['type'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    if (empty($name) || empty($contact)) {
        wp_send_json_error(array('message' => __('Please fill in the required fields.', 'photographer')));
    }

    $to      = get_option('admin_email');
    $subject = sprintf(__('New booking request from %s', 'photographer'), $name);
    $body    = sprintf(
        "Name: %s\nContact: %s\nType: %s\n\nMessage:\n%s",
        $name,
        $contact,
        $type,
        $message
    );
    $headers = array('Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $contact);

    if (wp_mail($to, $subject, $body, $headers)) {
        wp_send_json_success(array('message' => __('Thank you. Your request has been sent.', 'photographer')));
    } else {
        wp_send_json_error(array('message' => __('Unable to send message. Please try again later.', 'photographer')));
    }
}
add_action('wp_ajax_theme_contact_form', 'theme_handle_contact_form');
add_action('wp_ajax_nopriv_theme_contact_form', 'theme_handle_contact_form');

/**
 * Portfolio filter AJAX
 */
function photographer_filter_portfolio() {
    if (!wp_verify_nonce($_POST['nonce'] ?? '', 'wp_rest')) {
        wp_send_json_error('Security check failed.', 403);
    }

    $category = sanitize_text_field($_POST['category'] ?? '');
    $args = array(
        'post_type'      => 'portfolio',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value_num',
        'meta_key'       => 'project_order',
        'order'          => 'ASC',
    );

    if ($category) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'portfolio_category',
                'field'    => 'slug',
                'terms'    => $category,
            ),
        );
    }

    $query = new WP_Query($args);
    $output = '';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $output .= theme_portfolio_card(get_the_ID());
        }
    } else {
        $output = '<p class="text-muted">' . __('No projects found.', 'photographer') . '</p>';
    }

    wp_reset_postdata();
    echo $output;
    wp_die();
}
add_action('wp_ajax_photographer_filter_portfolio', 'photographer_filter_portfolio');
add_action('wp_ajax_nopriv_photographer_filter_portfolio', 'photographer_filter_portfolio');
