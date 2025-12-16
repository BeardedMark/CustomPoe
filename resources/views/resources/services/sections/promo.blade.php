<img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

<section class="back-color-dark pad-y-98 pos-rel over-hidden flex-center">
    <div class="pos-abs-fill z-0 decor-back-dark">
        <img class="temp-img-cover" src="{{ asset('img/bg/service.png') }}">
        {{-- <video class="temp-img-cover" src="{{ asset('video/services.mp4') }}"loop autoplay muted></video> --}}
    </div>

    <div class="container z-1">
        <div class="row ">
            <div class="col col-12 col-lg">
                <div class="flex-col-34 font-center">
                    <div class="flex-col-8">
                        <h2 class="font-size-h2 decor-gold">Объявления изнанников</h2>
                        <p class="font-size-lg font-color-accent">Найдите полезное среди предложений игроков или
                            разместите своё</p>
                    </div>

                    <img src="{{ asset('img/decor/cut.png') }}">

                    <div class="row g-4 justify-content-center">
                        <div class="col col-12 col-lg-4">
                            @component('pages.components.iconblock', [
                                'title' => 'Альтернатива TFT Discord',
                                'description' => 'Удобный способ торговли с фокусом на RU-сегмент',
                            ])
                            @endcomponent
                        </div>

                        <div class="col col-12 col-lg-4">
                            @component('pages.components.iconblock', [
                                'title' => 'Торговля и услуги',
                                'description' => 'Размещайте объявления о любых товарах или услугах',
                            ])
                            @endcomponent
                        </div>

                        <div class="col col-12 col-lg-4">
                            @component('pages.components.iconblock', [
                                'title' => 'Готовый текст сообщения',
                                'description' => 'Быстрая отправка сообщений в игре',
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
                        <h3 class="font-size-lg font-color-accent">Новые объявления</h3>
                        <p class="">Последние добавленные сообществом объявления</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach ($services->take(3) as $service)
                    <div class="col col-12 col-md-6 col-lg-4">
                        @component('resources.services.components.card', compact('service'))
                        @endcomponent
                    </div>
                @endforeach
            </div>

            <div class="flex-col-13 flex-center">
                <p class="">Всего на сайте опубликовано
                    <span class="decor-link active">{{ count($services) }}</span>
                    объявлений
                </p>
                <a class="decor-btn z-1" href="{{ route('services.index') }}">Все объявления</a>
            </div>
        </div>
    </div>
</section>
