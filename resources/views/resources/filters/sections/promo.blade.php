<img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

<section class="back-color-dark pad-y-98 pos-rel over-hidden flex-center">
    <div class="pos-abs-fill z-0 decor-back-dark">
        <img class="temp-img-cover" src="{{ asset('img/bg/items.jpg') }}">
    </div>

    <div class="container z-1">
        <div class="row ">
            <div class="col col-12 col-lg">
                <div class="flex-col-34 font-center">
                    <div class="flex-col-8">
                        <h2 class="font-size-h2 decor-gold">Фильтры предметов</h2>
                        <p class="font-size-lg font-color-accent">Подберите приятный и удобный фильтр для игры</p>
                    </div>

                    <img src="{{ asset('img/decor/cut.png') }}">

                    <div class="row g-4 justify-content-center">
                        <div class="col col-12 col-lg-4">
                            @component('pages.components.iconblock', [
                                'title' => 'Глобальные изменения',
                                'description' => 'Управляйте параметрами фильтров с одного места',
                            ])
                            @endcomponent
                        </div>

                        <div class="col col-12 col-lg-4">
                            @component('pages.components.iconblock', [
                                'title' => 'Удобная навигация',
                                'description' => 'Группы, секции и предпросмотр отображений',
                            ])
                            @endcomponent
                        </div>

                        <div class="col col-12 col-lg-4">
                            @component('pages.components.iconblock', [
                                'title' => 'Гибкость настроек',
                                'description' => 'Отключайте ненужные условия и правила',
                            ])
                            @endcomponent
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<img src="{{ asset('img/decor/feature-bottom-border.png') }}">

<section class="pad-y-98">
    <div class="container">
        <div class="flex-col-34">
            <div class="row">
                <div class="col">
                    <div class="flex-col-8 flex-center font-center">
                        <h3 class="font-size-lg font-color-accent">Популярные фильтры</h3>
                        <p class=" font-color-contrast">Самые скачиваемые фильтры нашего сообщества</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach ($filters->take(3) as $filter)
                    <div class="col col-12 col-md-6 col-lg-4">
                        @component('resources.filters.components.card', compact('filter'))
                        @endcomponent
                    </div>
                @endforeach
            </div>

            <div class="flex-col-13 flex-center">
                <p class=" font-color-contrast">Всего на сайте опубликовано <span
                        class="decor-link active">{{ count($filters) }}</span> фильтров</p>
                <a class="decor-btn z-1" href="{{ route('filters.index') }}">Все фильтры</a>
            </div>
        </div>
    </div>
</section>
