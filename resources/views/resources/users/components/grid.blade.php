<div class="row g-4">
    @foreach ($users as $user)
        <div class="col col-12 col-md-6 col-lg-4">
            @component('resources.users.components.card', compact('user'))
            @endcomponent
        </div>
    @endforeach
</div>