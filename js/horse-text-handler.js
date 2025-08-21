
// ===============================================================================
// АРХИТЕКТУРА: Стабильная система для hover text в пультике + skeleton navigation
// ===============================================================================

(function() {
    // 🐛 DEBUG MODE: включать только для диагностики проблем
    const DEBUG = false; // PRODUCTION MODE: disabled для продакшена
    
    const log = (...args) => DEBUG && console.log('🐴 [HorseText]', ...args);
    const DEFAULT_TEXT = "you can move me and listen to me. you can close me by pressing the button at the top.";

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

    // 🔄 СИСТЕМА ОБНОВЛЕНИЯ ТЕКСТА: стабильная анимация + принудительная видимость
    const updateHorseText = (text, options = {}) => {
        const { duration = 0, force = true } = options;
        const horseTextEl = findHorseTextElement();
        if (!horseTextEl) return;

        try {
            const textToSet = text || DEFAULT_TEXT;
            
            // Создаем/находим элемент для прокрутки текста
            let scrollTextEl = horseTextEl.querySelector('#horse-text-original');
            if (!scrollTextEl) {
                scrollTextEl = document.createElement('div');
                scrollTextEl.id = 'horse-text-original';
                horseTextEl.innerHTML = '';
                horseTextEl.appendChild(scrollTextEl);
            }
            
            scrollTextEl.textContent = textToSet;
            
            // 🎬 СТАБИЛЬНАЯ АНИМАЦИЯ: начинаем справа от контейнера
            let position = 20; 
            scrollTextEl.style.transform = `translateX(${position}px)`;
            
            // Очищаем предыдущую анимацию
            if (scrollTextEl.animationInterval) {
                clearInterval(scrollTextEl.animationInterval);
            }
            
            // Запускаем плавную анимацию прокрутки
            scrollTextEl.animationInterval = setInterval(() => {
                position -= 1;
                scrollTextEl.style.transform = `translateX(${position}px)`;
                
                // Сброс когда текст ушел за левый край
                if (position < -scrollTextEl.offsetWidth - 50) {
                    position = horseTextEl.offsetWidth + 20;
                }
            }, 16);
            
            log('🎬 Анимация запущена для текста:', textToSet);

            // 🔧 ПРИНУДИТЕЛЬНАЯ ВИДИМОСТЬ пульта
            if (force) {
                Object.assign(horseTextEl.style, {
                    opacity: '1 !important',
                    visibility: 'visible !important',
                    display: 'block !important',
                    color: 'white !important',
                    transform: 'none !important',
                    textShadow: '0 0 10px rgba(255,255,255,0.7)',
                    transition: 'all 0.3s ease'
                });

                const parentWrapper = horseTextEl.closest('.horse-indicator-text-wrapper');
                if (parentWrapper) {
                    Object.assign(parentWrapper.style, {
                        opacity: '1 !important',
                        visibility: 'visible !important'
                    });
                }
            }

            // ⏰ Авто-сброс через duration (если указан)
            if (duration > 0) {
                setTimeout(() => updateHorseText(DEFAULT_TEXT, { duration: 0 }), duration);
            }

        } catch (error) {
            console.error('❌ ОШИБКА обновления пульта:', error);
        }
    };

    // 🌍 ГЛОБАЛЬНАЯ ФУНКЦИЯ для других скриптов (items.js, golden.js, etc.)
    window.updateHorseText = (text, duration = 5000) => {
        log('🌐 Внешний вызов updateHorseText:', text);
        updateHorseText(text, { duration });
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
    // 🦴 SKELETON NAVIGATION SYSTEM: управление "limbs" текстом
    // ===============================================================================
    
    const setupSkeletonInteractions = () => {
        const skeletonButton = document.querySelector('.skeleton-button');
        const skeletonHome = document.querySelector('.skeleton-home');
        
        if (skeletonButton) {
            // При клике на кнопку скелета - показываем "limbs" текст
            skeletonButton.addEventListener('click', () => {
                updateHorseText("please, select one of my limbs");
                log('🦴 Скелет открыт - показан текст limbs');
            });
        }

        if (skeletonHome) {
            // Наблюдаем за закрытием скелета для сброса текста
            const observer = new MutationObserver((mutations) => {
                mutations.forEach(mutation => {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        const hasShow = skeletonHome.classList.contains('show');
                        if (!hasShow) {
                            // Скелет закрыт - возвращаем дефолтный текст
                            updateHorseText(DEFAULT_TEXT);
                            log('🚪 Скелет закрыт - сброшен текст к дефолтному');
                        }
                    }
                });
            });
            
            observer.observe(skeletonHome, { attributes: true, attributeFilter: ['class'] });
        }
    };

    // ===============================================================================
    // 🏠 BEDROOM INTERACTIONS: точные селекторы из [local]bedroom.php
    // ===============================================================================
    
    const setupBedroomInteractions = () => {
        log('🏠 Настройка BEDROOM interactions...');
        
        // Рюкзак - ТОЛЬКО hover text (без капчи!)
        setupHoverInteraction([
            '#bag-in-bedroom',
            '#backpack-in-bedroom', 
            '#backpack-in-bedroom-room',
            '.bag-in-bedroom',
            '.backpack'
        ], "watch out! Is something or someone behind you? are objects also subjects?");

        // Чемодан - ТОЛЬКО hover text (без капчи!)  
        setupHoverInteraction([
            '#suitcase-in-bedroom-room',
            '.suitcase',
            '.suitcase-in-bedroom-room'
        ], "watch out! Is something or someone behind you? are objects also subjects?");

        // Силуэт в окне
        setupHoverInteraction([
            '#silhouette',
            '.silhouette'
        ], "have you ever been activated? please, check in with your soul. there are many other souls in the walls, it can get confusing.");

        // Окно наружу
        setupHoverInteraction([
            '#outside-bedroom',
            '.outside-bedroom'
        ], "do you know the temperature of air outside someone's window?");
    };

    // ===============================================================================
    // 🗻 CAVE INTERACTIONS: точные селекторы из [local]cave.php  
    // ===============================================================================
    
    const setupCaveInteractions = () => {
        log('🗻 Настройка CAVE interactions...');
        
        // Шлем безопасности  
        setupHoverInteraction([
            '.safety-helmet',
            '.safety-helmet-f',
            '#safety-helmet',
            '#safety-helmet-f'
        ], "mind your head");

        // Колонка/Speaker
        setupHoverInteraction([
            '#gbl-speaker-in-items-room',
            '.gbl-speaker',
            '#speaker-to-mp3'
        ], "do you know how to follow well? are you a considerate person?");

        // Рация/Walkie
        setupHoverInteraction([
            '#walkie-phone-in-items-room',
            '.walkiephone',
            '.walkie'
        ], "do you know how to listen carefully?");

        // Зеркало
        setupHoverInteraction([
            '#mirror-svg-overlay',
            '.mirror-svg-overlay',
            '.items-next-to-mirror'
        ], "sorry, your reflection is not renderable");
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
            '#note8'
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