<form id="search" role="search" method="get" class="" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="flex justify-between  items-center search-container link">
        <div class="items-center search-icon p-2.5 box-border border border-solid border-customGreen rounded-[6px] cursor-pointer">
            <input type="search" placeholder="<?php echo esc_attr_x( 'Поиск...', 'placeholder' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Ищем:', 'label' ); ?>" id="voice-search"
                   class=" search-input hidden  w-full order-none focus:outline-non font-normal text-[14px] leading-6" required />
<!--            <input type="text" class="search-input hidden" placeholder="Поиск...">-->
            <img src="<?php echo get_stylesheet_directory_uri() . '/img/svg/search.svg'; ?>" alt="logo">
        </div>
    </div>
</form>
