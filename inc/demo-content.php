<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Demo content installer.
 * Creates sample portfolio, service, testimonial and page content.
 * Runs once on theme activation or first admin visit.
 * Delete the 'theme_demo_content_installed' option to re-run.
 */

function theme_get_demo_image($label, $width, $height, $bg = '222222') {
    if (!function_exists('media_sideload_image')) {
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
    }

    $url = sprintf('https://placehold.co/%1$dx%2$d/%3$s/fff.png?text=%4$s', $width, $height, $bg, rawurlencode($label));
    $id = media_sideload_image($url, 0, '', 'id');

    if (is_int($id)) {
        return $id;
    }

    return theme_generate_placeholder_image($label, $width, $height, $bg);
}

function theme_generate_placeholder_image($label, $width, $height, $bg = '222222') {
    if (!function_exists('imagecreatetruecolor')) {
        return false;
    }

    $upload_dir = wp_upload_dir();
    $filename   = sanitize_file_name('demo-' . $label . '-' . $width . 'x' . $height . '.png');
    $filepath   = $upload_dir['path'] . '/' . $filename;

    $image = imagecreatetruecolor($width, $height);
    imagealphablending($image, false);
    imagesavealpha($image, true);

    $bg_rgb = array_map('hexdec', str_split($bg, 2));
    $bg_color = imagecolorallocate($image, $bg_rgb[0], $bg_rgb[1], $bg_rgb[2]);
    imagefill($image, 0, 0, $bg_color);

    $white = imagecolorallocate($image, 255, 255, 255);
    $text  = substr($label, 0, 20);
    $font  = 5;
    $x     = 20;
    $y     = 20;
    imagestring($image, $font, $x, $y, $text, $white);

    imagepng($image, $filepath);
    imagedestroy($image);

    $filetype = wp_check_filetype($filename, array('png' => 'image/png'));
    $attachment = array(
        'post_title'     => sanitize_text_field($label),
        'post_content'   => '',
        'post_status'    => 'inherit',
        'post_mime_type' => $filetype['type'],
    );

    $attach_id = wp_insert_attachment($attachment, $filepath, 0);
    if (is_wp_error($attach_id)) {
        return false;
    }

    require_once ABSPATH . 'wp-admin/includes/image.php';
    $attach_data = wp_generate_attachment_metadata($attach_id, $filepath);
    wp_update_attachment_metadata($attach_id, $attach_data);

    return $attach_id;
}

function theme_create_demo_content() {
    if (get_option('theme_demo_content_installed')) {
        return;
    }

    if (!function_exists('update_field')) {
        return;
    }

    // ---------- IMAGES ----------
    $covers = array();
    for ($i = 1; $i <= 6; $i++) {
        $covers[] = theme_get_demo_image('Demo ' . $i, 800, 1000, '222222');
    }

    $gallery = array();
    for ($i = 1; $i <= 4; $i++) {
        $gallery[] = theme_get_demo_image('Gallery ' . $i, 1200, 800, '333333');
    }

    $hero_images = array_slice($covers, 0, 3);
    $about_image = theme_get_demo_image('About', 800, 1000, '444444');
    $avatar      = theme_get_demo_image('Avatar', 200, 200, '555555');
    $client_logos = array();
    for ($i = 1; $i <= 3; $i++) {
        $client_logos[] = theme_get_demo_image('Client ' . $i, 200, 80, '666666');
    }

    // ---------- TERMS ----------
    $terms = array('Fashion', 'Beauty', 'Editorial');
    $term_ids = array();
    foreach ($terms as $term) {
        $existing = get_term_by('name', $term, 'portfolio_category');
        if ($existing) {
            $term_ids[$term] = $existing->term_id;
        } else {
            $result = wp_insert_term($term, 'portfolio_category');
            if (!is_wp_error($result)) {
                $term_ids[$term] = $result['term_id'];
            }
        }
    }

    // ---------- PORTFOLIO ----------
    $portfolio_data = array(
        array('title' => 'Golden Hour Editorial', 'cat' => 'Fashion', 'year' => '2024'),
        array('title' => 'Urban Noir',            'cat' => 'Fashion', 'year' => '2023'),
        array('title' => 'Soft Beauty',           'cat' => 'Beauty',  'year' => '2023'),
        array('title' => 'Magazine Cover',        'cat' => 'Editorial','year' => '2024'),
        array('title' => 'Black & White',         'cat' => 'Fashion', 'year' => '2022'),
        array('title' => 'Spring Campaign',       'cat' => 'Beauty',  'year' => '2024'),
    );

    $portfolio_ids = array();
    foreach ($portfolio_data as $i => $data) {
        $post_id = wp_insert_post(array(
            'post_title'   => $data['title'],
            'post_name'    => sanitize_title($data['title']),
            'post_type'    => 'portfolio',
            'post_status'  => 'publish',
            'post_content' => '<p>Demo project description for ' . esc_html($data['title']) . '.</p>',
            'menu_order'   => $i,
        ));

        if (is_wp_error($post_id)) {
            continue;
        }

        $portfolio_ids[] = $post_id;

        update_field('project_cover',   $covers[$i % count($covers)], $post_id);
        update_field('project_gallery', $gallery, $post_id);
        update_field('project_year',    $data['year'], $post_id);
        update_field('project_order',   $i, $post_id);
        update_field('project_credits', array(
            'model'   => 'Demo Model',
            'stylist' => 'Demo Stylist',
            'mua'     => 'Demo MUA',
            'brand'   => 'Demo Brand',
        ), $post_id);

        if (isset($term_ids[$data['cat']])) {
            wp_set_object_terms($post_id, $term_ids[$data['cat']], 'portfolio_category');
        }
    }

    // ---------- SERVICES ----------
    $services_data = array(
        array(
            'title'    => 'Editorial Photoshoot',
            'price'    => 'from $800',
            'duration' => '4 hours',
            'includes' => array('Concept & moodboard', 'Studio rent', 'Color grading', '20 retouched photos'),
            'order'    => 1,
        ),
        array(
            'title'    => 'Beauty & Portrait',
            'price'    => 'from $500',
            'duration' => '2 hours',
            'includes' => array('Makeup artist', 'Studio or location', '10 retouched photos', 'Online gallery'),
            'order'    => 2,
        ),
        array(
            'title'    => 'Lookbook / E-commerce',
            'price'    => 'from $1,200',
            'duration' => '6 hours',
            'includes' => array('Styling support', 'Model casting', '50 retouched photos', 'Commercial license'),
            'order'    => 3,
        ),
    );

    $service_ids = array();
    foreach ($services_data as $data) {
        $post_id = wp_insert_post(array(
            'post_title'  => $data['title'],
            'post_name'   => sanitize_title($data['title']),
            'post_type'   => 'service',
            'post_status' => 'publish',
            'post_excerpt' => 'Demo service description for ' . $data['title'] . '.',
        ));

        if (is_wp_error($post_id)) {
            continue;
        }

        $service_ids[] = $post_id;

        update_field('service_price',    $data['price'], $post_id);
        update_field('service_duration', $data['duration'], $post_id);
        update_field('service_order',    $data['order'], $post_id);

        $includes = array();
        foreach ($data['includes'] as $item) {
            $includes[] = array('item' => $item);
        }
        update_field('service_includes', $includes, $post_id);
    }

    // ---------- TESTIMONIALS ----------
    $testimonials_data = array(
        array(
            'author'  => 'Anna Volkova',
            'company' => 'Vogue UA',
            'text'    => 'Albina delivered an incredible editorial series. Every frame had the emotion and light we were looking for.',
            'type'    => 'brand',
        ),
        array(
            'author'  => 'Diana K.',
            'company' => '',
            'text'    => 'I felt so comfortable during the shoot. The portraits turned out elegant and natural.',
            'type'    => 'private',
        ),
        array(
            'author'  => 'Maksim Brand',
            'company' => 'M.B. Atelier',
            'text'    => 'Professional, fast, and the final images perfectly matched our brand identity.',
            'type'    => 'brand',
        ),
        array(
            'author'  => 'Sofia L.',
            'company' => '',
            'text'    => 'Beautiful light, great atmosphere, and stunning retouching. Highly recommended.',
            'type'    => 'private',
        ),
    );

    foreach ($testimonials_data as $data) {
        $post_id = wp_insert_post(array(
            'post_title'  => $data['author'],
            'post_name'   => sanitize_title($data['author']),
            'post_type'   => 'testimonial',
            'post_status' => 'publish',
        ));

        if (is_wp_error($post_id)) {
            continue;
        }

        update_field('testimonial_author',  $data['author'], $post_id);
        update_field('testimonial_company', $data['company'], $post_id);
        update_field('testimonial_text',    $data['text'], $post_id);
        update_field('testimonial_type',    $data['type'], $post_id);
        update_field('testimonial_photo',   $avatar, $post_id);
    }

    // ---------- PAGES ----------
    $pages = array(
        'about'        => array('title' => 'About',        'template' => 'page-about.php'),
        'services'     => array('title' => 'Services',     'template' => 'page-services.php'),
        'testimonials' => array('title' => 'Testimonials', 'template' => 'page-testimonials.php'),
        'contact'      => array('title' => 'Contact',      'template' => 'page-contact.php'),
    );

    $page_ids = array();
    foreach ($pages as $slug => $data) {
        $existing = get_page_by_path($slug, OBJECT, 'page');
        if ($existing) {
            $page_ids[$slug] = $existing->ID;
            update_post_meta($existing->ID, '_wp_page_template', $data['template']);
        } else {
            $page_id = wp_insert_post(array(
                'post_title'  => $data['title'],
                'post_name'   => $slug,
                'post_type'   => 'page',
                'post_status' => 'publish',
            ));
            if (!is_wp_error($page_id)) {
                update_post_meta($page_id, '_wp_page_template', $data['template']);
                $page_ids[$slug] = $page_id;
            }
        }
    }

    if (!empty($page_ids['about'])) {
        update_field('about_hero_image', $about_image, $page_ids['about']);
        update_field('about_bio', '<p>Albina is a fashion and editorial photographer based in Kyiv. With over 10 years of experience, she creates bold, light-driven stories for magazines, brands and private clients.</p>', $page_ids['about']);
        update_field('about_equipment', array(
            array('item' => 'Canon EOS R5'),
            array('item' => 'RF 85mm f/1.2'),
            array('item' => 'Profoto lighting'),
            array('item' => 'Medium format film option'),
        ), $page_ids['about']);
        update_field('about_timeline', array(
            array('year' => '2014', 'title' => 'Started career', 'description' => 'Assisted leading fashion photographers in Kyiv.'),
            array('year' => '2018', 'title' => 'First Vogue cover', 'description' => 'Published an editorial cover story.'),
            array('year' => '2024', 'title' => 'Studio opening', 'description' => 'Opened a private studio for portrait and beauty work.'),
        ), $page_ids['about']);
        update_field('about_clients', $client_logos, $page_ids['about']);
    }

    if (!empty($page_ids['services'])) {
        update_field('services_intro', 'From editorial campaigns to intimate portraits, every service is tailored to your vision.', $page_ids['services']);
        update_field('services_process', array(
            array('title' => 'Brief', 'description' => 'We discuss mood, references, styling and location.'),
            array('title' => 'Shoot', 'description' => 'A relaxed and guided session with professional lighting.'),
            array('title' => 'Retouch', 'description' => 'Careful color grading and retouching within 7-14 days.'),
            array('title' => 'Delivery', 'description' => 'High-resolution files via a private online gallery.'),
        ), $page_ids['services']);
    }

    if (!empty($page_ids['contact'])) {
        update_field('contact_title', 'Let\'s Connect', $page_ids['contact']);
        update_field('contact_intro', 'Tell me about your project, deadline and budget. I will get back to you within 24 hours.', $page_ids['contact']);
        update_field('contact_form_shortcode', '', $page_ids['contact']);
    }

    // ---------- HOME PAGE ----------
    $home_page = get_pages(array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'front-page.php',
        'number'     => 1,
    ));

    if ($home_page) {
        $home_id = $home_page[0]->ID;
    } else {
        $home_id = wp_insert_post(array(
            'post_title'  => 'Home',
            'post_name'   => 'home',
            'post_type'   => 'page',
            'post_status' => 'publish',
        ));
        if (!is_wp_error($home_id)) {
            update_post_meta($home_id, '_wp_page_template', 'front-page.php');
            if (!get_option('page_on_front')) {
                update_option('show_on_front', 'page');
                update_option('page_on_front', $home_id);
            }
        }
    }

    if (!is_wp_error($home_id)) {
        update_field('home_hero_name',     get_bloginfo('name'), $home_id);
        update_field('home_hero_tagline',  'Fashion & Editorial Photographer', $home_id);
        update_field('home_hero_subline',  'Kyiv / Worldwide', $home_id);
        update_field('home_hero_images',   $hero_images, $home_id);
        update_field('home_selected_works', $portfolio_ids, $home_id);
        update_field('home_about_text',    'A fashion photographer with an eye for light, contrast and authentic emotion.', $home_id);
        update_field('home_about_link_label', 'Learn more', $home_id);
        if (!empty($page_ids['about'])) {
            update_field('home_about_link',   get_permalink($page_ids['about']), $home_id);
        }
        update_field('home_services_title', 'Services', $home_id);
        if (!empty($page_ids['services'])) {
            update_field('home_services_link', get_permalink($page_ids['services']), $home_id);
        }
        update_field('home_testimonials_title', 'Clients say', $home_id);
        update_field('home_cta_text',    'Ready to shoot?', $home_id);
        update_field('home_cta_button',  'Book a shoot', $home_id);
        if (!empty($page_ids['contact'])) {
            update_field('home_cta_link', get_permalink($page_ids['contact']), $home_id);
        }
    }

    // ---------- THEME OPTIONS ----------
    update_field('contact_email',    'hello@albina.example', 'option');
    update_field('contact_phone',    '+380 99 000 00 00', 'option');
    update_field('contact_whatsapp', 'https://wa.me/380990000000', 'option');
    update_field('contact_telegram', 'https://t.me/albina_example', 'option');
    update_field('footer_text',      'All Rights Reserved', 'option');
    update_field('preloader_text',   get_bloginfo('name'), 'option');
    update_field('socials', array(
        array('name' => 'Instagram', 'url' => 'https://instagram.com/albina.example', 'icon' => ''),
        array('name' => 'Facebook',  'url' => 'https://facebook.com/albina.example',  'icon' => ''),
        array('name' => 'Behance',   'url' => 'https://behance.net/albina.example',   'icon' => ''),
        array('name' => 'Pinterest', 'url' => 'https://pinterest.com/albina.example', 'icon' => ''),
    ), 'option');

    update_option('theme_demo_content_installed', true);
}

function theme_maybe_create_demo_content() {
    if (get_option('theme_demo_content_installed')) {
        return;
    }
    if (!current_user_can('manage_options')) {
        return;
    }
    theme_create_demo_content();
}

add_action('after_switch_theme', 'theme_create_demo_content');
add_action('admin_init', 'theme_maybe_create_demo_content');
