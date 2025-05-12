<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-info-variant-4 dark:text-gray-200 leading-tight">
            {{ __('Detalls de la Botiga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-primary-variant-1 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-primary-variant-5 dark:text-white mb-4">{{ $botiga->nom }}</h3>

                    <div class="mb-4">
                        <strong class="text-info-variant-3 dark:text-info-variant-4">Adreça:</strong>
                        <p class="text-gray-700 dark:text-gray-300">{{ $botiga->adreca ?? 'No especificada' }}</p>
                    </div>

                    @if($botiga->descripcio)
                        <div class="mb-4">
                            <strong class="text-info-variant-3 dark:text-info-variant-4">Descripció:</strong>
                            <p class="text-gray-700 dark:text-gray-300">{{ $botiga->descripcio }}</p>
                        </div>
                    @endif

                    @if($botiga->horariObertura)
                        <div class="mb-4">
                            <strong class="text-info-variant-3 dark:text-info-variant-4">Horari d'Obertura:</strong>
                            <p class="text-gray-700 dark:text-gray-300">{{ $botiga->horariObertura }}</p>
                        </div>
                    @endif

                    @if($botiga->horariTencament)
                        <div class="mb-4">
                            <strong class="text-info-variant-3 dark:text-info-variant-4">Horari de Tancament:</strong>
                            <p class="text-gray-700 dark:text-gray-300">{{ $botiga->horariTencament }}</p>
                        </div>
                    @endif

                    @if($botiga->telefono)
                        <div class="mb-4">
                            <strong class="text-info-variant-3 dark:text-info-variant-4">Telèfon:</strong>
                            <p class="text-gray-700 dark:text-gray-300">{{ $botiga->telefono }}</p>
                        </div>
                    @endif

                    @if($botiga->coreoelectronic)
                        <div class="mb-4">
                            <strong class="text-info-variant-3 dark:text-info-variant-4">Correu Electrònic:</strong>
                            <p class="text-gray-700 dark:text-gray-300">{{ $botiga->coreoelectronic }}</p>
                        </div>
                    @endif

                    @if($botiga->web)
                        <div class="mb-4">
                            <strong class="text-info-variant-3 dark:text-info-variant-4">Web:</strong>
                            <p class="text-gray-700 dark:text-gray-300">
                                <a href="{{ $botiga->web }}" target="_blank" rel="noopener noreferrer" class="text-blue-500 hover:text-blue-700">{{ $botiga->web }}</a>
                            </p>
                        </div>
                    @endif

                    @if($botiga->imatge)
                        <div class="mb-4">
                            <strong class="text-info-variant-3 dark:text-info-variant-4">Imatge:</strong>
                            <img src="{{ $botiga->imatge }}" alt="Imatge de la botiga" class="rounded-md max-w-full h-auto">
                        </div>
                    @endif

                    @if($botiga->latitud && $botiga->longitud)
                        <div class="mb-4">
                            <strong class="text-info-variant-3 dark:text-info-variant-4">Coordenades:</strong>
                            <p class="text-gray-700 dark:text-gray-300">Latitud: {{ $botiga->latitud }}, Longitud: {{ $botiga->longitud }}</p>
                            </div>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('botigues.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:bg-gray-400 dark:focus:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Tornar a la llista') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>