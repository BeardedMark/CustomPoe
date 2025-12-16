<img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

<section class="back-color-dark pad-y-98 pos-rel over-hidden flex-center">
    <div class="pos-abs-fill z-0 decor-back-dark">
        <img class="temp-img-cover" src="{{ asset('img/bg/community.jpg') }}">
    </div>

    <div class="container z-1">
        <div class="row ">
            <div class="col col-12 col-lg">
                <div class="flex-col-34 font-center">
                    <div class="flex-col-8 flex-center">
                        <h2 class="font-size-h2 decor-gold">Сообщество</h2>
                        <p class="font-size-lg font-color-accent">Создаем собственное комьюнити игроков</p>
                    </div>

                    <img src="{{ asset('img/decor/cut.png') }}">

                    <div class="row g-4 justify-content-center">
                        <div class="col col-12 col-lg-4">
                            @component('pages.components.iconblock', [
                                'title' => 'Синхронизация с PoE',
                                'description' => 'Удобный доступ к профилю и взаимодействию с ним',
                            ])
                            @endcomponent
                        </div>

                        <div class="col col-12 col-lg-4">
                            @component('pages.components.iconblock', [
                                'title' => 'Рейтинг и активность',
                                'description' => 'Оценка постов и пользователей для поиска качественного',
                            ])
                            @endcomponent
                        </div>

                        <div class="col col-12 col-lg-4">
                            @component('pages.components.iconblock', [
                                'title' => 'Персональная ссылка на профиль',
                                'description' => 'Делитесь своим контентом одной ссылкой',
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
                        <h3 class="font-size-lg font-color-accent">Активные пользователи</h3>
                        <p>Пользователи с самым высоким уровнем опыта на сайте</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach ($users->take(3) as $user)
                    <div class="col col-12 col-md-6 col-lg-4">
                        @component('resources.users.components.card', compact('user'))
                        @endcomponent
                    </div>
                @endforeach
            </div>

            <div class="flex-col-13 flex-center font-center">
                <p class="">В нашем сообществе уже <span class="decor-link active">{{ count($users) }}</span>
                    пользователей</p>
                <a class="decor-btn" href="{{ route('users.index') }}">Все пользователи</a>
            </div>
        </div>
    </div>
</section>
