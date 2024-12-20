@extends('layouts.app')
@section('content')
<main class="container mx-auto mt-10">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
        <!-- Карточка 1 -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden flex">
            <img src="{{url('https://via.placeholder.com/150')}}" alt="Логотип магазина 1" class="w-24 h-24 object-cover p-4">
            <div class="p-4 flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-bold">Магазин 1</h2>
                    <p class="text-sm text-gray-500">Электроника</p>
                    <p class="mt-2 text-gray-700">Описание магазина 1. Здесь вы найдете лучшие электроника по доступным ценам.</p>
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
                    <p class="mt-2 text-gray-700">Описание магазина 2. У нас широкий ассортимент одежды для всей семьи.</p>
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
                    <p class="mt-2 text-gray-700">Описание магазина 3. Все для вашего активного образа жизни и спорта.</p>
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
                    <p class="mt-2 text-gray-700">Описание магазина 4. Лучшие книги для чтения и саморазвития.</p>
                </div>
                <a href="#" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Подробнее</a>
            </div>
        </div>
    </div>
    
</main>
@endsection