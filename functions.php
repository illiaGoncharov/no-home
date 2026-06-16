<?php
// Мобильный модуль — вся логика в одном месте
require_once get_template_directory() . '/mobile/mobile.php';

/**
 * Скрипты и стили — только десктоп.
 * Мобильные ресурсы подключаются в mobile/mobile.php.
 */
function my_enqueue_scripts() {
    if ( nohome_is_mobile() ) return;

    wp_enqueue_script('jquery');
    wp_enqueue_script('nav-tools', get_template_directory_uri() . '/js/nav-tools.js', array('jquery'), null, true);
    wp_enqueue_script('horse-text-handler', get_template_directory_uri() . '/js/horse-text-handler.js', array('jquery'), null, true);
    wp_enqueue_script('attic', get_template_directory_uri() . '/js/attic.js', array('jquery'), filemtime(get_template_directory() . '/js/attic.js'), true);

    wp_localize_script('horse-text-handler', 'stickerEmailData', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('sticker_email_nonce')
    ));

    wp_localize_script('nav-tools', 'ajaxData', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

/**
 * Функция для загрузки контента страницы через AJAX
 * Получает ID страницы и возвращает её содержимоеskeleton-button
 */
function load_page_content() {
    // Получить ID страницы из POST-запроса
    $page_id = intval($_POST['page_id']);

    if (!$page_id) {
        echo 'Invalid page ID';
        wp_die();
    }

    // Получить данные страницы
    $page = get_post($page_id);

    if ($page && $page->post_type == 'page') {
        // Буферизация вывода для корректной обработки контента
        ob_start();

        // Вывод миниатюры страницы, если она есть
        if (has_post_thumbnail($page_id)) {
            echo get_the_post_thumbnail($page_id, 'full');
        }

        // Вывод основного контента страницы
        echo apply_filters('the_content', $page->post_content);
        $content = ob_get_clean();

        echo $content;
    } else {
        echo 'Page not found';
    }

    wp_die(); // Завершение запроса
}

add_action('wp_ajax_load_page_content', 'load_page_content');
add_action('wp_ajax_nopriv_load_page_content', 'load_page_content');

/**
 * Функция для загрузки контента элементов через AJAX
 * Загружает содержимое из файлов в директории items
 */
function load_items_content() {
    $content = sanitize_text_field($_POST['content']);
    $file_path = get_template_directory() . "/items/{$content}-content.php";
    
    if (file_exists($file_path)) {
        include($file_path);
    } else {
        echo 'Content not found.';
    }
    wp_die();
}
add_action('wp_ajax_load_items_content', 'load_items_content');
add_action('wp_ajax_nopriv_load_items_content', 'load_items_content');

/**
 * Функция для сохранения пользовательского текста в файл
 * Сохраняет текст в файл user_sticker_text.txt в директории uploads
 */
function save_user_text_file() {
    $user_text = sanitize_text_field($_POST['user_text']);

    // Путь к файлу для сохранения текста
    $file_path = WP_CONTENT_DIR . '/uploads/user_sticker_text.txt'; 

    // Создание файла, если он не существует
    if (!file_exists($file_path)) {
        $file = fopen($file_path, 'w');
        fclose($file);
    }

    // Добавление текста в конец файла
    file_put_contents($file_path, $user_text . "\n", FILE_APPEND);

    wp_send_json_success(array('message' => 'Text saved to file.'));
}
add_action('wp_ajax_save_user_text_file', 'save_user_text_file');

/**
 * Функция для отключения кэширования
 * Устанавливает заголовки для предотвращения кэширования
 */
function no_cache_headers() {
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
}
add_action('send_headers', 'no_cache_headers');

/**
 * Функция для загрузки скриптов Barba.js и GSAP
 * Подключает библиотеки для анимации переходов между страницами
 */
function enqueue_barba_gsap_scripts() {
    wp_enqueue_script('barba', 'https://cdn.jsdelivr.net/npm/@barba/core@2.10.0/dist/barba.umd.js', array(), '2.10.0', true);
    wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js', array(), '3.9.1', true);
    wp_enqueue_script('custom-transition', get_template_directory_uri() . '/js/custom-transition.js', array('barba', 'gsap'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_barba_gsap_scripts');

/**
 * Основная функция настройки темы
 * Регистрирует поддержку различных функций WordPress
 */
add_action('after_setup_theme', 'blankslate_setup');
function blankslate_setup() {
    load_theme_textdomain('blankslate', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'navigation-widgets'));
    add_theme_support('appearance-tools');
    add_theme_support('woocommerce');
    global $content_width;
    if (!isset($content_width)) { $content_width = 1920; }
    register_nav_menus(array('main-menu' => esc_html__('Main Menu', 'blankslate')));
}

/**
 * Функция для отображения уведомления в админ-панели
 * Показывает благодарность за использование темы и ссылки на поддержку
 */
add_action('admin_notices', 'blankslate_notice');
function blankslate_notice() {
    $user_id = get_current_user_id();
    $admin_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $param = (count($_GET)) ? '&' : '?';
    if (!get_user_meta($user_id, 'blankslate_notice_dismissed_11') && current_user_can('manage_options'))
        echo '<div class="notice notice-info"><p><a href="' . esc_url($admin_url), esc_html($param) . 'dismiss" class="alignright" style="text-decoration:none"><big>' . esc_html__('Ⓧ', 'blankslate') . '</big></a>' . wp_kses_post(__('<big><strong>🏆 Thank you for using BlankSlate!</strong></big>', 'blankslate')) . '<p>' . esc_html__('Powering over 10k websites! Buy me a sandwich! 🥪', 'blankslate') . '</p><a href="https://github.com/bhadaway/blankslate/issues/57" class="button-primary" target="_blank"><strong>' . esc_html__('How do you use BlankSlate?', 'blankslate') . '</strong></a> <a href="https://opencollective.com/blankslate" class="button-primary" style="background-color:green;border-color:green" target="_blank"><strong>' . esc_html__('Donate', 'blankslate') . '</strong></a> <a href="https://wordpress.org/support/theme/blankslate/reviews/#new-post" class="button-primary" style="background-color:purple;border-color:purple" target="_blank"><strong>' . esc_html__('Review', 'blankslate') . '</strong></a> <a href="https://github.com/bhadaway/blankslate/issues" class="button-primary" style="background-color:orange;border-color:orange" target="_blank"><strong>' . esc_html__('Support', 'blankslate') . '</strong></a></p></div>';
}

/**
 * Функция для обработки закрытия уведомления
 * Сохраняет метаданные о закрытии уведомления для пользователя
 */
add_action('admin_init', 'blankslate_notice_dismissed');
function blankslate_notice_dismissed() {
    $user_id = get_current_user_id();
    if (isset($_GET['dismiss']))
        add_user_meta($user_id, 'blankslate_notice_dismissed_11', 'true', true);
}

/**
 * Функция для загрузки основных стилей и скриптов темы
 */
add_action('wp_enqueue_scripts', 'blankslate_enqueue');
function blankslate_enqueue() {
    // Версия — filemtime, чтобы кэш браузера сбрасывался при изменениях
    wp_enqueue_style(
        'blankslate-style',
        get_stylesheet_uri(),
        array(),
        filemtime( get_stylesheet_directory() . '/style.css' )
    );
    wp_enqueue_script('jquery');
}

/**
 * Функция для добавления классов к тегу html в зависимости от устройства и браузера
 * Определяет тип устройства и браузера пользователя
 */
add_action('wp_footer', 'blankslate_footer');
function blankslate_footer() {
    ?>
    <script>
    jQuery(document).ready(function($) {
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

/**
 * Функция для установки разделителя в заголовке страницы
 */
add_filter('document_title_separator', 'blankslate_document_title_separator');
function blankslate_document_title_separator($sep) {
    $sep = esc_html('|');
    return $sep;
}

/**
 * Функция для обработки пустых заголовков
 * Заменяет пустой заголовок на многоточие
 */
add_filter('the_title', 'blankslate_title');
function blankslate_title($title) {
    if ($title == '') {
        return esc_html('...');
    } else {
        return wp_kses_post($title);
    }
}

/**
 * Функция для определения типа схемы в зависимости от типа страницы
 * Используется для микроразметки Schema.org
 */
function blankslate_schema_type() {
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

/**
 * Функция для добавления атрибута itemprop="url" к ссылкам меню
 * Используется для микроразметки Schema.org
 */
add_filter('nav_menu_link_attributes', 'blankslate_schema_url', 10);
function blankslate_schema_url($atts) {
    $atts['itemprop'] = 'url';
    return $atts;
}

/**
 * Функция для поддержки wp_body_open
 * Обеспечивает обратную совместимость с более старыми версиями WordPress
 */
if (!function_exists('blankslate_wp_body_open')) {
    function blankslate_wp_body_open() {
        do_action('wp_body_open');
    }
}

/**
 * Функция для добавления ссылки "Пропустить к содержимому"
 * Улучшает доступность для пользователей с ограниченными возможностями
 */
add_action('wp_body_open', 'blankslate_skip_link', 5);
function blankslate_skip_link() {
    echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__('Skip to the content', 'blankslate') . '</a>';
}

/**
 * Функция для настройки ссылки "Читать далее" в контенте
 */
add_filter('the_content_more_link', 'blankslate_read_more_link');
function blankslate_read_more_link() {
    if (!is_admin()) {
        return ' <a href="' . esc_url(get_permalink()) . '" class="more-link">' . sprintf(__('...%s', 'blankslate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}

/**
 * Функция для настройки ссылки "Читать далее" в анонсах
 */
add_filter('excerpt_more', 'blankslate_excerpt_read_more_link');
function blankslate_excerpt_read_more_link($more) {
    if (!is_admin()) {
        global $post;
        return ' <a href="' . esc_url(get_permalink($post->ID)) . '" class="more-link">' . sprintf(__('...%s', 'blankslate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}

/**
 * Отключает ограничение размера больших изображений
 */
add_filter('big_image_size_threshold', '__return_false');

/**
 * Функция для настройки размеров изображений
 * Удаляет ненужные размеры изображений для оптимизации
 */
add_filter('intermediate_image_sizes_advanced', 'blankslate_image_insert_override');
function blankslate_image_insert_override($sizes) {
    unset($sizes['medium_large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    return $sizes;
}

/**
 * Функция для регистрации области виджетов
 * Создает область для размещения виджетов в сайдбаре
 */
add_action('widgets_init', 'blankslate_widgets_init');
function blankslate_widgets_init() {
    register_sidebar(array(
        'name' => esc_html__('Sidebar Widget Area', 'blankslate'),
        'id' => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}

/**
 * Функция для добавления pingback-заголовка
 * Используется для уведомлений о ссылках на страницу
 */
add_action('wp_head', 'blankslate_pingback_header');
function blankslate_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo('pingback_url')));
    }
}

/**
 * Функция для загрузки скрипта ответов на комментарии
 * Загружается только если включена поддержка вложенных комментариев
 */
add_action('comment_form_before', 'blankslate_enqueue_comment_reply_script');
function blankslate_enqueue_comment_reply_script() {
    if (get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

/**
 * Функция для отображения pingback-комментариев
 */
function blankslate_custom_pings($comment) {
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url(comment_author_link()); ?></li>
    <?php
}

/**
 * Функция для подсчета количества комментариев
 * Учитывает только одобренные комментарии
 */
add_filter('get_comments_number', 'blankslate_comment_count', 0);
function blankslate_comment_count($count) {
    if (!is_admin()) {
        global $id;
        $get_comments = get_comments('status=approve&post_id=' . $id);
        $comments_by_type = separate_comments($get_comments);
        return count($comments_by_type['comment']);
    } else {
        return $count;
    }
}

/**
 * Функция для добавления пользовательского курсора
 * (В настоящее время пустая, может быть использована для добавления кастомного курсора)
 */
function add_custom_cursor() {
    ?>
    <?php
}
add_action('wp_footer', 'add_custom_cursor');

/**
 * Функция для настройки аутентификации REST API
 * Разрешает доступ к REST API без аутентификации
 */
add_filter( 'rest_authentication_errors', function( $result ) {
    if ( true === $result || is_wp_error( $result ) ) {
        return $result;
    }
    return true;
});

// 1. Локализуем скрипт для передачи ajaxurl и nonce в JavaScript
function enqueue_sticker_scripts() {
    // !!! ВАЖНО: Замените 'your-theme-main-script' на фактический идентификатор (handle) вашего основного JS-файла, 
    // если вы подключаете его через wp_enqueue_script. 
    // Если ваш JS код находится прямо в main[local].php (инлайн), этот способ НЕ сработает.
    // Вместо этого вам нужно будет добавить блок <script> с объектом stickerAjax прямо в main[local].php 
    // ПЕРЕД вашим основным скриптом, как показано ниже.
    
    // Пример, ЕСЛИ у вас есть идентификатор скрипта 'your-theme-main-script':
    // wp_localize_script('your-theme-main-script', 'stickerAjax', array(
    //     'ajaxurl' => admin_url('admin-ajax.php'),
    //     'nonce'   => wp_create_nonce('sticker_email_nonce') // Создаем nonce
    // ));

    // ЕСЛИ ваш JS встроен (inline) в main[local].php, добавьте ЭТОТ <script> блок 
    // в main[local].php перед вашим <script> с логикой стикеров:
    /*
    <script>
      const stickerAjax = {
        ajaxurl: "<?php echo admin_url('admin-ajax.php'); ?>",
        nonce: "<?php echo wp_create_nonce('sticker_email_nonce'); ?>"
      };
    </script>
    */
    // В этом случае, PHP функция enqueue_sticker_scripts() и add_action ниже НЕ НУЖНЫ.
}
// Подключаем функцию локализации, ЕСЛИ используется wp_enqueue_script для основного JS
// add_action('wp_enqueue_scripts', 'enqueue_sticker_scripts'); 

// 2. Функция-обработчик AJAX для отправки письма
function handle_send_sticker_email() {
    check_ajax_referer('sticker_email_nonce', 'security');

    if (isset($_POST['user_text'])) {
        $user_text = sanitize_textarea_field($_POST['user_text']);
        $to = array(
            'karnebero@gmail.com', 
            'n0h0me.cl0ud.me@gmail.com'
        ); // Список получателей
        $subject = 'Новый текст со стикера';
        $body = "Текст со стикера:\n\n" . $user_text;
        $headers = array('Content-Type: text/plain; charset=UTF-8');

        $sent = wp_mail($to, $subject, $body, $headers);

        if ($sent) {
            wp_send_json_success(array('message' => 'Письмо отправлено'));
        } else {
            wp_send_json_error(array('message' => 'Не удалось отправить письмо'));
        }
    }

    wp_die();
}

// Подключаем обработчик AJAX для залогиненных и незалогиненных пользователей
add_action('wp_ajax_send_sticker_email', 'handle_send_sticker_email'); // Для залогиненных
add_action('wp_ajax_nopriv_send_sticker_email', 'handle_send_sticker_email'); // Для гостей

// --- Конец кода для functions.php ---

function localize_sticker_script() {
    wp_localize_script('your-main-script', 'stickerEmailData', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('sticker_email_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'localize_sticker_script');
?>