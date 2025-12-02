<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result; // Импортируем модель Result для работы с БД

class GameController extends Controller
{
    public function coinToss(Request $request)
    {
        // Валидация ставки
        $request->validate([
            'bet' => 'required|numeric|min:1|max:1000',
        ]);

        $bet = (float)$request->input('bet');
        $userChoice = $request->input('choice'); // 'heads' или 'tails'

        // Генерация результата (0 — орёл, 1 — решка)
        $result = rand(0, 1);
        $win = ($result === 0 && $userChoice === 'heads') ||
                ($result === 1 && $userChoice === 'tails');

        $winnings = $win ? $bet * 2 : 0;

        // Сохраняем результат в БД
        Result::create([
            'user_id' => auth()->id(), // ID авторизованного пользователя
            'bet' => $bet,
            'choice' => $userChoice,
            'result' => $result === 0 ? 'heads' : 'tails',
            'win' => $win,
            'winnings' => $winnings,
        ]);

        return response()->json([
            'result' => $result === 0 ? 'heads' : 'tails',
            'userChoice' => $userChoice,
            'win' => $win,
            'winnings' => $winnings,
            'bet' => $bet
        ]);
    }
}
