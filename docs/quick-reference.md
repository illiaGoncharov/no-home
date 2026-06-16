# Быстрая справочная информация

## Основные файлы для модификации

```
js/horse-text-handler.js     # Пульт управления и hover тексты
style.css                    # Все стили проекта
header.php                   # HTML структура пульта и навигации
local/[local]main.php        # Главная страница с домом
items.js                     # Система предметов и MP3 плеер
nav-tools.js                 # Навигационные инструменты
```

## Частые операции

### Изменение hover текста

1. Открыть `js/horse-text-handler.js`
2. Найти соответствующую функцию (например, `setupBedroomInteractions`)
3. Изменить текст в вызове `setupHoverInteraction`
4. Деплой: `./deploy.sh hotfix`

### Изменение стилей элементов

1. Открыть `style.css`
2. Найти CSS селектор элемента
3. Изменить нужные свойства
4. Деплой: `./deploy.sh code`

### Добавление нового интерактивного элемента

1. Добавить HTML элемент в соответствующий файл комнаты
2. Добавить CSS стили в `style.css`
3. Добавить hover обработчик в `horse-text-handler.js`
4. Деплой: `./deploy.sh prod`

## Команды деплоя

```bash
./deploy.sh hotfix           # Только JavaScript файлы (быстро)
./deploy.sh code             # Код без изображений
./deploy.sh images           # Только изображения
./deploy.sh prod             # Полный деплой с подтверждением
```

## Отладка в браузере

```javascript
// Проверка работы пульта
updateHorseText("Тестовое сообщение");

// Реинициализация обработчиков
window.reInitializeHorseInteractions();

// Проверка загрузки модулей
console.log(typeof window.updateHorseText);

// Симуляция hover события
document.querySelector('.element').dispatchEvent(new Event('mouseenter'));
```

## Структура hover текстов по комнатам

### Главная страница
- Стикеры: "sorry for being weird it's my first time being alive"
- Стикер с заметкой: "you can leave a note or leave nothing"

### Спальня
- Рюкзак/чемодан: "watch out! Is something or someone behind you?"
- Силуэт: "have you ever been activated?"
- Окно: "do you know the temperature of air outside someone's window?"

### Пещера
- Шлем: "mind your head"
- Колонка: "do you know how to follow well?"
- Рация: "do you know how to listen carefully?"
- Зеркало: "sorry, your reflection is not renderable"

### Столовая
- Стол: "I hope this table is adaptive enough for you"
- Ноутбук: "my heart is surrounded by bones"
- Камера: "the motives of this camera are not clear"
- Жесткий диск: "don't rush to leave, it's a fine day"

### Золотая комната
- Дверь: "what do you prefer - closed/open doors?"
- Замок: "do you know how to cipher?"
- Крысы: "oh no, i am sorry, the mice have escaped the lab!"

## Решение проблем

### 404 ошибка на JavaScript файле
**Решение:** Ручная загрузка через FileZilla или повторный деплой

### Анимация текста не работает
**Решение:** Удалить CSS анимации, оставить только JavaScript в horse-text-handler.js

### Hover тексты не обновляются
**Решение:** Вызвать `window.reInitializeHorseInteractions()`

### Прелоадер показывается в Docker
**Решение:** Добавить проверку `window.location.port === '8000'` в условие определения разработки

## Полезные команды Git

```bash
git status                   # Проверка изменений
git add .                    # Добавление всех файлов
git commit -m "Описание"     # Коммит изменений
git push                     # Отправка на GitHub
git log --oneline -5         # Последние 5 коммитов
```

## Локальная разработка

```bash
docker-compose up -d         # Запуск контейнеров
docker-compose down          # Остановка контейнеров
docker-compose ps            # Статус контейнеров
```

Доступ:
- WordPress: http://localhost:8000
- phpMyAdmin: http://localhost:8003

## Контакты и ресурсы

- Продакшн: https://nohome.cloud
- GitHub: https://github.com/illiaGoncharov/no-home
- Локальная разработка: http://localhost:8000

## Включение режима отладки

В любом JavaScript файле изменить:
```javascript
const DEBUG = true; // было false
```

Это активирует подробные логи в консоли браузера для диагностики проблем.



