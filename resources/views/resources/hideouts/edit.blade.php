@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Редактирование убежища изгнанников ' . $hideout->name)
@section('description', 'Редактирование убежища изгнанников ' . $hideout->name . ' в сообществе ' . env('APP_NAME') . ' для Path of Exile')

@section('content')
    <form action="{{ route('hideouts.update', $hideout) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
            <div class="pos-abs-fill z-0 decor-back-grad">
                <img class="temp-img-cover" src="{{ $hideout->wallpaper ?: asset('img/bg/hero-bg.jpg') }}">
            </div>

            <div class="container z-1">
                <div class="row g-4 align-items-center">
                    <div class="col col-12 col-lg">
                        <div class="flex-col-13">
                            <div class="flex-col-8">
                                <h1 class="font-size-h1 decor-gold">Редактирование убежища изгнанников</h1>

                                <div class="flex-row-5 flex-ai-end">
                                    <a class="font-size-lg decor-link"
                                        href="{{ route('hideouts.show', $hideout) }}">{{ $hideout->name }}</a>
                                    <span class="font-color-second">.hideout</span>
                                </div>
                            </div>

                            <p class="font-color-warning">Автор! В связи с возможными вайпами во время разработки, храни
                                копию данных у себя на комптьютере</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

        <section class="pad-y-55">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="flex-col-21">
                            <div class="row">
                                <div class="col col-12 col-lg">
                                    <div class="flex-col-13">
                                        <h2 class="font-size-h2 decor-gold" for="text">Содержимое</h2>
                                        <textarea class="decor-textbox code" type="text" id="text" name="text" rows="30">{{ old('text') ?? $hideout->text }}</textarea>
                                    </div>
                                </div>

                                <div class="col col-12 col-lg-5">
                                    <div class="flex-col-13">
                                        <h2 class="font-size-h2 decor-gold" for="hideout">Данные</h2>

                                        <div class="flex-col-8">
                                            <div class="flex-col-5">
                                                <label class="font-color-second" for="name">Название</label>
                                                <input class="decor-input" type="text" id="name" name="name"
                                                    required value="{{ old('name') ?? $hideout->name }}">
                                            </div>

                                            <div class="flex-col-5">
                                                <label class="font-color-second" for="description">Описание</label>
                                                <textarea class="decor-textbox" type="text" id="description" name="description" rows="3">{{ old('description') ?? $hideout->description }}</textarea>
                                            </div>
                                        </div>

                                        <details>
                                            <summary class="font-size-lg">Дополнительно</summary>

                                            <div class="flex-col-8 mar-t-8">
                                                {{-- <div class="flex-col-5">
                                                    <label class="font-color-second" for="base">Базовая область</label>
                                                    <select class="decor-input" id="base" name="base" required>
                                                        @foreach ($hideout->bases() as $base)
                                                            <option value="{{ $base }}"
                                                                {{ $hideout->base === $base ? 'selected' : '' }}>
                                                                {{ $base }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div> --}}

                                                <div class="flex-col-5">
                                                    <label class="font-color-second" for="content">Статья</label>
                                                    <textarea class="decor-textbox" type="text" id="content" name="content" rows="10">{{ old('content') ?? $hideout->content }}</textarea>
                                                </div>

                                                <div class="flex-col-5">
                                                    <label class="font-color-second" for="comment">Комментарий</label>
                                                    <input class="decor-input" type="text" id="comment" name="comment"
                                                        value="{{ old('comment') ?? $hideout->comment }}">
                                                </div>
                                            </div>
                                        </details>

                                        <details>
                                            <summary class="font-size-lg">Изображения</summary>

                                            <div class="flex-col-8 mar-t-8">
                                                <div class="flex-col-5">
                                                    <label class="font-color-second" for="icon">Логотип</label>
                                                    <input class="decor-input" type="text" id="icon"
                                                        name="icon" value="{{ old('icon') ?? $hideout->icon }}">
                                                </div>

                                                <div class="flex-col-5">
                                                    <label class="font-color-second" for="wallpaper">Обложка</label>
                                                    <input class="decor-input" type="text" id="wallpaper"
                                                        name="wallpaper"
                                                        value="{{ old('wallpaper') ?? $hideout->wallpaper }}">
                                                </div>

                                                <div class="flex-col-5">
                                                    <label class="font-color-second" for="gallery">Галерея</label>
                                                    <textarea class="decor-textbox" type="text" id="gallery" name="gallery" rows="5">{{ old('gallery') ?? $hideout->gallery }}</textarea>
                                                </div>
                                            </div>
                                        </details>

                                        <details>
                                            <summary class="font-size-lg">Ссылки</summary>

                                            <div class="flex-col-8 mar-t-8">
                                                <div class="flex-col-5">
                                                    <label class="font-color-second" for="link">Внешняя ссылка</label>
                                                    <input class="decor-input" type="text" id="link"
                                                        name="link" value="{{ old('link') ?? $hideout->link }}">
                                                </div>

                                                <div class="flex-col-5">
                                                    <label class="font-color-second" for="webhook">Discord вебхук</label>
                                                    <input class="decor-input" type="text" id="webhook"
                                                        name="webhook" value="{{ old('webhook') ?? $hideout->webhook }}">
                                                </div>
                                            </div>
                                        </details>

                                        @if (Auth::user()->is_admin)
                                            <details>
                                                <summary class="font-size-lg font-color-warning">Данные</summary>

                                                <div class="flex-col-8 mar-t-8">
                                                    <div class="flex-col-5">
                                                        <label class="font-color-second" for="link">Автор</label>
                                                        <select class="decor-input" id="user_id" name="user_id" required>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}"
                                                                    {{ $hideout->user->id === $user->id ? 'selected' : '' }}>
                                                                    {{ $user->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="flex-col-5">
                                                        <label class="font-color-second" for="downloads">Скачивания</label>
                                                        <input class="decor-input" type="number" id="downloads"
                                                            name="downloads"
                                                            value="{{ old('downloads') ?? $hideout->downloads }}">
                                                    </div>

                                                    <div class="flex-col-5">
                                                        <label class="font-color-second" for="views">Просмотры</label>
                                                        <input class="decor-input" type="number" id="views"
                                                            name="views"
                                                            value="{{ old('views') ?? $hideout->views }}">
                                                    </div>

                                                    <div class="flex-col-5">
                                                        <label class="font-color-second" for="data">Данные</label>
                                                        <textarea class="decor-textbox" type="text" id="data" name="data" rows="5">{{ old('data') ?? $hideout->data }}</textarea>
                                                    </div>
                                                </div>
                                            </details>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="flex-row-13 flex-end">
                                        <button class="decor-btn" type="reset">Сбросить</button>
                                        <button class="decor-btn" type="submit">Сохранить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection
