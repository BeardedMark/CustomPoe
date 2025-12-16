<img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

<section class="back-color-dark pad-y-98 pos-rel over-hidden flex-center">
    <div class="pos-abs-fill z-0 decor-back-dark">
        <img class="temp-img-cover" src="{{ asset('img/bg/threePassive.png') }}">
    </div>

    <div class="container z-1">
        <div class="row ">
            <div class="col col-12 col-lg">
                <div class="flex-col-34 font-center">
                    <div class="flex-col-8">
                        <h2 class="font-size-h2 decor-gold">Сборки персонажей</h2>
                        <p class="font-size-lg font-color-accent">Список билдов персонажей от сообщества</p>
                    </div>

                    <img src="{{ asset('img/decor/cut.png') }}">

                    <div class="row g-4 justify-content-center">
                        <div class="col col-12 col-lg-4">
                            @component('pages.components.iconblock', [
                                'title' => 'Реальные билды',
                                'description' => 'Сборки только с персонажей 90+ уровня',
                            ])
                            @endcomponent
                        </div>

                        <div class="col col-12 col-lg-4">
                            @component('pages.components.iconblock', [
                                'title' => 'Ключевые данные о сборке',
                                'description' => 'Удобная структура для плюсов, минусов и особенностей',
                            ])
                            @endcomponent
                        </div>

                        <div class="col col-12 col-lg-4">
                            @component('pages.components.iconblock', [
                                'title' => 'Медиа-контент',
                                'description' => 'Скриншоты и видео для наглядности сборки',
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
                        <h3 class="font-size-lg font-color-accent">Обновленные сборки</h3>
                        <p>Сборки, которые были недавно изменены</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 justify-contewnt-center">
                @foreach ($builds->take(3) as $build)
                    <div class="col col-12 col-md-6 col-lg-4">
                        @component('resources.builds.components.card', compact('build'))
                        @endcomponent
                    </div>
                @endforeach
            </div>

            <div class="flex-col-13 flex-center">
                <p class="">Всего на сайте опубликовано <span
                        class="decor-link active">{{ count($builds) }}</span> сборок</p>
                <a class="decor-btn z-1" href="{{ route('builds.index') }}">Все сборки</a>
            </div>
        </div>
    </div>
</section>
