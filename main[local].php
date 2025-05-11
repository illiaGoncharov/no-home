<!-- wp:html -->
<style>
  body,
  html {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
  }
  .main-page {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100vh;
    background-color: #34332f;
  }
  .house-wrapper {
    position: absolute;
    height: 74vh;
    width: 74vh;
    display: block;
    pointer-events: none;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
  .house-img {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    object-fit: contain;
    opacity: 0;
    transition: opacity 600ms ease-out;
    pointer-events: none;
  }
  .house-img.house-frame {
    opacity: 1;
  }
  .house-img.active {
    opacity: 1;
  }
  .house-svg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
  }
  .house-svg svg {
    width: 100%;
    height: 100%;
    pointer-events: none;
  }
  .house-svg path {
    fill-opacity: 0;
    pointer-events: auto;
  }
  .stickers-wrapper {
    position: absolute;
    width: 100vw;
    height: 100vh;
    top: 0;
    left: 0;
  }
  .sticker-img {
    position: absolute;
    cursor: grab;
  }
  .note1 {
    left: 3.4%;
    top: 19.6%;
    width: auto;
    height: 34.5%;
  }
  .note2 {
    left: 14.6%;
    top: 26.8%;
    width: auto;
    height: 17.9%;
  }
  .note3 {
    left: 10.1%;
    top: 67.7%;
    width: auto;
    height: 18.1%;
  }
  .note4 {
    left: 77.3%;
    top: 25.8%;
    width: auto;
    height: 20.8%;
    z-index: 1;
  }
  .note5 {
    left: 85.9%;
    top: 35.5%;
    width: auto;
    height: 15.8%;
    z-index: 2;
  }
  .note6 {
    left: 68.2%;
    top: 76.4%;
    width: auto;
    height: 9%;
  }
  .note7 {
    left: 88.6%;
    top: 68%;
    width: auto;
    height: 15.7%;
  }
  .note8 {
    left: 63.6%;
    top: 11%;
    width: auto;
    height: 23.7%;
    cursor: pointer;
  }
  .sticker-go-bag {
    left: 15.7%;
    top: 56.6%;
    width: auto;
    height: 35.5%;
    transform-origin: center;
  }
  .sticker-subjectivity-worksheet {
    left: 26.3%;
    top: 6%;
    width: auto;
    height: 35.5%;
    aspect-ratio: 0.71;
    transform: rotate(3.27deg);
  }
  .sticker-survival-guides {
    left: 75.5%;
    top: 41%;
    width: auto;
    height: 35.5%;
  }
  .sticker-info {
    position: absolute;
    width: 100vw;
    height: 100vh;
    background-color: #151413;
    z-index: 9999;
    display: none;
  }
  .sticker-data {
    font-family: "Avara";
    color: #b0b0b0;
    opacity: 20%;
    padding-left: 30px;
    padding-top: 30px;
    position: absolute;
    top: 0;
    left: 0;
    font-size: 1.5em;
  }
  .sticker-info-exit {
    font-family: "Avara";
    color: #b0b0b0;
    opacity: 20%;
    padding-right: 30px;
    padding-top: 30px;
    position: absolute;
    top: 0;
    right: 0;
    font-size: 1.5em;
    width: 100%;
    height: 100%;
    text-align: right;
  }
  .sticker-info-exit:hover {
    opacity: 60%;
  }
  .sticker-info-link {
    font-family: "Avara-Bold";
    color: #b0b0b0;
    opacity: 60%;
    padding-left: 30px;
    padding-bottom: 30px;
    position: absolute;
    bottom: 0;
    left: 0;
    font-size: 1.5em;
    text-decoration: none;
    display: none;
  }
  .sticker-info-link:hover {
    opacity: 90%;
  }
  .sticker-info-next {
    font-family: "Avara-Bold";
    color: #b0b0b0;
    opacity: 60%;
    padding-right: 30px;
    position: absolute;
    font-size: 2.5em;
    border: none;
    background: transparent;
    height: calc(75vh - 1.25em);
    width: 21vw;
    top: 0;
    right: 0;
    text-align: right;
    z-index: +1;
    display: none;
    margin: 15vh 0;
  }
  .sticker-info-prev {
    font-family: "Avara-Bold";
    color: #b0b0b0;
    opacity: 60%;
    padding-left: 30px;
    position: absolute;
    font-size: 2.5em;
    text-decoration: none;
    border: none;
    background: transparent;
    height: 100vh;
    width: 21vw;
    top: 0;
    left: 0;
    text-align: left;
    z-index: +1;
    display: none;
  }
  .sticker-info-prev:hover,
  .sticker-info-next:hover {
    opacity: 90;
  }
  .fluid {
    pointer-events: none;
    visibility: hidden;
  }
  .textarea-note {
    font-family: "Avara";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-10deg);
    z-index: 10001;
    font-size: 1.4em;
    width: 18%;
    height: 45%;
    border: none;
    background: none;
    color: #333;
    padding: 8px;
    resize: none;
    outline: none;
  }

  .textarea-note:focus {
    border: none;
    outline: none;
  }

  .preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #1e1e1e;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 9999;
  }

  .preloader img {
    pointer-events: none;
  }

  .preloader-header {
    font-family: "Avara";
    margin-bottom: 30px;
    color: #b0b0b0;
    font-size: 91px;
  }

  .preloader-text {
    width: 30%;
    text-align: center;
    text-shadow: 15px -10px 6px rgba(176, 176, 176, 0.2);
  }

  .preloader-button {
    border: none;
    background-color: transparent;
    font-size: 30px;
    color: #b0b0b0;
    cursor: pointer;
  }

  .in {
    font-family:'Avara';
    text-decoration: underline;
    margin-top: 50px;
    text-shadow: 15px -10px 6px rgba(176, 176, 176, 0.2);
  }

  .preloader-exit {
    position: absolute;
    top: 15%;
    left: 47%;
  }

  .warning {
    font-family: "Avara";
    font-size: 15px;
    color: #b0b0b0;
  }

  .sticker-text {
    position: absolute;
    top: 24%;
    left: 70%;
    transform: translate(-50%, -50%) rotate(-10deg);
    font-size: 0.8em;
    color: #333;
    z-index: 10001;
    transition: opacity 1s ease-in-out;
  }

  .circle {
    position: absolute;
    width: 841px;
    animation: rotate 50s linear infinite;
  }

  @keyframes rotate {
    from {
      transform: rotate(0deg);
    }
    to {
      transform: rotate(360deg);
    }
  }
  .circle-shadow {
    top: 1%;
    left: 20%;
  }

  .animated-circle {
    position: absolute;
    width: 500px;
    height: auto;
    pointer-events: none;
  }
</style>

<div class="main-page">
  <div id="preloader" class="preloader">
    <div>
      <button id="preloader-exit" class="preloader-button preloader-exit">
        <img
          src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/preloader/exit.png"
          alt=""
        />
      </button>
    </div>
    <div class="preloader-text">
      <h1 class="preloader-header">Warning!</h1>
      <p class="warning">
        Things shown on the screen can cause strong emotions or make you feel
        empty. Be vigilant if <br />all of your senses are being engaged. You
        will<br />
        have to become a user of someone else's map.<br />
        ❤️‍🔥♡Ģₒₒ𝑑ļ𝓾cќ ♡❤️‍🔥 on your user journey and ⇶☞𝔸ใᶩ𝗍ℎ𝒆ḅ𝒆ઽ𝗍❈!1!☞☞☞
      </p>
      <div>
        <button id="letMeIn" class="preloader-button in">Let me in!</button>
      </div>
    </div>

    <img
      class="circle"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/preloader/circle.png"
      alt=""
    />
    <img
      class="circle circle-shadow"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/preloader/circle-shadow.png"
      alt=""
    />
    <img
      class="animated-circle"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/preloader/Rectangle1.png"
    />
    <img
      class="animated-circle"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/preloader/Rectangle2.png"
    />
    <img
      class="animated-circle"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/preloader/Rectangle3.png"
    />
    <img
      class="animated-circle"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/preloader/Rectangle4.png"
    />
  </div>

  <div class="stickers-wrapper">
    <img
      class="sticker-img note1"
      data-sticker="en--//note_1"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/note1.png"
      alt="Note 1"
      draggable="true"
    />
    <img
      class="sticker-img note2"
      data-sticker="en--//note_2"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/note2.png"
      alt="Note 2"
      draggable="true"
    />
    <img
      class="sticker-img note3"
      data-sticker="en--//note_3"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/note3.png"
      alt="Note 3"
      draggable="true"
    />
    <img
      class="sticker-img note4"
      data-sticker="en--//note_4"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/note4.png"
      alt="Note 4"
      draggable="true"
    />
    <img
      class="sticker-img note5"
      data-sticker="en--//note_5"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/note5.png"
      alt="Note 5"
      draggable="true"
    />
    <img
      class="sticker-img note6"
      data-sticker="en--//note_6"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/note6.png"
      alt="Note 6"
      draggable="true"
    />
    <img
      class="sticker-img note7"
      data-sticker="en--//note_7"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/note7.png"
      alt="Note 7"
      draggable="true"
    />
    <img
      class="sticker-img note8"
      data-sticker="en--//note_8"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/note8.png"
      alt="Note 8"
      draggable="false"
    />

    <style>
      .sticker-under-gb {
        position: absolute;
        height: 90%;
        position: absolute;
        transform: rotate(-7.75deg) translate(10.4%, 5.5%);
        transition: all 1s ease-in-out;
      }
      .sticker-above-gb {
        height: 100%;
        position: absolute;
      }
      .sticker-second-gb {
        height: 100%;
        position: absolute;
        height: 90%;
        position: absolute;
        transform: rotate(-7.75deg) translate(10.4%, 5.5%);
        z-index: -1;
        transition: all 1s ease-in-out;
      }
      .sticker-under-sw {
        height: 100%;
        position: absolute;
      }
      .sticker-above-sw {
        height: 100%;
        position: absolute;
        z-index: 4;
      }
      .sticker-under-sg {
        height: 100%;
        position: absolute;
        height: 93%;
        position: absolute;
        transform: rotate(2.9deg) translate(7.3%, 1.8%);
      }
      .sticker-above-sg {
        height: 100%;
        position: absolute;
      }
      .sticker-second-sg {
        height: 100%;
        position: absolute;
        height: 93%;
        position: absolute;
        transform: rotate(2.9deg) translate(7.3%, 1.8%);
        z-index: -1;
      }
      .sticker-sw-container img {
        position: absolute;
        height: 11.28%;
        filter: opacity(0);
      }
      .sticker-sw-container img:hover {
        filter: opacity(1);
      }
      .sw-pics-c1 {
        left: 7.44%;
      }
      .sw-pics-c2 {
        left: 36.9%;
      }
      .sw-pics-c3 {
        left: 66.36%;
      }

      .sw-pics-r1 {
        top: 25.88%;
      }
      .sw-pics-r2 {
        top: 40.34%;
      }
      .sw-pics-r3 {
        top: 54.72%;
      }
      .sw-pics-r4 {
        top: 69.105%;
      }
      .sticker-sw-pics {
        transition: 1s ease-in-out;
        opacity: 0;
        z-index: 3;
        position: absolute;
        width: 100%;
        height: 100%;
      }
    </style>
    <div
      class="sticker-img sticker-go-bag"
      data-sticker="ϲ๏𝙧єarea:\𝓷ѻℍѻოⲉ\go𖥻៹bag.pdf"
      data-sticker-link="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/go_bag_pdf.pdf"
      draggable="true"
    >
      <img
        class="sticker-under-gb"
        src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/go%20bag.jpg"
        alt="Note 8"
      />
      <img
        class="sticker-above-gb"
        src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/go%20bag.png"
        alt="Note 8"
      />
      <img
        class="sticker-second-gb"
        src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/gobag2.jpg"
        alt="Note 8"
      />
    </div>

    <div
      class="sticker-img sticker-subjectivity-worksheet"
      data-sticker="ϲ๏𝙧єarea:\𝓷ѻℍѻოⲉ\subjectivity𖥻៹report.pdf"
      draggable="true"
    >
      <img
        class="sticker-above-sw"
        src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/subjectivity-worksheet.png"
        alt="Note 9"
      />
      <div class="sticker-sw-pics">
        <img
          class="sticker-under-sw"
          src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/subjectivity%20worksheet.jpg"
          alt="Note 9"
        />
        <div class="sticker-sw-container">
          <img
            class="sw-pics-c1 sw-pics-r2"
            src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/pics/1.jpg"
          />
          <img
            class="sw-pics-c1 sw-pics-r3"
            src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/pics/2.jpg"
          />
          <img
            class="sw-pics-c1 sw-pics-r4 already-bw"
            src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/pics/3.jpg"
          />
          <img
            class="sw-pics-c2 sw-pics-r1"
            src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/pics/4.jpg"
          />
          <img
            class="sw-pics-c2 sw-pics-r2"
            src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/pics/5.jpg"
          />
          <img
            class="sw-pics-c2 sw-pics-r3"
            src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/pics/6.jpg"
          />
          <img
            class="sw-pics-c2 sw-pics-r4"
            src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/pics/7.jpg"
          />
          <img
            class="sw-pics-c3 sw-pics-r1"
            src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/pics/8.jpg"
          />
          <img
            class="sw-pics-c3 sw-pics-r2"
            src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/pics/9.jpg"
          />
          <img
            class="sw-pics-c3 sw-pics-r3 already-bw"
            src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/pics/10.jpg"
          />
          <img
            class="sw-pics-c3 sw-pics-r4"
            src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/pics/11.jpg"
          />
          <img
            class="sw-pics-c1 sw-pics-r1"
            src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/pics/12.jpg"
          />
        </div>
      </div>
    </div>

    <div
      class="sticker-img sticker-survival-guides"
      data-sticker="ϲ๏𝙧єarea:\𝓷ѻℍѻოⲉ\survival𖥻៹guides.pdf"
      data-sticker-link="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/survival_guide_pdf_1.pdf"
      draggable="true"
    >
      <img
        class="sticker-under-sg"
        src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/survival%20guides.jpg"
        alt="Note 10"
      />
      <img
        class="sticker-above-sg"
        src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/survival%20guides.png"
        alt="Note 10"
      />
      <img
        class="sticker-second-sg"
        src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/survival_guides2.png"
        alt="Note 10"
      />
    </div>

    <div class="sticker-info">
      <span class="sticker-data">en--//note_1</span>
      <span class="sticker-info-exit">-exit-</span>
      <div class="sticker-info-img"></div>
      <a class="sticker-info-link" href="#">download</a>
      <button class="sticker-info-next">></button>
      <button class="sticker-info-prev"><</button>
    </div>
  </div>

  <div class="house-wrapper">
    <img
      class="house-img house-frame"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/house-frame.png"
      alt="House Image"
    />
    <img
      class="house-img house-frame-garret"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/house-frame-garret.png"
      alt="Garret"
    />
    <img
      class="house-img house-frame-golden-room"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/house-frame-golden-room.png"
      alt="Golden Room"
    />
    <img
      class="house-img house-frame-table-room"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/house-frame-table-room.png"
      alt="Table Room"
    />
    <img
      class="house-img house-frame-bed-room"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/house-frame-bed-room.png"
      alt="Bed Room"
    />
    <img
      class="house-img house-frame-cave-room"
      src="https://nohome.cloud/wp-content/themes/blankslate/files/main-page/house-frame-cave-room.png"
      alt="Cave Room"
    />

    <div class="house-svg">
      <svg
        viewBox="0 0 762 759"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        preserveAspectRatio="xMidYMid slice"
      >
        <a
          href="https://nohome.cloud/0selectedarea1"
          class="ajax-page-link mbed"
          data-id="1891"
        >
          <path
            id="house-frame-bed-room"
            fill="black"
            d="M174 707L101.5 505.5H368.5L370.5 707H174Z"
          />
        </a>
        <a
          href="https://nohome.cloud/0selectedarea2"
          class="ajax-page-link mcave"
          data-id="95"
        >
          <path
            id="house-frame-cave-room"
            fill="black"
            d="M579.5 706.5L652 505H385L383 706.5H579.5Z"
          />
        </a>
        <a
          href="https://nohome.cloud/0selectedarea5"
          class="ajax-page-link mgolden"
          data-id="1330"
        >
          <path
            id="house-frame-golden-room"
            fill="black"
            d="M370 303H51H34L99.5 496.5H370V303Z"
          />
        </a>
        <a
          href="https://nohome.cloud/0selectedarea4"
          class="ajax-page-link mattic"
          data-id="1582"
        >
          <path
            id="house-frame-garret"
            fill="black"
            d="M374 48.5L84 271.5L684.5 272.5L374 48.5Z"
          />
        </a>
        <a
          href="https://nohome.cloud/0selectedarea3"
          class="ajax-page-link mtable"
          data-id="1973"
        >
          <path
            id="house-frame-table-room"
            fill="black"
            d="M383 303H702H719L653.5 496.5H383V303Z"
          />
        </a>
      </svg>
    </div>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const svgPaths = document.querySelectorAll(".house-svg path");
    const houseImages = document.querySelectorAll(
      ".house-img:not(.house-frame)"
    );

    svgPaths.forEach((path) => {
      path.addEventListener("mouseenter", function () {
        const imageClass = this.id;
        houseImages.forEach((img) => {
          img.classList.remove("active");
        });
        document
          .querySelector(`.house-img.${imageClass}`)
          .classList.add("active");
      });

      path.addEventListener("mouseleave", function () {
        houseImages.forEach((img) => {
          img.classList.remove("active");
        });
      });
    });
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const preloader = document.getElementById("preloader");
    const letMeInButton = document.getElementById("letMeIn");
    const exitButton = document.getElementById("preloader-exit");

    letMeInButton.addEventListener("click", function () {
      preloader.style.display = "none";
    });

    exitButton.addEventListener("click", function () {
      window.location.href = "https://www.google.com/search?q=home";
    });

    const images = document.querySelectorAll(".animated-circle");

    const viewportWidth = window.innerWidth;
    const viewportHeight = window.innerHeight;

    const initialPositions = [
      { top: -150, left: -200 }, 
      { top: 40, left: 900 }, 
      { top: 400, left: 1000 }, 
      { top: 600, left: 100 }, 
    ];

    function getRandomPosition() {
      const x = Math.random() * (viewportWidth - 500); 
      const y = Math.random() * (viewportHeight - 500);
      return { x, y };
    }

    function animateImage(image) {
      const { x, y } = getRandomPosition();
      image.style.transition = "top 60s linear, left 60s linear";
      image.style.top = `${y}px`;
      image.style.left = `${x}px`;

      setTimeout(() => animateImage(image), 50000); 
    }

    images.forEach((image, index) => {
      const { top, left } = initialPositions[index];
      image.style.position = "absolute";
      image.style.top = `${top}px`;
      image.style.left = `${left}px`;

      setTimeout(() => animateImage(image), 1000);
    });
    document.querySelectorAll(".sticker-img").forEach((sticker) => {
      let startX = 0;
      let startY = 0;

      sticker.addEventListener("dragstart", (e) => {
        const rect = sticker.getBoundingClientRect();
        startX = e.clientX - rect.left;
        startY = e.clientY - rect.top;

        e.dataTransfer.setDragImage(new Image(), 0, 0);
        sticker.setAttribute("dragging", true);
      });

      sticker.addEventListener("dragend", (e) => {
        const x = e.clientX - startX;
        const y = e.clientY - startY;

        sticker.style.left = `${x}px`;
        sticker.style.top = `${y}px`;

        sticker.removeAttribute("dragging");
      });

      document.addEventListener("dragover", (e) => e.preventDefault());
    });

    const stickersWrapper = document.querySelector(".stickers-wrapper");
    const stickerInfo = document.querySelector(".sticker-info");
    const stickerData = document.querySelector(".sticker-data");
    const stickerInfoExit = document.querySelector(".sticker-info-exit");
    const stickerInfoLink = document.querySelector(".sticker-info-link");
    const stickerInfoNext = document.querySelector(".sticker-info-next");
    const stickerInfoPrev = document.querySelector(".sticker-info-prev");
    let activeSticker = null;
    let isSecondStage = false;

    // Create overlay element
    const overlay = document.createElement("div");
    overlay.style.position = "fixed";
    overlay.style.top = "0";
    overlay.style.left = "0";
    overlay.style.width = "100%";
    overlay.style.height = "100%";
    overlay.style.backgroundColor = "rgba(0,0,0,0.01)";
    overlay.style.zIndex = "9999";
    overlay.style.display = "none";
    document.body.appendChild(overlay);

    function showOverlay() {
      overlay.style.display = "block";
    }

    function hideOverlay() {
      overlay.style.display = "none";
    }

    stickersWrapper.addEventListener("click", (e) => {
      const clickedSticker = e.target.closest(".sticker-img");

      if (clickedSticker) {
        showOverlay();
        if (
          clickedSticker.classList.contains("sticker-go-bag") ||
          clickedSticker.classList.contains("sticker-survival-guides")
        ) {
          showSpecialStickerInfo(clickedSticker, true);
        } else if (
          clickedSticker.classList.contains("sticker-subjectivity-worksheet")
        ) {
          showSpecialStickerInfo(clickedSticker, false);
        } else if (
          clickedSticker.classList.contains(
            "note" + clickedSticker.classList[1].slice(-1)
          )
        ) {
          showStickerInfo(clickedSticker);
        }
      }
    });

    stickerInfoExit.addEventListener("click", () => {
      showOverlay();
      hideStickerInfo();
    });

    stickerInfoNext.addEventListener("click", () => {
      if (
        activeSticker &&
        (activeSticker.classList.contains("sticker-go-bag") ||
          activeSticker.classList.contains("sticker-survival-guides"))
      ) {
        showOverlay();
        changeStage(true);
      }
    });

    stickerInfoPrev.addEventListener("click", () => {
      if (
        activeSticker &&
        (activeSticker.classList.contains("sticker-go-bag") ||
          activeSticker.classList.contains("sticker-survival-guides"))
      ) {
        showOverlay();
        changeStage(false);
      }
    });

    function changeStage(toSecondStage) {
      const underClass = activeSticker.classList.contains("sticker-go-bag")
        ? ".sticker-under-gb"
        : ".sticker-under-sg";
      const secondClass = activeSticker.classList.contains("sticker-go-bag")
        ? ".sticker-second-gb"
        : ".sticker-second-sg";
      const underElement = document.querySelector(underClass);
      const secondElement = document.querySelector(secondClass);

      underElement.style.transition = "opacity 1s ease-in-out";
      secondElement.style.transition = "opacity 1s ease-in-out";

      if (toSecondStage) {
        underElement.style.opacity = "0";
        secondElement.style.opacity = "1";
        stickerInfoNext.style.display = "none";
        stickerInfoPrev.style.display = "block";
      } else {
        underElement.style.opacity = "1";
        secondElement.style.opacity = "0";
        stickerInfoNext.style.display = "block";
        stickerInfoPrev.style.display = "none";
      }
      isSecondStage = toSecondStage;

      setTimeout(hideOverlay, 1000);
    }

    function showSpecialStickerInfo(sticker, hasSecondStage) {
      activeSticker = sticker;

      stickerData.textContent = sticker.dataset.sticker;

      const aspectRatio = 0.81;
      const height = window.innerHeight * 0.9;
      const width = height * aspectRatio;

      if (hasSecondStage) {
        stickerInfoLink.style.display = "block";
        stickerInfoLink.href = sticker.dataset.stickerLink;
        stickerInfoNext.style.display = "block";
        stickerInfoPrev.style.display = "none";
      } else {
        stickerInfoLink.style.display = "none";
        stickerInfoNext.style.display = "none";
        stickerInfoPrev.style.display = "none";
      }

      sticker.style.transition = "all 1s ease-in-out";
      sticker.style.position = "absolute";
      sticker.style.zIndex = "10000";
      sticker.style.height = `${height}px`;
      sticker.style.width = `${width}px`;
      sticker.style.left = `calc(50% - ${width / 2}px)`;
      sticker.style.top = `calc(50% - ${height / 2.1}px)`;

      if (sticker.classList.contains("sticker-go-bag")) {
        sticker.style.transform = "rotate(7.75deg)";
      } else if (sticker.classList.contains("sticker-survival-guides")) {
        sticker.style.transform = "rotate(-2.9deg)";
      } else if (sticker.classList.contains("sticker-subjectivity-worksheet")) {
        sticker.style.transform = "translate(-50%, -50%)";
        sticker.style.width = `auto`;
        sticker.style.left = `50%`;
        sticker.style.top = `50%`;
        sticker.style.height = `81%`;
      }

      stickerInfo.style.display = "block";
      stickerInfo.style.opacity = "0";
      requestAnimationFrame(() => {
        stickerInfo.style.transition = "opacity 1s ease-in-out";
        stickerInfo.style.opacity = "1";
      });

      let underClass, aboveClass;
      if (sticker.classList.contains("sticker-go-bag")) {
        underClass = ".sticker-under-gb";
        aboveClass = ".sticker-above-gb";
      } else if (sticker.classList.contains("sticker-survival-guides")) {
        underClass = ".sticker-under-sg";
        aboveClass = ".sticker-above-sg";
      } else if (sticker.classList.contains("sticker-subjectivity-worksheet")) {
        underClass = ".sticker-sw-pics";
        aboveClass = ".sticker-above-sw";
      }

      const underElement = document.querySelector(underClass);
      const aboveElement = document.querySelector(aboveClass);

      if (underElement && aboveElement) {
        underElement.style.transition = "opacity 1s ease-in-out";
        underElement.style.opacity = "1";
        aboveElement.style.transition = "opacity 1s ease-in-out";
        aboveElement.style.opacity = "0";
        aboveElement.style.zIndex = "1";
      }

      setTimeout(hideOverlay, 1000);
    }

    function showStickerInfo(sticker) {
      activeSticker = sticker;

      stickerData.textContent = sticker.dataset.sticker;

      const usersText = document.querySelector(".sticker-text");
      if (usersText) {
        usersText.remove();
      }

      stickerInfo.style.display = "block";
      stickerInfo.style.opacity = "0";
      requestAnimationFrame(() => {
        stickerInfo.style.transition = "opacity 1s ease-in-out";
        stickerInfo.style.opacity = "1";
      });

      let targetHeight = "92.7%";
      if (
        sticker.classList.contains("note2") ||
        sticker.classList.contains("note3") ||
        sticker.classList.contains("note4") ||
        sticker.classList.contains("note5") ||
        sticker.classList.contains("note7")
      ) {
        targetHeight = "66%";
      } else if (sticker.classList.contains("note6")) {
        targetHeight = "22.5%";
      }

      sticker.style.transition = "all 1s ease-in-out";
      sticker.style.position = "absolute";
      sticker.style.zIndex = "10000";
      sticker.style.left = "50%";
      sticker.style.top = "50%";
      sticker.style.width = "auto";
      sticker.style.height = targetHeight;
      sticker.style.transform = "translate(-50%, -50%)";

      if (sticker.classList.contains("note8")) {
        const inputField = document.createElement("textarea");
        inputField.classList.add("textarea-note");
        sticker.parentElement.appendChild(inputField);
        inputField.focus();

        // Создаем контейнер для индикатора
        const statusContainer = document.createElement("div");
        statusContainer.style.position = "absolute";
        statusContainer.style.top = "10px";
        statusContainer.style.right = "10px";
        statusContainer.style.color = "green";
        statusContainer.style.display = "none";
        sticker.parentElement.appendChild(statusContainer);

        inputField.addEventListener("keypress", function(event) {
          if (event.key === "Enter") {
            event.preventDefault();
            const text = inputField.value.trim();
            
            if (text) {
              // Блокируем поле ввода
              inputField.disabled = true;

              // Показываем индикатор отправки
              statusContainer.textContent = "Отправка...";
              statusContainer.style.display = "block";

              // Вызываем функцию отправки
              sendStickerTextViaAjax(text, (success) => {
                // Callback после отправки
                inputField.disabled = false;
                
                if (success) {
                  // Успешная отправка
                  statusContainer.textContent = "✓ Отправлено";
                  statusContainer.style.color = "green";
                  
                  // Очищаем поле через некоторое время
                  setTimeout(() => {
                    inputField.value = "";
                    statusContainer.style.display = "none";
                  }, 2000);
                } else {
                  // Ошибка отправки
                  statusContainer.textContent = "✗ Ошибка";
                  statusContainer.style.color = "red";
                  
                  // Возвращаем возможность редактирования
                  setTimeout(() => {
                    statusContainer.style.display = "none";
                  }, 2000);
                }
              });
            }
          }
        });
      }

      setTimeout(hideOverlay, 1000);
    }

    function hideStickerInfo() {
      const textArea = document.querySelector(".textarea-note");
      let textContent = "";

      if (textArea) {
        textContent = textArea.value;
        console.log(textContent);
        textArea.remove();
      }
      if (activeSticker) {
        if (activeSticker.classList.contains("note8")) {
          const stickerText = document.createElement("div");
          stickerText.classList.add("sticker-text");
          stickerText.textContent = textContent;

          stickerText.style.opacity = "0";
          stickerText.style.whiteSpace = "pre-wrap";
          stickerText.style.width = "100px";
          stickerText.style.height = "100px";
          stickerText.style.overflowWrap = "break-word";
          stickerText.style.overflow = "hidden";
          stickerText.style.textAlign = "center";
          stickerText.style.display = "block";
          stickerText.style.pointerEvents = "none";
          activeSticker.parentNode.insertBefore(
            stickerText,
            activeSticker.nextSibling
          );

          setTimeout(() => {
            stickerText.style.opacity = "1";
          }, 800);
        }
        activeSticker.style.transition = "all 1s ease-in-out";
        activeSticker.style.left = "";
        activeSticker.style.top = "";
        activeSticker.style.width = "";
        activeSticker.style.height = "";
        activeSticker.style.transform = "";
        activeSticker.style.zIndex = "";
        activeSticker = null;
      }

      stickerInfo.style.opacity = "0";
      setTimeout(() => {
        stickerInfo.style.display = "none";
        hideOverlay();
      }, 1000);

      const underClasses = [
        ".sticker-under-gb",
        ".sticker-under-sg",
        ".sticker-sw-pics",
      ];
      const aboveClasses = [
        ".sticker-above-gb",
        ".sticker-above-sg",
        ".sticker-above-sw",
      ];
      const secondClasses = [".sticker-second-gb", ".sticker-second-sg"];

      underClasses.forEach((cls) => {
        const element = document.querySelector(cls);
        if (element) element.style.opacity = "0";
      });
      aboveClasses.forEach((cls) => {
        const element = document.querySelector(cls);
        if (element) element.style.opacity = "1";
      });
      secondClasses.forEach((cls) => {
        const element = document.querySelector(cls);
        if (element) element.style.opacity = "0";
      });

      stickerInfoLink.style.display = "none";
      stickerInfoNext.style.display = "none";
      stickerInfoPrev.style.display = "none";
      isSecondStage = false;
    }

    document.querySelectorAll('.sticker-img').forEach(sticker => {
      sticker.addEventListener('mouseenter', () => {
        const horseText = document.getElementById("horse-text-original");
        if (horseText) {
          horseText.setAttribute('data-original', horseText.textContent || '');
          horseText.textContent = "sorry for being weird it's my first time being alive";
        }
      });
      
      sticker.addEventListener('mouseleave', () => {
        const horseText = document.getElementById("horse-text-original");
        if (horseText) {
          horseText.textContent = horseText.getAttribute('data-original') || '';
        }
      });
    });
  });
</script>

<script>
function sendStickerTextViaAjax(textToSend, callback) {
    const data = new FormData();
    data.append('action', 'send_sticker_email');
    data.append('user_text', textToSend);
    data.append('security', stickerEmailData.nonce);

    fetch(stickerEmailData.ajaxurl, {
        method: 'POST',
        body: data
    })
    .then(response => response.json())
    .then(result => {
        console.log(result);
        if (result.success) {
            // Используем глобальную функцию updateHorseText
            if (window.updateHorseText) {
                window.updateHorseText("successfully sent", 5000);
            }
            callback(true);
        } else {
            callback(false);
        }
    })
    .catch(error => {
        console.error('Ошибка:', error);
        callback(false);
    });
}
</script>

