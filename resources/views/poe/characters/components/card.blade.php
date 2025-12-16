<a class="decor-frame-hover h-100 pad-3" href="{{ route('characters.show', $character['name']) }}">
    <div class="pos-rel h-100">
        {{-- <div class="pos-abs-fill z-0 decor-back-grad">
            <img class="temp-img-cover" src="{{ asset('img/characters/customAvatars/' . $character['class'] . '.png') }}">
        </div> --}}

        <div class="flex-row-8 pad-21 h-100 z-1">
            <div class="flex-col-8 flex-grow z-1">
                <div class="flex-col">
                    <p class="font-size-lg font-color-accent">{{ $character['name'] }}</p>
                    <div class="flex-row-8 flex-wrap">
                        <p>{{ $character['class'] }} </p>
                        <p class="font-color-second">{{ $character['level'] }} уровень</p>
                    </div>
                </div>

                <div class="flex-col h-100">
                    @if (isset($character['current']))
                        <p class="decor-link active">Текущий</p>
                    @endif

                    @if (isset($character['ruthless']))
                        <p class="font-color-warning">Безжалостный</p>
                    @endif

                    @if (isset($character['expired']))
                        <p class="font-color-danger">Истекший</p>
                    @endif

                    @if (isset($character['deleted']))
                        <p class="font-color-danger">Удаленный</p>
                    @endif
                </div>

                <div class="flex-col">
                    <p class="font-color-second"> {{ $character['league'] }} ©
                        {{ $character['realm'] }}</p>
                </div>
            </div>

            <div class="flex flex-center font-center border-r-8 {{ isset($character['current']) ? 'decor-particle' : null }} z-0 h-auto">
                <img class="w-100 h-max-98 w-max-98 decor-frame pad-3 z-1"
                    src="{{ asset('img/characters/customAvatars/' . $character['class'] . '.png') }}">
            </div>
        </div>
    </div>
</a>
