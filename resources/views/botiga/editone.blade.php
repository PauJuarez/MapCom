<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-info-variant-4 leading-tight">
            {{ __('Editar Botiga') }}
        </h2>
    </x-slot>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 bg-primary-variant-1">
                <form method="POST" action="{{ route('botigues.update', ['id' => $botiga->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="nom" class="block text-sm font-medium text-gray-700">{{ __('Nom') }}</label>
                            <input type="text" name="nom" id="nom"
                                   value="{{ old('nom', $botiga->nom) }}"
                                   class="bg-info-variant-1 form-control mt-1 border-gray-300 rounded-md"
                                   required>
                        </div>
                        <div class="col-md-6">
                            <label for="adreca" class="block text-sm font-medium text-gray-700">{{ __('Adreça') }}</label>
                            <input type="text" name="adreca" id="adreca"
                                   value="{{ old('adreca', $botiga->adreca) }}"
                                   class="bg-info-variant-1 form-control mt-1 border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="descripcio" class="block text-sm font-medium text-gray-700">{{ __('Descripció') }}</label>
                        <textarea name="descripcio" id="descripcio" rows="3"
                                  class="bg-info-variant-1 form-control mt-1 border-gray-300 rounded-md">{{ old('descripcio', $botiga->descripcio) }}</textarea>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label for="web" class="block text-sm font-medium text-gray-700">{{ __('Web') }}</label>
                            <div class="input-group">
                                <input type="url" name="web" id="web"
                                       value="{{ old('web', $botiga->web) }}"
                                       class="bg-info-variant-1 form-control mt-1 border-gray-300 rounded-md"
                                       placeholder="https://www.ejemplo.com">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-link"></i></span>
                                </div>
                            </div>
                            <small class="form-text text-muted">Ej: https://www.ejemplo.com</small>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="horariObertura" class="block text-sm font-medium text-gray-700">{{ __('Horari d\'Obertura') }}</label>
                            <input type="time" name="horariObertura" id="horariObertura"
                                   value="{{ old('horariObertura', $botiga->horariObertura) }}"
                                   class="bg-info-variant-1 form-control mt-1 border-gray-300 rounded-md">
                        </div>
                        <div class="col-md-6">
                            <label for="horariTencament" class="block text-sm font-medium text-gray-700">{{ __('Horari de Tancament') }}</label>
                            <input type="time" name="horariTencament" id="horariTencament"
                                   value="{{ old('horariTencament', $botiga->horariTencament) }}"
                                   class="bg-info-variant-1 form-control mt-1 border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="telefono" class="block text-sm font-medium text-gray-700">{{ __('Telèfon') }}</label>
                            <input type="tel" name="telefono" id="telefono"
                                   value="{{ old('telefono', $botiga->telefono) }}"
                                   class="bg-info-variant-1 form-control mt-1 border-gray-300 rounded-md"
                                   placeholder="Ej: +34 123 456 789">
                            <small class="form-text text-muted">Formato: +34 Código País Número</small>
                            <div id="phoneDisplayArea" style="margin-top: 10px;">
                                <strong>Teléfono:</strong>
                                <span id="phoneNumberDisplay"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="coreoelectronic" class="block text-sm font-medium text-gray-700">{{ __('Correu Electrònic') }}</label>
                            <input type="email" name="coreoelectronic" id="coreoelectronic"
                                   value="{{ old('coreoelectronic', $botiga->coreoelectronic) }}"
                                   class="bg-info-variant-1 form-control mt-1 border-gray-300 rounded-md">
                            <small class="form-text text-muted">Ej: correo@ejemplo.com</small>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="latitud" class="block text-sm font-medium text-gray-700">{{ __('Latitud') }}</label>
                            <input type="text" name="latitud" id="latitud"
                                   value="{{ old('latitud', $botiga->latitud) }}"
                                   class="bg-info-variant-1 form-control mt-1 border-gray-300 rounded-md">
                        </div>
                        <div class="col-md-3">
                            <label for="longitud" class="block text-sm font-medium text-gray-700">{{ __('Longitud') }}</label>
                            <input type="text" name="longitud" id="longitud"
                                   value="{{ old('longitud', $botiga->longitud) }}"
                                   class="bg-info-variant-1 form-control mt-1 border-gray-300 rounded-md">
                        </div>
                        <div class="col-md-6">
                            <label for="imatge" class="block text-sm font-medium text-gray-700">{{ __('Imatge') }}</label>
                            <input type="text" name="imatge" id="imatge"
                                   value="{{ old('imatge', $botiga->imatge) }}"
                                   class="bg-info-variant-1 form-control mt-1 border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div id="mapContainer" class="d-flex" style="height: 300px; margin-top: 10px; gap: 20px;">
                                <div id="map" style="width: 50%; height: 100%;"></div>
                                <div id="imageDisplay" style="width: 50%; height: 100%; display: none;">
                                    <img id="imagePreview" src="#" alt="Vista previa de la imatge" style="max-width: 100%; max-height: 100%; border-radius: 5px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Característiques:</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($caracteristiques as $caracteristica)
                                <div class="flex items-center space-x-2">
                                    <input
                                        type="checkbox"
                                        name="caracteristiques[]"
                                        value="{{ $caracteristica->id }}"
                                        id="caracteristica_{{ $caracteristica->id }}"
                                        class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                        @if (is_array(old('caracteristiques')) && in_array($caracteristica->id, old('caracteristiques')))
                                            checked
                                        @elseif ($botiga->caracteristiques->contains($caracteristica->id))
                                            checked
                                        @endif
                                    >
                                    <label for="caracteristica_{{ $caracteristica->id }}" class="text-sm text-gray-700">
                                        {{ $caracteristica->nom }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a href="{{ route('botigues.index') }}" class="btn btn-secondary">
                            {{ __('Tornar') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            {{ __('Desar Canvis') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const imageInput = document.getElementById('imatge');
        const imagePreview = document.getElementById('imagePreview');
        const mapDiv = document.getElementById('map');
        const imageDisplay = document.getElementById('imageDisplay');
        const telefonoInput = document.getElementById('telefono');
        const latitudInput = document.getElementById('latitud');
        const longitudInput = document.getElementById('longitud');

        let map, marker;

        function initMap() {
            const defaultCoords = [41.6663, 1.8597];
            map = L.map('map').setView(defaultCoords, 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            marker = L.marker(defaultCoords).addTo(map);
            marker.bindPopup("Selecciona una ubicació fent clic al mapa").openPopup();

            if (latitudInput.value && longitudInput.value) {
                const lat = parseFloat(latitudInput.value);
                const lng = parseFloat(longitudInput.value);
                if (!isNaN(lat) && !isNaN(lng)) {
                    const position = [lat, lng];
                    map.setView(position, 15);
                    marker.setLatLng(position).bindPopup(`Ubicació seleccionada:<br>Lat: ${lat}<br>Lng: ${lng}`);
                }
            }

            map.on('click', function (e) {
                const { lat, lng } = e.latlng;
                latitudInput.value = lat.toFixed(6);
                longitudInput.value = lng.toFixed(6);
                marker.setLatLng([lat, lng])
                      .bindPopup(`Ubicació seleccionada:<br>Lat: ${lat.toFixed(6)}<br>Lng: ${lng.toFixed(6)}`)
                      .openPopup();
            });
        }

        function toggleImageVisibility(url) {
            if (url) {
                imagePreview.src = url;
                imageDisplay.style.display = 'flex';
            } else {
                imagePreview.src = '#';
                imageDisplay.style.display = 'none';
            }
        }

        function formatPhoneNumber(input) {
            let numbers = input.value.replace(/\D/g, '');
            if (numbers.startsWith('34') && numbers.length === 11) {
                input.value = '+' + numbers.substring(0, 2) + ' ' + numbers.substring(2, 5) + ' ' + numbers.substring(5, 8) + ' ' + numbers.substring(8);
            }
        }

        function updatePhoneDisplay(value) {
            const cleanValue = value.replace(/\s/g, '');
            const display = document.getElementById('phoneNumberDisplay');
            if (display) {
                display.innerHTML = `<a href="tel:${cleanValue}">${value}</a>`;
            }
        }

        telefonoInput?.addEventListener('input', function () {
            formatPhoneNumber(this);
            updatePhoneDisplay(this.value);
        });

        imageInput?.addEventListener('input', function () {
            toggleImageVisibility(this.value);
        });

        latitudInput?.addEventListener('input', function () {
            const lat = parseFloat(this.value);
            const lng = parseFloat(longitudInput.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                map.setView([lat, lng], 15);
                marker.setLatLng([lat, lng]);
            }
        });

        longitudInput?.addEventListener('input', function () {
            const lat = parseFloat(latitudInput.value);
            const lng = parseFloat(this.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                map.setView([lat, lng], 15);
                marker.setLatLng([lat, lng]);
            }
        });

        window.onload = () => {
            initMap();
            toggleImageVisibility(imageInput?.value);
            updatePhoneDisplay(telefonoInput?.value);
        };
    });
    </script>
</x-app-layout>
