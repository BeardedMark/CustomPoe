
<div class="row g-4">
    @foreach ($hideouts as $hideout)
        <div class="col col-12 col-md-6 col-lg-4">
            @component('resources.hideouts.components.card', compact('hideout'))
            @endcomponent
        </div>
    @endforeach
</div>