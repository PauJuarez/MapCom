<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-info-variant-4 leading-tight">
            Detalls ( "{{ $botiga->nom }}" )
        </h2>
    </x-slot>
    <div class="flex flex-col md:flex-row gap-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-0 bg-info-variant-1-5 border-b border-gray-200">
                    <div class="mb-4 p-4" style="background-color:#55afeb;">
                        <h3 class="text-3xl font-semibold text-primary-variant-5 flex items-center gap-2">
                            {{ $botiga->nom }}
                            <span class="text-lg font-normal text-gray-700">
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
                                    <i class="far fa-star text-gray-300 text-lg"></i>
                                @endfor
                            </div>

                            {{-- Total reseñas --}}
                            <span class="ml-2 text-sm text-gray-600">
                                ({{ $totalResenyas }} reseñas)
                            </span>
                        </div>
                    </div>
                    <!-- Información de la tienda -->
                        <div class="flex flex-col md:flex-row gap-6 p-6">
                            <!-- Columna izquierda -->
                            <div class="w-full md:w-1/2 space-y-4">
                                <div class="flex flex-col w-full break-words overflow-hidden">
                                    <strong class="text-info-variant-3">Adreça:</strong>
                                    <p class="text-gray-700">{{ $botiga->adreca ?? 'No especificada' }}</p>
                                </div>

                                @if($botiga->web)
                                <div>
                                    <strong class="text-info-variant-3">Web:</strong>
                                    <p class="text-gray-700 break-words">
                                        <a href="{{ $botiga->web }}" target="_blank" rel="noopener noreferrer" class="text-blue-500 hover:text-blue-700 break-all">{{ $botiga->web }}</a>
                                    </p>
                                </div>
                                @endif

                                @if($botiga->descripcio)
                                <div class="flex flex-col w-full break-words overflow-hidden">
                                    <strong class="text-info-variant-3">Descripció:</strong>
                                    <p class="text-gray-700 text-justify">{{ $botiga->descripcio }}</p>
                                </div>
                                @endif
                            </div>

                            <!-- Columna derecha -->
                            <div class="w-full md:w-1/2 space-y-4">
                                @if($botiga->imatge)
                                    <div>
                                        <img src="{{ $botiga->imatge }}" alt="Imatge de la botiga" class="rounded-md w-full max-w-xs md:max-w-sm h-auto object-cover">
                                    </div>
                                @endif

                                @if($botiga->horariObertura && $botiga->horariTencament)
                                    <div>
                                        <strong class="text-info-variant-3">Horari d'Obertura i Tancament:</strong>
                                        <p class="text-gray-700">{{ $botiga->horariObertura }} - {{ $botiga->horariTencament }}</p>
                                    </div>
                                @endif

                                @if($botiga->telefono && $botiga->coreoelectronic)
                                    <div>
                                        <strong class="text-info-variant-3">Contactes:</strong>
                                        <p class="text-gray-700">Telèfon: {{ $botiga->telefono }}</p>
                                        <p class="text-gray-700">Correu: {{ $botiga->coreoelectronic }}</p>
                                    </div>
                                @endif

                                @if($botiga->latitud && $botiga->longitud)
                                    <div>
                                        <strong class="text-info-variant-3">Coordenades:</strong>
                                        <p class="text-gray-700">Lat: {{ number_format($botiga->latitud, 2) }}, Lon: {{ number_format($botiga->longitud, 2) }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    <!-- Información adicional -->
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                @if($botiga->latitud && $botiga->longitud)
                                    <div class="mb-4">
                                        <strong class="text-info-variant-3">Mapa:</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div id="map" class="w-full h-64 md:h-96"></div>
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
                            <a href="{{ route('botigues.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Tornar a la llista') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-info-variant-1-5 border-b border-gray-200">
                    <div>
                        {{-- Cambiamos $botiga->ressenyes por $ressenyesPaginades --}}
                        @if($ressenyesPaginades->count()) 
                            <div class="mt-8">
                                <h4 class="text-lg font-semibold text-primary-variant-5 mb-4">Ressenyes</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    {{-- Iteramos sobre la colección paginada --}}
                                    @foreach($ressenyesPaginades as $r)
                                        <div x-data="{ expanded: false }" 
                                            @click="expanded = !expanded"
                                            class="inline-block w-72 flex-shrink-0 bg-white border rounded  p-4 cursor-pointer min-h-[10px]"
                                            >
                                            <p class="font-semibold text-primary-variant-4">
                                                {{ $r->usuari }} 
                                                <span class="text-sm text-gray-500">({{ $r->valoracio }}/5)</span>
                                            </p>

                                            <p class="text-sm mt-2 text-gray-700 break-words whitespace-normal transition-all duration-300 overflow-hidden" :class="expanded ? 'line-clamp-none max-h-full' : 'line-clamp-3 max-h-20'">
                                                {{ $r->comentari }}
                                            </p>

                                            <p class="text-xs text-gray-400 mt-2">
                                                {{ \Carbon\Carbon::parse($r->dataPublicacio)->format('d/m/Y H:i') }}
                                            </p>

                                            {{-- BOTÓN/FORMULARIO PARA ELIMINAR LA RESEÑA --}}
                                            @if(Auth::check() && (Auth::id() === $r->user_id || Gate::allows('access-admin')))
                                                <form action="{{ route('ressenyes.destroy', $r) }}" method="POST" class="mt-2" @click.stop="">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-500 hover:text-red-700 text-xs font-semibold"
                                                        onclick="return confirm('¿Estás seguro de que quieres eliminar esta reseña?')"
                                                        >
                                                        Eliminar reseña
                                                    </button>
                                                </form>
                                            @endif 
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Añadir los enlaces de paginación --}}
                                <div class="mt-6">
                                    {{ $ressenyesPaginades->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                    <div>
                        @if(Auth::check())
                            <div class="mt-6">
                                <h4 class="text-lg font-semibold text-primary-variant-5 mb-2">Deixa la teva ressenya</h4>

                                @if(session('success'))
                                    <div class="text-green-500 mb-2">{{ session('success') }}</div>
                                @endif
                                <form method="POST" action="{{ route('botigues.ressenya.guardar', $botiga->id) }}">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="valoracio" class="block text-sm font-medium text-gray-700">Valoració (1-5)</label>
                                        <input type="number" name="valoracio" id="valoracio" min="1" max="5" required
                                            class="bg-info-variant-1 form-control mt-1 rounded-md w-full"></textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label for="comentari" class="block text-sm font-medium text-gray-700">Comentari</label>
                                        <textarea name="comentari" id="comentari" rows="4" required
                                            class="bg-info-variant-1 form-control mt-1 rounded-md w-full"></textarea>
                                    </div>

                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        Enviar ressenya
                                    </button>
                                </form>
                            </div>
                        @else
                            <p class="text-gray-700 mt-6">
                                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Inicia sessió</a> per deixar una ressenya.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
