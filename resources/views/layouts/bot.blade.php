<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Скидки, промокоды и кэшбек - MOBUX</title>
    <meta property="og:url" content="https://mobux.ru">
    <meta property="og:title" content="">
    <meta property="og:description" content="">
    <meta property="og:type" content="website">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://telegram.org/js/telegram-web-app.js?56"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-custom {
            background-image: url('../assets/img/bg.jpg'); /* Замените на ваш URL */
            background-size: cover; /* Заставляет изображение заполнять весь элемент */
            background-position: center; /* Центрирует изображение */
        }
    </style>
</head>
<body class="flex flex-col items-center min-h-screen bg-custom">
    <header class="flex justify-center py-4 w-full">
        <div class="mx-auto text-center">
            <img src="{{asset('assets/img/logo.png')}}" alt="Логотип" class="h-16">
            <p class="text-white text-2xl mt-2">СКИДКИ И ПРОМОКОДЫ</p>
        </div>
    </header>
    <main class="flex-grow">
        @yield('content')
        <br>
        <br>
        <br>
        <br>
    </main>
    <div class="fixed bottom-10 left-0 right-0 bg-[#1E1E1E] shadow-md rounded-lg p-4 mx-10">
        <div class="flex justify-around">
            <a href="#" class="text-gray-100 hover:text-[#fcd839]">Акции</a>
            <div class="h-6 w-px bg-gray-300 mx-2"></div>
            <a href="#" class="text-gray-100 hover:text-[#fcd839]">Каталог</a>
            <div class="h-6 w-px bg-gray-300 mx-2"></div>
            <a href="#" class="text-gray-100 hover:text-[#fcd839]">О боте</a>
        </div>
    </div>
</body>
</html>
