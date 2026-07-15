<?php
get_header();
?>

<main id="primary-content" class="site-main">
    <section class="section section--light">
        <div class="container">
            <article class="reveal">
                <span class="uppercase-label">/<?php _e('Page', 'photographer'); ?></span>
                <h1 class="section__title"><?php the_title(); ?></h1>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        </div>
    </section>
</main>

<?php get_footer(); ?>
