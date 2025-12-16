@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Убежище изгнанников ' . $hideout->name)
@section('description', 'Подробности убежища изгнанников ' . $hideout->name . ' на ' . env('APP_NAME') . ' для Path of Exile')


@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ $hideout->wallpaper ?: asset('img/bg/ho.png') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <div class="flex-row-5">
                                <h1 class="font-size-h1 decor-gold">{{ $hideout->name }}</h1>
                            </div>
                            <p class="font-size-lg">{{ $hideout->getBase() }}</p>

                            @if ($hideout->description)
                                <p class="font-color-second font-size-lg">{{ $hideout->description }}</p>
                            @endif
                            
                            @if ($hideout->getLink())
                                <a class="flex-row-8 flex-ai-center {{ $hideout->getLink()->guarded ?: 'font-color-danger' }}"
                                    href="{{ $hideout->getLink()->url }}" target="_blink"><img width="16px" height="16px"
                                        class="img-contain" src="{{ $hideout->getLink()->favicon }}"><span
                                        class="decor-link">{{ $hideout->getLink()->domain }}</span></a>
                            @endif

                            <div class="flex-row-5 flex-ai-center">
                                <p class="decor-level">{{ $hideout->user->level() }}</p>

                                <a class="decor-link"
                                    href="{{ route('users.show', $hideout->user) }}">{{ $hideout->user->name }}</a>
                                <p class="font-color-second font-size-sm">{{ $hideout->updatedAt() }}</p>
                            </div>
                        </div>

                        @if (Auth::user() && ($hideout->user->id === Auth::id() || Auth::user()->is_admin))
                            <div class="flex-col-13">
                                <div class="flex-row-13 flex-wrap flex-ai-center">
                                    <a class="decor-btn" href="{{ route('hideouts.edit', $hideout) }}">Редактировать</a>

                                    @if (isset($hideout->deleted_at))
                                        <form action="{{ route('hideouts.restore', $hideout) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="decor-btn font-color-success">Восстановить</button>
                                        </form>
                                    @else
                                        <form action="{{ route('hideouts.destroy', $hideout) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="decor-btn font-color-danger">Удалить
                                                убежище</button>
                                        </form>
                                    @endif
                                </div>

                                @if ($hideout->comment)
                                    <p class="font-color-second">{{ $hideout->comment }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                @if ($hideout->icon)
                    <div class="col col-12 col-lg-5">
                        <div class="flex-col-8 flex-center font-center border-r-8 over-hidden">
                            <img class="h-max-144" src="{{ $hideout->icon }}">
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
                                    <h2 class="font-size-h2 decor-gold">Описание убежища</h2>
                                    <p class="font-size-lg">Подробная информация о убежище</p>
                                </div>

                                @if ($hideout->content)
                                    <p class="font-color-second">{!! nl2br(e($hideout->content)) !!}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($hideout->gallery)
                        <div class="row g-4">
                            @foreach ($hideout->gallery() as $image)
                                <div class="col col-4">
                                    <a class="decor-frame-hover pad-3 cursor-zoom-in" href="{{ $image }}"
                                        target="_blank">
                                        <img class="h-max-100 temp-img-cover" src="{{ $image }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <details>
                        <summary class="font-color-second">Подробности о убежище</summary>

                        <div class="flex-col-13 pad-13 decor-area mar-t-8">
                            <p><span class="font-color-second">Язык : </span>{{ $hideout->getLanguage() }}</p>
                            <p><span class="font-color-second">Область : </span>{{ $hideout->getBase() }}</p>
                            <p><span class="font-color-second">Хэшкод : </span>{{ $hideout->getHash() }}</p>
                            <p><span class="font-color-second">Наличие MTX : </span>{{ $hideout->getIsMtx() ? 'Да' : 'Нет' }}</p>
                            <p><span class="font-color-second">Объектов : </span>{{ count($hideout->getDoodads()) }}</p>
                            <p><span class="font-color-second">Разных предметов :
                                </span>{{ count($hideout->getAllUniqueHash()) }}</p>
                            <p><span class="font-color-second">Cоздан : </span> {{ $hideout->created_at }}
                            </p>
                            @if ($hideout->updated_at && $hideout->updated_at != $hideout->created_at)
                                <p><span class="font-color-second">Обновлен : </span>
                                    {{ $hideout->updated_at }}
                                </p>
                            @endif
                            @if ($hideout->deleted_at)
                                <p><span class="font-color-second">Удален : </span>
                                    {{ $hideout->deleted_at }}
                                </p>
                            @endif
                        </div>
                    </details>

                    <details>
                        <summary class="font-color-second">Список предметов ({{ count($doodads) }})</summary>

                        <div class="flex-col-5 pad-13 decor-area mar-t-8">
                            @foreach ($doodads as $key => $value)
                                <div class="row">

                                    <div class="col-1">
                                        <p class="font-color-second font-center {{ $value['mtx'] ? 'font-color-warning' : ''}}">{{ $value['count'] }}</p>
                                    </div>
                                    <div class="col">
                                        <p class="{{ $value['mtx'] ? 'font-color-warning' : ''}}">{{ $value['name'] }}</p>
                                    </div>

                                    <div class="col-2">
                                        <p class="font-color-second font-center">{{ implode(', ', $value['tags']) }}</p>
                                    </div>

                                    <div class="col-2">
                                        <p class="font-color-second font-center">{{ $value['category'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </details>
                </div>
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
                            <h2 class="font-size-h2 decor-gold">Скачать убежище</h2>
                            <p class="font-size-lg">Используйте данный интерьер в своем убежище</p>
                            <p><span class="font-color-second">Скачиваний : </span> {{ $hideout->downloads }}</p>
                        </div>

                        <div class="flex-row-13 flex-ai-center">
                            @if (session($hideout->id))
                                <p class="decor-link active">Есть сохранение</p>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col-8 flex-center decor-particle z-0">
                        <img src="{{ asset('img/decor/menu-select-bg.png') }}">
                        <a class="decor-btn z-1" onclick="return confirm('Скачать файл {{ $hideout->name }}.hideout?');"
                            href="{{ route('hideouts.download', $hideout) }}">Скачать убежище</a>
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
                            <h2 class="font-size-h2 decor-gold">Другие убежища</h2>
                            <p class="font-size-lg">Возможно вам понравятся другие убежища</p>
                        </div>

                        <div class="row g-4">
                            @foreach ($hideouts as $otherhideout)
                                <div class="col col-12 col-md-6 col-lg-4">
                                    @component('resources.hideouts.components.card', ['hideout' => $otherhideout])
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
