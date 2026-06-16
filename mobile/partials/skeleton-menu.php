<?php
/**
 * Партиал — оверлей skeleton-menu (круговое меню при клике на скелет).
 * Подключается из home.php и room.php.
 */
?>
<div class="m-skeleton-menu" id="mSkeletonMenu" aria-hidden="true">

    <!-- Фон: концентрические кольца + зерно -->
    <div class="msk-rings" aria-hidden="true"></div>
    <img class="msk-noise"
         src="<?php echo get_template_directory_uri(); ?>/files/items/noise.png"
         alt="" aria-hidden="true">

    <!-- Крестик закрытия -->
    <button class="msk-close" id="mskClose" aria-label="Close menu">
        <img src="<?php echo get_template_directory_uri(); ?>/files/mobile/skeleton-menu/cross.png" alt="">
    </button>

    <!-- Кнопка «домой» — обычная ссылка (без data-target), браузер сам переходит -->
    <a class="msk-home" href="<?php echo esc_url( nohome_mobile_url( home_url( '/' ) ) ); ?>" aria-label="Home">
        <img src="<?php echo get_template_directory_uri(); ?>/files/nav/skeleton-home-rooms.png" alt="">
        <span>home</span>
    </a>

    <!-- Внешнее кольцо: iphone / backpack / luggage -->
    <a href="#" class="msk-label msk-iphone"   data-target="iphone">iphone</a>
    <a href="#" class="msk-label msk-backpack" data-target="backpack">backpack</a>
    <a href="#" class="msk-label msk-luggage"  data-target="luggage">luggage</a>

    <!-- Среднее кольцо: camera / mp3 / diary -->
    <a href="#" class="msk-label msk-camera"   data-target="camera">camera</a>
    <a href="#" class="msk-label msk-mp3"      data-target="mp3">mp3</a>
    <a href="#" class="msk-label msk-diary"    data-target="diary">diary</a>

    <!-- Центр: items (яблоко) — открывает apple-menu -->
    <button class="msk-center" id="mskCenter" data-target="items">
        <img src="<?php echo get_template_directory_uri(); ?>/files/nav/items.png" alt="">
        <span>items</span>
    </button>

    <!-- Углы: trnsltr слева, x-ray справа -->
    <button class="msk-corner msk-trnsltr" data-target="trnsltr">
        <img src="<?php echo get_template_directory_uri(); ?>/files/nav/trnsltr.png" alt="">
        <span>trnsltr</span>
    </button>
    <button class="msk-corner msk-xray" data-target="xray">
        <img src="<?php echo get_template_directory_uri(); ?>/files/nav/x-ray.png" alt="">
        <span>x-ray</span>
    </button>

    <!-- Контейнер для iframe-контента -->
    <div class="msk-content" id="mskContent"></div>

</div><!-- /.m-skeleton-menu -->
