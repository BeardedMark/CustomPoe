@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Сообщество')
@section('description', 'Присоединяйтесь к нашему сообществу ' . env('APP_NAME') . ' посвященному игре Path od Exile')

@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/bg/community.jpg') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h1 class="font-size-h1 decor-gold">Сообщество проекта</h1>
                            <p class="font-size-lg font-color-accent">
                                Создаем сообщество для общения, поддержки и совместного взаимодействия по игре и интересам
                            </p>
                        </div>
                        <div class="flex-row-13">
                            <a class="decor-btn" href="{{ route('users.index') }}">Все пользователи</a>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    {{-- <div class="flex-col-8 flex-center font-center">
                        <img width="300px" src="{{ asset('img/decor/game-logo.png') }}">
                    </div> --}}
                    <div class="flex-col-8 flex-center">
                        <p class="font-size-h1 decor-link active cursor-def">{{ count($users) }}</p>
                        <p class="font-size-lg font-color-contrast">Участников</p>
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
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold">Топ пользователей</h2>
                            <p class="font-size-lg font-color-accent">Фавориты по уровню сообщества среди других участников</p>
                            <p>Повышайте уровень активно учавсвуя в сообществе или размещая годный контент</p>
                        </div>
                    </div>
                </div>

                <div class="row g-4 justify-content-center">
                    @foreach ($topLevels as $user)
                        <div class="col col-12 col-md-6 col-lg-4">
                            @component('resources.users.components.card', compact('user'))
                            @endcomponent
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/bg/library.jpg') }}">
        </div>
        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold">Форум Path of Exile</h2>
                            <p class="font-size-lg font-color-accent">Посетите нашу тему на официальном сайте игры</p>
                        </div>

                        <div class="flex-col-5">
                            <p><span class="font-color-second">Записей : <span class="font-color-contrast">2k</span></p>
                            <p><span class="font-color-second">Просмотров : <span class="font-color-contrast">605k</span>
                            </p>
                            <p><span class="font-color-second">Дата создания : <span
                                        class="font-color-contrast">2017-11-12</span></p>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col-8 flex-center font-center">
                        <img src="{{ asset('img/decor/menu-select-bg.png') }}">
                        <a class="decor-btn" href="{{ route('link.forumpoe') }}" target="_blank">Посетить форум</a>
                        <img class="flip-y" src="{{ asset('img/decor/menu-select-bg.png') }}">
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
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold">Новые пользователи</h2>
                            <p class="font-size-lg font-color-accent">Последние зарегестрированные пользователи</p>
                            <p>Присоединяйтесь к нам и станьте частью сообщества Path of Exile</p>
                        </div>
                    </div>
                </div>

                <div class="row g-4 justify-content-center">
                    @foreach ($lastUsers as $user)
                        <div class="col col-12 col-md-6 col-lg-4">
                            @component('resources.users.components.card', compact('user'))
                            @endcomponent
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="pad-y-98">
        <div class="container">
            <div class="row g-4 align-items-center">

                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold ">Обратная связь</h2>
                            <p class="font-size-lg font-color-accent">Отправте сообщение нам в сообщество</p>
                        </div>

                        <p class="font-color-second">
                            Мы всегда открыты для связи, поэтому можете отправить нам сообщение прямо сейчас
                        </p>
                    </div>
                </div>

                <div class="col col-12 col-lg-5 offset-1">
                    <form class="flex-col-21 flex-cent" action="{{ route('connect.feedback') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="flex-col-13">
                            <div class="flex-col-5 flex-center">
                                <label class="font-color-second" for="name">Псевдоним</label>
                                <input class="decor-input font-center" type="text" id="name" name="name"
                                    required>
                            </div>

                            <div class="flex-col-5 flex-center">
                                <label class="font-color-second" for="message">Сообщение</label>
                                <textarea class="decor-textbox" type="text" id="message" name="message" rows="5" required></textarea>
                            </div>
                        </div>

                        <div class="flex-row-13 flex-center">
                            <button class="decor-btn" type="submit">Отправить сообщение</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section> --}}
@endsection
