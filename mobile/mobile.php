<?php
/**
 * NOHOME — Mobile Module
 *
 * Единая точка входа для всей мобильной логики.
 * Подключается из functions.php одной строкой.
 * header.php и footer.php содержат только вызов render-функций.
 *
 * Чтобы принудительно включить мобильный режим на десктопе (для отладки):
 * http://localhost:8000/?mobile=1
 */

// --------------------------------------------------------------------------
// Детектор устройства
// --------------------------------------------------------------------------

function nohome_is_mobile() {
    static $result = null;
    if ( $result === null ) {
        // ВРЕМЕННЫЙ ОТКАТ: мобайл включён ТОЛЬКО на локалке.
        // На проде всегда десктоп (включая телефоны), пока мобильная
        // версия дорабатывается. Чтобы вернуть мобайл на прод —
        // убрать этот блок с проверкой хоста.
        $host = isset( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : '';
        $is_local = ( strpos( $host, 'localhost' ) !== false
                   || strpos( $host, '127.0.0.1' ) !== false
                   || strpos( $host, '.local' ) !== false );

        if ( ! $is_local ) {
            // Прод — мобайл выключен полностью
            $result = false;
        } elseif ( ! empty( $_GET['desktop'] ) ) {
            // ?desktop=1 — принудительный десктоп (для iframe внутри мобайл-меню)
            $result = false;
        } elseif ( isset( $_GET['mobile'] ) ) {
            $result = (bool) $_GET['mobile'];
        } else {
            $result = wp_is_mobile();
        }
    }
    return $result;
}

/**
 * Прокидывает ?mobile=1 во внутренние ссылки, если текущий запрос идёт
 * в мобайл-режиме через ?mobile=1 (а не через wp_is_mobile / User-Agent).
 *
 * Нужно чтобы при клике на /0selectedarea3 с локалки (где UA = десктоп)
 * не происходило переключение на десктоп-шаблон. На реальном телефоне
 * wp_is_mobile() и так = true, параметр не добавляется (URL чище).
 */
function nohome_mobile_url( $url ) {
    if ( isset( $_GET['mobile'] ) ) {
        return add_query_arg( 'mobile', '1', $url );
    }
    return $url;
}

// --------------------------------------------------------------------------
// Заглушка для телефонов на проде
// --------------------------------------------------------------------------
// Пока мобильная версия дорабатывается, на проде телефоны видят простое
// сообщение, а не десктоп. На локалке поведение не меняется.
// Превью с любого устройства: ?chrismsg=1
// Обход (показать сайт): ?desktop=1

function nohome_is_local_host() {
    $host = isset( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : '';
    return ( strpos( $host, 'localhost' ) !== false
          || strpos( $host, '127.0.0.1' ) !== false
          || strpos( $host, '.local' ) !== false );
}

add_action( 'template_redirect', function() {
    // Принудительное превью сообщения с любого устройства
    if ( isset( $_GET['chrismsg'] ) ) {
        include get_template_directory() . '/mobile/pages/message.php';
        // message.php сам делает exit
    }

    if ( nohome_is_local_host() ) return;   // на локалке не трогаем
    if ( ! empty( $_GET['desktop'] ) ) return; // ручной обход
    if ( ! wp_is_mobile() ) return;         // десктоп не трогаем

    include get_template_directory() . '/mobile/pages/message.php';
} );

// --------------------------------------------------------------------------
// Рендер header / footer — вызываются из header.php и footer.php
// --------------------------------------------------------------------------

function nohome_mobile_render_header() {
    if ( ! nohome_is_mobile() ) return false;
    include __DIR__ . '/header-mobile.php';
    return true;
}

function nohome_mobile_render_footer() {
    if ( ! nohome_is_mobile() ) return false;
    include __DIR__ . '/footer-mobile.php';
    return true;
}

// --------------------------------------------------------------------------
// Перехват шаблона WP — подменяем шаблон для нужных мобильных страниц
// --------------------------------------------------------------------------

add_filter( 'template_include', function( $template ) {
    // Iframe из скелет-меню: ?desktop=1 + ?item=<key>.
    // Грузим лёгкий шаблон item-frame.php — он независим от шаблона главной
    // и гарантированно содержит #items-content (через layout-content).
    // Срабатывает ДО проверки nohome_is_mobile (?desktop=1 даёт false).
    if ( ! empty( $_GET['desktop'] ) && ! empty( $_GET['item'] ) ) {
        return get_template_directory() . '/mobile/pages/item-frame.php';
    }

    if ( ! nohome_is_mobile() ) return $template;

    if ( is_front_page() ) {
        $GLOBALS['nohome_mobile_is_home_template'] = true;
        return get_template_directory() . '/mobile/pages/home.php';
    }

    // ВСЁ остальное — универсальный inner-шаблон (3 экрана + iframe ?desktop=1)
    $GLOBALS['nohome_mobile_is_inner_template'] = true;
    return get_template_directory() . '/mobile/pages/inner.php';
} );

// Проверка: подключён ли сейчас мобайл-шаблон главной (home.php)
function nohome_mobile_is_home_template() {
    return ! empty( $GLOBALS['nohome_mobile_is_home_template'] );
}

// Проверка: подключён ли сейчас универсальный мобайл-шаблон (inner.php)
function nohome_mobile_is_inner_template() {
    return ! empty( $GLOBALS['nohome_mobile_is_inner_template'] );
}

// --------------------------------------------------------------------------
// Скрипты и стили — только для мобильных
// --------------------------------------------------------------------------

add_action( 'wp_enqueue_scripts', function() {
    // Подгружаем мобайл-CSS/JS и для item-frame режима (?desktop=1&item=...)
    // — там нужны .m-marquee-wrap, .m-skeleton-btn, partials меню и т.д.,
    // хотя nohome_is_mobile() сейчас false (ставится ?desktop=1).
    $is_item_frame = ! empty( $_GET['desktop'] ) && ! empty( $_GET['item'] );

    if ( ! nohome_is_mobile() && ! $is_item_frame ) return;

    // Версии через filemtime — авто-бампятся при каждом изменении файла,
    // не нужно править ручную "1.2" → "1.3" → "1.4".
    $css_path = get_template_directory() . '/css/mobile.css';
    $js_path  = get_template_directory() . '/js/mobile.js';

    wp_enqueue_style(
        'nohome-mobile',
        get_template_directory_uri() . '/css/mobile.css',
        array(),
        file_exists( $css_path ) ? filemtime( $css_path ) : '1.3'
    );

    wp_enqueue_script(
        'nohome-mobile',
        get_template_directory_uri() . '/js/mobile.js',
        array( 'jquery' ),
        file_exists( $js_path ) ? filemtime( $js_path ) : '1.3',
        true
    );

    wp_localize_script( 'nohome-mobile', 'mobileData', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'sticker_email_nonce' ),
        'tplUri'  => get_template_directory_uri(),
    ) );
} );
