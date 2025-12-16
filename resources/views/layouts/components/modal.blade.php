<!-- modal.blade.php -->

<!-- CSS стили -->
@push('styles')
    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-window {
            max-width: 400px;
        }
    </style>
@endpush

<!-- Контейнер для модальных окон -->
<div id="modal-container"></div>

<!-- JS Скрипт -->
@push('scripts')
    <script>
        function createModal(type, message, callback = null) {
            // Создаем элементы
            let overlay = document.createElement('div');
            overlay.className = 'modal-overlay';

            let modalWindow = document.createElement('div');
            modalWindow.className = 'decor-area pad-13 font-center flex-center flex-col-13 w-auto';

            let modalMessage = document.createElement('p');
            modalMessage.innerText = message;

            let toolbar = document.createElement('div');
            toolbar.className = 'flex-center flex-row-13';

            let closeButton = document.createElement('button');
            closeButton.innerText = 'Закрыть';
            closeButton.className = 'decor-btn';

            // Добавляем элементы в DOM
            modalWindow.appendChild(modalMessage);
            modalWindow.appendChild(toolbar);
            toolbar.appendChild(closeButton);
            overlay.appendChild(modalWindow);
            document.getElementById('modal-container').appendChild(overlay);

            // Центрация окна
            overlay.style.display = 'flex';

            // Закрытие окна
            closeButton.addEventListener('click', function () {
                overlay.remove();
                if (callback) callback(false);  // для confirm или prompt
            });

            // Специфичная логика для confirm
            if (type === 'confirm') {
                let confirmButton = document.createElement('button');
                confirmButton.innerText = 'Подтвердить';
                confirmButton.className = 'decor-btn';
                toolbar.appendChild(confirmButton);

                confirmButton.addEventListener('click', function () {
                    overlay.remove();
                    if (callback) callback(true); // подтвердили действие
                });
            }

            // Специфичная логика для prompt
            if (type === 'prompt') {
                let inputField = document.createElement('input');
                inputField.type = 'text';
                inputField.placeholder = 'Введите значение';
                inputField.className = 'decor-input';
                modalWindow.insertBefore(inputField, toolbar);

                closeButton.addEventListener('click', function () {
                    overlay.remove();
                    if (callback) callback(null);  // Отмена действия
                });

                let confirmButton = document.createElement('button');
                confirmButton.innerText = 'Отправить';
                confirmButton.className = 'decor-btn';
                toolbar.appendChild(confirmButton);

                confirmButton.addEventListener('click', function () {
                    let userInput = inputField.value;
                    overlay.remove();
                    if (callback) callback(userInput); // Возвращаем введенное значение
                });
            }
        }

        // Пример использования:
        // Alert
        // createModal('alert', 'Это alert сообщение');

        // Confirm
        // createModal('confirm', 'Вы уверены?', function(result) {
        //     if (result) {
        //         console.log('Подтверждено');
        //     } else {
        //         console.log('Отменено');
        //     }
        // });

        // Prompt
        // createModal('prompt', 'Введите свое имя:', function(value) {
        //     if (value !== null) {
        //         console.log('Вы ввели: ' + value);
        //     } else {
        //         console.log('Отменено');
        //     }
        // });
    </script>
@endpush



{{-- 
Route::get('/popup', function () {
    return view('layouts.components.popup');
});

<div id="popup-overlay" class="popup-overlay  flex-center pos-fixed pos-fluid">
    <div class="decor-area flex-center flex-col-13 w-auto pad-13">
        <h2>{{ request('title', 'Заголовок по умолчанию') }}</h2>
        <p>{{ request('message', 'Сообщение по умолчанию') }}</p>
        <button class="decor-link" onclick="closePopup()">Закрыть</button>
    </div>
</div>

@push('styles')
    <style>
        .popup-overlay {
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function showPopup(title, message) {
            fetch(`/popup?title=${encodeURIComponent(title)}&message=${encodeURIComponent(message)}`)
                .then(response => response.text())
                .then(html => {
                    document.body.innerHTML = document.body.innerHTML + html;
                    document.getElementById('popup-overlay').style.display = 'block';
                });
        }

        function closePopup() {
            document.getElementById('popup-overlay').remove();
        }
    </script>
@endpush --}}
