<?php get_header(); ?>


<div class="grid grid-cols-[317px_1fr] tabletLandscape:grid-cols-1 min-h-full">
    <!-- Сайдбар -->
    <div class="flex flex-col tabletLandscape:hidden  bg-white py-5 gap-[30px] border border-solid border-sidebarborder">
        <?php get_sidebar(); ?>
    </div>

    <!--    Основной раздел-->
    <div class="flex flex-col gap-2.5">

        <!-- Шапка для десктопа -->
        <div id="header" class="block mobileLandscape:hidden">
            <?php get_template_part('module/header', null, array()); ?>
        </div>
        <!-- Шапка  для мобильных устройств-->
        <div id="header-mobile" class="hidden mobileLandscape:flex">
            <?php get_template_part('module/header-mobile', null, array()); ?>
        </div>

        <!-- Основной контент -->
        <div class="flex-grow flex-1">
            <div class="grid gap-10 my-2 mb-8  ">
                <div class="grid gap-10 my-2 ">


                    <!-- Основной контент -->
                    <div class="flex-grow pt-10">
                        <div class="flex flex-col px-5 mobileLandscape:p-2.5 gap-10">
                            <!-- Хлебные крошки (Yoast SEO) -->
                            <?php if (function_exists('yoast_breadcrumb')): ?>
                                <div class="font-normal text-[14px] leading-5 text-breadcrumb">
                                    <?php yoast_breadcrumb('<p id="breadcrumbs" class="breadcrumbs">', '</p>'); ?>
                                </div>
                            <?php endif; ?>

                            <!-- Товары по категории -->
                            <div class="flex flex-col gap-2.5">
                                <!-- Заголовок категории -->
                                <h1 class="font-medium text-[32px] leading-[48px]" itemprop="name">
                                    <?php single_term_title(); ?>
                                </h1>

                                <!-- Товары по данной категории -->
                                <div class="grid grid-cols-4 ultraWideDesktop:grid-cols-4 wideDesktop:grid-cols-2 desktop:grid-cols-2 mobileLandscape:grid-cols-1 gap-2.5">

                                    <?php
                                    $args = array(
                                        'post_type' => 'blog',  // Указываем тип записи
                                        'posts_per_page' => 10,      // Количество записей на странице
                                        'paged' => get_query_var('paged', 1)  // Пагинация
                                    );

                                    $query = new WP_Query($args);

                                    if ($query->have_posts()) :
                                        while ($query->have_posts()) : $query->the_post();
                                            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                            $description = get_the_content();
                                            $date = get_the_date('d.m.Y');  // Формат: 10-11-2024


                                            ?>


                                            <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"
                                               class="relative flex flex-col justify-end  h-[234px] w-full    p-2.5 rounded-md bg-cover bg-center"
                                               style="background-image: url('<?php echo esc_url($image_url); ?>');">
                                                <!-- Добавим дату -->
                                                <div class="flex items-center gap-[5px] py-1 px-2.5 max-w-max bg-white rounded-tr-md  rounded-tl-md ">
                                                    <img class="w-[15px] h-[15px] " src="<?php echo get_stylesheet_directory_uri() . '/img/svg/calendar.svg'; ?>" alt="mobile">
                                                    <p class=" font-normal text-[13px] leading-5 text-customGray-text">
                                                        <?php echo esc_html($date); ?>
                                                    </p>
                                                </div>
                                                <p class="p-2.5 font-medium text-[18px]  leading-[30px] text-black bg-white rounded-tr-md rounded-br-md rounded-bl-md"><?php the_title(); ?></p>
                                            </a>


                                        <?php
                                        endwhile;
                                    else:
                                        echo '<p>Записей не найдено</p>';
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
                                                <input class="custom-number-input" type="number" id="page_number" name="paged"
                                                       min="1" max="<?php echo $total_pages; ?>"
                                                       value="<?php echo (get_query_var('paged')) ? get_query_var('paged') : 1; ?>"/>
                                                <button class="w-[108px] h-[36px] py-1.5 px-5 rounded-md bg-customGreen-normal font-normal text-[16px] leading-5 text-center text-white"
                                                        type="submit"><?php _e('Перейти', 'textdomain'); ?></button>
                                            </form>
                                        </div>
                                        <?php
                                    }
                                    ?>

                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <!-- Футер для десктопа -->
        <div id="footer" >
            <?php get_template_part('module/footer', null, array()); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>

