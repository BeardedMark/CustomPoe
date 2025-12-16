<a class="decor-frame-hover h-100 pad-3" href="{{ route('services.show', $service) }}">
    <div class="pos-rel over-hidden h-100">
        @if ($service->wallpaper)
            <div class="pos-abs-fill z-0 decor-back-grad">
                <img class="temp-img-cover" src="{{ $service->wallpaper }}">
            </div>
        @endif

        <div class="flex-row-8 pad-21 h-100 z-1">
            <div class="flex-col-13 flex-grow z-1">
                <div class="flex-col">
                    <p class="font-size-lg font-color-accent">{{ $service->name }}</p>
                    <p>{{ $service->type }}@if ($service->count > 1)
                            <span class="font-color-second"> x{{ $service->count }}</span>
                        @endif
                    </p>
                </div>

                <div class="flex-col-8 h-100">
                    <div class="flex-row-5 flex-ai-center">
                        <svg class="stroke-color-contrast" width="16" height="16" viewBox="0 0 16 16"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7.5 2.5V5.5M11.5 7.5V5.5M11.5 7.5V9.5M11.5 7.5C11.5 7.5 9.5 5.5 7.5 5.5M11.5 7.5C11.5 7.5 9.5 9.5 7.5 9.5M3.5 7.5V9.5M3.5 7.5V5.5M3.5 7.5C3.5 7.5 5.5 5.5 7.5 5.5M3.5 7.5C3.5 7.5 5.5 9.5 7.5 9.5M7.5 12.5V9.5M7.5 5.5V7.5V9.5"
                                stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M14.5 7.5C14.5 11.366 11.366 14.5 7.5 14.5C3.63401 14.5 0.5 11.366 0.5 7.5C0.5 3.63401 3.63401 0.5 7.5 0.5C11.366 0.5 14.5 3.63401 14.5 7.5Z"
                                stroke="#4D4A45" />
                        </svg>

                        <p><span class="decor-link active">{{ $service->price }}</span><span class="font-color-second">
                                {{ $service->currency }}</span></p>
                    </div>

                    @if ($service->description)
                        <p class="font-color-second">{{ $service->description }}</p>
                    @endif
                </div>

                <div class="flex-col-8">
                    <div class="flex-row-13">
                        <p class="flex-row-5 flex-ai-center">{{ $service->views }}
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.5 6.5C3.5 6.5 0.5 8.5 0.5 8.5C0.5 8.5 3.5 12.5 7.5 12.5C11.5 12.5 14.5 8.5 14.5 8.5C14.5 8.5 11.5 6.5 7.5 6.5Z"
                                    stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12.5 3.75C11.25 3.125 9.5 2.5 7.5 2.5C5.5 2.5 3.75 3.125 2.5 3.75"
                                    stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                <circle cx="7.5" cy="8.5" r="2" stroke="#4D4A45" />
                            </svg>
                        </p>

                        <p class="flex-row-5 flex-ai-center">{{ $service->whisps }}
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.5 6.5H1.5L4.5 3.5M1.5 10.5H13.5L10.5 13.5" stroke="#4D4A45"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </p>
                    </div>

                    <div class="flex-row-5 flex-ai-center">
                        <p class="decor-level">{{ $service->user->level() }}</p>
    
                        <p class="">{{ $service->user->name }}</p>
                        <p class="font-color-second font-size-sm">{{ $service->updatedAt() }}</p>
                    </div>
                </div>
            </div>


            {{-- @if ($service->icon)
                <div class="flex flex-center font-center border-r-8 over-hidden z-1">
                    <img class="w-100 h-max-98 w-max-98" src="{{ $service->icon }}">
                </div>
            @endif --}}
        </div>
    </div>
</a>
