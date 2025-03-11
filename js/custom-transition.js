/* document.addEventListener('DOMContentLoaded', () => {
  barba.init({
    transitions: [{
      name: 'fade-transition',
      leave(data) {
        return gsap.to(data.current.container, { opacity: 0 });
      },
      enter(data) {
        return gsap.from(data.next.container, { opacity: 0 });
      }
    }],
    views: [{
      namespace: '*', // Этот обработчик будет вызываться для всех страниц
      afterEnter() {
        console.log('Страница загружена');
      }
    }]
  });
}); */