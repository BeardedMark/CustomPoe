<div class="fixed-top" id="header-top">
    <div class="decor-nav">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="flex-row-34 flex-ai-center flex-wrap pad-y-13">
                        <div class="flex-row-13 flex-ai-center">
                            <a class="hover-scale-1-1 trans-normal" href="{{ route('pages.menu') }}">
                                <img width="32" src="{{ asset('img/decor/ascendancy.png') }}">
                            </a>

                            <a class="{{ Route::currentRouteName() == 'pages.main' ? 'active ' : '' }} decor-link font-color-accent font-size-lg"
                                href="{{ route('pages.main') }}">CustomPoe</a>
                        </div>

                        <div class="d-none d-lg-flex flex-row-21 flex-ai-center">
                            <a class="{{ Route::currentRouteName() == 'pages.about' ? 'active' : '' }} decor-link"
                                href="{{ route('pages.about') }}">Описание</a>
                            <a class="{{ Route::currentRouteName() == 'pages.community' || request()->is('users*') ? 'active' : '' }} decor-link"
                                href="{{ route('pages.community') }}">Сообщество</a>
                        </div>

                        <div class="d-none d-lg-flex flex-row-21 flex-ai-center">
                            <a class="{{ Route::currentRouteName() == 'services.index' || request()->is('services*') ? 'active' : '' }} decor-link"
                                href="{{ route('services.index') }}">Объявления</a>
                            <a class="{{ Route::currentRouteName() == 'builds.index' || request()->is('builds*') ? 'active' : '' }} decor-link"
                                href="{{ route('builds.index') }}">Сборки</a>
                            <a class="{{ Route::currentRouteName() == 'filters.index' || request()->is('filters*') ? 'active' : '' }} decor-link"
                                href="{{ route('filters.index') }}">Фильтры</a>
                            <a class="{{ Route::currentRouteName() == 'hideouts.index' || request()->is('hideouts*') ? 'active' : '' }} decor-link"
                                href="{{ route('hideouts.index') }}">Убежища</a>
                            <p class="veiled"><img src="{{ asset('img/veiled/s4.gif') }}"></p>
                        </div>

                        <div class="flex-grow">

                        </div>

                        <div class="flex-row-13 flex-ai-center">
                            @if (Auth::user())
                                <div class="flex-row-5 flex-center">
                                    <p class="decor-level cursor-help"
                                        data-tooltip="До уровня {{ Auth::user()->level()+1 }} осталось {{ Auth::user()->experienceToNextLevel() }} опыта ({{ Auth::user()->experiencePerDay() }} оп/д)">
                                        {{ Auth::user()->level() }}</p>

                                    <div class="flex-center" data-tooltip="Личный кабинет">
                                        <a class="{{ Route::currentRouteName() == 'auth.dashboard' ? 'active' : '' }} decor-link {{ Auth::user()->is_admin ? 'font-color-warning' : '' }}"
                                            href="{{ route('auth.dashboard') }}">{{ Auth::user()->name }}</a>
                                        </a>
                                    </div>
                                </div>

                                {{-- <p class="flex-row-5 flex-ai-center cursor-help"
                                    data-tooltip="до уровня осталось {{ Auth::user()->experienceToNextLevel() }} опыта ({{ Auth::user()->experiencePerDay() }} оп/д)">
                                    <span class="decor-link active">{{ Auth::user()->level() }}</span> <span
                                        class="font-color-second">ур.</span>
                                </p> --}}

                                <div class="flex-center" data-tooltip="Публичный профиль">
                                    <a class="hover-scale-1-1 trans-normal"
                                        href="{{ route('users.show', Auth::id()) }}">
                                        <img width="32" class="border-r-max" src="{{ Auth::user()->avatar }}">
                                    </a>
                                </div>
                            @else
                                <a class="decor-btn" href="{{ route('auth.login') }}">Войти</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Создание отступа страницы по высоте фиксированной шапки
            function setSiteMargin() {
                var headerTop = document.getElementById('header-top');
                var headerBottom = document.getElementById('header-bottom');

                if (headerTop) {
                    var headerTopHeight = headerTop.offsetHeight;
                    document.querySelector('main').style.marginTop = headerTopHeight + 'px';
                }

                if (headerBottom) {
                    var headerBottomHeight = headerBottom.offsetHeight;
                    document.querySelector('main').style.marginBottom = headerBottomHeight + 'px';
                }
            }

            // Запуск функций при ресайзе
            setSiteMargin();
            window.addEventListener('resize', function() {
                setSiteMargin();
            });
        });
    </script>
@endpush
