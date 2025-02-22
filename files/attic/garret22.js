
document.addEventListener('DOMContentLoaded', function() {
    const cursor = document.querySelector('.custom-cursor');
    let clickCount = 0;
    let inactivityTimer;

    function resetCursor() {
        clickCount = 0;
        cursor.style.transform = 'translate(-50%, -50%) scale(1)';
        cursor.style.background ='black';
        cursor.style.background = 'radial-gradient(circle, #FF0000 0%, #FF0000 25%, rgba(0,0,0,0) 40%, #FF0000 60%, #FF0000 100%)';
    }
    
        function resetCursorAfterClick() {
        clickCount = 0;
        cursor.style.transform = 'translate(-50%, -50%) scale(1)';
        cursor.style.background ='black';
        setTimeout(() => {
        cursor.style.background = 'radial-gradient(circle, #FF0000 0%, #FF0000 25%, rgba(0,0,0,0) 40%, #FF0000 60%, #FF0000 100%)';
        }, 1200);
    }

    function resetInactivityTimer() {
        clearTimeout(inactivityTimer);
        inactivityTimer = setTimeout(resetCursor, 1000);
    }

    document.addEventListener('mouseup', function() {
        clickCount++;

        if (clickCount === 3) {
            cursor.style.transform = 'translate(-50%, -50%) scale(3)';
            cursor.style.background = 'black';
        } else if (clickCount > 3 && clickCount < 11) {
            cursor.style.transform = `translate(-50%, -50%) scale(${2 + (clickCount - 3) * 9})`;
        } else if (clickCount > 3 && clickCount === 11) {
            cursor.style.transform = `translate(-50%, -50%) scale(99)`;
        } else if (clickCount === 12) {
            cursor.style.transform = 'translate(-50%, -50%) scale(135)';

            const attic12Link = document.getElementById('attic-12-');
            if (attic12Link) {
                const clickEvent = new MouseEvent('click', {
                    bubbles: true,
                    cancelable: true,
                    view: window
                });
                attic12Link.dispatchEvent(clickEvent);
                attic12Link.style.pointerEvents = 'none';
                
                setTimeout(() => {
                    attic12Link.style.pointerEvents = 'auto';
                }, 3000);
            }

            resetCursorAfterClick();
        }

        resetInactivityTimer();
    });

    resetInactivityTimer();

    // Управление ссылками и видео
    document.querySelectorAll('a').forEach(function(link) {
        link.addEventListener('click', function(event) {
            var id = this.getAttribute('id');

            document.querySelectorAll('video.attic-video').forEach(function(video) {
                if (video.classList.contains(id)) return;
                hideVideo(video);
            });

            var videoToPlay = document.querySelector('video.' + id);
            if (videoToPlay) {
                if (!videoToPlay.querySelector('source')) {
                    var source = document.createElement('source');
                    source.src = 'https://nohome.cloud/wp-content/themes/blankslate/files/attic/videos' + id.replace(/-/g, '_') + '.mp4';
                    source.type = 'video/mp4';
                    videoToPlay.appendChild(source);
                    videoToPlay.load();
                }

                videoToPlay.style.display = 'block';
                setTimeout(() => {
                    videoToPlay.style.opacity = '1';
                }, 0);

                var playCount = 0;
                var playLimit = (id === 'attic-11-' || id === 'attic-10-' || id === 'attic-2-1') ? 2 : 3;
                var specialVideos = ['attic-1-1', 'attic-3-', 'attic-5-', 'attic-6-'];

                function playNextIteration() {
                    playCount++;
                    if (playCount <= playLimit) {
                        if (specialVideos.includes(id)) {
                            if (playCount === 1 || playCount === 3) {
                                videoToPlay.src = 'https://nohome.cloud/wp-content/themes/blankslate/files/attic/' + id.replace(/-/g, '_') + '.mp4';
                                videoToPlay.currentTime = 0.5;
                            } else if (playCount === 2) {
                                videoToPlay.src = 'https://nohome.cloud/wp-content/themes/blankslate/files/attic/' + id.replace(/-/g, '_') + '-reverse.mp4';
                                videoToPlay.currentTime = 0;
                            }
                        } else {
                            videoToPlay.currentTime = 0.5;
                        }
                        videoToPlay.play();
                    } else {
                        hideVideo(videoToPlay);
                    }
                }

                videoToPlay.playNextIteration = playNextIteration;
                videoToPlay.addEventListener('ended', playNextIteration);

                videoToPlay.addEventListener('click', function() {
                    hideVideo(videoToPlay);
                });

                playCount = 0;
                playNextIteration();
            }
        });
    });

    function hideVideo(video) {
        video.style.opacity = '0';
        setTimeout(() => {
            video.style.display = 'none';
            video.pause();
            video.currentTime = 0;
        }, 600);
        video.removeEventListener('ended', video.playNextIteration);
    }

    var link = document.getElementById('attic-pic-1-3');
    var image = document.querySelector('.attic-pic-1-3');
    var timer;
    var isVisible = false;

    function toggleImage() {
        clearTimeout(timer);
        
        if (isVisible) {
            hideImage();
        } else {
            showImage();
        }
    }

    function showImage() {
        image.classList.add('visible');
        link.textContent = 'Изображение показывается';
        isVisible = true;

        timer = setTimeout(function() {
            hideImage();
        }, 5000);
    }

    function hideImage() {
        image.classList.remove('visible');
        link.textContent = 'Показать изображение';
        isVisible = false;
    }

    link.addEventListener('click', function(e) {
        e.preventDefault();
        toggleImage();
    });

    const overlayImage = document.querySelector('.darken-skeletons');
  
    setTimeout(() => {
        overlayImage.style.opacity = '1';
        setTimeout(() => {
            overlayImage.style.opacity = '0';
        }, 6500);
    }, 1200);
});