<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-info-variant-4 leading-tight">
            {{ __('Crear Botiga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 bg-primary-variant-1">

                <form method="POST" action="{{ route('botigues.store') }}">
                    @csrf

                    <!-- Nom -->
                    <div class="mb-4">
                        <label for="nom" class="block text-sm font-medium text-gray-700">{{ __('Nom') }}</label>
                        <input type="text" name="nom" id="nom"
                            class="bg-info-variant-1 form-control mt-1 w-1/2 rounded-md shadow-sm border-gray-300 focus:border-info-500 focus:ring focus:ring-info-200"
                            required>
                    </div>

                    <!-- Descripció -->
                    <div class="mb-4">
                        <label for="descripcio" class="block text-sm font-medium text-gray-700">{{ __('Descripció') }}</label>
                        <textarea name="descripcio" id="descripcio" rows="3"
                            class="bg-info-variant-1 form-control mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-info-500 focus:ring focus:ring-info-200"></textarea>
                    </div>

                    <!-- Adreça -->
                    <div class="mb-4">
                        <label for="adreca" class="block text-sm font-medium text-gray-700">{{ __('Adreça') }}</label>
                        <input type="text" name="adreca" id="adreca"
                            class="bg-info-variant-1 form-control mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-info-500 focus:ring focus:ring-info-200">
                    </div>

                    <!-- Latitud i Longitud + Mapa -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="latitud" class="block text-sm font-medium text-gray-700">{{ __('Latitud') }}</label>
                            <input type="text" name="latitud" id="latitud"
                                class="bg-info-variant-1 form-control mt-1 rounded-md shadow-sm border-gray-300 focus:border-info-500 focus:ring focus:ring-info-200">
                        </div>
                        <div class="col-md-6">
                            <label for="longitud" class="block text-sm font-medium text-gray-700">{{ __('Longitud') }}</label>
                            <input type="text" name="longitud" id="longitud"
                                class="bg-info-variant-1 form-control mt-1 rounded-md shadow-sm border-gray-300 focus:border-info-500 focus:ring focus:ring-info-200">
                        </div>
                        <div class="col-md-12">
                            <div id="mapContainer" class="d-flex mt-4" style="height: 300px;">
                                <div id="map" style="width: 100%; height: 100%;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Característiques -->
                    <div class="form-group mb-4">
                        <label for="caracteristiques" class="block text-sm font-medium text-gray-700">Característiques:</label>
                        <div class="row mb-4 max-w-4xl mx-auto sm:px-6 lg:px-8">
                            @foreach($caracteristiques as $caracteristica)
                                <div class="col-md-4">
                                    <div class="form-check block text-sm font-medium text-gray-700">
                                        <input type="checkbox" name="caracteristiques[]" value="{{ $caracteristica->id }}"
                                            class="form-check-input" id="caracteristica{{ $caracteristica->id }}">
                                        <label class="form-check-label" for="caracteristica{{ $caracteristica->id }}">
                                            {{ $caracteristica->nom }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Guardar Botiga') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Script del Mapa -->
<script>
    const mapDiv = document.getElementById('map');
    const latitudInput = document.getElementById('latitud');
    const longitudInput = document.getElementById('longitud');

    let map;
    let marker;

    function initMap() {
        const catalunyaCenter = [41.6663, 1.8597];

        map = L.map('map').setView(catalunyaCenter, 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        marker = L.marker(catalunyaCenter).addTo(map);
        marker.bindPopup("Selecciona una ubicació fent clic al mapa").openPopup();

        if (latitudInput.value && longitudInput.value) {
            const lat = parseFloat(latitudInput.value);
            const lng = parseFloat(longitudInput.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                const initialLatLng = [lat, lng];
                map.setView(initialLatLng, 15);
                marker.setLatLng(initialLatLng);
                marker.bindPopup(`Ubicació seleccionada:<br>Lat: ${lat.toFixed(6)}<br>Lng: ${lng.toFixed(6)}`);
            }
        }

        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            latitudInput.value = lat.toFixed(6);
            longitudInput.value = lng.toFixed(6);

            marker.setLatLng([lat, lng]).addTo(map);
            marker.bindPopup(`Ubicació seleccionada:<br>Lat: ${lat.toFixed(6)}<br>Lng: ${lng.toFixed(6)}`).openPopup();
        });
    }

    function updateMarkerFromInputs() {
        const lat = parseFloat(latitudInput.value);
        const lng = parseFloat(longitudInput.value);

        if (!isNaN(lat) && !isNaN(lng)) {
            const newLatLng = [lat, lng];
            map.setView(newLatLng, 15);
            marker.setLatLng(newLatLng).addTo(map);
            marker.bindPopup(`Ubicació seleccionada:<br>Lat: ${lat.toFixed(6)}<br>Lng: ${lng.toFixed(6)}`).openPopup();
        }
    }

    latitudInput.addEventListener('input', updateMarkerFromInputs);
    longitudInput.addEventListener('input', updateMarkerFromInputs);

    window.onload = function () {
        initMap();
    };
</script>

<!-- Recuerda incluir Leaflet en tu layout o en esta vista -->
<!-- Puedes añadir esto en tu layout principal o sección head -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
