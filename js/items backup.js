/////////// ADD NAV-LINK-NOW

document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-items-link');

    navLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();

            // Удаляем класс у всех ссылок
            navLinks.forEach(l => l.classList.remove('nav-items-link-now'));

            // Добавляем класс к текущей нажатой ссылке
            this.classList.add('nav-items-link-now');
        });
    });
});




//////////// Функция для загрузки контента и инициализации скриптов




function loadContent(contentId, scriptInitializer) {
    fetch(`https://nohome.cloud/wp-content/themes/blankslate/items/${contentId}.php`)
        .then(response => response.text())
        .then(data => {
            // Вставляем контент в HTML
            document.getElementById('items-content').innerHTML = data;

            // Даем время DOM обновиться перед инициализацией скриптов
            requestAnimationFrame(() => {
                scriptInitializer();
            });
        })
        .catch(error => console.error('Error loading content:', error));
}




///////// BACKPACK




function initializeBackpackScript() {
    const container = document.getElementById('backpack-container');
    const itemNameDisplay = document.querySelector('.backpack-items-name');
    const images = [];
    const imageNames = [
        "antiseptic", "band-aids", "bandage", "batteries", "canned food_1", "canned food_2", 
        "carabiners", "compass", "dumb phone", "elastic water bottle", "emergency blanket", 
        "essential medicines", "file folder_1", "file folder_2", "fire starter", "flashlight", 
        "folding umbrella", "fork-spoon", "garbage bags", "gardening gloves", "hunting matches", 
        "lighter fluid", "lighter", "maps", "medical gloves", "medical mask", "menstrual cup", 
        "multi-cable", "multitool", "nuts", "paracord", "plastic bags", "power banks", "radio", 
        "reusable pads", "signal mirror", "soap", "socket adapter", "spare phone", "tape", 
        "thread and needle", "toothbrush and toothpaste", "vape liquids", "vapes", "wallet", 
        "water filter", "waterproof backpack cover", "waterproof shoe covers", "whistle", 
        "wire connectors kit"
    ];
    const numImages = imageNames.length;
    let enlarged = null;

    function createImage(index) {
        const image = document.createElement('div');
        image.className = 'image';
        const imageName = imageNames[index].replace(/ /g, '%20');
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
            changeDirectionCounter: Math.floor(Math.random() * 1000) + 500 // Значительно увеличен интервал смены направления
        });

        image.addEventListener('click', () => toggleEnlarge(index));
    }

    function moveImages() {
        images.forEach((img, index) => {
            if (enlarged !== null) return;

            img.changeDirectionCounter--;
            if (img.changeDirectionCounter <= 0) {
                // Более плавное изменение направления
                const newAngle = Math.atan2(img.dy, img.dx) + (Math.random() - 0.5) * Math.PI / 8;
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
            img.element.classList.add('enlarged');
            img.element.style.width = '50%';  // Изменено на 50%
            img.element.style.height = '50%'; // Изменено на 50%
            img.element.style.left = '25%'; // Центрирование (100 - 50) / 2
            img.element.style.top = '25%';  
            itemNameDisplay.textContent = imageNames[index];

            images.forEach((otherImg, otherIndex) => {
                if (otherIndex !== index) {
                    otherImg.element.style.opacity = '0';
                }
            });
        } else {
            const img = images[enlarged];
            img.element.classList.remove('enlarged');
            img.element.style.width = `${img.size}%`;
            img.element.style.height = `${img.size}%`;
            img.element.style.left = `${img.x}%`;
            img.element.style.top = `${img.y}%`;
            itemNameDisplay.textContent = '';

            images.forEach((otherImg) => {
                otherImg.element.style.opacity = '1';
            });

            enlarged = null;
        }
    }

    for (let i = 0; i < numImages; i++) {
        createImage(i);
    }

    moveImages();
}



///////// LUGGAGE




function initializeLuggageScript() {
    const leftContainer = document.querySelector('.luggage-container.left');
    const rightContainer = document.querySelector('.luggage-container.right');
    const switchLeftBtn = document.getElementById('luggage-left');
    const switchRightBtn = document.getElementById('luggage-right');
    const cells = document.querySelectorAll('.cell');
    const switcher = document.querySelector('.switcher');
    const itemLuggageName = document.querySelector('.item-luggage-name');

    if (!leftContainer || !rightContainer) {
        console.error('Containers not found');
        return;
    }

    function switchToLeftContainer() {
        leftContainer.style.transform = 'translateY(-50%) translateX(-50%)';
        rightContainer.style.transform = 'translateY(-50%) translateX(0%)';
        switchRightBtn.classList.remove('luggage-switch-now');
        switchLeftBtn.classList.add('luggage-switch-now');
    }

    function switchToRightContainer() {
        leftContainer.style.transform = 'translateY(-50%) translateX(calc(-150% - 80px))';
        rightContainer.style.transform = 'translateY(-50%) translateX(calc(-100% - 80px))';
        switchLeftBtn.classList.remove('luggage-switch-now');
        switchRightBtn.classList.add('luggage-switch-now');
    }

    switchLeftBtn.addEventListener('click', function(event) {
        event.preventDefault();
        switchToLeftContainer();
    });

    switchRightBtn.addEventListener('click', function(event) {
        event.preventDefault();
        switchToRightContainer();
    });

    cells.forEach(cell => {
        cell.addEventListener('click', function(event) {
            event.stopPropagation();
            const container = cell.closest('.luggage-container');
            container.classList.add('hide-cells');

            const img = cell.querySelector('img');
            const enlargedImg = img.cloneNode(true);
            const itemName = img.getAttribute('data-item-name');

            enlargedImg.classList.add('enlarged-img');
            enlargedImg.style.filter = 'blur(15px)';
            enlargedImg.style.opacity = '0';
            container.appendChild(enlargedImg);

            // Hide switcher and show item name
            switcher.style.display = 'none';
            itemLuggageName.textContent = itemName;
            itemLuggageName.style.display = 'block';

requestAnimationFrame(() => {
    enlargedImg.style.filter = 'blur(0px) drop-shadow(0 0 2px white)';
    enlargedImg.style.opacity = '1';
});

            container.addEventListener('click', function() {
                enlargedImg.style.filter = 'blur(15px)';
                enlargedImg.style.opacity = '0';

                setTimeout(() => {
                    enlargedImg.remove();
                    container.classList.remove('hide-cells');

                    // Show switcher and hide item name
                    switcher.style.display = 'block';
                    itemLuggageName.style.display = 'none';
                }, 500);
            }, { once: true });
        });
    });
}




///////// IPHONE




function initializeIphoneScript() {
    const lockscreen = document.querySelector('.lockscreen');
    const passScreen = document.querySelector('.pass-screen');
    const appsScreen = document.querySelector('.apps-screen');
    const stars = document.querySelectorAll('.stars path');
    const clickables = document.querySelectorAll('.pass-numbers .clickable');
    const cancelButton = document.querySelector('#pass-screen-cancel');

    let currentStar = 0;
	let leftEmojiTimeout, rightEmojiTimeout;  // Объявляем переменные здесь

    function resetStars() {
        stars.forEach(star => star.style.fill = 'none');
        currentStar = 0;
    }

    function toggleScreens(hideScreen, showScreen) {
        hideScreen.style.display = 'none';
        showScreen.style.display = 'block';
    }

    clickables.forEach(clickable => {
        clickable.addEventListener('click', function() {
            if (currentStar < stars.length) {
                stars[currentStar].style.fill = '#E7E7E7';
                currentStar++;

                if (currentStar === stars.length) {
                    setTimeout(() => {
                        toggleScreens(passScreen, appsScreen);
                        resetStars();
                    }, 500);
                }
            }
        });
    });

    cancelButton.addEventListener('click', function() {
        toggleScreens(passScreen, lockscreen);
        resetStars();
    });

    const notification = document.getElementById('notification');
    notification.addEventListener('click', function() {
        toggleScreens(lockscreen, passScreen);
    });

 const videos = document.querySelectorAll('.image-container video');
    const ANIMATION_REPEAT_COUNT = 1;

    videos.forEach(video => {
        video.addEventListener('loadedmetadata', () => {
            video.currentTime = 0;
        });

        video.addEventListener('mouseenter', () => {
            if (video.paused) {
                video.play();
            }
        });

        video.addEventListener('mouseleave', () => {
            if (!video.paused) {
                video.pause();
            }
        });

        video.addEventListener('click', (event) => {
            event.stopPropagation();
            playAllVideos();
        });
    });

    function playAllVideos() {
        videos.forEach(video => {
            video.currentTime = 0;
            video.play();
            setTimeout(() => {
                video.pause();
            }, video.duration * 1000 * ANIMATION_REPEAT_COUNT);
        });
    }

    document.querySelector('.apps-screen').addEventListener('click', playAllVideos);


    function updateDateTime() {
        const now = new Date();
        const dateOptions = {
            weekday: 'long',
            day: 'numeric',
            month: 'long'
        };
        const dateString = now.toLocaleDateString('en-GB', dateOptions);

        const timeOptions = {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        };
        const timeString = now.toLocaleTimeString('en-GB', timeOptions);

        document.getElementById('date').innerHTML = dateString;
        document.getElementById('time').innerHTML = timeString;
    }

    setInterval(updateDateTime, 30000);
    updateDateTime();

    function showEmoji(emojiToShow, emojiToHide, timeoutVarToClear) {
        if (emojiToHide.style.display === 'flex') {
            emojiToHide.style.animation = 'scaleDown 0.5s forwards';
            clearTimeout(timeoutVarToClear);
            setTimeout(() => {
                emojiToHide.style.display = 'none';
            }, 500);
        }

        emojiToShow.style.display = 'flex';
        emojiToShow.style.animation = 'scaleUp 0.5s forwards';

        return setTimeout(() => {
            emojiToShow.style.animation = 'scaleDown 0.5s forwards';
            setTimeout(() => {
                emojiToShow.style.display = 'none';
            }, 500);
        }, 9000);
    }

    document.getElementById('lockscreen-left').addEventListener('click', function() {
        clearTimeout(leftEmojiTimeout);
        leftEmojiTimeout = showEmoji(
            document.querySelector('.left-emoji'),
            document.querySelector('.right-emoji'),
            rightEmojiTimeout
        );
    });

    document.getElementById('lockscreen-right').addEventListener('click', function() {
        clearTimeout(rightEmojiTimeout);
        rightEmojiTimeout = showEmoji(
            document.querySelector('.right-emoji'),
            document.querySelector('.left-emoji'),
            leftEmojiTimeout
        );
    });

    // Запускаем уведомление
    setTimeout(function() {
        let sound = document.getElementById('notification-sound');
        sound.play();

        let notification = document.querySelector('.iphone-notification');
        notification.style.display = 'block';

        setTimeout(function() {
            notification.classList.add('notification');
        }, 10);
    }, 3000);
	
	///////// LEFT EMOJI
  const emojiImg = document.getElementById('emoji-img');
  const emojiRange = document.getElementById('emoji-range');

  emojiRange.addEventListener('input', function() {
    const value = parseInt(emojiRange.value) + 1; // чтобы началось с 1.png
    emojiImg.src = `https://nohome.cloud/wp-content/themes/blankslate/files/items/iphone/emoji/${value}.png`;
  });
}




//////////// DOCUMENTS




function initializeDocumentsScript() {
    console.log("Documents script initialized.");
    // Ваш код для documents
}




//////////// CAMERA




function initializeCameraScript() {
    const albumContainer = document.getElementById('album-container');
    const switcher = document.querySelector('.number-switcher');
    const itemLuggageName = document.querySelector('.img-number-in-switcher');
    const totalPages = 13;
    const imagesPerPage = 8;
    let currentPage = 1;
    let currentImageIndex = 0;
    let preloadedImages = {};

    // Добавляем стили для анимации
    const style = document.createElement('style');
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
            const button = document.createElement('button');
            button.textContent = i;
            button.classList.add('page-button');
            if (i === 1) button.classList.add('page-now');
            button.addEventListener('click', () => switchToPage(i));
            switcher.appendChild(button);
        }
        updateVisibleButtons();
    }

    function switchToPage(page) {
        const oldCells = albumContainer.querySelectorAll('.img-cell');
        oldCells.forEach(cell => {
            cell.classList.add('fade-out');
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
        const buttons = switcher.querySelectorAll('.page-button');
        buttons.forEach((button, index) => {
            const pageNum = index + 1;
            if (pageNum === currentPage - 1 || pageNum === currentPage || pageNum === currentPage + 1) {
                button.style.display = 'inline-block';
            } else {
                button.style.display = 'none';
            }
            
            // Особые случаи для первой и последней страницы
            if (currentPage === 1 && pageNum === 2) {
                button.style.display = 'inline-block';
            }
            if (currentPage === totalPages && pageNum === totalPages - 1) {
                button.style.display = 'inline-block';
            }
        });
    }

    function updatePageButtons() {
        const buttons = switcher.querySelectorAll('.page-button');
        buttons.forEach((button, index) => {
            button.classList.toggle('page-now', index + 1 === currentPage);
        });
    }

    function formatImageNumber(number) {
        return ('00' + number).slice(-5);
    }

    function loadImagesForPage(page) {
        albumContainer.innerHTML = '';
        const startIndex = (page - 1) * imagesPerPage + 1;
        const endIndex = Math.min(startIndex + imagesPerPage - 1, 100);

        for (let i = startIndex; i <= endIndex; i++) {
            const cell = document.createElement('div');
            cell.className = 'img-cell fade-in';
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
            
            const numberDiv = document.createElement('div');
            numberDiv.className = 'img-number';
            numberDiv.textContent = `${formattedNumber}.jpg`;
            
            cell.appendChild(img);
            cell.appendChild(numberDiv);
            albumContainer.appendChild(cell);
        }

        addImageClickListeners();
    }

    function lazyLoadImages() {
        const images = albumContainer.querySelectorAll('img[data-src]');
        images.forEach(img => {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
        });
    }

    function addImageClickListeners() {
        const cells = albumContainer.querySelectorAll('.img-cell');
        cells.forEach(cell => {
            cell.addEventListener('click', function(event) {
                event.stopPropagation();
                albumContainer.classList.add('hide-img-cells');
                
                const img = cell.querySelector('img');
                currentImageIndex = parseInt(img.dataset.index);
                showEnlargedImage(currentImageIndex);
            });
        });
    }

    function showEnlargedImage(index) {
        albumContainer.innerHTML = '';
        const enlargedImgContainer = document.createElement('div');
        enlargedImgContainer.classList.add('enlarged-img-container');

        const prevIndex = (index - 1 + 100) % 100;
        const nextIndex = (index + 1) % 100;

        const prevImg = createSideImage(prevIndex, 'side-img-left');
        const mainImg = createMainImage(index);
        const nextImg = createSideImage(nextIndex, 'side-img-right');

        enlargedImgContainer.appendChild(prevImg);
        enlargedImgContainer.appendChild(mainImg);
        enlargedImgContainer.appendChild(nextImg);

        albumContainer.appendChild(enlargedImgContainer);

        switcher.style.display = 'none';
        itemLuggageName.textContent = mainImg.dataset.itemName;
        itemLuggageName.style.display = 'block';

        addEnlargedImageListeners(enlargedImgContainer);
    }

    function updateEnlargedImage(container, direction) {
        const prevIndex = (currentImageIndex - 1 + 100) % 100;
        const nextIndex = (currentImageIndex + 1) % 100;

        const newPrevImg = createSideImage(prevIndex, 'side-img-left');
        const newMainImg = createMainImage(currentImageIndex);
        const newNextImg = createSideImage(nextIndex, 'side-img-right');

        container.innerHTML = '';
        container.appendChild(newPrevImg);
        container.appendChild(newMainImg);
        container.appendChild(newNextImg);

        if (direction === 'left') {
            newPrevImg.classList.add('slide-from-left');
        } else {
            newNextImg.classList.add('slide-from-right');
        }

        itemLuggageName.textContent = newMainImg.dataset.itemName;
        addEnlargedImageListeners(container);
    }

    function createSideImage(index, className) {
        const img = document.createElement('img');
        const formattedNumber = formatImageNumber(index + 1);
        img.src = `https://nohome.cloud/wp-content/themes/blankslate/files/table-room/camera/${formattedNumber}.jpg`;
        img.alt = `Image ${formattedNumber}`;
        img.dataset.itemName = `${formattedNumber}.jpg`;
        img.dataset.index = index;
        img.classList.add('side-img', className);
        return img;
    }

    function createMainImage(index) {
        const img = document.createElement('img');
        const formattedNumber = formatImageNumber(index + 1);
        img.src = `https://nohome.cloud/wp-content/themes/blankslate/files/table-room/camera/${formattedNumber}.jpg`;
        img.alt = `Image ${formattedNumber}`;
        img.dataset.itemName = `${formattedNumber}.jpg`;
        img.dataset.index = index;
        img.classList.add('enlarged-img');
        return img;
    }

    function addEnlargedImageListeners(container) {
        const leftArrow = container.querySelector('.side-img-left');
        const rightArrow = container.querySelector('.side-img-right');
        const mainImg = container.querySelector('.enlarged-img');

        leftArrow.addEventListener('click', (event) => {
            event.stopPropagation();
            navigateImages('left');
        });

        rightArrow.addEventListener('click', (event) => {
            event.stopPropagation();
            navigateImages('right');
        });

        mainImg.addEventListener('click', closeEnlargedImage);
        container.addEventListener('click', closeEnlargedImage);
        document.addEventListener('keydown', handleKeyPress);
    }

    function navigateImages(direction) {
        const currentImg = albumContainer.querySelector('.enlarged-img');
        currentImg.classList.add('slide-out');

        setTimeout(() => {
            if (direction === 'left') {
                currentImageIndex = (currentImageIndex - 1 + 100) % 100;
            } else {
                currentImageIndex = (currentImageIndex + 1) % 100;
            }
            showEnlargedImage(currentImageIndex);
            const newImg = albumContainer.querySelector('.enlarged-img');
            newImg.classList.add('slide-in');
        }, 300);
    }

    function handleKeyPress(event) {
        if (event.key === 'ArrowLeft') {
            navigateImages('left');
        } else if (event.key === 'ArrowRight') {
            navigateImages('right');
        } else if (event.key === 'Escape') {
            closeEnlargedImage();
        }
    }

    function closeEnlargedImage() {
        document.removeEventListener('keydown', handleKeyPress);
        albumContainer.innerHTML = '';
        albumContainer.classList.remove('hide-img-cells');
        switcher.style.display = 'block';
        itemLuggageName.style.display = 'none';
        loadImagesForPage(currentPage);
    }

    document.querySelector('.nav-arrow-left').addEventListener('click', () => {
        if (albumContainer.classList.contains('hide-img-cells')) {
            navigateImages('left');
        } else {
            switchToPage(Math.max(1, currentPage - 1));
        }
    });

    document.querySelector('.nav-arrow-right').addEventListener('click', () => {
        if (albumContainer.classList.contains('hide-img-cells')) {
            navigateImages('right');
        } else {
            switchToPage(Math.min(totalPages, currentPage + 1));
        }
    });

    createPageButtons();
    switchToPage(1);
    preloadNextPage(1);
}




//////////// MP3




function initializeMp3Script() {
    console.log("MP3 script initialized.");
    // Ваш код для mp3
}

// Назначаем обработчики кликов на каждый nav-item
document.getElementById('backpack-content').addEventListener('click', function(event) {
    event.preventDefault();
    loadContent('backpack-content', initializeBackpackScript);
});

document.getElementById('luggage-content').addEventListener('click', function(event) {
    event.preventDefault();
    loadContent('luggage-content', initializeLuggageScript);
});

document.getElementById('iphone-content').addEventListener('click', function(event) {
    event.preventDefault();
    loadContent('iphone-content', initializeIphoneScript);
});

document.getElementById('documents-content').addEventListener('click', function(event) {
    event.preventDefault();
    loadContent('documents-content', initializeDocumentsScript);
});

document.getElementById('camera-content').addEventListener('click', function(event) {
    event.preventDefault();
    loadContent('camera-content', initializeCameraScript);
});

document.getElementById('mp3-content').addEventListener('click', function(event) {
    event.preventDefault();
    loadContent('mp3-content', initializeMp3Script);
});

