<?php get_header(); ?>

<div class="m-home" id="mHome">

    <!-- ========== БЕГУЩАЯ СТРОКА ========== -->
    <div class="m-marquee-wrap" aria-hidden="true">
        <div class="m-marquee-horse">
            <img src="<?php echo get_template_directory_uri(); ?>/files/mobile/home/red-horse-running-text.png" alt="">
        </div>
        <div class="m-marquee-scroll">
            <div class="m-marquee-track">
                <?php
                $texts = [
                    'no home',
                    'sorry for being weird it\'s my first time being alive',
                    'no home',
                    'you can move me and listen to me',
                    'no home',
                    'you will have to become a user of someone else\'s map',
                    'no home',
                    'things shown on screen can cause strong emotions',
                ];
                for ($i = 0; $i < 2; $i++) {
                    foreach ($texts as $t) {
                        echo '<span>' . esc_html($t) . '</span>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <!-- ========== ГОРИЗОНТАЛЬНЫЙ СКРОЛЛ ========== -->
    <div class="m-rooms-scroll" id="mRoomsScroll">

        <!-- ТРЕК: 300vw — три секции + общий overlay стикеров -->
        <div class="m-rooms-track">

            <!-- Секция 0 — левая -->
            <div class="m-section" data-idx="0"></div>

            <!-- Секция 1 — центр (дом) -->
            <div class="m-section m-section-center" data-idx="1">
                <div class="m-house-wrap">
                    <img
                        class="m-house-img"
                        src="<?php echo get_template_directory_uri(); ?>/files/main-page/house-frame.png"
                        alt="no home"
                        draggable="false"
                    >
                    <!-- SVG с кликабельными комнатами -->
                    <svg class="m-house-svg" viewBox="0 0 762 759" fill="none"
                         xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet">
                        <a href="<?php echo esc_url( nohome_mobile_url( '/0selectedarea1' ) ); ?>" aria-label="Bedroom">
                            <path d="M174 707L101.5 505.5H368.5L370.5 707H174Z"/>
                        </a>
                        <a href="<?php echo esc_url( nohome_mobile_url( '/0selectedarea2' ) ); ?>" aria-label="Cave">
                            <path d="M579.5 706.5L652 505H385L383 706.5H579.5Z"/>
                        </a>
                        <a href="<?php echo esc_url( nohome_mobile_url( '/0selectedarea3' ) ); ?>" aria-label="Table room">
                            <path d="M383 303H702H719L653.5 496.5H383V303Z"/>
                        </a>
                        <a href="<?php echo esc_url( nohome_mobile_url( '/0selectedarea4' ) ); ?>" aria-label="Attic">
                            <path d="M374 48.5L84 271.5L684.5 272.5L374 48.5Z"/>
                        </a>
                        <a href="<?php echo esc_url( nohome_mobile_url( '/0selectedarea5' ) ); ?>" aria-label="Golden room">
                            <path d="M370 303H51H34L99.5 496.5H370V303Z"/>
                        </a>
                    </svg>
                </div>
            </div>

            <!-- Секция 2 — правая -->
            <div class="m-section" data-idx="2"></div>

            <!-- ===== ЕДИНЫЙ OVERLAY СТИКЕРОВ — каждый стикер ровно 1 раз ===== -->
            <!-- Позиции в % от 300vw (ширина трека).
                 0–33%  → левая зона
                 33–67% → центральная зона
                 67–100%→ правая зона                                           -->
            <div class="m-stickers-overlay" aria-hidden="true">

                <!-- ── ЛЕВАЯ ЗОНА ── -->

                <!-- note1: крупный список, top-left -->
                <img class="m-sticker ms-note1"
                    src="<?php echo get_template_directory_uri(); ?>/files/main-page/note1.png" alt="">

                <!-- worksheet: крупный SUBJECTIVITY REPORT, уходит за центральную зону -->
                <img class="m-sticker ms-worksheet"
                    src="<?php echo get_template_directory_uri(); ?>/files/main-page/subjectivity-worksheet.png" alt="">

                <!-- gobag: крупный GO BAG, bottom-left -->
                <img class="m-sticker ms-gobag"
                    src="<?php echo get_template_directory_uri(); ?>/files/main-page/go%20bag.png" alt="">

                <!-- note2: "Send the brief", малый, bottom-mid левой зоны -->
                <img class="m-sticker ms-note2"
                    src="<?php echo get_template_directory_uri(); ?>/files/main-page/note2.png" alt="">

                <!-- note3: "Ask to be added...", граница лево/центр — естественный переход -->
                <img class="m-sticker ms-note3"
                    src="<?php echo get_template_directory_uri(); ?>/files/main-page/note3.png" alt="">

                <!-- ── ЦЕНТРАЛЬНАЯ ЗОНА (рядом с домом, по эталону center.png) ── -->

                <!-- SUBJECTIVITY REPORT (дубль worksheet) — слева сверху от дома -->
                <img class="m-sticker ms-c-worksheet"
                    src="<?php echo get_template_directory_uri(); ?>/files/main-page/subjectivity-worksheet.png" alt="">

                <!-- note3 (дубль) "Ask to be added..." — слева снизу от дома -->
                <img class="m-sticker ms-c-note3"
                    src="<?php echo get_template_directory_uri(); ?>/files/main-page/note3.png" alt="">

                <!-- note8: ПУСТОЙ серый — справа сверху от дома, кликабельный -->
                <button class="m-sticker ms-note8-btn m-note-btn" id="mNoteBtn" aria-label="Оставить заметку">
                    <img src="<?php echo get_template_directory_uri(); ?>/files/main-page/note8.png" alt="">
                </button>

                <!-- note4: "Write out the time codes...", справа ниже -->
                <img class="m-sticker ms-note4"
                    src="<?php echo get_template_directory_uri(); ?>/files/main-page/note4.png" alt="">

                <!-- ── ПРАВАЯ ЗОНА ── -->

                <!-- note5: жёлтая "Organise the files...", top-right -->
                <img class="m-sticker ms-note5"
                    src="<?php echo get_template_directory_uri(); ?>/files/main-page/note5.png" alt="">

                <!-- note6: жёлтая лента "Pack" -->
                <img class="m-sticker ms-note6"
                    src="<?php echo get_template_directory_uri(); ?>/files/main-page/note6.png" alt="">

                <!-- survival: крупный SURVIVAL GUIDES, центр правой зоны -->
                <img class="m-sticker ms-survival"
                    src="<?php echo get_template_directory_uri(); ?>/files/main-page/survival%20guides.png" alt="">

                <!-- note7: "Clean cache / Make a new playlist...", bottom-right -->
                <img class="m-sticker ms-note7"
                    src="<?php echo get_template_directory_uri(); ?>/files/main-page/note7.png" alt="">

            </div><!-- /.m-stickers-overlay -->

        </div><!-- /.m-rooms-track -->

    </div><!-- /.m-rooms-scroll -->

    <!-- ========== СТРЕЛКИ ========== -->
    <button class="m-arrow m-arrow-left"  id="mArrowLeft"  aria-label="Previous">
        <img src="<?php echo get_template_directory_uri(); ?>/files/mobile/home/arrow-left.png"  alt="">
    </button>
    <button class="m-arrow m-arrow-right" id="mArrowRight" aria-label="Next">
        <img src="<?php echo get_template_directory_uri(); ?>/files/mobile/home/arrow-right.png" alt="">
    </button>

    <!-- ========== НИЖНИЙ ГРАДИЕНТ ========== -->
    <div class="m-bottom-gradient" aria-hidden="true"></div>

    <!-- ========== СКЕЛЕТ ========== -->
    <button class="m-skeleton-btn" id="mSkeletonBtn" aria-label="Open menu">
        <img
            src="<?php echo get_template_directory_uri(); ?>/files/mobile/home/skeleton-bottom.png"
            alt=""
            draggable="false"
        >
    </button>

</div><!-- /.m-home -->

<!-- ========== ОВЕРЛЕЙ ЗАМЕТКИ ========== -->
<div class="m-note-overlay" id="mNoteOverlay" aria-hidden="true">
    <div class="m-note-overlay-inner">
        <textarea class="m-note-textarea" id="mNoteText" placeholder="write something..."></textarea>
        <div class="m-note-overlay-actions">
            <button class="m-note-send" id="mNoteSend">send</button>
            <button class="m-note-cancel" id="mNoteCancel">cancel</button>
        </div>
        <p class="m-note-status" id="mNoteStatus"></p>
    </div>
</div>

<!-- Оверлеи меню — общие партиалы для главной и комнат -->
<?php include get_template_directory() . '/mobile/partials/skeleton-menu.php'; ?>
<?php include get_template_directory() . '/mobile/partials/apple-menu.php'; ?>

<?php get_footer(); ?>
