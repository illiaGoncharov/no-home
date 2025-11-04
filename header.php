<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php blankslate_schema_type(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<style src="https://nohome.cloud/wp-content/themes/blankslate/style.css"></style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	
<!-- Основные элементы интерфейса -->
<div class="interface-elements">
    <!-- Верхняя навигация -->
	<div class="nav-top">
        <div class="container-fluid">
            <div class="row nav-top-content">
                <div class="d-block col-xxl-9 col-xl-9 col-lg-8 col-md-8 col-sm-7">
                    <div class="about-link-wrapper">
                        <?php if (is_page('about')) : ?>
                            <a href="<?php echo get_home_url(); ?>" class="about-link" id="about-link" data-text="i">x</a>
                        <?php elseif (is_front_page()) : ?>
                            <a href="<?php echo get_permalink(get_page_by_path('about')); ?>" class="about-link" id="about-link" data-text="X">i</a>
                        <?php endif; ?>
                    </div>      
                </div>
        

                <!-- Кнопка отображения -->
                <div class="display-button-wrapper">
                    <button id="display-button">
                        <img src="https://nohome.cloud/wp-content/themes/blankslate/files/nav/horse.png" alt="Display"><p>display</p>
                    </button>
                </div>
                
                <!-- Индикатор состояния (лошадь) -->
                <div id="horseIndicator" class="horse-indicator col-xxl-3 col-xl-3 col-lg-4 col-md-4 col-sm-5">
                    <!-- Нормальный режим отображения -->
                    <div class="display-normal">
                        <img src="/wp-content/themes/blankslate/files/remote-control/remote-default.png" alt="Display">
                        <button id="close-hi"></button>
                        <div class="horse-indicator-wrapper">
                            <div class="horse-indicator-text-wrapper">
                                <div class="horse-indicator-text" id="hi-update">
                                    <!-- <p>The horse will lead you throughout the place</p> -->
                                    <span id="horse-text-original">
                                        you can move me and listen to me. 
                                        you can close me by pressing the button at the top
                                    </span>
                                </div>				
                            </div>
                        </div>
                    </div>
                    
                    <!-- Режим плеера -->
                    <div class="display-player" style="display:none;">
                        <img src="/wp-content/themes/blankslate/files/remote-control/remote-player.png" alt="Display">
                        <button id="close-hi"></button>
                        <!-- Информация о воспроизведении -->
                        <div class="horse-indicator-player">
                            <div class="horse-indicator-upper">
                                <div class="horse-indicator-playing-now">PLAYING NOW</div>
                                <div class="horse-indicator-side">SIDE I</div>
                            </div>
                            <div class="horse-indicator-song">
                                <div class="marquee-container">
                                    <div class="horse-indicator-song-now marquee-content">
                                        floating into
                                    </div>
                                </div>
                                <div class="horse-indicator-song-time">00:00</div>
                            </div>
                            <div class="horse-indicator-song-hashtag">
                                #WEB_SURFING
                            </div>		
                        </div>				
                    </div>
                        
                    <!-- Кнопки управления плеером -->
                    <button class="player-random player-button"></button>
                    <button class="player-previous player-button"></button>
                    <button class="player-stop-play player-button"></button>
                    <button class="player-next player-button"></button>
                    <button class="player-repeat player-button"></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Нижняя навигация -->
    <div class="nav-bottom">
        <!-- Кнопка управления громкостью -->
    <button id="volume-button">
            <img src="https://nohome.cloud/wp-content/themes/blankslate/files/nav/volume.png" alt="Volume"><p>volume</p>
        </button>

        <!-- Экран управления громкостью -->
        <div id="volume-screen">
            <img src="https://nohome.cloud/wp-content/themes/blankslate/files/nav/volume-screen.png">
            <div class="drop-wrapper">
                <div class="slider-container">
                    <input type="range" min="1" max="100" value="80" class="drop-range" id="volume-range">
                    <svg id="red-square" width="24" height="40">
                        <path d="M11.0912 0H12.5519V2.18099C13.037 2.18099 13.9861 2.18099 13.9861 2.18099H14.0178V2.20955V4.84421H15.4731V8.07705H16.9249C16.9249 8.90206 16.9249 11.5569 16.9249 11.5569H18.7494V17.3051H16.9232C16.9232 17.3051 16.9249 18.735 16.9249 18.9232H15.4678V20.1464H14.0072V21H9.64818V20.1464H8.16647V18.9232H6.71111C6.71111 17.8529 6.71111 18.3973 6.71111 17.3337C6.71111 17.3286 6.70936 17.3219 6.70584 17.3169C6.70233 17.3118 6.69881 17.3068 6.69529 17.3034H5.25049V11.5552H6.71111V8.07537H8.1735V4.84253H9.63588V2.18771C9.88371 2.18771 10.1263 2.18771 10.3688 2.18771C10.6096 2.18771 10.8504 2.19443 11.0912 2.18267V0Z" fill="#D42318"/>
                        <text x="5" y="33" id="volume-value" fill="#D42318">80</text>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Группа кнопок навигации -->
        <div class="button-group">
            <button id="translate-button">
                <img src="https://nohome.cloud/wp-content/themes/blankslate/files/nav/trnsltr.png" alt="Translate"><p>trnsltr</p>
            </button>
            <button id="x-ray-button">
                <img src="https://nohome.cloud/wp-content/themes/blankslate/files/nav/x-ray.png" alt="X-ray Vision"><p>x-ray</p>
            </button>
            <button id="items-button">
                <img src="https://nohome.cloud/wp-content/themes/blankslate/files/nav/items.png" alt="Items"><p>items</p>
            </button>
        </div>
    </div>
</div>

<!-- Кнопка скелета (не отображается на главной странице) -->
<!--?php
if (!is_page('5')) : ?-->
<div class="skeleton-button">
    <button id="skeleton-button" >
        <img src="/wp-content/themes/blankslate/files/nav/skeleton.png" alt="To rooms">
    </button>
    <a id="skeleton-home-link" href="/" style="display: none;">
        <img src="/wp-content/themes/blankslate/files/nav/skeleton-home-rooms.png" alt="To home">
		<p>nohome</p>
    </a>
</div>

<!-- Домашний экран скелета -->
<div class="skeleton-home" id="skeleton-home">
    <div class="skeleton-home-wrapper">
         <!-- Ссылки на различные области -->
        <img src="/wp-content/themes/blankslate/files/nav/skeleton-full.png">
		<a href="/0selectedarea4" class="skeleton-home-link ajax-page-link mattic" data-id="1582"></a>
		<a href="/0selectedarea3" class="skeleton-home-link ajax-page-link mtable" data-id="1973"></a>
		<a href="/0selectedarea2" class="skeleton-home-link ajax-page-link mcave" data-id="95"></a>
		<a href="/0selectedarea1" class="skeleton-home-link ajax-page-link mbed" data-id="1891"></a>
		<a href="/0selectedarea5" class="skeleton-home-link ajax-page-link mgolden" data-id="1330"></a>
    </div>
</div>
<!--?php endif; ?-->
				
<main id="content" role="main">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.insertAdjacentHTML('beforeend', '<div class="custom-cursor"></div>');
            const cursor = document.querySelector('.custom-cursor');
            
            document.addEventListener('mousemove', function(e) {
                cursor.style.left = e.clientX + 'px';
                cursor.style.top = e.clientY + 'px';
            });
            
            const clickableElements = document.querySelectorAll('a, button, [role="button"], .clickable, .overlay-svg');
            clickableElements.forEach(elem => {
                elem.addEventListener('mouseenter', () => cursor.classList.add('pulse'));
                elem.addEventListener('mouseleave', () => cursor.classList.remove('pulse'));
            });
            
            document.addEventListener('mousedown', function() {
                cursor.classList.add('clicked');
            });
            
            document.addEventListener('mouseup', function() {
                cursor.classList.remove('clicked');
            });
            
            // Обработка скелета и пульта
            const setupSkeletonNav = () => {
                const skeletonButton = document.getElementById('skeleton-button');
                const skeletonHomeLink = document.getElementById('skeleton-home-link');
                const skeletonHome = document.getElementById('skeleton-home');
                
                // Константы для текстов
                const SKELETON_TEXT = "please, select one of my limbs";
                const DEFAULT_TEXT = "you can move me and listen to me. you can close me by pressing the button at the top.";
                
                // Надежная функция обновления текста в пульте
                const safeUpdateHorseText = (text) => {
                    console.log('Обновляем текст в пульте:', text);
                    
                    // Попытка 1: Через глобальную функцию
                    if (typeof window.updateHorseText === 'function') {
                        try {
                            window.updateHorseText(text, 0); // 0 = без автосброса
                            return true;
                        } catch (e) {
                            console.error('Ошибка при вызове window.updateHorseText:', e);
                        }
                    }
                    
                    // Попытка 2: Прямое обновление DOM
                    try {
                        // Ищем элемент текста по разным селекторам
                        const horseTextEl = document.getElementById('horse-text-original') || 
                                           document.querySelector('.horse-indicator-text span') ||
                                           document.querySelector('.horse-indicator-text');
                        
                        if (horseTextEl) {
                            horseTextEl.textContent = text;
                            return true;
                        }
                    } catch (e) {
                        console.error('Ошибка при прямом обновлении DOM:', e);
                    }
                    
                    return false;
                };
                
                // Функция для отслеживания видимости скелета
                const setupSkeletonObserver = () => {
                    // Создаем наблюдатель за изменениями стилей
                    const observer = new MutationObserver((mutations) => {
                        mutations.forEach((mutation) => {
                            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                                const isVisible = skeletonHome.style.display === 'flex' || 
                                                skeletonHome.style.display === 'block';
                                
                                // Обновляем текст в зависимости от состояния
                                if (isVisible) {
                                    safeUpdateHorseText(SKELETON_TEXT);
                                } else {
                                    safeUpdateHorseText(DEFAULT_TEXT);
                                }
                            }
                        });
                    });
                    
                    // Запускаем наблюдение за изменениями стиля display
                    observer.observe(skeletonHome, { 
                        attributes: true, 
                        attributeFilter: ['style'] 
                    });
                    
                    return observer;
                };
                
                if (skeletonButton && skeletonHomeLink && skeletonHome) {
                    // Запускаем наблюдатель за скелетом
                    const observer = setupSkeletonObserver();
                    
                    // Открыть скелет
                    skeletonButton.addEventListener('click', () => {
                        skeletonHome.style.display = 'flex';
                        skeletonHomeLink.style.display = 'block';
                        skeletonButton.style.display = 'none';
                        
                        // Скрываем кнопку "i" когда открыт скелет (но не трогаем "x" на about)
                        const aboutLink = document.getElementById('about-link');
                        if (aboutLink && aboutLink.textContent.trim() === 'i') {
                            aboutLink.style.display = 'none';
                        }
                        
                        // Обновляем текст напрямую (дублирование для надежности)
                        safeUpdateHorseText(SKELETON_TEXT);
                    });
                    
                    // Закрыть скелет
                    skeletonHomeLink.addEventListener('click', () => {
                        // Небольшая задержка для анимации
                        setTimeout(() => {
                            skeletonHome.style.display = 'none';
                            skeletonHomeLink.style.display = 'none';
                            skeletonButton.style.display = 'block';
                            
                            // Показываем кнопку "i" ТОЛЬКО на главной странице
                            const aboutLink = document.getElementById('about-link');
                            if (aboutLink && aboutLink.textContent.trim() === 'i') {
                                aboutLink.style.display = 'block';
                            }
                            
                            // Обновляем текст с небольшой задержкой для надежности
                            setTimeout(() => {
                                safeUpdateHorseText(DEFAULT_TEXT);
                            }, 50);
                        }, 100);
                    });
                    
                    // При нажатии клавиши Escape закрываем скелет
                    document.addEventListener('keydown', (e) => {
                        if (e.key === 'Escape' && skeletonHome.style.display !== 'none') {
                            skeletonHome.style.display = 'none';
                            skeletonHomeLink.style.display = 'none';
                            skeletonButton.style.display = 'block';
                            
                            // Показываем кнопку "i" ТОЛЬКО на главной странице
                            const aboutLink = document.getElementById('about-link');
                            if (aboutLink && aboutLink.textContent.trim() === 'i') {
                                aboutLink.style.display = 'block';
                            }
                            
                            // Обновляем текст с небольшой задержкой для надежности
                            setTimeout(() => {
                                safeUpdateHorseText(DEFAULT_TEXT);
                            }, 50);
                        }
                    });
                }
            };
            
            // Запускаем настройку скелета
            setupSkeletonNav();
        });

        document.addEventListener('DOMContentLoaded', function() {
            var link = document.getElementById('about-link');
            var aboutPagePath = '<?php echo parse_url(get_permalink(get_page_by_path("about")), PHP_URL_PATH); ?>';
            var homePageURL = '<?php echo get_home_url(); ?>'; // Получаем URL главной страницы

            // Если мы на странице "about", меняем "i" на "x"
            if (window.location.pathname === aboutPagePath) {
                link.innerHTML = 'x';

                // Меняем ссылку на главную страницу
                link.href = homePageURL;
                link.setAttribute('data-text', 'i');
            } else {
                link.innerHTML = 'i';
                link.href = '<?php echo get_permalink(get_page_by_path("about")); ?>';
                link.setAttribute('data-text', 'x');
            }
            
            // Функция проверки и скрытия "i" на страницах комнат
            function checkAndHideInfoButton() {
                const link = document.getElementById('about-link');
                const currentPath = window.location.pathname;
                const isRoomPage = /\/0selectedarea\d+/.test(currentPath);
                
                if (link) {
                    if (isRoomPage && link.textContent.trim() === 'i') {
                        link.style.display = 'none';
                        console.log('🚪 Скрыта кнопка "i" на странице комнаты:', currentPath);
                    } else if (!isRoomPage && link.textContent.trim() === 'i') {
                        // Показываем "i" только на главной странице
                        const isHomePage = currentPath === '/' || currentPath === '';
                        if (isHomePage) {
                            link.style.display = 'block';
                            console.log('🏠 Показана кнопка "i" на главной странице');
                        }
                    }
                }
            }
            
            // Проверяем при загрузке
            checkAndHideInfoButton();
            
            // Отслеживаем изменения URL (для динамической навигации)
            // Перехватываем pushState и replaceState
            const originalPushState = history.pushState;
            const originalReplaceState = history.replaceState;
            
            history.pushState = function() {
                originalPushState.apply(this, arguments);
                setTimeout(checkAndHideInfoButton, 100);
            };
            
            history.replaceState = function() {
                originalReplaceState.apply(this, arguments);
                setTimeout(checkAndHideInfoButton, 100);
            };
            
            // Отслеживаем событие popstate (кнопки назад/вперед)
            window.addEventListener('popstate', function() {
                setTimeout(checkAndHideInfoButton, 100);
            });
            
            // Отслеживаем клики по ссылкам на комнаты
            document.addEventListener('click', function(e) {
                const target = e.target.closest('a');
                if (target && target.href) {
                    const href = target.getAttribute('href');
                    if (href && /0selectedarea\d+/.test(href)) {
                        console.log('🔗 Клик по ссылке на комнату:', href);
                        setTimeout(checkAndHideInfoButton, 200);
                    }
                }
            });
            
            // Дополнительно: периодическая проверка URL (на случай если другие методы не сработали)
            let lastCheckedPath = window.location.pathname;
            setInterval(function() {
                const currentPath = window.location.pathname;
                if (currentPath !== lastCheckedPath) {
                    console.log('🔄 Обнаружено изменение URL:', lastCheckedPath, '→', currentPath);
                    lastCheckedPath = currentPath;
                    checkAndHideInfoButton();
                }
            }, 500);
        });
        
    </script>
<div id="wrapper" class="hfeed x-ray-wrapper">
<div id="container">
