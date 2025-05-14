<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-info-variant-4 dark:text-gray-200 leading-tight">
            {{ __('Botigues Favorites') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl p-6 bg-info-variant-1-5">
                @if($botigues->isEmpty())
                    <p class="text-gray-600 dark:text-gray-300">No tens botigues favorites.</p>
                @else
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700 space-y-6 relative">
                        @foreach($botigues as $botiga)
                            <li class="relative py-6 px-4 bg-info-variant-1 dark:bg-gray-700 hover:bg-blue-100 dark:hover:bg-gray-600 rounded-xl shadow-md transition-all duration-300 ease-in-out ">
                                <!-- Botones arriba a la derecha -->
                                <div class="absolute top-2 right-2 flex space-x-2">
                                    @if(Gate::allows('access-admin') || Gate::allows('access-editor'))
                                        <a href="{{ route('editone', ['id' => $botiga->id]) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2 shadow transition duration-200"
                                        title="Editar">
                                            <!-- Icono: Pencil Square Solid -->
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/>
                                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h6a1 1 0 100-2H4a3 3 0 00-3 3v12a3 3 0 003 3h12a3 3 0 003-3v-6a1 1 0 10-2 0v6a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" clip-rule="evenodd"/>
                                            </svg>
                                        </a>
                                    @endif


                                    @php
                                        $user = auth()->user();
                                        $esFavorita = $user && $user->favoritos && $user->favoritos->contains($botiga->id);
                                    @endphp

                                    <form action="{{ $esFavorita ? route('botigues.treureFavorit', $botiga->id) : route('botigues.afegirFavorit', $botiga->id) }}"
                                        method="POST">
                                        @csrf
                                        @if($esFavorita)
                                            @method('DELETE')
                                        @endif
                                        <button type="submit"
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white rounded-full p-2 shadow transition duration-200"
                                            title="{{ $esFavorita ? 'Treure de favorits' : 'Afegir a favorits' }}">
                                            <svg class="w-5 h-5" fill="{{ $esFavorita ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.909c.969 0 1.371 1.24.588 1.81l-3.977 2.89a1 1 0 00-.364 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.977-2.89a1 1 0 00-1.175 0l-3.977 2.89c-.784.57-1.838-.197-1.54-1.118l1.518-4.674a1 1 0 00-.364-1.118L2.98 10.101c-.783-.57-.38-1.81.588-1.81h4.91a1 1 0 00.949-.69l1.518-4.674z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                    
                                <!-- Contenido de la tienda -->
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $botiga->nom }}</h3>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $botiga->adreca }}</p>
                                    @if($botiga->descripcio)
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">{{ $botiga->descripcio }}</p>
                                        <button class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">
                                            <a href="{{ route('botiga.show', $botiga->id) }}">Veure Detalls</a>
                                        </button>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <!-- Paginación -->
                <div class="mt-6">
                    <div class="flex justify-end">
                        {{ $botigues->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
