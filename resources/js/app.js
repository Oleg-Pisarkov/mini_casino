import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('coinTossForm');
    const resultDiv = document.getElementById('result');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        // Собираем данные формы
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        try {
            const response = await fetch('/coin-toss', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            // Формируем сообщение о результате
            let message = `
                <p><strong>Ваша ставка:</strong> ${result.bet} ₽</p>
                <p><strong>Ваш выбор:</strong> ${result.userChoice === 'heads' ? 'Орёл' : 'Решка'}</p>
                <p><strong>Результат:</strong> ${result.result === 'heads' ? 'Орёл' : 'Решка'}</p>
            `;

            if (result.win) {
                message += `<p class="win"><strong>Вы выиграли!</strong> Ваш выигрыш: ${result.winnings} ₽</p>`;
            } else {
                message += `<p class="lose"><strong>Вы проиграли.</strong> Потеряно: ${result.bet} ₽</p>`;
            }

            resultDiv.innerHTML = message;

        } catch (error) {
            resultDiv.innerHTML = '<p class="error">Ошибка при выполнении запроса. Попробуйте ещё раз.</p>';
            console.error('Ошибка:', error);
        }
    });
});
