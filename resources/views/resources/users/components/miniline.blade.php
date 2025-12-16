<div class="flex-row-5 flex-ai-center">
    <p class="decor-level">{{ $user->level() }}</p>

    <a class="decor-link" href="{{ route('users.show', $user) }}">{{ $user->name }}</a>

    <p class="font-color-second font-size-sm">{{ $user->role() }}</p>

    @isset($text)
        <p class="font-color-second font-size-sm">{{ $text }}</p>
    @endisset
</div>
