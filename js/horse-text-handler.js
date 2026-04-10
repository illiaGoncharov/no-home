
// ===============================================================================
// АРХИТЕКТУРА: Стабильная система для hover text в пультике + skeleton navigation
// ===============================================================================

(function() {
    // 🐛 DEBUG MODE: включать только для диагностики проблем
    const DEBUG = false; // PRODUCTION MODE: disabled для продакшена
    
    const log = (...args) => DEBUG && console.log('🐴 [HorseText]', ...args);
    const DEFAULT_TEXT = "you can move me and listen to me. you can close me by pressing the button at the top.";

    // ===============================================================================
    // 🧹 СИСТЕМА ОЧИСТКИ: сброс состояния при переходе между комнатами
    // ===============================================================================
    
    window.cleanupRoomState = () => {
        log('🧹 Очистка состояния комнат...');
        
        // 1. Сбрасываем состояние чердака
        if (window.atticState) {
            window.atticState.clickCount = 0;
            window.atticState.initialized = false; // Сбрасываем флаг для повторной инициализации
            if (window.atticState.cursor) {
                window.atticState.cursor.remove();
                window.atticState.cursor = null;
            }
            clearTimeout(window.atticState.inactivityTimer);
            log('🧹 Состояние чердака сброшено');
        }
        
        // 2. Удаляем лишние курсоры чердака
        document.querySelectorAll('.attic-cursor').forEach(el => el.remove());
        
        // 3. Сбрасываем состояние спальни
        if (window.bedroomState) {
            window.bedroomState.inDetailView = false;
        }
        
        // 4. Сбрасываем текст пульта на дефолт
        if (typeof window.updateHorseText === 'function') {
            window.updateHorseText(DEFAULT_TEXT, 0);
        }
        
        // 5. Отправляем событие очистки для кастомных обработчиков
        document.dispatchEvent(new CustomEvent('roomCleanup'));
        
        log('🧹 ✅ Очистка завершена');
    };
    
    // Автоматическая очистка при загрузке страницы (для bfcache)
    window.addEventListener('pageshow', (event) => {
        if (event.persisted) {
            log('🔄 Страница восстановлена из кэша, очищаем состояние...');
            window.cleanupRoomState();
        }
    });
    
    // Очистка при обычной загрузке
    document.addEventListener('DOMContentLoaded', () => {
        log('📄 DOM загружен, инициализируем чистое состояние');
        // Небольшая задержка чтобы скрипты комнат успели инициализироваться
        setTimeout(() => {
            // Удаляем старые курсоры если остались
            document.querySelectorAll('.attic-cursor').forEach(el => el.remove());
        }, 100);
    });
    
    // Очистка при уходе со страницы
    window.addEventListener('beforeunload', () => {
        log('🚪 Уход со страницы, очищаем состояние');
        window.cleanupRoomState();
    });
    
    // Очистка при клике на навигационные ссылки
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a[href]');
        if (link) {
            const href = link.getAttribute('href') || '';
            if (href && !href.startsWith('#') && !href.startsWith('javascript:')) {
                log('🔗 Клик по ссылке, очищаем состояние');
                window.cleanupRoomState();
            }
        }
    });

    // ===============================================================================
    // 🎯 CORE SYSTEM: Поиск элемента пульта и обновление текста
    // ===============================================================================
    
    const findHorseTextElement = () => {
        const candidates = [
            document.getElementById('hi-update'),
            document.querySelector('.horse-indicator-text'),
            document.querySelector('[data-horse-text]')
        ];

        for (let el of candidates) {
            if (el) {
                log('✅ Пульт найден:', el.id || el.className);
                return el;
            }
        }

        console.error('🚨 КРИТИЧЕСКАЯ ОШИБКА: Пульт не найден!');
        return null;
    };

    // 🔄 СИСТЕМА ОБНОВЛЕНИЯ ТЕКСТА: каждая смена — новая «титра» справа
    const updateHorseText = (text, options = {}) => {
        if (window.horseTextBlocked) return;
        const { duration = 0, force = true } = options;
        const horseTextEl = findHorseTextElement();
        if (!horseTextEl) return;

        try {
            const textToSet = text || DEFAULT_TEXT;
            
            let scrollTextEl = horseTextEl.querySelector('#horse-text-original');
            if (!scrollTextEl) {
                scrollTextEl = document.createElement('div');
                scrollTextEl.id = 'horse-text-original';
                horseTextEl.innerHTML = '';
                horseTextEl.appendChild(scrollTextEl);
            }
            
            scrollTextEl.textContent = textToSet;
            
            // Останавливаем предыдущую анимацию
            if (scrollTextEl.animationInterval) {
                clearInterval(scrollTextEl.animationInterval);
                scrollTextEl.animationInterval = null;
            }
            
            // Новый текст всегда выезжает справа
            let position = horseTextEl.offsetWidth;
            scrollTextEl.style.transform = `translateX(${position}px)`;
            
            scrollTextEl.animationInterval = setInterval(() => {
                position -= 1.5;
                scrollTextEl.style.transform = `translateX(${position}px)`;
                
                if (position < -scrollTextEl.offsetWidth - 50) {
                    position = horseTextEl.offsetWidth + 20;
                }
            }, 16);
            
            log('🎬 Новая титра:', textToSet);

            if (force) {
                Object.assign(horseTextEl.style, {
                    opacity: '1',
                    visibility: 'visible',
                    display: 'block',
                    textShadow: '0 0 8px rgba(255,255,255,0.3)',
                    transition: 'all 0.3s ease'
                });

                const parentWrapper = horseTextEl.closest('.horse-indicator-text-wrapper');
                if (parentWrapper) {
                    Object.assign(parentWrapper.style, {
                        opacity: '1',
                        visibility: 'visible'
                    });
                }
            }

            if (duration > 0) {
                setTimeout(() => updateHorseText(DEFAULT_TEXT, { duration: 0 }), duration);
            }

        } catch (error) {
            console.error('❌ ОШИБКА обновления пульта:', error);
        }
    };

    // 🌍 ГЛОБАЛЬНАЯ ФУНКЦИЯ для других скриптов (items.js, golden.js, etc.)
    window.updateHorseText = (text, duration = 5000) => {
        // Блокировка обновлений во время загрузки
        if (window.horseTextBlocked) {
            log('🚫 Обновление заблокировано');
            return;
        }
        log('🌐 Внешний вызов updateHorseText:', text);
        updateHorseText(text, { duration });
    };
    
    // Глобальные функции для блокировки/разблокировки обновлений
    window.blockHorseText = () => { window.horseTextBlocked = true; };
    window.unblockHorseText = () => { window.horseTextBlocked = false; };
    
    // ===============================================================================
    // 🎵 ГЛОБАЛЬНЫЕ ФУНКЦИИ УПРАВЛЕНИЯ МУЗЫКОЙ И ПУЛЬТОМ
    // ===============================================================================
    
    // Переключение режима пульта (обычный ↔ плеер)
    window.switchRemoteToPlayerMode = (showPlayer) => {
        const displayNormal = document.querySelector('.display-normal');
        const displayPlayer = document.querySelector('.display-player');
        
        if (displayNormal && displayPlayer) {
            if (showPlayer) {
                displayNormal.style.display = 'none';
                displayPlayer.style.display = 'block';
                log('🎛️ Пульт переключён в режим плеера');
            } else {
                displayNormal.style.display = 'block';
                displayPlayer.style.display = 'none';
                log('🎛️ Пульт переключён в обычный режим');
            }
        }
    };
    
    // Запуск музыки (если не играет)
    window.startMusicIfNotPlaying = (source = 'unknown') => {
        log('🎵 startMusicIfNotPlaying из:', source);
        
        const playButton = document.querySelector('.play-stop');
        if (playButton) {
            const buttonText = playButton.textContent.trim().toLowerCase();
            
            if (buttonText === 'play' || buttonText === '' || !buttonText.includes('stop')) {
                playButton.click();
                log('🎵 ✅ Музыка запущена из:', source);
                setTimeout(() => window.switchRemoteToPlayerMode(true), 100);
                return true;
            } else {
                log('🎵 Музыка уже играет');
                return false;
            }
        }
        log('⚠️ Кнопка плеера не найдена');
        return false;
    };
    
    // Остановка музыки (если играет)
    window.stopMusicIfPlaying = (source = 'unknown') => {
        log('🔇 stopMusicIfPlaying из:', source);
        
        const playButton = document.querySelector('.play-stop');
        if (playButton) {
            const buttonText = playButton.textContent.trim().toLowerCase();
            
            if (buttonText === 'stop' || buttonText.includes('stop')) {
                playButton.click();
                log('🔇 ✅ Музыка остановлена из:', source);
                setTimeout(() => window.switchRemoteToPlayerMode(false), 100);
                return true;
            } else {
                log('🔇 Музыка уже не играет');
                return false;
            }
        }
        return false;
    };
    
    // ===============================================================================
    // 🔍 СИСТЕМА ПОИСКА ЭЛЕМЕНТОВ: безопасный поиск по множественным селекторам
    // ===============================================================================
    
    const findElements = (selectors) => {
        const selectorArray = Array.isArray(selectors) ? selectors : [selectors];
        const results = [];

        selectorArray.forEach(selector => {
            try {
                if (selector && typeof selector === 'string') {
                    const elements = document.querySelectorAll(selector);
                    if (elements.length > 0) {
                        results.push(...Array.from(elements));
                        log('✅ Найдено', elements.length, 'элементов для:', selector);
                    }
                }
            } catch (e) {
                log('❌ Неверный селектор:', selector, '|', e.message);
            }
        });

        // Удаляем дубликаты
        const uniqueElements = results.filter((element, index, self) => 
            self.indexOf(element) === index
        );

        return uniqueElements;
    };

    // ===============================================================================
    // 🎯 HOVER INTERACTION SYSTEM: НЕ блокирует клики, ТОЛЬКО hover text
    // ===============================================================================
    
    const setupHoverInteraction = (selectors, enterText, leaveText = DEFAULT_TEXT) => {
        const foundElements = findElements(selectors);
        
        if (foundElements.length === 0) {
            log('⚠️ Не найдены элементы для:', selectors);
            return;
        }
        
        foundElements.forEach(element => {
            const elementId = element.id || element.className || 'unknown';
            
            // ЗАЩИТА ОТ ДУБЛЕЙ: проверяем есть ли уже наши handlers
            if (element.hasAttribute('data-horse-hover-setup')) {
                log('🛡️ Элемент уже настроен:', elementId);
                return;
            }

            // СОЗДАЕМ НЕБЛОКИРУЮЩИЕ PASSIVE HANDLERS
            const onMouseEnter = () => {
                updateHorseText(enterText);
                log('🎯 Hover IN:', elementId, '→', enterText);
            };

            const onMouseLeave = () => {
                updateHorseText(leaveText);
                log('👋 Hover OUT:', elementId, '→', leaveText);
            };

            // ДОБАВЛЯЕМ PASSIVE LISTENERS - НЕ блокируют click events!
            element.addEventListener('mouseenter', onMouseEnter, { passive: true });
            element.addEventListener('mouseleave', onMouseLeave, { passive: true });
            
            // Помечаем элемент как настроенный
            element.setAttribute('data-horse-hover-setup', 'true');
            
            log('✅ Hover настроен для:', elementId);
            });
        };

    // ===============================================================================
    // 🦴 SKELETON INTERACTIONS: управление текстом в пультике при работе со скелетом
    // ===============================================================================
    
    const setupSkeletonInteractions = () => {
        log('🦴 Настройка SKELETON interactions (текст пульта)...');
        
        // Находим нужные элементы
        const skeletonButton = document.querySelector('.skeleton-button');
        const skeletonButtonElement = document.getElementById('skeleton-button');
        const skeletonHomeLink = document.getElementById('skeleton-home-link');
        
        // Текст для открытого скелета
        const showSkeletonText = () => {
            updateHorseText("please, select one of my limbs");
            log('🦴 Показан текст про limbs');
        };
        
        // Сброс текста на дефолтный
        const resetToDefaultText = () => {
            updateHorseText(DEFAULT_TEXT);
            log('🔄 Сброс на дефолтный текст');
        };
        
        // Добавляем обработчики только для обновления текста
        if (skeletonButton) {
            skeletonButton.addEventListener('click', showSkeletonText);
            log('✓ Обработчик для кнопки скелета настроен');
        }
        
        if (skeletonButtonElement && skeletonButtonElement !== skeletonButton) {
            skeletonButtonElement.addEventListener('click', showSkeletonText);
            log('✓ Обработчик для элемента кнопки скелета настроен');
        }
        
        if (skeletonHomeLink) {
            skeletonHomeLink.addEventListener('click', resetToDefaultText);
            log('✓ Обработчик для ссылки home настроен');
        }
        
        // Примечание: визуальное управление скелетом происходит в header.php
    };

    // ===============================================================================
    // 🏠 BEDROOM INTERACTIONS: внешние ссылки для интеграции с [local]bedroom.php
    // ===============================================================================
    
    // Код перемещен в [local]bedroom.php для удобства работы с ним
    const setupBedroomInteractions = () => {
        log('🏠 BEDROOM interactions перенесены в [local]bedroom.php');
    };

    // ===============================================================================
    // 🗻 CAVE INTERACTIONS: точные селекторы из [local]cave.php  
    // ===============================================================================
    
    const setupCaveInteractions = () => {
        // Логика для пещеры перенесена в local/[local]cave.php, чтобы избежать дублей и гонок
        log('🗻 CAVE interactions перенесены в [local]cave.php');
    };

    // ===============================================================================
    // 🪑 TABLE INTERACTIONS: точные селекторы из [local]table.php
    // ===============================================================================
    
    const setupTableInteractions = () => {
        log('🪑 Настройка TABLE interactions...');
        
        // Стол
        setupHoverInteraction([
            '.table-in-table-room'
        ], "I hope this table is adaptive enough for you");

        // Ноутбук
        setupHoverInteraction([
            '#laptop-on-table'
        ], "my heart is surrounded by bones. I am able to hear both the heart and the bones. What about you?");

        // Камера  
        setupHoverInteraction([
            '.camera-in-table-room-'
        ], "the motives of this camera are not clear, the date and time are broken");

        // Жёсткий диск
        setupHoverInteraction([
            '#hard-disk-on-skeleton-chair'
        ], "don't rush to leave, it's a fine day");

        // ВАЖНО: iPhone НЕ добавляем в hover - у него своя логика капчи!
        // ВАЖНО: Окна НЕ добавляем - у них своя handleWindowInteraction!
        
        // Рукописный текст в окне
        setupHoverInteraction([
            '.hand',
            '.handwriting',
            '[class*="hand"]'
        ], "please, do not leave. I will hide away shortly and you can scroll.");
    };

    // ===============================================================================  
    // 🏆 GOLD INTERACTIONS: точные селекторы из [local]gold.php
    // ===============================================================================
    
    const setupGoldInteractions = () => {
        log('🏆 Настройка GOLD interactions...');
        
        // Дверь
        setupHoverInteraction([
            '.overlay-svg[class*="door"]', 
            '[class*="door"]'
        ], "what do you prefer - closed/open doors or closed/open locks?");

        // Замок
        setupHoverInteraction([
            '#LockInLockOverlay',
            '.lock', 
            '[class*="lock"]'
        ], "do you know how to cipher?");

        // Крысы (hover разрешен - они всё равно не анимировались)
        setupHoverInteraction([
            '.golden-room-door-rats', 
            '.rats', 
            '[class*="rat"]'
        ], "oh no, i am sorry, the mice have escaped the lab!");
    };

    // ===============================================================================
    // 🏠 MAIN PAGE INTERACTIONS: стикеры и элементы на главной странице
    // ===============================================================================
    
    const setupMainPageInteractions = () => {
        log('🏠 Настройка MAIN PAGE interactions...');
        
        // Стикеры и A4 листы
        setupHoverInteraction([
            '.sticker',
            '.paper',
            '.note',
            '[class*="sticker"]',
            '[class*="note"]',
            '.a4-sheet',
            '[class*="sheet"]'
        ], "sorry for being weird it's my first time being alive");
        
        // Стикер с отправкой на почту (с точным селектором)
        setupHoverInteraction([
            '.sticker-img.note8',
            '#sticker-img-note8',
            '.note8',
            '#note8',
            'img[src*="note8"]',
            'img[data-sticker="en—//note_8"]',
            '.sticker-img[data-sticker="en—//note_8"]',
            '[data-sticker*="note_8"]'
        ], "you can leave a note or leave nothing");
        
        // Классики (hopscotch) в cave room
        setupHoverInteraction([
            '.hopscotch',
            '.numbers',
            '[class*="hopscotch"]',
            '[class*="numbers"]'
        ], "the numbers on your way are a chance to establish contact with them");
    };

    // ===============================================================================
    // 🚀 MAIN INITIALIZATION: запуск всех систем
    // ===============================================================================
    
    const initializeHorseTextHandler = () => {
        log('🚀 Инициализация Horse Text Handler...');
        
        // Настройка базовых систем
        setupSkeletonInteractions();
        
        // Настройка hover interactions для главной страницы и всех комнат
        setupMainPageInteractions();
        setupBedroomInteractions();
        setupCaveInteractions(); 
        setupTableInteractions();
        setupGoldInteractions();
        
        // Устанавливаем дефолтный текст
                    updateHorseText(DEFAULT_TEXT);
        
        log('✅ Horse Text Handler полностью инициализирован!');
    };

    // ===============================================================================
    // 🔄 AUTO-START: запуск при загрузке DOM + реинициализация
    // ===============================================================================
    
    // Функция реинициализации (для skeleton navigation)
    window.reInitializeHorseInteractions = () => {
        log('🔄 РЕИНИЦИАЛИЗАЦИЯ Horse Text Handler...');
        
        // Очищаем старые handlers (снимаем защиту от дублей)
        document.querySelectorAll('[data-horse-hover-setup]').forEach(el => {
            el.removeAttribute('data-horse-hover-setup');
        });
        
        // Перезапускаем все interactions
        setTimeout(() => {
            setupMainPageInteractions();
            setupBedroomInteractions();
            setupCaveInteractions();
            setupTableInteractions(); 
            setupGoldInteractions();
            log('✅ Реинициализация завершена!');
        }, 500);
    };

    // Автозапуск при загрузке страницы
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeHorseTextHandler);
    } else {
        // DOM уже загружен
        setTimeout(initializeHorseTextHandler, 100);
    }

    // Реинициализация при Ajax-навигации (skeleton переходы)
    let lastUrl = window.location.href;
    new MutationObserver(() => {
        if (lastUrl !== window.location.href) {
            lastUrl = window.location.href;
            log('🌐 URL изменился - запуск реинициализации...');
            
            setTimeout(() => {
                if (window.reInitializeHorseInteractions) {
                    window.reInitializeHorseInteractions();
                }
            }, 1000);
        }
    }).observe(document.body, { childList: true, subtree: true });

    log('🐴 Horse Text Handler модуль загружен!');

})();