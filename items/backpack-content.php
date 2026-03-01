<style>
    .backpack-wrapper {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 87vh;
        height: 87vh;
        overflow: hidden;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .backpack-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle, 
                    rgba(53, 52, 48, 0.7) 10%, 
                    rgba(53, 52, 48, 0.7) 20%, 
                    rgba(53, 52, 48, 0.7) 30%, 
                    rgba(53, 52, 48, 0.7) 40%, 
                    rgba(53, 52, 48, 0.7) 50%, 
                    rgba(53, 52, 48, 0.6) 60%, 
                    rgba(53, 52, 48, 0) 70%, 
                    rgba(53, 52, 48, 0) 80%, 
                    rgba(53, 52, 48, 0) 90%, 
                    rgba(53, 52, 48, 0) 100%);
        pointer-events: none;
    }

    #backpack-container {
        width: 93%;
        height: 93%;
        mask-image: radial-gradient(circle, black 60%, transparent 70%);
        -webkit-mask-image: radial-gradient(circle, black 60%, transparent 70%);
    }
    #backpack-container {
        width: 100%;
        height: 100%;
        position: relative;
        overflow: hidden;
        border-radius: 50%;
    }
    .image {
        position: absolute;
        transition: opacity 1s ease;
        cursor: pointer;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
    }
    .enlarged {
        transition: all 1s ease;
        filter: drop-shadow(0 0 2px white);
    }
    .youwillbeokay {
        position: absolute;
        width: 95%;
        height: 95%;
        z-index: +1;
        pointer-events: none;
        animation: 30s linear infinite running youwillbeokay;
    }
    @keyframes youwillbeokay {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
    }
    .backpack-items-name {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        font-family: 'Avara-Bold';
        color: #B0B0B0;
        font-size: 21px;
    }
    .backpack-items-name::before,
    .backpack-items-name::after {
        content: '-'
    }
    .backpack-items-name:empty::before,
    .backpack-items-name:empty::after {
        content: none;
    }
</style>

<div class="backpack-wrapper">
    <img class="youwillbeokay" src="/wp-content/themes/blankslate/files/items/backback/youwillbeokay.png">
    <div id="backpack-container"></div>
</div>
<div class="backpack-items-name"></div>