//////////////// ОБНОВЛЕНИЕ СТРАНИЦЫ БЕЗ ПЕРЕЗАГРУЗКИ

// Функция для добавления import map
function addImportMap(content) {
  var importMapMatch = content.match(
    /<script\s+type=["']importmap["']>([\s\S]*?)<\/script>/i
  );
  if (importMapMatch) {
    var existingImportMap = document.querySelector('script[type="importmap"]');
    if (existingImportMap) {
      existingImportMap.remove();
    }
    var importMapScript = document.createElement("script");
    importMapScript.type = "importmap";
    importMapScript.textContent = importMapMatch[1];
    document.head.appendChild(importMapScript);
  }
}

// Функция для добавления скрипта
function addScript(scriptElement) {
  return new Promise((resolve, reject) => {
    var newScript = document.createElement("script");

    if (scriptElement.src) {
      newScript.src = scriptElement.src;
      newScript.onload = resolve;
      newScript.onerror = reject;
    } else {
      newScript.textContent = scriptElement.textContent;
    }

    if (scriptElement.type === "module") {
      newScript.type = "module";
      document.body.appendChild(newScript);
      resolve();
    } else {
      if (!scriptElement.src) {
        try {
          new Function(scriptElement.textContent)();
          resolve();
        } catch (error) {
          reject(error);
        }
      } else {
        document.body.appendChild(newScript);
      }
    }
  });
}

// Объект для хранения функций деактивации
const deactivateFunctions = {
  initializeGolden: null,
  initializeBedroomInteractions: null,
  initializeCave: null,
  initializeTable: null,
  initializeAttic: null,
};

// Переменная для отслеживания текущей активной страницы
let currentActivePage = null;

// Функция для деактивации предыдущего скрипта
function deactivatePreviousScript() {
  if (currentActivePage && deactivateFunctions[currentActivePage]) {
    try {
      deactivateFunctions[currentActivePage]();
    } catch (error) {
      // Error handling
    }
    deactivateFunctions[currentActivePage] = null;
  }
  currentActivePage = null;
}

// Модифицированные функции инициализации
const initializeFunctions = {
  mgolden: () => initializeAndSetDeactivation("initializeGolden"),
  mbed: () => initializeAndSetDeactivation("initializeBedroomInteractions"),
  mcave: () => initializeAndSetDeactivation("initializeCave"),
  mtable: () => initializeAndSetDeactivation("initializeTable"),
  mattic: () => initializeAndSetDeactivation("initializeAttic"),
};

// Общая функция для инициализации и установки функции деактивации
function initializeAndSetDeactivation(functionName) {
  deactivatePreviousScript();
  if (typeof window[functionName] === "function") {
    const deactivate = window[functionName]();
    if (typeof deactivate === "function") {
      deactivateFunctions[functionName] = deactivate;
      currentActivePage = functionName;
    }
  }
}

// Пример реализации одной из функций инициализации (остальные должны быть реализованы аналогично)
window.initializeCave = function () {
  const someEventListener = () => {
    // Event handling
  };
  document.addEventListener("someEvent", someEventListener);

  return function deactivate() {
    document.removeEventListener("someEvent", someEventListener);
  };
};

window.initializeGolden = function () {
  const someEventListener = () => {
    // Event handling
  };
  document.addEventListener("someEvent", someEventListener);

  return function deactivate() {
    document.removeEventListener("someEvent", someEventListener);
  };
};

window.initializeTable = function () {
  const someEventListener = () => {
    // Event handling
  };
  document.addEventListener("someEvent", someEventListener);

  return function deactivate() {
    document.removeEventListener("someEvent", someEventListener);
  };
};

// initializeAttic определён в attic.js -- здесь не дублируем

window.initializeBedroomInteractions = function () {
  const someEventListener = () => {
    // Event handling
  };
  document.addEventListener("someEvent", someEventListener);

  return function deactivate() {
    document.removeEventListener("someEvent", someEventListener);
  };
};

jQuery(document).ready(function ($) {
  $(".ajax-page-link").on("click", function (e) {
    e.preventDefault();
    var pageID = $(this).data("id");
    var newURL = $(this).attr("href");
    var clickedClasses = $(this).attr("class").split(/\s+/);

    $.ajax({
      url: ajaxData.ajaxurl,
      type: "POST",
      data: {
        action: "load_page_content",
        page_id: pageID,
      },
      success: function (response) {
        $("#content-to-blur").off().empty();

        addImportMap(response);

        $("#content-to-blur").html(response);
        try {
          window.history.pushState({ pageID: pageID }, "", newURL);
        } catch(pushErr) {
          console.warn('pushState error:', pushErr.message);
        }

        var tempDiv = document.createElement("div");
        tempDiv.innerHTML = response;
        var scripts = tempDiv.getElementsByTagName("script");

        var scriptPromises = Array.from(scripts).map((script) => {
          if (script.type !== "importmap") {
            return addScript(script);
          }
          return Promise.resolve();
        });

        Promise.all(scriptPromises)
          .then(() => {
            const initFunction = clickedClasses.find((cls) =>
              initializeFunctions.hasOwnProperty(cls)
            );

            if (initFunction) {
              setTimeout(() => {
                initializeFunctions[initFunction]();
              }, 100);
            }
          })
          .catch((error) => {
            // Error handling
          });
      },
      error: function (xhr, status, error) {
        // Error handling
      },
    });
  });
});

/////////////////////// Перемещение пультика и закрытие пультика
document.addEventListener("DOMContentLoaded", function () {
  const closeHi = document.getElementById("close-hi");
  const displayButtonWrapper = document.querySelector(
    ".display-button-wrapper"
  );
  const horseIndicator = document.getElementById("horseIndicator");
  const displayButton = document.getElementById("display-button");

  let isDragging = false;
  let startX, startY, startLeft, startTop;

  // Загрузка сохраненных данных. По умолчанию: пульт открыт, кнопка display скрыта.
  function loadSavedState() {
    const savedState = JSON.parse(localStorage.getItem("horseIndicatorState"));
    if (savedState) {
      horseIndicator.style.left = savedState.left;
      horseIndicator.style.top = savedState.top;
      horseIndicator.style.display = savedState.horseIndicatorDisplay;
      displayButtonWrapper.style.display =
        savedState.displayButtonWrapperDisplay;
    } else {
      horseIndicator.style.display = "block";
      displayButtonWrapper.style.display = "none";
    }
  }

  // Сохранение текущего состояния
  function saveState() {
    const state = {
      left: horseIndicator.style.left,
      top: horseIndicator.style.top,
      horseIndicatorDisplay: horseIndicator.style.display,
      displayButtonWrapperDisplay: displayButtonWrapper.style.display,
    };
    localStorage.setItem("horseIndicatorState", JSON.stringify(state));
  }

  loadSavedState();

  closeHi.addEventListener("click", function () {
    displayButtonWrapper.style.display = "block";
    horseIndicator.style.display = "none";
    saveState();
  });

  displayButton.addEventListener("click", function () {
    displayButtonWrapper.style.display = "none";
    horseIndicator.style.display = "block";
    saveState();
  });

  horseIndicator.addEventListener("mousedown", startDragging);
  document.addEventListener("mousemove", drag);
  document.addEventListener("mouseup", stopDragging);

  // Используем { passive: false } потому что вызываем e.preventDefault() в startDragging и drag
  horseIndicator.addEventListener("touchstart", startDragging, { passive: false });
  document.addEventListener("touchmove", drag, { passive: false });
  document.addEventListener("touchend", stopDragging);

  function startDragging(e) {
    isDragging = true;
    startX = e.type === "touchstart" ? e.touches[0].clientX : e.clientX;
    startY = e.type === "touchstart" ? e.touches[0].clientY : e.clientY;
    startLeft = horseIndicator.offsetLeft;
    startTop = horseIndicator.offsetTop;
    e.preventDefault();
  }

  function drag(e) {
    if (!isDragging) return;
    const clientX = e.type === "touchmove" ? e.touches[0].clientX : e.clientX;
    const clientY = e.type === "touchmove" ? e.touches[0].clientY : e.clientY;
    const dx = clientX - startX;
    const dy = clientY - startY;
    horseIndicator.style.left = `${startLeft + dx}px`;
    horseIndicator.style.top = `${startTop + dy}px`;
    e.preventDefault();
  }

  function stopDragging() {
    if (isDragging) {
      isDragging = false;
      saveState();
    }
  }
});

///////////////// СКЕЛЕТ

document.addEventListener("DOMContentLoaded", () => {
  const elements = {
    buttonContainer: document.querySelector(".skeleton-button"),
    button: document.getElementById("skeleton-button"),
    home: document.getElementById("skeleton-home"),
    homeLink: document.getElementById("skeleton-home-link"),
    buttonImg: document.querySelector("#skeleton-button img"),
    homeLinkImg: document.querySelector("#skeleton-home-link img"),
  };

  if (
    !elements.buttonContainer ||
    !elements.button ||
    !elements.home ||
    !elements.homeLink ||
    !elements.buttonImg ||
    !elements.homeLinkImg
  ) {
    return;
  }

  function toggleElement(element, show) {
    if (show) {
      element.style.display = "flex";
      requestAnimationFrame(() => {
        element.classList.remove("hidden");
      });
    } else {
      element.classList.add("hidden");
      element.addEventListener(
        "transitionend",
        function hideElement() {
          if (element.classList.contains("hidden")) {
            element.style.display = "none";
          }
          element.removeEventListener("transitionend", hideElement);
        },
        { once: true }
      );
    }
  }

  function toggleSkeletonHome(show) {
    if (show) {
      elements.home.style.display = "flex";
      requestAnimationFrame(() => {
        elements.home.classList.add("show");
      });
    } else {
      elements.home.classList.remove("show");
      elements.home.addEventListener(
        "transitionend",
        function hideHome() {
          if (!elements.home.classList.contains("show")) {
            elements.home.style.display = "none";
          }
          elements.home.removeEventListener("transitionend", hideHome);
        },
        { once: true }
      );
    }

    toggleElement(elements.button, !show);
    toggleElement(elements.homeLink, show);
  }

  elements.button.addEventListener("click", (e) => {
    e.stopPropagation();
    toggleSkeletonHome(true);
  });

  elements.home.addEventListener("click", (e) => {
    e.stopPropagation();
    toggleSkeletonHome(false);
  });

  /////////////// ПЕРЕВОДЧИК

  const translateButton = document.getElementById("translate-button");
  const translateDiv = document.querySelector(".trnsltr");

  // Функция для переключения видимости элемента
  function toggleTranslateDiv() {
    if (
      translateDiv.style.display === "none" ||
      translateDiv.style.display === ""
    ) {
      translateDiv.style.display = "block";
    } else {
      translateDiv.style.display = "none";
    }
  }

  // Событие клика по кнопке перевода
  translateButton.addEventListener("click", function (event) {
    event.preventDefault();
    toggleTranslateDiv();
  });
});

/////////////// X-RAY

document.addEventListener("DOMContentLoaded", function () {
  const xrayButton = document.getElementById("x-ray-button");
  const mainElement = document.querySelector(".x-ray-wrapper");
  const headerCornerWrapper = document.querySelector(".corner-wrapper");

  // Проверяем сохраненное состояние при загрузке страницы
  const savedState = localStorage.getItem("xrayState");
  if (savedState === "active") {
    mainElement.classList.add("xray-active");
    xrayButton.classList.add("active");
  }
  xrayButton.addEventListener("click", function () {
    if (mainElement.classList.contains("xray-active")) {
      mainElement.classList.remove("xray-active");
      mainElement.classList.remove("xray-animate");
      mainElement.classList.add("xray-animate-reverse");
      xrayButton.classList.remove("active");

      headerCornerWrapper.classList.remove("xray-active");
      headerCornerWrapper.classList.remove("xray-animate");
      headerCornerWrapper.classList.add("xray-animate-reverse");
      headerCornerWrapper.classList.remove("active");

      localStorage.setItem("xrayState", "inactive");
    } else {
      mainElement.classList.add("xray-active");
      mainElement.classList.remove("xray-animate-reverse");
      mainElement.classList.add("xray-animate");
      xrayButton.classList.add("active");

      headerCornerWrapper.classList.add("xray-active");
      headerCornerWrapper.classList.remove("xray-animate-reverse");
      headerCornerWrapper.classList.add("xray-animate");
      headerCornerWrapper.classList.add("active");

      localStorage.setItem("xrayState", "active");
    }

    // Удаляем классы анимации после завершения
    setTimeout(() => {
      mainElement.classList.remove("xray-animate", "xray-animate-reverse");
    }, 500);
  });
});

///////////////// ГРОМКОСТЬ

const volumeButton = document.getElementById("volume-button");
const volumeScreen = document.getElementById("volume-screen");
const volumeRange = document.getElementById("volume-range");
const volumeValue = document.getElementById("volume-value");
const redSquare = document.getElementById("red-square");
let hideTimeout;

function updateValue() {
  const value = volumeRange.value;
  volumeValue.textContent = value + "%"; // Добавляем знак процента к числу

  // Проверяем значение для изменения атрибута 'x'
  if (value >= 1 && value <= 9) {
    volumeValue.setAttribute("x", 8);
  } else if (value == 100) {
    volumeValue.setAttribute("x", 0);
  } else {
    volumeValue.setAttribute("x", 5); // Устанавливаем значение по умолчанию
  }

  const percent =
    (value - volumeRange.min) / (volumeRange.max - volumeRange.min);
  const position = percent * (volumeRange.offsetWidth - redSquare.offsetWidth);
  redSquare.style.left = `${position}px`;
}

volumeRange.addEventListener("input", updateValue);
updateValue(); // Initial position

function getSavedVolume() {
  return parseInt(localStorage.getItem("websiteVolume")) || 80;
}

function saveVolume(volume) {
  localStorage.setItem("websiteVolume", volume);
}

function applyVolumeToAudio(volume) {
  const normalizedVolume = Math.max(0, Math.min(volume / 100, 1)); // Убедимся, что значение в пределах [0, 1]

  document.querySelectorAll("audio").forEach((audio) => {
    audio.volume = normalizedVolume;
  });

  document.querySelectorAll("video.attic-video").forEach((video) => {
    video.volume = normalizedVolume;
  });

  if (window.audioContext && window.audioContext.gainNode) {
    window.audioContext.gainNode.gain.setValueAtTime(
      normalizedVolume,
      audioContext.currentTime
    );
  }

  if (window.scene) {
    window.scene.traverse(function (node) {
      if (node.isAudio) {
        node.setVolume(normalizedVolume);
      }
    });
  }
}

function updateRedSquarePosition() {
  const rangeRect = volumeRange.getBoundingClientRect();
  const thumbPosition =
    (volumeRange.value - volumeRange.min) / (volumeRange.max - volumeRange.min);
  const newPosition = thumbPosition * (rangeRect.width - 20);
  redSquare.style.left = `${newPosition}px`;
}

function updateVolumeValue() {
  volumeValue.textContent = volumeRange.value;
}

function setVolume(volume) {
  volumeRange.value = volume;
  updateVolumeValue();
  updateRedSquarePosition();
  saveVolume(volume);
  applyVolumeToAudio(volume);
}

volumeButton.addEventListener("mouseenter", showVolumeScreen);

// Переключение экрана громкости по клику: открыть/закрыть
volumeButton.addEventListener("click", () => {
  const isVisible =
    volumeScreen.style.display === "block" &&
    volumeScreen.style.opacity === "1";
  if (isVisible) {
    hideVolumeScreen();
  } else {
    showVolumeScreen();
  }
});

volumeScreen.addEventListener("mouseenter", () => {
  clearTimeout(hideTimeout);
});

volumeScreen.addEventListener("mouseleave", () => {
  hideTimeout = setTimeout(hideVolumeScreen, 1500);
});

document.addEventListener("mousemove", (e) => {
  const rect = volumeScreen.getBoundingClientRect();
  if (
    e.clientX < rect.left ||
    e.clientX > rect.right ||
    e.clientY < rect.top ||
    e.clientY > rect.bottom
  ) {
    if (volumeScreen.style.display !== "none") {
      clearTimeout(hideTimeout);
      hideTimeout = setTimeout(hideVolumeScreen, 1500);
    }
  }
});

volumeRange.addEventListener("input", () => {
  setVolume(volumeRange.value);
});

// Инициализация значения при загрузке страницы
setVolume(getSavedVolume());

function showVolumeScreen() {
  volumeButton.classList.add("volume-hidden", "volume-button-over");
  volumeScreen.style.display = "block";
  setTimeout(() => {
    volumeScreen.style.opacity = "1";
    volumeScreen.style.filter = "blur(0)";
  }, 10);
  updateRedSquarePosition();
}

function hideVolumeScreen() {
  volumeScreen.style.opacity = "0";
  volumeScreen.style.filter = "blur(10px)";
  setTimeout(() => {
    volumeScreen.style.display = "none";
    volumeButton.classList.remove("volume-hidden", "volume-button-over");
  }, 300);
}

function getSavedVolume() {
  return parseInt(localStorage.getItem("websiteVolume")) || 80;
}

function applyVolumeToSound(sound, volumeMultiplier) {
  const savedVolume = getSavedVolume() / 100;
  sound.volume = savedVolume * volumeMultiplier;
}

// НАСТРОЙКА ПЛАВНОГО УВЕЛИЧЕНИЯ ГРОМКОСТИ

function fadeInVolume(sound, targetVolume, duration) {
  const startVolume = sound.volume;
  const volumeDiff = targetVolume - startVolume;
  const startTime = performance.now();

  function updateVolume() {
    const currentTime = performance.now();
    const elapsedTime = currentTime - startTime;

    if (elapsedTime < duration) {
      const progress = elapsedTime / duration;
      const newVolume = startVolume + volumeDiff * progress;
      applyVolumeToSound(sound, newVolume);
      requestAnimationFrame(updateVolume);
    } else {
      applyVolumeToSound(sound, targetVolume);
    }
  }

  updateVolume();
}

// СПРЯТАТЬ FLUID В ОКНАХ

const nonFluidRooms = [
  "window-in-table-room",
  "outside-in-bedroom-room",
  "just-cave",
];
const fluidElement = document.querySelector(".fluid");
const contentContainer = document.getElementById("content-to-blur");

// Функция для проверки видимости и наличия комнат
function checkRooms() {
  const isAnyRoomPresent = nonFluidRooms.some((roomId) => {
    const room = document.getElementById(roomId);
    return (
      room &&
      // Проверяем как наличие элемента, так и его видимость
      room.parentElement &&
      window.getComputedStyle(room).display === "block"
    );
  });

  // Установка pointer-events в зависимости от наличия и видимости комнат
  fluidElement.style.pointerEvents = isAnyRoomPresent ? "none" : "auto";
}

// Наблюдатель за изменениями стилей и структуры DOM
const observer = new MutationObserver(checkRooms);

// Наблюдаем за контейнером content-to-blur
observer.observe(contentContainer, {
  attributes: true, // для изменений style
  childList: true, // для добавления/удаления элементов
  subtree: true, // включая все дочерние элементы
  attributeFilter: ["style"], // только для изменений style
});

// Начальная проверка при загрузке
checkRooms();
