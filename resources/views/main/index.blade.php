@extends('layouts.app')
@section('content')
<main class="container mx-auto mt-10">
    <div class="right-0 p-6">
        <script async src="https://telegram.org/js/telegram-widget.js?22" data-telegram-login="mobux_bot" data-size="large" data-auth-url="https://mobux.ru/api/auth" data-request-access="write"></script>
    </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-md p-4">
            <img src="https://via.placeholder.com/300" alt="Пример изображения" class="rounded-lg mb-4">
            <h2 class="text-xl font-semibold">Заголовок карточки</h2>
            <p class="text-gray-600 mt-2">Это описание карточки. Здесь можно разместить любую информацию.</p>
            <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Узнать больше</button>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4">
            <img src="https://via.placeholder.com/300" alt="Пример изображения" class="rounded-lg mb-4">
            <h2 class="text-xl font-semibold">Заголовок карточки</h2>
            <p class="text-gray-600 mt-2">Это описание карточки. Здесь можно разместить любую информацию.</p>
            <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Узнать больше</button>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4">
            <img src="https://via.placeholder.com/300" alt="Пример изображения" class="rounded-lg mb-4">
            <h2 class="text-xl font-semibold">Заголовок карточки</h2>
            <p class="text-gray-600 mt-2">Это описание карточки. Здесь можно разместить любую информацию.</p>
            <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Узнать больше</button>
        </div>
    </div>
</main>
@endsection