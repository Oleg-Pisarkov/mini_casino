@extends('layouts.app')

@section('title', 'Орёл или решка')

@section('content')
<section class="game">
    <h2>Орёл или решка</h2>


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
           <p><strong>Ваш баланс:</strong> <span id="balance-form">{{ number_format(Auth::user()->balance, 2) }} ₽</span></p>
            <div class="form-group">
                <label>Ваш выбор:</label>
                <div class="choices">
                    <label><input type="radio" name="choice" value="heads" checked> Орёл</label>
                    <label><input type="radio" name="choice" value="tails"> Решка</label>
                </div>
            </div>
            <button type="submit">Бросить монету</button>
        </form>
    @endguest


    <div id="result" class="result"></div>
</section>
@endsection
