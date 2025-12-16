<a class="decor-frame-hover h-100 pad-3" href="{{ route('users.show', $user) }}">
    <div class="pos-rel over-hidden h-100">
        @if ($user->wallpaper)
            <div class="pos-abs-fill z-0 decor-back-grad">
                <img class="temp-img-cover" src="{{ $user->wallpaper }}">
            </div>
        @endif

        <div class="flex-row-8 pad-21 h-100 z-1">
            <div class="flex-col-13 flex-grow z-1">
                <div class="flex-col-5">

                    <div class="flex-row-5 flex-ai-center">
                        <p class="decor-level">{{ $user->level() }}</p>
                        <p class="font-size-lg font-color-accent">{{ $user->name }}</p>
                    </div>
                    <p class="flex-row-5 flex-ai-center font-color-second">{{ $user->role() }}</p>
                </div>

                <div class="flex-col-8 flex-start h-100">
                    <div class="flex-col">
                        {{-- <p class="font-color-second">
                            <span class="decor-link active">{{ $user->level() }}</span> уровень
                        </p> --}}


                        @if ($user->contents() > 0)
                            <p class="font-color-second">
                                <span class="decor-link active">{{ $user->contents() }}</span> постов
                            </p>
                        @endif
                    </div>
                </div>

                <div class="flex-col">
                    <div class="flex-row-8">
                        @if ($user->views() > 0)
                            <p class="flex-row-5 flex-ai-center">{{ $user->views() }}
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
                        @endif

                        @if ($user->downloads() > 0)
                            <p class="flex-row-5 flex-ai-center">{{ $user->downloads() }}
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.5 11.5V13.5H13.5V11.5M7.5 10.5V2.5M7.5 10.5L11.5 6.5M7.5 10.5L3.5 6.5"
                                        stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </p>
                        @endif

                        @if ($user->whisps() > 0)
                            <p class="flex-row-5 flex-ai-center">{{ $user->whisps() }}
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.5 6.5H1.5L4.5 3.5M1.5 10.5H13.5L10.5 13.5" stroke="#4D4A45"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </p>
                        @endif

                        @if (0 > 0)
                            <p class="flex-row-5 flex-ai-center">0
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.5 7.5V1.5M7.5 7.5H13.5M7.5 7.5H1.5M7.5 7.5V13.5M7.5 1.5H9.5M7.5 1.5H5.5M13.5 7.5V5.5M13.5 7.5V9.5M1.5 7.5V9.5M1.5 7.5V5.5M7.5 13.5H9.5M7.5 13.5H5.5"
                                        stroke="#4D4A45" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </p>
                        @endif
                    </div>

                    {{-- <p class="font-color-second"> {{ $user->updated_at->format('d.m.Y') }}</p> --}}
                </div>
            </div>

            @if ($user->avatar)
                <div class="flex flex-center font-center border-r-8 over-hidden z-1">
                    <img class="decor-frame pad-5" src="{{ $user->avatar ?: 'https://web.poecdn.com/gen/image/WzAsMSx7ImlkIjo1ODgsInNpemUiOiJhdmF0YXIifV0/61f4a744b9/Path_of_Exile_Gallery_Image.jpg' }}">
                </div>
            @endif
        </div>
    </div>
</a>
