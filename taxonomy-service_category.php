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
    <div class="flex-grow py-10">
        <div class="flex flex-col px-5 mobileLandscape:p-2.5 gap-10">

            <?php
            $current_category_id = get_queried_object_id();
            $child_categories = get_categories(array(
                'hide_empty' => false,
                'parent' => $current_category_id,
            ));
            ?>

            <!-- Заголовок категории -->
            <h1 class="font-medium text-4xl leading-[54px]">
                <?php single_term_title(); ?>
            </h1>

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
                           class="subcategory-item <?php echo $index >= 5 ? 'hidden' : ''; ?> flex flex-col gap-2 relative items-center py-1.5 rounded-[5px] bg-white">
                        <span class="absolute top-0 left-0 py-1 px-2 font-semibold text-[12px] leading-[14px] rounded-[5px] bg-customGreen-dark text-white">
                            <?php echo $child_category->count > 0 ? $child_category->count . ' шт.' : '0 шт.'; ?>
                        </span>

                            <?php if ($categories_image): ?>
                                <img src="<?php echo esc_url($categories_image); ?>"
                                     alt="<?php echo esc_attr($child_category->name); ?>" class="w-[50px] h-[50px]"/>
                            <?php endif; ?>

                            <p class="text-center font-normal text-[14px] leading-4">
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
            <div class="flex flex-col gap-2.5">

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

                            <div class="flex flex-col justify-between gap-2 p-1.5 rounded-md bg-white">
                                <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>">
                                    <img class="h-[168px] w-full object-cover" src="<?php echo esc_url($image_url); ?>"
                                         alt="<?php the_title(); ?>" loading="lazy">
                                </a>


                                <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>">
                                    <p class="font-medium text-[14px] leading-5 text-black"><?php the_title(); ?></p>
                                </a>

                                <div class="flex flex-col gap-2">
                                    <?php $price = get_field('post-price'); ?>
                                    <?php $discount_price = get_field('post-discounted-price'); ?>
                                    <?php if ($price): ?>

                                        <div class="flex mobilePortrait:flex-col gap-2.5">
                                            <p class="font-medium leading-5 text-black"><?php echo esc_html($price); ?>
                                                BYN</p>
                                            <del class="font-medium text-sm leading-5 text-customGreen-dark"><?php echo esc_html($discount_price); ?>
                                                BYN
                                            </del>
                                        </div>


                                        <div class="flex justify-between items-center">
                                            <?php $primary_category_id = get_post_meta(get_the_ID(), '_yoast_wpseo_primary_category', true); ?>
                                            <?php $primary_category = get_category($primary_category_id); ?>
                                            <p class="font-normal text-[14px] leading-5 text-customBlue-light"><?php echo wp_kses_post($primary_category->name); ?></p>
                                            <button class="buy-button"
                                                    data-fancybox data-src="#buy" href="javascript:;"
                                                    data-price="<?php echo esc_attr($discount_price ? $discount_price : $price); ?>"
                                                    data-ptitle="<?php the_title(); ?>"
                                                    data-url="<?php echo esc_url(get_permalink()); ?>">
                                                <img src="<?php echo get_stylesheet_directory_uri() . '/img/svg/button.svg'; ?>"
                                                     alt="barCode">
                                            </button>
                                        </div>

                                    <?php else: ?>
                                        <div class="flex flex-col gap-[5px]">
                                            <?php $primary_category_id = get_post_meta(get_the_ID(), '_yoast_wpseo_primary_category', true); ?>
                                            <?php $primary_category = get_category($primary_category_id); ?>
                                            <p class="font-normal text-[14px] leading-5 text-customBlue-light"><?php echo wp_kses_post($primary_category->name); ?></p>

                                            <button class="price-button p-2 rounded-md border border-solid border-customGreen-dark"
                                                    data-fancybox
                                                    data-src="#price" href="javascript:;"
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
                <div class="pagination flex justify-between items-center ">

                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => __('Ранее', 'textdomain'),
                        'next_text' => __('Далее', 'textdomain'),
                    ));
                    ?>


                    <?php
                    // Получаем количество страниц
                    $total_pages = $wp_query->max_num_pages;
                    if ($total_pages > 1) {
                        ?>
                        <div class="pagination-container ">
                            <form action="" method="get" class="pagination-form flex items-center gap-2.5">
                                <label class="font-normal text-[16px] leading-5"
                                       for="page_number"><?php _e('Перейти на страницу:', 'textdomain'); ?></label>
                                <input class="custom-number-input" type="number" id="page_number" name="paged" min="1"
                                       max="<?php echo $total_pages; ?>"
                                       value="<?php echo (get_query_var('paged')) ? get_query_var('paged') : 1; ?>"/>
                                <button class="w-[108px] h-[36px] py-1.5 px-5 rounded-md bg-customGreen-dark font-normal text-[16px] leading-5 text-center text-white"
                                        type="submit"><?php _e('Перейти', 'textdomain'); ?></button>
                            </form>
                        </div>
                        <?php
                    }
                    ?>

                </div>

            </div>

            <!--Блок Ранее смотрели -->
            <?php
            if (isset($_COOKIE['viewedProd']) && !empty($_COOKIE['viewedProd'])) {
                // Получаем массив ID из cookie
                $viewedProd = $_COOKIE['viewedProd'];

                // Проверяем, чтобы это был массив
                if (!is_array($viewedProd)) {
                    $viewedProd = explode(',', $viewedProd); // Если это строка, разделенная запятыми
                }

                // Убираем все нечисловые значения из массива
                $viewedProd = array_filter($viewedProd, 'is_numeric');

                // Создаем WP_Query для получения постов по этим ID
                $args = array(
                    'post_type' => 'post',  // Тип записи, можно изменить на ваш нужный тип (например, 'product')
                    'posts_per_page' => -1, // Количество постов, можно ограничить
                    'post__in' => $viewedProd,  // Массив ID, по которым нужно сделать запрос
                    'orderby' => 'post__in', // Сохраняем порядок, как в массиве ID
                );

                $query = new WP_Query($args);

                // Проверяем, есть ли посты
                if ($query->have_posts()) {
                    ?>
                    <div class="grid gap-2.5 ">
                        <div class="font-medium text-[32px] leading-[48px]" itemprop="name">
                            Ранее смотрели
                        </div>

                        <div class="grid">
                            <div id="productSwiper" class="swiper">
                                <div id="productSwiper-wrapper" class="swiper-wrapper">
                                    <?php
                                    // Итерация по постам
                                    while ($query->have_posts()) {
                                        $query->the_post();

                                        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                        $price = get_field('post-price');
                                        $discount_price = get_field('post-discounted-price');
                                        $primary_category_id = get_post_meta(get_the_ID(), '_yoast_wpseo_primary_category', true);
                                        $primary_category = get_category($primary_category_id);

                                        ?>
                                        <div id="product-swiper-slide"
                                             class="swiper-slide flex flex-col justify-between gap-2 p-1.5 rounded-md bg-white">
                                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                                <img class="object-contain" src="<?php echo esc_url($image_url); ?>"
                                                     alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
                                            </a>


                                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                                <p class="font-medium text-[14px] leading-5 text-black"><?php the_title(); ?></p>
                                            </a>


                                            <?php if ($price): ?>
                                                <div class="flex mobilePortrait:flex-col gap-2.5">
                                                    <p class="font-medium leading-5 text-black"><?php echo esc_html($price); ?>
                                                        BYN</p>
                                                    <del class="font-medium text-sm leading-5 text-customGreen-dark"><?php echo esc_html($discount_price); ?>
                                                        BYN
                                                    </del>
                                                </div>

                                                <div class="flex justify-between items-center ">
                                                    <?php $primary_category_id = get_post_meta(get_the_ID(), '_yoast_wpseo_primary_category', true); ?>
                                                    <?php $primary_category = get_category($primary_category_id); ?>
                                                    <p class="font-normal text-[14px] leading-5 text-customBlue-light"><?php echo wp_kses_post($primary_category->name); ?></p>
                                                    <button class="buy-button"
                                                            data-fancybox data-src="#buy"
                                                            data-price="<?php echo esc_attr($discount_price ? $discount_price : $price); ?>"
                                                            data-ptitle="<?php the_title(); ?>"
                                                            data-url="<?php echo esc_url(get_permalink()); ?>">
                                                        <img id="add-button"
                                                             src="<?php echo get_stylesheet_directory_uri() . '/img/svg/button.svg'; ?>"
                                                             alt="barCode">
                                                    </button>
                                                </div>

                                            <?php else: ?>
                                                <div class="flex flex-col gap-2.5 ">
                                                    <?php $primary_category_id = get_post_meta(get_the_ID(), '_yoast_wpseo_primary_category', true); ?>
                                                    <?php $primary_category = get_category($primary_category_id); ?>
                                                    <p class="font-normal text-[14px] leading-5 text-customBlue-light"><?php echo wp_kses_post($primary_category->name); ?></p>

                                                    <button class="price-button p-2 rounded-md border border-solid border-customGreen-dark"
                                                            data-fancybox
                                                            data-src="#price"
                                                            data-ptitle="<?php the_title(); ?>"
                                                            data-url="<?php echo esc_url(get_permalink()); ?>">
                                                        <p class="font-medium text-[14px] leading-6 text-customGreen-dark">
                                                            Узнать цену</p>
                                                    </button>
                                                </div>
                                            <?php endif; ?>


                                        </div>
                                    <?php } ?>
                                </div>
                                <div id="swiper-button-prev">
                                    <img class=""
                                         src="<?php echo get_stylesheet_directory_uri() . '/img/svg/prev.svg'; ?>"
                                         alt="mobile">
                                </div>
                                <div id="swiper-button-next">
                                    <img class=""
                                         src="<?php echo get_stylesheet_directory_uri() . '/img/svg/next.svg'; ?>"
                                         alt="mobile">
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    wp_reset_postdata();
                }
            }
            ?>


        </div>
    </div>

    <!-- Футер для десктопа -->
    <div id="footer" >
        <?php get_template_part('module/footer', null, array()); ?>
    </div>
</div>

<?php get_footer(); ?>

