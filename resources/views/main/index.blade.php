@extends('layouts.app')
@section('content')
<main class="container mx-auto mt-10">
    <div class="right-0 p-6">
        <script async src="https://telegram.org/js/telegram-widget.js?22" data-telegram-login="mobux_bot" data-size="large" data-auth-url="https://mobux.ru/api/auth" data-request-access="write"></script>
    </div>
    <h1>MOBUX - Главная страница с описанием проекта</h1>
    <a href="{{route('bot.index')}}">Перейти в бота</a>
</main>
@endsection