// captcha.js
let captchaData;

function loadCaptchaData() {
    return fetch('https://nohome.cloud/wp-content/themes/blankslate/files/captcha/captcha.json')
        .then(response => response.json())
        .then(data => {
            captchaData = data;
        });
}

function initializeCaptcha() {
    if (!captchaData) {
        loadCaptchaData().then(() => {
            setupCaptcha();
        });
    } else {
        setupCaptcha();
    }
}

function setupCaptcha() {
    const captchaElement = document.getElementById('captcha');
    const skipButton = document.getElementById('skip-captcha');
    const captchaPics = document.querySelectorAll('.captcha-pic');
    const captchaTextElement = document.querySelector('.captcha-text');

    let currentCaptcha;
    let selectedImages = new Set();
    let incorrectSelections = 0;

    function showCaptcha() {
        currentCaptcha = captchaData[Math.floor(Math.random() * captchaData.length)];

        document.querySelector('.captcha-choose .captcha-red').textContent = currentCaptcha.question;
        document.querySelector('.captcha-description').textContent = currentCaptcha.description;
        captchaTextElement.textContent = currentCaptcha.text;

        captchaPics.forEach((pic, index) => {
            const img = pic.querySelector('img');
            img.src = currentCaptcha.images[index];
            pic.classList.remove('correct', 'incorrect');
        });

        selectedImages.clear();
        incorrectSelections = 0;
    }

    captchaPics.forEach((pic, index) => {
        pic.addEventListener('click', () => {
            const isCorrect = checkAnswer(index);

            if (isCorrect) {
                pic.classList.add('correct');
                selectedImages.add(index);
            } else {
                pic.classList.add('incorrect');
                incorrectSelections++;
            }

            if (currentCaptcha.correct_answer === "none" && incorrectSelections === 4) {
                setTimeout(showCaptcha, 1000);
            }

            if (allCorrectSelected()) {
                setTimeout(() => {
                    if (typeof window.onCaptchaSuccess === 'function') {
                        window.onCaptchaSuccess();
                    }
                }, 1000);
            }
        });
    });

    function checkAnswer(index) {
        const imgSrc = captchaPics[index].querySelector('img').src;

        if (currentCaptcha.correct_answer === "any") {
            return true;
        } else if (Array.isArray(currentCaptcha.correct_answer)) {
            return currentCaptcha.correct_answer.includes(imgSrc);
        } else {
            return currentCaptcha.correct_answer === imgSrc;
        }
    }

    function allCorrectSelected() {
        if (currentCaptcha.correct_answer === "any") {
            return true;
        }

        const correctAnswers = Array.isArray(currentCaptcha.correct_answer) ?
            currentCaptcha.correct_answer : [currentCaptcha.correct_answer];

        const selectedSrcs = Array.from(selectedImages).map(index => captchaPics[index].querySelector('img').src);

        return correctAnswers.every(answer => selectedSrcs.includes(answer));
    }

    skipButton.addEventListener('click', showCaptcha);

    showCaptcha();
}

function deinitializeCaptcha() {
    // Убираем обработчики событий у всех картинок капчи
    captchaPics.forEach((pic) => {
        pic.replaceWith(pic.cloneNode(true)); // Клонирование удаляет все обработчики событий
    });

    // Сбрасываем состояние выбранных изображений и количества ошибок
    selectedImages.clear();
    incorrectSelections = 0;

    // Очистка данных текущей капчи
    currentCaptcha = null;
}

// Экспортируем функцию initializeCaptcha, чтобы она была доступна глобально
window.initializeCaptcha = initializeCaptcha;
window.deinitializeCaptcha = deinitializeCaptcha;