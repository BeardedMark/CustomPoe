@extends('layouts.page')
@section('title', env('APP_NAME') . ' : Фильтры предметов')
@section('description', 'Фильтры предметов от сообщества ' . env('APP_NAME') . ' для Path of Exile')


@section('content')
    <section class="back-color-dark pad-y-55 pos-rel over-hidden flex-center">
        <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/bg/items.jpg') }}">
        </div>

        <div class="container z-1">
            <div class="row g-4 align-items-center">
                <div class="col col-12 col-lg">
                    <div class="flex-col-21">
                        <div class="flex-col-8">
                            <h1 class="font-size-h1 decor-gold">Фильтры предметов</h1>
                            <p class="font-size-lg font-color-accent">
                                Список множества пользовательских фильтров предметов для Path of Exile, где вы можете
                                подобрать подходящий
                            </p>
                        </div>

                        <div class="flex-col-8">
                            <div class="flex-row-13">
                                <a class="decor-link" href="{{ route('filters.index', ['sort' => 'downloads', 'reverse' => 'on']) }}">Популярные</a>
                                <a class="decor-link" href="{{ route('filters.index', ['sort' => 'views', 'reverse' => 'on']) }}">Интересные</a>
                                <a class="decor-link" href="{{ route('filters.index', ['sort' => 'updated_at']) }}">Обновленные</a>
                                <a class="decor-link" href="{{ route('filters.index', ['sort' => 'created_at']) }}">Новые</a>
                                <a class="decor-link" href="{{ route('filters.index', ['sort' => 'name']) }}">Алфавит</a>
                            </div>

                            <form id="form-search" class="flex-col-5" action="{{ route('filters.index') }}" method="GET"
                                enctype="multipart/form-data">

                                <div class="flex-row-5">
                                    <input class="decor-input" type="text" id="search" name="search"
                                        @if (isset($search['search'])) value="{{ $search['search'] }}" @endif>

                                    <button class="decor-btn" type="submit">Поиск</button>
                                </div>

                                <details>
                                    <summary class="font-color-second">
                                        <span class="temp-link">Расширеный поиск</span>
                                    </summary>

                                    <div class="flex-col-13 mar-t-21">
                                        <div class="flex-col-5">
                                            <label class="font-color-second" for="autor">Автор</label>
                                            <select class="decor-input" id="autor" name="autor">
                                                <option disabled selected></option>
                                                @foreach ($autors as $autor)
                                                    <option value="{{ $autor->id }}"
                                                        @if (isset($search['autor']) && $search['autor'] == $autor->id) selected @endif>
                                                        {{ $autor->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="flex-col-5">
                                            <label class="font-color-second" for="sort">Сортировка</label>

                                            <div class="flex-col-8">
                                                <select class="decor-input" id="sort" name="sort">
                                                    <option disabled selected></option>
                                                    @foreach ($fields as $field)
                                                        <option value="{{ $field }}"
                                                            @if (isset($search['sort']) && $search['sort'] == $field) selected @endif>
                                                            {{ $field }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <label class="cursor-pointer flex-row-5" for="reverse">
                                                    <input class="decor-checkbox" type="checkbox" id="reverse"
                                                        name="reverse" @if (isset($search['reverse'])) checked @endif>
                                                    <span>Инверсия направления сортировки</span>
                                                </label>

                                                <label class="cursor-pointer flex-row-5" for="empty">
                                                    <input class="decor-checkbox" type="checkbox" id="empty"
                                                        name="empty" @if (isset($search['empty'])) checked @endif>
                                                    <span>Исключить с пустым значением поля</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </details>
                                <script>
                                    document.querySelectorAll('form').forEach(function(form) {
                                        form.addEventListener('submit', function(e) {
                                            var inputs = this.querySelectorAll('input');
                                            inputs.forEach(function(input) {
                                                if (input.value.trim() === '') {
                                                    input.name = '';
                                                }
                                            });
                                        });
                                    });
                                </script>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-lg-5">
                    <div class="flex-col-8 flex-center decor-particle z-0">
                        <img src="{{ asset('img/decor/menu-select-bg.png') }}">
                        <a class="decor-btn z-1" href="{{ route('filters.create') }}">Добавить фильтр</a>
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
                            <div class="row g-4">
                                @foreach ($filters as $filter)
                                    <div class="col col-12 col-md-6 col-lg-4">
                                        @component('resources.filters.components.card', compact('filter'))
                                        @endcomponent
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
