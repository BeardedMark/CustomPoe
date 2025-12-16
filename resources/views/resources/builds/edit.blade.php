@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Редактирование сборки персонажа ' . $build->name)
@section('description', 'Редактирование сборки персонажа ' . $build->name . ' в сообществе ' . env('APP_NAME') . ' для Path of Exile')

@section('content')
    <form action="{{ route('builds.update', $build) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
            <div class="pos-abs-fill z-0 decor-back-grad">
                <img class="temp-img-cover" src="{{ $build->wallpaper ?: asset('img/bg/hero-bg.jpg') }}">
            </div>

            <div class="container z-1">
                <div class="row g-4 align-items-center">
                    <div class="col col-12 col-lg">
                        <div class="flex-col-13">
                            <div class="flex-col-8">
                                <h1 class="font-size-h1 decor-gold">Редактирование сборки персонажа</h1>

                                <div class="flex-row-5 flex-ai-end">
                                    <a class="font-size-lg decor-link"
                                        href="{{ route('builds.show', $build) }}">{{ $build->name }}</a>
                                    <span class="font-color-second">.build</span>
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

                                        <div class="flex-col-8">
                                            <div class="flex-col-5">
                                                <label class="font-color-second" for="class">Класс персонажа</label>
                                                <select class="decor-input" id="class" name="class" required>
                                                    @foreach ($build->classes() as $character)
                                                        <option value="{{ $character }}"
                                                            {{ $build->class === $character ? 'selected' : '' }}>
                                                            {{ $character }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="flex-row-13">

                                                <div class="flex-col-5">
                                                    <label class="font-color-second" for="budget">Бюджет сборки</label>
                                                    <input class="decor-input" type="number" min="0" id="budget" name="budget"
                                                        required value="{{ old('budget') ?? $build->budget }}">
                                                </div>
    
                                                <div class="flex-col-5">
                                                    <label class="font-color-second" for="currency">Валюта</label>
                                                    <select class="decor-input" id="currency" name="currency" required>
                                                        @foreach ($build->currencies() as $currency)
                                                            <option value="{{ $currency }}"
                                                                {{ $build->currency === $currency ? 'selected' : '' }}>
                                                                {{ $currency }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="flex-col-5">
                                                <label class="font-color-second" for="league">Лига</label>
                                                <input class="decor-input" type="text" id="league" name="league"
                                                    required value="{{ old('league') ?? $build->league }}">
                                            </div>

                                            <div class="flex-col-5">
                                                <label class="font-color-second" for="version">Версия игры</label>
                                                <input class="decor-input" type="text" id="version" name="version"
                                                    required value="{{ old('version') ?? $build->version }}">
                                            </div>

                                            {{-- <div class="flex-col-5">
                                                <label class="font-color-second" for="class">Основное умение</label>
                                                <select class="decor-input" id="class" name="class" required>
                                                    @foreach ($build->classes() as $character)
                                                        <option value="{{ $character }}"
                                                            {{ $build->class === $character ? 'selected' : '' }}>
                                                            {{ $character }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div> --}}

                                            <div class="flex-col-5">
                                                <label class="font-color-second" for="content">Статья</label>
                                                <textarea class="decor-textbox" type="text" id="content" name="content" rows="10">{{ old('content') ?? $build->content }}</textarea>
                                            </div>

                                            <details>
                                                <summary class="font-size-lg font-color-accent">Геймплей</summary>

                                                <div class="flex-col-13">
                                                    <div class="flex-col-5">
                                                        <label class="font-color-second" for="pros">Плюсы</label>
                                                        <textarea class="decor-textbox" type="text" id="pros" name="pros" rows="5">{{ old('pros') ?? $build->pros }}</textarea>
                                                    </div>

                                                    <div class="flex-col-5">
                                                        <label class="font-color-second" for="cons">Минусы</label>
                                                        <textarea class="decor-textbox" type="text" id="cons" name="cons" rows="5">{{ old('cons') ?? $build->cons }}</textarea>
                                                    </div>

                                                    <div class="flex-col-5">
                                                        <label class="font-color-second" for="important">Особенности</label>
                                                        <textarea class="decor-textbox" type="text" id="important" name="important" rows="5">{{ old('important') ?? $build->important }}</textarea>
                                                    </div>

                                                    <div class="flex-row-34">
                                                        <div class="flex-col-5">
                                                            <label class="font-color-second">Сложность</label>

                                                            <div class="flex-col-5">
                                                                <label class="cursor-pointer flex-row-5" for="hard-1">
                                                                    <input class="decor-checkbox" type="radio"
                                                                        id="hard-1" name="hard" value="1"
                                                                        checked>
                                                                    <span>Низкая</span>
                                                                </label>

                                                                <label class="cursor-pointer flex-row-5" for="hard-2">
                                                                    <input class="decor-checkbox" type="radio"
                                                                        id="hard-2" name="hard" value="2"
                                                                        @if (old('hard') ?? $build->hard == 2) checked @endif>
                                                                    <span>Средняя</span>
                                                                </label>

                                                                <label class="cursor-pointer flex-row-5" for="hard-3">
                                                                    <input class="decor-checkbox" type="radio"
                                                                        id="hard-3" name="hard" value="3"
                                                                        @if (old('hard') ?? $build->hard == 3) checked @endif>
                                                                    <span>Высокая</span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="flex-col-5">
                                                            <label class="font-color-second">Выживаемость</label>

                                                            <div class="flex-col-5">
                                                                <label class="cursor-pointer flex-row-5" for="life-1">
                                                                    <input class="decor-checkbox" type="radio"
                                                                        id="life-1" name="life" value="1"
                                                                        checked>
                                                                    <span>Низкая</span>
                                                                </label>

                                                                <label class="cursor-pointer flex-row-5" for="life-2">
                                                                    <input class="decor-checkbox" type="radio"
                                                                        id="life-2" name="life" value="2"
                                                                        @if (old('life') ?? $build->life == 2) checked @endif>
                                                                    <span>Средняя</span>
                                                                </label>

                                                                <label class="cursor-pointer flex-row-5" for="life-3">
                                                                    <input class="decor-checkbox" type="radio"
                                                                        id="life-3" name="life" value="3"
                                                                        @if (old('life') ?? $build->life == 3) checked @endif>
                                                                    <span>Высокая</span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="flex-col-5">
                                                            <label class="font-color-second">Скорость</label>

                                                            <div class="flex-col-5">
                                                                <label class="cursor-pointer flex-row-5" for="speed-1">
                                                                    <input class="decor-checkbox" type="radio"
                                                                        id="speed-1" name="speed" value="1"
                                                                        checked>
                                                                    <span>Низкая</span>
                                                                </label>

                                                                <label class="cursor-pointer flex-row-5" for="speed-2">
                                                                    <input class="decor-checkbox" type="radio"
                                                                        id="speed-2" name="speed" value="2"
                                                                        @if (old('speed') ?? $build->speed == 2) checked @endif>
                                                                    <span>Средняя</span>
                                                                </label>

                                                                <label class="cursor-pointer flex-row-5" for="speed-3">
                                                                    <input class="decor-checkbox" type="radio"
                                                                        id="speed-3" name="speed" value="3"
                                                                        @if (old('speed') ?? $build->speed == 3) checked @endif>
                                                                    <span>Высокая</span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="flex-col-5">
                                                            <label class="font-color-second">Урон</label>

                                                            <div class="flex-col-5">
                                                                <label class="cursor-pointer flex-row-5" for="damage-1">
                                                                    <input class="decor-checkbox" type="radio"
                                                                        id="damage-1" name="damage" value="1"
                                                                        checked>
                                                                    <span>Низкая</span>
                                                                </label>

                                                                <label class="cursor-pointer flex-row-5" for="damage-2">
                                                                    <input class="decor-checkbox" type="radio"
                                                                        id="damage-2" name="damage" value="2"
                                                                        @if (old('damage') ?? $build->damage == 2) checked @endif>
                                                                    <span>Средняя</span>
                                                                </label>

                                                                <label class="cursor-pointer flex-row-5" for="damage-3">
                                                                    <input class="decor-checkbox" type="radio"
                                                                        id="damage-3" name="damage" value="3"
                                                                        @if (old('damage') ?? $build->damage == 3) checked @endif>
                                                                    <span>Высокая</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </details>

                                            <details>
                                                <summary class="font-size-lg font-color-accent">Предметы</summary>

                                                <div class="flex-col-8">
                                                    <div class="flex-col-5">
                                                        <label class="font-color-second"
                                                            for="character">Персонаж</label>
                                                        <textarea class="decor-textbox" type="text" id="character" name="character" rows="5">{{ old('character') ?? $build->character }}</textarea>
                                                    </div>
                                                    <div class="flex-col-5">
                                                        <label class="font-color-second"
                                                            for="equipment">Экипировка</label>
                                                        <textarea class="decor-textbox" type="text" id="equipment" name="equipment" rows="5">{{ old('equipment') ?? $build->equipment }}</textarea>
                                                    </div>

                                                    <div class="flex-col-5">
                                                        <label class="font-color-second" for="jewels">Самоцветы</label>
                                                        <textarea class="decor-textbox" type="text" id="jewels" name="jewels" rows="5">{{ old('jewels') ?? $build->jewels }}</textarea>
                                                    </div>

                                                    <div class="flex-col-5">
                                                        <label class="font-color-second" for="rucksack">Рюкзак</label>
                                                        <textarea class="decor-textbox" type="text" id="rucksack" name="rucksack" rows="5">{{ old('rucksack') ?? $build->rucksack }}</textarea>
                                                    </div>

                                                    <div class="flex-col-5">
                                                        <label class="font-color-second" for="passives">Пассивные
                                                            навыки</label>
                                                        <textarea class="decor-textbox" type="text" id="passives" name="passives" rows="5">{{ old('passives') ?? $build->passives }}</textarea>
                                                    </div>
                                                </div>
                                            </details>

                                            <details>
                                                <summary class="font-size-lg font-color-accent">Ссылки</summary>

                                                <div class="flex-col-8">
                                                    <div class="flex-col-5">
                                                        <label class="font-color-second" for="pob">Path of Building
                                                            (PoB)</label>
                                                        <input class="decor-input" type="text" id="pob"
                                                            name="pob" value="{{ old('pob') ?? $build->pob }}">
                                                    </div>

                                                    <div class="flex-col-5">
                                                        <label class="font-color-second" for="three">PoE Three</label>
                                                        <input class="decor-input" type="text" id="three"
                                                            name="three" value="{{ old('three') ?? $build->three }}">
                                                    </div>
                                                </div>
                                            </details>
                                        </div>
                                    </div>
                                </div>

                                <div class="col col-12 col-lg-5">
                                    <div class="flex-col-13">
                                        <h2 class="font-size-h2 decor-gold" for="build">Данные</h2>

                                        <div class="flex-col-8">
                                            <div class="flex-col-5">
                                                <label class="font-color-second" for="name">Название</label>
                                                <input class="decor-input" type="text" id="name" name="name"
                                                    required value="{{ old('name') ?? $build->name }}">
                                            </div>

                                            <div class="flex-col-5">
                                                <label class="font-color-second" for="description">Описание</label>
                                                <textarea class="decor-textbox" type="text" id="description" name="description" rows="3">{{ old('description') ?? $build->description }}</textarea>
                                            </div>

                                            <div class="flex-col-5">
                                                <label class="font-color-second" for="comment">Комментарий</label>
                                                <input class="decor-input" type="text" id="comment" name="comment"
                                                    value="{{ old('comment') ?? $build->comment }}">
                                            </div>
                                        </div>

                                        <details>
                                            <summary class="font-size-lg font-color-accent">Изображения</summary>

                                            <div class="flex-col-8 mar-t-8">
                                                <div class="flex-col-5">
                                                    <label class="font-color-second" for="icon">Логотип</label>
                                                    <input class="decor-input" type="text" id="icon"
                                                        name="icon" value="{{ old('icon') ?? $build->icon }}">
                                                </div>

                                                <div class="flex-col-5">
                                                    <label class="font-color-second" for="wallpaper">Обложка</label>
                                                    <input class="decor-input" type="text" id="wallpaper"
                                                        name="wallpaper"
                                                        value="{{ old('wallpaper') ?? $build->wallpaper }}">
                                                </div>

                                                <div class="flex-col-5">
                                                    <label class="font-color-second" for="gallery">Галерея</label>
                                                    <textarea class="decor-textbox" type="text" id="gallery" name="gallery" rows="5">{{ old('gallery') ?? $build->gallery }}</textarea>
                                                </div>
                                            </div>
                                        </details>

                                        <details>
                                            <summary class="font-size-lg font-color-accent">Ссылки</summary>

                                            <div class="flex-col-8 mar-t-8">
                                                <div class="flex-col-5">
                                                    <label class="font-color-second" for="link">Внешняя ссылка</label>
                                                    <input class="decor-input" type="text" id="link"
                                                        name="link" value="{{ old('link') ?? $build->link }}">
                                                </div>

                                                <div class="flex-col-5">
                                                    <label class="font-color-second" for="webhook">Discord вебхук</label>
                                                    <input class="decor-input" type="text" id="webhook"
                                                        name="webhook" value="{{ old('webhook') ?? $build->webhook }}">
                                                </div>
                                            </div>
                                        </details>

                                        @if (Auth::user()->is_admin)
                                            <details>
                                                <summary class="font-size-lg font-color-warning">Приватное</summary>

                                                <div class="flex-col-8 mar-t-8">
                                                    <div class="flex-col-5">
                                                        <label class="font-color-second" for="link">Автор</label>
                                                        <select class="decor-input" id="user_id" name="user_id"
                                                            required>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}"
                                                                    {{ $build->user->id === $user->id ? 'selected' : '' }}>
                                                                    {{ $user->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="flex-col-5">
                                                        <label class="font-color-second" for="poe_id">ID персонажа</label>
                                                        <input class="decor-input" type="text" id="poe_id"
                                                            name="poe_id"
                                                            value="{{ old('poe_id') ?? $build->poe_id }}">
                                                    </div>

                                                    <div class="flex-col-5">
                                                        <label class="font-color-second" for="views">Просмотры</label>
                                                        <input class="decor-input" type="number" id="views"
                                                            name="views" value="{{ old('views') ?? $build->views }}">
                                                    </div>

                                                    <div class="flex-col-5">
                                                        <label class="font-color-second" for="data">JSON Data</label>
                                                        <textarea class="decor-textbox" type="text" id="data" name="data" rows="5">{{ old('data') ?? $build->data }}</textarea>
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
