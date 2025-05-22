<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary-variant-4 leading-tight">
            {{ __('Editar Municipio') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @if ($errors->any())
                <div class="mb-4 p-4 rounded bg-red-100 text-red-700 border border-red-400">
                    <strong>Se encontraron errores:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario de edición -->
            <form action="{{ route('municipis.update', $municipi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Campo Nombre -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nombre">Nombre</label>
                    <input name="nombre"
                           id="nombre"
                           value="{{ old('nombre', $municipi->nombre) }}"
                           required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           type="text"
                           placeholder="Ej: Barcelona">
                </div>

                <!-- Campos Latitud y Longitud -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="latitud">Latitud</label>
                        <input name="latitud"
                               id="latitud"
                               readonly
                               value="{{ old('latitud', $municipi->latitud) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-100"
                               type="number"
                               step="any">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="longitud">Longitud</label>
                        <input name="longitud"
                               id="longitud"
                               readonly
                               value="{{ old('longitud', $municipi->longitud) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-100"
                               type="number"
                               step="any">
                    </div>
                </div>

                <!-- Campo Zoom -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="zoom">Zoom</label>
                    <input name="zoom"
                           id="zoom"
                           readonly
                           value="{{ old('zoom', $municipi->zoom ?? '7') }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-100"
                           type="number"
                           step="0.1"
                           min="0"
                           max="18.9">
                </div>

                <!-- Mapa -->
                <div id="map" class="w-full h-96 bg-gray-300 rounded mb-6"></div>
                <p class="text-sm text-gray-500 mb-6">Haz clic en el mapa para seleccionar una nueva ubicación.</p>

                <!-- Botones -->
                <div class="flex items-center justify-between">
                    <button type="submit"
                            class="bg-primary-variant-4 hover:bg-primary-variant-5 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Guardar Cambios
                    </button>

                    <a href="{{ route('municipis.index') }}"
                       class="inline-block align-baseline font-bold text-sm text-primary-variant-4 hover:text-primary-variant-5">
                        Volver a la lista
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet @1.9.4/dist/leaflet.js"></script>

<!-- Script para inicializar el mapa -->
<script>
    // Obtener coordenadas desde el servidor o usar valores por defecto
    const initialLat = parseFloat("{{ old('latitud', $municipi->latitud ?? 41.3888) }}");
    const initialLng = parseFloat("{{ old('longitud', $municipi->longitud ?? 2.158) }}");
    const initialZoom = parseInt("{{ old('zoom', $municipi->zoom ?? 7) }}");

    // Inicializar el mapa
    var map = L.map('map').setView([initialLat, initialLng], initialZoom);

    // Capa base con OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Variable para almacenar el marcador
    var marker = null;

    // Colocar marcador inicial si hay coordenadas
    if (!isNaN(initialLat) && !isNaN(initialLng)) {
        marker = L.marker([initialLat, initialLng]).addTo(map)
            .bindPopup("Ubicación actual")
            .openPopup();
    }

    // Evento al hacer clic en el mapa
    map.on('click', function(e) {
        const lat = e.latlng.lat.toFixed(8);
        const lng = e.latlng.lng.toFixed(8);
        const zoomLevel = map.getZoom();

        // Actualizar inputs
        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;
        document.getElementById('zoom').value = zoomLevel;

        // Quitar marcador anterior si existe
        if (marker) {
            map.removeLayer(marker);
        }

        // Agregar nuevo marcador
        marker = L.marker([lat, lng]).addTo(map)
            .bindPopup("Ubicación seleccionada")
            .openPopup();
    });
</script>