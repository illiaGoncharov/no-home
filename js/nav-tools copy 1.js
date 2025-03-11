/////////////// ГРОМКОСТЬ


document.addEventListener('DOMContentLoaded', function() {
    const drops = document.querySelectorAll('.volume-control .drop');

    const emptyDropSrc = 'https://nohome.cloud/wp-content/themes/blankslate/files/nav/empty%20drop.svg';
    const fullDropSrc = 'https://nohome.cloud/wp-content/themes/blankslate/files/nav/drop.svg';

    function getSavedVolume() {
        return parseInt(localStorage.getItem('websiteVolume')) || 6;
    }

    function saveVolume(volume) {
        localStorage.setItem('websiteVolume', volume);
    }

    function applyVolumeToAudio(volume) {
        const normalizedVolume = volume / 8;

        document.querySelectorAll('audio').forEach(audio => {
            audio.volume = normalizedVolume;
        });

        if (window.audioContext && window.audioContext.gainNode) {
            window.audioContext.gainNode.gain.setValueAtTime(normalizedVolume, audioContext.currentTime);
        }

        if (window.scene) {
            window.scene.traverse(function(node) {
                if (node.isAudio) {
                    node.setVolume(normalizedVolume);
                }
            });
        }
    }

    drops.forEach(drop => {
        drop.addEventListener('click', function(event) {
            event.preventDefault();
            const volume = parseInt(drop.getAttribute('data-volume'));
            setVolume(volume);
        });
    });

    function setVolume(volume) {
        drops.forEach((drop, index) => {
            if (index < volume) {
                drop.querySelector('img').src = fullDropSrc;
            } else {
                drop.querySelector('img').src = emptyDropSrc;
            }
        });
        saveVolume(volume);
        applyVolumeToAudio(volume);
    }

    setVolume(getSavedVolume());
});


/////////////// БЕГУЩАЯ СТРОКА


document.addEventListener('DOMContentLoaded', function() {
    const textElement = document.querySelector('.horse-indicator-text');
    const wrapperElement = document.querySelector('.horse-indicator-text-wrapper');

    function checkOverflow() {
        const isOverflowing = textElement.scrollWidth > wrapperElement.clientWidth;
        if (isOverflowing) {
            textElement.classList.add('marquee');
            textElement.classList.remove('no-marquee');
        } else {
            textElement.classList.remove('marquee');
            textElement.classList.add('no-marquee');
        }
    }

    // Проверить переполнение при загрузке и при изменении размера окна
    checkOverflow();
    window.addEventListener('resize', checkOverflow);


/////////////// ПЕРЕВОДЧИК


    const translateButton = document.getElementById('translate-button');
    const translateDiv = document.querySelector('.trnsltr');
    
    // Функция для переключения видимости элемента
    function toggleTranslateDiv() {
        if (translateDiv.style.display === 'none' || translateDiv.style.display === '') {
            translateDiv.style.display = 'block';
        } else {
            translateDiv.style.display = 'none';
        }
    }
    
    // Событие клика по кнопке перевода
    translateButton.addEventListener('click', function(event) {
        event.preventDefault();
        toggleTranslateDiv();
    });


/////////////// X-RAY


    const xrayButton = document.getElementById('xray-button');
    const mainElement = document.querySelector('main');
    
    function toggleXray() {
        mainElement.classList.toggle('xray-active');
        xrayButton.classList.toggle('active');
        localStorage.setItem('xrayState', mainElement.classList.contains('xray-active') ? 'active' : 'inactive');
    }

    // Проверяем сохраненное состояние при загрузке страницы
    if (localStorage.getItem('xrayState') === 'active') {
        toggleXray();
    }

    xrayButton.addEventListener('click', toggleXray);
});