<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="flex gap-1.5 items-center  ">
        <!-- Поле ввода -->
        <input  type="search" placeholder="<?php echo esc_attr_x( 'Поиск по названию / артикул', 'placeholder' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Ищем:', 'label' ); ?>" id="voice-search"
               class="ultraWideDesktop:w-[222px] w-[473px] h-9 box-border  py-2 px-3  font-normal text-sm  border border-solid border-customBlue-search rounded-md focus:outline-none" required />

        <button type="submit"
                class="py-2 px-4 rounded-md bg-customGreen-dark link font-normal text-sm leading-5 text-white ">
            Поиск
        </button>
    </div>

</form>
