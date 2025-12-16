
<div class="row g-4">
    @foreach ($builds as $build)
        <div class="col col-12 col-md-6 col-lg-4">
            @component('resources.builds.components.card', compact('build'))
            @endcomponent
        </div>
    @endforeach
</div>