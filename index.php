<?php
get_header();
?>

<main id="primary-content" class="site-main">
    <section class="section">
        <div class="container">
            <?php if (have_posts()): ?>
                <?php while (have_posts()): the_post(); ?>
                    <article class="reveal">
                        <h1 class="section__title"><?php the_title(); ?></h1>
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <p><?php _e('Nothing found.', 'photographer'); ?></p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>