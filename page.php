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
	
<?php get_template_part('items/layout-content'); ?>

<div class="translator-wrapper">

  <div class="items-background">
    <img class="noise-blik" src="/wp-content/themes/blankslate/files/items/blik.png">
    <img class="noise-blik" src="/wp-content/themes/blankslate/files/items/noise.png">
  </div>


  <ul class="nav-items">
    <li class="nav-item">
      <a class="nav-items-link nav-items-link-now" href="#">translator</a>
    </li>

    <li class="nav-item"><a class="nav-items-link" href="#">-exit-</a></li>
  </ul>
          
  <div class="items-hi">
      <img src="/wp-content/themes/blankslate/files/items/items-hi.png" alt="Horse Indicator">
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