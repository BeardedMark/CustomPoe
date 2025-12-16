@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Создание фильтра предметов')
@section('description', 'Создание нового фильтра предметов в сообществе ' . env('APP_NAME') . ' для Path of Exile')

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
                            <h1 class="font-size-h1 decor-gold">Добавление фильтра предметов</h1>
                            <p class="font-size-lg font-color-second">
                                Создать новый фильтр предметов на сайте
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
                    <form class="flex-col-13 flex-grow flex-start" action="{{ route('filters.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col col-12 col-lg">
                            <div class="flex-col-13">
                                <h2 class="font-size-h2 decor-gold" for="filter">Создание с нуля</h2>

                                <div class="flex-col-5">
                                    <label class="font-color-second" for="name">Название нового фильтра
                                        предметов</label>
                                    <input class="decor-input" type="text" id="name" name="name"
                                        value="{{ old('name') }}" required>
                                </div>
                            </div>
                        </div>


                        <button class="decor-btn" type="submit">Создать</button>
                    </form>
                </div>

                {{-- <div class="col col-12 col-lg-5">
                    <div class="flex-col-13">
                        <h2 class="font-size-h2 decor-gold" for="filter">Импортировать</h2>

                        <div class="flex-col-5">
                            <label class="font-color-second" for="name">Из профиля Path of Exile</label>

                            @if (Auth::check())
                                @if (Auth::user()->fetchItemFilters())
                                    <select class="decor-input" id="name" name="name" required>
                                        @foreach (Auth::user()->fetchItemFilters() as $filter)
                                            <option value="{{ $filter->id }}">{{ $filter->filter_name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <p class="font-color-danger">Ошибка загрузки фильтров профиля</p>
                                @endif
                            @else
                                <a class="decor-btn" href="{{ route('auth.login') }}">Войти через Path of Exile</a>
                            @endif
                        </div>

                        <div class="flex-col-5">
                            <label class="font-color-second" for="name">Из файла .filter</label>
                            <input class="decor-input" type="text" id="name" name="name"
                                value="{{ old('name') }}" required>
                        </div>

                    </div>
                </div> --}}
            </div>
        </div>
    </section>
@endsection
