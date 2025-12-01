<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINI CASINO</title>

    <!-- Подключение CSS через Vite -->
    @vite(['resources/css/app.css'])

    <!-- CSRF-токен для форм -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <header class="header">
        <h1>MINI CASINO</h1>
    </header>

    <main class="container">
        <section class="game">
            <h2>Орёл или решка</h2>

            <!-- Форма с CSRF-токеном -->
            <form id="coinTossForm">
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

            <div id="result" class="result"></div>
        </section>
    </main>

    <!-- Подключение JS через Vite -->
    @vite(['resources/js/app.js'])
</body>
</html>
