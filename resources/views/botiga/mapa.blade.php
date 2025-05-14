<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-info-variant-4 dark:text-gray-200 leading-tight">
            {{ __('Mapa de Botigues a Catalunya') }}
        </h2>
    </x-slot>

    <!-- Añade esto en el head -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl p-6 bg-info-variant-1-5">
                <!-- Contenedor del mapa -->
                <div id="map" style="height: 600px;"></div>
                
                <!-- Mensaje si no hay coordenadas -->
                <div id="no-data" class="hidden text-center mt-4 text-red-600">
                    No s'han trobat botigues amb coordenades vàlides
                </div>
            </div>
        </div>
    </div>

    <!-- Script del mapa -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Centro de Catalunya
            const catalunyaCenter = [41.6663, 1.8597];
            const map = L.map('map').setView(catalunyaCenter, 15.2);

            // Capa base
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Datos de Laravel
            const botigues = @json($botigues);

            // Contador de marcadores
            let marcadores = 0;

            // Icono personalizado
            const iconUrl = 'https://cdn-icons-png.flaticon.com/512/484/484167.png'; // Nuevo icono de localización
            const botigaIcon = L.icon({
                iconUrl: iconUrl,
                iconSize: [32, 32],
                iconAnchor: [16, 32]
            });

            // Procesar cada botiga
            botigues.forEach(botiga => {
                if (botiga.latitud && botiga.longitud && 
                    !isNaN(parseFloat(botiga.latitud)) && 
                    !isNaN(parseFloat(botiga.longitud))) {
                    
                    L.marker([botiga.latitud, botiga.longitud], { icon: botigaIcon })
                        .addTo(map)
                        .bindPopup(`
                            <strong>${botiga.nom}</strong><br>
                            ${botiga.adreca || 'Sense adreça'}<br>
                            <em>${botiga.descripcio || ''}</em><br><br>
                            <a href="/botigues/botiga/${botiga.id}" class="text-blue-500 hover:text-blue-700 underline">Veure Detalls</a>
                        `);

                    marcadores++;
                }
            });

            // Manejar caso sin datos
            if (marcadores === 0) {
                document.getElementById('no-data').classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>