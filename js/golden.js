import * as THREE from "three";
import { GLTFLoader } from "three/examples/jsm/loaders/GLTFLoader";
import { DRACOLoader } from "three/examples/jsm/loaders/DRACOLoader";
import { OrbitControls } from "three/examples/jsm/controls/OrbitControls";
import { EffectComposer } from "three/examples/jsm/postprocessing/EffectComposer";
import { RenderPass } from "three/examples/jsm/postprocessing/RenderPass";
import { OutlinePass } from "three/examples/jsm/postprocessing/OutlinePass";
import { ShaderPass } from "three/examples/jsm/postprocessing/ShaderPass";
import { GammaCorrectionShader } from "three/examples/jsm/shaders/GammaCorrectionShader";

function initializeGolden() {
  let scene, camera, renderer, room, controls, composer, outlinePass;
  let raycaster = new THREE.Raycaster();
  let mouse = new THREE.Vector2();
  let selectedObject = null;
  let clickStartObject = null;
  let isRendering = true;
  let ratClickCount = 0;
  let userInteracted = false;
  let soundsLoaded = false;

  const Doors = ["Door_low", "Door_low_1", "Door_low_2", "Door_low_3"];
  const Rats = [
    "Mesh_0",
    "Mesh_1",
    "Mesh_2",
    "Mesh_3",
    "Mesh_4",
    "Mesh_5",
    "Mesh_6",
    "Mesh_7",
    "Mesh_8",
    "Mesh_9",
  ];
  const Locks = [
    ["defaultMaterial", "Boole", "Cube_2"],
    ["defaultMaterial_3", "Boole_3", "Cube_4"],
    ["chain", "Cube"],
    ["defaultMaterial_2", "Boole_2", "Cube_3"],
  ];

  const elements = {
    goldenRoomMain: document.getElementById("golden-room-3d"),
    goldenRoomDoor: document.getElementById("golden-room-door"),
    goldenRoomRats: document.querySelector(".golden-room-door-rats"),
    goldenRoomLock: document.getElementById("golden-room-door-lock"),
    LockInLockOverlay: document.getElementById("LockInLockOverlay"),
    goldenRoom3D: document.getElementById("golden-room-3d"),
  };

  const arrowButtons = {
    toGoldenRoomMain: null,
    toGoldenRoomDoor: null,
    toGoldenRoomDoorR: null,
  };

  const sounds = {
    doorSound: null,
    ratSound: null,
    doorLockSound: null,
    ratSoundR: null,
    lockSoundR: null,
  };

  let isAnimating = false;

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

  function init() {
    const goldenRoom3D = document.getElementById("golden-room-3d");
    if (!goldenRoom3D) {
      console.warn("Golden room 3D element not found");
      return;
    }

    // Проверяем размеры контейнера
    const containerWidth = goldenRoom3D.clientWidth;
    const containerHeight = goldenRoom3D.clientHeight;

    if (containerWidth === 0 || containerHeight === 0) {
      console.warn("Container has zero size, waiting for resize");
      return;
    }

    // Инициализация сцены с отложенной загрузкой
    setTimeout(() => {
      try {
        scene = new THREE.Scene();
        camera = new THREE.PerspectiveCamera(
          75,
          containerWidth / containerHeight,
          0.1,
          1000
        );
        camera.position.set(0.84, 0.13, -0.83);
        camera.lookAt(new THREE.Vector3(-0.7, -0.11, 0.7));

        renderer = new THREE.WebGLRenderer({
          antialias: true,
          powerPreference: "high-performance",
          stencil: false,
          depth: true,
          alpha: true,
        });
        renderer.setSize(containerWidth, containerHeight);
        renderer.physicallyCorrectLights = true;
        renderer.outputEncoding = THREE.sRGBEncoding;
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

        // Оптимизация загрузки модели
        const dracoLoader = new DRACOLoader();
        dracoLoader.setDecoderPath(
          "https://unpkg.com/three@0.166.0/examples/jsm/libs/draco/gltf/"
        );
        dracoLoader.setDecoderConfig({ type: "js" });

        const glbUrl = goldenRoom3D.getAttribute("data-glb-url");
        if (!glbUrl) {
          console.warn("GLB URL not found");
          return;
        }

        const loader = new GLTFLoader();
        loader.setDRACOLoader(dracoLoader);

        let lastLoggedPercentage = 0;
        const totalSizeInMB = 79.5;
        const hiUpdate = document.getElementById("hi-update");
        const originalText = hiUpdate.textContent;

        // Оптимизация загрузки модели
        loader.load(
          glbUrl,
          function (gltf) {
            try {
              room = gltf.scene;
              room.scale.set(1, 1, 1);
              room.position.set(0, -1.5, 0);

              // Оптимизация геометрии
              room.traverse((node) => {
                if (node.isMesh) {
                  node.geometry.computeVertexNormals();
                  node.geometry.attributes.position.needsUpdate = true;
                  node.geometry.attributes.normal.needsUpdate = true;

                  // Оптимизация материалов
                  if (node.material) {
                    node.material.dithering = false;
                    node.material.precision = "lowp";
                    node.material.vertexColors = false;
                  }
                }
              });

              // Добавляем сцену в DOM только после полной загрузки
              requestAnimationFrame(() => {
                scene.add(room);
                goldenRoom3D.appendChild(renderer.domElement);
                document.getElementById("loadingScreen").style.display = "none";
                
                // Обновляем текст в пультике
                const loadUpdate = document.getElementById("loadUpdate");
                
                if (typeof window.updateHorseText === 'function') {
                  window.updateHorseText("pixels are in a preparation process. wait for them please. I am sorry if you encounter any bugs.", 0);
                } else {
                  hiUpdate.textContent = "pixels are in a preparation process. wait for them please. I am sorry if you encounter any bugs.";
                  hiUpdate.classList.add("horse-indicator-text-active");
                }
                loadUpdate.textContent = "100%";

                // Инициализируем обработку событий после загрузки
                initializeInteractions();
              });
            } catch (error) {
              console.error("Error processing 3D model:", error);
            }
          },
          function (xhr) {
            const loadedMB = (xhr.loaded / 1024 / 1024).toFixed(2);
            const percentage = Math.floor((loadedMB / totalSizeInMB) * 100);

            if (percentage > lastLoggedPercentage) {
              requestAnimationFrame(() => {
                hiUpdate.textContent = `Preparing the room for you. Loaded: ${percentage}%`;
                hiUpdate.classList.add("horse-indicator-text-active");
                lastLoggedPercentage = percentage;
              });
            }
          },
          function (error) {
            console.error("Error loading 3D model:", error);
          }
        );

        // Оптимизация контролов
        controls = new OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.dampingFactor = 0.25;
        controls.enablePan = false;
        controls.minDistance = 0.1;
        controls.maxDistance = 6;
        controls.maxPolarAngle = Math.PI;
        controls.update();

        // Оптимизация пост-обработки
        composer = new EffectComposer(renderer);
        composer.setSize(containerWidth, containerHeight);

        const renderPass = new RenderPass(scene, camera);
        composer.addPass(renderPass);

        outlinePass = new OutlinePass(
          new THREE.Vector2(containerWidth, containerHeight),
          scene,
          camera
        );
        outlinePass.edgeStrength = 9;
        outlinePass.edgeGlow = 0;
        outlinePass.edgeThickness = 5;
        outlinePass.pulsePeriod = 1;
        composer.addPass(outlinePass);

        const gammaCorrectionPass = new ShaderPass(GammaCorrectionShader);
        composer.addPass(gammaCorrectionPass);

        // Оптимизация обработки событий
        const resizeObserver = new ResizeObserver(() => {
          onWindowResize();
        });
        resizeObserver.observe(goldenRoom3D);

        // Оптимизация обработки мыши
        const mouseMoveHandler = debounce((event) => {
          onMouseMoveDebounced(event);
        }, 16);

        renderer.domElement.addEventListener("mousemove", mouseMoveHandler, {
          passive: true,
        });
        renderer.domElement.addEventListener("mousedown", onMouseDown, {
          passive: true,
        });
        renderer.domElement.addEventListener("mouseup", onMouseUp, {
          passive: true,
        });

        // Добавляем обработчик первого взаимодействия
        document.addEventListener(
          "click",
          () => {
            userInteracted = true;
            loadSounds();
          },
          { once: true }
        );

        // Запускаем анимацию
        animate();
      } catch (error) {
        console.error("Error initializing 3D scene:", error);
      }
    }, 100); // Задержка для инициализации
  }

  function findRelatedObjects(object) {
    if (Doors.includes(object.name) || Rats.includes(object.name)) {
      return [object];
    } else {
      for (let lockGroup of Locks) {
        if (lockGroup.includes(object.name)) {
          return room.children.filter((child) =>
            lockGroup.includes(child.name)
          );
        }
      }
    }
    return [];
  }

  const onMouseMoveDebounced = debounce((event) => {
    event.preventDefault();
    const rect = renderer.domElement.getBoundingClientRect();
    mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
    mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;
    raycaster.setFromCamera(mouse, camera);

    if (room) {
      const intersects = raycaster.intersectObjects(room.children, true);
      if (intersects.length > 0) {
        const firstIntersected = intersects[0].object;
        if (selectedObject !== firstIntersected) {
          selectedObject = firstIntersected;
          outlinePass.selectedObjects = findRelatedObjects(firstIntersected);
        }

        if (Rats.includes(firstIntersected.name)) {
          showAsciiArt(event);
        } else {
          hideAsciiArt();
        }
      } else {
        clearSelection();
        hideAsciiArt();
      }
    }
  }, 16); // ~60fps

  function clearSelection() {
    selectedObject = null;
    outlinePass.selectedObjects = [];
  }

  function onMouseDown(event) {
    event.preventDefault();
    mouse.x = (event.clientX / containerWidth) * 2 - 1;
    mouse.y = -(event.clientY / containerHeight) * 2 + 1;
    raycaster.setFromCamera(mouse, camera);

    if (room) {
      const intersects = raycaster.intersectObjects(room.children, true);
      if (intersects.length > 0) {
        clickStartObject = intersects[0].object;
      }
    }
  }

  function onMouseUp(event) {
    event.preventDefault();
    mouse.x = (event.clientX / containerWidth) * 2 - 1;
    mouse.y = -(event.clientY / containerHeight) * 2 + 1;
    raycaster.setFromCamera(mouse, camera);

    if (room) {
      const intersects = raycaster.intersectObjects(room.children, true);
      if (intersects.length > 0) {
        const clickEndObject = intersects[0].object;
        if (clickStartObject === clickEndObject) {
          handleClick(clickEndObject);
        }
      }
    }

    clickStartObject = null;
  }

  function handleClick(object) {
    if (!userInteracted || !soundsLoaded) {
      console.warn(
        "Cannot play sound: user has not interacted with the page yet or sounds are not loaded"
      );
      return;
    }

    if (Doors.includes(object.name)) {
      
      playSound(sounds.doorSound);
      setTimeout(() => {
        toggleVisibility(elements.goldenRoomMain, elements.goldenRoomDoor);
        pauseRendering();
      }, 750);
    } else if (Rats.includes(object.name)) {
      
      playSound(sounds.ratSound);
    } else {
      for (let lockGroup of Locks) {
        if (lockGroup.includes(object.name)) {
          
          playSound(sounds.doorLockSound);
          break;
        }
      }
    }
  }

  function toggleVisibility(hide, show) {
    if (isAnimating) return;
    isAnimating = true;
    [hide, show].forEach(
      (el) => (el.style.animationName = el === hide ? "fadeOut" : "fadeIn")
    );
    show.style.display = "block";
    hide.addEventListener("animationend", function hideElement() {
      hide.style.display = "none";
      hide.style.animationName = "";
      hide.removeEventListener("animationend", hideElement);
      isAnimating = false;
    });
    show.addEventListener("animationend", function showElement() {
      show.style.animationName = "";
      show.removeEventListener("animationend", showElement);
    });
  }

  function onWindowResize() {
    camera.aspect = containerWidth / containerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(containerWidth, containerHeight);
    composer.setSize(containerWidth, containerHeight);
  }

  function pauseRendering() {
    isRendering = false;
    renderer.domElement.style.display = "none";
    renderer.domElement.removeEventListener("mousemove", onMouseMoveDebounced);
    renderer.domElement.removeEventListener("mousedown", onMouseDown);
    renderer.domElement.removeEventListener("mouseup", onMouseUp);
  }

  function resumeRendering() {
    isRendering = true;
    renderer.domElement.style.display = "block";
    renderer.domElement.addEventListener(
      "mousemove",
      onMouseMoveDebounced,
      false
    );
    renderer.domElement.addEventListener("mousedown", onMouseDown, false);
    renderer.domElement.addEventListener("mouseup", onMouseUp, false);
    requestAnimationFrame(animate);
  }

  let lastTime = 0;
  const fps = 60;
  const interval = 1000 / fps;

  function animate(currentTime) {
    if (isRendering) {
      requestAnimationFrame(animate);
      if (currentTime - lastTime < interval) return;
      lastTime = currentTime;

      if (controls && controls.enabled) {
        controls.update();
      }

      if (composer) {
        composer.render();
      }
    }
  }

  function initializeRoomTransfers() {
    elements.goldenRoomDoorLock = document.getElementById(
      "golden-room-door-lock"
    );

    arrowButtons.toGoldenRoomMain = document.getElementById(
      "to-golden-room-main"
    );
    arrowButtons.toGoldenRoomDoor = document.getElementById(
      "to-golden-room-door"
    );
    arrowButtons.toGoldenRoomDoorR = document.getElementById(
      "to-golden-room-door-r"
    );

    document.querySelectorAll(".overlay-svg").forEach((overlay) => {
      overlay.addEventListener("click", function () {
        const targetId = overlay.classList[1];
        const targetElement = document.getElementById(targetId);
        if (targetElement) {
          const currentElement = document.querySelector(
            '.room-wrapper:not([style*="display: none"])'
          );
          toggleVisibility(currentElement, targetElement);
        }
      });
    });

    document.querySelectorAll(".golden-room-door-rats").forEach((element) => {
      element.addEventListener("click", () => {
        playSound(sounds.ratSoundR);
        showNextRatImage();
      });
    });

    document.querySelectorAll(".golden-room-door-lock").forEach((element) => {
      element.addEventListener("click", () => {
        playSound(sounds.lockSoundR);
      });
    });

    arrowButtons.toGoldenRoomMain.addEventListener("click", () => {
      const currentElement = document.querySelector(
        '.room-wrapper:not([style*="display: none"])'
      );
      toggleVisibility(currentElement, elements.goldenRoomMain);
    });

    arrowButtons.toGoldenRoomDoor.addEventListener("click", () => {
      const currentElement = document.querySelector(
        '.room-wrapper:not([style*="display: none"])'
      );
      toggleVisibility(currentElement, elements.goldenRoomDoor);
    });

    arrowButtons.toGoldenRoomDoorR.addEventListener("click", () => {
      const currentElement = document.querySelector(
        '.room-wrapper:not([style*="display: none"])'
      );
      toggleVisibility(currentElement, elements.goldenRoomDoor);
    });

    const newCameraPosition = new THREE.Vector3(-4.24, 0.03, -4.24);
    const newCameraLookAt = new THREE.Vector3(0.7, -0.006, 0.7);

    function animateCameraTransition(
      startPosition,
      startLookAt,
      endPosition,
      endLookAt,
      duration
    ) {
      const startTime = performance.now();

      function update() {
        const elapsedTime = performance.now() - startTime;
        const progress = Math.min(elapsedTime / duration, 1);

        camera.position.lerpVectors(startPosition, endPosition, progress);

        const currentLookAt = new THREE.Vector3();
        currentLookAt.lerpVectors(startLookAt, endLookAt, progress);
        camera.lookAt(currentLookAt);

        if (progress < 1) {
          requestAnimationFrame(update);
        }
      }

      update();
    }

    elements.LockInLockOverlay.addEventListener("click", () => {
      
      playSound(sounds.lockSoundR);

      try {
        if (elements.goldenRoomDoorLock) {
          elements.goldenRoomDoorLock.style.display = "none";
        } else {
          console.warn("goldenRoomDoorLock element not found");
        }

        if (elements.goldenRoom3D) {
          elements.goldenRoom3D.style.display = "block";
          resumeRendering();

          const currentPosition = camera.position.clone();
          const currentLookAt = camera
            .getWorldDirection(new THREE.Vector3())
            .add(camera.position);

          animateCameraTransition(
            currentPosition,
            currentLookAt,
            newCameraPosition,
            newCameraLookAt,
            3000
          );
        } else {
          console.warn("goldenRoom3D element not found");
        }
      } catch (error) {
        console.error("Error in LockInLockOverlay click handler:", error);
      }
    });
  }

  function showNextRatImage() {
    const images = document.querySelectorAll(
      "#golden-room-door-rats .nextrats"
    );
    images.forEach((img) => (img.style.visibility = "hidden"));

    const indexToShow = ratClickCount % images.length;
    images[indexToShow].style.visibility = "visible";

    ratClickCount++;
  }

  const asciiArts = [
    document.getElementById("ascii-art"),
    document.getElementById("ascii-art-1"),
    document.getElementById("ascii-art-2"),
  ];
  let currentAsciiArtIndex = 0;
  let isHovering = false;
  let animationInterval;
  const originalHTMLs = asciiArts.map((art) => art.innerHTML);
  const goldenRoomRatsElements = document.querySelectorAll(
    ".golden-room-door-rats"
  );

  goldenRoomRatsElements.forEach((element) => {
    element.addEventListener("mouseenter", function (event) {
      isHovering = true;
      showAsciiArt(event);
    });
    element.addEventListener("mouseleave", function () {
      isHovering = false;
      hideAsciiArt();
    });
    element.addEventListener("mousemove", function (event) {
      if (isHovering) {
        updateAsciiArtPosition(event);
      }
    });
  });

  function showAsciiArt(event) {
    const currentAsciiArt = asciiArts[currentAsciiArtIndex];
    const originalHTML = originalHTMLs[currentAsciiArtIndex];
    const duration = 5000;
    const speed = duration / originalHTML.length;

    asciiArts.forEach((art) => (art.style.display = "none"));
    currentAsciiArt.style.display = "block";
    updateAsciiArtPosition(event);
    currentAsciiArt.innerHTML = "";
    let index = 0;
    clearInterval(animationInterval);
    animationInterval = setInterval(() => {
      if (index < originalHTML.length) {
        const currentContent = originalHTML.slice(0, index + 1);
        currentAsciiArt.innerHTML = currentContent;
        updateAsciiArtPosition(event);
        index++;
      } else {
        clearInterval(animationInterval);
      }
    }, speed);

    currentAsciiArtIndex = (currentAsciiArtIndex + 1) % asciiArts.length;
  }

  function updateAsciiArtPosition(event) {
    const currentAsciiArt = asciiArts[currentAsciiArtIndex];
    currentAsciiArt.style.left = `${event.clientX + 20}px`;
    currentAsciiArt.style.bottom = `${containerHeight - event.clientY + 20}px`;
    currentAsciiArt.style.top = "auto";
  }

  function hideAsciiArt() {
    asciiArts.forEach((art) => (art.style.display = "none"));
    clearInterval(animationInterval);
  }

  asciiArts.forEach((art) => {
    art.style.whiteSpace = "pre";
    art.style.textAlign = "center";
    art.style.position = "fixed";
    art.style.transformOrigin = "bottom left";
  });

  function onMouseMove3D(event) {
    event.preventDefault();
    mouse.x = (event.clientX / containerWidth) * 2 - 1;
    mouse.y = -(event.clientY / containerHeight) * 2 + 1;
    raycaster.setFromCamera(mouse, camera);

    if (room) {
      const intersects = raycaster.intersectObjects(room.children, true);
      if (intersects.length > 0) {
        const firstIntersected = intersects[0].object;
        if (Rats.includes(firstIntersected.name)) {
          isHovering = true;
          showAsciiArt(event);
        } else {
          isHovering = false;
          hideAsciiArt();
        }
      } else {
        isHovering = false;
        hideAsciiArt();
      }
    }
  }

  // Функция для загрузки звуков
  function loadSounds() {
    if (!userInteracted || soundsLoaded) return;

    const soundUrls = {
      doorSound:
        "https://nohome.cloud/wp-content/themes/blankslate/files/golden-room/door.wav",
      ratSound:
        "https://nohome.cloud/wp-content/themes/blankslate/files/golden-room/rat.wav",
      doorLockSound:
        "https://nohome.cloud/wp-content/themes/blankslate/files/golden-room/lock.wav",
      ratSoundR:
        "https://nohome.cloud/wp-content/themes/blankslate/files/golden-room/rat.wav",
      lockSoundR:
        "https://nohome.cloud/wp-content/themes/blankslate/files/golden-room/lock.wav",
    };

    // Загружаем звуки только после взаимодействия
    const loadSound = (key) => {
      return new Promise((resolve) => {
        const audio = new Audio();
        audio.src = soundUrls[key];
        audio.preload = "auto";
        audio.oncanplaythrough = () => {
          sounds[key] = audio;
          resolve();
        };
        audio.load();
      });
    };

    // Загружаем все звуки параллельно
    Promise.all(Object.keys(soundUrls).map(loadSound))
      .then(() => {
        soundsLoaded = true;
        
      })
      .catch((error) => {
        console.error("Error loading sounds:", error);
      });
  }

  // Функция для воспроизведения звука
  function playSound(sound) {
    if (!userInteracted || !soundsLoaded) {
      console.warn(
        "Audio playback blocked: user has not interacted with the page yet or sounds are not loaded"
      );
      return;
    }

    if (sound) {
      try {
        sound.currentTime = 0;
        const playPromise = sound.play();
        if (playPromise !== undefined) {
          playPromise.catch((error) => {
            console.warn("Audio playback failed:", error);
          });
        }
      } catch (error) {
        console.warn("Error playing sound:", error);
      }
    }
  }

  // Новая функция для инициализации взаимодействий
  function initializeInteractions() {
    // Добавляем обработчики для элементов сцены в 3D модели
    if (room) {
      // Обработчики для 3D объектов устанавливаются через ray casting
      // и уже реализованы в других функциях
      
      // Не добавляем никаких дополнительных обработчиков,
      // так как все необходимые взаимодействия уже установлены
      // в horse-text-handler.js
    }
  }

  init();
  animate();
  initializeRoomTransfers();
  showNextRatImage();

  //renderer.domElement.addEventListener('mousemove', onMouseMove, false);
}

// Загрузка скрипта после загрузки DOM
document.addEventListener("DOMContentLoaded", initializeGolden);

// Делаем функцию глобально доступной
window.initializeGolden = initializeGolden;
