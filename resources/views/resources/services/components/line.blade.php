<a class="decor-frame-hover h-100 pad-3" href="{{ route('services.show', $service) }}">
    <div class="pos-rel over-hidden h-100">
        @if ($service->wallpaper)
            <div class="pos-abs-fill z-0 decor-back-grad">
                <img class="temp-img-cover" src="{{ $service->wallpaper }}">
            </div>
        @endif
    
        <div class="flex-row-8 pad-21 h-100 z-1">
            <div class="flex-col-8 flex-grow z-1">
                <div class="flex-col">
                    <p class="font-size-lg">{{ $service->name }}</p>
    
                    @if ($service->description)
                        <p>{{ $service->description }}</p>
                    @endif
                </div>
    
                <div class="flex-col-5 h-100">
                    @if (session($service->id))
                        <p class="decor-link active">Сохранено</p>
                    @endif
                </div>
    
                <div class="flex-col">
                    <p>{{ $service->downloads }}<span class="font-color-second "> cкачиваний</span></p>
                    <p class="font-color-second"> {{ $service->user->name }} © {{ $service->updated_at->format('d.m.Y') }}</p>
                </div>
            </div>
    
    
            @if ($service->icon)
                <div class="flex flex-center font-center border-r-8 over-hidden z-1">
                    <img class="w-100 h-max-98 w-max-98" src="{{ $service->icon }}">
                </div>
            @endif
        </div>
    </div>
</a>
