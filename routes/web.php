<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('games.coin_toss');
})->name('home');

// Маршруты авторизации
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Игра (только для авторизованных)
Route::post('/coin-toss', [GameController::class, 'coinToss'])
    ->middleware('auth')
    ->name('coin.toss');

Route::get('/game-history', [GameController::class, 'showHistory'])
    ->middleware('auth')
    ->name('game.history');
