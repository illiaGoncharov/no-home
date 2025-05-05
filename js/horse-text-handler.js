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

    // Restart animation
    horseTextEl.style.animation = 'none'; // Remove existing animation
    horseTextEl.offsetHeight; /* Trigger reflow */
    horseTextEl.style.animation = 'scrollText 15s linear infinite'; // Re-add animation
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

  /**
   * Отправляет текст со стикера на сервер по AJAX для отправки на почту.
   * @param {string} textToSend Текст для отправки.
   * @param {HTMLElement|null} inputElement Элемент ввода (textarea), чтобы его можно было заблокировать/разблокировать.
   */
  function sendStickerTextViaAjax(textToSend, inputElement = null) {
    // Проверяем, доступны ли данные из functions.php (созданные wp_localize_script)
    if (typeof stickerEmailData === 'undefined' || !stickerEmailData.ajaxurl || !stickerEmailData.nonce) {
      console.error('Ошибка: Данные для отправки письма (stickerEmailData) не найдены или неполны. Проверьте wp_localize_script в functions.php.');
      if (inputElement) inputElement.disabled = false; // Разблокируем, если что-то пошло не так
      return; // Прерываем выполнение
    }

    console.log('Отправка текста на email:', textToSend);

    // Готовим данные для отправки
    const data = new FormData();
    data.append("action", "send_sticker_email"); // Должно совпадать с хуком в PHP: add_action('wp_ajax_send_sticker_email', ...)
    data.append("user_text", textToSend);
    data.append("security", stickerEmailData.nonce); // Используем nonce из локализованных данных

    // Блокируем поле ввода, если оно передано
    if (inputElement) {
      inputElement.disabled = true;
    }

    // Отправляем запрос
    fetch(stickerEmailData.ajaxurl, { // Используем ajaxurl из локализованных данных
      method: "POST",
      body: data,
    })
    .then(response => {
      if (!response.ok) { // Проверяем статус ответа HTTP
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json(); // Парсим JSON только если ответ OK
     })
    .then(result => {
      if (result.success) {
        console.log("Сервер ответил (успех отправки email):", result.data.message);
        // Можно добавить уведомление пользователю здесь
      } else {
        console.error("Сервер ответил (ошибка отправки email):", result.data.message);
        // Можно добавить уведомление об ошибке здесь
        if (inputElement) {
          inputElement.disabled = false; // Разблокируем поле при ошибке сервера
        }
      }
      // Заметьте: hideStickerInfo() здесь не вызывается. Управление окном остается в main[local].php
    })
    .catch((error) => {
      console.error("Ошибка сети или обработки ответа при отправке email:", error);
      if (inputElement) {
        inputElement.disabled = false; // Разблокируем поле при ошибке сети или парсинга JSON
      }
      // Можно добавить уведомление об ошибке сети здесь
    });
  }
});
