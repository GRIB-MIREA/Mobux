<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Default Title')</title>
    <meta property="og:url" content="https://mobux.ru">
    <meta property="og:title" content="Скидки, промокоды и кэшбек - MOBUX">
    <meta property="og:description" content="MOBUX — ваш надежный помощник в мире выгодных покупок! Мы собрали для вас лучшие предложения и промокоды от популярных магазинов и брендов, чтобы вы могли экономить на своих покупках и наслаждаться шопингом без лишних затрат.">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Мобакс.ru" />
    <meta name="description" content="MOBUX — ваш надежный помощник в мире выгодных покупок! Мы собрали для вас лучшие предложения и промокоды от популярных магазинов и брендов, чтобы вы могли экономить на своих покупках и наслаждаться шопингом без лишних затрат.">
    <meta name="keywords" content="Промокоды, Акции и скидки, Купоны на скидку, Скидки на покупки, Специальные предложения, Горящие скидки, Скидки до 50%, Лучшие промокоды, Экономия на покупках, Онлайн-скидки, Промокоды Россия, Промокоды Казахстан, Промокоды Беларусь, Промокоды Украина, Акции в России, Акции в Казахстане, Акции в Беларуси, Акции в Украине, Промокоды для одежды, Промокоды для электроники, Промокоды для косметики, Промокоды для продуктов питания, Промокоды для путешествий, Промокоды для ресторанов, Промокоды для онлайн-магазинов, Получить промокод, Ввести промокод, Сэкономить на покупках, Активировать купон, Найти лучшие акции, Узнать о скидках, Подписаться на рассылку скидок, Промокоды на Алиэкспресс, Промокоды на Ozon, Промокоды на Wildberries, Промокоды на Lamoda, Промокоды на Booking.com, Промокоды на Яндекс.Маркет, Промокоды на Rozetka, Как использовать промокоды, Где найти купоны, Сравнение акций, Обзоры на промокоды, Советы по экономии, Лучшие сайты с промокодами">
    <meta name="perfluence-verification" content="dac522971c71" />
    <meta name="apple-mobile-web-app-title" content="MOBUX" />
    <meta name="verify-admitad" content="18fa1da877" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{asset('favicon-96x96.png')}}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{asset('favicon.svg')}}" />
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('apple-touch-icon.png')}}" />
    <link rel="manifest" href="{{asset('site.webmanifest')}}" />

    <!-- Scripts -->
    <script src="https://telegram.org/js/telegram-web-app.js?56"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @yield('content')
</body>
</html>
