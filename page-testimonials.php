<?php
/**
 * Template Name: Testimonials
 */

get_header();

$testimonials = get_posts(array(
    'post_type'      => 'testimonial',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
));

$types = array(
    'brand'   => __('Brands & Agencies', 'photographer'),
    'private' => __('Private Clients', 'photographer'),
);
?>

<main id="primary-content" class="site-main">
    <section class="section section--light testimonials-hero">
        <div class="container">
            <header class="section__header reveal">
                <span class="uppercase-label">/<?php _e('Testimonials', 'photographer'); ?></span>
                <h1 class="section__title"><?php the_title(); ?></h1>
            </header>
        </div>
    </section>

    <section class="section testimonials-list">
        <div class="container">
            <?php foreach ($types as $type_key => $type_label): ?>
                <?php
                $type_testimonials = array_filter($testimonials, function ($t) use ($type_key) {
                    return get_field('testimonial_type', $t->ID) === $type_key;
                });
                if (!$type_testimonials) continue;
                ?>
                <div class="testimonials-group">
                    <h2 class="testimonials-group__title uppercase-label reveal"><?php echo esc_html($type_label); ?></h2>
                    <div class="testimonials-group__grid">
                        <?php foreach ($type_testimonials as $t): ?>
                            <blockquote class="testimonial-card reveal">
                                <?php if ($photo = get_field('testimonial_photo', $t->ID)): ?>
                                    <?php echo wp_get_attachment_image($photo, 'thumbnail', false, array('class' => 'testimonial-card__photo')); ?>
                                <?php endif; ?>
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
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
