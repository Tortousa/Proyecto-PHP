@if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition
         x-init="setTimeout(() => show = false, 4000)"
         class="mb-5 flex items-center gap-3 px-4 py-3.5 bg-green-50 border border-green-200
                rounded-xl text-sm text-green-800 shadow-sm animate-fade-up">
        <div class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center shrink-0">
            <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <span class="font-medium flex-1">{{ session('success') }}</span>
        <button @click="show = false" class="text-green-400 hover:text-green-600 transition-colors ml-1">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif

@if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-transition
         x-init="setTimeout(() => show = false, 5000)"
         class="mb-5 flex items-center gap-3 px-4 py-3.5 bg-red-50 border border-red-200
                rounded-xl text-sm text-red-800 shadow-sm animate-fade-up">
        <div class="w-5 h-5 rounded-full bg-red-500 flex items-center justify-center shrink-0">
            <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>
        <span class="font-medium flex-1">{{ session('error') }}</span>
        <button @click="show = false" class="text-red-400 hover:text-red-600 transition-colors ml-1">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif

@if(session('status'))
    <div x-data="{ show: true }" x-show="show" x-transition
         x-init="setTimeout(() => show = false, 4000)"
         class="mb-5 flex items-center gap-3 px-4 py-3.5 bg-blue-50 border border-blue-200
                rounded-xl text-sm text-blue-800 shadow-sm animate-fade-up">
        <div class="w-5 h-5 rounded-full bg-blue-500 flex items-center justify-center shrink-0">
            <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01"/>
            </svg>
        </div>
        <span class="font-medium flex-1">{{ session('status') }}</span>
        <button @click="show = false" class="text-blue-400 hover:text-blue-600 transition-colors ml-1">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif
