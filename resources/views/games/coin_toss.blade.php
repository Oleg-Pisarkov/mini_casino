<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINI CASINO</title>

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
            <span>Привет, {{ auth()->user()->name }}!</span>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button class="btn-logout">Выход</button>
            </form>
        @endguest
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
    <section class="game">
        <h2>Орёл или решка</h2>

        <!-- Защита от неавторизованных пользователей -->
        @guest
            <div class="auth-prompt">
                <p>Чтобы играть, необходимо войти в аккаунт или зарегистрироваться.</p>
                <a href="{{ route('login') }}" class="btn btn-login">Войти</a>
                <a href="{{ route('register') }}" class="btn btn-register">Зарегистрироваться</a>
            </div>
        @else
            <form id="coinTossForm" action="{{ route('coin.toss') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="bet">Ваша ставка (1–1000):</label>
                    <input type="number" id="bet" name="bet" min="1" max="1000" value="10" required>
                </div>

                <div class="form-group">
                    <label>Ваш выбор:</label>
                    <div class="choices">
                        <label>
                            <input type="radio" name="choice" value="heads" checked>
                            Орёл
                        </label>
                        <label>
                            <input type="radio" name="choice" value="tails">
                            Решка
                        </label>
                    </div>
                </div>

                <button type="submit">Бросить монету</button>
            </form>
        @endguest

        <div id="result" class="result"></div>
    </section>
</main>

@vite(['resources/js/app.js'])
</body>
</html>
