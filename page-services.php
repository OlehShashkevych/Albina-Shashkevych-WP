<?php
/**
 * Template Name: Services
 */

get_header();

$intro   = get_field('services_intro');
$process = get_field('services_process');
$services = get_posts(array(
    'post_type'      => 'service',
    'posts_per_page' => -1,
    'orderby'        => 'meta_value_num',
    'meta_key'       => 'service_order',
    'order'          => 'ASC',
));
?>

<main id="primary-content" class="site-main">
    <section class="section services-hero">
        <div class="container">
            <header class="section__header reveal">
                <span class="uppercase-label">/<?php _e('Services', 'photographer'); ?></span>
                <h1 class="section__title"><?php the_title(); ?></h1>
            </header>

            <?php if ($intro): ?>
                <div class="services-hero__intro reveal">
                    <?php echo wp_kses_post($intro); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php if ($services): ?>
        <section class="section section--light services-list">
            <div class="container">
                <?php foreach ($services as $service): ?>
                    <?php
                    $price = get_field('service_price', $service->ID);
                    $duration = get_field('service_duration', $service->ID);
                    $includes = get_field('service_includes', $service->ID);
                    ?>
                    <article class="service-full reveal" id="service-<?php echo $service->post_name; ?>">
                        <div class="service-full__header">
                            <h2 class="service-full__title"><?php echo esc_html(get_the_title($service->ID)); ?></h2>
                            <?php if ($price): ?>
                                <span class="service-full__price uppercase-label"><?php echo esc_html($price); ?></span>
                            <?php endif; ?>
                        </div>

                        <?php if ($duration): ?>
                            <p class="service-full__duration text-muted"><?php echo esc_html($duration); ?></p>
                        <?php endif; ?>

                        <div class="service-full__content">
                            <?php echo wp_kses_post(get_the_content(null, false, $service->ID)); ?>
                        </div>

                        <?php if ($includes): ?>
                            <ul class="service-full__includes">
                                <?php foreach ($includes as $item): ?>
                                    <?php if (!empty($item['item'])): ?>
                                        <li><?php echo esc_html($item['item']); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($process): ?>
        <section class="section services-process">
            <div class="container">
                <h2 class="section__title reveal"><?php _e('How it works', 'photographer'); ?></h2>
                <div class="services-process__list">
                    <?php foreach ($process as $i => $row): ?>
                        <div class="services-process__step reveal">
                            <span class="services-process__num uppercase-label"><?php echo sprintf('%02d', $i + 1); ?></span>
                            <?php if (!empty($row['title'])): ?>
                                <h3 class="services-process__title"><?php echo esc_html($row['title']); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty($row['description'])): ?>
                                <p class="text-muted"><?php echo esc_html($row['description']); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
