<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('results', function (Blueprint $table) {
        $table->id(); // первичный ключ (автоматически инкрементируется)
        $table->foreignId('user_id')->constrained(); // связь с таблицей users
        $table->decimal('bet', 10, 2); // ставка (число с 2 знаками после запятой)
        $table->string('choice'); // выбор пользователя ('heads' или 'tails')
        $table->string('result'); // результат ('heads' или 'tails')
        $table->boolean('win'); // выиграл ли пользователь (true/false)
        $table->decimal('winnings', 10, 2); // выигрыш (число с 2 знаками после запятой)
        $table->timestamps(); // поля created_at и updated_at (автоматически заполняются)
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
