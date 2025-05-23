<style>
  /* Estilo por defecto (en pantallas grandes) */
  #map {
    height: 500px;
  }

  /* Estilo para dispositivos móviles */
  @media (max-width: 768px) {
    #map {
      height: 300px;
    }
  }
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 id="map-title" class="font-semibold text-xl text-info-variant-4 leading-tight">
            {{ __('Mapa de Botigues a Sant Vicenç de Castellet') }}
        </h2>
    </x-slot>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl p-6 bg-info-variant-1-5">
            <!-- Selector de Municipios -->
                <div class="mb-6">
                    <select id="municipiSelect" class="bg-info-variant-2 w-full sm:w-1/2 p-2 border rounded-md">
                        <option value="">-- Selecciona un municipi --</option>
                        @foreach($municipis as $municipi)
                            <option value="{{ $municipi->id }}"
                                data-lat="{{ $municipi->latitud }}"
                                data-lng="{{ $municipi->longitud }}"
                                data-zoom="{{ $municipi->zoom }}">
                                {{ $municipi->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            <!-- Filtro dinámico por características -->
                <form id="filterForm" method="GET" action="{{ route('botigues.mapa') }}" class="mb-6">
                    <div class="flex flex-col">
                    <!-- Botones toggle -->
                        <div class="flex flex-wrap gap-2" id="caracteristiquesContainer">
                            @foreach($caracteristiques as $carac)
                                @php
                                    $isSelected = is_array(request('caracteristiques')) && in_array($carac->id, request('caracteristiques'));
                                @endphp
                                <button type="button"
                                        data-id="{{ $carac->id }}"
                                        class="caracteristica-btn px-4 py-1 rounded-full text-sm font-medium transition-all duration-200
                                            {{ $isSelected ? 'bg-info-variant-5 text-white' : 'bg-info-variant-2 text-gray-800 hover:bg-info-variant-2' }}">
                                    {{ $carac->nom }}
                                </button>
                            @endforeach
                        </div>
                    <!-- Input oculto para IDs seleccionadas -->
                        <input type="hidden" name="caracteristiques[]" id="selectedCaracteristiques" value="{{ request('caracteristiques') ? implode(',', request('caracteristiques')) : '' }}">
                    </div>
                </form>
            <!-- Mapa -->
                <div id="map"></div>
            <!-- Mensaje si no hay botigas -->
                <div id="no-data" class="hidden text-center mt-4 text-red-600">
                    No s'han trobat botigues amb coordenades vàlides
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Iniciar mapa con valores por defecto
            let currentMap = L.map('map');

            // Valores por defecto si no se ha seleccionado ningún municipio
            let defaultCenter = [41.66856851, 1.86356038]; // Sant Vicenç de Castellet aproximado
            let defaultZoom = 15;

            currentMap.setView(defaultCenter, defaultZoom);

            // Añadir capa OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(currentMap); // ✅ Usamos currentMap


            // Manejador del selector de municipios
            document.getElementById('municipiSelect').addEventListener('change', function () {
                const selected = this.options[this.selectedIndex];
                const lat = parseFloat(selected.getAttribute('data-lat'));
                const lng = parseFloat(selected.getAttribute('data-lng'));
                const zoom = parseInt(selected.getAttribute('data-zoom'));

                if (!isNaN(lat) && !isNaN(lng) && !isNaN(zoom)) {
                    currentMap.setView([lat, lng], zoom);
                }
            });


            // Mostrar botigues
            const botigues = @json($botigues);
            let marcadores = 0;

            const botigaIcon = L.icon({
                iconUrl: 'https://cdn-icons-png.flaticon.com/512/484/484167.png ',
                iconSize: [32, 32],
                iconAnchor: [16, 32]
            });

            botigues.forEach(botiga => {
                if (botiga.latitud && botiga.longitud && !isNaN(parseFloat(botiga.latitud)) && !isNaN(parseFloat(botiga.longitud))) {
                    L.marker([botiga.latitud, botiga.longitud], { icon: botigaIcon })
                        .addTo(currentMap) // ✅ Agregar al mapa correcto
                        .bindPopup(`
                            <strong>${botiga.nom}</strong><br>
                            ${botiga.adreca || 'Sense adreça'}<br>
                            <em>${botiga.descripcio || ''}</em><br><br>
                            <a href="/botigues/botiga/${botiga.id}" class="text-blue-500 hover:text-blue-700 underline">Veure Detalls</a>
                        `);
                    marcadores++;
                }
            });

            if (marcadores === 0) {
                document.getElementById('no-data').classList.remove('hidden');
            }

            // Filtro de características
            const buttons = document.querySelectorAll('.caracteristica-btn');
            const hiddenInput = document.getElementById('selectedCaracteristiques');

            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    let selected = [...hiddenInput.value.split(',')].filter(Boolean);

                    const index = selected.indexOf(id);
                    if (index === -1) {
                        selected.push(id);
                        this.classList.remove('bg-gray-200', 'text-gray-800', 'hover:bg-gray-300');
                        this.classList.add('bg-blue-600', 'text-white');
                    } else {
                        selected.splice(index, 1);
                        this.classList.remove('bg-blue-600', 'text-white');
                        this.classList.add('bg-gray-200', 'text-gray-800', 'hover:bg-gray-300');
                    }

                    hiddenInput.value = selected.join(',');

                    // Construir URL
                    const params = new URLSearchParams();
                    selected.forEach(id => params.append('caracteristiques[]', id));

                    const perPage = new URLSearchParams(window.location.search).get('per_page');
                    if (perPage) {
                        params.set('per_page', perPage);
                    }

                    // Redirigir a ruta actual (mapa)
                    window.location.href = "{{ route('botigues.mapa') }}?" + params.toString();
                });
            });
        });


        const titleElement = document.getElementById('map-title');
        const municipiSelect = document.getElementById('municipiSelect');

        // Función para actualizar el título
        function updateTitle() {
            const selected = municipiSelect.options[municipiSelect.selectedIndex];
            const municipiNombre = selected.text.trim();

            if (municipiNombre && municipiNombre !== '-- Selecciona un municipi --') {
                titleElement.textContent = `Mapa de Botigues a ${municipiNombre}`;
            } else {
                titleElement.textContent = 'Mapa de Botigues a Sant Vicenç de Castellet';
            }
        }

        // Llamar al cargar por primera vez
        updateTitle();

        // Escuchar cambios en el selector
municipiSelect.addEventListener('change', updateTitle);
    </script>
</x-app-layout>
