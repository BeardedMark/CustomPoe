@extends('layouts.app')

@section('page')
    <header>
        @include('partials.header')
    </header>

    <main>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <section class="flex-col-55 pad-y-98">
                            @yield('content')
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        @include('partials.footer')

        {{-- @include('components.popup') --}}
        {{-- @include('components.alert') --}}
    </footer>
@endsection
