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
</head>
<body class="bg-gray-500">
    @yield('content')
    <nav class="bg-black shadow fixed bottom-0 w-full">
        <div class="flex justify-around p-4">
            <div class="flex flex-col items-center">
                <a href="#" class="text-white hover:text-blue-500">Акции</a>
            </div>
            <div class="flex flex-col items-center">
                <a href="#" class="text-white hover:text-blue-500">Категории</a>
            </div>
            <div class="flex flex-col items-center">
                <a href="#" class="text-white hover:text-blue-500">Профиль</a>
            </div>
            <div class="flex flex-col items-center">
                <a href="#" class="text-white hover:text-blue-500">О боте</a>
            </div>
        </div>
    </nav>
</body>
</html>
