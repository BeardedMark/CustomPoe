<details>
    <summary class="font-color-second font-size-lg decor-link">{{ $group->name }}
        @isset ($group->description)
            <span class="font-size-sm font-color-second cursor-help pad-x-3"
                data-tooltip="{{ $group->description }}">?</span>
        @endisset
    </summary>

    <ul class="flex-col-8 mar-y-5 pad-l-8">
        @foreach ($group->sections as $section)
            @component('resources.settings.components.section', compact('section', 'filter'))
            @endcomponent
        @endforeach
    </ul>
</details>
