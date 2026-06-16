# Техническое руководство разработчика

## Введение

Данное руководство предназначено для разработчиков, работающих с кодовой базой проекта NOHOME. Документ содержит практические инструкции по модификации, отладке и расширению функциональности.

## Основные технологические стеки

### Backend технологии

**WordPress 6.x**
- Кастомная тема `blankslate`
- PHP 7.4+ для серверной логики
- MySQL база данных
- Apache/Nginx веб-сервер

**Структура темы:**
```php
functions.php    # WordPress хуки и функции
header.php       # HTML структура и навигация
page.php         # Основной шаблон страниц
style.css        # Глобальные стили
```

### Frontend технологии

**Vanilla JavaScript (ES6+)**
- Модульная архитектура без фреймворков
- Event-driven программирование
- DOM API для манипуляций с элементами
- Fetch API для асинхронных запросов

**CSS3**
- Flexbox и CSS Grid для лейаутов
- CSS Custom Properties (переменные)
- Анимации через @keyframes
- Viewport units для адаптивности

**SVG**
- Интерактивные области навигации
- Векторная графика для UI элементов
- CSS стилизация SVG элементов

## Архитектурные паттерны

### Module Pattern

Каждый JavaScript файл использует паттерн модуля для изоляции:

```javascript
(function() {
    'use strict';
    
    // Приватные переменные и функции
    const DEBUG = false;
    const moduleState = {
        initialized: false,
        currentMode: 'default'
    };
    
    function privateFunction() {
        // Внутренняя логика модуля
    }
    
    // Публичный API через window объект
    window.moduleAPI = {
        init: function() {
            // Инициализация модуля
        },
        destroy: function() {
            // Очистка ресурсов
        }
    };
    
    // Автоинициализация
    document.addEventListener('DOMContentLoaded', function() {
        window.moduleAPI.init();
    });
})();
```

### Event-Driven Architecture

Взаимодействие между модулями осуществляется через события:

```javascript
// Отправка события
document.dispatchEvent(new CustomEvent('roomChanged', {
    detail: { 
        roomId: 'bedroom',
        previousRoom: 'main' 
    }
}));

// Обработка события
document.addEventListener('roomChanged', function(event) {
    const { roomId, previousRoom } = event.detail;
    updateUI(roomId);
});
```

### State Management

Глобальное состояние приложения:

```javascript
const AppState = {
    currentRoom: 'main',
    horseMode: 'text', // 'text' | 'player'
    isPlaying: false,
    volume: 80,
    
    // Методы изменения состояния
    setRoom: function(roomId) {
        this.currentRoom = roomId;
        this.notifyStateChange();
    },
    
    notifyStateChange: function() {
        document.dispatchEvent(new CustomEvent('stateChanged', {
            detail: { state: this }
        }));
    }
};
```

## Система управления текстом (Remote Control)

### Основной API

Файл: `js/horse-text-handler.js`

```javascript
// Обновление текста в пульте
window.updateHorseText(text, duration);

// Реинициализация обработчиков после AJAX
window.reInitializeHorseInteractions();

// Настройка hover взаимодействий
setupHoverInteraction(selectors, enterText, leaveText);
```

### Добавление новых hover текстов

1. Найти соответствующую функцию настройки комнаты:
```javascript
const setupBedroomInteractions = () => {
    // Добавить новый элемент
    setupHoverInteraction([
        '#new-element-id',
        '.new-element-class'
    ], "Текст при наведении", "Текст при уходе курсора");
};
```

2. Убедиться, что функция вызывается в инициализации:
```javascript
const initializeHorseTextHandler = () => {
    setupBedroomInteractions(); // Должна быть в списке
    // ... другие функции
};
```

## Система предметов (Items System)

### Архитектура модуля

Файл: `js/items.js`

```javascript
// Структура функций инициализации
function initializeBackpackScript() { /* ... */ }
function initializeLuggageScript() { /* ... */ }
function initializeIphoneScript() { /* ... */ }
function initializeDocumentsScript() { /* ... */ }
function initializeCameraScript() { /* ... */ }
function initializeMp3Script() { /* ... */ }

// Загрузка контента
function loadContent(contentId) {
    fetch(`/wp-content/themes/blankslate/items/${contentId}.php`)
        .then(response => response.text())
        .then(data => {
            document.getElementById("items-content").innerHTML = data;
            // Инициализация соответствующего скрипта
            switch (contentId) {
                case "backpack-content":
                    initializeBackpackScript();
                    break;
                // ... другие случаи
            }
        });
}
```

### Добавление нового предмета

1. Создать PHP шаблон в папке `items/`:
```php
<!-- items/newitem-content.php -->
<div class="newitem-container">
    <!-- HTML структура нового предмета -->
</div>
```

2. Добавить функцию инициализации в `items.js`:
```javascript
function initializeNewItemScript() {
    // Логика нового предмета
    const container = document.querySelector('.newitem-container');
    
    container.addEventListener('click', function(event) {
        // Обработка взаимодействий
    });
}
```

3. Зарегистрировать в системе загрузки:
```javascript
function loadContent(contentId) {
    // ... существующий код
    switch (contentId) {
        // ... существующие случаи
        case "newitem-content":
            initializeNewItemScript();
            break;
    }
}
```

## Навигационная система

### AJAX переходы

Система навигации использует AJAX для переходов без перезагрузки:

```javascript
// Обработка клика по навигационной ссылке
document.querySelectorAll('.ajax-page-link').forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault();
        
        const url = this.getAttribute('href');
        const roomId = this.getAttribute('data-id');
        
        loadRoom(url, roomId);
    });
});

function loadRoom(url, roomId) {
    fetch(url)
        .then(response => response.text())
        .then(html => {
            // Обновление контента
            document.querySelector('#main-content').innerHTML = html;
            
            // Обновление URL
            history.pushState({roomId}, '', url);
            
            // Реинициализация обработчиков
            if (window.reInitializeHorseInteractions) {
                window.reInitializeHorseInteractions();
            }
        });
}
```

### Добавление новой комнаты

1. Создать файл комнаты `local/[local]newroom.php`:
```php
<!-- HTML структура новой комнаты -->
<div class="room-wrapper newroom-wrapper">
    <!-- Фоновое изображение -->
    <img class="room-background-img" src="path/to/background.jpg">
    
    <!-- Интерактивные элементы -->
    <div class="interactive-element" id="element1">
        <!-- Содержимое элемента -->
    </div>
</div>

<script>
// JavaScript для комнаты
document.addEventListener('DOMContentLoaded', function() {
    // Инициализация логики комнаты
});
</script>
```

2. Добавить SVG область в `[local]main.php`:
```html
<a href="/0selectedarea6" class="ajax-page-link mnewroom" data-id="6">
    <path id="house-frame-newroom" fill="black" d="SVG_PATH_COORDINATES"/>
</a>
```

3. Добавить hover обработчики в `horse-text-handler.js`:
```javascript
const setupNewroomInteractions = () => {
    setupHoverInteraction([
        '#element1',
        '.interactive-element'
    ], "Текст для нового элемента");
};

// Добавить в инициализацию
const initializeHorseTextHandler = () => {
    // ... существующие функции
    setupNewroomInteractions();
};
```

## Отладка и диагностика

### Включение режима отладки

В любом JavaScript файле изменить:
```javascript
const DEBUG = true; // было false
```

Это активирует подробное логирование в консоли браузера.

### Проверка состояния системы

В консоли браузера:
```javascript
// Проверка загрузки основных модулей
console.log(typeof window.updateHorseText); // должно быть 'function'
console.log(typeof window.reInitializeHorseInteractions); // должно быть 'function'

// Тестирование пульта управления
updateHorseText("Тестовое сообщение");

// Проверка текущего состояния
console.log(document.querySelector('#hi-update').textContent);

// Симуляция hover события
const element = document.querySelector('.test-element');
element.dispatchEvent(new Event('mouseenter'));
```

### Диагностика проблем с анимациями

```css
/* Временные стили для отладки */
.horse-indicator-text {
    border: 2px solid red !important;
    background: rgba(255, 255, 0, 0.3) !important;
}

#horse-text-original {
    border: 1px solid blue !important;
}
```

## Процессы разработки

### Локальная разработка

```bash
# Запуск Docker окружения
docker-compose up -d

# Проверка статуса контейнеров
docker-compose ps

# Просмотр логов
docker-compose logs wordpress

# Остановка окружения
docker-compose down
```

### Контроль версий

```bash
# Стандартный workflow
git status                    # Проверка изменений
git add .                     # Добавление всех изменений
git commit -m "Описание"      # Коммит с описанием
git push                      # Отправка на GitHub

# Просмотр истории
git log --oneline -10         # Последние 10 коммитов
git diff HEAD~1               # Изменения с предыдущего коммита
```

### Деплой на продакшн

```bash
# Различные типы деплоя
./deploy.sh hotfix            # Только JavaScript файлы
./deploy.sh code              # Код без изображений
./deploy.sh images            # Только изображения
./deploy.sh prod              # Полный деплой (с подтверждением)

# Ручной деплой через lftp
lftp -u username,password ftp://server -e "put filename; quit"
```

## Решение типичных проблем

### JavaScript файл не загружается (404)

**Симптомы:** Ошибка 404 в консоли браузера
**Причины:** Файл не загрузился на сервер или проблемы с кешем
**Решение:**
1. Проверить наличие файла на сервере через FTP
2. Повторить деплой: `./deploy.sh hotfix`
3. При необходимости загрузить вручную через FileZilla

### Анимация текста не работает

**Симптомы:** Текст в пульте не анимируется
**Причины:** Конфликт CSS и JavaScript анимаций
**Решение:**
1. Убрать CSS анимации из style.css
2. Оставить только JavaScript анимацию в horse-text-handler.js
3. Проверить отсутствие `!important` в CSS, блокирующих JS стили

### Hover тексты не обновляются

**Симптомы:** При наведении текст в пульте не меняется
**Причины:** Обработчики не инициализированы после AJAX перехода
**Решение:**
```javascript
// Вызвать реинициализацию
if (window.reInitializeHorseInteractions) {
    window.reInitializeHorseInteractions();
}
```

### Прелоадер показывается в Docker

**Симптомы:** Прелоадер не скрывается на localhost:8000
**Причины:** Неправильное определение среды разработки
**Решение:** Добавить проверку в `[local]main.php`:
```javascript
const isDevelopment = window.location.hostname === 'localhost' || 
                     window.location.port === '8000' ||
                     window.location.href.includes('localhost:8000');
```

## Стандарты кодирования

### JavaScript

- Использовать строгий режим: `'use strict';`
- Предпочитать `const` и `let` вместо `var`
- Использовать осмысленные имена переменных и функций
- Добавлять комментарии к сложной логике
- Обрабатывать ошибки через try-catch или .catch()

### CSS

- Использовать BEM методологию для именования классов
- Группировать связанные свойства
- Указывать единицы измерения явно
- Использовать относительные единицы для адаптивности

### PHP

- Следовать стандартам WordPress Coding Standards
- Экранировать выводимые данные
- Использовать WordPress функции вместо нативного PHP где возможно

## Производительность и оптимизация

### JavaScript оптимизация

- Минимизировать DOM запросы через кеширование селекторов
- Использовать делегирование событий для динамического контента
- Очищать интервалы и таймауты при уничтожении компонентов
- Использовать `passive: true` для event listeners где возможно

### CSS оптимизация

- Избегать глубоких селекторов (> 3 уровня)
- Использовать CSS Grid и Flexbox вместо float
- Минимизировать использование `!important`
- Группировать медиа-запросы

Данное руководство обеспечивает основу для эффективной работы с кодовой базой проекта NOHOME.



