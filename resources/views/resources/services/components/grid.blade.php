<div class="row g-4">
    @foreach ($services as $service)
        <div class="col col-12 col-md-6 col-lg-4">
            @component('resources.services.components.card', compact('service'))
            @endcomponent
        </div>
    @endforeach
</div>