<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Reusable helper functions
 */

/**
 * Render a single portfolio project card.
 *
 * @param WP_Post|int $post Post object or ID.
 * @return string
 */
function theme_portfolio_card($post) {
    $post = get_post($post);
    if (!$post) return '';

    $cover = get_field('project_cover', $post->ID);
    $terms = get_the_terms($post->ID, 'portfolio_category');
    $cat_name = $terms && !is_wp_error($terms) ? $terms[0]->name : '';
    $year = get_field('project_year', $post->ID);

    ob_start();
    ?>
    <article class="project-card project-card--archive reveal" data-cursor="view">
        <a href="<?php echo get_permalink($post->ID); ?>" class="project-card__link">
            <?php if ($cover): ?>
                <?php echo wp_get_attachment_image($cover, 'large', false, array('class' => 'project-card__img')); ?>
            <?php endif; ?>
            <div class="project-card__meta">
                <?php if ($cat_name): ?>
                    <span class="uppercase-label project-card__cat"><?php echo esc_html($cat_name); ?></span>
                <?php endif; ?>
                <h2 class="project-card__title"><?php echo esc_html(get_the_title($post->ID)); ?></h2>
                <?php if ($year): ?>
                    <span class="project-card__year"><?php echo esc_html($year); ?></span>
                <?php endif; ?>
            </div>
        </a>
    </article>
    <?php
    return ob_get_clean();
}

/**
 * Get an array of portfolio category filter links.
 *
 * @return array
 */
function theme_portfolio_categories() {
    return get_terms(array(
        'taxonomy'   => 'portfolio_category',
        'hide_empty' => true,
    ));
}
