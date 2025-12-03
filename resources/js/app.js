import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    // Ищем форму игры, блок результата и элемент баланса
    const form = document.getElementById('coinTossForm');
    const resultDiv = document.getElementById('result');
    const balanceElement = document.getElementById('balance');

    // Проверяем, есть ли все необходимые элементы на странице
    if (!form || !resultDiv || !balanceElement) {
        return; // Если чего-то нет — не инициализируем обработчик
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault(); // Отменяем стандартную отправку формы

        // Собираем данные формы
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        try {
            // Отправляем запрос на сервер
            const response = await fetch('/coin-toss', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });

            // Получаем ответ от сервера
            const result = await response.json();

            // Если сервер вернул ошибку (например, недостаточно средств)
            if (result.error) {
                resultDiv.innerHTML = `
                    <p class="error">${result.error}</p>
                    <p><strong>Текущий баланс:</strong> ${result.balance.toFixed(2)} ₽</p>
                `;
                return;
            }

            // Формируем сообщение о результате игры
            let message = `
                <p><strong>Ваша ставка:</strong> ${result.bet.toFixed(2)} ₽</p>
                <p><strong>Ваш выбор:</strong> ${
                    result.userChoice === 'heads' ? 'Орёл' : 'Решка'
                }</p>
                <p><strong>Результат:</strong> ${
                    result.result === 'heads' ? 'Орёл' : 'Решка'
                }</p>
            `;

            if (result.win) {
                message += `
                    <p class="win">
                        <strong>Вы выиграли!</strong>
                        Ваш выигрыш: ${result.winnings.toFixed(2)} ₽
                    </p>
                `;
            } else {
                message += `
                    <p class="lose">
                        <strong>Вы проиграли.</strong>
                        Потеряно: ${result.bet.toFixed(2)} ₽
                    </p>
                `;
            }

            // Обновляем баланс в интерфейсе
            balanceElement.textContent = `${result.balance.toFixed(2)} ₽`;
            
            // Дополнительно обновляем баланс в форме игры
const balanceFormElement = document.getElementById('balance-form');
if (balanceFormElement) {
    balanceFormElement.textContent = `${result.balance.toFixed(2)} ₽`;
}

            // Выводим результат в блок #result
            resultDiv.innerHTML = message;

        } catch (error) {
            // Обработка сетевых ошибок
            resultDiv.innerHTML = `
                <p class="error">
                    Ошибка при выполнении запроса. Проверьте подключение к интернету.
                </p>
            `;
            console.error('Ошибка запроса:', error);
        }
    });
});
