<?php wp_footer(); ?>
<?php get_template_part('module/widgetes/modal-forms', null, array()); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    var menuIcon = "<?php echo get_stylesheet_directory_uri(); ?>/img/svg/menu.svg";
    var closeIcon = "<?php echo get_stylesheet_directory_uri(); ?>/img/svg/close-white.svg";
</script>

<!--Библиотека слайдеров и каруселей   -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script  src="<?php echo get_stylesheet_directory_uri() . '/js/swiper.js'; ?>"></script>

<!--Библиотека всплывающих окон-->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

<script defer>
    const dirURL = "<?php echo get_stylesheet_directory_uri(); ?>";
</script>

<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/scripts.js"></script>

</body>
</html>
