@php
    $itemSizeCoeff = 47;
    $itemWidth = $itemWidth ?? (isset($item) ? $item['w'] : 1);
    $itemHeight = $itemHeight ?? (isset($item) ? $item['h'] : 1);
@endphp

<a href="#{{ $item['id']?? 'asd' }}" class="flex-center"
    style="
            width: {{ $itemSizeCoeff * $itemWidth }}px;
            height: {{ $itemSizeCoeff * $itemHeight }}px;
            min-width: {{ $itemSizeCoeff * $itemWidth }}px;
            min-height: {{ $itemSizeCoeff * $itemHeight }}px;
            max-width: {{ $itemSizeCoeff * $itemWidth }}px;
            max-height: {{ $itemSizeCoeff * $itemHeight }}px;">
    @isset($item)
        <div class="popup-container h-100">
            <img class="{{ (isset($item['corrupted']) && $item['corrupted'] === true) ? 'filter-shadow-corrupted' : null}} temp-img-cover w-auto h-auto h-max-100" src="{{ $item['icon'] }}">

            <div class="popup-content">
                @component('poe.items.components.card', compact('item'))
                @endcomponent
            </div>
        </div>
    @endisset
</a>
