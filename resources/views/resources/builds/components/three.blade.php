<canvas style="min-height: 50vh" class="decor-area" id="skillTreeCanvas"></canvas>

<script>
    // ===========================
    // Инициализация переменных
    // ===========================
    let skillTree;

    let highlightedNodes = @json($build->hashes());
    let characterNodes = @json($character['passives']['hashes']);

    let charClass = "{{ $character['class'] }}";
    let buildClass = "{{ $build->class }}";

    fetch('{{ route('json.tree') }}')
        .then(response => response.json())
        .then(data => {
            skillTree = data;
            initSkillTree(skillTree);
        })
        .catch(error => console.error('Ошибка при получении данных:', error));

    // Получение данных через fetch
    // fetch('{{ route('json.tree') }}')
    //     .then(response => response.json())
    //     .then(data => {
    //         skillTree = data;
    //         initSkillTree(skillTree);
    //     })
    //     .catch(error => console.error('Ошибка при получении данных:', error));

    const orbits = [1, 6, 16, 16, 40, 72, 72]; // Количество узлов на орбитах
    const angles = {
        1: [0, 60, 120, 180, 240, 300],
        2: [0, 30, 45, 60, 90, 120, 135, 150, 180, 210, 225, 240, 270, 300, 315, 330],
        3: [0, 30, 45, 60, 90, 120, 135, 150, 180, 210, 225, 240, 270, 300, 315, 330],
        4: [...Array(40).keys()].map(i => (i * 360 / 40)),
        5: [...Array(72).keys()].map(i => (i * 360 / 72)),
        6: [...Array(72).keys()].map(i => (i * 360 / 72))
    };

    const canvas = document.getElementById('skillTreeCanvas');
    const ctx = canvas.getContext('2d');

    // ===========================
    // Инициализация дерева навыков
    // ===========================
    function initSkillTree(skillTree) {
        const minX = skillTree['min_x'];
        const minY = skillTree['min_y'];
        const maxX = skillTree['max_x'];
        const maxY = skillTree['max_y'];

        // Настройки для масштабирования и перемещения
        let scale = 1;
        let translateX = 0;
        let translateY = 0;
        let isDragging = false;
        let startX, startY;

        const groups = skillTree['groups'];
        const nodes = skillTree['nodes'];
        const width = maxX - minX; // Ширина дерева
        const height = maxY - minY; // Высота дерева

        // ===========================
        // Настройка размера канваса
        // ===========================
        function resizeCanvas() {
            canvas.width = canvas.offsetWidth;
            canvas.height = canvas.offsetHeight;

            const canvasWidth = canvas.width;
            const canvasHeight = canvas.height;
            const scaleX = canvasWidth / width;
            const scaleY = canvasHeight / height;
            scale = Math.min(scaleX, scaleY) * 0.9; // Добавляем запас

            translateX = (canvasWidth - (width * scale)) / 2 - minX * scale;
            translateY = (canvasHeight - (height * scale)) / 2 - minY * scale;

            drawSkillTree(skillTree); // Перерисовываем дерево при изменении размера
        }

        // ===========================
        // Работа с координатами
        // ===========================
        function getWorldCoordinates(mouseX, mouseY) {
            return {
                worldX: (mouseX - translateX) / scale,
                worldY: (mouseY - translateY) / scale
            };
        }

        // ===========================
        // Обработчики событий
        // ===========================
        canvas.addEventListener('wheel', function(event) {
            event.preventDefault();
            const zoomFactor = 0.2;
            const mouseX = event.offsetX;
            const mouseY = event.offsetY;

            const {
                worldX,
                worldY
            } = getWorldCoordinates(mouseX, mouseY);

            // Обновляем масштаб
            scale *= (event.deltaY <= 0) ? (1 + zoomFactor) : (1 - zoomFactor);

            // Пересчитываем смещения
            translateX = mouseX - worldX * scale;
            translateY = mouseY - worldY * scale;

            drawSkillTree(skillTree);
        });

        canvas.addEventListener('mousedown', function(event) {
            isDragging = true;
            startX = event.offsetX - translateX;
            startY = event.offsetY - translateY;
        });

        canvas.addEventListener('mousemove', function(event) {
            if (isDragging) {
                translateX = event.offsetX - startX;
                translateY = event.offsetY - startY;
                drawSkillTree(skillTree);
            }
        });

        canvas.addEventListener('mouseup', function() {
            isDragging = false;
        });

        canvas.addEventListener('mouseout', function() {
            isDragging = false;
        });

        // ===========================
        // Функция отрисовки дерева
        // ===========================
        function drawSkillTree(skillTree) {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            const size = (scale * 110);

            // Функция для получения координат узла
            function getNodeCoordinates(node) {
                const group = groups[node['group']];
                const groupX = (group['x'] * scale) + translateX;
                const groupY = (group['y'] * scale) + translateY;
                const radius = node['orbit'] * size;
                const orbitAngles = angles[node['orbit']] || [0];
                const angleDeg = orbitAngles[node['orbitIndex']] - 90;
                const angleRad = angleDeg * (Math.PI / 180);

                // Координаты узла на орбите
                const x = groupX + radius * Math.cos(angleRad);
                const y = groupY + radius * Math.sin(angleRad);

                return {
                    x,
                    y
                };
            }

            // Сначала рисуем линии между узлами
            for (let nodeKey in nodes) {
                const node = nodes[nodeKey];
                const fromGroup = node['group'];
                const fromOrbit = node['orbit'];

                if (node['group'] && node['out'] && (!node['isMastery'])) {
                    const fromPos = getNodeCoordinates(node);

                    const allNodes = node['out'].concat(node['in']);

                    allNodes.forEach(outNodeKey => {
                        const targetNode = nodes[outNodeKey];

                        if (targetNode && targetNode['group'] && (node['ascendancyName'] === targetNode[
                                'ascendancyName'])) {
                            const toPos = getNodeCoordinates(targetNode);
                            ctx.strokeStyle = '#191919';
                            ctx.lineWidth = 2;

                            // Проверка на выделенные узлы
                            const isNodeHighlighted = highlightedNodes.includes(Number(nodeKey)) &&
                                highlightedNodes
                                .includes(Number(outNodeKey));
                            const isNodeCharacter = characterNodes.includes(Number(nodeKey)) && characterNodes
                                .includes(Number(outNodeKey));

                            if ((isNodeHighlighted && !isNodeCharacter) || (node['ascendancyName'] ===
                                    buildClass)) {
                                ctx.strokeStyle = '#5b554f';
                            }
                            if (!isNodeHighlighted && isNodeCharacter || (node['ascendancyName'] ===
                                    charClass)) {
                                ctx.strokeStyle = '#C34343';
                            }
                            if ((isNodeHighlighted && isNodeCharacter) || (node['ascendancyName'] ===
                                    buildClass && buildClass === charClass)) {
                                ctx.strokeStyle = '#7DA226';
                            }
                            if (
                                characterNodes.includes(Number(nodeKey)) &&
                                highlightedNodes.includes(Number(outNodeKey)) &&
                                !characterNodes.includes(Number(
                                    outNodeKey))
                            ) {
                                ctx.strokeStyle = '#D99F15'
                            }

                            if (fromGroup === targetNode['group'] && fromOrbit === targetNode['orbit']) {
                                const group = groups[targetNode['group']];
                                const centerX = (group['x'] * scale) + translateX;
                                const centerY = (group['y'] * scale) + translateY;
                                const radius = node['orbit'] * size;

                                const startAngle = Math.atan2(fromPos.y - centerY, fromPos.x - centerX);
                                const endAngle = Math.atan2(toPos.y - centerY, toPos.x - centerX);

                                // Вычисляем разницу между углами
                                let angleDiff = endAngle - startAngle;

                                // Приводим разницу углов к диапазону от -π до π
                                if (angleDiff >= Math.PI) {
                                    angleDiff -= 2 * Math.PI;
                                } else if (angleDiff < -Math.PI) {
                                    angleDiff += 2 * Math.PI;
                                }

                                // Если угол в положительном диапазоне, рисуем по часовой стрелке, иначе — против часовой стрелки
                                const clockwise = angleDiff > 0;

                                // Рисуем дугу
                                ctx.beginPath();
                                ctx.arc(centerX, centerY, radius, startAngle, endAngle, !clockwise);
                                ctx.stroke();
                            } else {
                                ctx.beginPath();
                                ctx.moveTo(fromPos.x, fromPos.y);
                                ctx.lineTo(toPos.x, toPos.y);
                                ctx.stroke();
                            }
                        }
                    });
                }
            }

            // Теперь рисуем сами узлы
            for (let nodeKey in nodes) {
                const node = nodes[nodeKey];
                if (node['group']) {
                    const {
                        x,
                        y
                    } = getNodeCoordinates(node);


                    const isNodeHighlighted = highlightedNodes.includes(Number(nodeKey)); // Нужен по билду
                    const isNodeCharacter = characterNodes.includes(Number(nodeKey)); // Уже взят персонажем

                    // Проверка на следующий узел для прокачки
                    const allNodes = node['out'].concat(node['in']);
                    allNodes.forEach(outNodeKey => {
                        const isNext = (
                            isNodeCharacter && // Текущий узел уже взят персонажем
                            highlightedNodes.includes(Number(outNodeKey)) &&
                            // Следующий узел нужен по билду
                            !characterNodes.includes(Number(outNodeKey)) // Следующий узел еще не взят
                        );

                        // Если это следующий узел для прокачки, подсвечиваем его
                        if (isNext) {
                            const nextNode = nodes[outNodeKey];
                            const {
                                x: nextX,
                                y: nextY
                            } = getNodeCoordinates(nextNode);

                            ctx.beginPath();
                            ctx.fillStyle = '#D99F15'; // Подсветка следующего узла (например, желтым)

                            let nextNodeSize = 2;
                            if (nextNode['isJewelSocket']) nextNodeSize = 3;
                            if (nextNode['isMastery'] || nextNode['isNotable'] || nextNode['isBlighted'])
                                nextNodeSize = 5;
                            if (nextNode['isKeystone']) nextNodeSize = 8;
                            if (nextNode['isAscendancyStart']) nextNodeSize = 12;

                            // Рисуем заливку следующего узла
                            ctx.arc(nextX, nextY, nextNodeSize * (scale * 10), 0, 2 * Math.PI);
                            ctx.fill();
                        }
                    });

                    ctx.beginPath();
                    // Цвет по умолчанию для неактивных узлов
                    ctx.fillStyle = 'transparent';

                    // Узел взят персонажем и нужен по билду
                    if (isNodeHighlighted && isNodeCharacter) {
                        ctx.fillStyle = '#7DA226'; // Зеленый для активных узлов по билду
                    }
                    // Узел нужен по билду, но не взят персонажем
                    else if (isNodeHighlighted && !isNodeCharacter) {
                        ctx.fillStyle = '#5b554f'; // Темно-серый для узлов, нужных по билду, но не взятых
                    }
                    // Узел взят персонажем, но не нужен по билду
                    else if (!isNodeHighlighted && isNodeCharacter) {
                        ctx.fillStyle = '#C34343'; // Красный для уже взятых ненужных узлов
                    }

                    // Определение размера узла для текущего
                    let nodeSize = 2;
                    if (node['isJewelSocket']) nodeSize = 3;
                    if (node['isMastery'] || node['isNotable'] || node['isBlighted']) nodeSize = 5;
                    if (node['isKeystone']) nodeSize = 8;
                    if (node['isAscendancyStart']) nodeSize = 12;

                    // Рисуем заливку текущего узла
                    ctx.arc(x, y, nodeSize * (scale * 10), 0, 2 * Math.PI);
                    ctx.fill();
                }
            }

        }




        // ===========================
        // События окна
        // ===========================
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas(); // Изначальная отрисовка
    }
</script>
