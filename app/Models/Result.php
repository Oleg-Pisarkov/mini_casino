<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    // Укажите, что модель связана с таблицей 'results'
    protected $table = 'results';

    // Укажите, какие поля можно массово присваивать (mass assignment)
    protected $fillable = ['user_id', 'bet', 'choice', 'result', 'win', 'winnings'];

    // Связь "один ко многим" с моделью User (один пользователь может иметь много результатов)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
