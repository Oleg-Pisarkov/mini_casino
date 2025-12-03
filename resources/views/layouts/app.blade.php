<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MINI CASINO')</title>
    @vite(['resources/css/app.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <header class="header">
        <nav class="auth-nav">
            @guest
                <a href="{{ route('register') }}" class="btn btn-register">Регистрация</a>
                <a href="{{ route('login') }}" class="btn btn-login">Вход</a>
            @else
            <div class="user-balance">
                Баланс: <span id="balance">{{ number_format(Auth::user()->balance, 2) }} ₽</span>
            </div>
                 @if(request()->routeIs('game.history'))
            <a href="{{ route('home') }}" class="history-link">Играть</a>
        @else
            {{-- На всех остальных страницах показываем «История игр» --}}
            <a href="{{ route('game.history') }}" class="history-link">История игр</a>
        @endif
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button class="btn-logout">Выход</button>
                </form>
            @endauth
        </nav>
        <h1>MINI CASINO</h1>
        <div class="social-icons">
            <a href="#" target="_blank">
                <img src="{{ asset('images/social/instagram.png') }}" alt="Instagram" width="30" height="30">
            </a>
            <a href="#" target="_blank">
                <img src="{{ asset('images/social/telegram.png') }}" alt="Telegram" width="30" height="30">
            </a>
            <a href="#" target="_blank">
                <img src="{{ asset('images/social/twitter.png') }}" alt="Twitter" width="30" height="30">
            </a>
            <a href="#" target="_blank">
                <img src="{{ asset('images/social/whatsapp.png') }}" alt="Whatsapp" width="30" height="30">
            </a>
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>

    @vite(['resources/js/app.js'])
</body>
</html>
