@php
    if (isset($item['requirements']) && is_array($item['requirements'])) {
        // Поиск требования по уровню
        foreach ($item['requirements'] as $requirement) {
            if (isset($requirement['name']) && $requirement['name'] === 'Level') {
                // Устанавливаем уровень предмета
                $itemLevel = intval($requirement['values'][0][0]);
                break;
            }
        }
    }

    $charLevel = json_decode(Auth::user()->character, true)['level'];
@endphp
<div class="pos-rel">
    <div class="{{ isset($itemLevel) && $itemLevel > $charLevel ? 'lock-gray' : null }}">
        @component('poe.items.components.preview', [
            'item' => $item,
            'itemWidth' => isset($itemWidth) ? $itemWidth : null,
            'itemHeight' => isset($itemHeight) ? $itemHeight : null,
        ])
        @endcomponent
    </div>
    @if (isset($itemLevel) && $itemLevel > $charLevel)
        <a href="#{{ $item['id']?? 'asd' }}" class="pos-abs-fill flex-col flex-center w-100 h-100 font-size-lg "
            style="background: radial-gradient(50% 50%, var(--dark) 30%, transparent 100%);">
            <span class="flex-center {{ ($itemLevel - $charLevel) <= 5 ? 'font-color-warning' : 'font-color-second' }}" data-tooltip="Осталось уровней : {{ $itemLevel - $charLevel }}">{{ $itemLevel }}</span></a>
    @endif
</div>
