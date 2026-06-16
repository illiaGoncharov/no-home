<?php
/**
 * Универсальный мобайл-шаблон для всех не-главных страниц.
 *
 * Стартовая точка: центральная секция = iframe ?desktop=1 с десктоп-версией.
 * 3 экрана (300vw), пользователь видит центр, может свайпить влево/вправо
 * (там пусто — будто оглядывается).
 *
 * Подключается из mobile/mobile.php через template_include для всего,
 * что не is_front_page().
 */

get_header();

$tpl = get_template_directory_uri();

// URL текущей страницы + ?desktop=1 (плюс перенос item= если был)
$current_path  = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
$current_query = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY );
parse_str( (string) $current_query, $qs );
$qs['desktop'] = '1';

$scheme       = ( is_ssl() ? 'https' : 'http' );
$base_url     = $scheme . '://' . $_SERVER['HTTP_HOST'] . $current_path;
$iframe_url   = $base_url . '?' . http_build_query( $qs );

// 3D-комнаты (0selectedarea*) показываем на 300vw — свайп «оглядывается».
// Остальные (текстовые: about и т.п.) — один экран 100vw, иначе текст
// рендерится втрое шире и не вмещается.
$nh_queried = get_queried_object();
$nh_slug    = ( $nh_queried && isset( $nh_queried->post_name ) ) ? $nh_queried->post_name : '';
$nh_is_room = ( strpos( $nh_slug, '0selectedarea' ) === 0 );
$nh_inner_class = $nh_is_room ? 'm-inner-room' : 'm-inner-flat';
?>

<div class="m-home m-inner <?php echo esc_attr( $nh_inner_class ); ?>" id="mHome">

    <!-- Бегущая строка — лошадка слева, текст бежит -->
    <div class="m-marquee-wrap" aria-hidden="true">
        <div class="m-marquee-horse">
            <img src="<?php echo $tpl; ?>/files/mobile/home/red-horse-running-text.png" alt="">
        </div>
        <div class="m-marquee-scroll">
            <div class="m-marquee-track">
                <?php
                $texts = [
                    'no home',
                    'sorry for being weird it\'s my first time being alive',
                    'no home',
                    'you can move me and listen to me',
                ];
                for ( $i = 0; $i < 2; $i++ ) {
                    foreach ( $texts as $t ) {
                        echo '<span>' . esc_html( $t ) . '</span>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <!-- 3-экранный скролл-контейнер.
         Iframe вынесен поверх трека (300vw) — по аналогии с .m-stickers-overlay
         на главной. Секции остаются как «направляющие» для scroll-snap и стрелок. -->
    <div class="m-rooms-scroll" id="mRoomsScroll">
        <div class="m-rooms-track">

            <!-- Iframe-оверлей на всю ширину трека -->
            <iframe
                class="m-inner-iframe"
                src="<?php echo esc_url( $iframe_url ); ?>"
                loading="eager"
                title="<?php echo esc_attr( wp_get_document_title() ); ?>"></iframe>

            <!-- 3 пустые секции — только для scroll-snap/стрелок -->
            <div class="m-section" data-idx="0"></div>
            <div class="m-section" data-idx="1"></div>
            <div class="m-section" data-idx="2"></div>

        </div>
    </div>

    <!-- Стрелки навигации -->
    <button class="m-arrow m-arrow-left"  id="mArrowLeft"  aria-label="Previous">
        <img src="<?php echo $tpl; ?>/files/mobile/home/arrow-left.png"  alt="">
    </button>
    <button class="m-arrow m-arrow-right" id="mArrowRight" aria-label="Next">
        <img src="<?php echo $tpl; ?>/files/mobile/home/arrow-right.png" alt="">
    </button>

    <!-- Нижний градиент -->
    <div class="m-bottom-gradient" aria-hidden="true"></div>

    <!-- Скелет — кнопка открытия меню -->
    <button class="m-skeleton-btn" id="mSkeletonBtn" aria-label="Open menu">
        <img src="<?php echo $tpl; ?>/files/mobile/home/skeleton-bottom.png" alt="" draggable="false">
    </button>

</div><!-- /.m-inner -->

<!-- Общие оверлеи меню -->
<?php include get_template_directory() . '/mobile/partials/skeleton-menu.php'; ?>
<?php include get_template_directory() . '/mobile/partials/apple-menu.php'; ?>

<?php get_footer(); ?>
