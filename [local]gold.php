<!-- wp:html -->
<style>
.particle {
	font-size: 180px;
	font-family: "arial", sans-serif;
	position: absolute;
	visibility: hidden;
top: 0;
}
.numbers-in-lock {
position: absolute;
width: 100vw;
height: 100vh;
top: 0;
left: 0;
overflow: hidden;
}
#ascii-art, #ascii-art-1, #ascii-art-2 {
    position: fixed;
    display: none;
    font-family: 'Lucida Console', Monaco, monospace;
    white-space: pre;
    font-size: 15px;
    line-height: 1.1;
    /*letter-spacing: 0.15 em;*/
    color: rgba(255, 255, 255, 0.5);
    background: rgba(0, 0, 0, 0);
    /*border: 1px solid rgba(255, 255, 255, 0.3);*/
    z-index: 1000;
    pointer-events: none;
    direction: ltr; /* Добавлено для правильного направления текста */
}
.ascii-art-18px {
    font-size: 17px;
    direction: ltr; /* Добавлено для правильного направления текста */
}
#ascii-art::after, #ascii-art-1::after, #ascii-art-2::after {
    content: '';
    position: absolute;
    top: -40px;
    left: -40px;
    width: calc(100% + 80px);
    height: calc(100% + 80px);
    background: rgba(0, 0, 0, 0.8);
    z-index: -1;
    border-radius: 55px; /* Закругление краев псевдоэлемента */
    filter: blur(20px); /* Эффект размытия */
}
#golden-room-3d {
    z-index: 55;
    background-color: transparent;
}
#loadingScreen {
    position: absolute;
    /* left: 50% !important; */
    /* top: 50% !important; */
    /* transform: translate(-50%, -50%) !important; */
    /* border-radius: 10px !important; */
    z-index: 99 !IMPORTANT;
    width: 100vw !IMPORTANT;
    height: 100vh !IMPORTANT;
}
#loadingProgress {
width: 100%;
height: 100%;
}
.loading-horse {
    height: 100%;
    width: 100%;
object-fit: cover;
}
#loadUpdate {
    z-index: +1;
    position: absolute;
    font-size: 50vh;
    top: 60%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-family: 'Henny Penny';
    -webkit-text-stroke: 1px white;
    color: transparent;
}
</style>

<div id="ascii-art">
<span class="ascii-art-18px">0️⃣1️⃣2️⃣3️⃣4️⃣5️⃣6️⃣7️⃣8️⃣9️⃣</span>
────▄████▄▄─▄▄████▄───
───▐███████████████▌──
────█████░░▒░░█████───
─────▀▀▀█░█▒█░█▀▀▀────
───────▐▒▒▒▓▒▒▒▌──────
▀▀▐▐▐▐▀▀▀▀▀▀▀▀▀▀▀▌▌▌▌▀▀
<span class="ascii-art-18px">🎡🎢🎠🎡🎢🎠🎡🎢🎠🎡🎢🎠🎡</span>
</div>
<div id="ascii-art-1">
<span class="ascii-art-18px">🛒🪟🪞🗝️🚪💎💳⏱️💻🖱️🕹️🛩️🚅🚔🚘🛸</span>
 ░░░░░░░░░░░░▄▄▄▀▀▀▀▄▄▄██▄░░░░░░░
 ░░░░░░░░░▄▀▀░░░░░░░░░█████░░░░░░
 ░░░░░░░░█░░░░░░░░░░░░▀████░░░░░░
 ░░░░░░░▀░░░░░░░░░░░░░░░░░░█▄░░░░
 ░░░░░░█░░░░░░░░░░░░░░░░░▀░░▀▀▄▄░
 ░▄▀▀▀▀█░░░░░░░░░░░░░░░░░░░░░░██▀
 █░░░░░▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀░░░
 ░▀▄▄▄▄▄▄▄▀▀▀▀▀▄░░░░░░░░░░░░░░░░░
 ░░░░░░░░░░░░░░█░░░░░░░░░░░░░░░░░
 ░░░░░░░░░░▀▄▄▄▀░░░░░░░░░░░░░░░░░
<span class="ascii-art-18px">🔐🔓🧮📝📌📍🗄️📋🗂️🗞️🗓️📬📉📑🧾📩🦴</span>
</div>

<div id="ascii-art-2">
<span class="ascii-art-18px">🩺🩻🧬💊🧪🦠💉🩸🌡️⚔️🪪</span>
░░░░░░░░░░░░░░░░░░░░░░░
░░░░░░▄░░░▄░▄░░░▄░░░░░░
░░░░▄███▄░███░▄███▄░░░░
░░▄█▀█▀█▀█████▀█▀█▀█▄░░
░▀▀░░░░░░░▐░▌░░░░░░░▀▀░
<span class="ascii-art-18px">🔋🪫⚰️🪦🕳️🔬🔬🔬🔬🔬🔬</span>
</div>



<!--div class="numbers-in-lock"></div-->

<!-- ////////////// GOLDEN-ROOM-MAIN ////////////////// -->

    <div id="loadingScreen">
        <div id="loadingProgress">
    <video class="loading-horse" autoplay muted loop>
        <source src="https://nohome.cloud/wp-content/themes/blankslate/files/golden-room/lock.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
         <div id="loadUpdate">0%</div>
         </div>
    </div>

<div id="golden-room-3d" data-glb-url="/wp-content/themes/blankslate/files/golden-room/Compressed_GR1.glb" class="room-wrapper animated-display">
</div>

<!-- ////////////// GOLDEN-ROOM-DOOR ////////////////// -->

<div id="golden-room-door" class="room-wrapper animated-display" style="display: none">
    <img class="room-background-img" src="https://nohome.cloud/wp-content/themes/blankslate/files/golden-room/golden-room-door.jpg" alt="Golden room with rats and locker">

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
      <path class="overlay-svg golden-room-door-rats" pointer-events="bounding-box" d="M828.131 1942.54C837.84 1942.56 848.069 1945.08 855.481 1948.61C870.946 1955.96 872.87 1967.32 874.623 1977.85C885.458 1981.01 953.966 1996.06 964.529 1996.86C975.166 1997.66 987.116 1997.18 997.873 1997.14L998.068 1998.06C954.913 2003.36 911.973 1991.99 871.235 1984.85C870.824 1985.36 870.37 1985.85 870.003 1986.37C866.532 1991.25 864.041 1993.04 856.822 1996.29L854.501 1997.33C853.89 1998.98 853.189 2000.44 852.142 2002.03C851.806 2002.54 851.445 2003.05 851.097 2003.56C850.38 2004.1 849.675 2004.64 848.946 2005.18C842.765 2009.72 838.742 2010.31 829.151 2011L826.553 2009.71L826.145 2010.45C830.01 2006.96 839.3 2004.6 845.492 2002.45C845.823 2000.25 843.624 1998.63 841.944 1996.66L839.423 1996.71L838.557 1998.04L841.118 1996.13L839.999 1995.77C830.902 2001.56 825.846 2005.53 813.018 2008.74C807.161 2010.2 807.677 2013.71 801.887 2015.48L800.363 2014.21C799.94 2009.46 806.351 2004.94 808.785 2000.47C810.38 1997.53 809.653 1996.19 807.499 1993.47L805.276 1993.74C800.48 2000.23 800.977 2007.17 797.771 2013.93L795.951 2012.7L794.034 2014.5L791.371 2013.48C789.574 2008.87 795.171 2005.23 796.648 2000.85C797.445 1998.49 796.52 1994.92 793.874 1992.98C792.118 1991.7 787.847 1992.01 785.172 1991.86C776.926 1986.58 787.421 1977.17 786.106 1970.69C785.441 1967.41 784.01 1964.21 787.287 1961.39C789.117 1963.1 789.893 1963.78 792.805 1965.01C806.549 1959.22 813.644 1948.81 828.131 1942.54Z"/>
          <path class="overlay-svg golden-room-door-rats" pointer-events="bounding-box" d="M2613.11 1876.1C2631.71 1876.45 2641.83 1889.12 2656.02 1894.54L2659.14 1894.12L2661.37 1890.62L2663.35 1890.18L2664.97 1891.43C2664.31 1900.19 2676.93 1910.69 2674.84 1917.04C2673.91 1919.85 2658.3 1920.72 2653.24 1922.91C2647.63 1929.42 2659.48 1934.75 2658.37 1942.2L2656.85 1942.66L2654.81 1941.82L2651.66 1945.09C2645.33 1943.51 2640.17 1933.52 2632.9 1930.19C2626.89 1927.44 2620.04 1927.4 2612.71 1927.87L2612.38 1929.8C2617.83 1934.2 2627.72 1932.95 2634.39 1937.05L2633.79 1939.16L2630.35 1939.7C2622.21 1938.14 2615.75 1935.39 2608.75 1932.66L2604.95 1933.33L2603.7 1935.44L2606.24 1937.31C2612.16 1938.18 2616.81 1938.87 2621.81 1940.9L2621.77 1942.47L2617.81 1943.49C2612.29 1943.31 2609.88 1942.98 2604.99 1941.29C2603.73 1940.54 2601.58 1939.32 2600.65 1938.5C2593.74 1932.37 2582.88 1928.52 2578.33 1921.65C2567.04 1925.02 2555.53 1928.48 2543.28 1930.61C2528.51 1933.17 2494.53 1933.16 2484.04 1938.9C2480.39 1940.9 2480.12 1943.13 2479.83 1945.81C2479.79 1946.12 2479.78 1946.43 2479.75 1946.75C2479.05 1946.43 2478.21 1946.19 2477.65 1945.79C2474.9 1943.85 2475.01 1942.52 2475.54 1940.28C2488.68 1929.4 2543.39 1927.22 2570.54 1916.29L2572.44 1915.51C2573.3 1910.37 2574.11 1905.17 2576.24 1900.14C2581.39 1887.92 2595.42 1882.46 2613.11 1876.1Z"/>
          <path class="overlay-svg golden-room-door-rats" pointer-events="bounding-box" d="M1401.49 1844.18C1405.73 1844.45 1409.78 1844.93 1413.71 1845.91C1428.15 1849.48 1435.12 1859.01 1439.78 1866.85C1448.06 1867.85 1463.39 1869.17 1468.42 1873.59C1470.86 1875.73 1472.08 1877.55 1470.38 1880.04C1466.4 1885.87 1451.94 1888.83 1442.64 1891.24C1441.66 1893.8 1440.83 1895.74 1438.29 1897.98C1433.43 1902.28 1430.91 1907.19 1426.45 1911.63C1423.04 1915.02 1419.59 1916.88 1412.84 1917.96L1408.46 1915.52L1408.25 1916.45L1408.82 1913.75C1413.59 1909.78 1421.05 1908.51 1428.57 1906.63C1425.68 1904.84 1422.17 1902.24 1418.7 1900.85C1413.46 1898.76 1408.73 1899.79 1402.89 1900.22C1399.22 1902.95 1401.67 1906.86 1399.33 1910.15C1386.2 1911.64 1381.22 1918.41 1370.31 1918.68L1369.35 1914.32L1365.7 1916.25L1363.79 1915.73L1362.78 1912.67C1364.61 1908.86 1368.31 1906.3 1372.49 1903.17C1371.23 1898.99 1369.98 1894.84 1368.21 1890.72C1359.92 1890.27 1349.71 1890.09 1342.09 1888.17C1338.03 1887.15 1336.69 1886.22 1335.3 1883.93C1336.18 1881.93 1336.88 1881.06 1339.3 1879.46C1345.26 1875.53 1349.23 1870.47 1355.87 1866.94C1356.64 1866.53 1357.45 1866.14 1358.24 1865.74C1358.41 1863.38 1358.68 1861.07 1359.13 1858.73L1362.34 1857.72C1363.32 1859.58 1364.34 1861.09 1366.05 1862.78C1379.05 1861.65 1391.3 1849.28 1401.49 1844.18ZM1440.56 1868.47C1442.04 1872.65 1443.34 1876.75 1444.11 1880.99L1446.87 1883.07C1453.11 1883.58 1458.54 1881.44 1463.96 1879.92L1466.71 1877.05C1464.39 1874.04 1461.11 1872.85 1455.9 1871.67Q1448.28 1869.99 1440.56 1868.47Z"/>
          <path class="overlay-svg golden-room-door-rats" pointer-events="bounding-box" d="M3199.56 1909.69C3202.45 1911.02 3201.71 1910.45 3203.45 1911.99C3206.02 1914.26 3207.29 1915.96 3211.74 1917.25C3221.35 1916.25 3230.97 1913.83 3240.18 1911.97C3247.24 1913.42 3253.32 1914.85 3259.06 1917.65C3285.89 1930.73 3291.04 1948.57 3293.62 1967.28C3307.68 1976.83 3352.18 2006.81 3368.44 2011.69C3381.27 2015.54 3394.82 2015.89 3408.2 2018.48C3405.43 2018.81 3402.9 2018.97 3400.07 2018.84C3369.75 2017.44 3355.95 2013.2 3336.01 2000.38C3321.92 1991.97 3304.06 1978.68 3284.77 1974.49C3278.76 1974.95 3278.33 1975.82 3274.25 1978.22C3269.31 1979.57 3266.01 1978.98 3260.9 1978.38L3258.83 1978.12C3256.44 1979.63 3253.79 1982.36 3250.99 1983.5C3246.93 1985.15 3243.27 1985.62 3238.37 1984.85C3234.13 1984.18 3231.43 1982.73 3229.18 1980.71L3231.37 1979.19C3237.41 1978.35 3240.95 1978.5 3247.03 1979.26C3247.68 1979.34 3248.33 1979.43 3248.98 1979.51L3249.66 1978.58L3245.66 1975.3C3242.96 1975.1 3240.8 1974.84 3238.13 1974.43C3238.61 1972.94 3239.16 1971.34 3239.17 1969.82C3239.23 1964.56 3229.16 1960.78 3222.85 1957.54C3214.38 1961.65 3205.89 1965.58 3196.87 1969.31L3195.55 1968.15C3196.6 1962.45 3203.8 1959.78 3206.2 1954.7C3212.82 1940.71 3172.04 1938.66 3162.39 1930.05C3159.99 1927.91 3160.65 1927.24 3161.44 1924.89C3168.68 1919.94 3180.67 1918.05 3190.86 1915.76C3197.3 1914.32 3196.93 1913.12 3199.56 1909.69Z"/>
          <path class="overlay-svg golden-room-door-rats" pointer-events="bounding-box" d="M551.031 1841.46C562.054 1842 586.187 1849.89 594.525 1848.04C595.663 1845.66 596.353 1843.57 599.413 1841.7L602.456 1842.14C602.796 1842.69 603.104 1843.25 603.475 1843.79C604.205 1844.86 605.498 1846.79 607.717 1847.31C610.844 1848.05 615.604 1848.03 619.018 1848.57C626.732 1849.8 634.454 1852.32 641.676 1854.28C643.103 1855.65 644.283 1856.06 643.723 1857.74C641.032 1865.76 611.014 1873.67 599.026 1877.9C586.673 1896.75 598.373 1888.99 607.791 1903.33L606.111 1903.9C593.956 1901.23 584.076 1896.03 573.863 1891.54C565.731 1895.51 554.065 1898.16 547.75 1902.98L548.923 1904.27C553.485 1904.51 557.717 1904.6 561.849 1905.84C564.605 1906.66 563.83 1906.37 564.487 1908.11C559.076 1909.7 554.211 1908.99 548.389 1909.16C543.258 1909.31 540.246 1909.32 536.754 1911.49C540.337 1914.28 554.646 1912.7 561.375 1914.47L561.375 1915.91C558.617 1916.81 556.331 1917.48 553.169 1917.83C541.993 1919.07 536.264 1917.57 526.928 1914.16C527.513 1911.78 528.417 1911.49 526.087 1909.37C522.238 1909.82 518.821 1910 514.889 1910.02C507.559 1907.76 509.422 1906.28 504.395 1903.52C500.782 1901.53 467.255 1912.96 459.65 1913.87C440.857 1916.12 418.636 1911.95 399.467 1911.61C385.453 1911.37 371.678 1912.84 357.827 1913.86L359.167 1912.56L356.686 1913.83L356.653 1913.34C414.5 1901.93 445.937 1918.03 497.461 1894.74C498.648 1888.22 499.469 1881.5 502.793 1875.2C510.087 1861.37 528.193 1848.29 551.031 1841.46Z"/>
          <path class="overlay-svg golden-room-door-lock" pointer-events="bounding-box" d="M1594.29 1018.58C1612.64 1019.03 1631.24 1018.8 1649.59 1018.48C1648.3 1040.2 1649.67 1062.06 1649.3 1083.8C1641.27 1083.73 1633.2 1083.39 1625.31 1084.39C1626.74 1100.87 1625.27 1117.44 1626 1133.93C1626.32 1141.11 1628.89 1148.13 1629.14 1155.43C1635.8 1159.3 1644.2 1170.2 1651.07 1171.8L1655.59 1169.72C1660.78 1169.57 1662.53 1170.69 1666.87 1172.21C1676.26 1171.13 1671.52 1167.9 1676.05 1164.8C1678.32 1163.25 1683.11 1161.67 1686.03 1160.38C1692.26 1145.97 1689.68 1128.59 1689.71 1113.72L1689.58 1049.23C1717.95 1048.36 1746.83 1048.95 1775.26 1048.98C1795.14 1049 1816.82 1047.96 1836.43 1049.71L1838.88 1051.77Q1837.59 1108.9 1838.87 1166.03C1813.24 1167.65 1704.34 1164.46 1692.2 1167.64C1684.49 1169.66 1675.11 1178.77 1663.57 1181.52C1659.03 1182.61 1656.78 1182.28 1652.4 1181.27C1651.59 1180.33 1650.82 1179.37 1649.91 1178.45C1646.82 1175.34 1644.49 1175.06 1638.45 1174.06C1637.58 1173.92 1636.7 1173.79 1635.83 1173.65C1632.82 1172.05 1630.96 1170.57 1629.21 1168.45C1616.51 1153.02 1610.67 1122.89 1620.87 1107.16C1611.53 1096.56 1620.18 1090.4 1615.68 1084.87C1609.23 1083.01 1601.34 1083.87 1594.31 1084.13C1595.1 1062.31 1594.35 1040.4 1594.29 1018.58Z"/>
</svg>

<!-- Left Arrow Button -->
  <div class="container">
    <div class="row">
      <div class="col-12">
        <button id="to-golden-room-main" class="arrow-button arrow-left-button">
            <img class="arrow arrow-left arrow-white" src="https://nohome.cloud/wp-content/themes/blankslate/files/nav/arrow-right.png" alt="Left arrow">
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ////////////// GOLDEN-ROOM-DOOR-RATS ////////////////// -->

<div id="golden-room-door-rats" class="room-wrapper animated-display" style="display: none">
    <img class="room-background-img nextrats" src="https://nohome.cloud/wp-content/themes/blankslate/files/golden-room/golden-room-door-rats1.jpg" alt="Rats">
    <img class="room-background-img nextrats" src="https://nohome.cloud/wp-content/themes/blankslate/files/golden-room/golden-room-door-rats2.jpg" alt="Rats">
    <img class="room-background-img nextrats" src="https://nohome.cloud/wp-content/themes/blankslate/files/golden-room/golden-room-door-rats3.jpg" alt="Rats">
    <img class="room-background-img nextrats" src="https://nohome.cloud/wp-content/themes/blankslate/files/golden-room/golden-room-door-rats4.jpg" alt="Rats">

<!-- Left Arrow Button -->
  <div class="container">
    <div class="row">
      <div class="col-12">
        <button id="to-golden-room-door" class="arrow-button arrow-left-button">
            <img class="arrow arrow-left arrow-white" src="https://nohome.cloud/wp-content/themes/blankslate/files/nav/arrow-right.png" alt="Left arrow">
        </button>
      </div>
    </div>
  </div>
</div>


<!-- ////////////// GOLDEN-ROOM-DOOR-LOCK ////////////////// -->

<div id="golden-room-door-lock" class="room-wrapper animated-display" style="display: none">
    <img class="room-background-img" src="https://nohome.cloud/wp-content/themes/blankslate/files/golden-room/golden-room-door-lock.jpg" alt="Lock on a door">

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
        <path class="overlay-svg" id="LockInLockOverlay" d="M536.631 208.689C552.559 211.828 673.953 209.823 699.783 209.821L1102.69 209.843C1108.9 216.682 1119.26 223.833 1120.44 231.645C1123.86 254.319 1120.81 278.462 1120.8 301.28L1120.79 443.49L1120.72 894.053L836.188 894.077L836.157 916.603C852.075 927.859 860.463 942.554 863.834 956.683C867.354 971.436 866.21 986.703 866.236 1001.56C866.289 1032.17 871.301 1065.21 836.162 1090.91L836.42 1144.35C836.443 1155.07 837.507 1166.26 834.966 1176.89C851.682 1188.57 860.424 1202.11 863.923 1216.92C867.429 1231.75 866.223 1247.16 866.247 1262.1C866.296 1292.72 871.009 1325.99 836.326 1351.89C836.379 1379.87 839.203 1408.91 834.952 1436.73C840.338 1440.72 845.462 1444.68 849.573 1449.13Q854.142 1454.17 857.688 1459.46Q861.234 1464.76 863.715 1470.24C870.833 1486.03 873.085 1502.95 876.787 1519.09C880.519 1535.36 886.154 1552.38 885.875 1568.81Q885.878 1573.42 885.267 1578.01Q884.656 1582.6 883.434 1587.16Q882.213 1591.71 880.387 1596.2Q878.562 1600.69 876.144 1605.09Q898.172 1641.05 921.717 1676.7L935.845 1678.6C943.023 1679.52 948.588 1680.23 954.455 1682.88C978.414 1693.68 1026.4 1732.03 1037.81 1748.21C1044.72 1758.02 1047.41 1767.66 1049.09 1778.12C1073.45 1787.97 1100.09 1796.47 1125.36 1805.62C1134.95 1796.91 1147.37 1791.67 1162.32 1786.16C1186.4 1785.57 1219.15 1783.58 1242.33 1787.35C1263.33 1790.76 1272.86 1799.98 1282.77 1810.02C1305.73 1803.55 1328.58 1796.66 1350.17 1788.83C1351.81 1777.85 1354.22 1766.98 1361.39 1756.65C1369.42 1745.07 1421 1701.85 1441.47 1698.58C1452.44 1696.82 1464.99 1697.62 1475.15 1700.39C1475.66 1700.53 1476.16 1700.68 1476.66 1700.82C1487.16 1695.54 1506.52 1662.69 1512.84 1653.67C1489.99 1617.78 1495.59 1602.13 1509.46 1565.9C1513.88 1554.35 1517.18 1542 1523.14 1530.7C1526.93 1523.53 1535.62 1517.17 1537.71 1509.72C1542 1494.42 1538.42 1456.71 1538.42 1439.06L1538.21 556.347C1577.18 558.283 1619.11 556.545 1658.39 556.628L1949.68 556.612L2900.34 556.951L2998.71 556.875C3000.17 606.5 2998.88 656.252 2998.88 705.894L2998.89 993.729L2998.57 1707.98L2108.09 1707.85L1747.83 1707.83C1678.68 1707.82 1609.21 1707.06 1540.11 1708.27Q1530.28 1721.9 1520.21 1735.47C1521.84 1740.15 1522.95 1744.94 1523.87 1749.67C1531.68 1790.18 1493.59 1813.74 1451.27 1843.38C1440.25 1851.09 1425.1 1858.87 1406.65 1859.62C1399.71 1859.91 1393.67 1858.73 1388.56 1856.06C1384.3 1853.83 1379.87 1851.79 1375.33 1849.74C1374.97 1849.93 1374.61 1850.12 1374.24 1850.31C1373.62 1850.63 1372.99 1850.93 1372.38 1851.25C1350.8 1862.43 1320.71 1869.9 1295.13 1877.83C1294.04 1880.18 1292.88 1882.47 1291.42 1884.75C1284.12 1896.11 1272.75 1907.72 1252.19 1912.78C1233.08 1917.47 1167.68 1917.39 1148.21 1912.94C1124.49 1907.51 1114.48 1892.78 1105.27 1880.51C1074.19 1875.15 1043.27 1861.35 1015.68 1851.64C1013.26 1852.63 1014.29 1852.04 1012.3 1853.83C1010.06 1855.85 1009.66 1855.46 1005.79 1856.15L1006.92 1853.37C1003.84 1851.27 974.816 1853.87 964.861 1850.9C940.181 1843.53 872.483 1787.23 864.641 1769.93C858.523 1756.44 862.8 1741.29 855.15 1728.41C837.552 1698.78 815.221 1669.94 800.153 1639.84C793.443 1637.81 788.059 1635.37 783.076 1632.12C772.838 1625.46 764.708 1616.33 760.144 1607.92C751.225 1591.46 729.849 1505.82 732.835 1489.9C734.392 1481.6 736.837 1472.95 741.106 1464.95C746.745 1454.37 755.861 1444.5 757.193 1433.31C760.291 1407.27 755.301 1380.81 758.011 1354.67C741.047 1336.66 730.798 1322.12 729.252 1301.54C728.225 1287.89 728.776 1274.11 728.778 1260.44C728.783 1235.25 724.364 1199.38 757.436 1179.34C756.326 1153.77 761.815 1116.65 755.862 1092.7C753.232 1082.11 737.872 1072.42 733.571 1061.62C724.016 1037.64 728.554 1003.57 728.824 978.289C729.03 958.99 732.027 931.737 758.071 917.259C757.178 909.545 757.29 901.768 757.114 894.038L637.144 894.159C613.891 894.174 589.688 894.969 566.602 893.483C556.288 892.819 546.037 891.05 536.057 889.483L536.091 435.715L536.061 288.897C536.028 262.277 534.322 235.267 536.631 208.689ZM824.447 1479.2C821.084 1484.3 817.762 1493.73 811.016 1497.14C802.5 1498.06 789.77 1500.77 782.068 1498.67C779.592 1495.71 777.105 1491.07 772.254 1489.42C769.865 1502.12 786.86 1573.74 793.782 1587.47L794.397 1588.72L797.128 1589.31L797.747 1587.7L799.329 1583.8C801.554 1578.36 808.19 1567.61 817.715 1565.03C823.201 1563.55 828.733 1563.28 834.448 1564.44C839.676 1565.51 843.619 1567.9 846.998 1570.28L848.459 1570.38C845.819 1556.94 832.869 1484.73 824.447 1479.2ZM823.524 1215.71C818.695 1220.98 813.349 1228.98 802.396 1230.86C794.388 1232.23 787.982 1230.17 781.142 1228.15L769.529 1216.99C767.066 1231.37 763.772 1298.22 771.024 1310.08C772.986 1309 772.538 1309.58 772.967 1308.52C777.558 1303.48 783.041 1296.59 793.515 1294.76C799.233 1293.76 804.011 1294.12 809.153 1295.85C818.181 1298.89 822.327 1304.66 826.687 1309.77C828.473 1288.65 832.262 1233.86 823.524 1215.71ZM771.494 955.332C764.191 972.305 766.143 1030.27 769.257 1049.41L780.542 1036.88L797.463 1032.08C803.33 1033.81 808.887 1035.46 814.155 1037.73L825.221 1049.6C830.415 1036.07 829.731 969.68 824.465 956.203C819.468 961.49 814.272 968.388 803.252 970.386C798.155 971.311 793.298 970.324 789.028 968.761C779.862 965.407 776.773 961.552 772.604 956.245C772.339 955.908 771.864 955.637 771.494 955.332ZM937.666 1715.55C937.797 1725.59 935.167 1733.53 930.207 1743.11C923.936 1746.93 917.495 1750.69 911.48 1754.64C906.975 1754.29 904.255 1754.18 900.458 1752.65C898.896 1760.1 961.642 1805.06 972.542 1813.49L974.312 1812.44L973.906 1810.97C971.41 1801.33 970.44 1790.09 981.17 1782.03C987.601 1777.19 995.909 1773.36 1003.05 1768.89C997.919 1759.05 955.701 1726.59 941.112 1719.15C939.058 1718.11 938.422 1717 937.666 1715.55ZM1450.84 1730.55C1436.66 1736.59 1392.49 1768.74 1387.52 1777.81C1389.45 1779.75 1388.07 1779.02 1391.39 1779.94C1400.77 1782.55 1407.25 1784.62 1410.71 1790.43C1417.27 1801.45 1410.5 1811.43 1407.04 1822.12C1412.84 1823.23 1416.96 1822.58 1422.34 1820.96C1423.09 1820.74 1423.8 1820.47 1424.54 1820.23C1443.87 1806 1475.12 1786.27 1489.37 1771.37L1487.03 1770.35L1485.8 1768.08L1486.42 1768.16C1481.31 1769.75 1475.77 1771.99 1469.7 1771.01C1464.15 1770.11 1460.77 1767.34 1458.56 1764.52C1445.48 1747.79 1459.64 1741.77 1456.59 1731.38L1450.84 1730.55ZM1159.41 1822.57C1169.42 1832.87 1173.04 1843.81 1167.41 1855.3C1163.95 1862.35 1157.75 1867.55 1149.35 1873.03C1153.88 1875.1 1158.32 1877.31 1163.26 1879.05L1240.29 1878.97L1242.39 1877.87C1238.76 1872.37 1232.67 1868.25 1230.95 1862.31C1229.31 1856.66 1228.99 1850.62 1231.06 1845C1233.19 1839.21 1245.25 1829.3 1241.02 1823.85C1223.24 1821.1 1178.17 1821.18 1159.41 1822.57Z"/>

</svg>

<!-- Left Arrow Button -->
  <div class="container">
    <div class="row">
      <div class="col-12">
        <button id="to-golden-room-door-r" class="arrow-button arrow-left-button">
            <img class="arrow arrow-left arrow-white" src="https://nohome.cloud/wp-content/themes/blankslate/files/nav/arrow-right.png" alt="Left arrow">
        </button>
      </div>
    </div>
  </div>
</div>

<script type="importmap">
{
  "imports": {
    "three": "https://nohome.cloud/three.js-master/build/three.module.js",
    "three/examples/jsm/loaders/GLTFLoader": "https://nohome.cloud/three.js-master/examples/jsm/loaders/GLTFLoader.js",
    "three/examples/jsm/loaders/DRACOLoader": "https://nohome.cloud/three.js-master/examples/jsm/loaders/DRACOLoader.js",
    "three/examples/jsm/controls/OrbitControls": "https://nohome.cloud/three.js-master/examples/jsm/controls/OrbitControls.js",
    "three/examples/jsm/postprocessing/EffectComposer": "https://nohome.cloud/three.js-master/examples/jsm/postprocessing/EffectComposer.js",
    "three/examples/jsm/postprocessing/RenderPass": "https://nohome.cloud/three.js-master/examples/jsm/postprocessing/RenderPass.js",
    "three/examples/jsm/postprocessing/OutlinePass": "https://nohome.cloud/three.js-master/examples/jsm/postprocessing/OutlinePass.js",
    "three/examples/jsm/postprocessing/ShaderPass": "https://nohome.cloud/three.js-master/examples/jsm/postprocessing/ShaderPass.js",
    "three/examples/jsm/shaders/GammaCorrectionShader": "https://nohome.cloud/three.js-master/examples/jsm/shaders/GammaCorrectionShader.js"
  }
}
</script>

<script type="module">
import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader';
import { DRACOLoader } from 'three/examples/jsm/loaders/DRACOLoader';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls';
import { EffectComposer } from 'three/examples/jsm/postprocessing/EffectComposer';
import { RenderPass } from 'three/examples/jsm/postprocessing/RenderPass';
import { OutlinePass } from 'three/examples/jsm/postprocessing/OutlinePass';
import { ShaderPass } from 'three/examples/jsm/postprocessing/ShaderPass';
import { GammaCorrectionShader } from 'three/examples/jsm/shaders/GammaCorrectionShader';

document.addEventListener('initializeGoldenReady', function() {
    window.initializeGolden();
});



window.initializeGolden = function() {
    let numbersInLock = document.querySelector(".numbers-in-lock");
    let isInitialized = false;
/*
    // Function to initialize the animation
    function initializeAnimation() {
        if (isInitialized) return;
        isInitialized = true;

        var density = 21,
            speed = 0.5,
            numbersInLockHeight = numbersInLock.offsetHeight,
            numbersInLockWidth = numbersInLock.offsetWidth,
            start = {
                yMin: numbersInLockHeight + 50,
                yMax: numbersInLockHeight + 50,
                xMin: [0, numbersInLockWidth / 2 - 50, numbersInLockWidth - 100],
                xMax: [100, numbersInLockWidth / 2 + 50, numbersInLockWidth],
                scaleMin: 0.1,
                scaleMax: 0.25,
                opacityMin: 0.2,
                opacityMax: 0.4
            },
            mid = {
                yMin: numbersInLockHeight * 0.3,
                yMax: numbersInLockHeight * 0.5,
                xMin: [0, numbersInLockWidth / 2 - 150, numbersInLockWidth - 300],
                xMax: [300, numbersInLockWidth / 2 + 150, numbersInLockWidth],
                scaleMin: 0.2,
                scaleMax: 1,
                opacityMin: 0.4,
                opacityMax: 1
            },
            end = {
                yMin: -180,
                yMax: -180,
                xMin: [0, numbersInLockWidth / 2 - 300, numbersInLockWidth - 600],
                xMax: [600, numbersInLockWidth / 2 + 300, numbersInLockWidth],
                scaleMin: 0.1,
                scaleMax: 1,
                opacityMin: 0.2,
                opacityMax: 0.7
            },
            colors = ['#ff0000'];

        function range(map, prop) {
            var min = map[prop + "Min"],
                max = map[prop + "Max"];
            if (Array.isArray(min)) {
                var index = Math.floor(Math.random() * min.length);
                return min[index] + (max[index] - min[index]) * Math.random();
            }
            return min + (max - min) * Math.random();
        }

        function spawn(particle) {
            var wholeDuration = (10 / speed) * (0.7 + Math.random() * 0.4),
                delay = wholeDuration * Math.random(),
                partialDuration = (wholeDuration + 1) * (0.3 + Math.random() * 0.4);

            gsap.set(particle, {
                y: range(start, "y"),
                x: range(start, "x"),
                scale: range(start, "scale"),
                opacity: range(start, "opacity"),
                visibility: "hidden",
                color: colors[Math.floor(Math.random() * colors.length)]
            });

            gsap.to(particle, {
                y: range(end, "y"),
                duration: wholeDuration,
                delay: delay,
                ease: "none"
            });
            gsap.to(particle, {
                x: range(mid, "x"),
                duration: partialDuration,
                delay: delay,
                ease: "power1.out"
            });
            gsap.to(particle, {
                x: range(end, "x"),
                duration: wholeDuration - partialDuration,
                delay: partialDuration + delay,
                ease: "power1.in"
            });

            partialDuration = wholeDuration * (0.5 + Math.random() * 0.3);
            gsap.to(particle, {
                scale: range(mid, "scale"),
                autoAlpha: range(mid, "opacity"),
                duration: partialDuration,
                delay: delay,
                ease: "none"
            });
            gsap.to(particle, {
                scale: range(end, "scale"),
                autoAlpha: range(end, "opacity"),
                duration: wholeDuration - partialDuration,
                delay: partialDuration + delay,
                ease: "none",
                onComplete: spawn,
                onCompleteParams: [particle]
            });
        }

        for (var i = 0; i < density; i++) {
            var particle = document.createElement("div");
            particle.id = "particle" + i;
            particle.classList.add("particle");
            particle.textContent = Math.round(Math.random() * 9);
            numbersInLock.appendChild(particle);
            spawn(particle);
        }
    }

    // Function to check the visibility of the element
    function checkVisibility() {
        if (numbersInLock.offsetParent !== null) {
            if (numbersInLock.offsetHeight > 0 || numbersInLock.offsetWidth > 0) {
                initializeAnimation();
            }
        }
    }

    // Check visibility on page load
    checkVisibility();

    // Add click event listener to .golden-room-door-lock
    document.querySelector(".golden-room-door-lock").addEventListener('click', function() {
        // Add a small delay to let the element become visible
        setTimeout(checkVisibility, 50);
        numbersInLock.style.zIndex = '1';
    }); */


    let scene, camera, renderer, room, controls, composer, outlinePass;
    let raycaster = new THREE.Raycaster();
    let mouse = new THREE.Vector2();
    let selectedObject = null;
    let clickStartObject = null;
    let isRendering = true;
    let ratClickCount = 0;

    const Doors = ["Door_low"];

    const elements = {
        goldenRoomMain: document.getElementById('golden-room-3d'),
        goldenRoomDoor: document.getElementById('golden-room-door'),
        goldenRoomRats: document.querySelector('.golden-room-door-rats'),
        goldenRoomLock: document.getElementById('golden-room-door-lock'),
        LockInLockOverlay: document.getElementById('LockInLockOverlay'),
        goldenRoom3D: document.getElementById('golden-room-3d')
    };

    const arrowButtons = {
        toGoldenRoomMain: null,
        toGoldenRoomDoor: null,
        toGoldenRoomDoorR: null,
    };

    const sounds = {
        doorSound: new Audio('https://nohome.cloud/wp-content/themes/blankslate/files/golden-room/door.wav'),
        ratSound: new Audio('https://nohome.cloud/wp-content/themes/blankslate/files/golden-room/rat.wav'),
        doorLockSound: new Audio('https://nohome.cloud/wp-content/themes/blankslate/files/golden-room/lock.wav')
    };

    // Убедимся, что звуки загружены перед воспроизведением
    function playSound(sound) {
        if (sound && typeof sound.play === 'function') {
            // Сбрасываем звук перед воспроизведением для возможности повторного проигрывания
            sound.pause();
            sound.currentTime = 0;
            
            // Играем звук
            sound.play().catch(error => {
                console.error('Failed to play sound:', error);
            });
        }
    }

    let isAnimating = false;

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function init() {
        scene = new THREE.Scene();
        camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.set(0.84, 0.13, -0.83);
        camera.lookAt(new THREE.Vector3(-0.7, -0.11, 0.7));
    renderer = new THREE.WebGLRenderer({ 
        antialias: true,
        alpha: true  // Включаем поддержку прозрачности
    });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setClearColor(0x000000, 0); // Устанавливаем прозрачный фон
    renderer.physicallyCorrectLights = true;
    renderer.outputEncoding = THREE.sRGBEncoding;

        const dracoLoader = new DRACOLoader();
        dracoLoader.setDecoderPath('https://unpkg.com/three@0.166.0/examples/jsm/libs/draco/gltf/');
        dracoLoader.setDecoderConfig({ type: 'js' });

        const glbUrl = document.getElementById('golden-room-3d').getAttribute('data-glb-url');
        const loader = new GLTFLoader();
        loader.setDRACOLoader(dracoLoader);

        let lastLoggedPercentage = 0;
        const totalSizeInMB = 5.39;
        const hiUpdate = document.getElementById('hi-update');
        const loadUpdate = document.getElementById('loadUpdate');
        const originalText = hiUpdate.textContent;

        loader.load(glbUrl, function(gltf) {
            room = gltf.scene;
            room.scale.set(1, 1, 1);
            room.position.set(0, -1.5, 0);
            scene.add(room);
            document.getElementById('golden-room-3d').appendChild(renderer.domElement);
            document.getElementById('loadingScreen').style.display = 'none';

            hiUpdate.textContent = originalText;
            hiUpdate.classList.remove('horse-indicator-text-active');
            loadUpdate.textContent = '100%';
        },
        function(xhr) {
            const loadedMB = (xhr.loaded / 1024 / 1024).toFixed(2);
            const percentage = Math.floor((loadedMB / totalSizeInMB) * 100);

            // Плавное обновление процентов с анимацией
            requestAnimationFrame(() => {
                const currentPercentage = parseInt(loadUpdate.textContent);
                const animatePercentage = (start, end, duration) => {
                    let startTimestamp = null;
                    const step = (timestamp) => {
                        if (!startTimestamp) startTimestamp = timestamp;
                        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                        const currentValue = Math.floor(progress * (end - start) + start);
                        loadUpdate.textContent = `${currentValue}%`;
                        
                        if (progress < 1) {
                            window.requestAnimationFrame(step);
                        }
                    };
                    window.requestAnimationFrame(step);
                };

                if (percentage > currentPercentage) {
                    hiUpdate.textContent = `Preparing the room for you. Loading...`;
                    hiUpdate.classList.add('horse-indicator-text-active');
                    animatePercentage(currentPercentage, percentage, 500);
                }
            });
        },
        function(error) {
            console.error('An error happened', error);
        });

        controls = new OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.dampingFactor = 0.25;
        controls.enablePan = false;
        controls.minDistance = 0.1;
        controls.maxDistance = 6;
        controls.maxPolarAngle = Math.PI;

        composer = new EffectComposer(renderer);
        composer.setSize(window.innerWidth, window.innerHeight);

        const renderPass = new RenderPass(scene, camera);
        composer.addPass(renderPass);

        outlinePass = new OutlinePass(new THREE.Vector2(window.innerWidth, window.innerHeight), scene, camera);
        outlinePass.edgeStrength = 9;
        outlinePass.edgeGlow = 0;
        outlinePass.edgeThickness = 5;
        outlinePass.pulsePeriod = 1;
        composer.addPass(outlinePass);

        const gammaCorrectionPass = new ShaderPass(GammaCorrectionShader);
        composer.addPass(gammaCorrectionPass);

        window.addEventListener('resize', onWindowResize, false);
        renderer.domElement.addEventListener('mousemove', onMouseMoveDebounced, false);
        renderer.domElement.addEventListener('mousedown', onMouseDown, false);
        renderer.domElement.addEventListener('mouseup', onMouseUp, false);
    }

function findRelatedObjects(object) {
  if (Doors.includes(object.name) || Rats.includes(object.name)) {
    return [object];
  } else {
    for (let lockGroup of Locks) {
      if (lockGroup.includes(object.name)) {
        return room.children.filter(child => lockGroup.includes(child.name));
      }
    }
  }
  return [];
}


function findRelatedObjects(object) {
  if (Doors.includes(object.name)) {
    return [object];
  }
  return [];
}

const onMouseMoveDebounced = debounce((event) => {
    event.preventDefault();
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
    raycaster.setFromCamera(mouse, camera);

    if (room) {
        const intersects = raycaster.intersectObjects(room.children, true);
        if (intersects.length > 0) {
            const firstIntersected = intersects[0].object;
            if (selectedObject !== firstIntersected) {
                selectedObject = firstIntersected;
                outlinePass.selectedObjects = findRelatedObjects(firstIntersected);
            }
        } else {
            clearSelection();
        }
    }
}, 50);

function clearSelection() {
    selectedObject = null;
    outlinePass.selectedObjects = [];
}

function onMouseDown(event) {
    event.preventDefault();
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
    raycaster.setFromCamera(mouse, camera);

    if (room) {
        const intersects = raycaster.intersectObjects(room.children, true);
        if (intersects.length > 0) {
            clickStartObject = intersects[0].object;
        }
    }
}

function onMouseUp(event) {
    event.preventDefault();
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
    raycaster.setFromCamera(mouse, camera);

    if (room) {
        const intersects = raycaster.intersectObjects(room.children, true);
        if (intersects.length > 0) {
            const clickEndObject = intersects[0].object;
            if (clickStartObject === clickEndObject) {
                handleClick(clickEndObject);
            }
        }
    }

    clickStartObject = null;
}

function handleClick(object) {
    if (Doors.includes(object.name)) {
        console.log('Door clicked');
        playSound(sounds.doorSound);
        setTimeout(() => {
            toggleVisibility(elements.goldenRoomMain, elements.goldenRoomDoor);
            pauseRendering();
        }, 750);
    }
}

function toggleVisibility(hide, show) {
    if (isAnimating) return;
    isAnimating = true;
    
    // Устанавливаем анимации
    hide.style.animationName = 'fadeOut';
    show.style.animationName = 'fadeIn';
    
    // Показываем элемент перед анимацией
    show.style.display = 'block';
    
    let hideAnimationEnded = false;
    let showAnimationEnded = false;

    // Обработчик для завершения анимации скрытия
    function hideElement() {
        hide.style.display = 'none';
        hide.style.animationName = '';
        hide.removeEventListener('animationend', hideElement);
        hideAnimationEnded = true;
        checkIfAnimationComplete();
    }

    // Обработчик для завершения анимации появления
    function showElement() {
        show.style.display = 'block';
        show.style.animationName = '';
        show.removeEventListener('animationend', showElement);
        showAnimationEnded = true;
        checkIfAnimationComplete();
    }

    // Проверка завершения обеих анимаций
    function checkIfAnimationComplete() {
        if (hideAnimationEnded && showAnimationEnded) {
            isAnimating = false;
        }
    }

    hide.addEventListener('animationend', hideElement);
    show.addEventListener('animationend', showElement);
}


    function onWindowResize() {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
        composer.setSize(window.innerWidth, window.innerHeight);
    }

    function pauseRendering() {
        isRendering = false;
        renderer.domElement.style.display = 'none';
        renderer.domElement.removeEventListener('mousemove', onMouseMoveDebounced);
        renderer.domElement.removeEventListener('mousedown', onMouseDown);
        renderer.domElement.removeEventListener('mouseup', onMouseUp);
    }

    function resumeRendering() {
        isRendering = true;
        renderer.domElement.style.display = 'block';
        renderer.domElement.addEventListener('mousemove', onMouseMoveDebounced, false);
        renderer.domElement.addEventListener('mousedown', onMouseDown, false);
        renderer.domElement.addEventListener('mouseup', onMouseUp, false);
        requestAnimationFrame(animate);
    }

    let lastTime = 0;
    const fps = 60;
    const interval = 1000 / fps;

    function animate(currentTime) {
      if (isRendering) {
        requestAnimationFrame(animate);
        if (currentTime - lastTime < interval) return;
        lastTime = currentTime;
        controls.update();
        composer.render();
      }
    }

    function initializeRoomTransfers() {
        elements.goldenRoomDoorLock = document.getElementById('golden-room-door-lock');

        arrowButtons.toGoldenRoomMain = document.getElementById('to-golden-room-main');
        arrowButtons.toGoldenRoomDoor = document.getElementById('to-golden-room-door');
        arrowButtons.toGoldenRoomDoorR = document.getElementById('to-golden-room-door-r');

        document.querySelectorAll('.overlay-svg').forEach(overlay => {
            overlay.addEventListener('click', function() {
                const targetId = overlay.classList[1];
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    const currentElement = document.querySelector('.room-wrapper:not([style*="display: none"])');
                    toggleVisibility(currentElement, targetElement);
                }
            });
        });

        document.querySelectorAll('.golden-room-door-rats').forEach(element => {
            element.addEventListener('click', () => {
                playSound(sounds.ratSound);
                showNextRatImage();
            });
        });

        document.querySelectorAll('.golden-room-door-lock').forEach(element => {
            element.addEventListener('click', () => {
                playSound(sounds.doorLockSound);
            });
        });

        arrowButtons.toGoldenRoomMain.addEventListener('click', () => {
            const currentElement = document.querySelector('.room-wrapper:not([style*="display: none"])');
            toggleVisibility(currentElement, elements.goldenRoomMain);
        });

        arrowButtons.toGoldenRoomDoor.addEventListener('click', () => {
            const currentElement = document.querySelector('.room-wrapper:not([style*="display: none"])');
            toggleVisibility(currentElement, elements.goldenRoomDoor);
        });

        arrowButtons.toGoldenRoomDoorR.addEventListener('click', () => {
            const currentElement = document.querySelector('.room-wrapper:not([style*="display: none"])');
            toggleVisibility(currentElement, elements.goldenRoomDoor);
        });

        const newCameraPosition = new THREE.Vector3(-4.24, 0.03, -4.24);
        const newCameraLookAt = new THREE.Vector3(0.7, -0.006, 0.7);

        function animateCameraTransition(startPosition, startLookAt, endPosition, endLookAt, duration) {
            const startTime = performance.now();

            function update() {
                const elapsedTime = performance.now() - startTime;
                const progress = Math.min(elapsedTime / duration, 1);

                camera.position.lerpVectors(startPosition, endPosition, progress);

const currentLookAt = new THREE.Vector3();
                currentLookAt.lerpVectors(startLookAt, endLookAt, progress);
                camera.lookAt(currentLookAt);

                if (progress < 1) {
                    requestAnimationFrame(update);
                }
            }

            update();
        }

elements.goldenRoomLock.addEventListener('click', () => {
        playSound(sounds.doorLockSound);
    });

        elements.LockInLockOverlay.addEventListener('click', () => {
            console.log('Click on LockInLockOverlay');
            playSound(sounds.doorLockSound);

            try {
                if (elements.goldenRoomDoorLock) {
                    elements.goldenRoomDoorLock.style.display = 'none';
                } else {
                    console.warn('goldenRoomDoorLock element not found');
                }

                if (elements.goldenRoom3D) {
                    elements.goldenRoom3D.style.display = 'block';
                    resumeRendering();

                    const currentPosition = camera.position.clone();
                    const currentLookAt = camera.getWorldDirection(new THREE.Vector3()).add(camera.position);
                    
                    animateCameraTransition(currentPosition, currentLookAt, newCameraPosition, newCameraLookAt, 4500);
                    
                    if (typeof window.updateHorseText === 'function') {
                      window.updateHorseText("pixels are in a preparation process. wait for please. I am sorry if you encounter any bugs.");
                    } else {
                      const hiUpdate = document.getElementById('hi-update');
                      if (hiUpdate) {
                        hiUpdate.textContent = "pixels are in a preparation process. wait for please. I am sorry if you encounter any bugs.";
                        hiUpdate.classList.add('horse-indicator-text-active');
                      }
                    }
                } else {
                    console.warn('goldenRoom3D element not found');
                }
            } catch (error) {
                console.error('Error in LockInLockOverlay click handler:', error);
            }
        });
    }

    function showNextRatImage() {
        const images = document.querySelectorAll('#golden-room-door-rats .nextrats');
        images.forEach(img => img.style.visibility = 'hidden');

        const indexToShow = ratClickCount % images.length;
        images[indexToShow].style.visibility = 'visible';

        ratClickCount++;
    }

    const asciiArts = [
        document.getElementById("ascii-art"),
        document.getElementById("ascii-art-1"),
        document.getElementById("ascii-art-2")
    ];
    let currentAsciiArtIndex = 0;
    let isHovering = false;
    let animationInterval;
    const originalHTMLs = asciiArts.map(art => art.innerHTML);
    const goldenRoomRatsElements = document.querySelectorAll(".golden-room-door-rats");

    goldenRoomRatsElements.forEach(element => {
        element.addEventListener("mouseenter", function(event) {
            isHovering = true;
            showAsciiArt(event);
        });
        element.addEventListener("mouseleave", function() {
            isHovering = false;
            hideAsciiArt();
        });
        element.addEventListener("mousemove", function(event) {
            if (isHovering) {
                updateAsciiArtPosition(event);
            }
        });
    });

    function showAsciiArt(event) {
        const currentAsciiArt = asciiArts[currentAsciiArtIndex];
        const originalHTML = originalHTMLs[currentAsciiArtIndex];
        const duration = 5000;
        const speed = duration / originalHTML.length;
        
        asciiArts.forEach(art => art.style.display = "none");
        currentAsciiArt.style.display = "block";
        updateAsciiArtPosition(event);
        currentAsciiArt.innerHTML = '';
        let index = 0;
        clearInterval(animationInterval);
        animationInterval = setInterval(() => {
            if (index < originalHTML.length) {
                const currentContent = originalHTML.slice(0, index + 1);
                currentAsciiArt.innerHTML = currentContent;
                updateAsciiArtPosition(event);
                index++;
            } else {
                clearInterval(animationInterval);
            }
        }, speed);

        currentAsciiArtIndex = (currentAsciiArtIndex + 1) % asciiArts.length;
    }

    function updateAsciiArtPosition(event) {
        const currentAsciiArt = asciiArts[currentAsciiArtIndex];
        currentAsciiArt.style.left = `${event.clientX + 20}px`;
        currentAsciiArt.style.bottom = `${window.innerHeight - event.clientY + 20}px`;
        currentAsciiArt.style.top = 'auto';
    }

    function hideAsciiArt() {
        asciiArts.forEach(art => art.style.display = "none");
        clearInterval(animationInterval);
    }

    asciiArts.forEach(art => {
        art.style.whiteSpace = "pre";
        art.style.textAlign = "center";
        art.style.position = "fixed";
        art.style.transformOrigin = "bottom left";
    });

    function onMouseMove3D(event) {
        event.preventDefault();
        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
        raycaster.setFromCamera(mouse, camera);

        if (room) {
            const intersects = raycaster.intersectObjects(room.children, true);
            if (intersects.length > 0) {
                const firstIntersected = intersects[0].object;
                if (Rats.includes(firstIntersected.name)) {
                    isHovering = true;
                    showAsciiArt(event);
                } else {
                    isHovering = false;
                    hideAsciiArt();
                }
            } else {
                isHovering = false;
                hideAsciiArt();
            }
        }
    }

    init();
    animate();
    initializeRoomTransfers();
    showNextRatImage();

    renderer.domElement.addEventListener('mousemove', onMouseMoveDebounced, false);


}

document.dispatchEvent(new Event('initializeGoldenReady'));

// Загрузка скрипта после загрузки DOM
document.addEventListener('DOMContentLoaded', () => {
  if (typeof initializeGolden === 'function') {
    initializeGolden();
  } else {
    console.error('initializeGolden is not a function');
  }
});

// Новая функция для инициализации взаимодействий
function initializeInteractions() {
  // Добавляем обработчики для элементов сцены
  const interactiveElements = [
    { selector: '.overlay-svg[class*="door"]', hoverText: "what do you prefer - closed/open doors or closed/open locks?" },
    { selector: '.golden-room-door-rats', hoverText: "oh no, i am sorry, the mice have escaped the lab!" },
    { selector: '.overlay-svg[class*=\"lock\"]', clickText: "do you know how to cipher?" },
    { selector: '.overlay-svg[class*=\"outside\"]', clickText: "welcome to complete isolation" }
  ];

  interactiveElements.forEach(({ selector, hoverText, clickText }) => {
    const elements = document.querySelectorAll(selector);
    elements.forEach(element => {
      if (hoverText) {
        element.addEventListener('mouseenter', () => {
          if (typeof window.updateHorseText === 'function') {
            window.updateHorseText(hoverText);
          } else {
            const hiUpdate = document.getElementById('hi-update');
            if (hiUpdate) {
              hiUpdate.textContent = hoverText;
              hiUpdate.classList.add('horse-indicator-text-active');
            }
          }
        });
      }
      
      if (clickText) {
        element.addEventListener('click', () => {
          if (typeof window.updateHorseText === 'function') {
            window.updateHorseText(clickText);
          } else {
            const hiUpdate = document.getElementById('hi-update');
            if (hiUpdate) {
              hiUpdate.textContent = clickText;
              hiUpdate.classList.add('horse-indicator-text-active');
            }
          }
        });
      }
    });
  });
}
</script>
<!--script src="https://nohome.cloud/wp-content/themes/blankslate/files/test/fluid.js"></script--> 

<!-- /wp:html -->