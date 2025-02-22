document.addEventListener('DOMContentLoaded', function() {
    barba.init({
        transitions: [{
            leave({ current }) {
                return new Promise((resolve) => {
                    const tl = gsap.timeline({
                        onComplete: resolve
                    });

                    // Плавно исчезает контент текущей страницы
                    tl.to(current.container, {
                        opacity: 0,
                        duration: 0.5
                    });

                    // Плавно меняем фон на белый с задержкой
                    tl.to('body', {
                        backgroundColor: '#ffffff',
                        duration: 0.5
                    }, '-=0.5'); // Начинаем одновременно с исчезновением контента

                    // Добавляем задержку для белого экрана
                    tl.set('body', {
                        backgroundColor: '#ffffff',
                        delay: 0.5
                    });

                    // Плавно возвращаем фон к исходному состоянию
                    tl.to('body', {
                        backgroundColor: '',
                        duration: 0.5
                    });
                });
            },
            enter({ next }) {
                const tl = gsap.timeline();

                // Устанавливаем белый фон
                document.body.style.backgroundColor = '#ffffff';

                // Плавно появляется контент новой страницы с задержкой
                tl.fromTo(next.container, {
                    opacity: 0
                }, {
                    opacity: 1,
                    duration: 0.5,
                    delay: 0.5 // Задержка для плавного появления контента
                });

                // Плавно возвращаем фон к исходному состоянию (если нужно)
                tl.to('body', {
                    backgroundColor: '',
                    duration: 0.5
                });
            }
        }]
    });

    // Добавляем обработку события popstate, чтобы анимация работала при нажатии на кнопки навигации браузера (назад/вперед)
    window.addEventListener('popstate', function() {
        barba.go(document.location.href);
    });
});