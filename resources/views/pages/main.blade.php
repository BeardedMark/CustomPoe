@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Главная страница')
@section('description',
    'Добро пожаловать в сообществао ' .
    env('APP_NAME') .
    ', узнайте больше о возможностях в Path of
    Exile.')

@section('content')
    <section class="back-color-dark pad-y-98 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-dark">
            <img class="temp-img-cover" src="{{ asset('img/bg/druid.jpg') }}">
        </div>

        <div class="container z-1">
            <div class="row ">
                <div class="col col-12 col-lg">
                    <div class="flex-row-34 flex-center" style="min-height: 40vh">
                        <img class="d-none d-lg-block" width="200" src="{{ asset('img/decor/list-ornament.png') }}">

                        <div class="flex-col-21 flex-center font-center w-auto">
                            <div class="flex-col-8 pad-x-34 flex-center font-center">
                                <img src="{{ asset('img/decor/menu-select-bg.png') }}">
                                <p class="font-size-h1 decor-gold">Welcome Exile!</p>
                                <h1 class="font-size-h3 font-color-accent">CustomPoe - сообщество Path of Exile</h1>
                                <div class="flex-col-21 flex-center">
                                    @if (Auth::user())
                                        <p class="font-size-lg">Вы уже <span
                                                class="decor-link active">{{ Auth::user()->createdDays() }}</span> дней с
                                            нами</p>
                                        <a class="decor-btn" href="{{ route('auth.dashboard') }}">Личный профиль</a>
                                    @else
                                        <p class="font-size-lg">Присоединяйся к сообществу</p>
                                        <a class="decor-btn" href="{{ route('auth.login') }}">Авторизация через PoE</a>
                                    @endif
                                </div>
                            </div>

                            <img class="flip-y" src="{{ asset('img/decor/menu-select-bg.png') }}">

                        </div>

                        <img width="200" class="flip-x d-none d-lg-block"
                            src="{{ asset('img/decor/list-ornament.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <img src="{{ asset('img/decor/feature-bottom-border.png') }}">

    <section class="pad-y-98 over-hidden flex-center">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21 font-center">
                        <div class="row g-4 justify-content-center">
                            <div class="col col-6 col-lg-3">
                                @component('pages.components.iconblock', [
                                    'icon' => asset('img/icon/safe.png'),
                                    'title' => 'Безопасная авторизация',
                                    'description' => 'Авторизация через Path of Exile, гарантирует безопасность данных',
                                ])
                                @endcomponent
                            </div>

                            <div class="col col-6 col-lg-3">
                                @component('pages.components.iconblock', [
                                    'icon' => asset('img/icon/lock.png'),
                                    'title' => 'Официальные данные',
                                    'description' => 'Приложение интегрировано с официальными источниками игры',
                                ])
                                @endcomponent
                            </div>

                            <div class="col col-6 col-lg-3">
                                @component('pages.components.iconblock', [
                                    'icon' => asset('img/icon/tools.png'),
                                    'title' => 'Инструменты в одном месте',
                                    'description' => 'Полезные функции для игроков с централизованным доступом',
                                ])
                                @endcomponent
                            </div>

                            <div class="col col-6 col-lg-3">
                                @component('pages.components.iconblock', [
                                    'icon' => asset('img/icon/mask.png'),
                                    'title' => 'Интуитивный интерфейс',
                                    'description' => 'Удобный и приятный дизайн, стилизованный под игру',
                                ])
                                @endcomponent
                            </div>

                            <div class="col col-6 col-lg-3">
                                @component('pages.components.iconblock', [
                                    'icon' => asset('img/icon/seetube.png'),
                                    'title' => 'Фильтры и поиск',
                                    'description' => 'Гибкие инструменты для сортировки и поиска контента',
                                ])
                                @endcomponent
                            </div>

                            <div class="col col-6 col-lg-3">
                                @component('pages.components.iconblock', [
                                    'icon' => asset('img/icon/magic.png'),
                                    'title' => 'Комьюнити и ресурсы',
                                    'description' => 'Платформа для общения и обмена игровыми ресурсами',
                                ])
                                @endcomponent
                            </div>

                            <div class="col col-6 col-lg-3">
                                @component('pages.components.iconblock', [
                                    'icon' => asset('img/icon/bomb.png'),
                                    'title' => 'Альтернатива оффоруму',
                                    'description' => 'Место для публикации и обсуждения контента с нужными функциями',
                                ])
                                @endcomponent
                            </div>

                            <div class="col col-6 col-lg-3">
                                @component('pages.components.iconblock', [
                                    'icon' => asset('img/icon/punch.png'),
                                    'title' => 'Конкурентный аналог',
                                    'description' => 'Если что-то уже есть, то можно попытаться сделать это лучше',
                                ])
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="row">
                <div class="col col-12 col-lg">
                    <div class="flex-row-34 flex-center">
                        <div class="flex-col-34 flex-center font-center">
                            <div class="flex-col-8 flex-center">
                                <h2 class="font-size-h2 decor-gold">Крупное обновление!</h2>
                                <p class="font-size-lg font-color-contrast decor-link active">Добавлены новые разделы и возможности</p>
                            </div>

                            <div class="flex-col-8 flex-center">
                                <div class="row justify-content-center">
                                    <div class="col col-12 col-lg-7">
                                        <div class="flex-col flex-center">
                                            <img clas src="{{ asset('img/decor/title-border.png') }}">
                                            <div class="flex-col-8 pad-13 back-color-dark decor-area">
                                                <p>Мы рады сообщить, что наш проект получил значительное обновление,
                                                    которое включает множество новых разделов и уникальных функций!
                                                    Теперь пользователи могут наслаждаться расширенным функционалом,
                                                    включая синхронизацию с Path of Exile. Это означает, что вы сможете
                                                    легко импортировать свои данные и делиться ими с сообществом прямо
                                                    на нашей платформе!</p>

                                                <p>Также мы добавили уровни сообщества для пользователей. Чем активнее
                                                    вы участвуете в жизни проекта, тем выше ваш уровень! Это открывает
                                                    новые возможности и привилегии для каждого участника.
                                                    Присоединяйтесь, исследуйте обновления и взаимодействуйте с
                                                    сообществом — впереди много интересного!</p>
                                            </div>
                                            <img src="{{ asset('img/decor/title-border-bottom.png') }}">
                                        </div>
                                    </div>
                                </div>
                                <a class="decor-btn" href="{{ route('pages.about') }}">О проекте</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>

    <img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    <section class="back-color-dark pad-y-98 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-dark">
            <img class="temp-img-cover" src="{{ asset('img/bg/monk.jpg') }}">
        </div>

        <div class="container z-1">
            <div class="row ">
                <div class="col col-12 col-lg">
                    <div class="flex-row-34 flex-center">

                        <div class="flex-col-34 flex-center font-center">
                            <div class="flex-col-8">
                                <h2 class="font-size-h2 decor-gold">Возможности</h2>
                                <p class="font-size-lg font-color-accent">Улучшайте свой геймплей в Path of Exile</p>
                            </div>

                            <div class="flex-row-8 flex-center font-cente flex-wrap">
                                <a class="decor-icon levitate" href="{{ route('services.index') }}">S</a>
                                <a class="decor-icon levitate" href="{{ route('builds.index') }}">B</a>
                                <a class="decor-icon levitate" href="{{ route('filters.index') }}">F</a>
                                <a class="decor-icon levitate" href="{{ route('hideouts.index') }}">H</a>
                                <p class="lock-gray decor-icon levitate">?</p>
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
            <div class="row g-4 align-items-center justify-content-center">

                <div class="col col-6 col-lg">
                    @component('pages.components.counter', [
                        'count' => $transactions,
                        'title' => "Сделок"
                    ])
                    @endcomponent
                </div>

                <div class="col col-6 col-lg">
                    @component('pages.components.counter', [
                        'count' => $pumpings,
                        'title' => "Прокачек"
                    ])
                    @endcomponent
                </div>

                <div class="col col-6 col-lg">
                    @component('pages.components.counter', [
                        'count' => $views,
                        'title' => "Просмотров"
                    ])
                    @endcomponent
                </div>

                <div class="col col-6 col-lg">
                    @component('pages.components.counter', [
                        'count' => $downloads,
                        'title' => "Скачиваний"
                    ])
                    @endcomponent
                </div>

                <div class="col col-6 col-lg">
                    @component('pages.components.counter', [
                        'count' => $count,
                        'title' => "Записей"
                    ])
                    @endcomponent
                </div>
            </div>
        </div>
    </section>


    @component('resources.services.sections.promo', compact('services'))
    @endcomponent

    @component('resources.builds.sections.promo', compact('builds'))
    @endcomponent

    @component('resources.filters.sections.promo', compact('filters'))
    @endcomponent

    @component('resources.hideouts.sections.promo', compact('hideouts'))
    @endcomponent

    @component('resources.users.sections.promo', compact('users'))
    @endcomponent
@endsection
