document.addEventListener("DOMContentLoaded", function () {
  try {
    const wrapper = document.querySelector(".about-page-wrapper");
    const xrayButton = document.getElementById("x-ray-button");
    const secondListItem = document.querySelector(
      ".about-page-list:nth-child(2)"
    );

    if (!wrapper) {
      console.warn("Wrapper element not found");
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
        zero.style.left = `${Math.random() * 90}%`;
        zero.style.top = `${Math.random() * 90}%`;
        zeros.push(zero);
        fragment.appendChild(zero);
      } catch (error) {
        console.error("Error creating floating zero:", error);
      }
    }

    wrapper.appendChild(fragment);

    // Оптимизация анимации плавающих элементов
    let lastTime = 0;
    const fps = 30; // Уменьшаем частоту обновления
    const interval = 1000 / fps;

    function animateZeros(currentTime) {
      if (currentTime - lastTime < interval) {
        requestAnimationFrame(animateZeros);
        return;
      }
      lastTime = currentTime;

      zeros.forEach((zero) => {
        const currentLeft = parseFloat(zero.style.left);
        const currentTop = parseFloat(zero.style.top);

        zero.style.left = `${
          (currentLeft + (Math.random() - 0.5) * 0.5) % 90
        }%`;
        zero.style.top = `${(currentTop + (Math.random() - 0.5) * 0.5) % 90}%`;
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
          <li class="about-page-block-list-item" data-text="*ACU__238 + / SOUND ARTIST…&">*ACU__238 + / SOUND ARTIST…&</li>
          <li class="about-page-block-list-item" data-text="ANDREY LOPATIN / WEB DESIGNER / GRAPHIC DESIGNER…&">ANDREY LOPATIN / WEB DESIGNER / GRAPHIC DESIGNER…&</li>
          <li class="about-page-block-list-item" data-text="SEMIK ZLO / MOBILE DESIGNER / GRAPHIC DESIGNER…&">SEMIK ZLO / MOBILE DESIGNER / GRAPHIC DESIGNER…&</li>
          <li class="about-page-block-list-item" data-text="O0000000J / ILLUSTRATOR…&">O0000000J / ILLUSTRATOR…&</li>
          <li class="about-page-block-list-item" data-text="ANASTASIA OLEGOVNA / TRANSLATOR">ANASTASIA OLEGOVNA / TRANSLATOR</li>
          <li class="about-page-block-list-item" data-text="MAKSIM GERASIMOV / WEB DEVELOPER…&">MAKSIM GERASIMOV / WEB DEVELOPER…&</li>
          <li class="about-page-block-list-item" data-text="ILIA GONCHAROV-SERPOV / WEB DEVELOPER…&">ILIA GONCHAROV-SERPOV / WEB DEVELOPER…&</li>
          <li class="about-page-block-list-item" data-text="VLAD MD GOLAM / WEB DEVELOPER…&">VLAD MD GOLAM / WEB DEVELOPER…&</li>
        </ul>
      `;

      // Оптимизация обработки клика
      const debouncedToggle = debounce(() => {
        try {
          if (
            secondListItem.innerHTML === secondListItem.dataset.originalText
          ) {
            secondListItem.innerHTML = newText;
          } else {
            secondListItem.innerHTML = secondListItem.dataset.originalText;
          }
        } catch (error) {
          console.error("Error toggling x-ray content:", error);
        }
      }, 100);

      xrayButton.addEventListener("click", debouncedToggle, { passive: true });
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
