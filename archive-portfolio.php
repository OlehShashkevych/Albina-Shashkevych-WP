<?php
/**
 * Portfolio archive
 */

get_header();

$categories = get_terms(array(
    'taxonomy'   => 'portfolio_category',
    'hide_empty' => true,
));

$current_cat = get_queried_object();
$current_cat_id = ($current_cat && isset($current_cat->term_id)) ? $current_cat->term_id : 0;
?>

<main id="primary-content" class="site-main">
    <section class="section section--light portfolio-archive-hero">
        <div class="container">
            <header class="section__header reveal">
                <span class="uppercase-label">/<?php _e('Portfolio', 'photographer'); ?></span>
                <h1 class="section__title"><?php post_type_archive_title(); ?></h1>
            </header>

            <?php if ($categories && !is_wp_error($categories)): ?>
                <nav class="portfolio-filter reveal" aria-label="<?php _e('Portfolio categories', 'photographer'); ?>">
                    <a href="<?php echo esc_url(get_post_type_archive_link('portfolio')); ?>" class="portfolio-filter__link <?php echo $current_cat_id ? '' : 'is-active'; ?>" data-category="">
                        <?php _e('All', 'photographer'); ?>
                    </a>
                    <?php foreach ($categories as $cat): ?>
                        <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="portfolio-filter__link <?php echo ($current_cat_id === $cat->term_id) ? 'is-active' : ''; ?>" data-category="<?php echo esc_attr($cat->slug); ?>">
                            <?php echo esc_html($cat->name); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            <?php endif; ?>
        </div>
    </section>

    <section class="section portfolio-archive-grid">
        <div class="container">
            <?php if (have_posts()): ?>
                <div class="portfolio-grid">
                    <?php while (have_posts()): the_post(); ?>
                        <?php echo theme_portfolio_card(get_the_ID()); ?>
                    <?php endwhile; ?>
                </div>

                <?php the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => __('← Previous', 'photographer'),
                    'next_text' => __('Next →', 'photographer'),
                )); ?>
            <?php else: ?>
                <p class="reveal"><?php _e('No projects yet.', 'photographer'); ?></p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
get_footer();
