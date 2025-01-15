@extends('layouts.bot')
@section('title', 'Промокоды на скидку ' . $card->title . ' за ' . $titleDate . ' | MOBUX')
@section('content')
        <section class="antialiased p-6">
            <div class="flex flex-col mx-auto px-4 2xl:px-0">
              <div class="flex flex-row items-center">
                <img src="{{url('storage/' . $card->image)}}" alt="Логотип магазина 1" class="lg:w-36 lg:h-36 w-24 h-24 object-cover p-4 rounded-full">
                <div class="flex flex-col items-start space-y-2">
                  <h1 class="lg:text-2xl text-xl font-semibold text-gray-100">{{$card->title}}</h1>
                  @foreach ($card->stamps as $stamp)
                      <div class="flex flex-row space-x-2">
                        <div class="bg-gray-200 px-1 py-1 rounded-full">
                          <svg class="w-5 h-5" style="color: #{{$stamp->color}};" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                              <path d="{{$stamp->icon}}"/>
                          </svg>                                                        
                        </div>
                        <div class="flex items-center text-gray-200 font-normal lg:text-md text-xs">{{$stamp->title}}</div>
                      </div>
                  @endforeach
                  <p class="text-gray-100 text-sm">Промокодов доступно: {{$promocodeCount}}</p> 
                </div>   
              </div>
              <div class="px-4 py-2 text-gray-200">
                <span>{{truncate_text($card->description, 10)}}</span>
                <a href="#" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="text-gray-400 underline hover:no-underline hover:text-yellow-300">Показать полностью</a>
              </div>
              <div id="popup-modal" tabindex="-1" class="fixed inset-0 z-50 flex justify-center items-center hidden">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative rounded-lg shadow bg-zinc-800">
                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center hover:bg-gray-600 hover:text-white" data-modal-hide="popup-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Закрыть</span>
                        </button>
                        <div class="text-center">
                            <h3 class="text-lg p-10 font-normal text-gray-400">{{$card->description}}</h3>
                        </div>
                    </div>
                </div>
            </div>
              @foreach ($card->promocodes as $promocode)
              <div class="card-item p-4 mt-6 bg-gradient-to-br from-[#2e2e2e] to-[#3a372d] rounded-md flex border border-zinc-900" style="-webkit-mask-image: radial-gradient(circle at right 8.5px bottom 68px, transparent 8.5px, rgb(255, 255, 255) 8.75px), radial-gradient(circle closest-side at 50% center, rgb(255, 255, 255) 99%, transparent 100%); -webkit-mask-size: 100%, 8.5px 5px; -webkit-mask-repeat: repeat, repeat-x; -webkit-mask-position: 8.5px center, 50% calc(100% - 65px); -webkit-mask-composite: source-out;">
                <div class="flex flex-col w-full">
                  <div class="text-white lg:text-4xl text-xl text-center">{{$promocode->reward}}</div>
                  <div class="flex flex-row items-between space-x-4">
                    <div class="flex lg:flex-row flex-col justify-between bg-zinc-500 rounded-md lg:w-11/12 w-4/5 p-4 mt-2">
                      <div class="text-white lg:text-2xl text-md">Промокод: <strong>{{$promocode->title}}</strong></div>
                      <div class="flex items-center text-white lg:text-md text-xs">Действует до: {{ Carbon\Carbon::parse($promocode->expiration_date)->translatedFormat('d F Y') }}</div>
                    </div>
                    <div class="flex lg:w-1/12 w-1/5 bg-zinc-500 rounded-md mt-2">
                      <button onclick="copyToClipboard('{{ $promocode->title }}', this)" class="text-white text-center flex justify-center items-center mx-auto">
                        <svg class="w-10 h-10 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                          <path fill-rule="evenodd" d="M18 3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1V9a4 4 0 0 0-4-4h-3a1.99 1.99 0 0 0-1 .267V5a2 2 0 0 1 2-2h7Z" clip-rule="evenodd"/>
                          <path fill-rule="evenodd" d="M8 7.054V11H4.2a2 2 0 0 1 .281-.432l2.46-2.87A2 2 0 0 1 8 7.054ZM10 7v4a2 2 0 0 1-2 2H4v6a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3Z" clip-rule="evenodd"/>
                        </svg>                        
                      </button>
                    </div>
                  </div>
                  <div class="inline-block rounded bg-yellow-300 px-6 pb-2 pt-2.5 mt-4 text-md text-center font-medium uppercase leading-normal shadow-md shadow-yellow-300/50 transition duration-150 ease-in-out hover:bg-yellow-400 hover:shadow-yellow-400 focus:bg-yellow-500 focus:shadow-yellow-500 focus:outline-none focus:ring-0 active:bg-yellow-500 active:shadow-yellow-500">
                    <a href="{{$promocode->link}}" target="_blank" class="text-black">Перейти на сайт</a>
                  </div>  
              </div>
              </div>  
              @endforeach
              <button class="inline-block mt-6 rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2"
              type="button" data-twe-collapse-init data-twe-ripple-init data-twe-ripple-color="light" data-twe-target="#collapseRules" aria-expanded="false" aria-controls="collapseRules">Где и как применяется бонус</button>
              <div class="!visible hidden text-center text-white mt-8"
              id="collapseRules"
              data-twe-collapse-item>
              {!!$card->rules!!}
            </div>
            </div>
        </section>
        <script>
          function copyToClipboard(text, button) {
              const input = document.createElement('input');
              input.setAttribute('value', text);
              document.body.appendChild(input);
              input.select();
              document.execCommand('copy');
              document.body.removeChild(input);
              button.innerHTML = '<svg class="w-10 h-10 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/></svg>';
              setTimeout(() => {
                  button.innerHTML = '<svg class="w-10 h-10 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M18 3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1V9a4 4 0 0 0-4-4h-3a1.99 1.99 0 0 0-1 .267V5a2 2 0 0 1 2-2h7Z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M8 7.054V11H4.2a2 2 0 0 1 .281-.432l2.46-2.87A2 2 0 0 1 8 7.054ZM10 7v4a2 2 0 0 1-2 2H4v6a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3Z" clip-rule="evenodd"/></svg>';
              }, 2000);
          }
      </script>
      <script>
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const modalId = this.getAttribute('data-modal-toggle');
                const modal = document.getElementById(modalId);
                
                modal.classList.toggle('hidden');
            });
        });

        document.querySelectorAll('[data-modal-hide]').forEach(button => {
            button.addEventListener('click', function(event) {
                const modalId = this.getAttribute('data-modal-hide');
                const modal = document.getElementById(modalId);
                
                modal.classList.add('hidden');
            });
        });
      </script>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Проверяем, доступен ли объект Telegram.WebApp
            if (Telegram.WebApp) {
                // Устанавливаем параметры видимости кнопки "Назад"
                Telegram.WebApp.BackButton.setParams({ is_visible: true });

                // Устанавливаем обработчик события нажатия на кнопку "Назад"
                Telegram.WebApp.BackButton.onClick(function() {
                    console.log("Кнопка 'Назад' нажата");
                    // Здесь можно добавить логику для обработки нажатия на кнопку
                });
            } else {
                console.error("Telegram.WebApp не доступен");
            }
        });
    </script>
@endsection