<?php
/**
 * Single portfolio project
 */

get_header();

if (have_posts()):
    while (have_posts()):
        the_post();

        $cover    = get_field('project_cover');
        $gallery  = get_field('project_gallery');
        $year     = get_field('project_year');
        $credits  = get_field('project_credits');
        $terms    = get_the_terms(get_the_ID(), 'portfolio_category');
        $cat_name = $terms && !is_wp_error($terms) ? $terms[0]->name : '';
        ?>

        <main id="primary-content" class="site-main">

            <section class="project-hero section section--full">
                <?php if ($cover): ?>
                    <div class="project-hero__media">
                        <?php echo wp_get_attachment_image($cover, 'full', false, array('class' => 'project-hero__img')); ?>
                    </div>
                <?php endif; ?>

                <div class="project-hero__content">
                    <span class="uppercase-label project-hero__cat"><?php echo esc_html($cat_name); ?></span>
                    <h1 class="project-hero__title"><?php the_title(); ?></h1>
                    <?php if ($year): ?>
                        <span class="project-hero__year"><?php echo esc_html($year); ?></span>
                    <?php endif; ?>
                </div>
            </section>

            <?php if ($gallery): ?>
                <section class="project-gallery">
                    <?php foreach ($gallery as $img_id): ?>
                        <figure class="project-gallery__item reveal">
                            <?php echo wp_get_attachment_image($img_id, 'full', false, array('class' => 'project-gallery__img')); ?>
                        </figure>
                    <?php endforeach; ?>
                </section>
            <?php endif; ?>

            <?php if ($credits && is_array($credits) && array_filter($credits)): ?>
                <section class="section project-credits">
                    <div class="container">
                        <h2 class="project-credits__title uppercase-label"><?php _e('Credits', 'photographer'); ?></h2>
                        <dl class="project-credits__list reveal">
                            <?php if (!empty($credits['model'])): ?>
                                <div class="project-credits__row">
                                    <dt class="uppercase-label"><?php _e('Model', 'photographer'); ?></dt>
                                    <dd><?php echo esc_html($credits['model']); ?></dd>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($credits['stylist'])): ?>
                                <div class="project-credits__row">
                                    <dt class="uppercase-label"><?php _e('Stylist', 'photographer'); ?></dt>
                                    <dd><?php echo esc_html($credits['stylist']); ?></dd>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($credits['mua'])): ?>
                                <div class="project-credits__row">
                                    <dt class="uppercase-label"><?php _e('MUA / Hair', 'photographer'); ?></dt>
                                    <dd><?php echo esc_html($credits['mua']); ?></dd>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($credits['brand'])): ?>
                                <div class="project-credits__row">
                                    <dt class="uppercase-label"><?php _e('Brand', 'photographer'); ?></dt>
                                    <dd><?php echo esc_html($credits['brand']); ?></dd>
                                </div>
                            <?php endif; ?>
                        </dl>
                    </div>
                </section>
            <?php endif; ?>

            <nav class="project-nav">
                <div class="container">
                    <?php
                    $next = get_next_post(true, '', 'portfolio_category');
                    if ($next):
                    ?>
                        <a href="<?php echo get_permalink($next->ID); ?>" class="project-nav__next link-arrow" data-cursor="next">
                            <?php _e('Next project', 'photographer'); ?> →
                        </a>
                    <?php endif; ?>
                </div>
            </nav>

        </main>

        <?php
    endwhile;
endif;

get_footer();
