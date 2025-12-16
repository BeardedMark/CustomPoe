<div class="popup-container">
    <div class="flex-center pad-5-8 example"
        style="
background-color: {{ $rule->styles->backgroundColor ?? '#000000cc' }};
border: solid 1px {{ $rule->styles->borderColor ?? 'transparent' }};
{{-- box-shadow: 0px 0px 8px {{ $rule->getEffect()->color ?? 'transparent' }};  --}}
">
        <div
            style="
background: {{ $rule->getTextColor() ?? 'linear-gradient(to right, #c8c8c8, #8888ff, #ffff77, #af6025);' }};
width: 21px;
height: 3px;
">
        </div>
    </div>

    <div class="popup-content">
        @component('resources.filters.components.popup', compact('rule'))
        @endcomponent
    </div>
</div>
