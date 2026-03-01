<style>
    .album-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: calc(100% - 80px);
        min-height: 65vh;
        display: flex;
        flex-wrap: wrap;
        box-sizing: border-box;
        align-content: stretch;
        align-items: stretch;
        margin: 0;
        transition: all 0.5s ease-in-out;
    }

    .img-cell {
        flex: 1 1 25%;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 10px;
        transition: all 0.5s ease-in-out;
        height: auto;
    }

    .img-cell img {
        max-height: 63%;
        max-width: 80%;
        object-fit: contain;
        transition: all 0.5s ease-in-out;
        /*border-radius: 5px;
        border: 5px solid white;*/
        filter: drop-shadow(0 0 3px rgba(0, 0, 0, 0.5));
    }

    .img-number {
        margin-top: 15px;
        color: #B0B0B0;
    }

    .img-cell:nth-of-type(2) img { transform: rotate(-6deg); }
    .img-cell:nth-of-type(4) img { transform: rotate(6deg); }
    .img-cell:nth-of-type(5) img { transform: rotate(-6deg); }
    .img-cell:nth-of-type(7) img { transform: rotate(6deg); }

    .hide-img-cells .img-cell {
        opacity: 0;
        filter: blur(25px);
        pointer-events: none;
    }

    .enlarged-img-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 80%;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .side-img {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        max-height: 100%;
        max-width: 10%;
        object-fit: contain;
        opacity: 0.5;
        transition: all 0.5s ease-in-out;
    }


    .hide-img-cells .img-cell,
    .hide-img-cells .img-cell:nth-child(4n),
    .hide-img-cells .img-cell:nth-child(-n+4) {
        border: none;
        transition: all 0.5s ease-in-out;
    }

    .album-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        transition: transform 0.5s ease-in-out;
    }

    .album-switcher {
        display: flex;
        position: absolute;
        bottom: 0;
        left: 50%;
        padding-bottom: 30px;
        transform: translateX(-50%);
        color: #B0B0B0;
        font-size: 21px;
        text-decoration: none;
    }

    .page-button {
        padding: 0 10px;
        border: none;
        background-color: transparent;
        color: #B0B0B0;
        filter: blur(1px);
        cursor: pointer;
    }

    .page-button:hover {
        filter: blur(0px);
        opacity: 100%;
    }

    .page-now {
        filter: blur(0px) !important;
    }

    .nav-arrow {
        cursor: pointer;
        font-size: 27px;
        color: #B0B0B0;
        padding: 0 20px;
        transform: translateY(-2px);
    }
    .enlarged-img-container {
        display: flex;
        height: 100%;
    }
    .enlarged-img, .side-img {
        max-height: 60vh;
        max-width: 60%;
        object-fit: contain;
        transition: transform 0.3s ease-in-out;
        border-radius: 7px;
        filter: drop-shadow(0 0 9px rgba(0, 0, 0, 0.5));
        transform: rotate(3deg) translate(-50%, -50%);
        position: absolute;
        top: 50%;
        left: 50%;
    }
    .enlarged-img-container::before {
        content: '×';
        font-size: 3.9vh;
        position: absolute;
        top: -39px;
        left: 50%;
        color: #b0b0b0;
    }
    .side-img:hover {
        opacity: 1;
    }
    .side-img-right {
        opacity: 0.3;
        cursor: pointer;
        transform: translate(80%, -57%);
    }
    .side-img-left {
        opacity: 0.3;
        cursor: pointer;
        transform: rotate(-3deg) translate(-170%, -63%);
    }
    @keyframes slideOutLeft {
    0% {
        opacity: 1;
        transform: translateX(0) rotate(0deg);
    }
    100% {
        opacity: 0;
        transform: translateX(-100%) rotate(-10deg);
    }
    }

    @keyframes slideInFromRight {
    0% {
        opacity: 0;
        transform: translateX(100%) rotate(10deg);
    }
    100% {
        opacity: 1;
        transform: translateX(0) rotate(0deg);
    }
    }

    @keyframes slideInToLeft {
    0% {
        opacity: 0.5;
        transform: translateX(100%) rotate(3deg);
    }
    100% {
        opacity: 1;
        transform: translateX(0) rotate(0deg);
    }
    }

    @keyframes slideInFromLeft {
    0% {
        opacity: 0;
        transform: translateX(-100%) rotate(-3deg);
    }
    100% {
        opacity: 0.5;
        transform: translateX(0) rotate(0deg);
    }
    }

    .side-img-left.animate-out {
        animation: slideOutLeft 0.5s ease-in-out forwards;
    }

    .enlarged-img.animate-in {
        animation: slideInToLeft 0.5s ease-in-out forwards;
    }

    .side-img-right.animate-in {
        animation: slideInFromRight 0.5s ease-in-out forwards;
    }

    .new-side-img-right {
        animation: slideInFromRight 0.5s ease-in-out forwards;
    }
</style>

<div class="album-switcher">
        <span class="nav-arrow nav-arrow-left"><</span>
        <span class="img-number-in-switcher"></span>
        <div class="number-switcher"></div>
        <span class="nav-arrow nav-arrow-right">></span>
</div>

<div id="album-container" class="album-container"></div>

<!--script>
document.addEventListener("DOMContentLoaded", function() {
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
            img.src = `/wp-content/themes/blankslate/files/table-room/camera/${formattedNumber}.jpg`;
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
                img.src = `/wp-content/themes/blankslate/files/table-room/camera/${formattedNumber}.jpg`;
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
        img.src = `/wp-content/themes/blankslate/files/table-room/camera/${formattedNumber}.jpg`;
        img.alt = `Image ${formattedNumber}`;
        img.dataset.itemName = `${formattedNumber}.jpg`;
        img.dataset.index = index;
        img.classList.add('side-img', className);
        return img;
    }

    function createMainImage(index) {
        const img = document.createElement('img');
        const formattedNumber = formatImageNumber(index + 1);
        img.src = `/wp-content/themes/blankslate/files/table-room/camera/${formattedNumber}.jpg`;
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
});
</script-->