@props([
    'name',
    'label',
    'required' => false,
    'multiple' => false,
    'accept' => 'image/*',
])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-2">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    <input
        type="file"
        name="{{ $multiple ? $name . '[]' : $name }}"
        id="{{ $name }}"
        accept="{{ $accept }}"
        @if($required) required @endif
        @if($multiple) multiple @endif
        {{ $attributes->merge(['class' => 'w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 ' . ($errors->has($name) ? 'border-red-500 bg-red-50' : 'border-gray-300')]) }}
    >

    @if($multiple)
        <p class="mt-1 text-xs text-gray-500">{{ __('Puedes seleccionar múltiples archivos') }}</p>
    @endif

    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
