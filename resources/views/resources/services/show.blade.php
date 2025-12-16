@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Объявление изгнанника ' . $service->name)
@section('description', 'Подробности объявления изгнанника ' . $service->name . ' на ' . env('APP_NAME') . ' для Path of
    Exile')

@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ $service->wallpaper ?: asset('img/bg/service.png') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <div class="flex-row-5">
                                <h1 class="font-size-h1 decor-gold">{{ $service->name }}</h1>
                            </div>

                            @if ($service->description)
                                <p class="font-color-accent font-size-lg">{{ $service->description }}</p>
                            @endif

                            <div class="flex-row-5 flex-ai-center font-size-lg">
                                <svg class="stroke-color-contrast" width="16" height="16" viewBox="0 0 16 16"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.5 2.5V5.5M11.5 7.5V5.5M11.5 7.5V9.5M11.5 7.5C11.5 7.5 9.5 5.5 7.5 5.5M11.5 7.5C11.5 7.5 9.5 9.5 7.5 9.5M3.5 7.5V9.5M3.5 7.5V5.5M3.5 7.5C3.5 7.5 5.5 5.5 7.5 5.5M3.5 7.5C3.5 7.5 5.5 9.5 7.5 9.5M7.5 12.5V9.5M7.5 5.5V7.5V9.5"
                                        stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M14.5 7.5C14.5 11.366 11.366 14.5 7.5 14.5C3.63401 14.5 0.5 11.366 0.5 7.5C0.5 3.63401 3.63401 0.5 7.5 0.5C11.366 0.5 14.5 3.63401 14.5 7.5Z"
                                        stroke="#4D4A45" />
                                </svg>

                                <p><span class="decor-link active">{{ $service->price }}</span><span
                                        class="font-color-second"> {{ $service->currency }}</span></p>
                            </div>

                            @if ($service->getLink())
                                <a class="flex-row-8 flex-ai-center {{ $service->getLink()->guarded ?: 'font-color-danger' }}"
                                    href="{{ $service->getLink()->url }}" target="_blink"><img width="16px" height="16px"
                                        class="img-contain" src="{{ $service->getLink()->favicon }}"><span
                                        class="decor-link">{{ $service->getLink()->domain }}</span></a>
                            @endif

                            <div class="flex-row-5 flex-ai-center">
                                <p class="decor-level">{{ $service->user->level() }}</p>

                                <a class="decor-link"
                                    href="{{ route('users.show', $service->user) }}">{{ $service->user->name }}</a>
                                <p class="font-color-second font-size-sm">{{ $service->updatedAt() }}</p>
                            </div>
                        </div>

                        @if (Auth::user() && ($service->user->id === Auth::id() || Auth::user()->is_admin))
                            <div class="flex-col-13">
                                <div class="flex-row-13 flex-wrap flex-ai-center">
                                    <a class="decor-btn" href="{{ route('services.edit', $service) }}">Редактировать</a>

                                    @if (isset($service->deleted_at))
                                        <form action="{{ route('services.restore', $service) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="decor-btn font-color-success">Восстановить</button>
                                        </form>
                                    @else
                                        <form action="{{ route('services.destroy', $service) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="decor-btn font-color-danger">Удалить
                                                Объявление</button>
                                        </form>
                                    @endif
                                </div>

                                @if ($service->comment)
                                    <p class="font-color-second">{{ $service->comment }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                @if ($service->icon)
                    <div class="col col-12 col-lg-5">
                        <div class="flex-col-8 flex-center font-center border-r-8 over-hidden">
                            <img class="h-max-144" src="{{ $service->icon }}">
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
                                    <h2 class="font-size-h2 decor-gold">Описание объявления</h2>
                                    <p class="font-size-lg font-color-accent">Подробная информация об объявлении</p>
                                </div>

                                @if ($service->content)
                                    <p>{{ $service->content }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($service->gallery)
                        <div class="row g-4">
                            @foreach ($service->gallery() as $image)
                                <div class="col col-4">
                                    <a class="decor-frame-hover pad-3 cursor-zoom-in" href="{{ $image }}"
                                        target="_blank">
                                        <img class="h-max-100 temp-img-cover" src="{{ $image }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <details {{ $service->content || $service->gallery ?: 'open' }}>
                        <summary class="font-color-second">Подробности об объявлении</summary>

                        <div class="flex-col-13 pad-13 decor-area mar-t-8">
                            @if ($service->version)
                                <p><span class="font-color-second">Версия : </span> {{ $service->version }}</p>
                            @endif

                            <p><span class="font-color-second">Тип : </span> {{ $service->type }}</p>
                            <p><span class="font-color-second">Количество : </span> {{ $service->count }}</p>
                            <p><span class="font-color-second">Цена : </span> {{ $service->price }}
                                {{ $service->currency }}</p>
                            <p><span class="font-color-second">Cоздан : </span> {{ $service->created_at }}</p>

                            @if ($service->updated_at && $service->updated_at != $service->created_at)
                                <p><span class="font-color-second">Обновлен : </span>
                                    {{ $service->updated_at }}
                                </p>
                            @endif

                            @if ($service->deleted_at)
                                <p><span class="font-color-second">Удален : </span>
                                    {{ $service->deleted_at }}
                                </p>
                            @endif

                            <p><span class="font-color-second">Обращений : </span> {{ $service->whisps }}</p>
                            <p><span class="font-color-second">Просмотров : </span> {{ $service->views }}</p>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </section>

    <img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}">

    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/bg/wallpaperflare.com_wallpaper.jpg') }}">
        </div>
        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold">Откликнутся на объявление</h2>
                            <p class="font-size-lg font-color-accent">Напишите автору объявления в игре</p>
                            <p class="lock" id="message">{{ $service->getMessageText() }}</p>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col-8 flex-center decor-particle z-0">
                        <img src="{{ asset('img/decor/menu-select-bg.png') }}">
                        {{-- <button class="decor-btn z-1"
                            onclick="copyToClipboard('{{ '\@' . $service->user->name }} {{ $service->name }}')">Личное
                            сообщение</button> --}}
                        <button class="decor-btn z-1" onclick="copyToText()">Скопировать сообщение</button>

                        <script>
                            function copyToText() {
                                var text = document.getElementById('message').innerText;
                                var button = event.target;
                                navigator.clipboard.writeText(text).then(function() {
                                    button.innerText = 'Сообщение скопировано!';
                                }, function(err) {
                                    button.innerText = 'Ошибка копирования';
                                });

                                fetch('{{ route('services.whisp', $service) }}');
                            }
                        </script>
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
                            <h2 class="font-size-h2 decor-gold">Другие объявления</h2>
                            <p class="font-size-lg font-color-accent">Возможно вам могут пригодится другие предложения</p>
                        </div>

                        <div class="row g-4">
                            @foreach ($services as $otherservice)
                                <div class="col col-12 col-md-6 col-lg-4">
                                    @component('resources.services.components.card', ['service' => $otherservice])
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
