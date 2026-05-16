<div class="space-y-4">

    <h3 class="text-sm font-semibold text-gray-700">{{ __('Listing images') }}</h3>

    {{-- Grid de imágenes actuales --}}
    @if($images->isNotEmpty())
        <div class="grid grid-cols-3 gap-3">
            @foreach($images as $image)
                <div class="relative group">
                    <img src="{{ $image->url }}" class="w-full h-28 object-cover rounded-lg border border-gray-200">
                    {{-- Overlay de acciones: visible al hacer hover --}}
                    <div class="absolute inset-0 hidden group-hover:flex flex-col items-end justify-between p-1 gap-1">
                        <button wire:click="delete({{ $image->id }})"
                                wire:confirm="¿Eliminar esta imagen?"
                                class="bg-red-600 text-white rounded-full w-6 h-6 text-xs flex items-center justify-center">
                            ✕
                        </button>
                        @if($image->position !== 0)
                        <button wire:click="setPrimary({{ $image->id }})"
                                title="Marcar como imagen principal"
                                class="bg-yellow-400 text-gray-900 rounded-full w-6 h-6 text-xs flex items-center justify-center font-bold">
                            ★
                        </button>
                        @else
                        <span class="bg-yellow-400 text-gray-900 rounded-full w-6 h-6 text-xs flex items-center justify-center font-bold" title="Imagen principal">
                            ★
                        </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-sm text-gray-400">Sin imágenes todavía.</p>
    @endif

    {{-- Dropzone: arrastra o haz clic para seleccionar una imagen --}}
    <div id="lw-dropzone"
         class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition"
         onclick="document.getElementById('lw-input').click()">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <span id="lw-dropzone-label" class="text-xs text-gray-400">Arrastra una imagen aquí o haz clic</span>
    </div>

    {{-- Input real vinculado a Livewire — oculto, se activa desde el dropzone --}}
    <input type="file" id="lw-input" wire:model="newImage" accept="image/*" class="hidden">

    {{-- Preview de la imagen seleccionada antes de pulsar Subir --}}
    <div id="lw-preview" class="hidden mt-2">
        <img id="lw-preview-img" src="" class="w-full h-24 object-cover rounded-lg border border-gray-200">
    </div>

    <button wire:click="upload"
            class="w-full mt-2 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition">
        Subir imagen
    </button>

    @error('newImage')
        <p class="text-red-500 text-xs">{{ $message }}</p>
    @enderror

    <div wire:loading wire:target="upload" class="text-sm text-gray-400 text-center">Subiendo...</div>

    <script>
        (function () {
            const dropzone = document.getElementById('lw-dropzone');
            const input    = document.getElementById('lw-input');
            const label    = document.getElementById('lw-dropzone-label');
            const preview  = document.getElementById('lw-preview');
            const prevImg  = document.getElementById('lw-preview-img');

            // Muestra miniatura y nombre del archivo seleccionado
            function showPreview(file) {
                if (!file) return;
                label.textContent = file.name;
                const reader = new FileReader();
                reader.onload = e => {
                    prevImg.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }

            // Cuando Livewire termina de procesar el upload, limpia el preview
            document.addEventListener('livewire:update', () => {
                preview.classList.add('hidden');
                label.textContent = 'Arrastra una imagen aquí o haz clic';
            });

            // Selección mediante explorador de archivos
            input.addEventListener('change', () => showPreview(input.files[0]));

            // Resalta el área mientras se arrastra encima
            dropzone.addEventListener('dragover', e => {
                e.preventDefault();
                dropzone.classList.add('border-indigo-400', 'bg-indigo-50');
            });

            dropzone.addEventListener('dragleave', () => {
                dropzone.classList.remove('border-indigo-400', 'bg-indigo-50');
            });

            // Al soltar el archivo: lo asigna al input y dispara el evento change
            // para que Livewire lo detecte a través de wire:model
            dropzone.addEventListener('drop', e => {
                e.preventDefault();
                dropzone.classList.remove('border-indigo-400', 'bg-indigo-50');
                const dt = new DataTransfer();
                dt.items.add(e.dataTransfer.files[0]); // solo la primera imagen
                input.files = dt.files;
                input.dispatchEvent(new Event('change')); // Livewire escucha este evento
                showPreview(input.files[0]);
            });
        })();
    </script>

</div>
