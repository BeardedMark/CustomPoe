@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Персонаж ' . $character['name'])
@section('description', 'Просмотр информации о персонаже ' . $character['name'] . ' на ' . env('APP_NAME') . '.')

@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/characters/customAvatars/' . $character['class'] . '.png') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h1 class="font-size-h1 decor-gold">{{ $character['name'] }}</h1>

                            <a class="flex-row-8 flex-ai-center"
                                href="https://ru.pathofexile.com/account/view-profile/{{ Auth::user()->name }}/characters?characterName={{ $character['name'] }}"
                                target="_blink">
                                <img width="16px" height="16px" class="img-contain"
                                    src="https://ru.pathofexile.com/favicon.ico">
                                <span class="decor-link cursor-alias">pathofexile.com</span>
                            </a>
                        </div>

                        <div class="flex-col">
                            @if (isset($character['current']))
                                <p class="decor-link active">Текущий</p>
                            @endif

                            @if (isset($character['ruthless']))
                                <p class="font-color-warning">Безжалостный</p>
                            @endif

                            @if (isset($character['expired']))
                                <p class="font-color-danger">Истекший</p>
                            @endif

                            @if (isset($character['deleted']))
                                <p class="font-color-danger">Удаленный</p>
                            @endif
                        </div>

                        <p class="font-color-second"> {{ $character['league'] }} ©
                            {{ $character['realm'] }}</p>
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col-8 flex-center font-center border-r-8">
                        <p class="font-size-lg decor-link active">{{ $character['class'] }}</p>
                        <div class="flex-col-8 flex-center decor-particle z-0">
                            <img class="h-max-144 decor-frame pad-5 z-1"
                                src="{{ asset('img/characters/customAvatars/' . $character['class'] . '.png') }}">
                        </div>
                        <div class="flex-col flex-center">
                            <p>уровень</p>
                            <p class="font-size-lg decor-link active">{{ $character['level'] }}</p>
                        </div>
                    </div>
                </div>
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
                                    <h2 class="font-size-h2 decor-gold">Предметы</h2>
                                    <p class="font-size-lg">Подробная информация о предметах персонажа</p>
                                </div>

                                <div class="flex-col-8">
                                    @if (count($character['jewels']) > 0)
                                        <details>
                                            <summary class="font-color-second">Самоцветы :
                                                {{ count($character['jewels']) }}
                                            </summary>

                                            <div class="mar-t-8">
                                                @component('poe.items.components.grid', ['items' => $character['jewels']])
                                                @endcomponent
                                            </div>
                                        </details>
                                    @endif

                                    @if (count($character['inventory']) > 0)
                                        <details>
                                            <summary class="font-color-second">Инвентарь :
                                                {{ count($character['inventory']) }}
                                            </summary>

                                            <div class="mar-t-8">
                                                @component('poe.items.components.grid', ['items' => $character['inventory']])
                                                @endcomponent
                                            </div>
                                        </details>
                                    @endif

                                    @isset($character['rucksack'])
                                        <details>
                                            <summary class="font-color-second">Рюкзак : {{ count($character['rucksack']) }}
                                            </summary>

                                            <div class="mar-t-8">
                                                @component('poe.items.components.grid', ['items' => $character['rucksack']])
                                                @endcomponent
                                            </div>
                                        </details>
                                    @endisset

                                    <details>
                                        <summary class="font-color-second">Экипировка :
                                            {{ count($character['equipment']) }}
                                        </summary>

                                        <div class="mar-t-8">
                                            @component('poe.items.components.grid', ['items' => $character['equipment']])
                                            @endcomponent
                                        </div>
                                    </details>
                                </div>
                            </div>
                        </div>
                    </div>

                    <details>
                        <summary class="font-color-second">Подробности о персонаже</summary>

                        <div class="flex-col-13 pad-13 decor-area mar-t-8">
                            @if ($character['passives']['bandit_choice'])
                                <p><span class="font-color-second">Помощь бандитам : </span>
                                    {{ $character['passives']['bandit_choice'] }}</p>
                            @endif
                            @if ($character['passives']['pantheon_major'])
                                <p><span class="font-color-second">Крупный пантеон : </span>
                                    {{ $character['passives']['pantheon_major'] }}</p>
                            @endif
                            @if ($character['passives']['pantheon_minor'])
                                <p><span class="font-color-second">Малый пантеон : </span>
                                    {{ $character['passives']['pantheon_minor'] }}</p>
                            @endif
                            @if ($character['metadata']['version'])
                                <p><span class="font-color-second">Версия игры : </span>
                                    {{ $character['metadata']['version'] }}</p>
                            @endif
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </section>

    <img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">

    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/bg/threePassive.png') }}">
        </div>
        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h2 class="font-size-h2 decor-gold">Создать сборку из персонажа</h2>
                            <p class="font-size-lg">Делитесь своим персонажем с сообществом как примером сборки</p>
                        </div>

                        <div class="flex-col flex-start">
                            <p class="font-color-second">Так же можете скачать данные о персонаже</p>
                            <a class="decor-link"
                                href="{{ route('characters.download', $character['name']) }}">{{ $character['name'] }}.json</a>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col-8 flex-center @if ($character['level'] > 90) decor-particle @endif z-0">
                        <img src="{{ asset('img/decor/menu-select-bg.png') }}">
                        @if ($build)
                            <form class="z-1" action="{{ route('builds.update', $build) }}" method="POST">
                                @method('PUT')
                                @csrf

                                <div class="flex-col-5">
                                    <input class="decor-input" type="hidden" id="characterName" name="characterName"
                                        required value="{{ $character['name'] }}">
                                </div>

                                <button type="submit" class="decor-btn">
                                    Обновить сборку
                                </button>
                            </form>
                        @else
                            <a class="decor-btn z-1 @if ($character['level'] < 90) lock-gray @endif"
                                href="{{ route('builds.create', ['characterName' => $character['name']]) }}">
                                @if ($character['level'] > 90)
                                    Опубликовать сборку
                                @else
                                    Осталось {{ 90 - $character['level'] }} уровней
                                @endif
                            </a>
                        @endif
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
                            <h2 class="font-size-h2 decor-gold">Другие сборки сообщества</h2>
                            <p class="font-size-lg">Возможно вам понравятся другие сборки персонажей</p>
                        </div>

                        {{-- <div class="row g-4">
                            @foreach ($characters as $othercharacter)
                                <div class="col col-12 col-md-6 col-lg-4">
                                    @component('resources.characters.components.card', ['character' => $othercharacter])
                                    @endcomponent
                                </div>
                            @endforeach
                        </div> --}}
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
