<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<link rel="icon" href="data:,">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<?php wp_head(); ?>
</head>
<body <?php body_class('mobile'); ?>>

<div class="mobile-interface">

    <!-- Верхняя полоса: ссылка i/x — те же классы что на десктопе (шрифт Avara) -->
    <div class="mobile-nav-top">
        <?php if ( is_page('about') ) : ?>
            <a href="<?php echo get_home_url(); ?>"
               class="about-link" id="about-link" data-text="i">x</a>
        <?php elseif ( is_front_page() ) : ?>
            <a href="<?php echo get_permalink( get_page_by_path('about') ); ?>"
               class="about-link" id="about-link" data-text="x">i</a>
        <?php endif; ?>
    </div>

</div><!-- .mobile-interface -->
