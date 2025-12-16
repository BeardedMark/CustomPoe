<div class="flex-col-21 flex-ai-center flex-jc-center ">
    <div class="flex-row-8 flex-ai-end flex-jc-center">
        <div class="flex-col-8 flex-ai-end flex-jc-end">
            <div class="flex-row-8 flex-ai-end flex-jc-end">
                @component('poe.items.components.preview', [
                    'item' => $build->getItemByInventoryId('Weapon'),
                    'itemWidth' => 2,
                    'itemHeight' => 4,
                ])
                @endcomponent

                <div class="flex-col-8 flex-ai-center flex-jc-end">
                    @component('poe.items.components.preview', [
                        'item' => $build->getItemByInventoryId('Weapon2'),
                        'itemWidth' => 1,
                        'itemHeight' => 2,
                    ])
                    @endcomponent
                    @component('poe.items.components.preview', ['item' => $build->getItemByInventoryId('Trinket')])
                    @endcomponent
                    @component('poe.items.components.preview', ['item' => $build->getItemByInventoryId('Ring')])
                    @endcomponent
                </div>
            </div>

            @component('poe.items.components.preview', ['item' => $build->getItemByInventoryId('Gloves')])
            @endcomponent
        </div>

        <div class="flex-col-8 flex-ai-center flex-jc-end">
            @component('poe.items.components.preview', ['item' => $build->getItemByInventoryId('Helm')])
            @endcomponent
            @component('poe.items.components.preview', ['item' => $build->getItemByInventoryId('BodyArmour')])
            @endcomponent
            @component('poe.items.components.preview', ['item' => $build->getItemByInventoryId('Belt')])
            @endcomponent
        </div>

        <div class="flex-col-8 flex-ai-start flex-jc-end">
            <div class="flex-row-8 flex-ai-end flex-jc-end">
                <div class="flex-col-8 flex-ai-center flex-jc-end">
                    @component('poe.items.components.preview', [
                        'item' => $build->getItemByInventoryId('Offhand2'),
                        'itemWidth' => 1,
                        'itemHeight' => 2,
                    ])
                    @endcomponent
                    @component('poe.items.components.preview', ['item' => $build->getItemByInventoryId('Amulet')])
                    @endcomponent
                    @component('poe.items.components.preview', ['item' => $build->getItemByInventoryId('Ring2')])
                    @endcomponent
                </div>
                @component('poe.items.components.preview', [
                    'item' => $build->getItemByInventoryId('Offhand'),
                    'itemWidth' => 2,
                    'itemHeight' => 4,
                ])
                @endcomponent
            </div>
            @component('poe.items.components.preview', ['item' => $build->getItemByInventoryId('Boots')])
            @endcomponent
        </div>
    </div>

    @if (count($build->jewels() ?? []) > 0)
        <img src="{{ asset('img/decor/cut.png') }}">

        <div class="flex-row-8 flex-center flex-wrap">
            @foreach ($build->jewels() as $item)
                @component('poe.items.components.preview', compact('item'))
                @endcomponent
            @endforeach
        </div>
    @endif

    @if (count($build->flasks() ?? []) > 0)
        <img src="{{ asset('img/decor/cut.png') }}">

        <div class="flex-row-8 flex-ai-center flex-jc-end">
            @foreach ($build->flasks() as $item)
                @component('poe.items.components.preview', compact('item'))
                @endcomponent
            @endforeach
        </div>
    @endif

    @if (count($build->gemLinks() ?? []) > 0)
    <img src="{{ asset('img/decor/cut.png') }}">
        <div class="flex-col-13 flex-ai-center flex-jc-end">
            @foreach ($build->gemLinks() as $links)

                <div class="flex-row flex-ai-center flex-jc-end">
                    @foreach ($links as $item)
                        @component('poe.items.components.preview', compact('item'))
                        @endcomponent
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif
</div>
