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
    <style>
        .gradient-border {
            border-image: linear-gradient(135deg, #fcd839, #999999) 1;
            border-width: 1px;
            border-style: solid;
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
    </main>
    <nav class="bg-black shadow fixed bottom-0 w-full">
        <div class="flex justify-around p-4">
            <div class="flex flex-col items-center">
                <a href="#" class="text-white hover:text-yellow-500">Акции</a>
            </div>
            <div class="flex flex-col items-center">
                <a href="#" class="text-white hover:text-yellow-500">Категории</a>
            </div>
            <div class="flex flex-col items-center">
                <a href="#" class="text-white hover:text-yellow-500">О боте</a>
            </div>
        </div>
    </nav>
</body>
</html>
