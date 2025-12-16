@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Личный кабинет')
@section('description', 'Изучите возможности которые предоставляет наше сообщество ' . env('APP_NAME') . ' для Path of Exile')

@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ Auth::user()->wallpaper ?? asset('img/bg/huntress.jpg') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg-7">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h1 class="font-size-h1 decor-gold">Добро пожаловать {{ Auth::user()->name }}!</h1>
                            <p class="font-color-second">На этой странице размещен приватный контент, доступный только для
                                вас</p>
                        </div>

                        <div class="flex-row-13">
                            @if (Auth::user()->is_admin)
                                <a class="decor-btn font-color-warning" href="{{ route('data.dashboard') }}">Перенос
                                    данных</a>
                            @endif
                            <a class="decor-btn" href="{{ route('users.show', Auth::user()) }}">Публичный профиль</a>
                            <a class="decor-btn font-color-danger" href="{{ route('auth.logout') }}">Выйти</a>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col-8 flex-center">
                        <p class="font-size-h1 decor-link active cursor-def">{{ $user->level() }}</p>
                        <p class="font-size-lg font-color-accent">Уровень сообщества</p>
                        <div class="flex-col flex-center">
                            @if (Auth::user()->is_admin)
                                <p class="decor-link active">Администратор</p>
                            @endif
                            <p class="font-center">{{ $user->role() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    @component('poe.characters.sections.promo', compact('user', 'characters'))
    @endcomponent

@endsection
