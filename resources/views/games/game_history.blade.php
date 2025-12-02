@extends('layouts.app')

@section('content')
<div class="game-history">
    <h2 class="history-title">История игр</h2>

    @if($results->isEmpty())
        <p>У вас пока нет истории игр.</p>
    @else
        <table class="history-table">
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Ставка</th>
                    <th>Ваш выбор</th>
                    <th>Результат</th>
                    <th>Выигрыш</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                    <tr>
                        <td>{{ $result->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ number_format($result->bet, 2) }} ₽</td>
                        <td>{{ $result->choice === 'heads' ? 'Орёл' : 'Решка' }}</td>
                        <td>{{ $result->result === 'heads' ? 'Орёл' : 'Решка' }}</td>
                        <td>{{ number_format($result->winnings, 2) }} ₽</td>
                        <td>
                            @if($result->win)
                                <span class="status-win">Победа</span>
                            @else
                                <span class="status-lose">Поражение</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Пагинация -->
        <div class="pagination">
            {{ $results->links() }}
        </div>
    @endif
</div>
@endsection
