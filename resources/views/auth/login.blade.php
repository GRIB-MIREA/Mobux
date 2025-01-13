@extends('layouts.app')

@section('content')
<main class="container mx-auto p-4 mt-12 flex flex-col items-center border-2 rounded-lg justify-center text-black">
    <div class="w-10/12 sm:w-8/12 md:w-6/12 lg:w-5/12 xl:w-4/12 mb-4">
        <h1 class="text-4xl font-semibold">Авторизируйтесь</h1>
    </div>
    <div class="w-10/12 sm:w-8/12 md:w-6/12 lg:w-5/12 xl:w-4/12 mb-6">
        <form method="POST" action="{{ route('login') }}">
        @csrf
            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>
            <input id="email" type="email" class="mb-4 p-2 appearance-none block w-full bg-gray-200 text-black placeholder-gray-900 rounded border focus:border-teal-500 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>    
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <label for="password" class="col-md-4 col-form-label text-md-end">Пароль</label>
            <input id="password" type="password" class="mb-4 p-2 appearance-none block w-full bg-gray-200 text-black placeholder-gray-900 rounded border focus:border-teal-500 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="flex items-center">
                <div class="w-1/2 flex items-center">
                    <input name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} type="checkbox" class="mt-1 mr-2" />
                    <label for="remember-me">Запомнить меня!</label>
                </div>
                <button class="ml-auto w-1/2 bg-gray-800 text-white p-2 rounded font-semibold hover:bg-gray-900" type="submit">Войти</button>
            </div>
        </form>    
    </div>
</main>
@endsection
