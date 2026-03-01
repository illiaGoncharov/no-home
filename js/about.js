document.addEventListener("DOMContentLoaded", function () {
  try {
    const wrapper = document.querySelector(".about-page-wrapper");
    const xrayButton = document.getElementById("x-ray-button");
    const secondListItem = document.querySelector(
      ".about-page-list:nth-child(2)"
    );

    if (!wrapper) {
      // console.warn("Wrapper element not found");
      return;
    }

    // Оптимизация создания плавающих элементов
    const fragment = document.createDocumentFragment();
    const zeros = [];

    for (let i = 0; i < 20; i++) {
      try {
        const zero = document.createElement("div");
        zero.className = "floating-zero";
        zero.textContent = "0";

        // Устанавливаем начальную позицию
        const startX = Math.random() * 80 + 10; // От 10% до 90%
        const startY = Math.random() * 80 + 10;
        zero.style.left = `${startX}%`;
        zero.style.top = `${startY}%`;

        // Добавляем начальные параметры анимации
        zero.dataset.directionX = Math.random() > 0.5 ? 1 : -1;
        zero.dataset.directionY = Math.random() > 0.5 ? 1 : -1;
        zero.dataset.speedX = (Math.random() * 0.6 + 0.5) / 100; // От 0.5% до 1.1% за кадр - быстрее
        zero.dataset.speedY = (Math.random() * 0.6 + 0.5) / 100;
        
        // Параметры для эффекта глитча (смена на А и 1)
        zero.dataset.lastGlitch = Date.now();
        zero.dataset.glitchInterval = Math.random() * 3000 + 2000; // От 2 до 5 секунд между глитчами

        zeros.push(zero);
        fragment.appendChild(zero);
      } catch (error) {
        console.error("Error creating floating zero:", error);
      }
    }

    wrapper.appendChild(fragment);

    // Оптимизация анимации плавающих элементов
    let lastTime = 0;
    const fps = 60;
    const interval = 1000 / fps;

    function animateZeros(currentTime) {
      if (currentTime - lastTime < interval) {
        requestAnimationFrame(animateZeros);
        return;
      }
      lastTime = currentTime;

      zeros.forEach((zero) => {
        // Получаем текущие координаты
        let currentX = parseFloat(zero.style.left);
        let currentY = parseFloat(zero.style.top);

        // Получаем параметры движения
        const directionX = parseFloat(zero.dataset.directionX);
        const directionY = parseFloat(zero.dataset.directionY);
        const speedX = parseFloat(zero.dataset.speedX);
        const speedY = parseFloat(zero.dataset.speedY);

        // Обновляем позицию
        currentX += directionX * speedX;
        currentY += directionY * speedY;

        // Проверяем границы и меняем направление при необходимости
        if (currentX <= 10 || currentX >= 90) {
          zero.dataset.directionX = -directionX;
          currentX = Math.max(10, Math.min(90, currentX));
        }
        if (currentY <= 10 || currentY >= 90) {
          zero.dataset.directionY = -directionY;
          currentY = Math.max(10, Math.min(90, currentY));
        }

        // Применяем новые координаты
        zero.style.left = `${currentX}%`;
        zero.style.top = `${currentY}%`;
        
        // Эффект глитча - изменение содержимого на А или 1
        const now = Date.now();
        const timeSinceLastGlitch = now - parseFloat(zero.dataset.lastGlitch);
        const glitchInterval = parseFloat(zero.dataset.glitchInterval);
        
        if (timeSinceLastGlitch > glitchInterval) {
          // Глитч - показываем А или 1 на более длительное время
          const glitchChars = ['A', '1'];
          const originalText = zero.textContent;
          zero.textContent = glitchChars[Math.floor(Math.random() * glitchChars.length)];
          
          setTimeout(() => {
            zero.textContent = '0';
          }, Math.random() * 300 + 400); // Возвращаем 0 через 400-700ms (было 100-200ms)
          
          zero.dataset.lastGlitch = now;
          zero.dataset.glitchInterval = Math.random() * 3000 + 2000; // Новый интервал
        }
      });

      requestAnimationFrame(animateZeros);
    }

    requestAnimationFrame(animateZeros);

    if (xrayButton && secondListItem) {
      // Сохраняем оригинальный текст
      if (!secondListItem.dataset.originalText) {
        secondListItem.dataset.originalText = secondListItem.innerHTML;
      }

      const newText = `
        <ul class="about-page-list list-2">
          <li class="about-page-block-list-item" data-text="XRISTINA IDX / ART DIRECTOR / ARTIST / AI IMAGE GENERATOR…&">XRISTINA IDX / ART DIRECTOR / ARTIST / AI IMAGE GENERATOR…&</li>
          <li class="about-page-block-list-item" data-text="AMIL_NITRRITE / 3D ARTIST / AI IMAGE GENERATOR…&">AMIL_NITRRITE / 3D ARTIST / AI IMAGE GENERATOR…&</li>
          <li class="about-page-block-list-item" data-text="。.:*dj soundhoe / SOUND ARTIST…&">。.:*dj soundhoe / SOUND ARTIST…&</li>
          <li class="about-page-block-list-item" data-text="ANDREY LOPATIN / WEB DESIGNER / GRAPHIC DESIGNER…&">ANDREY LOPATIN / WEB DESIGNER / GRAPHIC DESIGNER…&</li>
          <li class="about-page-block-list-item" data-text="SEMIK ZLO / MOBILE DESIGNER / GRAPHIC DESIGNER…&">SEMIK ZLO / MOBILE DESIGNER / GRAPHIC DESIGNER…&</li>
          <li class="about-page-block-list-item" data-text="O0000000J / ILLUSTRATOR…&">O0000000J / ILLUSTRATOR…&</li>
          <li class="about-page-block-list-item" data-text="ANASTASIA OLEGOVNA / TRANSLATOR">ANASTASIA OLEGOVNA / TRANSLATOR</li>
          <li class="about-page-block-list-item" data-text="MAKSIM GERASIMOV / WEB DEVELOPER…&">MAKSIM GERASIMOV / WEB DEVELOPER…&</li>
          <li class="about-page-block-list-item" data-text="ILIA GONCHAROV-SERPOV / WEB DEVELOPER…&">ILIA GONCHAROV-SERPOV / WEB DEVELOPER…&</li>
          <li class="about-page-block-list-item" data-text="VLAD MD GOLAM / WEB DEVELOPER…&">VLAD MD GOLAM / WEB DEVELOPER…&</li>
        </ul>
      `;

      // Синхронизация списка с фактическим состоянием X-Ray в DOM
      function syncWithXray() {
        const xrayWrapper = document.querySelector('.x-ray-wrapper');
        const isXrayOn = xrayWrapper && xrayWrapper.classList.contains('xray-active');
        if (isXrayOn) {
          secondListItem.innerHTML = newText;
        } else {
          secondListItem.innerHTML = secondListItem.dataset.originalText;
        }
      }

      // При загрузке: ждём пока nav-tools.js выставит класс xray-active
      setTimeout(syncWithXray, 200);

      // При клике: ждём пока nav-tools.js переключит класс, потом синхронизируемся
      xrayButton.addEventListener("click", () => {
        setTimeout(syncWithXray, 200);
      }, { passive: true });
    }
  } catch (error) {
    console.error("Error in about.js initialization:", error);
  }
});

// Вспомогательная функция для debounce
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}
