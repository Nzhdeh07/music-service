<?php get_header(); ?>


<div class="flex flex-col min-h-full">

    <!-- Основной контент -->
    <div class="flex flex-grow flex-1 flex-col gap-10 items-center justify-center">
        <div class="flex items-center justify-center">
            <button id="recording-btn" class="w-48 h-48 bg-customGreen-dark text-white rounded-full flex items-center justify-center text-xl">
                Начать запись
            </button>
        </div>
        <div id="response"></div>
    </div>

    <!-- Футер -->
<!--    <div id="footer">-->
<!--        --><?php //get_template_part('module/footer', null, array()); ?>
<!--    </div>-->
</div>

<?php get_footer(); ?>


<!--<div class="px-5 mobileLandscape:px-2.5">-->
<!--    <div class="flex flex-col gap-2.5 ">-->
<!--        <div>Бренды запчастей</div>-->
<!--    </div>-->
<!---->
<!--</div>-->