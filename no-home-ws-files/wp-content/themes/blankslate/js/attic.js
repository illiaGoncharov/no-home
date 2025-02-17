document.querySelectorAll('a').forEach(function(link) {
    link.addEventListener('click', function(event) {
        event.preventDefault();
        var id = this.getAttribute('id');
        // Скрываем все видео и останавливаем их
        document.querySelectorAll('video.attic-video').forEach(function(video) {
            if (video.classList.contains(id)) return; // Пропускаем видео, которое нужно показать
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
                source.src = 'https://nohome.cloud/wp-content/themes/blankslate/files/attic/' + id.replace(/-/g, '_') + '.mp4';
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
                    videoToPlay.currentTime = 0.5; // Начинаем с 500 мс
                    if (playCount === 2) {
                        videoToPlay.playbackRate = -1; // Воспроизведение в обратную сторону
                    } else {
                        videoToPlay.playbackRate = 1; // Воспроизведение в обычном направлении
                    }
                    videoToPlay.play();
                } else {
                    // После третьего воспроизведения начинаем анимацию закрытия
                    videoToPlay.style.opacity = '0';
                    setTimeout(() => {
                        videoToPlay.style.display = 'none';
                        videoToPlay.pause();
                        videoToPlay.currentTime = 0;
                        videoToPlay.playbackRate = 1; // Сбрасываем скорость воспроизведения
                    }, 600);
                    videoToPlay.removeEventListener('ended', playNextIteration);
                }
            }

            videoToPlay.playNextIteration = playNextIteration;
            videoToPlay.addEventListener('ended', playNextIteration);
            // Начинаем воспроизведение после завершения анимации открытия
            setTimeout(() => {
                videoToPlay.currentTime = 0.5; // Начинаем с 500 мс
                videoToPlay.play();
            }, 600);
        }
    });
});