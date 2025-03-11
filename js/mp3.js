// Глобальные переменные
let currentSide = 1;
let currentTrack = null;
let isPlaying = false;
let isRandom = false;
let originalOrder = [];
let repeatSong = false;
let isFirstPlay = true;

// Функция для рандомного перемешивания
function shufflePlaylist() {
    const tracks = Array.from(document.querySelectorAll(`audio[data-side="${currentSide}"]`));
    if (!isRandom) {
        originalOrder = tracks.map(track => track.dataset.order);
        tracks.forEach(track => track.dataset.order = Math.floor(Math.random() * tracks.length) + 1);
        document.querySelector('.random').style.opacity = '100%';
        document.querySelector('.random').style.textShadow = '0 0 9px #b0b0b0';
    } else {
        tracks.forEach((track, index) => track.dataset.order = originalOrder[index]);
        document.querySelector('.random').style.opacity = '50%';
        document.querySelector('.random').style.textShadow = 'none';
    }
    isRandom = !isRandom;
    updatePlaylistDisplay();
}

document.querySelector('.random').addEventListener('click', shufflePlaylist);

function toggleRepeatSong() {
    repeatSong = !repeatSong;
    if (currentTrack) currentTrack.loop = repeatSong;
    document.querySelector('.repeat-song').style.opacity = repeatSong ? '100%' : '50%';
    document.querySelector('.repeat-song').style.textShadow = repeatSong ? '0 0 9px #b0b0b0' : 'none';
}

document.querySelector('.repeat-song').addEventListener('click', toggleRepeatSong);

// Функция для переключения между сторонами
function toggleSide() {
    const spinningWrapper = document.querySelector('.spinning-sides-wrapper');
    const diskWrapper = document.querySelector('.disk-wrapper');
    const timeChangerWrapper = document.querySelector('.time-changer');
    const progressCircl = document.querySelector('.pc-wrapper');
    const side1Elements = document.querySelectorAll('.song-next.side-1, .now-playing-wrapper.side-1, .now-playing-hashtag.side-1');
    const side2Elements = document.querySelectorAll('.song-next.side-2, .now-playing-wrapper.side-2, .now-playing-hashtag.side-2');
    const invertedElements = document.querySelectorAll('.mp3-wrapper, .disk-wrapper');

    currentSide = currentSide === 1 ? 2 : 1;

    const rotation = currentSide === 2 ? 180 : 0;
    spinningWrapper.style.transform = `rotateY(${rotation}deg)`;
    diskWrapper.style.transform = `rotateY(-${rotation}deg)`;
    timeChangerWrapper.style.transform = `rotateY(-${rotation}deg)`;
    progressCircl.style.transform = `rotateY(-${rotation}deg)`;

    side1Elements.forEach(el => el.style.filter = currentSide === 1 ? 'blur(0px)' : 'blur(3px)');
    side2Elements.forEach(el => el.style.filter = currentSide === 2 ? 'blur(0px)' : 'blur(3px)');
    invertedElements.forEach(el => el.style.filter = currentSide === 2 ? 'invert(1)' : 'invert(0)');

    [spinningWrapper, diskWrapper, timeChangerWrapper, progressCircl].forEach(el => {
        el.style.transition = 'transform 2s';
    });

    updatePlaylistDisplay();
}

function updatePlaylistDisplay(isTrackChange = false) {
    const tracks = Array.from(document.querySelectorAll(`audio[data-side="${currentSide}"]`))
        .sort((a, b) => parseInt(a.dataset.order) - parseInt(b.dataset.order));
    let startIndex = currentTrack ? parseInt(currentTrack.dataset.order) % 5 : 5;

    // Применяем анимацию блюра только при смене трека
    if (isTrackChange) {
        const elementsToUpdate = document.querySelectorAll(`.song-next-title.side-${currentSide}, .song-next-time.side-${currentSide}, .now-playing-wrapper.side-${currentSide}, .now-playing-hashtag.side-${currentSide}, .song-next.side-${currentSide}`);
        elementsToUpdate.forEach(el => {
            el.classList.add('transition-blur');
            el.classList.add('blurred');
        });
    }

    setTimeout(() => {
        for (let i = 0; i < 4; i++) {
            const trackIndex = (startIndex + i) % 5;
            const track = tracks[trackIndex];
            const nextTitle = document.querySelector(`.song-${i+1}-next-title.side-${currentSide}`);
            const nextTime = document.querySelector(`.song-${i+1}-next-time.side-${currentSide}`);
            
            if (track) {
                nextTitle.textContent = track.dataset.songName;
                nextTime.textContent = formatTime(track.duration);
                nextTitle.dataset.order = track.dataset.order;
                nextTime.dataset.order = track.dataset.order;
            } else {
                nextTitle.textContent = '?????????';
                nextTime.textContent = '00:00';
                nextTitle.dataset.order = '';
                nextTime.dataset.order = '';
            }
        }

        const playingTitle = document.querySelector(`.song-playing-title.side-${currentSide}`);
        const playingTime = document.querySelector(`.song-playing-time.side-${currentSide}`);
        const nowPlayingTitle = document.querySelector(`.now-playing-title.side-${currentSide}`);
        const nowPlayingTime = document.querySelector(`.now-playing-time.side-${currentSide}`);
        const nowPlayingHashtag = document.querySelector(`.now-playing-hashtag.side-${currentSide}`);

        if (currentTrack && currentTrack.dataset.side == currentSide) {
            playingTitle.textContent = currentTrack.dataset.songName;
            playingTime.textContent = formatTime(currentTrack.duration - currentTrack.currentTime);
            nowPlayingTitle.textContent = currentTrack.dataset.songName;
            nowPlayingTime.textContent = formatTime(currentTrack.duration - currentTrack.currentTime);
            nowPlayingHashtag.textContent = currentTrack.dataset.songHashtag;
            document.querySelector(`.song-playing.side-${currentSide}`).style.filter = 'blur(1px)';
        } else {
            const lastTrack = tracks[4];
            playingTitle.textContent = lastTrack.dataset.songName;
            playingTime.textContent = formatTime(lastTrack.duration);
            nowPlayingTitle.textContent = '?????????';
            nowPlayingTime.textContent = '00:00';
            nowPlayingHashtag.textContent = '#TAGTAGTAG';
            document.querySelector(`.song-playing.side-${currentSide}`).style.filter = 'none';
        }

        // Убираем блюр только если была смена трека
        if (isTrackChange) {
            setTimeout(() => {
                const elementsToUpdate = document.querySelectorAll(`.song-next-title.side-${currentSide}, .song-next-time.side-${currentSide}, .now-playing-wrapper.side-${currentSide}, .now-playing-hashtag.side-${currentSide}, .song-next.side-${currentSide}`);
                elementsToUpdate.forEach(el => {
                    el.classList.remove('blurred');
                });

                // Удаляем класс transition-blur после завершения анимации
                setTimeout(() => {
                    elementsToUpdate.forEach(el => {
                        el.classList.remove('transition-blur');
                    });
                }, 500);
            }, 50); // Небольшая задержка перед началом обратной анимации
        }
        
        updateBackgroundImage();
    }, isTrackChange ? 500 : 0);  // Задержка 500 мс для полного эффекта блюра
}

let currentBackgroundSrc = '';

function updateBackgroundImage() {
    const mp3Player = document.querySelector('.mp3-wrapper');
    let backgroundImg = mp3Player.querySelector('.mp3-background-img');
    
    if (currentTrack) {
        const newSrc = currentTrack.dataset.mp3BackgroundImg;
        
        if (newSrc !== currentBackgroundSrc) {
            currentBackgroundSrc = newSrc;
            
            if (!backgroundImg) {
                const backgroundContainer = mp3Player.querySelector('.mp3-background');
                backgroundImg = document.createElement('img');
                backgroundImg.className = 'mp3-background-img';
                backgroundImg.alt = 'Background';
                backgroundContainer.appendChild(backgroundImg);
            }
            
            const tempImg = new Image();
            tempImg.onload = () => {
                backgroundImg.style.animation = 'fadeOut 750ms ease-in-out';
                
                setTimeout(() => {
                    backgroundImg.src = newSrc;
                    backgroundImg.style.opacity = '0';
                    
                    setTimeout(() => {
                        backgroundImg.style.animation = 'fadeIn 750ms ease-in-out';
                        backgroundImg.style.opacity = '1';
                    }, 300);
                }, 750);
            };
            
            tempImg.src = newSrc;
        }
    } else if (backgroundImg) {
        backgroundImg.style.animation = 'fadeOut 750ms ease-in-out';
        setTimeout(() => {
            backgroundImg.src = '';
            backgroundImg.style.opacity = '0';
            currentBackgroundSrc = '';
        }, 750);
    }
}

function formatTime(time) {
    if (isNaN(time)) return '00:00';
    const minutes = Math.floor(time / 60);
    const seconds = Math.floor(time % 60);
    return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
}

function toggleAnimations(play) {
    const cd = document.querySelector('.cd');
    const ice = document.querySelector('.ice');
    const diskWrapper = document.querySelector('.disk-wrapper');
    const spinningWrapper = document.querySelector('.spinning-sides-wrapper');
    
    if (play) {
        if (isFirstPlay) {
            diskWrapper.style.animation = 'none';
            spinningWrapper.style.animation = 'none';
            isFirstPlay = false;
        }
        cd.style.animation = 'rotate-cd 60s linear infinite';
        ice.style.animation = 'rotate-ice 15s linear infinite';
    } else {
        cd.style.animation = 'none';
        ice.style.animation = 'none';
    }
}

function togglePlayStop() {
    const playStopButton = document.querySelector('.play-stop');
    
    if (!currentTrack) {
        currentTrack = document.querySelector(`audio[data-side="${currentSide}"][data-order="1"]`);
    }

    if (isPlaying) {
        currentTrack.pause();
        playStopButton.textContent = 'play';
        toggleAnimations(false);
    } else {
        currentTrack.play();
        playStopButton.textContent = 'stop';
        toggleAnimations(true);
    }

    isPlaying = !isPlaying;
    updatePlaylistDisplay();
    updateTimeChanger();
}

let isHovering = false;

function updateTimeChanger() {
    const timeChanger = document.querySelector('.time-changer');
    const progressCircle = document.querySelector('.progress-circle');
    
    if (currentTrack && isPlaying) {
        const progress = (currentTrack.currentTime / currentTrack.duration) * 100;
        const angle = (progress / 100) * 2 * Math.PI;
        
        timeChanger.style.background = `conic-gradient(rgb(212, 35, 24) ${progress}%, rgba(255,255,255,0.3) ${progress}%)`;
        
        const radius = (timeChanger.offsetWidth / 2) - 3;
        const x = Math.sin(angle) * radius;
        const y = -Math.cos(angle) * radius;
        progressCircle.style.transform = `translate(calc(-50% + ${x}px), calc(-50% + ${y}px))`;
        
        progressCircle.style.opacity = isHovering ? '1' : '0';
    } else {
        timeChanger.style.background = 'none';
        progressCircle.style.opacity = '0';
    }
}

function seekTrack(event) {
    if (currentTrack && isPlaying) {
        const timeChanger = document.querySelector('.time-changer');
        const rect = timeChanger.getBoundingClientRect();
        const center = { x: rect.left + rect.width / 2, y: rect.top + rect.height / 2 };

        let angle = Math.atan2(event.clientY - center.y, event.clientX - center.x);
        angle += Math.PI / 2;
        angle = angle % (2 * Math.PI);
        if (angle < 0) {
            angle += 2 * Math.PI;
        }

        const progress = angle / (2 * Math.PI);
        currentTrack.currentTime = progress * currentTrack.duration;
        updateTimeChanger();
    }
}

function playNextTrack() {
    if (currentTrack) {
        const nextOrder = (parseInt(currentTrack.dataset.order) % 5) + 1;
        const nextTrack = document.querySelector(`audio[data-side="${currentSide}"][data-order="${nextOrder}"]`);
        
        if (nextTrack) {
            currentTrack.pause();
            currentTrack.currentTime = 0;
            currentTrack = nextTrack;
            currentTrack.play();
            isPlaying = true;
            document.querySelector('.play-stop').textContent = 'stop';
            updatePlaylistDisplay(true);  // Передаем флаг, указывающий на смену трека
            checkOverflow();  // Проверяем переполнение текста после смены трека
        }
    }
}

function playPreviousTrack() {
    if (currentTrack) {
        const prevOrder = ((parseInt(currentTrack.dataset.order) - 2 + 5) % 5) + 1;
        const prevTrack = document.querySelector(`audio[data-side="${currentSide}"][data-order="${prevOrder}"]`);
        
        if (prevTrack) {
            currentTrack.pause();
            currentTrack.currentTime = 0;
            currentTrack = prevTrack;
            currentTrack.play();
            isPlaying = true;
            document.querySelector('.play-stop').textContent = 'stop';
            updatePlaylistDisplay(true);  // Передаем флаг, указывающий на смену трека
            checkOverflow();  // Проверяем переполнение текста после смены трека
        }
    }
}

document.querySelector('.time-changer').addEventListener('mouseenter', () => {
    isHovering = true;
    updateTimeChanger();
});

document.querySelector('.time-changer').addEventListener('mouseleave', () => {
    isHovering = false;
    updateTimeChanger();
});

document.querySelector('.time-changer').addEventListener('mousedown', (e) => {
    seekTrack(e);
    document.addEventListener('mousemove', seekTrack);
});

document.addEventListener('mouseup', () => {
    document.removeEventListener('mousemove', seekTrack);
});

function playTrack(order) {
    const track = document.querySelector(`audio[data-side="${currentSide}"][data-order="${order}"]`);
    if (track) {
        if (currentTrack) {
            currentTrack.pause();
            currentTrack.currentTime = 0;
        }
        currentTrack = track;
        currentTrack.play();
        isPlaying = true;
        document.querySelector('.play-stop').textContent = 'stop';
        toggleAnimations(true);
        updatePlaylistDisplay(true);  // Передаем флаг, указывающий на смену трека
        updateTimeChanger();
        checkOverflow();  // Проверяем переполнение текста после смены трека
    }
}

document.querySelector('.block-side-1').addEventListener('click', () => {
    if (currentSide === 2) toggleSide();
});

document.querySelector('.block-side-2').addEventListener('click', () => {
    if (currentSide === 1) toggleSide();
});

document.querySelector('.play-stop').addEventListener('click', togglePlayStop);
document.querySelector('.previous-song').addEventListener('click', playPreviousTrack);
document.querySelector('.next-song').addEventListener('click', playNextTrack);

// Обработчики для клика на элементы плейлиста
for (let i = 1; i <= 4; i++) {
    ['side-1', 'side-2'].forEach(side => {
        document.querySelector(`.song-${i}-next-title.${side}`).addEventListener('click', function() {
            playTrack(this.dataset.order);
        });
        document.querySelector(`.song-${i}-next-time.${side}`).addEventListener('click', function() {
            playTrack(this.dataset.order);
        });
    });
}

// Обновляем обработчик окончания трека
document.querySelectorAll('audio').forEach(audio => {
    audio.addEventListener('ended', () => {
        if (!repeatSong) {
            playNextTrack();
        } else {
            audio.play();
        }
        toggleAnimations(true);
        checkOverflow();  // Проверяем переполнение текста после окончания трека
    });
    audio.addEventListener('timeupdate', () => {
        updatePlaylistDisplay();
        updateTimeChanger();
    });
    audio.addEventListener('loadedmetadata', () => {
        updatePlaylistDisplay();
        checkOverflow();  // Проверяем переполнение текста после загрузки метаданных
    });
});

// Добавляем стили для анимаций
const style = document.createElement('style');
style.textContent = `
    @keyframes rotate-cd {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    @keyframes rotate-ice {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
`;
document.head.appendChild(style);

// Функция для проверки переполнения текста
function checkOverflow() {
    const containers = document.querySelectorAll('.marquee-container');
    
    containers.forEach(container => {
        const content = container.querySelector('.marquee-content');
        
        if (content.scrollWidth > container.clientWidth) {
            content.classList.add('marquee-animate');
        } else {
            content.classList.remove('marquee-animate');
        }
    });
}

// Инициализация
document.addEventListener('DOMContentLoaded', () => {
    updatePlaylistDisplay();
    updateTimeChanger();
    checkOverflow();
});

// Проверяем при изменении размера окна
window.addEventListener('resize', checkOverflow);
setInterval(checkOverflow, 5000);