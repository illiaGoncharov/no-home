<!-- wp:html -->
<head>
<link rel="stylesheet" href="https://nohome.cloud/wp-content/themes/blankslate/files/test/fog.css">
</head>

<style>
.cave-classiki {
  opacity: 0;
  position: absolute;
  top: 0;
  left: 0;
  transition: opacity 0.3s ease-in-out;
}

.light-cave {
  opacity: 0;
  transition: opacity 1s ease-in-out;
}

.safety-helmet-img, .safety-helmet-flash-img {
   opacity: 0;
   transition: opacity 2s ease-out;
}
.mirror {
 z-index: 20;
}
.pixel-mirror {
z-index: 21;
/*filter: blur(3px);*/
transition: filter 1s ease;
}
.fly {
    position: absolute;
    width: 42px;
    height: 42px;
    background-image: url('https://nohome.cloud/wp-content/themes/blankslate/files/test/fly2.png');
    background-size: contain;
    background-repeat: no-repeat;
    transition: transform 0.5s, left 0.5s, top 0.5s;
    mix-blend-mode: multiply;
    /*filter: drop-shadow(0 0 3px black);*/
    z-index: 1000000;
}
.foggy {
  position: relative;
  width: 150%;
  height: 100%;
  transform-style: preserve-3d;
  transform: translate(-20%) translateY(15%);
  filter: opacity(0.81);
}
.material {
display: none;
}
</style>

    <audio id="walkiephoneSound" src="https://nohome.cloud/wp-content/themes/blankslate/files/cave-room/walkiephone.ogg"></audio>
    <audio id="caveSound" loop src="https://nohome.cloud/wp-content/themes/blankslate/files/cave-room/cave.ogg"></audio>

<!-- ////////////// CAVE-ROOM-MAIN ////////////////// -->

<div id="cave-room-main" class="room-wrapper animated-display">
    <img class="room-background-img" src="https://nohome.cloud/wp-content/themes/blankslate/files/cave-room/Room_2_4k_1-standard-height-2160px.jpg" alt="Room with a cave">
    <img class="object-overlay mirror" src="https://nohome.cloud/wp-content/themes/blankslate/files/cave-room/Room_2_4k_mirror_1-standard-height-2160px.png" alt="Mirror">
    <img class="room-background-img darken-cave" style="filter: opacity(0);" src="https://nohome.cloud/wp-content/themes/blankslate/files/cave-room/cave-dark.jpg" alt="Darken cave room">
    <img class="room-background-img light-cave" src="/wp-content/themes/blankslate/files/cave-room/cave-room-main-light.jpg">
            <img src="/wp-content/themes/blankslate/files/cave-room/animation/1.png" class="room-background-img cave-classiki" alt="Image 1">
        <img src="/wp-content/themes/blankslate/files/cave-room/animation/2.png" class="room-background-img cave-classiki" alt="Image 2">
        <img src="/wp-content/themes/blankslate/files/cave-room/animation/3.png" class="room-background-img cave-classiki" alt="Image 3">
        <img src="/wp-content/themes/blankslate/files/cave-room/animation/4.png" class="room-background-img cave-classiki" alt="Image 4">
        <img src="/wp-content/themes/blankslate/files/cave-room/animation/5.png" class="room-background-img cave-classiki" alt="Image 5">
        <img src="/wp-content/themes/blankslate/files/cave-room/animation/6.png" class="room-background-img cave-classiki" alt="Image 6">
        <img src="/wp-content/themes/blankslate/files/cave-room/animation/7.png" class="room-background-img cave-classiki" alt="Image 7">
        <img src="/wp-content/themes/blankslate/files/cave-room/animation/8.png" class="room-background-img cave-classiki" alt="Image 8">
        <img src="/wp-content/themes/blankslate/files/cave-room/animation/9.png" class="room-background-img cave-classiki" alt="Image 9">
        <img src="/wp-content/themes/blankslate/files/cave-room/animation/10.png" class="room-background-img cave-classiki" alt="Image 10">
        <img src="https://nohome.cloud/wp-content/themes/blankslate/files/cave-room/mirror/mirror.gif" class="room-background-img pixel-mirror" alt="Pixel mirror">

    <svg class="object-overlay items-in-cave-room-main" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 3840 2160" preserveAspectRatio="xMidYMid slice">
  <defs>
    <filter id="glow" x="-50%" y="-50%" width="200%" height="200%">
      <!---feMorphology in="SourceAlpha" result="morphed" operator="dilate" radius="3"/--->
      <feGaussianBlur in="morphed" result="blurred" stdDeviation="6"/>
      <feFlood flood-color="#FFFDF0" result="glowColor"/>
      <feComposite in="glowColor" in2="blurred" operator="in" result="softGlow"/>
      <feMerge>
        <feMergeNode in="softGlow"/>
        <!---feMergeNode in="SourceGraphic"/--->
      </feMerge>
    </filter>
  </defs>
<rect class="overlay-svg to-cave no-glow" id="arrow-right-button" width="1500" height="1800" x="2300" y="100"/>
        <a xlink:href="javascript:void(0);" id="CaveMainOverlay">
            <path class="overlay-svg no-glow" id="mirror-svg-overlay" pointer-events="bounding-box" d="M881.089 346C873.483 351.2 865.477 356.4 863.875 356.8C861.874 357.6 863.075 392.4 866.678 434C869.88 475.6 875.484 543.2 878.687 584C881.889 624.8 887.094 691.2 890.296 732C923.922 1146 924.723 1156.4 920.72 1224.4C917.117 1285.6 907.509 1580.8 902.706 1782L900.704 1870L916.717 1883.6C932.329 1896.8 932.729 1896.8 952.745 1892C980.366 1885.2 984.77 1888 984.77 1910.8C984.77 1921.2 985.971 1936.8 987.172 1944.8C989.574 1958.4 991.575 1960.4 1009.19 1966L1028.4 1972.4L1155.7 1944C1355.46 1899.2 1497.57 1867.2 1518.79 1862.4C1529.6 1860 1538.4 1856.8 1538.4 1854.8C1538 1845.6 1532 1769.2 1527.19 1710C1523.99 1672.4 1513.98 1553.6 1505.18 1446C1496.37 1338 1486.36 1218.4 1483.16 1180C1479.96 1141.6 1472.75 1054 1467.15 986C1461.54 917.6 1454.34 829.6 1451.13 790C1437.92 634.4 1432.72 574.4 1425.11 480.4C1420.71 426.8 1416.31 382 1415.11 380.8C1414.31 380 1342.65 373.2 1256.18 365.6C1169.71 358.4 1066.43 349.6 1026.8 346.4C890.296 334.8 896.301 334.8 881.089 346Z" fill="black"/>
        </a>
            <path class="overlay-svg items-next-to-mirror" pointer-events="bounding-box" d="M632.4 318.694C610 334.709 604.4 391.562 621.6 426.394C630 442.809 630.8 446.413 625.6 451.217C619.6 457.623 618.4 464.029 623.2 470.835C626.8 476.04 668 485.649 690 486.049C705.2 486.45 706 485.649 707.2 473.237C708 464.429 706.4 459.625 702.4 458.023C696.8 456.022 696.8 454.42 703.2 443.21C714 423.191 712.8 363.536 701.2 341.516C696 332.307 688 321.897 683.2 318.694C671.6 310.287 644.4 310.687 632.4 318.694ZM661.6 332.707C672 323.899 696 362.735 696 388.359C696 400.77 681.6 440.007 676.4 440.807C663.6 443.61 650.8 441.608 646 436.403C628 416.385 621.2 364.737 633.6 341.115C639.2 329.905 641.2 328.704 648.4 332.707C654 335.51 658 335.51 661.6 332.707Z" fill="black"/>
            <path class="overlay-svg items-next-to-mirror" pointer-events="bounding-box" d="M464 479.243C456.8 485.649 446.8 502.865 440 520.081C430 544.904 428 554.913 428 584.941C428 641.794 438 675.825 464.8 709.056C490 740.285 531.6 745.489 552.8 720.266C558.8 713.059 564.8 702.65 566 696.644C567.2 690.639 574 680.629 580.4 674.224C602 653.805 609.2 634.587 611.2 594.149C612.8 563.721 611.6 554.913 604.4 537.697C586.4 496.859 542.4 468.433 496 468.433C480 468.433 474 470.435 464 479.243Z" fill="black"/>
            <path class="overlay-svg items-next-to-mirror" pointer-events="bounding-box" d="M657.2 763.506C649.6 775.117 649.2 784.325 654 897.63C656.4 950.879 656 952.881 648.4 952.881C644 952.881 639.6 956.084 638.8 959.687C625.2 1008.13 625.6 1022.55 640.4 1037.36C653.2 1050.17 686 1046.17 699.2 1030.55C707.6 1020.94 708.8 1016.54 707.2 995.721C705.6 975.702 703.6 970.097 694.8 962.49C685.2 954.483 684 950.479 684 928.859V904.837H698.4H712.4L709.6 859.595C708 835.172 705.6 812.752 703.6 810.75C702 808.347 699.2 797.137 697.6 785.526C694 757.901 688 759.102 687.6 787.528L687.2 810.75L683.6 790.731C678.4 758.702 676 752.696 670 752.696C666.8 752.696 660.8 757.5 657.2 763.506ZM668 800.34C673.6 811.15 673.2 812.752 664 812.752C658 812.752 656 809.949 656 802.742C656 790.731 662 789.53 668 800.34ZM676 919.65C676 928.058 677.2 938.868 678.4 943.673C680.4 951.28 679.2 952.881 672.4 952.881C664.8 952.881 664 950.479 664 928.859C664 910.042 665.2 904.837 670 904.837C674.4 904.837 676 909.241 676 919.65Z" fill="black"/>
            <path class="overlay-svg items-next-to-mirror" pointer-events="bounding-box" d="M389.2 871.206C388 874.809 388.8 883.617 391.2 891.224C395.2 904.036 394.8 904.837 385.6 904.837H375.6L376.8 955.684L378 1006.93L414 1008.13C463.6 1009.73 462.8 1010.53 460.4 950.879L458 902.835L438 901.634L417.6 900.433L419.2 886.019C420.4 876.811 419.2 870.805 415.6 868.403C406.4 862.798 392 864.399 389.2 871.206ZM409.2 887.22C407.6 891.224 405.6 892.025 403.2 889.623C398.4 884.818 402.8 875.61 408 878.813C410 880.014 410.4 884.018 409.2 887.22Z" fill="black"/>
    </svg>


<!-- Right Arrow Button -->
  <!---div class="container">
    <div class="row">
      <div class="col-12">
        <button id="arrow-right-button" class="arrow-button">
            <img class="arrow arrow-white" src="https://nohome.cloud/wp-content/themes/blankslate/files/nav/arrow-right.png" alt="Left arrow">
        </button>
      </div>
    </div>
  </div--->
</div>

<!-- ////////////// JUST CAVE ////////////////// -->

<div id="just-cave" class="room-wrapper animated-display hide-elements" style="display: none">
    <img class="room-background-img" src="https://nohome.cloud/wp-content/themes/blankslate/files/cave-room/Room_2_4k_cave1-standard-width-3840px.jpg" alt="Room with a cave">
<div class="fly"></div>
<!--div class="container3d"><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="trigger"></div><div class="monitor"><div class="camera o-x"><div class="camera o-y"><div class="camera o-z"><div class="foggy"><div class="material"></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div><div class="fog"><div class="fog_graphic"></div></div></div></div></div></div></div></div-->

<!-- Left Arrow Button -->
  <div class="container">
    <div class="row">
      <div class="col-12">
        <button id="arrow-left-button" class="arrow-button arrow-left-button">
            <img class="arrow arrow-white arrow-left" src="https://nohome.cloud/wp-content/themes/blankslate/files/nav/arrow-right.png" alt="Left arrow">
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ////////////// ITEMS IN CAVE ROOM ////////////////// -->

<div id="items-cave-room" class="room-wrapper animated-display" style="display: none">

    <img class="room-background-img" src="https://nohome.cloud/wp-content/themes/blankslate/files/cave-room/wall-with-items.jpg" alt="Wall with items">

    <img class="object-overlay safety-helmet-img" src="https://nohome.cloud/wp-content/themes/blankslate/files/cave-room/safety-helmet.jpg" alt="Safety Helmet">

    <img class="object-overlay safety-helmet-flash-img" src="https://nohome.cloud/wp-content/themes/blankslate/files/cave-room/flashlight.jpg" alt="Flash light">

    <svg class="object-overlay" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 3840 2160" preserveAspectRatio="xMidYMid slice">
	<path class="overlay-svg" id="gbl-speaker-in-items-room" pointer-events="bounding-box" d="M1342.37 1597.76C1353.4 1598.65 1360.29 1599.79 1367.03 1605.07C1390.26 1623.28 1367.86 1659.5 1360.63 1679.52C1377.47 1679.24 1440.83 1674.6 1451.87 1679.15C1458.57 1681.91 1461.84 1685.85 1462.77 1690.39C1466.08 1706.57 1464.1 1724.05 1464.35 1740.37L1466.03 1829.41C1466.2 1846.6 1471.14 1865.74 1466.68 1882.65C1465.01 1888.99 1460.77 1892.46 1453.65 1897.36C1433.98 1901.94 1413.04 1902.11 1392.08 1902.72C1369.14 1903.38 1305.75 1907.55 1290.2 1898.74C1280.64 1893.32 1283.24 1880.85 1283.2 1873.91L1280.57 1758.4C1280.07 1738.65 1277.28 1718.12 1279.59 1698.44C1279.93 1695.54 1280.39 1692.89 1283.2 1690.38C1291.45 1683.01 1307.97 1681.67 1321.83 1679.86C1313.59 1648.94 1294.56 1637.57 1311.9 1605.18C1318.49 1602.51 1326.01 1600.38 1333.06 1598.11L1333.62 1614.26L1320.1 1624.22C1318.98 1640.66 1331.76 1670.17 1341.92 1685.75C1349.5 1673.99 1361.78 1641.89 1361.25 1629.7C1361.07 1625.43 1359.3 1621.11 1353.38 1618.2C1351.56 1617.3 1349.62 1616.48 1347.86 1615.55C1341.05 1611.92 1342.65 1602.75 1342.37 1597.76Z"/>
	<path class="overlay-svg safety-helmet-f no-glow" pointer-events="bounding-box" d="M2466.99 308.068Q2472.1 307.942 2477.21 307.918C2497.56 307.836 2522.96 318.209 2537.04 326.047C2598.15 360.062 2621.84 432.104 2622.2 479.069C2622.57 527.22 2593.6 598.194 2526.65 630.835C2523.31 632.459 2520.92 632.403 2516.77 632.376C2513.23 632.352 2511.17 632.298 2507.86 633.175C2506.08 635.769 2507.03 637.374 2507.98 640.008L2510.92 640.345L2521.62 635.871C2540.38 635.302 2571.74 635.26 2588.81 639.701C2593.53 652.712 2591.67 672.408 2583.52 684.963C2581.5 688.077 2578.51 691.4 2572.61 692.567C2571.54 692.779 2568.32 693.085 2567.3 693.169C2533.7 695.966 2533.67 687.012 2507.94 684.81C2491.77 683.426 2473.44 684.772 2456.92 684.461C2435.63 684.06 2414.52 682.275 2393.32 681.776C2378.51 681.427 2364.26 683.295 2350.59 679.488C2341.29 669.452 2348.14 648.203 2349.94 636.695C2350.78 636.596 2351.62 636.49 2352.47 636.396C2353.65 636.265 2354.84 636.154 2356.03 636.02C2378.25 633.501 2402.36 640.676 2425.62 636.69C2427.68 634.202 2428.21 633.8 2427.59 631.118C2424.4 628.854 2421.49 628.323 2416.85 627.399L2405.01 625.014C2394.24 616.347 2380.53 608.738 2370.71 599.718C2338.64 570.283 2324.53 530.674 2320.87 496.513C2310.68 451.608 2335.15 384.64 2377.2 346.515C2391.3 333.736 2419.28 313.982 2447.46 311.38C2452.21 310.942 2454.34 311.181 2458.06 312.799L2457.66 314.802C2451.23 318.672 2429.87 319.782 2418.62 324.441C2361.75 347.999 2341.12 392.983 2332.49 430.328C2326.31 457.054 2331.15 510.135 2340.23 536.48C2346 553.241 2355.91 571.492 2369.52 586.855C2380.46 599.199 2398.63 610.008 2413.55 620.881C2415.37 617.587 2416.4 614.323 2421.27 612.015C2433.03 609.684 2446.68 612.317 2458.66 613.586C2459.13 613.126 2459.62 612.671 2460.08 612.208C2476.65 595.551 2470.86 571.552 2473.36 553.011C2475.86 534.431 2481.75 515.863 2483.89 497.397C2488.64 456.379 2488.47 352.754 2469.98 316.238C2468.75 313.8 2467.86 311.504 2467.21 308.992L2466.99 308.068ZM2502.46 321.57C2500.93 332.539 2506.81 344.861 2509.02 355.839C2511.76 369.411 2513.34 383.262 2514.31 396.904Q2516.84 442.409 2514.47 487.916C2513.6 512.126 2513.5 535.642 2508.87 559.775C2505.3 578.409 2498.48 597.312 2493.02 615.836C2504.28 615.739 2518.59 614.751 2529.24 616.631C2531.93 618.894 2531.48 620.595 2531.47 623.219C2536.44 622.855 2540.85 619.262 2543.92 617.041C2548.43 613.771 2552.97 610.402 2556.98 606.928C2567.32 599.08 2574.43 589.267 2580.8 580.237C2609.02 540.229 2610.11 503.755 2606.98 461.75C2606.13 450.274 2606.06 438.238 2603.03 426.898C2593.6 391.496 2566.04 346.856 2512.01 325.163Q2507.32 323.291 2502.46 321.57Z"/>
	<path class="overlay-svg" id="walkie-phone-in-items-room" pointer-events="bounding-box" d="M2433.74 1325.28C2436.41 1325.36 2439.13 1325.49 2441.69 1325.96C2464.76 1330.19 2461.79 1351.65 2470.13 1361.89C2471.66 1362.26 2474.78 1362.97 2476.09 1363.48C2476.56 1363.67 2478.93 1365.03 2479.28 1365.49C2483.78 1371.33 2482.96 1449.3 2483.95 1463.03Q2485.6 1463.62 2487.21 1464.25C2496.76 1468.02 2500.08 1472.63 2502.05 1478.98C2505.09 1488.83 2507.01 1499.52 2507.72 1509.51C2509.51 1534.75 2507.37 1560.49 2507.25 1585.78C2507.14 1608.28 2509.47 1631.82 2506.2 1654.21C2505.67 1657.79 2505.27 1661.69 2501.56 1664.71C2490.04 1669.28 2475.79 1667.55 2462.42 1667.13L2459.44 1798.64C2493.03 1820.48 2497.25 1849.69 2500.72 1877.51C2504.74 1909.73 2491.24 1944.83 2452.47 1969.7C2436.02 1980.25 2408.33 1992.94 2382.56 1993.89C2360.29 1989.28 2334.69 1981.43 2320.74 1970.32C2293 1948.26 2284.01 1910.91 2289.65 1884.63C2292.18 1872.81 2299.45 1861.13 2303.32 1849.4C2306.39 1840.12 2307.72 1830.66 2310.83 1821.38C2314.92 1809.16 2322.01 1799.92 2341.12 1792.96C2354.38 1788.13 2366 1790.4 2380.22 1792.3C2387.3 1720.64 2393.2 1648.25 2390.06 1576.49C2388.92 1550.43 2381 1525.59 2377.13 1499.76C2372.22 1466.96 2375.52 1432.15 2384.91 1399.68C2389.36 1384.28 2401.8 1348.25 2415.72 1335.17C2420.36 1330.8 2426.47 1328.2 2433.74 1325.28ZM2402.89 1371.99C2384.36 1413.5 2378.19 1459.65 2383.72 1502.32C2385.41 1515.41 2389.54 1528.38 2391.96 1541.44C2394.83 1556.89 2395.52 1572.73 2396.05 1588.26C2398.36 1655.8 2393.99 1724.02 2387.38 1791.47C2396.25 1790.66 2407.56 1788.98 2416.46 1789.6C2423.92 1790.13 2447.95 1796.31 2452.17 1795.39L2452.58 1794.15L2455.27 1666.76C2441.67 1666.39 2415.96 1667.44 2405.87 1662.3C2398.17 1647.38 2396.31 1527.76 2397.53 1508.07C2398.1 1498.78 2398.71 1476.99 2406.09 1469.31C2408.76 1466.54 2411.86 1464.72 2416.12 1462.72C2416.35 1455.82 2413.89 1441.53 2421.15 1436.3L2427.82 1435.01C2431.69 1424.08 2408.33 1388.16 2404.43 1373.02L2402.89 1371.99ZM2433.84 1333.79C2438.07 1337.34 2439.6 1339.63 2440 1343.9L2439 1344.25C2435.51 1342.05 2435.06 1341.01 2429.72 1340.66C2419.7 1343.98 2414.72 1347.58 2411.95 1354.02C2402.4 1376.25 2423.33 1395.23 2432.15 1415.94C2435.79 1424.48 2436.03 1434.35 2437.53 1443.14C2438.6 1449.45 2435.53 1456.75 2439.81 1462.64C2445.66 1464.04 2450.25 1462.64 2456.32 1461.81Q2455.3 1436.59 2452.95 1411.39C2452.45 1402.36 2446.85 1375.99 2451.93 1369.25C2463.52 1382.58 2458.09 1419.19 2462.92 1435.24C2464.43 1415.85 2470.1 1348.13 2445.83 1335.75C2441.77 1333.68 2439.08 1333.98 2433.84 1333.79Z"/>
	<path class="overlay-svg safety-helmet no-glow" pointer-events="bounding-box" d="M1815.38 727.183C1844.29 727.251 1873.67 733.443 1897.8 742.052C1986.38 773.655 2016.69 842.815 2029.74 897.947C2033.25 912.785 2031.78 929.325 2037.58 943.772C2049.36 951.04 2041.42 955.229 2047.37 963.439C2050.61 964.974 2053.6 966.519 2056.52 968.239C2058.47 978.136 2057.48 988.527 2057.33 998.482C2056.13 1081.21 2009.67 1210.24 1917.21 1276.29C1892.88 1293.67 1863.19 1307.42 1822.96 1310.1C1802.66 1310.08 1781.98 1308.58 1762.77 1304.73C1711.81 1294.53 1678.81 1262.66 1657.21 1236.65C1598.83 1166.33 1580.35 1053.88 1583.8 977.242C1584.59 959.644 1585.43 934.137 1596.02 917.775C1600.08 916.873 1598.53 917.076 1602.55 916.682C1610.59 915.891 1611.32 904.421 1612.86 900.489C1629.87 856.808 1646.24 808.15 1697.09 772.24C1726.52 751.46 1766.75 730.37 1815.38 727.183Z"/>
    </svg>


<!-- Left Arrow Button -->
  <div class="container">
    <div class="row">
      <div class="col-12">
        <button id="arrow-left-button-in-items" class="arrow-button arrow-left-button">
            <img class="arrow arrow-left" src="https://nohome.cloud/wp-content/themes/blankslate/files/nav/arrow-right.png" alt="Left arrow">
        </button>
      </div>
    </div>
  </div>
</div>


<!-- ////////////// WALKIE-PHONE ////////////////// -->

<div id="walkie-phone-room" class="room-wrapper animated-display" style="display: none">
    <img class="room-background-img" src="https://nohome.cloud/wp-content/themes/blankslate/files/cave-room/Room_2_4k_zoom_racia_zoom-standard-width-3840px.jpg" alt="Walkie Talkie">

    <svg class="object-overlay" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 3840 2160" preserveAspectRatio="xMidYMid slice">
	<path class="overlay-svg walkiephone" pointer-events="bounding-box" d="M2029.14 272.288C2032.37 272.053 2035.81 271.723 2039.06 271.942C2056.98 273.149 2067.53 284.111 2071.79 292.782C2079.39 308.264 2077.63 357.887 2078.55 377.151Q2085.36 496.898 2087.59 616.7L2089.9 699.314C2090.1 715.079 2087.92 732.051 2090.64 747.663C2091.57 753.025 2096.81 759.735 2102.84 763.929C2122.25 765.272 2137.19 776.095 2151.91 782.991C2158.54 793.087 2165.88 803.363 2170.16 813.876C2185.64 851.942 2183.94 895.533 2188.41 934.534C2189.43 943.385 2195.87 951.815 2196.77 960.703C2202.84 1020.47 2204.94 1081.68 2202.53 1141.5C2202.01 1154.24 2197.04 1166.81 2196.77 1179.48C2196.09 1211.88 2197.55 1244.42 2197.74 1276.83Q2199.92 1375.87 2199.09 1474.92C2198.29 1525.84 2194.8 1576.9 2192.95 1627.84C2191.19 1676.54 2193.2 1724.78 2187.51 1773.43C2186.75 1779.95 2181.22 1785.72 2176.57 1791.63C2163.18 1795.11 2149.68 1798.21 2135.9 1801.16C2135.51 1805.87 2136.1 1813.92 2131.08 1817.78C2100.16 1820.96 2036.01 1806.85 2000.86 1805.03C1956.3 1802.72 1911.17 1807.16 1867.01 1809.36C1845.09 1810.46 1822.74 1810.43 1800.73 1811.21L1798.97 1823.37C1772.05 1823.91 1750.21 1818 1724.25 1815.83L1720.23 1802.72C1702.65 1801.52 1687.79 1796.27 1672.61 1791.5C1666.06 1784.4 1661.76 1778.64 1659.9 1770.72C1658.6 1758.95 1655.41 1747.34 1654.72 1735.52C1653.01 1706.09 1655.13 1676.58 1653.96 1647.14C1651.65 1589.43 1648.17 1531.64 1647.09 1473.92C1646.45 1439.87 1653.24 1165.74 1643.8 1153.41C1642.99 1152.35 1641.89 1151.31 1641.37 1150.18C1637.95 1142.71 1642.07 1130.38 1642.08 1122.34Q1641.4 1058.75 1643.94 995.174C1644.73 976.681 1644.32 957.978 1647.41 939.554C1649.52 926.95 1658.84 916.247 1662.56 904.026C1672.14 872.62 1669.74 839.905 1688.19 809.218C1696.07 796.104 1709.05 779.247 1724.34 768.39C1734.59 761.117 1749.99 753.993 1756.86 745.591C1760.33 741.344 1764.05 739.194 1770.32 736.09L1754.19 719.36C1759.65 699.67 1762.05 679.505 1765.63 659.672C1767.6 648.807 1768.31 637.309 1774.62 626.903C1777.26 622.553 1782.24 618.635 1786.74 614.833C1793.24 613.098 1799.94 611.275 1806.78 610.02C1826.78 606.349 1842.52 611.333 1859.59 616.532C1863.18 620.618 1867.3 624.872 1869.62 629.245C1875.74 640.766 1876.4 653.75 1878.48 665.662Q1883.12 693.876 1888.63 722.041Q1886.19 724.224 1883.8 726.425C1879.4 730.49 1873.9 734.582 1876.05 739.559C1891.08 748.689 1962.47 751.807 1986.5 753.192C1988.76 699.347 1987.2 645.283 1987.76 591.412Q1989.48 499.715 1993.69 408.044L1996.27 340.557C1996.7 327.246 1995.54 313.322 1999.16 300.155C2000.87 293.93 2004.43 287.804 2007.68 281.787C2014.55 278.451 2021.96 275.412 2029.14 272.288Z"/>
</svg>


<!-- Left Arrow Button -->
  <div class="container">
    <div class="row">
      <div class="col-12">
        <button id="arrow-left-button-walkie-phone" class="arrow-button arrow-left-button">
            <img class="arrow arrow-left" src="https://nohome.cloud/wp-content/themes/blankslate/files/nav/arrow-right.png" alt="Left arrow">
        </button>
      </div>
    </div>
  </div>
</div>



<!-- ////////////// GBL-SPEAKER-ROOM ////////////////// -->

<div id="gbl-speaker-room" class="room-wrapper animated-display" style="display: none">
    <img class="room-background-img" src="https://nohome.cloud/wp-content/themes/blankslate/files/cave-room/Room_2_4k_zoom_jbl_button1-standard-width-3840px.jpg" alt="GBL speaker">

    <svg class="object-overlay" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 3840 2160" preserveAspectRatio="xMidYMid slice">
	<path class="overlay-svg" id="speaker-to-mp3" pointer-events="bounding-box" d="M1646.24 0L1687.89 0Q1683.92 82.9741 1682.98 165.976C1681.99 227.821 1670.93 302.838 1705.76 361.647Q1710.65 343.96 1717.02 326.423C1720.22 317.689 1715.07 309.719 1717.84 301.038C1723.02 284.792 1739.66 271.01 1758.46 258.727C1762.05 256.377 1766.38 252.967 1771.38 251.544C1779.41 249.259 1790.4 250.959 1798 252.946C1824.1 259.769 1838.21 257.48 1865.83 267.063C1867.26 254.313 1870.22 241.605 1871.63 228.835Q1875.17 199.005 1875.81 169.111Q1876.46 139.217 1874.21 109.347C1919.61 147.307 1922.27 209.138 1920.04 254.053C1919.52 264.636 1913.1 278.793 1917.08 288.922C1919.35 294.688 1932.45 301.343 1937.23 307.192C1951.85 325.088 1960.08 344.939 1967.55 364.074C1965.63 367.951 1962.74 371.611 1959.98 375.319C2002.92 479.232 1937.98 583.959 1921.23 687.097C1965.6 692.559 2009.79 704.387 2052.64 712.932L2174.93 736.977C2204.99 742.863 2241.12 747.851 2267.8 757.648C2299.59 769.319 2331.01 787.286 2338.41 809.134C2343.4 823.867 2340.81 840.618 2340.83 855.643L2341.72 911.929L2343.22 1138.81L2347.13 1585.28L2347.52 1715.61C2347.67 1738.37 2350.25 1761.72 2347.75 1784.4C2346.31 1797.49 2338.15 1808.77 2324.99 1819.44Q2323.61 1820.54 2322.17 1821.61Q2320.73 1822.68 2319.23 1823.72Q2317.73 1824.76 2316.16 1825.78Q2314.6 1826.79 2312.98 1827.78Q2311.37 1828.77 2309.69 1829.72Q2308.02 1830.68 2306.29 1831.61Q2304.56 1832.53 2302.78 1833.43Q2301 1834.32 2299.17 1835.18Q2297.33 1836.04 2295.45 1836.87Q2293.57 1837.7 2291.65 1838.49Q2289.72 1839.28 2287.75 1840.04Q2285.78 1840.8 2283.77 1841.52Q2281.75 1842.24 2279.7 1842.92Q2277.64 1843.6 2275.55 1844.25Q2273.46 1844.9 2271.33 1845.5Q2269.2 1846.11 2267.04 1846.68C2230.92 1856.32 2176.61 1861.69 2136.96 1868.11L2010.46 1889.14C1978.67 1894.45 1947.09 1900.12 1914.38 1903.45C1818.6 1913.19 1653.18 1915.06 1571.67 1881.89C1544.84 1870.97 1524.23 1851.21 1518.9 1832.9C1514.46 1817.67 1517.23 1800.96 1517.62 1785.56Q1518.43 1751.68 1518.45 1717.8L1520.64 1427.14L1523.67 986.209L1524.58 837.402C1524.82 812.344 1522.71 786.441 1526.28 761.496C1528.2 748.078 1540.81 734.582 1554.63 723.765C1585.3 699.748 1649.35 688.612 1698.64 683.7C1719.56 681.615 1740.77 680.894 1761.74 678.882C1758.09 618.715 1729.46 550.016 1714.38 489.349Q1708.83 465.712 1705.97 441.924C1704.82 431.323 1705.24 420.319 1701.72 409.867C1698.94 401.604 1687.97 393.589 1682.8 385.56C1670.03 365.721 1663.03 345.136 1658.39 324.256C1646.53 270.819 1650.71 213.259 1651.24 159.37Q1652.17 79.6509 1646.24 0ZM1872.02 388.916C1846.09 406.577 1821.33 417.343 1783.19 425.437C1795.31 505.281 1830.16 583.672 1838.64 663.589C1839.53 670.909 1839.82 678.486 1842.33 685.686C1851.84 664.153 1853.26 637.412 1859.67 614.859C1876.78 554.561 1906.54 493.732 1898.2 432.151C1896.9 422.543 1895.88 410.72 1886.66 402.26C1882.18 398.148 1877.27 395.578 1874.08 390.891C1873.11 389.459 1873.72 390.055 1872.02 388.916Z"/>
</svg>


<!-- Left Arrow Button -->
  <div class="container">
    <div class="row">
      <div class="col-12">
        <button id="arrow-left-button-gbl-speaker" class="arrow-button arrow-left-button">
            <img class="arrow arrow-left" src="https://nohome.cloud/wp-content/themes/blankslate/files/nav/arrow-right.png" alt="Left arrow">
        </button>
      </div>
    </div>
  </div>
</div>
<canvas id="fluid" style="display:none;"></canvas>
<script src="https://nohome.cloud/wp-content/themes/blankslate/files/test/fluid.js"></script>

<script>
function initializeCave() {
    const elements = {
        mirrorOverlay: document.getElementById('mirror-svg-overlay'),
        backgroundImg: document.querySelector('.darken-cave'),
        caveRoomMain: document.getElementById('cave-room-main'),
        justCave: document.getElementById('just-cave'),
        itemsCaveRoom: document.getElementById('items-cave-room'),
        walkiePhoneRoom: document.getElementById('walkie-phone-room'),
        gblSpeakerRoom: document.getElementById('gbl-speaker-room'),
        safetyHelmetH: document.querySelector('.safety-helmet'),
        safetyHelmetF: document.querySelector('.safety-helmet-f'),
        safetyHelmetHI: document.querySelector('.safety-helmet-img'),
        safetyHelmetFI: document.querySelector('.safety-helmet-flash-img'),
        walkiephone: document.querySelector('.walkiephone'),
        pixelMirror: document.querySelector('.pixel-mirror')
    };

    const buttons = {
        arrowRight: document.getElementById('arrow-right-button'),
        arrowLeft: document.getElementById('arrow-left-button'),
        arrowLeftItems: document.getElementById('arrow-left-button-in-items'),
        arrowLeftWalkiePhone: document.getElementById('arrow-left-button-walkie-phone'),
        arrowLeftGblSpeaker: document.getElementById('arrow-left-button-gbl-speaker')
    };

    const sounds = {
        walkiephoneSound: document.getElementById('walkiephoneSound'),
        caveSound: document.getElementById('caveSound')
    };

    ////// CAVE ANIMATION
    const toCaveElement = document.querySelector('.to-cave');
    const caveClassiki = document.querySelectorAll('.cave-classiki');
    const lightCave = document.querySelector('.light-cave');
    let animationInterval;
    let currentIndex = 0;

    function startAnimation() {
        lightCave.style.opacity = '1';
        if (animationInterval) return;
        currentIndex = 0;
        caveClassiki[currentIndex].style.opacity = '1';
        animationInterval = setInterval(() => {
            caveClassiki[currentIndex].style.opacity = '0';
            currentIndex = (currentIndex + 1) % caveClassiki.length;
            caveClassiki[currentIndex].style.opacity = '1';
        }, 300);
    }

    function endAnimation() {
        lightCave.style.opacity = '0';
        clearInterval(animationInterval);
        animationInterval = null;
        caveClassiki.forEach(img => img.style.opacity = '0');
    }

    toCaveElement.addEventListener('mouseenter', startAnimation);
    toCaveElement.addEventListener('mouseleave', endAnimation);

    ////// WALKIE PHONE SOUND PLAY
    elements.walkiephone.addEventListener('click', () => {
        sounds.walkiephoneSound.play();
    });

    ////// ROOM SWITCHER
    let isAnimating = false;

    function toggleVisibility(hide, show) {
        if (isAnimating) return;
        isAnimating = true;

        [hide, show].forEach(el => el.style.animationName = el === hide ? 'fadeOut' : 'fadeIn');
        show.style.display = 'block';
        
        hide.addEventListener('animationend', function hideElement() {
            hide.style.display = 'none';
            hide.style.animationName = '';
            hide.removeEventListener('animationend', hideElement);
            isAnimating = false;
        });

        show.addEventListener('animationend', function showElement() {
            show.style.animationName = '';
            show.removeEventListener('animationend', showElement);
        });
    }

    ////// MIRROR
    elements.mirrorOverlay.addEventListener('mouseenter', () => {
        elements.backgroundImg.style.filter = 'opacity(1)';
        elements.pixelMirror.style.filter = 'blur(0px)';
    });
    elements.mirrorOverlay.addEventListener('mouseleave', () => {
        elements.backgroundImg.style.filter = 'opacity(0)';
    });

    ////// BUTTONS BACK
    document.querySelectorAll('.items-next-to-mirror').forEach(item => 
        item.addEventListener('click', () => toggleVisibility(elements.caveRoomMain, elements.itemsCaveRoom))
    );

    buttons.arrowLeftItems.addEventListener('click', () => toggleVisibility(elements.itemsCaveRoom, elements.caveRoomMain));
    document.getElementById('walkie-phone-in-items-room').addEventListener('click', () => toggleVisibility(elements.itemsCaveRoom, elements.walkiePhoneRoom));

    buttons.arrowLeftWalkiePhone.addEventListener('click', () => {
        toggleVisibility(elements.walkiePhoneRoom, elements.itemsCaveRoom);
        sounds.walkiephoneSound.pause();
    });

    document.getElementById('gbl-speaker-in-items-room').addEventListener('click', () => toggleVisibility(elements.itemsCaveRoom, elements.gblSpeakerRoom));
    buttons.arrowLeftGblSpeaker.addEventListener('click', () => toggleVisibility(elements.gblSpeakerRoom, elements.itemsCaveRoom));

    /////////// SOUND OF CAVE AND CLICK TO CAVE
    function fadeInVolume(audio, targetVolume, duration) {
        const startVolume = audio.volume;
        const volumeDiff = targetVolume - startVolume;
        const startTime = performance.now();

        function updateVolume() {
            const elapsed = performance.now() - startTime;
            const progress = Math.min(elapsed / duration, 1);
            audio.volume = startVolume + volumeDiff * progress;

            if (progress < 1) {
                requestAnimationFrame(updateVolume);
            }
        }

        requestAnimationFrame(updateVolume);
    }

    function applyVolumeToSound(audio, volume) {
        audio.volume = volume;
    }

    toCaveElement.addEventListener('mouseenter', () => {
        sounds.caveSound.volume = 0;
        sounds.caveSound.play();
        fadeInVolume(sounds.caveSound, 0.5, 3000);
    });

    toCaveElement.addEventListener('mouseleave', () => {
        sounds.caveSound.pause();
    });

    toCaveElement.addEventListener('click', () => {
        applyVolumeToSound(sounds.caveSound, 1);
        toggleVisibility(elements.caveRoomMain, elements.justCave);
        setTimeout(() => {
            sounds.caveSound.play();
        }, 10);
    });

    buttons.arrowLeft.addEventListener('click', () => {
        toggleVisibility(elements.justCave, elements.caveRoomMain);
        sounds.caveSound.pause();
        sounds.caveSound.currentTime = 0;
    });

    ////// HELMET AND FLASH ANIMATIONS
    elements.safetyHelmetH.addEventListener('mouseenter', () => elements.safetyHelmetHI.style.opacity = '1');
    elements.safetyHelmetH.addEventListener('mouseleave', () => elements.safetyHelmetHI.style.opacity = '0');
    elements.safetyHelmetF.addEventListener('mouseenter', () => elements.safetyHelmetFI.style.opacity = '1');
    elements.safetyHelmetF.addEventListener('mouseleave', () => elements.safetyHelmetFI.style.opacity = '0');

    //////////////// FLY
    const fly = document.querySelector('.fly');
    const viewportWidth = window.innerWidth;
    const viewportHeight = window.innerHeight;

    function getRandomPosition() {
        return {
            x: Math.random() * (viewportWidth - 30),
            y: Math.random() * (viewportHeight - 30)
        };
    }

    function getRandomRotation() {
        return Math.random() * 360;
    }

    function moveFly() {
        const newPos = getRandomPosition();
        const rotation = getRandomRotation();

        fly.style.transform = `rotate(${rotation}deg)`;
        fly.style.left = `${newPos.x}px`;
        fly.style.top = `${newPos.y}px`;
    }

    function flyBehavior() {
        moveFly();
        const nextMove = Math.random() * 3000 + 1000;
        setTimeout(flyBehavior, nextMove);
    }

    flyBehavior();

//////////////////// ИСЧЕЗНОВЕНИЕ ЭЛЕМЕНТОВ В ОКНЕ

        const hideElements = document.querySelector('.hide-elements');
        const interfaceElements = document.querySelector('.interface-elements');
        let timeout;

        function isHideElementsVisible() {
            return getComputedStyle(hideElements).display === 'block';
        }

        function showInterface() {
            if (isHideElementsVisible()) {
                interfaceElements.classList.remove('hidden');
                clearTimeout(timeout);
                timeout = setTimeout(hideInterface, 2000);
            }
        }

        function hideInterface() {
            if (isHideElementsVisible()) {
                interfaceElements.classList.add('hidden');
            }
        }

        function handleMouseMove() {
            showInterface();
        }

        if (isHideElementsVisible()) {
            showInterface();
        } else {
            hideInterface();
        }

        document.addEventListener('mousemove', handleMouseMove);

        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === "attributes" && mutation.attributeName === "style") {
                    if (isHideElementsVisible()) {
                        showInterface();
                    } else {
                        hideInterface();
                    }
                }
            });
        });
}

document.addEventListener('DOMContentLoaded', initializeCave);
</script>

<script src="https://nohome.cloud/wp-content/themes/blankslate/files/captcha/captcha.js"></script>
<!-- /wp:html -->