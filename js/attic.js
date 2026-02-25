(function() {
  console.log('[Attic] Script loaded');

  window.atticState = window.atticState || {
    clickCount: 0,
    cursor: null,
    inactivityTimer: null,
    initialized: false
  };

  window.atticResetCursor = function() {
    window.atticState.clickCount = 0;
    if (window.atticState.cursor) {
      window.atticState.cursor.style.transform = 'translate(-50%, -50%) scale(1)';
      window.atticState.cursor.style.background = 'radial-gradient(circle, #FF0000 0%, #FF0000 30%, transparent 50%, #FF0000 70%, #FF0000 100%)';
    }
  };

  window.atticResetCursorAfterFlash = function() {
    window.atticState.clickCount = 0;
    if (window.atticState.cursor) {
      window.atticState.cursor.style.transform = 'translate(-50%, -50%) scale(1)';
      window.atticState.cursor.style.background = 'black';
      setTimeout(function() {
        if (window.atticState.cursor) {
          window.atticState.cursor.style.background = 'radial-gradient(circle, #FF0000 0%, #FF0000 30%, transparent 50%, #FF0000 70%, #FF0000 100%)';
        }
      }, 1200);
    }
  };

  window.atticResetInactivityTimer = function() {
    clearTimeout(window.atticState.inactivityTimer);
    window.atticState.inactivityTimer = setTimeout(window.atticResetCursor, 5000);
  };

  window.atticMouseMove = function(e) {
    if (window.atticState && window.atticState.cursor) {
      window.atticState.cursor.style.left = e.clientX + 'px';
      window.atticState.cursor.style.top = e.clientY + 'px';
    }
  };

  window.atticClick = function(event) {
    var atticRoom = document.getElementById('attic-room-main');
    if (!atticRoom) return;
    
    var isHidden = atticRoom.style.display === 'none' || 
                   getComputedStyle(atticRoom).display === 'none' ||
                   !atticRoom.offsetParent;
    if (isHidden) return;
    
    if (!window.atticState || !window.atticState.cursor) return;
    
    window.atticState.clickCount++;
    var count = window.atticState.clickCount;
    console.log('[Attic] Click #' + count);

    if (count <= 12 && window.atticState.cursor) {
      var currentScale = 1 + (count * count * 0.04);
      window.atticState.cursor.style.transform = 'translate(-50%, -50%) scale(' + currentScale + ')';
    } 
    else if (count === 13) {
      console.log('[Attic] 13th click!');
      
      // Block skeleton clicks during 13th click animation
      window.atticState.is13thClickActive = true;
      
      if (window.atticState.cursor) {
        window.atticState.cursor.style.transform = 'translate(-50%, -50%) scale(500)';
        window.atticState.cursor.style.background = 'black';
        window.atticState.cursor.style.transition = 'all 0.3s ease-out';
      }
      
      setTimeout(function() {
        var videoToPlay = document.querySelector('video.attic-12');
        if (videoToPlay) {
          console.log('[Attic] Playing video 12');
          window.atticDimPlayerVolume();
          window.atticSetVolume(videoToPlay);
          videoToPlay.style.display = 'block';
          setTimeout(function() { videoToPlay.style.opacity = '1'; }, 0);
          videoToPlay.play();
          videoToPlay.addEventListener('ended', function() {
            window.atticHideVideo(videoToPlay);
            window.atticState.is13thClickActive = false;
          }, { once: true });
          videoToPlay.addEventListener('click', function() {
            window.atticHideVideo(videoToPlay);
            window.atticState.is13thClickActive = false;
          }, { once: true });
        } else {
          window.atticState.is13thClickActive = false;
        }
        window.atticResetCursorAfterFlash();
      }, 500);
    }

    window.atticResetInactivityTimer();
  };

  window.atticHideVideo = function(video) {
            video.style.opacity = '0';
    setTimeout(function() {
                video.style.display = 'none';
                video.pause();
                video.currentTime = 0;
            }, 600);
    // Restore player volume
    window.atticRestorePlayerVolume();
  };

  window.atticSetVolume = function(video) {
    var savedVolume = (typeof getSavedVolume === 'function' ? getSavedVolume() : 80) / 100;
    video.volume = savedVolume;
  };
  
  // Dim player when skeleton video plays
  window.atticDimPlayerVolume = function() {
    var audios = document.querySelectorAll('audio');
    audios.forEach(function(audio) {
      if (!audio.paused) {
        audio.dataset.originalVolume = audio.volume;
        audio.volume = audio.volume * 0.2; // Reduce to 20%
      }
    });
  };
  
  // Restore player volume after video ends
  window.atticRestorePlayerVolume = function() {
    var audios = document.querySelectorAll('audio');
    audios.forEach(function(audio) {
      if (audio.dataset.originalVolume) {
        audio.volume = parseFloat(audio.dataset.originalVolume);
        delete audio.dataset.originalVolume;
      }
    });
  };

  window.initializeAttic = function() {
    var atticRoom = document.getElementById('attic-room-main');
    if (!atticRoom) {
      return;
    }
    
    // Prevent race conditions
    if (window.atticState.isInitializing) {
      return;
    }
    
    // Remove ALL existing cursors first
    document.querySelectorAll('.attic-cursor').forEach(function(el) { el.remove(); });
    window.atticState.cursor = null;
    
    window.atticState.isInitializing = true;
    console.log('[Attic] Init');
    
    window.atticState.clickCount = 0;
    clearTimeout(window.atticState.inactivityTimer);
    
    var cursor = document.createElement('div');
    cursor.className = 'attic-cursor';
    cursor.style.cssText = 'position: fixed; left: 50%; top: 50%; width: 40px; height: 40px; border-radius: 50%; pointer-events: none; z-index: 99999; transform: translate(-50%, -50%) scale(1); background: radial-gradient(circle, #FF0000 0%, #FF0000 30%, transparent 50%, #FF0000 70%, #FF0000 100%); transition: transform 0.3s ease-out, background 0.3s ease-out; box-shadow: 0 0 10px rgba(255,0,0,0.5);';
    document.body.appendChild(cursor);
    window.atticState.cursor = cursor;
    window.atticState.isInitializing = false;
    
    if (!window.atticState.initialized) {
      window.atticState.initialized = true;
      document.addEventListener('mousemove', window.atticMouseMove);
      document.addEventListener('mouseup', window.atticClick);
      console.log('[Attic] Global handlers added');
    }
    
    var svgLinks = document.querySelectorAll('.object-overlay a[id^="attic-"]');
    console.log('[Attic] Found ' + svgLinks.length + ' skeleton links');
    
    svgLinks.forEach(function(link) {
      if (link.dataset.atticBound) return;
      link.dataset.atticBound = 'true';
      
      link.onclick = function(event) {
        event.preventDefault();
        event.stopPropagation();
        
        // Block skeleton clicks during 13th click animation
        if (window.atticState.is13thClickActive) {
          console.log('[Attic] Skeleton click blocked (13th click active)');
          return false;
        }
        
        var linkId = this.id;
        console.log('[Attic] Skeleton click: ' + linkId);
        
        if (linkId.indexOf('attic-pic-') === 0) {
          var picId = linkId.replace('attic-pic-', '');
          var imageToShow = document.querySelector('.attic-pic-' + picId);
          if (imageToShow) {
            imageToShow.style.display = 'block';
            setTimeout(function() { imageToShow.style.opacity = '1'; }, 0);
            setTimeout(function() {
              imageToShow.style.opacity = '0';
              setTimeout(function() { imageToShow.style.display = 'none'; }, 600);
            }, 5000);
          }
          return false;
        }
        
        var id = linkId.replace('attic-', '');
        var videoToPlay = document.querySelector('video.attic-' + id);
        
        if (videoToPlay) {
          document.querySelectorAll('video.attic-video').forEach(function(video) {
            if (video !== videoToPlay) {
              window.atticHideVideo(video);
            }
          });

          window.atticDimPlayerVolume();
          window.atticSetVolume(videoToPlay);
            
            videoToPlay.style.display = 'block';
          setTimeout(function() {
                videoToPlay.style.opacity = '1';
            }, 0);
          videoToPlay.play();

          videoToPlay.addEventListener('ended', function() {
            window.atticHideVideo(videoToPlay);
          }, { once: true });

          videoToPlay.addEventListener('click', function() {
            window.atticHideVideo(videoToPlay);
          });
        }
        return false;
      };
    });
    
    window.atticResetInactivityTimer();

    var volumeRange = document.querySelector('#volumeRange');
    if (volumeRange && !volumeRange.dataset.atticBound) {
      volumeRange.dataset.atticBound = 'true';
      volumeRange.addEventListener('input', function() {
        document.querySelectorAll('video.attic-video').forEach(function(video) {
          window.atticSetVolume(video);
        });
      });
    }

    var overlayImage = document.querySelector('.darken-skeletons');
    if (overlayImage && !overlayImage.dataset.atticBound) {
      overlayImage.dataset.atticBound = 'true';
      setTimeout(function() {
        overlayImage.style.opacity = '1';
        setTimeout(function() {
          overlayImage.style.opacity = '0';
        }, 6500);
      }, 1200);
    }
    
    console.log('[Attic] Init complete');
  };

  // Cleanup when leaving attic
  window.atticCleanup = function() {
    document.querySelectorAll('.attic-cursor').forEach(function(el) { el.remove(); });
    if (window.atticState.cursor) {
      window.atticState.cursor.remove();
      window.atticState.cursor = null;
    }
    clearTimeout(window.atticState.inactivityTimer);
    window.atticState.clickCount = 0;
    // Reset initialized so handlers get re-added on next visit
    window.atticState.initialized = false;
  };

  // Run on page load
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', window.initializeAttic);
  } else {
    window.initializeAttic();
  }

  // Run on AJAX navigation
  document.addEventListener('pageTransitionComplete', function() {
    var atticRoom = document.getElementById('attic-room-main');
    if (atticRoom) {
      window.initializeAttic();
    } else {
      window.atticCleanup();
    }
  });
  
  // Cleanup on room transition
  document.addEventListener('roomCleanup', window.atticCleanup);
  
  // Cleanup on navigation click (but not on attic skeleton links)
  document.addEventListener('click', function(e) {
    var link = e.target.closest('a[href]');
    if (!link || !link.href) return;
    
    // Skip attic skeleton links
    if (link.id && link.id.indexOf('attic-') === 0) return;
    
    // Skip hash-only links
    if (link.getAttribute('href') === '#') return;
    
    // Clicking a real navigation link - cleanup cursor
    window.atticCleanup();
  });
  
  // Cleanup before page unload
  window.addEventListener('beforeunload', window.atticCleanup);
  
  // Also cleanup on pageTransitionStart (before transition)
  document.addEventListener('pageTransitionStart', window.atticCleanup);
})();
