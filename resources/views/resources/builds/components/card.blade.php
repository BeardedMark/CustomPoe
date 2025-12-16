<a class="decor-frame-hover h-100 pad-3" href="{{ route('builds.show', $build) }}">
    <div class="pos-rel over-hidden h-100">
        @if ($build->wallpaper)
            <div class="pos-abs-fill z-0 decor-back-grad">
                <img class="temp-img-cover" src="{{ $build->wallpaper }}">
            </div>
        @endif

        <div class="flex-row-8 pad-21 h-100 z-1">
            <div class="flex-col-13 flex-grow z-1">
                <div class="flex-col">
                    <p class="font-size-lg font-color-accent">{{ $build->name }}
                    <p>{{ $build->class }}</p>
                </div>

                <div class="flex-col-8 h-100">
                    @isset($build->budget)
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

                            <p><span class="decor-link active">{{ $build->budget }}</span><span class="font-color-second">
                                {{ $build->currency }}</span></p>
                        </div>
                    @endisset
                    
                    <div class="flex-row-8">
                        @if ($build->hard)
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                                class="stroke-color-{{ $build->hard > 2 ? 'danger' : ($build->hard > 1 ? 'warning' : 'success') }}">
                                <path
                                    d="M5.75 12.75H7.25M10.25 12.75H11.75M8.75 15.75V16.5M8.75 5.25C2.75 5.25 2.75 9.75 2.75 9.75V14.25L5.75 17.25V20.25H11.75V17.25L14.75 14.25V9.75C14.75 9.75 14.75 5.25 8.75 5.25Z"
                                    stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />

                                @if ($build->hard > 1)
                                    <path
                                        d="M15.5 20.2499V17.2499L18.5 14.2499V9.74976C18.5 9.74976 18.5 6.91493 15.5 5.74529"
                                        stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                @endif

                                @if ($build->hard > 2)
                                    <path
                                        d="M19.25 20.2499V17.2499L22.25 14.2499V9.75007C22.25 9.75007 22.25 6.91525 19.25 5.74561"
                                        stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                @endif
                            </svg>
                        @endif

                        @if ($build->damage)
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                                class="stroke-color-{{ $build->damage > 2 ? 'success' : ($build->damage > 1 ? 'warning' : 'danger') }}">
                                <path
                                    d="M2.75 12.75C2.75 9 5 6.75 8.75 6.75M2.75 12.75C2.75 16.5 5 18.75 8.75 18.75M2.75 12.75H5.75M8.75 6.75C12.5 6.75 14.75 9 14.75 12.75M8.75 6.75V5.25M8.75 6.75V9.75M14.75 12.75C14.75 16.5 12.5 18.75 8.75 18.75M14.75 12.75H11.75M8.75 18.75V15.75M8.75 18.75V20.25"
                                    stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />

                                @if ($build->damage > 1)
                                    <path
                                        d="M14.75 6.75049C17.1314 7.49457 18.5 9.82545 18.5 12.7501C18.5 15.6748 17.1314 18.0064 14.75 18.7505"
                                        stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                @endif

                                @if ($build->damage > 2)
                                    <path
                                        d="M18.5 6.75049C20.8814 7.49457 22.25 9.82545 22.25 12.7501C22.25 15.6748 20.8814 18.0064 18.5 18.7505"
                                        stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                @endif
                            </svg>
                        @endif


                        @if ($build->life)
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                                class="stroke-color-{{ $build->life > 2 ? 'success' : ($build->life > 1 ? 'warning' : 'danger') }}">
                                <path
                                    d="M5.74979 6.75C7.99979 6.75 8.74979 8.25 8.74979 8.25C8.74979 8.25 9.49979 6.75 11.7498 6.75C13.9998 6.75 15.4998 9 14.7498 12C13.9998 15 8.74979 20.25 8.74979 20.25C8.74979 20.25 3.49951 15 2.74979 12C2.00007 9 3.49979 6.75 5.74979 6.75Z"
                                    stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />

                                @if ($build->life > 1)
                                    <path
                                        d="M12.5 20.2502C12.5 20.2502 17.75 15.0002 18.5 12.0002C19.0658 9.73712 18.3511 7.90081 17 7.13525"
                                        stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                @endif

                                @if ($build->life > 2)
                                    <path
                                        d="M16.25 20.2499C16.25 20.2499 21.5 14.9999 22.25 11.9999C22.8408 9.63654 22.0353 7.73864 20.5668 7.03955"
                                        stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                @endif
                            </svg>
                        @endif

                        @if ($build->speed)
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                                class="stroke-color-{{ $build->speed > 2 ? 'success' : ($build->speed > 1 ? 'warning' : 'danger') }}">
                                <path
                                    d="M12.5 8.25L6.5 5.25L5 9L2.75 11.25V12.75L5.75 15.75L8.75 21.75H14L15.5 19.5L11.75 16.5L11 12L12.5 8.25Z"
                                    stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />

                                @if ($build->speed > 1)
                                    <path d="M17.75 21.75L19.25 19.5L15.5 16.5L14.75 12L16.25 8.25L13.25 6"
                                        stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                @endif

                                @if ($build->speed > 2)
                                    <path d="M20.75 21.75L22.25 18.75L18.5 15.75L17.75 12L19.25 8.25L17 6"
                                        stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                @endif
                            </svg>
                        @endif
                    </div>

                    @if ($build->description)
                        <p class="font-color-second">{{ $build->description }}</p>
                    @endif
                </div>

                <div class="flex-col-8">
                    <div class="flex-row-13">
                        <p class="flex-row-5 flex-ai-center">{{ $build->views }}
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

                        <p class="flex-row-5 flex-ai-center">{{ $build->buildings }}
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7.5 7.5V1.5M7.5 7.5H13.5M7.5 7.5H1.5M7.5 7.5V13.5M7.5 1.5H9.5M7.5 1.5H5.5M13.5 7.5V5.5M13.5 7.5V9.5M1.5 7.5V9.5M1.5 7.5V5.5M7.5 13.5H9.5M7.5 13.5H5.5"
                                    stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </p>
                    </div>

                    <div class="flex-row-5 flex-ai-center">
                        <p class="decor-level">{{ $build->user->level() }}</p>
    
                        <p class="">{{ $build->user->name }}</p>
                        <p class="font-color-second font-size-sm">{{ $build->updatedAt() }}</p>
    
                        {{-- <p class="font-color-second font-size-sm">©
                            {{ $build->updated_at->format('d.m.Y') }}
                        </p> --}}
                    </div>
                </div>
            </div>

            <div class="flex flex-center font-center border-r-8 over-hidden z-1">
                <img class="w-100 h-max-98 w-max-98 decor-frame pad-3"
                    src="{{ asset('img/characters/customAvatars/' . $build->class . '.png') }}">
            </div>
        </div>
    </div>
</a>
