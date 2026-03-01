<script src="https://cdnjs.cloudflare.com/ajax/libs/parallax/2.1.3/parallax.min.js"></script>
<link rel="stylesheet" type="text/css" href="/wp-content/themes/blankslate/files/items/iphone/parallax-emoji.css">
<style>
    .cables {
        opacity: 1;
        mix-blend-mode: normal;
        pointer-events: none;
    }

    .iphone-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        height: 80vh;
        display: flex;
        flex-wrap: wrap;
        box-sizing: border-box;
        align-content: stretch;
        align-items: stretch;
        margin: 0;
        transition: all 0.5s ease-in-out;
        aspect-ratio: 0.5;
    }

    .lockscreen, .pass-screen, .apps-screen {
        height: 100%;
        position: absolute;
    }

    .lockscreen-img, .pass-screen-img, .apps-screen-img { 
        height: 100%;
    }

    #notification {
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        background: transparent;
        border: none;
    }

    .iphone-notification {
        opacity: 0;
        position: absolute;
        left: 49%;
        bottom: 15%;
        width: 5%;
        filter: drop-shadow(0 5px 3px rgba(0, 0, 0, 0.5));
        transition: all 0.5s ease;
    }

    .iphone-notification.notification {
        opacity: 0.93;
        bottom: 15%;
        width: 85%;
        left: 7.5%;
    }

    #lockscreen-left {
        position: absolute;
        right: 12%;
        bottom: 6%;
        width: 12.5%;
        height: 7.5%;
        background-color: transparent;
        border: none;
    }

    #lockscreen-right {
        position: absolute;
        left: 12%;
        bottom: 6%;
        width: 12.5%;
        height: 7.5%;
        background-color: transparent;
        border: none;
    }
    .left-emoji {
        transform: scale(0.5);
        position: absolute;
        width: 100%;
        height: 100%;
        display: flex;
        top: 0;
        justify-content: center;
        align-items: center;
        display: none;
        animation: scaleUp 0.5s forwards; /* Анимация с масштабированием */
        transform-origin: center;
    }
    @keyframes scaleUp {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(0.5);
        }
    }

    @keyframes scaleDown {
        from {
            transform: scale(0.5);
        }
        to {
            transform: scale(0);
        }
    }
    .right-emoji {
        position: absolute;
        width: 76%;
        top: 32%;
        left: 13.2%;
        transform-origin: center;
        display: none;
    }
    .right-emoji img { 
        width: 100% !important;
        height: 100% !important;
    }
    .right-emoji input {
        position: absolute;
        bottom: -27%;
        width: 100%;
    }
    .pass-numbers {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
    }
    .pass-numbers path {
        fill: transparent;
        stroke: 1px #e7e7e7;
    }
    .pass-numbers > path:hover {
        fill: transparent;
        stroke: #e7e7e7;
        stroke-width: 0.33px;
    }
    .pass-numbers > path:active {
        fill: #e7e7e7;
        stroke: #e7e7e7;
        stroke-width: 0.12px;
    }
    #pass-screen-emergency {
        position: absolute;
        left: 12%;
        bottom: 4.5%;
        width: 24%;
        height: 7.5%;
        background-color: transparent;
        border: none;
    }
    #pass-screen-cancel {
        position: absolute;
        right: 12%;
        bottom: 4.5%;
        width: 19.5%;
        height: 7.5%;
        background-color: transparent;
        border: none;
    }
    .clock-widget {
        position: absolute;
        top: 9%;
        right: 9%;
        width: 39%;
        height: auto;
        border-radius: 50%;
        filter: drop-shadow(-2px 4px 1.5px rgba(0, 0, 0, 0.45))
    }
    .touch-id {
        position: absolute;
        top: 34%;
        left: 9%;
        width: 39%;
        height: auto;
        border-radius: 50%;
        filter: drop-shadow(-2px 4px 1.5px rgba(0, 0, 0, 0.45))
    }
    .eye-widget {
        position: absolute;
        width: 79%;
        left: 10.5%;
        top: 58%;
        border-radius: 20px;
        filter: drop-shadow(-2px 4px 1.5px rgba(0, 0, 0, 0.45))
    }
    .apps-bar {
        position: absolute;
        width: 84%;
        left: 8%;
        top: 85%;
        border-radius: 25px;
        height: 11%;
        filter: drop-shadow(-2px 4px 1.5px rgba(0, 0, 0, 0.45))
    }

    .image-container video {
        width: 100%;
        border-radius: inherit;
        display: block;
        height: 100%;
        animation-play-state: paused !important;
    }

    .image-container div {
        --border-width: 0.81px;
        --border-color-1: rgba(44,44,44,0.39);
        --border-color-2: rgba(212,212,212,0.81);
        display: inline-block;
    }

    .image-container div::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: inherit;
        background: 
            linear-gradient(to top right, 
            var(--border-color-1) 0%,
            var(--border-color-1) 20%,
            var(--border-color-2) 70%,
            var(--border-color-2) 100%
            );
        mask:
            linear-gradient(#fff 0 0) content-box,
            linear-gradient(#fff 0 0);
        mask-composite: exclude;
        padding: var(--border-width);
    }
    .iphone-links {
        position:  absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .iphone-links a {
        position: absolute;
        width: 15.7%;
        height: 10.8%;
    }
    .tiktok {
        left: 10.2%;
        top: 9%;
    }
    .instagram {
        left: 31.8%;
        top: 9%;
    }
    .youtube {
        left: 10.2%;
        top: 21%;
    }
    .tumblr {
        left: 31.8%;
        top: 21%;
    }
    .soundcloud {
        right: 31.5%;
        top: 33.3%;
    }
    .spotify {
        right: 10.2%;
        top: 33.3%;
    }
    .pinterest {
        right: 31.5%;
        top: 45.3%;
    }
    .telegram {
        right: 10.2%;
        top: 45.3%;
    }
    #time {
        position: absolute;
        top: 15%;
        font-family: "Henny Penny";
        color: #8F8E8C;
        width: 100%;
        text-align: center;
        font-size: 10vh;
    }
    #date {
        position: absolute;
        top: 9.6%;
        font-family: "This reality";
        color: #8F8E8C;
        width: 100%;
        text-align: center;
        font-size: 3vh;
    }
        
    .sticker-info-i {
        position: absolute;
        width: 100vw;
        height: 100vh;
        background-color: #151413;
        z-index: 9999;
        display: none;
        top: 0;
    }
    .sticker-data-i {
        font-family: 'Avara';
        color: #b0b0b0;
        opacity: 20%;
        padding-left: 30px;
        padding-top: 30px;
        position: absolute;
        top: 0;
        left: 0;
        font-size: 1.5em;
    }
    .sticker-info-exit-i {
        font-family: 'Avara';
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
    .sticker-info-exit-i:hover {
        opacity: 60%;
    }
    .sticker-info-link-i {
    font-family: 'Avara-Bold';
        color: #b0b0b0;
        opacity: 60%;
        padding-left: 30px;
        padding-bottom: 30px;
        position: absolute;
        bottom: 0;
        left: 0;
        font-size: 1.5em;
        text-decoration: none;
    }
    .sticker-info-link-i:hover {
        opacity: 90%;
    }
    .sticker-info-next-i {
    font-family: 'Avara-Bold';
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
        margin: 15vh 0;
    }
    .sticker-info-prev-i {
        font-family: 'Avara-Bold'; 
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
    .sticker-info-prev-i:hover,
    .sticker-info-next-i:hover {
        opacity: 90%;
    }
	.sticker-info-img-1 {
        height: 81%;
        position: absolute;
		width: auto;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
	.sticker-info-img-2 {
        height: 81%;
        position: absolute;
        width: auto;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0;
	}
</style>

<div class="iphone-background">
    <img class="noise-blik cables" src="/wp-content/themes/blankslate/files/items/cables.png">
</div>

<div class="sticker-info-i">
    <span class="sticker-data-i">ϲ๏𝙧єarea:\𝓷ѻℍѻოⲉ\survival𖥻៹guides.pdf"</span>
    <span class="sticker-info-exit-i">-exit-</span>
    <img class="sticker-info-img-1" src="/wp-content/themes/blankslate/files/main-page/survival%20guides.jpg">
    <img class="sticker-info-img-2" src="/wp-content/themes/blankslate/files/main-page/survivalguides2.jpg">
    <a class="sticker-info-link-i" href="/wp-content/themes/blankslate/files/main-page/survival_guide_pdf.pdf" target="_blank">download</a>
    <button class="sticker-info-next-i">></button>
    <button class="sticker-info-prev-i"><</button>
</div>

<div class="iphone-container">
    <audio id="notification-sound" src="/wp-content/themes/blankslate/files/items/iphone/iphone.ogg" preload="auto"></audio>
    <div class="lockscreen">
        <img class="lockscreen-img" src="/wp-content/themes/blankslate/files/items/iphone/lockscreen-img.png">
        <button id="notification">
            <img class="iphone-notification" src="/wp-content/themes/blankslate/files/items/iphone/notification.png">
        </button>
        <div id="date"></div>
        <div id="time"></div>
        <button id="lockscreen-left"></button>
        <button id="lockscreen-right"></button>
        <div class="right-emoji">
            <img class="emoji" src="/wp-content/themes/blankslate/files/items/iphone/emoji/1.png" id="emoji-img">
            <input type="range" min="0" max="4" step="1" id="emoji-range">
        </div>
        <div class="left-emoji">
            <ul id="emoji">
                <li class="layer" data-depth="0.2">
                    <div class="face"></div>
                </li>
                <li class="layer" data-depth="0.3">
                    <div class="shine"></div>
                </li>
                <li class="layer" data-depth="0.8">
                    <div class="eye left"></div>
                </li>
                <li class="layer" data-depth="0.8">
                    <div class="eye right"></div>
                </li>
                <li class="layer" data-depth="0.8">
                    <div class="mouth"></div>
                </li>
            </ul>
        </div>
    </div>

    <div class="pass-screen" style="display:none;">
        <img class="pass-screen-img" src="/wp-content/themes/blankslate/files/items/iphone/pass-screen.png">
        <svg class="pass-numbers" viewBox="0 0 412 822" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g class="stars" filter="url(#filter2_b_4282_6482)">
            <path d="M108 218.968L109.967 222.227L110.068 222.396L110.258 222.45L113.817 223.463L111.476 226.547L111.366 226.692L111.375 226.874L111.575 230.803L108.191 229.403L108 229.324L107.809 229.403L104.425 230.803L104.625 226.874L104.634 226.692L104.524 226.547L102.183 223.463L105.742 222.45L105.932 222.396L106.033 222.227L108 218.968Z" stroke="#E7E7E7" stroke-opacity="0.6"/>
            <path d="M157 218.968L158.967 222.227L159.068 222.396L159.258 222.45L162.817 223.463L160.476 226.547L160.366 226.692L160.375 226.874L160.575 230.803L157.191 229.403L157 229.324L156.809 229.403L153.425 230.803L153.625 226.874L153.634 226.692L153.524 226.547L151.183 223.463L154.742 222.45L154.932 222.396L155.033 222.227L157 218.968Z" stroke="#E7E7E7" stroke-opacity="0.6"/>
            <path d="M206 218.968L207.967 222.227L208.068 222.396L208.258 222.45L211.817 223.463L209.476 226.547L209.366 226.692L209.375 226.874L209.575 230.803L206.191 229.403L206 229.324L205.809 229.403L202.425 230.803L202.625 226.874L202.634 226.692L202.524 226.547L200.183 223.463L203.742 222.45L203.932 222.396L204.033 222.227L206 218.968Z" stroke="#E7E7E7" stroke-opacity="0.6"/>
            <path d="M255 218.968L256.967 222.227L257.068 222.396L257.258 222.45L260.817 223.463L258.476 226.547L258.366 226.692L258.375 226.874L258.575 230.803L255.191 229.403L255 229.324L254.809 229.403L251.425 230.803L251.625 226.874L251.634 226.692L251.524 226.547L249.183 223.463L252.742 222.45L252.932 222.396L253.033 222.227L255 218.968Z" stroke="#E7E7E7" stroke-opacity="0.6"/>
            <path d="M304 218.968L305.967 222.227L306.068 222.396L306.258 222.45L309.817 223.463L307.476 226.547L307.366 226.692L307.375 226.874L307.575 230.803L304.191 229.403L304 229.324L303.809 229.403L300.425 230.803L300.625 226.874L300.634 226.692L300.524 226.547L298.183 223.463L301.742 222.45L301.932 222.396L302.033 222.227L304 218.968Z" stroke="#E7E7E7" stroke-opacity="0.6"/>
            </g>
            <path class="clickable" d="M119.555 289.508C127.953 291.094 135.562 295.487 141.134 301.967C146.428 308.123 149.592 315.824 150.155 323.924L150.257 325.385C150.838 333.748 148.909 342.093 144.718 349.352L143.827 350.895C139.636 358.155 133.373 363.997 125.841 367.675L124.525 368.318C117.228 371.88 108.977 372.991 100.998 371.484C92.6007 369.898 84.9917 365.505 79.4196 359.026C74.1255 352.869 70.9613 345.168 70.3984 337.068L70.2968 335.607C69.7156 327.245 71.6441 318.899 75.8353 311.64L76.7262 310.097C80.9174 302.838 87.1804 296.995 94.7128 293.317L96.0288 292.675C103.325 289.112 111.577 288.002 119.555 289.508Z" fill="#E7E7E7" fill-opacity="0.09"/>
            <path class="clickable" d="M187.035 293.137C194.488 288.954 203.14 287.428 211.574 288.81C219.586 290.123 226.961 293.989 232.599 299.832L233.615 300.886C239.436 306.918 243.323 314.55 244.778 322.805L245.088 324.56C246.543 332.815 245.501 341.317 242.095 348.976L241.5 350.314C238.2 357.733 232.593 363.888 225.513 367.862C218.061 372.045 209.408 373.571 200.974 372.189C192.962 370.876 185.587 367.01 179.95 361.167L178.933 360.113C173.112 354.081 169.226 346.448 167.77 338.193L167.461 336.439C166.005 328.184 167.047 319.682 170.453 312.023L171.048 310.685C174.348 303.266 179.955 297.111 187.035 293.137Z" fill="#E7E7E7" fill-opacity="0.09"/>
            <path class="clickable" d="M276.841 297.042C283.454 291.628 291.71 288.623 300.255 288.52C308.374 288.421 316.308 290.948 322.875 295.723L324.059 296.585C330.839 301.515 335.992 308.356 338.859 316.233L339.468 317.907C342.335 325.784 342.785 334.338 340.761 342.472L340.407 343.893C338.446 351.772 333.993 358.807 327.71 363.95C321.097 369.364 312.841 372.369 304.296 372.472C296.177 372.571 288.243 370.044 281.676 365.269L280.492 364.408C273.713 359.478 268.559 352.636 265.692 344.759L265.083 343.085C262.216 335.208 261.766 326.655 263.79 318.521L264.144 317.1C266.105 309.22 270.559 302.185 276.841 297.042Z" fill="#E7E7E7" fill-opacity="0.09"/>
            <path class="clickable" d="M164.587 435.801C163.205 427.367 164.731 418.714 168.914 411.262C172.888 404.182 179.043 398.575 186.462 395.275L187.8 394.68C195.459 391.274 203.961 390.232 212.216 391.687L213.97 391.997C222.225 393.452 229.858 397.339 235.89 403.16L236.944 404.176C242.787 409.814 246.653 417.189 247.966 425.201C249.348 433.635 247.822 442.287 243.639 449.74C239.665 456.82 233.51 462.427 226.091 465.727L224.753 466.322C217.094 469.728 208.592 470.77 200.337 469.314L198.583 469.005C190.328 467.549 182.695 463.663 176.663 457.842L175.609 456.825C169.766 451.188 165.9 443.813 164.587 435.801Z" fill="#E7E7E7" fill-opacity="0.09"/>
            <path class="clickable" d="M84.8413 397.042C91.4539 391.628 99.7102 388.623 108.255 388.52C116.374 388.421 124.308 390.948 130.875 395.723L132.059 396.585C138.839 401.515 143.992 408.356 146.859 416.233L147.468 417.907C150.335 425.784 150.785 434.338 148.761 442.472L148.407 443.893C146.446 451.772 141.993 458.807 135.71 463.95C129.097 469.364 120.841 472.369 112.296 472.472C104.177 472.571 96.2433 470.044 89.6764 465.269L88.492 464.408C81.7126 459.478 76.5594 452.636 73.6925 444.759L73.0831 443.085C70.2161 435.208 69.766 426.655 71.7905 418.521L72.1442 417.1C74.1051 409.22 78.5586 402.185 84.8413 397.042Z" fill="#E7E7E7" fill-opacity="0.09"/>
            <path class="clickable" d="M262.138 442.968C259.312 434.903 259.312 426.117 262.138 418.051C264.822 410.388 269.91 403.797 276.643 399.26L277.857 398.442C284.809 393.757 293 391.255 301.383 391.255H303.164C311.547 391.255 319.738 393.757 326.689 398.442L327.904 399.26C334.637 403.797 339.725 410.388 342.409 418.051C345.235 426.117 345.235 434.903 342.409 442.968C339.725 450.631 334.637 457.222 327.904 461.76L326.689 462.578C319.738 467.262 311.547 469.765 303.164 469.765H301.383C293 469.765 284.809 467.262 277.857 462.578L276.643 461.76C269.91 457.222 264.822 450.631 262.138 442.968Z" fill="#E7E7E7" fill-opacity="0.09"/>
            <path class="clickable" d="M196.993 571.484C188.596 569.898 180.987 565.505 175.415 559.025C170.121 552.869 166.957 545.168 166.394 537.068L166.292 535.607C165.711 527.245 167.639 518.899 171.831 511.64L172.722 510.097C176.913 502.838 183.176 496.995 190.708 493.317L192.024 492.675C199.32 489.112 207.572 488.002 215.551 489.508C223.948 491.094 231.557 495.487 237.129 501.967C242.423 508.123 245.588 515.824 246.15 523.924L246.252 525.385C246.833 533.747 244.905 542.093 240.714 549.352L239.823 550.895C235.631 558.155 229.368 563.997 221.836 567.675L220.52 568.318C213.224 571.88 204.972 572.991 196.993 571.484Z" fill="#E7E7E7" fill-opacity="0.09"/>
            <path class="clickable" d="M168.909 651.739C164.726 644.287 163.201 635.634 164.582 627.201C165.895 619.188 169.761 611.814 175.604 606.176L176.658 605.159C182.69 599.339 190.323 595.452 198.578 593.996L200.333 593.687C208.588 592.231 217.089 593.273 224.748 596.679L226.086 597.275C233.505 600.574 239.66 606.181 243.634 613.262C247.817 620.714 249.343 629.367 247.961 637.8C246.648 645.813 242.782 653.187 236.939 658.825L235.885 659.842C229.853 665.662 222.221 669.549 213.966 671.004L212.211 671.314C203.956 672.769 195.454 671.727 187.795 668.321L186.457 667.726C179.038 664.427 172.883 658.819 168.909 651.739Z" fill="#E7E7E7" fill-opacity="0.09"/>
            <path class="clickable" d="M135.709 563.958C129.097 569.372 120.841 572.377 112.295 572.48V572.48C104.176 572.579 96.2429 570.052 89.6761 565.277L88.4917 564.415C81.7123 559.485 76.559 552.644 73.6921 544.767L73.0827 543.093C70.2157 535.216 69.7657 526.662 71.7901 518.528L72.1438 517.107C74.1048 509.228 78.5582 502.193 84.8409 497.05V497.05C91.4535 491.636 99.7098 488.631 108.255 488.527V488.527C116.374 488.429 124.308 490.956 130.874 495.731L132.059 496.592C138.838 501.522 143.991 508.364 146.858 516.241L147.468 517.915C150.335 525.792 150.785 534.345 148.76 542.479L148.407 543.9C146.446 551.78 141.992 558.815 135.709 563.958V563.958Z" fill="#E7E7E7" fill-opacity="0.09"/>
            <path class="clickable" d="M300.251 572.472C291.706 572.368 283.45 569.363 276.837 563.95V563.95C270.555 558.806 266.101 551.771 264.14 543.892L263.787 542.471C261.762 534.337 262.212 525.783 265.079 517.906L265.689 516.232C268.555 508.355 273.709 501.514 280.488 496.584L281.672 495.723C288.239 490.947 296.173 488.421 304.292 488.519V488.519C312.837 488.623 321.093 491.628 327.706 497.041V497.041C333.989 502.184 338.442 509.22 340.403 517.099L340.757 518.52C342.781 526.654 342.331 535.207 339.464 543.084L338.855 544.759C335.988 552.635 330.835 559.477 324.055 564.407L322.871 565.268C316.304 570.044 308.37 572.57 300.251 572.472V572.472Z" fill="#E7E7E7" fill-opacity="0.09"/>
        </svg>
        <button id="pass-screen-emergency"></button>
        <button id="pass-screen-cancel"></button>
    </div>


    <div class="apps-screen" style="display:none;">

   <img class="apps-screen-img" src="/wp-content/themes/blankslate/files/items/iphone/apps-screen.png">


    <div class="iphone-links">
        <a class="tiktok" href="https://www.tiktok.com/@n0h0me_user" target="_blank" rel="noopener"></a>
        <a class="instagram" href="https://www.instagram.com/noh0me_user/" target="_blank" rel="noopener"></a>
        <a class="pinterest" href="https://pinterest.com/123456789noh0me/" target="_blank" rel="noopener"></a>
        <a class="soundcloud" href="https://soundcloud.com/no-home-312498155" target="_blank" rel="noopener"></a>
        <a class="tumblr" href="https://www.tumblr.com/noh0me" target="_blank" rel="noopener"></a>
        <a class="youtube" href="https://www.youtube.com/channel/UCdfhILTwyvE8XEUPw4fv2cA" target="_blank" rel="noopener"></a>
        <a class="telegram" href="https://t.me/n0h0me_cloud" target="_blank" rel="noopener"></a>
        <a class="spotify" href="https://open.spotify.com/user/31oyh3auvyslqco6ttkyb7dp3adu?si=e656e70d2f244a51" target="_blank" rel="noopener"></a>
    </div>

    <div class="image-container">
        <div class="clock-widget">
            <video loop muted playsinline>
                <source src="/wp-content/themes/blankslate/files/items/iphone/clock-widget.mp4" type="video/mp4">
            </video>
        </div>
        <div class="touch-id">
            <video loop muted playsinline>
                <source src="/wp-content/themes/blankslate/files/items/iphone/touch-id.mp4" type="video/mp4">
            </video>
        </div>
        <div class="apps-bar">
            <video loop muted playsinline>
                <source src="/wp-content/themes/blankslate/files/items/iphone/apps-bar.mp4" type="video/mp4">
            </video>
        </div>
        <div class="eye-widget">
            <video loop muted playsinline>
                <source src="/wp-content/themes/blankslate/files/items/iphone/eye-widget.mp4" type="video/mp4">
            </video>
        </div>
    </div>
</div>

</div>