<?php
/**
 * Партиал — оверлей apple-menu (сетка 2x3 предметов).
 * Открывается при клике на яблоко в skeleton-menu.
 * Подключается из home.php и room.php.
 */
$tpl = get_template_directory_uri();
?>
<div class="m-apple-menu" id="mAppleMenu" aria-hidden="true">

    <!-- Зерно -->
    <img class="map-noise" src="<?php echo $tpl; ?>/files/items/noise.png" alt="" aria-hidden="true">

    <!-- Верхняя полоса: лошадка + бегущая строка + крестик -->
    <div class="map-top">
        <div class="map-marquee-wrap">
            <div class="map-marquee-horse">
                <img src="<?php echo $tpl; ?>/files/mobile/home/red-horse-running-text.png" alt="">
            </div>
            <div class="map-marquee-scroll">
                <div class="map-marquee-track">
                    <?php
                    $texts = [
                        'no home',
                        'lorem ipsum dolor sit amet, consectetur adipiscing elit',
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
    </div>

    <!-- Крестик закрытия — top-center, прямой ребёнок меню, чтобы быть
         ПОВЕРХ контента (.msk-content), а не прятаться за iframe предмета -->
    <button class="map-close" id="mapClose" aria-label="Close apple menu">
        <img src="<?php echo $tpl; ?>/files/mobile/skeleton-menu/cross.png" alt="">
    </button>

    <!-- Сетка 2x3 предметов -->
    <div class="map-grid">
        <button class="map-item" data-target="backpack">
            <span class="map-item-img">
                <img src="<?php echo $tpl; ?>/files/items/backback/Frame 376 (1).png" alt="">
            </span>
            <span class="map-item-label">backpack</span>
        </button>
        <button class="map-item" data-target="luggage">
            <span class="map-item-img">
                <img src="<?php echo $tpl; ?>/files/items/luggage/object1.png" alt="">
            </span>
            <span class="map-item-label">luggage</span>
        </button>
        <button class="map-item" data-target="iphone">
            <span class="map-item-img">
                <img src="<?php echo $tpl; ?>/files/items/iphone/iPhone.png" alt="">
            </span>
            <span class="map-item-label">iPhone</span>
        </button>
        <button class="map-item" data-target="diary">
            <span class="map-item-img">
                <img src="<?php echo $tpl; ?>/files/items/diary/diary-mask.png" alt="">
            </span>
            <span class="map-item-label">diary</span>
        </button>
        <button class="map-item" data-target="camera">
            <span class="map-item-img map-item-img-placeholder">
                <span>camera</span>
            </span>
            <span class="map-item-label">camera</span>
        </button>
        <button class="map-item" data-target="mp3">
            <span class="map-item-img">
                <img src="<?php echo $tpl; ?>/files/items/mp3/cd.png" alt="">
            </span>
            <span class="map-item-label">.mp3</span>
        </button>
    </div>

    <!-- Нижняя полоса: trnsltr / x-ray / nohome / about -->
    <div class="map-bottom">
        <button class="map-corner" data-target="trnsltr">
            <img src="<?php echo $tpl; ?>/files/nav/trnsltr.png" alt="">
            <span>trnsltr</span>
        </button>
        <button class="map-corner" data-target="xray">
            <img src="<?php echo $tpl; ?>/files/nav/x-ray.png" alt="">
            <span>x-ray</span>
        </button>
        <a class="map-corner map-corner-link" href="<?php echo esc_url( nohome_mobile_url( get_home_url() ) ); ?>">
            <img src="<?php echo $tpl; ?>/files/nav/skeleton-home-rooms.png" alt="">
            <span>nohome</span>
        </a>
        <a class="map-corner map-corner-link" href="<?php echo esc_url( nohome_mobile_url( get_permalink( get_page_by_path( 'about' ) ) ) ); ?>">
            <span class="map-i" aria-hidden="true">i</span>
            <span>about</span>
        </a>
    </div>

    <!-- Контейнер для iframe-контента (открывается при клике на предмет) -->
    <div class="msk-content" id="mapContent"></div>

</div><!-- /.m-apple-menu -->
