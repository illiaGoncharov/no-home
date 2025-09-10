document.addEventListener("DOMContentLoaded", function () {
  const navLinks = document.querySelectorAll(".nav-items-link");
  const mp3Element = document.querySelector(".mp3"); // Элемент .mp3
  const itemsContent = document.getElementById("items-content");
  const itemsButton = document.getElementById("items-button"); // Кнопка items-button

  // Находим элемент iPhone
  const iphoneLink = document.getElementById("iphone-content");

  // Изначально добавляем класс к #mp3-content и скрываем #items-content
  // navLinks[0].classList.add("nav-items-link-now");
  // itemsContent.style.display = "none";

  // Добавляем класс активной ссылки к iPhone
  iphoneLink.classList.add("nav-items-link-now");

  // Скрываем элемент .mp3 и показываем #items-content
  mp3Element.style.display = "none";
  itemsContent.style.display = "block";

  // Загружаем контент iPhone по умолчанию
  loadContent("iphone-content");

  navLinks.forEach((link) => {
    link.addEventListener("click", function (event) {
      event.preventDefault();

      // Удаляем класс у всех ссылок
      navLinks.forEach((l) => l.classList.remove("nav-items-link-now"));

      // Добавляем класс к текущей нажатой ссылке
      this.classList.add("nav-items-link-now");

      // Скрываем элемент .mp3 и показываем #items-content с соответствующим контентом
      if (this.id !== "mp3-content") {
        mp3Element.style.display = "none"; // Скрываем элемент с классом .mp3
        itemsContent.style.display = "block";

        // Загружаем контент, связанный с выбранным элементом
        loadContent(this.id);
      } else {
        // Если mp3-content выбран, показываем .mp3 и скрываем items-content
        mp3Element.style.display = "block";
        itemsContent.style.display = "none";
        initializeMp3Script(); // Инициализируем MP3 скрипт
      }
    });
  });

  // Обработчик клика по кнопке items-button
  itemsButton.addEventListener("click", function () {
    // Открываем раздел iPhone безопасно (без ошибки из-за iPhoneElement)
    itemsContent.style.display = "block";
    loadContent("iphone-content");
  });
});

// Функция для загрузки контента
let itemsLoadToken = 0; // Токен для предотвращения гонок загрузки
function loadContent(contentId) {
  const token = ++itemsLoadToken;

  fetch(`/wp-content/themes/blankslate/items/${contentId}.php`)
    .then((response) => response.text())
    .then((data) => {
      // Если это не самый свежий запрос — игнорируем ответ
      if (token !== itemsLoadToken) {
        return;
      }

      // Вставляем контент в HTML
      document.getElementById("items-content").innerHTML = data;

      // Показать items-content
      document.getElementById("items-content").style.display = "block"; // Убедитесь, что элемент показан

      // Скрываем .mp3, если открываем не mp3-раздел (повторяем логику из кликов меню)
      if (contentId !== "mp3-content") {
        const mp3ElementLocal = document.querySelector(".mp3");
        if (mp3ElementLocal) {
          mp3ElementLocal.style.display = "none";
        }
      }

      // Обновляем активный пункт меню, если он существует
      const allLinks = document.querySelectorAll('.nav-items-link');
      allLinks.forEach(l => l.classList.remove('nav-items-link-now'));
      const activeLink = document.getElementById(contentId);
      if (activeLink) {
        activeLink.classList.add('nav-items-link-now');
      }

      // Инициализация скриптов в зависимости от contentId
      switch (contentId) {
        case "backpack-content":
          initializeBackpackScript();
          break;
        case "luggage-content":
          initializeLuggageScript();
          break;
        case "iphone-content":
          initializeIphoneScript();
          break;
        case "documents-content":
          initializeDocumentsScript();
          break;
        case "camera-content":
          initializeCameraScript();
          break;
        case "mp3-content":
          initializeMp3Script();
          break;
        default:
          console.warn("No initialization function for:", contentId);
      }

      // ВАЖНО: не реинициализируем hover тут, чтобы не сбивать кастомный текст в пульте
    })
    .catch((error) => console.error("Error loading content:", error));
}

// Оставьте вашу существующую логику для items-button и exit, если она вам нужна
jQuery(document).ready(function ($) {
  // Функция для скрытия элементов и сброса стилей
  function resetElements() {
    // Скрываем элемент с классом .items-wrapper
    $(".items-wrapper").hide();

    // Показываем элемент с классом .nav-top и с классом .skeleton-button
    $(".nav-top").show();
    $(".skeleton-button").show();

    // Убираем стили у дочерних div внутри #content-to-blur
    $("#content-to-blur > div, .main-page > div").each(function () {
      $(this).css({
        filter: "none", // Сброс фильтра
      });
    });

    // Показываем блок .about-page-wrapper, если он есть
    if ($(".about-page-wrapper").length) {
      $(".about-page-wrapper").show();
      // console.log(".about-page-wrapper показан");
    } else {
      // console.log(".about-page-wrapper не найден");
    }
  }

  // Функция для показа элементов и добавления стилей
  function showElements() {
    // Показываем элемент с классом .items-wrapper
    $(".items-wrapper").show();

    // Скрываем элемент с классом .nav-top и с классом .skeleton-button
    $(".nav-top").hide();
    $(".skeleton-button").hide();

    // Добавляем стили к дочерним div внутри #content-to-blur и .main-page, у которых display: block;
    $("#content-to-blur > div, .main-page > div").each(function () {
      if ($(this).css("display") === "block") {
        $(this).css({
          filter: "blur(15px) brightness(60%)",
        });
      }
    });

    // Скрываем блок .about-page-wrapper, если он есть
    if ($(".about-page-wrapper").length) {
      $(".about-page-wrapper").hide();
      console.log(".about-page-wrapper скрыт");
    } else {
      console.log(".about-page-wrapper не найден");
    }
  }
  
  // Делаем функцию глобальной для доступа из других скриптов
  window.showElements = showElements;

  // Функция для закрытия капчи
  function hideCaptcha() {
    const captchaElement = document.getElementById("captcha");
    if (captchaElement) {
      captchaElement.style.display = "none";
    }
  }

  // Обновленная функция для обработки клика по #iphone-on-zoomed-table
  function handleIphoneZoomClick() {
    // Показ капчи перед выполнением основной логики
    showCaptcha();

    // Функция обратного вызова при успешном прохождении капчи
    window.onCaptchaSuccess = function () {
      // Скрываем капчу
      hideCaptcha();

      // Вызываем showElements, чтобы применить стили и показать нужные элементы
      showElements();

      // Добавляем класс nav-items-link-now к #iphone-content
      document
        .getElementById("iphone-content")
        .classList.add("nav-items-link-now");

      // Делаем #items-content видимым
      const itemsContent = document.getElementById("items-content");
      itemsContent.style.display = "block";

      // Скрываем элемент с классом .mp3
      const mp3Element = document.querySelector(".mp3");
      if (mp3Element) {
        mp3Element.style.display = "none";
      }

      // Загружаем контент для iphone-content
      fetch(
        "https://nohome.cloud/wp-content/themes/blankslate/items/iphone-content.php"
      )
        .then((response) => response.text())
        .then((data) => {
          // Вставляем контент в #items-content
          itemsContent.innerHTML = data;
          // Инициализируем скрипты для iphone-content
          initializeIphoneScript();
        })
        .catch((error) =>
          console.error("Error loading iPhone content:", error)
        );
    };
  }

  // При нажатии на кнопку items-button
  $("#items-button").click(function () {
    if ($(".items-wrapper").is(":visible")) {
      // Если элемент видим, то скрываем его (как при нажатии exit)
      resetElements();
    } else {
      // Если элемент скрыт, то показываем его
      showElements();
    }
  });

  // При нажатии на кнопку exit
  $("#exit").click(function () {
    resetElements();
  });
});

// CAPTCHA CLICKS

// common.js или captcha-common.js
window.currentCaptchaAction = null;

// Делаем функции доступными глобально через объект window
window.hideCaptcha = function () {
  const captchaElement = document.getElementById("captcha");
  if (captchaElement) {
    captchaElement.style.display = "none";
    //deinitializeCaptcha();
  }
};

window.showCaptcha = function (successCallback) {
  const captchaElement = document.getElementById("captcha");
  if (captchaElement) {
    captchaElement.style.display = "flex";
    // Сохраняем callback для использования после успешного прохождения капчи
    window.currentCaptchaAction = successCallback;
    // Вызываем функцию инициализации капчи
    if (typeof initializeCaptcha === 'function') {
      initializeCaptcha();
    } else {
      // ПРОСТАЯ заглушка если функция не найдена
      console.log('🎯 Captcha initialized (simple mode)');
      
      // Добавляем базовую логику кликов на картинки
      const captchaPics = document.querySelectorAll('.captcha-pic');
      captchaPics.forEach(pic => {
        pic.addEventListener('click', function() {
          pic.classList.toggle('correct');
        });
      });
      
      // Кнопка skip
      const skipButton = document.getElementById('skip-captcha');
      if (skipButton) {
        skipButton.addEventListener('click', function() {
          if (window.onCaptchaSuccess) {
            window.onCaptchaSuccess();
          }
        });
      }
    }
  } else {
    console.error("Captcha element not found");
  }
};

// Общий обработчик успешного прохождения капчи
window.onCaptchaSuccess = function () {
  // Сначала скрываем капчу
  window.hideCaptcha();

  // Затем выполняем специфичный callback
  if (window.currentCaptchaAction) {
    window.currentCaptchaAction();
    // Очищаем текущий обработчик
    window.currentCaptchaAction = null;
  }
};

// iphone.js
function handleIphoneZoomClick() {
  // Используем глобальную функцию showCaptcha
  window.showCaptcha(function () {
    // Вызываем showElements, чтобы применить стили и показать нужные элементы
    showElements();

    // Добавляем класс nav-items-link-now к #iphone-content
    document
      .getElementById("iphone-content")
      .classList.add("nav-items-link-now");

    // Делаем #items-content видимым
    const itemsContent = document.getElementById("items-content");
    itemsContent.style.display = "block";

    // Скрываем элемент с классом .mp3
    const mp3Element = document.querySelector(".mp3");
    if (mp3Element) {
      mp3Element.style.display = "none";
    }

    // Загружаем контент для iphone-content
    fetch(
      "https://nohome.cloud/wp-content/themes/blankslate/items/iphone-content.php"
    )
      .then((response) => response.text())
      .then((data) => {
        // Вставляем контент в #items-content
        itemsContent.innerHTML = data;
        // Инициализируем скрипты для iphone-content
        initializeIphoneScript();
      })
      .catch((error) => console.error("Error loading iPhone content:", error));
  });
}

// Привязываем обработчик клика для айфона
document.addEventListener("click", function (event) {
  if (event.target && event.target.id === "iphone-on-zoomed-table") {
    handleIphoneZoomClick();
  }
});

// Обработчик для рюкзака - БЕЗ КАПЧИ!
function handleBackpackClick() {
  const backpackOverlay = document.querySelector(".backpack-close-overlay");
  if (backpackOverlay) {
    backpackOverlay.addEventListener("click", function () {
      // Прямо вызываем функционал БЕЗ капчи
      // Вызываем showElements, чтобы применить стили и показать нужные элементы
      showElements();
      // Загружаем контент через общий безопасный загрузчик
      loadContent("backpack-content");
    });
  }
}
handleBackpackClick();

// Обработчик для чемодана - БЕЗ КАПЧИ!
function handleSuitcaseClick() {
  const suitcaseOverlay = document.querySelector(".suitcase-close-overlay");
  if (suitcaseOverlay) {
    suitcaseOverlay.addEventListener("click", function () {
      // Прямо вызываем функционал БЕЗ капчи
      // Вызываем showElements, чтобы применить стили и показать нужные элементы
      showElements();
      // Загружаем контент через общий безопасный загрузчик
      loadContent("luggage-content");
    });
  }
}
handleSuitcaseClick();

// Обработчик для динамика
function handleSpeakerClick() {
  const speakerElement = document.getElementById("speaker-to-mp3");
  if (speakerElement) {
    speakerElement.addEventListener("click", function () {
      // Показываем капчу и передаем только showElements как callback
      window.showCaptcha(function () {
        showElements();
      });
    });
  }
}
handleSpeakerClick();

// BACKPACK

function initializeBackpackScript() {
  const container = document.getElementById("backpack-container");
  const itemNameDisplay = document.querySelector(".backpack-items-name");
  const images = [];
  const imageNames = [
    "antiseptic",
    "band-aids",
    "bandage",
    "batteries",
    "canned food_1",
    "canned food_2",
    "carabiners",
    "compass",
    "dumb phone",
    "elastic water bottle",
    "emergency blanket",
    "essential medicines",
    "file folder_1",
    "file folder_2",
    "fire starter",
    "flashlight",
    "folding umbrella",
    "fork-spoon",
    "garbage bags",
    "gardening gloves",
    "hunting matches",
    "lighter fluid",
    "lighter",
    "maps",
    "medical gloves",
    "medical mask",
    "menstrual cup",
    "multi-cable",
    "multitool",
    "nuts",
    "paracord",
    "plastic bags",
    "power banks",
    "radio",
    "reusable pads",
    "signal mirror",
    "soap",
    "socket adapter",
    "spare phone",
    "tape",
    "thread and needle",
    "toothbrush and toothpaste",
    "vape liquids",
    "vapes",
    "wallet",
    "water filter",
    "waterproof backpack cover",
    "waterproof shoe covers",
    "whistle",
    "wire connectors kit",
  ];
  const numImages = imageNames.length;
  let enlarged = null;

  function createImage(index) {
    const image = document.createElement("div");
    image.className = "image";
    const imageName = imageNames[index].replace(/ /g, "%20");
    image.style.backgroundImage = `url(https://nohome.cloud/wp-content/themes/blankslate/files/items/backback/pieces/${imageName}.png)`;
    container.appendChild(image);

    const angle = Math.random() * Math.PI * 2;
    const speed = Math.random() * 0.05 + 0.02; // Значительно уменьшена скорость движения

    images.push({
      element: image,
      x: Math.random() * 100,
      y: Math.random() * 100,
      dx: Math.cos(angle) * speed,
      dy: Math.sin(angle) * speed,
      size: Math.random() * 9 + 9,
      sizeDirection: Math.random() < 0.5 ? 0.01 : -0.01, // Уменьшена скорость изменения размера
      changeDirectionCounter: Math.floor(Math.random() * 1000) + 500, // Значительно увеличен интервал смены направления
    });

    image.addEventListener("click", () => toggleEnlarge(index));
  }

  function moveImages() {
    images.forEach((img, index) => {
      if (enlarged !== null) return;

      img.changeDirectionCounter--;
      if (img.changeDirectionCounter <= 0) {
        // Более плавное изменение направления
        const newAngle =
          Math.atan2(img.dy, img.dx) + ((Math.random() - 0.5) * Math.PI) / 8;
        const speed = Math.sqrt(img.dx * img.dx + img.dy * img.dy);
        img.dx = Math.cos(newAngle) * speed;
        img.dy = Math.sin(newAngle) * speed;
        img.changeDirectionCounter = Math.floor(Math.random() * 1000) + 500;
      }

      img.x += img.dx;
      img.y += img.dy;

      // Плавное отражение от границ
      if (img.x < 0 || img.x > 100 - img.size) {
        img.dx *= -1;
        img.x = Math.max(0, Math.min(img.x, 100 - img.size));
      }
      if (img.y < 0 || img.y > 100 - img.size) {
        img.dy *= -1;
        img.y = Math.max(0, Math.min(img.y, 100 - img.size));
      }

      // Очень плавное изменение размера
      img.size += img.sizeDirection;
      if (img.size <= 9 || img.size >= 18) {
        img.sizeDirection *= -1;
      }

      img.element.style.width = `${img.size}%`;
      img.element.style.height = `${img.size}%`;
      img.element.style.left = `${img.x}%`;
      img.element.style.top = `${img.y}%`;
    });

    requestAnimationFrame(moveImages);
  }

  function toggleEnlarge(index) {
    if (enlarged === null) {
      enlarged = index;
      const img = images[index];
      img.element.classList.add("enlarged");
      img.element.style.width = "50%"; // Изменено на 50%
      img.element.style.height = "50%"; // Изменено на 50%
      img.element.style.left = "25%"; // Центрирование (100 - 50) / 2
      img.element.style.top = "25%";
      itemNameDisplay.textContent = imageNames[index];

      images.forEach((otherImg, otherIndex) => {
        if (otherIndex !== index) {
          otherImg.element.style.opacity = "0";
        }
      });
    } else {
      const img = images[enlarged];
      img.element.classList.remove("enlarged");
      img.element.style.width = `${img.size}%`;
      img.element.style.height = `${img.size}%`;
      img.element.style.left = `${img.x}%`;
      img.element.style.top = `${img.y}%`;
      itemNameDisplay.textContent = "";

      images.forEach((otherImg) => {
        otherImg.element.style.opacity = "1";
      });

      enlarged = null;
    }
  }

  for (let i = 0; i < numImages; i++) {
    createImage(i);
  }

  moveImages();
}

// LUGGAGE

function initializeLuggageScript() {
  const leftContainer = document.querySelector(".luggage-container.left");
  const rightContainer = document.querySelector(".luggage-container.right");
  const switchLeftBtn = document.getElementById("luggage-left");
  const switchRightBtn = document.getElementById("luggage-right");
  const cells = document.querySelectorAll(".cell");
  const switcher = document.querySelector(".switcher");
  const itemLuggageName = document.querySelector(".item-luggage-name");
  const uploadButton = document.querySelector(".upload-button"); // Select upload button

  if (!leftContainer || !rightContainer) {
    console.error("Containers not found");
    return;
  }

  function switchToLeftContainer() {
    leftContainer.style.transform = "translateY(-50%) translateX(-50%)";
    rightContainer.style.transform = "translateY(-50%) translateX(0%)";
    switchRightBtn.classList.remove("luggage-switch-now");
    switchLeftBtn.classList.add("luggage-switch-now");
  }

  function switchToRightContainer() {
    leftContainer.style.transform =
      "translateY(-50%) translateX(calc(-150% - 80px))";
    rightContainer.style.transform =
      "translateY(-50%) translateX(calc(-100% - 80px))";
    switchLeftBtn.classList.remove("luggage-switch-now");
    switchRightBtn.classList.add("luggage-switch-now");
  }

  switchLeftBtn.addEventListener("click", function (event) {
    event.preventDefault();
    switchToLeftContainer();
  });

  switchRightBtn.addEventListener("click", function (event) {
    event.preventDefault();
    switchToRightContainer();
  });

  cells.forEach((cell) => {
    cell.addEventListener("click", function (event) {
      event.stopPropagation();
      const container = cell.closest(".luggage-container");
      container.classList.add("hide-cells");
      uploadButton.classList.add("hide-upload-button"); // Hide upload button

      const img = cell.querySelector("img");
      const enlargedImg = img.cloneNode(true);
      const itemName = img.getAttribute("data-item-name");

      enlargedImg.classList.add("enlarged-img");
      enlargedImg.style.filter = "blur(15px)";
      enlargedImg.style.opacity = "0";
      container.appendChild(enlargedImg);

      // Hide switcher and show item name
      switcher.style.display = "none";
      itemLuggageName.textContent = itemName;
      itemLuggageName.style.display = "block";

      requestAnimationFrame(() => {
        enlargedImg.style.filter = "blur(0px) drop-shadow(0 0 2px white)";
        enlargedImg.style.opacity = "1";
      });

      container.addEventListener(
        "click",
        function () {
          enlargedImg.style.filter = "blur(15px)";
          enlargedImg.style.opacity = "0";

          setTimeout(() => {
            enlargedImg.remove();
            container.classList.remove("hide-cells");
            uploadButton.classList.remove("hide-upload-button"); // Show upload button again

            // Show switcher and hide item name
            switcher.style.display = "block";
            itemLuggageName.style.display = "none";
          }, 500);
        },
        { once: true }
      );
    });
  });

  const fileInput = document.getElementById("file-input");
  const uploadedImg = document.getElementById("uploaded-img");

  uploadButton.addEventListener("click", function () {
    fileInput.click();
  });

  fileInput.addEventListener("change", function () {
    if (this.files && this.files[0]) {
      const file = this.files[0];
      const allowedTypes = [
        "image/jpeg",
        "image/jpg",
        "image/png",
        "image/gif",
        "image/heic",
      ];
      const maxSize = 0.5 * 1024 * 1024;

      if (!allowedTypes.includes(file.type)) {
        alert("Only JPEG, PNG, GIF and HEIC formats are accepted");
        return;
      }

      if (file.size > maxSize) {
        alert("Max size of the file is 0.5 MB");
        return;
      }

      const formData = new FormData();
      formData.append("file", file);

      fetch("https://nohome.cloud/wp-content/themes/blankslate/upload.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((result) => {
          if (result.status === "success") {
            // Обновляем изображение
            uploadedImg.src = result.path;
            alert(result.message);
          } else {
            alert(result.message);
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("Error uploading file");
        });
    }
  });
}

// IPHONE

function initializeIphoneScript() {
  const lockscreen = document.querySelector(".lockscreen");
  const passScreen = document.querySelector(".pass-screen");
  const appsScreen = document.querySelector(".apps-screen");
  const stars = document.querySelectorAll(".stars path");
  const clickables = document.querySelectorAll(".pass-numbers .clickable");
  const cancelButton = document.querySelector("#pass-screen-cancel");

  let currentStar = 0;
  let leftEmojiTimeout, rightEmojiTimeout;

  function resetStars() {
    stars.forEach((star) => (star.style.fill = "none"));
    currentStar = 0;
  }

  function fadeTransition(hideScreen, showScreen, duration = 500) {
    hideScreen.style.opacity = "1";
    showScreen.style.opacity = "0";
    showScreen.style.display = "block";

    let start = null;
    function step(timestamp) {
      if (!start) start = timestamp;
      const progress = timestamp - start;
      const ratio = Math.min(progress / duration, 1);

      hideScreen.style.opacity = String(1 - ratio);
      showScreen.style.opacity = String(ratio);

      if (progress < duration) {
        window.requestAnimationFrame(step);
      } else {
        hideScreen.style.display = "none";
      }
    }
    window.requestAnimationFrame(step);
  }

  clickables.forEach((clickable) => {
    clickable.addEventListener("click", function () {
      if (currentStar < stars.length) {
        stars[currentStar].style.fill = "#E7E7E7";
        currentStar++;

        if (currentStar === stars.length) {
          setTimeout(() => {
            fadeTransition(passScreen, appsScreen);
            resetStars();
          }, 500);
        }
      }
    });
  });

  cancelButton.addEventListener("click", function () {
    fadeTransition(passScreen, lockscreen);
    resetStars();
  });

  const notification = document.getElementById("notification");
  notification.addEventListener("click", function () {
    fadeTransition(lockscreen, passScreen);
  });

  const videos = document.querySelectorAll(".image-container video");

  videos.forEach((video) => {
    video.addEventListener("loadedmetadata", () => {
      video.currentTime = 0;
    });

    video.addEventListener("click", (event) => {
      event.stopPropagation();
      if (video.paused) {
        video.currentTime = 0;
        video.play();
        video.addEventListener(
          "ended",
          () => {
            video.currentTime = 0;
          },
          { once: true }
        );
      } else {
        video.pause();
        video.currentTime = 0;
      }
    });
  });

  function updateDateTime() {
    const now = new Date();
    const dateOptions = {
      weekday: "long",
      day: "numeric",
      month: "long",
    };
    const dateString = now.toLocaleDateString("en-GB", dateOptions);

    const timeOptions = {
      hour: "2-digit",
      minute: "2-digit",
      hour12: false,
    };
    const timeString = now.toLocaleTimeString("en-GB", timeOptions);

    document.getElementById("date").innerHTML = dateString;
    document.getElementById("time").innerHTML = timeString;
  }

  setInterval(updateDateTime, 30000);
  updateDateTime();

  function showEmoji(emojiToShow, emojiToHide, timeoutVarToClear) {
    if (emojiToHide.style.display === "flex") {
      emojiToHide.style.animation = "scaleDown 0.5s forwards";
      clearTimeout(timeoutVarToClear);
      setTimeout(() => {
        emojiToHide.style.display = "none";
      }, 500);
    }

    emojiToShow.style.display = "flex";
    emojiToShow.style.animation = "scaleUp 0.5s forwards";

    return setTimeout(() => {
      emojiToShow.style.animation = "scaleDown 0.5s forwards";
      setTimeout(() => {
        emojiToShow.style.display = "none";
      }, 500);
    }, 9000);
  }

  document
    .getElementById("lockscreen-left")
    .addEventListener("click", function () {
      clearTimeout(leftEmojiTimeout);
      leftEmojiTimeout = showEmoji(
        document.querySelector(".left-emoji"),
        document.querySelector(".right-emoji"),
        rightEmojiTimeout
      );
    });

  document
    .getElementById("lockscreen-right")
    .addEventListener("click", function () {
      clearTimeout(rightEmojiTimeout);
      rightEmojiTimeout = showEmoji(
        document.querySelector(".right-emoji"),
        document.querySelector(".left-emoji"),
        leftEmojiTimeout
      );
    });

  setTimeout(function () {
    let sound = document.getElementById("notification-sound");
    if (sound) {
      sound.play().catch(error => {
        // Игнорируем ошибку автовоспроизведения - это нормально для браузеров
        // console.log('Sound autoplay blocked:', error);
      });
    }

    let notification = document.querySelector(".iphone-notification");
    if (notification) {
      notification.style.display = "block";
    }

    setTimeout(function () {
      notification.classList.add("notification");
    }, 10);
  }, 2500);

  const emojiImg = document.getElementById("emoji-img");
  const emojiRange = document.getElementById("emoji-range");

  emojiRange.addEventListener("input", function () {
    const value = parseInt(emojiRange.value) + 1;
    emojiImg.src = `https://nohome.cloud/wp-content/themes/blankslate/files/items/iphone/emoji/${value}.png`;
  });

  const passScreenEmergency = document.getElementById("pass-screen-emergency");
  const stickerInfoI = document.querySelector(".sticker-info-i");
  const navBottom = document.querySelector(".nav-bottom");
  const stickerInfoNextI = document.querySelector(".sticker-info-next-i");
  const stickerInfoPrevI = document.querySelector(".sticker-info-prev-i");
  const stickerInfoImg1 = document.querySelector(".sticker-info-img-1");
  const stickerInfoImg2 = document.querySelector(".sticker-info-img-2");
  const stickerInfoExitI = document.querySelector(".sticker-info-exit-i");

  function fadeIn(element, duration) {
    element.style.display = "block";
    element.style.opacity = 0;
    let start = null;
    function step(timestamp) {
      if (!start) start = timestamp;
      const progress = timestamp - start;
      element.style.opacity = Math.min(progress / duration, 1);
      if (progress < duration) {
        window.requestAnimationFrame(step);
      }
    }
    window.requestAnimationFrame(step);
  }

  function fadeOut(element, duration) {
    let start = null;
    function step(timestamp) {
      if (!start) start = timestamp;
      const progress = timestamp - start;
      element.style.opacity = Math.max(1 - progress / duration, 0);
      if (progress < duration) {
        window.requestAnimationFrame(step);
      } else {
        element.style.display = "none";
      }
    }
    window.requestAnimationFrame(step);
  }

  function crossFade(fadeOutElement, fadeInElement, duration) {
    let start = null;
    function step(timestamp) {
      if (!start) start = timestamp;
      const progress = timestamp - start;
      const ratio = progress / duration;
      fadeOutElement.style.opacity = Math.max(1 - ratio, 0);
      fadeInElement.style.opacity = Math.min(ratio, 1);
      if (progress < duration) {
        window.requestAnimationFrame(step);
      }
    }
    window.requestAnimationFrame(step);
  }

  passScreenEmergency.addEventListener("click", () => {
    fadeIn(stickerInfoI, 1000);
    navBottom.style.display = "none";
  });

  stickerInfoNextI.addEventListener("click", () => {
    crossFade(stickerInfoImg1, stickerInfoImg2, 1000);
    stickerInfoNextI.style.display = "none";
    stickerInfoPrevI.style.display = "block";
  });

  stickerInfoPrevI.addEventListener("click", () => {
    crossFade(stickerInfoImg2, stickerInfoImg1, 1000);
    stickerInfoPrevI.style.display = "none";
    stickerInfoNextI.style.display = "block";
  });

  stickerInfoExitI.addEventListener("click", () => {
    fadeOut(stickerInfoI, 1000);
    setTimeout(() => {
      stickerInfoI.style.display = "none";
      navBottom.style.display = "block";
    }, 1000);
  });
}

// DOCUMENTS

function initializeDocumentsScript() {
  const pages = document.querySelectorAll(".diary-page");
  const prevButtons = document.querySelectorAll(".page-prev, .diary-page-prev");
  const nextButtons = document.querySelectorAll(".page-next, .diary-page-next");
  let currentPage = 0;

  function showPage(index) {
    pages.forEach((page, i) => {
      if (i === index) {
        page.style.display = "block";
        setTimeout(() => {
          page.style.opacity = "1";
        }, 50);
      } else {
        page.style.opacity = "0";
        setTimeout(() => {
          page.style.display = "none";
        }, 500);
      }
    });
  }

  function nextPage() {
    currentPage = (currentPage + 1) % pages.length;
    showPage(currentPage);
  }

  function prevPage() {
    currentPage = (currentPage - 1 + pages.length) % pages.length;
    showPage(currentPage);
  }

  nextButtons.forEach((button) => {
    button.addEventListener("click", nextPage);
  });

  prevButtons.forEach((button) => {
    button.addEventListener("click", prevPage);
  });

  // Show the first page on load
  showPage(currentPage);
}

// CAMERA

function initializeCameraScript() {
  const albumContainer = document.getElementById("album-container");
  const switcher = document.querySelector(".number-switcher");
  const itemLuggageName = document.querySelector(".img-number-in-switcher");
  const totalPages = 13;
  const imagesPerPage = 8;
  let currentPage = 1;
  let currentImageIndex = 0;
  let preloadedImages = {};

  // Добавляем стили для анимации
  const style = document.createElement("style");
  style.textContent = `
        @keyframes fadeOutRotate {
            from { transform: rotate(0deg) scale(1); opacity: 1; }
            to { transform: rotate(180deg) scale(0); opacity: 0; }
        }
        @keyframes fadeInRotate {
            from { transform: rotate(-180deg) scale(0); opacity: 0; }
            to { transform: rotate(0deg) scale(1); opacity: 1; }
        }
        .img-cell.fade-out {
            animation: fadeOutRotate 0.5s forwards;
        }
        .img-cell.fade-in {
            animation: fadeInRotate 0.5s forwards;
        }
    `;
  document.head.appendChild(style);

  function preloadNextPage(page) {
    const nextPage = page < totalPages ? page + 1 : 1;
    const startIndex = (nextPage - 1) * imagesPerPage + 1;
    const endIndex = Math.min(startIndex + imagesPerPage - 1, 100);

    for (let i = startIndex; i <= endIndex; i++) {
      const formattedNumber = formatImageNumber(i);
      const img = new Image();
      img.src = `https://nohome.cloud/wp-content/themes/blankslate/files/table-room/camera/${formattedNumber}.jpg`;
      preloadedImages[formattedNumber] = img;
    }
  }

  function createPageButtons() {
    for (let i = 1; i <= totalPages; i++) {
      const button = document.createElement("button");
      button.textContent = i;
      button.classList.add("page-button");
      if (i === 1) button.classList.add("page-now");
      button.addEventListener("click", () => switchToPage(i));
      switcher.appendChild(button);
    }
    updateVisibleButtons();
  }

  function switchToPage(page) {
    const oldCells = albumContainer.querySelectorAll(".img-cell");
    oldCells.forEach((cell) => {
      cell.classList.add("fade-out");
    });

    setTimeout(() => {
      currentPage = page;
      loadImagesForPage(page);
      updatePageButtons();
      updateVisibleButtons();
      preloadNextPage(page);
    }, 500);
  }

  function updateVisibleButtons() {
    const buttons = switcher.querySelectorAll(".page-button");
    buttons.forEach((button, index) => {
      const pageNum = index + 1;
      if (
        pageNum === currentPage - 1 ||
        pageNum === currentPage ||
        pageNum === currentPage + 1
      ) {
        button.style.display = "inline-block";
      } else {
        button.style.display = "none";
      }

      // Особые случаи для первой и последней страницы
      if (currentPage === 1 && pageNum === 2) {
        button.style.display = "inline-block";
      }
      if (currentPage === totalPages && pageNum === totalPages - 1) {
        button.style.display = "inline-block";
      }
    });
  }

  function updatePageButtons() {
    const buttons = switcher.querySelectorAll(".page-button");
    buttons.forEach((button, index) => {
      button.classList.toggle("page-now", index + 1 === currentPage);
    });
  }

  function formatImageNumber(number) {
    return ("00" + number).slice(-5);
  }

  function loadImagesForPage(page) {
    albumContainer.innerHTML = "";
    const startIndex = (page - 1) * imagesPerPage + 1;
    const endIndex = Math.min(startIndex + imagesPerPage - 1, 100);

    for (let i = startIndex; i <= endIndex; i++) {
      const cell = document.createElement("div");
      cell.className = "img-cell fade-in";
      const formattedNumber = formatImageNumber(i);

      let img;
      if (preloadedImages[formattedNumber]) {
        img = preloadedImages[formattedNumber];
        delete preloadedImages[formattedNumber];
      } else {
        img = new Image();
        img.src = `https://nohome.cloud/wp-content/themes/blankslate/files/table-room/camera/${formattedNumber}.jpg`;
      }

      img.alt = `Image ${formattedNumber}`;
      img.dataset.itemName = `${formattedNumber}.jpg`;
      img.dataset.index = i - 1;

      const numberDiv = document.createElement("div");
      numberDiv.className = "img-number";
      numberDiv.textContent = `${formattedNumber}.jpg`;

      cell.appendChild(img);
      cell.appendChild(numberDiv);
      albumContainer.appendChild(cell);
    }

    addImageClickListeners();
  }

  function lazyLoadImages() {
    const images = albumContainer.querySelectorAll("img[data-src]");
    images.forEach((img) => {
      img.src = img.dataset.src;
      img.removeAttribute("data-src");
    });
  }

  function addImageClickListeners() {
    const cells = albumContainer.querySelectorAll(".img-cell");
    cells.forEach((cell) => {
      cell.addEventListener("click", function (event) {
        event.stopPropagation();
        albumContainer.classList.add("hide-img-cells");

        const img = cell.querySelector("img");
        currentImageIndex = parseInt(img.dataset.index);
        showEnlargedImage(currentImageIndex);
      });
    });
  }

  function showEnlargedImage(index) {
    albumContainer.innerHTML = "";
    const enlargedImgContainer = document.createElement("div");
    enlargedImgContainer.classList.add("enlarged-img-container");

    const prevIndex = (index - 1 + 100) % 100;
    const nextIndex = (index + 1) % 100;

    const prevImg = createSideImage(prevIndex, "side-img-left");
    const mainImg = createMainImage(index);
    const nextImg = createSideImage(nextIndex, "side-img-right");

    enlargedImgContainer.appendChild(prevImg);
    enlargedImgContainer.appendChild(mainImg);
    enlargedImgContainer.appendChild(nextImg);

    albumContainer.appendChild(enlargedImgContainer);

    switcher.style.display = "none";
    itemLuggageName.textContent = mainImg.dataset.itemName;
    itemLuggageName.style.display = "block";

    addEnlargedImageListeners(enlargedImgContainer);
  }

  function updateEnlargedImage(container, direction) {
    const prevIndex = (currentImageIndex - 1 + 100) % 100;
    const nextIndex = (currentImageIndex + 1) % 100;

    const newPrevImg = createSideImage(prevIndex, "side-img-left");
    const newMainImg = createMainImage(currentImageIndex);
    const newNextImg = createSideImage(nextIndex, "side-img-right");

    container.innerHTML = "";
    container.appendChild(newPrevImg);
    container.appendChild(newMainImg);
    container.appendChild(newNextImg);

    if (direction === "left") {
      newPrevImg.classList.add("slide-from-left");
    } else {
      newNextImg.classList.add("slide-from-right");
    }

    itemLuggageName.textContent = newMainImg.dataset.itemName;
    addEnlargedImageListeners(container);
  }

  function createSideImage(index, className) {
    const img = document.createElement("img");
    const formattedNumber = formatImageNumber(index + 1);
    img.src = `https://nohome.cloud/wp-content/themes/blankslate/files/table-room/camera/${formattedNumber}.jpg`;
    img.alt = `Image ${formattedNumber}`;
    img.dataset.itemName = `${formattedNumber}.jpg`;
    img.dataset.index = index;
    img.classList.add("side-img", className);
    return img;
  }

  function createMainImage(index) {
    const img = document.createElement("img");
    const formattedNumber = formatImageNumber(index + 1);
    img.src = `https://nohome.cloud/wp-content/themes/blankslate/files/table-room/camera/${formattedNumber}.jpg`;
    img.alt = `Image ${formattedNumber}`;
    img.dataset.itemName = `${formattedNumber}.jpg`;
    img.dataset.index = index;
    img.classList.add("enlarged-img");
    return img;
  }

  function addEnlargedImageListeners(container) {
    const leftArrow = container.querySelector(".side-img-left");
    const rightArrow = container.querySelector(".side-img-right");
    const mainImg = container.querySelector(".enlarged-img");

    leftArrow.addEventListener("click", (event) => {
      event.stopPropagation();
      navigateImages("left");
    });

    rightArrow.addEventListener("click", (event) => {
      event.stopPropagation();
      navigateImages("right");
    });

    mainImg.addEventListener("click", closeEnlargedImage);
    container.addEventListener("click", closeEnlargedImage);
    document.addEventListener("keydown", handleKeyPress);
  }

  function navigateImages(direction) {
    const currentImg = albumContainer.querySelector(".enlarged-img");
    currentImg.classList.add("slide-out");

    setTimeout(() => {
      if (direction === "left") {
        currentImageIndex = (currentImageIndex - 1 + 100) % 100;
      } else {
        currentImageIndex = (currentImageIndex + 1) % 100;
      }
      showEnlargedImage(currentImageIndex);
      const newImg = albumContainer.querySelector(".enlarged-img");
      newImg.classList.add("slide-in");
    }, 300);
  }

  function handleKeyPress(event) {
    if (event.key === "ArrowLeft") {
      navigateImages("left");
    } else if (event.key === "ArrowRight") {
      navigateImages("right");
    } else if (event.key === "Escape") {
      closeEnlargedImage();
    }
  }

  function closeEnlargedImage() {
    document.removeEventListener("keydown", handleKeyPress);
    albumContainer.innerHTML = "";
    albumContainer.classList.remove("hide-img-cells");
    switcher.style.display = "block";
    itemLuggageName.style.display = "none";
    loadImagesForPage(currentPage);
  }

  document.querySelector(".nav-arrow-left").addEventListener("click", () => {
    if (albumContainer.classList.contains("hide-img-cells")) {
      navigateImages("left");
    } else {
      switchToPage(Math.max(1, currentPage - 1));
    }
  });

  document.querySelector(".nav-arrow-right").addEventListener("click", () => {
    if (albumContainer.classList.contains("hide-img-cells")) {
      navigateImages("right");
    } else {
      switchToPage(Math.min(totalPages, currentPage + 1));
    }
  });

  createPageButtons();
  switchToPage(1);
  preloadNextPage(1);
}

// MP3

// Инициализация скрипта для MP3
function initializeMp3Script() {
  // Глобальные переменные
  let currentSide = 1;
  let currentTrack = null;
  let isPlaying = false;
  let isRandom = false;
  let originalOrder = [];
  let repeatSong = false;
  let isFirstPlay = true;

  // Функция для рандомного перемешивания
  function shufflePlaylist() {
    const tracks = Array.from(
      document.querySelectorAll(`audio[data-side="${currentSide}"]`)
    );
    if (!isRandom) {
      originalOrder = tracks.map((track) => track.dataset.order);
      tracks.forEach(
        (track) =>
          (track.dataset.order = Math.floor(Math.random() * tracks.length) + 1)
      );
      document.querySelector(".random").style.opacity = "100%";
      document.querySelector(".random").style.textShadow = "0 0 9px #b0b0b0";
    } else {
      tracks.forEach(
        (track, index) => (track.dataset.order = originalOrder[index])
      );
      document.querySelector(".random").style.opacity = "50%";
      document.querySelector(".random").style.textShadow = "none";
    }
    isRandom = !isRandom;
    document
      .querySelector(".player-random")
      .classList.toggle("active", isRandom);
    updatePlaylistDisplay();
  }

  document.querySelector(".random").addEventListener("click", shufflePlaylist);

  function toggleRepeatSong() {
    repeatSong = !repeatSong;
    if (currentTrack) currentTrack.loop = repeatSong;
    document.querySelector(".repeat-song").style.opacity = repeatSong
      ? "100%"
      : "50%";
    document.querySelector(".repeat-song").style.textShadow = repeatSong
      ? "0 0 9px #b0b0b0"
      : "none";
    document
      .querySelector(".player-repeat")
      .classList.toggle("active", repeatSong);
  }

  document
    .querySelector(".repeat-song")
    .addEventListener("click", toggleRepeatSong);

  // Функция для переключения между сторонами
  function toggleSide() {
    const spinningWrapper = document.querySelector(".spinning-sides-wrapper");
    const diskWrapper = document.querySelector(".disk-wrapper");
    const timeChangerWrapper = document.querySelector(".time-changer");
    const progressCircl = document.querySelector(".pc-wrapper");
    const side1Elements = document.querySelectorAll(
      ".song-next.side-1, .now-playing-wrapper.side-1, .now-playing-hashtag.side-1"
    );
    const side2Elements = document.querySelectorAll(
      ".song-next.side-2, .now-playing-wrapper.side-2, .now-playing-hashtag.side-2"
    );
    const invertedElements = document.querySelectorAll(
      ".mp3-wrapper, .disk-wrapper, .nav-items"
    );

    currentSide = currentSide === 1 ? 2 : 1;

    const rotation = currentSide === 2 ? 180 : 0;
    spinningWrapper.style.transform = `rotateY(${rotation}deg)`;
    diskWrapper.style.transform = `rotateY(-${rotation}deg)`;
    timeChangerWrapper.style.transform = `rotateY(-${rotation}deg)`;
    progressCircl.style.transform = `rotateY(-${rotation}deg)`;

    side1Elements.forEach(
      (el) => (el.style.filter = currentSide === 1 ? "blur(0px)" : "blur(3px)")
    );
    side2Elements.forEach(
      (el) => (el.style.filter = currentSide === 2 ? "blur(0px)" : "blur(3px)")
    );
    invertedElements.forEach(
      (el) => (el.style.filter = currentSide === 2 ? "invert(1)" : "invert(0)")
    );

    [spinningWrapper, diskWrapper, timeChangerWrapper, progressCircl].forEach(
      (el) => {
        el.style.transition = "transform 2s";
      }
    );

    updatePlaylistDisplay();
    updateDisplay();
  }

  /**
   * ЛОГИКА ПУЛЬТА/ПЛЕЕРА - ДОКУМЕНТАЦИЯ
   * 
   * Пульт (horse indicator) имеет два режима отображения:
   * 1. display-normal - обычный режим с текстом подсказок
   * 2. display-player - режим плеера с информацией о треке
   * 
   * ПРАВИЛЬНАЯ ЛОГИКА:
   * - Когда музыка НЕ играет → показываем display-normal (обычный пульт с текстом)
   * - Когда музыка играет → показываем display-player (плеер с треком)
   * 
   * УПРАВЛЕНИЕ:
   * - Кнопка display-button только показывает/скрывает весь пульт
   * - Режим переключается автоматически при play/stop музыки
   * - В режиме плеера кнопки left/right переключают стороны (SIDE I/II)
   */
  function updateDisplay() {
    const displayNormal = document.querySelector(".display-normal");
    const displayPlayer = document.querySelector(".display-player");
    const horseIndicatorSide = document.querySelector(".horse-indicator-side");
    const horseIndicatorSongNow = document.querySelector(
      ".horse-indicator-song-now"
    );
    const horseIndicatorSongTime = document.querySelector(
      ".horse-indicator-song-time"
    );
    const horseIndicatorSongHashtag = document.querySelector(
      ".horse-indicator-song-hashtag"
    );

    if (isPlaying && currentTrack) {
      // ИСПРАВЛЕНО: Когда играет музыка → показываем плеер
      displayNormal.style.display = "none";
      displayPlayer.style.display = "block";

      horseIndicatorSide.textContent = `SIDE ${currentSide === 1 ? "I" : "II"}`;
      horseIndicatorSongNow.textContent = currentTrack.dataset.songName;
      horseIndicatorSongTime.textContent = formatTime(
        currentTrack.duration - currentTrack.currentTime
      );
      horseIndicatorSongHashtag.textContent = currentTrack.dataset.songHashtag;
    } else {
      // ИСПРАВЛЕНО: Когда музыка НЕ играет → показываем обычный режим
      displayNormal.style.display = "block";
      displayPlayer.style.display = "none";
    }

    // Update button states
    document
      .querySelector(".player-random")
      .classList.toggle("active", isRandom);
    document
      .querySelector(".player-repeat")
      .classList.toggle("active", repeatSong);
    document
      .querySelector(".player-stop-play")
      .classList.toggle("playing", isPlaying);
  }

  function updatePlaylistDisplay(isTrackChange = false) {
    const tracks = Array.from(
      document.querySelectorAll(`audio[data-side="${currentSide}"]`)
    ).sort((a, b) => parseInt(a.dataset.order) - parseInt(b.dataset.order));
    let startIndex = currentTrack
      ? parseInt(currentTrack.dataset.order) % 5
      : 5;

    // Применяем анимацию блюра только при смене трека
    if (isTrackChange) {
      const elementsToUpdate = document.querySelectorAll(
        `.song-next-title.side-${currentSide}, .song-next-time.side-${currentSide}, .now-playing-wrapper.side-${currentSide}, .now-playing-hashtag.side-${currentSide}, .song-next.side-${currentSide}`
      );
      elementsToUpdate.forEach((el) => {
        el.classList.add("transition-blur");
        el.classList.add("blurred");
      });
    }

    setTimeout(
      () => {
        for (let i = 0; i < 4; i++) {
          const trackIndex = (startIndex + i) % 5;
          const track = tracks[trackIndex];
          const nextTitle = document.querySelector(
            `.song-${i + 1}-next-title.side-${currentSide}`
          );
          const nextTime = document.querySelector(
            `.song-${i + 1}-next-time.side-${currentSide}`
          );

          if (track) {
            nextTitle.textContent = track.dataset.songName;
            nextTime.textContent = formatTime(track.duration);
            nextTitle.dataset.order = track.dataset.order;
            nextTime.dataset.order = track.dataset.order;
          } else {
            nextTitle.textContent = "?????????";
            nextTime.textContent = "00:00";
            nextTitle.dataset.order = "";
            nextTime.dataset.order = "";
          }
        }

        const playingTitle = document.querySelector(
          `.song-playing-title.side-${currentSide}`
        );
        const playingTime = document.querySelector(
          `.song-playing-time.side-${currentSide}`
        );
        const nowPlayingTitle = document.querySelector(
          `.now-playing-title.side-${currentSide}`
        );
        const nowPlayingTime = document.querySelector(
          `.now-playing-time.side-${currentSide}`
        );
        const nowPlayingHashtag = document.querySelector(
          `.now-playing-hashtag.side-${currentSide}`
        );

        if (currentTrack && currentTrack.dataset.side == currentSide) {
          playingTitle.textContent = currentTrack.dataset.songName;
          playingTime.textContent = formatTime(
            currentTrack.duration - currentTrack.currentTime
          );
          nowPlayingTitle.textContent = currentTrack.dataset.songName;
          nowPlayingTime.textContent = formatTime(
            currentTrack.duration - currentTrack.currentTime
          );
          nowPlayingHashtag.textContent = currentTrack.dataset.songHashtag;
          document.querySelector(
            `.song-playing.side-${currentSide}`
          ).style.filter = "blur(1px)";
        } else {
          const lastTrack = tracks[4];
          playingTitle.textContent = lastTrack.dataset.songName;
          playingTime.textContent = formatTime(lastTrack.duration);
          nowPlayingTitle.textContent = "?????????";
          nowPlayingTime.textContent = "00:00";
          nowPlayingHashtag.textContent = "#TAGTAGTAG";
          document.querySelector(
            `.song-playing.side-${currentSide}`
          ).style.filter = "none";
        }

        // Убираем блюр только если была смена трека
        if (isTrackChange) {
          setTimeout(() => {
            const elementsToUpdate = document.querySelectorAll(
              `.song-next-title.side-${currentSide}, .song-next-time.side-${currentSide}, .now-playing-wrapper.side-${currentSide}, .now-playing-hashtag.side-${currentSide}, .song-next.side-${currentSide}`
            );
            elementsToUpdate.forEach((el) => {
              el.classList.remove("blurred");
            });

            // Удаляем класс transition-blur после завершения анимации
            setTimeout(() => {
              elementsToUpdate.forEach((el) => {
                el.classList.remove("transition-blur");
              });
            }, 500);
          }, 50); // Небольшая задержка перед началом обратной анимации
        }

        updateBackgroundImage();
      },
      isTrackChange ? 500 : 0
    ); // Задержка 500 мс для полного эффекта блюра
  }

  let currentBackgroundSrc = "";

  function updateBackgroundImage() {
    const mp3Player = document.querySelector(".mp3-wrapper");
    let backgroundImg = mp3Player.querySelector(".mp3-background-img");

    if (currentTrack) {
      const newSrc = currentTrack.dataset.mp3BackgroundImg;

      if (newSrc !== currentBackgroundSrc) {
        currentBackgroundSrc = newSrc;

        if (!backgroundImg) {
          const backgroundContainer =
            mp3Player.querySelector(".mp3-background");
          backgroundImg = document.createElement("img");
          backgroundImg.className = "mp3-background-img";
          backgroundImg.alt = "Background";
          backgroundContainer.appendChild(backgroundImg);
        }

        const tempImg = new Image();
        tempImg.onload = () => {
          backgroundImg.style.animation = "fadeOut 750ms ease-in-out";

          setTimeout(() => {
            backgroundImg.src = newSrc;
            backgroundImg.style.opacity = "0";

            setTimeout(() => {
              backgroundImg.style.animation = "fadeIn 750ms ease-in-out";
              backgroundImg.style.opacity = "1";
            }, 300);
          }, 750);
        };

        tempImg.src = newSrc;
      }
    } else if (backgroundImg) {
      backgroundImg.style.animation = "fadeOut 750ms ease-in-out";
      setTimeout(() => {
        backgroundImg.src = "";
        backgroundImg.style.opacity = "0";
        currentBackgroundSrc = "";
      }, 750);
    }
  }

  function formatTime(time) {
    if (isNaN(time)) return "00:00";
    const minutes = Math.floor(time / 60);
    const seconds = Math.floor(time % 60);
    return `${minutes.toString().padStart(2, "0")}:${seconds
      .toString()
      .padStart(2, "0")}`;
  }

  function toggleAnimations(play) {
    const cd = document.querySelector(".cd");
    const ice = document.querySelector(".ice");
    const diskWrapper = document.querySelector(".disk-wrapper");
    const spinningWrapper = document.querySelector(".spinning-sides-wrapper");

    if (play) {
      if (isFirstPlay) {
        diskWrapper.style.animation = "none";
        spinningWrapper.style.animation = "none";
        isFirstPlay = false;
      }
      cd.style.animation = "rotate-cd 60s linear infinite";
      ice.style.animation = "rotate-ice 15s linear infinite";
    } else {
      cd.style.animation = "none";
      ice.style.animation = "none";
    }
  }

  function togglePlayStop() {
    const playStopButton = document.querySelector(".play-stop");

    if (!currentTrack) {
      currentTrack = document.querySelector(
        `audio[data-side="${currentSide}"][data-order="1"]`
      );
    }

    if (isPlaying) {
      currentTrack.pause();
      playStopButton.textContent = "play";
      toggleAnimations(false);
    } else {
      currentTrack.play();
      playStopButton.textContent = "stop";
      toggleAnimations(true);
    }

    isPlaying = !isPlaying;
    updatePlaylistDisplay();
    updateTimeChanger();
    document
      .querySelector(".player-stop-play")
      .classList.toggle("playing", isPlaying);
    updateDisplay();
  }

  let isHovering = false;

  function updateTimeChanger() {
    const timeChanger = document.querySelector(".time-changer");
    const progressCircle = document.querySelector(".progress-circle");

    if (currentTrack && isPlaying) {
      const progress = (currentTrack.currentTime / currentTrack.duration) * 100;
      const angle = (progress / 100) * 2 * Math.PI;

      timeChanger.style.background = `conic-gradient(rgb(212, 35, 24) ${progress}%, rgba(255,255,255,0.3) ${progress}%)`;

      const radius = timeChanger.offsetWidth / 2 - 3;
      const x = Math.sin(angle) * radius;
      const y = -Math.cos(angle) * radius;
      progressCircle.style.transform = `translate(calc(-50% + ${x}px), calc(-50% + ${y}px))`;

      progressCircle.style.opacity = isHovering ? "1" : "0";
    } else {
      timeChanger.style.background = "none";
      progressCircle.style.opacity = "0";
    }
  }

  function seekTrack(event) {
    if (currentTrack && isPlaying) {
      const timeChanger = document.querySelector(".time-changer");
      const rect = timeChanger.getBoundingClientRect();
      const center = {
        x: rect.left + rect.width / 2,
        y: rect.top + rect.height / 2,
      };

      let angle = Math.atan2(
        event.clientY - center.y,
        event.clientX - center.x
      );
      angle += Math.PI / 2;
      angle = angle % (2 * Math.PI);
      if (angle < 0) {
        angle += 2 * Math.PI;
      }

      const progress = angle / (2 * Math.PI);
      currentTrack.currentTime = progress * currentTrack.duration;
      updateTimeChanger();
    }
  }

  function playNextTrack() {
    if (currentTrack) {
      const nextOrder = (parseInt(currentTrack.dataset.order) % 5) + 1;
      const nextTrack = document.querySelector(
        `audio[data-side="${currentSide}"][data-order="${nextOrder}"]`
      );

      if (nextTrack) {
        currentTrack.pause();
        currentTrack.currentTime = 0;
        currentTrack = nextTrack;
        currentTrack.play();
        isPlaying = true;
        document.querySelector(".play-stop").textContent = "stop";
        updatePlaylistDisplay(true); // Передаем флаг, указывающий на смену трека
        checkOverflow(); // Проверяем переполнение текста после смены трека
        updateDisplay();
      }
    }
  }

  function playPreviousTrack() {
    if (currentTrack) {
      const prevOrder =
        ((parseInt(currentTrack.dataset.order) - 2 + 5) % 5) + 1;
      const prevTrack = document.querySelector(
        `audio[data-side="${currentSide}"][data-order="${prevOrder}"]`
      );

      if (prevTrack) {
        currentTrack.pause();
        currentTrack.currentTime = 0;
        currentTrack = prevTrack;
        currentTrack.play();
        isPlaying = true;
        document.querySelector(".play-stop").textContent = "stop";
        updatePlaylistDisplay(true); // Передаем флаг, указывающий на смену трека
        checkOverflow(); // Проверяем переполнение текста после смены трека
        updateDisplay();
      }
    }
  }

  // Привязка функций к новым кнопкам
  document
    .querySelector(".player-random")
    .addEventListener("click", shufflePlaylist);
  document
    .querySelector(".player-previous")
    .addEventListener("click", playPreviousTrack);
  document
    .querySelector(".player-stop-play")
    .addEventListener("click", togglePlayStop);
  document
    .querySelector(".player-next")
    .addEventListener("click", playNextTrack);
  document
    .querySelector(".player-repeat")
    .addEventListener("click", toggleRepeatSong);

  document.querySelector(".time-changer").addEventListener("mouseenter", () => {
    isHovering = true;
    updateTimeChanger();
  });

  document.querySelector(".time-changer").addEventListener("mouseleave", () => {
    isHovering = false;
    updateTimeChanger();
  });

  document.querySelector(".time-changer").addEventListener("mousedown", (e) => {
    seekTrack(e);
    document.addEventListener("mousemove", seekTrack);
  });

  document.addEventListener("mouseup", () => {
    document.removeEventListener("mousemove", seekTrack);
  });

  function playTrack(order) {
    const track = document.querySelector(
      `audio[data-side="${currentSide}"][data-order="${order}"]`
    );
    if (track) {
      if (currentTrack) {
        currentTrack.pause();
        currentTrack.currentTime = 0;
      }
      currentTrack = track;
      currentTrack.play();
      isPlaying = true;
      document.querySelector(".play-stop").textContent = "stop";
      toggleAnimations(true);
      updatePlaylistDisplay(true); // Передаем флаг, указывающий на смену трека
      updateTimeChanger();
      checkOverflow(); // Проверяем переполнение текста после смены трека
    }
  }

  document.querySelector(".block-side-1").addEventListener("click", () => {
    if (currentSide === 2) toggleSide();
  });

  document.querySelector(".block-side-2").addEventListener("click", () => {
    if (currentSide === 1) toggleSide();
  });

  document
    .querySelector(".play-stop")
    .addEventListener("click", togglePlayStop);
  document
    .querySelector(".previous-song")
    .addEventListener("click", playPreviousTrack);
  document.querySelector(".next-song").addEventListener("click", playNextTrack);

  // Обработчики для клика на элементы плейлиста
  for (let i = 1; i <= 4; i++) {
    ["side-1", "side-2"].forEach((side) => {
      document
        .querySelector(`.song-${i}-next-title.${side}`)
        .addEventListener("click", function () {
          playTrack(this.dataset.order);
        });
      document
        .querySelector(`.song-${i}-next-time.${side}`)
        .addEventListener("click", function () {
          playTrack(this.dataset.order);
        });
    });
  }

  // Обновляем обработчик окончания трека
  document.querySelectorAll("audio").forEach((audio) => {
    audio.addEventListener("ended", () => {
      if (!repeatSong) {
        playNextTrack();
      } else {
        audio.play();
      }
      toggleAnimations(true);
      checkOverflow(); // Проверяем переполнение текста после окончания трека
    });
    audio.addEventListener("timeupdate", () => {
      updatePlaylistDisplay();
      updateTimeChanger();
      updateDisplay();
    });
    audio.addEventListener("loadedmetadata", () => {
      updatePlaylistDisplay();
      checkOverflow(); // Проверяем переполнение текста после загрузки метаданных
    });
  });

  // Добавляем стили для анимаций
  const style = document.createElement("style");
  style.textContent = `
    @keyframes rotate-cd {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    @keyframes rotate-ice {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
`;
  document.head.appendChild(style);

  // Функция для проверки переполнения текста
  function checkOverflow() {
    const containers = document.querySelectorAll(".marquee-container");

    containers.forEach((container) => {
      const content = container.querySelector(".marquee-content");

      if (content.scrollWidth > container.clientWidth) {
        content.classList.add("marquee-animate");
      } else {
        content.classList.remove("marquee-animate");
      }
    });
  }

  // Инициализация
  document.addEventListener("DOMContentLoaded", () => {
    updatePlaylistDisplay();
    updateTimeChanger();
    checkOverflow();
    updateDisplay();
  });

  // Проверяем при изменении размера окна
  window.addEventListener("resize", checkOverflow);
  setInterval(checkOverflow, 5000);
}

// Назначаем обработчики кликов на каждый nav-item
document
  .getElementById("backpack-content")
  .addEventListener("click", function (event) {
    event.preventDefault();
    loadContent("backpack-content", initializeBackpackScript);
  });

document
  .getElementById("luggage-content")
  .addEventListener("click", function (event) {
    event.preventDefault();
    loadContent("luggage-content", initializeLuggageScript);
  });

document
  .getElementById("iphone-content")
  .addEventListener("click", function (event) {
    event.preventDefault();
    loadContent("iphone-content", initializeIphoneScript);
  });

document
  .getElementById("documents-content")
  .addEventListener("click", function (event) {
    event.preventDefault();
    loadContent("documents-content", initializeDocumentsScript);
  });

document
  .getElementById("camera-content")
  .addEventListener("click", function (event) {
    event.preventDefault();
    loadContent("camera-content", initializeCameraScript);
  });

document
  .getElementById("mp3-content")
  .addEventListener("click", function (event) {
    event.preventDefault();
    loadContent("mp3-content", initializeMp3Script);
  });
