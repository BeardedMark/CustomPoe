<section class="flex-col-13 pad-13 decor-area pos-rel over-hidden pad-21">
    <div class="flex-col-5  flex-center font-center">

        <div class="flex-col">
            <p class="font-size-lg">{{ $item['baseType'] }}</p>

            @if (isset($item['name']))
                <p class="font-color-second">{{ $item['name'] }}</p>
            @endif
        </div>

        <img src="{{ asset('img/decor/cut.png') }}">

        <div class="flex-col">
            @if (isset($item['properties']))
                <div class="flex-col">
                    @foreach ($item['properties'] as $property)
                        <p style="color: var(--color-default-text)">
                            @php
                                $prop = $property['name'];

                                if (strpos($prop, '{') !== false) {
                                    foreach ($property['values'] as $key => $value) {
                                        if (isset($value[0])) {
                                            $prop = str_replace('{' . $key . '}', $value[0], $prop);
                                        }
                                    }
                                } else {
                                    if (isset($property['values'][0][0])) {
                                        $prop = $property['values'][0][0] . ' ' . $prop;
                                    }
                                }
                            @endphp

                            {{ $prop }}
                        </p>
                    @endforeach
                </div>
            @endif

            @if (isset($item['utilityMods']))
                <div class="flex-col">
                    @foreach ($item['utilityMods'] as $utilityMods)
                        <p style="color: var(--color-default-text)">{{ $utilityMods }}</p>
                    @endforeach
                </div>
            @endif

            @if (isset($item['implicitMods']))
                <div class="flex-col">
                    @foreach ($item['implicitMods'] as $implicitMods)
                        <p style="color: var(--color-value-text)">{{ $implicitMods }}</p>
                    @endforeach
                </div>
            @endif

            @if (isset($item['fracturedMods']))
                <div class="flex-col">
                    @foreach ($item['fracturedMods'] as $fracturedMods)
                        <p style="color: var(--color-supporter-pack-item)">{{ $fracturedMods }}</p>
                    @endforeach
                </div>
            @endif

            @if (isset($item['explicitMods']))
                <div class="flex-col">
                    @foreach ($item['explicitMods'] as $explicitMod)
                        <p style="color: var(--color-augmented-value-text)">{{ $explicitMod }}</p>
                    @endforeach
                </div>
            @endif

            @foreach (['scourgeMods', 'crucibleMods', 'ultimatumMods'] as $mod)
                @if (isset($item[$mod]))
                    <div class="flex-col">
                        @foreach ($item[$mod] as $itemMod)
                            <p style="color: var(--color-supporter-pack-new-item)">{{ $itemMod }}</p>
                        @endforeach
                    </div>
                @endif
            @endforeach

            @foreach (['cosmeticMods', 'veiledMods'] as $mod)
                @if (isset($item[$mod]))
                    <div class="flex-col">
                        @foreach ($item[$mod] as $itemMod)
                            </p>
                        @endforeach
                    </div>
                @endif
            @endforeach

            @if (isset($item['craftedMods']))
                <div class="flex-col">
                    @foreach ($item['craftedMods'] as $craftedMods)
                        </p>
                    @endforeach
                </div>
            @endif
        </div>

        @if (isset($item['fractured']) || isset($item['synthesised']) || isset($item['replica']) || isset($item['corrupted']) || isset($item['influences']))
            <img src="{{ asset('img/decor/cut.png') }}">

            <div class="flex-col">
                @if (isset($item['fractured']))
                    <p style="color: var(--color-supporter-pack-item)">Расколот</p>
                @endif

                @if (isset($item['synthesised']))
                    <p style="color: var(--color-supporter-pack-item)">Синтезирован</p>
                @endif

                @if (isset($item['replica']))
                    <p style="color: var(--color-supporter-pack-new-item)">Копия</p>
                @endif

                @if (isset($item['corrupted']))
                    <p style="color: var(--color-corrupted)">Осквернён</p>
                @endif

                @if (isset($item['influences']))
                    @foreach ($item['influences'] as $key => $value)
                        <p class="decor-link active">{{ ucfirst($key) }}</p>
                    @endforeach
                @endif
            </div>
        @endif
    </div>
</section>
