<?php
/**
 * Нативная мобильная комната «спальня» (0selectedarea1) — БЕЗ iframe.
 *
 * main: цельная панорама Room_1_4k (как пещера) — без склейки кадров.
 * Свободный свайп; старт чуть правее левого края (стекло + чемодан).
 *
 * Зумы: рюкзак / чемодан / окно — fixed-оверлеи + Back; тап по вещи → items.
 */

$nh_tpl  = get_template_directory_uri();
$nh_bed  = $nh_tpl . '/files/bedroom';
$nh_main = $nh_bed . '/Room_1_4k_12-standard-width-3840px.jpg';
?>
<div class="m-native-room" data-room="bedroom">

    <audio id="mBedBackpackSound" preload="auto" src="<?php echo esc_url( $nh_bed ); ?>/backpack.ogg"></audio>
    <audio id="mBedSuitcaseSound" preload="auto" src="<?php echo esc_url( $nh_bed ); ?>/suitcase.ogg"></audio>

    <!-- ============================================================
         main — цельная панорама 3840×2160
    ============================================================ -->
    <div class="m-level is-active" data-level="main">
        <div class="m-bed-pano">
            <img class="m-bed-pano-img"
                 src="<?php echo esc_url( $nh_main ); ?>"
                 alt="Bedroom"
                 width="3840"
                 height="2160"
                 draggable="false">

            <svg class="m-tap-overlay m-bed-pano-hit"
                 viewBox="0 0 3840 2160"
                 preserveAspectRatio="xMidYMid meet"
                 xmlns="http://www.w3.org/2000/svg">
                <!-- Окно / разбитое стекло -->
                <rect class="m-tap-zone" data-nh-goto="outside-zoom"
                      x="0" y="0" width="1600" height="1100"></rect>

                <!-- Чемодан — поверх зоны окна, чтобы тап не уходил в outside -->
                <rect class="m-tap-zone" data-nh-goto="suitcase-zoom"
                      x="620" y="1100" width="520" height="700"></rect>

                <!-- Рюкзак (правее центра) -->
                <rect class="m-tap-zone" data-nh-goto="backpack-zoom"
                      x="2050" y="1280" width="420" height="480"></rect>
            </svg>
        </div>
    </div>

    <!-- ============================================================
         suitcase-zoom
    ============================================================ -->
    <div class="m-level m-bed-detail" data-level="suitcase-zoom">
        <img class="m-bed-detail-img m-bed-detail-suitcase"
             src="<?php echo esc_url( $nh_bed ); ?>/Room_1_4k_suitcase2-standard-width-3840px.jpg"
             alt="Suitcase close-up"
             draggable="false">

        <button type="button" class="m-tap-hit m-tap-zone m-bed-hit-open"
                data-nh-action="open-luggage" aria-label="Open suitcase"></button>

        <button type="button" class="m-level-back" data-nh-back="main" aria-label="Back">Back</button>
    </div>

    <!-- ============================================================
         backpack-zoom
    ============================================================ -->
    <div class="m-level m-bed-detail" data-level="backpack-zoom">
        <img class="m-bed-detail-img m-bed-detail-backpack"
             src="<?php echo esc_url( $nh_bed ); ?>/Room_1_4k_bag2-standard-width-3840px.jpg"
             alt="Backpack close-up"
             draggable="false">

        <button type="button" class="m-tap-hit m-tap-zone m-bed-hit-open"
                data-nh-action="open-backpack" aria-label="Open backpack"></button>

        <button type="button" class="m-level-back" data-nh-back="main" aria-label="Back">Back</button>
    </div>

    <!-- ============================================================
         outside-zoom — вид из окна
    ============================================================ -->
    <div class="m-level m-bed-detail" data-level="outside-zoom">
        <img class="m-bed-detail-img"
             src="<?php echo esc_url( $nh_bed ); ?>/Room_1_4k_Window_2_.jpg"
             alt="Outside the window"
             draggable="false">

        <button type="button" class="m-level-back" data-nh-back="main" aria-label="Back">Back</button>
    </div>

</div>
