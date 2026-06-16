// Тест анимации пультика - запускать в консоли браузера

console.log('🎛️ Тест анимации пультика');

// Ждем загрузки страницы
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        console.log('🐴 Тестируем анимацию...');
        
        // Проверяем наличие функции
        if (typeof window.testHorseAnimation === 'function') {
            console.log('✅ Функция testHorseAnimation найдена');
            window.testHorseAnimation();
        } else {
            console.log('❌ Функция testHorseAnimation не найдена');
        }
        
        // Дополнительный тест с очень длинным текстом
        setTimeout(() => {
            if (typeof window.updateHorseText === 'function') {
                console.log('🧪 Дополнительный тест с длинным текстом...');
                window.updateHorseText("you can move me and listen to me and this text is intentionally very long to test the marquee animation functionality in the horse indicator remote control device", 0);
            }
        }, 2000);
        
    }, 1000);
});

// Консольные команды для ручного тестирования:
console.log(`
🔧 Команды для тестирования:

1. Тест анимации:
   testHorseAnimation()

2. Тест с кастомным текстом:
   updateHorseText("Очень длинный текст для проверки анимации скроллинга")

3. Проверка элементов:
   document.querySelector('.horse-indicator-text')
   document.querySelector('#horse-text-original')

4. Принудительная анимация:
   document.querySelector('.horse-indicator-text').classList.add('marquee')
`);
