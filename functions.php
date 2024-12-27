<?php

add_action('after_setup_theme', 'blankslate_setup');
function blankslate_setup()
{
    load_theme_textdomain('blankslate', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'navigation-widgets'));
    add_theme_support('appearance-tools');
    add_theme_support('woocommerce');
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1920;
    }
    register_nav_menus(array('main-menu' => esc_html__('Main Menu', 'blankslate')));
}

add_action('admin_notices', 'blankslate_notice');
function blankslate_notice()
{
    $user_id = get_current_user_id();
    $admin_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $param = (count($_GET)) ? '&' : '?';
    if (!get_user_meta($user_id, 'blankslate_notice_dismissed_11') && current_user_can('manage_options'))
        echo '<div class="notice notice-info"><p><a href="' . esc_url($admin_url), esc_html($param) . 'dismiss" class="alignright" style="text-decoration:none"><big>' . esc_html__('Ⓧ', 'blankslate') . '</big></a>' . wp_kses_post(__('<big><strong>🏆 Thank you for using BlankSlate!</strong></big>', 'blankslate')) . '<p>' . esc_html__('Powering over 10k websites! Buy me a sandwich! 🥪', 'blankslate') . '</p><a href="https://github.com/bhadaway/blankslate/issues/57" class="button-primary" target="_blank"><strong>' . esc_html__('How do you use BlankSlate?', 'blankslate') . '</strong></a> <a href="https://opencollective.com/blankslate" class="button-primary" style="background-color:green;border-color:green" target="_blank"><strong>' . esc_html__('Donate', 'blankslate') . '</strong></a> <a href="https://wordpress.org/support/theme/blankslate/reviews/#new-post" class="button-primary" style="background-color:purple;border-color:purple" target="_blank"><strong>' . esc_html__('Review', 'blankslate') . '</strong></a> <a href="https://github.com/bhadaway/blankslate/issues" class="button-primary" style="background-color:orange;border-color:orange" target="_blank"><strong>' . esc_html__('Support', 'blankslate') . '</strong></a></p></div>';
}


add_action('admin_init', 'blankslate_notice_dismissed');
function blankslate_notice_dismissed()
{
    $user_id = get_current_user_id();
    if (isset($_GET['dismiss']))
        add_user_meta($user_id, 'blankslate_notice_dismissed_11', 'true', true);
}


add_action('wp_enqueue_scripts', 'blankslate_enqueue');
function blankslate_enqueue()
{
    wp_enqueue_style('blankslate-style', get_stylesheet_uri());
    wp_enqueue_script('jquery');
}


add_action('wp_footer', 'blankslate_footer');
function blankslate_footer()
{
    ?>
    <script>
        jQuery(document).ready(function ($) {
            var deviceAgent = navigator.userAgent.toLowerCase();
            if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
                $("html").addClass("ios");
                $("html").addClass("mobile");
            }
            if (deviceAgent.match(/(Android)/)) {
                $("html").addClass("android");
                $("html").addClass("mobile");
            }
            if (navigator.userAgent.search("MSIE") >= 0) {
                $("html").addClass("ie");
            } else if (navigator.userAgent.search("Chrome") >= 0) {
                $("html").addClass("chrome");
            } else if (navigator.userAgent.search("Firefox") >= 0) {
                $("html").addClass("firefox");
            } else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
                $("html").addClass("safari");
            } else if (navigator.userAgent.search("Opera") >= 0) {
                $("html").addClass("opera");
            }
        });
    </script>
    <?php
}


add_filter('document_title_separator', 'blankslate_document_title_separator');
function blankslate_document_title_separator($sep)
{
    $sep = esc_html('|');
    return $sep;
}


add_filter('the_title', 'blankslate_title');
function blankslate_title($title)
{
    if ($title == '') {
        return esc_html('...');
    } else {
        return wp_kses_post($title);
    }
}

function blankslate_schema_type()
{
    $schema = 'https://schema.org/';
    if (is_single()) {
        $type = "Article";
    } elseif (is_author()) {
        $type = 'ProfilePage';
    } elseif (is_search()) {
        $type = 'SearchResultsPage';
    } else {
        $type = 'WebPage';
    }
    echo 'itemscope itemtype="' . esc_url($schema) . esc_attr($type) . '"';
}

add_filter('nav_menu_link_attributes', 'blankslate_schema_url', 10);

function blankslate_schema_url($atts)
{
    $atts['itemprop'] = 'url';
    return $atts;
}

if (!function_exists('blankslate_wp_body_open')) {
    function blankslate_wp_body_open()
    {
        do_action('wp_body_open');
    }
}

add_action('wp_body_open', 'blankslate_skip_link', 5);
function blankslate_skip_link()
{
    echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__('Skip to the content', 'blankslate') . '</a>';
}


add_filter('the_content_more_link', 'blankslate_read_more_link');
function blankslate_read_more_link()
{
    if (!is_admin()) {
        return ' <a href="' . esc_url(get_permalink()) . '" class="more-link">' . sprintf(__('...%s', 'blankslate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}


add_filter('excerpt_more', 'blankslate_excerpt_read_more_link');
function blankslate_excerpt_read_more_link($more)
{
    if (!is_admin()) {
        global $post;
        return ' <a href="' . esc_url(get_permalink($post->ID)) . '" class="more-link">' . sprintf(__('...%s', 'blankslate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}


add_filter('big_image_size_threshold', '__return_false');
add_filter('intermediate_image_sizes_advanced', 'blankslate_image_insert_override');
function blankslate_image_insert_override($sizes)
{
    unset($sizes['medium_large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    return $sizes;
}

add_action('widgets_init', 'blankslate_widgets_init');
function blankslate_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Sidebar Widget Area', 'blankslate'),
        'id' => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}

add_action('wp_head', 'blankslate_pingback_header');
function blankslate_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo('pingback_url')));
    }
}

add_action('comment_form_before', 'blankslate_enqueue_comment_reply_script');
function blankslate_enqueue_comment_reply_script()
{
    if (get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

function blankslate_custom_pings($comment)
{
    ?>
    <li <?php comment_class(); ?>
            id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url(comment_author_link()); ?></li>
    <?php
}

add_filter('get_comments_number', 'blankslate_comment_count', 0);
function blankslate_comment_count($count)
{
    if (!is_admin()) {
        global $id;
        $get_comments = get_comments('status=approve&post_id=' . $id);
        $comments_by_type = separate_comments($get_comments);
        return count($comments_by_type['comment']);
    } else {
        return $count;
    }
}

function change_post_menu_label()
{
    global $menu, $submenu;
    // Меняем название меню и добавляем иконку
    $menu[5][0] = 'Товары';
    $menu[5][6] = 'dashicons-cart';
    // Обновляем подменю
    $submenu['edit.php'][5][0] = 'Товары';
    $submenu['edit.php'][10][0] = 'Добавить товар';
    $submenu['edit.php'][16][0] = 'Товарные метки';
}

add_action('admin_menu', 'change_post_menu_label');

function change_post_object_label()
{
    global $wp_post_types;
    // Обновляем метки для объекта post
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Товары';
    $labels->singular_name = 'Товар';
    $labels->add_new = 'Добавить товар';
    $labels->add_new_item = 'Добавить товар';
    $labels->edit_item = 'Редактировать товар';
    $labels->new_item = 'Добавить товар';
    $labels->view_item = 'Посмотреть товар';
    $labels->search_items = 'Найти товар';
    $labels->not_found = 'Не найдено';
    $labels->not_found_in_trash = 'Корзина пуста';
    $labels->all_items = 'Все товары';
    $labels->menu_name = 'Товары';
    $labels->name_admin_bar = 'Товары';
}

add_action('init', 'change_post_object_label');


function register_blog_post_type()
{
    $labels = array(
        'name' => 'Блог',
        'singular_name' => 'Блог',
        'menu_name' => 'Блог',
        'name_admin_bar' => 'Блог',
        'add_new' => 'Добавить новый',
        'add_new_item' => 'Добавить новый блог',
        'new_item' => 'Новый блог',
        'edit_item' => 'Редактировать блог',
        'view_item' => 'Просмотреть блог',
        'all_items' => 'Все блоги',
        'search_items' => 'Найти блоги',
        'not_found' => 'Блоги не найдены',
        'not_found_in_trash' => 'В корзине блоги не найдены'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'blog'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'menu_icon' => 'dashicons-welcome-write-blog', // Иконка в меню админ-панели
        'menu_position' => 7,
    );

    register_post_type('blog', $args);
}

add_action('init', 'register_blog_post_type');

function register_services_post_type()
{
    $labels = array(
        'name' => 'Сервисы',
        'singular_name' => 'Сервис',
        'menu_name' => 'Сервисы',
        'name_admin_bar' => 'Сервис',
        'add_new' => 'Добавить ',
        'add_new_item' => 'Добавить сервис',
        'new_item' => 'Новый сервис',
        'edit_item' => 'Редактировать сервис',
        'view_item' => 'Просмотреть сервис',
        'all_items' => 'Все сервисы',
        'search_items' => 'Найти сервисы',
        'not_found' => 'Сервисы не найдены',
        'not_found_in_trash' => 'В корзине сервисы не найдены'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'services'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-admin-tools',
        'menu_position' => 4,
    );

    register_post_type('services', $args);
}

add_action('init', 'register_services_post_type');


// Добавляет поле для выбора изображения в форму добавления и редактирования рубрики
require_once __DIR__ . '/wp-term-image.php';
add_action('admin_init', [\Kama\WP_Term_Image::class, 'init']);


add_filter('wpseo_breadcrumb_separator', 'custom_breadcrumb_separator');
function custom_breadcrumb_separator($separator)
{
    return '<span>/</span>';
}

function exclude_pages_from_search($query)
{
    if ($query->is_search() && !is_admin() && $query->is_main_query()) {
        $query->set('post_type', 'post');
    }
}

add_action('pre_get_posts', 'exclude_pages_from_search');


if (function_exists('acf_add_options_page')) {
    // Главная страница
    acf_add_options_page(array(
        'page_title' => 'Настройки сайта',
        'menu_title' => 'Настройки сайта',
        'menu_slug' => 'general-settings',
        'capability' => 'manage_options',
        'redirect' => false
    ));
    acf_add_options_sub_page(array(
        'page_title' => 'Меню сайта',
        'menu_title' => 'menu',
        'parent_slug' => 'general-settings',
        'capability' => 'manage_options',
    ));
    acf_add_options_sub_page(array(
        'page_title' => 'Преимущества',
        'menu_title' => 'advantages',
        'parent_slug' => 'general-settings',
        'capability' => 'manage_options',
    ));
    acf_add_options_sub_page(array(
        'page_title' => 'О Нас',
        'menu_title' => 'about us',
        'parent_slug' => 'general-settings',
        'capability' => 'manage_options',
    ));
    acf_add_options_sub_page(array(
        'page_title' => 'Документы',
        'menu_title' => 'documents',
        'parent_slug' => 'general-settings',
        'capability' => 'manage_options',
    ));
}


add_filter('wpseo_breadcrumb_single_link', function ($link_output, $link) {
    if ($link['text'] === 'Главная страница') { // Замените на текущее название главной страницы
        $link_output = str_replace('Главная страница', 'Главная', $link_output);
    }
    return $link_output;
}, 10, 2);


function enqueue_fancybox()
{
    wp_enqueue_style('fancybox-css', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0.27/dist/fancybox.css');
    wp_enqueue_script('fancybox-js', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0.27/dist/fancybox.umd.js', array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'enqueue_fancybox');


if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Глобальные настройки для сервиса', // Название страницы
        'menu_title' => 'Настройки сервиса',               // Название в меню
        'menu_slug' => 'services-global-settings',      // Уникальный slug
        'capability' => 'manage_options',                // Права доступа
        'parent_slug' => 'edit.php?post_type=services',  // Родительский пункт меню
        'redirect' => false,                           // Отключаем редирект на подстраницы
    ));
}

function modify_posts_per_page($query)
{
    $query->set('posts_per_page', 12);
    if ($query->is_post_type_archive('services')) {
        $query->set('posts_per_page', 6);
    }
}
add_action('pre_get_posts', 'modify_posts_per_page');



add_filter('wpseo_breadcrumb_links', function ($links) {
    if (is_search()) {
        $search_query = get_search_query();

        // Сохраняем первую ссылку (обычно это ссылка на главную)
        $home_link = isset($links[0]) ? $links[0] : null;

        // Создаём новые хлебные крошки
        $custom_links = [];

        if ($home_link) {
            $custom_links[] = $home_link; // Добавляем ссылку на главную
        }

        $custom_links[] = [
            'url' => '',
            'text' => 'Вы искали: ' . $search_query,
            'allow_html' => true, // Позволяет использовать HTML в тексте
        ];

        return $custom_links;
    }
    return $links;
});


add_action('save_post', function ($post_id) {
    // Проверяем, что это не автосохранение и не ревизия
    if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
        return;
    }

    // Получаем категории поста
    $categories = wp_get_post_categories($post_id);

    // Если категории отсутствуют, ничего не делаем
    if (empty($categories)) {
        return;
    }

    // Сохраняем первую категорию как основную
    $primary_category = $categories[0];

    // Массив для хранения всех категорий (включая родительские)
    $all_categories = $categories;

    foreach ($categories as $category_id) {
        $parent_id = get_category($category_id)->parent;

        // Проверяем родительскую категорию и добавляем её, если ещё не добавлена
        while ($parent_id) {
            if (!in_array($parent_id, $all_categories)) {
                $all_categories[] = $parent_id;
            }
            $parent_id = get_category($parent_id)->parent;
        }
    }

    // Обновляем категории поста, включая родительские, и устанавливаем основную категорию
    wp_set_post_categories($post_id, $all_categories, false);

    // Устанавливаем основную категорию
    update_post_meta($post_id, '_yoast_wpseo_primary_category', $primary_category);
});


function allow_audio_upload($mime_types) {
    $mime_types['wav'] = 'audio/wav'; // Разрешить файлы .wav
    $mime_types['mp3'] = 'audio/mpeg'; // Разрешить файлы .mp3
    return $mime_types;
}
add_filter('upload_mimes', 'allow_audio_upload');






add_action('wp_ajax_upload_audio_to_wordpress', 'handle_audio_upload');
add_action('wp_ajax_nopriv_upload_audio_to_wordpress', 'handle_audio_upload');

function handle_audio_upload() {
    // Проверяем nonce, если вы используете его для безопасности (рекомендуется)
    if (!empty($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'audio_upload_nonce')) {
        wp_send_json_error(['message' => 'Неверный nonce.'], 400);
        wp_die();
    }

    // Проверяем наличие загруженного файла
    if (empty($_FILES['audio_file'])) {
        wp_send_json_error(['message' => 'Файл не загружен.'], 400);
        wp_die();
    }

    $file = $_FILES['audio_file'];

    // Проверяем тип файла
    $allowed_mime_types = ['audio/wav', 'audio/mp3'];
    if (!in_array($file['type'], $allowed_mime_types)) {
        wp_send_json_error(['message' => 'Недопустимый тип файла.'], 400);
        wp_die();
    }

    // Используем WP-функцию для загрузки файла в медиа-библиотеку
    $upload = wp_handle_upload($file, ['test_form' => false]);

    if (isset($upload['error'])) {
        wp_send_json_error(['message' => $upload['error']], 500);
        wp_die();
    }

    // Добавляем файл в медиа-библиотеку
    $attachment_id = wp_insert_attachment([
        'guid'           => $upload['url'], // URL загруженного файла
        'post_mime_type' => $upload['type'], // MIME-тип файла
        'post_title'     => sanitize_file_name($file['name']), // Название файла
        'post_content'   => '', // Описание (необязательно)
        'post_status'    => 'inherit' // Статус вложения
    ], $upload['file']);

    // Создаем метаданные для вложения
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $upload['file']));

    // Отправляем успешный ответ с ID и URL файла
    wp_send_json_success([
        'message' => 'Файл успешно загружен.',
        'attachment_id' => $attachment_id,
        'url' => wp_get_attachment_url($attachment_id)
    ]);
}
