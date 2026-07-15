<?php
/**
 * Template Name: About
 */

get_header();

$hero_image  = get_field('about_hero_image');
$bio         = get_field('about_bio');
$equipment   = get_field('about_equipment');
$timeline    = get_field('about_timeline');
$clients     = get_field('about_clients');
?>

<main id="primary-content" class="site-main">
    <section class="about-hero section">
        <div class="container">
            <header class="section__header reveal">
                <span class="uppercase-label">/<?php _e('About', 'photographer'); ?></span>
                <h1 class="section__title"><?php the_title(); ?></h1>
            </header>
        </div>

        <?php if ($hero_image): ?>
            <div class="about-hero__media reveal">
                <?php echo wp_get_attachment_image($hero_image, 'full', false, array('class' => 'about-hero__img')); ?>
            </div>
        <?php endif; ?>
    </section>

    <?php if ($bio): ?>
        <section class="section section--light about-bio">
            <div class="container">
                <div class="about-bio__text reveal">
                    <?php echo wp_kses_post($bio); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($equipment): ?>
        <section class="section about-equipment">
            <div class="container">
                <h2 class="section__title reveal"><?php _e('Equipment', 'photographer'); ?></h2>
                <ul class="about-equipment__list">
                    <?php foreach ($equipment as $item): ?>
                        <?php if (!empty($item['item'])): ?>
                            <li class="about-equipment__item reveal"><?php echo esc_html($item['item']); ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($timeline): ?>
        <section class="section section--light about-timeline">
            <div class="container">
                <h2 class="section__title reveal"><?php _e('Timeline', 'photographer'); ?></h2>
                <div class="about-timeline__list">
                    <?php foreach ($timeline as $row): ?>
                        <div class="about-timeline__item reveal">
                            <?php if (!empty($row['year'])): ?>
                                <span class="uppercase-label"><?php echo esc_html($row['year']); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($row['title'])): ?>
                                <h3 class="about-timeline__title"><?php echo esc_html($row['title']); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty($row['description'])): ?>
                                <p><?php echo esc_html($row['description']); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($clients): ?>
        <section class="section about-clients">
            <div class="container">
                <h2 class="section__title reveal"><?php _e('Clients', 'photographer'); ?></h2>
                <div class="clients-grid">
                    <?php foreach ($clients as $img_id): ?>
                        <div class="client-item reveal">
                            <?php echo wp_get_attachment_image($img_id, 'medium'); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
