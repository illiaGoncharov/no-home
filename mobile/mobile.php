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
        if ( isset( $_GET['mobile'] ) ) {
            $result = (bool) $_GET['mobile'];
        } else {
            $result = wp_is_mobile();
        }
    }
    return $result;
}

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
    if ( ! nohome_is_mobile() ) return $template;

    if ( is_front_page() ) {
        return get_template_directory() . '/mobile/pages/home.php';
    }

    return $template;
} );

// --------------------------------------------------------------------------
// Скрипты и стили — только для мобильных
// --------------------------------------------------------------------------

add_action( 'wp_enqueue_scripts', function() {
    if ( ! nohome_is_mobile() ) return;

    wp_enqueue_style(
        'nohome-mobile',
        get_template_directory_uri() . '/css/mobile.css',
        array(),
        '1.0'
    );

    wp_enqueue_script(
        'nohome-mobile',
        get_template_directory_uri() . '/js/mobile.js',
        array( 'jquery' ),
        '1.0',
        true
    );

    wp_localize_script( 'nohome-mobile', 'mobileData', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'sticker_email_nonce' ),
    ) );
} );
