document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const targetId = this.getAttribute('href').substring(1);
        const targetElement = document.getElementById(targetId);

        if (targetElement) {
            // Если элемент внутри <details>, раскрываем его
            const details = targetElement.closest('details');
            if (details) {
                details.open = true; // Раскрываем <details>
            }

            // Даём браузеру установить состояние :target автоматически
            setTimeout(() => {
                // Вычисляем положение элемента и прокручиваем, чтобы верх был в центре экрана
                const offset = targetElement.getBoundingClientRect().top + window.pageYOffset;
                const scrollPosition = offset - (window.innerHeight / 2) + (targetElement.offsetHeight / 2);

                // Плавная прокрутка
                window.scrollTo({
                    top: scrollPosition,
                    behavior: 'smooth'
                });
            }, 0); // С задержкой, чтобы дать браузеру обновить :target
        }
    });
});
