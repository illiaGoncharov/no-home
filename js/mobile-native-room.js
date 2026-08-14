/**
 * NOHOME — движок нативных мобильных комнат (без iframe).
 *
 * Общий/generic: уровни и тап-зоны читает из data-nh-* в разметке.
 * table-zoom: карусель из 3 экранов через тёмный фейд.
 * cave: панорама со свайпом + детальные уровни (стена / рация / just-cave).
 */
(function () {
    'use strict';

    var FADE_MS = 160;
    var SWIPE_MIN = 40;
    var animating = false;
    var touchStartX = 0;
    var touchStartY = 0;
    var carouselIdx = 1; // зафиксированный кадр карусели (0/1/2)
    var caveSavedScroll = null; // панорама пещеры: куда вернуться после зума
    var caveWallSavedScroll = null; // панорама стены: после зума колонки/рации
    var bedroomSavedScroll = null; // спальня: позиция 3-кадрового трека
    var caveClassikiTimer = null;
    var caveClassikiIdx = 0;
    var caveFlyTimer = null;

    function onReady( fn ) {
        if ( document.readyState !== 'loading' ) fn();
        else document.addEventListener( 'DOMContentLoaded', fn );
    }

    function isTableZoom() {
        var mHome = document.getElementById( 'mHome' );
        return mHome && mHome.classList.contains( 'is-table-zoom' );
    }

    function isCameraZoom() {
        var mHome = document.getElementById( 'mHome' );
        return mHome && mHome.classList.contains( 'is-camera-zoom' );
    }

    function isCaveDetail() {
        var mHome = document.getElementById( 'mHome' );
        return mHome && mHome.classList.contains( 'is-cave-detail' );
    }

    function getFade() {
        return document.querySelector( '.m-level[data-level="table-zoom"] .m-zoom-fade' );
    }

    function lockScrollToIdx( idx ) {
        var scroll = document.getElementById( 'mRoomsScroll' );
        if ( ! scroll ) return;
        carouselIdx = idx;
        scroll.scrollLeft = idx * scroll.offsetWidth;
    }

    function setAudio( id, on, volume ) {
        var a = document.getElementById( id );
        if ( ! a ) return;
        if ( on ) {
            a.volume = typeof volume === 'number' ? volume : 0.6;
            var p = a.play();
            if ( p && typeof p.catch === 'function' ) p.catch( function () {} );
        } else {
            a.pause();
            a.currentTime = 0;
        }
    }

    // Классики на полу — как на десктопе (цикл opacity), на мобайле крутим
    // пока открыт main (hover нет).
    function stopCaveClassiki( room ) {
        if ( caveClassikiTimer ) {
            clearInterval( caveClassikiTimer );
            caveClassikiTimer = null;
        }
        if ( ! room ) return;
        var pano = room.querySelector( '.m-cave-pano' );
        var frames = room.querySelectorAll( '.m-cave-classiki' );
        if ( pano ) pano.classList.remove( 'is-classiki-on' );
        for ( var i = 0; i < frames.length; i++ ) {
            frames[ i ].style.opacity = '0';
        }
        caveClassikiIdx = 0;
    }

    function startCaveClassiki( room ) {
        stopCaveClassiki( room );
        if ( ! room ) return;
        var pano = room.querySelector( '.m-cave-pano' );
        var frames = room.querySelectorAll( '.m-cave-classiki' );
        if ( ! pano || ! frames.length ) return;

        pano.classList.add( 'is-classiki-on' );
        caveClassikiIdx = 0;
        frames[ 0 ].style.opacity = '1';

        caveClassikiTimer = setInterval( function () {
            frames[ caveClassikiIdx ].style.opacity = '0';
            caveClassikiIdx = ( caveClassikiIdx + 1 ) % frames.length;
            frames[ caveClassikiIdx ].style.opacity = '1';
        }, 300 );
    }

    function stopCaveFly() {
        if ( caveFlyTimer ) {
            clearTimeout( caveFlyTimer );
            caveFlyTimer = null;
        }
    }

    function startCaveFly( room ) {
        stopCaveFly();
        if ( ! room ) return;
        var fly = room.querySelector( '.m-cave-fly' );
        if ( ! fly ) return;

        function move() {
            var w = window.innerWidth;
            var h = window.innerHeight;
            var x = Math.random() * Math.max( 0, w - 42 );
            var y = Math.random() * Math.max( 0, h - 42 );
            var rot = Math.random() * 360;
            fly.style.transform = 'rotate(' + rot + 'deg)';
            fly.style.left = x + 'px';
            fly.style.top = y + 'px';
            caveFlyTimer = setTimeout( move, Math.random() * 3000 + 1000 );
        }

        move();
    }

    // Карусель: фейд → мгновенная смена кадра → фейд назад
    function carouselGo( idx ) {
        if ( animating || ! isTableZoom() ) return;
        if ( idx < 0 || idx > 2 ) return;
        if ( idx === carouselIdx ) return;

        var scroll = document.getElementById( 'mRoomsScroll' );
        var fade = getFade();
        if ( ! scroll ) return;

        animating = true;

        if ( fade ) {
            fade.style.transition = 'opacity ' + FADE_MS + 'ms ease';
            fade.style.opacity = '0.55';
        }

        setTimeout( function () {
            lockScrollToIdx( idx );
            if ( fade ) fade.style.opacity = '0';

            window.dispatchEvent( new CustomEvent( 'nh-carousel-idx', { detail: { idx: idx } } ) );

            setTimeout( function () {
                if ( fade ) fade.style.transition = '';
                animating = false;
            }, FADE_MS + 20 );
        }, FADE_MS );
    }

    /**
     * @param {Element} room
     * @param {string} levelId
     * @param {{ idx?: number }} [opts] — кадр панорамы / карусели
     */
    function goToLevel( room, levelId, opts ) {
        opts = opts || {};

        var prevLevel = room.querySelector( '.m-level.is-active' );
        var prevId = prevLevel ? prevLevel.getAttribute( 'data-level' ) : '';
        // Уходя со стены в зум — запомнить горизонтальный скролл
        if ( prevId === 'items-wall' && levelId !== 'items-wall' ) {
            var wallLeaving = document.getElementById( 'mCaveWallScroll' );
            if ( wallLeaving ) caveWallSavedScroll = wallLeaving.scrollLeft;
        }
        if ( levelId === 'main' ) caveWallSavedScroll = null;

        var levels = room.querySelectorAll( '.m-level' );
        for ( var i = 0; i < levels.length; i++ ) {
            var isTarget = levels[ i ].getAttribute( 'data-level' ) === levelId;
            levels[ i ].classList.toggle( 'is-active', isTarget );
            if ( ! isTarget ) {
                levels[ i ].classList.remove( 'is-helmet-on', 'is-flash-on', 'is-open' );
            }
        }

        var isCave = room.getAttribute( 'data-room' ) === 'cave';
        var isBedroom = room.getAttribute( 'data-room' ) === 'bedroom';
        var mHome = document.getElementById( 'mHome' );
        if ( mHome ) {
            mHome.classList.toggle( 'is-table-zoom', levelId === 'table-zoom' );
            mHome.classList.toggle( 'is-camera-zoom', levelId === 'camera-zoom' );
            mHome.classList.toggle( 'is-cave-detail', isCave && levelId !== 'main' );
            mHome.classList.toggle( 'is-cave-wall', isCave && levelId === 'items-wall' );
            mHome.classList.toggle( 'is-bedroom-detail', isBedroom && levelId !== 'main' );
            mHome.classList.toggle( 'is-native-zoom', levelId !== 'main' );
        }

        // Амбиент пещеры — только внутри just-cave; классики — на main
        if ( isCave ) {
            setAudio( 'mCaveSound', levelId === 'just-cave', 0.55 );
            if ( levelId !== 'walkie-zoom' ) {
                setAudio( 'mCaveWalkieSound', false );
            }
            if ( levelId === 'main' ) startCaveClassiki( room );
            else stopCaveClassiki( room );

            if ( levelId === 'just-cave' ) startCaveFly( room );
            else stopCaveFly();

            // Стена: старт — JBL слева + каска в кадре; вправо — рация и остальное.
            // 0 = пустая штукатурка слева; ~0.42 max ≈ JBL/каска, вправо — рация.
            if ( levelId === 'items-wall' ) {
                function placeWallStart() {
                    var wallScroll = document.getElementById( 'mCaveWallScroll' );
                    if ( ! wallScroll ) return;
                    var max = Math.max( 0, wallScroll.scrollWidth - wallScroll.offsetWidth );
                    if ( ! max ) return;
                    if ( caveWallSavedScroll !== null ) {
                        wallScroll.scrollLeft = Math.min( max, caveWallSavedScroll );
                    } else {
                        wallScroll.scrollLeft = max * 0.42;
                    }
                    window.dispatchEvent( new CustomEvent( 'nh-cave-wall-scroll' ) );
                }
                requestAnimationFrame( function () {
                    placeWallStart();
                    setTimeout( placeWallStart, 120 );
                } );
            }
        }

        var scroll = room.closest( '#mRoomsScroll' ) || document.getElementById( 'mRoomsScroll' );

        // Пещера: зумы — fixed-оверлей, скролл панорамы сохраняем/восстанавливаем
        if ( isCave && scroll ) {
            if ( levelId !== 'main' ) {
                if ( caveSavedScroll === null ) caveSavedScroll = scroll.scrollLeft;
            } else {
                if ( caveSavedScroll !== null ) {
                    scroll.scrollLeft = caveSavedScroll;
                    caveSavedScroll = null;
                }
                animating = false;
                var fadeCave = getFade();
                if ( fadeCave ) {
                    fadeCave.style.transition = '';
                    fadeCave.style.opacity = '0';
                }
                window.dispatchEvent( new CustomEvent( 'nh-carousel-idx', { detail: { idx: 1 } } ) );
                return;
            }
        }

        // Спальня: зумы fixed; скролл 3-кадрового трека не трогаем до Back
        if ( isBedroom && scroll ) {
            if ( levelId !== 'main' ) {
                if ( bedroomSavedScroll === null ) bedroomSavedScroll = scroll.scrollLeft;
                animating = false;
                return;
            }
            if ( bedroomSavedScroll !== null ) {
                scroll.scrollLeft = bedroomSavedScroll;
                bedroomSavedScroll = null;
            }
            animating = false;
            window.dispatchEvent( new CustomEvent( 'nh-carousel-idx', { detail: { idx: 0 } } ) );
            return;
        }

        // Детали стола / карусель — центр или opts.idx
        var idx = ( typeof opts.idx === 'number' ) ? opts.idx : 1;
        if ( scroll ) {
            lockScrollToIdx( idx );
        }

        var fade = getFade();
        if ( fade ) {
            fade.style.transition = '';
            fade.style.opacity = '0';
        }
        animating = false;

        window.dispatchEvent( new CustomEvent( 'nh-carousel-idx', { detail: { idx: idx } } ) );
    }

    function cycleFrame( room, imgId ) {
        var img = room.querySelector( '#' + imgId );
        if ( ! img ) return;

        var frames;
        try {
            frames = JSON.parse( img.getAttribute( 'data-nh-frames' ) || '[]' );
        } catch ( e ) {
            frames = [];
        }
        if ( ! frames.length ) return;

        var idx = parseInt( img.getAttribute( 'data-nh-frame-index' ) || '0', 10 );
        idx = ( idx + 1 ) % frames.length;

        img.setAttribute( 'data-nh-frame-index', String( idx ) );
        img.setAttribute( 'src', frames[ idx ] );
    }

    function openItem( target ) {
        if ( typeof window.nhOpenMobileItem === 'function' ) {
            window.nhOpenMobileItem( target );
        } else {
            console.warn( '[native-room] nhOpenMobileItem недоступен' );
        }
    }

    function handleAction( room, action ) {
        if ( action === 'iphone-on-zoomed-table' ) {
            openItem( 'iphone' );
            return;
        }

        if ( action === 'camera-in-table-room' ) {
            goToLevel( room, 'camera-zoom' );
            return;
        }

        if ( action === 'open-items-camera' ) {
            openItem( 'camera' );
            return;
        }

        // --- спальня ---
        if ( action === 'open-backpack' ) {
            setAudio( 'mBedBackpackSound', true, 0.7 );
            openItem( 'backpack' );
            return;
        }

        if ( action === 'open-luggage' ) {
            setAudio( 'mBedSuitcaseSound', true, 0.7 );
            openItem( 'luggage' );
            return;
        }

        // --- пещера ---
        if ( action === 'cave-jbl' ) {
            goToLevel( room, 'speaker-zoom' );
            return;
        }

        if ( action === 'cave-speaker-mp3' ) {
            openItem( 'mp3' );
            return;
        }

        if ( action === 'cave-walkie' ) {
            goToLevel( room, 'walkie-zoom' );
            return;
        }

        if ( action === 'cave-walkie-play' ) {
            setAudio( 'mCaveWalkieSound', true, 0.8 );
            return;
        }

        if ( action === 'cave-helmet' ) {
            var wall = room.querySelector( '.m-level[data-level="items-wall"]' );
            if ( wall ) wall.classList.toggle( 'is-helmet-on' );
            return;
        }

        if ( action === 'cave-flashlight' ) {
            var wallF = room.querySelector( '.m-level[data-level="items-wall"]' );
            if ( wallF ) wallF.classList.toggle( 'is-flash-on' );
            return;
        }

        if ( action === 'cave-mirror' ) {
            // Как на десктопе — текст «reflection not renderable»; без отдельного зума
            console.log( '[native-room] cave mirror' );
            return;
        }

        console.log( '[native-room] stub action:', action );
    }

    function handleTap( e ) {
        var zone = e.target.closest( '.m-tap-zone' );
        if ( ! zone ) return;

        var room = zone.closest( '.m-native-room' );
        if ( ! room ) return;

        var gotoLevel = zone.getAttribute( 'data-nh-goto' );
        var backLevel = zone.getAttribute( 'data-nh-back' );
        var toggle    = zone.getAttribute( 'data-nh-toggle' );
        var cycle     = zone.getAttribute( 'data-nh-cycle' );
        var action    = zone.getAttribute( 'data-nh-action' );

        if ( gotoLevel ) {
            goToLevel( room, gotoLevel );
        } else if ( backLevel ) {
            var backIdx = parseInt( zone.getAttribute( 'data-nh-back-idx' ) || '', 10 );
            var opts = {};
            if ( ! isNaN( backIdx ) ) opts.idx = backIdx;
            goToLevel( room, backLevel, opts );
        } else if ( toggle ) {
            var level = zone.closest( '.m-level' );
            if ( level ) level.classList.toggle( 'is-open' );
        } else if ( cycle ) {
            cycleFrame( room, cycle );
        } else if ( action ) {
            handleAction( room, action );
        }
    }

    function initCarousel() {
        var scroll = document.getElementById( 'mRoomsScroll' );
        if ( ! scroll ) return;

        scroll.addEventListener( 'touchstart', function ( e ) {
            if ( ! isTableZoom() || ! e.touches.length ) return;
            touchStartX = e.touches[ 0 ].clientX;
            touchStartY = e.touches[ 0 ].clientY;
        }, { passive: true } );

        scroll.addEventListener( 'touchend', function ( e ) {
            if ( ! isTableZoom() || animating || ! e.changedTouches.length ) return;
            var dx = e.changedTouches[ 0 ].clientX - touchStartX;
            var dy = e.changedTouches[ 0 ].clientY - touchStartY;
            if ( Math.abs( dx ) < SWIPE_MIN || Math.abs( dx ) < Math.abs( dy ) ) return;
            carouselGo( carouselIdx + ( dx < 0 ? 1 : -1 ) );
        }, { passive: true } );

        scroll.addEventListener( 'wheel', function ( e ) {
            if ( ! isTableZoom() || animating ) return;
            if ( Math.abs( e.deltaX ) < 20 && Math.abs( e.deltaY ) < 20 ) return;
            var delta = Math.abs( e.deltaX ) > Math.abs( e.deltaY ) ? e.deltaX : ( e.shiftKey ? e.deltaY : 0 );
            if ( ! delta ) return;
            e.preventDefault();
            carouselGo( carouselIdx + ( delta > 0 ? 1 : -1 ) );
        }, { passive: false } );

        scroll.addEventListener( 'scroll', function () {
            // table-zoom / camera-zoom — кадр зафиксирован
            // (cave-detail: overflow:hidden + fixed-оверлей, scrollLeft не трогаем)
            if ( ( ! isTableZoom() && ! isCameraZoom() ) || animating ) return;
            var target = carouselIdx * scroll.offsetWidth;
            if ( Math.abs( scroll.scrollLeft - target ) > 1 ) {
                scroll.scrollLeft = target;
            }
        }, { passive: true } );

        var arrowLeft  = document.getElementById( 'mArrowLeft' );
        var arrowRight = document.getElementById( 'mArrowRight' );

        function onArrow( dir, e ) {
            if ( ! isTableZoom() ) return;
            e.preventDefault();
            e.stopImmediatePropagation();
            carouselGo( carouselIdx + dir );
        }

        if ( arrowLeft )  arrowLeft.addEventListener( 'click',  function ( e ) { onArrow( -1, e ); }, true );
        if ( arrowRight ) arrowRight.addEventListener( 'click', function ( e ) { onArrow(  1, e ); }, true );

        window.addEventListener( 'nh-zoom-carousel', function ( e ) {
            if ( e.detail && typeof e.detail.idx === 'number' ) {
                carouselGo( e.detail.idx );
            }
        } );
    }

    onReady( function () {
        var rooms = document.querySelectorAll( '.m-native-room' );
        rooms.forEach( function ( room ) {
            room.addEventListener( 'click', handleTap );
            // Пещера: сразу крутим классики на main
            if ( room.getAttribute( 'data-room' ) === 'cave' ) {
                startCaveClassiki( room );
            }
        } );

        var backButtons = document.querySelectorAll( '.m-native-room .m-level-back' );
        backButtons.forEach( function ( btn ) {
            btn.classList.add( 'm-tap-zone' );
        } );

        window.nhNativeRoomBack = function () {
            var activeBack = document.querySelector( '.m-native-room .m-level.is-active .m-level-back' );
            if ( activeBack ) activeBack.click();
        };

        initCarousel();

        // Стена пещеры: свайп пальцем → обновляем dim стрелок
        var wallScrollEl = document.getElementById( 'mCaveWallScroll' );
        if ( wallScrollEl ) {
            var wallTimer;
            wallScrollEl.addEventListener( 'scroll', function () {
                clearTimeout( wallTimer );
                wallTimer = setTimeout( function () {
                    window.dispatchEvent( new CustomEvent( 'nh-cave-wall-scroll' ) );
                }, 60 );
            }, { passive: true } );
        }
    } );
})();
