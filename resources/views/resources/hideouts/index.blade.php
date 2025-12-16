@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Убежища изгнанников')
@section('description', 'Убежища изгнанников от сообщества ' . env('APP_NAME') . ' для Path of Exile')

@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/bg/ho.png') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h1 class="font-size-h1 decor-gold">Убежища изгнанников</h1>
                            <p class="font-size-lg font-color-accent">
                                Список множества пользовательских убежищ изгнанников для Path of Exile, где вы можете
                                подобрать комфортное для себя или своей гильдии
                            </p>
                        </div>

                        <div class="flex-col-8">
                            <div class="flex-row-13">
                                <a class="decor-link" href="{{ route('hideouts.index', ['sort' => 'downloads', 'reverse' => 'on']) }}">Популярные</a>
                                <a class="decor-link" href="{{ route('hideouts.index', ['sort' => 'views', 'reverse' => 'on']) }}">Интересные</a>
                                <a class="decor-link" href="{{ route('hideouts.index', ['sort' => 'updated_at']) }}">Обновленные</a>
                                <a class="decor-link" href="{{ route('hideouts.index', ['sort' => 'created_at']) }}">Новые</a>
                                <a class="decor-link" href="{{ route('hideouts.index', ['sort' => 'name']) }}">Алфавит</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col-8 flex-center decor-particle z-0">
                        <img src="{{ asset('img/decor/menu-select-bg.png') }}">
                        <a class="decor-btn z-1" href="{{ route('hideouts.create') }}">Добавить убежище</a>
                        <img class="flip-y" src="{{ asset('img/decor/menu-select-bg.png') }}">
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
                    <div class="col col-12 col-lg">
                        <div class="flex-col-21">
                            @component('resources.hideouts.components.grid', compact('hideouts'))
                            @endcomponent
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
