<div class="grid gap-5 px-5 mobileLandscape:px-2.5 py-5">

    <!--Карточка товара-->
    <div class="grid gap-2.5">


        <?php if (function_exists('bcn_display')) {
            echo '<div class="breadcrumbs">';
            bcn_display();
            echo '</div>';
        } ?>

        <!--Картинки и описание товара-->
        <div id="post-<?php the_ID(); ?>"
             class="grid desktop:grid-cols-[650px_1fr]  grid-cols-[780px_1fr] tabletLandscape:grid-cols-1  gap-2.5 ">

            <!-- Основное изображение и миниатюры -->
            <?php if (has_post_thumbnail()) : ?>
                <?php $gallery_images = get_field('post-images'); ?>
                <div class="">
                    <div class="grid <?php echo ($gallery_images) ? 'grid grid-cols-[75%_25%] ' : 'grid grid-cols-1'; ?> grid-rows-[580px] mobileLandscape:grid-cols-1  mobilePortrait:grid-rows-[300px]  p-2.5 gap-2.5 bg-white rounded-md overflow-hidden  ">

                        <!-- Основное изображение -->
                        <div class="max-h-max bg-white ">
                            <a data-fancybox="gallery"
                               href="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>">
                                <img class="h-full w-full object-contain"
                                     src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>"
                                     alt="<?php the_title(); ?>">
                            </a>
                        </div>

                        <?php if ($gallery_images): ?>
                            <!-- Дополнительные миниатюры справа с прокруткой -->
                            <div class="flex flex-col mobileLandscape:flex-row gap-2.5 p-2.5 overflow-auto ">
                                <!-- Ограничиваем высоту и добавляем прокрутку -->
                                <?php foreach ($gallery_images as $image): ?>
                                    <a data-fancybox="gallery" href="<?php echo esc_url($image['url'], 'full'); ?>">
                                        <img class="h-full w-full mobileLandscape:w-auto mobileLandscape:h-[100px] object-cover rounded-md"
                                             src="<?php echo esc_url($image['sizes']['thumbnail'], 'full'); ?>"
                                             alt="<?php echo esc_attr($image['alt']); ?>">
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endif; ?>

            <div class="flex flex-col gap-2.5 mobileLandscape:gap-5">

                <!--Категория и артикул-->
                <div class="flex gap-10 wideDesktop:flex-col wideDesktop:gap-2.5">
                    <?php $primary_category_id = get_post_meta(get_the_ID(), '_yoast_wpseo_primary_category', true); ?>
                    <?php if ($primary_category_id) { ?>
                        <div class="flex  gap-1">
                        <h3 class="font-bold  leading-5 text-customGray-black">Категория:</h3>
                        <?php $primary_category = get_category($primary_category_id); ?>
                        <?php if ($primary_category) { ?>
                            <a class="font-normal leading-5 text-customGreen-dark"
                               href="<?php echo esc_url(get_category_link($primary_category->term_id)); ?>">
                                <?php echo wp_kses_post($primary_category->name); ?>
                            </a>
                            </div>
                        <?php }
                    }
                    ?>

                    <div class="flex items-center gap-1">
                        <?php $article = get_field('post-article'); ?>
                        <?php if ($article) { ?>
                            <img class=""
                                 src="<?php echo get_stylesheet_directory_uri() . '/img/svg/barCode.svg'; ?>"
                                 alt="barCode">
                            <div class="font-normal leading-5 text-customGray-black">AGCO Part Number:
                            </div>
                            <div class="font-bold  leading-5 text-customGray-black">
                                <?php echo $article ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="flex flex-col gap-2.5">
                    <!--Название товара-->
                    <h2 class="ont-medium text-4xl mobileLandscape:text-[28px] leading-[54px] mobileLandscape:leading-[42px] text-black"><?php the_title(); ?></h2>

                    <!--Цена и кнопка заказать-->
                    <div class="flex flex-col gap-2.5">
                        <div class="flex  mobilePortrait:flex-col wideDesktop:gap-6  gap-12  rounded-md ">
                            <?php $price = get_field('post-price'); ?>
                            <?php $discount_price = get_field('post-discounted-price'); ?>
                            <?php if ($price): ?>
                                <button class="link order-button max-w-max buy-button py-2 px-4 rounded-md bg-customGreen-dark"
                                        data-productId="<?php echo get_the_ID(); ?>"
                                        data-price="<?php echo esc_attr($price); ?>"
                                        data-discountPrice="<?php echo esc_attr($discount_price ? $discount_price : ''); ?>"
                                        data-img="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>"
                                        data-ptitle="<?php the_title(); ?>"
                                        data-basetitle="<?php the_title(); ?>"
                                        data-baseId="<?php echo get_the_ID(); ?>">
                                    <p class="font-medium text-sm leading-6 text-white">Добавить в корзину</p>
                                </button>


                                <div class="flex gap-2.5 mobileLandscape:min-h-10 ">
                                    <?php if (!empty($discount_price)) : ?>
                                        <div class="flex items-center">
                                            <p class="font-medium text-3xl leading-5 text-black">
                                                <?php echo esc_html($discount_price); ?> BYN
                                            </p>
                                        </div>
                                        <del class="font-medium text-xl leading-5 text-customGreen-dark">
                                            <?php echo esc_html($price); ?> BYN
                                        </del>
                                    <?php else : ?>
                                        <div class="flex items-center ">
                                            <p class="font-medium text-3xl leading-5 text-black">
                                                <?php echo esc_html($price); ?> BYN
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </div>


                            <?php else: ?>
                                <div class="flex gap-5">
                                    <button class="link max-w-max  py-2 px-4 rounded-md bg-customGreen-dark" data-fancybox
                                            data-src="#price"
                                            data-ptitle="<?php the_title(); ?>"
                                            data-url="<?php echo esc_url(get_permalink()); ?>">

                                        <p class="font-medium text-sm leading-6 text-white">Узнать цену</p>
                                    </button>
                                    <p class="font-medium text-[24px] leading-9 text-black">По запросу</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class=""></div>
                <div class=""></div>

                <!--Технические характеристики товара-->
                <?php if (have_rows('specifications')) : ?>
                    <div class="flex flex-col ">
                        <div class="font-medium text-xl leading-[30px] text-black">Технические характеристики</div>
                        <?php while (have_rows('specifications')) : the_row(); ?>
                            <?php $spec_title = get_sub_field('specification-title'); ?>
                            <?php $spec_value = get_sub_field('specification-value'); ?>
                            <div class="grid grid-cols-2  gap-10 py-2.5  border-b border-dotted border-customGreen">
                                <div class="font-normal leading-5 text-customGray-black text-left">
                                    <?php echo wp_kses_post($spec_title); ?>
                                </div>
                                <p class="break-words whitespace-normal  font-normal  leading-5 text-customGray-black text-left ">
                                    <?php echo wp_kses_post($spec_value); ?>
                                </p>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>

                <?php if (have_rows('specifications')) : ?>
                    <div class=""></div>
                <?php endif; ?>

                <?php if (have_rows('brands')) : ?>
                    <div class="flex flex-col gap-2.5">
                        <div class="font-medium text-xl leading-[30px] text-black">Бренды</div>
                        <?php while (have_rows('brands')) : the_row(); ?>
                            <?php
                            $image = get_sub_field('brand-img'); // Получаем ID изображения
                            $brand_value = get_sub_field('brand-value'); // Получаем значение бренда
                            ?>
                            <div class="grid grid-cols-2 gap-10 py-2.5 border-b border-dotted border-customGreen">
                                <p class="flex items-center break-words whitespace-normal font-normal leading-5 text-customGray-black text-left">
                                    <?php if ($brand_value) : ?>
                                        <?php echo wp_kses_post($brand_value); ?>
                                    <?php endif; ?>
                                </p>
                                <div class="font-normal leading-5 text-customGray-black text-left">
                                    <?php if ($image) : ?>
                                        <img src="<?php echo esc_url($image['sizes']['thumbnail'], 'full'); ?>"
                                             alt="<?php echo esc_attr($image['alt']); ?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>

                <?php if (have_rows('brands')) : ?>
                    <div class=""></div>
                <?php endif; ?>

                <!--Описание-->
                <?php if (get_the_content()) : ?>
                    <div class="grid gap-2.5 ">
                        <div class="font-medium text-xl  text-black">Описание</div>
                        <p class="font-normal mobileLandscape:text-sm leading-6 text-customGray-description"><?php echo wp_kses_post(get_the_content()); ?></p>
                    </div>
                <?php endif; ?>

                <?php $feature = get_field('feature'); ?>
                <?php if ($feature): ?>
                    <div class=""></div>
                    <div class="flex flex-col gap-2.5  ">
                        <div class="font-medium text-xl text-black">Особенность</div>
                        <div class="p-0 "> <?php echo $feature ?> </div>
                    </div>
                <?php endif ?>

            </div>

        </div>
    </div>

    <!--    Блок Похожие товары-->
    <?php get_template_part('module/widgetes/similar-products', null, array()); ?>

    <!--Блок Ранее смотрели -->
    <?php get_template_part('module/widgetes/previously-watched', null, array()); ?>

</div>





