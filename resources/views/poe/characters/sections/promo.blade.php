<section class="pad-y-98">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="row">
                <div class="col col-12 col-lg">
                    <div class="flex-col-13">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold">Ваши персонажи</h2>
                            <p class="font-color-second">Информация по вашим игровым персонажам</p>
                        </div>

                        <div class="flex-col-8 pad-13 decor-area">
                            <p><span class="font-color-second">Всего пероснажей :</span> {{ count($characters) }}</p>
                            <p><span class="font-color-second">Частый класс :</span> {{ array_search(max(array_count_values(array_column($characters, 'class'))), array_count_values(array_column($characters, 'class'))) }}</p>
                            <p><span class="font-color-second">Максимальный уровень :</span> {{ max(array_column($characters, 'level')); }}</p>
                            <p><span class="font-color-second">Средний уровень :</span> {{ ceil(array_sum(array_column($characters, 'level')) / count($characters)) }}</p>
                            <p><span class="font-color-second">Минимальный уровень :</span> {{ min(array_column($characters, 'level')); }}</p>
                        </div>

                        <div class="flex-row-13">
                            <a class="decor-btn" href="{{ route('characters.index') }}">Все персонажи</a>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col-13">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold">Текущий персонаж</h2>
                            <p class="font-color-second">Последний активный в игре персонаж</p>
                        </div>

                        @foreach ($characters as $character)
                            @isset($character['current'])
                                @component('poe.characters.components.card', compact('character'))
                                @endcomponent
                            @endisset
                        @endforeach

                        <p class="font-color-warning">На имя данного персонажа будут приходить сообщения в игре</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
