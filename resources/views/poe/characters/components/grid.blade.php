
<div class="row g-4">
    @foreach ($characters as $character)
        <div class="col col-12 col-md-6 col-lg-4">
            @component('poe.characters.components.card', compact('character'))
            @endcomponent
        </div>
    @endforeach
</div>