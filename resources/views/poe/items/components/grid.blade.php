
<div class="row g-4">
    @foreach ($items as $item)
        <div class="col col-12 col-md-6 col-lg-4">
            @component('poe.items.components.card', compact('item'))
            @endcomponent
        </div>
    @endforeach
</div>