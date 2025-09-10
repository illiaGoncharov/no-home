<!-- wp:html -->

<style>
.overlay-svg {
  /* Увеличиваем область клика вокруг path элемента */
  cursor: pointer;
  padding: 200px;
  /* Делаем область клика больше, чем сам path элемент */
  margin: -200px;
}
.rain {
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background-image: url(https://nohome.cloud/wp-content/themes/blankslate/files/test/rain.png);
    animation: rain 0.9s linear infinite;
    pointer-events: none;
    mix-blend-mode: screen;
    opacity: 1;
    --rainAngle: 33deg; /* Начальный угол */
}

@keyframes rain {
    0% {
        background-position: 0% 0%;
        transform: rotate(var(--rainAngle)); /* Угол дождя */
    }
    100% {
        background-position: -20% 100%;
        transform: rotate(var(--rainAngle)); /* Угол дождя */
    }
}

</style>


    <audio id="backpackSound" src="https://nohome.cloud/wp-content/themes/blankslate/files/bedroom/backpack.ogg"></audio>
    <audio id="suitcaseSound" src="https://nohome.cloud/wp-content/themes/blankslate/files/bedroom/suitcase.ogg"></audio>
    <audio id="outsideSound" loop src="https://nohome.cloud/wp-content/themes/blankslate/files/bedroom/outside.ogg"></audio>
    <audio id="lullabySound" src="https://nohome.cloud/wp-content/themes/blankslate/files/bedroom/lullaby.ogg"></audio>

<!-- ////////////// BEDROOM-MAIN ////////////////// -->

<div id="bedroom-main" class="room-wrapper animated-display">
    <img class="room-background-img" src="https://nohome.cloud/wp-content/themes/blankslate/files/bedroom/Room_1_4k_12-standard-width-3840px.jpg" alt="Room with a cave">
    <img class="room-background-img darken-bedroom" src="https://nohome.cloud/wp-content/themes/blankslate/files/bedroom/bedroom-darken.jpg" alt="Room with a cave" style="opacity: 0;">
    <img class="room-background-img silhouette" src="https://nohome.cloud/wp-content/themes/blankslate/files/bedroom/silhouette.jpg" alt="Room with a cave" style="opacity: 0;">

    <svg class="object-overlay" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 3840 2160" preserveAspectRatio="xMidYMid slice">
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
<rect class="overlay-svg no-glow" id="silhouette" width="800" height="800" x="2200" y="300" fill="blue" />
<path class="overlay-svg no-glow" id="outside-bedroom" d="M1252 -0.5H7.5V1420.5L1610.5 1349V164L1252 -0.5Z"/>
        <path class="overlay-svg" id="backpack-in-bedroom" d="M2264.28 1396.36C2276.13 1396.26 2285.17 1398.04 2294.26 1402.4C2303.52 1406.84 2310.71 1413.14 2317.58 1418.74C2351.81 1446.64 2345.41 1461.92 2350.61 1493.58C2352.5 1505.07 2357.04 1516.38 2358.3 1527.92C2361.35 1555.7 2355.43 1582.71 2354.67 1610.37C2354.01 1634.5 2360.36 1658.66 2354.27 1682.75C2352.44 1689.97 2348.76 1697.65 2339.5 1703.05C2327.35 1710.13 2285.33 1703.78 2269.32 1703.01C2256.91 1702.41 2244.29 1702.41 2231.84 1702.29C2209.77 1702.16 2187.67 1701.44 2165.62 1700.92C2151.24 1694.89 2140.36 1688.71 2134.54 1678.87C2131.68 1674.03 2130.83 1669.37 2130.67 1664.29C2130.1 1645.91 2134.65 1627.32 2135.7 1608.94C2137.1 1584.37 2137.96 1559.93 2140.2 1535.37C2141.42 1521.87 2141.88 1507.43 2147.23 1494.24C2152.52 1481.19 2171.53 1457.62 2182.99 1445.3C2193.96 1433.5 2202.57 1432.75 2216.68 1424.08C2233.02 1414.05 2238.39 1400.84 2264.28 1396.36ZM2269.31 1405.58C2259.3 1407.92 2251.26 1410.3 2244.91 1415.37L2245.51 1417.38C2250.99 1418.8 2255.44 1417.85 2261.03 1417.21L2263.79 1416.91L2265.44 1416.71C2273.83 1416.62 2282.26 1416.62 2290.64 1416.42C2284.54 1412.49 2278.2 1407.5 2269.31 1405.58Z"/>
	<path class="overlay-svg" id="bag-in-bedroom" d="M790.374 1178.59C802.926 1178.18 817.439 1176.89 829.677 1178.54C834.231 1187.65 829.027 1210.41 828.994 1221.53L828.814 1321.95C828.764 1339.55 829.634 1357.41 828.246 1374.99C830.678 1385.44 829.444 1396.61 829.542 1407.16C843.642 1405.28 859.16 1403.09 873.617 1402.85C879.028 1402.76 878.767 1403.18 882.724 1405.32C890.226 1406.6 897.545 1404.8 904.842 1403.64C904.936 1407.51 905.217 1411.24 906.04 1415.08L907.267 1414C907.702 1414.6 907.926 1415.27 908.572 1415.82C908.748 1415.97 909.197 1415.89 909.513 1415.89C938.788 1416.28 965.767 1412.69 992.195 1421.86C1002.14 1430.48 1015.73 1443.3 1019.97 1453.21C1029.07 1474.51 1023.85 1516.31 1023.74 1539.89L1022.49 1703.82L1021.75 1778.85C1021.88 1796.56 1023.67 1814.84 1020.85 1832.46C1019.08 1843.48 1014.24 1852.65 1004.46 1862.25C998.354 1863.73 991.992 1865.02 986.799 1867.41C988.85 1868.79 990.855 1870.21 992.64 1871.71C1000.26 1878.11 1006.95 1886.84 1003.54 1894.69C1002.06 1898.09 998.008 1900.93 992.6 1902.65C987.918 1904.14 985.556 1904.46 980.373 1903.81C967.047 1897.36 966.864 1881.37 965.367 1872.26C910.473 1886.01 855.533 1899.28 798.929 1910.7C804.323 1919.05 809.417 1926.78 809.433 1935.82C809.444 1941.83 806.886 1947.63 799.026 1951.88C793.892 1952.79 793.715 1952.74 788.62 1951.72C773.138 1942.95 775.148 1927.37 773.973 1915.78C754.02 1917.84 736.107 1913.93 717.133 1910.9C716.616 1913.76 716.155 1916.67 715.25 1919.5C713.561 1924.78 710.407 1932.23 701.38 1935.22C697.678 1936.44 693.218 1936.84 689.195 1935.83C683.17 1934.31 679.939 1930.3 678.652 1926.87C675.888 1919.51 679.276 1911.54 686.647 1905.41C676.586 1896.41 669.067 1887.73 665.262 1877.24C659.318 1860.85 662.21 1842.87 662.314 1826.2L662.219 1751.45L661.619 1572.93C661.57 1541.84 657.35 1508.07 663.167 1477.26C665.786 1463.39 672.896 1452.77 686.626 1441.19C707.096 1435.88 729.562 1435.23 751.046 1431.79C760.449 1430.28 769.193 1427.46 778.183 1425.29C777.355 1375.49 779.37 1325.56 779.339 1275.73L779.521 1205.22C779.503 1198.43 777.617 1191.4 777.999 1184.72C778.169 1181.76 778.906 1180.5 782.618 1178.46L790.374 1178.59ZM798.444 1184.26C795.901 1184.8 794.181 1184.72 792.964 1186.23C787.617 1192.85 787.33 1403.31 791.628 1408.67C799.257 1411.14 808.835 1409.46 817.311 1408.76C817.292 1394.95 817.791 1381.36 819.544 1367.58C817.532 1352.63 819.087 1336.98 819.06 1321.94L818.887 1233.34C818.849 1217.66 821.095 1200.61 816.858 1185.13C812.135 1183.72 803.908 1184.27 798.444 1184.26ZM790.374 1178.59L797.994 1181.25L798.444 1184.26C803.908 1184.27 812.135 1183.72 816.858 1185.13C821.095 1200.61 818.849 1217.66 818.887 1233.34L819.06 1321.94C819.087 1336.98 817.532 1352.63 819.544 1367.58L821.768 1365.92C824.781 1311.97 821.719 1257.66 822.148 1203.66C825.798 1226.71 816.204 1368.44 828.246 1374.99C829.634 1357.41 828.764 1339.55 828.814 1321.95L828.994 1221.53C829.027 1210.41 834.231 1187.65 829.677 1178.54C817.439 1176.89 802.926 1178.18 790.374 1178.59Z"/>
    </svg>

</div>

<!-- ////////////// BACKPACK IN BEDROOM MAIN ////////////////// -->

<div id="backpack-in-bedroom-room" class="room-wrapper animated-display" style="display: none;">
    <img class="room-background-img" src="https://nohome.cloud/wp-content/themes/blankslate/files/bedroom/Room_1_4k_bag2-standard-width-3840px.jpg" alt="Backpack on a mattress in bedroom">

    <svg class="object-overlay" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 3840 2160" preserveAspectRatio="xMidYMid slice">
            <path class="overlay-svg backpack-close-overlay" d="M1993.25 507.893C2013.28 506.841 2029.45 507.306 2048.06 512.262C2084.71 522.021 2106.87 540.877 2123.59 560.843C2129.98 568.476 2135.9 576.911 2145.36 583.555C2171.96 602.248 2203.44 591.223 2226.92 627.208C2242.35 650.857 2248.41 677.927 2255.25 702.736C2267.09 745.622 2276.03 788.739 2287.64 831.64C2302.74 887.455 2328.49 942.928 2339.36 998.981C2346.35 1035.03 2344.48 1071.15 2342.99 1107.32C2340.8 1160.42 2334.01 1212.89 2324.21 1265.69C2317 1304.53 2308.9 1343.17 2294.55 1381.42C2277.84 1425.98 2255.56 1470.12 2234.26 1514.05C2224.42 1534.35 2211.24 1555.61 2205.34 1576.31C2201.54 1589.67 2204.91 1604.63 2204.75 1618.19C2204.25 1663.46 2204.25 1724.11 2170.02 1765.77C2149.16 1791.16 2114.3 1805.87 2068.19 1815.25C1993.34 1830.48 1829.64 1815.77 1759.56 1797.23C1739.34 1792.72 1722.74 1785.85 1703.66 1780.25C1677.86 1772.68 1650.8 1766.52 1625.38 1758.53C1595.69 1749.18 1573.13 1736.51 1546 1725.47C1533.43 1720.34 1518.56 1717.11 1505.97 1711.9C1445.77 1687.02 1408.37 1648.24 1388.55 1608.45C1369.03 1569.29 1369.71 1525.9 1371.85 1485.53C1374.27 1440.04 1382.29 1394.88 1389.44 1349.57C1396.16 1306.99 1401.94 1264.25 1410.88 1221.79C1414.22 1205.97 1422.17 1190.48 1425.22 1174.72L1455.98 1016.59C1462.54 979.828 1466.18 942.472 1477.01 906.026C1482.26 888.377 1489.32 866.85 1504.35 850.91C1516.57 837.946 1539.83 829.925 1553.99 817.555C1575.41 798.839 1592.22 778.713 1611.25 759.245C1621.73 748.534 1634.06 738.519 1645.72 728.22C1668.26 708.314 1689.86 688.306 1718.08 670.707C1731.52 662.329 1746.41 654.376 1763.1 648.063C1789.72 637.999 1822.27 630.964 1842.55 616.401C1857.31 605.796 1865.56 592.638 1877.39 580.994C1897.57 561.124 1927.63 527.93 1960.83 515.317C1970.88 511.498 1981.69 509.633 1993.25 507.893ZM2235.79 937.544C2231.45 954.35 2230.36 971.604 2228.19 988.555Q2222.49 1032.52 2217.69 1076.51Q2206.83 1174.59 2203.02 1272.84Q2199.22 1371.09 2202.47 1469.34L2209.16 1455.5C2226.98 1413.7 2246.97 1371.51 2255.34 1328.71C2266.18 1273.3 2259.51 1215.98 2257.82 1160.33C2255.46 1082.67 2261.58 1014.83 2235.79 937.544ZM2013.96 551.274C1993.11 560.267 1955.57 582.595 1952.28 597.783C1951.67 600.602 1952.55 601.724 1955.38 603.978C1965.19 603.539 1974.69 602.191 1984.27 600.989L1987.34 600.576C2007.53 597.937 2028.99 598.755 2048.7 595.837C2052.37 591.122 2047.99 584.802 2044.82 580.263C2038.13 570.679 2027.87 559.545 2016 551.756L2013.96 551.274Z"/>
    </svg>


<!-- Left Arrow Button -->
  <div class="container">
    <div class="row">
      <div class="col-12">
        <button id="arrow-left-backpack-bedroom" class="arrow-button arrow-left-button">
            <img class="arrow arrow-left arrow-white" src="https://nohome.cloud/wp-content/themes/blankslate/files/nav/arrow-right.png" alt="Left arrow">
        </button>
      </div>
    </div>
  </div>
</div>


<!-- ////////////// SUITCASE IN BEDROOM ////////////////// -->

<div id="suitcase-in-bedroom-room" class="room-wrapper animated-display" style="display: none;">
    <img class="room-background-img" src="https://nohome.cloud/wp-content/themes/blankslate/files/bedroom/Room_1_4k_suitcase2-standard-width-3840px.jpg" alt="Suitcase in bedroom">

    <svg class="object-overlay" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 3840 2160" preserveAspectRatio="xMidYMid slice">
<defs>
    <filter id="glow" x="-50%" y="-50%" width="200%" height="200%">
      <feMorphology in="SourceAlpha" result="morphed" operator="dilate" radius="3"/>
      <feGaussianBlur in="morphed" result="blurred" stdDeviation="6"/>
      <feFlood flood-color="#FFFDF0" result="glowColor"/>
      <feComposite in="glowColor" in2="blurred" operator="in" result="softGlow"/>
      <feMerge>
        <feMergeNode in="softGlow"/>
        <!---feMergeNode in="SourceGraphic"/--->
      </feMerge>
    </filter>
  </defs>
            <path class="overlay-svg suitcase-close-overlay" d="M1347.98 251.177C1386 255.234 1425.67 252.082 1463.76 255.901C1465.86 275.059 1462.36 294.358 1462.46 313.566L1464.65 445.658L1468.04 637.887C1468.39 649.313 1470.56 660.644 1471.32 672.048C1472.3 686.747 1471.89 701.55 1471.96 716.262C1473.51 716.1 1475.06 715.932 1476.62 715.805C1490.71 714.66 1561.92 709.654 1569.47 712.737L1569.83 716.575L1573.56 718.385C1582.15 719.834 1591.08 718.868 1599.87 718.376L1600.47 737.931C1617.82 738.977 1634.58 742.514 1652.04 743.166C1692.71 744.683 1735.54 736.182 1772.6 751.067C1778.6 753.476 1784.63 756.589 1788.51 760.134C1793.42 764.623 1826.59 822.467 1827.96 828.657C1834.13 856.521 1832.62 885.4 1832.44 913.432L1831.82 1017.53L1831.5 1341.21C1830.74 1385.1 1828.43 1429.16 1829.21 1473.03C1829.81 1506.87 1835.58 1541.48 1829.08 1575.18C1825.14 1595.61 1816.26 1607.91 1794.16 1624.34L1772.07 1628.89C1780.68 1635.83 1788.2 1642.49 1792.69 1650.65C1799.3 1662.67 1799.85 1678.2 1788.45 1689.4C1784.4 1693.38 1778.07 1697.31 1769.61 1698.04C1763.88 1698.54 1758.83 1697.37 1754.61 1695.28C1730.97 1683.52 1729.98 1653.19 1728.26 1636.89Q1614.53 1660.46 1498.54 1680.24C1437.32 1690.7 1376.01 1701.36 1314.36 1710.98C1315.22 1729.28 1329.68 1764.21 1315.24 1779.97C1313.58 1781.78 1312.18 1783.35 1311.25 1785.33C1310.97 1785.94 1310.71 1786.55 1310.44 1787.16C1308.62 1787.68 1308.38 1787.81 1306.07 1788.08C1300.03 1788.79 1291.48 1788.36 1286.17 1786.48C1259.3 1777 1279.81 1727.57 1271.33 1715.42C1267.9 1710.52 1248.04 1711.71 1239.42 1709.92C1231.3 1708.23 1230.32 1701.9 1222.72 1700.3C1216.55 1707.81 1205.91 1709.34 1193.27 1712.55Q1190.31 1710.77 1187.47 1708.92C1166.82 1695.4 1170.1 1676.27 1172.43 1659.78C1150.93 1636.04 1143.03 1607.91 1138.4 1581.57C1133.12 1551.57 1135.91 1521.28 1135.74 1491.16C1135.59 1464 1132.86 1436.78 1131.25 1409.63L1108.72 903.252Q1107.48 883.463 1107.75 863.662C1107.93 856.865 1111.32 843.717 1109.14 837.906C1108.72 836.794 1107.2 835.911 1106.23 834.913C1106.21 817.991 1119.55 790.544 1129.17 773.853C1157.98 762.89 1203.53 766.826 1237.35 763.578C1270.82 760.362 1305.89 750.86 1337.77 744.168L1338.24 723.823C1341.74 723.513 1352.44 723.044 1354.24 721.114C1358.49 716.567 1355.02 695.04 1354.75 688.831C1353.61 662.666 1355.53 636.342 1355.05 610.114L1349.9 416.326C1349.16 383.811 1348.73 351.17 1347.16 318.674C1346.21 298.871 1343.31 278.691 1344.18 258.904C1344.33 255.407 1343.92 253.794 1347.98 251.177ZM1367.95 265.939C1364.58 293.701 1366 320.812 1366.61 348.575L1368.46 444.382L1376.9 721.606C1399.71 719.745 1423.08 719.705 1445.51 716.825L1449.57 716.561C1451.24 703.008 1449.96 689.204 1450.14 675.607L1449.9 575.79L1441.99 267.902C1417.22 267.576 1392.64 267.055 1367.95 265.939Z"/>
    </svg>

<!-- Left Arrow Button -->
  <div class="container">
    <div class="row">
      <div class="col-12">
        <button id="arrow-left-suitcase-bedroom" class="arrow-button arrow-left-button">
            <img class="arrow arrow-left arrow-white" src="https://nohome.cloud/wp-content/themes/blankslate/files/nav/arrow-right.png" alt="Left arrow">
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ////////////// OUTSIDE  ////////////////// -->

<div id="outside-in-bedroom-room" class="room-wrapper animated-display hide-elements" style="display: none;">
    <img class="room-background-img" src="https://nohome.cloud/wp-content/themes/blankslate/files/bedroom/Room_1_4k_Window_2_.jpg" alt="The outside">
<div class="rain"></div>


<!-- Left Arrow Button -->
  <div class="container">
    <div class="row">
      <div class="col-12">
        <button id="arrow-left-outside-bedroom" class="arrow-button arrow-left-button">
            <img class="arrow arrow-left arrow-white" src="https://nohome.cloud/wp-content/themes/blankslate/files/nav/arrow-right.png" alt="Left arrow">
        </button>
      </div>
    </div>
  </div>
</div>

<script>
// Вспомогательная функция для изменения громкости звука
function fadeInVolume(sound, targetVolume, duration) {
    if (!sound) return;
    
    const startVolume = sound.volume;
    const volumeChange = targetVolume - startVolume;
    const startTime = Date.now();
    
    function updateVolume() {
        const elapsedTime = Date.now() - startTime;
        const progress = Math.min(elapsedTime / duration, 1);
        sound.volume = startVolume + (volumeChange * progress);
        
        if (progress < 1) {
            requestAnimationFrame(updateVolume);
        }
    }
    
    updateVolume();
}

// Вспомогательная функция для установки громкости
function applyVolumeToSound(sound, volume) {
    if (sound) {
        sound.volume = volume;
    }
}

// Константы для текстов
const DEFAULT_TEXT = "you can move me and listen to me. you can close me by pressing the button at the top.";
const BACKPACK_HOVER_TEXT = "watch out! Is something or someone behind you? are objects also subjects?";
const BACKPACK_CLICK_TEXT = "press to secure/save/survive";
const SUITCASE_HOVER_TEXT = "watch out! Is something or someone behind you? are objects also subjects?";
const SUITCASE_CLICK_TEXT = "press to secure/save/survive";
const SILHOUETTE_HOVER_TEXT = "have you ever been activated? please, check in with your soul. there are many other souls in the walls, it can get confusing.";
const SILHOUETTE_CLICK_TEXT = "have you ever been activated? please, check in with your soul.";
const OUTSIDE_HOVER_TEXT = "do you know the temperature of air outside someone's window?";
const OUTSIDE_CLICK_TEXT = "what is your favorite transmission tower? Though let me not distract you for long, I will hide away shortly";

// Прямая функция для обновления текста в пульте (усиленная и с запасным повтором)
function bedroomUpdateText(text) {
    try {
        // 1) Пробуем штатную систему
        if (typeof window.updateHorseText === 'function') {
            window.updateHorseText(text, 0);
        }

        // 2) Прямое обновление DOM — надёжно и сразу
        const container = document.getElementById('hi-update') || document.querySelector('.horse-indicator-text');
        if (container) {
            let child = container.querySelector('#horse-text-original');
            if (!child) {
                child = document.createElement('div');
                child.id = 'horse-text-original';
                container.innerHTML = '';
                container.appendChild(child);
            }
            child.textContent = text;
        }

        // 3) Повторно продублируем через короткую задержку — на случай гонок
        setTimeout(() => {
            try {
                if (typeof window.updateHorseText === 'function') {
                    window.updateHorseText(text, 0);
                }
                const c2 = document.getElementById('hi-update') || document.querySelector('.horse-indicator-text');
                if (c2) {
                    const ch2 = c2.querySelector('#horse-text-original');
                    if (ch2) ch2.textContent = text;
                }
            } catch (_) { /* noop */ }
        }, 60);
    } catch (e) {
        console.error('Ошибка при обновлении текста:', e);
    }
}

// Вспомогательная функция для поиска элементов по нескольким селекторам
function findElement(selectors) {
    if (!Array.isArray(selectors)) selectors = [selectors];
    for (const selector of selectors) {
        const elements = document.querySelectorAll(selector);
        if (elements.length > 0) return elements[0];
    }
    return null;
}

// Инициализация взаимодействий

function initializeBedroomInteractions() {
    // Находим все необходимые элементы
    const elements = {
        bedroomMain: document.getElementById('bedroom-main'),
        backpackInBedroomRoom: document.getElementById('backpack-in-bedroom-room'),
        suitcaseInBedroomRoom: document.getElementById('suitcase-in-bedroom-room'),
        outsideInBedroomRoom: document.getElementById('outside-in-bedroom-room'),
        backpackOverlay: document.getElementById('backpack-in-bedroom'),
        suitcaseOverlay: document.getElementById('bag-in-bedroom'),
        outsideOverlay: document.getElementById('outside-bedroom'),
        darkenBedroom: document.querySelector('.darken-bedroom'),
        suitcaseCloseOverlay: document.querySelector('.suitcase-close-overlay'),
        backpackCloseOverlay: document.querySelector('.backpack-close-overlay'),
        silhouetteOverlay: document.getElementById('silhouette'),
        silhouette: document.querySelector('.silhouette')
    };

    const buttons = {
        arrowLeftBackpackBedroom: document.getElementById('arrow-left-backpack-bedroom'),
        arrowLeftSuitcaseBedroom: document.getElementById('arrow-left-suitcase-bedroom'),
        arrowLeftOutsideBedroom: document.getElementById('arrow-left-outside-bedroom')
    };

    const sounds = {
        backpackSound: document.getElementById('backpackSound'),
        suitcaseSound: document.getElementById('suitcaseSound'),
        outsideSound: document.getElementById('outsideSound'),
        lullabySound: document.getElementById('lullabySound')
    };

        // Инициализируем глобальное состояние
        window.bedroomState = {
            inDetailView: false,
            currentText: DEFAULT_TEXT
        };

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

    // Обработчики hover-эффектов для текста в пультике
    
    // Рюкзак - hover и click эффекты
    if (elements.backpackOverlay) {
        // Hover
        elements.backpackOverlay.addEventListener('mouseenter', function() {
            bedroomUpdateText(BACKPACK_HOVER_TEXT);
        });
        
        elements.backpackOverlay.addEventListener('mouseleave', function() {
            // Не сбрасываем текст, если вошли в детальный режим
            if (!(window.bedroomState && window.bedroomState.inDetailView)) {
                bedroomUpdateText(DEFAULT_TEXT);
            }
        });
        
        // Click
        elements.backpackOverlay.addEventListener('click', function() {
            // Входим в детальный режим — фиксируем, чтобы hover не сбивал текст
            if (window.bedroomState) window.bedroomState.inDetailView = true;
            toggleVisibility(elements.bedroomMain, elements.backpackInBedroomRoom);
            bedroomUpdateText(BACKPACK_CLICK_TEXT);
        });
    }
    
    // Чемодан - hover и click эффекты
    if (elements.suitcaseOverlay) {
        // Hover
        elements.suitcaseOverlay.addEventListener('mouseenter', function() {
            bedroomUpdateText(SUITCASE_HOVER_TEXT);
        });
        
        elements.suitcaseOverlay.addEventListener('mouseleave', function() {
            // Не сбрасываем текст, если вошли в детальный режим
            if (!(window.bedroomState && window.bedroomState.inDetailView)) {
                bedroomUpdateText(DEFAULT_TEXT);
            }
        });
        
        // Click
        elements.suitcaseOverlay.addEventListener('click', function() {
            if (window.bedroomState) window.bedroomState.inDetailView = true;
            toggleVisibility(elements.bedroomMain, elements.suitcaseInBedroomRoom);
            bedroomUpdateText(SUITCASE_CLICK_TEXT);
        });
    }
    
    // Силуэт в окне - hover эффект с визуальным отображением
    if (elements.silhouetteOverlay && elements.silhouette) {
        elements.silhouetteOverlay.addEventListener('mouseenter', function() {
            // Визуальный эффект + текст в пультике
            elements.silhouette.style.transition = 'opacity 1s';
            elements.silhouette.style.opacity = '1';
            bedroomUpdateText(SILHOUETTE_HOVER_TEXT);
        });
        
        elements.silhouetteOverlay.addEventListener('mouseleave', function() {
            // Скрытие силуэта + сброс текста
            elements.silhouette.style.opacity = '0';
            bedroomUpdateText(DEFAULT_TEXT);
        });
        
        // Клик по силуэту - только воспроизведение звука без изменения текста
        elements.silhouetteOverlay.addEventListener('click', function() {
            if (sounds.lullabySound) {
                sounds.lullabySound.play();
            }
            // Текст уже обновлен при наведении (hover)
        });
    }

    elements.backpackCloseOverlay.addEventListener('click', () => {
        sounds.backpackSound.play();
        // Обновляем текст в пультике при клике на рюкзак
        bedroomUpdateText(BACKPACK_CLICK_TEXT);
    });

    elements.suitcaseCloseOverlay.addEventListener('click', () => {
        sounds.suitcaseSound.play();
        // Обновляем текст в пультике при клике на чемодан
        bedroomUpdateText(SUITCASE_CLICK_TEXT);
    });

        // Кнопки возврата - сбрасываем состояние детального просмотра
    if (buttons.arrowLeftBackpackBedroom) {
        buttons.arrowLeftBackpackBedroom.addEventListener('click', () => {
            // Выключаем режим детального просмотра
            window.bedroomState.inDetailView = false;
            
            // Переключение видимости
            toggleVisibility(elements.backpackInBedroomRoom, elements.bedroomMain);
            
            // Сбрасываем текст на дефолтный с задержкой
            setTimeout(() => {
                bedroomUpdateText(DEFAULT_TEXT);
            }, 100);
        });
    }
    
    if (buttons.arrowLeftSuitcaseBedroom) {
        buttons.arrowLeftSuitcaseBedroom.addEventListener('click', () => {
            // Выключаем режим детального просмотра
            window.bedroomState.inDetailView = false;
            
            // Переключение видимости
            toggleVisibility(elements.suitcaseInBedroomRoom, elements.bedroomMain);
            
            // Сбрасываем текст на дефолтный с задержкой
            setTimeout(() => {
                bedroomUpdateText(DEFAULT_TEXT);
            }, 100);
        });
    }

//////////// ИНТАРАКЦИЯ С ОКНОМ

// Окно наружу - hover, click эффекты и затемнение
if (elements.outsideOverlay) {
    // Hover с затемнением и звуком
elements.outsideOverlay.addEventListener('mouseenter', () => {
        // Визуальный эффект затемнения
        if (elements.darkenBedroom) {
            elements.darkenBedroom.style.transition = 'opacity 1s';
            elements.darkenBedroom.style.opacity = '1';
        }
    
        // Звуковой эффект
        if (sounds.outsideSound) {
            sounds.outsideSound.volume = 0;
            sounds.outsideSound.play();
            fadeInVolume(sounds.outsideSound, 0.5, 1800);
        }
        
        // Текст в пультике
        bedroomUpdateText(OUTSIDE_HOVER_TEXT);
    });

    // Уход с окна
elements.outsideOverlay.addEventListener('mouseleave', () => {
        // Возвращаем исходное состояние
        if (elements.darkenBedroom) {
    elements.darkenBedroom.style.opacity = '0';
        }
        
        if (sounds.outsideSound) {
    sounds.outsideSound.pause();
        }
        
        // Сбрасываем текст в пультике только если не в детальном режиме
        if (!(window.bedroomState && window.bedroomState.inDetailView)) {
            bedroomUpdateText(DEFAULT_TEXT);
        }
});

    // Клик по окну - открытие режима просмотра
    elements.outsideOverlay.addEventListener('click', function() {
        if (window.bedroomState) window.bedroomState.inDetailView = true;
        // Звук
        if (sounds.outsideSound) {
            applyVolumeToSound(sounds.outsideSound, 1);
        }
        
        // Переключение видимости
        toggleVisibility(elements.bedroomMain, elements.outsideInBedroomRoom);
        
        // Обновляем текст в пультике
        bedroomUpdateText(OUTSIDE_CLICK_TEXT);
        
        // Запуск звука с небольшой задержкой
        if (sounds.outsideSound) {
            setTimeout(function() {
                sounds.outsideSound.play();
            }, 10);
        }
    });
}


// Возврат из режима просмотра окна
if (buttons.arrowLeftOutsideBedroom) {
    buttons.arrowLeftOutsideBedroom.addEventListener('click', function() {
        // Выключаем режим детального просмотра
        if (window.bedroomState) window.bedroomState.inDetailView = false;
        // Переключение видимости
        toggleVisibility(elements.outsideInBedroomRoom, elements.bedroomMain);
        
        // Останавливаем воспроизведение звука
        if (sounds.outsideSound) {
            sounds.outsideSound.pause();
            sounds.outsideSound.currentTime = 0;
        }
        
        // Сбрасываем текст на дефолтный
        bedroomUpdateText(DEFAULT_TEXT);
    });
}

//////////// ИНТАРАКЦИЯ С СИЛУЭТОМ

// Обработчик клика для силуэта перенесен в основной блок с hover-эффектами

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
//////////// RAIN CHANGE

document.addEventListener('mousemove', (e) => {
    const width = window.innerWidth;
    const xPercent = e.clientX / width; // Нормализация положения курсора (от 0 до 1)

    // Интерполяция угла от 33 до -57 градусов
    const angle = 33 - (90 * xPercent); // Линейная интерполяция от 33 до -57

    // Применение угла к CSS-переменной
    document.querySelector('.rain').style.setProperty('--rainAngle', `${angle}deg`);
});

}

/*
// Этот код больше не нужен, так как текст в пультике обрабатывается через horse-text-handler.js
// Функция для проверки загрузки зависимостей
function checkHorseHandler() {
    console.log('Проверка наличия обработчика horse-text-handler...');
    
    // Проверяем наличие функции updateHorseText
    if (typeof window.updateHorseText === 'function') {
        console.log('✓ Найдена функция updateHorseText');
        return true;
    }
    
    // Проверяем наличие обработчика по элементу
    const horseTextElement = document.getElementById('horse-text-original');
    if (horseTextElement) {
        console.log('✓ Найден элемент horse-text-original');
        return true;
    }
    
    // Проверяем наличие элемента пультика
    const horseIndicator = document.querySelector('.horse-indicator');
    if (horseIndicator) {
        console.log('✓ Найден элемент horse-indicator');
        return true;
    }
    
    console.log('✗ Обработчик horse-text-handler не загружен полностью');
    return false;
}

// Функция для динамической загрузки скрипта horse-text-handler, если он отсутствует
function loadHorseTextHandler() {
    if (checkHorseHandler()) return true;
    
    console.log('Загружаю скрипт horse-text-handler.js...');
    
    // Создаем и добавляем скрипт
    const script = document.createElement('script');
    script.src = '/wp-content/themes/blankslate/js/horse-text-handler.js';
    script.async = true;
    
    // Обработчик загрузки
    script.onload = function() {
        console.log('✓ Скрипт horse-text-handler.js загружен успешно');
        // Ждем небольшую паузу для инициализации скрипта
        setTimeout(initializeBedroomInteractions, 500);
    };
    
    // Обработчик ошибки
    script.onerror = function() {
        console.error('✗ Ошибка загрузки скрипта horse-text-handler.js');
        // Все равно пытаемся инициализировать
        setTimeout(initializeBedroomInteractions, 500);
    };
    
    document.head.appendChild(script);
    return false;
}
*/

// Обычная инициализация при загрузке DOM
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM загружен, инициализируем bedroom interactions');
    initializeBedroomInteractions();
});
</script>




<script src="https://nohome.cloud/wp-content/themes/blankslate/files/captcha/captcha.js"></script>
<!-- /wp:html -->