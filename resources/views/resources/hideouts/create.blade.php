@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Создание убежища изгнанников')
@section('description', 'Создание нового убежища ищгнанников в сообществе ' . env('APP_NAME') . ' для Path of Exile')

@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/bg/topbg.png') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h1 class="font-size-h1 decor-gold">Создание убежища</h1>
                            <p class="font-size-lg font-color-second">
                                Создать новое убежище изгнанника на сайте
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <img src="{{ asset('img/decor/feature-bottom-border.png') }}">

    <section class="pad-98">
        <div class="container">    
            <div class="row justify-content-center">
                <div class="col col-12 col-lg">
                    <form class="flex-col-13 flex-grow flex-start" action="{{ route('hideouts.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="flex-col-5">
                            <label class="font-color-second" for="name">Название нового убежища изгнанников</label>
                            <input class="decor-input" type="text" id="name" name="name" value="{{ old('name') }}" required>
                        </div>

                        <button class="decor-btn" type="submit">Создать</button>
                    </form>
                </div>
                
                <div class="col col-12 col-lg-5">
                    {{-- <form class="flex-row-13" action="{{ route('filters.import', $filter) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div>
                            <input class="decot-input" type="file" name="file" id="file" required>
                        </div>
                        <button class="decor-btn" type="submit">Импортировать</button>
                    </form> --}}
                </div>
            </div>
        </div>
    </section>
@endsection
