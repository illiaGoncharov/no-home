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

        // Без анимации прокручиваем к центральной секции
        scroll.scrollLeft = scroll.offsetWidth;

        // Плавный переход к секции по индексу
        function goTo(idx) {
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

    $(document).ready(function() {
        console.log('[nohome mobile] ready');
        initMobileHome();
        initNoteOverlay();
    });

})(jQuery);
