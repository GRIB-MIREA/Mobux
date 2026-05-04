@extends('layouts.app')
@section('title', 'Скидки, промокоды и кэшбек - MOBUX')
@section('content')
<main class="min-h-screen overflow-hidden bg-[#101114] text-white">
    <section class="relative min-h-[calc(100vh-44px)] px-5 py-6 sm:px-8 lg:px-12">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_72%_34%,rgba(250,204,21,.22),transparent_32%),linear-gradient(135deg,#101114_0%,#191a1f_48%,#242111_100%)]"></div>
            <div class="absolute inset-x-0 bottom-0 h-44 bg-gradient-to-t from-[#101114] to-transparent"></div>
        </div>

        <div class="relative mx-auto flex min-h-[calc(100vh-92px)] max-w-7xl flex-col">
            <header class="flex items-center justify-between">
                <img src="{{ asset('assets/img/logo.png') }}" alt="MOBUX" class="h-8 w-auto sm:h-10">
                <a
                    href="{{ route('bot.index') }}"
                    class="rounded-full border border-white/15 px-4 py-2 text-sm font-semibold text-white/90 transition hover:border-yellow-300 hover:bg-yellow-300 hover:text-[#101114]"
                >
                    Открыть каталог
                </a>
            </header>

            <div class="grid flex-1 items-center gap-12 py-14 lg:grid-cols-[minmax(0,0.9fr)_minmax(380px,1fr)] lg:py-8">
                <div class="max-w-3xl">
                    <p class="mb-5 inline-flex rounded-full border border-yellow-300/30 bg-yellow-300/10 px-4 py-2 text-sm font-semibold uppercase tracking-[.22em] text-yellow-200">
                        MOBUX
                    </p>
                    <h1 class="max-w-4xl text-5xl font-black leading-[.92] text-white sm:text-7xl lg:text-8xl">
                        Все скидки тут
                    </h1>
                    <p class="mt-7 max-w-xl text-xl leading-8 text-white/72 sm:text-2xl">
                        Сотни предложений ждут вас
                    </p>
                    <div class="mt-10">
                        <a
                            href="{{ route('bot.index') }}"
                            class="inline-flex items-center justify-center rounded-full bg-yellow-300 px-7 py-4 text-base font-bold text-[#101114] shadow-[0_18px_48px_rgba(250,204,21,.26)] transition hover:-translate-y-0.5 hover:bg-yellow-200"
                        >
                            Посмотреть промокоды
                        </a>
                    </div>
                </div>

                <div class="relative flex min-h-[360px] items-end justify-center lg:min-h-[620px]">
                    <div class="absolute bottom-8 h-[68%] w-[72%] rounded-full bg-yellow-300/15 blur-3xl"></div>
                    <div class="absolute bottom-0 h-[44%] w-full max-w-[620px] rounded-[50%] bg-black/35 blur-2xl"></div>
                    <img
                        src="{{ asset('assets/img/iphone.png') }}"
                        alt="Промокоды MOBUX в телефоне"
                        class="relative z-10 max-h-[72vh] w-auto max-w-[82%] translate-y-4 object-contain drop-shadow-[0_34px_80px_rgba(0,0,0,.55)] sm:max-w-[62%] lg:max-w-[74%]"
                    >
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="border-t border-white/10 bg-[#101114] px-5 py-3 text-center text-xs text-white/45">
    <p>Разработка сайта: <a href="https://t.me/dlitvinoff" target="_blank">Litvinoff</a></p>
</footer>
@endsection
