<section id="{{ $item['id'] }}" class="flex-col-13 pad-13 decor-area pos-rel over-hidden pad-21 ping">
    {{-- <div class="flex-row-8"> --}}
    <div class="row g-4 align-items-center">
        <div class="col-12 col-lg-2">
            <div class="flex-col-8 flex-center h-100">
                <img src="{{ $item['icon'] }}">
            </div>
        </div>

        <div class="col-12 col-lg-2">
            <div class="flex-col-8">
                <div class="flex-col">
                    @if (isset($item['name']))
                        <h2 class="font-size-lg font-color-accent">{{ $item['name'] }}</h2>
                    @endif

                    @if (isset($item['baseType']))
                        <p class="">{{ $item['baseType'] }}</p>
                    @endif
                </div>
                
                @if (isset($item['requirements']))
                    <div class="flex-col">
                        @foreach ($item['requirements'] as $property)
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

                    @if (isset($item['influences']))
                        @foreach ($item['influences'] as $key => $value)
                            <p class="decor-link active">{{ ucfirst($key) }}</p>
                        @endforeach
                    @endif
                    @if (isset($item['corrupted']))
                        <p style="color: var(--color-corrupted)">Осквернён</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-2">
            <div class="flex-col-8">

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
            </div>
        </div>

        <div class="col-12 col-lg">
            @if (isset($item['utilityMods']))
                <div class="flex-col">
                    @foreach ($item['utilityMods'] as $utilityMods)
                        <p style="color: var(--color-default-text)">{{ $utilityMods }}
                            <span class="font-color-second">({{ str_replace('Mods', '', 'utilityMods') }})</span>
                        </p>
                    @endforeach
                </div>
            @endif

            @if (isset($item['implicitMods']))
                <div class="flex-col">
                    @foreach ($item['implicitMods'] as $implicitMods)
                        <p style="color: var(--color-value-text)">{{ $implicitMods }}
                            <span class="font-color-second">({{ str_replace('Mods', '', 'implicitMods') }})</span>
                        </p>
                    @endforeach
                </div>
            @endif

            @if (isset($item['fracturedMods']))
                <div class="flex-col">
                    @foreach ($item['fracturedMods'] as $fracturedMods)
                        <p style="color: var(--color-supporter-pack-item)">{{ $fracturedMods }}
                            <span class="font-color-second">({{ str_replace('Mods', '', 'fracturedMods') }})</span>
                        </p>
                    @endforeach
                </div>
            @endif

            @if (isset($item['explicitMods']))
                <div class="flex-col">
                    @foreach ($item['explicitMods'] as $explicitMod)
                        <p style="color: var(--color-augmented-value-text)">{{ $explicitMod }}
                            <span class="font-color-second">({{ str_replace('Mods', '', 'explicitMods') }})</span>
                        </p>
                    @endforeach
                </div>
            @endif

            @foreach (['scourgeMods', 'crucibleMods', 'ultimatumMods'] as $mod)
                @if (isset($item[$mod]))
                    <div class="flex-col">
                        @foreach ($item[$mod] as $itemMod)
                            <p style="color: var(--color-supporter-pack-new-item)">{{ $itemMod }}
                                <span class="font-color-second">({{ str_replace('Mods', '', $mod) }})</span>
                            </p>
                        @endforeach
                    </div>
                @endif
            @endforeach

            @foreach (['cosmeticMods', 'veiledMods'] as $mod)
                @if (isset($item[$mod]))
                    <div class="flex-col">
                        @foreach ($item[$mod] as $itemMod)
                            <p style="color: var(--color-default-text)">{{ $itemMod }}
                                <span class="font-color-second">({{ str_replace('Mods', '', $mod) }})</span>
                            </p>
                        @endforeach
                    </div>
                @endif
            @endforeach

            @if (isset($item['craftedMods']))
                <div class="flex-col">
                    @foreach ($item['craftedMods'] as $craftedMods)
                        <p style="color: var(--color-crafted-mod)">{{ $craftedMods }}
                            <span class="font-color-second">({{ str_replace('Mods', '', 'craftedMods') }})</span>
                        </p>
                    @endforeach
                </div>
            @endif
        </div>
    </div>


    {{-- <img src="{{ asset('img/decor/cut.png') }}"> --}}


    {{-- @if (isset($item['sockets']))
                <p>Ячейки: 
                    <span class="decor-link active">
                        {{ implode(', ', array_map(function($socket) { return $socket['colour']; }, $item['sockets'])) }}
                    </span>
                </p>
            @endif --}}

    {{-- </div> --}}
</section>
