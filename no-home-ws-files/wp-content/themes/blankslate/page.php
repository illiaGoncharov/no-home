<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="entry-content" itemprop="mainContentOfPage">
	
<canvas class="fluid"></canvas>
	
<div class="captcha" id="captcha" style="display: none;">
  <div class="captcha-wrapper">
    <div class="captcha-header">
      <div class="captcha-choose"><span class="captcha-text">Choose all squares with </span> <span class="captcha-red">screen</span>  
      </div>
      <div class="captcha-description">If there are none, click "skip"</div>
    </div> <!-- этот тег был незакрыт -->
    <div class="captcha-pics">
      <div class="captcha-pic">
        <div class="shadow-overlay"></div>
        <img id="capt1" src=" ">
      </div>
      <div class="captcha-pic">
        <div class="shadow-overlay"></div>
        <img id="capt2" src=" ">
      </div>
      <div class="captcha-pic">
        <div class="shadow-overlay"></div>
        <img id="capt3" src=" ">
      </div>
      <div class="captcha-pic">
        <div class="shadow-overlay"></div>
        <img id="capt4" src=" ">
      </div>
    </div>
    <div class="captcha-footer">
      <div class="captcha-footer-text">I hope you choose<br>the right one</div>
      <button id="skip-captcha">SKIP</button>
    </div>
  </div>
</div>
	
<div class="items-wrapper">
    <div class="items-background">
        <img class="noise-blik" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/blik.png">
        <img class="noise-blik" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/noise.png">
    </div>

    <ul class="nav-items">
	    <li class="nav-item"><a class="nav-items-link" id="mp3-content" href="#">mp3</a></li>
	    <li class="nav-item"><a class="nav-items-link" id="documents-content" href="#">diary</a></li>
        <li class="nav-item"><a class="nav-items-link" id="luggage-content" href="#">luggage</a></li>
        <li class="nav-item"><a class="nav-items-link" id="backpack-content" href="#">backpack</a></li>
        <li class="nav-item"><a class="nav-items-link" id="iphone-content" href="#">iphone</a></li>
        <li class="nav-item"><a class="nav-items-link" id="camera-content" href="#">camera</a></li>
    </ul>
	
	<a id="exit" href="#">-exit-</a>

    <div class="items-hi">
        <img src="https://nohome.cloud/wp-content/themes/blankslate/files/items/items-hi.png" alt="Horse Indicator">
        <div class="items-hi-wrapper">
            <div class="items-hi-text">My dirty stuff</div>
        </div>
    </div>
		
	<div id="items-content"></div>
	<div class="mp3">
		
	<style>
		.mp3{
			position: absolute;
    top: 0;
    z-index: -1;
		}
.mp3-background-wrapper {
    position: absolute;
    top: 0;
    width: 100vw;
    height: 100vh;
    overflow: hidden;
}
.mp3-background-img {
    position: relative;
    width: 100%;
    height: 100%;
    object-fit: cover;
    pointer-events: none;
    transition: opacity 750ms ease-in-out;
}
.mp3-vhs-wrapper {
    position: absolute;
    top: 0;
    width: 100vw;
    height: 100vh;
    overflow: hidden;
    background-color: #000;
    display: flex;
    flex-wrap: nowrap;
    background-image: url('https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/tileable_pattern.jpg'); /* Add the path to your pattern */
    background-repeat: repeat;
    background-size: auto;
    animation: shake 0.01s ease-in-out infinite;
    opacity: 0.7;
}
@keyframes shake {
    0% { transform: translate(3px, 3px) scale(1.2); }
    50% { transform: translate(63px, -33px) scale(1.2); }
    100% { transform: translate(3px, 3px) scale(1.2); }
}

.mp3-vhs-background-img {
    position: relative;
    width: 100%;
    height: 100%;
    object-fit: cover;
    pointer-events: none;
    animation: shake 0.5s linear infinite;
}

@keyframes scrollBackground {
    0% {
        transform: translateX(0);
    }
    50% {
        transform: translateX(-90%);
    }
    100% {
        transform: translateX(0);
    }
}

        .mp3-wrapper {
    display: flex;
    position: absolute;
    width: 100vw;
    height: 100vh;
    perspective: 3333px;
    top: 0;
        }

        .spinning-sides-wrapper {
            width: calc(100% - 60px);
            height: 100%;
            position: absolute;
            transform-style: preserve-3d;
            animation: rotateTillPlay 10s linear infinite;
            margin: 0 30px;
        }

        .disk-wrapper {
            position: absolute;
            left: calc(50% - 21vw); /* Отнимаем половину ширины элемента */
            top: calc(50% - 21vw); /* Отнимаем половину высоты элемента */
            width: 42vw;
            height: 42vw;
            animation: counter-rotateTillPlay 10s linear infinite;
            z-index: 10;
            filter: drop-shadow(0 0 10px black);
        }
.time-changer {
    position: absolute;
    left: calc(50% - 21.3vw);
    top: calc(50% - 21.3vw);
    width: 42.6vw;
    height: 42.6vw;
    border-radius: 50%;
    opacity: 0.6;
    mask: radial-gradient(circle, transparent 70%, black 30%);
    -webkit-mask: radial-gradient(circle, transparent 70%, black 30%);
    transition: all 0.5s ease;
    z-index: 11;
}

.time-changer:hover {
    left: calc(50% - 22.05vw);
    top: calc(50% - 22.05vw);
    width: 44.1vw;
    height: 44.1vw;
    opacity: 1;
    mask: radial-gradient(circle, transparent 69.3%, black 30.7%);
    -webkit-mask: radial-gradient(circle, transparent 69.3%, black 30.7%);
}

.progress-circle {
    position: absolute;
    width: 12px;
    height: 12px;
    background-color: rgb(212, 35, 24);
    border-radius: 50%;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
    transition: opacity 0.5s ease;
    z-index: 12;
}
        .pc-wrapper {
            position: absolute;
            left: calc(50% - 21vw); /* Отнимаем половину ширины элемента */
            top: calc(50% - 21vw); /* Отнимаем половину высоты элемента */
            width: 42vw;
            height: 42vw;
            /*animation: counter-rotate 10s linear infinite;*/
            z-index: 12;
            pointer-events: none;
            filter: drop-shadow(0 0 10px black);
        }

.time-changer:hover .progress-circle {
    opacity: 1;
}
        .disk-wrapper img {
            position: absolute;
            width: 100%;
            backdrop-filter: blur(5px);
            border-radius: 50%;
        }
        .cd {
        -webkit-backdrop-filter: blur(5px);
        }
        .block-side-1,
        .block-side-2 {
            position: absolute;
            width: 22.5%;
            height: 100%;
            color: #b0b0b0;
            backface-visibility: visible;
            top: 50%;

        }
        .block-side-1 {
            left: 0;
            transform: translateY(-25%);
            z-index: 3;
        }
        .block-side-2 {
            right: 0;
            transform: translateY(-25%) rotateY(180deg);
            z-index: 1;
        }
        @keyframes rotateTillPlay {
            0% {
                transform: rotateY(0deg);
            }
            100% {
                transform: rotateY(360deg);
            }
        }
        @keyframes rotateTillPlay {
            0% {
                transform: rotateY(0deg);
            }
            100% {
                transform: rotateY(360deg);
            }
        }
        @keyframes counter-rotateTillPlay {
            0% {
                transform: rotateY(0deg);
            }
            100% {
                transform: rotateY(-360deg);
            }
        }
        @keyframes counter-rotate {
            0% {
                transform: rotateY(0deg);
            }
            100% {
                transform: rotateY(-360deg);
            }
        }
.upper {
display: flex;
    justify-content: space-between;
    font-family: 'Hershey';
    padding-bottom: 0.3vh;
    border-bottom: 2px dashed rgba(255, 255, 255, 0.2);
    margin-bottom: 3.9vh;
}
.upper span {
text-stroke:  1px #B0B0B0;
-webkit-text-stroke: 1px #B0B0B0;
}
.now-playing-wrapper {
    display: flex;
    font-family: 'Avara';
    align-items: end;
    justify-content: space-between;
}
.now-playing-title {
display: inline-block;
font-size: 1.95em;
text-wrap: nowrap;
line-height: normal;
}
.now-playing-time {
display: inline-block;
font-size: 1.5em;
text-align: end;
line-height: normal;
}
.now-playing-hashtag {
    font-family: 'Hershey';
    font-size: 1.2em;
    padding-top: 5px;
    opacity: 60%;
}
.now-playing {
margin-bottom: 3.9vh;
}
.upper-next {
    font-family: 'Hershey';
    padding-bottom: 0.3vh;
    border-bottom: 2px dashed rgba(255, 255, 255, 0.2);
    text-stroke: 1px #B0B0B0;
    -webkit-text-stroke: 1px #B0B0B0;
    margin-bottom: 3.9vh;
}
.song-next {
display: flex;
justify-content: space-between;
font-family: 'Avara';
font-size: 1.2em;
padding-bottom: 1.8vh;
}
.song-playing-blured {
filter: blur(1px);
opacity: 50%;
}
.next {
    padding-bottom: 0.3vh;
    border-bottom: 2px dashed rgba(255, 255, 255, 0.2);
}
.mp3-controls {
position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translate(-50%);
    font-family: 'Avara-Bold';
    font-size: 1.8em;
    z-index: +1;
}
.mp3-controls button { 
background-color: transparent;
color: #b0b0b0;
text-stroke: 1.5px #b0b0b0;
-webkit-text-stroke: 1.5px #b0b0b0;
border: none;
}
.mp3-controls button:hover { 
opacity: 100%;
}
.mp3-controls span { 
color: #b0b0b0;
opacity: 30%;
}
.previous-song,
.next-song {
opacity: 60%;
}
.random {
opacity: 30%;
}
.repeat-song {
opacity: 30%;
transform: rotate(90deg) translate(-3px, 5px)
}
.play-stop {
text-shadow: 0 0 9px #b0b0b0;
}
       .marquee-container {
            overflow: hidden;
        }
       .marquee-content {
            display: inline-block;
            text-wrap: nowrap;
        }

        .marquee-animate {
            animation: marquee 12s linear infinite alternate;
        }

        @keyframes marquee {
            0%, 5% {
                transform: translateX(0%);
            }
            45%, 55% {
                transform: translateX(calc(-100% + 200px));
            }
            95%, 100% {
                transform: translateX(0%);
            }
        }
.now-playing-time,
.song-1-next-time,
.song-2-next-time,
.song-3-next-time,
.song-4-next-time,
.song-playing-time {
margin-left: 10px;
}
.song-next.side-2,
.now-playing-wrapper.side-2,
.now-playing-hashtag.side-2 {
filter: blur(3px);
}
.cd, .ice {
animation:none;
}
@keyframes rotateCD {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(45deg); }
}

@keyframes rotateIce {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
.transition-blur {
  transition: filter 0.5s ease, opacity 0.5s ease;
}

.blurred {
  filter: blur(3px);
  opacity: 0.3;
}
.repeat-song::before {
content: "Repeat";
    position: absolute;
    left: -190%;
    transform: rotate(-90deg) translateX(5px);
    visibility: hidden;
    opacity: 0;
    color: #b0b0b0;
    padding: 5px;
    z-index: 100;
    white-space: nowrap;
    transition: opacity 0.5s ease-in-out;
    font-size: 15px !important;
	text-stroke: 0;
    -webkit-text-stroke: 0;
    background-color: rgba(0, 0, 0, 0.3);
    padding: 10px 9px 6px 9px;
    border-radius: 5px;
}
.random::before {
content: "Randomize";
    position: absolute;
    bottom: 125%;
    transform: translateX(-37%);
    visibility: hidden;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
    font-size: 15px !important;
    text-stroke: 0;
    -webkit-text-stroke: 0;
    background-color: rgba(0, 0, 0, 0.3);
    padding: 10px 9px 6px 9px;
    border-radius: 5px;
		}
.random:hover::before,
.repeat-song:hover::before {
  visibility: visible;  /* Показываем подсказку при наведении */
  opacity: 1;  /* Делаем подсказку видимой */
}
</style>


<!----------------------- SONGS SIDE 1 ---------------------------->

    <audio
preload="metadata"
id="floating-into-the-night"
data-song-name="floating into the night"
data-side="1"
data-order="1"
data-song-hashtag="#web_surfing"
data-mp3-background-img="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/backgrounds/into%20the%20night.jpg"
src="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/side%201/floating-into-the-night.ogg"></audio>

    <audio
preload="metadata"
id="youareyes"
data-song-name="youareyes"
data-side="1"
data-order="2"
data-song-hashtag="#doorbell_invasion"
data-mp3-background-img="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/backgrounds/youareyes.jpg"
src="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/side%201/youareyes.ogg"></audio>

    <audio
preload="metadata"
id="yourerror"
data-song-name="yourerror"
data-side="1"
data-order="3"
data-song-hashtag="#12345678_omg"
data-mp3-background-img="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/backgrounds/yourerror.jpg"
src="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/side%201/yourerror.ogg"></audio>

    <audio
preload="metadata"
id="a-creepy-storm"
data-song-name="a creepy storm"
data-side="1"
data-order="4"
data-song-hashtag="#without_mouth"
data-mp3-background-img="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/backgrounds/a%20creepy%20storm.jpg"
src="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/side%201/a-creepy-storm.ogg"></audio>

    <audio
preload="metadata"
id="cross-talk-with-notmytrauma"
data-song-name="cross talk with notmytrauma"
data-side="1"
data-order="5"
data-song-hashtag="#trauma_zone"
data-mp3-background-img="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/backgrounds/%20cross%20talk%20with%20notmytrauma.jpg"
src="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/side%201/cross-talk-with-notmytrauma.ogg"></audio>

<!----------------------- SONGS SIDE 2 ---------------------------->

    <audio
preload="metadata"
id="lullaby"
data-song-name="lullaby"
data-side="2"
data-order="1"
data-song-hashtag="#am_i_asleep"
data-mp3-background-img="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/backgrounds/lullaby.jpg"
src="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/side%202/lullaby.ogg"></audio>

    <audio
preload="metadata"
id="i-looked-up"
data-song-name="i looked up"
data-side="2"
data-order="2"
data-song-hashtag="#hold_ to_record"
data-mp3-background-img="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/backgrounds/i%20looked%20up.jpg"
src="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/side%202/i-looked-up.ogg"></audio>

    <audio
preload="metadata"
id="its-a-fine-day"
data-song-name="it's a fine day"
data-side="2"
data-order="3"
data-song-hashtag="#scrrrrr***olllll"
data-mp3-background-img="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/backgrounds/it_s%20a%20fine%20day.jpg"
src="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/side%202/it_s-a-fine-day.ogg"></audio>

    <audio
preload="metadata"
id="thirst-for-clean-water"
data-song-name="thirst for clean water"
data-side="2"
data-order="4"
data-song-hashtag="#and_and_and"
data-mp3-background-img="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/backgrounds/thirst%20for%20clean%20water.jpg"
src="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/side%202/thirst-for-clean-water-.ogg"></audio>

    <audio
preload="metadata"
id="i-try-to-hear-an-explosion-both-here-and-there"
data-song-name="i try to hear an explosion both here and there"
data-side="2"
data-order="5"
data-song-hashtag="#your_grid"
data-mp3-background-img="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/backgrounds/-.jpg"
src="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/side%202/i-try-to-hear-an-explosion-both-here-and-there-.ogg"></audio>

<div class="mp3-wrapper">
<div class="mp3-vhs-wrapper">
</div>

<div class="mp3-background-wrapper">
    <img class="mp3-background-img" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/empty.png" alt="MP3 Background">
</div>

  <div class="mp3-controls">
     <span>|</span>
     <button class="random">≈</button>
     <span>|</span>
     <button class="previous-song"><</button>
     <span>|</span>
     <button class="play-stop">play</button>
     <span>|</span>
     <button class="next-song">></button>
     <span>|</span>
     <button class="repeat-song">8</button>
     <span>|</span>
  </div>
  <div class="spinning-sides-wrapper">
    <div class="time-changer">
    </div>
    <div class="pc-wrapper"><div class="progress-circle"></div></div>
    <div class="disk-wrapper">
       <img class="cd" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/cd.png">
       <img class="ice" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/mp3/ice.png">
    </div>
    <div class="block-side-1">
      <div class="now-playing side-1">
        <div class="upper side-1">
          <span class="upper-left side-1">PLAYING NOW</span>
          <span class="upper-right side-1">SIDE I</span>
        </div>
        <div class="mp3-dash"></div>
        <div class="now-playing-wrapper side-1">
          <div class="marquee-container">
             <span class="now-playing-title side-1 marquee-content">?????????</span>
          </div>
          <span class="now-playing-time side-1">00:00</span>
        </div>
        <div class="now-playing-hashtag side-1">#WEB_SURFING</div>
      </div>
      <div class="next side-1">
        <div class="upper-next side-1">NEXT</div>
        <div class="song-1-next side-1 song-next">
          <div class="marquee-container">
             <span class="song-1-next-title side-1 marquee-content"></span>
          </div>
          <span class="song-1-next-time side-1"></span>
        </div>
        <div class="song-2-next side-1 song-next">
          <div class="marquee-container">
             <span class="song-2-next-title side-1 marquee-content"></span>
          </div>
          <span class="song-2-next-time side-1"></span>
        </div>
        <div class="song-3-next side-1 song-next">
          <div class="marquee-container">
             <span class="song-3-next-title side-1 marquee-content">a creepy storm</span>
          </div>
          <span class="song-3-next-time side-1">00:40</span>
        </div>
        <div class="song-4-next side-1 song-next">
          <div class="marquee-container">
             <span class="song-4-next-title side-1 marquee-content">cross talk with notmytrauma</span>
          </div>
          <span class="song-4-next-time side-1">01:42</span>
        </div>
        <div class="song-playing side-1 song-next">
          <div class="marquee-container">
             <span class="song-playing-title side-1 marquee-content">floating into the night</span>
          </div>
          <span class="song-playing-time side-1">02:03</span>
        </div>
      </div>
    </div>
    <div class="block-side-2">
      <div class="now-playing side-2">
        <div class="upper side-2">
          <span class="upper-left side-2">NOW PLAYING</span>
          <span class="upper-right side-2">SIDE II</span>
        </div>
        <div class="now-playing-wrapper side-2">
          <div class="marquee-container">
             <span class="now-playing-title side-2 marquee-content">?????????</span>
          </div>
          <span class="now-playing-time side-2">00:00</span>
        </div>
        <div class="now-playing-hashtag side-2">#am_i_asleep </div>
      </div>
      <div class="next side-2">
        <div class="upper-next side-2">NEXT</div>
        <div class="song-1-next side-2 song-next">
          <div class="marquee-container">
             <span class="song-1-next-title side-2 marquee-content">i looked up</span>
          </div>
          <span class="song-1-next-time side-2">01:24</span>
        </div>
        <div class="song-2-next side-2 song-next">
          <div class="marquee-container">
             <span class="song-2-next-title side-2 marquee-content">it's a fine day</span>
          </div>
          <span class="song-2-next-time side-2">01:38</span>
        </div>
        <div class="song-3-next side-2 song-next">
          <div class="marquee-container">
             <span class="song-3-next-title side-2 marquee-content">thirst for clean water</span>
          </div>
          <span class="song-3-next-time side-2">00:40</span>
        </div>
        <div class="song-4-next side-2 song-next">
          <div class="marquee-container">
             <span class="song-4-next-title side-2 marquee-content">i try to hear an explosion both here and there</span>
          </div>
          <span class="song-4-next-time side-2">01:42</span>
        </div>
        <div class="song-playing side-2 song-next">
          <div class="marquee-container">
             <span class="song-playing-title side-2 marquee-content">lullaby</span>
          </div>
          <span class="song-playing-time side-2">02:03</span>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
	
<div class="translator-wrapper">

<div class="items-background">
<img class="noise-blik" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/blik.png">
<img class="noise-blik" src="https://nohome.cloud/wp-content/themes/blankslate/files/items/noise.png">
</div>


<ul class="nav-items">
    <li class="nav-item"><a class="nav-items-link nav-items-link-now" href="#">translator</a></li>

    <li class="nav-item"><a class="nav-items-link" href="#">-exit-</a></li>
</ul>
        
<div class="items-hi">
     <img src="https://nohome.cloud/wp-content/themes/blankslate/files/items/items-hi.png" alt="Horse Indicator">
     <div class="items-hi-wrapper">
         <div class="items-hi-text">My dirty stuff</div>
     </div>
</div>

<section class="translator-container">
<div class="language-container">
<ul class="language-list">
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="en" label="english" flags="ru"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="ar" label="arabic"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="bg" label="bulgarian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="zh-CN" label="chinese (simplified)"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="zh-TW" label="chinese (traditional)"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="hr" label="croatian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="cs" label="czech"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="da" label="danish"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="nl" label="dutch"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="fi" label="finnish"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="fr" label="french"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="de" label="german"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="el" label="greek"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="hi" label="hindi"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="it" label="italian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="ja" label="japanese"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="ko" label="korean"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="no" label="norwegian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="pl" label="polish"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="pt" label="portuguese"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="ro" label="romanian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="ru" label="russian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="es" label="spanish"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="sv" label="swedish"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="ca" label="catalan"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="tl" label="filipino"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="iw" label="hebrew"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="id" label="indonesian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="lv" label="latvian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="lt" label="lithuanian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="sr" label="serbian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="sk" label="slovak"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="sl" label="slovenian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="uk" label="ukrainian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="vi" label="vietnamese"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="sq" label="albanian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="et" label="estonian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="gl" label="galician"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="hu" label="hungarian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="mt" label="maltese"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="th" label="thai"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="tr" label="turkish"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="fa" label="persian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="af" label="afrikaans"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="ms" label="malay"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="sw" label="swahili"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="ga" label="irish"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="cy" label="welsh"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="be" label="belarusian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="is" label="icelandic"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="mk" label="macedonian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="yi" label="yiddish"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="hy" label="armenian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="az" label="azerbaijani"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="eu" label="basque"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="ka" label="georgian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="ht" label="haitian creole"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="ur" label="urdu"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="bn" label="bengali"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="bs" label="bosnian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="ceb" label="cebuano"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="eo" label="esperanto"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="gu" label="gujarati"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="ha" label="hausa"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="hmn" label="hmong"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="ig" label="igbo"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="jw" label="javanese"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="kn" label="kannada"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="km" label="khmer"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="lo" label="lao"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="ml" label="malayalam"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="mr" label="marathi"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="my" label="myanmar (burmese)"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="ne" label="nepali"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="pl" label="polish"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="si" label="sinhala"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="so" label="somali"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="su" label="sundanese"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="tg" label="tajik"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="ta" label="tamil"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="te" label="telugu"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="th" label="thai"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="tl" label="tagalog"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="uk" label="ukrainian"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="xh" label="xhosa"]'); ?></li>
    <li class="language-unit"><?php echo do_shortcode('[gt-link lang="yi" label="yiddish"]'); ?></li>

</ul>
</div>
<!--div class="ip-data">
<p><span>temperature</span><span class="temperature">17</span></p> 
<p><span>location</span><span class="location">berlin</span></p>
<p><span>wind</span><span class="wind">18km/h</span></p> 
<p><span>humidity</span><span class="humidity">63%</span></p> 
</div-->
</section>
</div>
	
<div id="content-to-blur">
	
<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) ); } ?>
<?php the_content(); ?>
	
</div>
	
<div class="entry-links"><?php wp_link_pages(); ?></div>
</div>
</article>
<?php if ( comments_open() && !post_password_required() ) { comments_template( '', true ); } ?>
<?php endwhile; endif; ?>
<?php get_footer(); ?>