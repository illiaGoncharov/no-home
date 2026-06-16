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

        // Flat-страницы (about и т.п.) — один экран 100vw, центрировать НЕ
        // надо: иначе scrollLeft уводит единственный iframe за экран влево.
        var mHome  = document.getElementById('mHome');
        var isFlat = mHome && mHome.classList.contains('m-inner-flat');

        // Без анимации прокручиваем к центральной секции (только не-flat)
        if (isFlat) {
            currentIdx = 0;
            scroll.scrollLeft = 0;
        } else {
            scroll.scrollLeft = scroll.offsetWidth;
        }

        // Плавный переход к секции по индексу
        function goTo(idx) {
            // Guard: при открытом скелет-меню стрелки не должны навигировать
            if (document.body.classList.contains('m-menu-open')) return;
            if (idx < 0 || idx >= total) return;
            currentIdx = idx;
            scroll.scrollTo({ left: idx * scroll.offsetWidth, behavior: 'smooth' });
            updateArrows();
        }

        // Затемняем стрелки на крайних позициях (не скрываем)
        function updateArrows() {
            if (arrowLeft)  arrowLeft.classList.toggle('is-dimmed',  currentIdx === 0);
            if (arrowRight) arrowRight.classList.toggle('is-dimmed', currentIdx === total - 1);
        }

        // Синхронизация при ручном свайпе
        var scrollTimer;
        scroll.addEventListener('scroll', function() {
            clearTimeout(scrollTimer);
            scrollTimer = setTimeout(function() {
                var w = scroll.offsetWidth;
                if (w > 0) {
                    currentIdx = Math.round(scroll.scrollLeft / w);
                    updateArrows();
                }
            }, 80);
        }, { passive: true });

        if (arrowLeft)  arrowLeft.addEventListener('click',  function() { goTo(currentIdx - 1); });
        if (arrowRight) arrowRight.addEventListener('click', function() { goTo(currentIdx + 1); });

        if (skeletonBtn) {
            skeletonBtn.addEventListener('click', function() {
                console.log('[nohome mobile] skeleton menu — coming soon');
            });
        }

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
        var cancelBtn = document.getElementById('mNoteCancel');
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
        cancelBtn.addEventListener('click', close);

        // Клик по фону закрывает оверлей
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
        if (sk) { sk.classList.remove('is-open'); sk.setAttribute('aria-hidden', 'true'); }
        if (ap) { ap.classList.remove('is-open'); ap.setAttribute('aria-hidden', 'true'); }
        document.body.classList.remove('m-menu-open');
        // Заморозка трека снимается через CSS (класс m-menu-open убран).
        // Inline display/scrollLeft больше не трогаем — позиция сохраняется.
        var skC = document.getElementById('mskContent');
        var apC = document.getElementById('mapContent');
        if (skC) { skC.classList.remove('is-open'); skC.innerHTML = ''; }
        if (apC) { apC.classList.remove('is-open'); apC.innerHTML = ''; }
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

    function clearContent(container) {
        if (!container) return;
        container.classList.remove('is-open');
        container.innerHTML = '';
        delete container.dataset.kind;
    }

    // Закрытие открытого контента: предмет уводит на главную,
    // инструмент (переводчик) просто очищается.
    function closeContentOrHome(container) {
        if (!container) return;
        if (container.dataset.kind === 'item') { goHome(); return; }
        clearContent(container);
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
                showIframe(content, 'trnsltr');
                return;
            }
            // iphone/backpack/luggage/camera/mp3/diary → iframe item-frame
            showIframe(content, target);
        }

        skeletonBtn.addEventListener('click', openMenu);

        // Глобальный touch-перехватчик: при открытом скелет-меню любой
        // touchmove ВНЕ меню/яблока — отменяем (preventDefault).
        // Закрывает iOS-дыру, когда display:none не успевает применить.
        document.addEventListener('touchmove', function(e) {
            if (!document.body.classList.contains('m-menu-open')) return;
            if (e.target.closest('.m-skeleton-menu, .m-apple-menu')) return;
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
            showIframe(content, target);
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

        // Swipe вбок по shell → закрыть. Триггер: |dx| > 40% ширины окна,
        // и жест явно горизонтальный (|dx| > |dy| * 1.5) — иначе мешаем
        // вертикальному скроллу items-wrapper.
        if (shell) {
            var startX = 0, startY = 0, tracking = false;
            shell.addEventListener('touchstart', function(e) {
                if (e.touches.length !== 1) return;
                startX = e.touches[0].clientX;
                startY = e.touches[0].clientY;
                tracking = true;
            }, { passive: true });

            shell.addEventListener('touchend', function(e) {
                if (!tracking) return;
                tracking = false;
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
            if (!e.data || e.data.type !== 'nh-item-close') return;
            // Предмет закрыт изнутри (крестик/свайп) — уводим на главную.
            goHome();
        });
    }

    $(document).ready(function() {
        console.log('[nohome mobile] ready');
        restoreMobileXray();          // восстановить инверсию, если был активен
        initMobileHome();
        initNoteOverlay();
        initSkeletonMenu();
        initAppleMenu();
        initItemClose();              // работает только если в DOM есть #mItemClose (item-frame)
        initParentMessageListener();  // безвредно если родитель = top-window
    });

})(jQuery);
