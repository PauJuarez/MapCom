<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Botigues') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($botigues->isEmpty())
                    <p class="text-gray-600 dark:text-gray-300">No hi ha botigues registrades.</p>
                @else
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($botigues as $botiga)
                            <li class="py-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $botiga->nom }}</h3>
                                <p class="text-gray-700 dark:text-gray-300">{{ $botiga->adreca }}</p>
                                @if($botiga->descripcio)
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $botiga->descripcio }}</p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif

                <!-- Aquí se agregan los enlaces de paginación -->
                <div class="mt-4">
                    {{ $botigues->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
