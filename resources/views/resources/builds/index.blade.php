@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Сборки персонажей')
@section('description', 'Сборки персонажей от сообщества ' . env('APP_NAME') . ' для Path of Exile')

@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/bg/threePassive.png') }}">
        </div>

        <div class="container z-1">
            <div class="flex-col-34">
                <div class="row g-4 align-items-center">
                    <div class="col col-12 col-lg">
                        <div class="flex-col-21">
                            <div class="flex-col-8">
                                <h1 class="font-size-h1 decor-gold">Сборки персонажей</h1>
                                <p class="font-size-lg font-color-accent">
                                    Выберите подходящий для своего стиля игры билд или найдите что-то интересное и новое
                                </p>
                            </div>

                            <div class="flex-col-8">
                                <div class="flex-row-13">
                                    <a class="decor-link"
                                        href="{{ route('builds.index', ['sort' => 'downloads', 'reverse' => 'on']) }}">Популярные</a>
                                    <a class="decor-link"
                                        href="{{ route('builds.index', ['sort' => 'updated_at']) }}">Актуальные</a>
                                    <a class="decor-link"
                                        href="{{ route('builds.index', ['sort' => 'created_at']) }}">Новые</a>
                                    <a class="decor-link" href="{{ route('builds.index', ['sort' => 'name']) }}">По
                                        алфавиту</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col col-12 col-lg-5">
                        <div class="flex-col-8 flex-center decor-particle z-0">
                            <img src="{{ asset('img/decor/menu-select-bg.png') }}">
                            <a class="decor-btn z-1" href="{{ route('builds.create') }}">Добавить сборку</a>
                            <img class="flip-y" src="{{ asset('img/decor/menu-select-bg.png') }}">
                        </div>
                    </div>
                </div>

                <div class="row g-1 justify-content-start">
                    @foreach ($classes as $class)
                        <div class="col-2 col-md-1 col-xl">
                            <a class="decor-frame-hover pad-3" href="{{ route('builds.index', ['class' => $class]) }}">
                                <img class="w-100"
                                    src="{{ asset('img/characters/customAvatars/' . $class . '.png') }}">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <img src="{{ asset('img/decor/feature-bottom-border.png') }}">

    <section class="pad-y-98">
        <div class="container">
            <div class="flex-col-34">
                <div class="row">
                    <div class="col col-12 col-lg">
                        <div class="flex-col-21">
                            <div class="row g-4">
                                @foreach ($builds as $build)
                                    <div class="col col-12 col-md-6 col-lg-4">
                                        @component('resources.builds.components.card', compact('build'))
                                        @endcomponent
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
