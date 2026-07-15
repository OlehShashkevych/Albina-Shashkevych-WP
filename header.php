<?php
/**
 * The header for our theme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container">
        <div class="site-header__inner">
            <div class="site-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo__text">
                    <?php bloginfo('name'); ?>
                </a>
            </div>

            <nav class="main-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'header_menu',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'menu_class'     => 'nav-list',
                    'fallback_cb'    => false,
                ));
                ?>
            </nav>

            <button class="burger-btn" aria-label="<?php _e('Toggle menu', 'photographer'); ?>">
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</header>

<div class="site-preloader">
    <div class="preloader-name">
        <?php echo esc_html(get_field('preloader_text', 'option') ?: get_bloginfo('name')); ?>
    </div>
    <div class="preloader-progress" aria-hidden="true">0%</div>
</div>