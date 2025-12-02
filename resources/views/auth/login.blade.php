<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    @vite(['resources/css/app.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <header class="header-register">
        <h1>MINI CASINO</h1>
    </header>

    <main class="container">
        <section class="auth-form">
            <h2 class="form-title">Вход</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-input" type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input class="form-input" type="password" id="password" name="password" required>
                </div>

                <button type="submit">Войти</button>

                <p class="mt-3">
                    <a href="{{ route('register') }}">Нет аккаунта? Зарегистрироваться</a>
                </p>
            </form>
        </section>
    </main>

    @vite(['resources/js/app.js'])
</body>
</html>
