<footer class="site-footer">
    <div class="container">
        <div class="footer-inner">
            <?php if (have_rows('socials', 'option')): ?>
                <div class="footer-socials">
                    <?php while (have_rows('socials', 'option')): the_row(); ?>
                        <?php
                        $name = get_sub_field('name');
                        $url  = get_sub_field('url');
                        $icon = get_sub_field('icon');
                        ?>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($name); ?>">
                            <?php if ($icon): ?>
                                <?php echo $icon; ?>
                            <?php else: ?>
                                <span class="uppercase-label"><?php echo esc_html($name); ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>

            <div class="footer-bottom">
                <?php
                $privacy_url = get_privacy_policy_url();
                if ($privacy_url): ?>
                    <a href="<?php echo esc_url($privacy_url); ?>" class="footer-link">
                        <?php _e('Privacy Policy', 'photographer'); ?>
                    </a>
                <?php endif; ?>

                <span class="copyright-text">
                    &copy; <?php echo date('Y'); ?> <?php echo esc_html(get_field('footer_text', 'option') ?: 'All Rights Reserved'); ?> | <?php echo esc_html(get_bloginfo('name')); ?>
                </span>
            </div>
        </div>
    </div>
</footer>

<div id="lightbox" class="lightbox">
    <div class="lightbox-overlay"></div>
    
    <button class="lightbox-close" aria-label="Close">&times;</button>
    <button class="lightbox-prev" aria-label="Previous">&#10094;</button>
    
    <div class="lightbox-container">
        <img id="lightbox-img" src="" alt="Full view">
        <div class="lightbox-loader"></div>
    </div>
    
    <button class="lightbox-next" aria-label="Next">&#10095;</button>
</div>

<?php wp_footer(); ?>
</body>
</html>