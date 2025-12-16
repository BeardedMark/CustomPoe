<div class="flex-row-5">
    <input class="decor-checkbox-invert" type="checkbox" id="{{ $rule->id }}"
        name="{{ 'rules[S' . $section->id . '][R' . $rule->id . ']' }}"
        @isset($settings->{'rules'}->{'S' . $section->id}->{'R' . $rule->id})
checked
@endisset>

    <div class="flex-col-5">
        <div class="flex-row-13 flex-ai-start">
            <div class="flex-col flex-ai-start">
                <div class="flex-row-3 flex-ai-center">
                    <p>{{ $rule->getName() }}</p>

                    @if ($rule->getDescription())
                        <span class="font-size-sm font-color-second cursor-help pad-x-3"
                            data-tooltip="{{ $rule->getDescription() }}">?</span>
                    @endif
                </div>

                {{-- @if (count($section->getRules()) > 0) --}}
                {{-- <details>
                    <summary class="font-color-second font-size-sm">Настройки</summary>

                    <div class="flex-col-8 pad-t-13 pad-l-8"> --}}
                {{-- @foreach ($section->getRules() as $rule)
                                @component('resources.settings.components.rule', compact('rule'))
                                @endcomponent
                            @endforeach --}}

                {{-- </div>
                </details> --}}
                {{-- @endif --}}

                <details>
                    <summary class="font-color-second font-size-sm decor-link">Команды правила:
                        {{ count($rule->commands) }}</summary>

                    <pre class="font-size-sm code pad-y-13">{{ $rule->getCode() }}</pre>
                </details>
            </div>

            <div class="flex-row-5 flex-ai-center">
                {{-- <p class="font-color-second font-size-sm cursor-help" data-tooltip="Строка в файле фильтра">
                    {{ 'R'.$rule->id }}</p> --}}
                @if (isset($rule->data->sound))
                    <p class="cursor-pointer font-color-second font-size-lg pad-5"
                        data-tooltip="Звук при выпадении предмета"
                        onclick="new Audio('{{ asset('sounds/' . $rule->data->sound->sound . '.wav') }}').play();">♫</p>
                @endif

                @if (!$rule->data->visible)
                    <p class="font-color-second pad-5 cursor-help" data-tooltip="Отображается при зажатой клавише Alt">
                        Alt</p>
                @endif

                <div class="popup-container">
                    @component('resources.filters.components.example', compact('rule'))
                    @endcomponent

                    <div class="popup-content">
                        @component('resources.filters.components.popup', compact('rule'))
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
