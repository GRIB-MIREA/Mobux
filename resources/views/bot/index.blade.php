@extends('layouts.app')
@section('content')
<main class="container mx-auto mt-10">
    <div class="w-full p-6">
        <div class="relative">
            <input type="text" placeholder="Поиск..." class="w-full p-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 pl-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 50 50" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M 21 3 C 11.601563 3 4 10.601563 4 20 C 4 29.398438 11.601563 37 21 37 C 24.355469 37 27.460938 36.015625 30.09375 34.34375 L 42.375 46.625 L 46.625 42.375 L 34.5 30.28125 C 36.679688 27.421875 38 23.878906 38 20 C 38 10.601563 30.398438 3 21 3 Z M 21 7 C 28.199219 7 34 12.800781 34 20 C 34 27.199219 28.199219 33 21 33 C 13.800781 33 8 27.199219 8 20 C 8 12.800781 13.800781 7 21 7 Z"></path>
                </svg>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
        <!-- Карточка 1 -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden flex">
            <img src="{{url('https://via.placeholder.com/150')}}" alt="Логотип магазина 1" class="w-24 h-24 object-cover p-4">
            <div class="p-4 flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-bold">Магазин 1</h2>
                    <p class="text-sm text-gray-500">Электроника</p>
                    <p class="mt-2 text-gray-700">Здесь вы найдете лучшие электроника по доступным ценам.</p>
                </div>
                <a href="#" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Подробнее</a>
            </div>
        </div>
    
        <!-- Карточка 2 -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden flex">
            <img src="https://via.placeholder.com/150" alt="Логотип магазина 2" class="w-24 h-24 object-cover p-4">
            <div class="p-4 flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-bold">Магазин 2</h2>
                    <p class="text-sm text-gray-500">Одежда</p>
                    <p class="mt-2 text-gray-700">У нас широкий ассортимент одежды для всей семьи.</p>
                </div>
                <a href="#" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Подробнее</a>
            </div>
        </div>
    
        <!-- Карточка 3 -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden flex">
            <img src="https://via.placeholder.com/150" alt="Логотип магазина 3" class="w-24 h-24 object-cover p-4">
            <div class="p-4 flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-bold">Магазин 3</h2>
                    <p class="text-sm text-gray-500">Спорт</p>
                    <p class="mt-2 text-gray-700">Все для вашего активного образа жизни и спорта.</p>
                </div>
                <a href="#" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Подробнее</a>
            </div>
        </div>
    
        <!-- Карточка 4 -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden flex">
            <img src="https://via.placeholder.com/150" alt="Логотип магазина 4" class="w-24 h-24 object-cover p-4">
            <div class="p-4 flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-bold">Магазин 4</h2>
                    <p class="text-sm text-gray-500">Книги</p>
                    <p class="mt-2 text-gray-700">Лучшие книги для чтения и саморазвития.</p>
                </div>
                <a href="#" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Подробнее</a>
            </div>
        </div>
    </div>
    
</main>
@endsection