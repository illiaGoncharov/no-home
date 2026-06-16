<?php
/**
 * Минимальный шаблон item-frame — грузится ТОЛЬКО внутри iframe
 * скелет-меню родителя при ?desktop=1&item=<key>.
 *
 * Родитель (мобайл скелет-меню) уже показывает свою бегущую строку,
 * скелет, крестик меню — здесь дублировать не надо.
 *
 * Только:
 *  - крестик "закрыть предмет" (postMessage родителю)
 *  - layout-content (items-wrapper + #items-content)
 *  - swipe вбок (handled in mobile.js) тоже шлёт postMessage close
 *
 * header.php при ?desktop=1&item=… делает ранний return —
 * desktop-навигация/скелет НЕ выводятся в DOM iframe.
 */

get_header();

$tpl = get_template_directory_uri();
?>

<button class="m-item-close" id="mItemClose" aria-label="Close">
    <img src="<?php echo $tpl; ?>/files/mobile/skeleton-menu/cross.png" alt="">
</button>

<div class="m-item-shell" id="mItemShell">
    <?php get_template_part( 'items/layout-content' ); ?>
</div>

<?php
get_footer();
