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
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700 space-y-6">
                        @foreach($botigues as $botiga)
                            <li class="py-6 px-4 flex justify-between items-center bg-[#e9f2fc] dark:bg-gray-700 hover:bg-blue-100 dark:hover:bg-gray-600 rounded-xl shadow-md transition-all duration-300 ease-in-out">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $botiga->nom }}</h3>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $botiga->adreca }}</p>
                                    @if($botiga->descripcio)
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">{{ $botiga->descripcio }}</p>
                                    @endif
                                </div>
                                <div class="flex space-x-4">
                                    <!-- Botón de edición con icono -->
                                    <a href="{{ route('editone', ['id' => $botiga->id]) }}" class="text-blue-600 hover:text-blue-800 flex items-center space-x-1 transition-colors duration-200">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232a3 3 0 011.768 4.768L6 20H4v-2l12.464-12.464a3 3 0 011.768-4.768z"></path>
                                        </svg>
                                        <span class="font-medium">{{ __('Editar') }}</span>
                                    </a>
                                    <!-- Botón de eliminar con icono -->
                                    <form action="{{ route('botigues.destroy', $botiga->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 flex items-center space-x-1 transition-colors duration-200">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            <span class="font-medium">{{ __('Eliminar') }}</span>
                                        </button>
                                    </form>
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
