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

    <?php
    $current_category_id = get_queried_object_id();
    $ancestors = get_ancestors($current_category_id, 'category');
    $child_categories = get_categories(array(
        'hide_empty' => false,
        'parent' => $current_category_id,
    ));
    ?>

    <?php if (count($ancestors) < 1): ?>
    <!-- Основной контент -->
    <div class="flex-grow py-5 ">

        <div class="flex flex-col gap-5">
            <div class="flex mobileLandscape:flex-col justify-between mobileLandscape:items-start items-center px-5 mobileLandscape:px-2.5">
                <div class=" font-medium text-[32px] leading-[48px] mobileLandscape:text-[28px] mobileLandscape:leading-[42px] text-black"
                     itemprop="name">
                    <?php single_cat_title(); ?>
                </div>
                <!-- Хлебные крошки (Yoast SEO) -->
                <?php if (function_exists('yoast_breadcrumb')): ?>
                    <div class="z-10 font-normal text-[14px] leading-5 text-breadcrumb text-center">
                        <?php yoast_breadcrumb('<p  class="breadcrumbs-text last-gray ">', '</p>'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php

            $current_category = get_queried_object_id();
            foreach ($child_categories

            as $index => $category) {
            $category_id = $category->term_id;
            $category_link = get_category_link($category_id);

            $child_categories = get_categories(array(
                'hide_empty' => false,
                'parent' => $category_id,
            ));

            $child_category_ids = wp_list_pluck($child_categories, 'term_id');
            error_log('Child Category IDs for ' . $category->name . ': ' . implode(', ', $child_category_ids));


            $is_open = in_array($current_category, wp_list_pluck($child_categories, 'term_id'));


            ?>

            <div class="flex flex-col gap-2.5 py-5 mobileLandscape:py-5 px-5 mobileLandscape:px-2.5 <?php echo $index % 2 === 0 ? 'bg-customGray-category' : ''; ?>">
                <a href="<?php echo esc_url($category_link); ?>"
                   class="font-medium text-xl leading-[30px] text-black">
                    <?php echo esc_html($category->name); ?>
                </a>
                <?php if (empty($child_categories)): ?>
            </div>
        <?php endif; ?>


            <?php if (!empty($child_categories)): ?>
            <div class="subcategories grid grid-cols-9 ultraWideDesktop:grid-cols-7 wideDesktop:grid-cols-6 desktop:grid-cols-4 mobileLandscape:grid-cols-2 gap-2.5">
                <?php foreach ($child_categories as $index => $child_category): ?>
                    <?php
                    $image_id = get_term_meta($child_category->term_id, '_thumbnail_id', true);
                    $categories_image = wp_get_attachment_image_url($image_id, 'full');
                    $child_link = get_category_link($child_category->term_id);
                    ?>

                    <!-- Показывать только первые 5 элементов изначально -->
                    <a href="<?php echo esc_url($child_link); ?>"
                       class="link subcategory-item <?php echo $index >= 5 ? 'hidden' : ''; ?> flex flex-col gap-2  relative items-center py-1.5 text-center rounded-[5px] bg-white">
                        <?php if ($child_category->count > 0): ?>
                            <span class="absolute top-0 left-0 py-1 px-2 font-semibold text-[12px] leading-[14px] rounded-[5px] bg-customGreen-dark text-white">
                            <?php echo $child_category->count; ?> шт.
                        </span>
                        <?php else: ?>
                            <span class="absolute top-0 left-0 py-1 px-2 font-semibold text-[12px] leading-[14px] rounded-[5px] bg-customGreen-dark text-white">
                           0 шт.
                        </span>
                        <?php endif; ?>

                        <img src="<?php echo esc_url($categories_image); ?>"
                             alt="<?php echo esc_attr($child_category->name); ?>"
                             class="h-[50px]"/>

                        <p class="font-semibold text-[14px] leading-4">
                            <?php echo esc_html($child_category->name); ?>
                        </p>
                    </a>

                <?php endforeach; ?>

                <!-- Кнопка "Показать еще" как шестой элемент, если категорий больше 5 -->
                <?php if (count($child_categories) > 5): ?>
                    <div class="show-all-button  min-h-20 flex justify-center items-center py-1.5 px-14 mobileLandscape:px-2.5 rounded-[5px] bg-customGreen text-center cursor-pointer text-black">
                        Посмотреть все
                        категории
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php } ?>

        <?php if (get_field('about-us-kartinki', 'options') and get_field('about-us-tekst', 'options')) : ?>
            <div class="about-us px-[15px] mobileLandscape:px-2.5 ">
                <div class="grid grid-cols-[58%_42%] tabletLandscape:grid-cols-1 rounded-md overflow-hidden">
                    <?php $text = get_field('about-us-tekst', 'options'); ?>
                    <?php $img = get_field('about-us-kartinki', 'options'); ?>

                    <div class="flex flex-col  gap-5 mobileLandscape:gap-2.5 py-6 px-[15px] mobileLandscape:px-2.5  bg-white">

                        <div class="font-medium text-[32px] leading-[48px] mobileLandscape:text-2xl mobileLandscape:leading-9">
                            О нас
                        </div>
                        <div class="text-hide"> <!-- Контейнер для текста с ограничением высоты -->
                            <div class="text-block font-normal text-[16px] leading-6">
                                <?php echo wpautop(esc_html($text)); ?>
                            </div>
                        </div>
                        <div class="read-more-container ">
                            <button class="link read-more-button w-full items-center py-3 px-8 border border-solid border-customGreen-dark rounded-md cursor-pointer read-more-button">
                                <p class="font-medium leading-5 text-customGreen-dark">Читать далее</p>
                            </button>
                        </div>
                    </div>

                    <?php if (!empty($img)): ?>
                        <img class="about-us-img w-full" src="<?php echo esc_url($img['url']); ?>"
                             alt="<?php echo esc_attr($img['alt']); ?>">
                    <?php endif; ?>

                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php endif ?>


<?php if (count($ancestors) >= 1): ?>
    <div class="flex-grow py-5  mobileLandscape:py-5">
        <div class="flex flex-col px-5 mobileLandscape:px-2.5 gap-5">
            <div class="flex mobileLandscape:flex-col gap-2.5 justify-between mobileLandscape:items-start items-center ">
                <div class="font-medium text-[32px] leading-[48px] mobileLandscape:text-[28px] mobileLandscape:leading-[42px] text-black"
                     itemprop="name">
                    <?php single_term_title(); ?>
                </div>
                <!-- Хлебные крошки (Yoast SEO) -->
                <?php if (function_exists('yoast_breadcrumb')): ?>
                    <div class="z-10 font-normal text-[14px] leading-5 text-breadcrumb ">
                        <?php yoast_breadcrumb('<p  class="breadcrumbs-text last-gray ">', '</p>'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!--Дочерние категори-->
            <?php if (!empty($child_categories)): ?>
                <div class="subcategories grid grid-cols-9 ultraWideDesktop:grid-cols-8 wideDesktop:grid-cols-6 desktop:grid-cols-5 mobileLandscape:grid-cols-4 mobilePortrait:grid-cols-3 mobilePortraitSmall:grid-cols-2 gap-2.5">
                    <?php foreach ($child_categories as $index => $child_category): ?>
                        <?php
                        $image_id = get_term_meta($child_category->term_id, '_thumbnail_id', true);
                        $categories_image = wp_get_attachment_image_url($image_id, 'full');
                        $child_link = get_category_link($child_category->term_id);
                        ?>

                        <!-- Показывать только первые 5 элементов изначально -->
                        <a href="<?php echo esc_url($child_link); ?>"
                           class="link subcategory-item <?php echo $index >= 5 ? 'hidden' : ''; ?> flex flex-col gap-2 relative items-center py-1.5 rounded-[5px] bg-white">
                        <span class="absolute top-0 left-0 py-1 px-2 font-semibold text-[12px] leading-[14px] rounded-[5px] bg-customGreen-dark text-white">
                            <?php echo $child_category->count > 0 ? $child_category->count . ' шт.' : '0 шт.'; ?>
                        </span>

                            <?php if ($categories_image): ?>
                                <img src="<?php echo esc_url($categories_image); ?>"
                                     alt="<?php echo esc_attr($child_category->name); ?>"
                                     class="w-[50px] h-[50px]"/>
                            <?php endif; ?>

                            <p class="text-center font-normal text-sm leading-4">
                                <?php echo esc_html($child_category->name); ?>
                            </p>
                        </a>

                    <?php endforeach; ?>

                    <!-- Кнопка "Показать еще" как шестой элемент, если категорий больше 5 -->
                    <?php if (count($child_categories) > 9): ?>
                        <div class="show-all-button min-h-20 flex justify-center items-center py-1.5 px-14 mobileLandscape:px-2.5 rounded-[5px] bg-customGreen-dark text-center cursor-pointer text-white">
                            Посмотреть все категории
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Товары по данной категории -->
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


                                        <div class="flex justify-between items-center">
                                            <?php $primary_category_id = get_post_meta(get_the_ID(), '_yoast_wpseo_primary_category', true); ?>
                                            <?php $primary_category = get_category($primary_category_id); ?>
                                            <p class="font-normal text-sm leading-5 text-customBlue-light"><?php echo wp_kses_post($primary_category->name); ?></p>
                                            <button class="link order-button buy-button"
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

            <!--Блок Ранее смотрели -->
            <?php get_template_part('module/widgetes/previously-watched', null, array()); ?>
        </div>
    </div>
<?php endif ?>


<!-- Футер -->
<div id="footer">
    <?php get_template_part('module/footer', null, array()); ?>
</div>


<?php get_footer(); ?>


<?php /* Template Name: Каталог товаров */ ?>












