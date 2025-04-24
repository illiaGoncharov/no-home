document.addEventListener("DOMContentLoaded", () => {
  // Флаг для включения/отключения отладки
  const DEBUG = false;

  // Функция для логирования
  const log = (...args) => {
    if (DEBUG) {
      console.log(...args);
    }
  };

  log("Horse text handler initialized");

  const horseTextEl = document.getElementById("horse-text-original");
  log("Horse text element:", horseTextEl);

  if (!horseTextEl) {
    console.error("Horse text element not found!");
    return;
  }

  const defaultText = horseTextEl.textContent;
  log("Default text:", defaultText);

  // Функция для установки текста
  const setHorseText = (text) => {
    log("Setting horse text to:", text);
    horseTextEl.textContent = text || defaultText;
  };

  // Функция для обработки всех элементов с атрибутами
  const handleHorseElements = () => {
    // Обработка кликов
    document.querySelectorAll("[data-horse-click]").forEach((element) => {
      // Проверяем, не добавлен ли уже обработчик
      if (!element.hasAttribute("data-horse-click-handled")) {
        element.addEventListener("click", (e) => {
          log("Click detected on:", element);
          const clickText = element.getAttribute("data-horse-click");
          setHorseText(clickText);
        });
        element.setAttribute("data-horse-click-handled", "true");
      }
    });

    // Обработка наведения
    document.querySelectorAll("[data-horse-hover]").forEach((element) => {
      // Проверяем, не добавлен ли уже обработчик
      if (!element.hasAttribute("data-horse-hover-handled")) {
        element.addEventListener("mouseover", (e) => {
          log("Hover detected on:", element);
          const hoverText = element.getAttribute("data-horse-hover");
          setHorseText(hoverText);
        });

        element.addEventListener("mouseout", (e) => {
          log("Mouse out from:", element);
          setHorseText(defaultText);
        });
        element.setAttribute("data-horse-hover-handled", "true");
      }
    });
  };

  // Инициализация обработки элементов при загрузке
  handleHorseElements();

  // Наблюдатель за изменениями в DOM
  const observer = new MutationObserver((mutations) => {
    let shouldHandle = false;

    mutations.forEach((mutation) => {
      // Проверяем изменения в скелетном меню
      if (
        mutation.target.classList &&
        mutation.target.classList.contains("skeleton-home")
      ) {
        const skeletonHome = document.querySelector(".skeleton-home");
        if (skeletonHome) {
          // Если меню открывается
          if (
            skeletonHome.style.display === "flex" &&
            skeletonHome.classList.contains("show")
          ) {
            log("Skeleton menu is visible");
            // Устанавливаем текст из кнопки скелета
            const skeletonButton = document.querySelector(
              ".skeleton-button[data-horse-click]"
            );
            if (skeletonButton) {
              const clickText = skeletonButton.getAttribute("data-horse-click");
              setHorseText(clickText);
            }
          }
          // Если меню закрывается
          else if (!skeletonHome.classList.contains("show")) {
            log("Skeleton menu is hidden");
            setHorseText(defaultText);
          }
        }
      }

      // Проверяем, добавились ли новые узлы
      if (mutation.addedNodes.length) {
        shouldHandle = true;
      }
    });

    if (shouldHandle) {
      log("DOM changes detected, handling elements");
      handleHorseElements();
    }
  });

  // Начинаем наблюдение за изменениями в body
  observer.observe(document.body, {
    childList: true,
    subtree: true,
    attributes: true,
    attributeFilter: ["style", "class"],
  });
});
