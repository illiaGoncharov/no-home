<?php
/**
 * Заглушка для мобильных устройств на проде.
 * Показывается вместо сайта, пока мобильная версия дорабатывается.
 * Простое сообщение, без загрузки тяжёлых десктоп-ассетов.
 */
$tpl = get_template_directory_uri();
?><!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>no home</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body {
            height: 100%;
            background: #0e0d0b;
            color: #f3ede2;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .wrap {
            min-height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 32px 24px;
            gap: 28px;
        }
        .horse {
            width: 96px;
            height: auto;
            image-rendering: pixelated;
            filter: drop-shadow(0 0 18px rgba(220, 60, 40, 0.55));
        }
        .msg {
            font-size: 22px;
            line-height: 1.5;
            max-width: 320px;
            letter-spacing: 0.2px;
        }
        .sub {
            font-size: 14px;
            opacity: 0.55;
            max-width: 300px;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <img class="horse" src="<?php echo esc_url( $tpl ); ?>/files/mobile/home/red-horse-running-text.png" alt="">
        <div class="msg">Крис, жду твоего ответа.<br>Давай поговорим.</div>
        <div class="sub">мобильная версия временно недоступна, открой с компьютера</div>
    </div>
</body>
</html>
<?php
exit;
