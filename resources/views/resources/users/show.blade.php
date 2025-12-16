@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Профиль пользователя ' . $user->name)
@section('description', 'Подробности профиля пользователя ' . $user->name . ' на ' . env('APP_NAME') . ' для Path of
    Exile')

@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ $user->wallpaper ?: asset('img/bg/hero-bg.jpg') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg-7">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <div class="flex-col-5">
                                <h1 class="font-size-h1 decor-gold">{{ $user->name }}</h1>

                                <a class="flex-row-8 flex-ai-center"
                                    href="https://ru.pathofexile.com/account/view-profile/{{ $user->name }}"
                                    target="_blink">
                                    <img width="16px" height="16px" class="img-contain"
                                        src="https://ru.pathofexile.com/favicon.ico">
                                    <span class="decor-link cursor-alias">Профиль Path of Exile</span>
                                </a>

                                @if ($user->description)
                                    <p class="font-size-lg">{{ $user->description ?? '' }}</p>
                                @endif

                                <div class="flex-col-5 flex-jc-start">
                                    <p class="flex-row-5 flex-ai-center">{{ $user->role() }}<span
                                            class="decor-link active">{{ $user->level() }}</span> уровень</p>
                                </div>
                            </div>
                        </div>

                        @if (Auth::check() && (Auth::user()->is_admin || Auth::user() == $user))
                            <div class="flex-col-13">
                                <div class="flex-row-13 flex-wrap flex-ai-center">
                                    <a class="decor-btn" href="{{ route('users.edit', $user) }}">Редактировать</a>

                                    @if (Auth::user()->is_admin)
                                        @if (isset($user->deleted_at))
                                            <form action="{{ route('users.restore', $user) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="decor-btn font-color-success">Восстановить</button>
                                            </form>
                                        @else
                                            <form action="{{ route('users.destroy', $user) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="decor-btn font-color-danger">Удалить</button>
                                            </form>
                                        @endif
                                    @endif
                                </div>

                                @if ($user->comment && (Auth::check() && Auth::user()->is_admin))
                                    <p class="font-color-second">{{ $user->comment }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                @if ($user->avatar)
                    <div class="col col-12 col-lg-5">
                        <div class="flex-col-8 flex-center font-center border-r-8 over-hidden">
                            <img class="decor-frame pad-5 h-max-144" src="{{ $user->avatar }}">
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
                                    <h2 class="font-size-h2 decor-gold">Описание пользователя</h2>
                                    <p class="font-size-lg">Подробная информация о пользователе</p>
                                </div>

                                @if ($user->content)
                                    <p class="font-color-second">{{ $user->content }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($user->gallery)
                        <div class="row g-4">
                            @foreach ($user->gallery() as $image)
                                <div class="col col-4">
                                    <a class="decor-frame-hover pad-3 cursor-zoom-in" href="{{ $image }}"
                                        target="_blank">
                                        <img class="h-max-100 temp-img-cover" src="{{ $image }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <details open>
                        <summary class="font-color-second">Подробности пользователе</summary>

                        <div class="flex-col-13 pad-13 decor-area mar-t-8">
                            {{-- <pre>{{ json_encode($user->getCharacters(), JSON_PRETTY_PRINT) }}</pre> --}}
                            <div class="flex-col-5">
                                <p><span class="font-color-second">Уровень : </span> {{ $user->level() }}</p>
                                <p><span class="font-color-second">Всего опыта : </span> {{ $user->experience() }}</p>
                                <p><span class="font-color-second">Опыта до уровня : </span>
                                    {{ $user->experienceToNextLevel() }}</p>
                                <p><span class="font-color-second">Опыта в день : </span>
                                    {{ $user->experiencePerDay() }}</p>
                            </div>

                            <div class="flex-col-5">
                                <p><span class="font-color-second">Просмотров : </span> {{ $user->views() }}</p>
                                <p><span class="font-color-second">Скачиваний : </span> {{ $user->downloads() }}</p>
                                <p><span class="font-color-second">Сделок : </span> {{ $user->whisps() }}</p>
                            </div>

                            <div class="flex-col-5">
                                <p><span class="font-color-second">Cоздан : </span> {{ $user->created_at }}</p>
                                @if ($user->updated_at && $user->updated_at != $user->created_at)
                                    <p><span class="font-color-second">Обновлен : </span>
                                        {{ $user->updated_at }}
                                    </p>
                                @endif
                                @if ($user->deleted_at)
                                    <p><span class="font-color-second">Удален : </span>
                                        {{ $user->deleted_at }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </section>

    @if (count($user->services()) > 0)
        <img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

        <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
            <div class="pos-abs-fill z-0 decor-back-grad">
                <img class="temp-img-cover" src="{{ asset('img/bg/service.png') }}">
            </div>

            <div class="container z-1">
                <div class="row g-4 align-items-center">
                    <div class="col col-12 col-lg">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold ">Объявления изгнанника</h2>
                            <p class="font-size-lg font-color-second">
                                Всего создано автором : <span
                                    class="decor-link active">{{ count($user->services()) }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="col col-12 col-lg-5">
                        <div class="flex-col-8 flex-center">
                            <img src="{{ asset('img/decor/menu-select-bg.png') }}">
                            <a class="decor-btn" href="{{ route('services.index', ['autor' => $user->id]) }}">Все
                                объявления автора</a>
                            <img class="flip-y" src="{{ asset('img/decor/menu-select-bg.png') }}">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

        <section class="pad-y-98">
            <div class="container">
                <div class="row g-4">
                    @foreach ($user->services(3) as $service)
                        <div class="col col-12 col-md-6 col-lg-4">
                            @component('resources.services.components.card', compact('service'))
                            @endcomponent
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if (count($user->builds()) > 0)
        <img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

        <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
            <div class="pos-abs-fill z-0 decor-back-grad">
                <img class="temp-img-cover" src="{{ asset('img/bg/threePassive.png') }}">
            </div>

            <div class="container z-1">
                <div class="row g-4 align-items-center">
                    <div class="col col-12 col-lg">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold ">Сборки персонажей</h2>
                            <p class="font-size-lg font-color-second">
                                Всего создано автором : <span
                                    class="decor-link active">{{ count($user->builds()) }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="col col-12 col-lg-5">
                        <div class="flex-col-8 flex-center">
                            <img src="{{ asset('img/decor/menu-select-bg.png') }}">
                            <a class="decor-btn" href="{{ route('builds.index', ['autor' => $user->id]) }}">Все
                                сборки автора</a>
                            <img class="flip-y" src="{{ asset('img/decor/menu-select-bg.png') }}">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

        <section class="pad-y-98">
            <div class="container">
                <div class="row g-4">
                    @foreach ($user->builds(3) as $build)
                        <div class="col col-12 col-md-6 col-lg-4">
                            @component('resources.builds.components.card', compact('build'))
                            @endcomponent
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if (count($user->filters()) > 0)
        <img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

        <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
            <div class="pos-abs-fill z-0 decor-back-grad">
                <img class="temp-img-cover" src="{{ asset('img/bg/items.jpg') }}">
            </div>

            <div class="container z-1">
                <div class="row g-4 align-items-center">
                    <div class="col col-12 col-lg">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold ">Фильтры предметов</h2>
                            <p class="font-size-lg font-color-second">
                                Всего создано автором : <span
                                    class="decor-link active">{{ count($user->filters()) }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="col col-12 col-lg-5">
                        <div class="flex-col-8 flex-center">
                            <img src="{{ asset('img/decor/menu-select-bg.png') }}">
                            <a class="decor-btn" href="{{ route('filters.index', ['autor' => $user->id]) }}">Все фильтры
                                автора</a>
                            <img class="flip-y" src="{{ asset('img/decor/menu-select-bg.png') }}">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

        <section class="pad-y-98">
            <div class="container">
                <div class="row g-4">
                    @foreach ($user->filters(3) as $filter)
                        <div class="col col-12 col-md-6 col-lg-4">
                            @component('resources.filters.components.card', compact('filter'))
                            @endcomponent
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if (count($user->hideouts()) > 0)
        <img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

        <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
            <div class="pos-abs-fill z-0 decor-back-grad">
                <img class="temp-img-cover" src="{{ asset('img/bg/ho.png') }}">
            </div>

            <div class="container z-1">
                <div class="row g-4 align-items-center">
                    <div class="col col-12 col-lg">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold ">Убежища изгнанников</h2>
                            <p class="font-size-lg font-color-second">
                                Всего создано автором : <span
                                    class="decor-link active">{{ count($user->hideouts()) }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="col col-12 col-lg-5">
                        <div class="flex-col-8 flex-center">
                            <img src="{{ asset('img/decor/menu-select-bg.png') }}">
                            <a class="decor-btn" href="{{ route('hideouts.index', ['autor' => $user->id]) }}">Все убежища
                                автора</a>
                            <img class="flip-y" src="{{ asset('img/decor/menu-select-bg.png') }}">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

        <section class="pad-y-98">
            <div class="container">
                <div class="row g-4">
                    @foreach ($user->hideouts(3) as $hideout)
                        <div class="col col-12 col-md-6 col-lg-4">
                            @component('resources.hideouts.components.card', compact('hideout'))
                            @endcomponent
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
