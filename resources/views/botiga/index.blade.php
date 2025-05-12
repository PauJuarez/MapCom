<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-info-variant-4 dark:text-gray-200 leading-tight">
            {{ __('Botigues') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl p-6">
                @if($botigues->isEmpty())
                    <p class="text-gray-600 dark:text-gray-300">No hi ha botigues registrades.</p>
                @else
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700 space-y-6 relative">
                        @foreach($botigues as $botiga)
                            <li class="relative py-6 px-4 bg-[#e9f2fc] dark:bg-gray-700 hover:bg-blue-100 dark:hover:bg-gray-600 rounded-xl shadow-md transition-all duration-300 ease-in-out">
                                <!-- Botones arriba a la derecha -->
                                <div class="absolute top-2 right-2 flex space-x-2">
                                    <a href="{{ route('editone', ['id' => $botiga->id]) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2 shadow transition duration-200"
                                    title="Editar">
                                        <!-- Icono: Pencil Square Solid -->
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/>
                                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h6a1 1 0 100-2H4a3 3 0 00-3 3v12a3 3 0 003 3h12a3 3 0 003-3v-6a1 1 0 10-2 0v6a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" clip-rule="evenodd"/>
                                        </svg>
                                    </a>
                    
                                    <form action="{{ route('botigues.destroy', $botiga->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white rounded-full p-2 shadow transition duration-200"
                                                title="Eliminar">
                                            <!-- Icono: Trash Solid -->
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 011-1h6a1 1 0 011 1v1h4a1 1 0 110 2h-1v11a2 2 0 01-2 2H5a2 2 0 01-2-2V5H2a1 1 0 110-2h4V2zm2 4a1 1 0 012 0v7a1 1 0 11-2 0V6zm4 0a1 1 0 012 0v7a1 1 0 11-2 0V6z" clip-rule="evenodd"/>
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
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                
                @endif

                <!-- Paginación -->
                <div class="mt-6">
                    <div class="flex justify-center">
                        {{ $botigues->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
