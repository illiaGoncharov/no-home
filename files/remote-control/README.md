# 🎛️ REMOTE CONTROL IMAGES

Картинки для пультика (remote control) в проекте NO HOME.

## 📁 ФАЙЛЫ

### Оригинальные (кириллица):
- `пультик.png` - обычное состояние пультика (481KB)
- `пультик-плеер.png` - состояние с активным плеером (458KB) 
- `пауза.png` - кнопка паузы (9KB)

### Английские названия (для кода):
- `remote-default.png` - обычное состояние
- `remote-player.png` - состояние с плеером
- `pause-button.png` - кнопка паузы

## 🔄 ИСПОЛЬЗОВАНИЕ

### В CSS:
```css
.remote-control {
    background-image: url('files/remote-control/remote-default.png');
}

.remote-control.player-active {
    background-image: url('files/remote-control/remote-player.png');
}

.pause-button {
    background-image: url('files/remote-control/pause-button.png');
}
```

### В HTML:
```html
<img src="files/remote-control/remote-default.png" alt="Remote Control">
```

## 📏 ХАРАКТЕРИСТИКИ

| Файл | Размер | Назначение | Когда показывается |
|------|--------|------------|-------------------|
| remote-default.png | 481KB | Обычный пультик | По умолчанию |
| remote-player.png | 458KB | Пультик с плеером | Когда MP3 активен |
| pause-button.png | 9KB | Кнопка паузы | Во время воспроизведения |

## 🚀 ДЕПЛОЙ

Для обновления только картинок:
```bash
./deploy.sh images
```

---
**Обновлено:** 13.08.2025
**Статус:** ✅ Картинки готовы 