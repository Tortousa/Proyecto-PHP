@props([
    'name',
    'label',
    'checked' => false,
])

<div class="mb-4">
    <div class="flex items-center">
        <input
            type="checkbox"
            name="{{ $name }}"
            id="{{ $name }}"
            value="1"
            {{ old($name, $checked) ? 'checked' : '' }}
            {{ $attributes->merge(['class' => 'w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 transition-colors duration-200']) }}
        >
        <label for="{{ $name }}" class="ml-2 text-sm font-medium text-gray-700">
            {{ $label }}
        </label>
    </div>

    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
