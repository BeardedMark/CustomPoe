<div id="footer">
    <img class="flip-y" src="{{ asset('img/decor/feature-bottom-border.png') }}" alt="">
    
    <div class="back-color-dark" style="border-top: solid 1px var(--other)">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="flex-col-34 mar-y-55">
                        <div class="row g-4">
                            <div class="col">
                                <div class="flex-col-8">
                                    <p class="font-size-lg font-color-second">Проект</p>
    
                                    <div class="flex-col flex-start">
                                        <a class="{{ Route::currentRouteName() == 'pages.main' ? 'active' : '' }} decor-link" href="{{ route('pages.main') }}">Главная</a>
                                        <a class="{{ Route::currentRouteName() == 'pages.community' ? 'active' : '' }} decor-link" href="{{ route('pages.community') }}">Сообщество</a>
                                        <a class="{{ Route::currentRouteName() == 'pages.about' ? 'active' : '' }} decor-link" href="{{ route('pages.about') }}">Описание</a>
                                        <p class="veiled pad-t-3"><img src="{{ asset('img/veiled/s3.gif') }}"></p>
                                    </div>
                                </div>
                            </div>
    
                            <div class="col">
                                <div class="flex-col-8">
                                    <p class="font-size-lg font-color-second">Сервисы</p>
    
                                    <div class="flex-col flex-start">
                                        <a class="{{ (Route::currentRouteName() == 'services.index' || request()->is('services*')) ? 'active' : '' }} decor-link" href="{{ route('services.index') }}">Объявления изгнанников</a>
                                        <a class="{{ (Route::currentRouteName() == 'builds.index' || request()->is('builds*')) ? 'active' : '' }} decor-link" href="{{ route('builds.index') }}">Сборки персонажей</a>
                                        <a class="{{ (Route::currentRouteName() == 'filters.index' || request()->is('filters*')) ? 'active' : '' }} decor-link" href="{{ route('filters.index') }}">Фильтры предметов</a>
                                        <a class="{{ (Route::currentRouteName() == 'hideouts.index' || request()->is('hideouts*')) ? 'active' : '' }} decor-link" href="{{ route('hideouts.index') }}">Убежища изгнанников</a>
                                        <p class="veiled pad-t-3"><img src="{{ asset('img/veiled/p4.gif') }}"></p>
                                    </div>
                                </div>
                            </div>
    
                            <div class="col">
                                <div class="flex-col-8">
                                    <p class="font-size-lg font-color-second">Полезное</p>
    
                                    <div class="flex-col flex-start">
                                        <a class="{{ (Route::currentRouteName() == 'auth.dashboard' || request()->is('auth*')) ? 'active' : '' }} decor-link" href="{{ route('auth.dashboard') }}">Личный профиль</a>
                                        <a class="{{ (Route::currentRouteName() == 'characters.index' || request()->is('characters*')) ? 'active' : '' }} decor-link" href="{{ route('characters.index') }}">Игровые персонажи</a>
                                        <a class="{{ (Route::currentRouteName() == 'users.index' || request()->is('users*')) ? 'active' : '' }} decor-link" href="{{ route('users.index') }}">Пользователи</a>
                                        {{-- <a class="decor-link lock" href="">Лиги и события</a> --}}
                                        <p class="veiled pad-t-3" target="_blank"><img src="{{ asset('img/veiled/p5.gif') }}"></p>
                                    </div>
                                </div>
                            </div>
    
                            <div class="col">
                                <div class="flex-col-8 flex-end">
                                    <p class="font-size-lg font-end font-color-second">Ссылки</p>
    
                                    <div class="flex-col flex-end">
                                        <a class="decor-link cursor-alias" href="{{ route('link.discord') }}" target="_blank">Discord</a>
                                        <a class="decor-link cursor-alias" href="{{ route('link.forumpoe') }}" target="_blank">PoE Forum</a>
                                        <a class="decor-link cursor-alias" href="https://ru.pathofexile.com/developer/docs" target="_blank">PoE Api</a>
                                        <a class="decor-link cursor-alias" href="{{ route('link.develop') }}" target="_blank">Develop</a>
                                        <p class="veiled pad-t-3"><img src="{{ asset('img/veiled/s3.gif') }}"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="row g-4">
                            <div class="col">
                                <div class="flex-col">
                                    <a class="lock-gray veiled pad-t-3"><img src="{{ asset('img/veiled/p3.gif') }}"></a>
                                    <p class="lock" style="opacity: 0">Не можешь победить - возглавь</p>
                                </div>
                            </div>
    
                            <div class="col-auto">
                                <div class="flex-col flex-wrap flex-end">
                                    <p class="font-color-second">CustomPoe © 2024</p>
                                    <p class="font-color-second font-size-sm font-end lock">This product isn't affiliated with or endorsed by Grinding Gear Games in any way</p>
                                </div>
                            </div>
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
            function setFooterPosition() {
                var footer = document.getElementById('footer');
                var main = document.querySelector('main');
                var header = document.getElementById('header-top');

                if (footer && main) {
                    var footerHeight = footer.offsetHeight;
                    var headerHeight = header ? header.offsetHeight : 0;
                    var windowHeight = window.innerHeight;
                    var mainHeight = main.offsetHeight;
                    var totalHeight = headerHeight + mainHeight + footerHeight;

                    if (totalHeight < windowHeight) {
                        main.style.minHeight = (windowHeight - headerHeight - footerHeight) + 'px';
                    } else {
                        main.style.minHeight = 'auto';
                    }
                }
            }

            setFooterPosition();
            window.addEventListener('resize', setFooterPosition);
        });
    </script>
@endpush
