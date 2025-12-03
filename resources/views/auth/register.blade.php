<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    @vite(['resources/css/app.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <header class="header-register">
        <h1>MINI CASINO</h1>
    </header>

    <main class="container">
        <section class="auth-form">
            <h2 class="form-title">Регистрация</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                 <div class="form-group">
                    <label for="name">Имя</label>
                    <input class="form-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                           type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           autofocus>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                           type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           required>
                    @if($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                 <div class="form-group">
                    <label for="password">Пароль (минимум 8 символов)</label>
                    <input class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                           type="password"
                           id="password"
                           name="password"
                           required>
                    @if($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                 <div class="form-group">
                    <label for="password_confirmation">Подтвердите пароль</label>
                    <input class="form-input {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                           type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           required>
                    @if($errors->has('password_confirmation'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password_confirmation') }}
                        </div>
                    @endif
                </div>

                <button type="submit">Зарегистрироваться</button>

                <p class="mt-3">
                    <a href="{{ route('login') }}">Уже есть аккаунт? Войти</a>
                </p>
            </form>
        </section>
    </main>

    @vite(['resources/js/app.js'])
</body>
</html>
