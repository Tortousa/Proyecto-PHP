@props([])

<form method="GET" action="{{ url()->current() }}"
      class="mb-6 p-4 bg-white border border-gray-200 rounded-2xl shadow-sm">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="maker" class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('Make') }}</label>
            <input type="text" name="maker" id="maker" value="{{ request('maker') }}"
                   placeholder="{{ __('Search by make') }}"
                   class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900
                          placeholder-gray-400 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400
                          outline-none transition-all duration-200 focus:bg-white">
        </div>

        <div>
            <label for="min_price" class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('Min. price') }}</label>
            <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}"
                   placeholder="0"
                   class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900
                          placeholder-gray-400 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400
                          outline-none transition-all duration-200 focus:bg-white">
        </div>

        <div>
            <label for="max_price" class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('Max. price') }}</label>
            <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}"
                   placeholder="100000"
                   class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900
                          placeholder-gray-400 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400
                          outline-none transition-all duration-200 focus:bg-white">
        </div>

        <div>
            <label for="fuel_type" class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __('Fuel type') }}</label>
            <select name="fuel_type" id="fuel_type"
                    class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-900
                           focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400
                           outline-none transition-all duration-200 cursor-pointer focus:bg-white">
                <option value="">{{ __('All') }}</option>
                @foreach($fuelTypes as $fuelType)
                    <option value="{{ $fuelType->id }}" {{ request('fuel_type') == $fuelType->id ? 'selected' : '' }}>
                        {{ $fuelType->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mt-4 flex items-center justify-between">
        <button type="submit" class="btn-primary-sm font-semibold text-xs px-5">
            {{ __('Filter') }}
        </button>
        <a href="{{ url()->current() }}" class="text-xs text-gray-400 hover:text-gray-600 transition-colors duration-150">
            {{ __('Clear filters') }}
        </a>
    </div>
</form>
