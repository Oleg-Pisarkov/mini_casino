<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/', function () {
    return view('games.coin_toss');
});

Route::post('/coin-toss', [GameController::class, 'coinToss'])->name('coin.toss');
