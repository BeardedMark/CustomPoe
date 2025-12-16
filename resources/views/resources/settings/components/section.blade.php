<div class="flex-row-5 pad-13 decor-area">
    <input class="decor-checkbox-invert" type="checkbox" name="{{ 'sections[S' . $section->id . ']' }}"
        @isset($settings->{'sections'}->{'S'.$section->id})
    checked
    @endisset>

    <div class="flex-col-5">
        <div class="flex-row-3 flex-ai-center">
            <div class="flex-row-3 flex-ai-center flex-grow">
                <p>{{ $section->getName() ?? 'Без имени' }}</p>

                @if ($section->getDescription())
                    <span class="font-size-sm font-color-second cursor-help pad-x-3"
                        data-tooltip="{{ $section->getDescription() }}">?</span>
                @endif
            </div>

            {{-- <p class="font-color-second font-size-sm cursor-help" data-tooltip="Строка в файле фильтра">{{ 'S'.$section->id }}</p> --}}
        </div>

        <div class="flex-row-8 flex-wrap flex-grow">
            @foreach ($section->getPalette() as $rule)
                @component('resources.filters.components.preview', compact('rule'))
                @endcomponent
            @endforeach
        </div>

        {{-- @if (count($section->getCommands()) > 0)
            <details>
                <summary
                    class="font-color-second font-size-sm decor-link">
                    Общие команды: {{ count($section->getCommands()) }}</summary>

                    <pre class="font-size-sm code pad-t-13">{{ $section->getCode() }}</pre>
            </details>
        @endif --}}

        @if (count($section->rules) > 0)
            <details>
                <summary
                    class="font-color-second font-size-sm decor-link @isset($settings->{'rules'}->{'S'.$section->id})
    active
    @endisset">
                    Правила: {{ count($section->rules) }}</summary>

                <div class="flex-col-8 pad-t-21">
                    @foreach ($section->rules as $rule)
                        @component('resources.settings.components.rule', compact('rule', 'settings', 'section'))
                        @endcomponent
                    @endforeach
                </div>
            </details>
        @endif
    </div>
</div>
