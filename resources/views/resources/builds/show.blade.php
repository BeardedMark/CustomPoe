@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Сборка персонажа ' . $build->name)
@section('description',
    'Подробности сборки персонажа ' .
    $build->name .
    ' на ' .
    env('APP_NAME') .
    ' для Path of
    Exile')

@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ $build->wallpaper ?: asset('img/bg/threePassive.png') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg-7 order-2 order-lg-1">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h1 class="font-size-h1 decor-gold">{{ $build->name }}</h1>

                            @if ($build->description)
                                <p class="font-color-accent font-size-lg">{{ $build->description }}</p>
                            @endif

                            @isset($build->budget)
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

                                    <p><span class="decor-link active">{{ $build->budget }}</span><span
                                            class="font-color-second"> {{ $build->currency }}</span></p>
                                </div>
                            @endisset

                            @if ($build->getLink())
                                <a class="flex-row-8 flex-ai-center {{ $build->getLink()->guarded ?: 'font-color-danger' }}"
                                    href="{{ $build->getLink()->url }}" target="_blink"><img width="16px" height="16px"
                                        class="img-contain" src="{{ $build->getLink()->favicon }}"><span
                                        class="decor-link">{{ $build->getLink()->domain }}</span></a>
                            @endif

                            <p class="font-color-second">{{ $build->updatedAt() }}</p>
                        </div>

                        @if (Auth::user() && ($build->user->id === Auth::id() || Auth::user()->is_admin))
                            <div class="flex-col-13">
                                <div class="flex-row-13 flex-wrap flex-ai-center">
                                    <a class="decor-btn" href="{{ route('builds.edit', $build) }}">Редактировать</a>

                                    @if (isset($build->deleted_at))
                                        <form action="{{ route('builds.restore', $build) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="decor-btn font-color-success">Восстановить</button>
                                        </form>
                                    @else
                                        <form action="{{ route('builds.destroy', $build) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="decor-btn font-color-danger">Удалить</button>
                                        </form>
                                    @endif
                                </div>

                                @if ($build->comment)
                                    <p class="font-color-second">{{ $build->comment }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col col-12 col-lg-5 order-1 order-lg-2">
                    <div class="flex-col-8 flex-center font-center border-r-8">
                        <p class="font-size-lg decor-link active">{{ $build->class }}</p>
                        <img class="h-max-144 decor-frame pad-5"
                            src="{{ asset('img/characters/customAvatars/' . $build->class . '.png') }}">

                        <div class="flex-row-8">
                            @if ($build->hard)
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="stroke-color-{{ $build->hard > 2 ? 'danger' : ($build->hard > 1 ? 'warning' : 'success') }}">
                                    <path
                                        d="M5.75 12.75H7.25M10.25 12.75H11.75M8.75 15.75V16.5M8.75 5.25C2.75 5.25 2.75 9.75 2.75 9.75V14.25L5.75 17.25V20.25H11.75V17.25L14.75 14.25V9.75C14.75 9.75 14.75 5.25 8.75 5.25Z"
                                        stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />

                                    @if ($build->hard > 1)
                                        <path
                                            d="M15.5 20.2499V17.2499L18.5 14.2499V9.74976C18.5 9.74976 18.5 6.91493 15.5 5.74529"
                                            stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                    @endif

                                    @if ($build->hard > 2)
                                        <path
                                            d="M19.25 20.2499V17.2499L22.25 14.2499V9.75007C22.25 9.75007 22.25 6.91525 19.25 5.74561"
                                            stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                    @endif
                                </svg>
                            @endif

                            @if ($build->damage)
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="stroke-color-{{ $build->damage > 2 ? 'success' : ($build->damage > 1 ? 'warning' : 'danger') }}">
                                    <path
                                        d="M2.75 12.75C2.75 9 5 6.75 8.75 6.75M2.75 12.75C2.75 16.5 5 18.75 8.75 18.75M2.75 12.75H5.75M8.75 6.75C12.5 6.75 14.75 9 14.75 12.75M8.75 6.75V5.25M8.75 6.75V9.75M14.75 12.75C14.75 16.5 12.5 18.75 8.75 18.75M14.75 12.75H11.75M8.75 18.75V15.75M8.75 18.75V20.25"
                                        stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />

                                    @if ($build->damage > 1)
                                        <path
                                            d="M14.75 6.75049C17.1314 7.49457 18.5 9.82545 18.5 12.7501C18.5 15.6748 17.1314 18.0064 14.75 18.7505"
                                            stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                    @endif

                                    @if ($build->damage > 2)
                                        <path
                                            d="M18.5 6.75049C20.8814 7.49457 22.25 9.82545 22.25 12.7501C22.25 15.6748 20.8814 18.0064 18.5 18.7505"
                                            stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                    @endif
                                </svg>
                            @endif


                            @if ($build->life)
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="stroke-color-{{ $build->life > 2 ? 'success' : ($build->life > 1 ? 'warning' : 'danger') }}">
                                    <path
                                        d="M5.74979 6.75C7.99979 6.75 8.74979 8.25 8.74979 8.25C8.74979 8.25 9.49979 6.75 11.7498 6.75C13.9998 6.75 15.4998 9 14.7498 12C13.9998 15 8.74979 20.25 8.74979 20.25C8.74979 20.25 3.49951 15 2.74979 12C2.00007 9 3.49979 6.75 5.74979 6.75Z"
                                        stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />

                                    @if ($build->life > 1)
                                        <path
                                            d="M12.5 20.2502C12.5 20.2502 17.75 15.0002 18.5 12.0002C19.0658 9.73712 18.3511 7.90081 17 7.13525"
                                            stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                    @endif

                                    @if ($build->life > 2)
                                        <path
                                            d="M16.25 20.2499C16.25 20.2499 21.5 14.9999 22.25 11.9999C22.8408 9.63654 22.0353 7.73864 20.5668 7.03955"
                                            stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                    @endif
                                </svg>
                            @endif

                            @if ($build->speed)
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="stroke-color-{{ $build->speed > 2 ? 'success' : ($build->speed > 1 ? 'warning' : 'danger') }}">
                                    <path
                                        d="M12.5 8.25L6.5 5.25L5 9L2.75 11.25V12.75L5.75 15.75L8.75 21.75H14L15.5 19.5L11.75 16.5L11 12L12.5 8.25Z"
                                        stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />

                                    @if ($build->speed > 1)
                                        <path d="M17.75 21.75L19.25 19.5L15.5 16.5L14.75 12L16.25 8.25L13.25 6"
                                            stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                    @endif

                                    @if ($build->speed > 2)
                                        <path d="M20.75 21.75L22.25 18.75L18.5 15.75L17.75 12L19.25 8.25L17 6"
                                            stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                    @endif
                                </svg>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    {{-- Основной контент --}}
    <section class="pad-y-98">
        <div class="container">
            <div class="flex-col-34">
                <div class="flex-col-21">
                    <div class="row g-4">
                        <div class="col col-12 col-lg-7 order-2 order-lg-1">
                            <div class="flex-col-21">
                                <div class="flex-col-8">
                                    <h2 class="font-size-h2 decor-gold">Описание сборки</h2>
                                    <p class="font-size-lg font-color-accent">Подробная информация о сборке персонажа</p>

                                    <details>
                                        <summary class="font-color-second">Детальная информация</summary>

                                        <div class="flex-col-8 pad-13 decor-area mar-t-8">
                                            @if ($build->version)
                                                <p><span class="font-color-second">Версия : </span> {{ $build->version }}
                                                </p>
                                            @endif
                                            <p><span class="font-color-second">Лига : </span> {{ $build->league }}</p>
                                            <p><span class="font-color-second">Платформа : </span> {{ $build->realm }}</p>
                                            <p><span class="font-color-second">Cоздан : </span> {{ $build->createdAt() }}
                                            </p>
                                            @if ($build->updated_at && $build->updated_at != $build->created_at)
                                                <p><span class="font-color-second">Обновлен : </span>
                                                    {{ $build->updatedAt() }}
                                                </p>
                                            @endif
                                            @if ($build->deleted_at)
                                                <p><span class="font-color-second">Удален : </span>
                                                    {{ $build->deleted_at }}
                                                </p>
                                            @endif
                                        </div>
                                    </details>
                                </div>

                                @if ($build->content)
                                    <p>{!! nl2br(e($build->content)) !!}</p>
                                @endif

                                <div class="row g-4">
                                    @if (count($build->pros()) > 0)
                                        <div class="col col-12 col-lg">
                                            <div class="flex-col-8 pad-13 decor-area">
                                                <p class="font-color-second">Плюсы:</p>

                                                <div class="flex-col-8">
                                                    @foreach ($build->pros() as $pros)
                                                        <img src="{{ asset('img/decor/cut.png') }}">
                                                        <p class="font-color-success">{{ $pros }}</p>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if (count($build->important()) > 0)
                                        <div class="col col-12 col-lg">
                                            <div class="flex-col-8 pad-13 decor-area">
                                                <p class="font-color-second">Особенности:</p>

                                                <div class="flex-col-8">
                                                    @foreach ($build->important() as $important)
                                                        <img src="{{ asset('img/decor/cut.png') }}">
                                                        <p class="font-color-warning">{{ $important }}</p>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if (count($build->cons()) > 0)
                                        <div class="col col-12 col-lg">
                                            <div class="flex-col-8 pad-13 decor-area">
                                                <p class="font-color-second">Минусы:</p>

                                                <div class="flex-col-8">
                                                    @foreach ($build->cons() as $cons)
                                                        <img src="{{ asset('img/decor/cut.png') }}">
                                                        <p class="font-color-danger">{{ $cons }}</p>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col col-12 col-lg-5 order-1 order-lg-2">
                            <div class="flex-col-34">
                                @component('resources.builds.components.equipment', compact('build'))
                                @endcomponent
                            </div>
                        </div>
                    </div>


                    @if ($build->gallery)
                        <div class="row g-4">
                            @foreach ($build->gallery() as $image)
                                <div class="col col-4">
                                    <a class="decor-frame-hover pad-3 cursor-zoom-in" href="{{ $image }}"
                                        target="_blank">
                                        <img class="h-max-100 temp-img-cover" src="{{ $image }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>

    {{-- Прокачка персонажа --}}
    <img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/bg/wallpaperflare.com_wallpaper.jpg') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg-7">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold">Прокачка персонажа</h2>
                            <p class="font-size-lg font-color-accent">Прокачивайте своего текущего персонажа по данной
                                сборке</p>
                            <p class="font-color-second">Так же вы можете подробно изучить дерево пассивных умений на
                                сайте PoE</p>
                        </div>

                        <div class="flex-row-13">
                            @isset($build->three)
                                <div class="flex-col flex-start">
                                    <p class="font-color-second">Так же вы можете подробно изучить дерево пассивных умений на
                                        сайте PoE</p>

                                    <a class="flex-row-8 flex-ai-center" href="{{ $build->three }}" target="_blink">
                                        <img width="16px" height="16px" class="img-contain"
                                            src="https://ru.pathofexile.com/favicon.ico">
                                        <span class="decor-link cursor-alias">Path of Exile Three</span>
                                    </a>
                                </div>
                            @endisset

                            @isset($build->pob)
                                <div class="flex-col flex-start">
                                    <p class="font-color-second">Так же вы можете подробно изучить сборку в программе PoB</p>

                                    <a class="flex-row-8 flex-ai-center" href="{{ $build->three }}" target="_blink">
                                        <img width="16px" height="16px" class="img-contain"
                                            src="https://ru.pathofexile.com/favicon.ico">
                                        <span class="decor-link cursor-alias">Path of Building</span>
                                    </a>
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col-8 flex-center decor-particle z-0">
                        <img src="{{ asset('img/decor/menu-select-bg.png') }}">
                        <a class="decor-btn z-1" href="{{ route('builds.building', $build) }}">Прокачка</a>
                        <img class="flip-y" src="{{ asset('img/decor/menu-select-bg.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    {{-- Дополнительный контент --}}
    <section class="pad-y-98">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold">Подробности о предметах</h2>
                            <p class="font-size-lg font-color-accent">Расширеная информация о предметах в сборке</p>
                        </div>

                        <div class="flex-col-8">
                            @if (count($build->armor() ?? []) > 0)
                                <details>
                                    <summary class="font-color-second">Доспехи : {{ count($build->armor()) }}
                                    </summary>

                                    <div class="flex-col-13 mar-t-8">
                                        @foreach ($build->armor() as $item)
                                            @component('resources.builds.components.equip', compact('item'))
                                            @endcomponent
                                        @endforeach
                                    </div>
                                </details>
                            @endif

                            @if (count($build->bijuteri() ?? []) > 0)
                                <details>
                                    <summary class="font-color-second">Бижутерия : {{ count($build->bijuteri()) }}
                                    </summary>

                                    <div class="flex-col-13 mar-t-8">
                                        @foreach ($build->bijuteri() as $item)
                                            @component('resources.builds.components.equip', compact('item'))
                                            @endcomponent
                                        @endforeach
                                    </div>
                                </details>
                            @endif

                            @if (count($build->weapon() ?? []) > 0)
                                <details>
                                    <summary class="font-color-second">Оружие : {{ count($build->weapon()) }}
                                    </summary>

                                    <div class="flex-col-13 mar-t-8">
                                        @foreach ($build->weapon() as $item)
                                            @component('resources.builds.components.equip', compact('item'))
                                            @endcomponent
                                        @endforeach
                                    </div>
                                </details>
                            @endif

                            @if (count($build->flasks() ?? []) > 0)
                                <details>
                                    <summary class="font-color-second">Флаконы : {{ count($build->flasks()) }}
                                    </summary>

                                    <div class="flex-col-13 mar-t-8">
                                        @foreach ($build->flasks() as $item)
                                            @component('resources.builds.components.equip', compact('item'))
                                            @endcomponent
                                        @endforeach
                                    </div>
                                </details>
                            @endif

                            @if (count($build->jewels() ?? []) > 0)
                                <details>
                                    <summary class="font-color-second">Самоцветы : {{ count($build->jewels()) }}
                                    </summary>

                                    <div class="flex-col-13 mar-t-8">
                                        @foreach ($build->jewels() as $item)
                                            @component('resources.builds.components.equip', compact('item'))
                                            @endcomponent
                                        @endforeach
                                    </div>
                                </details>
                            @endif

                            @if (count($build->rucksack() ?? []) > 0)
                                <details>
                                    <summary class="font-color-second">Рюкзак : {{ count($build->rucksack()) }}
                                    </summary>

                                    <div class="flex-col-13 mar-t-8">
                                        @foreach ($build->rucksack() as $item)
                                            @component('resources.builds.components.equip', compact('item'))
                                            @endcomponent
                                        @endforeach
                                    </div>
                                </details>
                            @endif

                            @if (count($build->equipment()) > 0)
                                <details>
                                    <summary class="font-color-second">Экипировка :
                                        {{ count($build->equipment()) }}
                                    </summary>

                                    <div class="flex-col-13 mar-t-8">
                                        @foreach ($build->equipment() as $item)
                                            @component('resources.builds.components.equip', compact('item'))
                                            @endcomponent
                                        @endforeach
                                    </div>
                                </details>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Автор сборки --}}
    <img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ $build->user->wallpaper ?? asset('img/bg/community.jpg') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg-7">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold">Автор сборки персонажа</h2>
                            <div class="flex-row-5 flex-ai-center">
                                <p class="decor-level">{{ $build->user->level() }}</p>

                                <a class="decor-link font-size-lg font-color-accent"
                                    href="{{ route('users.show', $build->user) }}">{{ $build->user->name }}</a>
                                <p class="font-color-second">{{ $build->user->role() }}</p>
                            </div>

                            @isset($build->user->description)
                                <p>{{ $build->user->description }}</p>
                            @endisset
                        </div>

                        <div class="flex-col-8">

                            <div class="flex-row-8">
                                @if ($build->user->views() > 0)
                                    <p class="flex-row-5 flex-ai-center">{{ $build->user->views() }}
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.5 6.5C3.5 6.5 0.5 8.5 0.5 8.5C0.5 8.5 3.5 12.5 7.5 12.5C11.5 12.5 14.5 8.5 14.5 8.5C14.5 8.5 11.5 6.5 7.5 6.5Z"
                                                stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M12.5 3.75C11.25 3.125 9.5 2.5 7.5 2.5C5.5 2.5 3.75 3.125 2.5 3.75"
                                                stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                            <circle cx="7.5" cy="8.5" r="2" stroke="#4D4A45" />
                                        </svg>
                                    </p>
                                @endif

                                @if ($build->user->downloads() > 0)
                                    <p class="flex-row-5 flex-ai-center">{{ $build->user->downloads() }}
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M1.5 11.5V13.5H13.5V11.5M7.5 10.5V2.5M7.5 10.5L11.5 6.5M7.5 10.5L3.5 6.5"
                                                stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </p>
                                @endif

                                @if ($build->user->whisps() > 0)
                                    <p class="flex-row-5 flex-ai-center">{{ $build->user->whisps() }}
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.5 6.5H1.5L4.5 3.5M1.5 10.5H13.5L10.5 13.5" stroke="#4D4A45"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </p>
                                @endif

                                @if (0 > 0)
                                    <p class="flex-row-5 flex-ai-center">0
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.5 7.5V1.5M7.5 7.5H13.5M7.5 7.5H1.5M7.5 7.5V13.5M7.5 1.5H9.5M7.5 1.5H5.5M13.5 7.5V5.5M13.5 7.5V9.5M1.5 7.5V9.5M1.5 7.5V5.5M7.5 13.5H9.5M7.5 13.5H5.5"
                                                stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- <div class="flex-row-34">
                            <a class="flex-row-8 flex-ai-center" href="{{ $build->three }}" target="_blink">
                                <img width="16px" height="16px" class="img-contain"
                                    src="https://boosty.to/favicon.ico">
                                <span class="decor-link cursor-alias font-color-second">boosty.to</span>
                            </a>
                        </div> --}}
                    </div>
                </div>

                {{-- @isset($build->user->avatar) --}}
                <div class="col col-12 col-lg-5">
                    <div class="flex-col-8 flex-center font-center border-r-8">
                        <img class="h-max-98 decor-frame pad-5"
                            src="{{ $build->user->avatar ?? asset('img/ascendancy.png') }}">
                    </div>
                </div>
                {{-- @endisset --}}
            </div>
        </div>
    </section>
    <img src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    {{-- Другие сборки --}}
    <section class="pad-y-98">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold">Другие сборки сообщества</h2>
                            <p class="font-size-lg font-color-accent">Возможно вам понравятся другие сборки персонажей</p>
                        </div>

                        <div class="row g-4">
                            @foreach ($builds as $build)
                                <div class="col col-12 col-md-6 col-lg-4">
                                    @component('resources.builds.components.card', compact('build'))
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
