@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Вход в сообщество')
@section('description', 'Авторизуйтесь в нашем сообществе ' . env('APP_NAME') . ' через Path of Exile')

@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/bg/sorceress.jpg') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h1 class="font-size-h1 decor-gold">Авторизация через PoE</h1>
                            <p class=" font-size-lg">Синхронизация с аккаунтом Path of Exile</p>
                        </div>

                        <p class="font-color-second">
                            Для обеспечения дополнительных возможностей и безопасности сервиса мы используем официальные
                            учетные записи Path of Exile. Авторизация (вход или регистрация) на сайте осуществляется через
                            oAuth Path of Exile
                        </p>
                    </div>
                </div>

                <div class="col col-12 col-lg-5 offset-1">
                    <div class="flex-col-8 flex-center font-center decor-particle z-0">
                        <img src="{{ asset('img/decor/menu-select-bg.png') }}">
                        {{-- <a class="decor-btn" href="{{ route('auth.login') }}">Войти через Path of Exile</a> --}}
                        <a class="decor-btn z-1" href="{{ route('pages.main', ['auth' => true]) }}">Войти через Path of Exile</a>
                        <img class="flip-y" src="{{ asset('img/decor/menu-select-bg.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    <section class="pad-y-98">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold ">Вход по паролю</h2>
                            <p class="font-size-lg">Доступ к проекту без привязки к учетной записи Path of Exile</p>
                        </div>

                        <div class="flex-col-8 font-color-second">
                            <p>
                                Если у вас установлен пароль для профиля на нашем сайте, вы можете войти, используя ваш логин
                                Path of Exile, независимо от авторизации в самой игре
                            </p>
    
                            <p>
                                Установить пароль можно в личном кабинете после авторизации через Path of Exile или при регистрации
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-5 offset-1">
                    <form class="flex-col-21 flex-cent" action="{{ route('auth.enter') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="flex-col-13">
                            <div class="flex-col-5 flex-center">
                                <label class="font-color-second" for="name">Логин Path of Exile</label>
                                <input class="decor-input font-center" type="text" id="name" name="name" value="{{ old('name') }}">
                            </div>

                            <div class="flex-col-5 flex-center">
                                <label class="font-color-second" for="password">Пароль на сайте</label>
                                <input class="decor-input font-center" type="password" id="password" name="password" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="flex-row-13 flex-center">
                            <button class="decor-btn" type="submit">Войти на сайт</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- <img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/bg/witch.jpg') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold ">Регистрация</h2>
                            <p class="font-size-lg">Создайте профиль и ожидайте подтверждения</p>
                        </div>

                        <div class="flex-col-8 font-color-second">
                            <p class="font-color-second">
                                Мы используем данные сервера Path of Exile, поэтому мы лично контролируем процесс создания аккаунтов
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-5 offset-1">
                    <div class="flex-col-8 flex-center font-center">
                        <img src="{{ asset('img/decor/menu-select-bg.png') }}">
                        <a class="decor-btn" href="{{ route('auth.register') }}">Зарегистрироваться</a>
                        <img class="flip-y" src="{{ asset('img/decor/menu-select-bg.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    <section class="pad-y-98">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold">Нужна помощь</h2>
                            <p class="font-size-lg">Обратитесь в сообщество с вопросом</p>
                        </div>
    
                        <p class="font-color-second">
                            На нашем сервере Discord вы можете задать вопросы или обратиться за помощью. Модераторы или участники сообщества помогут вам разобраться
                        </p>
                    </div>
                </div>

                <div class="col col-12 col-lg-5 offset-1">
                    <div class="flex-col flex-center">
                        <img src="{{ asset('img/decor/title-border.png') }}">
                            <iframe class="discord-frame" src="https://discord.com/widget?id=544453334208217088&theme=dark" allowtransparency="true" frameborder="0"
                                sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
                        <img src="{{ asset('img/decor/title-border-bottom.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection
