// Подключаем библиотеку video.js
var videojs = require('https://cdn.jsdelivr.net/npm/video.js@7.10.2/dist/video.min.js');

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
      // Инициализируем плеер video.js
      var player = videojs(videoToPlay, {
        controls: true,
        autoplay: false,
        preload: 'auto'
      });
      if (!videoToPlay.querySelector('source')) {
        var source = document.createElement('source');
        source.src = 'https://nohome.cloud/wp-content/themes/blankslate/files/attic/' + id.replace(/-/g, '_') + '.mp4';
        source.type = 'video/mp4';
        videoToPlay.appendChild(source);
        player.load();
      }
      videoToPlay.style.display = 'block';
      setTimeout(() => {
        videoToPlay.style.opacity = '1';
      }, 0);
      var playCount = 0;
      var playLimit = 3;
      var reversePlay = ['attic-1-1', 'attic-3-', 'attic-4-', 'attic-6-'].includes(id);
      function playNextIteration() {
        playCount++;
        if (playCount < playLimit) {
          if (reversePlay) {
            // Воспроизведение видео в обратную сторону
            player.playbackRate(-1);
          } else {
            player.playbackRate(1);
          }
          player.currentTime(0.5); // Начинаем с 500 мс
          player.play();
        } else {
          // После третьего воспроизведения начинаем анимацию закрытия
          videoToPlay.style.opacity = '0';
          setTimeout(() => {
            videoToPlay.style.display = 'none';
            player.pause();
            player.currentTime(0);
          }, 600);
          player.removeEventListener('ended', playNextIteration);
        }
      }
      player.playNextIteration = playNextIteration;
      player.addEventListener('ended', playNextIteration);
      // Начинаем воспроизведение после завершения анимации открытия
      setTimeout(() => {
        player.currentTime(0.5); // Начинаем с 500 мс
        player.play();
      }, 600);
    }
  });
});

document.getElementById('attic-pic-1-3').addEventListener('click', function(e) {
  e.preventDefault();
  var img = document.querySelector('.attic-pic-1-3');
  img.classList.add('visible');
  setTimeout(function() {
    img.classList.remove('visible');
  }, 3900);
});

document.addEventListener('DOMContentLoaded', function() {
  const overlayImage = document.querySelector('.darken-skeletons');

  // Начинаем появление через 1200мс после загрузки страницы
  setTimeout(() => {
    overlayImage.style.opacity = '1';

    // Начинаем исчезновение через 6500мс (5000мс появление + 1500мс пауза)
    setTimeout(() => {
      overlayImage.style.opacity = '0';
    }, 6500);
  }, 1200);
});