@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Фильтр предметов ' . $filter->name)
@section('description', 'Подробности фильтра предметов ' . $filter->name . ' на ' . env('APP_NAME') . ' для Path of Exile')

@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ $filter->wallpaper ?: asset('img/bg/items.jpg') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <div class="flex-row-5">
                                <h1 class="font-size-h1 decor-gold">{{ $filter->name }}</h1>
                            </div>

                            @if ($filter->description)
                                <p class="font-color-accent font-size-lg">{{ $filter->description }}</p>
                            @endif
                            
                            @if ($filter->getLink())
                                <a class="flex-row-8 flex-ai-center {{ $filter->getLink()->guarded ?: 'font-color-danger' }}"
                                    href="{{ $filter->getLink()->url }}" target="_blink"><img width="16px" height="16px"
                                        class="img-contain" src="{{ $filter->getLink()->favicon }}"><span
                                        class="decor-link">{{ $filter->getLink()->domain }}</span></a>
                            @endif

                            <div class="flex-row-5 flex-ai-center">
                                <p class="decor-level">{{ $filter->user->level() }}</p>

                                <a class="decor-link"
                                    href="{{ route('users.show', $filter->user) }}">{{ $filter->user->name }}</a>
                                <p class="font-color-second font-size-sm">{{ $filter->updatedAt() }}</p>
                            </div>
                        </div>

                        @if (Auth::user() && ($filter->user->id === Auth::id() || Auth::user()->is_admin))
                            <div class="flex-col-13">
                                <div class="flex-row-13 flex-wrap flex-ai-center">
                                    <a class="decor-btn" href="{{ route('filters.edit', $filter) }}">Редактировать</a>
                                    @if (Auth::user()->is_admin)
                                        <a class="decor-btn" href="{{ route('filters.export', $filter) }}">Экспорт
                                            данных</a>
                                    @endif

                                    @if (isset($filter->deleted_at))
                                        <form action="{{ route('filters.restore', $filter) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="decor-btn font-color-success">Восстановить</button>
                                        </form>
                                    @else
                                        <form action="{{ route('filters.destroy', $filter) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="decor-btn font-color-danger">Удалить
                                                фильтр</button>
                                        </form>
                                    @endif
                                </div>

                                @if ($filter->comment)
                                    <p class="font-color-second">{{ $filter->comment }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                @if ($filter->icon)
                    <div class="col col-12 col-lg-5">
                        <div class="flex-col-8 flex-center font-center border-r-8 over-hidden">
                            <img class="h-max-144" src="{{ $filter->icon }}">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    <section class="pad-y-98">
        <div class="container">
            <div class="flex-col-34">
                <div class="flex-col-21">
                    <div class="row g-4">
                        <div class="col col-12 col-lg">
                            <div class="flex-col-21">
                                <div class="flex-col-8">
                                    <h2 class="font-size-h2 decor-gold">Описание фильтра</h2>
                                    <p class="font-size-lg font-color-accent">Подробная информация о фильтре предметов</p>
                                </div>

                                @if ($filter->content)
                                    <p>{{ $filter->content }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($filter->gallery)
                        <div class="row g-4">
                            @foreach ($filter->gallery() as $image)
                                <div class="col col-4">
                                    <a class="decor-frame-hover pad-3 cursor-zoom-in" href="{{ $image }}" target="_blank">
                                        <img class="h-max-100 temp-img-cover" src="{{ $image }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <details>
                        <summary class="font-color-second">Подробности о фильтре</summary>

                        <div class="flex-col-13 pad-13 decor-area mar-t-8">
                            <p><span class="font-color-second">Скачиваний : </span> {{ $filter->downloads }}</p>
                            @if ($filter->version)
                                <p><span class="font-color-second">Версия : </span> {{ $filter->version }}</p>
                            @endif
                            <p><span class="font-color-second">Тип : </span> {{ $filter->type }}</p>
                            <p><span class="font-color-second">Платформа : </span> {{ $filter->realm }}</p>
                            <p><span class="font-color-second">Cоздан : </span> {{ $filter->created_at }}
                            </p>
                            @if ($filter->updated_at && $filter->updated_at != $filter->created_at)
                                <p><span class="font-color-second">Обновлен : </span>
                                    {{ $filter->updated_at }}
                                </p>
                            @endif
                            @if ($filter->deleted_at)
                                <p><span class="font-color-second">Удален : </span>
                                    {{ $filter->deleted_at }}
                                </p>
                            @endif
                        </div>
                    </details>
                </div>

                @if (count($palette) > 0)
                    <div class="flex-col-21">
                        <div class="row g-4">
                            <div class="col col-12 col-lg">
                                <div class="flex-col-21">
                                    <div class="flex-col-8">
                                        <h3 class="font-size-h3 decor-gold">Палитра стилей</h3>
                                        <p class="font-size-lg font-color-accent">Все уникальные комбинации окрасок табличек</p>
                                    </div>

                                    <div class="flex-row-13 flex-wrap">
                                        @foreach ($palette as $rule)
                                            @component('resources.filters.components.preview', compact('rule'))
                                            @endcomponent
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/bg/wallpaperflare.com_wallpaper.jpg') }}">
        </div>
        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold">Использовать фильтр</h2>
                            <p class="font-size-lg">Измените фильтр для большего комфорта во время игры</p>
                        </div>

                        @if (session($filter->id))
                        <p class="decor-link active">Есть сохранение</p>
                    @endif

                        <div class="flex-col flex-start">
                            <p class="font-color-second">Так же можете скачать оригинальный фильтр премдетов</p>
                            <a class="decor-link"
                                href="{{ route('settings.download', $filter) }}">{{ $filter->name }}.filter</a>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col-8 flex-center decor-particle z-0">
                        <img src="{{ asset('img/decor/menu-select-bg.png') }}">
                        <a class="decor-btn z-1" href="{{ route('settings.index', $filter) }}">Применить фильтр</a>
                        <img class="flip-y" src="{{ asset('img/decor/menu-select-bg.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    <section class="pad-y-98">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold">Другие фильтры</h2>
                            <p class="font-size-lg">Возможно вам понравятся другие фильтры предметов</p>
                        </div>

                        <div class="row g-4">
                            @foreach ($filters as $otherFilter)
                                <div class="col col-12 col-md-6 col-lg-4">
                                    @component('resources.filters.components.card', ['filter' => $otherFilter])
                                        )
                                    @endcomponent
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
