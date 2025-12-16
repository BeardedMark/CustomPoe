@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Персонажи')
@section('description', 'Список персонажей на ' . env('APP_NAME') . ' с возможностью редактирования и управления.')

@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="https://webcdn.pathofexile.com/public/news/2017-08-10/WallpaperChitus.jpg">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h1 class="font-size-h1 decor-gold">Ваши персонажи</h1>
                            <p class="font-size-lg font-color-second">На основе персонажа можно создать сборку билда для
                                публикации</p>
                        </div>

                        <div class="flex-col-8">
                            <div class="flex-row-13">
                                <a class="decor-link" href="{{ route('characters.index', ['sort' => 'experience', 'reverse' => 'on']) }}">По уровню</a>
                                <a class="decor-link" href="{{ route('characters.index', ['sort' => 'name']) }}">По имени</a>
                                <a class="decor-link" href="{{ route('characters.index', ['sort' => 'class']) }}">По классу</a>
                                <a class="decor-link" href="{{ route('characters.index', ['sort' => 'league']) }}">По лиге</a>

                                {{-- @if (Auth::user())
                                    <a class="decor-link"
                                        href="{{ route('characters.index', ['autor' => Auth::id()]) }}">Созданые мной</a>
                                @else
                                    <a class="decor-link lock">Созданые мной</a>
                                @endif --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col-8 flex-center decor-particle z-0">
                        <img src="{{ asset('img/decor/menu-select-bg.png') }}">
                        <a class="decor-btn z-1" href="{{ route('builds.create') }}">Создать сборку</a>
                        <img class="flip-y" src="{{ asset('img/decor/menu-select-bg.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <img src="{{ asset('img/decor/feature-bottom-border.png') }}">

    <section class="pad-y-98">
        <div class="container">
            @component('poe.characters.components.grid', compact('characters'))
            @endcomponent
        </div>
    </section>
@endsection
