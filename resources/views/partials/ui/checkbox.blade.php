<label class="flex-row-5 flex-ai-center cursor-pointer temp-link cursor-select-no" for="{{ $id }}">
    <input class="decor-checkbox" type="checkbox" id="{{ $id }}" value="{{ $value }}"
        name="{{ $name }}" {{ isset($checked) ?: 'checked' }}>
        {{ $label }}
</label>
