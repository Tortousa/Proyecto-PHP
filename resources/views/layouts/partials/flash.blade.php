@if(session('success'))
    <div class="mb-4 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded-lg text-sm">
        ✓ {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 px-4 py-3 bg-red-100 border border-red-300 text-red-800 rounded-lg text-sm">
        ⚠ {{ session('error') }}
    </div>
@endif

@if(session('status'))
    <div class="mb-4 px-4 py-3 bg-blue-100 border border-blue-300 text-blue-800 rounded-lg text-sm">
        {{ session('status') }}
    </div>
@endif
