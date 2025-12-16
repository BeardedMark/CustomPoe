<div class="flex-col back-color-dark decor-area over-hidden" style="margin-bottom: -5px">
    @if ($rule->getStyles())
        <section class="back-color-dark pos-rel over-hidden flex-center pad-34">
            <div class="pos-abs-fill z-0">
                <img class="temp-img-cover" src="{{ asset('img/bg/library.jpg') }}">
            </div>

            <div class="z-1">
                @component('resources.filters.components.example', compact('rule'))
                @endcomponent
            </div>

        </section>
        <img src="{{ asset('img/decor/cut.png') }}">
    @endif

    <div class="flex-col-8 flex-center font-center pad-13">
        @if (isset($rule->arrays->rarity) || $rule->getClass() || $rule->getBaseType())
            <div class="flex-col">
                @isset($rule->arrays->rarity)
                    <p class="font-color-second ">{{ implode(', ', $rule->arrays->rarity) }}</p>
                @endisset

                @if ($rule->getClass())
                    <p class="font-size">{{ implode(', ', $rule->getClass()) }}</p>
                @endif

                @if ($rule->getBaseType())
                    <p class="font-color-second font-size-sm">{{ implode(', ', $rule->getBaseType()) }}</p>
                @endif
            </div>
        @endif

        <div class="flex-col">
            @if ($rule->getHasInfluence())
                <div class="flex-col">
                    <p>Влияние: <span
                            class="decor-link active">{{ count($rule->getHasInfluence()) > 1 ? count($rule->getHasInfluence()) : implode(', ', $rule->getHasInfluence()) }}</span>
                    </p>

                    @if (count($rule->getHasInfluence()) > 1)
                        <p class="font-color-second font-size-sm">{{ implode(', ', $rule->getHasInfluence()) }}</p>
                    @endif
                </div>
            @endif

            @if ($rule->getHasExplicitMod()->array)
                <div class="flex-col">
                    <p>Свойства: <span class="decor-link active">{{ count($rule->getHasExplicitMod()->array) }}</span>
                    </p>
                    <p class="font-color-second font-size-sm">{{ implode(', ', $rule->getHasExplicitMod()->array) }}
                    </p>
                </div>
            @endif

            {{-- @if ($rule->getHasEnchantment())
                    <div class="flex-col">
                        <p>Зачарования: <span class="decor-link active">{{ count($rule->getHasEnchantment()) }}</span>
                        </p>
                        <p class="font-color-second font-size-sm">{{ implode(', ', $rule->getHasEnchantment()) }}</p>
                    </div>
                @endif --}}

            @if ($rule->getEnchantmentPassiveNode())
                <div class="flex-col">
                    <p>Свойства дерева: <span
                            class="decor-link active">{{ count($rule->getEnchantmentPassiveNode()) }}</span></p>
                    <p class="font-color-second font-size-sm">
                        {{ implode(', ', $rule->getEnchantmentPassiveNode()) }}</p>
                </div>
            @endif

            @if ($rule->getArchnemesisMod())
                <div class="flex-col">
                    <p>Архнемезис: <span class="decor-link active">{{ count($rule->getArchnemesisMod()) }}</span>
                    </p>
                    <p class="font-color-second font-size-sm">{{ implode(', ', $rule->getArchnemesisMod()) }}</p>
                </div>
            @endif
        </div>

        <div class="flex-col">
            @if ($rule->getStackSize())
                <p>Размер стопки: <span class="decor-link active">{{ $rule->getStackSize()->title }}</span></p>
            @endif

            @if ($rule->getWidth())
                <p>Ширина: <span class="decor-link active">{{ $rule->getWidth()->title }}</span></p>
            @endif

            @if ($rule->getHeight())
                <p>Высота: <span class="decor-link active">{{ $rule->getHeight()->title }}</span></p>
            @endif

            @if ($rule->getQuality())
                <p>Качество: <span class="decor-link active">{{ $rule->getQuality()->title }}</span></p>
            @endif

            {{-- Свойства --}}

            @if ($rule->getHasExplicitMod()->numeric)
                <p>Свойств: <span
                        class="decor-link active">{{ $rule->getHasExplicitMod()->numeric->title }}</span>
                </p>
            @endif

            @if ($rule->getHasEaterOfWorldsImplicit())
                <p>Свойств пожирателя: <span
                        class="decor-link active">{{ $rule->getHasEaterOfWorldsImplicit()->title }}</span>
                </p>
            @endif

            @if ($rule->getHasSearingExarchImplicit())
                <p>Свойств Экзарха: <span
                        class="decor-link active">{{ $rule->getHasSearingExarchImplicit()->title }}</span>
                </p>
            @endif

            @if ($rule->getCorruptedMods())
                <p>Свойств осквернения: <span class="decor-link active">{{ $rule->getCorruptedMods()->title }}</span>
                </p>
            @endif

            {{-- Уровни --}}

            @if ($rule->getItemLevel())
                <p>Уровень предмета: <span class="decor-link active">{{ $rule->getItemLevel()->title }}</span>
                </p>
            @endif

            @if ($rule->getAreaLevel())
                <p>Уровень области: <span class="decor-link active">{{ $rule->getAreaLevel()->title }}</span>
                </p>
            @endif

            @if ($rule->getDropLevel())
                <p>Уровень выпадения: <span class="decor-link active">{{ $rule->getDropLevel()->title }}</span>
                </p>
            @endif

            @if ($rule->getGemLevel())
                <p>Уровень камня: <span class="decor-link active">{{ $rule->getGemLevel()->title }}</span></p>
            @endif

            @if ($rule->getMapTier())
                <p>Уровень карты: <span class="decor-link active">{{ $rule->getMapTier()->title }}</span></p>
            @endif

            {{-- Защита --}}

            @if ($rule->getBaseArmour())
                <p>Броня: <span class="decor-link active">{{ $rule->getBaseArmour()->title }}</span></p>
            @endif

            @if ($rule->getBaseEvasion())
                <p>Уклонение: <span class="decor-link active">{{ $rule->getBaseEvasion()->title }}</span></p>
            @endif

            @if ($rule->getBaseEnergyShield())
                <p>Энергощит: <span class="decor-link active">{{ $rule->getBaseEnergyShield()->title }}</span>
                </p>
            @endif

            @if ($rule->getBaseWard())
                <p>Барьер: <span class="decor-link active">{{ $rule->getBaseWard()->title }}</span></p>
            @endif

            @if ($rule->getBaseDefencePercentile())
                <p>Процент защиты: <span
                        class="decor-link active">{{ $rule->getBaseDefencePercentile()->title }}</span></p>
            @endif

            {{-- Ячейки --}}

            @if ($rule->getLinkedSockets())
                <p>Связанных ячеек: <span class="decor-link active">{{ $rule->getLinkedSockets()->title }}</span>
                </p>
            @endif

            @if ($rule->getSocketGroup())
                <p>Всего ячеек: <span class="decor-link active">{{ $rule->getSocketGroup()->title }}</span></p>
            @endif

            @if ($rule->getSockets())
                <p>Всего ячеек: <span class="decor-link active">{{ $rule->getSockets()->title }}</span></p>
            @endif

            @if ($rule->getSocketsColor())
                <div class="flex-col">
                    <p>Цвета ячеек: <span class="decor-link active">{{ implode('', $rule->getSocketsColor()) }}</span>
                    </p>
                </div>
            @endif
        </div>

        <div class="flex-col">
            @if ($rule->getTransfiguredGem() !== null)
                <p>Измененный камень: <span
                        class="decor-link active">{{ $rule->getTransfiguredGem() ? 'да' : 'нет' }}</span></p>
            @endif

            @if ($rule->getAlternateQuality() !== null)
                <p>Альтернативное качество: <span
                        class="decor-link active">{{ $rule->getAlternateQuality() ? 'да' : 'нет' }}</span></p>
            @endif

            @if ($rule->getHasCruciblePassiveTree() !== null)
                <p>Пассивное дерево: <span
                        class="decor-link active">{{ $rule->getHasCruciblePassiveTree() ? 'да' : 'нет' }}</span>
                </p>
            @endif

            @if ($rule->getHasImplicitMod() !== null)
                <p>Собственное свойство: <span
                        class="decor-link active">{{ $rule->getHasImplicitMod() ? 'да' : 'нет' }}</span></p>
            @endif

            @if ($rule->getShaperItem() !== null)
                <p>Предмет Создателя: <span
                        class="decor-link active">{{ $rule->getShaperItem() ? 'да' : 'нет' }}</span>
                </p>
            @endif

            @if ($rule->getElderItem() !== null)
                <p>Предмет Древнего: <span class="decor-link active">{{ $rule->getElderItem() ? 'да' : 'нет' }}</span>
                </p>
            @endif

            @if ($rule->getShapedMap() !== null)
                <p>Карта Создателя: <span class="decor-link active">{{ $rule->getShapedMap() ? 'да' : 'нет' }}</span>
                </p>
            @endif

            @if ($rule->getElderMap() !== null)
                <p>Карта Древнего: <span class="decor-link active">{{ $rule->getElderMap() ? 'да' : 'нет' }}</span>
                </p>
            @endif

            @if ($rule->getBlightedMap() !== null)
                <p>Зараженная карта: <span
                        class="decor-link active">{{ $rule->getBlightedMap() ? 'да' : 'нет' }}</span>
                </p>
            @endif

            @if ($rule->getUberBlightedMap() !== null)
                <p>Убер-зараженная карта: <span
                        class="decor-link active">{{ $rule->getUberBlightedMap() ? 'да' : 'нет' }}</span>
                </p>
            @endif

            @if ($rule->getScourged() !== null)
                <p>Искаженный: <span class="decor-link active">{{ $rule->getScourged() ? 'да' : 'нет' }}</span>
                </p>
            @endif

            @if ($rule->getVeiledItem())
                <p>Завуалированно: <span class="decor-link active">{{ $rule->getVeiledItem() ? 'да' : 'нет' }}</span>
                </p>
            @endif

            @if ($rule->getReplica() !== null)
                <p>Подделка: <span class="decor-link active">{{ $rule->getReplica() ? 'да' : 'нет' }}</span>
                </p>
            @endif

            @if ($rule->getAnyEnchantment() !== null || $rule->getHasEnchantment() !== null)
                <p>Зачарованный: <span
                        class="decor-link active">{{ $rule->getAnyEnchantment() || $rule->getHasEnchantment() ? 'да' : 'нет' }}</span>
                </p>
            @endif

            @if ($rule->getFracturedItem() !== null)
                <p>Расколотый: <span class="decor-link active">{{ $rule->getFracturedItem() ? 'да' : 'нет' }}</span>
                </p>
            @endif

            @if ($rule->getSynthesisedItem() !== null)
                <p>Синтезированый: <span
                        class="decor-link active">{{ $rule->getSynthesisedItem() ? 'да' : 'нет' }}</span>
                </p>
            @endif

            @if ($rule->getIdentified() !== null)
                <p> Опознаный: <span class="decor-link active">{{ $rule->getIdentified() ? 'да' : 'нет' }}</span>
                </p>
            @endif

            @if ($rule->getCorrupted() !== null || $rule->getCorruptedMods() !== null)
                <p>Оскверненый: <span
                        class="decor-link active">{{ $rule->getCorrupted() || $rule->getCorruptedMods() ? 'да' : 'нет' }}</span>
                </p>
            @endif

            @if ($rule->getMirrored() !== null)
                <p>Отраженный: <span class="decor-link active">{{ $rule->getMirrored() ? 'да' : 'нет' }}</span></p>
            @endif
        </div>

        @isset($rule->description)
            <img src="{{ asset('img/decor/cut.png') }}">

            <div class="flex-col">
                <p class="font-color-second">{{ $rule->description }}</p>
            </div>
        @endisset

        @if (!$rule->data->visible || isset($rule->data->continue))
            <img src="{{ asset('img/decor/cut.png') }}">

            @if (!$rule->data->visible)
                <div class="flex-col">
                    <p>Отображается при нажатии на <span class="decor-link active">Alt</span></p>
                </div>
            @endif

            @isset($rule->data->continue)
                <p>Фильтровать дальше: <span class="decor-link active">{{ $rule->data->continue ? 'да' : 'нет' }}</span>
                </p>
            @endisset
        @endif
    </div>
</div>

<img src="{{ asset('img/decor/title-border-bottom.png') }}">
