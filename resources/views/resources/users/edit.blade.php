@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Редактирование профиля пользователя ' . $user->name)
@section('description', 'Редактирование профиля пользователя ' . $user->name . ' в сообществе ' . env('APP_NAME') . ' для Path of Exile')

@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ $user->wallpaper ?: asset('img/bg/hero-bg.jpg') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-13">
                        <div class="flex-col-8">
                            <h1 class="font-size-h1 decor-gold">Редактирование пользователя</h1>

                            <div class="flex-row-5 flex-ai-end">
                                <a class="font-size-lg decor-link"
                                    href="{{ route('users.show', $user) }}">{{ $user->name }}</a>
                                <span class="font-color-second">.user</span>
                            </div>
                        </div>

                        @if (session($user->id))
                            <p class="decor-link active cursor-def">Есть сохранение</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    <section class="pad-y-98">
        <div class="container">
            <div class="row">
                <div class="col col-12 col-lg">
                    <form class="flex-col-13 flex-grow" action="{{ route('users.update', $user) }}"
                        method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="flex-col-5">
                            <label class="font-color-second" for="avatar">Аватар</label>
                            <input class="decor-input" type="text" id="avatar" name="avatar"
                                value="{{ old('avatar') ?? $user->avatar }}" placeholder="{{ $user->avatar }}">
                        </div>
                        
                        <div class="flex-col-5">
                            <label class="font-color-second" for="wallpaper">Обложка</label>
                            <input class="decor-input" type="text" id="wallpaper" name="wallpaper"
                                value="{{ old('wallpaper') ?? $user->wallpaper }}" placeholder="{{ $user->wallpaper }}">
                        </div>

                        <div class="flex-col-5">
                            <label class="font-color-second" for="description">Описание</label>
                            <input class="decor-input" type="text" id="description" name="description"
                                value="{{ old('description') ?? $user->description }}"
                                placeholder="{{ $user->description }}">
                        </div>

                        @if (Auth::user()->is_admin)
                            <details>
                                <summary class="font-size-lg font-color-warning">Данные</summary>

                                <div class="flex-col-13 mar-t-8">
                                    <div class="flex-col-5">
                                        <label class="font-color-second" for="comment">Комментарий</label>
                                        <input class="decor-input" type="text" id="comment" name="comment"
                                            value="{{ old('comment') ?? $user->comment }}"
                                            placeholder="{{ $user->comment }}">
                                    </div>

                                    <div class="flex-col-5">
                                        <label class="font-color-second" for="name">Новый логин</label>
                                        <input class="decor-input" type="text" id="name" name="name"
                                            value="{{ old('wallpaper') ?? $user->name }}"
                                            placeholder="{{ $user->name }}">
                                    </div>

                                    <div class="flex-col-5">
                                        <label class="font-color-second" for="password">Новый пароль</label>
                                        <input class="decor-input" type="password" id="password" name="password"
                                            autocomplete="new-password">
                                    </div>
                                </div>
                            </details>
                        @endif

                        <div class="flex-row-13 flex-grow">
                            <button class="decor-btn" type="submit">Сохранить</button>
                            <button class="decor-btn" type="reset">Сбросить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
