@extends('layouts.bot')
@section('content')
    <div class="p-6">
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
        {{-- @foreach ($cards as $card)
        <div class="bg-gradient-to-br from-[#524a26] to-[#1E1E1E] rounded-lg p-2 flex">
            <img src="{{url('storage/' . $card->image)}}" alt="Логотип магазина 1" class="w-24 h-24 object-cover p-4">
            <div class="p-4 flex flex-col justify-between">
                <div>
                    <h2 class="text-xl text-gray-100 font-bold">{{$card->title}}</h2>
                    <div class="w-24 h-px bg-gray-300 my-1"></div>
                    <p class="text-xs text-gray-100">{{$card->category->title}}</p>
                    <p class="mt-2 text-gray-100">{{truncate_text($card->description, 10)}}</p>
                </div>
                <a href="#" class="mt-4 text-center bg-yellow-500 text-black px-4 py-2 rounded-full hover:bg-yellow-600">Подробнее</a>
            </div>
        </div>
        @endforeach --}}
        @foreach ($cards as $card)
        <div class="bg-gradient-to-br from-[#2e2e2e] to-[#3a372d] rounded-md flex" style="-webkit-mask-image: radial-gradient(circle at right 8.5px bottom 76px, transparent 8.5px, rgb(255, 255, 255) 8.75px), radial-gradient(circle closest-side at 50% center, rgb(255, 255, 255) 99%, transparent 100%); -webkit-mask-size: 100%, 9.5px 5px; -webkit-mask-repeat: repeat, repeat-x; -webkit-mask-position: 8.5px center, 50% calc(100% - 73px); -webkit-mask-composite: source-out;">
            <img src="{{url('storage/' . $card->image)}}" alt="Логотип магазина 1" class="w-24 h-24 object-cover p-4">
            <div class="p-4 flex flex-col justify-between">
                <div>
                    <h2 class="text-xl text-gray-100 font-bold">{{$card->title}}</h2>
                    <div class="w-24 h-px bg-gray-300 my-1"></div>
                    <p class="text-xs text-gray-100">{{$card->category->title}}</p>
                    <p class="mt-2 text-gray-100">{{truncate_text($card->description, 10)}}</p>
                </div>
                <a href="#" class="mt-8 text-center bg-yellow-500 text-black px-4 py-2 rounded-full hover:bg-yellow-600">Подробнее</a>
            </div>
        </div>
        @endforeach
    </div>
@endsection