@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Меню')
@section('description', 'Ознакомьтесь со всеми разделами и функциями сообщества ' . env('APP_NAME'))

@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back">
            <img class="temp-img-cover" src="{{ asset('img/bg/atlas.png') }}">
        </div>

        <div class="container z-1">
            <div class="flex-col-34">
                <div class="row g-4 align-items-center">
                    <div class="col col-12 col-lg">
                        <div class="flex-col-21">
                            <div class="flex-col-8">
                                <h1 class="font-size-h1 decor-gold">Карта проекта</h1>
                                <p class="font-size-lg font-color-accent">
                                    Изучайте возможности проекта путешествуя по его страницам
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    .road {
                        stroke: rgb(50 50 50);
                        stroke-width: 4px;
                        filter: drop-shadow(0px 0px 1px #ffffff);
                    }
                </style>

                {{-- <svg id="map" height="400" viewBox="0 0 800 400" xmlns="http://www.w3.org/2000/svg">
                    <line x1="400" y1="300" x2="330" y2="250" class="road" />
                    <line x1="330" y1="250" x2="260" y2="160" class="road" />
                    <line x1="330" y1="250" x2="340" y2="120" class="road" />
                    <line x1="400" y1="300" x2="480" y2="280" class="road" />
                    <line x1="180" y1="320" x2="250" y2="300" class="road" />
                    <line x1="330" y1="250" x2="250" y2="300" class="road" />
                    <line x1="480" y1="280" x2="500" y2="200" class="road" />
                    <line x1="480" y1="280" x2="600" y2="200" class="road" />

                    <a href="{{ route('pages.main') }}" data-tooltip="Главная страница">
                        <image x="380" y="280" width="40" height="40" href="{{ asset('img/icon/home.png') }}" />
                    </a>

                    <a href="{{ route('pages.main') }}" data-tooltip="Личный кабинет">
                        <image x="160" y="300" width="40" height="40" href="{{ asset('img/icon/Hideout.png') }}" />
                    </a>

                    <image x="310" y="230" width="40" height="40" href="{{ asset('img/icon/novisited.png') }}" />

                    <a href="{{ route('pages.about') }}" data-tooltip="Описание">
                        <image x="240" y="140" width="40" height="40" href="{{ asset('img/icon/unvisited.png') }}" />
                    </a>

                    <a href="{{ route('pages.community') }}" data-tooltip="Сообщество">
                        <image x="320" y="100" width="40" height="40" href="{{ asset('img/icon/unvisited.png') }}" />
                    </a>

                    <a href="{{ route('users.index') }}" data-tooltip="Изгнанники">
                        <image x="230" y="280" width="40" height="40" href="{{ asset('img/icon/visited.png') }}" />
                    </a>

                    <image x="460" y="260" width="40" height="40" href="{{ asset('img/icon/novisited.png') }}" />

                    <a href="{{ route('services.index') }}" data-tooltip="Услуги изгнанников">
                        <image x="580" y="180" width="40" height="40" href="{{ asset('img/icon/visited.png') }}" />
                    </a>

                    <a href="{{ route('services.index') }}" data-tooltip="Услуги изгнанников">
                        <image x="480" y="180" width="40" height="40" href="{{ asset('img/icon/visited.png') }}" />
                    </a>
                </svg> --}}
            </div>
        </div>
    </section>

    <img src="{{ asset('img/decor/feature-bottom-border.png') }}">

    <section class="pad-y-98">
        <div class="container">
            <div class="flex-col-34">
                <div class="row g-4">
                    <div class="col col-12 col-lg">
                        <div class="flex-col-8">
                            <div class="flex-row-8 flex-ai-center">
                                <img width="32" src="{{ asset('img/icon/home.png') }}">
                                <a class="decor-link" href="{{ route('pages.main') }}">Главная страница</a>
                            </div>

                            <div class="flex-row-8 flex-ai-center">
                                <img width="32" src="{{ asset('img/icon/unvisited.png') }}">
                                <a class="decor-link" href="{{ route('pages.community') }}">Сообщество</a>
                            </div>

                            <div class="flex-row-8 flex-ai-center">
                                <img width="32" src="{{ asset('img/icon/unvisited.png') }}">
                                <a class="decor-link" href="{{ route('pages.about') }}">Описание</a>
                            </div>

                            @if (Auth::check())
                                <div class="flex-row-8 flex-ai-center">
                                    <img width="32" src="{{ asset('img/icon/Hideout.png') }}">
                                    <a class="decor-link" href="{{ route('users.show', Auth::user()) }}">Личный профиль</a>
                                </div>
                            @else
                                <div class="flex-row-8 flex-ai-center">
                                    <img width="32" src="{{ asset('img/icon/Hideout.png') }}">
                                    <a class="decor-link" href="{{ route('auth.login') }}">Авторизация</a>
                                </div>
                            @endif

                            <div class="flex-row-8 flex-ai-center">
                                <img width="32" src="{{ asset('img/icon/visited.png') }}">
                                <a class="decor-link" href="{{ route('characters.index') }}">Персонажи</a>
                            </div>

                            {{-- <div class="flex-row-8 flex-ai-center">
                                <img width="32" src="{{ asset('img/icon/novisited.png') }}">
                                <p>Сервисы</p>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col col-12 col-lg">
                        <div class="flex-col-8">
                            <div class="flex-row-8 flex-ai-center">
                                <img width="32" src="{{ asset('img/icon/visited.png') }}">
                                <a class="decor-link" href="{{ route('services.index') }}">Объявления изгнанников</a>
                            </div>

                            <div class="flex-row-8 flex-ai-center">
                                <img width="32" src="{{ asset('img/icon/visited.png') }}">
                                <a class="decor-link" href="{{ route('builds.index') }}">Сборки персонажей</a>
                            </div>

                            <div class="flex-row-8 flex-ai-center">
                                <img width="32" src="{{ asset('img/icon/visited.png') }}">
                                <a class="decor-link" href="{{ route('filters.index') }}">Фильтры предметов</a>
                            </div>

                            <div class="flex-row-8 flex-ai-center">
                                <img width="32" src="{{ asset('img/icon/visited.png') }}">
                                <a class="decor-link" href="{{ route('hideouts.index') }}">Убежища изгнанников</a>
                            </div>

                            <div class="flex-row-8 flex-ai-center">
                                <img width="32" src="{{ asset('img/icon/visited.png') }}">
                                <a class="decor-link" href="{{ route('users.index') }}">Профили пользователей</a>
                            </div>
                        </div>
                    </div>
                    <div class="col col-12 col-lg-5">
                        <img class="flip-x" src="{{ asset('img/decor/hero-image.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
