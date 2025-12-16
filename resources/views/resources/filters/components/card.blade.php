<a class="decor-frame-hover h-100 pad-3" href="{{ route('filters.show', $filter) }}">
    <div class="pos-rel over-hidden h-100">
        @if ($filter->wallpaper)
            <div class="pos-abs-fill z-0 decor-back-grad">
                <img class="temp-img-cover" src="{{ $filter->wallpaper }}">
            </div>
        @endif

        <div class="flex-row-8 pad-21 h-100 z-1">
            <div class="flex-col-13 flex-grow z-1">
                <div class="flex-col">
                    <p class="font-size-lg font-color-accent">{{ $filter->name }}</p>
                    {{-- <p><span class="font-color-second">Правил : </span>
                        {{ count($filter->getRules($filter->getLines())) }}</p> --}}
                </div>

                <div class="flex-col h-100">
                    @if (session($filter->id))
                        <p class="decor-link active">Сохранено</p>
                    @endif

                    @if ($filter->description)
                        <p>{{ $filter->description }}</p>
                    @endif
                </div>

                <div class="flex-col-8">
                    <div class="flex-row-13">
                        <p class="flex-row-5 flex-ai-center">{{ $filter->views }}
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

                        <p class="flex-row-5 flex-ai-center">{{ $filter->downloads }}
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.5 11.5V13.5H13.5V11.5M7.5 10.5V2.5M7.5 10.5L11.5 6.5M7.5 10.5L3.5 6.5"
                                    stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </p>
                    </div>

                    <div class="flex-row-5 flex-ai-center">
                        <p class="decor-level">{{ $filter->user->level() }}</p>
    
                        <p class="">{{ $filter->user->name }}</p>
                        <p class="font-color-second font-size-sm">{{ $filter->updatedAt() }}</p>
                    </div>
                </div>
            </div>


            {{-- @if ($filter->icon)
                <div class="flex flex-center font-center border-r-8 over-hidden z-1">
                    <img class="w-100 h-max-98 w-max-98" src="{{ $filter->icon }}">
                </div>
            @endif --}}
        </div>
    </div>
</a>
