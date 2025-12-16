@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Профили пользователей')
@section('description', 'Профили пользователей сообщества ' . env('APP_NAME') . ' для Path of Exile')

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
                            <h1 class="font-size-h1 decor-gold">Пользователи сообщества</h1>
                            <p class="font-size-lg font-color-second">
                                Список пользователей сервиса CustomPoe
                            </p>
                        </div>

                        <div class="flex-col-8">
                            <div class="flex-row-13">
                                @if (!Auth::check())
                                    <a class="decor-btn" href="{{ route('auth.login') }}">Авторизация</a>
                                @endif

                                @if (Auth::check() && Auth::user()->is_admin)
                                    <a class="decor-btn font-color-warning" href="{{ route('users.create') }}">Создать</a>
                                @endif
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
            @component('resources.users.components.grid', compact('users'))
            @endcomponent
        </div>
    </section>
@endsection
