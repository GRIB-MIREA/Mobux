@extends('layouts.bot')
@section('content')
        <section class="antialiased p-6">
            <div class="mx-auto px-4 2xl:px-0">
              <div class="mb-4 flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-100 sm:text-2xl">Категории:</h1>
              </div>
              @foreach ($categories as $category)
              <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 grid-cols-4 py-1">
                <a href="{{route('category.card.index', $category->id)}}" class="flex items-center rounded-lg px-4 py-2 gradient-hover" data-twe-ripple-init data-twe-ripple-color="light">
                  <svg class="w-6 h-6 text-gray-100" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                  </svg>                  
                  <span class="text-sm font-medium text-gray-100">{{$category->title}}</span>
                </a>
              </div>
              @endforeach
            </div>
        </section>
        <style>
            .gradient-hover {
                background-image: linear-gradient(to right, #2e2e2e, #3a372d);
                transition: background-image 0.3s ease-in-out;
            }
        
            .gradient-hover:hover {
                background-image: linear-gradient(to right, #3a372d, #3a372d);
            }
        </style>
@endsection