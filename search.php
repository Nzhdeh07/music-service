<?php get_header(); ?>


<div class="flex flex-col min-h-full">

    <!-- Шапка для десктопа -->
    <div id="header"
         class="block mobileLandscape:hidden sticky top-0 z-50 border-b border-solid border-transparent transition-all duration-300 bg-customWhite-main">
        <?php get_template_part('module/header', null, array()); ?>
    </div>

    <!-- Шапка  для мобильных устройств-->
    <div id="header-mobile"
         class="hidden mobileLandscape:flex sticky top-0 z-50 border-b border-solid border-transparent transition-all duration-300 bg-customWhite-main">
        <?php get_template_part('module/header-mobile', null, array()); ?>
    </div>

    <!-- Основной контент -->
    <div class="flex-grow grid gap-10 px-5 mobileLandscape:px-2.5 py-5 mobileLandscape:py-2.5">
        <div class="grid gap-2.5">
            <!-- Хлебные крошки (Yoast SEO) -->
            <?php if (function_exists('yoast_breadcrumb')): ?>
                <div class="font-normal text-[14px] leading-5 text-breadcrumb">
                    <?php yoast_breadcrumb('<p id="breadcrumbs" class="breadcrumbs">', '</p>'); ?>
                </div>
            <?php endif; ?>

            <?php if (have_posts()) : ?>
            <!-- Товары по категории -->
            <div class="flex flex-col gap-10">

                <!-- Товары по данной категории -->
                <div class="grid grid-cols-6 ultraWideDesktop:grid-cols-5 wideDesktop:grid-cols-4 desktop:grid-cols-3 mobileLandscape:grid-cols-2 gap-2.5">
                    <?php
                    if (have_posts()) :
                        while (have_posts()) : the_post();
                            // Получаем данные из ACF полей
                            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            $description = get_the_content();
                            $weight = get_field('weight');
                            $price = get_field('price');
                            $discount_price = get_field('discount-price');
                            $count = get_field('count');
                            $tags = get_the_terms(get_the_ID(), 'post_tag');

                            $tag_image_urls = [];
                            if ($tags && !is_wp_error($tags)) {
                                foreach ($tags as $tag) {
                                    $image_id = get_term_meta($tag->term_id, '_thumbnail_id', true);
                                    $tag_image_urls[] = wp_get_attachment_image_url($image_id, 'full');
                                }
                            }
                            ?>

                            <div class=" flex flex-col justify-between gap-2 p-1.5 rounded-md bg-white">
                                <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>">
                                    <img class="h-[127px] w-full object-contain"
                                         src="<?php echo esc_url($image_url); ?>"
                                         alt="<?php the_title(); ?>" loading="lazy">
                                </a>


                                <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>">
                                    <p class="font-medium text-sm leading-5 text-black"><?php the_title(); ?></p>
                                </a>

                                <div class="flex flex-col gap-2">
                                    <?php $price = get_field('post-price'); ?>
                                    <?php $discount_price = get_field('post-discounted-price'); ?>
                                    <?php if ($price): ?>
                                        <div class="flex  gap-2.5">
                                            <?php if (!empty($discount_price)) : ?>
                                                <p class="font-medium leading-5 text-black">
                                                    <?php echo esc_html($discount_price); ?> BYN
                                                </p>
                                                <del class="font-medium leading-5 text-sm text-black text-customGreen-dark">
                                                    <?php echo esc_html($price); ?> BYN
                                                </del>
                                            <?php else : ?>
                                                <p class="font-medium leading-5 text-black">
                                                    <?php echo esc_html($price); ?> BYN
                                                </p>
                                            <?php endif; ?>
                                        </div>


                                        <div class="flex justify-between items-end">
                                            <?php $primary_category_id = get_post_meta(get_the_ID(), '_yoast_wpseo_primary_category', true); ?>
                                            <?php $primary_category = get_category($primary_category_id); ?>
                                            <div class="font-normal text-sm leading-5 text-customBlue-light"><?php echo wp_kses_post($primary_category->name); ?></div>
                                            <button class="w-8 h-8 flex-none link order-button buy-button"
                                                    data-productId="<?php echo esc_attr(get_the_ID()); ?>"
                                                    data-price="<?php echo esc_attr($price); ?>"
                                                    data-discountPrice="<?php echo esc_attr($discount_price ? $discount_price : ''); ?>"
                                                    data-img="<?php echo esc_url($image_url); ?>"
                                                    data-url="<?php echo esc_url(get_permalink()); ?>"
                                                    data-ptitle="<?php echo wp_kses_post(get_the_title()); ?>"
                                                    data-basetitle="<?php echo wp_kses_post(get_the_title()); ?>"
                                                    data-baseId="<?php echo esc_attr(get_the_ID()); ?>">
                                                <img id="add-button"
                                                     src="<?php echo esc_url(get_stylesheet_directory_uri() . '/img/svg/button.svg'); ?>"
                                                     alt="Add product icon: <?php echo wp_kses_post(get_the_title()); ?>">
                                            </button>
                                        </div>

                                    <?php else: ?>
                                        <div class="flex flex-col gap-[5px]">
                                            <?php $primary_category_id = get_post_meta(get_the_ID(), '_yoast_wpseo_primary_category', true); ?>
                                            <?php $primary_category = get_category($primary_category_id); ?>
                                            <p class="font-normal text-[14px] leading-5 text-customBlue-light"><?php echo wp_kses_post($primary_category->name); ?></p>

                                            <button class="link price-button p-2 rounded-md border border-solid border-customGreen-dark"
                                                    data-fancybox
                                                    data-src="#price"
                                                    data-ptitle="<?php the_title(); ?>"
                                                    data-url="<?php echo esc_url(get_permalink()); ?>">
                                                <p class="font-medium text-sm leading-6 text-customGreen-dark">
                                                    Узнать цену</p>
                                            </button>


                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                        <?php
                        endwhile;

                    endif;
                    ?>
                </div>

                <!-- Пагинация -->
                <?php
                // Получаем количество страниц
                $total_pages = $wp_query->max_num_pages;
                if ($total_pages > 1) {
                    ?>
                    <div class="pagination flex justify-between items-center ">

                        <?php
                        the_posts_pagination(array(
                            'mid_size' => 2,
                            'prev_text' => __('Ранее', 'textdomain'),
                            'next_text' => __('Далее', 'textdomain'),
                        ));
                        ?>

                        <div class="pagination-container ">
                            <form action="" method="get"
                                  class="pagination-form flex mobilePortraitSm:flex-col items-center gap-2.5">
                                <label class="font-normal text-[16px] leading-5">
                                    <span>
                                        <?php _e('Перейти на страницу:', 'textdomain'); ?>
                                    </span>
                                </label>
                                <div>
                                    <input class="custom-number-input" type="number" name="paged"
                                           min="1"
                                           max="<?php echo $total_pages; ?>"
                                           value="<?php echo (get_query_var('paged')) ? get_query_var('paged') : 1; ?>"/>
                                    <button class="w-[108px] h-[36px] py-1.5 px-5 rounded-md bg-customGreen-dark font-normal  leading-5 text-center text-white"
                                            type="submit"><?php _e('Перейти', 'textdomain'); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php endif; ?>

            <?php if (!have_posts()) : ?>
                <div class="flex flex-col gap-2.5 font-medium text-xl leading-5 text-black">
                    По вашему запросу ничего не найдено.
                    <div class="leading-5 text-[18px] text-black">
                        Пожалуйста, убедитесь, что запрос введён правильно, или попробуйте использовать другие ключевые
                        слова.
                    </div>
                </div>
            <?php endif; ?>

            <!--Блок Ранее смотрели -->
            <?php get_template_part('module/widgetes/previously-watched', null, array()); ?>
        </div>




        <!-- Футер -->
        <div id="footer">
            <?php get_template_part('module/footer', null, array()); ?>
        </div>
    </div>

    <?php get_footer(); ?>

