# Патчи интеграции AnimationManager

## 1. Подключение animation-manager.js

### functions.php — добавить в wp_enqueue_scripts:

```php
// В функции blankslate_scripts() добавить ПЕРЕД другими скриптами:
wp_enqueue_script(
    'animation-manager',
    get_template_directory_uri() . '/js/animation-manager.js',
    array(), // без зависимостей
    '1.0.0',
    false // в head, чтобы был доступен остальным скриптам
);
```

---

## 2. horse-text-handler.js — замена setInterval на rAF

### Проблема:
Строки 139-147: `setInterval(16ms)` для прокрутки текста блокирует main thread.

### Патч:

```diff
--- a/js/horse-text-handler.js
+++ b/js/horse-text-handler.js
@@ -106,6 +106,9 @@
         return null;
     };
 
+    // Глобальная ссылка на marquee для управления
+    let currentMarquee = null;
+
     // 🔄 СИСТЕМА ОБНОВЛЕНИЯ ТЕКСТА: стабильная анимация + принудительная видимость
     const updateHorseText = (text, options = {}) => {
         const { duration = 0, force = true } = options;
@@ -127,22 +130,24 @@
             
             scrollTextEl.textContent = textToSet;
             
-            // 🎬 СТАБИЛЬНАЯ АНИМАЦИЯ: начинаем справа от контейнера
-            let position = 20; 
-            scrollTextEl.style.transform = `translateX(${position}px)`;
-            
-            // Очищаем предыдущую анимацию
-            if (scrollTextEl.animationInterval) {
-                clearInterval(scrollTextEl.animationInterval);
+            // 🎬 НОВАЯ АНИМАЦИЯ через AnimationManager (rAF)
+            // Останавливаем предыдущую анимацию
+            if (currentMarquee) {
+                currentMarquee.stop();
             }
             
-            // Запускаем плавную анимацию прокрутки
-            scrollTextEl.animationInterval = setInterval(() => {
-                position -= 1;
-                scrollTextEl.style.transform = `translateX(${position}px)`;
-                
-                // Сброс когда текст ушел за левый край
-                if (position < -scrollTextEl.offsetWidth - 50) {
-                    position = horseTextEl.offsetWidth + 20;
-                }
-            }, 16);
+            // Создаём новый marquee через AnimationManager
+            if (typeof AnimationManager !== 'undefined') {
+                currentMarquee = AnimationManager.createMarquee(
+                    scrollTextEl,
+                    horseTextEl,
+                    { speed: 1, gap: 50 }
+                );
+                currentMarquee.start();
+            } else {
+                // Fallback для случая когда AnimationManager не загружен
+                scrollTextEl.style.transform = 'translateX(20px)';
+                console.warn('AnimationManager не найден, marquee отключён');
+            }
             
             log('🎬 Анимация запущена для текста:', textToSet);
```

---

## 3. header.php — throttle для mousemove

### Проблема:
Строки 161-163: mousemove срабатывает на каждый пиксель.

### Патч:

```diff
--- a/header.php
+++ b/header.php
@@ -156,11 +156,17 @@
         document.body.insertAdjacentHTML('beforeend', '<div class="custom-cursor"></div>');
         const cursor = document.querySelector('.custom-cursor');
         
-        document.addEventListener('mousemove', function(e) {
+        // Используем throttle через rAF для оптимизации
+        const updateCursor = (e) => {
             cursor.style.left = e.clientX + 'px';
             cursor.style.top = e.clientY + 'px';
-        });
+        };
         
+        // Throttle: обновляем позицию не чаще 1 раза за кадр
+        const throttledUpdate = typeof AnimationManager !== 'undefined' 
+            ? AnimationManager.throttleRAF(updateCursor)
+            : updateCursor; // fallback
+        
+        document.addEventListener('mousemove', throttledUpdate, { passive: true });
+        
         const clickableElements = document.querySelectorAll('a, button, [role="button"], .clickable, .overlay-svg');
```

---

## 4. attic.js — плавное масштабирование курсора

### Проблема:
Масштабирование курсора происходит рывками при быстрых кликах.

### Патч (использование CSS transitions вместо JS):

```diff
--- a/js/attic.js
+++ b/js/attic.js
@@ -44,6 +44,9 @@
   window.atticClick = function(event) {
     var atticRoom = document.getElementById('attic-room-main');
     if (!atticRoom) return;
+    
+    // Проверяем что AnimationManager загружен
+    var hasAnimManager = typeof AnimationManager !== 'undefined';
     
     var isHidden = atticRoom.style.display === 'none' || 
                    getComputedStyle(atticRoom).display === 'none' ||
@@ -58,8 +61,14 @@
 
     if (count <= 12 && window.atticState.cursor) {
       var currentScale = 1 + (count * 0.2);
-      window.atticState.cursor.style.transform = 'translate(-50%, -50%) scale(' + currentScale + ')';
-    } 
+      
+      // CSS transition обеспечит плавность (см. style.css .attic-cursor)
+      // Просто меняем значение, CSS сделает анимацию
+      window.atticState.cursor.style.transform = 
+        'translate(-50%, -50%) scale(' + currentScale + ')';
+      
+      console.log('[Attic] Scale:', currentScale.toFixed(2));
+    }
     else if (count === 13) {
       console.log('[Attic] 13th click!');
       
@@ -67,9 +76,15 @@
       window.atticState.is13thClickActive = true;
       
       if (window.atticState.cursor) {
-        window.atticState.cursor.style.transform = 'translate(-50%, -50%) scale(500)';
-        window.atticState.cursor.style.background = 'black';
+        // Временно отключаем transition для мгновенной вспышки
         window.atticState.cursor.style.transition = 'all 0.3s ease-out';
+        window.atticState.cursor.style.transform = 'translate(-50%, -50%) scale(500)';
+        window.atticState.cursor.style.background = 'black';
+        
+        // Возвращаем transition после вспышки
+        setTimeout(function() {
+          window.atticState.cursor.style.transition = '';
+        }, 350);
       }
```

---

## 5. items.js — унификация fadeTransition

### Проблема:
3 разных функции для fade анимаций (fadeTransition, fadeIn, fadeOut).

### Рефакторинг (замена на AnimationManager):

```diff
--- a/js/items.js
+++ b/js/items.js
@@ -736,26 +736,20 @@
   let leftEmojiTimeout, rightEmojiTimeout;
 
   function resetStars() {
     stars.forEach((star) => (star.style.fill = "none"));
     currentStar = 0;
   }
 
+  // Используем AnimationManager вместо кастомной функции
   function fadeTransition(hideScreen, showScreen, duration = 500) {
-    hideScreen.style.opacity = "1";
-    showScreen.style.opacity = "0";
-    showScreen.style.display = "block";
-
-    let start = null;
-    function step(timestamp) {
-      if (!start) start = timestamp;
-      const progress = timestamp - start;
-      const ratio = Math.min(progress / duration, 1);
-
-      hideScreen.style.opacity = String(1 - ratio);
-      showScreen.style.opacity = String(ratio);
-
-      if (progress < duration) {
-        window.requestAnimationFrame(step);
-      } else {
-        hideScreen.style.display = "none";
-      }
+    if (typeof AnimationManager !== 'undefined') {
+      return AnimationManager.crossFade(hideScreen, showScreen, { duration }).start();
+    } else {
+      // Fallback без анимации
+      hideScreen.style.display = 'none';
+      showScreen.style.display = 'block';
+      return Promise.resolve();
     }
-    window.requestAnimationFrame(step);
   }
```

### Удаление дублирующихся функций:

```diff
@@ -914,41 +908,23 @@
+  // fadeIn теперь использует AnimationManager
   function fadeIn(element, duration) {
-    element.style.display = "block";
-    element.style.opacity = 0;
-    let start = null;
-    function step(timestamp) {
-      if (!start) start = timestamp;
-      const progress = timestamp - start;
-      element.style.opacity = Math.min(progress / duration, 1);
-      if (progress < duration) {
-        window.requestAnimationFrame(step);
-      }
+    if (typeof AnimationManager !== 'undefined') {
+      return AnimationManager.fadeIn(element, { duration }).start();
     }
-    window.requestAnimationFrame(step);
+    element.style.display = 'block';
+    element.style.opacity = '1';
   }

   function fadeOut(element, duration) {
-    let start = null;
-    function step(timestamp) {
-      if (!start) start = timestamp;
-      const progress = timestamp - start;
-      element.style.opacity = Math.max(1 - progress / duration, 0);
-      if (progress < duration) {
-        window.requestAnimationFrame(step);
-      } else {
-        element.style.display = "none";
-      }
+    if (typeof AnimationManager !== 'undefined') {
+      return AnimationManager.fadeOut(element, { duration }).start();
     }
-    window.requestAnimationFrame(step);
+    element.style.display = 'none';
   }
```

---

## 6. nav-tools.js — использование CSS variables для timing

### Патч для toggleElement:

```diff
--- a/js/nav-tools.js
+++ b/js/nav-tools.js
@@ -389,6 +389,9 @@
   }
 
   function toggleElement(element, show) {
+    // Используем timing из CSS variables (читаем computed style)
+    var timing = getComputedStyle(document.documentElement)
+      .getPropertyValue('--timing-ui').trim() || '300ms';
+    
     if (show) {
       element.style.display = "flex";
       requestAnimationFrame(() => {
@@ -398,6 +401,10 @@
       element.classList.add("hidden");
       element.addEventListener(
         "transitionend",
         function hideElement() {
           if (element.classList.contains("hidden")) {
             element.style.display = "none";
           }
           element.removeEventListener("transitionend", hideElement);
         },
         { once: true }
       );
+      
+      // Fallback timeout на случай если transitionend не сработает
+      setTimeout(() => {
+        if (element.classList.contains("hidden")) {
+          element.style.display = "none";
+        }
+      }, parseInt(timing) + 50);
     }
   }
```

---

## 7. golden.js — синхронизация с AnimationManager

### Патч для debounce:

```diff
--- a/js/golden.js
+++ b/js/golden.js
@@ -65,14 +65,12 @@
 
   let isAnimating = false;
 
-  function debounce(func, wait) {
-    let timeout;
-    return function executedFunction(...args) {
-      const later = () => {
-        clearTimeout(timeout);
-        func(...args);
-      };
-      clearTimeout(timeout);
-      timeout = setTimeout(later, wait);
-    };
-  }
+  // Используем debounce из AnimationManager если доступен
+  const debounce = typeof AnimationManager !== 'undefined' 
+    ? AnimationManager.debounce 
+    : function(func, wait) {
+        let timeout;
+        return function(...args) {
+          clearTimeout(timeout);
+          timeout = setTimeout(() => func.apply(this, args), wait);
+        };
+      };
```

---

## 8. Добавление will-change для анимируемых элементов

### style.css — дополнительные оптимизации:

```css
/* Добавить в конец style.css */

/* ==============================
   GPU-ускорение для анимируемых элементов
============================== */

/* Скелет-навигация */
.skeleton-home {
  will-change: opacity, transform;
}

.skeleton-home.show {
  transition: opacity var(--timing-ui) var(--ease-out);
}

/* Элементы iPhone */
.lockscreen,
.pass-screen,
.apps-screen {
  will-change: opacity;
  transition: opacity var(--timing-content) var(--ease-in-out);
}

/* MP3 плеер */
.cd,
.ice {
  will-change: transform;
}

.mp3-background-img {
  will-change: opacity;
  transition: opacity var(--timing-long) var(--ease-in-out);
}

/* Модальные окна items */
.items-wrapper {
  will-change: opacity;
}

/* Hover состояния с плавными переходами */
.nav-items-link,
.skeleton-home-link,
.ajax-page-link {
  transition: opacity var(--timing-micro) var(--ease-out);
}

.nav-items-link:hover,
.skeleton-home-link:hover {
  opacity: var(--opacity-hover);
}

/* Blur анимации */
.transition-blur {
  transition: filter var(--timing-content) var(--ease-in-out);
}
```

---

## Порядок применения патчей

1. **Сначала** — подключить `animation-manager.js` в `functions.php`
2. **Затем** — добавить CSS variables в `style.css` (уже сделано)
3. **Далее** — применить патчи к JS файлам по приоритету:
   - `horse-text-handler.js` (Critical)
   - `header.php` (High)
   - `attic.js` (Medium)
   - `items.js` (Medium)
   - `nav-tools.js` (Medium)
   - `golden.js` (Low)

## Совместимость

- AnimationManager написан как IIFE без внешних зависимостей
- Все патчи включают fallback для случая когда AnimationManager не загружен
- CSS variables поддерживаются во всех современных браузерах
- `will-change` следует использовать экономно (только для активно анимируемых элементов)
