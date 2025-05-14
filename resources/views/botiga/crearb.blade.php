<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-info-variant-4 dark:text-gray-200 leading-tight">
            {{ __('Crear Botiga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 bg-primary-variant-1">

                <form method="POST" action="{{ route('botigues.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="nom"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Nom') }}</label>
                        <input type="text" name="nom" id="nom"
                               class="bg-info-variant-1 form-control mt-1 w-1/2 rounded-md shadow-sm border-gray-300 focus:border-info-500 focus:ring focus:ring-info-200 dark:bg-gray-700 dark:text-white"
                               required>
                    </div>


                    <div class="mb-4">
                        <label for="descripcio"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Descripció') }}</label>
                        <textarea name="descripcio" id="descripcio" rows="3"
                                  class=" bg-info-variant-1 form-control mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-info-500 focus:ring focus:ring-info-200 dark:bg-gray-700 dark:text-white"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="adreca"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Adreça') }}</label>
                        <input type="text" name="adreca" id="adreca"
                               class="bg-info-variant-1 form-control mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-info-500 focus:ring focus:ring-info-200 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="latitud"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Latitud') }}</label>
                            <input type="text" name="latitud" id="latitud"
                                   class="bg-info-variant-1 form-control mt-1 rounded-md shadow-sm border-gray-300 focus:border-info-500 focus:ring focus:ring-info-200 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div class="col-md-6">
                            <label for="longitud"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Longitud') }}</label>
                            <input type="text" name="longitud" id="longitud"
                                   class="bg-info-variant-1 form-control mt-1 rounded-md shadow-sm border-gray-300 focus:border-info-500 focus:ring focus:ring-info-200 dark:bg-gray-700 dark:text-white">
                        </div>
                         <div class="col-md-12">
                            <div id="mapContainer" class="d-flex" style="height: 300px; margin-top: 10px;">
                                <div id="map" style="width: 100%; height: 100%;"></div>
                            </div>
                         </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Guardar Botiga') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
<script>
    const mapDiv = document.getElementById('map');
    const mapContainer = document.getElementById('mapContainer');
    const latitudInput = document.getElementById('latitud');
    const longitudInput = document.getElementById('longitud');


    let map;
    let marker;


    function initMap() {
        const catalunyaCenter = [41.6663, 1.8597];
        map = L.map('map', {
            center: catalunyaCenter,
            zoom: 15.2,
            renderer: L.canvas()
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            tileSize: 256,
            zoomOffset: 0,
            maxZoom: 19,
        }).addTo(map);

        marker = L.marker([0, 0]).addTo(map);
        marker.setLatLng([catalunyaCenter[0], catalunyaCenter[1]]);
        marker.setStyle({ display: 'none' });
        map.invalidateSize();

        // Si hay valores de latitud y longitud iniciales, mostrar el marcador
        if (latitudInput.value && longitudInput.value) {
            const lat = parseFloat(latitudInput.value);
            const lng = parseFloat(longitudInput.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                const initialLatLng = [lat, lng];
                map.setView(initialLatLng, 15);
                marker.setLatLng(initialLatLng);
                marker.setStyle({ display: 'block' });
            }
        }
    }

    function updateMap() {
        const lat = parseFloat(latitudInput.value);
        const lng = parseFloat(longitudInput.value);

        if (!isNaN(lat) && !isNaN(lng)) {
            const newLatLng = [lat, lng];
            map.setView(newLatLng, 15);
            marker.setLatLng(newLatLng);
            marker.setStyle({ display: 'block' });
        } else {
            marker.setStyle({ display: 'none' });
        }
    }



    latitudInput.addEventListener('input', updateMap);
    longitudInput.addEventListener('input', updateMap);

    window.onload = function () {
        initMap();
    };
</script>
</x-app-layout>
