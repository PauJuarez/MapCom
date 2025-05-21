<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-info-variant-4 dark:text-gray-200 leading-tight">
            Detalls ( "{{ $botiga->nom }}" )
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-0 bg-info-variant-1-5 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <div class="mb-4 p-4" style="background-color:#55afeb;">
                        <h3 class="text-3xl font-semibold text-primary-variant-5 dark:text-white flex items-center gap-2">
                            {{ $botiga->nom }}
                            <span class="text-lg font-normal text-gray-700 dark:text-gray-300">
                                ({{ number_format($promedioValoracion, 1) }} de 5)
                            </span>
                        </h3>

                        <div class="flex items-center mt-2 space-x-1">
                            @php
                                $promedio = number_format($promedioValoracion, 1);
                                $estrellasCompletas = floor($promedio);
                                $mediaEstrella = ($promedio - $estrellasCompletas >= 0.5);
                                $estrellasVacias = 5 - $estrellasCompletas - ($mediaEstrella ? 1 : 0);
                            @endphp

                            {{-- Estrellas --}}
                            <div class="flex items-center space-x-0.5">
                                @for ($i = 0; $i < $estrellasCompletas; $i++)
                                    <i class="fas fa-star text-yellow-400 text-lg"></i>
                                @endfor

                                @if ($mediaEstrella)
                                    <i class="fas fa-star-half-alt text-yellow-400 text-lg"></i>
                                @endif

                                @for ($i = 0; $i < $estrellasVacias; $i++)
                                    <i class="far fa-star text-gray-300 dark:text-gray-600 text-lg"></i>
                                @endfor
                            </div>

                            {{-- Total reseñas --}}
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                ({{ $totalResenyas }} reseñas)
                            </span>
                        </div>
                    </div>


                    <!-- Información de la tienda -->
                    <div class="flex items-start justify-between p-6">
                        <div class="flex-1">
                            <div class="flex flex-col w-96 break-words overflow-hidden">
                                <strong class="text-info-variant-3 dark:text-info-variant-4">Adreça:</strong>
                                <p class="text-gray-700 dark:text-gray-300">{{ $botiga->adreca ?? 'No especificada' }}</p>
                            </div>
                            <br>
                            <div>
                            @if($botiga->web)
                                <div class="mb-4">
                                    <strong class="text-info-variant-3 dark:text-info-variant-4">Web:</strong>
                                    <p class="text-gray-700 dark:text-gray-300">
                                        <a href="{{ $botiga->web }}" target="_blank" rel="noopener noreferrer" class="text-blue-500 hover:text-blue-700">{{ $botiga->web }}</a>
                                    </p>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col w-full sm:w-96 md:w-[30rem] break-words overflow-hidden pr-10">
                            @if($botiga->descripcio)
                                <div class="mb-4">
                                    <strong class="text-info-variant-3 dark:text-info-variant-4">Descripció:</strong>
                                    <p class="text-gray-700 dark:text-gray-300 text-justify">{{ $botiga->descripcio }}</p>
                                </div>
                            @endif
                        </div>


                        </div>
                        <div>
                            <div>
                                @if($botiga->imatge)
                                    <div class="mb-4">
                                        <img src="{{ $botiga->imatge }}" alt="Imatge de la botiga" class="rounded-md w-72 h-auto">
                                    </div>
                                @endif
                            </div>
                            <div>
                                @if($botiga->horariObertura&&$botiga->horariTencament)
                                    <div class="mb-4">
                                        <strong class="text-info-variant-3 dark:text-info-variant-4">Horari d'Obertura y Tancament:</strong>
                                        <p class="text-gray-700 dark:text-gray-300">{{ $botiga->horariObertura }} - {{ $botiga->horariTencament }}</p>
                                    </div>
                                @endif
                            </div>
                            <div>
                                @if($botiga->telefono&&$botiga->coreoelectronic)
                                    <div class="mb-4">
                                        <strong class="text-info-variant-3 dark:text-info-variant-4">Contractos:</strong>
                                        <p class="text-gray-700 dark:text-gray-300">Telefono: {{ $botiga->telefono }}</p>
                                        <p class="text-gray-700 dark:text-gray-300">Correo: {{ $botiga->coreoelectronic }}</p>

                                    </div>
                                @endif
                            </div>
                            <div>
                                @if($botiga->latitud && $botiga->longitud)
                                    <div class="mb-4">
                                        <strong class="text-info-variant-3 dark:text-info-variant-4">Coordenades:</strong>
                                        <p class="text-gray-700 dark:text-gray-300">  Lat: {{ number_format($botiga->latitud, 2) }}, Lon: {{ number_format($botiga->longitud, 2) }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Información adicional -->
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                @if($botiga->latitud && $botiga->longitud)
                                    <div class="mb-4">
                                        <strong class="text-info-variant-3 dark:text-info-variant-4">Mapa:</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div id="map" style="height: 300px;"></div>
                    </div>
                    <div class="p-6">
                        <!-- Mapa de la tienda -->
                        @if($botiga->latitud && $botiga->longitud)
                            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Coordenadas de la tienda
                                    const latitud = {{ $botiga->latitud }};
                                    const longitud = {{ $botiga->longitud }};
                                    
                                    // Crear el mapa
                                    const map = L.map('map').setView([latitud, longitud], 15);

                                    // Capa base
                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        attribution: '&copy; OpenStreetMap contributors'
                                    }).addTo(map);

                                    // Icono personalizado para la tienda
                                    const iconUrl = 'https://cdn-icons-png.flaticon.com/512/484/484167.png'; // Icono personalizado
                                    const botigaIcon = L.icon({
                                        iconUrl: iconUrl,
                                        iconSize: [32, 32],
                                        iconAnchor: [16, 32]
                                    });

                                    // Agregar marcador
                                    L.marker([latitud, longitud], { icon: botigaIcon }).addTo(map)
                                        .bindPopup(`
                                            <strong>{{ $botiga->nom }}</strong><br>
                                            {{ $botiga->adreca ?? 'Sense adreça' }}<br>
                                            <em>{{ $botiga->descripcio ?? '' }}</em><br><br>
                                        `);
                                });
                            </script>
                        @endif

                        <!-- Botón para volver a la lista -->
                        <div class="mt-6">
                            <a href="{{ route('botigues.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:bg-gray-400 dark:focus:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Tornar a la llista') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-info-variant-1-5 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <div>
                        <!-- Reseñas y comentarios (esto ya está implementado en tu código) -->
                        @if($botiga->ressenyes->count())
                            <div class="mt-8">
                                <h4 class="text-lg font-semibold text-primary-variant-5 dark:text-white mb-4">Ressenyes</h4>
                                <div class="overflow-x-auto space-x-4 flex">
                                    @foreach($botiga->ressenyes as $r)
                                        <div class="inline-block w-72 flex-shrink-0 bg-white dark:bg-gray-800 border rounded dark:border-gray-600 p-4 break-words overflow-hidden min-h-[10px]">
                                            <p class="font-semibold text-primary-variant-4">
                                                {{ $r->usuari }} 
                                                <span class="text-sm text-gray-500">({{ $r->valoracio }}/5)</span>
                                            </p>
                                            <p class="text-sm mt-2 text-gray-700 dark:text-gray-300 break-words whitespace-normal">
                                                {{ $r->comentari }}
                                            </p>
                                            <p class="text-xs text-gray-400 mt-2">
                                                {{ \Carbon\Carbon::parse($r->dataPublicacio)->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div>
                        @if(Auth::check())
                            <div class="mt-6">
                                <h4 class="text-lg font-semibold text-primary-variant-5 dark:text-white mb-2">Deixa la teva ressenya</h4>

                                @if(session('success'))
                                    <div class="text-green-500 mb-2">{{ session('success') }}</div>
                                @endif
                                <form method="POST" action="{{ route('botigues.ressenya.guardar', $botiga->id) }}">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="valoracio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Valoració (1-5)</label>
                                        <input type="number" name="valoracio" id="valoracio" min="1" max="5" required
                                            class="bg-info-variant-1 form-control mt-1 rounded-md  dark:text-gray-100 dark:border-gray-600 w-full"></textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label for="comentari" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Comentari</label>
                                        <textarea name="comentari" id="comentari" rows="4" required
                                            class="bg-info-variant-1 form-control mt-1 rounded-md  dark:text-gray-100 dark:border-gray-600 w-full"></textarea>
                                    </div>

                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        Enviar ressenya
                                    </button>
                                </form>
                            </div>
                        @else
                            <p class="text-gray-700 dark:text-gray-300 mt-6">
                                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Inicia sessió</a> per deixar una ressenya.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
