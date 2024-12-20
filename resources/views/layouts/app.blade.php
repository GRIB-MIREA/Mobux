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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="bg-blue-600 text-white p-6 text-center">
        <h1 class="text-3xl font-bold">Добро пожаловать на мой сайт!</h1>
        <p class="mt-2">Это пример страницы с использованием Tailwind CSS.</p>
    </header>
    @yield('content')
    <footer class="bg-gray-800 text-white text-center p-4 mt-10">
        <p>&copy; 2023 Мой сайт. Все права защищены.</p>
    </footer>
</body>
</html>
