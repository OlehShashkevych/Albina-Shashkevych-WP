<?php
/**
 * Template Name: Contact Page
 */

get_header();

?>

<main id="primary-content" class="site-main">

    <section class="section contact-hero">
        <div class="container">
            <header class="section__header reveal">
                <span class="uppercase-label">/<?php _e('Contact', 'photographer'); ?></span>
                <h1 class="section__title"><?php echo esc_html(get_field('contact_title') ?: get_the_title()); ?></h1>
            </header>

            <?php if ($intro = get_field('contact_intro')): ?>
                <div class="contact-hero__intro reveal">
                    <?php echo wp_kses_post($intro); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="section section--light contact-content">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-info reveal">
                    <?php
                    $email = get_field('contact_email', 'option');
                    $phone = get_field('contact_phone', 'option');
                    $whatsapp = get_field('contact_whatsapp', 'option');
                    $telegram = get_field('contact_telegram', 'option');
                    ?>

                    <?php if ($email): ?>
                        <div class="contact-info__item">
                            <span class="uppercase-label text-muted"><?php _e('Email', 'photographer'); ?></span>
                            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                        </div>
                    <?php endif; ?>

                    <?php if ($phone): ?>
                        <div class="contact-info__item">
                            <span class="uppercase-label text-muted"><?php _e('Phone', 'photographer'); ?></span>
                            <a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a>
                        </div>
                    <?php endif; ?>

                    <?php if ($whatsapp || $telegram): ?>
                        <div class="contact-info__item">
                            <span class="uppercase-label text-muted"><?php _e('Messenger', 'photographer'); ?></span>
                            <?php if ($whatsapp): ?>
                                <a href="<?php echo esc_url($whatsapp); ?>" target="_blank" rel="noopener">WhatsApp</a>
                            <?php endif; ?>
                            <?php if ($telegram): ?>
                                <a href="<?php echo esc_url($telegram); ?>" target="_blank" rel="noopener">Telegram</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="contact-form-wrap reveal">
                    <?php if ($shortcode = get_field('contact_form_shortcode')): ?>
                        <?php echo do_shortcode($shortcode); ?>
                    <?php else: ?>
                        <form class="contact-form" id="contact-form" method="POST" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
                            <input type="hidden" name="action" value="theme_contact_form">
                            <?php wp_nonce_field('theme_contact_form', 'contact_nonce'); ?>

                            <div class="form-field">
                                <label for="contact-name"><?php _e('Name', 'photographer'); ?></label>
                                <input type="text" id="contact-name" name="name" required autocomplete="name">
                            </div>

                            <div class="form-field">
                                <label for="contact-email"><?php _e('Email or Phone', 'photographer'); ?></label>
                                <input type="text" id="contact-email" name="contact" required autocomplete="email">
                            </div>

                            <div class="form-field">
                                <label for="contact-type"><?php _e('Shoot type', 'photographer'); ?></label>
                                <select id="contact-type" name="type" required>
                                    <option value=""><?php _e('Select a service', 'photographer'); ?></option>
                                    <?php
                                    $services = get_posts(array('post_type' => 'service', 'posts_per_page' => -1));
                                    foreach ($services as $service): ?>
                                        <option value="<?php echo esc_attr($service->post_name); ?>"><?php echo esc_html(get_the_title($service->ID)); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-field">
                                <label for="contact-message"><?php _e('Message', 'photographer'); ?></label>
                                <textarea id="contact-message" name="message" rows="4"></textarea>
                            </div>

                            <button type="submit" class="btn btn--accent">
                                <?php _e('Send request', 'photographer'); ?>
                            </button>

                            <div class="contact-form__notice" role="status" aria-live="polite"></div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>