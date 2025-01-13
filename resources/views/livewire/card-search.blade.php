<div>
    <div class="p-6">
        <div class="relative">
            <input type="text" wire:model="search" placeholder="Поиск..." class="w-full p-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" autocomplete="off"/>
            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 pl-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 50 50" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M 21 3 C 11.601563 3 4 10.601563 4 20 C 4 29.398438 11.601563 37 21 37 C 24.355469 37 27.460938 36.015625 30.09375 34.34375 L 42.375 46.625 L 46.625 42.375 L 34.5 30.28125 C 36.679688 27.421875 38 23.878906 38 20 C 38 10.601563 30.398438 3 21 3 Z M 21 7 C 28.199219 7 34 12.800781 34 20 C 34 27.199219 28.199219 33 21 33 C 13.800781 33 8 27.199219 8 20 C 8 12.800781 13.800781 7 21 7 Z"></path>
                </svg>
            </div>
        </div>
    </div>
    <div>
        @if($search)
            @if($cards->isEmpty())
                <h1 class="text-xl text-gray-100 font-bold text-center">Ничего не найдено :(</h1>
                <h1 class="text-xl text-gray-100 font-bold text-center">Вот всё, что у нас есть:</h1>
            @else
                <h1 class="text-2xl text-gray-100 font-bold text-center">Результаты поиска:</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
                    @foreach($cards as $card)
                    <div class="card-item bg-gradient-to-br from-[#2e2e2e] to-[#3a372d] rounded-md flex border border-zinc-900" style="-webkit-mask-image: radial-gradient(circle at right 8.5px bottom 68px, transparent 8.5px, rgb(255, 255, 255) 8.75px), radial-gradient(circle closest-side at 50% center, rgb(255, 255, 255) 99%, transparent 100%); -webkit-mask-size: 100%, 8.5px 5px; -webkit-mask-repeat: repeat, repeat-x; -webkit-mask-position: 8.5px center, 50% calc(100% - 65px); -webkit-mask-composite: source-out;">
                        <img src="{{url('storage/' . $card->image)}}" alt="Логотип магазина 1" class="w-24 h-24 object-cover p-4 rounded-full">
                        <div class="w-full p-4 flex flex-col justify-between">
                            <div class="flex justify-between item-center">
                                <h2 class="text-xl text-gray-100 font-bold">{{$card->title}}</h2>
                                <div class="flex flex-row space-x-1">
                                    @foreach ($card->stamps as $stamp)
                                    <div class="bg-gray-200 px-1 py-1 rounded-full" data-twe-toggle="tooltip" data-twe-placement="top" data-twe-ripple-init data-twe-ripple-color="light" title="{{$stamp->title}}">
                                        <svg class="w-5 h-5" style="color: #{{$stamp->color}};" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="{{$stamp->icon}}"/>
                                        </svg>                                                        
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <div class="w-24 h-px bg-gray-300 my-1"></div>
                                <p class="text-xs text-gray-400">{{$card->category->title}}</p>
                            </div>
                            <div class="flex flex-row space-x-2 mt-8 justify-end">
                                <a href="{{route('card.show', $card->id)}}" class="text-center font-bold bg-yellow-500 text-black px-4 py-2 rounded-full hover:bg-yellow-600">Подробнее</a>
                                {{-- <a href="#" class="text-center bg-yellow-200 text-black px-6 py-2 rounded-full hover:bg-yellow-600">
                                    <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="m12.75 20.66 6.184-7.098c2.677-2.884 2.559-6.506.754-8.705-.898-1.095-2.206-1.816-3.72-1.855-1.293-.034-2.652.43-3.963 1.442-1.315-1.012-2.678-1.476-3.973-1.442-1.515.04-2.825.76-3.724 1.855-1.806 2.201-1.915 5.823.772 8.706l6.183 7.097c.19.216.46.34.743.34a.985.985 0 0 0 .743-.34Z"/>
                                    </svg>                                                   
                                </a> --}}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <h1 class="text-2xl text-gray-100 font-bold text-center">Все магазины:</h1>
            @endif
        @endif
    </div>
</div>
