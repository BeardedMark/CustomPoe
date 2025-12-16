@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Настройки фильтра предметов')
@section('description', 'Настройки фильтра предметов от сообщества ' . env('APP_NAME') . ' для Path of Exile')

@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ $filter->wallpaper ?: asset('img/bg/hero-bg.jpg') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-13">
                        <div class="flex-col-8">
                            <h1 class="font-size-h1 decor-gold">Настройка фильтра предметов</h1>
                            <div class="flex-row-5 flex-ai-end">
                                <a class="font-size-lg decor-link"
                                    href="{{ route('filters.show', $filter) }}">{{ $filter->name }}</a>
                                <span class="font-color-second">.filter</span>
                            </div>
                        </div>

                        @if (session($filter->id))
                            <p class="decor-link active cursor-def">Есть сохранение</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    <form id="settingsForm" action="{{ route('settings.store', $filter) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <section class="pad-y-98">
            <div class="container">
                <div class="flex-col-34">
                    <div class="row">
                        <div class="col col-12 col-lg">
                            <div class="flex-col-8">
                                <h2 class="font-size-h2 decor-gold">Настройки правил</h2>

                                @foreach ($groups as $group)
                                    @if (count($groups) > 1)
                                        <details>
                                            <summary class="font-color-second font-size-lg">{{ $group->name }}
                                                @if($group->description)
                                                    <span class="font-size-sm font-color-second cursor-help pad-x-5"
                                                        data-tooltip="{{ $group->description }}">?</span>
                                                @endif
                                            </summary>
                                    @endif

                                    <div class="flex-col-5 mar-t-5">
                                        @foreach ($group->sections as $section)
                                            @component('resources.settings.components.section', compact('section', 'settings'))
                                            @endcomponent
                                        @endforeach
                                    </div>

                                    @if (count($groups) > 1)
                                        </details>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="col col-12 col-lg-5">
                            <div class="flex-col flex-center">
                                <img clas src="{{ asset('img/decor/title-border.png') }}">
                                <div class="flex-col-13 pad-13 decor-area over-x-auto">
                                    <h3 class="font-size-h3 decor-gold">Глобальные настройки</h3>

                                    <div class="flex-col-8 pad-l-8">
                                        <details open>
                                            <summary class="font-color-second font-size-lg">Таблички</summary>

                                            <ul class="flex-col-13 mar-y-5 pad-l-8">
                                                <li>
                                                    <label class="cursor-pointer temp-link" for="volume-default">
                                                        Изменение масштаба <output class="decor-link active" for="size"
                                                            id="sizeOutput">{{ $settings->{'global'}->{'size'} ?? 0 }}</output>%
                                                    </label>

                                                    <input type="range" id="size" name="global[size]" min="-100"
                                                        max="100" value="{{ $settings->{'global'}->{'size'} ?? 0 }}"
                                                        oninput="document.getElementById('sizeOutput').value = this.value">
                                                </li>

                                                <li>
                                                    <label
                                                        class="flex-row-5 flex-ai-center cursor-pointer cursor-select-no temp-link"
                                                        for="transparent">
                                                        <input class="decor-checkbox" type="checkbox" id="transparent"
                                                            value="off" name="global[transparent]"
                                                            @isset($settings->{'global'}->{'transparent'})
                                                            checked
                                                            @endisset>
                                                        Отключить прозрачность
                                                    </label>
                                                </li>
                                            </ul>
                                        </details>

                                        <details open>
                                            <summary class="font-color-second font-size-lg">Звуки</summary>

                                            <ul class="flex-col-13 mar-y-5 pad-l-8">
                                                <li>
                                                    <label class="cursor-pointer temp-link" for="volume">
                                                        Изменение громкости <output class="decor-link active" for="volume"
                                                            id="volumeOutput">{{ $settings->{'global'}->{'volume'} ?? 0 }}</output>%
                                                    </label>

                                                    <input type="range" id="volume" name="global[volume]"
                                                        min="-100" max="100"
                                                        value="{{ $settings->{'global'}->{'volume'} ?? null }}"
                                                        oninput="document.getElementById('volumeOutput').value = this.value">
                                                </li>

                                                <li>
                                                    <label
                                                        class="flex-row-5 flex-ai-center cursor-pointer cursor-select-no temp-link"
                                                        for="setVolume">
                                                        <input class="decor-checkbox" type="checkbox" id="setVolume"
                                                            name="global[setVolume]"
                                                            @isset($settings->{'global'}->{'setVolume'})
                                                            checked
                                                            @endisset>
                                                        Одинаковая громкость всех звуков
                                                    </label>
                                                </li>

                                                <li>
                                                    <label
                                                        class="flex-row-5 flex-ai-center cursor-pointer cursor-select-no temp-link"
                                                        for="customSounds">
                                                        <input class="decor-checkbox" type="checkbox" id="customSounds"
                                                            value="off" name="global[customSounds]"
                                                            @isset($settings->{'global'}->{'customSounds'})
                                                            checked
                                                            @endisset>
                                                        Не использовать аудиофайлы
                                                    </label>
                                                </li>

                                                <li>
                                                    <label
                                                        class="flex-row-5 flex-ai-center cursor-pointer cursor-select-no temp-link"
                                                        for="posSound">
                                                        <input class="decor-checkbox" type="checkbox" id="posSound"
                                                            value="off" name="global[posSound]"
                                                            @isset($settings->{'global'}->{'posSound'})
                                                            checked
                                                            @endisset>
                                                        Отключить пространственный звук
                                                    </label>
                                                </li>

                                                {{-- <li>
                                                    <label
                                                        class="flex-row-5 flex-ai-center cursor-pointer cursor-select-no temp-link"
                                                        for="defSound">
                                                        <input class="decor-checkbox" type="checkbox" id="defSound"
                                                            value="off" name="global[defSound]"
                                                            @isset($settings->{'global'}->{'defSound'})
                                                            checked
                                                            @endisset>
                                                        Заглушить стандартные звуки
                                                    </label>
                                                </li> --}}
                                            </ul>
                                        </details>

                                        <details open>
                                            <summary class="font-color-second font-size-lg">Эффекты</summary>

                                            <ul class="flex-col-13 mar-y-5 pad-l-8">
                                                <li>
                                                    <label class="flex-row-5 flex-ai-center cursor-pointer temp-link"
                                                        for="icons">
                                                        <input class="decor-checkbox" type="checkbox" id="icons"
                                                            value="off" name="global[icons]"
                                                            @isset($settings->{'global'}->{'icons'})
                                                            checked
                                                            @endisset>
                                                        Скрыть иконки миникарты
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="flex-row-5 flex-ai-center cursor-pointer temp-link"
                                                        for="rays">
                                                        <input class="decor-checkbox" type="checkbox" id="rays"
                                                            value="off" name="global[rays]"
                                                            @isset($settings->{'global'}->{'rays'})
                                                            checked
                                                            @endisset>
                                                        Выключить лучи выпадения
                                                    </label>
                                                </li>
                                            </ul>
                                        </details>

                                        {{-- <details open>
                                            <summary class="font-color-second font-size-lg">Дополнительно</summary>

                                            <ul class="flex-col-13 mar-y-5 pad-l-8">
                                                <li>
                                                    <label class="flex-row-5 flex-ai-center cursor-pointer temp-link"
                                                        for="trash">
                                                        <input class="decor-checkbox" type="checkbox" id="trash"
                                                            value="off" name="global[trash]"
                                                            @isset($settings->{'global'}->{'trash'})
                                                            checked
                                                            @endisset>
                                                        Скрывать мусор при Alt
                                                    </label>
                                                </li>
                                            </ul>
                                        </details> --}}

                                        @if (Auth::check() && Auth::user()->is_admin)
                                            <details>
                                                <summary class="font-color-warning font-size-lg">Сохранение</summary>

                                                <div class="flex-col-13 mar-y-5 pad-l-8">
                                                    <pre class="code">{{ json_encode($settings, JSON_PRETTY_PRINT) }}</pre>
                                                </div>
                                            </details>

                                            <details>
                                                <summary class="font-color-warning font-size-lg">Uncown commands</summary>

                                                <div class="flex-col-13 mar-y-5 pad-l-8">
                                                    <pre class="code">{{ implode("\n", $uncownCommands) }}</pre>
                                                </div>
                                            </details>
                                        @endif
                                    </div>
                                </div>

                                <img src="{{ asset('img/decor/title-border-bottom.png') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">
    </form>

    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/bg/wallpaperflare.com_wallpaper.jpg') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-row-13">
                        <button class="decor-btn"
                            onclick="document.getElementById('settingsForm').submit();">Сохранить</button>
                        <button class="decor-btn" onclick="document.getElementById('settingsForm').reset();">Отменить
                            изменения</button>
                        @if (session($filter->id))
                            <form class="flex-row-13 flex-ai-center" action="{{ route('settings.destroy', $filter) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="decor-btn font-color-danger"
                                    onclick="return confirm('Очистить сохранения?');"
                                    href="{{ route('settings.download', $filter) }}">Удалить сохранение</button>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col-8 flex-center decor-particle z-0">
                        <a class="decor-btn z-1"
                            onclick="return confirm('Несохраненные изменения будут потеряны. Продолжить?');"
                            href="{{ route('settings.download', $filter) }}"
                            href="{{ route('settings.download', $filter) }}">Скачать фильтр</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    <section class="pad-y-98">
        <div class="container">
            <div class="row g-4">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold">Содержимое фильтра</h2>
                            <p class="font-size-lg">Оригинал фильтра предметов в текстовом виде</p>
                        </div>

                        <div class="flex-col flex-center">
                            <img clas src="{{ asset('img/decor/title-border.png') }}">
                            <div class="flex-col-13 pad-13 decor-area flex-ai-start over-x-auto" style="max-height: 66vh">
                                <pre class="code w-100" id="content">{{ $filter->filter }}</pre>
                            </div>
                            <img src="{{ asset('img/decor/title-border-bottom.png') }}">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
