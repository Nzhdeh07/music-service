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
        <div class="flex-grow flex-1 px-2.5 py-5">
            <h1 class="font-medium text-[24px] leading-[34px] text-black" >
                Возможно, в адресной строке была допущена ошибка. </h1>
            <h1 class="font-medium text-[24px] leading-[34px] text-black" > Перейдите на нашу
                <a href="/" class="text-blue-500 underline">главную страницу</a> чтобы найти то, что вам нужно.
            </h1>
        </div>


        <!-- Футер -->
        <div id="footer" >
            <?php get_template_part('module/footer', null, array()); ?>
        </div>
    </div>

<?php get_footer(); ?>