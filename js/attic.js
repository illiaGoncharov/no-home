// Проверяем, находимся ли мы на странице чердака при загрузке
if (window.location.pathname.includes('selectedarea4')) {
    console.log('🏠 Прямая загрузка страницы чердака - вызываем initializeAttic');
    // Ждём, пока window.initializeAttic будет определена
    setTimeout(function() {
        if (typeof window.initializeAttic === 'function') {
            window.initializeAttic();
        } else {
            console.warn('⚠️ window.initializeAttic не определена');
        }
    }, 500);
}

// Логика видео
document.querySelectorAll('a').forEach(function(link) {
    link.addEventListener('click', function(event) {
        event.preventDefault();
        var id = this.getAttribute('id');
        
        // Скрываем все видео
        document.querySelectorAll('video.attic-video').forEach(function(video) {
            if (video.classList.contains(id)) return;
            video.style.opacity = '0';
            setTimeout(() => {
                video.style.display = 'none';
                video.pause();
                video.currentTime = 0;
            }, 600);
            video.removeEventListener('ended', video.playNextIteration);
        });
        
        var videoToPlay = document.querySelector('video.' + id);
        if (videoToPlay) {
            if (!videoToPlay.querySelector('source')) {
                var source = document.createElement('source');
                source.src = 'https://nohome.cloud/wp-content/themes/blankslate/files/attic/videos/' + id.replace(/-/g, '_') + '.mp4';
                source.type = 'video/mp4';
                videoToPlay.appendChild(source);
                videoToPlay.load();
            }
            
            videoToPlay.style.display = 'block';
            setTimeout(() => {
                videoToPlay.style.opacity = '1';
            }, 0);

            var playCount = 0;
            var playLimit = 3;
            
            function playNextIteration() {
                playCount++;
                if (playCount < playLimit) {
                    videoToPlay.currentTime = 0.5;
                    if (playCount === 2) {
                        videoToPlay.playbackRate = -1;
                    } else {
                        videoToPlay.playbackRate = 1;
                    }
                    videoToPlay.play();
                } else {
                    videoToPlay.style.opacity = '0';
                    setTimeout(() => {
                        videoToPlay.style.display = 'none';
                        videoToPlay.pause();
                        videoToPlay.currentTime = 0;
                        videoToPlay.playbackRate = 1;
                    }, 600);
                    videoToPlay.removeEventListener('ended', playNextIteration);
                }
            }

            // Клик по видео закрывает его
            videoToPlay.addEventListener('click', function() {
                videoToPlay.style.opacity = '0';
                setTimeout(() => {
                    videoToPlay.style.display = 'none';
                    videoToPlay.pause();
                    videoToPlay.currentTime = 0;
                }, 600);
                videoToPlay.removeEventListener('ended', playNextIteration);
            });

            videoToPlay.playNextIteration = playNextIteration;
            videoToPlay.addEventListener('ended', playNextIteration);
            
            setTimeout(() => {
                videoToPlay.currentTime = 0.5;
                videoToPlay.play();
            }, 600);
        }
    });
});