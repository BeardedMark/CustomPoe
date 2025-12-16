@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Создание сборки персонажа')
@section('description', 'Создание новой сборки персонажа в сообществе ' . env('APP_NAME') . ' для Path of Exile')

@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/bg/topbg.png') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h1 class="font-size-h1 decor-gold">Создание сборки персонажа</h1>
                            <p class="font-size-lg font-color-second">
                                Создать новую сборку персонажа на сайте
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <img src="{{ asset('img/decor/feature-bottom-border.png') }}">

    <section class="pad-98">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col col-12 col-lg">
                    <form class="flex-col-13 flex-grow flex-start" action="{{ route('builds.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <h2 class="font-size-h2 decor-gold" for="filter">Новая сборка персонажа</h2>

                        <div class="flex-col-5">
                            <label class="font-color-second" for="name">Название сборки</label>
                            <input class="decor-input" type="text" id="name" name="name"
                                value="{{ old('name') }}" required>
                        </div>

                        <div class="flex-col-5">
                            <label class="font-color-second" for="name">Игровой персонаж {{ $characterName }}</label>

                            @if (Auth::check())
                                @if (Auth::user()->fetchCharacters())
                                    <select class="decor-input" id="characterName" name="characterName" required>
                                        <option disabled selected></option>
                                        @foreach (Auth::user()->fetchCharacters() as $character)
                                            <option value="{{ $character['name'] }}"
                                                @if ($characterName === $character['name']) selected @endif>{{ $character['name'] }} ({{ $character['level'] }} уровень)
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <p class="font-color-danger">Ошибка загрузки персонажей профиля</p>
                                @endif
                            @else
                                <a class="decor-btn" href="{{ route('auth.login') }}">Войти через Path of Exile</a>
                            @endif
                        </div>

                        <button class="decor-btn" type="submit">Создать</button>
                    </form>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col-13">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
