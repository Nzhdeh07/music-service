<?php
setcookie('viewedProd['. $post->ID .']', $post->ID, time()+6600, COOKIEPATH, COOKIE_DOMAIN, false);

if ($_COOKIE['viewedProd']){
    if(count($_COOKIE['viewedProd']) > 6){
        unset($_COOKIE['viewedProd['. array_slice($_COOKIE['viewedProd'], 0, 1)[0] .']']);
        setcookie('viewedProd['. array_slice($_COOKIE['viewedProd'], 0, 1)[0] .']', '', time() - 3600, '/');
    }
}
?>

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
    <div class="flex-grow">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'entry' ); ?>
            <?php if ( comments_open() && !post_password_required() ) { comments_template( '', true ); } ?>
        <?php endwhile; endif; ?>
    </div>


    <!-- Футер для десктопа -->
    <div id="footer" >
        <?php get_template_part('module/footer', null, array()); ?>
    </div>

</div>

<?php get_footer(); ?>

