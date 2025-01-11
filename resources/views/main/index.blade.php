@extends('layouts.app')
@section('content')
<header class="py-6 bg-gray-800">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-yellow-400 text-3xl font-bold">
            <img src="{{asset('assets/img/logo.png')}}" alt="Логотип" class="h-8">
        </div>
        <nav class="hidden md:flex space-x-4">
            <ul class="flex space-x-4 text-gray-100">
                <li><a href="#about" class="hover:text-yellow-400">О нас</a></li>
                <li><a href="#partners" class="hover:text-yellow-400">Партнеры</a></li>
                <li><a href="#advantages" class="hover:text-yellow-400">Преимущества</a></li>
            </ul>
        </nav>
        <button id="mobile-menu-button" class="md:hidden text-yellow-400 focus:outline-none">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 5h14a1 1 0 110 2H3a1 1 0 110-2zm0 5h14a1 1 0 110 2H3a1 1 0 110-2zm0 5h14a1 1 0 110 2H3a1 1 0 110-2z" clip-rule="evenodd" /></svg>
        </button>
    </div>
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden bg-gray-800">
        <ul class="flex flex-col items-center space-y-2 py-4">
            <li><a href="#about" class="hover:text-yellow-400">О нас</a></li>
            <li><a href="#partners" class="hover:text-yellow-400">Партнеры</a></li>
            <li><a href="#advantages" class="hover:text-yellow-400">Преимущества</a></li>
        </ul>
    </div>
</header>

<!-- Introduction Section -->
<section id="about" class="py-20 bg-gray-800">
    <div class="container mx-auto flex flex-col md:flex-row items-center bg-gray-500 rounded-3xl">
        <div class="md:w-1/2 lg:text-left text-center mb-10 md:mb-0">
            <h2 class="font-bold lg:text-7xl text-xl mb-4 text-gray-100">Ваш проводник в мир выгодных покупок!</h2>
            <p class="text-xl mb-8 text-gray-100">Лучшие предложения в одном месте.</p>
            <a href="#partners" class="bg-yellow-400 text-gray-900 px-6 py-3 rounded-lg hover:bg-yellow-300 transition">Посмотреть промокоды</a>
        </div>
        <div class="md:w-1/2 flex justify-center">
            <img src="{{asset('assets/img/iphone.png')}}" alt="iPhone" class="lg:w-1/2 w-1/2 h-auto">
        </div>
    </div>
</section>

<!-- Partners Section -->
<section id="partners" class="py-20 bg-gray-800">
    <div class="container mx-auto text-center">
        <h2 class="text-3xl font-bold mb-6">Наши партнёры</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="p-4 bg-gray-700 rounded-lg">Партнер 1</div>
            <div class="p-4 bg-gray-700 rounded-lg">Партнер 2</div>
            <div class="p-4 bg-gray-700 rounded-lg">Партнер 3</div>
            <div class="p-4 bg-gray-700 rounded-lg">Партнер 4</div>
            <div class="p-4 bg-gray-700 rounded-lg">Партнер 5</div>
            <div class="p-4 bg-gray-700 rounded-lg">Партнер 6</div>
            <div class="p-4 bg-gray-700 rounded-lg">Партнер 7</div>
            <div class="p-4 bg-gray-700 rounded-lg">Партнер 8</div>
        </div>
    </div>
</section>

<!-- Advantages Section -->
<section id="advantages" class="py-20">
    <div class="container mx-auto text-center">
        <h2 class="text-3xl font-bold mb-6">Преимущества нашего сайта</h2>
        <ul class="list-disc list-inside space-y-4">
            <li>🔹 Широкий выбор промокодов</li>
            <li>🔹 Регулярные обновления</li>
            <li>🔹 Удобный интерфейс</li>
            <li>🔹 Поддержка 24/7</li>
            <li>🔹 Легкость в использовании</li>
        </ul>
    </div>
</section>

<!-- Footer -->
<footer class="py-6 bg-gray-800 text-center">
    <p>&copy; 2023 Промокоды для магазинов. Все права защищены.</p>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("menu-toggle").addEventListener("click", function() {
        var menu = document.getElementById("mobile-menu");
        menu.style.display = (menu.style.display === "block") ? "none" : "block";
    });
});
</script>
@endsection
{{-- <script async src="https://telegram.org/js/telegram-widget.js?22" data-telegram-login="mobux_bot" data-size="large" data-auth-url="https://mobux.ru/api/auth" data-request-access="write"></script> --}}