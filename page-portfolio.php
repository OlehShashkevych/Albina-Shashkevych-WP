<?php
/**
 * Template Name: Portfolio Page
 */

get_header();

?>

<main id="primary-content" class="site-main">

    <?php
// 1. Получаем данные для Hero секции заранее
$hero_title = get_field('port_hero_title');
$hero_desc = get_field('port_hero_desc');
$btn_text = get_field('port_hero_btn');
$btn_link = get_field('port_hero_btn_link');

// Проверяем: если есть Заголовок ИЛИ Описание ИЛИ (Кнопка + Ссылка), то выводим секцию
if ($hero_title || $hero_desc || ($btn_text && $btn_link)):
?>
    <section class="portfolio-hero fade-up">
        <div class="container">
            <div class="port-hero-content">
                
                <?php if ($hero_title): ?>
                    <h1 class="port-hero-title">
                        <?php echo esc_html($hero_title); ?>
                    </h1>
                <?php
    endif; ?>
                
                <?php if ($hero_desc): ?>
                    <div class="port-hero-desc">
                        <?php echo wp_kses_post($hero_desc); ?>
                    </div>
                <?php
    endif; ?>

                <?php if ($btn_text && $btn_link): ?>
                    <div class="port-hero-actions">
                        <a href="<?php echo esc_url($btn_link); ?>" class="hero-cta-btn">
                            <?php echo esc_html($btn_text); ?>
                        </a>
                    </div>
                <?php
    endif; ?>

            </div>
        </div>
    </section>
    <?php
endif; // Конец проверки Hero ?>


    <?php
// 2. Проверяем, есть ли картинки в галерее
if (have_rows('port_page_gallery')):
?>
    <section class="portfolio-grid fade-up">
        <div class="container">
    <div class="portfolio-regular-grid">
                
                <?php while (have_rows('port_page_gallery')):
        the_row();
        $image_id = get_sub_field('image');
?>
                    
                    <div class="grid-item">
                        <div class="grid-item__inner">
                            <?php echo wp_get_attachment_image($image_id, 'full', false, ['class' => 'grid-img']); ?>
                        </div>
                    </div>

                <?php
    endwhile; ?>

            </div>

        </div>
    </section>
    <?php
endif; // Конец проверки Grid (если пусто - секция вообще не выводится) ?>

</main>

<?php get_footer(); ?>