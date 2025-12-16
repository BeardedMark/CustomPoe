<img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

<section class="back-color-dark pad-y-98 pos-rel over-hidden flex-center">
    <div class="pos-abs-fill z-0 decor-back-dark">
        <img class="temp-img-cover" src="{{ asset('img/bg/ho.png') }}">
    </div>

    <div class="container z-1">
        <div class="row ">
            <div class="col col-12 col-lg">
                <div class="flex-col-34 font-center">
                    <div class="flex-col-8">
                        <h2 class="font-size-h2 decor-gold">Убежища изгнанников</h2>
                        <p class="font-size-lg font-color-accent">Сделайте свое убежище комфортным и красивым</p>
                    </div>

                    <img src="{{ asset('img/decor/cut.png') }}">

                    <div class="row g-4 justify-content-center">
                        <div class="col col-12 col-lg-4">
                            @component('pages.components.iconblock', [
                                'title' => 'Загрузка и совместимость',
                                'description' => 'Узнайте нагрузку перед установкой убежища',
                            ])
                            @endcomponent
                        </div>

                        <div class="col col-12 col-lg-4">
                            @component('pages.components.iconblock', [
                                'title' => 'Поиск по областям',
                                'description' => 'Найдите оформление под нужный тип области',
                            ])
                            @endcomponent
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

<section class="pad-y-98">
    <div class="container">
        <div class="flex-col-34">
            <div class="row">
                <div class="col">
                    <div class="flex-col-8 flex-center font-center">
                        <h3 class="font-size-lg font-color-accent">Интересные убежища</h3>
                        <p>Работы с наибольшим количеством просмотров</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach ($hideouts->take(3) as $hideout)
                    <div class="col col-12 col-md-6 col-lg-4">
                        @component('resources.hideouts.components.card', compact('hideout'))
                        @endcomponent
                    </div>
                @endforeach
            </div>

            <div class="flex-col-13 flex-center">
                <p class="">Всего на сайте опубликовано <span
                        class="decor-link active">{{ count($hideouts) }}</span> убежищь</p>
                <a class="decor-btn z-1" href="{{ route('hideouts.index') }}">Все убежища</a>
            </div>
        </div>
    </div>
</section>
