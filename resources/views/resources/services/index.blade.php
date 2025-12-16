@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Объявления изгнанников')
@section('description', 'Объявления изгнанников от сообщества ' . env('APP_NAME') . ' для Path of Exile')

@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/bg/service.png') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg-7">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h1 class="font-size-h1 decor-gold">Объявления изгнанников</h1>
                            <p class="font-size-lg font-color-accent">
                                Предлагайте свои внутриигрвые услуги или товары, а так же ищите помощь среди объявлений
                                других игроков
                            </p>
                        </div>

                        <div class="flex-col-8">
                            <div class="flex-row-13">
                                <a class="decor-link"
                                    href="{{ route('services.index', ['sort' => 'appeals', 'reverse' => 'on']) }}">Популярные</a>
                                <a class="decor-link"
                                    href="{{ route('services.index', ['sort' => 'views', 'reverse' => 'on']) }}">Интересные</a>
                                <a class="decor-link"
                                    href="{{ route('services.index', ['sort' => 'updated_at']) }}">Обновленные</a>
                                <a class="decor-link"
                                    href="{{ route('services.index', ['sort' => 'created_at']) }}">Новые</a>
                                <a class="decor-link" href="{{ route('services.index', ['sort' => 'name']) }}">Алфавит</a>
                            </div>
                        </div>

                        <div class="">
                            @foreach ($types as $type)
                                <a class="decor-link"
                                    href="{{ route('services.index', ['type' => $type]) }}"> <span class="font-color-second">#</span>{{ $type }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col-8 flex-center decor-particle z-0">
                        <img src="{{ asset('img/decor/menu-select-bg.png') }}">
                        <a class="decor-btn z-1" href="{{ route('services.create') }}">Добавить объявление</a>
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
                            @component('resources.services.components.grid', compact('services'))
                            @endcomponent
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
