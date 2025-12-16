<div class="flex-col-8 flex-ai-center font-center pad-21 h-100">
    @isset($icon)
        <img width="64" src="{{ $icon }}">
    @endisset

    <h3 class="font-color-accent font-size-lg">{{ $title }}</h3>
    
    @isset($description)
        <img src="{{ asset('img/decor/cut.png') }}">
        <p class="font-color-">{{ $description }}</p>
    @endisset
</div>
