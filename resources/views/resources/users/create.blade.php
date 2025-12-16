@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Создание профиля пользователя')
@section('description', 'Создание нового профиля пользователя в сообществе ' . env('APP_NAME') . ' для Path of Exile')

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
                            <h1 class="font-size-h1 decor-gold">Создание пользователя</h1>
                            <p class="font-size-lg font-color-second">
                                Создать нового пользователя на сайте
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <img src="{{ asset('img/decor/feature-bottom-border.png') }}">
    
    <section class="pad-y-98">
        <div class="container">
            <div class="row">
                <div class="col">
                    <form class="flex-col-13 flex-grow flex-start" action="{{ route('users.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="flex-col-5">
                            <label class="font-color-second" for="name">Логин с сайта Path of Exile</label>
                            <input class="decor-input" type="text" id="name" name="name" required>
                        </div>

                        <div class="flex-col-5">
                            <label class="font-color-second" for="password">Пароль для входа на сайте</label>
                            <input class="decor-input" type="password" id="password" name="password" autocomplete="new-password" required>
                        </div>

                        <button class="decor-btn" type="submit">Создать</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
