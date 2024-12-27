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
    <div class="flex flex-col flex-grow gap-5  py-5 ">

        <div class="px-5 mobileLandscape:px-2.5">
            <?php $background_image = get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
            <div class="relative flex flex-col  items-center justify-center gap-2.5 py-5 px-4 rounded-md bg-cover bg-center"
                 style="background-image: url('<?php echo esc_url($background_image); ?>');">
                <div class="absolute z-10 inset-0 bg-[hsla(0,0%,85%,0.8)] rounded-md pointer-events-none"></div>
                <div class="z-20 text-center font-medium text-[36px] leading-[54px] mobileLandscape:text-[28px] mobileLandscape:leading-[42px] text-black"><?php echo get_the_title(); ?></div>

                <!-- Хлебные крошки (Yoast SEO) -->
                <?php if (function_exists('yoast_breadcrumb')): ?>
                    <div id="text-black" class="z-20 text-center font-normal text-[14px] leading-5 text-breadcrumb">
                        <?php yoast_breadcrumb('<p  class="breadcrumbs-text  last-gray underscore">', '</p>'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php get_template_part('entry-blog'); ?>
            <?php if (comments_open() && !post_password_required()) {
                comments_template('', true);
            } ?>
        <?php endwhile; endif; ?>

        <footer class="footer">
            <div class="px-5 mobileLandscape:px-2.5">
                <div class="flex justify-center gap-5">
                    <div class="previous-post py-2 px-3 rounded-md bg-customGreen-dark font-medium text-sm leading-6 text-white cursor-pointer <?php if (!get_previous_post()) echo 'hidden'; ?>" onclick="window.location='<?php echo get_permalink(get_previous_post()->ID); ?>';">
                        Предыдущая запись
                    </div>

                    <div class="next-post py-2 px-3 rounded-md bg-customGreen-dark font-medium text-sm leading-6 text-white cursor-pointer <?php if (!get_next_post()) echo 'hidden'; ?>" onclick="window.location='<?php echo get_permalink(get_next_post()->ID); ?>';">
                        Следующая запись
                    </div>

                </div>
            </div>

            <?php get_template_part('nav', 'below-single'); ?>
        </footer>

        <!--Блок "Contact Information" -->
        <div class="px-5 mobileLandscape:px-2.5">
            <div class="grid grid-cols-2 tabletPortrait:grid-cols-1 gap-5 mobileLandscape:gap-5">
                <?php $map_iframe = get_field('ci-map', 'options'); ?>
                <div style="height: 360px" class="tabletPortrait:order-2 rounded-md overflow-hidden">
                    <?php echo $map_iframe ?>
                </div>

                <div class="tabletPortrait:order-1 flex flex-col p-[15px] mobileLandscape:py-6 mobileLandscape:px-2.5 gap-5 rounded-md bg-customGreen-contact">
                    <div class="font-medium text-xl leading-6">Контактная инфомация</div>

                    <div class="grid grid-cols-2 mobilePortrait:grid-cols-1 gap-5 max-w-[600px]">
                        <div class="flex flex-col gap-2.5">
                            <a class="flex gap-[5px] items-center link"
                               href="tel:<?php echo preg_replace('/\D/', '', get_field('contact-1', 'options')); ?>">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.804 12.194C13.685 12.446 13.531 12.684 13.328 12.908C12.985 13.286 12.607 13.559 12.18 13.734C11.76 13.909 11.305 14 10.815 14C10.101 14 9.338 13.832 8.533 13.489C7.728 13.146 6.923 12.684 6.125 12.103C5.32 11.515 4.557 10.864 3.829 10.143C3.108 9.415 2.457 8.652 1.876 7.854C1.302 7.056 0.84 6.258 0.504 5.467C0.168 4.669 0 3.906 0 3.178C0 2.702 0.0839999 2.247 0.252 1.827C0.42 1.4 0.686 1.008 1.057 0.658C1.505 0.217 1.995 0 2.513 0C2.709 0 2.905 0.042 3.08 0.126C3.262 0.21 3.423 0.336 3.549 0.518L5.173 2.807C5.299 2.982 5.39 3.143 5.453 3.297C5.516 3.444 5.551 3.591 5.551 3.724C5.551 3.892 5.502 4.06 5.404 4.221C5.313 4.382 5.18 4.55 5.012 4.718L4.48 5.271C4.403 5.348 4.368 5.439 4.368 5.551C4.368 5.607 4.375 5.656 4.389 5.712C4.41 5.768 4.431 5.81 4.445 5.852C4.571 6.083 4.788 6.384 5.096 6.748C5.411 7.112 5.747 7.483 6.111 7.854C6.489 8.225 6.853 8.568 7.224 8.883C7.588 9.191 7.889 9.401 8.127 9.527C8.162 9.541 8.204 9.562 8.253 9.583C8.309 9.604 8.365 9.611 8.428 9.611C8.547 9.611 8.638 9.569 8.715 9.492L9.247 8.967C9.422 8.792 9.59 8.659 9.751 8.575C9.912 8.477 10.073 8.428 10.248 8.428C10.381 8.428 10.521 8.456 10.675 8.519C10.829 8.582 10.99 8.673 11.165 8.792L13.482 10.437C13.664 10.563 13.79 10.71 13.867 10.885C13.937 11.06 13.979 11.235 13.979 11.431C13.979 11.683 13.923 11.942 13.804 12.194Z"
                                          fill="black"/>
                                </svg>
                                <p class="font-semibold leading-5 "><?php echo get_field('contact-1', 'options') ?></p>
                            </a>

                            <p class="font-medium text-sm leading-5">
                                <?php echo get_field('adress', 'options'); ?>
                            </p>

                            <a class="link font-medium text-sm leading-5  "
                               href="mailto:<?php echo get_field('mail', 'options'); ?>">
                                <?php echo get_field('mail', 'options'); ?>
                            </a>
                        </div>

                        <!-- Сервис  -->
                        <?php $contacts = get_field('service-contacts', 'options') ?>
                        <?php if ($contacts) : ?>
                            <div class="flex flex-col gap-2.5 ">
                                <p class="font-bold leading-6 text-customGreen-dark">Сервис</p>
                                <?php foreach ($contacts as $contact) : ?>
                                    <a class=" link"
                                       href="tel:<?php echo preg_replace('/\D/', '', $contact['sv-contact']); ?>">
                                        <p class="font-semibold leading-5  "><?php echo $contact['sv-contact'] ?></p>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Запчасти  -->
                        <?php $contacts = get_field('spares-contacts', 'options') ?>
                        <?php if ($contacts) : ?>
                            <div class="flex flex-col gap-2.5 ">
                                <p class="font-bold  leading-6 text-customGreen-dark ">Запчасти</p>
                                <?php foreach ($contacts as $contact) : ?>
                                    <a class=" link"
                                       href="tel:<?php echo preg_replace('/\D/', '', $contact['spr-contact']); ?>">
                                        <p class="font-semibold leading-5 "><?php echo $contact['spr-contact'] ?></p>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Бухгалтерия  -->
                        <?php $contacts = get_field('accounting-contacts', 'options') ?>
                        <?php if ($contacts) : ?>
                            <div class="flex flex-col gap-2.5 ">
                                <p class=" font-bold leading-6 text-customGreen-dark">Бухгалтерия</p>
                                <?php foreach ($contacts as $contact) : ?>
                                    <a class=" link"
                                       href="tel:<?php echo preg_replace('/\D/', '', $contact['acn-contact']); ?>">
                                        <p class="font-semibold leading-5 "><?php echo $contact['acn-contact'] ?></p>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>


                        <div class="flex flex-col gap-2.5 ">
                            <p class=" font-bold leading-6 text-customGreen-dark">Мы в соц. сетях</p>
                            <div class="flex  items-center gap-2.5">
                                <a class="link" href="#" target="_blank"
                                   rel="noopener noreferrer">
                                    <img  style="width: 50px; height: 50px;" src="<?php echo get_stylesheet_directory_uri() . '/img/svg/instagram.svg'; ?>"
                                          alt="Instagram">
                                </a>
                                <a class="link" href="#" target="_blank" rel="noopener noreferrer">
                                    <img style="width: 50px; height: 50px;" src="<?php echo get_stylesheet_directory_uri() . '/img/svg/viber.svg'; ?>"
                                         alt="Instagram">
                                </a>
                                <a class="link" href="#" target="_blank" rel="noopener noreferrer">
                                    <img style="width: 50px; height: 50px;" src="<?php echo get_stylesheet_directory_uri() . '/img/svg/whatsapp.svg'; ?>"
                                         alt="Instagram">
                                </a>
                                <a class="link" href="#" target="_blank" rel="noopener noreferrer">
                                    <img style="width: 50px; height: 50px;" src="<?php echo get_stylesheet_directory_uri() . '/img/svg/telegram.svg'; ?>"
                                         alt="Instagram">
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <button class="max-w-max py-1.5 px-4 rounded-md bg-customGreen-dark font-medium text-sm leading-6 text-white link"
                                    data-fancybox data-src="#contact-modal">
                                Связаться
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Футер -->
    <div id="footer">
        <?php get_template_part('module/footer', null, array()); ?>
    </div>
</div>

<?php get_footer(); ?>




