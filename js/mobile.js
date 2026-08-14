(function($) {
    'use strict';

    // -----------------------------------------------------------------------
    // Главная страница — 3 секции (left / center / right)
    // -----------------------------------------------------------------------

    function initMobileHome() {
        var scroll      = document.getElementById('mRoomsScroll');
        if (!scroll) return;

        var sections    = scroll.querySelectorAll('.m-section');
        var arrowLeft   = document.getElementById('mArrowLeft');
        var arrowRight  = document.getElementById('mArrowRight');
        var skeletonBtn = document.getElementById('mSkeletonBtn');
        var total       = sections.length; // 3
        var currentIdx  = 1;              // стартуем на центре

        // Flat / single-viewport комнаты (about, золотая): один экран 100vw,
        // scrollLeft=0 — иначе уводит iframe за край.
        var mHome  = document.getElementById('mHome');
        var isFlat = mHome && (
            mHome.classList.contains('m-inner-flat') ||
            mHome.classList.contains('m-inner-single')
        );

        // Только на главной (.m-home-main): центр = 100vw, лево/право —
        // ближе к центру (35/165vw), видна полоска соседа.
        var isMainHome = mHome && mHome.classList.contains('m-home-main');
        var isSoftSnap = isMainHome;

        function posForIdx(idx) {
            var w = scroll.offsetWidth;
            if (!isSoftSnap) return idx * w;
            return w + (idx - 1) * w * 0.65;
        }

        function nearestIdxForScroll(scrollLeft) {
            var w = scroll.offsetWidth;
            if (!isSoftSnap) return w > 0 ? Math.round(scrollLeft / w) : 0;
            var best = 0, bestDist = Infinity;
            for (var i = 0; i < total; i++) {
                var d = Math.abs(scrollLeft - posForIdx(i));
                if (d < bestDist) { bestDist = d; best = i; }
            }
            return best;
        }

        // Стартовая позиция по slug комнаты.
        // Пещера / спальня — цельные панорамы (свободный скролл, без snap).
        var roomSlug = mHome ? (mHome.dataset.roomSlug || '') : '';
        var isCavePano = roomSlug === '0selectedarea2';
        var isBedPano  = roomSlug === '0selectedarea1';
        var isRoomPano = isCavePano || isBedPano;
        // Доля maxScroll при старте
        // Пещера: дверь + полвхода. Спальня: считаем по координатам картинки
        // (чуть дерева слева, рюкзак ~у правого края кадра).
        var caveStartFrac = 0.66;
        // Правый край рюкзака в Room_1_4k (~2370) + небольшой зазор до края экрана
        var bedViewRightX = 2460; // из 3840 — капельку правее
        var startPos = 1;
        var startSection = 1;

        function caveMaxScroll() {
            return Math.max(0, scroll.scrollWidth - scroll.offsetWidth);
        }

        function caveStartScrollLeft() {
            return caveMaxScroll() * caveStartFrac;
        }

        // Спальня: выравниваем правый край viewport по рюкзаку
        function bedStartScrollLeft() {
            var max = caveMaxScroll();
            var panoW = scroll.scrollWidth;
            var viewW = scroll.offsetWidth;
            if (!panoW || !viewW || !max) return 0;
            var target = (bedViewRightX / 3840) * panoW - viewW;
            return Math.max(0, Math.min(max, target));
        }

        function startScrollLeft() {
            if (isBedPano) return bedStartScrollLeft();
            if (isCavePano) return caveStartScrollLeft();
            var w = scroll.offsetWidth;
            if (!w) return posForIdx(startSection);
            // Дробный старт (комнаты): 1.35 * width и т.п.
            if (!isSoftSnap && !isFlat && startPos !== startSection) {
                return startPos * w;
            }
            return posForIdx(startSection);
        }

        // Плавный переход к секции по индексу
        function goTo(idx) {
            // Guard: при открытом скелет-меню стрелки не должны навигировать
            if (document.body.classList.contains('m-menu-open')) return;
            // Чердак: во время анимации скелета — без свайпа/стрелок
            if (document.body.classList.contains('is-attic-animating')) return;
            // Детальный экран комнаты (стена/зумы) — кадр зафиксирован по центру
            if (document.body.classList.contains('is-room-detail')) return;
            if (document.body.classList.contains('is-cave-detail')) return;
            // Пещера / спальня: стрелки ходят через caveNudge, не через секции
            if (isRoomPano) return;
            if (idx < 0 || idx >= total) return;

            // table-zoom: карусель с фейдом — обрабатывает mobile-native-room.js
            if (mHome && mHome.classList.contains('is-table-zoom')) {
                window.dispatchEvent(new CustomEvent('nh-zoom-carousel', { detail: { idx: idx } }));
                return;
            }

            // camera-zoom / bedroom-detail: горизонтальная навигация заблокирована
            if (mHome && mHome.classList.contains('is-camera-zoom')) return;
            if (mHome && mHome.classList.contains('is-bedroom-detail')) return;

            currentIdx = idx;
            scroll.scrollTo({ left: posForIdx(idx), behavior: 'smooth' });
            updateArrows();
        }

        function caveNudge(dir) {
            if (document.body.classList.contains('m-menu-open')) return;
            // Стена с вещами — стрелки крутят её панораму
            if (mHome && mHome.classList.contains('is-cave-wall')) {
                var wall = document.getElementById('mCaveWallScroll');
                if (!wall) return;
                var wStep = wall.offsetWidth * 0.75;
                var wMax = Math.max(0, wall.scrollWidth - wall.offsetWidth);
                var wNext = Math.max(0, Math.min(wMax, wall.scrollLeft + dir * wStep));
                wall.scrollTo({ left: wNext, behavior: 'smooth' });
                setTimeout(updateArrows, 320);
                return;
            }
            if (mHome && mHome.classList.contains('is-cave-detail')) return;
            if (mHome && mHome.classList.contains('is-bedroom-detail')) return;
            var step = scroll.offsetWidth * 0.85;
            var max = caveMaxScroll();
            var next = Math.max(0, Math.min(max, scroll.scrollLeft + dir * step));
            scroll.scrollTo({ left: next, behavior: 'smooth' });
        }

        // Синхронизация индекса после карусели table-zoom
        window.addEventListener('nh-carousel-idx', function(e) {
            if (!e.detail || typeof e.detail.idx !== 'number') return;
            currentIdx = e.detail.idx;
            updateArrows();
        });

        window.addEventListener('nh-cave-wall-scroll', function() {
            updateArrows();
        });

        // Затемняем стрелки на крайних позициях (не скрываем)
        function updateArrows() {
            if (mHome && mHome.classList.contains('is-cave-wall')) {
                var wall = document.getElementById('mCaveWallScroll');
                if (wall) {
                    var wMax = Math.max(0, wall.scrollWidth - wall.offsetWidth);
                    var wSl = wall.scrollLeft;
                    if (arrowLeft)  arrowLeft.classList.toggle('is-dimmed', wSl <= 2);
                    if (arrowRight) arrowRight.classList.toggle('is-dimmed', wSl >= wMax - 2);
                }
                return;
            }
            if (isRoomPano) {
                var max = caveMaxScroll();
                var sl = scroll.scrollLeft;
                if (arrowLeft)  arrowLeft.classList.toggle('is-dimmed', sl <= 2);
                if (arrowRight) arrowRight.classList.toggle('is-dimmed', sl >= max - 2);
                return;
            }
            if (arrowLeft)  arrowLeft.classList.toggle('is-dimmed',  currentIdx === 0);
            if (arrowRight) arrowRight.classList.toggle('is-dimmed', currentIdx === total - 1);
        }

        // Пока ширина трека = 0, scrollLeft=0; clamp на scroll-событии
        // успевал утянуть на левую точку (35vw) вместо центра (100vw).
        var startReady = false;

        // Без анимации прокручиваем к нужной позиции (только не-flat)
        function applyStartScroll() {
            if (isFlat) {
                currentIdx = 0;
                scroll.scrollLeft = 0;
                startReady = true;
                return false;
            }
            var w = scroll.offsetWidth;
            if (!w) return false; // layout ещё не готов — попробуем снова

            if (isRoomPano) {
                scroll.scrollLeft = startScrollLeft();
                currentIdx = 1;
                updateArrows();
                startReady = true;
                return true;
            }
            currentIdx = startSection;
            scroll.scrollLeft = startScrollLeft();
            updateArrows();
            startReady = true;
            return true;
        }

        // На время старта глушим snap — иначе браузер может притянуть к 35vw
        var prevSnap = scroll.style.scrollSnapType;
        scroll.style.scrollSnapType = 'none';

        function finishStartScroll() {
            applyStartScroll();
            scroll.style.scrollSnapType = prevSnap || '';
            // Ещё раз после включения snap — закрепить центр
            requestAnimationFrame(function() {
                applyStartScroll();
            });
        }

        if (!applyStartScroll()) {
            requestAnimationFrame(function() {
                if (!applyStartScroll()) {
                    setTimeout(finishStartScroll, 50);
                } else {
                    finishStartScroll();
                }
            });
        } else {
            finishStartScroll();
        }
        // Панорама: картинка может догрузить размеры чуть позже
        if (isRoomPano) setTimeout(function() { applyStartScroll(); }, 400);

        // Синхронизация при ручном свайпе
        var scrollTimer;
        scroll.addEventListener('scroll', function() {
            // Жёсткий стоп в реальном времени: на главной не даём пальцу утащить
            // дальше доступных точек (35vw/165vw), а не до истинного края трека
            // (0/200vw) — иначе перед прилипанием на миг был бы виден кусок
            // «за границей» дизайна.
            // До startReady clamp НЕ трогаем — иначе 0 → 35vw вместо центра.
            if (isSoftSnap && startReady) {
                var min = posForIdx(0);
                var max = posForIdx(total - 1);
                if (scroll.scrollLeft < min) scroll.scrollLeft = min;
                else if (scroll.scrollLeft > max) scroll.scrollLeft = max;
            }

            clearTimeout(scrollTimer);
            scrollTimer = setTimeout(function() {
                if (isRoomPano) {
                    updateArrows();
                    return;
                }
                // Прилипание — нативный CSS scroll-snap (.m-snap-point на главной,
                // границы секций в комнатах), тут только синхронизируем индекс
                // для затемнения стрелок.
                currentIdx = nearestIdxForScroll(scroll.scrollLeft);
                updateArrows();
            }, 80);
        }, { passive: true });

        // bfcache / возврат назад — снова в центр
        window.addEventListener('pageshow', function() {
            if (isFlat) return;
            startReady = false;
            scroll.style.scrollSnapType = 'none';
            finishStartScroll();
        });

        if (arrowLeft) {
            arrowLeft.addEventListener('click', function() {
                if (mHome && mHome.classList.contains('is-cave-wall')) caveNudge(-1);
                else if (isRoomPano) caveNudge(-1);
                else goTo(currentIdx - 1);
            });
        }
        if (arrowRight) {
            arrowRight.addEventListener('click', function() {
                if (mHome && mHome.classList.contains('is-cave-wall')) caveNudge(1);
                else if (isRoomPano) caveNudge(1);
                else goTo(currentIdx + 1);
            });
        }

        // Открытие меню — только в initSkeletonMenu (openMenu).
        // Здесь не вешаем заглушку: иначе путаница и лишние обработчики.

        updateArrows();
    }

    // -----------------------------------------------------------------------
    // Пустой стикер — оверлей отправки заметки на почту
    // -----------------------------------------------------------------------

    function initNoteOverlay() {
        var btn     = document.getElementById('mNoteBtn');
        var overlay = document.getElementById('mNoteOverlay');
        var textarea = document.getElementById('mNoteText');
        var sendBtn = document.getElementById('mNoteSend');
        var exitBtn = document.getElementById('mNoteExit');
        var status  = document.getElementById('mNoteStatus');

        if (!btn || !overlay) return;

        function open() {
            overlay.classList.add('is-open');
            overlay.setAttribute('aria-hidden', 'false');
            setTimeout(function() { textarea.focus(); }, 100);
        }

        function close() {
            overlay.classList.remove('is-open');
            overlay.setAttribute('aria-hidden', 'true');
            textarea.value = '';
            status.textContent = '';
        }

        btn.addEventListener('click', open);
        exitBtn.addEventListener('click', close);

        // Клик по фону (вне карточки) закрывает оверлей
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) close();
        });

        sendBtn.addEventListener('click', function() {
            var text = textarea.value.trim();
            if (!text) return;

            sendBtn.disabled = true;
            status.textContent = 'sending...';

            $.ajax({
                url: mobileData.ajaxurl,
                type: 'POST',
                data: {
                    action:    'send_sticker_email',
                    user_text: text,
                    security:  mobileData.nonce
                },
                success: function() {
                    status.textContent = 'sent.';
                    setTimeout(close, 1200);
                },
                error: function() {
                    status.textContent = 'error, try again.';
                    sendBtn.disabled = false;
                }
            });
        });
    }

    // -----------------------------------------------------------------------
    // Оверлей стикера #mStickerInfo — общий для всех стикеров главной
    // (кроме note8, у него свой оверлей заметки — initNoteOverlay()).
    // Три режима: is-simple (note1–7), is-flip (go bag / survival guides,
    // 2 стадии + download), is-worksheet (subjectivity worksheet, тап-грид
    // из 12 фото). Клик делегирован с .m-stickers-overlay — сами стикеры
    // кликабельны (pointer-events: auto), сквозной свайп не задет.
    // -----------------------------------------------------------------------

    function initStickerInfoOverlay() {
        var stickersOverlay = document.querySelector('.m-stickers-overlay');
        var info = document.getElementById('mStickerInfo');
        if (!stickersOverlay || !info) return;

        var label      = document.getElementById('mStickerLabel');
        var exitBtn    = document.getElementById('mStickerExit');
        var simpleImg  = document.getElementById('mStickerSimpleImg');
        var flipStage1 = document.getElementById('mStickerFlipStage1');
        var flipStage2 = document.getElementById('mStickerFlipStage2');
        var worksheet  = document.getElementById('mStickerWorksheet');
        var swGrid     = worksheet ? worksheet.querySelector('.m-sw-grid') : null;
        var swCells    = worksheet ? worksheet.querySelectorAll('.m-sw-cell') : [];
        var prevBtn    = document.getElementById('mStickerPrev');
        var nextBtn    = document.getElementById('mStickerNext');
        var downloadA  = document.getElementById('mStickerDownload');

        var tplUri = (typeof mobileData !== 'undefined' && mobileData.tplUri) ? mobileData.tplUri : '';

        // Вторая стадия флипа берётся из тех же файлов, что на десктопе
        // (см. [local]main.php: sticker-under-* / sticker-second-*).
        var flipAssets = {
            gobag: {
                stage1: tplUri + '/files/main-page/go%20bag.jpg',
                stage2: tplUri + '/files/main-page/gobag2.jpg'
            },
            survival: {
                stage1: tplUri + '/files/main-page/survival%20guides.jpg',
                stage2: tplUri + '/files/main-page/survival_guides2.png'
            }
        };

        function resetWorksheet() {
            for (var i = 0; i < swCells.length; i++) {
                swCells[i].classList.remove('is-revealed');
            }
        }

        function close() {
            info.classList.remove('is-open', 'is-simple', 'is-flip', 'is-worksheet', 'is-stage2');
            info.setAttribute('aria-hidden', 'true');
            simpleImg.src = '';
            flipStage1.src = '';
            flipStage2.src = '';
            resetWorksheet();
        }

        function openSimple(sticker) {
            label.textContent = sticker.dataset.sticker || '';
            simpleImg.src = sticker.getAttribute('src') || '';
            info.classList.add('is-open', 'is-simple');
            info.setAttribute('aria-hidden', 'false');
        }

        function openFlip(sticker, type) {
            var assets = flipAssets[type];
            if (!assets) return;
            label.textContent = sticker.dataset.sticker || '';
            flipStage1.src = assets.stage1;
            flipStage2.src = assets.stage2;
            downloadA.href = sticker.dataset.pdf || '#';
            info.classList.remove('is-stage2');
            info.classList.add('is-open', 'is-flip');
            info.setAttribute('aria-hidden', 'false');
        }

        function openWorksheet(sticker) {
            label.textContent = sticker.dataset.sticker || '';
            resetWorksheet();
            info.classList.add('is-open', 'is-worksheet');
            info.setAttribute('aria-hidden', 'false');
        }

        stickersOverlay.addEventListener('click', function(e) {
            var sticker = e.target.closest('.m-sticker');
            if (!sticker) return;
            // note8 — отдельная кнопка со своим оверлеем заметки
            if (sticker.id === 'mNoteBtn') return;

            var type = sticker.dataset.stickerType;
            if (type === 'gobag' || type === 'survival') {
                openFlip(sticker, type);
            } else if (type === 'worksheet') {
                openWorksheet(sticker);
            } else if (sticker.dataset.sticker) {
                openSimple(sticker);
            }
        });

        exitBtn.addEventListener('click', close);

        // Клик по фону (не по картинке/футеру) закрывает оверлей
        info.addEventListener('click', function(e) {
            if (e.target === info) close();
        });

        if (prevBtn) prevBtn.addEventListener('click', function() {
            info.classList.remove('is-stage2');
        });
        if (nextBtn) nextBtn.addEventListener('click', function() {
            info.classList.add('is-stage2');
        });

        if (swGrid) {
            swGrid.addEventListener('click', function(e) {
                var cell = e.target.closest('.m-sw-cell');
                if (!cell) return;
                cell.classList.toggle('is-revealed');
            });
        }
    }

    // -----------------------------------------------------------------------
    // Скелет-меню — круговое меню с AJAX-подгрузкой items-контента
    // -----------------------------------------------------------------------

    // URL iframe по target:
    //  - trnsltr → ТЕКУЩАЯ страница в десктоп-режиме + trnsltr=1
    //    (items.js сам кликнет #translate-button → покажет десктоп-переводчик).
    //    Same-origin, поэтому работает и на localhost.
    //  - предметы (iphone/backpack/...) → главная + item-frame шаблон.
    function buildContentUrl(target) {
        if (target === 'trnsltr') {
            return window.location.origin + window.location.pathname + '?desktop=1&trnsltr=1';
        }
        return window.location.origin + '/?desktop=1&item=' + encodeURIComponent(target);
    }

    // Полностью закрыть оба меню (skeleton + apple), снять блокировку фона,
    // очистить iframe-контейнеры. Нужно перед локальными действиями (x-ray),
    // чтобы инверсия/страница были видны без открытого меню сверху.
    function closeAllMenus() {
        var sk = document.getElementById('mSkeletonMenu');
        var ap = document.getElementById('mAppleMenu');
        if (sk) {
            sk.classList.remove('is-open');
            sk.setAttribute('aria-hidden', 'true');
            sk.classList.remove('is-item-from-room');
        }
        if (ap) { ap.classList.remove('is-open'); ap.setAttribute('aria-hidden', 'true'); }
        document.body.classList.remove('m-menu-open');
        var skC = document.getElementById('mskContent');
        var apC = document.getElementById('mapContent');
        if (skC) { skC.classList.remove('is-open'); skC.innerHTML = ''; delete skC.dataset.kind; }
        if (apC) { apC.classList.remove('is-open'); apC.innerHTML = ''; }
        setItemStrip(null);
    }

    // Переход на главную мобайл-страницу. Используется при закрытии предмета —
    // по решению: закрытие предмета всегда возвращает на главную.
    function goHome() {
        window.location.href = window.location.origin + '/?mobile=1';
    }

    function showIframe(container, target) {
        if (!container) return;
        var url = buildContentUrl(target);
        // Помечаем тип контента: предмет закрывается «на главную»,
        // инструмент (переводчик) — просто очищается и возвращает в меню.
        container.dataset.kind = (target === 'trnsltr') ? 'tool' : 'item';
        container.innerHTML = '<iframe class="msk-iframe" src="' + url + '" loading="lazy"></iframe>';
        container.classList.add('is-open');
    }

    // Если оба меню закрыты — снять m-menu-open.
    // Иначе .m-skeleton-btn остаётся с pointer-events:none («скелет не кликается»).
    function syncMenuBodyLock() {
        var sk = document.getElementById('mSkeletonMenu');
        var ap = document.getElementById('mAppleMenu');
        var skOpen = !!(sk && sk.classList.contains('is-open'));
        var apOpen = !!(ap && ap.classList.contains('is-open'));
        if (!skOpen && !apOpen) {
            document.body.classList.remove('m-menu-open');
            setItemStrip(null);
        }
    }

    // Полоска items под крестиком.
    // mode: 'overlay' — поверх apple Items; 'menu' — внутри skeleton под крестиком;
    //       auto — по тому, открыт ли apple.
    // Предметы (не trnsltr): полоска должна быть ВСЕГДА при открытом item-frame.
    var ITEM_STRIP_KEYS = {
        backpack: 1, luggage: 1, iphone: 1, diary: 1, camera: 1, mp3: 1
    };

    function setItemStrip(activeKey, mode) {
        var menu = document.getElementById('mSkeletonMenu');
        var apple = document.getElementById('mAppleMenu');
        var strip = document.getElementById('mItemStrip');
        if (!strip) return;

        function restoreStripHome() {
            strip.classList.remove('is-overlay');
            if (!menu) return;
            if (strip.parentElement === menu) return;
            var close = document.getElementById('mskClose');
            if (close && close.parentNode) {
                close.parentNode.insertBefore(strip, close.nextSibling);
            } else {
                menu.appendChild(strip);
            }
        }

        // Скрыть
        if (!activeKey || !ITEM_STRIP_KEYS[activeKey]) {
            strip.hidden = true;
            strip.setAttribute('hidden', '');
            strip.classList.remove('is-overlay', 'is-visible');
            if (menu) menu.classList.remove('is-item-from-room');
            restoreStripHome();
            return;
        }

        // Показать + подсветить текущий
        strip.hidden = false;
        strip.removeAttribute('hidden');
        strip.classList.add('is-visible');
        var links = strip.querySelectorAll('.m-item-strip-link');
        for (var i = 0; i < links.length; i++) {
            var key = links[i].getAttribute('data-item');
            links[i].classList.toggle('is-active', key === activeKey);
        }

        var useOverlay = mode === 'overlay';
        if (!mode || mode === 'auto') {
            useOverlay = !!(apple && apple.classList.contains('is-open'));
        }

        if (useOverlay) {
            if (menu) menu.classList.remove('is-item-from-room');
            strip.classList.add('is-overlay');
            // на body — иначе overflow:hidden у skeleton/apple клипит полоску
            if (strip.parentElement !== document.body) {
                document.body.appendChild(strip);
            }
        } else {
            strip.classList.remove('is-overlay');
            if (menu) menu.classList.add('is-item-from-room');
            restoreStripHome();
        }
    }

    // Открыть предмет + гарантированно показать полоску под крестиком
    function openItemFrame(container, target, stripMode) {
        if (!container || !target) return;
        showIframe(container, target);
        if (target === 'trnsltr') {
            setItemStrip(null);
            return;
        }
        setItemStrip(target, stripMode || 'auto');
    }

    // Публичный API: открыть предмет (iphone и т.п.) из нативной комнаты —
    // тот же iframe item-frame, что из skeleton-menu. Без капчи.
    // kind=item-stay: закрытие возвращает в комнату, а не на главную.
    window.nhOpenMobileItem = function(target) {
        if (!target) return;
        var menu    = document.getElementById('mSkeletonMenu');
        var content = document.getElementById('mskContent');
        if (!menu || !content) return;
        menu.classList.add('is-open');
        menu.setAttribute('aria-hidden', 'false');
        document.body.classList.add('m-menu-open');
        openItemFrame(content, target, 'menu');
        content.dataset.kind = 'item-stay';
    };

    function clearContent(container) {
        if (!container) return;
        container.classList.remove('is-open');
        container.innerHTML = '';
        delete container.dataset.kind;
        setItemStrip(null);
    }

    // Закрытие: item → главная; item в apple (#mapContent) → назад к сетке;
    // tool → очистить iframe; item-stay (из комнаты) → очистить и закрыть skeleton.
    function closeContentOrHome(container) {
        if (!container) return;
        if (container.dataset.kind === 'item') {
            // Apple Items: крестик возвращает к сетке, полоска скрывается
            if (container.id === 'mapContent') {
                clearContent(container);
                syncMenuBodyLock();
                return;
            }
            goHome();
            return;
        }
        var stay = container.dataset.kind === 'item-stay';
        clearContent(container);
        if (stay) {
            var menu = document.getElementById('mSkeletonMenu');
            if (menu) {
                menu.classList.remove('is-open');
                menu.setAttribute('aria-hidden', 'true');
            }
            document.body.classList.remove('m-menu-open');
        }
        syncMenuBodyLock();
    }

    // -----------------------------------------------------------------------
    // X-ray локально — toggle инверсии экрана.
    // Берём готовые десктоп-классы из style.css:
    //   .xray-active         — filter: invert(1)
    //   .xray-animate        — плавный переход (0.5s)
    //   .xray-animate-reverse — плавное снятие
    // Применяем к <body> — он оборачивает весь мобайл-контент (.m-home сидит
    // отдельно от .mobile-interface, поэтому инверсия на ней не видна).
    // Десктоп вешает .xray-active на .x-ray-wrapper (#wrapper) — тот же смысл.
    // Состояние сохраняется в localStorage — как на десктопе.
    // -----------------------------------------------------------------------
    function xrayRoot() {
        return document.body;
    }

    function toggleMobileXray() {
        var root = xrayRoot();
        var isOn = root.classList.toggle('xray-active');
        root.classList.remove('xray-animate', 'xray-animate-reverse');
        // force reflow — иначе анимация не перезапустится при быстрых тогглах
        void root.offsetWidth;
        root.classList.add(isOn ? 'xray-animate' : 'xray-animate-reverse');
        setTimeout(function() {
            root.classList.remove('xray-animate', 'xray-animate-reverse');
        }, 500);
        // НЕ сохраняем состояние: x-ray на мобайле сессионный, дефолт OFF.
        // Иначе залипал «включённым» на всех страницах (комнаты — отдельные
        // загрузки), а ещё комнаты-iframe подхватывали 'active' из общего ключа.
    }

    // Дефолт OFF: при загрузке мобайла гасим залипшее состояние x-ray —
    // и на body, и в общем localStorage-ключе, который читают десктоп-iframe
    // комнат (nav-tools.js), чтобы они не открывались инвертированными.
    function restoreMobileXray() {
        xrayRoot().classList.remove('xray-active');
        try { localStorage.removeItem('xrayState'); } catch (e) {}
    }

    function initSkeletonMenu() {
        var skeletonBtn = document.getElementById('mSkeletonBtn');
        var menu        = document.getElementById('mSkeletonMenu');
        var closeBtn    = document.getElementById('mskClose');
        var content     = document.getElementById('mskContent');
        var appleMenu   = document.getElementById('mAppleMenu');

        if (!skeletonBtn || !menu) return;

        function openMenu() {
            // Фон/трек замораживаются на месте через CSS (body.m-menu-open):
            // overflow:hidden + pointer-events:none. Позицию scrollLeft НЕ
            // трогаем — иначе комната «уезжает» при закрытии (старый баг).
            menu.classList.add('is-open');
            menu.setAttribute('aria-hidden', 'false');
            document.body.classList.add('m-menu-open');
        }

        function closeMenu() {
            menu.classList.remove('is-open');
            menu.setAttribute('aria-hidden', 'true');
            // Снятие класса убирает CSS-заморозку трека. scrollLeft не
            // восстанавливаем — он и не менялся, комната остаётся где была.
            document.body.classList.remove('m-menu-open');
            clearContent(content);
            setItemStrip(null);
            // apple мог остаться — добиваем блокировку
            syncMenuBodyLock();
        }

        function handleTarget(target) {
            // items — открыть apple-menu поверх skeleton-menu
            if (target === 'items') {
                if (appleMenu) {
                    appleMenu.classList.add('is-open');
                    appleMenu.setAttribute('aria-hidden', 'false');
                }
                return;
            }
            // x-ray — локальная инверсия всего экрана (без iframe), как десктоп.
            if (target === 'xray') {
                closeAllMenus();
                toggleMobileXray();
                return;
            }
            // trnsltr — десктопный переводчик текущей страницы в iframe.
            if (target === 'trnsltr') {
                openItemFrame(content, 'trnsltr');
                return;
            }
            // iphone/backpack/luggage/camera/mp3/diary → iframe + полоска под крестиком
            openItemFrame(content, target, 'menu');
        }

        skeletonBtn.addEventListener('click', openMenu);

        // Глобальный touch-перехватчик: при открытом скелет-меню любой
        // touchmove ВНЕ меню/яблока/полоски items — отменяем (preventDefault).
        document.addEventListener('touchmove', function(e) {
            if (!document.body.classList.contains('m-menu-open')) return;
            if (e.target.closest('.m-skeleton-menu, .m-apple-menu, .m-item-strip')) return;
            e.preventDefault();
        }, { passive: false });

        // Крестик: если открыт iframe-контент — сначала закрываем его,
        // только повторный клик закрывает само меню
        closeBtn.addEventListener('click', function() {
            if (content && content.classList.contains('is-open')) {
                closeContentOrHome(content);
            } else {
                closeMenu();
            }
        });

        menu.addEventListener('click', function(e) {
            var el = e.target.closest('[data-target]');
            if (!el) return;
            e.preventDefault();
            handleTarget(el.dataset.target);
        });

        // Полоска items: lugg | iphone | … (комната или apple Items)
        var itemStrip = document.getElementById('mItemStrip');
        if (itemStrip) {
            itemStrip.addEventListener('click', function(e) {
                var link = e.target.closest('[data-item]');
                if (!link) return;
                e.preventDefault();
                e.stopPropagation();
                var key = link.getAttribute('data-item');
                if (!key) return;
                // Куда грузить: apple открыт → mapContent, иначе skeleton mskContent
                var mapContent = document.getElementById('mapContent');
                var host = (appleMenu && appleMenu.classList.contains('is-open') && mapContent)
                    ? mapContent
                    : content;
                if (!host) return;
                openItemFrame(
                    host,
                    key,
                    (appleMenu && appleMenu.classList.contains('is-open')) ? 'overlay' : 'menu'
                );
                // из комнаты остаёмся в комнате; из apple — kind=item (на главную)
                if (host === content) {
                    host.dataset.kind = 'item-stay';
                }
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key !== 'Escape') return;
            // apple-menu обрабатывает свой ESC сам
            if (appleMenu && appleMenu.classList.contains('is-open')) return;
            // если открыт iframe — закрыть его (предмет уводит на главную)
            if (content && content.classList.contains('is-open')) {
                closeContentOrHome(content);
                return;
            }
            closeMenu();
        });
    }

    // -----------------------------------------------------------------------
    // Apple-menu — сетка предметов, открывается из skeleton-menu
    // -----------------------------------------------------------------------

    function initAppleMenu() {
        var menu     = document.getElementById('mAppleMenu');
        var closeBtn = document.getElementById('mapClose');
        var content  = document.getElementById('mapContent');

        if (!menu) return;

        function closeMenu() {
            menu.classList.remove('is-open');
            menu.setAttribute('aria-hidden', 'true');
            clearContent(content);
            setItemStrip(null);
            syncMenuBodyLock();
        }

        // Крестик в apple-menu: сначала закрыть iframe (если открыт), потом меню
        if (closeBtn) closeBtn.addEventListener('click', function() {
            if (content && content.classList.contains('is-open')) {
                closeContentOrHome(content);
            } else {
                closeMenu();
            }
        });

        menu.addEventListener('click', function(e) {
            var el = e.target.closest('[data-target]');
            if (!el) return;
            // Ссылки nohome / about — обычные <a>, дёргать data-target не надо
            if (el.tagName === 'A') return;
            e.preventDefault();
            var target = el.dataset.target;
            // x-ray — локальная инверсия, закрываем оба меню (не в iframe!)
            if (target === 'xray') {
                closeAllMenus();
                toggleMobileXray();
                return;
            }
            // trnsltr и предметы — в iframe внутри apple-menu
            openItemFrame(content, target, target === 'trnsltr' ? null : 'overlay');
        });

        document.addEventListener('keydown', function(e) {
            if (e.key !== 'Escape' || !menu.classList.contains('is-open')) return;
            if (content && content.classList.contains('is-open')) {
                closeContentOrHome(content);
                return;
            }
            closeMenu();
        });
    }

    // -----------------------------------------------------------------------
    // Item-frame ⇄ родитель: кнопка закрыть (#mItemClose) внутри iframe
    // шлёт родителю postMessage; родитель чистит .msk-content или закрывает
    // меню. Сам iframe закрыть себя не может — он живёт внутри родителя.
    // -----------------------------------------------------------------------

    function initItemClose() {
        var btn = document.getElementById('mItemClose');
        var shell = document.getElementById('mItemShell');

        function sendClose() {
            if (window.parent && window.parent !== window) {
                window.parent.postMessage({ type: 'nh-item-close' }, '*');
            }
        }

        if (btn) btn.addEventListener('click', sendClose);

        // Swipe вбок по shell → закрыть.
        // Camera: при открытой фотке / в режиме camera свайп только листает,
        // закрытие — крестиком (иначе «выкидывает на главную»).
        if (shell) {
            var startX = 0, startY = 0, tracking = false;
            function isCameraSwipeNav() {
                if (document.body.classList.contains('is-camera-enlarged')) return true;
                if (document.querySelector('.enlarged-img-container, .enlarged-img')) return true;
                try {
                    var item = new URLSearchParams(window.location.search).get('item');
                    if (item === 'camera') return true;
                } catch (err) { /* ignore */ }
                return false;
            }
            shell.addEventListener('touchstart', function(e) {
                if (e.touches.length !== 1) return;
                // В camera не трекаем swipe-close вообще
                if (isCameraSwipeNav()) {
                    tracking = false;
                    return;
                }
                startX = e.touches[0].clientX;
                startY = e.touches[0].clientY;
                tracking = true;
            }, { passive: true });

            shell.addEventListener('touchend', function(e) {
                if (!tracking) return;
                tracking = false;
                if (isCameraSwipeNav()) return;
                var t = e.changedTouches[0];
                var dx = t.clientX - startX;
                var dy = t.clientY - startY;
                var threshold = window.innerWidth * 0.40;
                if (Math.abs(dx) > threshold && Math.abs(dx) > Math.abs(dy) * 1.5) {
                    sendClose();
                }
            }, { passive: true });
        }
    }

    function initParentMessageListener() {
        window.addEventListener('message', function(e) {
            if (!e.data || !e.data.type) return;

            // Чердак в iframe: блокировка свайпа на время анимации скелета
            if (e.data.type === 'nh-attic-animating') {
                document.body.classList.toggle('is-attic-animating', !!e.data.active);
                return;
            }

            // Детальный экран комнаты (спальня: рюкзак/чемодан):
            // блокируем свайп; при center — кадр по центру трека;
            // при закрытии — возвращаем scroll куда был до зума.
            if (e.data.type === 'nh-room-detail') {
                var scrollEl = document.getElementById('mRoomsScroll');
                var w = scrollEl ? scrollEl.offsetWidth : 0;
                var iframeBack = document.getElementById('mIframeBack');
                document.body.classList.toggle('is-room-detail', !!e.data.active);
                if (iframeBack) {
                    if (e.data.active) {
                        iframeBack.hidden = false;
                        iframeBack.removeAttribute('hidden');
                    } else {
                        iframeBack.hidden = true;
                    }
                }
                if (!scrollEl || !w) return;
                if (e.data.active) {
                    // Запомнить позицию «оглядывания», чтобы Back вернул туда
                    if (document.body.dataset.nhDetailRestore == null) {
                        document.body.dataset.nhDetailRestore = String(scrollEl.scrollLeft / w);
                    }
                    if (e.data.center) {
                        scrollEl.scrollLeft = w; // центр 300vw → чемодан/рюкзак в кадре
                    }
                } else {
                    var restore = typeof e.data.restore === 'number'
                        ? e.data.restore
                        : parseFloat(document.body.dataset.nhDetailRestore);
                    if (!isNaN(restore)) {
                        scrollEl.scrollLeft = restore * w;
                    }
                    delete document.body.dataset.nhDetailRestore;
                }
                return;
            }

            if (e.data.type !== 'nh-item-close') return;
            var skContent = document.getElementById('mskContent');
            var mapContent = document.getElementById('mapContent');
            // item → главная; item-stay / tool → очистить (+ меню при stay)
            if (skContent && skContent.classList.contains('is-open')) {
                closeContentOrHome(skContent);
                syncMenuBodyLock();
                return;
            }
            if (mapContent && mapContent.classList.contains('is-open')) {
                closeContentOrHome(mapContent);
                syncMenuBodyLock();
                return;
            }
            goHome();
        });
    }

    // Back на родителе → iframe закрывает зум (рюкзак/чемодан/окно)
    function initIframeBackButton() {
        var btn = document.getElementById('mIframeBack');
        if (!btn) return;

        function sendBack() {
            var mHome = document.getElementById('mHome');
            // Нативный зум: Back на родителе (поверх градиента) → та же логика, что у кнопки в комнате
            if (mHome && mHome.classList.contains('is-native-zoom') &&
                typeof window.nhNativeRoomBack === 'function') {
                window.nhNativeRoomBack();
                return;
            }
            var iframe = document.querySelector('.m-inner-iframe');
            if (!iframe || !iframe.contentWindow) return;
            try {
                iframe.contentWindow.postMessage({ type: 'nh-room-back' }, '*');
            } catch (err) { /* ignore */ }
        }

        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            sendBack();
        });
        // iOS иногда глотает click на fixed-кнопках поверх iframe — дубль на touchend
        btn.addEventListener('touchend', function(e) {
            e.preventDefault();
            e.stopPropagation();
            sendBack();
        }, { passive: false });
    }

    $(document).ready(function() {
        console.log('[nohome mobile] ready');
        // На всякий случай: после hot-reload / странного back не оставлять
        // m-menu-open без открытых меню (скелет тогда не кликается).
        document.body.classList.remove('m-menu-open');
        restoreMobileXray();          // восстановить инверсию, если был активен
        initMobileHome();
        initNoteOverlay();
        initStickerInfoOverlay();
        initSkeletonMenu();
        initAppleMenu();
        initItemClose();              // работает только если в DOM есть #mItemClose (item-frame)
        initParentMessageListener();  // безвредно если родитель = top-window
        initIframeBackButton();
        syncMenuBodyLock();
    });

})(jQuery);
