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

        // 1. Запускаем анимацию
        const coin = document.getElementById('coin');
        coin.addEventListener('animationend', () => {
            coin.style.animation = 'none'; // Убираем анимацию после завершения
        });
        coin.style.animation = 'coinFlip 1s ease';

        // 2. Ждём завершения анимации (3 секунды)
        await new Promise((resolve) => setTimeout(resolve, 3000));

        // Собираем данные формы
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        try {
            // Отправляем запрос на сервер
            const response = await fetch('/coin-toss', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(data),
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

            if (result.result === 'heads') {
                coin.innerHTML = ` <svg xml:space="preserve" width="800" height="800" viewBox="0 0 800 800">
  <path d="M256 512A255 255 0 0 0 437 75C387 25 322 0 256 0z" style="opacity:.06;fill:#040000"/>
  <path d="M256 512a256 256 0 1 1 1-513 256 256 0 0 1-1 513" style="fill:#f8d176"/>
  <g style="opacity:.2">
    <path d="M332 279q-4-12-13-20-7-7-17-11-9-5-24-6h-2l-24-4-16-5-4-3-5-8-1-8a26 26 0 0 1 10-21q9-6 23-6l23 2q12 3 22 13l26-27a82 82 0 0 0-54-24 148 148 0 0 0-40 2 77 77 0 0 0-31 15q-11 9-15 21-6 12-5 27 0 27 15 42 8 8 18 12l24 6 26 4 12 3 8 5q6 6 6 18t-9 20l-9 4q-9 3-20 3a103 103 0 0 1-29-4q-13-4-23-15l-28 28q16 16 35 22a126 126 0 0 0 44 7 116 116 0 0 0 32-5q15-4 26-13a59 59 0 0 0 23-48q-1-15-4-26" style="fill:#fff"/>
    <path d="M276 151v37l-17-1q-14 0-23 6v-42a20 20 0 0 1 34-14 20 20 0 0 1 6 14m0 91v40l-8-2-26-4-6-1v-42l4 2 12 3zm-20 91q12 0 20-3v39q-2 18-20 20-17-2-20-20v-38z" style="fill:#fff"/>
  </g>
  <g style="opacity:.5">
    <path d="M256 473a217 217 0 1 1 0-434 217 217 0 0 1 0 434m0-378a162 162 0 1 0 0 323 162 162 0 0 0 0-323" style="fill:#c69949"/>
  </g>
  <path d="m184 82 2 6v3l-1 2-5 5-4 1-6-2-1-2-2-3-3-9v-2l1-2 5-6h4l6 2 1 2 2 2zm-5 2-2-5-1-1h-4l-3 2v3l1 2 4 8 1 1h3a4 4 0 0 0 3-5l-1-2zm29 5-14-13 4 16-5 1-7-25 5-1 14 12-4-15 4-1 7 25zm10-2-4-26 17-2 1 4-12 2 1 6 10-2v5l-10 1 1 7 12-2 1 4zm48-21v3l-5 4-4 1h-5v10h-5V57l11 1h3a8 8 0 0 1 5 8m-5 0-1-3-3-1h-5v7h5l3-1zm9 18 3-26 17 2-1 5-12-2-1 6 11 1-1 5-10-1-1 6 12 1v5zm36 6-6-18-4 16-5-1 6-26 4 1 7 18 3-15 5 1-5 25zm24 8-4-19-6 15-4-1 9-25 4 2 4 18 6-15 5 2-10 25zm23-1-5 9-4-2 5-10-1-17 5 3v11l9-7 5 2zm-22 336-2-6v-3l1-2 5-5 4-1 6 2 2 2 1 2 3 9v5l-6 5-4 1-6-2-1-2-2-2zm5-2 2 4 1 2h4l3-2v-5l-5-8v-1h-4a4 4 0 0 0-3 5l1 2zm-29-5 14 13-4-16 5-1 7 25-4 1-15-12 5 15-5 1-7-25zm-10 2 4 26-17 2v-4l12-2-1-6-11 1v-4l10-2-1-6-12 2-1-5zm-48 21 1-3 4-4 4-1h5v-10h5v26h-14l-4-5zm5 0 1 3 3 1h5v-7h-5l-3 1zm-8-18-3 26-18-2 1-5 12 2 1-6-11-1 1-5 10 1 1-6-12-2v-4zm-37-6 7 18 3-16 5 1-6 26-4-1-7-18-3 15-5-1 6-25zm-24-8 4 19 6-16 5 2-9 25-5-2-4-18-6 15-4-2 9-25zm-23 1 5-9 4 2-4 9v18l-5-3v-11l-9 7-5-3z" style="fill:#f8d176"/>
  <path d="M332 274q-4-11-13-19-7-8-17-11-9-4-24-6l-2-1-24-3-16-5-4-3-5-8-1-8a26 26 0 0 1 10-21q9-6 23-6l23 2q12 3 22 13l26-27a82 82 0 0 0-54-25 148 148 0 0 0-40 2 77 77 0 0 0-31 16q-11 9-15 21-6 12-5 27 0 27 15 42 8 8 18 12l24 6 26 4 12 3 8 4q6 8 6 18 0 14-9 20l-9 5q-9 3-20 2a103 103 0 0 1-29-3q-13-5-23-15l-28 28q16 15 35 22a126 126 0 0 0 44 6 116 116 0 0 0 32-4q15-4 26-13a59 59 0 0 0 23-49q-1-14-4-26" style="fill:#d9ae56"/>
  <path d="M276 147v37l-17-1q-14 0-23 6v-42a20 20 0 0 1 34-14 20 20 0 0 1 6 14m0 90v40l-8-1-26-4-6-1v-42l4 2 12 3zm-20 91q12 0 20-2v39q-2 18-20 20-17-2-20-20v-38z" style="fill:#d9ae56"/>
  <circle cx="66" cy="256" r="9.6" style="fill:#f8d176"/>
  <circle cx="444.1" cy="256" r="9.6" style="fill:#f8d176"/>
  <path d="M256 512A255 255 0 0 0 437 75C387 25 322 0 256 0z" style="opacity:.06;fill:#040000"/>
</svg>`;
            } else {
                coin.innerHTML = `<svg xml:space="preserve" width="800" height="800" viewBox="0 0 800 800">
  <path d="M256 512a256 256 0 1 1 1-513 256 256 0 0 1-1 513" style="fill:#e0f1ef"/>
  <g style="opacity:.2">
    <path d="M332 279q-4-12-13-20-7-7-17-11-9-5-24-6h-2l-24-4-16-5-4-3-5-8-1-8a26 26 0 0 1 10-21q9-6 23-6l23 2q12 3 22 13l26-27a82 82 0 0 0-54-24 148 148 0 0 0-40 2 77 77 0 0 0-31 15q-11 9-15 21-6 12-5 27 0 27 15 42 8 8 18 12l24 6 26 4 12 3 8 5q6 6 6 18t-9 20l-9 4q-9 3-20 3a103 103 0 0 1-29-4q-13-4-23-15l-28 28q16 16 35 22a126 126 0 0 0 44 7 116 116 0 0 0 32-5q15-4 26-13a59 59 0 0 0 23-48q-1-15-4-26" style="fill:#fff"/>
    <path d="M276 151v37l-17-1q-14 0-23 6v-42a20 20 0 0 1 34-14 20 20 0 0 1 6 14m0 91v40l-8-2-26-4-6-1v-42l4 2 12 3zm-20 91q12 0 20-3v39q-2 18-20 20-17-2-20-20v-38z" style="fill:#fff"/>
  </g>
  <g style="opacity:.5">
    <path d="M256 473a217 217 0 1 1 0-434 217 217 0 0 1 0 434m0-378a162 162 0 1 0 0 323 162 162 0 0 0 0-323" style="fill:#99948a"/>
  </g>
  <path d="m184 82 2 6v3l-1 2-5 5-4 1-6-2-1-2-2-3-3-9v-2l1-2 5-6h4l6 2 1 2 2 2zm-5 2-2-5-1-1h-4l-3 2v3l1 2 4 8 1 1h3a4 4 0 0 0 3-5l-1-2zm29 5-14-13 4 16-5 1-7-25 5-1 14 12-4-15 4-1 7 25zm10-2-4-26 17-2 1 4-12 2 1 6 10-2v5l-10 1 1 7 12-2 1 4zm48-21v3l-5 4-4 1h-5v10h-5V57l11 1h3a8 8 0 0 1 5 8m-5 0-1-3-3-1h-5v7h5l3-1zm9 18 3-26 17 2-1 5-12-2-1 6 11 1-1 5-10-1-1 6 12 1v5zm36 6-6-18-4 16-5-1 6-26 4 1 7 18 3-15 5 1-5 25zm24 8-4-19-6 15-4-1 9-25 4 2 4 18 6-15 5 2-10 25zm23-1-5 9-4-2 5-10-1-17 5 3v11l9-7 5 2zm-22 336-2-6v-3l1-2 5-5 4-1 6 2 2 2 1 2 3 9v5l-6 5-4 1-6-2-1-2-2-2zm5-2 2 4 1 2h4l3-2v-5l-5-8v-1h-4a4 4 0 0 0-3 5l1 2zm-29-5 14 13-4-16 5-1 7 25-4 1-15-12 5 15-5 1-7-25zm-10 2 4 26-17 2v-4l12-2-1-6-11 1v-4l10-2-1-6-12 2-1-5zm-48 21 1-3 4-4 4-1h5v-10h5v26h-14l-4-5zm5 0 1 3 3 1h5v-7h-5l-3 1zm-8-18-3 26-18-2 1-5 12 2 1-6-11-1 1-5 10 1 1-6-12-2v-4zm-37-6 7 18 3-16 5 1-6 26-4-1-7-18-3 15-5-1 6-25zm-24-8 4 19 6-16 5 2-9 25-5-2-4-18-6 15-4-2 9-25zm-23 1 5-9 4 2-4 9v18l-5-3v-11l-9 7-5-3z" style="fill:#e0f1ef"/>
  <path d="M332 274q-4-11-13-19-7-8-17-11-9-4-24-6l-2-1-24-3-16-5-4-3-5-8-1-8a26 26 0 0 1 10-21q9-6 23-6l23 2q12 3 22 13l26-27a82 82 0 0 0-54-25 148 148 0 0 0-40 2 77 77 0 0 0-31 16q-11 9-15 21-6 12-5 27 0 27 15 42 8 8 18 12l24 6 26 4 12 3 8 4q6 8 6 18 0 14-9 20l-9 5q-9 3-20 2a103 103 0 0 1-29-3q-13-5-23-15l-28 28q16 15 35 22a126 126 0 0 0 44 6 116 116 0 0 0 32-4q15-4 26-13a59 59 0 0 0 23-49q-1-14-4-26" style="fill:#b7c1b4"/>
  <path d="M276 147v37l-17-1q-14 0-23 6v-42a20 20 0 0 1 34-14 20 20 0 0 1 6 14m0 90v40l-8-1-26-4-6-1v-42l4 2 12 3zm-20 91q12 0 20-2v39q-2 18-20 20-17-2-20-20v-38z" style="fill:#b7c1b4"/>
  <circle cx="66" cy="256" r="9.6" style="fill:#e0f1ef"/>
  <circle cx="444.1" cy="256" r="9.6" style="fill:#e0f1ef"/>
  <path d="M256 512A255 255 0 0 0 437 75C387 25 322 0 256 0z" style="opacity:.06;fill:#040000"/>
</svg>`;
            }

            // Формируем сообщение о результате игры
            let message = `
                <p><strong>Ваша ставка:</strong> ${result.bet.toFixed(2)} ₽</p>
                <p><strong>Ваш выбор:</strong> ${result.userChoice === 'heads' ? 'Орёл' : 'Решка'}</p>
                <p><strong>Результат:</strong> ${result.result === 'heads' ? 'Орёл' : 'Решка'}</p>
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
            resultDiv.scrollIntoView({
                behavior: 'smooth',
                block: 'start',
                inline: 'nearest',
            });
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
