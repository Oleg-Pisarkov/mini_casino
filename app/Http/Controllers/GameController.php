<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * Обработка броска монеты
     */
    public function coinToss(Request $request)
{
    // Валидация ставки
    $request->validate([
        'bet' => 'required|numeric|min:1|max:1000',
    ]);

    $bet = (float)$request->input('bet');
    $userChoice = $request->input('choice'); // 'heads' или 'tails'

    // Получаем текущего пользователя
    $user = Auth::user();

    // Проверяем, хватает ли баланса
    if ($user->balance < $bet) {
        return response()->json([
            'error' => 'Недостаточно средств на балансе.',
            'balance' => $user->balance,
        ], 400);
    }

    // Генерация результата (0 — орёл, 1 — решка)
    $result = rand(0, 1);
    $win = ($result === 0 && $userChoice === 'heads') ||
            ($result === 1 && $userChoice === 'tails');

    $winnings = $win ? $bet * 2 : 0;

    // Обновляем баланс: списываем ставку, начисляем выигрыш
    $user->balance -= $bet;
    if ($win) {
        $user->balance += $winnings;
    }
    $user->save();

    // Сохраняем результат в БД
    Result::create([
        'user_id' => $user->id,
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
        'bet' => $bet,
        'balance' => $user->balance, // Отправляем новый баланс
    ]);
}

    /**
     * Отображение истории игр текущего пользователя
     */
    public function showHistory(Request $request)
    {
        // Получаем историю игр текущего пользователя (сортировка по дате, новые сверху)
        $results = Result::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10); // 10 записей на страницу

        // Возвращаем представление с данными
        return view('games.game_history', compact('results'));
    }
}
