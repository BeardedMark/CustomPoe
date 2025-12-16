@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Прокачка персонажа')
@section('description', 'Прокачка персонажа по сборке ' . env('APP_NAME') . ' для Path of Exile')

@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/bg/threePassive.png') }}">
        </div>

        <div class="container z-1">
            <div class="flex-col-34">
                <div class="row g-4 align-items-center">
                    <div class="col col-12 col-lg">
                        <div class="flex-col-21">
                            <div class="flex-col-8">
                                <h1 class="font-size-h1 decor-gold">Прокачка по сборке</h1>
                                <p class="font-size-lg font-color-accent">Сопоставление вашего активного персонажа и
                                    выбранной сборки</p>
                            </div>

                            <div class="flex-row-8 flex-ai-center">
                                <p>{{ $character['class'] }}</p>
                                <p class="decor-link active">{{ $character['level'] }}</p>
                                <p class="font-color-second">уровень</p>
                            </div>
                        </div>
                    </div>

                    <div class="col col-12 col-lg-5">
                        <div class="flex-col-8 flex-center decor-particle z-0">
                            <img class="h-max-98 decor-frame pad-5 z-1"
                                src="{{ asset('img/characters/customAvatars/' . $character['class'] . '.png') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <img src="{{ asset('img/decor/feature-bottom-border.png') }}">

    <section class="pad-y-98">
        <div class="container">
            <div class="flex-col-34">
                <div class="row">
                    <div class="col col-12 col-lg-7">

                        <div class="flex-col-21">
                            @component('resources.builds.components.three', compact('build', 'character'))
                            @endcomponent

                            <div class="flex-col-8 pad-13 decor-area mar-t-8">
                                <p class="font-color-second">Класс персонажа :
                                    <span
                                        class="{{ $build->class() == $character['class'] ? 'font-color-success' : 'font-color-danger' }}">
                                        {{ $build->class() }}
                                    </span>
                                </p>

                                @if ($build->banditChoice())
                                    <p class="font-color-second">Помощь бандитам :
                                        <span
                                            class="{{ $build->banditChoice() == $character['passives']['bandit_choice'] ? 'font-color-success' : 'font-color-danger' }}">
                                            {{ $build->banditChoice() }}
                                        </span>
                                    </p>
                                @endif

                                @if ($build->pantheonMajor())
                                    <p class="font-color-second">Крупный пантеон :
                                        <span
                                            class="{{ $build->pantheonMajor() == $character['passives']['pantheon_major'] ? 'font-color-success' : 'font-color-danger' }}">
                                            {{ $build->pantheonMajor() }}
                                        </span>
                                    </p>
                                @endif

                                @if ($build->pantheonMinor())
                                    <p class="font-color-second">Малый пантеон :
                                        <span
                                            class="{{ $build->pantheonMinor() == $character['passives']['pantheon_minor'] ? 'font-color-success' : 'font-color-danger' }}">
                                            {{ $build->pantheonMinor() }}
                                        </span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="col col-12 col-lg-5 order-1 order-lg-2">
                        <div class="flex-col-34">
                            <div class="flex-col-21 flex-ai-center flex-jc-center ">
                                <div class="flex-row-8 flex-ai-end flex-jc-center">
                                    <div class="flex-col-8 flex-ai-end flex-jc-end">
                                        <div class="flex-row-8 flex-ai-end flex-jc-end">
                                            @component('poe.items.components.builditem', [
                                                'item' => $build->getItemByInventoryId('Weapon'),
                                                'itemWidth' => 2,
                                                'itemHeight' => 4,
                                            ])
                                            @endcomponent

                                            <div class="flex-col-8 flex-ai-center flex-jc-end">
                                                @component('poe.items.components.builditem', [
                                                    'item' => $build->getItemByInventoryId('Weapon2'),
                                                    'itemWidth' => 1,
                                                    'itemHeight' => 2,
                                                ])
                                                @endcomponent
                                                @component('poe.items.components.builditem', ['item' => $build->getItemByInventoryId('Trinket')])
                                                @endcomponent
                                                @component('poe.items.components.builditem', ['item' => $build->getItemByInventoryId('Ring')])
                                                @endcomponent
                                            </div>
                                        </div>

                                        @component('poe.items.components.builditem', ['item' => $build->getItemByInventoryId('Gloves')])
                                        @endcomponent
                                    </div>

                                    <div class="flex-col-8 flex-ai-center flex-jc-end">
                                        @component('poe.items.components.builditem', ['item' => $build->getItemByInventoryId('Helm')])
                                        @endcomponent
                                        @component('poe.items.components.builditem', ['item' => $build->getItemByInventoryId('BodyArmour')])
                                        @endcomponent
                                        @component('poe.items.components.builditem', ['item' => $build->getItemByInventoryId('Belt')])
                                        @endcomponent
                                    </div>

                                    <div class="flex-col-8 flex-ai-start flex-jc-end">
                                        <div class="flex-row-8 flex-ai-end flex-jc-end">
                                            <div class="flex-col-8 flex-ai-center flex-jc-end">
                                                @component('poe.items.components.builditem', [
                                                    'item' => $build->getItemByInventoryId('Offhand2'),
                                                    'itemWidth' => 1,
                                                    'itemHeight' => 2,
                                                ])
                                                @endcomponent
                                                @component('poe.items.components.builditem', ['item' => $build->getItemByInventoryId('Amulet')])
                                                @endcomponent
                                                @component('poe.items.components.builditem', ['item' => $build->getItemByInventoryId('Ring2')])
                                                @endcomponent
                                            </div>
                                            @component('poe.items.components.builditem', [
                                                'item' => $build->getItemByInventoryId('Offhand'),
                                                'itemWidth' => 2,
                                                'itemHeight' => 4,
                                            ])
                                            @endcomponent
                                        </div>
                                        @component('poe.items.components.builditem', ['item' => $build->getItemByInventoryId('Boots')])
                                        @endcomponent
                                    </div>
                                </div>

                                @if (count($build->jewels() ?? []) > 0)
                                    <img src="{{ asset('img/decor/cut.png') }}">

                                    <div class="flex-row-8 flex-center flex-wrap">
                                        @foreach ($build->jewels() as $item)
                                            @component('poe.items.components.builditem', compact('item'))
                                            @endcomponent
                                        @endforeach
                                    </div>
                                @endif

                                @if (count($build->flasks() ?? []) > 0)
                                    <img src="{{ asset('img/decor/cut.png') }}">

                                    <div class="flex-row-8 flex-ai-center flex-jc-end">
                                        @foreach ($build->flasks() as $item)
                                            @component('poe.items.components.builditem', compact('item'))
                                            @endcomponent
                                        @endforeach
                                    </div>
                                @endif

                                @if (count($build->gemLinks() ?? []) > 0)
                                    <img src="{{ asset('img/decor/cut.png') }}">
                                    <div class="flex-col-13 flex-ai-center flex-jc-end">
                                        @foreach ($build->gemLinks() as $links)
                                            <div class="flex-row flex-ai-center flex-jc-end">
                                                @foreach ($links as $item)
                                                    @component('poe.items.components.builditem', compact('item'))
                                                    @endcomponent
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
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
                            <h2 class="font-size-h2 decor-gold">Прогресс прокачки</h2>
                            <p class="font-size-lg font-color-accent">Схожесть дерева умений вашего персонажа со сборкой</p>
                            <p class="font-color-second">Так же вы можете подробно изучить дерево пассивных умений на
                                сайте PoE</p>
                        </div>

                        <div class="flex-col-8 flex-center">
                            <div class="decor-frame-hover pad-5 w-100">
                                <div class="decor-progress" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col-8 flex-center">
                        <p class="font-size-h1 decor-link active cursor-def">{{ $percentage }}%</p>
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
                            @foreach ($build->itemsByLevel() as $key => $items)
                                <details>
                                    <summary class="font-color-second">{{ $key }} уровень
                                    </summary>

                                    <div class="flex-col-8 mar-t-8">
                                        @foreach ($items as $item)
                                            @component('resources.builds.components.equip', compact('item'))
                                            @endcomponent
                                        @endforeach
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
