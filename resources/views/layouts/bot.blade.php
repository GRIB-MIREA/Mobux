<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'MOBUX')</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/png" href="{{asset('favicon-96x96.png')}}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{asset('favicon.svg')}}" />
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('apple-touch-icon.png')}}" />
    <link rel="manifest" href="{{asset('site.webmanifest')}}" />

    <!-- Scripts -->
    <script src="https://telegram.org/js/telegram-web-app.js?56"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
    
        ym(99510700, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true
        });
    </script>
 <noscript><div><img src="https://mc.yandex.ru/watch/99510700" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
 <!-- /Yandex.Metrika counter -->
</head>
<style>
    .bg-custom {
    background-image: url('/assets/img/bg.jpg'); /* Замените на ваш URL */
    background-size: cover; /* Заставляет изображение заполнять весь элемент */
    background-position: center; /* Центрирует изображение */
}
</style>
<body class="flex flex-col items-center min-h-screen bg-custom">
    <header class="flex justify-center py-4 w-full">
        <div class="mx-auto text-center">
            <img src="{{asset('assets/img/logo.png')}}" alt="Логотип" class="h-16">
            <p class="text-white text-2xl mt-2">СКИДКИ И ПРОМОКОДЫ</p>
        </div>
    </header>
    <main class="flex-grow w-full">
        @yield('content')
        @livewireScripts
        <br>
        <br>
        <br>
        <br>
    </main>
    <div class="fixed bottom-10 left-0 right-0 bg-[#1E1E1E] shadow-md rounded-lg p-4 mx-10">
        <div class="flex justify-evenly">
            <a href="{{route('bot.index')}}" class="text-gray-100 hover:text-[#fcd839] flex items-center">
                <span class="px-1 hidden md:block">
                    <svg class="w-6 h-6 text-gray-100" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M20.29 8.567c.133.323.334.613.59.85v.002a3.536 3.536 0 0 1 0 5.166 2.442 2.442 0 0 0-.776 1.868 3.534 3.534 0 0 1-3.651 3.653 2.483 2.483 0 0 0-1.87.776 3.537 3.537 0 0 1-5.164 0 2.44 2.44 0 0 0-1.87-.776 3.533 3.533 0 0 1-3.653-3.654 2.44 2.44 0 0 0-.775-1.868 3.537 3.537 0 0 1 0-5.166 2.44 2.44 0 0 0 .775-1.87 3.55 3.55 0 0 1 1.033-2.62 3.594 3.594 0 0 1 2.62-1.032 2.401 2.401 0 0 0 1.87-.775 3.535 3.535 0 0 1 5.165 0 2.444 2.444 0 0 0 1.869.775 3.532 3.532 0 0 1 3.652 3.652c-.012.35.051.697.184 1.02ZM9.927 7.371a1 1 0 1 0 0 2h.01a1 1 0 0 0 0-2h-.01Zm5.889 2.226a1 1 0 0 0-1.414-1.415L8.184 14.4a1 1 0 0 0 1.414 1.414l6.218-6.217Zm-2.79 5.028a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01Z" clip-rule="evenodd"/>
                    </svg>                      
                </span>
                Все акции
            </a>
            <div class="h-6 w-px bg-gray-300 mx-2"></div>
            <a href="{{route('bot.categories')}}" class="text-gray-100 hover:text-[#fcd839] flex items-center">
                <span class="px-1 hidden md:block">
                    <svg class="w-6 h-6 text-gray-100" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 6H6m12 4H6m12 4H6m12 4H6"/>
                    </svg>                      
                </span>
                Категории
            </a>
            <div class="h-6 w-px bg-gray-300 mx-2"></div>
            <a href="{{route('bot.about')}}" class="text-gray-100 hover:text-[#fcd839] flex items-center">
                <span class="px-1 hidden md:block">
                    <svg class="w-6 h-6 text-gray-100" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z" clip-rule="evenodd"/>
                    </svg>                      
                </span>
                О боте
            </a>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Проверяем, доступен ли объект BackButton
            if (Telegram.WebApp && Telegram.WebApp.BackButton) {
                // Устанавливаем isVisible в true, чтобы сделать кнопку "Назад" видимой
                Telegram.WebApp.BackButton.isVisible = true;
                console.log(Telegram.WebApp);
                // Устанавливаем обработчик события нажатия на кнопку "Назад"
                Telegram.WebApp.BackButton.onClick(function() {
                    console.log("Кнопка 'Назад' нажата");
                    // Здесь можно добавить логику для обработки нажатия на кнопку
                });
            } else {
                console.error("BackButton не доступен");
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>
    <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.min.js"></script>
</body>
</html>
