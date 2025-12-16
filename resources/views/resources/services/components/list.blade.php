<div class="row g-4">
    @foreach ($services as $service)
        <div class="col col-12">
            @component('resources.services.components.line', compact('service'))
            @endcomponent
        </div>
    @endforeach
</div>