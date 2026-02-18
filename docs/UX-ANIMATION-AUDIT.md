# UX/Animation Аудит проекта NOHOME

## 1. Таблица проблем

| Файл | Строки | Описание проблемы | Приоритет | Решение |
|------|--------|-------------------|-----------|---------|
| **horse-text-handler.js** | 139-147 | `setInterval(16ms)` для прокрутки текста — блокирует main thread | Critical | Заменить на `requestAnimationFrame` |
| **horse-text-handler.js** | 134-136 | Интервал не очищается при смене текста до завершения | High | Добавить AbortController или флаг отмены |
| **header.php** | 161-163 | `mousemove` без throttle — срабатывает на каждый пиксель | High | Добавить throttle 16ms через rAF |
| **attic.js** | 181 | Глобальный `mousemove` handler без throttle | High | Использовать rAF-based throttle |
| **attic.js** | 60-62 | `cursor.style.transform` без плавной анимации при кликах 1-12 | Medium | Добавить CSS transition или GSAP-like ease |
| **attic.js** | 86-107 | Цепочка `setTimeout(500)` для 13-го клика — жёсткая задержка | Medium | Использовать Promise-based анимации |
| **items.js** | 738-758 | Дублирование `fadeTransition` — есть в 3 местах | Medium | Вынести в animation-manager.js |
| **items.js** | 914-957 | Три отдельных функции fadeIn/fadeOut/crossFade | Medium | Унифицировать в одну систему |
| **items.js** | 833 | `setInterval(30000)` для часов — можно оптимизировать | Low | Использовать `requestIdleCallback` |
| **items.js** | 878-895 | Вложенные `setTimeout` — сложно отменить | Medium | Promise-based chain |
| **mp3.js** | 90-151 | Сложная логика `setTimeout` внутри `updatePlaylistDisplay` | Medium | Разбить на async функции |
| **mp3.js** | 176-199 | Анимация фона через `setTimeout(750)` — дублирует CSS | Low | Использовать CSS transitions |
| **golden.js** | 67-77 | Собственная реализация debounce — можно унифицировать | Low | Использовать общий debounce |
| **golden.js** | 96-321 | Большой `setTimeout(100)` для инициализации | Medium | Использовать MutationObserver |
| **nav-tools.js** | 391-410 | `toggleElement` использует `transitionend` без fallback | Medium | Добавить timeout fallback |
| **nav-tools.js** | 266-269 | `setTimeout(100)` для инициализации после AJAX | High | Использовать Promise/MutationObserver |
| **style.css** | разные | Несогласованные timing-functions | Medium | CSS custom properties |
| **header.php** | 156-178 | Inline-скрипты курсора без модуля | Low | Вынести в cursor-handler.js |

## 2. Карта setTimeout/setInterval

### Критические (влияют на производительность):
```
horse-text-handler.js:139 - setInterval(16ms) - прокрутка текста ❌
items.js:533 - requestAnimationFrame - движение рюкзака ✅
mp3.js:466-469 - timeupdate event - обновление времени ✅
```

### UI Transitions (250-500ms):
```
attic.js:23-28      - setTimeout(1200) - сброс курсора после вспышки
attic.js:86-107     - setTimeout(500)  - запуск видео на 13-м клике  
items.js:651-659    - setTimeout(500)  - закрытие увеличенного изображения
items.js:768-771    - setTimeout(500)  - переход между экранами iPhone
mp3.js:90-151       - setTimeout(500)  - blur анимация плейлиста
nav-tools.js:156-157 - setTimeout(1200) - сброс курсора
```

### Content Transitions (500-1000ms):
```
golden.js:96        - setTimeout(100)  - отложенная инициализация 3D
golden.js:500       - setTimeout(?)    - анимация двери (из click handler)
items.js:877-895    - setTimeout(2500) - показ уведомления iPhone
nav-tools.js:266-269 - setTimeout(100) - init после AJAX
```

### Long Delays (1000ms+):
```
attic.js:34         - setTimeout(5000) - сброс курсора по бездействию
horse-text-handler.js:62-66 - setTimeout(100) - очистка курсоров
items.js:848-854    - setTimeout(9000) - скрытие эмодзи
```

## 3. Несогласованные easing-функции

### CSS (style.css):
```css
.custom-cursor { transition: transform 0.1s ease; }           /* ease */
.transition-blur { transition: filter 0.5s ease-in-out; }     /* ease-in-out */
.skeleton-home { transition: opacity 0.3s ease-out; }         /* ease-out */
.mp3-background-img { animation: fadeIn 750ms ease-in-out; }  /* ease-in-out */
```

### JS (атрибуты style.transition):
```javascript
attic.js:72    - 'all 0.3s ease-out'
mp3.js:70-71   - 'transform 2s' (без easing!)
nav-tools.js   - использует CSS transitions через классы
```

## 4. Дублирующийся код анимаций

### fadeTransition (items.js:738-758)
```javascript
function fadeTransition(hideScreen, showScreen, duration = 500) {
  // ... ~20 строк с requestAnimationFrame
}
```

### fadeIn/fadeOut (items.js:914-942)
```javascript
function fadeIn(element, duration) { /* ~14 строк */ }
function fadeOut(element, duration) { /* ~14 строк */ }
```

### crossFade (items.js:944-957)
```javascript
function crossFade(fadeOutElement, fadeInElement, duration) { /* ~14 строк */ }
```

### toggleElement (nav-tools.js:391-410)
```javascript
function toggleElement(element, show) {
  // Использует CSS transitions, но дублирует логику
}
```

**Итого:** ~60+ строк дублирующегося кода анимаций.

## 5. Потенциальные утечки памяти

### Незакрытые intervals:
```javascript
// horse-text-handler.js:139
scrollTextEl.animationInterval = setInterval(...);
// Очищается только при новом тексте, но не при уходе со страницы!
```

### Event listeners при AJAX:
```javascript
// items.js: при каждой загрузке контента добавляются новые listeners
// Нет механизма очистки при смене раздела
```

### MutationObserver в header.php:
```javascript
// header.php:225-246 - observer создаётся, но никогда не отключается
observer.observe(skeletonHome, { attributes: true });
```

## 6. Рекомендации по производительности

### Chrome DevTools профилирование:
1. Performance tab → Record → Взаимодействие с UI
2. Проверить Long Tasks (>50ms)
3. Найти Layout Thrashing (forced reflow)

### Избежание Layout Thrashing:
```javascript
// ❌ Плохо - читаем и пишем вперемешку:
element.style.width = '100px';
const height = element.offsetHeight; // FORCED REFLOW
element.style.height = height + 'px';

// ✅ Хорошо - сначала читаем, потом пишем:
const height = element.offsetHeight;
element.style.width = '100px';
element.style.height = height + 'px';
```

### will-change для анимируемых элементов:
```css
.custom-cursor { will-change: transform; }
.attic-cursor { will-change: transform, background; }
.skeleton-home { will-change: opacity, transform; }
```

## 7. Чеклист тестирования после изменений

### Базовые проверки:
- [ ] Курсор отслеживается плавно без рывков
- [ ] Hover-текст в пульте обновляется без задержки
- [ ] Переходы между экранами iPhone плавные
- [ ] Видео на чердаке запускается корректно на 13-м клике
- [ ] MP3 плеер работает без дёрганий
- [ ] Скелет-навигация открывается/закрывается плавно

### Performance проверки:
- [ ] FPS стабильно 60 при движении мыши (Performance Monitor)
- [ ] Нет Long Tasks >50ms (Performance tab)
- [ ] Memory не растёт при навигации между комнатами
- [ ] CPU idle при отсутствии взаимодействия

### AJAX навигация:
- [ ] Переход main → bedroom → attic → gold без утечек
- [ ] Курсор чердака появляется/исчезает корректно
- [ ] 3D комната загружается без повторных инициализаций

### Edge cases:
- [ ] Быстрые клики на чердаке (10+ кликов в секунду)
- [ ] Быстрое переключение разделов в items
- [ ] Открытие/закрытие скелета во время загрузки комнаты
- [ ] Изменение размера окна во время анимаций
