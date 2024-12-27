<div class="grid gap-5 px-5 mobileLandscape:px-2.5 py-5 ">

    <!--Карточка товара-->
    <div class="grid gap-2.5">


        <!-- Хлебные крошки (Yoast SEO) -->
        <?php if (function_exists('yoast_breadcrumb')): ?>
            <div class="z-50 font-normal text-[14px] leading-5 text-breadcrumb ">
                <?php yoast_breadcrumb('<p  class="breadcrumbs-text last-gray ">', '</p>'); ?>
            </div>
        <?php endif; ?>


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
                                <img class="h-full w-full object-cover"
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

            <div class="flex flex-col gap-2.5">

                <!--Название товара-->
                <h2 class="font-medium text-4xl mobileLandscape:text-[28px] mobileLandscape:leading-[42px] text-black"><?php the_title(); ?></h2>

                <!--Цена и кнопка заказать-->
                <div class="flex flex-col gap-2.5">
                    <div class="flex max-w-max   wideDesktop:gap-2.5  gap-2.5    py-2.5  rounded-md  ">

                            <button class="link price-button py-2 px-4  rounded-md bg-customGreen-dark" data-fancybox
                                    data-src="#buy"
                                    data-ptitle="<?php the_title(); ?>"
                                    data-url="<?php echo esc_url(get_permalink()); ?>">

                                <p class="font-medium text-sm leading-6  text-white">Заказать</p>
                            </button>
                        <button class="link price-button py-2 px-4  rounded-md border border-solid border-customGreen-dark " data-fancybox
                                data-src="#buy"
                                data-ptitle="<?php the_title(); ?>"
                                data-url="<?php echo esc_url(get_permalink()); ?>">
                            <p class="font-medium text-sm leading-6  text-customGreen-dark">Получить консультацию</p>
                        </button>

                    </div>
                </div>

                <div class=""></div>
                <div class=""></div>

                <!--Описание-->
                <?php if (get_the_content()) : ?>
                    <div class="grid gap-2.5 ">
                        <div class="font-medium text-xl leading-[30px] text-black">Описание</div>
                        <p class="font-normal text-sm leading-6 text-customGray-description"><?php echo wp_kses_post(get_the_content()); ?></p>
                    </div>
                <?php endif; ?>

                <div class=""></div>

                <?php $feature = get_field('feature'); ?>
                <?php if ($feature): ?>
                    <div class="flex flex-col gap-2.5  ">
                        <div class="font-medium text-xl leading-[30px] text-black">Особенность</div>
                        <div class="p-0 "> <?php echo $feature ?> </div>
                    </div>
                <?php endif ?>


                <div class=""></div>

                <!--Технические характеристики товара-->
                <?php if (have_rows('specifications')) : ?>
                    <div class="flex flex-col gap-2.5 ">
                        <div class="font-medium text-xl leading-[30px] text-black">Тут таблица с ценами</div>
                        <?php while (have_rows('specifications')) : the_row(); ?>
                            <?php $spec_title = get_sub_field('specification-title'); ?>
                            <?php $spec_value = get_sub_field('specification-value'); ?>
                            <div class="grid grid-cols-2  gap-2. py-2.5  border-b border-dotted border-customGreen">
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



            </div>

        </div>
    </div>


</div>






