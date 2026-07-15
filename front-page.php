<?php
/**
 * Template Name: Front Page
 */

get_header();

?>

<main id="primary-content" class="site-main">

    <?php
    $hero_name     = get_field('home_hero_name') ?: get_bloginfo('name');
    $hero_tagline  = get_field('home_hero_tagline') ?: 'Fashion & Editorial Photographer';
    $hero_subline  = get_field('home_hero_subline');
    $hero_images   = get_field('home_hero_images');
    ?>

    <!-- Hero -->
    <section class="hero section section--full" id="hero">
        <div class="hero__canvas-wrap">
            <canvas
                id="hero-canvas"
                class="hero__canvas"
                <?php if ($hero_images && !empty($hero_images)):
                    $hero_urls = array_filter(array_map(function ($id) {
                        $src = wp_get_attachment_image_src($id, 'hero');
                        return $src ? $src[0] : '';
                    }, $hero_images));
                    echo 'data-hero-images="' . esc_attr(json_encode(array_slice($hero_urls, 0, 12))) . '"';
                endif; ?>
            ></canvas>
        </div>
        <?php if ($hero_images && !empty($hero_images)) : ?>
            <div class="hero__fallback" aria-hidden="true">
                <?php foreach (array_slice($hero_images, 0, 3) as $img_id): ?>
                    <?php echo wp_get_attachment_image($img_id, 'large', false, array('class' => 'hero__fallback-img')); ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="hero__content">
            <span class="uppercase-label hero__label"><?php echo esc_html($hero_subline); ?></span>
            <h1 class="hero__title"><?php echo esc_html($hero_name); ?></h1>
            <p class="hero__tagline"><?php echo esc_html($hero_tagline); ?></p>
        </div>

        <div class="hero__scroll">
            <span class="uppercase-label"><?php _e('Scroll', 'photographer'); ?></span>
            <span class="hero__scroll-line" aria-hidden="true"></span>
        </div>
    </section>

    <!-- Selected Works -->
    <section class="section selected-works" id="selected-works">
        <div class="container">
            <header class="section__header reveal">
                <span class="uppercase-label"><?php _e('Selected Works', 'photographer'); ?></span>
                <h2 class="section__title"><?php _e('Portfolio', 'photographer'); ?></h2>
            </header>

            <?php
            $selected = get_field('home_selected_works');
            if (!$selected) {
                $selected = get_posts(array(
                    'post_type'      => 'portfolio',
                    'posts_per_page' => 6,
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC',
                ));
            }
            if ($selected):
            ?>
                <div class="selected-works__grid">
                    <?php foreach ($selected as $project): ?>
                        <?php
                        $pid = is_object($project) ? $project->ID : $project;
                        $title = get_the_title($pid);
                        $cover = get_field('project_cover', $pid);
                        $terms = get_the_terms($pid, 'portfolio_category');
                        $cat_name = $terms && !is_wp_error($terms) ? $terms[0]->name : '';
                        $link = get_permalink($pid);
                        ?>
                        <article class="project-card reveal" data-cursor="view">
                            <a href="<?php echo esc_url($link); ?>" class="project-card__link">
                                <?php if ($cover): ?>
                                    <?php echo wp_get_attachment_image($cover, 'large', false, array('class' => 'project-card__img')); ?>
                                <?php endif; ?>
                                <div class="project-card__meta">
                                    <?php if ($cat_name): ?>
                                        <span class="uppercase-label project-card__cat"><?php echo esc_html($cat_name); ?></span>
                                    <?php endif; ?>
                                    <h3 class="project-card__title"><?php echo esc_html($title); ?></h3>
                                </div>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div class="section__footer reveal">
                    <a href="<?php echo esc_url(get_post_type_archive_link('portfolio')); ?>" class="link-arrow">
                        <?php _e('View all portfolio', 'photographer'); ?> →
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- About teaser -->
    <section class="section section--light about-teaser" id="about-teaser">
        <div class="container">
            <div class="about-teaser__grid">
                <div class="about-teaser__content reveal">
                    <span class="uppercase-label">/<?php _e('About', 'photographer'); ?></span>
                    <h2 class="about-teaser__title"><?php echo esc_html(get_bloginfo('name')); ?></h2>
                    <?php if ($about_text = get_field('home_about_text')): ?>
                        <div class="about-teaser__text">
                            <?php echo wp_kses_post($about_text); ?>
                        </div>
                    <?php endif; ?>
                    <?php
                    $about_link = get_field('home_about_link');
                    if ($about_link):
                    ?>
                        <a href="<?php echo esc_url($about_link); ?>" class="link-arrow">
                            <?php echo esc_html(get_field('home_about_link_label') ?: __('Learn more', 'photographer')); ?> →
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Services teaser -->
    <section class="section services-teaser" id="services-teaser">
        <div class="container">
            <header class="section__header reveal">
                <span class="uppercase-label">/<?php _e('Services', 'photographer'); ?></span>
                <h2 class="section__title"><?php echo esc_html(get_field('home_services_title') ?: 'Services'); ?></h2>
            </header>

            <?php
            $services = get_posts(array(
                'post_type'      => 'service',
                'posts_per_page' => 3,
                'orderby'        => 'meta_value_num',
                'meta_key'       => 'service_order',
                'order'          => 'ASC',
            ));
            if ($services):
            ?>
                <div class="services-teaser__grid">
                    <?php foreach ($services as $service): ?>
                        <article class="service-card reveal">
                            <h3 class="service-card__title"><?php echo esc_html(get_the_title($service->ID)); ?></h3>
                            <?php if ($price = get_field('service_price', $service->ID)): ?>
                                <span class="service-card__price uppercase-label"><?php echo esc_html($price); ?></span>
                            <?php endif; ?>
                            <div class="service-card__excerpt">
                                <?php echo wp_kses_post(get_the_excerpt($service->ID)); ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <?php if ($services_link = get_field('home_services_link')): ?>
                    <div class="section__footer reveal">
                        <a href="<?php echo esc_url($services_link); ?>" class="link-arrow">
                            <?php _e('All services', 'photographer'); ?> →
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- Testimonials teaser -->
    <section class="section section--light testimonials-teaser" id="testimonials-teaser">
        <div class="container">
            <header class="section__header reveal">
                <span class="uppercase-label">/<?php _e('Testimonials', 'photographer'); ?></span>
                <h2 class="section__title"><?php echo esc_html(get_field('home_testimonials_title') ?: 'Clients say'); ?></h2>
            </header>

            <?php
            $testimonials = get_posts(array(
                'post_type'      => 'testimonial',
                'posts_per_page' => 3,
            ));
            if ($testimonials):
            ?>
                <div class="testimonials-teaser__grid">
                    <?php foreach ($testimonials as $t): ?>
                        <blockquote class="testimonial-card reveal">
                            <?php if ($text = get_field('testimonial_text', $t->ID)): ?>
                                <p class="testimonial-card__text"><?php echo esc_html($text); ?></p>
                            <?php endif; ?>
                            <footer class="testimonial-card__author">
                                <strong><?php echo esc_html(get_field('testimonial_author', $t->ID) ?: get_the_title($t->ID)); ?></strong>
                                <?php if ($company = get_field('testimonial_company', $t->ID)): ?>
                                    <span class="text-muted"> — <?php echo esc_html($company); ?></span>
                                <?php endif; ?>
                            </footer>
                        </blockquote>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Instagram placeholder -->
    <section class="section instagram-feed" id="instagram-feed">
        <div class="container">
            <header class="section__header reveal">
                <span class="uppercase-label">/Instagram</span>
                <h2 class="section__title"><?php _e('Latest on Instagram', 'photographer'); ?></h2>
            </header>
            <p class="reveal text-muted"><?php _e('Instagram feed will be connected in Phase 7.', 'photographer'); ?></p>
        </div>
    </section>

    <!-- CTA -->
    <section class="section cta-section" id="cta-section">
        <div class="container">
            <div class="cta-section__inner reveal text-center">
                <h2 class="cta-section__title"><?php echo esc_html(get_field('home_cta_text') ?: 'Ready to shoot?'); ?></h2>
                <?php if ($cta_link = get_field('home_cta_link')): ?>
                    <a href="<?php echo esc_url($cta_link); ?>" class="btn btn--accent">
                        <?php echo esc_html(get_field('home_cta_button') ?: 'Book a shoot'); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>