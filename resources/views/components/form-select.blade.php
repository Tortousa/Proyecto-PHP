@props([
    'name',
    'label',
    'options' => [],
    'selected' => null,
    'displayField' => 'name',
    'required' => false,
])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-2">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 ' . ($errors->has($name) ? 'border-red-500 bg-red-50' : 'border-gray-300')]) }}
    >
        <option value="">{{ __('Select an option') }}</option>
        @foreach($options as $option)
            <option
                value="{{ $option->id }}"
                {{ old($name, $selected) == $option->id ? 'selected' : '' }}
            >
                {{ is_object($option) ? $option->$displayField : $option[$displayField] }}
            </option>
        @endforeach
    </select>

    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
