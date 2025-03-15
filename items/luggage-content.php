<style> 
    /* Оставляем все существующие стили без изменений */
    .luggage-container {
        position: absolute;
        top: 50%;
        left: calc(50% - 40px);
        transform: translate(-50%, -50%);
        width: calc(100% - 80px);
        min-height: 65vh;
        display: flex;
        flex-wrap: wrap;
        box-sizing: border-box;
        align-content: stretch;
        align-items: stretch; /* Обеспечивает одинаковую высоту для всех .cell */
        margin: 0 40px;
        transition: all 0.5s ease-in-out;
        border-top: 1px dashed rgba(255, 255, 255, 0.3);
        border-bottom: 1px dashed rgba(255, 255, 255, 0.3);
    }

    .cell {
        flex: 1 1 25%;
        box-sizing: border-box;
        border-right: 1px dashed rgba(255, 255, 255, 0.3);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
        transition: all 0.5s ease-in-out;
        height: auto;
    }

    .upload-button {
        flex: 1 1 25%;
        box-sizing: border-box;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
        transition: all 0.5s ease-in-out;
        height: auto;
        position: relative;
        overflow: hidden;
    }

    .upload-button img {
        max-height: 63%;
        max-width: 63%;
        object-fit: contain;
        transition: all 0.5s ease-in-out;
    }

    #upload-button {
        background-color: transparent;
        border: none;
        position: relative;
        z-index: 2; /* Обеспечивает кликабельность кнопки */
        cursor: pointer;
        width: 100%;
        height: 100%;
    }
    
    .cell img {
        max-height: 85%;
        max-width: 80%;
        object-fit: contain;
        transition: all 0.5s ease-in-out;
    }

    /* Убираем правую границу у последних ячеек в каждом ряду */
    .cell:nth-child(4n) {
        border-right: none;
    }

    /* Добавляем верхнюю границу (пунктир) для первого ряда */
    .cell:nth-child(-n+4) {
        border-bottom: 1px dashed rgba(255, 255, 255, 0.3);
    }

    /* Скрываем все ячейки */
    .hide-cells .cell {
        opacity: 0;
        filter: blur(25px);
        pointer-events: none;
    }
    
    .upload-button.hide-upload-button {
        opacity: 0;
        filter: blur(25px);
        pointer-events: none;
        transition: all 0.5s ease-in-out;
    }

    /* Стилизуем центральное изображение */
    .enlarged-img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        height: 70%;
        max-width: 70%;
        object-fit: contain;
        z-index: 1000;
        transition: all 0.5s ease-in-out;
        filter: drop-shadow(0 0 2px white);
    }

    .luggage-container:has(.enlarged-img)::before {
        content: '×';
        font-size: 3.9vh;
        position: absolute;
        top: 39px;
        left: calc(50% - 9.75px);
        color: #b0b0b0;
    }

    /* Убираем границы у таблицы */
    .hide-cells .cell, 
    .hide-upload-button .upload-button,
    .hide-cells .cell:nth-child(4n),
    .hide-cells .cell:nth-child(-n+4) {
        border: none;
        transition: all 0.5s ease-in-out;
    }

    .luggage-container.left {
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        width: calc(100% - 80px);
        min-height: 65vh;
        display: flex;
        flex-wrap: wrap;
        box-sizing: border-box;
        align-content: stretch;
        align-items: stretch; /* Обеспечивает одинаковую высоту для всех .cell */
        margin: 0 40px;
        transition: transform 0.5s ease-in-out;
        border-top: 1px dashed rgba(255, 255, 255, 0.3);
        border-bottom: 1px dashed rgba(255, 255, 255, 0.3);
    }

    /*Правый контейнер - изначально скрыт справа за экраном */
    .luggage-container.right {
        position: absolute;
        top: 50%;
        left: 100%;
        transform: translateY(-50%);
        width: calc(100% - 80px);
        min-height: 65vh;
        display: flex;
        align-content: stretch;
        align-items: stretch; /* Обеспечивает одинаковую высоту для всех .cell */
        flex-wrap: wrap;
        box-sizing: border-box;
        margin: 0 40px;
        transition: transform 0.5s ease-in-out;
        border-top: 1px dashed rgba(255, 255, 255, 0.3);
        border-bottom: 1px dashed rgba(255, 255, 255, 0.3);
    }

    /* Кнопки переключения */
    .luggage-switch {
        display: inline-block;
        position: absolute;
        bottom: 0;
        left: 50%;
        padding-bottom: 30px;
        transform: translateX(-50%);
        color: #B0B0B0;
        font-size: 21px;
        text-decoration: none;
    }

    #luggage-right, #luggage-left {
        padding: 0 27px;
        border: none;
        background-color: transparent;
        color: #B0B0B0;
        filter: blur(1px);
    }

    #luggage-right:hover, #luggage-left:hover {
        filter: blur(0px);
        opacity: 100%;
    }

    .luggage-switch span {
        display: inline-block;
    }

    .luggage-switch-now {
        filter: blur(0px) !important;
    }

    .upload-mb {
        color: #9f9f9f;
        filter: blur(1px);
    }
    
    .upload-text {
        font-size: 2.5rem;
        color: #7a7a7a;
        filter: blur(1px);
    }
    
    /* НОВЫЕ СТИЛИ для знаков вопроса - заменяют предыдущие */
    .up-frame {
        position: relative;
        width: 100%;
        z-index: 2;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    
    .upload-qm {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        pointer-events: none;
    }
    
    .upload-qm span {
        position: absolute;
        font-size: 2.5rem;
        color: rgba(245, 245, 245, 0.7);
        text-shadow: 0 0 8px rgba(255, 255, 255, 0.8);
        filter: blur(0.5px);
        opacity: 0.7;
        pointer-events: none;
    }
    
    /* Индивидуальные стили и анимации для каждого знака вопроса */
    .upload-qm span:nth-child(1) {
        top: 20%;
        left: 20%;
        animation: float1 7s infinite ease-in-out;
    }
    
    .upload-qm span:nth-child(2) {
        top: 30%;
        left: 70%;
        animation: float2 9s infinite ease-in-out;
    }
    
    .upload-qm span:nth-child(3) {
        top: 70%;
        left: 30%;
        animation: float3 8s infinite ease-in-out;
    }
    
    .upload-qm span:nth-child(4) {
        top: 60%;
        left: 60%;
        animation: float4 10s infinite ease-in-out;
    }
    
    .upload-qm span:nth-child(5) {
        top: 40%;
        left: 40%;
        animation: float5 7.5s infinite ease-in-out;
    }
    
    .upload-qm span:nth-child(6) {
        top: 15%;
        left: 55%;
        animation: float6 11s infinite ease-in-out;
    }
    
    .upload-qm span:nth-child(7) {
        top: 75%;
        left: 75%;
        animation: float7 8.5s infinite ease-in-out;
    }
    
    /* Индивидуальные анимации для каждого знака */
    @keyframes float1 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(30px, 20px); }
    }
    
    @keyframes float2 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-20px, 30px); }
    }
    
    @keyframes float3 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(25px, -15px); }
    }
    
    @keyframes float4 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-15px, -20px); }
    }
    
    @keyframes float5 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(10px, 30px); }
    }
    
    @keyframes float6 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-30px, 10px); }
    }
    
    @keyframes float7 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(20px, -25px); }
    }
</style>
<div id="items-content">
    <div class="luggage-switch">
    <div class="item-luggage-name"></div>
    <div class="switcher">
        <button id="luggage-left" class="luggage-switch-now"><</button>
        <span>|</span>
        <button id="luggage-right">></button>
    </div>
    </div>
    <div class="luggage-container left">
        <div class="cell"><img data-item-name="-sleeping bag-" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/luggage/object8.png" alt="Image 1"></div>
        <div class="cell"><img data-item-name="-camping mat-" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/luggage/object10.png" alt="Image 2"></div>
        <div class="cell"><img data-item-name="-quadrobiс set-" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/luggage/object7.png" alt="Image 3"></div>
        <div class="cell"><img data-item-name="-emergency bandage-" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/luggage/object3.png" alt="Image 4"></div>
        <div class="cell"><img data-item-name="-shoes-" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/luggage/object9.png" alt="Image 5"></div>
        <div class="cell"><img data-item-name="-outdoor folding chair-" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/luggage/object13.png" alt="Image 6"></div>
        <div class="cell"><img data-item-name="-waterproof pillow-" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/luggage/object11.png" alt="Image 7"></div>
        <div class="cell"><img data-item-name="-trail flip-flops-" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/luggage/object14.png" alt="Image 8"></div>
    </div>

    <div class="luggage-container right">
        <div class="cell"><img data-item-name="-sleep mask-" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/luggage/object2.png" alt="Image 1"></div>
        <div class="cell"><img data-item-name="-thermal underwear-" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/luggage/object4.png" alt="Image 2"></div>
        <div class="cell"><img data-item-name="-t-shirt-" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/luggage/object5.png" alt="Image 3"></div>
        <div class="cell"><img data-item-name="-thermal sweatshirt-" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/luggage/object12.png" alt="Image 4"></div>
        <div class="cell"><img data-item-name="-microfibre towel-" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/luggage/object6.png" alt="Image 5"></div>
        <div class="cell"><img data-item-name="-socks set-" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/luggage/object15.png" alt="Image 6"></div>
        <div class="cell"><img data-item-name="-panty shorts-" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/luggage/object1.png" alt="Image 7"></div>
		<div class="upload-button">
			<button id="upload-button">
               <!-- <img id="uploaded-img" src="/wp-content/themes/blankslate/files/items/luggage/upload.png" alt="Image 8"> -->
				<div class="up-frame">
				<div class="upload-text">upload</div>
				<div class="upload-mb"><0.5mb</div>
				<div class="upload-qm">
				<span>?</span>
				<span>?</span>
				<span>?</span>
				<span>?</span>
				<span>?</span>
				<span>?</span>
				<span>?</span>
				</div>
				</div>
			</button>
			<input type="file" id="file-input" style="display: none;">
    	</div>
    </div>
</div>

<script>
    // Вставьте этот скрипт в ваш файл JavaScript
    document.addEventListener('DOMContentLoaded', function() {
    initializeQuestionMarks();
    });

    // Функция для инициализации анимации знаков вопроса
    function initializeQuestionMarks() {
    // Получаем все знаки вопроса
    const questionMarks = document.querySelectorAll('.upload-qm span');
    
    console.log('Найдено знаков вопроса:', questionMarks.length);
    
    // Для каждого знака рассчитываем случайные начальные позиции и направления движения
    questionMarks.forEach((mark, index) => {
        // Случайные начальные координаты от 10% до 90% контейнера
        const xStart = Math.random() * 80 + 10;
        const yStart = Math.random() * 80 + 10;
        
        // Случайные конечные координаты от 10% до 90% контейнера
        const xEnd = Math.random() * 80 + 10;  
        const yEnd = Math.random() * 80 + 10;
        
        // Устанавливаем CSS-переменные для начальной и конечной точек
        mark.style.setProperty('--x-start', xStart);
        mark.style.setProperty('--y-start', yStart);
        mark.style.setProperty('--x-end', xEnd);
        mark.style.setProperty('--y-end', yEnd);
        
        // Устанавливаем начальную позицию
        mark.style.left = `${xStart}%`;
        mark.style.top = `${yStart}%`;
        
        console.log(`Знак ${index+1}: начало (${xStart}%, ${yStart}%), конец (${xEnd}%, ${yEnd}%)`);
    });
    }

    // Если контент загружается динамически, вызовите эту функцию после загрузки соответствующего контента
    function reinitializeQuestionMarks() {
    setTimeout(initializeQuestionMarks, 100);
    }
</script>

<!--script>

document.addEventListener("DOMContentLoaded", function() {
    const leftContainer = document.querySelector('.luggage-container.left');
    const rightContainer = document.querySelector('.luggage-container.right');
    const switchLeftBtn = document.getElementById('luggage-left');
    const switchRightBtn = document.getElementById('luggage-right');
    const cells = document.querySelectorAll('.cell');
    const switcher = document.querySelector('.switcher');
    const itemLuggageName = document.querySelector('.item-luggage-name');

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
                enlargedImg.style.filter = 'blur(0px)';
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
});
</script-->