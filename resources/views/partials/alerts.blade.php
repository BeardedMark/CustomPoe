@if (
    $errors->any() ||
        session('success') ||
        session('error') ||
        session('warning') ||
        session('info') ||
        session('message'))
        
    <section class="flex-col-21 back-color-dark">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="pad-y-13 font-center">
                        @if (session('error'))
                            <p class="font-color-danger">
                                {{ session('error') }}
                            </p>
                        @endif

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <p class="font-color-danger">
                                    {{ $error }}
                                </p>
                            @endforeach
                        @endif

                        @if (session('success'))
                            <p class="font-color-success">
                                {{ session('success') }}
                            </p>
                        @endif

                        @if (session('warning'))
                            <p class="font-color-warning">
                                {{ session('warning') }}
                            </p>
                        @endif

                        @if (session('info'))
                            <p class="font-color-info">
                                {{ session('info') }}
                            </p>
                        @endif

                        @if (session('message'))
                            <p class="font-color-accent">
                                {{ session('message') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <img src="{{ asset('img/decor/cut.png') }}">
@endif
