@extends('layouts.bot')
@section('title', 'О сайте MOBUX')
@section('content')
        <section class="antialiased p-6">
            <div class="mx-auto px-4 2xl:px-0">
              <div class="mb-4 flex flex-col text-gray-100 justify-between">
                <h1 class="text-3xl font-semibold text-center sm:text-2xl">О боте</h1>
                <p class="mt-4">MOBUX — ваш надежный помощник в мире выгодных покупок! Мы собрали для вас лучшие предложения и промокоды от популярных магазинов и брендов, чтобы вы могли экономить на своих покупках и наслаждаться шопингом без лишних затрат.</p>
                <p class="mt-4 text-2xl font-semibold text-center">Почему именно MOBUX?</p>
                <div class="grid mt-8 gap-14 xl:grid-cols-4 lg:grid-cols-2 md:gap-5">
                  <div class="rounded-xl bg-gray-100 p-6 text-center shadow-xl">
                    <div class="mx-auto flex h-16 w-16 -translate-y-12 transform items-center justify-center rounded-full bg-teal-400 shadow-lg shadow-teal-500/40">
                      <svg class="w-8 h-8 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 9h6m-6 3h6m-6 3h6M6.996 9h.01m-.01 3h.01m-.01 3h.01M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/>
                      </svg>                                            
                    </div>
                    <h1 class="text-black mb-3 text-xl font-medium lg:px-14">ШИРОКИЙ ВЫБОР ПРОМОКОДОВ</h1>
                    <p class="px-4 text-gray-600">Получайте доступ к актуальным промокодам от множества магазинов. Мы постоянно обновляем нашу базу, чтобы вы всегда могли найти самые свежие предложения.</p>
                  </div>
                  <div class="rounded-xl bg-gray-100 p-6 text-center shadow-xl">
                    <div class="mx-auto flex h-16 w-16 -translate-y-12 transform items-center justify-center rounded-full bg-sky-500 shadow-lg shadow-sky-500/40">
                      <svg class="w-8 h-8 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.891 15.107 15.11 8.89m-5.183-.52h.01m3.089 7.254h.01M14.08 3.902a2.849 2.849 0 0 0 2.176.902 2.845 2.845 0 0 1 2.94 2.94 2.849 2.849 0 0 0 .901 2.176 2.847 2.847 0 0 1 0 4.16 2.848 2.848 0 0 0-.901 2.175 2.843 2.843 0 0 1-2.94 2.94 2.848 2.848 0 0 0-2.176.902 2.847 2.847 0 0 1-4.16 0 2.85 2.85 0 0 0-2.176-.902 2.845 2.845 0 0 1-2.94-2.94 2.848 2.848 0 0 0-.901-2.176 2.848 2.848 0 0 1 0-4.16 2.849 2.849 0 0 0 .901-2.176 2.845 2.845 0 0 1 2.941-2.94 2.849 2.849 0 0 0 2.176-.901 2.847 2.847 0 0 1 4.159 0Z"/>
                      </svg>                      
                    </div>
                    <h1 class="text-black mb-3 text-xl font-medium lg:px-14">ЭКСКЛЮЗИВНЫЕ АКЦИИ</h1>
                    <p class="px-4 text-gray-600">Будьте в курсе всех акций и распродаж! Наше приложение уведомит вас о специальных предложениях, которые помогут вам сэкономить еще больше.</p>
                  </div>
                  <div class="rounded-xl bg-gray-100 p-6 text-center shadow-xl">
                    <div class="mx-auto flex h-16 w-16 -translate-y-12 transform items-center justify-center rounded-full bg-rose-400 shadow-lg shadow-rose-500/40">
                      <svg class="w-8 h-8 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                      </svg>                      
                    </div>
                    <h1 class="text-black mb-3 text-xl font-medium lg:px-14">УДОБНЫЙ ПОИСК И ФИЛЬТРАЦИЯ</h1>
                    <p class="px-4 text-gray-600">Легко находите нужные промокоды и акции с помощью удобной системы поиска. Также вы можете искать магазины по категориям.</p>
                  </div>
                  <div class="rounded-xl bg-gray-100 p-6 text-center shadow-xl">
                    <div class="mx-auto flex h-16 w-16 -translate-y-12 transform items-center justify-center rounded-full bg-amber-500 shadow-lg shadow-amber-600/40">
                      <svg class="w-8 h-8 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h.01M8.99 9H9m12 3a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM6.6 13a5.5 5.5 0 0 0 10.81 0H6.6Z"/>
                      </svg>                      
                    </div>
                    <h1 class="text-black mb-3 text-xl font-medium lg:px-14">ИНТУИТИВНО ПОНЯТНЫЙ ИНТЕРФЕЙС</h1>
                    <p class="px-4 text-gray-600">Простота и удобство использования — наш приоритет. Вы сможете быстро и легко находить нужные предложения без лишних усилий.</p>
                  </div>
                </div>
                <p class="mt-8 text-center text-2xl font-semibold">Наши социальные сети:</p>
                <div class="flex flex-col justify-center items-center mt-4">
                  <a href="https://t.me/m0bux" target="_blank" class="flex items-center w-1/10 bg-sky-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-sky-700 transition duration-300">
                    <i class="fab fa-telegram fa-2x mr-4"></i>
                    Наш канал в телеграм
                  </a>
                  <div class="mt-4">
                    <span>
                      Разработка сайта и приложения:
                      <a href="https://t.me/dlitvinoff" target="_blank" class="text-yellow-300 hover:text-yellow-500">Litvinoff</a>
                    </span>
                  </div>
                </div>
              </div>
            </div>
        </section>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
              // Проверяем, доступен ли объект Telegram.WebApp
              if (Telegram.WebApp) {
                  // Устанавливаем видимость кнопки "Назад"
                  Telegram.WebApp.BackButton.isVisible = false;
              } else {
                  console.error("Telegram.WebApp не доступен");
              }
          });
      </script>
@endsection