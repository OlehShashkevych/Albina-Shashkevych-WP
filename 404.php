<?php
get_header();
?>

<main id="primary-content" class="site-main">
    <section class="section section--full text-center" style="display: flex; align-items: center; justify-content: center;">
        <div class="container">
            <span class="uppercase-label reveal">/<?php _e('404', 'photographer'); ?></span>
            <h1 class="section__title reveal"><?php _e('Page not found', 'photographer'); ?></h1>
            <p class="reveal text-muted"><?php _e('The page you are looking for does not exist.', 'photographer'); ?></p>
            <div class="reveal" style="margin-top: var(--space-md);">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn">
                    <?php _e('Back to home', 'photographer'); ?>
                </a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
