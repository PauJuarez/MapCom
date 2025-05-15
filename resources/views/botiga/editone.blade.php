<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-info-variant-4 dark:text-gray-200 leading-tight">
            {{ __('Editar Botiga') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('botigues.update', ['id' => $botiga->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="nom"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Nom') }}</label>
                            <input type="text" name="nom" id="nom"
                                   value="{{ old('nom', $botiga->nom) }}"
                                   class="form-control mt-1 rounded-md dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                                   required>
                        </div>
                        <div class="col-md-6">
                            <label for="adreca"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Adreça') }}</label>
                            <input type="text" name="adreca" id="adreca"
                                   value="{{ old('adreca', $botiga->adreca) }}"
                                   class="form-control mt-1 rounded-md dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="descripcio"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Descripció') }}</label>
                        <textarea name="descripcio" id="descripcio" rows="3"
                                  class="form-control mt-1 rounded-md dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600">{{ old('descripcio', $botiga->descripcio) }}</textarea>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label for="web"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Web') }}</label>
                            <div class="input-group">
                                <input type="url" name="web" id="web"
                                       value="{{ old('web', $botiga->web) }}"
                                       class="form-control mt-1 rounded-md dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                                       placeholder="https://www.ejemplo.com">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                         <i class="fas fa-link"></i>
                                    </span>
                                </div>
                            </div>
                            <small class="form-text text-muted">Ej: https://www.ejemplo.com</small>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="horariObertura"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Horari d\'Obertura') }}</label>
                            <input type="time" name="horariObertura" id="horariObertura"
                                   value="{{ old('horariObertura', $botiga->horariObertura) }}"
                                   class="form-control mt-1 rounded-md dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600">
                        </div>
                        <div class="col-md-6">
                            <label for="horariTencament"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Horari de Tancament') }}</label>
                            <input type="time" name="horariTencament" id="horariTencament"
                                   value="{{ old('horariTencament', $botiga->horariTencament) }}"
                                   class="form-control mt-1 rounded-md dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="telefono" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Telèfon') }}</label>
                            <div class="input-group">
                                <input type="tel" name="telefono" id="telefono"
                                       value="{{ old('telefono', $botiga->telefono) }}"
                                       class="form-control mt-1 rounded-md dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600"
                                       placeholder="Ej: +34 123 456 789">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                </div>
                            </div>
                            <small class="form-text text-muted">Formato: +34 Código País Número</small>
                            <div id="phoneDisplayArea" style="margin-top: 10px;">
                                <strong>Teléfono:</strong>
                                <span id="phoneNumberDisplay">
                                    {{-- El número de teléfono formateado se mostrará aquí --}}
                                    <script>
                                        const telefonoValue = "{{ old('telefono', $botiga->telefono) }}";
                                        if (telefonoValue) {
                                            document.getElementById('phoneNumberDisplay').innerHTML = `<a href="tel:${telefonoValue.replace(/\s/g, '')}">${telefonoValue}</a>`;
                                        }
                                    </script>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="coreoelectronic"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Correu Electrònic') }}</label>
                            <input type="email" name="coreoelectronic" id="coreoelectronic"
                                   value="{{ old('coreoelectronic', $botiga->coreoelectronic) }}"
                                   class="form-control mt-1 rounded-md dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600">
                            <small class="form-text text-muted">Ej: correo@ejemplo.com</small>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="latitud"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Latitud') }}</label>
                            <input type="text" name="latitud" id="latitud"
                                   value="{{ old('latitud', $botiga->latitud) }}"
                                   class="form-control mt-1 rounded-md dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600">
                        </div>
                        <div class="col-md-3">
                            <label for="longitud"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Longitud') }}</label>
                            <input type="text" name="longitud" id="longitud"
                                   value="{{ old('longitud', $botiga->longitud) }}"
                                   class="form-control mt-1 rounded-md dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600">
                        </div>
                        <div class="col-md-6">
                            <label for="imatge"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Imatge') }}</label>
                            <input type="text" name="imatge" id="imatge"
                                   value="{{ old('imatge', $botiga->imatge) }}"
                                   class="form-control mt-1 rounded-md dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600">

                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div id="mapContainer" class="d-flex" style="height: 300px; margin-top: 10px;">
                                <div id="map" style="width: 50%; height: 100%;"></div>
                                <div id="imageDisplay" style="width: 50%; height: 100%; display: none;">
                                    <img id="imagePreview" src="#" alt="Vista previa de la imatge" style="max-width: 100%; max-height: 100%; border-radius: 5px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a href="{{ route('botigues.index') }}" class="btn btn-secondary">
                            {{ __('Volver') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            {{ __('Guardar Cambios') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet @1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet @1.9.4/dist/leaflet.js"></script>

<!-- Tu script -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const imageInput = document.getElementById('imatge');
    const imagePreview = document.getElementById('imagePreview');
    const mapDiv = document.getElementById('map');
    const imageDisplay = document.getElementById('imageDisplay');
    const telefonoInput = document.getElementById('telefono');
    const latitudInput = document.getElementById('latitud');
    const longitudInput = document.getElementById('longitud');

    let map;
    let marker;

    function initMap() {
        const catalunyaCenter = [41.6663, 1.8597];

        map = L.map('map').setView(catalunyaCenter, 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright ">OpenStreetMap</a> contributors'
        }).addTo(map);

        marker = L.marker(catalunyaCenter).addTo(map);
        marker.bindPopup("Selecciona una ubicació fent clic al mapa").openPopup();

        if (latitudInput && longitudInput && latitudInput.value && longitudInput.value) {
            const lat = parseFloat(latitudInput.value);
            const lng = parseFloat(longitudInput.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                const initialLatLng = [lat, lng];
                map.setView(initialLatLng, 15);
                marker.setLatLng(initialLatLng);
                marker.bindPopup("Ubicació seleccionada:<br>Lat: " + lat.toFixed(6) + "<br>Lng: " + lng.toFixed(6));
            }
        }

        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            latitudInput.value = lat.toFixed(6);
            longitudInput.value = lng.toFixed(6);
            marker.setLatLng([lat, lng]);
            marker.bindPopup("Ubicació seleccionada:<br>Lat: " + lat.toFixed(6) + "<br>Lng: " + lng.toFixed(6)).openPopup();
        });
    }

    function updateMap() {
        const lat = parseFloat(latitudInput?.value);
        const lng = parseFloat(longitudInput?.value);
        if (!isNaN(lat) && !isNaN(lng)) {
            const newLatLng = [lat, lng];
            map.setView(newLatLng, 15);
            marker.setLatLng(newLatLng);
        }
    }

    function toggleImageVisibility(imageUrl) {
        if (imageUrl) {
            imagePreview.src = imageUrl;
            imageDisplay.style.display = 'flex';
        } else {
            imageDisplay.style.display = 'none';
            imagePreview.src = '#';
        }
    }

    function formatPhoneNumber(input) {
        let numbers = input.value.replace(/\D/g, '');
        let formattedNumber = numbers;
        if (numbers.startsWith('34') && numbers.length === 11) {
            formattedNumber = '+' + numbers.substring(0, 2) + ' ' + numbers.substring(2, 5) + ' ' + numbers.substring(5, 8) + ' ' + numbers.substring(8);
        }
        input.value = formattedNumber;
    }

    telefonoInput?.addEventListener('input', function() {
        formatPhoneNumber(this);
    });

    imageInput?.addEventListener('input', function () {
        toggleImageVisibility(this.value);
    });

    latitudInput?.addEventListener('input', updateMap);
    longitudInput?.addEventListener('input', updateMap);

    window.onload = function () {
        initMap();
        toggleImageVisibility(imageInput?.value);
        const telefonoValue = "{{ old('telefono', $botiga->telefono) }}";
        if (telefonoValue) {
            document.getElementById('phoneNumberDisplay').innerHTML = `<a href="tel:${telefonoValue.replace(/\s/g, '')}">${telefonoValue}</a>`;
        }
    };
});
</script>
</x-app-layout>
