<style>
    .diary-wrapper {
        position: absolute;
        width: 100vw;
        height: 100vh;
        top: 0;
        left: 0;
	    pointer-events: none;
    }
    .diary-mask-img {
        position: absolute;
        width: 90%;
        height: auto;
        top: 49.9%;
        left: 50%;
        transform: translate(-50%, -50%) scaleY(0.98);
    }
    .diary-page-wrapper {
        position: absolute;
        width: 62%;
        height: auto;
        top: 50.2%;
        left: 50%;
        transform: translate(-50%, -50%);
        aspect-ratio: 1.7777;
    }
    .diary-mask-svg {
        position: absolute;
        width: 100%;
        height: auto;
        top: 0;
        left: 0;
        aspect-ratio: 1.7777;
    }
    .page-switch {
        font-family: 'Avara-Bold';
        display: inline-block;
        position: absolute;
        bottom: 0;
        left: 50%;
        padding-bottom: 30px;
        transform: translateX(-50%);
        color: #B0B0B0;
        font-size: 30px;
        text-decoration: none;
    }
    .page-prev, .page-next {
        background-color: transparent;
        border: none;
        color: #B0B0B0;
        padding: 27px 30px 0 30px;
	    pointer-events: auto;
    }
    .diary-page {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        pointer-events: none;
        clip-path: url(#diaryMask);
        aspect-ratio: 1.7777;
        backface-visibility: hidden;
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }
    .diary-cover {
        position: absolute;
        width: 100%;
        height: auto;
        top: 0;
        left: 0;
    }

.diary-page:not(:first-child) {
    display: none;
}

    .mouse-spiral {
    position: absolute;
    width: 16%;
    top: 3%;
    left: 24%;
    animation: rotate 10s linear infinite;
    }

@keyframes rotate {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
.mouse-mask { 
  -webkit-mask-image: url(https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/mouse/mask.png);
  mask-image: url(https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/mouse/mask.png);
  mask-size: 100%;
  mask-repeat: no-repeat;
    width: 100%;
    height: 100%;
}
.ice-square {
    height: 19.8%;
    width: auto;
    left: 37.7%;
    top: 78%;
    position: absolute;
    animation: shakeICE 0.2s infinite;
}

@keyframes shakeICE {
    0% { transform: translate(0, 0); }
    25% { transform: translate(1px, -1px); }
    50% { transform: translate(-1px, 1px); }
    75% { transform: translate(1px, 1px); }
    100% { transform: translate(0, 0); }
}

.ice-directions {
    width: 20%;
    left: 15%;
    top: 3%;
    position: absolute;
    animation: rotateICE 5s linear infinite;
}

@keyframes rotateICE {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
.ice-items {
    width: 24.2%;
    left: 59.5%;
    top: 3.3%;
    position: absolute;
    animation: shakeICE 0.45s infinite;
}
.desktop-pieces {
width: 3.03%;
left: 74%;
top: 2%;
    transform-origin: bottom center;
    transform-origin: calc(50%) calc(96%);
filter: drop-shadow(0 0 5px rgba(0,0,0,0.45));
}
@keyframes rotatePIECES {
    0% { transform: rotate(var(--initial-rotate)); }
    45% { transform: rotate(calc(var(--initial-rotate) + 0deg)); }
    100% { transform: rotate(calc(var(--initial-rotate) + 360deg)); }
}

.dp-1 {
    --initial-rotate: 0.16deg;
    transform: rotate(var(--initial-rotate));
    animation: rotatePIECES 7s infinite;
}
.dp-2 {
    --initial-rotate: 29.24deg;
    transform: rotate(var(--initial-rotate));
    animation: rotatePIECES 8s infinite;
}
.dp-3 {
    --initial-rotate: 56deg;
    transform: rotate(var(--initial-rotate));
    animation: rotatePIECES 9s infinite;
}
.dp-4 {
    --initial-rotate: 86deg;
    transform: rotate(var(--initial-rotate));
    animation: rotatePIECES 10s infinite;
}
.dp-5 {
    --initial-rotate: 120deg;
    transform: rotate(var(--initial-rotate));
    animation: rotatePIECES 11s infinite;
}
.dp-6 {
    --initial-rotate: 164deg;
    transform: rotate(var(--initial-rotate));
    animation: rotatePIECES 12s infinite;
}
.sims {
    width: 4.1%;
    top: 4.5%;
    left: 2.4%;
    animation: shakeICE 0.45s infinite;
}
.desktop-square {
    height: 19.8%;
    width: auto;
    left: 61.2%;
    top: 18%;
    position: absolute;
    animation: shakeICE 0.2s infinite;
}
.middle-diary {
    position: absolute;
    width: 100%;
    height: 100%;
    pointer-events: none;
}
.middle-diary::before {
    content: '';
    width: 0.9px;
    background-color: rgba(0, 0, 0, 0.3);
    height: 98%;
    position: absolute;
    left: 50%;
    top: 1%;
}
.clips { 
    position: absolute;
    left: 50%;
    height: 48%;
    top: 50%;
    transform: translate(-50%, -50%);
}
.diary-page-prev {
    width: 50%;
    height: 100%;
    z-index: +1;
    position: absolute;
    background-color: transparent;
    border: none;
    pointer-events: auto;
}
.diary-page-next {
    width: 50%;
    height: 100%;
    z-index: +1;
    position: absolute;
    right: 0;
    background-color: transparent;
    border: none;
    pointer-events: auto;
}
</style>

<div class="diary-wrapper">
    <img class="diary-mask-img" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/diary-mask.png">

    <div class="diary-page-wrapper">
<svg class="diary-mask-svg">
  <clipPath id="diaryMask" clipPathUnits="objectBoundingBox"><path d="M0.5,0.011 L0.5,0.011 L0.5,0.011 L0.5,0.011 C0.5,0.011,0.5,0.011,0.5,0.011 L0.5,0.011 L0.5,0.011 L0.5,0.011 L0.501,0.011 C0.501,0.011,0.501,0.011,0.501,0.011 C0.501,0.011,0.502,0.011,0.502,0.011 C0.504,0.011,0.506,0.011,0.508,0.01 C0.513,0.01,0.52,0.009,0.529,0.008 C0.546,0.007,0.569,0.005,0.595,0.005 C0.714,0.006,0.815,0.008,0.887,0.009 C0.923,0.01,0.951,0.011,0.971,0.011 C0.98,0.011,0.988,0.012,0.993,0.012 C0.995,0.012,0.997,0.012,0.998,0.012 L1,0.012 L1,0.012 V0.99 L1,0.99 L0.998,0.99 L0.992,0.99 L0.969,0.99 C0.948,0.99,0.92,0.991,0.885,0.991 C0.817,0.993,0.726,0.994,0.636,0.995 C0.601,0.996,0.546,0.995,0.5,0.989 L0.5,0.989 L0.5,0.989 C0.46,1,0.397,1,0.356,1 C0.321,1,0.232,0.998,0.152,0.995 C0.111,0.994,0.073,0.992,0.045,0.991 C0.031,0.99,0.02,0.99,0.012,0.99 C0.008,0.989,0.005,0.989,0.003,0.989 L0,0.989 L0,0.989 V0.011 L0,0.011 L0.002,0.011 C0.004,0.011,0.006,0.011,0.009,0.011 C0.016,0.011,0.025,0.011,0.037,0.01 C0.06,0.01,0.092,0.009,0.128,0.008 C0.2,0.005,0.289,0.003,0.355,0.001 C0.395,0,0.471,0.004,0.5,0.011"></path></clipPath>
</svg>
    <div class="mouse-wrapper diary-page">
        <img class="diary-cover" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/mouse/background.png">
        <img class="diary-cover" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/mouse/border.png">
        <div class="mouse-mask"><img class="mouse-spiral" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/mouse/spiral.jpg"></div>
        <img class="diary-cover" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/mouse/girl.png">
    </div>
    <div class="peeps-wrapper diary-page" style="display:none;">
       <video class="diary-cover" autoplay muted loop controlsList="nodownload noremote noduration noplaybackrate" preload="auto">
          <source src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/peeps/00_%D0%92%D0%98%D0%94%D0%95%D0%9E.mp4" type="video/mp4">
            Ваш браузер не поддерживает воспроизведение видео.
        </video>
    </div>
    <div class="desktop-wrapper diary-page" style="display:none;">
        <img class="diary-cover desktop-main" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/desktop/000.jpg">
        <img class="diary-cover desktop-pieces dp-1" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/desktop/1.png">
        <img class="diary-cover desktop-pieces dp-2" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/desktop/2.png">
        <img class="diary-cover desktop-pieces dp-3" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/desktop/3.png">
        <img class="diary-cover desktop-pieces dp-4" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/desktop/4.png">
        <img class="diary-cover desktop-pieces dp-5" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/desktop/5.png">
        <img class="diary-cover desktop-pieces dp-6" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/desktop/6.png">
        <img class="diary-cover" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/desktop/girls.png">
        <img class="diary-cover sims" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/desktop/sims.png">
       <img class="diary-cover desktop-square" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/iceberg/square.png">
    </div>
    <div class="iceberg-wrapper diary-page" style="display:none;">
       <img class="diary-cover" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/iceberg/iceberg-cover.png">
       <img class="diary-cover ice-square" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/iceberg/square.png">
       <img class="diary-cover ice-directions" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/iceberg/iceberg-directions.png">
       <img class="diary-cover ice-items" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/iceberg/ice.png">
    </div>
    <div class="twins-wrapper diary-page" style="display:none;">
        <video class="diary-cover" autoplay muted loop controlsList="nodownload noremote noduration noplaybackrate" preload="auto">
          <source src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/twins/00_%D0%92%D0%98%D0%94%D0%95%D0%9E.mp4" type="video/mp4">
        </video>
    </div>
    <span class="middle-diary"><img class="clips" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/diary/clips.png"></span>
    <button class="diary-page-prev"></button><button class="diary-page-next"></button>
    </div>
<div class="page-switch">
    <button class="page-prev"><</button><span>|</span><button class="page-next">></button>
</div>
</div>