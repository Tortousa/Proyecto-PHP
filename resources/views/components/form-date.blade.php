@props([
    'name',
    'label',
    'selected' => null,
    'required' => false,
])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-2">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    <input
        type="date"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $selected ? \Carbon\Carbon::parse($selected)->format('Y-m-d') : '') }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 ' . ($errors->has($name) ? 'border-red-500 bg-red-50' : 'border-gray-300')]) }}
    >

    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
