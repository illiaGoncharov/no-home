<?php
/*
Template Name: About
*/

get_header();?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="entry-content" itemprop="mainContentOfPage">
        <div class="about-page-wrapper">
            <section class="about-page-lists">
                <ul class="about-page-list list-1">
                    <li class="about-page-block-list-item" data-text="YOU CAN'T KNOW MY (?) ">YOU CAN'T KNOW MY (?) STORY. </li>
                    <li class="about-page-block-list-item" data-text="YOU CAN'T KNOW MY (?) HOME.">YOU CAN'T KNOW MY (?) HOME. </li>
                    <li class="about-page-block-list-item" data-text="YOU CAN'T KNOW MY (?) LANGUAGE.">YOU CAN'T KNOW MY (?) LANGUAGE. </li>
                    <li class="about-page-block-list-item" data-text="SOMEONE (?) IS WAITING FOR US (?).">SOMEONE (?) IS WAITING FOR US (?). </li>
                    <li class="about-page-block-list-item" data-text="IS THIS CRINGE?">IS THIS CRINGE? </li>
                    <li class="about-page-block-list-item" data-text="WE'RE (?) ALL (?) IN DANGER.">WE'RE (?) ALL (?) IN DANGER. </li>
                </ul>

                <ul class="about-page-list">
                    <li class="about-page-block-list-item" data-text="NOBODY / ART DIRECTOR / ARTIST / AI IMAGE GENERATOR…& ">NOBODY / ART DIRECTOR / ARTIST / AI IMAGE GENERATOR…&</li>
                    <li class="about-page-block-list-item" data-text="NOBODY / 3D ARTIST / AI IMAGE GENERATOR…& ">NOBODY / 3D ARTIST / AI IMAGE GENERATOR…&  </li>
                    <li class="about-page-block-list-item" data-text="NOBODY / SOUND ARTIST…&">NOBODY / SOUND ARTIST…&  </li>
                    <li class="about-page-block-list-item" data-text="NOBODY / WEB DESIGNER / GRAPHIC DESIGNER…& ">NOBODY / WEB DESIGNER / GRAPHIC DESIGNER…&  </li>
                    <li class="about-page-block-list-item" data-text="NOBODY / MOBILE DESIGNER / GRAPHIC DESIGNER…& ">NOBODY / MOBILE DESIGNER / GRAPHIC DESIGNER…&  </li>
                    <li class="about-page-block-list-item" data-text="NOBODY / ILLUSTRATOR…& ">NOBODY / ILLUSTRATOR…&  </li>
                    <li class="about-page-block-list-item" data-text="NOBODY / TRANSLATOR">NOBODY / TRANSLATOR  </li>
                    <li class="about-page-block-list-item" data-text="NOBODY / WEB DEVELOPER…&">NOBODY / WEB DEVELOPER…&  </li>
                    <li class="about-page-block-list-item" data-text="NOBODY / WEB DEVELOPER…& ">NOBODY / WEB DEVELOPER…&  </li>
                    <li class="about-page-block-list-item" data-text="NOBODY / WEB DEVELOPER…&">NOBODY / WEB DEVELOPER…&  </li>
                </ul>

                <ul class="about-page-list">
                    <li class="about-page-block-list-item" data-text="ONTS USED">FONTS USED </li>
                    <li class="about-page-block-list-item"  data-text="THIS REALITY – LICENSED VIA ENVATO">HIS REALITY – LICENSED VIA ENVATO </li>
                    <li class="about-page-block-list-item"  data-text="VIKTORIE – ADOBE CREATIVE CLOUD">VIKTORIE – ADOBE CREATIVE CLOUD </li>
                    <li class="about-page-block-list-item"  data-text="AVARA – SIL OPEN FONT LICENSE 1.1">AVARA – SIL OPEN FONT LICENSE 1.1 </li>
                    <li class="about-page-block-list-item"  data-text="FT88 (DEHEEST PROJECT) – SIL OPEN FONT LICENSE 1.1">FT88 (DEHEEST PROJECT) – SIL OPEN FONT LICENSE 1.1 </li>
                    <li class="about-page-block-list-item"  data-text="PROFESSOR – ADOBE CREATIVE CLOUD">PROFESSOR – ADOBE CREATIVE CLOUD </li>
                    <li class="about-page-block-list-item"  data-text="HENNY PENNY – GOOGLE FONTS (SIL OPEN FONT LICENSE 1.1)">HENNY PENNY – GOOGLE FONTS (SIL OPEN FONT LICENSE 1.1)</li>
                </ul>

                <ul class="about-page-list">
                    <li class="about-page-block-list-item"  data-text="MUSIC USED">MUSIC USED </li>
                    <li class="about-page-block-list-item"  data-text="CLAUDINE LONGET - SLEEP SAFE & WARM / LULLABY FROM ROSEMARY'S BABYJANE - IT’S A FINE DAY">CLAUDINE LONGET - SLEEP SAFE & WARM / LULLABY FROM ROSEMARY'S BABYJANE - IT’S A FINE DAY</li>
                    <li class="about-page-block-list-item"  data-text="HIGH PLACES - BANANA SLUGS / COSMONAUT">HIGH PLACES - BANANA SLUGS / COSMONAUT</li>
                </ul> 
                
            </section>
        </div>

        <!-- Основной контейнер для раздела Items -->
        <?php get_template_part('items/layout-content'); ?>
    </div>
    
</article>
<?php endwhile; endif; ?>
<?php get_footer(); ?>